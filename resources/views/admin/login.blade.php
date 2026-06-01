<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - LPK Phitagoras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e1e2f, #0f0c1b);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: #ffffff;
            border-radius: 20px;
            width: 100%;
            max-width: 420px;
            padding: 40px;
        }
    </style>
</head>
<body>

<div class="login-card shadow-lg">
    <div class="text-center mb-4">
        <h3 class="fw-bold text-dark">Geriya Admin</h3>
        <p class="text-muted small">LPK Phitagoras Back-Office</p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger rounded-3 small mb-3">
            <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
        </div>
    @endif

    <form action="/admin/login" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label text-muted small fw-bold">Username Admin</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fa fa-user text-muted"></i></span>
                <input type="text" name="username" class="form-control bg-light border-start-0 text-dark" placeholder="Masukkan username" required autofocus>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label text-muted small fw-bold">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fa fa-lock text-muted"></i></span>
                <input type="password" name="password" class="form-control bg-light border-start-0 text-dark" placeholder="••••••••" required>
            </div>
        </div>

        <button type="submit" class="btn btn-dark w-100 py-2 fw-semibold mb-3" style="border-radius: 10px;">
            Masuk Sebagai Admin
        </button>

        <div class="text-center">
            <a href="/login" class="text-decoration-none small text-muted"><i class="fa fa-arrow-left me-1"></i> Kembali ke Login Murid</a>
        </div>
    </form>
</div>

</body>
</html>