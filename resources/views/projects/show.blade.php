<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $project->title }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-3 gap-4">

        <!-- TODO -->
        <div class="bg-gray-100 p-4 rounded">
            <h2 class="font-bold mb-3">🟡 To Do</h2>

            @foreach($project->tasks->where('status','todo') as $task)
                <div class="bg-white p-3 mb-2 rounded shadow">
                    {{ $task->title }}
                </div>
            @endforeach
        </div>

        <!-- IN PROGRESS -->
        <div class="bg-gray-100 p-4 rounded">
            <h2 class="font-bold mb-3">🔵 In Progress</h2>

            @foreach($project->tasks->where('status','in_progress') as $task)
                <div class="bg-white p-3 mb-2 rounded shadow">
                    {{ $task->title }}
                </div>
            @endforeach
        </div>

        <!-- DONE -->
        <div class="bg-gray-100 p-4 rounded">
            <h2 class="font-bold mb-3">🟢 Done</h2>

            @foreach($project->tasks->where('status','done') as $task)
                <div class="bg-white p-3 mb-2 rounded shadow">
                    {{ $task->title }}
                </div>
            @endforeach
        </div>

    </div>

   <h3 class="text-xl font-bold mt-8">Team Members</h3>

<div class="flex items-center gap-2 mt-3">

    @foreach($project->users as $user)

        <div class="relative group">

            <!-- Avatar -->
            <div
                class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold border-2 border-white"
            >
                {{ strtoupper(substr($user->name,0,1)) }}
            </div>

            <!-- Tooltip -->
            <div
                class="absolute hidden group-hover:block bg-black text-white text-xs rounded px-2 py-1 -top-8 left-1/2 -translate-x-1/2"
            >
                {{ $user->name }}
            </div>

        </div>

    @endforeach

</div>
  @if($user->pivot->role !== 'lead')

    <form
        action="{{ route('projects.members.remove', [$project, $user]) }}"
        method="POST"
    >
        @csrf
        @method('DELETE')

        <button
            type="submit"
            class="text-red-500 text-sm"
        >
            delet
        </button>

    </form>

    @endif


<!-- Add Member Form -->
@can('update', $project)
<form
    action="{{ route('projects.members.add', $project) }}"
    method="POST"
    class="mt-6 flex gap-2"
>
    @csrf

    <input
        type="email"
        name="email"
        placeholder="Enter member email"
        class="border rounded px-3 py-2 w-72"
        required
    >

    <button
        type="submit"
        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
    >
        Add Member
    </button>

</form>
@endcan

</x-app-layout>