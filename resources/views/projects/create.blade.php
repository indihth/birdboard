@extends('layouts.app')

@section('content')
    <h1>Create Project</h1>

    <form method="POST" action="/projects">
        @csrf

        <div class="field">
            <label for="title" class="label">Title</label>


            <div class="control">
                <input type="text" class="input" name="title" placeholder="Title">
            </div>
        </div>

        <div class="field">
            <label for="description" class="label">Description</label>


            <div class="control">
                <textarea type="text" class="textarea" name="description" placeholder="Description">
                </textarea>
            </div>

            <div class="field">
                <div class="control">
                    <button type="submit" class="button">Submit</button>
                    <a href="/projects">Cancel</a>
                </div>
            </div>
    </form>
@endsection
