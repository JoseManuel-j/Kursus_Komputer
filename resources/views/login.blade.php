<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>

        body{
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card{
            width: 400px;
            background: white;
            padding: 40px;
            border-radius: 20px;
        }

    </style>

</head>
<body>

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

        <input type="email"
               name="email"
               class="form-control mb-3"
               placeholder="Email">

        <input type="password"
               name="password"
               class="form-control mb-3"
               placeholder="Password">

        <button class="btn btn-dark w-100">

            Login

        </button>

    </form>

</div>

</body>
</html>