@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div>
                <h1>{{ $project->title }}</h1>
                <p> {{ $project->description }} </p>
            </div>
        </div>
    </div>
@endsection
