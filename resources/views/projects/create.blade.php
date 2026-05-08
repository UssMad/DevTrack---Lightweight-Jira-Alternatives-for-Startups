<h1>Create Project</h1>

<form method="POST" action="{{ route('projects.store') }}">
    @csrf

    <input type="text" name="title" placeholder="Title"><br><br>

    <textarea name="description" placeholder="Description"></textarea><br><br>

    <input type="date" name="deadline"><br><br>

    <button type="submit">Save</button>
</form>