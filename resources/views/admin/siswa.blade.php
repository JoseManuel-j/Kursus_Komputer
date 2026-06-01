<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - LPK Phitagoras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background: #f4f7fc; }
        .sidebar { min-height: 100vh; background: #1e1e2f; color: white; }
        .sidebar a { color: #a0a5b1; text-decoration: none; padding: 12px 20px; display: block; border-radius: 8px; margin-bottom: 5px; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: #4f46e5; color: white; }
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
                <h2 class="fw-bold text-dark">Data Siswa Terdaftar</h2>
                <p class="text-muted">Kelola semua akun murid LPK Phitagoras di sini.</p>
            </div>
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=1e1e2f&color=fff" class="rounded-circle shadow-sm" width="50">
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">Nama Lengkap</th>
                            <th class="py-3 px-4">Email</th>
                            <th class="py-3 px-4">Tanggal Daftar</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswas as $index => $siswa)
                        <tr>
                            <td class="py-3 px-4 fw-bold text-muted">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 fw-semibold">{{ $siswa->name }}</td>
                            <td class="py-3 px-4 text-muted">{{ $siswa->email }}</td>
                            <td class="py-3 px-4 text-muted">{{ \Carbon\Carbon::parse($siswa->created_at)->format('d M Y') }}</td>
                            <td class="py-3 px-4 text-center">
                                <button class="btn btn-sm btn-outline-primary" title="Detail Siswa"><i class="fa fa-eye"></i></button>
                                <button class="btn btn-sm btn-outline-danger" title="Hapus Siswa"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-5 text-center text-muted">
                                <i class="fa fa-folder-open fs-1 mb-3"></i>
                                <h5>Belum ada siswa yang terdaftar.</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>