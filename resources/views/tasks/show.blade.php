<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Task Details') }}
            </h2>
            <div>
                <a href="{{ route('tasks.edit', $task) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">
                    {{ __('Edit Task') }}
                </a>
                <a href="{{ route('tasks.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Back to List') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">{{ $task->title }}</h3>
                        <div class="mt-2">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($task->status == 'completed') bg-green-100 text-green-800 
                                @elseif($task->status == 'in-progress') bg-blue-100 text-blue-800 
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($task->status) }}
                            </span>
                            @if($task->due_date)
                                <span class="ml-2 text-sm text-gray-500">Due: {{ $task->due_date->format('M d, Y') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Description</h4>
                        <div class="prose max-w-none">
                            @if($task->description)
                                <p>{{ $task->description }}</p>
                            @else
                                <p class="text-gray-500 italic">No description provided.</p>
                            @endif
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4 mt-6">
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Additional Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Created: {{ $task->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Last Updated: {{ $task->updated_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('tasks.delete', $task) }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Delete Task') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>