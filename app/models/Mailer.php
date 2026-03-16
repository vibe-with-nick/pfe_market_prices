<?php
/**
 * Mailer — client SMTP natif (sockets PHP, sans dépendance externe).
 *
 * MODES :
 *   • smtp_host vide  → MODE DEV : email écrit dans storage/mail.log
 *   • smtp_host renseigné → envoi SMTP réel (Gmail, Outlook, etc.)
 *
 * Configuration dans app/config/app.php :
 *   smtp_host, smtp_port, smtp_secure ('tls'|'ssl'), smtp_user, smtp_pass,
 *   smtp_from, smtp_from_name
 */
class Mailer {

    /** Envoie l'email de réinitialisation de mot de passe. */
    public static function sendPasswordReset(string $toEmail, string $toName, string $resetUrl): bool {
        $subject = 'Réinitialisation de votre mot de passe — Market Prices MU';
        $html    = self::buildResetHtml($toName, $resetUrl);
        $plain   = "Bonjour {$toName},\n\n"
                 . "Réinitialisez votre mot de passe (valable 1 heure) :\n"
                 . $resetUrl . "\n\n"
                 . "Si vous n'êtes pas à l'origine de cette demande, ignorez cet email.\n\n"
                 . "— Market Prices MU";

        return self::dispatch($toEmail, $toName, $subject, $html, $plain);
    }

    // ────────────────────────────────────────────────────────────────────────
    // Noyau d'envoi
    // ────────────────────────────────────────────────────────────────────────

    private static function dispatch(
        string $toEmail, string $toName,
        string $subject, string $html, string $plain
    ): bool {
        $cfg = Config::all();

        if (empty($cfg['smtp_host'])) {
            return self::writeLog($toEmail, $subject, $plain, $html);
        }

        return self::smtpSend($cfg, $toEmail, $toName, $subject, $html, $plain);
    }

    // ────────────────────────────────────────────────────────────────────────
    // Client SMTP natif — pas de mail(), pas de librairie externe
    // Supporte : STARTTLS (port 587) et SSL direct (port 465)
    // Fonctionne avec Gmail, Outlook, OVH, Mailgun SMTP, etc.
    // ────────────────────────────────────────────────────────────────────────

    private static function smtpSend(
        array  $cfg,
        string $toEmail, string $toName,
        string $subject, string $html, string $plain
    ): bool {
        $host     = $cfg['smtp_host'];
        $port     = (int)($cfg['smtp_port']     ?? 587);
        $secure   = strtolower($cfg['smtp_secure']    ?? 'tls');
        $user     = $cfg['smtp_user']      ?? '';
        $pass     = $cfg['smtp_pass']      ?? '';
        $from     = $cfg['smtp_from']      ?? 'noreply@market.mu';
        $fromName = $cfg['smtp_from_name'] ?? 'Market Prices MU';
        $timeout  = 20;

        // Contexte SSL (accepte les certs auto-signés en dev)
        $ctx = stream_context_create(['ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true,
        ]]);

        // ── Connexion ─────────────────────────────────────────────────────
        if ($secure === 'ssl') {
            $socket = @stream_socket_client(
                "ssl://{$host}:{$port}", $errno, $errstr, $timeout,
                STREAM_CLIENT_CONNECT, $ctx
            );
        } else {
            $socket = @stream_socket_client(
                "tcp://{$host}:{$port}", $errno, $errstr, $timeout
            );
        }

        if (!$socket) {
            error_log("[Mailer] Connexion SMTP impossible — {$errstr} ({$errno})");
            return false;
        }

        stream_set_timeout($socket, $timeout);

        // Fonctions internes ───────────────────────────────────────────────

        /** Lit la réponse complète (gère les réponses multi-lignes 250-...) */
        $read = static function () use ($socket): string {
            $out = '';
            while ($line = fgets($socket, 512)) {
                $out .= $line;
                // La dernière ligne d'une réponse SMTP a un espace en 4e position
                if (strlen($line) < 4 || $line[3] === ' ') break;
            }
            return $out;
        };

        /** Envoie une commande et retourne le code numérique (ex: 250) */
        $cmd = static function (string $command) use ($socket, $read): int {
            fwrite($socket, $command . "\r\n");
            $resp = $read();
            return (int)substr(trim($resp), 0, 3);
        };

        // ── Dialogue SMTP ─────────────────────────────────────────────────

        $read(); // Bannière de bienvenue (220 ...)

        $ehlo = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $cmd("EHLO {$ehlo}");

        // STARTTLS si demandé (port 587)
        if ($secure === 'tls') {
            if ($cmd('STARTTLS') !== 220) {
                fclose($socket);
                error_log('[Mailer] STARTTLS refusé par le serveur.');
                return false;
            }
            // Montée en TLS sur la socket existante
            stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
            $cmd("EHLO {$ehlo}");
        }

        // Authentification (AUTH LOGIN)
        if ($user !== '') {
            $cmd('AUTH LOGIN');
            $cmd(base64_encode($user));
            $authCode = $cmd(base64_encode($pass));
            if ($authCode !== 235) {
                fclose($socket);
                error_log("[Mailer] Authentification SMTP échouée (code {$authCode}).");
                return false;
            }
        }

        // Enveloppe
        $cmd("MAIL FROM:<{$from}>");
        $cmd("RCPT TO:<{$toEmail}>");
        $cmd('DATA'); // → 354

