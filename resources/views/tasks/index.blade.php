<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Task List
            </h2>

            <a href="{{ route('tasks.create') }}"
               class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700">
                + Add Task
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @forelse($tasks as $task)
                <div class="bg-white shadow rounded-lg p-4 mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">
                        {{ $task->name }} <span class="text-sm text-gray-500">({{ $task->status }})</span>
                    </h3>
                    <p class="text-sm text-gray-600">{{ $task->description }}</p>

                    @if($task->subtasks->isNotEmpty())
                        <ul class="list-disc pl-5 mt-2 text-sm text-gray-700">
                            @foreach($task->subtasks as $subtask)
                                <li>{{ $subtask->name }} - <span class="text-gray-500">{{ $subtask->status }}</span></li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="mt-3 flex gap-4 text-sm">
                        @can('update', $task)
                            <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:underline">Edit</a>
                        @endcan

                        @can('delete', $task)
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        @endcan
                    </div>
                </div>
            @empty
                <p class="text-gray-600">No tasks found.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
