<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('tasks.show', $task) }}" class="text-label-sm text-on-surface-variant hover:text-dt-primary transition-colors flex items-center gap-1 mb-4">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span> Back to Task
            </a>
            <h1 class="text-h1 text-on-surface font-bold">Edit Task</h1>
            <p class="text-body-md text-on-surface-variant mt-1">Update the task details below.</p>
        </div>

        <div class="glass-panel rounded-xl p-6">
            <form method="POST" action="{{ route('tasks.update', $task) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="flex flex-col gap-1">
                    <label class="text-label-sm text-on-surface-variant" for="title">Task Title</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">task_alt</span>
                        <input class="devtrack-input w-full rounded-lg pl-10 pr-4 py-2.5 text-body-md text-on-surface"
                               id="title" name="title" type="text" value="{{ old('title', $task->title) }}" required/>
                    </div>
                    <x-input-error :messages="$errors->get('title')" class="mt-1" />
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-label-sm text-on-surface-variant" for="description">Description</label>
                    <textarea class="devtrack-input w-full rounded-lg px-4 py-2.5 text-body-md text-on-surface min-h-[100px] resize-y"
                              id="description" name="description">{{ old('description', $task->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-1" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="flex flex-col gap-1">
                        <label class="text-label-sm text-on-surface-variant" for="project_id">Project</label>
                        <div class="relative">
                            <select class="devtrack-input w-full rounded-lg px-4 py-2.5 text-body-md text-on-surface appearance-none" id="project_id" name="project_id" required>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>{{ $project->title }}</option>
                                @endforeach
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none text-[20px]">expand_more</span>
                        </div>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-label-sm text-on-surface-variant" for="user_id">Assign To</label>
                        <div class="relative">
                            <select class="devtrack-input w-full rounded-lg px-4 py-2.5 text-body-md text-on-surface appearance-none" id="user_id" name="user_id">
                                <option value="">Unassigned</option>
                                @foreach($projects as $project)
                                    @foreach($project->users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $task->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none text-[20px]">expand_more</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div class="flex flex-col gap-1">
                        <label class="text-label-sm text-on-surface-variant" for="status">Status</label>
                        <div class="relative">
                            <select class="devtrack-input w-full rounded-lg px-4 py-2.5 text-body-md text-on-surface appearance-none" id="status" name="status" required>
                                <option value="todo" {{ old('status', $task->status) === 'todo' ? 'selected' : '' }}>Todo</option>
                                <option value="in_progress" {{ old('status', $task->status) === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="done" {{ old('status', $task->status) === 'done' ? 'selected' : '' }}>Done</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none text-[20px]">expand_more</span>
                        </div>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-label-sm text-on-surface-variant" for="priority">Priority</label>
                        <div class="relative">
                            <select class="devtrack-input w-full rounded-lg px-4 py-2.5 text-body-md text-on-surface appearance-none" id="priority" name="priority" required>
                                <option value="low" {{ old('priority', $task->priority) === 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('priority', $task->priority) === 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ old('priority', $task->priority) === 'high' ? 'selected' : '' }}>High</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none text-[20px]">expand_more</span>
                        </div>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-label-sm text-on-surface-variant" for="deadline">Deadline</label>
                        <input class="devtrack-input w-full rounded-lg px-4 py-2.5 text-body-md text-on-surface"
                               id="deadline" name="deadline" type="date" value="{{ old('deadline', $task->deadline?->format('Y-m-d')) }}"/>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-outline-variant/10">
                    <a href="{{ route('tasks.show', $task) }}" class="px-4 py-2 rounded-lg text-label-sm text-on-surface-variant hover:bg-surface-variant/50 border border-transparent hover:border-outline-variant/30 transition-all">
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary-gradient text-white px-6 py-2 rounded-lg text-label-sm font-medium flex items-center gap-2 transition-opacity hover:opacity-90">
                        <span class="material-symbols-outlined text-[18px]">save</span> Update Task
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
