<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'Velyx · Laravel components you own, line by line' }}</title>
        <meta name="description" content="Accessible Blade, Livewire and Alpine components you copy into your Laravel app with one command.">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">

        <script>
            (() => {
                let theme = null;
                try { theme = localStorage.getItem('theme'); } catch (e) {}
                const dark = theme ? theme === 'dark' : matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.classList.toggle('dark', dark);
                document.documentElement.classList.toggle('light', !dark);
                document.documentElement.classList.add('motion');
            })();
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="min-h-screen">
        {{ $slot }}

        @livewireScripts
    </body>
</html>
