<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="/images/card-oil.png" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;800;900&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        <link rel="stylesheet" href="https://unpkg.com/vue3-tel-input@1.0.4/dist/vue3-tel-input.css">
        <link rel="stylesheet" href="{{ asset('css/lightbox.min.css') }}">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>

    <body class="font-sans antialiased bg-gray-200/20 dark:bg-gray-900">
        @inertia
        <script src="{{ asset('js/lightbox.min.js') }}" nonce="{{ Vite::cspNonce() }}"></script>
        <script src="{{ asset('js/qrcode.min.js') }}"></script>
    </body>
</html>
