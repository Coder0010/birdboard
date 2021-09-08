@extends ('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('projects.update', $project) }}">
            @csrf
            @method('patch')

            <h1 class="">Update a Project</h1>

            <div class="form-group">
                <label for="title">title</label>
                <input type="text" id="title" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $project->title }}">
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">description</label>
                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description">{{ $project->description }}</textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">Update Project</button>
                <a class="btn btn-primary" href="{{ route('projects.index') }}">Cancel</a>
            </div>
        </form>
    </div>
    @if ($errors->{ $bag ?? 'default' }->any())
        <ul class="field mt-6 list-reset">
            @foreach ($errors->{ $bag ?? 'default' }->all() as $error)
                <li class="text-sm text-red">{{ $error }}</li>
            @endforeach
        </ul>
    @endif
@endsection
