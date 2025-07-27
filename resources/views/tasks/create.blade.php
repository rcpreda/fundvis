<x-app-layout>
    <x-slot name="title">
        Create Task
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create New Task
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <!-- Task Name -->
            <div class="mb-4">
                <label for="name" class="block font-medium text-sm text-gray-700">Task Name</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label for="status" class="block font-medium text-sm text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="pending">Pending</option>
                    <option value="done">Done</option>
                </select>
            </div>

            <!-- Subtasks -->
            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700 mb-2">Subtasks</label>
                <div id="subtasks-container">
                    <div class="flex items-center gap-4 mb-2 subtask-row">
                        <input type="text" name="subtasks[0][name]" placeholder="Subtask name" class="w-1/2 border-gray-300 rounded-md shadow-sm">
                        <select name="subtasks[0][status]" class="w-1/3 border-gray-300 rounded-md shadow-sm">
                            <option value="pending">Pending</option>
                            <option value="done">Done</option>
                        </select>
                        <button type="button" class="remove-subtask text-red-500 font-bold">✕</button>
                    </div>
                </div>
                <button type="button" onclick="addSubtask()" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-md">Add Subtask</button>
            </div>

            <!-- Submit -->
            <div>
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700">Save Task</button>
            </div>
        </form>
    </div>

    <script>
        let subtaskIndex = 1;

        function addSubtask() {
            const container = document.getElementById('subtasks-container');
            const html = `
            <div class="flex items-center gap-4 mb-2 subtask-row">
                <input type="text" name="subtasks[${subtaskIndex}][name]" placeholder="Subtask name" class="w-1/2 border-gray-300 rounded-md shadow-sm">
                <select name="subtasks[${subtaskIndex}][status]" class="w-1/3 border-gray-300 rounded-md shadow-sm">
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
