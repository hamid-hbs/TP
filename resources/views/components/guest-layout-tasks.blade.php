<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
{{-- On force le Dark Mode ici pour la cohérence --}}

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-950 text-gray-100 min-h-screen">

    {{-- Barre de navigation minimaliste pour la déconnexion et l'info utilisateur --}}
    <nav class="bg-gray-900/50 backdrop-blur-md border-b border-gray-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                {{-- Logo/Nom de l'App --}}
                <div class="flex-shrink-0">
                    <a href="{{ route('tasks.index') }}" class="text-2xl font-bold text-purple-400">
                        TaskFlow
                    </a>
                </div>

                {{-- Espace Utilisateur --}}
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-gray-400 hidden sm:block">
                        Bienvenue, {{ Auth::user()->name }}
                    </span>

                    {{-- Formulaire de Déconnexion --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="text-sm font-semibold text-red-400 hover:text-red-300 transition duration-150">
                            Déconnexion
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>

</body>

</html>