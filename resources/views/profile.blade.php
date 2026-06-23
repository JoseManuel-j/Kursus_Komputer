@extends('layouts.app')

@section('content')

@php
    $pendaftaran = \Illuminate\Support\Facades\DB::table('pendaftaran')
        ->leftJoin('program_kursus', 'pendaftaran.program_id', '=', 'program_kursus.id')
        ->where('pendaftaran.user_id', auth()->id())
        ->select('pendaftaran.*', 'program_kursus.nama_program')
        ->orderBy('pendaftaran.created_at', 'desc')
        ->first();

    $avatarUrl = ($pendaftaran && $pendaftaran->pas_foto) 
        ? asset('uploads/dokumen_siswa/' . $pendaftaran->pas_foto) 
        : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=ffffff&color=4f46e5&size=100&bold=true';
@endphp

<div class="row justify-content-center">
    <div class="col-md-10">
        
        <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
            
            <div class="card-header border-0 text-white p-5" style="background: linear-gradient(135deg, #4f46e5, #7c3aed);">
                <h2 class="fw-bold mb-0">Profil Siswa</h2>
                <p class="mb-0 opacity-75">Kelola informasi akun Anda di LPK Phitagoras</p>
            </div>
            
            <div class="card-body p-5 position-relative">
                
                <div class="position-absolute" style="top: -50px; left: 40px;">
                    <img src="{{ $avatarUrl }}" 
                         alt="Avatar" 
                         class="rounded-circle shadow-sm border border-4 border-white"
                         style="width: 100px; height: 100px; object-fit: cover; background-color: #fff;">
                </div>

                <div style="margin-top: 60px;"></div>

                <h5 class="fw-bold mb-4" style="color: #4f46e5;"><i class="fa fa-user-circle me-2"></i>Informasi Akun</h5>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small fw-bold text-uppercase mb-1"><i class="fa fa-user me-2"></i>Nama Lengkap</label>
                        <p class="fs-5 fw-semibold text-dark mb-0">{{ auth()->user()->name }}</p>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small fw-bold text-uppercase mb-1"><i class="fa fa-envelope me-2"></i>Email Address</label>
                        <p class="fs-5 fw-semibold text-dark mb-0">{{ auth()->user()->email }}</p>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small fw-bold text-uppercase mb-1"><i class="fa fa-shield-alt me-2"></i>Status Akun</label>
                        <p class="fs-5 fw-semibold text-success mb-0"><i class="fa fa-check-circle me-1"></i> Terverifikasi</p>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small fw-bold text-uppercase mb-1"><i class="fa fa-calendar-alt me-2"></i>Bergabung Sejak</label>
                        <p class="fs-5 fw-semibold text-dark mb-0">{{ auth()->user()->created_at->format('d F Y') }}</p>
                    </div>
                </div>

                <hr class="my-4 text-muted opacity-25">

                <h5 class="fw-bold mb-4" style="color: #4f46e5;"><i class="fa fa-id-card me-2"></i>Biodata Pribadi</h5>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small fw-bold text-uppercase mb-1"><i class="fa fa-phone me-2"></i>Nomor HP</label>
                        <p class="fs-5 fw-semibold text-dark mb-0">{{ auth()->user()->nomor_hp ?? 'Belum ada nomor HP' }}</p>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small fw-bold text-uppercase mb-1"><i class="fa fa-map-marker-alt me-2"></i>Tempat, Tanggal Lahir</label>
                        <p class="fs-5 fw-semibold text-dark mb-0">
                            {{ auth()->user()->tempat_lahir ?? '-' }}, 
                            {{ (auth()->user()->tanggal_lahir ?? null) ? date('d F Y', strtotime(auth()->user()->tanggal_lahir)) : '-' }}
                        </p>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small fw-bold text-uppercase mb-1"><i class="fa fa-pray me-2"></i>Agama</label>
                        <p class="fs-5 fw-semibold text-dark mb-0">{{ auth()->user()->agama ?? '-' }}</p>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small fw-bold text-uppercase mb-1"><i class="fa fa-home me-2"></i>Alamat Lengkap</label>
                        <p class="fs-5 fw-semibold text-dark mb-0">{{ auth()->user()->alamat ?? 'Belum ada data alamat.' }}</p>
                    </div>
                </div>

                <hr class="my-4 text-muted opacity-25">

                <h5 class="fw-bold mb-4" style="color: #4f46e5;"><i class="fa fa-graduation-cap me-2"></i>Kursus & Dokumen</h5>
                
                @if($pendaftaran)
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Program Kursus</label>
                            <p class="fs-5 fw-semibold text-dark mb-0">{{ $pendaftaran->nama_program }}</p>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Status Pendaftaran</label>
                            <div>
                                <span class="badge rounded-pill bg-success px-3 py-2 text-uppercase fw-bold shadow-sm">
                                    <i class="fa fa-check-circle me-1"></i> {{ $pendaftaran->status }}
                                </span>
                            </div>
                        </div>

                        <div class="col-12 mb-4">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Berkas Lampiran Saya</label>
                            <div class="d-flex gap-2 mt-2">
                                @if($pendaftaran->file_ktp)
                                    <a href="{{ asset('uploads/dokumen_siswa/' . $pendaftaran->file_ktp) }}" target="_blank" class="btn btn-outline-primary fw-bold px-4 rounded-pill shadow-sm">
                                        <i class="fa fa-id-badge me-2"></i> Lihat KTP
                                    </a>
                                @endif
                                
                                @if($pendaftaran->file_ijazah)
                                    <a href="{{ asset('uploads/dokumen_siswa/' . $pendaftaran->file_ijazah) }}" target="_blank" class="btn btn-outline-primary fw-bold px-4 rounded-pill shadow-sm">
                                        <i class="fa fa-graduation-cap me-2"></i> Lihat Ijazah
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning border-0 shadow-sm rounded-3">
                        <i class="fa fa-exclamation-triangle me-2"></i> Anda belum terdaftar di program kursus manapun.
                    </div>
                @endif

            </div>
        </div>
        
    </div>
</div>
@endsection 