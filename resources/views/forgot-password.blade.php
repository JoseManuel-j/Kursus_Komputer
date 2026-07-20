<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
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
        Lupa Password
    </h1>
    
    <p class="text-center text-muted small mb-4">
        Masukkan email terdaftar kamu. Kami akan mengirimkan link verifikasi untuk mengatur ulang password.
    </p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <form action="{{ route('password.email') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="custom-label">Email Address</label>
            <input type="email"
                   name="email"
                   class="form-control"
                   value="{{ old('email') }}"
                   placeholder="Masukkan email Anda" required>
        </div>

        <button type="submit" class="btn btn-dark w-100" style="background-color: #1e1b4b; border: none; padding: 10px; border-radius: 8px;">
            Verifikasi Email
        </button>

    </form>

</div>

</body>
</html>