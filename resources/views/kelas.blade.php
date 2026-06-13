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

<div class="row g-4">
    @forelse ($programs as $program)
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 15px; overflow: hidden;">
                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=1200" 
                     class="class-image" 
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