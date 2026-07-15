<!-- File: resources/views/angsuran.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Angsuran - LPK Phitagoras</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { background: #f4f7fc; font-family: 'Poppins', sans-serif; }
        
        /* Desain Sidebar Kiri */
        .sidebar { 
            width: 260px; height: 100vh; background: #111827; position: fixed; left: 0; top: 0; padding: 30px 15px; 
            display: flex; flex-direction: column; box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar h2 { color: white; text-align: center; margin-bottom: 40px; font-size: 22px; font-weight: 700; letter-spacing: 1px; }
        
        .sidebar a { 
            display: flex; align-items: center; color: #9ca3af; padding: 12px 20px; text-decoration: none; 
            border-radius: 8px; margin-bottom: 10px; font-weight: 500; transition: all 0.3s ease; 
        }
        .sidebar a i { width: 25px; font-size: 18px; }
        .sidebar a:hover { background: rgba(255, 255, 255, 0.05); color: #ffffff; transform: translateX(5px); }
        .sidebar a.active { background: #7c3aed; color: white; }
        
        .main-content { margin-left: 260px; padding: 40px; min-height: 100vh; }

        /* Jarak antar kartu kelas supaya tidak nempel satu sama lain */
        .kelas-block:not(:last-child) { margin-bottom: 40px; }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
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

<!-- KONTEN UTAMA ANGSURAN -->
<div class="main-content">
    
    <div class="mb-4">
        <h3 class="fw-bold" style="color: #111827;">Pembayaran Angsuran</h3>
        <p class="text-muted">Berikut ini adalah riwayat pembayaran angsuran untuk semua kelas yang Anda ikuti.</p>
    </div>

    {{-- $kelasList berisi SEMUA kelas yang diikuti siswa (bisa lebih dari satu), --}}
    {{-- masing-masing sudah lengkap dengan tagihan, sisa bayar, dan status lunasnya sendiri. --}}
    @forelse($kelasList as $kelas)
        @php
            $p = $kelas->pendaftaran;
        @endphp

        <div class="kelas-block">

            {{-- Kartu Info Ringkasan per kelas --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="fw-bold mb-0" style="color: #7c3aed;">
                            <i class="fa fa-book me-2"></i>{{ $p->nama_program }}
                        </h5>
                        @if($kelas->statusLunas == 'Lunas')
                            <span class="badge bg-success px-3 py-2 rounded-pill">Lunas Total</span>
                        @else
                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Belum Lunas</span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless table-sm mb-0">
                                <tr>
                                    <td style="width: 150px;" class="text-muted">Nomor Bukti</td>
                                    <td style="width: 10px;">:</td>
                                    <td class="fw-medium">REG-{{ str_pad($p->id, 5, '0', STR_PAD_LEFT) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Program Kelas</td>
                                    <td>:</td>
                                    <td class="fw-medium">{{ $p->nama_program }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Total Tagihan</td>
                                    <td>:</td>
                                    <td class="fw-bold" style="color: #7c3aed;">Rp {{ number_format($p->total_biaya, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless table-sm mb-0">
                                <tr>
                                    <td style="width: 150px;" class="text-muted">Sisa Bayar</td>
                                    <td style="width: 10px;">:</td>
                                    <td class="fw-medium text-danger">Rp {{ number_format($kelas->sisaBayar, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Jenis</td>
                                    <td>:</td>
                                    <td class="fw-medium">Angsuran Kursus</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Keterangan</td>
                                    <td>:</td>
                                    <td>
                                        @if($kelas->statusLunas == 'Lunas')
                                            <span class="badge bg-success px-3 py-1 rounded-pill">Lunas Total</span>
                                        @else
                                            <span class="badge bg-warning text-dark px-3 py-1 rounded-pill">Belum Lunas</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kartu Tabel Detail Angsuran per kelas --}}
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4" style="color: #111827;">Detil Angsuran</h5>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle table-bordered text-center">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3">Angs. Ke</th>
                                    <th class="py-3">Jml Hrs Bayar</th>
                                    <th class="py-3">No. Bukti</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3">Tgl Kwitansi</th>
                                    <th class="py-3">Batas Akhir Bayar</th>
                                    <th class="py-3">Tgl Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kelas->tagihans as $index => $t)
                                <tr>
                                    <td class="fw-medium">{{ $index + 1 }}</td>
                                    <td>Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-secondary rounded-pill px-3">INV-{{ str_pad($t->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td>
                                        @if($t->status == 'lunas')
                                            <span class="badge bg-success rounded-pill px-3">Lunas</span>
                                        @elseif($t->status == 'cicilan')
                                            <span class="badge bg-warning text-dark rounded-pill px-3">Cicilan</span>
                                        @elseif($t->status == 'ditolak')
                                            <span class="badge bg-danger rounded-pill px-3">Ditolak</span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-3">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ isset($t->created_at) ? \Carbon\Carbon::parse($t->created_at)->format('d M Y') : '-' }}</td>
                                    <td>{{ isset($t->created_at) ? \Carbon\Carbon::parse($t->created_at)->addDays(30)->format('d M Y') : '-' }}</td>
                                    <td>
                                        @if($t->status == 'lunas')
                                            <span class="text-success fw-medium">{{ isset($t->updated_at) ? \Carbon\Carbon::parse($t->updated_at)->format('d M Y') : 'Lunas' }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-muted py-4">Belum ada riwayat tagihan atau angsuran untuk kelas ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div> {{-- /.kelas-block --}}

    @empty
        <!-- Jika belum mendaftar kelas sama sekali -->
        <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center" style="border-radius: 15px; padding: 20px;">
            <i class="fa fa-info-circle fa-2x me-3"></i>
            <div>
                <strong>Oops!</strong><br>
                Anda belum terdaftar di kelas manapun. Silakan daftar kelas terlebih dahulu di menu Kelas.
            </div>
        </div>
    @endforelse
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>