<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="p-6 flex flex-col max-w-7xl mx-auto sm:px-6 lg:px-8 items-center">
        @if(isset($weather))
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 flex items-center gap-4">
                    <div>
                        <h3 class="text-lg font-semibold">Current Weather in {{ $weather['name'] }}</h3>
                        <p class="text-sm text-gray-600">
                            {{ $weather['weather'][0]['description'] }} | Temperature: {{ $weather['main']['temp'] }}°C | Humidity: {{ $weather['main']['humidity'] }}%
                        </p>
                    </div>
                    <img src="https://openweathermap.org/img/wn/{{ $weather['weather'][0]['icon'] }}@2x.png" alt="Weather Icon">
                </div>
            </div>
        @endif
    </div>
    <div class="p-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <div class="mb-4 flex justify-between items-center">
                <h3 class="text-lg font-semibold">Your Tasks</h3>
                <a href="{{ route('tasks.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                    + New Task
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($tasks->isEmpty())
                        <p class="text-gray-500">No tasks yet. Create your first one!</p>
                    @else
                        <ul class="space-y-4">
                            @foreach ($tasks as $task)
                                <li class="flex justify-between items-center border-b pb-3 last:border-0">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <form method="POST" action="{{ route('tasks.toggle', $task) }}" data-toggle-task>
                                                @csrf
                                                @method('PATCH')
                                                <label class="inline-flex items-center gap-2">
                                                    <input type="checkbox" {{ $task->is_completed ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                                </label>
                                            </form>
                                            <span class="{{ $task->is_completed ? 'line-through text-gray-500' : '' }}">
                                                {{ $task->title }}
                                            </span>
                                        </div>
                                        @if($task->description)
                                            <p class="text-sm text-gray-600 mt-1">
                                                {{ $task->description }}
                                            </p>
                                        @endif
                                        @if($task->due_date)
                                            @if($task->due_date <= now()->endOfDay())
                                                <p class="text-xs text-red-500 mt-1">
                                                    Due: {{ $task->due_date->format('d M Y') }}
                                                </p>
                                            @else
                                                <p class="text-xs text-gray-400 mt-1">
                                                    Due: {{ $task->due_date->format('d M Y') }}
                                                </p>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="flex gap-2 items-center">
                                        <a href="{{ route('tasks.edit', $task) }}"
                                           class="text-sm text-blue-600 hover:underline" name="editButton">Edit</a>
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                              onsubmit="return confirm('Delete this task?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:underline">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
