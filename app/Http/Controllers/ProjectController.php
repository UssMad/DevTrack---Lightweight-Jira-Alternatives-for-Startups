<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Requests\AddMemberRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class ProjectController extends Controller
{
     use AuthorizesRequests;
   public function index()
{
    $this->authorize('viewAny', Project::class);

    $projects = auth()->user()
        ->projects()
        ->with('users', 'tasks')
        ->get();

    return view('projects.index', compact('projects'));
}
    public function create(){
        $this->authorize('create',Project::class);
        return view ('projects.create');
    }
   public function store(StoreProjectRequest $request)
{
    $this->authorize('create', Project::class);

    $project = Project::create([
        'title' => $request->title,
        'description' => $request->description,
        'deadline' => $request->deadline,
    ]);

    $project->users()->attach(auth()->id(), [
        'role' => 'lead'
    ]);

    return redirect()->route('projects.index');
}    public function show (Project $project){
        $this->authorize('view',$project);
        return view ('projects.show',compact('project'));

    }
     public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }
    public function update(UpdateProjectRequest $request ,Project $project){
          $this->authorize('update',$project);
          $project->update($request->validate([
            'title'=>'required',
            'description'=>'nullable',
            'deadline'=>'nullable| date'
          ]));
          return redirect()->route('projects.index');

    }
    public function destroy(Project $project){
        $this->authorize('delete',$project);
        $project->delete();
        return redirect()->route('projects.index');
    }
    public function archives(){
        $projects = Project::onlyTrashed()->get();

        return view('projects.archives', compact('projects'));
   
    }
     public function restore($id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $project);

        $project->restore();

        return redirect()->route('projects.index');
    }

    public function forceDelete($id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $project);
        $project->forceDelete();
        return redirect()->route('projects.archives')->with('success', 'Project permanently deleted.');
    }
    public function addMember(AddMemberRequest $request ,Project $project){
         $this->authorize('update', $project);

    

    $user = User::where('email', $request->email)->firstOrFail();

    $project->users()->syncWithoutDetaching([
        $user->id => ['role' => 'developer']
    ]);

    return back();
    }
     public function removeMember(Project $project, User $user)
    {
        $this->authorize('update', $project);

        $project->users()->detach($user->id);

        return back();
    }


}