@extends('layouts.app')

@section('content')

<div class="mb-4">
    <h2 class="fw-bold">Pilihan Kelas</h2>
    <p class="text-muted">Pilih kursus yang sesuai dengan kebutuhanmu.</p>
    
    <div class="row g-2 mt-3">
        <div class="col-md-6">
            <form action="/kelas" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control" placeholder="Cari nama kelas..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary ms-2"><i class="fa fa-search"></i></button>
            </form>
        </div>
        
        <div class="col-md-6">
            <div class="d-flex gap-2 justify-content-md-end">
                <a href="/kelas" class="btn btn-outline-secondary">Semua</a>
                <a href="/kelas?kategori=reguler" class="btn btn-outline-secondary">Reguler</a>
                <a href="/kelas?kategori=private" class="btn btn-outline-secondary">Private</a>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- BAGIAN 1: KELAS YANG SUDAH DIDAFTAR        -->
<!-- ========================================== -->
@if(isset($programTerdaftar) && $programTerdaftar)
    <h5 class="fw-bold mb-3 mt-4" style="color: #4f46e5;">
        <i class="fa fa-check-circle me-2"></i>Kelas Saya Saat Ini
    </h5>
    
    <div class="row mb-5">
        <div class="col-md-4">
            <!-- Kartu diberi border warna khusus agar terlihat berbeda -->
            <div class="card shadow-sm h-100" style="border-radius: 15px; overflow: hidden; border: 2px solid #4f46e5;">
                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=1200" 
                     class="class-image" style="height: 180px; object-fit: cover;"
                     alt="{{ $programTerdaftar->nama_program }}">
                     
                <div class="card-body d-flex flex-column p-4">
                    <span class="badge bg-{{ $programTerdaftar->tipe_kelas == 'intensif' ? 'danger' : 'primary' }} mb-2 align-self-start">
                        {{ ucfirst($programTerdaftar->tipe_kelas) }}
                    </span>
                    <h5 class="fw-bold">{{ $programTerdaftar->nama_program }}</h5>
                    <p class="text-muted small mb-3">{{ $programTerdaftar->deskripsi }}</p>
                    
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted"><i class="fa fa-clock me-1"></i> {{ $programTerdaftar->jumlah_sesi }} Sesi</span>
                            <strong class="text-primary">Rp {{ number_format($programTerdaftar->biaya, 0, ',', '.') }}</strong>
                        </div>
                        <button class="btn btn-secondary w-100" style="border-radius: 8px;" disabled>
                            <i class="fa fa-check me-1"></i> Sedang Diikuti
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Garis Pemisah -->
    <hr class="mb-5 text-muted opacity-25">
    
    <h5 class="fw-bold mb-4" style="color: #111827;">
        <i class="fa fa-th-large me-2"></i> Kelas Lainnya
    </h5>
@endif

<!-- ========================================== -->
<!-- BAGIAN 2: KELAS YANG BELUM DIDAFTAR        -->
<!-- ========================================== -->
<div class="row g-4">
    <!-- Menggunakan $programLainnya jika ada, atau fallback ke $programs jika error -->
    @forelse ($programLainnya ?? $programs as $program)
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 15px; overflow: hidden;">
                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=1200" 
                     class="class-image" style="height: 180px; object-fit: cover;"
                     alt="{{ $program->nama_program }}">
                     
                <div class="card-body d-flex flex-column p-4">
                    <span class="badge bg-{{ $program->tipe_kelas == 'intensif' ? 'danger' : 'primary' }} mb-2 align-self-start">
                        {{ ucfirst($program->tipe_kelas) }}
                    </span>
                    <h5 class="fw-bold">{{ $program->nama_program }}</h5>
                    <p class="text-muted small mb-3">{{ $program->deskripsi }}</p>
                    
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted"><i class="fa fa-clock me-1"></i> {{ $program->jumlah_sesi }} Sesi</span>
                            <strong class="text-primary">Rp {{ number_format($program->biaya, 0, ',', '.') }}</strong>
                        </div>
                        <a href="/pendaftaran/{{ $program->id }}" class="btn btn-outline-dark w-100" style="border-radius: 8px;">
                            Detail & Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center mt-5 text-muted">
            <i class="fa fa-folder-open fa-3x mb-3"></i>
            <p>Kelas tidak ditemukan.</p>
        </div>
    @endforelse
</div>

@endsection