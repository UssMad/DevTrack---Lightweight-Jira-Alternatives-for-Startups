<x-app-layout>
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-on-surface-variant text-label-sm mb-4">
        <a href="{{ route('projects.index') }}" class="hover:text-dt-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-[14px]">folder</span> Projects
        </a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-on-surface">{{ $project->title }}</span>
    </div>

    {{-- Project Header --}}
    @php
        $taskCount = $project->tasks->count();
        $doneCount = $project->tasks->where('status', 'done')->count();
        $progress = $taskCount > 0 ? round(($doneCount / $taskCount) * 100) : 0;
    @endphp

    <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-6 mb-6">
        <div class="flex-1">
            <div class="flex items-center gap-4 mb-2">
                <h1 class="text-h1 font-bold text-on-surface tracking-tight">{{ $project->title }}</h1>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-secondary-container/15 text-secondary-fixed-dim border border-secondary-container/30 text-label-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-secondary-fixed-dim"></span>
                    Active
                </span>
            </div>
            <p class="text-on-surface-variant text-body-lg max-w-3xl leading-relaxed">
                {{ $project->description ?? 'No description provided.' }}
            </p>
        </div>
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 lg:gap-6 bg-surface-container-low/50 p-4 rounded-xl border border-outline-variant/20 backdrop-blur-sm">
            @if($project->deadline)
            <div>
                <div class="text-on-surface-variant text-label-sm mb-1 uppercase tracking-wider">Deadline</div>
                <div class="flex items-center gap-2 text-on-surface text-body-md font-medium">
                    <span class="material-symbols-outlined text-dt-error text-[18px]">calendar_today</span>
                    {{ \Carbon\Carbon::parse($project->deadline)->format('M d, Y') }}
                </div>
            </div>
            <div class="hidden sm:block w-px h-10 bg-outline-variant/30"></div>
            @endif
            <div>
                <div class="text-on-surface-variant text-label-sm mb-1 uppercase tracking-wider">Progress</div>
                <div class="flex items-center gap-2">
                    <span class="text-h2 text-dt-primary font-bold">{{ $progress }}%</span>
                    <span class="text-label-sm text-on-surface-variant">{{ $doneCount }}/{{ $taskCount }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('projects.edit', $project) }}" class="bg-surface-container hover:bg-surface-container-high text-on-surface text-body-md px-4 py-2 rounded-lg border border-outline-variant/30 flex items-center gap-2 transition-colors">
            <span class="material-symbols-outlined text-[18px]">edit</span> Edit
        </a>
        @can('create', \App\Models\Task::class)
        <a href="{{ route('tasks.create') }}?project={{ $project->id }}" class="btn-primary-gradient text-white text-body-md px-4 py-2 rounded-lg flex items-center gap-2 hover:opacity-90 transition-opacity">
            <span class="material-symbols-outlined text-[18px]">add</span> New Task
        </a>
        @endcan
    </div>

    {{-- Kanban Board --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        {{-- TODO Column --}}
        <div class="flex flex-col">
            <div class="flex items-center justify-between mb-3 px-1">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-outline"></div>
                    <h3 class="text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Todo</h3>
                    <span class="bg-surface-container-high text-on-surface-variant font-mono text-[11px] px-2 py-0.5 rounded-full">{{ $project->tasks->where('status', 'todo')->count() }}</span>
                </div>
            </div>
            <div class="space-y-3 min-h-[100px]">
                @foreach($project->tasks->where('status', 'todo') as $task)
                    <a href="{{ route('tasks.show', $task) }}" class="glass-card rounded-xl p-4 block hover:border-outline-variant/60 transition-colors group">
                        <div class="flex justify-between items-start mb-2">
                            <span class="font-mono text-code text-outline-variant group-hover:text-dt-primary transition-colors">{{ $project->title }}</span>
                            @if($task->priority === 'high')
                                <span class="material-symbols-outlined text-dt-error text-[16px]" title="High Priority">keyboard_double_arrow_up</span>
                            @elseif($task->priority === 'medium')
                                <span class="material-symbols-outlined text-dt-secondary text-[16px]" title="Medium Priority">keyboard_arrow_up</span>
                            @endif
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
            </div>
        </div>

        {{-- IN PROGRESS Column --}}
        <div class="flex flex-col">
            <div class="flex items-center justify-between mb-3 px-1">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-secondary-container"></div>
                    <h3 class="text-label-sm uppercase tracking-wider text-dt-primary font-semibold">In Progress</h3>
                    <span class="bg-secondary-container/20 text-dt-primary font-mono text-[11px] px-2 py-0.5 rounded-full">{{ $project->tasks->where('status', 'in_progress')->count() }}</span>
                </div>
            </div>
            <div class="space-y-3 min-h-[100px]">
                @foreach($project->tasks->where('status', 'in_progress') as $task)
                    <a href="{{ route('tasks.show', $task) }}" class="glass-card rounded-xl p-4 block border-secondary-container/50 bg-secondary-container/5 hover:border-secondary-container transition-colors group relative overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-primary-container to-secondary-container"></div>
                        <div class="pl-2">
                            <div class="flex justify-between items-start mb-2">
                                <span class="font-mono text-code text-dt-primary">{{ $project->title }}</span>
                                @if($task->priority === 'high')
                                    <span class="material-symbols-outlined text-dt-error text-[16px]">keyboard_double_arrow_up</span>
                                @endif
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
                                    <div class="w-6 h-6 rounded-full bg-surface-container-high border border-dt-primary/50 flex items-center justify-center text-[10px] font-bold text-on-surface" title="{{ $task->user->name }}">
                                        {{ strtoupper(substr($task->user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- DONE Column --}}
        <div class="flex flex-col">
            <div class="flex items-center justify-between mb-3 px-1">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-[#4CAF50]"></div>
                    <h3 class="text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Done</h3>
                    <span class="bg-surface-container-high text-on-surface-variant font-mono text-[11px] px-2 py-0.5 rounded-full">{{ $doneCount }}</span>
                </div>
            </div>
            <div class="space-y-3 min-h-[100px] opacity-70 hover:opacity-100 transition-opacity">
                @foreach($project->tasks->where('status', 'done') as $task)
                    <a href="{{ route('tasks.show', $task) }}" class="glass-card rounded-xl p-4 block hover:border-outline-variant/60 transition-colors group">
                        <div class="flex justify-between items-start mb-2">
                            <span class="font-mono text-code text-outline-variant line-through">{{ $project->title }}</span>
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

    {{-- Team Members Section --}}
    <div class="mt-8">
        <h2 class="text-h3 text-on-surface font-semibold mb-4">Team Members</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($project->users as $member)
                <div class="glass-card rounded-xl p-4 flex items-start gap-3 group hover:border-outline-variant/40 transition-colors">
                    <div class="w-10 h-10 rounded-full bg-primary-container/20 border border-dt-primary/20 flex items-center justify-center text-sm font-bold text-dt-primary shrink-0">
                        {{ strtoupper(substr($member->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-h3 text-on-surface truncate">{{ $member->name }}</h3>
                        <p class="font-mono text-code text-on-surface-variant truncate mt-0.5">{{ $member->email }}</p>
                        <div class="mt-2 flex gap-2">
                            <span class="bg-dt-primary/15 text-dt-primary border border-dt-primary/20 px-2 py-0.5 rounded-full text-[10px] uppercase tracking-wider flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-dt-primary"></span>
                                {{ ucfirst($member->pivot->role) }}
                            </span>
                        </div>
                    </div>
                    @if($member->pivot->role !== 'lead')
                        @can('update', $project)
                        <form action="{{ route('projects.members.remove', [$project, $member]) }}" method="POST" onsubmit="return confirm('Remove this member?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1 text-on-surface-variant hover:text-dt-error transition-colors opacity-0 group-hover:opacity-100" title="Remove">
                                <span class="material-symbols-outlined text-[18px]">person_remove</span>
                            </button>
                        </form>
                        @endcan
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Add Member Form --}}
        @can('update', $project)
        <div class="mt-6 glass-card rounded-xl p-5 max-w-lg">
            <h3 class="text-h3 text-on-surface mb-4">Add Team Member</h3>
            <form action="{{ route('projects.members.add', $project) }}" method="POST" class="flex gap-3">
                @csrf
                <div class="relative flex-1">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">mail</span>
                    <input type="email" name="email" placeholder="developer@company.com" required
                           class="w-full devtrack-input rounded-lg pl-10 pr-4 py-2 text-body-md text-on-surface placeholder:text-outline-variant/50"/>
                </div>
                <button type="submit" class="btn-primary-gradient text-white px-4 py-2 rounded-lg text-label-sm font-medium flex items-center gap-1 shrink-0">
                    <span class="material-symbols-outlined text-[18px]">person_add</span> Add
                </button>
            </form>
        </div>
        @endcan
    </div>
</x-app-layout>