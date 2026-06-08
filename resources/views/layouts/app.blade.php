<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siswa - LPK Phitagoras</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { background: #f4f7fc; font-family: 'Poppins', sans-serif; }
        
        /* Desain Sidebar Kiri */
        .sidebar { 
            width: 260px; height: 100vh; background: #111827; position: fixed; left: 0; top: 0; padding: 30px 15px; 
            display: flex; flex-direction: column; box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar h2 { color: white; text-align: center; margin-bottom: 40px; font-size: 22px; font-weight: 700; letter-spacing: 1px; }
        
        .sidebar a { 
            display: flex; align-items: center; color: #9ca3af; padding: 12px 20px; text-decoration: none; 
            border-radius: 8px; margin-bottom: 10px; font-weight: 500; transition: all 0.3s ease; 
        }
        .sidebar a i { width: 25px; font-size: 18px; }
        .sidebar a:hover { background: rgba(255, 255, 255, 0.05); color: #ffffff; transform: translateX(5px); }
        .sidebar a.active { background: #7c3aed; color: white; }
        
        .main-content { margin-left: 260px; padding: 40px; min-height: 100vh; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>LPK Phitagoras</h2>

    <div class="nav-menus">
        <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="fa fa-home me-2"></i> Dashboard
        </a>
        <a href="/kelas" class="{{ request()->is('kelas') ? 'active' : '' }}">
            <i class="fa fa-book me-2"></i> Kelas
        </a>
        <a href="/profile" class="{{ request()->is('profile') ? 'active' : '' }}">
            <i class="fa fa-user me-2"></i> Profile
        </a>
    </div>
    
    <div class="mt-auto">
        <hr style="border-color: rgba(255,255,255,0.1); margin-bottom: 15px;">
        <form action="/logout" method="POST" class="m-0">
            @csrf
            <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="text-danger">
                <i class="fa fa-sign-out-alt me-2"></i> Logout
            </a>
        </form>
    </div>
</div> 

<div class="main-content">
    @yield('content')
</div>

<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1050; margin-top: 60px;">
    @if(session('success'))
    <div class="toast show align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"><i class="fa fa-check-circle me-2"></i> {{ session('success') }}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Auto-hide toast setelah 4 detik
    var toastElList = [].slice.call(document.querySelectorAll('.toast'));
    var toastList = toastElList.map(function (toastEl) {
        return new bootstrap.Toast(toastEl, { delay: 4000 });
    });
    toastList.forEach(toast => toast.show());
</script>

</body>
</html>