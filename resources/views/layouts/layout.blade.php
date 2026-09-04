<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield ('title', 'LIBAS Peternakan')</title>

    <!-- Favicon / Logo Tab -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />

    <!-- Google Fonts & Style -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap"
        rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Menyisipkan Komponent Sidebar -->
    @include ('sidebar-component.sidebar')

    <!-- Main Content Area -->
    <main class="main-content">
        @yield ('content')
    </main>

    <!-- Script Global UI Utilities -->
    <script src="{{ asset('js/shared/ui-utils.js') }}"></script>

    @if (session()->has('firebase_custom_token'))
        <script type="module">
            import { signInWithCustomToken } from "https://www.gstatic.com/firebasejs/10.9.0/firebase-auth.js";
            import { auth } from "{{ asset('js/firebase.component/firebase-init.js') }}";

            const token = "{{ session('firebase_custom_token') }}";
            if (token) {
                signInWithCustomToken(auth, token)
                    .then(() => {
                        console.log("Firebase Auth synced successfully via custom token.");
                    })
                    .catch((err) => {
                        console.error("Firebase Auth Sync Failed:", err);
                    });
            }
        </script>
    @endif

    @stack ('scripts')
</body>
</html>
