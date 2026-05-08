<h1>Archived Projects</h1>

@foreach($projects as $project)
    <div>
        <h3>{{ $project->title }}</h3>

        <form method="POST" action="{{ route('projects.restore', $project->id) }}">
            @csrf
            <button>Restore</button>
        </form>
    </div>
@endforeach