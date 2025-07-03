@extends('layout')

@section('content')
<h1>Tasks</h1>
<a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Create New Task</a>

@if($tasks->count())
    <table class="table">
    <thead>
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Description</th> {{-- ✅ Add this line --}}
            <th>Due Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
            <tr>
                <td>
                    @if($task->image)
                        <img src="{{ asset('storage/' . $task->image) }}" width="80" height="80">
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $task->title }}</td>
                <td>{{ $task->description ?? '-' }}</td> {{-- ✅ Show description --}}
                <td>{{ $task->due_date ?? '-' }}</td>
                <td>{{ $task->is_completed ? '✅ Completed' : '❌ Pending' }}</td>
                <td>
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete?')" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


@else
    <p>No tasks available.</p>
@endif
@endsection
