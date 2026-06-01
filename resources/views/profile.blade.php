@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        
        <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
            
            <div class="card-header border-0 text-white p-5" style="background: linear-gradient(135deg, #4f46e5, #7c3aed);">
                <h2 class="fw-bold mb-0">Profil Siswa</h2>
                <p class="mb-0 opacity-75">Kelola informasi akun Anda di LPK Phitagoras</p>
            </div>
            
            <div class="card-body p-5 position-relative">
                
                <div class="position-absolute" style="top: -50px; left: 40px;">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=ffffff&color=4f46e5&size=100&bold=true" 
                         alt="Avatar" 
                         class="rounded-circle shadow-sm border border-4 border-white">
                </div>

                <div style="margin-top: 60px;"></div>

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

                <hr class="my-4 text-muted">


            </div>
        </div>
        
    </div>
</div>
@endsection