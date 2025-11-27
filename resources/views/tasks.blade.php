<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des tâches</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }
        .task {
            padding: 10px;
            margin-bottom: 10px;
            background: #f4f4f4;
            border-radius: 5px;
        }
        button {
            background: red;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background: darkred;
        }
    </style>
</head>
<body>

    <h1>📌 Liste des tâches</h1>

    {{-- Message de succès --}}
    @if(session('success'))
        <div style="color: green; font-weight:bold;">
            {{ session('success') }}
        </div>
    @endif


    {{-- LISTE DES TÂCHES --}}
    @foreach($tasks as $task)
        <div class="task">
            <h3>{{ $task->title }}</h3>
            <p>{{ $task->description }}</p>

            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Supprimer cette tâche ?')">
                    Supprimer
                </button>
            </form>
        </div>
    @endforeach

</body>
</html>
