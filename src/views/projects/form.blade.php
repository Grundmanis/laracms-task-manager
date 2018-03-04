@extends('laracms.dashboard::layouts.app')

@section('styles')
    <!-- Include external CSS. -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
@endsection

@section('scripts')
    <!-- Include external JS libs. -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>
@endsection

@section('content')
    <form method="post">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name">Name<span>*</span></label>
            <input value="{{ formValue($project ?? null, 'name') }}" name="name" class="form-control" id="name">
        </div>

        <div class="form-group">
            <label for="users">Employers</label>
            <select class="form-control" name="users[]" id="users" multiple>
                @foreach($users as $user)
                    <option @if(isset($project) && $project->employers->firstWhere('id', $user->id)) selected @endif value="{{ $user->id }}">{{ $user->id }} {{ $user->name }} {{ $user->email }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
