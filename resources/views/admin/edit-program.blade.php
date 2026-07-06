@extends('admin.layouts.app_admin')

@section('title', 'Edit Program Kursus')

@section('page_title', 'Edit Program Kursus')

@section('page_desc', 'Perbarui informasi program kelas di LPK Phitagoras.')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">

        <strong>Data belum berhasil diperbarui.</strong>

        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
        ></button>

    </div>
@endif

<div
    class="card border-0 shadow-sm"
    style="border-radius: 20px;"
>
    <div class="card-body p-4">

        <form
            action="{{ route('admin.program.update', $program->id) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="form-label fw-bold">
                    Nama Program
                </label>

                <input
                    type="text"
                    name="nama_program"
                    class="form-control"
                    value="{{ old('nama_program', $program->nama_program) }}"
                    required
                >
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">
                    Tipe Kelas
                </label>

                <select
                    name="tipe_kelas"
                    class="form-select"
                    required
                >
                    <option
                        value="reguler"
                        {{ old('tipe_kelas', $program->tipe_kelas) == 'reguler' ? 'selected' : '' }}
                    >
                        Reguler
                    </option>

                    <option
                        value="intensif"
                        {{ old('tipe_kelas', $program->tipe_kelas) == 'intensif' ? 'selected' : '' }}
                    >
                        Intensif
                    </option>

                    <option
                        value="private"
                        {{ old('tipe_kelas', $program->tipe_kelas) == 'private' ? 'selected' : '' }}
                    >
                        Private
                    </option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">
                    Deskripsi
                </label>

                <textarea
                    name="deskripsi"
                    class="form-control"
                    rows="5"
                    required
                >{{ old('deskripsi', $program->deskripsi) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">
                    Jumlah Sesi
                </label>

                <input
                    type="number"
                    name="jumlah_sesi"
                    class="form-control"
                    value="{{ old('jumlah_sesi', $program->jumlah_sesi) }}"
                    min="1"
                    required
                >
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">
                    Biaya Program
                </label>

                <div class="input-group">

                    <span class="input-group-text">
                        Rp
                    </span>

                    <input
                        type="number"
                        name="biaya"
                        class="form-control"
                        value="{{ old('biaya', $program->biaya) }}"
                        min="0"
                        required
                    >

                </div>
            </div>

            <div class="d-flex justify-content-end gap-3 pt-3">

                <a
                    href="{{ route('admin.program') }}"
                    class="btn btn-light border px-4"
                >
                    <i class="fa fa-arrow-left me-2"></i>
                    Batal
                </a>

                <button
                    type="submit"
                    class="btn btn-warning px-4"
                >
                    <i class="fa fa-save me-2"></i>
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>
</div>

@endsection