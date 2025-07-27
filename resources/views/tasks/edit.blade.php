<x-app-layout>
    <x-slot name="title">Edit Task</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Task: {{ $task->getTranslation('name', app()->getLocale()) }}</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <form action="{{ route('tasks.update', $task) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Task Name Translations -->
            @foreach ($locales as $locale)
                <div class="mb-4">
                    <label for="name_{{ $locale }}">Task Name ({{ strtoupper($locale) }})</label>
                    <input type="text" name="name_{{ $locale }}" id="name_{{ $locale }}" class="block w-full mt-1" value="{{ old('name_' . $locale, $task->getTranslation('name', $locale)) }}" required>
                </div>
            @endforeach

            <!-- Description Translations -->
            @foreach ($locales as $locale)
                <div class="mb-4">
                    <label for="description_{{ $locale }}">Description ({{ strtoupper($locale) }})</label>
                    <textarea name="description_{{ $locale }}" id="description_{{ $locale }}" rows="3" class="block w-full mt-1">{{ old('description_' . $locale, $task->getTranslation('description', $locale)) }}</textarea>
                </div>
            @endforeach

            <!-- Status -->
            <div class="mb-4">
                <label for="status">Status</label>
                <select name="status" id="status" class="block w-full mt-1">
                    <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>Done</option>
                </select>
            </div>

            <!-- Subtasks -->
            <div class="mb-4">
                <label>Subtasks</label>
                <div id="subtasks-container">
                    @foreach($task->subtasks as $index => $subtask)
                        <div class="flex gap-4 mb-2 subtask-row">
                            @foreach ($locales as $locale)
                                <input type="text" name="subtasks[{{ $index }}][name_{{ $locale }}]" value="{{ $subtask->getTranslation('name', $locale) }}" placeholder="Name ({{ strtoupper($locale) }})" class="w-1/3">
                            @endforeach
                            <select name="subtasks[{{ $index }}][status]" class="w-1/6">
                                <option value="pending" {{ $subtask->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="done" {{ $subtask->status === 'done' ? 'selected' : '' }}>Done</option>
                            </select>
                            <button type="button" class="remove-subtask text-red-500 font-bold">✕</button>
                        </div>
                    @endforeach
                </div>
                <button type="button" onclick="addSubtask()" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded">Add Subtask</button>
            </div>

            <div class="flex gap-4 mt-6">
                <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600">Update Task</button>
                <a href="{{ route('tasks.index') }}" class="px-6 py-2 border rounded text-gray-700 hover:bg-gray-100">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        let subtaskIndex = {{ $task->subtasks->count() }};

        function addSubtask() {
            const container = document.getElementById('subtasks-container');
            let inputs = '';

            @foreach ($locales as $locale)
                inputs += `<input type="text" name="subtasks[${subtaskIndex}][name_{{ $locale }}]" placeholder="Name ({{ strtoupper($locale) }})" class="w-1/3">`;
            @endforeach

            const html = `
            <div class="flex gap-4 mb-2 subtask-row">
                ${inputs}
                <select name="subtasks[${subtaskIndex}][status]" class="w-1/6">
                    <option value="pending">Pending</option>
                    <option value="done">Done</option>
                </select>
                <button type="button" class="remove-subtask text-red-500 font-bold">✕</button>
            </div>`;

            container.insertAdjacentHTML('beforeend', html);
            subtaskIndex++;
        }

        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-subtask')) {
                e.target.closest('.subtask-row').remove();
            }
        });
    </script>
</x-app-layout>
