<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            position: relative; /* Penting untuk tombol melayang */
        }

        .login-card {
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

<!-- REVISI DI SINI: Mengubah href agar langsung mengarah ke halaman utama (/) atau dashboard -->
<a href="{{ url('/') }}" class="btn btn-light position-absolute top-0 start-0 m-4 shadow-sm" style="border-radius: 8px;">
    &larr; Back
</a>

<div class="login-card shadow">

    <h1 class="text-center mb-4">
        Login
    </h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="/login" method="POST">
        @csrf

        <div>
            <label class="custom-label">Email</label>
            <input type="email"
                   name="email"
                   class="form-control mb-3"
                   placeholder="Email" required>
        </div>

        <div>
            <label class="custom-label">Password</label>
            <input type="password"
                   name="password"
                   class="form-control mb-3"
                   placeholder="Password" required>
        </div>

        <button type="submit" class="btn btn-dark w-100 mb-3"> <!-- Ditambahkan mb-3 agar ada jarak dengan text bawah -->
            Login
        </button>

        <div class="text-center">
            <a href="/forgot-password" class="text-decoration-none small">Lupa password?</a>
        </div>

    </form>

</div>

</body>
</html>