<x-guest-layout-tasks> {{-- Conteneur Principal centré et espacé --}}
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

        {{-- Titre de la Page --}}
        <h1 class="text-4xl font-extrabold mb-8 text-gray-900 dark:text-gray-50 tracking-tight">
            Vos Tâches Actuelles
        </h1>

        {{-- Section 1 : Formulaire de Création de Tâche (Carte Modale-like) --}}
        <div
            class="bg-white dark:bg-gray-900/80 backdrop-blur-sm shadow-xl rounded-2xl p-6 border border-gray-200 dark:border-gray-800 mb-10 transition-all duration-300 hover:shadow-2xl dark:hover:shadow-purple-500/10">

            <form method="POST" action="{{ route('tasks.store') }}" class="space-y-5">
                @csrf

                {{-- Champ Titre --}}
                <input type="text" name="title" placeholder="Titre de la tâche (ex: Finir le rapport)"
                    class="w-full text-lg rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:border-purple-500 focus:ring-purple-500 transition duration-150"
                    required>

                {{-- Champ Description --}}
                <textarea name="description" placeholder="Détails, notes ou contexte..." rows="3"
                    class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 focus:border-purple-500 focus:ring-purple-500 transition duration-150"></textarea>

                <div class="flex items-center justify-between">
                    {{-- Champ Date d'échéance --}}
                    <input type="datetime-local" name="due_date"
                        class="rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">

                    {{-- Bouton Créer avec style Néon --}}
                    <button type="submit" class="px-6 py-2 rounded-xl text-white font-bold bg-purple-700 hover:bg-purple-600 transition duration-300 
                                shadow-lg shadow-purple-500/50 hover:shadow-purple-500/80 dark:shadow-purple-900/50 dark:hover:shadow-purple-700/80
                                transform hover:scale-[1.02] active:scale-[0.98]">
                        Créer la Tâche
                    </button>
                </div>

                @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </form>
        </div>

                {{-- Section 2 : Liste des Tâches --}}
        <div class="space-y-4">

            @forelse ($tasks as $task)
            <div
                class="flex items-start justify-between bg-white dark:bg-gray-900/70 p-5 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm transition-all duration-200 hover:shadow-md hover:border-purple-400 dark:hover:border-purple-600">

                <div class="flex items-start gap-4 flex-1">

                    {{-- Checkbox/Toggle --}}
                    <form action="{{ route('tasks.update', $task) }}" method="POST" class="mt-1">
                        @csrf
                        @method('PATCH')
                        <button type="submit">
                            <span
                                class="w-5 h-5 flex-shrink-0 inline-flex items-center justify-center rounded-full border-2 transition duration-200
                                    {{ $task->is_completed 
                                        ? 'bg-purple-600 border-purple-600 shadow-inner shadow-black/30' 
                                        : 'border-gray-400 dark:border-gray-600 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                                @if ($task->is_completed)
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                @endif
                            </span>
                        </button>
                    </form>

                    {{-- Texte --}}
                    <div class="flex-1 min-w-0">
                        <p
                            class="font-semibold text-lg text-gray-900 dark:text-gray-100 {{ $task->is_completed ? 'line-through opacity-40' : '' }}">
                            {{ $task->title }}
                        </p>

                        @if($task->description)
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">
                            {{ $task->description }}
                        </p>
                        @endif

                        @if($task->due_date)
                        <p
                            class="text-xs font-medium mt-1 {{ $task->due_date->isPast() ? 'text-red-500' : 'text-purple-500' }}">
                            Échéance : {{ $task->due_date->format('d M à H:i') }}
                        </p>
                        @endif
                    </div>

                </div>

                {{-- Actions (Edit + Delete) --}}
                <div class="flex items-center gap-3 ml-4">

                    {{-- Bouton Edit (ouvre le modal) --}}
                    <button onclick="document.getElementById('modal-edit-{{ $task->id }}').showModal()"
                        class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition p-1 rounded-full hover:bg-blue-500/10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536M4 20h4l10-10-4-4L4 16v4z"></path>
                        </svg>
                    </button>

                    {{-- Form Delete --}}
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="flex-shrink-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition p-1 rounded-full hover:bg-red-500/10"
                            onclick="return confirm('Êtes-vous sûr ?')">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </form>

                </div>

            </div>

            {{-- MODAL UPDATE --}}
            <dialog id="modal-edit-{{ $task->id }}"
                class="backdrop:bg-black/50 rounded-xl p-0 w-11/12 max-w-lg">

                <form method="POST" action="{{ route('tasks.update', $task) }}"
                    class="bg-white dark:bg-gray-900 rounded-xl p-6 space-y-4">
                    @csrf
                    @method('PATCH')

                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Modifier la tâche</h2>

                    {{-- Champ titre --}}
                    <input type="text" name="title" value="{{ $task->title }}"
                        class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 p-3"
                        required />

                    {{-- Champ description --}}
                    <textarea name="description" rows="3"
                        class="w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 p-3">{{ $task->description }}</textarea>

                    {{-- Date --}}
                    <input type="datetime-local" name="due_date"
                        value="{{ $task->due_date ? $task->due_date->format('Y-m-d\TH:i') : '' }}"
                        class="rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100" />

                    {{-- Boutons --}}
                    <div class="flex justify-end gap-3 mt-4">
                        <button type="button"
                            onclick="document.getElementById('modal-edit-{{ $task->id }}').close()"
                            class="px-4 py-2 rounded-xl bg-gray-200 dark:bg-gray-700 dark:text-gray-300">
                            Annuler
                        </button>

                        <button type="submit"
                            class="px-4 py-2 rounded-xl bg-purple-600 text-white font-semibold hover:bg-purple-500">
                            Enregistrer
                        </button>
                    </div>
                </form>

            </dialog>

            @empty

            {{-- Message si aucune tâche --}}
            <div
                class="p-10 text-center bg-white dark:bg-gray-900/70 rounded-xl border border-gray-200 dark:border-gray-800">
                <p class="text-lg font-medium text-gray-700 dark:text-gray-300">🎉 Bravo ! Toutes les tâches sont
                    faites.</p>
                <p class="text-sm text-gray-500 dark:text-gray-500 mt-2">Utilisez le formulaire ci-dessus pour ajouter
                    de nouvelles tâches à votre liste.</p>
            </div>
            @endforelse

        </div>


    </div>
</x-guest-layout-tasks>