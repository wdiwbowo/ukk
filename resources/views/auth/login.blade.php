<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Kasir App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: linear-gradient(135deg, #003366, #0056b3);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden; /* Hindari scroll saat SweetAlert muncul */
        }
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            min-width: 450px;
            position: absolute;
            top: 50%;
            transform: translateY(-50%); /* Pastikan tetap di tengah */
        }
        .btn-primary {
            background: #0056b3;
            border: none;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background: #00408a;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h3 class="text-center mb-4">Login</h3>

        <!-- Jika Login Gagal -->
        @if (session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'error',
                text: '{{ session("error") }}',
                backdrop: false // Menonaktifkan efek blur pada latar belakang
            });
        });
    </script>
@endif

@if (session('success') && !session('logout'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'success',
                text: '{{ session("success") }}',
                backdrop: false // Menonaktifkan efek blur pada latar belakang
            });
        });
    </script>
@endif

@if (session('logout'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'success',
                text: '{{ session("logout") }}',
                backdrop: false // Menonaktifkan efek blur pada latar belakang
            }).then(() => {
                window.location.href = "{{ route('login') }}";
            });
        });
    </script>
@endif



        <form method="POST" action="{{ route('login') }}">
            @csrf  
            
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" required value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Login
            </button>
        </form>
    </div>
</body>
</html>
