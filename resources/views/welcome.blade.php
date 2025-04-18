<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem AHP - Bank Sumut</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- jika pakai Vite --}}
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-orange-50 text-gray-800 font-sans">
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center p-10 bg-white shadow-2xl rounded-2xl max-w-lg border border-orange-200">
            <img src="https://www.banksumut.co.id/wp-content/uploads/2019/04/logo-1.png" alt="Logo Bank Sumut" class="mx-auto h-20 mb-6">

            <h1 class="text-4xl font-extrabold text-orange-600 mb-3">Sistem Pendukung Keputusan</h1>
            <h2 class="text-lg font-semibold text-orange-400 mb-6">Metode AHP – Pemilihan Karyawan Terbaik</h2>

            <p class="text-gray-600 mb-8 px-2">Aplikasi ini membantu memilih karyawan terbaik berdasarkan berbagai kriteria melalui metode AHP yang terstruktur dan objektif.</p>

            @auth
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-orange-600 text-white px-6 py-3 rounded-lg shadow hover:bg-orange-700 transition duration-200">
                    <i class="fas fa-chart-line"></i> Masuk ke Dashboard
                </a>
            @else
                <div class="flex justify-center gap-4 flex-wrap">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-white text-orange-600 px-6 py-3 rounded-lg border border-orange-600 hover:bg-orange-100 transition duration-200">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-orange-600 text-white px-6 py-3 rounded-lg shadow hover:bg-orange-700 transition duration-200">
                        <i class="fas fa-user-plus"></i> Register
                    </a>
                </div>
            @endauth
        </div>
    </div>
</body>
</html>
