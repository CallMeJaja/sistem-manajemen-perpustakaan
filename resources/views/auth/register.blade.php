<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Anggota — GramediKu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        html, body { min-height: 100%; }
        body {
            background: linear-gradient(135deg, #0f2444 0%, #1e3a5f 50%, #1e40af 100%);
            display: flex; align-items: center; justify-content: center; padding: 32px 0;
        }
        .login-card {
            width: 100%; max-width: 440px; background: #fff;
            border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.25); padding: 36px 32px;
        }
        .login-logo {
            width: 52px; height: 52px;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            border-radius: 14px; display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; color: #fff; margin: 0 auto 16px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-4">
            <div class="login-logo"><i class="bi bi-person-plus"></i></div>
            <h5 class="fw-bold mb-1">Daftar Anggota</h5>
            <p class="text-muted small mb-0">Buat akun untuk reservasi buku secara online</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" id="name" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" required autofocus>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">No. Telepon <span class="text-muted small">(opsional)</span></label>
                <input type="text" id="phone" name="phone"
                       class="form-control @error('phone') is-invalid @enderror"
                       value="{{ old('phone') }}">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" id="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Minimal 8 karakter" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-person-check me-2"></i>Daftar
            </button>
        </form>

        <div class="text-center mt-4 small">
            <span class="text-muted">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="text-decoration-none fw-medium">Masuk</a>
            <div class="mt-2">
                <a href="{{ route('catalog.index') }}" class="text-muted text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i>Kembali ke Katalog
                </a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
