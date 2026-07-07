<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>LPK Phitagoras - Kursus Komputer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f7fc;
            color: #172a45;
        }

        /* =========================
           NAVBAR
        ========================= */

        .navbar {
            padding: 15px 0;
        }

        .navbar-brand {
            font-size: 24px;
        }


        /* =========================
           HERO
        ========================= */

        .hero {
            min-height: calc(100vh - 70px);

            background:
                linear-gradient(
                    to right,
                    #141e30,
                    #243b55
                );

            color: white;

            display: flex;
            align-items: center;

            padding: 70px 0;
        }

        .hero h1 {
            font-size: 65px;
            font-weight: bold;
            line-height: 1.2;
        }

        .hero p {
            font-size: 18px;
            line-height: 1.8;
        }

        .hero-image {
            width: 100%;
            max-width: 450px;
        }


        /* =========================
           PROGRAM KURSUS
        ========================= */

        .program-section {
            padding: 100px 0;
            background: #f8fafc;
        }

        .program-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 55px;
        }

        .program-label {
            display: inline-block;

            color: #f5a800;

            font-size: 14px;
            font-weight: 700;

            letter-spacing: 2px;

            margin-bottom: 12px;
        }

        .program-header h2 {
            font-size: 42px;
            font-weight: 700;

            color: #172a45;

            margin-bottom: 15px;
        }

        .program-header p {
            color: #64748b;

            font-size: 17px;

            line-height: 1.7;
        }


        /* =========================
           PROGRAM CARD
        ========================= */

        .program-card {
            height: 100%;

            background: white;

            border-radius: 20px;

            overflow: hidden;

            box-shadow:
                0 10px 35px
                rgba(15, 23, 42, 0.08);

            transition:
                transform 0.3s ease,
                box-shadow 0.3s ease;
        }

        .program-card:hover {
            transform: translateY(-8px);

            box-shadow:
                0 20px 45px
                rgba(15, 23, 42, 0.15);
        }

        .program-image {
            width: 100%;
            height: 550px;

            padding: 20px;

            background: #ffffff;

            display: flex;

            justify-content: center;
            align-items: center;

            overflow: hidden;
        }

        .program-image img {
            width: 100%;
            height: 100%;

            object-fit: contain;

            display: block;
        }

        .program-content {
            padding: 30px;
        }

        .program-content h3 {
            font-size: 28px;

            font-weight: 700;

            margin-bottom: 12px;

            color: #172a45;
        }

        .program-content p {
            color: #64748b;

            line-height: 1.7;

            margin-bottom: 25px;
        }

        .program-button {
            display: inline-block;

            padding: 12px 25px;

            background: #ffb800;

            color: #172a45;

            text-decoration: none;

            font-weight: 700;

            border-radius: 8px;

            transition: 0.3s;
        }

        .program-button:hover {
            background: #e5a600;

            color: #172a45;

            transform: translateY(-2px);
        }


        /* =========================
           KELAS POPULER
        ========================= */

        .popular-section {
            padding: 100px 0;
            background: white;
        }

        .popular-title {
            font-size: 42px;
            font-weight: 700;
        }

        .card-course {
            border: none;

            border-radius: 20px;

            transition: 0.3s;

            height: 100%;
        }

        .card-course:hover {
            transform: translateY(-10px);
        }


        /* =========================
           FOOTER
        ========================= */

        footer {
            padding: 25px;
        }


        /* =========================
           RESPONSIVE TABLET
        ========================= */

        @media (max-width: 768px) {

            .hero {
                text-align: center;
            }

            .hero h1 {
                font-size: 45px;
            }

            .hero-image {
                margin-top: 60px;

                max-width: 350px;
            }

            .program-section {
                padding: 70px 0;
            }

            .program-header h2 {
                font-size: 34px;
            }

            .program-image {
                height: 450px;
            }

            .program-card {
                margin-bottom: 25px;
            }

        }


        /* =========================
           RESPONSIVE MOBILE
        ========================= */

        @media (max-width: 480px) {

            .hero {
                padding: 60px 15px;
            }

            .hero h1 {
                font-size: 36px;
            }

            .hero p {
                font-size: 16px;
            }

            .hero-image {
                max-width: 280px;
            }

            .program-header h2 {
                font-size: 29px;
            }

            .program-header p {
                font-size: 15px;
            }

            .program-image {
                height: 370px;
            }

            .program-content {
                padding: 25px;
            }

            .program-content h3 {
                font-size: 24px;
            }

        }

    </style>

