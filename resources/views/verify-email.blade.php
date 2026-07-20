<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            position: relative;
        }
        .verify-card { width: 420px; background: white; padding: 40px; border-radius: 20px; }
        .custom-label { font-size: 14px; font-weight: 500; margin-bottom: 5px; color: #333; display: block; }
    </style>
</head>
<body>

<a href="/login" class="btn btn-light position-absolute top-0 start-0 m-4 shadow-sm" style="border-radius: 8px;">
    &larr; Back to Login
</a>

<div class="verify-card shadow text-center">

    <div class="mb-3" style="font-size: 48px;">📧</div>

    <h1 class="mb-3" style="font-size: 26px; font-weight: 700; color: #333;">
        Verifikasi Email Kamu
    </h1>

    <p class="text-muted small mb-4">
        Kami sudah kirim link verifikasi ke <strong>{{ $email ?? 'email kamu' }}</strong>.
        Buka email itu dan klik link-nya sebelum bisa login. Cek folder Spam kalau nggak ketemu di Inbox.
    </p>

    @if (session('success'))
        <div class="alert alert-success text-start">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger text-start">{{ session('error') }}</div>
    @endif

    <form action="{{ route('verification.send') }}" method="POST">
        @csrf
        <div class="mb-3 text-start">
            <label class="custom-label">Email Kamu</label>
            <input type="email" name="email" class="form-control" value="{{ $email }}" placeholder="Masukkan email Anda" required>
        </div>
        <button type="submit" class="btn btn-dark w-100" style="background-color: #1e1b4b; border: none; padding: 10px; border-radius: 8px;">
            Kirim Ulang Link Verifikasi
        </button>
    </form>

</div>

</body>
</html>
