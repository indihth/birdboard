<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::all();

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        ///////////////////////////////////////////
        // Finds the ID from the route request /projects/{project}
        // findOrFail used to throw exception is nothing found
        // Not needed due to Route Model Binding above (Project $project)
        // 
        // $project = Project::findOrFail(request('project'));
        ///////////////////////////////////////////

        return view('projects.show', compact('project'));
    }

    public function store()
    {
        // validate
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        // persist - saved fully
        Project::create($attributes);

        // redirect
        return redirect('/projects');
    }
}
