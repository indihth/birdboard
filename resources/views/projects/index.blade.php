@extends('layouts.app')

@section('content')
    <div class="flex items-center mb-3">
        <a href="/projects/create">New project</a>
    </div>
    <ol>

        @forelse ($projects as $project)
            <li>
                <a href="{{ $project->path() }}">{{ $project->title }}</a>
            </li>

        @empty
            <li>No projects yet.</li>
        @endforelse
    </ol>
@endsection
