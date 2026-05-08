<x-app-layout>
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-h1 text-on-surface font-bold">Team Members</h1>
            <p class="text-body-md text-on-surface-variant mt-1">Manage your engineering team access and roles.</p>
        </div>
        <button onclick="document.getElementById('invite-modal').classList.toggle('hidden')"
                class="bg-primary-container text-on-primary-container hover:opacity-90 text-label-sm px-4 py-2 rounded-lg flex items-center gap-1.5 transition-opacity border border-white/10 shrink-0">
            <span class="material-symbols-outlined text-[18px]">person_add</span>
            Add Member
        </button>
    </div>

    {{-- Members Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($members as $member)
            <div class="bg-surface-container/50 border border-outline-variant/30 rounded-xl p-4 flex items-start gap-4 hover:bg-surface-container transition-colors group">
                {{-- Avatar --}}
                <div class="w-12 h-12 rounded-full bg-primary-container/20 border border-dt-primary/20 flex items-center justify-center text-lg font-bold text-dt-primary shrink-0">
                    {{ strtoupper(substr($member->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $member->name)[1] ?? '', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <h3 class="text-h3 text-on-surface truncate">{{ $member->name }}</h3>
                            <p class="font-mono text-code text-on-surface-variant truncate mt-1">{{ $member->email }}</p>
                        </div>
                        <button class="text-on-surface-variant opacity-0 group-hover:opacity-100 transition-opacity p-1 hover:text-on-surface">
                            <span class="material-symbols-outlined text-[20px]">more_vert</span>
                        </button>
                    </div>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @php
                            $role = $member->team_role ?? 'developer';
                            $roleColor = $role === 'lead'
                                ? 'bg-dt-primary/15 text-dt-primary border-dt-primary/20'
                                : 'bg-secondary/15 text-secondary border-secondary/20';
                        @endphp
                        <span class="{{ $roleColor }} border px-2 py-0.5 rounded-full text-[10px] uppercase tracking-wider flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full {{ $role === 'lead' ? 'bg-dt-primary' : 'bg-secondary' }}"></span>
                            {{ ucfirst($role) }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center py-20 text-center border border-dashed border-outline-variant/30 rounded-xl bg-surface-container-low/30">
                <div class="w-20 h-20 mb-6 rounded-full bg-surface-container flex items-center justify-center opacity-50">
                    <span class="material-symbols-outlined text-4xl text-on-surface-variant">group_off</span>
                </div>
                <h3 class="text-h2 text-on-surface font-semibold mb-2">No team members yet</h3>
                <p class="text-body-md text-on-surface-variant max-w-md">Create a project and add members to start collaborating.</p>
            </div>
        @endforelse
    </div>

    {{-- Invite Modal --}}
    <div id="invite-modal" class="hidden mt-12">
        <div class="p-1 rounded-xl bg-gradient-to-b from-white/10 to-transparent max-w-lg mx-auto">
            <div class="bg-surface-container-high rounded-lg p-6 border border-outline-variant/20 shadow-[0_20px_40px_rgba(0,0,0,0.4)] relative overflow-hidden">
                {{-- Decorative glow --}}
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-1/2 bg-dt-primary/5 blur-[40px] pointer-events-none"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-h2 text-on-surface">Invite New Member</h3>
                        <button onclick="document.getElementById('invite-modal').classList.add('hidden')" class="text-on-surface-variant hover:text-on-surface transition-colors">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                    <form method="POST" action="" id="invite-form" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-label-sm text-on-surface-variant mb-1">Email Address</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">mail</span>
                                <input id="invite-email" class="w-full devtrack-input rounded-lg py-2 pl-10 pr-4 text-on-surface text-body-md placeholder:text-on-surface-variant/50" placeholder="developer@company.com" type="email" name="email" required/>
                            </div>
                        </div>
                        <div>
                            <label class="block text-label-sm text-on-surface-variant mb-1">Project</label>
                            <div class="relative">
                                <select id="invite-project" class="w-full devtrack-input rounded-lg py-2 pl-3 pr-10 text-on-surface appearance-none text-body-md" name="project_id" required>
                                    <option value="">Select project...</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->title }}</option>
                                    @endforeach
                                </select>
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none text-[20px]">expand_more</span>
                            </div>
                        </div>
                        <div class="pt-2 flex justify-end gap-3">
                            <button type="button" onclick="document.getElementById('invite-modal').classList.add('hidden')" class="px-4 py-2 rounded-lg text-label-sm text-on-surface-variant hover:bg-surface-variant/50 border border-transparent hover:border-outline-variant/30 transition-all">
                                Cancel
                            </button>
                            <button type="submit" class="btn-primary-gradient text-white text-label-sm px-4 py-2 rounded-lg transition-opacity hover:opacity-90">
                                Send Invite
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Update form action when project is selected
        document.getElementById('invite-project')?.addEventListener('change', function() {
            const projectId = this.value;
            if (projectId) {
                document.getElementById('invite-form').action = '/projects/' + projectId + '/members';
            }
        });
    </script>
</x-app-layout>
