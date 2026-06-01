<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>
<body style="background:#f4f7fc;">

<div class="container mt-5">

    <div class="col-md-4 mx-auto">

        <div class="card p-5 shadow border-0 rounded-4">

            <h1 class="text-center mb-4">
                Register
            </h1>

            <form action="/register" method="POST">

                @csrf

                <input type="text"
                       name="name"
                       class="form-control mb-3"
                       placeholder="Nama">

                <input type="email"
                       name="email"
                       class="form-control mb-3"
                       placeholder="Email">

                <input type="password"
                       name="password"
                       class="form-control mb-3"
                       placeholder="Password">

                <button class="btn btn-primary w-100">

                    Register

                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>