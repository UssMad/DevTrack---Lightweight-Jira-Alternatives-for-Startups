<x-app-layout>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-h1 font-semibold text-on-surface">Archived Projects</h1>
            <p class="text-body-md text-on-surface-variant mt-1">Review, restore, or permanently delete inactive projects.</p>
        </div>
        <div class="flex items-center gap-2">
            <button class="bg-surface-container-high border border-outline-variant/30 text-on-surface px-3 py-1.5 rounded-md text-body-md hover:bg-surface-container-highest transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">filter_list</span>
                Filter
            </button>
        </div>
    </div>

    @if($projects->count() > 0)
    <div class="grid grid-cols-1 gap-4">
        @foreach($projects as $project)
            <div class="bg-surface-container/40 backdrop-blur-md border border-outline-variant/20 rounded-xl p-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 hover:border-outline-variant/40 transition-colors">
                <div class="flex items-start gap-4 flex-1">
                    <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center border border-outline-variant/10 shrink-0 opacity-70">
                        <span class="material-symbols-outlined text-on-surface-variant">terminal</span>
                    </div>
                    <div>
                        <h3 class="text-h3 text-on-surface-variant line-through decoration-on-surface-variant/30">{{ $project->title }}</h3>
                        <div class="flex items-center gap-3 mt-1 text-sm text-on-surface-variant/70">
                            <span class="flex items-center gap-1 font-mono text-code">
                                <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                Archived: {{ $project->deleted_at ? $project->deleted_at->format('M d, Y') : 'N/A' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2 w-full md:w-auto justify-end">
                    <form method="POST" action="{{ route('projects.restore', $project->id) }}">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 rounded-md border border-outline-variant/30 text-dt-primary hover:bg-dt-primary/10 transition-colors text-body-md flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">restore</span>
                            Restore
                        </button>
                    </form>
                    <form method="POST" action="{{ route('projects.forceDelete', $project->id) }}" onsubmit="return confirm('Permanently delete this project? This cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 rounded-md border border-dt-error/30 text-dt-error hover:bg-dt-error/10 transition-colors text-body-md flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">delete_forever</span>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    @else
    <div class="flex flex-col items-center justify-center py-20 px-4 text-center border border-dashed border-outline-variant/30 rounded-xl bg-surface-container-low/30 mt-8">
        <div class="w-24 h-24 mb-6 rounded-full bg-surface-container flex items-center justify-center opacity-50">
            <span class="material-symbols-outlined text-4xl text-on-surface-variant">inbox</span>
        </div>
        <h3 class="text-h2 text-on-surface font-semibold mb-2">Archive is clear</h3>
        <p class="text-body-md text-on-surface-variant max-w-md">There are currently no archived projects. Projects you archive will appear here for safe keeping.</p>
    </div>
    @endif
</x-app-layout>