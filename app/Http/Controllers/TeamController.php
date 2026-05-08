<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $projects = $user->projects()->with('users')->get();

        // Collect all unique team members across user's projects
        $members = collect();
        foreach ($projects as $project) {
            foreach ($project->users as $member) {
                if (!$members->contains('id', $member->id)) {
                    $member->team_role = $member->pivot->role;
                    $member->project_name = $project->title;
                    $members->push($member);
                }
            }
        }

        return view('team.index', compact('members', 'projects'));
    }
}
