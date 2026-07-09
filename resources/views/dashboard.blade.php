@extends('layouts.app')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="fa fa-check-circle me-2"></i> <strong>Mantap!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="top-banner shadow-sm p-4 mb-4 bg-white rounded-4" style="border-left: 5px solid #7c3aed;">
    <h2 class="fw-bold mb-1">Selamat Datang, {{ auth()->user()->name ?? 'Siswa' }}! 👋</h2>
    <p class="text-muted mb-0">Selamat belajar dan kembangkan skill kamu di LPK Phitagoras.</p>
</div>

@php
    $tagihanBelumLunas = $pendaftaran->filter(function($item) {
        return $item->sisa_bayar > 0;
    })->count();
@endphp

<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100" style="border-radius: 15px; border-bottom: 4px solid #0d6efd;">
            <div class="card-body p-4 text-center">
                <i class="fa fa-laptop-code text-primary mb-3" style="font-size: 2.5rem;"></i>
                <h2 class="fw-bold mb-1">{{ $pendaftaran->count() }}</h2>
                <p class="text-muted mb-0">Kelas Diikuti</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100" style="border-radius: 15px; border-bottom: 4px solid #198754;">
            <div class="card-body p-4 text-center">
                <i class="fa fa-certificate text-success mb-3" style="font-size: 2.5rem;"></i>
                <h2 class="fw-bold mb-1">0</h2>
                <p class="text-muted mb-0">Sertifikat Diperoleh</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100" style="border-radius: 15px; border-bottom: 4px solid #dc3545;">
            <div class="card-body p-4 text-center">
                <i class="fa fa-file-invoice-dollar text-danger mb-3" style="font-size: 2.5rem;"></i>
                <h2 class="fw-bold mb-1 text-danger">{{ $tagihanBelumLunas }}</h2>
                <p class="text-muted mb-0">Kelas Belum Lunas</p>
            </div>
        </div>
    </div>
</div>

<h5 class="fw-bold mb-3 mt-5"><i class="fa fa-book-open text-primary me-2"></i>Kelas & Tagihan Saya</h5>

@if($pendaftaran->isEmpty())
    <div class="alert alert-warning border-0 shadow-sm" style="border-radius: 15px;">
        <i class="fa fa-info-circle me-2"></i> Kamu belum terdaftar atau belum di-ACC di program kursus manapun.
    </div>
@else
    <div class="row g-4 mb-4">
        @foreach($pendaftaran as $item)
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-primary mb-0">
                            <i class="fa fa-book me-2"></i> {{ $item->programKursus->nama_program ?? 'Program' }}
                        </h5>
                        <span class="badge bg-light text-dark border">
                            Kelas {{ ucfirst($item->programKursus->tipe_kelas ?? '-') }}
                        </span>
                    </div>

                    <div class="mb-4 p-3 bg-light rounded" style="border-radius: 15px !important;">
                        <h6 class="fw-bold mb-2 small text-muted">STATUS PEMBAYARAN:</h6>
                        @if($item->sisa_bayar <= 0)
                            <span class="badge bg-success px-3 py-2 w-100 text-start" style="font-size: 0.9rem;">
                                <i class="fa fa-check-circle me-2"></i> Lunas Total
                            </span>
                        @else
                            <span class="badge bg-danger px-3 py-2 w-100 text-start" style="font-size: 0.9rem;">
                                <i class="fa fa-exclamation-circle me-2"></i> Sisa Tagihan: Rp {{ number_format($item->sisa_bayar, 0, ',', '.') }}
                            </span>
                        @endif
                    </div>

                    <h6 class="fw-bold mb-3 small text-muted"><i class="fa fa-calendar-alt me-2"></i>JADWAL BELAJAR:</h6>
                    @if(isset($item->jadwal) && $item->jadwal->isEmpty())
                        <div class="alert alert-light border border-warning-subtle text-warning-emphasis mb-0" style="border-radius: 10px; font-size: 0.9rem;">
                            <i class="fa fa-clock me-1"></i> Jadwal belum diatur. Silakan tunggu info admin.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless align-middle mb-0">
                                <tbody>
                                    @foreach($item->jadwal as $jadwal)
                                    <tr>
                                        <td class="fw-bold text-dark" style="width: 25%;">{{ $jadwal->hari }}</td>
                                        <td>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle">
                                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }} WIB
                                            </span>
                                        </td>
                                        <td class="text-muted small text-end">{{ $jadwal->ruangan ?? 'Online / Lab' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3"><i class="fa fa-history text-secondary me-2"></i>Aktivitas Terakhir</h5>
                <ul class="list-group list-group-flush">
                    @forelse($aktivitas as $log)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <p class="mb-0 fw-medium">{{ $log->keterangan }}</p>
                            <small class="text-muted">Kursus: {{ $log->kursus }}</small>
                        </div>
                        <span class="badge bg-light text-muted">
                            {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                        </span>
                    </li>
                    @empty
                    <li class="list-group-item text-muted text-center">Belum ada riwayat aktivitas terbaru.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection