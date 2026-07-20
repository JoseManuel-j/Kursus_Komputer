<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siswa - LPK Phitagoras</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { background: #f4f7fc; font-family: 'Poppins', sans-serif; }

        /* Desain Sidebar Kiri */
        .sidebar {
            width: 260px; height: 100vh; background: #111827; position: fixed; left: 0; top: 0; padding: 30px 15px;
            display: flex; flex-direction: column; box-shadow: 4px 0 10px rgba(0,0,0,0.1);
            z-index: 1040; transition: transform 0.3s ease;
        }
        .sidebar h2 { color: white; text-align: center; margin-bottom: 40px; font-size: 22px; font-weight: 700; letter-spacing: 1px; }

        .sidebar a {
            display: flex; align-items: center; color: #9ca3af; padding: 12px 20px; text-decoration: none;
            border-radius: 8px; margin-bottom: 10px; font-weight: 500; transition: all 0.3s ease;
        }
        .sidebar a i { width: 25px; font-size: 18px; }
        .sidebar a:hover { background: rgba(255, 255, 255, 0.05); color: #ffffff; transform: translateX(5px); }
        .sidebar a.active { background: #7c3aed; color: white; }

        .main-content { margin-left: 260px; padding: 40px; min-height: 100vh; transition: margin-left 0.3s ease; }

        /* ================= RESPONSIVE: SIDEBAR JADI OFF-CANVAS DI LAYAR KECIL ================= */

        /* Tombol hamburger mengambang, cuma tampil di layar kecil.
           Layout ini tidak punya header bersama (langsung @yield('content')),
           jadi tombolnya dibuat fixed di pojok kiri atas supaya selalu bisa
           diakses dari halaman manapun (dashboard, kelas, angsuran, profile). */
        .btn-toggle-sidebar {
            display: none;
            position: fixed; top: 16px; left: 16px; z-index: 1050;
            background: #111827; color: #fff; border: none; border-radius: 10px;
            width: 44px; height: 44px; align-items: center; justify-content: center;
            font-size: 1.2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.25);
        }

        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0; background: rgba(17, 24, 39, 0.5);
            z-index: 1030;
        }
        .sidebar-overlay.show { display: block; }

        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 24px 20px;
                /* kasih jarak atas biar konten gak ketiban tombol hamburger */
                padding-top: 76px;
            }

            .btn-toggle-sidebar {
                display: inline-flex;
            }
        }

        @media (max-width: 575.98px) {
            .main-content { padding-left: 14px; padding-right: 14px; }
        }
    </style>
</head>
<body>

{{-- Tombol hamburger: cuma kelihatan di layar kecil (lihat CSS .btn-toggle-sidebar) --}}
<button type="button" class="btn-toggle-sidebar" id="btnToggleSidebar" aria-label="Buka menu">
    <i class="fa fa-bars"></i>
</button>

{{-- Overlay: klik di luar sidebar buat nutup (khusus mobile) --}}
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="sidebar" id="sidebarSiswa">
    <h2>LPK Phitagoras</h2>

    <div class="nav-menus">
        <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="fa fa-home me-2"></i> Dashboard
        </a>
        <a href="/kelas" class="{{ request()->is('kelas') ? 'active' : '' }}">
            <i class="fa fa-book me-2"></i> Kelas
        </a>
        <a href="/angsuran" class="{{ request()->is('angsuran') ? 'active' : '' }}">
            <i class="fa fa-money-bill-wave me-2"></i> Angsuran
        </a>
        <a href="/profile" class="{{ request()->is('profile') ? 'active' : '' }}">
            <i class="fa fa-user me-2"></i> Profile
        </a>
    </div>

    <div class="mt-auto">
        <hr style="border-color: rgba(255,255,255,0.1); margin-bottom: 15px;">
        <form action="/logout" method="POST" class="m-0">
            @csrf
            <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="text-danger">
                <i class="fa fa-sign-out-alt me-2"></i> Logout
            </a>
        </form>
    </div>
</div>

<div class="main-content">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle sidebar untuk tampilan mobile/tablet (<= 991px)
    (function () {
        const sidebar = document.getElementById('sidebarSiswa');
        const overlay = document.getElementById('sidebarOverlay');
        const btnToggle = document.getElementById('btnToggleSidebar');

        function openSidebar() {
            sidebar.classList.add('show');
            overlay.classList.add('show');
        }

        function closeSidebar() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        }

        btnToggle.addEventListener('click', function () {
            if (sidebar.classList.contains('show')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });

        overlay.addEventListener('click', closeSidebar);

        // Tutup sidebar otomatis kalau salah satu menu diklik (di layar kecil)
        sidebar.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth <= 991.98) closeSidebar();
            });
        });

        // Kalau layar di-resize jadi besar, pastikan sidebar & overlay balik normal
        window.addEventListener('resize', function () {
            if (window.innerWidth > 991.98) closeSidebar();
        });
    })();
</script>

</body>
</html>