@extends('layouts.app')

@section('content')
<div class="top-banner shadow">
    <h1>Kelas Kursus Komputer</h1>
    <p class="mt-3 mb-0">Pilih kelas terbaik untuk meningkatkan skill kamu.</p>
</div>

<div class="row mt-5 g-4">
    @php
        // Bikin array warna bootstrap biar card-nya warna warni kayak desain lu
        $colors = ['primary', 'danger', 'success', 'warning', 'info'];
    @endphp

    @forelse ($programs as $index => $program)
        @php
            // Ngambil warna bergiliran
            $themeColor = $colors[$index % count($colors)];
        @endphp

        <div class="col-md-4">
            <div class="card shadow class-card h-100">
                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=1200" class="class-image">

                <div class="card-body d-flex flex-column">
                    <h4>{{ $program->nama_program }}</h4>
                    <p class="flex-grow-1">
                        {{ $program->deskripsi ?? 'Belajar materi komprehensif dari dasar hingga mahir.' }}
                    </p>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-{{ $themeColor }} p-2">
                            {{ $program->jumlah_sesi }} Sesi ({{ ucfirst($program->tipe_kelas) }})
                        </span>
                        <strong>
                            Rp {{ number_format($program->biaya, 0, ',', '.') }}
                        </strong>
                    </div>

                    <a href="/pendaftaran/{{ $program->id }}" class="btn btn-{{ $themeColor }} w-100 mt-auto">
                        Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center mt-5">
            <p class="text-muted">Belum ada kelas yang didaftarkan di database.</p>
        </div>
    @endforelse
</div>
@endsection