@props([
    'title' => 'Velyx',
    'description' => config('velyx-docs.site_description'),
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
    <meta name="description" content="{{ $description }}">
    @livewireStyles
    <script>
        (function () {
            const theme = localStorage.getItem('theme');
            if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</head>
<body class="min-h-screen bg-background text-foreground antialiased">
    <livewire:docs.header />
    {{ $slot }}
    <livewire:docs.footer />
    @livewireScripts
</body>
</html>