</head>

<body>


<!-- =========================
     NAVBAR
========================= -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <div class="container">

        <a href="/" class="navbar-brand fw-bold">
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



<!-- =========================
     HERO
========================= -->

<section class="hero">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-md-6">

                <h1>
                    Belajar Komputer
                    Jadi Lebih Mudah
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

                <img
                    src="https://cdn-icons-png.flaticon.com/512/1055/1055687.png"
                    class="hero-image"
                    alt="Belajar Komputer"
                >

            </div>

        </div>

    </div>

</section>



<!-- =========================
     PROGRAM KURSUS
========================= -->

<section class="program-section" id="program">

    <div class="container">


        <div class="program-header">

            <span class="program-label">

                PROGRAM KURSUS

            </span>


            <h2>

                Pilih Program Belajar Kamu

            </h2>


            <p>

                Temukan program kursus komputer
                yang sesuai dengan kebutuhan
                dan tujuan belajar kamu.

            </p>

        </div>



        <div class="row g-4">


            <!-- PROGRAM PAKET -->

            <div class="col-lg-6">

                <div class="program-card">


                    <div class="program-image">

                        <img
                            src="{{ asset('images/program/program-paket.jpg') }}"
                            alt="Program Paket LPK Phitagoras"
                        >

                    </div>


                    <div class="program-content">

                        <h3>

                            Program Paket

                        </h3>


                        <p>

                            Program pembelajaran lengkap
                            dengan berbagai materi komputer
                            dalam satu paket kursus.

                        </p>


                        <a
                            href="/register"
                            class="program-button"
                        >

                            Daftar Sekarang

                        </a>

                    </div>

                </div>

            </div>



            <!-- PROGRAM SATUAN -->

            <div class="col-lg-6">

                <div class="program-card">


                    <div class="program-image">

                        <img
                            src="{{ asset('images/program/program-satuan.jpg') }}"
                            alt="Program Satuan LPK Phitagoras"
                        >

                    </div>


                    <div class="program-content">

                        <h3>

                            Program Satuan

                        </h3>


                        <p>

                            Pilih materi kursus secara satuan
                            sesuai dengan kemampuan
                            yang ingin kamu pelajari.

                        </p>


                        <a
                            href="/register"
                            class="program-button"
                        >

                            Daftar Sekarang

                        </a>

                    </div>

                </div>

            </div>


        </div>

    </div>

</section>



<!-- =========================
     KELAS POPULER
========================= -->

<section class="popular-section">

    <div class="container">


        <div class="text-center mb-5">

            <h2 class="popular-title">

                Kelas Populer

            </h2>

            <p class="text-muted mt-3">

                Pilihan kelas komputer yang banyak diminati.

            </p>

        </div>



        <div class="row g-4">


            <!-- MICROSOFT OFFICE -->

            <div class="col-md-4">

                <div class="card p-4 shadow-sm card-course">

                    <i
                        class="fa fa-file-word fa-3x text-primary mb-3">
                    </i>

                    <h4>

                        Microsoft Office

                    </h4>

                    <p class="text-muted">

                        Belajar Word,
                        Excel,
                        dan PowerPoint.

                    </p>

                </div>

            </div>



            <!-- DESIGN GRAFIS -->

            <div class="col-md-4">

                <div class="card p-4 shadow-sm card-course">

                    <i
                        class="fa fa-palette fa-3x text-danger mb-3">
                    </i>

                    <h4>

                        Design Grafis

                    </h4>

                    <p class="text-muted">

                        Belajar Photoshop,
                        Illustrator,
                        dan Canva.

                    </p>

                </div>

            </div>



            <!-- WEB DEVELOPMENT -->

            <div class="col-md-4">

                <div class="card p-4 shadow-sm card-course">

                    <i
                        class="fa fa-code fa-3x text-success mb-3">
                    </i>

                    <h4>

                        Web Development

                    </h4>

                    <p class="text-muted">

                        Belajar HTML,
                        CSS,
                        PHP,
                        dan Laravel.

                    </p>

                </div>

            </div>


        </div>

    </div>

</section>



<!-- =========================
     FOOTER
========================= -->

<footer class="bg-dark text-white text-center">

    © 2026 LPK Phitagoras.
    Kursus Komputer.

</footer>


</body>

</html>