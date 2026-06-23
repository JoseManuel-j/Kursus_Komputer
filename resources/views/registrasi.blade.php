<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Kursus - LPK Phitagoras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f7fc; }
        .register-box { background: white; border-radius: 20px; padding: 40px; }
        .payment-box { background: #f8f9fa; border-radius: 15px; padding: 20px; border: 1px solid #e9ecef; }
        .section-title { font-weight: 600; font-size: 18px; margin-bottom: 15px; border-bottom: 2px solid #f0f0f0; padding-bottom: 8px; margin-top: 20px; }
        .form-label { font-weight: 500; font-size: 14px; color: #444; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="register-box shadow mx-auto" style="max-width: 800px;">
        <h2 class="mb-4 text-center fw-bold">Formulir Registrasi Kursus</h2>

        @if ($errors->any())
            <div class="alert alert-danger mb-4 rounded-3">
                <strong>Waduh, gagal daftar nih!</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/pendaftaran" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="section-title">A. Data Diri Calon Siswa</div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly style="background-color: #e9ecef;">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly style="background-color: #e9ecef;">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" placeholder="Contoh: Tangerang" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Agama</label>
                    <select name="agama" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Agama --</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen Protestan">Kristen Protestan</option>
                        <option value="Kristen Katolik">Kristen Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Konghucu">Konghucu</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nomor Telp / HP</label>
                    <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat Lengkap</label>
                <textarea name="alamat" class="form-control" rows="3" placeholder="Nama Jalan, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten" required></textarea>
            </div>

            <div class="section-title">B. Program Kursus & Dokumen</div>

            <div class="mb-4">
                <label class="form-label">Pilih Kelas</label>
                <select name="program_id" class="form-select" required>
                    <option value="" disabled>-- Pilih Program Kursus --</option>
                    @foreach($semuaProgram as $prog)
                        <option value="{{ $prog->id }}" {{ $prog->id == $programTerpilih ? 'selected' : '' }}>
                            {{ $prog->nama_program }} ({{ ucfirst($prog->tipe_kelas) }}) - Rp {{ number_format($prog->biaya, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">File Ijazah Terakhir</label>
                    <input type="file" name="file_ijazah" class="form-control" accept=".pdf, image/*" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">FC KTP</label>
                    <input type="file" name="file_ktp" class="form-control" accept=".pdf, image/*" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Pas Foto 3x4</label>
                    <input type="file" name="pas_foto" class="form-control" accept="image/*" required>
                </div>
            </div>

            <div class="section-title">C. Metode Pembayaran</div>

            <div class="payment-box">
                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0 border-end">
                        <h5 class="fw-bold mb-3">Transfer Bank</h5>
                        <p class="mb-1 text-muted">Bank BCA</p>
                        <p class="mb-1 fw-bold fs-5">1234 5678 90</p>
                        <p class="mb-0">A/N LPK Phitagoras</p>
                    </div>
                <div class="col-md-6 text-center">
                    <h5 class="fw-bold mb-3">QRIS</h5>
                    <img src="{{ asset('images/qris-phitagoras.jpeg') }}" width="200" alt="QRIS LPK Phitagoras" class="border p-1 rounded bg-white shadow-sm">
                </div>
                
                </div>

                <hr>

                <div class="mt-3">
                    <label class="form-label fw-bold">Upload Bukti Pembayaran (Maks 2MB)</label>
                    <input type="file" name="bukti_pembayaran" class="form-control" accept="image/*, .pdf" required>
                    <small class="text-muted">Pastikan bukti transfer terlihat jelas.</small>
                </div>
            </div>

            <div class="d-flex gap-3 mt-5">
                <a href="/kelas" class="btn btn-outline-secondary btn-lg w-25 fw-bold">Batal</a>
                <button type="submit" class="btn btn-primary btn-lg w-75 fw-bold shadow-sm">Daftar & Konfirmasi Pembayaran</button>
            </div>
        </form>

    </div>
</div>

</body>
</html>