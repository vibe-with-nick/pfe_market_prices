-- Migration 002 : Réinitialisation de mot de passe par email
-- À exécuter dans phpMyAdmin ou via la CLI MySQL :
--   mysql -u root market_prices_mu < database/002_password_resets.sql

CREATE TABLE IF NOT EXISTS `password_resets` (
  `id`         INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  `user_id`    INT UNSIGNED    NOT NULL,
  `token_hash` CHAR(64)        NOT NULL COMMENT 'SHA-256 du token brut envoyé par email',
  `expires_at` DATETIME        NOT NULL,
  `created_at` DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_token_hash` (`token_hash`),
  CONSTRAINT `fk_pr_user` FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
