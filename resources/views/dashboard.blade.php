<x-app-layout>
    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-h1 text-on-surface font-bold">Good morning, {{ Auth::user()->name }} 👋</h1>
        <p class="text-body-lg text-on-surface-variant mt-1">Here's what's happening across your projects.</p>
    </div>

    {{-- Stats Cards --}}
    @php
        $totalTasks = $allTasks->count();
        $doneTasks = $allTasks->where('status', 'done')->count();
        $inProgressTasks = $allTasks->where('status', 'in_progress')->count();
        $todoTasks = $allTasks->where('status', 'todo')->count();
        $velocity = $totalTasks > 0 ? round(($doneTasks / $totalTasks) * 100) : 0;
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        {{-- Total Projects --}}
        <div class="glass-card rounded-xl p-5 group hover:border-dt-primary/30 transition-colors">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-primary-container/20 flex items-center justify-center border border-dt-primary/20">
                    <span class="material-symbols-outlined text-dt-primary text-[20px]">folder_open</span>
                </div>
                <span class="text-label-sm text-on-surface-variant uppercase tracking-wider">Projects</span>
            </div>
            <p class="text-h1 text-on-surface font-bold">{{ $projects->count() }}</p>
            <p class="text-label-sm text-on-surface-variant mt-1">Active projects</p>
        </div>

        {{-- Total Tasks --}}
        <div class="glass-card rounded-xl p-5 group hover:border-dt-primary/30 transition-colors">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-secondary-container/20 flex items-center justify-center border border-secondary-container/30">
                    <span class="material-symbols-outlined text-dt-secondary text-[20px]">checklist</span>
                </div>
                <span class="text-label-sm text-on-surface-variant uppercase tracking-wider">Tasks</span>
            </div>
            <p class="text-h1 text-on-surface font-bold">{{ $totalTasks }}</p>
            <p class="text-label-sm text-on-surface-variant mt-1">{{ $inProgressTasks }} in progress</p>
        </div>

        {{-- Completed --}}
        <div class="glass-card rounded-xl p-5 group hover:border-[#4CAF50]/30 transition-colors">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-[#4CAF50]/10 flex items-center justify-center border border-[#4CAF50]/20">
                    <span class="material-symbols-outlined text-[#4CAF50] text-[20px]">check_circle</span>
                </div>
                <span class="text-label-sm text-on-surface-variant uppercase tracking-wider">Done</span>
            </div>
            <p class="text-h1 text-on-surface font-bold">{{ $doneTasks }}</p>
            <p class="text-label-sm text-on-surface-variant mt-1">Tasks completed</p>
        </div>

        {{-- Velocity --}}
        <div class="glass-card rounded-xl p-5 group hover:border-tertiary-container/30 transition-colors">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-tertiary-container/20 flex items-center justify-center border border-tertiary-container/30">
                    <span class="material-symbols-outlined text-dt-tertiary text-[20px]">speed</span>
                </div>
                <span class="text-label-sm text-on-surface-variant uppercase tracking-wider">Velocity</span>
            </div>
            <p class="text-h1 text-on-surface font-bold">{{ $velocity }}%</p>
            <div class="h-1.5 w-full bg-surface-container-highest rounded-full overflow-hidden mt-2">
                <div class="h-full bg-gradient-to-r from-inverse-primary to-secondary-container rounded-full transition-all duration-500" style="width: {{ $velocity }}%"></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        {{-- Recent Projects (2/3 width) --}}
        <div class="lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-h3 text-on-surface font-semibold">Your Projects</h2>
                <a href="{{ route('projects.index') }}" class="text-label-sm text-dt-primary hover:text-primary-fixed-dim transition-colors flex items-center gap-1">
                    View All <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>
            <div class="space-y-3">
                @forelse($projects->take(5) as $project)
                    @php
                        $projectTasks = $project->tasks->count();
                        $projectDone = $project->tasks->where('status', 'done')->count();
                        $projectProgress = $projectTasks > 0 ? round(($projectDone / $projectTasks) * 100) : 0;
                    @endphp
                    <a href="{{ route('projects.show', $project) }}" class="group glass-card rounded-xl p-4 flex items-center gap-4 hover:border-outline-variant/40 transition-colors block">
                        <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center border border-outline-variant/10 shrink-0">
                            <span class="material-symbols-outlined text-dt-primary text-[20px]">code</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-body-md font-medium text-on-surface group-hover:text-dt-primary transition-colors truncate">{{ $project->title }}</h3>
                            <div class="flex items-center gap-3 mt-1 text-on-surface-variant text-label-sm">
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">checklist</span>
                                    {{ $projectTasks }} tasks
                                </span>
                                @if($project->deadline)
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                    {{ \Carbon\Carbon::parse($project->deadline)->format('M d') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            {{-- Team avatars --}}
                            <div class="flex -space-x-2">
                                @foreach($project->users->take(3) as $member)
                                    <div class="w-7 h-7 rounded-full bg-surface-container-high border-2 border-surface-container-low flex items-center justify-center text-[10px] font-bold text-on-surface" title="{{ $member->name }}">
                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                    </div>
                                @endforeach
                                @if($project->users->count() > 3)
                                    <div class="w-7 h-7 rounded-full bg-dt-primary/20 border-2 border-surface-container-low flex items-center justify-center text-[10px] font-bold text-dt-primary">
                                        +{{ $project->users->count() - 3 }}
                                    </div>
                                @endif
                            </div>
                            {{-- Progress --}}
                            <div class="w-16">
                                <div class="h-1.5 w-full bg-surface-container-highest rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-inverse-primary to-secondary-container rounded-full" style="width: {{ $projectProgress }}%"></div>
                                </div>
                                <p class="text-[10px] text-on-surface-variant text-right mt-0.5">{{ $projectProgress }}%</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="glass-card rounded-xl p-8 text-center">
                        <span class="material-symbols-outlined text-4xl text-on-surface-variant/50 mb-3">folder_off</span>
                        <p class="text-body-md text-on-surface-variant">No projects yet.</p>
                        <a href="{{ route('projects.create') }}" class="inline-flex items-center gap-1 btn-primary-gradient text-white px-4 py-2 rounded-lg text-label-sm mt-4">
                            <span class="material-symbols-outlined text-[16px]">add</span> Create Project
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Recent Tasks (1/3 width) --}}
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-h3 text-on-surface font-semibold">Recent Tasks</h2>
                <a href="{{ route('tasks.index') }}" class="text-label-sm text-dt-primary hover:text-primary-fixed-dim transition-colors flex items-center gap-1">
                    View All <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>
            <div class="space-y-3">
                @forelse($allTasks->take(6) as $task)
                    <a href="{{ route('tasks.show', $task) }}" class="group glass-card rounded-xl p-3 block hover:border-outline-variant/40 transition-colors">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-mono text-code text-outline-variant group-hover:text-dt-primary transition-colors">{{ $task->project->title ?? 'N/A' }}</span>
                            @if($task->priority === 'high')
                                <span class="material-symbols-outlined text-dt-error text-[14px]">keyboard_double_arrow_up</span>
                            @elseif($task->priority === 'medium')
                                <span class="material-symbols-outlined text-dt-secondary text-[14px]">keyboard_arrow_up</span>
                            @endif
                        </div>
                        <h4 class="text-body-md text-on-surface truncate">{{ $task->title }}</h4>
                        <div class="flex items-center justify-between mt-2">
                            @if($task->status === 'done')
                                <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-[#4CAF50]/10 text-[#4CAF50] border border-[#4CAF50]/20">Done</span>
                            @elseif($task->status === 'in_progress')
                                <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-secondary-container/10 text-dt-secondary border border-secondary-container/20">In Progress</span>
                            @else
                                <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-outline/10 text-outline border border-outline/20">Todo</span>
                            @endif
                            @if($task->deadline)
                                <span class="text-label-sm text-on-surface-variant flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[12px]">calendar_today</span>
                                    {{ $task->deadline->format('M d') }}
                                </span>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="glass-card rounded-xl p-6 text-center">
                        <span class="material-symbols-outlined text-3xl text-on-surface-variant/50 mb-2">task</span>
                        <p class="text-body-md text-on-surface-variant">No tasks yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