        // ── Corps du message (multipart/alternative) ──────────────────────
        $boundary = '==MP_' . md5(uniqid('', true));

        $message  = "From: {$fromName} <{$from}>\r\n";
        $message .= "To: {$toName} <{$toEmail}>\r\n";
        $message .= "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=\r\n";
        $message .= "Date: " . date('r') . "\r\n";
        $message .= "MIME-Version: 1.0\r\n";
        $message .= "Content-Type: multipart/alternative; boundary=\"{$boundary}\"\r\n";
        $message .= "\r\n";
        $message .= "--{$boundary}\r\n";
        $message .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
        $message .= $plain . "\r\n\r\n";
        $message .= "--{$boundary}\r\n";
        $message .= "Content-Type: text/html; charset=UTF-8\r\n\r\n";
        $message .= $html . "\r\n\r\n";
        $message .= "--{$boundary}--\r\n";
        $message .= "\r\n."; // Fin du DATA

        $endCode = $cmd($message);
        $cmd('QUIT');
        fclose($socket);

        if ($endCode !== 250) {
            error_log("[Mailer] Serveur SMTP n'a pas accepté le message (code {$endCode}).");
            return false;
        }

        return true;
    }

    // ────────────────────────────────────────────────────────────────────────
    // Mode développement : écriture dans storage/mail.log
    // ────────────────────────────────────────────────────────────────────────

    private static function writeLog(string $to, string $subject, string $plain, string $html): bool {
        $dir = __DIR__ . '/../../storage';
        if (!is_dir($dir)) mkdir($dir, 0755, true);

        $separator = str_repeat('─', 60);
        $entry  = "\n{$separator}\n";
        $entry .= date('[Y-m-d H:i:s]') . " → {$to}\n";
        $entry .= "Sujet : {$subject}\n";
        $entry .= "{$separator}\n";
        $entry .= $plain . "\n";
        $entry .= "{$separator}\n";

        file_put_contents($dir . '/mail.log', $entry, FILE_APPEND | LOCK_EX);
        return true;
    }

    // ────────────────────────────────────────────────────────────────────────
    // Template HTML de l'email
    // ────────────────────────────────────────────────────────────────────────

    private static function buildResetHtml(string $name, string $resetUrl): string {
        $appName  = htmlspecialchars('Market Prices MU');
        $safeName = htmlspecialchars($name);
        $safeUrl  = htmlspecialchars($resetUrl);

        return <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Réinitialisation de mot de passe</title>
</head>
<body style="margin:0;padding:0;background:#F6F1E9;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 16px;">
    <tr><td align="center">
      <table width="100%" style="max-width:520px;background:#FFFDF9;border:1px solid rgba(28,26,23,.12);">

        <!-- En-tête -->
        <tr>
          <td style="background:#141310;padding:26px 36px;">
            <span style="font-family:Georgia,serif;font-size:17px;font-weight:700;color:#F6F1E9;letter-spacing:-.01em;">
              {$appName}
            </span>
          </td>
        </tr>

        <!-- Corps -->
        <tr>
          <td style="padding:36px 36px 24px;">
            <p style="margin:0 0 6px;font-size:10px;font-weight:500;letter-spacing:.12em;text-transform:uppercase;color:#7A7468;">
              Réinitialisation du mot de passe
            </p>
            <h1 style="margin:0 0 22px;font-family:Georgia,serif;font-size:22px;font-weight:700;color:#1C1A17;line-height:1.2;">
              Bonjour, {$safeName}
            </h1>
            <p style="margin:0 0 18px;font-size:14px;line-height:1.7;color:#7A7468;">
              Vous avez demandé la réinitialisation de votre mot de passe sur
              <strong style="color:#1C1A17;">{$appName}</strong>.
              Cliquez sur le bouton ci-dessous pour choisir un nouveau mot de passe.
            </p>
            <p style="margin:0 0 28px;font-size:13px;color:#7A7468;">
              Ce lien est <strong style="color:#1C1A17;">valable 1 heure</strong>.
              Après expiration, vous devrez faire une nouvelle demande.
            </p>

            <!-- CTA -->
            <table cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
              <tr>
                <td style="background:#C05A28;">
                  <a href="{$safeUrl}"
                     style="display:inline-block;padding:14px 28px;font-size:11px;font-weight:600;letter-spacing:.09em;text-transform:uppercase;color:#fff;text-decoration:none;">
                    Réinitialiser mon mot de passe
                  </a>
                </td>
              </tr>
            </table>

            <p style="margin:0;font-size:11px;color:#7A7468;line-height:1.7;word-break:break-all;">
              Ou copiez ce lien dans votre navigateur :<br>
              <a href="{$safeUrl}" style="color:#C05A28;text-decoration:none;">{$safeUrl}</a>
            </p>
          </td>
        </tr>

        <!-- Pied -->
        <tr>
          <td style="padding:0 36px;"><hr style="border:none;border-top:1px solid rgba(28,26,23,.08);margin:0;"></td>
        </tr>
        <tr>
          <td style="padding:18px 36px;font-size:11px;color:#7A7468;line-height:1.6;">
            Si vous n'avez pas demandé cette réinitialisation, ignorez cet email —
            votre mot de passe restera inchangé.
          </td>
        </tr>

      </table>
    </td></tr>
  </table>
</body>
</html>
HTML;
    }
}
