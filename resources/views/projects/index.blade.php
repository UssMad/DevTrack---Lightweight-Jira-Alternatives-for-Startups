<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Projects Dashboard
        </h2>
    </x-slot>

    <a href="{{ route('projects.create') }}"
       class="bg-blue-500 text-white px-4 py-2 rounded">
       + New Project
    </a>

    <div class="grid grid-cols-3 gap-6 mt-6">

        @foreach($projects as $project)

        <div class="bg-white p-5 rounded shadow">

            <h2 class="text-xl font-bold">
                {{ $project->title }}
            </h2>

            <p class="text-gray-500 mt-2">
                {{ $project->description }}
            </p>

            <!-- Tasks stats -->
            <div class="mt-4">
                <p>
                    📝 Tasks:
                    {{ $project->tasks->count() }}
                </p>
            </div>

            <!-- Progress bar -->
            <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                <div class="bg-green-500 h-2 rounded-full"
                     style="width: 60%">
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-4 flex gap-2">
                <!-- Team Members -->
<div class="flex -space-x-2 mt-4">

    @foreach($project->users as $user)

        <div
            class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center text-sm font-bold border-2 border-white"
            title="{{ $user->name }}"
        >
            {{ strtoupper(substr($user->name,0,1)) }}
        </div>

    @endforeach

</div>

                <a href="{{ route('projects.show', $project) }}"
                   class="text-blue-500">
                    View
                </a>

                <a href="{{ route('projects.edit', $project) }}"
                   class="text-yellow-500">
                    Edit
                </a>

            </div>

        </div>

        @endforeach

    </div>

</x-app-layout>