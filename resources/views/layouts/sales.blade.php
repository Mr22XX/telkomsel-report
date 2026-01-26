<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sales Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Sweet Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Tailwind CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside id="sidebar"
    class="fixed lg:static inset-y-0 left-0 w-64
    bg-gradient-to-br from-red-700 via-red-600 to-orange-400
    text-white transform -translate-x-full lg:translate-x-0
    transition duration-300 z-50
    flex flex-col justify-between">

    <div>
        <!-- LOGO -->
        <div class="p-6 font-bold text-xl tracking-wide border-b border-red-500">
            TSR
            <p class="text-sm font-extralight">Telkomsel Sales Reporting</p>
        </div>
        
        <!-- MENU -->
        <nav class="p-4 space-y-2 text-sm">
            
            <a href="{{ route('sales.dashboard') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-lg
            {{ request()->routeIs('sales.dashboard') ? 'bg-white text-red-600 font-semibold' : 'hover:bg-red-800' }}">
            <i class="fas fa-chart-line"></i>
            Dashboard
            </a>
            
            <a href="{{ route('reports.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-lg
            {{ request()->routeIs('reports.*') ? 'bg-white text-red-600 font-semibold' : 'hover:bg-red-800' }}">
            <i class="fas fa-file-alt"></i>
            Data Report
            </a>
        
        </nav>
    </div>

    
    <div class="absolute bottom-20 text-center items-center flex justify-center w-full font-extralight">
        <p id="cp"></p>
    </div>

    <!-- LOGOUT -->
<div class="p-4 border-t border-red-500">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
            class="w-full flex items-center gap-3 px-4 py-3 rounded-lg
            hover:bg-red-800 transition text-sm font-medium">
            <i class="fas fa-sign-out-alt"></i>
            Logout
        </button>
    </form>
</div>

    </aside>

    <!-- OVERLAY (MOBILE) -->
    <div id="overlay" class="fixed inset-0 bg-black/50 hidden z-40 lg:hidden"></div>

    <!-- CONTENT -->
    <div class="flex-1 flex flex-col min-h-screen ">

        <!-- TOPBAR -->
        <header class="bg-white shadow-sm px-6 py-4 flex items-center">
            <button id="toggleSidebar" class="lg:hidden text-red-600 text-xl">
                <i class="fas fa-bars"></i>
            </button>

            <div class="text-sm text-gray-500 w-full flex gap-3 justify-end">
                {{ auth()->user()->name }}
                {{-- <p id="clock"></p> --}}
            </div>

        </header>

        <!-- PAGE CONTENT -->
        <main class="p-6 flex-1">
            @yield('content')
        </main>

    </div>
</div>

<!-- DATATABLES -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

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

        // function startTime(){

            
        //     let h = today.getHours()
        //     let m = today.getMinutes()
        //     let s = today.getSeconds()
            
        //     m = checkTime(m)
        //     s = checkTime(s)
            
        //     document.getElementById('clock').innerHTML = h + ":" + m + ":" + s
            
        //     setTimeout(startTime, 1000)
        // }

        // function checkTime(i) {
        //     if (i < 10) {
        //         i = "0" + i;
        //     }
        //     return i;
        // }

    </script>



@stack('scripts')


</body>
</html>
