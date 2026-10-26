<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesi Telah Kedaluwarsa - Smile Score</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23168C83'><path d='M12 2C9.5 2 7.5 3.5 7.5 5.5c0 .7.2 1.4.6 2C6.8 8.1 6 9.4 6 11c0 2.5 1.5 6 3 9.5 1 2.3 2 2.5 3 2.5s2-.2 3-2.5c1.5-3.5 3-7 3-9.5 0-1.6-.8-2.9-2.1-3.5.4-.6.6-1.3.6-2C16.5 3.5 14.5 2 12 2z'/></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #F4FBF9;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }
        .error-card {
            background: #ffffff;
            border: 1px solid #e5e9f0;
            border-radius: 18px;
            padding: 40px 32px;
            max-width: 460px;
            width: 100%;
            text-align: center;
            box-shadow: 0 10px 35px rgba(22, 140, 131, 0.08);
        }
        .icon-box {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: #fef3c7;
            border: 1px solid #fde68a;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        .code-badge {
            display: inline-block;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #d97706;
            background: #fef3c7;
            padding: 4px 10px;
            border-radius: 999px;
            margin-bottom: 12px;
        }
        h1 {
            font-size: 22px;
            font-weight: 800;
            color: #183B38;
            margin-bottom: 8px;
        }
        p {
            font-size: 13.5px;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 26px;
        }
        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px 20px;
            background: #168C83;
            color: #ffffff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            border-radius: 10px;
            transition: background 0.15s, transform 0.1s;
            border: none;
            cursor: pointer;
        }
        .btn-action:hover { background: #11665F; }
        .btn-action:active { transform: scale(0.98); }
        .back-link {
            display: block;
            margin-top: 14px;
            font-size: 13px;
            color: #94a3b8;
            text-decoration: none;
            font-weight: 600;
        }
        .back-link:hover { color: #168C83; }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="icon-box">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
        </div>
        <div class="code-badge">Kode 419 &bull; Sesi Kedaluwarsa</div>
        <h1>Sesi Anda Telah Berakhir</h1>
        <p>Halaman ini telah terbuka terlalu lama atau token keamanan telah kedaluwarsa. Silakan muat ulang atau buka kembali halaman login untuk melanjutkan.</p>
        <a href="{{ route('admin.login') }}" class="btn-action">
            <span>Buka Halaman Login</span>
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </a>
        <a href="{{ url('/') }}" class="back-link">&larr; Kembali ke Beranda Smile Score</a>
    </div>
</body>
</html>
