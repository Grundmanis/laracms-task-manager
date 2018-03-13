@extends('laracms.dashboard::layouts.app')

@section('styles')

    <!-- Include external CSS. -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">

    <!-- Include Editor style. -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.7.3/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.7.3/css/froala_style.min.css" rel="stylesheet" type="text/css" />

@endsection

@section('scripts')
    <!-- Include external JS libs. -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>

    <!-- Include Editor JS files. -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.7.3/js/froala_editor.pkgd.min.js"></script>

    <script> $(function() { $('textarea').froalaEditor() }); </script>
@endsection

@section('content')
    <div class="form-group">
        <a class="btn btn-success" href="{{ route('laracms.task.edit', $task->id) }}">Edit</a>
    </div>
    <form method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="project_id">Project</label>
            <p>
                <a href="{{ route('laracms.task.project.edit', $task->project->id) }}">{{ $task->project->name }}</a>
            </p>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <p>
                {{ \Grundmanis\Laracms\Modules\TaskManager\Models\LaracmsTask::getStatuses($task->status) }}
            </p>
        </div>

        <div class="form-group">
            <label for="title">Title</label>
            <p>
                {{ $task->title }}
            </p>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <p>
                {!! $task->description !!}
            </p>
        </div>

        @if(isset($task))
            <h3>History <small>Total time: {{ $task->getHours() }} {{ str_plural('hour', $task->getHours()) }} </small></h3>
            <table class="table table-striped">
            <tr>
                <thead>
                    <tr>
                        <th>
                            Date
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Minutes
                        </th>
                        <th>
                            User id
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($task->history as $history)
                        <tr>
                            <td>{{ $history->created_at }}</td>
                            <td>{{ $history->status }}</td>
                            <td>{{ $history->minutes }}</td>
                            <td>{{ $history->user_id }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </tr>
        </table>
        @endif
    </form>
@endsection
