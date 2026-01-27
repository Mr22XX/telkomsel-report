<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','Dashboard Manager')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>


</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside id="sidebar"
        class="fixed lg:static inset-y-0 left-0 w-64
        bg-gradient-to-br from-blue-700 via-blue-600 to-blue-500
        text-white transform -translate-x-full lg:translate-x-0
        transition duration-300 z-50
        flex flex-col justify-between">

        <div>
            <!-- LOGO -->
            <div class="p-6 font-bold text-xl border-b border-indigo-400">
                Manager Panel
                <p class="text-sm font-extralight">Telkomsel Selling Report</p>
            </div>

            <!-- MENU -->
            <nav class="p-4 space-y-2 text-sm">

                <a href="{{ route('manager.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg
                   {{ request()->routeIs('manager.dashboard') ? 'bg-white text-indigo-600 font-semibold' : 'hover:bg-blue-800' }}">
                    <i class="fa-solid fa-chart-line"></i>
                    Dashboard
                </a>

                <a href="{{ route('manager.monitoring') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('manager.monitoring') ? 'bg-white text-indigo-600 font-semibold' : 'hover:bg-blue-800' }}">
                    <i class="fa-solid fa-eye"></i>
                    Monitoring Sales
                </a>

                {{-- <a href="{{ route('manager.ranking') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-800">
                    <i class="fa-solid fa-trophy"></i>
                    Ranking Sales
                </a> --}}

                <a href="{{ route('manager.rekap') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('manager.rekap') ? 'bg-white text-indigo-600 font-semibold' : 'hover:bg-blue-800' }}">
                    <i class="fa-solid fa-table"></i>
                    Rekap Laporan
                </a>

                <a href="{{ route('manager.users') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('manager.users') ? 'bg-white text-indigo-600 font-semibold' : 'hover:bg-blue-800' }}">
                    <i class="fa-solid fa-users"></i>
                    Data Sales
                </a>

                {{-- <a href="{{ route('manager.export') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-indigo-800">
                    <i class="fa-solid fa-file-export"></i>
                    Export Report
                </a> --}}

            </nav>
        </div>

        <div class="absolute bottom-20 text-center items-center flex justify-center w-full font-extralight">
        <p id="cp"></p>
        </div>

        <!-- LOGOUT -->
        <div class="p-4 border-t border-indigo-400">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-lg
                    hover:bg-blue-800 transition text-sm font-medium">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </form>
        </div>

    </aside>

    <!-- OVERLAY -->
    <div id="overlay" class="fixed inset-0 bg-black/50 hidden z-40 lg:hidden"></div>

    <!-- CONTENT -->
    <div class="flex-1 flex flex-col min-h-screen">

        <!-- TOPBAR -->
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">

            <!-- TOGGLE BUTTON -->
            <button id="toggleSidebar" class="lg:hidden text-indigo-600 text-xl">
                <i class="fas fa-bars"></i>
            </button>

            <div class="flex items-center gap-3">
                <span class="text-gray-600 text-sm">
                    {{ Auth::user()->name }} (Manager)
                </span>
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}"
                     class="w-8 h-8 rounded-full">
            </div>

        </header>

        <!-- PAGE CONTENT -->
        <main class="p-6 flex-1">
            @yield('content')
        </main>

    </div>
</div>

<!-- SIDEBAR SCRIPT -->
<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const toggle = document.getElementById('toggleSidebar');

    toggle?.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    });

    overlay?.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });
</script>

<script>
    const today = new Date()
        let years = today.getFullYear()
    
        const cp = document.getElementById('cp')
    
        cp.innerHTML = `&copy; ${years} All Right Reserved`
</script>

@stack('scripts')

</body>
</html>
