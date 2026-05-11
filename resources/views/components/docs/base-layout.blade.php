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
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const resolvedTheme = theme === 'dark' || theme === 'light' ? theme : (prefersDark ? 'dark' : 'light');
            document.documentElement.classList.toggle('dark', resolvedTheme === 'dark');
            document.documentElement.dataset.theme = resolvedTheme;
        })();
    </script>
</head>
<body class="min-h-screen bg-background text-foreground antialiased">
    <livewire:docs.header />
    {{ $slot }}
    <livewire:docs.footer />
    @livewireScriptConfig
</body>
</html>
