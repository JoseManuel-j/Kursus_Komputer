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
                                    @if($kelas->sisaBayar > 0)
                                        <button type="button" class="btn btn-sm btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#modalBayar{{ $p->id }}">
                                            <i class="fa fa-upload"></i> Bayar
                                        </button>
                                    @endif
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
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr class="text-muted small">
                                    <th class="py-3 px-4">Angs. Ke</th>
                                    <th class="py-3 px-4">Nominal</th>
                                    <th class="py-3 px-4">Status</th>
                                    <th class="py-3 px-4">Tgl Tagihan</th> <!-- Tgl Kwitansi -->
                                    <th class="py-3 px-4">Jatuh Tempo</th>
                                    <th class="py-3 px-4">Tgl Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kelas->tagihans as $index => $t)
                                <tr>
                                    <td class="px-4 fw-bold text-dark">{{ $index + 1 }}</td>
                                    <td class="px-4 text-dark">Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                                    <td class="px-4">
                                        @php
                                            $badge = [
                                                'lunas' => 'bg-success',
                                                'cicilan' => 'bg-warning text-dark',
                                                'pending' => 'bg-secondary',
                                                'ditolak' => 'bg-danger'
                                            ][$t->status] ?? 'bg-light text-dark';
                                        @endphp
                                        <span class="badge {{ $badge }} rounded-pill px-3">{{ ucfirst($t->status) }}</span>
                                    </td>
                                <td class="px-4 text-muted small">{{ \Carbon\Carbon::parse($t->created_at)->format('d M Y') }}</td>
                                <td class="px-4 text-muted small">{{ \Carbon\Carbon::parse($t->jatuh_tempo)->format('d M Y') }}</td>
                                <td class="px-4">
                                    @if($t->status == 'lunas')
                                        <span class="text-success fw-bold">{{ $t->tanggal_bayar ? \Carbon\Carbon::parse($t->tanggal_bayar)->format('d M Y') : '-' }}</span>
                                    @elseif($t->status == 'pending')
                                        <span class="text-primary small fst-italic">⏳ Verifikasi Admin</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Belum ada riwayat tagihan.</td>
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

    @foreach($kelasList as $kelas)
        @php $p = $kelas->pendaftaran; @endphp
        <div class="modal fade" id="modalBayar{{ $p->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="border-radius: 16px;">
                    <form action="{{ route('siswa.angsuran.bayar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="pendaftaran_id" value="{{ $p->id }}">
                        <div class="modal-header"><h5 class="modal-title">Upload Bukti - {{ $p->nama_program }}</h5></div>
        <div class="modal-body">
            <!-- BAGIAN INFO BANK & QRIS -->
            <div class="row mb-3 align-items-center bg-light p-3 rounded" style="border: 1px solid #e0e0e0;">
                <div class="col-7 border-end">
                    <h6 class="fw-bold mb-1">Transfer Bank</h6>
                    <div class="text-muted small">Bank BCA</div>
                    <div class="fw-bold fs-6">1234 5678 90</div>
                    <div class="small">A/N LPK Phitagoras</div>
                </div>
                <div class="col-5 text-center">
                    <!-- QRIS Diperbesar ke 140px -->
                    <img src="{{ asset('images/qris-phitagoras.jpeg') }}" width="140" alt="QRIS" class="img-fluid border rounded shadow-sm">
                </div>
            </div>

                <!-- BAGIAN INPUT FORM -->
            @if($kelas->nextTagihan)
                @php
                    $nomorAngsuran = $kelas->tagihans->search(fn($t) => $t->id === $kelas->nextTagihan->id) + 1;
                @endphp
                <div class="mb-3">
                    <label class="form-label small fw-bold">Yang Akan Dibayar</label>
                    <div class="alert alert-info d-flex justify-content-between align-items-center mb-0" style="border-radius: 10px;">
                        <span>Angsuran ke-{{ $nomorAngsuran }}</span>
                        <strong>Rp {{ number_format($kelas->nextTagihan->jumlah, 0, ',', '.') }}</strong>
                    </div>
                </div>
            @else
                <div class="alert alert-warning mb-0">Tidak ada angsuran yang perlu dibayar saat ini.</div>
            @endif
            <div class="mb-3">
                <label class="form-label small fw-bold">Foto Bukti Transfer</label>
                <input type="file" name="bukti_bayar" class="form-control" accept="image/*" required>
            </div>

            </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" {{ !$kelas->nextTagihan ? 'disabled' : '' }}>
                        Kirim
                    </button>
                </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
            </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>