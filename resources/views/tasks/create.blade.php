<x-app-layout>
    <x-slot name="title">Create Task</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create New Task</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <!-- Task Name Translations -->
            @foreach ($locales as $locale)
                <div class="mb-4">
                    <label for="name_{{ $locale }}">Task Name ({{ strtoupper($locale) }})</label>
                    <input type="text" name="name_{{ $locale }}" id="name_{{ $locale }}" class="block w-full mt-1" required>
                </div>
            @endforeach

            <!-- Description Translations -->
            @foreach ($locales as $locale)
                <div class="mb-4">
                    <label for="description_{{ $locale }}">Description ({{ strtoupper($locale) }})</label>
                    <textarea name="description_{{ $locale }}" id="description_{{ $locale }}" rows="3" class="block w-full mt-1"></textarea>
                </div>
            @endforeach

            <!-- Status -->
            <div class="mb-4">
                <label for="status">Status</label>
                <select name="status" id="status" class="block w-full mt-1">
                    <option value="pending">Pending</option>
                    <option value="done">Done</option>
                </select>
            </div>

            <!-- Subtasks -->
            <div class="mb-4">
                <label>Subtasks</label>
                <div id="subtasks-container">
                    <div class="flex gap-4 mb-2 subtask-row">
                        @foreach ($locales as $locale)
                            <input type="text" name="subtasks[0][name_{{ $locale }}]" placeholder="Name ({{ strtoupper($locale) }})" class="w-1/3" required>
                        @endforeach
                        <select name="subtasks[0][status]" class="w-1/6">
                            <option value="pending">Pending</option>
                            <option value="done">Done</option>
                        </select>
                        <button type="button" class="remove-subtask text-red-500 font-bold">✕</button>
                    </div>
                </div>
                <button type="button" onclick="addSubtask()" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded">Add Subtask</button>
            </div>

            <div class="flex gap-4 mt-6">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Save Task</button>
                <a href="{{ route('tasks.index') }}" class="px-6 py-2 border rounded text-gray-700 hover:bg-gray-100">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        let subtaskIndex = 1;

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
