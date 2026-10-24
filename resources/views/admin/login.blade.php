<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator — Smile Score</title>
    <meta name="description" content="Portal masuk administrator penelitian Smile Score.">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23168C83'><path d='M12 2C9.5 2 7.5 3.5 7.5 5.5c0 .7.2 1.4.6 2C6.8 8.1 6 9.4 6 11c0 2.5 1.5 6 3 9.5 1 2.3 2 2.5 3 2.5s2-.2 3-2.5c1.5-3.5 3-7 3-9.5 0-1.6-.8-2.9-2.1-3.5.4-.6.6-1.3.6-2C16.5 3.5 14.5 2 12 2z'/></svg>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #e6f7f5 0%, #f4f6f9 50%, #ddf5ec 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
        }

        /* Brand top */
        .login-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 28px;
        }
        .login-brand-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #e6f7f5;
            border: 1px solid #a8e6d7;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-brand-text {
            font-size: 18px;
            font-weight: 800;
            color: #183B38;
        }
        .login-brand-sub {
            font-size: 10px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .1em;
        }

        /* Card */
        .login-card {
            background: #fff;
            border: 1px solid #e5e9f0;
            border-radius: 16px;
            padding: 36px 32px 28px;
            box-shadow: 0 4px 32px rgba(22,140,131,0.08);
        }

        .login-header {
            text-align: center;
            margin-bottom: 28px;
        }
        .login-icon {
            width: 52px;
            height: 52px;
            border-radius: 13px;
            background: #e6f7f5;
            border: 1px solid #a8e6d7;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }
        .login-header h1 {
            font-size: 20px;
            font-weight: 800;
            color: #183B38;
            margin-bottom: 4px;
        }
        .login-header p {
            font-size: 13px;
            color: #64748b;
        }

        /* Form */
        .form-group { margin-bottom: 16px; }
        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 700;
            color: #374151;
            margin-bottom: 6px;
        }
        .form-input {
            width: 100%;
            padding: 11px 14px;
            font-size: 14px;
            font-family: inherit;
            border: 1.5px solid #dde3eb;
            border-radius: 9px;
            background: #f8fafc;
            color: #1e293b;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }
        .form-input:focus {
            border-color: #168C83;
            box-shadow: 0 0 0 3px rgba(22,140,131,0.12);
            background: #fff;
        }
        .form-input.error {
            border-color: #e11d48;
            background: #fff1f2;
        }
        .form-error {
            font-size: 12px;
            font-weight: 600;
            color: #e11d48;
            margin-top: 5px;
        }

        /* Alert */
        .alert-info {
            background: #dbeafe;
            border-left: 3px solid #3b82f6;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            color: #1d4ed8;
            font-weight: 600;
            margin-bottom: 20px;
        }

        /* Remember */
        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }
        .remember-row input[type="checkbox"] {
            width: 15px;
            height: 15px;
            accent-color: #168C83;
            cursor: pointer;
        }
        .remember-row label {
            font-size: 13px;
            color: #64748b;
            cursor: pointer;
        }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 12px;
            background: #168C83;
            color: #fff;
            font-size: 14px;
            font-weight: 800;
            font-family: inherit;
            border: none;
            border-radius: 9px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.15s, transform 0.1s;
        }
        .btn-submit:hover { background: #11665F; }
        .btn-submit:active { transform: scale(0.98); }

        /* Back link */
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 12.5px;
            font-weight: 600;
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.15s;
        }
        .back-link:hover { color: #168C83; }

        /* Footer note */
        .login-footer {
            text-align: center;
            margin-top: 16px;
            font-size: 11.5px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">

        <!-- Brand -->
        <div class="login-brand">
            <div class="login-brand-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="#168C83">
                    <path d="M12 2C9.5 2 7.5 3.5 7.5 5.5c0 .7.2 1.4.6 2C6.8 8.1 6 9.4 6 11c0 2.5 1.5 6 3 9.5 1 2.3 2 2.5 3 2.5s2-.2 3-2.5c1.5-3.5 3-7 3-9.5 0-1.6-.8-2.9-2.1-3.5.4-.6.6-1.3.6-2C16.5 3.5 14.5 2 12 2z"/>
                </svg>
            </div>
            <div>
                <div class="login-brand-text">Smile Score</div>
                <div class="login-brand-sub">Admin Panel</div>
            </div>
        </div>

        <!-- Card -->
        <div class="login-card">

            <div class="login-header">
                <div class="login-icon">
                    <svg width="24" height="24" fill="none" stroke="#168C83" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h1>Login Administrator</h1>
                <p>Masuk untuk mengelola data responden penelitian.</p>
            </div>

            @if (session('info'))
                <div class="alert-info">{{ session('info') }}</div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">Email Administrator</label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="admin@smilescore.id"
                           required
                           autofocus
                           class="form-input {{ $errors->has('email') ? 'error' : '' }}">
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password"
                           id="password"
                           name="password"
                           placeholder="••••••••"
                           required
                           class="form-input {{ $errors->has('password') ? 'error' : '' }}">
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember -->
                <div class="remember-row">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ingat sesi saya</label>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit">
                    <span>Masuk ke Dashboard</span>
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>

            </form>

            <a href="{{ route('home') }}" class="back-link">
                &larr; Kembali ke Beranda Smile Score
            </a>

        </div>

        <p class="login-footer">
            🔒 Sistem Terproteksi &bull; Akses Khusus Peneliti &amp; Tim Smile Score
        </p>

    </div>
</body>
</html>
