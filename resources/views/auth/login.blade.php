<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin - PPID Provinsi Kalimantan Selatan</title>
    
    {{-- CSS Frameworks --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    {{-- Google Fonts: Outfit --}}
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #4361ee 0%, #3a56d4 100%);
            --glass-bg: rgba(255, 255, 255, 0.98); /* Slightly more opaque */
            --glass-border: rgba(255, 255, 255, 0.8);
            --shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #0f172a;
            position: relative;
            overflow: hidden;
        }

        /* DYNAMIC BACKGROUND */
        @php
            $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
            $bgImage = (isset($settings['hero_bg'])) 
                ? asset('storage/' . $settings['hero_bg']) 
                : 'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2069&auto=format&fit=crop';
        @endphp

        .bg-image {
            position: absolute;
            inset: 0;
            background-image: url('{{ $bgImage }}');
            background-size: cover;
            background-position: center;
            z-index: -2;
            animation: zoomEffect 40s infinite alternate;
        }

        .bg-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.92) 0%, rgba(15, 23, 42, 0.85) 100%);
            backdrop-filter: blur(5px);
            z-index: -1;
        }

        @keyframes zoomEffect { from { transform: scale(1); } to { transform: scale(1.1); } }

        /* AUTH CARD */
        .auth-card {
            width: 100%;
            max-width: 400px; /* Slightly narrower */
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 30px; /* Reduced padding */
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
            animation: slideUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* LOGO AREA (No Circle) */
        .brand-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 25px;
        }
        .brand-logo-img { height: 50px; width: auto; }
        .brand-text h6 { font-size: 1.1rem; line-height: 1.1; color: #1e293b; margin-bottom: 2px; }
        .brand-text small { font-size: 0.7rem; letter-spacing: 1.5px; color: #64748b; }

        /* FORM STYLES */
        .form-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin-bottom: 6px;
        }

        .form-control {
            padding: 10px 14px; /* Reduced padding */
            font-size: 0.9rem;
            font-weight: 500;
            color: #1e293b;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background-color: #ffffff;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: #4361ee;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            padding: 12px;
            font-weight: 700;
            border-radius: 8px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 0.85rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px -3px rgba(67, 97, 238, 0.3);
            background: var(--primary-gradient);
        }

        /* CAPTCHA */
        .captcha-wrapper {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            overflow: hidden;
            padding: 4px;
            height: 48px; /* Fixed height for consistency */
        }
        .captcha-img-box img { 
            height: 100%; 
            width: auto; 
            object-fit: contain;
        }
        .btn-refresh {
            width: 48px; 
            height: 48px;
            flex-shrink: 0;
            border: none; 
            background: #f8fafc;
            color: #64748b; 
            border-radius: 8px;
            display:flex; 
            align-items:center; 
            justify-content:center;
            transition: all 0.2s;
            border: 1px solid #cbd5e1;
        }
        .btn-refresh:hover { background: #fff; color: #4361ee; border-color: #4361ee; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fee2e2;
            color: #ef4444;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .input-group-text { border: 1px solid #cbd5e1; background-color: #f1f5f9; color: #64748b; border-radius: 8px 0 0 8px; }
        .form-control.rounded-end-3 { border-radius: 0 8px 8px 0; }
        
        /* Compact Spacing */
        .mb-3 { margin-bottom: 0.8rem !important; }
        .mb-4 { margin-bottom: 1.2rem !important; }

    </style>
</head>
<body>

    {{-- Background --}}
    <div class="bg-image"></div>
    <div class="bg-overlay"></div>
    
    {{-- Main Card --}}
    <div class="auth-card">
        
        {{-- Header: Logo & Title --}}
        <div class="brand-header">
             {{-- Logo Image --}}
             <img src="{{ asset('assets/static/images/logo/ppidutama.png') }}" class="brand-logo-img" alt="Logo">
             
             {{-- Text --}}
             <div class="brand-text d-flex flex-column">
                <h6 class="fw-bold text-dark font-monospace mb-0">PPID KALSEL</h6>
                <small class="text-secondary fw-bold text-uppercase ls-1">Admin Panel</small>
             </div>
        </div>

        @if($errors->any())
            <div class="alert-error d-block">
                @foreach ($errors->all() as $error)
                    <div class="d-flex align-items-center mb-1 gap-2">
                        <i class="bi bi-exclamation-circle-fill flex-shrink-0"></i>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" name="email" class="form-control shadow-none" placeholder="admin@kalselprov.go.id" required autofocus value="{{ old('email') }}" style="border-left: none;">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" name="password" class="form-control shadow-none" placeholder="••••••••" required style="border-left: none;">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Kode Keamanan</label>
                
                {{-- Row 1: Captcha Image & Refresh --}}
                <div class="d-flex align-items-stretch mb-2">
                    <div class="captcha-wrapper flex-grow-1 mb-0 me-2">
                         <div class="captcha-img-box section-captcha h-100 d-flex align-items-center justify-content-center">
                            {!! captcha_img('flat') !!}
                         </div>
                    </div>
                    <button type="button" class="btn-refresh" onclick="refreshCaptcha()" title="Refresh Kode">
                        <i class="bi bi-arrow-clockwise fs-5"></i>
                    </button>
                </div>

                {{-- Row 2: Input Code --}}
                <input type="text" name="captcha" class="form-control text-center fw-bold" placeholder="Masukkan karakter di atas" required autocomplete="off" style="letter-spacing: 1px;">
            </div>

            <button type="submit" class="btn btn-primary w-100 shadow-sm mb-3">
                <i class="bi bi-box-arrow-in-right me-2"></i> Masuk Sistem
            </button>

            <div class="text-center">
                <small class="text-muted fw-bold opacity-75" style="font-size: 0.65rem;">&copy; {{ date('Y') }} DISKOMINFO KALSEL</small>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function refreshCaptcha() {
            let btn = $('.btn-refresh i');
            btn.addClass('spin-animation');
            $.ajax({
                type: 'GET',
                url: '/refresh-captcha',
                success: function (data) {
                    $(".section-captcha").html(data.captcha);
                    setTimeout(() => btn.removeClass('spin-animation'), 500);
                }
            });
        }
    </script>
    
    <style>
        .spin-animation { animation: spin 0.5s linear; }
        @keyframes spin { 100% { transform: rotate(360deg); } }
    </style>
</body>
</html>
