<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - LPK Phitagoras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background: #f4f7fc; }
        .sidebar { min-height: 100vh; background: #1e1e2f; color: white; }
        .sidebar a { color: #a0a5b1; text-decoration: none; padding: 12px 20px; display: block; border-radius: 8px; margin-bottom: 5px; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: #4f46e5; color: white; }
        .stat-card { border-radius: 15px; border: none; transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-5px); }
        .icon-box { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px; }
    </style>
</head>
<body>

<div class="d-flex">
    <div class="sidebar p-3" style="width: 260px;">
        <h4 class="text-white fw-bold text-center mb-4 mt-2">Phitagoras<span class="text-primary">.</span></h4>
        
        <p class="text-muted small fw-bold text-uppercase px-3 mb-2">Menu Utama</p>
        
        <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <i class="fa fa-home me-2"></i> Dashboard
        </a>
        <a href="/admin/siswa" class="{{ request()->is('admin/siswa') ? 'active' : '' }}">
            <i class="fa fa-users me-2"></i> Data Siswa
        </a>
        <a href="/admin/program" class="{{ request()->is('admin/program') ? 'active' : '' }}">
            <i class="fa fa-book me-2"></i> Program Kursus
        </a>
        <a href="/admin/tagihan" class="{{ request()->is('admin/tagihan') ? 'active' : '' }}">
            <i class="fa fa-file-invoice-dollar me-2"></i> Tagihan & Bukti
        </a>
        
        <div class="mt-5 px-3">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100"><i class="fa fa-sign-out-alt me-2"></i> Logout</button>
            </form>
        </div>
    </div>

    <div class="flex-grow-1 p-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark">Dashboard Admin</h2>
                <p class="text-muted">Selamat datang kembali, {{ auth()->user()->name }}!</p>
            </div>
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=1e1e2f&color=fff" class="rounded-circle shadow-sm" width="50">
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card stat-card shadow-sm p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted fw-bold mb-1">Total Siswa</p>
                            <h3 class="fw-bold mb-0">{{ $totalSiswa }}</h3>
                        </div>
                        <div class="icon-box bg-primary text-white bg-opacity-75">
                            <i class="fa fa-user-graduate"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card shadow-sm p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted fw-bold mb-1">Program Kursus</p>
                            <h3 class="fw-bold mb-0">{{ $totalProgram }}</h3>
                        </div>
                        <div class="icon-box bg-success text-white bg-opacity-75">
                            <i class="fa fa-book-open"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card shadow-sm p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted fw-bold mb-1">Total Pendaftaran</p>
                            <h3 class="fw-bold mb-0">{{ $totalPendaftar }}</h3>
                        </div>
                        <div class="icon-box bg-warning text-dark bg-opacity-75">
                            <i class="fa fa-clipboard-list"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-body p-4">
                <h5 class="fw-bold"><i class="fa fa-bell text-primary me-2"></i> Pusat Kontrol LPK Phitagoras</h5>
                <p class="text-muted mb-0 mt-2">Dari sini lu bisa ngatur semua data kelas, ngecek bukti transfer murid, sampe ngurusin status pendaftaran. Modul-modul di *sidebar* kiri bisa pelan-pelan kita idupin nanti.</p>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>