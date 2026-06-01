<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Kursus Komputer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>

        body{
            font-family: Poppins;
            background: #f4f7fc;
        }

        .hero{
            height: 100vh;
            background: linear-gradient(to right, #141e30, #243b55);
            color: white;

            display: flex;
            align-items: center;
        }

        .hero h1{
            font-size: 65px;
            font-weight: bold;
        }

        .card-course{
            border-radius: 20px;
            transition: 0.3s;
        }

        .card-course:hover{
            transform: translateY(-10px);
        }

    </style>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <div class="container">

        <a class="navbar-brand fw-bold">
            KursusKomputer
        </a>

        <div>

            <a href="/login"
               class="btn btn-outline-light me-2">

               Login

            </a>

            <a href="/register"
               class="btn btn-warning">

               Register

            </a>

        </div>

    </div>

</nav>

<section class="hero">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-md-6">

                <h1>
                    Belajar Komputer Jadi Lebih Mudah
                </h1>

                <p class="mt-4">

                    Belajar Microsoft Office,
                    Design Grafis,
                    dan Web Development.

                </p>

                <a href="/register"
                   class="btn btn-warning btn-lg mt-3">

                   Mulai Belajar

                </a>

            </div>

            <div class="col-md-6 text-center">

                <img src="https://cdn-icons-png.flaticon.com/512/1055/1055687.png"
                     width="450">

            </div>

        </div>

    </div>

</section>

<section class="container py-5">

    <div class="text-center mb-5">

        <h1>Kelas Populer</h1>

    </div>

    <div class="row g-4">

        <div class="col-md-4">

            <div class="card p-4 shadow card-course">

                <i class="fa fa-file-word fa-3x text-primary mb-3"></i>

                <h4>Microsoft Office</h4>

                <p>
                    Belajar Word, Excel, dan PowerPoint.
                </p>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card p-4 shadow card-course">

                <i class="fa fa-palette fa-3x text-danger mb-3"></i>

                <h4>Design Grafis</h4>

                <p>
                    Belajar Photoshop dan Canva.
                </p>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card p-4 shadow card-course">

                <i class="fa fa-code fa-3x text-success mb-3"></i>

                <h4>Web Development</h4>

                <p>
                    Belajar HTML, CSS, PHP, Laravel.
                </p>

            </div>

        </div>

    </div>

</section>

<footer class="bg-dark text-white text-center p-4">

    © 2026 Kursus Komputer

</footer>

</body>
</html>