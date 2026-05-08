<x-app-layout>
    <div class="max-w-2xl mx-auto">
        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('projects.index') }}" class="text-label-sm text-on-surface-variant hover:text-dt-primary transition-colors flex items-center gap-1 mb-4">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span> Back to Projects
            </a>
            <h1 class="text-h1 text-on-surface font-bold">Create New Project</h1>
            <p class="text-body-md text-on-surface-variant mt-1">Set up a new project for your engineering team.</p>
        </div>

        {{-- Form --}}
        <div class="glass-panel rounded-xl p-6">
            <form method="POST" action="{{ route('projects.store') }}" class="space-y-5">
                @csrf

                <div class="flex flex-col gap-1">
                    <label class="text-label-sm text-on-surface-variant" for="title">Project Title</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">edit</span>
                        <input class="devtrack-input w-full rounded-lg pl-10 pr-4 py-2.5 text-body-md text-on-surface placeholder:text-outline/50"
                               id="title" name="title" type="text" value="{{ old('title') }}" placeholder="e.g. Mobile App Redesign" required/>
                    </div>
                    <x-input-error :messages="$errors->get('title')" class="mt-1" />
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-label-sm text-on-surface-variant" for="description">Description</label>
                    <textarea class="devtrack-input w-full rounded-lg px-4 py-2.5 text-body-md text-on-surface placeholder:text-outline/50 min-h-[120px] resize-y"
                              id="description" name="description" placeholder="Describe the project scope and objectives...">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-1" />
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-label-sm text-on-surface-variant" for="deadline">Deadline</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">calendar_today</span>
                        <input class="devtrack-input w-full rounded-lg pl-10 pr-4 py-2.5 text-body-md text-on-surface"
                               id="deadline" name="deadline" type="date" value="{{ old('deadline') }}"/>
                    </div>
                    <x-input-error :messages="$errors->get('deadline')" class="mt-1" />
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-outline-variant/10">
                    <a href="{{ route('projects.index') }}" class="px-4 py-2 rounded-lg text-label-sm text-on-surface-variant hover:bg-surface-variant/50 border border-transparent hover:border-outline-variant/30 transition-all">
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary-gradient text-white px-6 py-2 rounded-lg text-label-sm font-medium flex items-center gap-2 transition-opacity hover:opacity-90">
                        <span class="material-symbols-outlined text-[18px]">add</span> Create Project
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>