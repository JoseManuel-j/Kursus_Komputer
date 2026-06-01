<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Instruktur - LPK Phitagoras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark mb-0">Dashboard Instruktur</h2>
        <form action="/logout" method="POST" class="m-0">
            @csrf
            <button type="submit" class="btn btn-outline-danger">Logout</button>
        </form>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-body p-4">
            <h4 class="mb-1">Selamat Datang, {{ auth()->user()->name }}!</h4>
            <p class="text-muted mb-4">Berikut adalah jadwal mengajar Anda di LPK Phitagoras.</p>
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>No</th>
                            <th>Program Kelas</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Ruangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwals as $index => $jadwal)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td><strong>{{ $jadwal->nama_program }}</strong></td>
                                <td class="text-center">{{ $jadwal->hari }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }} WIB</td>
                                <td class="text-center"><span class="badge bg-secondary">{{ $jadwal->ruangan }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i>Anda belum memiliki jadwal mengajar saat ini.</i>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

</body>
</html>