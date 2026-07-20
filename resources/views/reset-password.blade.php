<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Password Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            position: relative;
        }

        .forgot-card {
            width: 400px;
            background: white;
            padding: 40px;
            border-radius: 20px;
        }

        .custom-label {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 5px;
            color: #333;
            display: block;
        }
    </style>
</head>
<body>

<a href="/login" class="btn btn-light position-absolute top-0 start-0 m-4 shadow-sm" style="border-radius: 8px;">
    &larr; Back to Login
</a>

<div class="forgot-card shadow">

    <h1 class="text-center mb-3" style="font-size: 28px; font-weight: 700; color: #333;">
        Buat Password Baru
    </h1>

    <p class="text-center text-muted small mb-4">
        Kode OTP kamu sudah terverifikasi. Silakan buat password baru untuk akun <strong>{{ $email }}</strong>.
    </p>

    @if ($errors->any())
        <div class="alert alert-danger small">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('password.reset.submit') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="custom-label">Password Baru</label>
            <input type="password"
                   name="password"
                   class="form-control"
                   placeholder="Minimal 8 karakter" required minlength="8">
        </div>

        <div class="mb-4">
            <label class="custom-label">Konfirmasi Password</label>
            <input type="password"
                   name="password_confirmation"
                   class="form-control"
                   placeholder="Ulangi password baru" required minlength="8">
        </div>

        <button type="submit" class="btn btn-dark w-100" style="background-color: #1e1b4b; border: none; padding: 10px; border-radius: 8px;">
            Simpan Password Baru
        </button>

    </form>

</div>

</body>
</html>
