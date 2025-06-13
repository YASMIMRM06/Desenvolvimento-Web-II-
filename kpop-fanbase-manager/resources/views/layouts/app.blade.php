<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KPOP FanBase Manager - @yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('home') }}" class="logo">KPOP FanBase</a>
            <div class="nav-links">
                <a href="{{ route('songs.index') }}">Songs</a>
                <a href="{{ route('groups.index') }}">Groups</a>
                <a href="{{ route('events.index') }}">Events</a>
                
                @auth
                    @can('access-admin')
                        <a href="{{ route('admin.dashboard') }}">Admin</a>
                    @endcan
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container">
        @if(session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert error">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer>
        <div class="container">
            <p>© 2025 KPOP FanBase Manager - IFPR Paranaguá</p>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>