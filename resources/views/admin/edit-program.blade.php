@extends('admin.layouts.app_admin')

@section('title', 'Edit Program Kursus')

@section('page_title', 'Edit Program Kursus')

@section('page_desc', 'Perbarui informasi program kelas di LPK Phitagoras.')

@section('content')

<!-- Notifikasi Error Utama -->
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <strong>Data belum berhasil diperbarui.</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Notifikasi Sukses Tambah Jadwal -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- CARD 1: FORM EDIT PROGRAM -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-4 border-bottom pb-2">Informasi Program</h5>
        
        <form action="{{ route('admin.program.update', $program->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="form-label fw-bold">Nama Program</label>
                <input type="text" name="nama_program" class="form-control" value="{{ old('nama_program', $program->nama_program) }}" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Tipe Kelas</label>
                <select name="tipe_kelas" class="form-select" required>
                    <option value="reguler" {{ old('tipe_kelas', $program->tipe_kelas) == 'reguler' ? 'selected' : '' }}>Reguler</option>
                    <option value="intensif" {{ old('tipe_kelas', $program->tipe_kelas) == 'intensif' ? 'selected' : '' }}>Intensif</option>
                    <option value="private" {{ old('tipe_kelas', $program->tipe_kelas) == 'private' ? 'selected' : '' }}>Private</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Kategori Program</label>
                <select name="kategori" class="form-select" required>
                    <option value="paket" {{ old('kategori', $program->kategori) == 'paket' ? 'selected' : '' }}>Program Paket (boleh dicicil)</option>
                    <option value="satuan" {{ old('kategori', $program->kategori) == 'satuan' ? 'selected' : '' }}>Program Satuan (bayar lunas saja)</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="5" required>{{ old('deskripsi', $program->deskripsi) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Jumlah Sesi</label>
                <input type="number" name="jumlah_sesi" class="form-control" value="{{ old('jumlah_sesi', $program->jumlah_sesi) }}" min="1" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Biaya Program</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" name="biaya" class="form-control" value="{{ old('biaya', $program->biaya) }}" min="0" required>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-3 pt-3">
                <a href="{{ route('admin.program') }}" class="btn btn-light border px-4">
                    <i class="fa fa-arrow-left me-2"></i> Batal
                </a>
                <button type="submit" class="btn btn-warning px-4">
                    <i class="fa fa-save me-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- CARD 2: FORM TAMBAH JADWAL -->
<div class="card border-0 shadow-sm" style="border-radius: 20px;">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-4 border-bottom pb-2">Atur Jadwal Kelas</h5>
        
        <form action="{{ route('admin.jadwal.store') }}" method="POST">
            @csrf
            <!-- Hidden input untuk nyimpen ID Program otomatis -->
            <input type="hidden" name="program_kursus_id" value="{{ $program->id }}"> 
            
            <div class="row">
                <div class="col-md-3 mb-4">
                    <label class="form-label fw-bold">Hari</label>
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

                <div class="col-md-3 mb-4">
                    <label class="form-label fw-bold">Jam Mulai</label>
                    <input type="time" name="jam_mulai" class="form-control" required>
                </div>

                <div class="col-md-3 mb-4">
                    <label class="form-label fw-bold">Jam Selesai</label>
                    <input type="time" name="jam_selesai" class="form-control" required>
                </div>

                <div class="col-md-3 mb-4">
                    <label class="form-label fw-bold">Ruangan (Opsional)</label>
                    <input type="text" name="ruangan" class="form-control" placeholder="Misal: Kelas A">
                </div>
            </div>

            <div class="d-flex justify-content-end pt-2">
                <button type="submit" class="btn btn-success px-4">
                    <i class="fa fa-calendar-plus me-2"></i> Tambah Jadwal
                </button>
            </div>
        </form>
    </div>
</div>

@endsection