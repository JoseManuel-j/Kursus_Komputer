<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Kursus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{ background: #f4f7fc; }
        .register-box{ background: white; border-radius: 20px; padding: 40px; }
        .payment-box{ background: #f8f9fa; border-radius: 15px; padding: 20px; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="register-box shadow">
        <h1 class="mb-4">Registrasi Kursus</h1>

        @if ($errors->any())
            <div class="alert alert-danger mb-4">
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

            <div class="row">
                <div class="col-md-6">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control mb-3" value="{{ auth()->user()->name }}" readonly>
                </div>
                <div class="col-md-6">
                    <label>Email</label>
                    <input type="email" class="form-control mb-3" value="{{ auth()->user()->email }}" readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label>No HP</label>
                    <input type="text" name="no_hp" class="form-control mb-3" placeholder="08xxxxxxxxxx" required>
                </div>
                <div class="col-md-6">
                    <label>Pilih Kelas</label>
                    <select name="program_id" class="form-control mb-3" required>
                        <option value="" disabled>-- Pilih Kelas --</option>
                        
                        @foreach($semuaProgram as $prog)
                            <option value="{{ $prog->id }}" {{ $prog->id == $programTerpilih ? 'selected' : '' }}>
                                {{ $prog->nama_program }} ({{ ucfirst($prog->tipe_kelas) }}) - Rp {{ number_format($prog->biaya, 0, ',', '.') }}
                            </option>
                        @endforeach

                    </select>
                </div>
            </div>

            <div class="payment-box mt-4">
                <h4 class="mb-3">Metode Pembayaran</h4>
                
                <div class="mb-4">
                    <h5>Transfer Bank</h5>
                    <p class="mb-1">BCA : 1234567890</p>
                    <p>A/N LPK Phitagoras</p>
                </div>

                <div class="mb-4">
                    <h5>QRIS</h5>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/8/80/QR_code_for_mobile_English_Wikipedia.svg" width="200" alt="QRIS">
                </div>

                <div>
                    <label>Upload Bukti Pembayaran (Maks 2MB)</label>
                    <input type="file" name="bukti_bayar" class="form-control" accept="image/*" required>
                </div>
            </div>

            <div class="d-flex gap-3 mt-4">
                <a href="/kelas" class="btn btn-secondary btn-lg w-25">Batal</a>
                <button type="submit" class="btn btn-primary btn-lg w-75">Daftar & Konfirmasi Pembayaran</button>
            </div>
        </form>

    </div>
</div>

</body>
</html>