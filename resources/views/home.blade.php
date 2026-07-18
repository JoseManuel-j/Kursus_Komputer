<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LPK Phitagoras - Kursus Komputer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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

        a { text-decoration: none; }


        /* =========================
           TOPBAR (ala detik.com)
        ========================= */

        .topbar {
            background: #172a45;
            color: #cbd5e1;
            font-size: 13px;
            padding: 6px 0;
        }

        .topbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar-right a {
            color: #cbd5e1;
            margin-left: 14px;
            font-size: 15px;
        }

        .topbar-right a:hover {
            color: #ffb800;
        }


        /* =========================
           NAVBAR (sticky, ala detik.com)
        ========================= */

        .navbar-main {
            background: #ffffff;
            box-shadow: 0 2px 10px rgba(15, 23, 42, 0.08);
            position: sticky;
            top: 0;
            z-index: 999;
            padding: 14px 0;
        }

        .navbar-main .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-logo {
            font-size: 24px;
            font-weight: 800;
            color: #172a45;
            display: flex;
            align-items: center;
        }

        .brand-logo-img {
            height: 48px;
            width: auto;
            display: block;
        }

        .nav-menu {
            display: flex;
            gap: 28px;
            list-style: none;
        }

        .nav-menu a {
            color: #172a45;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 0.4px;
            text-transform: uppercase;
            padding-bottom: 6px;
            border-bottom: 2px solid transparent;
            transition: 0.2s;
        }

        .nav-menu a:hover,
        .nav-menu a.active {
            color: #e5a600;
            border-bottom: 2px solid #ffb800;
        }

        .nav-auth a {
            font-weight: 700;
            font-size: 14px;
            margin-left: 10px;
            padding: 8px 18px;
            border-radius: 6px;
        }

        .nav-auth .btn-login {
            color: #172a45;
            border: 1px solid #172a45;
        }

        .nav-auth .btn-login:hover {
            background: #172a45;
            color: #fff;
        }

        .nav-auth .btn-register {
            background: #ffb800;
            color: #172a45;
        }

        .nav-auth .btn-register:hover {
            background: #e5a600;
        }


        /* =========================
           GALERI KEGIATAN (slider ala detik.com)
        ========================= */

        .galeri-section {
            background: #0f172a;
            padding: 40px 0 55px;
        }

        .galeri-label {
            color: #ffb800;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 2px;
            margin-bottom: 8px;
            display: block;
        }

        .galeri-title {
            color: #fff;
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .slider-wrap {
            position: relative;
            border-radius: 14px;
            overflow: hidden;
            background: #1e293b;
            box-shadow: 0 15px 40px rgba(0,0,0,0.35);
        }

        .slider-track {
            display: flex;
            transition: transform 0.45s ease;
        }

        .slide {
            min-width: 100%;
            height: 420px;
            position: relative;
            display: flex;
            align-items: flex-end;
        }

        .slide img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .slide.img-error img {
            display: none;
        }

        /* fallback gradient tiap slide kalau foto asli belum ada */
        .slide[data-fallback="1"] { background: linear-gradient(135deg, #1d4ed8, #172a45); }
        .slide[data-fallback="2"] { background: linear-gradient(135deg, #ffb800, #b8860b); }
        .slide[data-fallback="3"] { background: linear-gradient(135deg, #16a34a, #0f3d24); }
        .slide[data-fallback="4"] { background: linear-gradient(135deg, #dc2626, #4c0f0f); }
        .slide[data-fallback="5"] { background: linear-gradient(135deg, #7c3aed, #241143); }

        .slide-fallback-icon {
            position: absolute;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 90px;
            color: rgba(255,255,255,0.25);
        }

        .slide.img-error .slide-fallback-icon {
            display: flex;
        }

        .slide-caption {
            position: relative;
            z-index: 2;
            width: 100%;
            padding: 30px 90px 24px 30px;
            background: linear-gradient(to top, rgba(0,0,0,0.85), rgba(0,0,0,0));
            color: #fff;
        }

        .slide-caption .tag {
            display: inline-block;
            background: #ffb800;
            color: #172a45;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1px;
            padding: 3px 10px;
            border-radius: 4px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .slide-caption h3 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .slide-caption p {
            font-size: 14px;
            color: #cbd5e1;
        }

        .slide-counter {
            position: absolute;
            top: 18px;
            right: 20px;
            z-index: 3;
            background: rgba(0,0,0,0.55);
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 20px;
        }

        .slide-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 4;
            background: rgba(255,255,255,0.9);
            color: #172a45;
            border: none;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.2s;
        }

        .slide-nav-btn:hover {
            background: #ffb800;
        }

        .slide-nav-btn.prev { left: 16px; }
        .slide-nav-btn.next { right: 16px; }

        .thumb-strip {
            display: flex;
            gap: 12px;
            margin-top: 14px;
            overflow-x: auto;
            padding-bottom: 4px;
        }

        .thumb-item {
            flex: 0 0 auto;
            width: 130px;
            height: 74px;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            cursor: pointer;
            opacity: 0.55;
            border: 2px solid transparent;
            transition: 0.2s;
        }

        .thumb-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .thumb-item.img-error img { display: none; }

        .thumb-item[data-fallback="1"] { background: linear-gradient(135deg, #1d4ed8, #172a45); }
        .thumb-item[data-fallback="2"] { background: linear-gradient(135deg, #ffb800, #b8860b); }
        .thumb-item[data-fallback="3"] { background: linear-gradient(135deg, #16a34a, #0f3d24); }
        .thumb-item[data-fallback="4"] { background: linear-gradient(135deg, #dc2626, #4c0f0f); }
        .thumb-item[data-fallback="5"] { background: linear-gradient(135deg, #7c3aed, #241143); }

        .thumb-item.active,
        .thumb-item:hover {
            opacity: 1;
            border-color: #ffb800;
        }

        .thumb-item span {
            position: absolute;
            bottom: 4px;
            left: 6px;
            right: 6px;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            text-shadow: 0 1px 3px rgba(0,0,0,0.8);
        }


        /* =========================
           INTRO SINGKAT
        ========================= */

        .intro-section {
            padding: 55px 0 20px;
            text-align: center;
        }

        .intro-section h1 {
            font-size: 38px;
            font-weight: 800;
            color: #172a45;
            margin-bottom: 14px;
        }

        .intro-section p {
            color: #64748b;
            font-size: 16px;
            max-width: 600px;
            margin: 0 auto 22px;
            line-height: 1.7;
        }


        /* =========================
           PROGRAM KURSUS
        ========================= */

        .program-section {
            padding: 70px 0 100px;
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

        .program-card {
            height: 100%;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 35px rgba(15, 23, 42, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .program-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.15);
        }

        .program-banner {
            width: 100%;
            padding: 22px 30px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .program-banner i {
            font-size: 26px;
        }

        .program-banner span {
            font-weight: 700;
            font-size: 15px;
        }

        .banner-paket {
            background: linear-gradient(120deg, #1d4ed8, #172a45);
        }

        .banner-satuan {
            background: linear-gradient(120deg, #f5a800, #b8860b);
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
            margin-bottom: 15px;
        }

        .program-teaser-link {
            display: block;
            height: 100%;
        }

        .program-teaser {
            height: 100%;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 35px rgba(15, 23, 42, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .program-teaser:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.15);
        }

        .program-teaser-content {
            padding: 30px;
        }

        .program-teaser-content h3 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #172a45;
        }

        .program-teaser-content p {
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 18px;
        }

        .teaser-cta {
            color: #172a45;
            font-weight: 700;
            font-size: 14px;
        }

        .teaser-cta i {
            margin-left: 4px;
            transition: 0.2s;
        }

        .program-teaser-link:hover .teaser-cta i {
            transform: translateX(4px);
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

        .site-footer {
            background: #0f172a;
            color: #cbd5e1;
            padding: 50px 0 20px;
        }

        .site-footer h5 {
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 14px;
        }

        .site-footer h5 i {
            color: #ffb800;
            margin-right: 6px;
        }

        .footer-text {
            font-size: 14px;
            line-height: 1.8;
            color: #94a3b8;
        }

        .footer-wa {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 10px;
            color: #25d366;
            font-weight: 700;
            font-size: 15px;
        }

        .footer-wa:hover {
            color: #1ebc59;
        }

        .footer-divider {
            border-color: rgba(255,255,255,0.1);
            margin: 30px 0 18px;
        }

        .footer-bottom {
            font-size: 13px;
            color: #64748b;
            padding-bottom: 10px;
        }


        /* =========================
           RESPONSIVE TABLET
        ========================= */

        @media (max-width: 768px) {

            .nav-menu { display: none; }

            .intro-section h1 { font-size: 30px; }

            .slide { height: 320px; }

            .slide-caption { padding: 20px 60px 18px 18px; }

            .program-section { padding: 50px 0; }

            .program-header h2 { font-size: 34px; }

            .program-image { height: 450px; }

            .program-card { margin-bottom: 25px; }

        }


        /* =========================
           RESPONSIVE MOBILE
        ========================= */

        @media (max-width: 480px) {

            .slide { height: 260px; }

            .slide-caption h3 { font-size: 17px; }

            .slide-nav-btn { width: 34px; height: 34px; font-size: 14px; }

            .intro-section h1 { font-size: 25px; }

            .program-header h2 { font-size: 29px; }

            .program-header p { font-size: 15px; }

            .program-image { height: 370px; }

            .program-content { padding: 25px; }

            .program-content h3 { font-size: 24px; }

        }

    </style>

</head>

<body>


<!-- =========================
     TOPBAR
========================= -->

<div class="topbar">
    <div class="container">
        <div class="topbar-left" id="topbar-date">Selamat datang di LPK Phitagoras</div>
        <div class="topbar-right">
            <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
            <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
        </div>
    </div>
</div>


<!-- =========================
     NAVBAR
========================= -->

<nav class="navbar-main">
    <div class="container">

        <a href="/" class="brand-logo"><img src="{{ asset('Images/logo/logo-phitagoras.png') }}" alt="LPK Phitagoras" class="brand-logo-img"></a>

        <ul class="nav-menu">
            <li><a href="#galeri" class="active">Home</a></li>
            <li><a href="/program">Program Kursus</a></li>
            <li><a href="#kelas">Kelas Populer</a></li>
            <li><a href="#footer-kontak">Kontak</a></li>
        </ul>

        <div class="nav-auth">
            <a href="/login" class="btn-login">Login</a>
            <a href="/register" class="btn-register">Register</a>
        </div>

    </div>
</nav>



<!-- =========================
     GALERI KEGIATAN (slider ala detik.com)
========================= -->

<section class="galeri-section" id="galeri">

    <div class="container">

        <span class="galeri-label">GALERI KEGIATAN</span>
        <h2 class="galeri-title">Momen &amp; Aktivitas LPK Phitagoras</h2>

        <div class="slider-wrap">

            <div class="slide-counter">
                <span id="slideCounter">1</span> / <span id="slideTotal">5</span>
            </div>

            <button class="slide-nav-btn prev" onclick="prevSlide()" aria-label="Sebelumnya">
                <i class="fa fa-chevron-left"></i>
            </button>

            <button class="slide-nav-btn next" onclick="nextSlide()" aria-label="Berikutnya">
                <i class="fa fa-chevron-right"></i>
            </button>

            <div class="slider-track" id="sliderTrack">

                <div class="slide" data-fallback="1">
                    <img src="{{ asset('Images/kegiatan/kegiatan-1.jpg') }}"
                         alt="Pelatihan Komputer Pegawai Kecamatan Ciputat"
                         onerror="this.parentElement.classList.add('img-error')">
                    <div class="slide-fallback-icon"><i class="fa fa-building"></i></div>
                    <div class="slide-caption">
                        <span class="tag">Pelatihan Instansi</span>
                        <h3>Pelatihan Komputer Pegawai Kec. Ciputat</h3>
                        <p>Pelatihan komputer untuk pegawai Kecamatan Ciputat, 16-19 November 2022.</p>
                    </div>
                </div>

                <div class="slide" data-fallback="2">
                    <img src="{{ asset('Images/kegiatan/kegiatan-2.jpg') }}"
                         alt="Praktik Komputer Pegawai Kecamatan Ciputat"
                         onerror="this.parentElement.classList.add('img-error')">
                    <div class="slide-fallback-icon"><i class="fa fa-desktop"></i></div>
                    <div class="slide-caption">
                        <span class="tag">Pelatihan Instansi</span>
                        <h3>Praktik Langsung Bersama Instruktur</h3>
                        <p>Peserta pelatihan pegawai Kecamatan Ciputat praktik langsung didampingi instruktur.</p>
                    </div>
                </div>

                <div class="slide" data-fallback="3">
                    <img src="{{ asset('Images/kegiatan/kegiatan-3.jpg') }}"
                         alt="Pelatihan Komputer Ibu PKK Rempoa"
                         onerror="this.parentElement.classList.add('img-error')">
                    <div class="slide-fallback-icon"><i class="fa fa-users"></i></div>
                    <div class="slide-caption">
                        <span class="tag">Pelatihan PKK</span>
                        <h3>Pelatihan Komputer Ibu PKK Rempoa</h3>
                        <p>Kegiatan pelatihan komputer untuk Ibu PKK Rempoa, Juni 2025.</p>
                    </div>
                </div>

                <div class="slide" data-fallback="4">
                    <img src="{{ asset('Images/kegiatan/kegiatan-4.jpg') }}"
                         alt="Praktik Microsoft Office Ibu PKK Rempoa"
                         onerror="this.parentElement.classList.add('img-error')">
                    <div class="slide-fallback-icon"><i class="fa fa-file-word"></i></div>
                    <div class="slide-caption">
                        <span class="tag">Pelatihan PKK</span>
                        <h3>Praktik Microsoft Office Bersama Ibu PKK</h3>
                        <p>Peserta Ibu PKK Rempoa antusias mempraktikkan materi Microsoft Office.</p>
                    </div>
                </div>

                <div class="slide" data-fallback="5">
                    <img src="{{ asset('Images/kegiatan/kegiatan-5.jpg') }}"
                         alt="Pengarahan Sebelum Pelatihan Kader PKK Rengas"
                         onerror="this.parentElement.classList.add('img-error')">
                    <div class="slide-fallback-icon"><i class="fa fa-chalkboard-user"></i></div>
                    <div class="slide-caption">
                        <span class="tag">Pelatihan PKK</span>
                        <h3>Pengarahan Kader PKK Rengas</h3>
                        <p>Pengarahan dari Pak Purwiyanto sebelum pelatihan kader PKK Rengas dimulai.</p>
                    </div>
                </div>

                <div class="slide" data-fallback="6">
                    <img src="{{ asset('Images/kegiatan/kegiatan-6.jpg') }}"
                         alt="Pelatihan Komputer Kader PKK Rengas"
                         onerror="this.parentElement.classList.add('img-error')">
                    <div class="slide-fallback-icon"><i class="fa fa-laptop"></i></div>
                    <div class="slide-caption">
                        <span class="tag">Pelatihan PKK</span>
                        <h3>Pelatihan Komputer Kader PKK Rengas</h3>
                        <p>Kegiatan pelatihan komputer untuk kader PKK Rengas, Juni 2022.</p>
                    </div>
                </div>

                <div class="slide" data-fallback="7">
                    <img src="{{ asset('Images/kegiatan/kegiatan-7.jpg') }}"
                         alt="Pelatihan Kader PKK Kecamatan Ciputat Timur"
                         onerror="this.parentElement.classList.add('img-error')">
                    <div class="slide-fallback-icon"><i class="fa fa-people-group"></i></div>
                    <div class="slide-caption">
                        <span class="tag">Pelatihan PKK</span>
                        <h3>Pelatihan Kader PKK Kec. Ciputat Timur</h3>
                        <p>Foto bersama peserta kader PKK se-Kecamatan Ciputat Timur bersama Pak Purwiyanto.</p>
                    </div>
                </div>

                <div class="slide" data-fallback="8">
                    <img src="{{ asset('Images/kegiatan/kegiatan-8.jpg') }}"
                         alt="Suasana Pelatihan Pegawai Kecamatan Ciputat"
                         onerror="this.parentElement.classList.add('img-error')">
                    <div class="slide-fallback-icon"><i class="fa fa-user-group"></i></div>
                    <div class="slide-caption">
                        <span class="tag">Pelatihan Instansi</span>
                        <h3>Suasana Kelas Pegawai Kecamatan Ciputat</h3>
                        <p>Suasana belajar yang interaktif selama pelatihan komputer pegawai Kec. Ciputat.</p>
                    </div>
                </div>

            </div>

        </div>

        <div class="thumb-strip" id="thumbStrip">
            <div class="thumb-item active" data-fallback="1" onclick="goToSlide(0)">
                <img src="{{ asset('Images/kegiatan/kegiatan-1.jpg') }}" alt="" onerror="this.parentElement.classList.add('img-error')">
                <span>Pegawai Ciputat</span>
            </div>
            <div class="thumb-item" data-fallback="2" onclick="goToSlide(1)">
                <img src="{{ asset('Images/kegiatan/kegiatan-2.jpg') }}" alt="" onerror="this.parentElement.classList.add('img-error')">
                <span>Praktik Bersama</span>
            </div>
            <div class="thumb-item" data-fallback="3" onclick="goToSlide(2)">
                <img src="{{ asset('Images/kegiatan/kegiatan-3.jpg') }}" alt="" onerror="this.parentElement.classList.add('img-error')">
                <span>PKK Rempoa</span>
            </div>
            <div class="thumb-item" data-fallback="4" onclick="goToSlide(3)">
                <img src="{{ asset('Images/kegiatan/kegiatan-4.jpg') }}" alt="" onerror="this.parentElement.classList.add('img-error')">
                <span>Ms. Office</span>
            </div>
            <div class="thumb-item" data-fallback="5" onclick="goToSlide(4)">
                <img src="{{ asset('Images/kegiatan/kegiatan-5.jpg') }}" alt="" onerror="this.parentElement.classList.add('img-error')">
                <span>PKK Rengas</span>
            </div>
            <div class="thumb-item" data-fallback="6" onclick="goToSlide(5)">
                <img src="{{ asset('Images/kegiatan/kegiatan-6.jpg') }}" alt="" onerror="this.parentElement.classList.add('img-error')">
                <span>Kader PKK</span>
            </div>
            <div class="thumb-item" data-fallback="7" onclick="goToSlide(6)">
                <img src="{{ asset('Images/kegiatan/kegiatan-7.jpg') }}" alt="" onerror="this.parentElement.classList.add('img-error')">
                <span>Ciputat Timur</span>
            </div>
            <div class="thumb-item" data-fallback="8" onclick="goToSlide(7)">
                <img src="{{ asset('Images/kegiatan/kegiatan-8.jpg') }}" alt="" onerror="this.parentElement.classList.add('img-error')">
                <span>Suasana Kelas</span>
            </div>
        </div>

    </div>

</section>



<!-- =========================
     INTRO SINGKAT
========================= -->

<section class="intro-section">
    <div class="container">
        <h1>Belajar Komputer Jadi Lebih Mudah</h1>
        <p>Belajar Microsoft Office, Design Grafis, dan Web Development bersama instruktur berpengalaman di LPK Phitagoras.</p>
        <a href="/register" class="program-button">Mulai Belajar</a>
    </div>
</section>



<!-- =========================
     PROGRAM KURSUS (teaser -> halaman detail)
========================= -->

<section class="program-section" id="program">

    <div class="container">

        <div class="program-header">
            <span class="program-label">PROGRAM KURSUS</span>
            <h2>Pilih Program Belajar Kamu</h2>
            <p>Temukan program kursus komputer yang sesuai dengan kebutuhan dan tujuan belajar kamu.</p>
        </div>

        <div class="row g-4">

            <!-- TEASER PROGRAM PAKET -->
            <div class="col-lg-6">
                <a href="/program#paket" class="program-teaser-link">
                    <div class="program-teaser">
                        <div class="program-banner banner-paket">
                            <i class="fa fa-box-open"></i>
                            <span>Semua kebutuhan belajar dalam satu paket</span>
                        </div>
                        <div class="program-teaser-content">
                            <h3>Program Paket</h3>
                            <p>Adm Perkantoran Dasar &amp; Lanjutan, Practical Office, Graphic Design, sampai Technical Support — lengkap dalam satu paket kursus.</p>
                            <span class="teaser-cta">Lihat Detail Program <i class="fa fa-arrow-right"></i></span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- TEASER PROGRAM SATUAN -->
            <div class="col-lg-6">
                <a href="/program#satuan" class="program-teaser-link">
                    <div class="program-teaser">
                        <div class="program-banner banner-satuan">
                            <i class="fa fa-list-check"></i>
                            <span>Pilih materi sesuai kebutuhanmu</span>
                        </div>
                        <div class="program-teaser-content">
                            <h3>Program Satuan</h3>
                            <p>Pilih sendiri materi yang ingin dipelajari, mulai dari Microsoft Office, Design &amp; Multimedia, sampai AutoCAD.</p>
                            <span class="teaser-cta">Lihat Detail Program <i class="fa fa-arrow-right"></i></span>
                        </div>
                    </div>
                </a>
            </div>

        </div>

    </div>

</section>



<!-- =========================
     KELAS POPULER
========================= -->

<section class="popular-section" id="kelas">

    <div class="container">

        <div class="text-center mb-5">
            <h2 class="popular-title">Kelas Populer</h2>
            <p class="text-muted mt-3">Pilihan kelas komputer yang banyak diminati.</p>
        </div>

        <div class="row g-4">

            <!-- PRACTICAL OFFICE -->
            <div class="col-md-4">
                <div class="card p-4 shadow-sm card-course">
                    <i class="fa fa-briefcase fa-3x text-primary mb-3"></i>
                    <h4>Practical Office</h4>
                    <p class="text-muted">Praktik intensif Microsoft Word &amp; PowerPoint setiap hari, cocok buat yang mau cepat mahir.</p>
                </div>
            </div>

            <!-- ADM PERKANTORAN DASAR -->
            <div class="col-md-4">
                <div class="card p-4 shadow-sm card-course">
                    <i class="fa fa-address-card fa-3x text-danger mb-3"></i>
                    <h4>Adm Perkantoran Dasar</h4>
                    <p class="text-muted">Pengenalan komputer, mengetik 10 jari, korespondensi, Microsoft Word &amp; Excel, dan internet basic user.</p>
                </div>
            </div>

            <!-- ADM PERKANTORAN LANJUTAN -->
            <div class="col-md-4">
                <div class="card p-4 shadow-sm card-course">
                    <i class="fa fa-layer-group fa-3x text-success mb-3"></i>
                    <h4>Adm Perkantoran Lanjutan</h4>
                    <p class="text-muted">Pendalaman Microsoft Word &amp; Excel tingkat lanjutan plus Microsoft Access untuk kebutuhan kantor.</p>
                </div>
            </div>

        </div>

    </div>

</section>



<!-- =========================
     KONTAK / FOOTER
========================= -->

<footer class="site-footer" id="footer-kontak">

    <div class="container">

        <div class="row g-4">

            <div class="col-md-4">
                <h5><i class="fa fa-graduation-cap"></i> LPK Phitagoras</h5>
                <p class="footer-text">
                    Lembaga Kursus dan Pelatihan komputer terpercaya di Tangerang Selatan.
                    Menyiapkan SDM berkualitas menuju Indonesia Emas.
                </p>
            </div>

            <div class="col-md-4">
                <h5><i class="fa fa-location-dot"></i> Alamat &amp; Kontak</h5>
                <p class="footer-text">
                    Jl. Otista Raya Ruko Prima No. B15,<br>
                    Kel. Ciputat, Kec. Ciputat,<br>
                    Tangerang Selatan, Banten 15411
                </p>
                <a href="https://wa.me/6285217184694" target="_blank" class="footer-wa">
                    <i class="fab fa-whatsapp"></i> 0852-1718-4694
                </a>
            </div>

            <div class="col-md-4">
                <h5><i class="fa fa-stamp"></i> Legalitas</h5>
                <p class="footer-text">
                    Nilek Nasional: 23204.1.0001<br>
                    NPSN: K5666513
                </p>
            </div>

        </div>

        <hr class="footer-divider">

        <div class="text-center footer-bottom">
            © 2026 LPK Phitagoras. Kursus Komputer.
        </div>

    </div>

</footer>


<script>

    // =========================
    // TANGGAL DI TOPBAR
    // =========================

    const hariIni = new Date();
    const opsiTanggal = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
    document.getElementById('topbar-date').textContent =
        hariIni.toLocaleDateString('id-ID', opsiTanggal);


    // =========================
    // SLIDER GALERI KEGIATAN
    // (klik kiri-kanan, thumbnail, autoplay - ala detik.com)
    // =========================

    const track = document.getElementById('sliderTrack');
    const slides = track.querySelectorAll('.slide');
    const thumbs = document.querySelectorAll('.thumb-item');
    const counterEl = document.getElementById('slideCounter');
    const totalEl = document.getElementById('slideTotal');

    let currentSlide = 0;
    const totalSlides = slides.length;
    totalEl.textContent = totalSlides;

    let autoplayTimer = null;

    function renderSlide() {
        track.style.transform = `translateX(-${currentSlide * 100}%)`;
        counterEl.textContent = currentSlide + 1;

        thumbs.forEach((t, i) => t.classList.toggle('active', i === currentSlide));
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        renderSlide();
        resetAutoplay();
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        renderSlide();
        resetAutoplay();
    }

    function goToSlide(index) {
        currentSlide = index;
        renderSlide();
        resetAutoplay();
    }

    function startAutoplay() {
        autoplayTimer = setInterval(nextSlide, 5000);
    }

    function resetAutoplay() {
        clearInterval(autoplayTimer);
        startAutoplay();
    }

    // dukungan panah kiri/kanan keyboard
    document.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowRight') nextSlide();
        if (e.key === 'ArrowLeft') prevSlide();
    });

    renderSlide();
    startAutoplay();

</script>


</body>

</html>
