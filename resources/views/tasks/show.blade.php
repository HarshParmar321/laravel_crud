@extends('layout')

@section('content')
<h1>{{ $task->title }}</h1>

@if($task->image)
    <img src="{{ asset('storage/' . $task->image) }}" width="200" height="200">
@endif

<p><strong>Description:</strong> {{ $task->description }}</p>
<p><strong>Due Date:</strong> {{ $task->due_date ?? 'N/A' }}</p>
<p><strong>Status:</strong> {{ $task->is_completed ? '✅ Completed' : '❌ Pending' }}</p>

<a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back</a>
@endsection
