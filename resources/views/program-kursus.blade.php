<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Kursus - LPK Phitagoras</title>

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
           TOPBAR
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
           NAVBAR
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
        }

        .brand-logo span {
            color: #ffb800;
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
           PAGE HEADER
        ========================= */

        .page-header {
            background: linear-gradient(120deg, #172a45, #243b55);
            color: #fff;
            padding: 45px 0 40px;
        }

        .breadcrumb-nav {
            font-size: 13px;
            color: #94a3b8;
            margin-bottom: 12px;
        }

        .breadcrumb-nav a {
            color: #94a3b8;
        }

        .breadcrumb-nav a:hover {
            color: #ffb800;
        }

        .page-header h1 {
            font-size: 34px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .page-header p {
            color: #cbd5e1;
            font-size: 15px;
            max-width: 600px;
        }


        /* =========================
           TAB SWITCH
        ========================= */

        .tab-switch-wrap {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 65px;
            z-index: 998;
        }

        .tab-switch {
            display: flex;
            gap: 10px;
        }

        .tab-btn {
            border: none;
            background: none;
            padding: 18px 22px;
            font-weight: 700;
            font-size: 15px;
            color: #64748b;
            border-bottom: 3px solid transparent;
            cursor: pointer;
            transition: 0.2s;
        }

        .tab-btn i {
            margin-right: 8px;
        }

        .tab-btn:hover {
            color: #172a45;
        }

        .tab-btn.active {
            color: #172a45;
            border-bottom-color: #ffb800;
        }


        /* =========================
           TAB PANEL
        ========================= */

        .tab-panel {
            display: none;
            padding: 45px 0 80px;
        }

        .tab-panel.active {
            display: block;
        }

        .panel-intro {
            max-width: 700px;
            margin-bottom: 35px;
        }

        .panel-intro span.badge-label {
            display: inline-block;
            color: #f5a800;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }

        .panel-intro h2 {
            font-size: 30px;
            font-weight: 800;
            color: #172a45;
            margin-bottom: 12px;
        }

        .panel-intro p {
            color: #64748b;
            font-size: 16px;
            line-height: 1.7;
        }


        /* =========================
           ACCORDION (Program Paket)
        ========================= */

        .accordion-list {
            max-width: 800px;
            margin-bottom: 30px;
        }

        .acc-item {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            margin-bottom: 14px;
            overflow: hidden;
        }

        .acc-header {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 22px;
            background: #fff;
            border: none;
            cursor: pointer;
            font-size: 15.5px;
            font-weight: 700;
            color: #172a45;
            text-align: left;
        }

        .acc-header i.acc-cat-icon {
            color: #ffb800;
            margin-right: 10px;
            width: 18px;
        }

        .acc-header .acc-icon {
            color: #94a3b8;
            transition: transform 0.25s ease;
        }

        .acc-item.open .acc-header .acc-icon {
            transform: rotate(180deg);
            color: #ffb800;
        }

        .acc-item.open .acc-header {
            background: #f8fafc;
        }

        .acc-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .acc-body-inner {
            padding: 4px 22px 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .chip {
            background: #f1f5f9;
            color: #172a45;
            font-size: 12.5px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
        }


        /* =========================
           GRID CARDS (Program Satuan)
        ========================= */

        .satuan-card {
            background: #fff;
            border-radius: 14px;
            padding: 26px;
            height: 100%;
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.06);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .satuan-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.12);
        }

        .satuan-card h5 {
            font-size: 16px;
            font-weight: 800;
            color: #172a45;
            margin-bottom: 16px;
        }

        .satuan-card h5 i {
            color: #f5a800;
            margin-right: 8px;
        }

        .satuan-card .materi-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .note-box {
            max-width: 800px;
            background: #fff8e6;
            border: 1px solid #ffe4a6;
            border-radius: 10px;
            padding: 16px 20px;
            color: #7a5b00;
            font-size: 14px;
            margin: 24px 0;
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
           RESPONSIVE
        ========================= */

        @media (max-width: 768px) {
            .nav-menu { display: none; }
            .page-header h1 { font-size: 26px; }
            .tab-btn { padding: 14px 14px; font-size: 13.5px; }
            .panel-intro h2 { font-size: 24px; }
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

        <a href="/" class="brand-logo">Kursus<span>Komputer</span></a>

        <ul class="nav-menu">
            <li><a href="/">Home</a></li>
            <li><a href="/program" class="active">Program Kursus</a></li>
            <li><a href="/#kelas">Kelas Populer</a></li>
            <li><a href="/#footer-kontak">Kontak</a></li>
        </ul>

        <div class="nav-auth">
            <a href="/login" class="btn-login">Login</a>
            <a href="/register" class="btn-register">Register</a>
        </div>

    </div>
</nav>



<!-- =========================
     PAGE HEADER
========================= -->

<section class="page-header">
    <div class="container">
        <div class="breadcrumb-nav">
            <a href="/">Home</a> / <span>Program Kursus</span>
        </div>
        <h1>Program Kursus</h1>
        <p>Dua pilihan cara belajar di LPK Phitagoras — ambil paket lengkap atau pilih materi satuan sesuai kebutuhanmu.</p>
    </div>
</section>



<!-- =========================
     TAB SWITCH
========================= -->

<div class="tab-switch-wrap">
    <div class="container">
        <div class="tab-switch">
            <button class="tab-btn" id="btn-paket" onclick="showTab('paket')">
                <i class="fa fa-box-open"></i> Program Paket
            </button>
            <button class="tab-btn" id="btn-satuan" onclick="showTab('satuan')">
                <i class="fa fa-list-check"></i> Program Satuan
            </button>
        </div>
    </div>
</div>



<!-- =========================
     PANEL: PROGRAM PAKET
========================= -->

<div class="tab-panel" id="panel-paket">
    <div class="container">

        <div class="panel-intro">
            <span class="badge-label">PROGRAM PAKET</span>
            <h2>Semua Kebutuhan Belajar Dalam Satu Paket</h2>
            <p>Program pembelajaran lengkap dengan berbagai materi komputer, mulai dari administrasi perkantoran, praktik intensif, design grafis, sampai technical support. Klik tiap kategori untuk lihat materinya.</p>
        </div>

        <div class="accordion-list">

            <div class="acc-item open">
                <button class="acc-header" onclick="toggleAcc(this)">
                    <span><i class="fa fa-address-card acc-cat-icon"></i> Adm Perkantoran Dasar</span>
                    <i class="fa fa-chevron-down acc-icon"></i>
                </button>
                <div class="acc-body">
                    <div class="acc-body-inner">
                        <span class="chip">Pengenalan Komputer</span>
                        <span class="chip">Mengetik 10 Jari</span>
                        <span class="chip">Korespondensi</span>
                        <span class="chip">Microsoft Word</span>
                        <span class="chip">Microsoft Excel</span>
                        <span class="chip">Internet Basic User</span>
                    </div>
                </div>
            </div>

            <div class="acc-item">
                <button class="acc-header" onclick="toggleAcc(this)">
                    <span><i class="fa fa-layer-group acc-cat-icon"></i> Adm Perkantoran Lanjutan</span>
                    <i class="fa fa-chevron-down acc-icon"></i>
                </button>
                <div class="acc-body">
                    <div class="acc-body-inner">
                        <span class="chip">Microsoft Word Lanjutan</span>
                        <span class="chip">Microsoft Excel Lanjutan</span>
                        <span class="chip">Microsoft Access</span>
                    </div>
                </div>
            </div>

            <div class="acc-item">
                <button class="acc-header" onclick="toggleAcc(this)">
                    <span><i class="fa fa-briefcase acc-cat-icon"></i> Practical Office (Intensif Harian)</span>
                    <i class="fa fa-chevron-down acc-icon"></i>
                </button>
                <div class="acc-body">
                    <div class="acc-body-inner">
                        <span class="chip">Microsoft Word</span>
                        <span class="chip">Microsoft PowerPoint</span>
                    </div>
                </div>
            </div>

            <div class="acc-item">
                <button class="acc-header" onclick="toggleAcc(this)">
                    <span><i class="fa fa-palette acc-cat-icon"></i> Graphic Design</span>
                    <i class="fa fa-chevron-down acc-icon"></i>
                </button>
                <div class="acc-body">
                    <div class="acc-body-inner">
                        <span class="chip">Corel Draw</span>
                        <span class="chip">Adobe Illustrator</span>
                        <span class="chip">Adobe InDesign</span>
                        <span class="chip">Adobe Photoshop</span>
                    </div>
                </div>
            </div>

            <div class="acc-item">
                <button class="acc-header" onclick="toggleAcc(this)">
                    <span><i class="fa fa-screwdriver-wrench acc-cat-icon"></i> Technical Support</span>
                    <i class="fa fa-chevron-down acc-icon"></i>
                </button>
                <div class="acc-body">
                    <div class="acc-body-inner">
                        <span class="chip">Pengenalan Sistem Operasi</span>
                        <span class="chip">Pengenalan Hardware</span>
                        <span class="chip">Merakit PC &amp; BIOS Setting</span>
                        <span class="chip">Instal OS &amp; Program Aplikasi</span>
                        <span class="chip">Networking &amp; Troubleshooting</span>
                    </div>
                </div>
            </div>

        </div>

        <a href="/register" class="program-button">Daftar Sekarang</a>

    </div>
</div>



<!-- =========================
     PANEL: PROGRAM SATUAN
========================= -->

<div class="tab-panel" id="panel-satuan">
    <div class="container">

        <div class="panel-intro">
            <span class="badge-label">PROGRAM SATUAN</span>
            <h2>Pilih Materi Sesuai Kebutuhanmu</h2>
            <p>Gak perlu ambil semua materi — cukup pilih yang benar-benar kamu butuhkan, sesuai kemampuan dan waktu belajar kamu.</p>
        </div>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="satuan-card">
                    <h5><i class="fa fa-file-word"></i> Aplikasi Perkantoran</h5>
                    <div class="materi-chips">
                        <span class="chip">Microsoft Word</span>
                        <span class="chip">Microsoft Excel</span>
                        <span class="chip">Microsoft PowerPoint</span>
                        <span class="chip">Microsoft Access</span>
                        <span class="chip">Mengetik 10 Jari</span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="satuan-card">
                    <h5><i class="fa fa-palette"></i> Design &amp; Multimedia</h5>
                    <div class="materi-chips">
                        <span class="chip">Corel Draw</span>
                        <span class="chip">Adobe Photoshop</span>
                        <span class="chip">Adobe Illustrator</span>
                        <span class="chip">Adobe InDesign</span>
                        <span class="chip">Wondershare Filmora</span>
                        <span class="chip">Canva</span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="satuan-card">
                    <h5><i class="fa fa-drafting-compass"></i> Teknik &amp; Lainnya</h5>
                    <div class="materi-chips">
                        <span class="chip">AutoCAD</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="note-box">
            <i class="fa fa-circle-info"></i>
            Tersedia kelas reguler maupun privat. Bisa datang langsung ke tempat kursus, atau instruktur kami yang berkunjung ke lokasimu.
        </div>

        <a href="/register" class="program-button">Daftar Sekarang</a>

    </div>
</div>



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
    // TAB SWITCH (Program Paket / Program Satuan)
    // =========================

    function showTab(name) {
        document.getElementById('panel-paket').classList.toggle('active', name === 'paket');
        document.getElementById('panel-satuan').classList.toggle('active', name === 'satuan');

        document.getElementById('btn-paket').classList.toggle('active', name === 'paket');
        document.getElementById('btn-satuan').classList.toggle('active', name === 'satuan');

        history.replaceState(null, '', '#' + name);
    }

    // buka tab sesuai hash URL (misal dari home.blade.php: /program#satuan)
    const initialTab = (window.location.hash === '#satuan') ? 'satuan' : 'paket';
    showTab(initialTab);


    // =========================
    // ACCORDION PROGRAM PAKET
    // =========================

    function toggleAcc(headerBtn) {
        const item = headerBtn.closest('.acc-item');
        const body = item.querySelector('.acc-body');
        const isOpen = item.classList.contains('open');

        // tutup semua accordion lain (single-open, biar rapih)
        document.querySelectorAll('.acc-item').forEach(function (el) {
            el.classList.remove('open');
            el.querySelector('.acc-body').style.maxHeight = null;
        });

        if (!isOpen) {
            item.classList.add('open');
            body.style.maxHeight = body.scrollHeight + 'px';
        }
    }

    // buka accordion pertama secara default
    document.addEventListener('DOMContentLoaded', function () {
        const firstAcc = document.querySelector('.acc-item.open .acc-body');
        if (firstAcc) {
            firstAcc.style.maxHeight = firstAcc.scrollHeight + 'px';
        }
    });

</script>


</body>

</html>