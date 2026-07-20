@extends('admin.layouts.app_admin')

@section('title', 'Momen & Aktivitas')
@section('page_title', 'Momen & Aktivitas')
@section('page_desc', 'Kelola foto dokumentasi dan aktivitas LPK Phitagoras')

@section('content')
<div class="row">
    <!-- Kolom Kiri: Form Upload Foto -->
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4"><i class="fa fa-cloud-upload-alt me-2 text-primary"></i>Upload Foto Baru</h5>
                
                <form action="{{ route('admin.foto.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Foto <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control" placeholder="Contoh: Pelatihan Komputer Dasar" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keterangan (Opsional)</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Deskripsi singkat kegiatan..."></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Pilih File Foto <span class="text-danger">*</span></label>
                        <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/jpg" required>
                        <small class="text-muted">Format: JPG, JPEG, PNG. Maks: 5MB.</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">
                        <i class="fa fa-save me-2"></i> Simpan Foto
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Daftar Foto -->
    <div class="col-md-8">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
                <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4"><i class="fa fa-images me-2 text-primary"></i>Daftar Foto Kegiatan</h5>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Preview Foto</th>
                                <th>Judul & Keterangan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($fotos as $foto)
                            <tr>
                                <td style="width: 150px;">
                                    <!-- JALUR FOTO UDAH DITEMBAK KE IMAGES/KEGIATAN -->
                                    <img src="{{asset('Images/kegiatan/' . $foto->nama_file) }}" alt="{{ $foto->judul }}" class="img-fluid rounded-3 shadow-sm" style="max-height: 100px; object-fit: cover;">
                                </td>
                                <td>
                                    <h6 class="fw-bold mb-1">{{ $foto->judul }}</h6>
                                    <p class="text-muted small mb-0">{{ $foto->keterangan ?? 'Tidak ada keterangan' }}</p>
                                </td>
                                <td class="text-center" style="width: 100px;">
                                    <form action="{{ route('admin.foto.destroy', $foto->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill" onclick="return confirm('Yakin mau hapus foto ini? Nggak bisa di-undo lho.')">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">
                                    <i class="fa fa-folder-open fs-1 mb-2 text-light"></i><br>
                                    Belum ada foto yang diupload.
                                </td>
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