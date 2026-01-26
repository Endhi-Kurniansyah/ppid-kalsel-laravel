<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Login | PPID</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        /* Background dengan Gradien Modern */
        body {
            background: radial-gradient(circle at top right, #f8fafc, #e2e8f0);
            font-family: 'Inter', -apple-system, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
        }

        .login-container {
            width: 100%;
            max-width: 440px;
            padding: 20px;
            z-index: 2;
        }

        /* Card Modern dengan Efek Glassmorphism Tipis */
        .card {
            border: 1px solid rgba(255, 255, 255, 0.8) !important;
            border-radius: 32px !important;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05) !important;
        }

        /* Label & Input Styling */
        .form-label {
            font-size: 0.7rem;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            margin-left: 4px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 20px;
        }

        .form-control {
            background-color: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 16px !important;
            padding: 14px 18px;
            font-weight: 600;
            color: #1e293b;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background-color: #ffffff !important;
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1) !important;
        }

        /* Tombol Sign In - Bold & Wide */
        .btn-login {
            background: linear-gradient(135deg, #0d6efd 0%, #004dc0 100%) !important;
            color: white !important;
            border: none !important;
            padding: 16px;
            border-radius: 16px !important;
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: 1px;
            margin-top: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(13, 110, 253, 0.2) !important;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(13, 110, 253, 0.3) !important;
        }

        /* Area Captcha Placeholder */
        .captcha-box {
            background: #f1f5f9;
            border-radius: 16px;
            padding: 15px;
            border: 1px dashed #cbd5e1;
            margin-bottom: 20px;
            text-align: center;
        }

        .forgot-link {
            color: #64748b;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
            transition: color 0.2s;
        }

        .forgot-link:hover { color: #0d6efd; }

        /* Dekorasi Lingkaran Halus di Background */
        .bg-decoration {
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(13, 110, 253, 0.03);
            border-radius: 50%;
            z-index: 1;
        }
    </style>
</head>
<body>

    <div class="bg-decoration" style="top: -100px; right: -100px;"></div>
    <div class="bg-decoration" style="bottom: -100px; left: -100px;"></div>

    <div class="login-container">
        {{-- LOGO AREA --}}
        <div class="text-center mb-5">
            @php $settings = \App\Models\Setting::pluck('value', 'key')->all(); @endphp
            @if(isset($settings['site_logo']))
                <img src="{{ asset('storage/' . $settings['site_logo']) }}" style="max-height: 100px;">
            @else
                <div class="d-inline-block p-4 rounded-4 bg-white shadow-sm">
                    <i class="bi bi-shield-lock-fill text-primary fs-1"></i>
                </div>
            @endif
        </div>

        {{-- FORM CARD --}}
        <div class="card border-0">
            <div class="card-body p-4 p-md-5">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Input Email --}}
                    <div class="input-group-custom">
                        <label class="form-label">Admin Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="Masukkan email">
                        @error('email') <span class="text-danger small fw-bold mt-1 d-block">{{ $message }}</span> @enderror
                    </div>

                    {{-- Input Password --}}
                    <div class="input-group-custom">
                        <div class="d-flex justify-content-between">
                            <label class="form-label">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-link">Lupa sandi?</a>
                            @endif
                        </div>
                        <input type="password" name="password" class="form-control" required placeholder="••••••••">
                        @error('password') <span class="text-danger small fw-bold mt-1 d-block">{{ $message }}</span> @enderror
                    </div>

                    {{-- PLACEHOLDER CAPTCHA (Mas bisa masukkan script Google reCAPTCHA di sini) --}}
                    <div class="captcha-box">
                        {{-- Contoh Integrasi Captcha --}}
                        <div class="d-flex align-items-center justify-content-center gap-2">
                             <input type="checkbox" class="form-check-input" id="verify" required>
                             <label class="small fw-bold text-muted" for="verify">Saya bukan robot (reCAPTCHA)</label>
                        </div>
                        {{-- GANTI DIV DI ATAS DENGAN: {!! NoCaptcha::display() !!} JIKA PAKAI PACKAGE --}}
                    </div>

                    {{-- Opsi Remember Me --}}
                    <div class="form-check mb-4 ms-1">
                        <input type="checkbox" class="form-check-input border-0" id="remember_me" name="remember" style="background-color: #e2e8f0;">
                        <label class="form-check-label small text-muted fw-bold" for="remember_me">Tetap Masuk</label>
                    </div>

                    {{-- Action --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-login">MASUK SEKARANG</button>
                    </div>
                </form>
            </div>
        </div>

        <p class="text-center mt-4 text-muted small fw-bold opacity-50">PPID PROVINSI KALSEL &copy; {{ date('Y') }}</p>
    </div>

</body>
</html>
