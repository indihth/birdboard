@extends('layouts.app')

@section('content')
    <div class="flex items-center mb-3">
        <a href="/projects/create">New project</a>
    </div>

    <div class="flex">
        @forelse ($projects as $project) 
        <div class="bg-white mr-4 p-5 rounded shadow w-1/3" style="height:200px;">
            <h3 class="font-normal text-xl m-0 py-4">{{ $project->title }}</h3>
            {{-- <h3>{{ Illuminate\Support\Str::limit($project->title, 300) }}</h3> --}}
            
            <div class="text-grey">{{ Str::limit($project->description, 100) }}</div>
        </div>

        @empty

        <div class="">No projects yet.</div>

        @endforelse
    </div>
    {{-- <ul>
        @forelse ($projects as $project)
            <li>
                <a href="{{ $project->path() }}">{{ $project->title }}</a>
            </li>

        @empty
            <li>No projects yet.</li>
        @endforelse
    </ul> --}}
@endsection
