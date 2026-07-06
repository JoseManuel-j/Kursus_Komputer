@extends('admin.layouts.app_admin')

@section('title', 'Program Kursus')
@section('page_title', 'Daftar Program Kursus')
@section('page_desc', 'Kelola katalog kelas yang tersedia di LPK Phitagoras.')

@section('content')
<div class="d-flex justify-content-end mb-4">
    <a href="{{ route('admin.program.create') }}" class="btn btn-primary">
        <i class="fa fa-plus me-2"></i>
        Tambah Kelas
    </a>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="py-3 px-4 text-muted">No</th>
                    <th class="py-3 px-4 text-muted">Nama Program</th>
                    <th class="py-3 px-4 text-muted">Tipe Kelas</th>
                    <th class="py-3 px-4 text-muted">Total Sesi</th>
                    <th class="py-3 px-4 text-muted">Biaya (Rp)</th>
                    <th class="py-3 px-4 text-muted text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($programs as $index => $program)
                <tr>
                    <td class="py-3 px-4 fw-bold text-dark">{{ $index + 1 }}</td>
                    <td class="py-3 px-4 fw-semibold">{{ $program->nama_program }}</td>
                    <td class="py-3 px-4">
                        <span class="badge {{ $program->tipe_kelas == 'intensif' ? 'bg-danger' : 'bg-secondary' }} rounded-pill px-3">
                            {{ ucfirst($program->tipe_kelas) }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-muted">{{ $program->jumlah_sesi }} Sesi</td>
                    <td class="py-3 px-4 fw-bold text-success">{{ number_format($program->biaya, 0, ',', '.') }}</td>
                    <td class="py-3 px-4 text-center">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-warning"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-5 text-muted">Belum ada data program kursus.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection