<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Task List
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach($tasks as $task)
                <div class="bg-white shadow rounded-lg p-4 mb-4">
                    <h3 class="text-lg font-semibold">{{ $task->name }} ({{ $task->status }})</h3>
                    <p class="text-sm text-gray-600">{{ $task->description }}</p>
                    <ul class="list-disc pl-5 mt-2 text-sm">
                        @foreach($task->subtasks as $subtask)
                            <li>{{ $subtask->name }} - {{ $subtask->status }}</li>
                        @endforeach
                    </ul>

                    <div class="mt-3 flex gap-2">
                        <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
