@extends('admin.layouts.app_admin')

@section('title', 'Data Siswa')
@section('page_title', 'Kelola Data Siswa')
@section('page_desc', 'Daftar seluruh akun siswa yang terdaftar di sistem LPK Phitagoras.')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
    <div class="card-header bg-white border-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0" style="color: #111827;">Daftar Akun Siswa</h5>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="bg-light">
                    <tr>
                        <th class="py-3 px-4">No</th>
                        <th class="py-3 px-4 text-start">Nama Lengkap</th>
                        <th class="py-3 px-4">Email</th>
                        <th class="py-3 px-4">Nomor HP</th>
                        <th class="py-3 px-4">Tanggal Daftar Akun</th>
                        <th class="py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Melakukan looping data dari variabel $siswas -->
                    @forelse($siswas as $index => $siswa)
                    <tr>
                        <td class="py-3 px-4 fw-medium text-muted">{{ $index + 1 }}</td>
                        
                        <td class="py-3 px-4 text-start">
                            <div class="d-flex align-items-center">
                                <!-- Avatar inisial nama -->
                                <div class="rounded-circle text-white d-flex justify-content-center align-items-center me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, #4f46e5, #7c3aed); font-weight: bold;">
                                    {{ strtoupper(substr($siswa->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark">{{ $siswa->name }}</h6>
                                </div>
                            </div>
                        </td>
                        
                        <td class="py-3 px-4">{{ $siswa->email }}</td>
                        
                        <td class="py-3 px-4">{{ $siswa->nomor_hp ?? '-' }}</td>
                        
                        <td class="py-3 px-4 text-muted">
                            {{ isset($siswa->created_at) ? \Carbon\Carbon::parse($siswa->created_at)->format('d M Y') : '-' }}
                        </td>
                        
                        <td class="py-3 px-4">
                            <!-- Tombol ini akan mengarahkan ke halaman Detail Siswa yang kita buat sebelumnya -->
                            <a href="/admin/siswa/{{ $siswa->id }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold">
                                <i class="fa fa-eye me-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-5 text-center text-muted">
                            <i class="fa fa-users fs-1 mb-3 opacity-50"></i>
                            <h5>Belum ada data siswa yang mendaftar.</h5>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection