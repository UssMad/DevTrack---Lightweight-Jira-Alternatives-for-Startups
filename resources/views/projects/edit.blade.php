<h1>Edit Project</h1>

<form method="POST" action="{{ route('projects.update', $project) }}">
    @csrf
    @method('PUT')

    <input type="text" name="title" value="{{ $project->title }}"><br><br>

    <textarea name="description">{{ $project->description }}</textarea><br><br>

    <input type="date" name="deadline" value="{{ $project->deadline }}"><br><br>

    <button>Update</button>
</form>