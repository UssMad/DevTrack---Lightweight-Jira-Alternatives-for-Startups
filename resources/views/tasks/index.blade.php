<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🗂️ {{ __('My Tasks') }}
            </h2>
            @can('create', App\Models\Task::class)
                <a href="{{ route('tasks.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-indigo-700 transition duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Task
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl shadow-sm">
                    <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Filters (leads only) --}}
            @can('create', App\Models\Task::class)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <form method="GET" action="{{ route('tasks.index') }}" class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-[180px]">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Project</label>
                            <select name="project" id="filter-project"
                                    class="w-full rounded-lg border-gray-200 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">All Projects</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ request('project') == $project->id ? 'selected' : '' }}>
                                        {{ $project->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-1 min-w-[160px]">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Status</label>
                            <select name="status" id="filter-status"
                                    class="w-full rounded-lg border-gray-200 text-sm shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">All Statuses</option>
                                <option value="todo"        {{ request('status') === 'todo'        ? 'selected' : '' }}>To Do</option>
                                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="done"        {{ request('status') === 'done'        ? 'selected' : '' }}>Done</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit"
                                    class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition duration-150 shadow-sm">
                                Filter
                            </button>
                            @if(request()->hasAny(['project','status']))
                                <a href="{{ route('tasks.index') }}"
                                   class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-semibold rounded-lg hover:bg-gray-200 transition duration-150">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            @endcan

            {{-- Task Grid --}}
            @if($tasks->isEmpty())
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-1">No tasks found</h3>
                    <p class="text-sm text-gray-400">
                        @can('create', App\Models\Task::class)
                            Get started by creating your first task.
                        @else
                            No tasks have been assigned to you yet.
                        @endcan
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($tasks as $task)
                        @php
                            $statusConfig = match($task->status) {
                                'todo'        => ['label' => 'To Do',       'bg' => 'bg-gray-100',  'text' => 'text-gray-600',  'dot' => 'bg-gray-400'],
                                'in_progress' => ['label' => 'In Progress', 'bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'dot' => 'bg-amber-500'],
                                'done'        => ['label' => 'Done',        'bg' => 'bg-green-100', 'text' => 'text-green-700', 'dot' => 'bg-green-500'],
                                default       => ['label' => $task->status, 'bg' => 'bg-gray-100',  'text' => 'text-gray-600',  'dot' => 'bg-gray-400'],
                            };
                            $priorityConfig = match($task->priority) {
                                'low'    => ['label' => 'Low',    'bg' => 'bg-green-100', 'text' => 'text-green-700', 'icon' => '🟢'],
                                'medium' => ['label' => 'Medium', 'bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'icon' => '🟡'],
                                'high'   => ['label' => 'High',   'bg' => 'bg-red-100',   'text' => 'text-red-700',   'icon' => '🔴'],
                                default  => ['label' => '—',      'bg' => 'bg-gray-100',  'text' => 'text-gray-500',  'icon' => ''],
                            };
                            $isOverdue = $task->deadline && $task->deadline->isPast() && $task->status !== 'done';
                        @endphp

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col">
                            {{-- Top colour bar by priority --}}
                            <div class="h-1 rounded-t-2xl
                                {{ $task->priority === 'high'   ? 'bg-red-400' :
                                   ($task->priority === 'medium' ? 'bg-amber-400' : 'bg-green-400') }}">
                            </div>

                            <div class="p-5 flex-1">
                                {{-- Status + Priority badges --}}
                                <div class="flex items-center justify-between mb-3 flex-wrap gap-1">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                                        {{ $statusConfig['label'] }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold {{ $priorityConfig['bg'] }} {{ $priorityConfig['text'] }}">
                                        {{ $priorityConfig['icon'] }} {{ $priorityConfig['label'] }}
                                    </span>
                                </div>

                                {{-- Project --}}
                                @if($task->project)
                                    <p class="text-xs text-indigo-500 font-semibold mb-1 truncate">
                                        📁 {{ $task->project->title }}
                                    </p>
                                @endif

                                {{-- Title --}}
                                <h3 class="font-semibold text-gray-800 text-base leading-snug mb-2 line-clamp-2">
                                    {{ $task->title }}
                                </h3>

                                {{-- Description --}}
                                @if($task->description)
                                    <p class="text-sm text-gray-500 line-clamp-2 mb-3">{{ $task->description }}</p>
                                @endif

                                {{-- Deadline + Assignee --}}
                                <div class="flex items-center justify-between mt-auto pt-2">
                                    {{-- Deadline --}}
                                    @if($task->deadline)
                                        <span class="text-xs font-medium {{ $isOverdue ? 'text-red-500' : 'text-gray-400' }}">
                                            📅 {{ $task->deadline->format('d M Y') }}
                                            @if($isOverdue) <span class="font-bold">⚠</span> @endif
                                        </span>
                                    @else
                                        <span></span>
                                    @endif

                                    {{-- Assignee avatar --}}
                                    @if($task->user)
                                        <div class="flex items-center gap-1.5">
                                            <div class="w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 text-xs font-bold">
                                                {{ strtoupper(substr($task->user->name, 0, 1)) }}
                                            </div>
                                            <span class="text-xs text-gray-500 hidden sm:inline">{{ $task->user->name }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Card Footer --}}
                            <div class="px-5 py-3 border-t border-gray-50 flex items-center justify-between gap-2">
                                <a href="{{ route('tasks.show', $task) }}"
                                   class="text-xs font-medium text-indigo-600 hover:text-indigo-800 transition">
                                    View details →
                                </a>
                                <div class="flex items-center gap-3">
                                    @can('update', $task)
                                        <a href="{{ route('tasks.edit', $task) }}"
                                           class="text-xs text-gray-400 hover:text-indigo-600 transition font-medium">Edit</a>
                                    @endcan
                                    @can('delete', $task)
                                        <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                                              onsubmit="return confirm('Delete this task?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="text-xs text-gray-400 hover:text-red-500 transition font-medium">
                                                Delete
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
