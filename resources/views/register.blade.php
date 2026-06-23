<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembuatan Akun - Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #ffffff;
            font-family: sans-serif;
            min-height: 100vh; /* Diubah agar halaman bisa di-scroll jika layar kecil */
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 40px 15px; /* Tambahan padding atas bawah */
            position: relative; 
        }

        .custom-card {
            border: 1px solid #dcdcdc;
            border-radius: 15px;
            overflow: hidden;
            width: 100%;
            max-width: 600px; /* Diperlebar agar muat 2 kolom */
        }

        .custom-card-header {
            background-color: #9d5bfe; 
            color: #000;
            text-align: center;
            padding: 20px;
            font-weight: 500;
            font-size: 22px;
            letter-spacing: 0.5px;
        }

        .custom-card-body {
            padding: 30px;
            background-color: #fff;
        }

        .custom-label {
            font-family: "Times New Roman", Times, serif;
            font-size: 14px;
            margin-bottom: 5px;
            color: #000;
            display: block;
            font-weight: bold;
        }

        .custom-input {
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .custom-btn {
            background-color: #00bfff; 
            color: #000;
            font-family: "Times New Roman", Times, serif;
            font-size: 20px;
            border: none;
            border-radius: 8px;
            padding: 10px 40px;
            width: 100%; 
        }

        .custom-btn:hover {
            background-color: #009ee6;
        }
    </style>
</head>
<body>

    <a href="javascript:history.back()" class="btn btn-outline-dark position-fixed top-0 start-0 m-4" style="border-radius: 8px; z-index: 999;">
        &larr; Back
    </a>

    <div class="custom-card shadow-sm">
        
        <div class="custom-card-header">
            BUAT AKUN BARU
        </div>
        
        <div class="custom-card-body">
            
            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            <form action="/register" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <label class="custom-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control custom-input" required minlength="3" placeholder="Budi Santoso">
                    </div>
                    <div class="col-md-6">
                        <label class="custom-label">Email</label>
                        <input type="email" name="email" class="form-control custom-input" required placeholder="nama@gmail.com">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="custom-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control custom-input" required placeholder="Contoh: Tangerang">
                    </div>
                    <div class="col-md-6">
                        <label class="custom-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control custom-input" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="custom-label">Agama</label>
                        <select name="agama" class="form-select custom-input" required>
                            <option value="" disabled selected>-- Pilih Agama --</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen Protestan">Kristen Protestan</option>
                            <option value="Kristen Katolik">Kristen Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="custom-label">Nomor HP</label>
                        <input type="tel" name="phone" class="form-control custom-input" required minlength="10" maxlength="13" placeholder="081234567890">
                    </div>
                </div>

                <div>
                    <label class="custom-label">Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control custom-input" rows="2" required placeholder="Jalan, RT/RW, Kelurahan, Kecamatan..."></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="custom-label">Password</label>
                        <input type="password" name="password" class="form-control custom-input" required minlength="8" placeholder="Masukkan password">
                    </div>
                    <div class="col-md-6">
                        <label class="custom-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control custom-input" required minlength="8" placeholder="Ulangi password">
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn custom-btn shadow-sm">
                        Register
                    </button>
                </div>

            </form>
        </div>
    </div>

</body>
</html>