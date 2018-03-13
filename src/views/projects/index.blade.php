@extends('laracms.dashboard::layouts.app')

@section('content')
    <h1 class="page-header">Projects</h1>
    <div class="form-group">
        <a class="btn btn-success" href="{{ route('laracms.task.project.create') }}">Create</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Project</th>
                    <th>Employers</th>
                    <th>Unpaid time</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($projects as $project)
                <tr>
                    <td>#</td>
                    <td>{{ $project->name }}</td>
                    <td>
                        @foreach($project->employers as $employer)
                            <a href="{{ route('laracms.users.edit', $employer->id) }}">{{ $employer->email }}</a>
                        @endforeach
                    </td>
                    <td>0.00</td>
                    <td>
                        <a href="{{ route('laracms.task.project.edit', $project->id) }}">Edit</a>
                        |
                        <a onclick="return confirm('Are you sure?')" href="{{ route('laracms.task.project.destroy', $project->id) }}">Delete</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
