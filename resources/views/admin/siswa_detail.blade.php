@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="/admin/siswa" class="btn btn-outline-secondary shadow-sm rounded-pill px-4">
            <i class="fa fa-arrow-left me-2"></i> Kembali ke Data Siswa
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                
                <div class="card-header border-0 text-white p-5" style="background: linear-gradient(135deg, #4f46e5, #7c3aed);">
                    <h2 class="fw-bold mb-0">Detail Profil Siswa</h2>
                    <p class="mb-0 opacity-75">Data lengkap akun dan pendaftaran kursus.</p>
                </div>
                
                <div class="card-body p-5 position-relative">
                    
                    <div class="position-absolute" style="top: -50px; left: 40px;">
                        @php
                            $avatarUrl = ($pendaftaran && $pendaftaran->pas_foto) 
                                ? asset('uploads/dokumen_siswa/' . $pendaftaran->pas_foto) 
                                : 'https://ui-avatars.com/api/?name=' . urlencode($siswa->name) . '&background=ffffff&color=4f46e5&size=100&bold=true';
                        @endphp
                        
                        <img src="{{ $avatarUrl }}" 
                             alt="Avatar {{ $siswa->name }}" 
                             class="rounded-circle shadow-sm border border-4 border-white"
                             style="width: 100px; height: 100px; object-fit: cover; background-color: #fff;">
                    </div>

                    <div style="margin-top: 60px;"></div>

                    <h5 class="fw-bold mb-4" style="color: #4f46e5;"><i class="fa fa-id-card me-2"></i>Informasi Pribadi</h5>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Nama Lengkap</label>
                            <p class="fs-5 fw-semibold text-dark mb-0">{{ $siswa->name }}</p>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Email Address</label>
                            <p class="fs-5 fw-semibold text-dark mb-0">{{ $siswa->email }}</p>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Nomor HP</label>
                            <p class="fs-5 fw-semibold text-dark mb-0">{{ $siswa->nomor_hp ?? 'Belum ada nomor HP' }}</p>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Tempat, Tanggal Lahir</label>
                            <p class="fs-5 fw-semibold text-dark mb-0">
                                {{ $siswa->tempat_lahir ?? '-' }}, 
                                {{ ($siswa->tanggal_lahir ?? null) ? date('d F Y', strtotime($siswa->tanggal_lahir)) : '-' }}
                            </p>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Agama</label>
                            <p class="fs-5 fw-semibold text-dark mb-0">{{ $siswa->agama ?? '-' }}</p>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Alamat Lengkap</label>
                            <p class="fs-5 fw-semibold text-dark mb-0">{{ $siswa->alamat ?? 'Belum ada data alamat.' }}</p>
                        </div>
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <h5 class="fw-bold mb-4" style="color: #4f46e5;"><i class="fa fa-graduation-cap me-2"></i>Status Pendaftaran & Dokumen</h5>
                    
                    @if($pendaftaran)
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="text-muted small fw-bold text-uppercase mb-1">Program Kursus</label>
                                <p class="fs-5 fw-semibold text-dark mb-0">{{ $pendaftaran->nama_program }}</p>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="text-muted small fw-bold text-uppercase mb-1">Tanggal Daftar</label>
                                <p class="fs-5 fw-semibold text-dark mb-0">{{ date('d F Y', strtotime($pendaftaran->tanggal_daftar)) }}</p>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="text-muted small fw-bold text-uppercase mb-1">Status Kursus</label>
                                <div>
                                    <span class="badge rounded-pill bg-success px-3 py-2 text-uppercase fw-bold shadow-sm">
                                        <i class="fa fa-check-circle me-1"></i> {{ $pendaftaran->status }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="text-muted small fw-bold text-uppercase mb-1">Berkas Lampiran</label>
                                <div class="d-flex gap-2 mt-1">
                                    @if($pendaftaran->file_ktp)
                                        <a href="{{ asset('uploads/dokumen_siswa/' . $pendaftaran->file_ktp) }}" target="_blank" class="btn btn-sm btn-outline-primary fw-bold">
                                            <i class="fa fa-file-pdf me-1"></i> KTP
                                        </a>
                                    @endif
                                    
                                    @if($pendaftaran->file_ijazah)
                                        <a href="{{ asset('uploads/dokumen_siswa/' . $pendaftaran->file_ijazah) }}" target="_blank" class="btn btn-sm btn-outline-primary fw-bold">
                                            <i class="fa fa-file-pdf me-1"></i> Ijazah
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning border-0 shadow-sm rounded-3">
                            <i class="fa fa-exclamation-triangle me-2"></i> Siswa ini belum mendaftar program kursus apapun.
                        </div>
                    @endif

                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection