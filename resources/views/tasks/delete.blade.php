<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Confirm Delete') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('Are you sure you want to delete this task?') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ __('Once this task is deleted, all of its resources and data will be permanently deleted.') }}</p>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-900">{{ __('Task Details:') }}</h4>
                        <div class="mt-2">
                            <p><span class="font-semibold">{{ __('Title:') }}</span> {{ $task->title }}</p>
                            <p><span class="font-semibold">{{ __('Status:') }}</span> {{ ucfirst($task->status) }}</p>
                            <p><span class="font-semibold">{{ __('Due Date:') }}</span> {{ $task->due_date ? $task->due_date->format('Y-m-d') : __('No due date') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('tasks.show', $task) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                            {{ __('Cancel') }}
                        </a>

                        <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>
                                {{ __('Delete Task') }}
                            </x-danger-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>