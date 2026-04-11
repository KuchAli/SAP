<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Aplikasi Peminjaman Alat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background:#0d0b0b;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .register-card {
            background: white;
            border-radius: 15px;
            box-shadow: 50px 70px 50px rgba(0,0,0,0.1);
        }
        .logo {
            font-size: 2.5rem;
            font-weight: bold;
            background: linear-gradient(135deg, #0d0b0b 0%, #135ba9 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        /* Style untuk password toggle */
        .password-wrapper {
            position: relative;
        }
        
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 0;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .password-toggle:hover {
            color: #495057;
        }
        
        .password-toggle:focus {
            outline: none;
            box-shadow: none;
        }
        
        /* Padding untuk input password */
        .password-field {
            padding-right: 40px;
        }
        
        /* Password strength indicator */
        .password-strength {
            height: 4px;
            margin-top: 5px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
        
        .strength-weak { background-color: #dc3545; width: 25%; }
        .strength-medium { background-color: #ffc107; width: 50%; }
        .strength-good { background-color: #28a745; width: 75%; }
        .strength-strong { background-color: #20c997; width: 100%; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="register-card p-5">
                    <div class="text-center mb-4">
                        <div class="logo">Aplikasi Perpustakaan</div>
                        <p class="text-muted">Silahkan Daftar</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ old('name') }}" required autofocus>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="{{ old('email') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="password-wrapper">
                                <input type="password" class="form-control password-field" id="password" 
                                       name="password" required minlength="8"
                                       oninput="checkPasswordStrength(this.value)">
                                <button type="button" class="password-toggle" 
                                        onclick="togglePasswordVisibility('password', 'password-icon')">
                                    <i class="bi bi-eye" id="password-icon"></i>
                                </button>
                            </div>
                            <div class="password-strength" id="password-strength"></div>
                            <small class="text-muted">8 Character minim for Password</small>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Password Confirmation</label>
                            <div class="password-wrapper">
                                <input type="password" class="form-control password-field" 
                                       id="password_confirmation" name="password_confirmation" required>
                                <button type="button" class="password-toggle" 
                                        onclick="togglePasswordVisibility('password_confirmation', 'confirm-password-icon')">
                                    <i class="bi bi-eye" id="confirm-password-icon"></i>
                                </button>
                            </div>
                            <div class="mt-2" id="password-match"></div>
                        </div>
                        
                        <button type="submit" class="btn btn-outline-secondary w-100 mb-3">Daftar</button>
                        
                        <div class="text-center">
                            <p class="mb-0">Sudah punya akun? 
                                <a href="{{ route('login') }}" class="text-decoration-none">Login here!</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk toggle visibility password
        function togglePasswordVisibility(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const passwordIcon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('bi-eye');
                passwordIcon.classList.add('bi-eye-slash');
                passwordIcon.setAttribute('title', 'Sembunyikan password');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('bi-eye-slash');
                passwordIcon.classList.add('bi-eye');
                passwordIcon.setAttribute('title', 'Tampilkan password');
            }
            
            // Update tooltip
            const tooltip = bootstrap.Tooltip.getInstance(passwordIcon.parentElement);
            if (tooltip) {
                tooltip.update();
            }
        }
        
        // Fungsi untuk mengecek kekuatan password
        function checkPasswordStrength(password) {
            const strengthBar = document.getElementById('password-strength');
            let strength = 0;
            
            if (password.length >= 8) strength += 1;
            if (/[A-Z]/.test(password)) strength += 1;
            if (/[a-z]/.test(password)) strength += 1;
            if (/[0-9]/.test(password)) strength += 1;
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;
            
            // Update strength bar
            strengthBar.className = 'password-strength';
            
            if (password.length === 0) {
                strengthBar.style.width = '0%';
                strengthBar.style.backgroundColor = 'transparent';
            } else if (strength <= 1) {
                strengthBar.className += ' strength-weak';
            } else if (strength <= 2) {
                strengthBar.className += ' strength-medium';
            } else if (strength <= 3) {
                strengthBar.className += ' strength-good';
            } else {
                strengthBar.className += ' strength-strong';
            }
            
            // Cek kesesuaian password
            checkPasswordMatch();
        }
        
        // Fungsi untuk mengecek kesesuaian password
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const matchDiv = document.getElementById('password-match');
            
            if (confirmPassword.length === 0) {
                matchDiv.innerHTML = '';
                return;
            }
            
            if (password === confirmPassword) {
                matchDiv.innerHTML = '<small class="text-success"><i class="bi bi-check-circle"></i> Password cocok</small>';
            } else {
                matchDiv.innerHTML = '<small class="text-danger"><i class="bi bi-x-circle"></i> Password tidak cocok</small>';
            }
        }
        
        // Inisialisasi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Tambahkan event listener untuk konfirmasi password
            document.getElementById('password_confirmation').addEventListener('input', checkPasswordMatch);
            document.getElementById('password').addEventListener('input', checkPasswordMatch);
            
            // Validasi form sebelum submit
            document.getElementById('registerForm').addEventListener('submit', function(e) {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('password_confirmation').value;
                
                if (password !== confirmPassword) {
                    e.preventDefault();
                    alert('Password dan konfirmasi password tidak cocok!');
                    document.getElementById('password_confirmation').focus();
                }
                
                if (password.length < 8) {
                    e.preventDefault();
                    alert('Password minimal harus 8 karakter!');
                    document.getElementById('password').focus();
                }
            });
        });
    </script>
    
    <!-- Bootstrap JS untuk tooltip -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>