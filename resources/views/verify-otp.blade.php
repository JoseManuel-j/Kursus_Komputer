<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Kode OTP</title>
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

        .otp-input {
            letter-spacing: 10px;
            font-size: 24px;
            text-align: center;
            font-weight: 700;
        }
    </style>
</head>
<body>

<a href="{{ route('password.request') }}" class="btn btn-light position-absolute top-0 start-0 m-4 shadow-sm" style="border-radius: 8px;">
    &larr; Back
</a>

<div class="forgot-card shadow">

    <h1 class="text-center mb-3" style="font-size: 28px; font-weight: 700; color: #333;">
        Verifikasi Kode OTP
    </h1>

    <p class="text-center text-muted small mb-4">
        Kami sudah kirim kode OTP 6 digit ke <strong>{{ $email }}</strong>. Kode berlaku selama 10 menit.
    </p>

    @if(session('success'))
        <div class="alert alert-success small">{{ session('success') }}</div>
    @endif
    @error('otp')
        <div class="alert alert-danger small">{{ $message }}</div>
    @enderror

    <form action="{{ route('password.otp.verify') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="custom-label">Kode OTP</label>
            <input type="text"
                   name="otp"
                   class="form-control otp-input"
                   inputmode="numeric"
                   maxlength="6"
                   pattern="\d{6}"
                   placeholder="------"
                   autocomplete="one-time-code"
                   required autofocus>
        </div>

        <button type="submit" class="btn btn-dark w-100" style="background-color: #1e1b4b; border: none; padding: 10px; border-radius: 8px;">
            Verifikasi Kode
        </button>

    </form>

    <form action="{{ route('password.otp.resend') }}" method="POST" class="mt-3">
        @csrf
        <button type="submit" class="btn btn-link w-100 text-decoration-none small">
            Nggak dapat kode? Kirim ulang
        </button>
    </form>

</div>

</body>
</html>
