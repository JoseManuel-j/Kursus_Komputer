<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - LPK Phitagoras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: #f8fafc; font-family: 'Poppins', sans-serif; }
        
        /* Sidebar Modern - Deep Slate Theme */
        .sidebar { 
            width: 260px; height: 100vh; background: #0f172a; position: fixed; 
            display: flex; flex-direction: column; color: white; box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            top: 0; left: 0; z-index: 1040;
            transition: transform 0.3s ease;
        }
        
        .sidebar-brand { padding: 30px 0; text-align: center; font-size: 1.4rem; font-weight: 700; color: white; }
        
        .menu-header { 
            color: #475569; font-size: 0.75rem; text-transform: uppercase; 
            letter-spacing: 1px; margin: 20px 0 10px 25px; font-weight: 700;
        }

        .sidebar a { 
            color: #94a3b8; text-decoration: none; padding: 14px 25px; display: flex; 
            align-items: center; border-radius: 10px; margin: 0 15px 6px 15px; 
            transition: all 0.3s ease; font-weight: 500; white-space: nowrap;
        }
        
        .sidebar a i { margin-right: 15px; width: 20px; text-align: center; opacity: 0.7; }
        
        .sidebar a:hover { background: #1e293b; color: #fff; transform: translateX(5px); }
        .sidebar a.active { background: #6366f1; color: white; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3); }
        
        .main-content { margin-left: 260px; padding: 40px; transition: margin-left 0.3s ease; }
        
        /* User Profile Pill */
        .user-pill { 
            background: white; padding: 8px 20px; border-radius: 50px; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.05); display: flex; align-items: center;
        }

        /* ================= RESPONSIVE: SIDEBAR JADI OFF-CANVAS DI LAYAR KECIL ================= */

        /* Tombol hamburger, cuma tampil di layar kecil */
        .btn-toggle-sidebar {
            display: none;
            background: #0f172a; color: #fff; border: none; border-radius: 10px;
            width: 44px; height: 44px; align-items: center; justify-content: center;
            font-size: 1.2rem; flex-shrink: 0;
        }

        /* Overlay gelap di belakang sidebar saat dibuka (mobile) */
        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0; background: rgba(15, 23, 42, 0.5);
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
                padding: 20px;
            }

            .btn-toggle-sidebar {
                display: inline-flex;
            }

            /* Header jadi wrap rapi + gap di layar kecil */
            .page-header {
                flex-wrap: wrap;
                gap: 16px;
            }

            .user-pill {
                padding: 6px 14px;
            }

            .user-pill span {
                display: none; /* sembunyikan nama, cuma foto di layar sempit */
            }
        }

        @media (max-width: 575.98px) {
            .main-content { padding: 14px; }
        }
    </style>
</head>
<body>

{{-- Overlay: klik di luar sidebar buat nutup (khusus mobile) --}}
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="sidebar" id="sidebarAdmin">
    <div class="sidebar-brand">Phitagoras<span class="text-indigo-500">.</span></div>
    <div class="menu-header">Menu Admin</div>
    
    <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
        <i class="fa fa-home"></i> Dashboard
    </a>
    <a href="/admin/siswa" class="{{ request()->is('admin/siswa') ? 'active' : '' }}">
        <i class="fa fa-users"></i> Data Siswa
    </a>
    <a href="/admin/program" class="{{ request()->is('admin/program') ? 'active' : '' }}">
        <i class="fa fa-book"></i> Program Kursus
    </a>
    
    <a href="/admin/jadwal" class="{{ request()->is('admin/jadwal') ? 'active' : '' }}">
        <i class="fa fa-calendar-alt"></i> Jadwal Kelas
    </a>
    
    <a href="/admin/tagihan" class="{{ request()->is('admin/tagihan') ? 'active' : '' }}">
        <i class="fa fa-file-invoice-dollar"></i> Tagihan & Bukti
    </a>

    <a href="/admin/foto-kegiatan" class="{{ request()->is('admin/foto-kegiatan') ? 'active' : '' }}">
        <i class="fa fa-camera"></i> Momen & Aktivitas
    </a>
    
    <div class="mt-auto px-4 pb-4">
        <hr class="border-secondary mb-3">
        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100 rounded-pill">
                <i class="fa fa-sign-out-alt me-2"></i> Logout
            </button>
        </form>
    </div>
</div>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-5 page-header">
        <div class="d-flex align-items-center gap-3">
            {{-- Tombol hamburger: cuma kelihatan di layar kecil (lihat CSS .btn-toggle-sidebar) --}}
            <button type="button" class="btn-toggle-sidebar" id="btnToggleSidebar" aria-label="Buka menu">
                <i class="fa fa-bars"></i>
            </button>
            <div>
                <h2 class="fw-bold text-dark mb-0">@yield('page_title')</h2>
                <p class="text-muted mb-0">@yield('page_desc')</p>
            </div>
        </div>
        <div class="user-pill">
            <span class="me-3 fw-bold">{{ auth()->user()->name }}</span>
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=6366f1&color=fff" class="rounded-circle" width="40">
        </div>
    </div>
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle sidebar untuk tampilan mobile/tablet (<= 991px)
    (function () {
        const sidebar = document.getElementById('sidebarAdmin');
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