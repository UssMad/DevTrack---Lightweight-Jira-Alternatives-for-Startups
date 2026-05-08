<x-app-layout>
    {{-- Sprint Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-on-surface text-[24px]">view_kanban</span>
            <h1 class="text-h1 text-on-surface font-bold">Tasks</h1>
        </div>
        <div class="flex items-center gap-3">
            {{-- Filter Tabs --}}
            <div class="flex items-center gap-2">
                <a href="{{ route('tasks.index') }}"
                   class="px-3 py-1.5 rounded-lg text-body-md transition-colors {{ !request('status') ? 'bg-secondary-container/20 text-dt-primary border border-dt-primary/20' : 'bg-surface-container hover:bg-surface-container-high text-on-surface-variant border border-outline-variant/30' }}">
                    All
                </a>
                <a href="{{ route('tasks.index', ['status' => 'todo']) }}"
                   class="px-3 py-1.5 rounded-lg text-body-md transition-colors {{ request('status') === 'todo' ? 'bg-secondary-container/20 text-dt-primary border border-dt-primary/20' : 'bg-surface-container hover:bg-surface-container-high text-on-surface-variant border border-outline-variant/30' }}">
                    Todo
                </a>
                <a href="{{ route('tasks.index', ['status' => 'in_progress']) }}"
                   class="px-3 py-1.5 rounded-lg text-body-md transition-colors {{ request('status') === 'in_progress' ? 'bg-secondary-container/20 text-dt-primary border border-dt-primary/20' : 'bg-surface-container hover:bg-surface-container-high text-on-surface-variant border border-outline-variant/30' }}">
                    In Progress
                </a>
                <a href="{{ route('tasks.index', ['status' => 'done']) }}"
                   class="px-3 py-1.5 rounded-lg text-body-md transition-colors {{ request('status') === 'done' ? 'bg-secondary-container/20 text-dt-primary border border-dt-primary/20' : 'bg-surface-container hover:bg-surface-container-high text-on-surface-variant border border-outline-variant/30' }}">
                    Done
                </a>
            </div>

            <div class="hidden sm:block w-px h-8 bg-outline-variant/30"></div>

            <button class="bg-surface-container-high border border-outline-variant/30 text-on-surface px-3 py-1.5 rounded-lg text-body-md hover:bg-surface-container-highest transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">filter_list</span> Filter
            </button>

            @can('create', \App\Models\Task::class)
            <a href="{{ route('tasks.create') }}"
               class="btn-primary-gradient text-white px-4 py-1.5 rounded-lg text-body-md font-semibold flex items-center gap-1.5 hover:opacity-90 transition-opacity shrink-0">
                <span class="material-symbols-outlined text-[18px]">add</span> Task
            </a>
            @endcan
        </div>
    </div>

    {{-- Kanban Board --}}
    @php
        $todoTasks = $tasks->where('status', 'todo');
        $inProgressTasks = $tasks->where('status', 'in_progress');
        $doneTasks = $tasks->where('status', 'done');

        // Apply filter
        if(request('status') === 'todo') { $inProgressTasks = collect(); $doneTasks = collect(); }
        if(request('status') === 'in_progress') { $todoTasks = collect(); $doneTasks = collect(); }
        if(request('status') === 'done') { $todoTasks = collect(); $inProgressTasks = collect(); }
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        {{-- TODO Column --}}
        <div class="flex flex-col">
            <div class="flex items-center justify-between mb-3 px-1">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-outline"></div>
                    <h3 class="text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Todo</h3>
                    <span class="bg-surface-container-high text-on-surface-variant font-mono text-[11px] px-2 py-0.5 rounded-full">{{ $todoTasks->count() }}</span>
                </div>
                <button class="text-on-surface-variant hover:text-on-surface p-1 rounded transition-colors">
                    <span class="material-symbols-outlined text-[18px]">more_horiz</span>
                </button>
            </div>
            <div class="space-y-3 min-h-[200px]">
                @foreach($todoTasks as $task)
                    <a href="{{ route('tasks.show', $task) }}" class="glass-card rounded-xl p-4 block hover:border-outline-variant/60 transition-colors group">
                        <div class="flex justify-between items-start mb-2">
                            <span class="font-mono text-code text-outline-variant group-hover:text-dt-primary transition-colors">DEV-{{ str_pad($task->id, 4, '0', STR_PAD_LEFT) }}</span>
                            <div class="flex items-center gap-1">
                                @if($task->priority === 'high')
                                    <span class="material-symbols-outlined text-dt-error text-[16px]" title="High Priority">keyboard_double_arrow_up</span>
                                @elseif($task->priority === 'medium')
                                    <span class="material-symbols-outlined text-dt-secondary text-[16px]" title="Medium Priority">keyboard_arrow_up</span>
                                @endif
                            </div>
                        </div>
                        <h4 class="text-body-md text-on-surface mb-3 leading-snug">{{ $task->title }}</h4>
                        <div class="flex items-center justify-between mt-auto pt-2 border-t border-outline-variant/10">
                            @if($task->deadline)
                            <div class="flex items-center gap-1 text-outline text-label-sm">
                                <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                <span>{{ $task->deadline->format('M d') }}</span>
                            </div>
                            @else
                                <div></div>
                            @endif
                            @if($task->user)
                                <div class="w-6 h-6 rounded-full bg-surface-container-high border border-outline-variant flex items-center justify-center text-[10px] font-bold text-on-surface" title="{{ $task->user->name }}">
                                    {{ strtoupper(substr($task->user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
                {{-- Add Task Button --}}
                @can('create', \App\Models\Task::class)
                <a href="{{ route('tasks.create') }}?status=todo" class="flex items-center justify-center gap-1 p-3 border border-dashed border-outline-variant/30 rounded-xl text-on-surface-variant/50 hover:text-on-surface-variant hover:border-outline-variant/50 transition-colors text-body-md">
                    <span class="material-symbols-outlined text-[18px]">add</span> Add Task
                </a>
                @endcan
            </div>
        </div>

        {{-- IN PROGRESS Column --}}
        <div class="flex flex-col">
            <div class="flex items-center justify-between mb-3 px-1">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-secondary-container"></div>
                    <h3 class="text-label-sm uppercase tracking-wider text-dt-primary font-semibold">In Progress</h3>
                    <span class="bg-secondary-container/20 text-dt-primary font-mono text-[11px] px-2 py-0.5 rounded-full">{{ $inProgressTasks->count() }}</span>
                </div>
                <button class="text-on-surface-variant hover:text-on-surface p-1 rounded transition-colors">
                    <span class="material-symbols-outlined text-[18px]">more_horiz</span>
                </button>
            </div>
            <div class="space-y-3 min-h-[200px]">
                @foreach($inProgressTasks as $task)
                    <a href="{{ route('tasks.show', $task) }}" class="glass-card rounded-xl p-4 block border-secondary-container/50 bg-secondary-container/5 hover:border-secondary-container transition-colors group relative overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-primary-container to-secondary-container"></div>
                        <div class="pl-2">
                            <div class="flex justify-between items-start mb-2">
                                <span class="font-mono text-code text-dt-primary">DEV-{{ str_pad($task->id, 4, '0', STR_PAD_LEFT) }}</span>
                                <div class="flex items-center gap-1">
                                    @if($task->priority === 'high')
                                        <span class="material-symbols-outlined text-dt-error text-[16px]">keyboard_double_arrow_up</span>
                                        <span class="material-symbols-outlined text-dt-error text-[16px]">error</span>
                                    @elseif($task->priority === 'medium')
                                        <span class="material-symbols-outlined text-dt-secondary text-[16px]">keyboard_arrow_up</span>
                                    @endif
                                </div>
                            </div>
                            <h4 class="text-body-md text-on-surface mb-3 leading-snug">{{ $task->title }}</h4>
                            {{-- Progress bar --}}
                            <div class="h-1 w-full bg-surface-container-highest rounded-full overflow-hidden mb-3">
                                <div class="h-full bg-gradient-to-r from-primary-container to-secondary-container rounded-full" style="width: 60%"></div>
                            </div>
                            <div class="flex items-center justify-between mt-auto pt-2 border-t border-outline-variant/10">
                                @if($task->deadline)
                                <div class="flex items-center gap-1 text-label-sm {{ $task->deadline->isToday() ? 'text-dt-error' : 'text-outline' }}">
                                    @if($task->deadline->isToday())
                                        <span class="material-symbols-outlined text-[14px]">warning</span>
                                        <span>Due Today</span>
                                    @else
                                        <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                        <span>{{ $task->deadline->format('M d') }}</span>
                                    @endif
                                </div>
                                @else
                                    <div></div>
                                @endif
                                @if($task->user)
                                    <div class="w-6 h-6 rounded-full bg-surface-container-high border border-dt-primary/50 flex items-center justify-center text-[10px] font-bold text-on-surface" title="{{ $task->user->name }}">
                                        {{ strtoupper(substr($task->user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
                @can('create', \App\Models\Task::class)
                <a href="{{ route('tasks.create') }}?status=in_progress" class="flex items-center justify-center gap-1 p-3 border border-dashed border-outline-variant/30 rounded-xl text-on-surface-variant/50 hover:text-on-surface-variant hover:border-outline-variant/50 transition-colors text-body-md">
                    <span class="material-symbols-outlined text-[18px]">add</span> Add Task
                </a>
                @endcan
            </div>
        </div>

        {{-- DONE Column --}}
        <div class="flex flex-col">
            <div class="flex items-center justify-between mb-3 px-1">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-[#4CAF50]"></div>
                    <h3 class="text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Done</h3>
                    <span class="bg-surface-container-high text-on-surface-variant font-mono text-[11px] px-2 py-0.5 rounded-full">{{ $doneTasks->count() }}</span>
                </div>
                <button class="text-on-surface-variant hover:text-on-surface p-1 rounded transition-colors">
                    <span class="material-symbols-outlined text-[18px]">more_horiz</span>
                </button>
            </div>
            <div class="space-y-3 min-h-[200px] opacity-70 hover:opacity-100 transition-opacity">
                @foreach($doneTasks as $task)
                    <a href="{{ route('tasks.show', $task) }}" class="glass-card rounded-xl p-4 block hover:border-outline-variant/60 transition-colors group">
                        <div class="flex justify-between items-start mb-2">
                            <span class="font-mono text-code text-outline-variant line-through">DEV-{{ str_pad($task->id, 4, '0', STR_PAD_LEFT) }}</span>
                            <div class="flex items-center gap-1 text-[#4CAF50] bg-[#4CAF50]/10 px-1.5 py-0.5 rounded text-[10px] font-mono border border-[#4CAF50]/20">
                                <span class="material-symbols-outlined text-[12px]">check</span> Done
                            </div>
                        </div>
                        <h4 class="text-body-md text-on-surface-variant mb-3 leading-snug">{{ $task->title }}</h4>
                        <div class="flex items-center justify-between mt-auto pt-2 border-t border-outline-variant/10">
                            @if($task->deadline)
                            <div class="flex items-center gap-1 text-outline text-label-sm">
                                <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                <span>{{ $task->deadline->format('M d') }}</span>
                            </div>
                            @else
                                <div></div>
                            @endif
                            @if($task->user)
                                <div class="w-6 h-6 rounded-full bg-surface-container-high border border-surface-container-highest flex items-center justify-center text-[10px] font-bold text-on-surface-variant grayscale" title="{{ $task->user->name }}">
                                    {{ strtoupper(substr($task->user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    @if($tasks->isEmpty())
    <div class="flex flex-col items-center justify-center py-20 text-center border border-dashed border-outline-variant/30 rounded-xl bg-surface-container-low/30 mt-4">
        <div class="w-20 h-20 mb-6 rounded-full bg-surface-container flex items-center justify-center opacity-50">
            <span class="material-symbols-outlined text-4xl text-on-surface-variant">task</span>
        </div>
        <h3 class="text-h2 text-on-surface font-semibold mb-2">No tasks found</h3>
        <p class="text-body-md text-on-surface-variant max-w-md">Create your first task to start tracking your work.</p>
    </div>
    @endif
</x-app-layout>
