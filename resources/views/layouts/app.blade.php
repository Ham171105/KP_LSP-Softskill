<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Sertifikasi - PT LSP Soft Skill</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @auth
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('dashboard') }}" class="navbar-brand">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 15l8.38-4.19a2 2 0 0 0 1.1-1.61L22 4l-5.19 1.1a2 2 0 0 0-1.61 1.1L11 14.62"/><path d="m14 12-4-4"/><path d="m8 18-5.5 3 2.5-5.5"/></svg>
                LSP Soft Skill
            </a>
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <span style="font-size: 0.9rem; font-weight: 500;">Hi, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="padding: 0.4rem 1rem; font-size: 0.8rem;">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    @endauth

    <main>
        @yield('content')
    </main>

    <script>
        // Simple JS for micro animations or toast notifications could go here
    </script>
</body>
</html>
