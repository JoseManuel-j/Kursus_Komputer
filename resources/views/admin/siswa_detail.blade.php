@extends('admin.layouts.app_admin')

@section('content')
<div class="container pt-2 pb-4">
    <div class="mb-4" style="margin-top:-100px;">
        <a href="/admin/siswa" class="btn btn-outline-secondary shadow-sm rounded-pill px-4">
            <i class="fa fa-arrow-left me-2"></i> Kembali ke Data Siswa
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                
                <div class="card-header border-0 text-white p-5" style="background: linear-gradient(135deg, #4f46e5, #7c3aed);">
                    <h2 class="fw-bold mb-0">Detail Profil Siswa</h2>
                    <p class="mb-0 opacity-75">Data lengkap akun dan pendaftaran kursus.</p>
                </div>
                
                <div class="card-body p-5 position-relative">
                    
                    <div class="position-absolute" style="top: -50px; left: 40px;">
                        @php
                            $avatarUrl = (!empty($pendaftaran->pas_foto ?? null)) 
                                ? asset('uploads/dokumen_siswa/' . $pendaftaran->pas_foto) 
                                : 'https://ui-avatars.com/api/?name=' . urlencode($siswa->name) . '&background=ffffff&color=4f46e5&size=100&bold=true';
                        @endphp
                        
                        <img src="{{ $avatarUrl }}" 
                             alt="Avatar {{ $siswa->name }}" 
                             class="rounded-circle shadow-sm border border-4 border-white"
                             style="width: 100px; height: 100px; object-fit: cover; background-color: #fff;">
                    </div>

                    <div style="margin-top: 60px;"></div>

                    <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                        <h5 class="fw-bold mb-0" style="color: #4f46e5;"><i class="fa fa-id-card me-2"></i>Informasi Pribadi</h5>
                        <button type="button" class="btn btn-sm btn-outline-primary fw-bold rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalEditSiswa">
                            <i class="fa fa-edit me-1"></i> Edit Data Siswa
                        </button>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Nama Lengkap</label>
                            <p class="fs-5 fw-semibold text-dark mb-0">{{ $siswa->name }}</p>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Email Address</label>
                            <p class="fs-5 fw-semibold text-dark mb-0">{{ $siswa->email }}</p>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Nomor HP</label>
                            <p class="fs-5 fw-semibold text-dark mb-0">{{ $siswa->nomor_hp ?? 'Belum ada nomor HP' }}</p>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Tempat, Tanggal Lahir</label>
                            <p class="fs-5 fw-semibold text-dark mb-0">
                                {{ $siswa->tempat_lahir ?? '-' }}, 
                                {{ ($siswa->tanggal_lahir ?? null) ? date('d F Y', strtotime($siswa->tanggal_lahir)) : '-' }}
                            </p>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Agama</label>
                            <p class="fs-5 fw-semibold text-dark mb-0">{{ $siswa->agama ?? '-' }}</p>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="text-muted small fw-bold text-uppercase mb-1">Alamat Lengkap</label>
                            <p class="fs-5 fw-semibold text-dark mb-0">{{ $siswa->alamat ?? 'Belum ada data alamat.' }}</p>
                        </div>
                    </div>

                    <hr class="my-4 text-muted opacity-25">

                    <h5 class="fw-bold mb-4" style="color: #4f46e5;"><i class="fa fa-graduation-cap me-2"></i>Status Pendaftaran & Dokumen</h5>
                    
                    @if($pendaftaran)
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="text-muted small fw-bold text-uppercase mb-1">Program Kursus</label>
                                <p class="fs-5 fw-semibold text-dark mb-0">{{ $pendaftaran->nama_program }}</p>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="text-muted small fw-bold text-uppercase mb-1">Tanggal Daftar</label>
                                <p class="fs-5 fw-semibold text-dark mb-0">{{ date('d F Y', strtotime($pendaftaran->tanggal_daftar)) }}</p>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="text-muted small fw-bold text-uppercase mb-1">Status Kursus</label>
                                <div>
                                    <span class="badge rounded-pill bg-success px-3 py-2 text-uppercase fw-bold shadow-sm">
                                        <i class="fa fa-check-circle me-1"></i> {{ $pendaftaran->status }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="text-muted small fw-bold text-uppercase mb-1">Berkas Lampiran</label>
                                <div class="d-flex gap-2 mt-1">
                                    @if(!empty($pendaftaran->file_ktp ?? null))
                                        <a href="{{ asset('uploads/dokumen_siswa/' . $pendaftaran->file_ktp) }}" target="_blank" class="btn btn-sm btn-outline-primary fw-bold">
                                            <i class="fa fa-file-pdf me-1"></i> KTP
                                        </a>
                                    @endif
                                    
                                    @if(!empty($pendaftaran->file_ijazah ?? null))
                                        <a href="{{ asset('uploads/dokumen_siswa/' . $pendaftaran->file_ijazah) }}" target="_blank" class="btn btn-sm btn-outline-primary fw-bold">
                                            <i class="fa fa-file-pdf me-1"></i> Ijazah
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning border-0 shadow-sm rounded-3">
                            <i class="fa fa-exclamation-triangle me-2"></i> Siswa ini belum mendaftar program kursus apapun.
                        </div>
                    @endif

                </div>
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditSiswa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #4f46e5, #7c3aed); border-radius: 15px 15px 0 0;">
                <h5 class="modal-title fw-bold"><i class="fa fa-user-edit me-2"></i>Edit Data Siswa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="/admin/siswa/{{ $siswa->id }}/update" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ $siswa->name }}">
                        </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-muted small text-uppercase">Nomor HP</label>
                        <input type="text" name="nomor_hp" class="form-control" value="{{ $siswa->nomor_hp }}">
                    </div>

                    </div>  

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" value="{{ $siswa->tempat_lahir }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ $siswa->tanggal_lahir }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Agama</label>
                            <select name="agama" class="form-select">
                                <option value="Islam" {{ $siswa->agama == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen Protestan" {{ $siswa->agama == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                                <option value="Kristen Katolik" {{ $siswa->agama == 'Kristen Katolik' ? 'selected' : '' }}>Kristen Katolik</option>
                                <option value="Hindu" {{ $siswa->agama == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ $siswa->agama == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ $siswa->agama == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small text-uppercase">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="3">{{ $siswa->alamat }}</textarea>
                    </div>
                </div>
                
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm" style="background: linear-gradient(135deg, #4f46e5, #7c3aed); border: none;">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection