<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>E-Clinic | dr. Rusdiani</title>

    <link rel="shortcut icon" href="/assets/gambar/logo.png" type="image/x-icon" />

    {{-- FONT AWESOME ICON --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- SELECT2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- DATA TABLE --}}
    <link rel="stylesheet" href="/assets/compiled/css/table-datatable-jquery.css">
    <link rel="stylesheet" href="/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">

    {{-- FORM CHOICES --}}
    <link rel="stylesheet" href="/assets/extensions/choices.js/public/assets/styles/choices.css" />

    <link rel="stylesheet" href="/assets/compiled/css/app.css" />
    <link rel="stylesheet" href="/assets/compiled/css/app-dark.css" />
    <link rel="stylesheet" href="/assets/compiled/css/iconly.css" />
    {{-- <style>
        * {
            border: 1px solid red;
        }
    </style> --}}

    <style>
        #sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            /* Tersembunyi di luar layar secara default */
            width: 250px;
            height: 100vh;
            background-color: #fff;
            /* Warna background untuk sidebar */
            transition: left 0.3s ease;
            z-index: 1001;
        }

        #sidebar,
        .overlay {
            border: none;
            /* Menghapus border jika ada */
            box-shadow: none;
            /* Menghapus shadow jika ada */
            margin: 0;
            padding: 0;
        }


        #sidebar.show {
            left: 0;
            /* Sidebar muncul ke dalam layar */
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            transition: opacity 0.3s ease;
        }

        .overlay.show {
            display: block;
            opacity: 1;
        }
    </style>
</head>

<body>
    <script src="/assets/static/js/initTheme.js"></script>

    <div id="app">
        {{-- Sidebar --}}
        <x-sidebar></x-sidebar>

        {{-- Content --}}
        <div id="main" class="layout-navbar navbar-fixed">
            {{-- Header & Navbar --}}
            <x-header></x-header>

            {{-- Main --}}
            <div id="main-content">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            <x-footer></x-footer>
        </div>
    </div>

    <script src="/assets/static/js/components/dark.js"></script>
    <script src="/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <script src="/assets/compiled/js/app.js"></script>

    <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="assets/static/js/pages/dashboard.js"></script>

</body>

</html>
