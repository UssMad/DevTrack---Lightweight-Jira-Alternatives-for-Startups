<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('tasks.index') }}"
               class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ✏️ {{ __('Create New Task') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                {{-- Form Header --}}
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-8 py-6">
                    <h3 class="text-white font-bold text-lg">Task Details</h3>
                    <p class="text-indigo-100 text-sm mt-1">Fill in the information below to create a new task.</p>
                </div>

                <form method="POST" action="{{ route('tasks.store') }}" class="p-8 space-y-6" id="create-task-form">
                    @csrf

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
                               value="{{ old('title') }}"
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
                                  class="w-full rounded-xl border-gray-200 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500 resize-none @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Project & Assignee --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5"
                         x-data="taskForm()"
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
                                            {{ old('project_id') == $project->id ? 'selected' : '' }}>
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
                                            :selected="member.id == {{ old('user_id', 'null') }}"
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
                                               {{ old('priority', 'medium') === $value ? 'checked' : '' }}>
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
                                   value="{{ old('deadline') }}"
                                   required
                                   min="{{ now()->toDateString() }}"
                                   class="w-full rounded-xl border-gray-200 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500 @error('deadline') border-red-400 @enderror">
                            @error('deadline')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Initial Status <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-3">
                            @foreach(['todo' => '📋 To Do', 'in_progress' => '⚡ In Progress', 'done' => '✅ Done'] as $value => $label)
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="status" value="{{ $value }}"
                                           class="sr-only peer"
                                           {{ old('status', 'todo') === $value ? 'checked' : '' }}>
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

                    {{-- Actions --}}
                    <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100">
                        <a href="{{ route('tasks.index') }}"
                           class="px-5 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition duration-150">
                            Cancel
                        </a>
                        <button type="submit" id="submit-task-btn"
                                class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl shadow hover:bg-indigo-700 active:scale-95 transition-all duration-150">
                            Create Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function taskForm() {
            return {
                members: [],
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
                }
            }
        }
    </script>
</x-app-layout>
