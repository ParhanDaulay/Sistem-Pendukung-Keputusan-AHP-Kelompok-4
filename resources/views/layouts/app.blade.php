<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Sistem Pendukung Keputusan AHP - Bank Sumut') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-white shadow-md">
            <div class="p-4 text-center border-b">
                <h1 class="text-xl font-bold text-indigo-600">{{ config('app.name') }}</h1>
            </div>
            <nav class="p-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="block py-2 px-4 rounded hover:bg-indigo-100 {{ request()->routeIs('dashboard') ? 'bg-indigo-100 font-bold' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('karyawan.index') }}" class="block py-2 px-4 rounded hover:bg-indigo-100 {{ request()->routeIs('karyawan.*') ? 'bg-indigo-100 font-bold' : '' }}">
                    Karyawan
                </a>
                <a href="{{ route('kriteria.index') }}" class="block py-2 px-4 rounded hover:bg-indigo-100 {{ request()->routeIs('kriteria.*') ? 'bg-indigo-100 font-bold' : '' }}">
                    Kriteria
                </a>               
                <a href="{{ route('pairwise.index') }}" class="block py-2 px-4 rounded hover:bg-indigo-100 {{ request()->routeIs('pairwise.*') ? 'bg-indigo-100 font-bold' : '' }}">
                    Perbandingan
                </a>
                <a href="{{ route('penilaian.index') }}" class="block py-2 px-4 rounded hover:bg-indigo-100 {{ request()->routeIs('penilaian.*') ? 'bg-indigo-100 font-bold' : '' }}">
                    Penilaian
                </a> 
                <a href="{{ route('ranking') }}" class="block py-2 px-4 rounded hover:bg-indigo-100 {{ request()->routeIs('ranking') ? 'bg-indigo-100 font-bold' : '' }}">
                    Ranking
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full text-left py-2 px-4 text-red-600 hover:bg-red-100 rounded">
                        Logout
                    </button>
                </form>
            </nav>
        </aside>

<!-- CONTENT AREA -->
<div class="flex-1 flex flex-col">
    <!-- TOPBAR -->
    <header class="bg-white shadow px-6 py-6 flex justify-end items-center">
        <div class="relative group">
            <button class="font-semibold text-gray-700 focus:outline-none">
                👤 {{ Auth::user()->name }}
            </button>
            <div class="absolute right-0 mt-2 w-40 bg-white border rounded shadow hidden group-hover:block">
                <div class="p-2 text-sm text-gray-600 px-4">{{ Auth::user()->email }}</div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left text-red-500 px-4 py-2 hover:bg-red-100">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- PAGE CONTENT -->
    <main class="flex-1 p-6">
        @yield('content')
    </main>
</div>


    </div>
    @yield('scripts')
    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonColor: '#16a34a'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                confirmButtonColor: '#dc2626'
            });
        @endif
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
