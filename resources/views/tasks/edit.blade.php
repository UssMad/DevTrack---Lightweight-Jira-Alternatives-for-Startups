<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('tasks.show', $task) }}"
               class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight truncate">
                ✏️ Edit: {{ $task->title }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                {{-- Form Header --}}
                <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-8 py-6">
                    <h3 class="text-white font-bold text-lg">Update Task</h3>
                    <p class="text-purple-100 text-sm mt-1">Modify the details below and save your changes.</p>
                </div>

                <form method="POST" action="{{ route('tasks.update', $task) }}" class="p-8 space-y-6" id="edit-task-form">
                    @csrf
                    @method('PUT')

                    {{-- Validation Errors --}}
                    @if($errors->any())
                        <div class="p-4 bg-red-50 border border-red-200 rounded-xl">
                            <p class="text-sm font-semibold text-red-700 mb-2">Please fix the following errors:</p>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li class="text-sm text-red-600">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Title --}}
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Task Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="title"
                               value="{{ old('title', $task->title) }}"
                               placeholder="e.g. Implement login page"
                               required
                               class="w-full rounded-xl border-gray-200 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-400 @enderror">
                        @error('title')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" id="description" rows="4"
                                  placeholder="Describe what needs to be done..."
                                  required
                                  class="w-full rounded-xl border-gray-200 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500 resize-none @error('description') border-red-400 @enderror">{{ old('description', $task->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Project & Assignee --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5"
                         x-data="editTaskForm()"
                         x-init="init()">

                        {{-- Project --}}
                        <div>
                            <label for="project_id" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Project <span class="text-red-500">*</span>
                            </label>
                            <select name="project_id" id="project_id"
                                    required
                                    x-on:change="onProjectChange($event)"
                                    class="w-full rounded-xl border-gray-200 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500 @error('project_id') border-red-400 @enderror">
                                <option value="">— Select project —</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}"
                                            data-members="{{ $project->users->toJson() }}"
                                            {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>
                                        {{ $project->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Assignee --}}
                        <div>
                            <label for="user_id" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Assign To
                            </label>
                            <select name="user_id" id="user_id"
                                    x-bind:disabled="members.length === 0"
                                    class="w-full rounded-xl border-gray-200 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500 disabled:bg-gray-50 disabled:text-gray-400 @error('user_id') border-red-400 @enderror">
                                <option value="">— Select member —</option>
                                <template x-for="member in members" :key="member.id">
                                    <option :value="member.id"
                                            :selected="member.id == currentAssignee"
                                            x-text="member.name"></option>
                                </template>
                            </select>
                            @error('user_id')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Priority & Deadline --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        {{-- Priority --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Priority <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-2">
                                @foreach(['low' => ['label' => '🟢 Low', 'active' => 'border-green-500 bg-green-50 text-green-700'],
                                          'medium' => ['label' => '🟡 Medium', 'active' => 'border-amber-500 bg-amber-50 text-amber-700'],
                                          'high' => ['label' => '🔴 High', 'active' => 'border-red-500 bg-red-50 text-red-700']] as $value => $cfg)
                                    <label class="flex-1 cursor-pointer">
                                        <input type="radio" name="priority" value="{{ $value }}"
                                               class="sr-only peer"
                                               {{ old('priority', $task->priority) === $value ? 'checked' : '' }}>
                                        <span class="block text-center px-2 py-2.5 rounded-xl border-2 text-xs font-semibold
                                                     border-gray-200 text-gray-500
                                                     peer-checked:{{ $cfg['active'] }}
                                                     hover:border-gray-300 transition-all duration-150">
                                            {{ $cfg['label'] }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            @error('priority')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Deadline --}}
                        <div>
                            <label for="deadline" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Deadline <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="deadline" id="deadline"
                                   value="{{ old('deadline', $task->deadline?->toDateString()) }}"
                                   required
                                   class="w-full rounded-xl border-gray-200 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500 @error('deadline') border-red-400 @enderror">
                            @error('deadline')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-3">
                            @foreach(['todo' => '📋 To Do', 'in_progress' => '⚡ In Progress', 'done' => '✅ Done'] as $value => $label)
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="status" value="{{ $value }}"
                                           class="sr-only peer"
                                           {{ old('status', $task->status) === $value ? 'checked' : '' }}>
                                    <span class="block text-center px-3 py-2.5 rounded-xl border-2 text-sm font-medium
                                                 border-gray-200 text-gray-500
                                                 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:text-indigo-700
                                                 hover:border-indigo-300 transition-all duration-150">
                                        {{ $label }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('status')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Danger Zone --}}
                    @can('delete', $task)
                        <div class="rounded-xl border border-red-200 bg-red-50 p-5">
                            <p class="text-sm font-semibold text-red-700 mb-1">Danger Zone</p>
                            <p class="text-xs text-red-500 mb-3">Deleting a task is permanent and cannot be undone.</p>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                                  onsubmit="return confirm('Are you sure you want to permanently delete this task?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-red-600 border border-red-300 text-sm font-semibold rounded-lg hover:bg-red-100 transition duration-150">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete this task
                                </button>
                            </form>
                        </div>
                    @endcan

                    {{-- Actions --}}
                    <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100">
                        <a href="{{ route('tasks.show', $task) }}"
                           class="px-5 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition duration-150">
                            Cancel
                        </a>
                        <button type="submit" id="save-task-btn"
                                class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl shadow hover:bg-indigo-700 active:scale-95 transition-all duration-150">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function editTaskForm() {
            return {
                members: [],
                currentAssignee: {{ old('user_id', $task->user_id) ?? 'null' }},
                projectsData: {},

                init() {
                    document.querySelectorAll('#project_id option[data-members]').forEach(opt => {
                        try { this.projectsData[opt.value] = JSON.parse(opt.dataset.members); } catch(e) {}
                    });
                    const selectedId = document.getElementById('project_id').value;
                    if (selectedId && this.projectsData[selectedId]) {
                        this.members = this.projectsData[selectedId];
                    }
                },

                onProjectChange(event) {
                    const id = event.target.value;
                    this.members = this.projectsData[id] ?? [];
                    this.currentAssignee = null;
                }
            }
        }
    </script>
</x-app-layout>
