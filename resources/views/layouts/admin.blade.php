<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - @yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind via CDN (no vite, no npm) --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

<div class="flex">
    {{-- Sidebar --}}
    <aside class="w-64 bg-gray-800 text-white min-h-screen p-5">
        <h2 class="text-xl font-bold mb-6">Admin Panel</h2>
        <nav>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('admin.hotel.create') }}" 
                       class="block px-3 py-2 rounded hover:bg-gray-700">
                       🏨 Hotels
                    </a>
                </li>
                <li>
                    <a href="#" 
                       class="block px-3 py-2 rounded hover:bg-gray-700">
                       ✈️ Flights
                    </a>
                </li>
                <li>
                    <a href="#" 
                       class="block px-3 py-2 rounded hover:bg-gray-700">
                       🎒 Tours
                    </a>
                </li>
                <li>
                    <a href="#" 
                       class="block px-3 py-2 rounded hover:bg-gray-700">
                       🛒 Orders
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 p-8">
        @yield('content')
    </main>
</div>

</body>
</html>
