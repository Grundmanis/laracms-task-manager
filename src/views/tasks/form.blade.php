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
    <form method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="project_id">Projects<span>*</span></label>
            <select class="form-control" name="project_id" id="project_id">
                @foreach($projects as $project)
                    <option @if(formValue($task ?? null, 'project_id') == $project->id) selected @endif value="{{ $project->id }}">
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="status">Status<span>*</span></label>
            <select class="form-control" name="status" id="status">
                <option @if($task->getStatus() == 'open') selected @endif value="open">Open</option>
                <option @if($task->getStatus() == 'working') selected @endif value="working">Working</option>
                <option @if($task->getStatus() == 'testing') selected @endif value="testing">Testing</option>
                <option @if($task->getStatus() == 'done') selected @endif value="done">Done</option>
            </select>

        </div>

        <div class="form-group">
            <label for="title">Title<span>*</span></label>
            <input value="{{ formValue($task ?? null, 'title') }}" name="title" class="form-control" id="title" placeholder="Task title">
        </div>

        <div class="form-group">
            <label for="description">Description<span>*</span></label>
            <textarea name="description" id="description" cols="30" rows="10">{{ formValue($task ?? null, 'description') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>

        <h3>History <small>Total time: {{ $task->getHours() }} {{ str_plural('hour', $task->getHours()) }} </small></h3>
        <table class="table table-striped">
            <tr>
                <thead>
                    <tr>

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
                            <td>{{ $history->status }}</td>
                            <td>{{ $history->minutes }}</td>
                            <td>{{ $history->user_id }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </tr>
        </table>
    </form>
@endsection
