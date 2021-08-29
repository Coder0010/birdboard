@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @forelse ($projects as $project)
                <div>
                    <h1>{{ $project->title }}</h1>
                    <p> {{ $project->description }} </p>
                </div>
            @empty
                <div class="text-center alert alert-info col">
                    there is no data
                </div>
            @endforelse
        </div>
    </div>
@endsection
