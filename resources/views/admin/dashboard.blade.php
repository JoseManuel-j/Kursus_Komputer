@extends('admin.layouts.app_admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Admin')
@section('page_desc', 'Halo, ' . auth()->user()->name . '. Monitor aktivitas LPK hari ini.')

@section('content')
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card stat-card p-4 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted fw-bold mb-1">Total Siswa</p>
                        <h2 class="fw-bold mb-0">{{ $totalSiswa }}</h2>
                    </div>
                    <div class="icon-box bg-primary bg-opacity-10 text-primary">
                        <i class="fa fa-user-graduate"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card p-4 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted fw-bold mb-1">Total Program</p>
                        <h2 class="fw-bold mb-0">{{ $totalProgram }}</h2>
                    </div>
                    <div class="icon-box bg-success bg-opacity-10 text-success">
                        <i class="fa fa-book-open"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card p-4 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted fw-bold mb-1">Total Pendaftaran</p>
                        <h2 class="fw-bold mb-0">{{ $totalPendaftar }}</h2>
                    </div>
                    <div class="icon-box bg-warning bg-opacity-10 text-warning">
                        <i class="fa fa-clipboard-list"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm p-4" style="border-radius: 20px;">
        <div class="card-body">
            <h5 class="fw-bold mb-3 text-primary"><i class="fa fa-shield-halved me-2"></i> Akses Admin</h5>
            <p class="text-muted mb-0">Halaman ini adalah pusat kontrol utama. Pastikan setiap perubahan pada data siswa atau tagihan sudah terverifikasi.</p>
        </div>
    </div>
@endsection