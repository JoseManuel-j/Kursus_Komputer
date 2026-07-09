@extends('admin.layouts.app_admin')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard')
@section('page_desc', 'Selamat datang di panel admin LPK Phitagoras.')

@section('content')
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
                    <i class="fa fa-users fs-5"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted mb-1" style="font-size: 13px;">Total Siswa</h6>
                    <h4 class="fw-bold mb-0">{{ $totalSiswa }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-success text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
                    <i class="fa fa-book fs-5"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted mb-1" style="font-size: 13px;">Total Program</h6>
                    <h4 class="fw-bold mb-0">{{ $totalProgram }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-warning text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
                    <i class="fa fa-file-signature fs-5"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted mb-1" style="font-size: 13px;">Total Pendaftar</h6>
                    <h4 class="fw-bold mb-0">{{ $totalPendaftar }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
    <div class="card-header bg-white pt-4 pb-3 border-0">
        <h6 class="fw-bold mb-0"><i class="fa fa-clock me-2 text-primary"></i>5 Pendaftaran Terbaru</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="py-3 px-4 text-muted small">Nama Siswa</th>
                    <th class="py-3 px-4 text-muted small">Program Diambil</th>
                    <th class="py-3 px-4 text-muted small">Status Keuangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendaftaran as $item)
                <tr>
                    <td class="py-3 px-4 fw-bold text-dark">{{ $item->nama_siswa }}</td>
                    <td class="py-3 px-4 text-muted">{{ $item->nama_program }}</td>
                    <td class="py-3 px-4">
                        @if($item->sisa_bayar <= 0)
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                                <i class="fa fa-check me-1"></i> Lunas Total
                            </span>
                        @else
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">
                                Sisa: Rp {{ number_format($item->sisa_bayar, 0, ',', '.') }}
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-5 text-muted">
                        <i class="fa fa-folder-open fs-1 mb-3 opacity-25"></i>
                        <p class="mb-0">Belum ada data pendaftaran.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection