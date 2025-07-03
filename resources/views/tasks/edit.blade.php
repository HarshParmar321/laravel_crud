@extends('layout')

@section('content')
<h1>Edit Task</h1>

<form action="{{ route('tasks.update', $task) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $task->title) }}">
        @error('title') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control">{{ old('description', $task->description) }}</textarea>
    </div>

    <div class="mb-3">
        <label>Due Date</label>
        <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $task->due_date) }}">
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" name="is_completed" class="form-check-input" value="1" {{ old('is_completed', $task->is_completed) ? 'checked' : '' }}>
        <label class="form-check-label">Completed</label>
    </div>

    <div class="mb-3">
        <label>Image</label>
        <input type="file" name="image" class="form-control">

        @if($task->image)
            <p class="mt-2">Current Image:</p>
            <img src="{{ asset('storage/' . $task->image) }}" width="100" height="100">
        @endif
    </div>

    <button type="submit" class="btn btn-success">Update</button>
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
