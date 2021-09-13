@extends ('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('projects.store') }}">
            @csrf

            <h1 class="">Create a Project</h1>

            <div class="form-group">
                <label for="title">title</label>
                <input type="text" id="title" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old("title") }}">
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">description</label>
                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description">{{ old("description") }}</textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">Create Project</button>
                <a class="btn btn-primary" href="{{ route('projects.index') }}">Cancel</a>
            </div>
        </form>
    </div>
    @include ('errors')
@endsection
