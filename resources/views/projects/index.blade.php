<x-app-layout>
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-h1 text-on-surface font-bold">Projects</h1>
            <p class="text-body-md text-on-surface-variant mt-1">Manage your engineering projects and track progress.</p>
        </div>
        <a href="{{ route('projects.create') }}"
           class="btn-primary-gradient text-white px-4 py-2 rounded-lg text-body-md font-semibold flex items-center gap-2 hover:opacity-90 transition-opacity shrink-0">
            <span class="material-symbols-outlined text-[18px]">add</span>
            New Project
        </a>
    </div>

    {{-- Projects Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($projects as $project)
            @php
                $taskCount = $project->tasks->count();
                $doneCount = $project->tasks->where('status', 'done')->count();
                $progress = $taskCount > 0 ? round(($doneCount / $taskCount) * 100) : 0;
            @endphp
            <div class="glass-card rounded-xl p-5 group hover:border-outline-variant/40 transition-all duration-200">
                {{-- Project Header --}}
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 rounded-lg bg-primary-container/20 flex items-center justify-center border border-dt-primary/20 shrink-0">
                        <span class="material-symbols-outlined text-dt-primary text-[20px]">code</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <a href="{{ route('projects.edit', $project) }}" class="p-1.5 text-on-surface-variant hover:text-dt-primary hover:bg-dt-primary/10 rounded-lg transition-all opacity-0 group-hover:opacity-100" title="Edit">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                        </a>
                        <form method="POST" action="{{ route('projects.destroy', $project) }}" onsubmit="return confirm('Are you sure you want to archive this project?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 text-on-surface-variant hover:text-dt-error hover:bg-dt-error/10 rounded-lg transition-all opacity-0 group-hover:opacity-100" title="Archive">
                                <span class="material-symbols-outlined text-[18px]">archive</span>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Title & Description --}}
                <a href="{{ route('projects.show', $project) }}" class="block">
                    <h2 class="text-h3 text-on-surface group-hover:text-dt-primary transition-colors mb-1">{{ $project->title }}</h2>
                    <p class="text-body-md text-on-surface-variant line-clamp-2">{{ $project->description ?? 'No description provided.' }}</p>
                </a>

                {{-- Stats --}}
                <div class="flex items-center gap-4 mt-4 text-on-surface-variant text-label-sm">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">checklist</span>
                        {{ $taskCount }} tasks
                    </span>
                    @if($project->deadline)
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                        {{ \Carbon\Carbon::parse($project->deadline)->format('M d, Y') }}
                    </span>
                    @endif
                </div>

                {{-- Progress Bar --}}
                <div class="mt-4">
                    <div class="flex justify-between text-label-sm mb-1">
                        <span class="text-on-surface-variant">Progress</span>
                        <span class="text-dt-primary font-medium">{{ $progress }}%</span>
                    </div>
                    <div class="h-1.5 w-full bg-surface-container-highest rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-inverse-primary to-secondary-container rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                    </div>
                </div>

                {{-- Team Avatars --}}
                <div class="flex items-center justify-between mt-4 pt-3 border-t border-outline-variant/10">
                    <div class="flex -space-x-2">
                        @foreach($project->users->take(4) as $user)
                            <div class="w-7 h-7 rounded-full bg-surface-container-high border-2 border-surface-container-low flex items-center justify-center text-[10px] font-bold text-on-surface" title="{{ $user->name }}">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endforeach
                        @if($project->users->count() > 4)
                            <div class="w-7 h-7 rounded-full bg-dt-primary/20 border-2 border-surface-container-low flex items-center justify-center text-[10px] font-bold text-dt-primary">
                                +{{ $project->users->count() - 4 }}
                            </div>
                        @endif
                    </div>
                    <a href="{{ route('projects.show', $project) }}" class="text-label-sm text-dt-primary hover:text-primary-fixed-dim flex items-center gap-1 transition-colors">
                        View <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center py-20 px-4 text-center border border-dashed border-outline-variant/30 rounded-xl bg-surface-container-low/30">
                <div class="w-20 h-20 mb-6 rounded-full bg-surface-container flex items-center justify-center opacity-50">
                    <span class="material-symbols-outlined text-4xl text-on-surface-variant">folder_off</span>
                </div>
                <h3 class="text-h2 text-on-surface font-semibold mb-2">No projects yet</h3>
                <p class="text-body-md text-on-surface-variant max-w-md">Create your first project to start tracking tasks and collaborating with your team.</p>
                <a href="{{ route('projects.create') }}" class="btn-primary-gradient text-white px-6 py-2 rounded-lg text-body-md font-semibold flex items-center gap-2 mt-6">
                    <span class="material-symbols-outlined text-[18px]">add</span> New Project
                </a>
            </div>
        @endforelse
    </div>
</x-app-layout>