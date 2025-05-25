<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>E-Clinic | dr. Rusdiani</title>

    <link rel="shortcut icon" href="/assets/gambar/logo.png" type="image/x-icon" />

    <link rel="stylesheet" href="/assets/compiled/css/app.css" />
    <link rel="stylesheet" href="/assets/compiled/css/app-dark.css" />

    {{-- SWEET ALERT --}}
    <link rel="stylesheet" href="assets/extensions/sweetalert2/sweetalert2.min.css">
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="{{ route('index') }}"><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="{{ route('index') }}">
                <img src="/assets/gambar/logo.png" />
            </a>
        </div>
    </nav>

    <div class="container">
        <h1>Ini Halaman Profile</h1>
    </div>

    <script src="assets/compiled/js/app.js"></script>
</body>

</html>
