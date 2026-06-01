<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siswa - LPK Phitagoras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background: #f4f7fc; font-family: Poppins; }
        .sidebar { width: 250px; height: 100vh; background: #111827; position: fixed; left: 0; top: 0; padding-top: 30px; }
        .sidebar h2 { color: white; text-align: center; margin-bottom: 40px; font-size: 24px;}
        .sidebar a { display: block; color: white; padding: 15px 30px; text-decoration: none; transition: 0.3s; }
        .sidebar a:hover { background: #1f2937; padding-left: 40px; }
        .main-content { margin-left: 250px; padding: 30px; }
        .top-banner { background: linear-gradient(to right, #4f46e5, #7c3aed); color: white; padding: 40px; border-radius: 20px; }
        .class-card { border: none; border-radius: 20px; overflow: hidden; transition: 0.3s; }
        .class-card:hover { transform: translateY(-10px); }
        .class-image { height: 200px; object-fit: cover; width: 100%; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>LPK Phitagoras</h2>

    <a href="/dashboard">
        <i class="fa fa-home me-2"></i> Dashboard
    </a>
    <a href="/kelas">
        <i class="fa fa-book me-2"></i> Kelas
    </a>
    <a href="/profile">
        <i class="fa fa-user me-2"></i> Profile
    </a>
    
    <form action="/logout" method="POST">
        @csrf
        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
            <i class="fa fa-sign-out-alt me-2"></i> Logout
        </a>
    </form>
</div> <div class="main-content">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>