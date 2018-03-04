@extends('laracms.dashboard::layouts.app')

@section('content')
    <h1 class="page-header">Task Manager</h1>
    <div class="form-group">
        <a class="btn btn-success" href="{{ route('laracms.tasks.create') }}">Create</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Task</th>
                    <th>Project</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>#</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->project->name }}</td>
                    <td>Time</td>
                    <td>Status</td>
                    <td>
                        <a href="{{ route('laracms.tasks.edit', $task->id) }}">Edit</a>
                        |
                        <a onclick="return confirm('Are you sure?')" href="{{ route('laracms.tasks.destroy', $task->id) }}">Delete</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
