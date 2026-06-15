@extends('admin.layouts.app_admin')

@section('title', 'Tagihan & Bukti')
@section('page_title', 'Data Tagihan & Pembayaran')
@section('page_desc', 'Cek bukti transfer dan konfirmasi pendaftaran murid.')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="py-3 px-4 text-muted">Nama Siswa</th>
                    <th class="py-3 px-4 text-muted">Program Didaftar</th>
                    <th class="py-3 px-4 text-muted">Total Bayar</th>
                    <th class="py-3 px-4 text-muted text-center">Status</th>
                    <th class="py-3 px-4 text-muted text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tagihans as $tagihan)
                <tr>
                    <td class="py-3 px-4 fw-bold text-dark">{{ $tagihan->nama_siswa }}</td>
                    <td class="py-3 px-4 text-muted">{{ $tagihan->nama_program }}</td>
                    <td class="py-3 px-4 fw-semibold">Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}</td>
                    <td class="py-3 px-4 text-center">
                        <span class="badge {{ $tagihan->status == 'lunas' ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill px-3">
                            {{ ucfirst($tagihan->status) }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-center">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-info rounded-pill px-3 me-2"><i class="fa fa-image me-1"></i> Bukti</button>
                            <button class="btn btn-sm btn-outline-success rounded-pill px-3"><i class="fa fa-check me-1"></i> Konfirmasi</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-5 text-center text-muted">
                        <i class="fa fa-inbox fs-1 mb-3 opacity-50"></i>
                        <h5>Belum ada data pendaftaran & tagihan yang masuk.</h5>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection