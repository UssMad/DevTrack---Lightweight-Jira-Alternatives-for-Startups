<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('tasks.index') }}"
               class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight truncate">
                🔍 {{ $task->title }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl shadow-sm">
                    <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @php
                $statusConfig = match($task->status) {
                    'todo'        => ['label' => 'To Do',       'dot' => 'bg-gray-400',  'bar' => 'from-gray-300 to-gray-400',           'bg' => 'bg-gray-100',  'text' => 'text-gray-700',  'ring' => 'ring-gray-200'],
                    'in_progress' => ['label' => 'In Progress', 'dot' => 'bg-amber-500', 'bar' => 'from-amber-400 to-orange-500',         'bg' => 'bg-amber-50',  'text' => 'text-amber-800', 'ring' => 'ring-amber-100'],
                    'done'        => ['label' => 'Done',        'dot' => 'bg-green-500', 'bar' => 'from-green-400 to-emerald-500',        'bg' => 'bg-green-50',  'text' => 'text-green-800', 'ring' => 'ring-green-100'],
                    default       => ['label' => $task->status, 'dot' => 'bg-gray-400',  'bar' => 'from-gray-300 to-gray-400',           'bg' => 'bg-gray-100',  'text' => 'text-gray-700',  'ring' => 'ring-gray-200'],
                };

                $priorityConfig = match($task->priority) {
                    'low'    => ['label' => 'Low',    'bg' => 'bg-green-100', 'text' => 'text-green-700', 'icon' => '🟢'],
                    'medium' => ['label' => 'Medium', 'bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'icon' => '🟡'],
                    'high'   => ['label' => 'High',   'bg' => 'bg-red-100',   'text' => 'text-red-700',   'icon' => '🔴'],
                    default  => ['label' => $task->priority ?? '—', 'bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'icon' => '⚪'],
                };

                $isOverdue = $task->deadline && $task->deadline->isPast() && $task->status !== 'done';
            @endphp

            {{-- Main Task Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                {{-- Status colour strip --}}
                <div class="h-2 bg-gradient-to-r {{ $statusConfig['bar'] }}"></div>

                <div class="p-8">
                    {{-- Title & Status Badge --}}
                    <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                        <h1 class="text-2xl font-bold text-gray-900 leading-snug">{{ $task->title }}</h1>
                        <div class="flex items-center gap-2 flex-wrap">
                            {{-- Priority Badge --}}
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold {{ $priorityConfig['bg'] }} {{ $priorityConfig['text'] }}">
                                {{ $priorityConfig['icon'] }} {{ $priorityConfig['label'] }}
                            </span>
                            {{-- Status Badge --}}
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-semibold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} ring-1 {{ $statusConfig['ring'] }}">
                                <span class="w-2 h-2 rounded-full {{ $statusConfig['dot'] }}"></span>
                                {{ $statusConfig['label'] }}
                            </span>
                        </div>
                    </div>

                    {{-- Description --}}
                    @if($task->description)
                        <div class="text-sm text-gray-600 mb-8 leading-relaxed whitespace-pre-line">{{ $task->description }}</div>
                    @else
                        <p class="text-sm text-gray-400 italic mb-8">No description provided.</p>
                    @endif

                    {{-- Meta Grid --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">

                        {{-- Project --}}
                        <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl col-span-2 sm:col-span-1">
                            <div class="w-9 h-9 bg-indigo-100 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Project</p>
                                <p class="text-sm font-semibold text-gray-800 mt-0.5 truncate">
                                    {{ $task->project->title ?? '—' }}
                                </p>
                            </div>
                        </div>

                        {{-- Assignee --}}
                        <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl col-span-2 sm:col-span-1">
                            <div class="w-9 h-9 bg-purple-100 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Assigned To</p>
                                <p class="text-sm font-semibold text-gray-800 mt-0.5 truncate">
                                    {{ $task->user->name ?? '—' }}
                                </p>
                            </div>
                        </div>

                        {{-- Deadline --}}
                        <div class="flex items-start gap-3 p-4 {{ $isOverdue ? 'bg-red-50' : 'bg-gray-50' }} rounded-xl col-span-2 sm:col-span-1">
                            <div class="w-9 h-9 {{ $isOverdue ? 'bg-red-100' : 'bg-teal-100' }} rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 {{ $isOverdue ? 'text-red-500' : 'text-teal-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold {{ $isOverdue ? 'text-red-400' : 'text-gray-400' }} uppercase tracking-wide">Deadline</p>
                                <p class="text-sm font-semibold {{ $isOverdue ? 'text-red-600' : 'text-gray-800' }} mt-0.5">
                                    {{ $task->deadline ? $task->deadline->format('d M Y') : '—' }}
                                    @if($isOverdue)
                                        <span class="ml-1 text-xs font-bold text-red-500">Overdue</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        {{-- Created --}}
                        <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl col-span-2 sm:col-span-1">
                            <div class="w-9 h-9 bg-slate-100 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Created</p>
                                <p class="text-sm font-semibold text-gray-800 mt-0.5">
                                    {{ $task->created_at->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick Status Update (developer: only own task) --}}
                @can('updateStatus', $task)
                    <div class="px-8 py-5 bg-gray-50 border-t border-gray-100">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Update Your Status</p>
                        <form method="POST" action="{{ route('tasks.updateStatus', $task) }}" class="flex flex-wrap gap-3">
                            @csrf @method('PATCH')
                            @foreach(['todo' => '📋 To Do', 'in_progress' => '⚡ In Progress', 'done' => '✅ Done'] as $value => $label)
                                <button type="submit" name="status" value="{{ $value }}"
                                        class="px-4 py-2 rounded-lg text-sm font-semibold border-2 transition-all duration-150
                                               {{ $task->status === $value
                                                  ? 'border-indigo-500 bg-indigo-600 text-white shadow-sm'
                                                  : 'border-gray-200 bg-white text-gray-600 hover:border-indigo-300 hover:text-indigo-700' }}">
                                    {{ $label }}
                                </button>
                            @endforeach
                        </form>
                    </div>
                @endcan

                {{-- Footer Actions --}}
                <div class="px-8 py-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-3">
                    <a href="{{ route('tasks.index') }}"
                       class="text-sm text-gray-500 hover:text-gray-700 font-medium transition">
                        ← Back to tasks
                    </a>
                    <div class="flex items-center gap-3">
                        @can('update', $task)
                            <a href="{{ route('tasks.edit', $task) }}"
                               class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-indigo-700 transition duration-150">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </a>
                        @endcan
                        @can('delete', $task)
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                                  onsubmit="return confirm('Are you sure you want to delete this task?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-50 text-red-600 text-sm font-semibold rounded-lg border border-red-200 hover:bg-red-100 transition duration-150">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
