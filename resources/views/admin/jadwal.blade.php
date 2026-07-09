@extends('admin.layouts.app_admin')

@section('title', 'Kelola Jadwal Murid')
@section('page_title', 'Data Jadwal Murid')
@section('page_desc', 'Atur jadwal untuk murid yang sudah melakukan pembayaran (Lunas).')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-white pt-4 pb-2 border-0">
                <h6 class="fw-bold mb-0">Set Jadwal Murid</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.jadwal.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Pilih Murid (Sudah Lunas)</label>
                        <select name="pendaftaran_id" class="form-select" required>
                            <option value="">-- Pilih Murid --</option>
                            @foreach($muridLunas as $murid)
                                <option value="{{ $murid->pendaftaran_id }}">
                                    {{ $murid->nama_siswa }} ({{ $murid->nama_program }})
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text" style="font-size: 11px;">Hanya murid dengan tagihan 'Lunas' yang muncul di sini.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Hari</label>
                        <select name="hari" class="form-select" required>
                            <option value="">-- Pilih Hari --</option>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                            <option value="Minggu">Minggu</option>
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold small">Jam Mulai</label>
                            <input type="time" name="jam_mulai" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold small">Jam Selesai</label>
                            <input type="time" name="jam_selesai" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small">Ruangan / Tempat</label>
                        <input type="text" name="ruangan" class="form-control" placeholder="Contoh: Lab 1 / Online">
                    </div>

                    <button type="submit" class="btn btn-primary w-100" style="border-radius: 10px;">
                        Simpan Jadwal
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Murid</th>
                                <th>Program</th>
                                <th>Hari & Waktu</th>
                                <th>Ruangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jadwals as $jadwal)
                            <tr>
                                <td class="fw-bold text-primary">{{ $jadwal->nama_siswa }}</td>
                                <td>{{ $jadwal->nama_program }}</td>
                                <td>
                                    <div class="fw-bold">{{ $jadwal->hari }}</div>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                                        {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                    </span>
                                </td>
                                <td>{{ $jadwal->ruangan ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Belum ada jadwal yang ditambahkan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection