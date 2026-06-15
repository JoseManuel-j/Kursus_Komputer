@extends('admin.layouts.app_admin')

@section('title', 'Data Siswa')
@section('page_title', 'Data Siswa Terdaftar')
@section('page_desc', 'Kelola semua akun murid LPK Phitagoras di sini.')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="py-3 px-4 text-muted">No</th>
                    <th class="py-3 px-4 text-muted">Nama Lengkap</th>
                    <th class="py-3 px-4 text-muted">Email</th>
                    <th class="py-3 px-4 text-muted">Tanggal Daftar</th>
                    <th class="py-3 px-4 text-muted text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($siswas as $index => $siswa)
                <tr>
                    <td class="py-3 px-4 fw-bold text-dark">{{ $index + 1 }}</td>
                    <td class="py-3 px-4 fw-semibold">{{ $siswa->name }}</td>
                    <td class="py-3 px-4 text-muted">{{ $siswa->email }}</td>
                    <td class="py-3 px-4 text-muted">{{ \Carbon\Carbon::parse($siswa->created_at)->format('d M Y') }}</td>
                    <td class="py-3 px-4 text-center">
                        <button class="btn btn-sm btn-outline-primary rounded-pill px-3"><i class="fa fa-eye me-1"></i> Detail</button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="py-5 text-center text-muted">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection