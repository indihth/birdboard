<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        // Scopes to only projects belonging to the authenticated user - scope projects
        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        return view('projects.show', compact('project'));

        // /////////////////////////////////////////
        // Finds the ID from the route request /projects/{project} findOrFail used to throw exception is nothing found. Not needed due to Route Model Binding above (Project $project)
        // $project = Project::findOrFail(request('project'));
        // /////////////////////////////////////////
    }

    public function store()
    {

        // validate
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        // Sets the authenticated user as owner
        $attributes['owner_id'] = auth()->id();

        // Automatically set the owner_id to auth user with User Project model relationship
        auth()->user()->projects()->create($attributes);

        // redirect
        return redirect('/projects');
    }
}
