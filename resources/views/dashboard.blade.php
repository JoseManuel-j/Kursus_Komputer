@extends('layouts.app')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="fa fa-check-circle me-2"></i> <strong>Mantap!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="top-banner shadow">
    <h1>Selamat Datang, {{ auth()->user()->nama_lengkap ?? 'Siswa' }}</h1>
    <p class="mt-2 mb-0">Selamat belajar di website LPK Phitagoras.</p>
</div>

<div class="row mt-4 g-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-body p-4">
                <i class="fa fa-book text-primary mb-3" style="font-size: 2.5rem;"></i>
                <h2 class="fw-bold mb-1">0</h2>
                <p class="text-muted mb-0">Total Kelas</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-body p-4">
                <i class="fa fa-users text-success mb-3" style="font-size: 2.5rem;"></i>
                <h2 class="fw-bold mb-1">0</h2>
                <p class="text-muted mb-0">Total Siswa</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-body p-4">
                <i class="fa fa-laptop-code text-danger mb-3" style="font-size: 2.5rem;"></i>
                <h2 class="fw-bold mb-1">0</h2>
                <p class="text-muted mb-0">Kelas Aktif</p>
            </div>
        </div>
    </div>
</div>
@endsection