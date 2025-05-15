<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="login/style.css">

    <link rel="shortcut icon" href="./assets/gambar/logo.png" type="image/x-icon" />

    <title>E-Clinic | Dokter Rusdiani</title>
    {{-- <style>
            * {
                border: 1px solid red;
            }
        </style> --}}
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-in">
            <form action="#" method="post">
                @csrf
                <h1>Log in</h1>
                @error('username')
                    <div style="color: red">
                        {{ $message }}
                    </div>
                @enderror
                <input type="username" placeholder="Username" name="username" value="{{ old('username') }}" required>
                <input type="password" class="form-control @error('password') is-invalid @enderror""
                    placeholder="Password" name="password" value="{{ old('password') }}" required>
                <button>Log in</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-right">
                    <img src="./assets/gambar/logo.png" width="100" height="100" alt="Logo"
                        style="position: absolute; margin-bottom: 200px; border-radius: 10px">
                    <h2>E-Clinic | Dokter Rusdiani</h2>
                    <p>Sistem Informasi Klinik - Dokter L</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
