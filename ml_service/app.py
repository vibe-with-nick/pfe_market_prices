from flask import Flask, request, jsonify
import numpy as np
from datetime import datetime

app = Flask(__name__)

def encode_season(season: str) -> np.ndarray:
    # Maurice : 2 saisons tropicales
    # "ete"   = saison chaude/pluvieuse (nov–avr) → 1
    # "hiver" = saison fraîche/sèche   (mai–oct)  → 0
    v = 1.0 if (season or "").lower() == "ete" else 0.0
    return np.array([v], dtype=float)

def simple_regression(series, season):
    # series: list of {date, price}
    if not series or len(series) < 6:
        return None, "Pas assez de points (min 6)."
    # Sort by date
    pts = []
    for r in series:
        try:
            d = datetime.fromisoformat(str(r["date"]))
            p = float(r["price"])
            pts.append((d, p))
        except Exception:
            continue
    pts.sort(key=lambda x: x[0])
    if len(pts) < 6:
        return None, "Pas assez de points valides (min 6)."

    # Features: time index + season one-hot
    t = np.arange(len(pts), dtype=float).reshape(-1,1)
    y = np.array([p for _,p in pts], dtype=float).reshape(-1,1)
    s = np.tile(encode_season(season), (len(pts),1))
    X = np.hstack([np.ones((len(pts),1)), t, s])  # intercept + trend + season

    # Ridge regression closed form
    lam = 1e-2
    I = np.eye(X.shape[1])
    beta = np.linalg.inv(X.T @ X + lam*I) @ (X.T @ y)

    # predict for next step
    t_next = np.array([[len(pts)]], dtype=float)
    Xn = np.hstack([np.ones((1,1)), t_next, encode_season(season).reshape(1,-1)])
    pred = float((Xn @ beta)[0,0])

    # confidence: heuristic based on residual std
    yhat = (X @ beta).reshape(-1)
    resid = y.reshape(-1) - yhat
    sigma = float(np.std(resid)) if len(resid) > 1 else 0.0
    conf = max(0.0, 1.0 - (sigma / (np.mean(y) + 1e-6)))
    return {"pred": max(0.0, pred), "points": len(pts), "sigma": sigma, "confidence": conf}, None

@app.post("/predict")
def predict():
    data = request.get_json(force=True, silent=True) or {}
    series = data.get("series", [])
    target_date = data.get("target_date")
    season = data.get("season", "hiver")

    result, err = simple_regression(series, season)
    if err:
        return jsonify({"ok": False, "message": err}), 200

    return jsonify({
        "ok": True,
        "model": "ridge_linear_trend+saison_tropicale",
        "predicted_price": round(result["pred"], 2),
        "target_date": target_date,
        "points": result["points"],
        "confidence": round(result["confidence"], 2),
        "sigma": round(result["sigma"], 2),
    }), 200

if __name__ == "__main__":
    app.run(host="127.0.0.1", port=5055, debug=True)
