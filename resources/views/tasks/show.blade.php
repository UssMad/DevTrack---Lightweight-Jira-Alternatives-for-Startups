<x-app-layout>
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-on-surface-variant text-label-sm mb-6">
        <a href="{{ route('tasks.index') }}" class="hover:text-dt-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-[14px]">checklist</span> Tasks
        </a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-on-surface">{{ $task->title }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content (2/3) --}}
        <div class="lg:col-span-2">
            <div class="glass-panel rounded-xl p-6">
                {{-- Task Header --}}
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            @if($task->priority === 'high')
                                <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-dt-error/15 text-dt-error border border-dt-error/20 uppercase tracking-wider">High Priority</span>
                            @elseif($task->priority === 'medium')
                                <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-primary-container/15 text-dt-primary border border-primary-container/20 uppercase tracking-wider">Medium Priority</span>
                            @else
                                <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-outline/15 text-outline border border-outline/20 uppercase tracking-wider">Low Priority</span>
                            @endif

                            @if($task->status === 'done')
                                <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-[#4CAF50]/15 text-[#4CAF50] border border-[#4CAF50]/20 uppercase tracking-wider flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[12px]">check</span> Done
                                </span>
                            @elseif($task->status === 'in_progress')
                                <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-secondary-container/15 text-dt-secondary border border-secondary-container/20 uppercase tracking-wider">In Progress</span>
                            @else
                                <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-outline/10 text-outline border border-outline/20 uppercase tracking-wider">Todo</span>
                            @endif
                        </div>
                        <h1 class="text-h1 text-on-surface font-bold">{{ $task->title }}</h1>
                    </div>
                    <div class="flex items-center gap-2">
                        @can('update', $task)
                        <a href="{{ route('tasks.edit', $task) }}" class="p-2 text-on-surface-variant hover:text-dt-primary hover:bg-dt-primary/10 rounded-lg transition-all" title="Edit">
                            <span class="material-symbols-outlined text-[20px]">edit</span>
                        </a>
                        @endcan
                        @can('delete', $task)
                        <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-on-surface-variant hover:text-dt-error hover:bg-dt-error/10 rounded-lg transition-all" title="Delete">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>

                {{-- Description --}}
                <div class="mt-6 pt-4 border-t border-outline-variant/10">
                    <h3 class="text-label-sm text-on-surface-variant uppercase tracking-wider mb-3">Description</h3>
                    <div class="text-body-lg text-on-surface-variant leading-relaxed">
                        {{ $task->description ?? 'No description provided.' }}
                    </div>
                </div>

                {{-- Status Update (for developers) --}}
                @can('updateStatus', $task)
                <div class="mt-6 pt-4 border-t border-outline-variant/10">
                    <h3 class="text-label-sm text-on-surface-variant uppercase tracking-wider mb-3">Update Status</h3>
                    <form method="POST" action="{{ route('tasks.updateStatus', $task) }}" class="flex gap-2">
                        @csrf
                        @method('PATCH')
                        <button type="submit" name="status" value="todo"
                                class="px-3 py-1.5 rounded-lg text-body-md transition-colors {{ $task->status === 'todo' ? 'bg-outline/20 text-on-surface border border-outline/30' : 'bg-surface-container hover:bg-surface-container-high text-on-surface-variant border border-outline-variant/30' }}">
                            Todo
                        </button>
                        <button type="submit" name="status" value="in_progress"
                                class="px-3 py-1.5 rounded-lg text-body-md transition-colors {{ $task->status === 'in_progress' ? 'bg-secondary-container/20 text-dt-primary border border-dt-primary/30' : 'bg-surface-container hover:bg-surface-container-high text-on-surface-variant border border-outline-variant/30' }}">
                            In Progress
                        </button>
                        <button type="submit" name="status" value="done"
                                class="px-3 py-1.5 rounded-lg text-body-md transition-colors {{ $task->status === 'done' ? 'bg-[#4CAF50]/20 text-[#4CAF50] border border-[#4CAF50]/30' : 'bg-surface-container hover:bg-surface-container-high text-on-surface-variant border border-outline-variant/30' }}">
                            Done
                        </button>
                    </form>
                </div>
                @endcan
            </div>
        </div>

        {{-- Sidebar (1/3) --}}
        <div class="space-y-4">
            {{-- Details Card --}}
            <div class="glass-card rounded-xl p-5">
                <h3 class="text-h3 text-on-surface mb-4">Details</h3>
                <div class="space-y-4">
                    <div>
                        <div class="text-label-sm text-on-surface-variant uppercase tracking-wider mb-1">Project</div>
                        @if($task->project)
                        <a href="{{ route('projects.show', $task->project) }}" class="text-body-md text-dt-primary hover:text-primary-fixed-dim transition-colors flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">folder</span>
                            {{ $task->project->title }}
                        </a>
                        @else
                            <span class="text-body-md text-on-surface-variant">N/A</span>
                        @endif
                    </div>
                    <div>
                        <div class="text-label-sm text-on-surface-variant uppercase tracking-wider mb-1">Assignee</div>
                        @if($task->user)
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-primary-container/20 border border-dt-primary/20 flex items-center justify-center text-[10px] font-bold text-dt-primary">
                                {{ strtoupper(substr($task->user->name, 0, 1)) }}
                            </div>
                            <span class="text-body-md text-on-surface">{{ $task->user->name }}</span>
                        </div>
                        @else
                            <span class="text-body-md text-on-surface-variant">Unassigned</span>
                        @endif
                    </div>
                    @if($task->deadline)
                    <div>
                        <div class="text-label-sm text-on-surface-variant uppercase tracking-wider mb-1">Deadline</div>
                        <div class="flex items-center gap-2 text-body-md text-on-surface">
                            <span class="material-symbols-outlined text-[16px] text-dt-error">calendar_today</span>
                            {{ $task->deadline->format('M d, Y') }}
                        </div>
                    </div>
                    @endif
                    <div>
                        <div class="text-label-sm text-on-surface-variant uppercase tracking-wider mb-1">Created</div>
                        <span class="text-body-md text-on-surface-variant">{{ $task->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
