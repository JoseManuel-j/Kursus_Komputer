<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembuatan Akun - Registrasi</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menambahkan Font Poppins agar konsisten dengan Dashboard -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body {
            background-color: #f4f7fc; /* Warna background disamakan dengan dashboard */
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 40px 15px;
            position: relative; 
        }

        .custom-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            width: 100%;
            max-width: 650px;
            background: #fff;
        }

        .custom-card-header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed); /* Tema warna LPK Phitagoras */
            color: #fff;
            text-align: center;
            padding: 25px;
            font-weight: 700;
            font-size: 24px;
            letter-spacing: 0.5px;
        }

        .custom-card-body {
            padding: 40px;
        }

        .custom-label {
            font-size: 13px;
            margin-bottom: 8px;
            color: #6c757d;
            display: block;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .custom-input {
            margin-bottom: 20px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            padding: 12px 15px;
            font-size: 14px;
            background-color: #f8fafc;
            transition: all 0.3s;
        }

        .custom-input:focus {
            border-color: #7c3aed;
            box-shadow: 0 0 0 0.25rem rgba(124, 58, 237, 0.25);
            background-color: #fff;
        }

        .custom-btn {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff;
            font-weight: 600;
            font-size: 16px;
            border: none;
            border-radius: 10px;
            padding: 12px 40px;
            width: 100%; 
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .custom-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(124, 58, 237, 0.4);
            color: #fff;
        }
    </style>
</head>
<body>

    <a href="javascript:history.back()" class="btn btn-white shadow-sm position-fixed top-0 start-0 m-4 fw-medium" style="border-radius: 10px; z-index: 999; background: white; color: #4f46e5;">
        <i class="fa fa-arrow-left me-2"></i> Kembali
    </a>

    <div class="custom-card shadow-lg">
        
        <div class="custom-card-header">
            <i class="fa fa-user-plus mb-2 d-block fa-2x"></i>
            Buat Akun Baru
        </div>
        
        <div class="custom-card-body">
            
            <!-- ALERT JIKA REGISTRASI SUKSES -->
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center" style="border-radius: 10px;">
                    <i class="fa fa-check-circle fa-lg me-2"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            <!-- PANTAUAN ERROR VALIDASI -->
            @if($errors->any())
                <div class="alert alert-danger" style="border-radius: 10px;">
                    <div class="fw-bold mb-1"><i class="fa fa-exclamation-triangle me-2"></i>Terdapat kesalahan:</div>
                    <ul class="mb-0 small">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/register" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <label class="custom-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control custom-input" value="{{ old('name') }}" required minlength="3" placeholder="Contoh: Budi Santoso">
                    </div>
                    <div class="col-md-6">
                        <label class="custom-label">Email</label>
                        <input type="email" name="email" class="form-control custom-input" value="{{ old('email') }}" required placeholder="nama@gmail.com">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="custom-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control custom-input" value="{{ old('tempat_lahir') }}" required placeholder="Contoh: Tangerang">
                    </div>
                    <div class="col-md-6">
                        <label class="custom-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control custom-input" value="{{ old('tanggal_lahir') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="custom-label">Agama</label>
                        <select name="agama" class="form-select custom-input" required>
                            <option value="" disabled selected>-- Pilih Agama --</option>
                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen Protestan" {{ old('agama') == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                            <option value="Kristen Katolik" {{ old('agama') == 'Kristen Katolik' ? 'selected' : '' }}>Kristen Katolik</option>
                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="custom-label">Nomor HP</label>
                        <input type="tel" name="nomor_hp" class="form-control custom-input" value="{{ old('nomor_hp') }}" required minlength="10" maxlength="13" placeholder="081234567890">
                    </div>
                </div>

                <div>
                    <label class="custom-label">Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control custom-input" rows="2" required placeholder="Jalan, RT/RW, Kelurahan, Kecamatan...">{{ old('alamat') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="custom-label">Password</label>
                        <input type="password" name="password" class="form-control custom-input" required minlength="8" placeholder="Minimal 8 karakter">
                    </div>
                    <div class="col-md-6">
                        <label class="custom-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control custom-input" required minlength="8" placeholder="Ulangi password">
                    </div>
                </div>
                
                <div class="mt-2">
                    <button type="submit" class="btn custom-btn">
                        Daftar Sekarang <i class="fa fa-arrow-right ms-2"></i>
                    </button>
                </div>
                
                <div class="text-center mt-4">
                    <span class="text-muted small">Sudah punya akun? <a href="/login" class="fw-bold text-decoration-none" style="color: #4f46e5;">Login di sini</a></span>
                </div>

            </form>
        </div>
    </div>

</body>
</html>