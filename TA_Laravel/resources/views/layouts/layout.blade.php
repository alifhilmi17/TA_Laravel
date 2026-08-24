<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'LIBAS Peternakan')</title>

  <!-- Google Fonts & Style -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

  <!-- Menyisipkan Komponent Sidebar -->
  <x-sidebar />

  <!-- Main Content Area -->
  <main class="main-content">
    @yield('content')
  </main>

  <!-- Script Global UI Utilities -->
  <script src="{{ asset('js/shared/ui-utils.js') }}"></script>
  @stack('scripts')
</body>
</html>
