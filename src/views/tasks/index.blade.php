@extends('laracms.dashboard::layouts.app')

@section('content')
    <h1 class="page-header">Task Manager</h1>
    <div class="form-group">
        <a class="btn btn-success" href="{{ route('laracms.task.create') }}">Create</a>
    </div>

    <div class="form-group">
        <div class="form-inline">
            <form>
                <div class="form-group">
                    <label for="project">Project</label>
                    <select name="project_id" id="project" class="form-control">
                        <option value="">All</option>
                        @foreach(\Grundmanis\Laracms\Modules\TaskManager\Models\LaracmsTaskProject::all() as $project)
                            <option @if(request()->project_id == $project->id) selected @endif value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">All</option>
                        @foreach(\Grundmanis\Laracms\Modules\TaskManager\Models\LaracmsTask::getStatuses() as $key => $status)
                            <option @if(request()->status == $key) selected @endif value="{{ $key }}">
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                    <button class="btn-primary btn-sm">Filter</button>
                    <a href="{{ route('laracms.task') }}" class="btn-warning btn-sm">Reset</a>
                </div>
            </form>
        </div>
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
                    <th>Working</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>#</td>
                    <td>{{ $task->title }}</td>
                    <td><a href="{{ route('laracms.task.project.edit', $task->project->id) }}">{{ $task->project->name }}</a></td>
                    <td>{{ $task->getHours() }}</td>
                    <td>{{ \Grundmanis\Laracms\Modules\TaskManager\Models\LaracmsTask::getStatuses($task->getStatus()) }}</td>
                    <td>
                        <a href="{{ route('laracms.task.work', $task->id) }}">
                            @if ($task->getStatus() == 'in_progress')
                                Stop working
                            @else
                                Start working
                            @endif
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('laracms.task.edit', $task->id) }}">Edit</a>
                        |
                        <a onclick="return confirm('Are you sure?')" href="{{ route('laracms.task.destroy', $task->id) }}">Delete</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @if ($tasks->isEmpty())
            <p class="alert alert-info text-center">
                No tasks
            </p>
        @endif
    </div>
@endsection
