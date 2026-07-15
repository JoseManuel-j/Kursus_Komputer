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
        .summary-box { background: #eef2ff; border: 1px dashed #4f46e5; border-radius: 12px; padding: 15px; }
        /* Menghilangkan panah spinner pada input number */
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
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
                <!-- Ditambahkan id="program_select" untuk kebutuhan manipulasi Javascript -->
                <select name="program_id" id="program_select" class="form-select" required>
                    <option value="" disabled {{ is_null($programTerpilih) ? 'selected' : '' }}>-- Pilih Program Kursus --</option>
                    @foreach($semuaProgram as $prog)
                        <option value="{{ $prog->id }}" data-biaya="{{ $prog->biaya }}" {{ $prog->id == $programTerpilih ? 'selected' : '' }}>
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

            <!-- REVISI: MENAMBAHKAN RINCIAN RINGKASAN BIAYA (HARGA KELAS + PENDAFTARAN) -->
            <div class="section-title">C. Opsi Pembayaran</div>

            <div class="mb-4">
                <label class="form-label fw-bold">Pilih Metode Pembayaran</label>
                <select name="tipe_pembayaran" id="tipe_pembayaran" class="form-select" onchange="toggleCicilan()" required>
                    <option value="lunas">Bayar Lunas</option>
                    <option value="angsuran">Cicilan (Maksimal 3x)</option>
                </select>
            </div>

            <!-- Form 3 Input Cicilan -->
            <div id="form_cicilan" class="mb-4 p-3 border rounded" style="display:none; background-color: #f8f9fa;">
                <label class="form-label fw-bold">Masukkan Nominal Cicilan (Tiap Termin):</label>
                <div class="row">
                    @for($i=1; $i<=3; $i++)
                        <div class="col-md-4 mb-2">
                            <input type="text" name="cicilan[]" class="form-control" placeholder="Angsuran {{ $i }} (Contoh: 1.000.000)" onkeyup="formatRupiah(this)">
                        </div>
                    @endfor
                </div>
                <small class="text-muted">*Masukkan angka tanpa titik, sistem akan memformat otomatis.</small>
            </div>

            <!-- SCRIPT PENGATURAN -->
            <script>
                function toggleCicilan() {
                    let tipe = document.getElementById('tipe_pembayaran').value;
                    document.getElementById('form_cicilan').style.display = (tipe == 'angsuran') ? 'block' : 'none';
                }

                // Fungsi format rupiah 1.000.000
                function formatRupiah(input) {
                    let angka = input.value.replace(/\D/g, ''); // Hapus semua selain angka
                    input.value = angka.replace(/\B(?=(\d{3})+(?!\d))/g, "."); // Tambahkan titik
                }
            </script>

            <!--C. Rincian & Metode Pembayaran Anda yang lama -->
            <div class="section-title">C. Rincian & Metode Pembayaran</div>

            <div class="payment-box">
                <div class="summary-box mb-4">
                    <h6 class="fw-bold text-indigo mb-3" style="color: #4f46e5;">Rincian Biaya Kursus</h6>
                    <div class="d-flex justify-content-between mb-2 fs-6">
                        <span class="text-muted">Biaya Program Kelas:</span>
                        <span id="text_biaya_kelas" class="fw-medium">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 fs-6">
                        <span class="text-muted">Biaya Pendaftaran (Wajib):</span>
                        <span class="fw-medium text-success">+ Rp 100.000</span>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Total yang Harus Ditransfer:</span>
                        <span id="text_total_bayar" class="fw-bold fs-5 text-primary">Rp 100.000</span>
                    </div>
                </div>

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
                    <label class="form-label fw-bold">Upload Bukti Pembayaran (JPG/PNG/PDF, Maks 2MB)</label>
                    <input type="file" name="bukti_bayar" class="form-control" accept="image/jpeg,image/png,application/pdf" required>
                    <small class="text-muted">Pastikan bukti transfer senilai dengan jumlah <strong>Total yang Harus Ditransfer</strong> di atas.</small>
                </div>
            </div>

            <div class="d-flex gap-3 mt-5">
                <a href="/kelas" class="btn btn-outline-secondary btn-lg w-25 fw-bold">Batal</a>
                <button type="submit" class="btn btn-primary btn-lg w-75 fw-bold shadow-sm">Daftar & Konfirmasi Pembayaran</button>
            </div>

            <!-- KOTAK INFORMASI ANGSURAN -->
            <div class="alert border-0 shadow-sm d-flex align-items-center mb-4" style="border-radius: 15px; background-color: #eef2ff; color: #4338ca;">
                <i class="fa fa-info-circle fa-2x me-3"></i>
                <div>
                    <strong class="fw-bold text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.5px;">Informasi Pembayaran</strong><br>
                    <span class="fs-6">Biaya program kursus ini dapat dibayar secara penuh atau diangsur <strong>maksimal 3 kali pembayaran (3 termin)</strong>.</span>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- JAVASCRIPT HINGGA AKHIR FILE UNTUK LOGIKA HITUNG OTOMATIS -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const selectProgram = document.getElementById("program_select");
        const textBiayaKelas = document.getElementById("text_biaya_kelas");
        const textTotalBayar = document.getElementById("text_total_bayar");
        const biayaPendaftaran = 100000;

        function hitungTotal() {
            const selectedOption = selectProgram.options[selectProgram.selectedIndex];

            if (selectedOption && selectedOption.value !== "") {
                const biayaKelas = parseInt(selectedOption.getAttribute("data-biaya")) || 0;
                const totalBayar = biayaKelas + biayaPendaftaran;

                // Format ke Rupiah string
                textBiayaKelas.innerText = "Rp " + biayaKelas.toLocaleString("id-ID");
                textTotalBayar.innerText = "Rp " + totalBayar.toLocaleString("id-ID");
            } else {
                textBiayaKelas.innerText = "Rp 0";
                textTotalBayar.innerText = "Rp " + biayaPendaftaran.toLocaleString("id-ID");
            }
        }

        // Jalankan fungsi saat halaman pertama kali dimuat (jika sudah ada program terpilih)
        hitungTotal();

        // Jalankan fungsi setiap kali pilihan kelas dirubah
        selectProgram.addEventListener("change", hitungTotal);
    });
</script>

</body>
</html>