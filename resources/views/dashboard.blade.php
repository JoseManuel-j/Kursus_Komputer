@extends('layouts.app')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="fa fa-check-circle me-2"></i> <strong>Mantap!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="top-banner shadow-sm p-4 mb-4 bg-white rounded-4" style="border-left: 5px solid #7c3aed;">
    <h2 class="fw-bold mb-1">Selamat Datang, {{ auth()->user()->name ?? 'Siswa' }}!</h2>
    <p class="text-muted mb-0">Selamat belajar dan kembangkan skill kamu di LPK Phitagoras.</p>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100" style="border-radius: 15px; border-bottom: 4px solid #0d6efd;">
            <div class="card-body p-4 text-center">
                <i class="fa fa-laptop-code text-primary mb-3" style="font-size: 2.5rem;"></i>
                <h2 class="fw-bold mb-1">0</h2>
                <p class="text-muted mb-0">Kelas Aktif</p>
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
                <h2 class="fw-bold mb-1 text-danger">0</h2>
                <p class="text-muted mb-0">Tagihan Belum Lunas</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3"><i class="fa fa-history text-secondary me-2"></i>Aktivitas Terakhir</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <p class="mb-0 fw-medium">Menyelesaikan Kuis Modul 1</p>
                            <small class="text-muted">Kursus: Web Development</small>
                        </div>
                        <span class="badge bg-light text-dark">Baru saja</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <p class="mb-0 fw-medium">Membaca Materi Pengenalan HTML</p>
                            <small class="text-muted">Kursus: Web Development</small>
                        </div>
                        <span class="badge bg-light text-muted">2 jam yang lalu</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection