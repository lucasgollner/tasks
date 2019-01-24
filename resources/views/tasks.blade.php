@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tasks</div>

                <div class="card-body">
                    
                    @if(count( $errors ) > 0)
                        <div class="alert alert-danger col-xs-12" role="alert">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif

                    @if(Session::has('success'))
                        <div class="alert alert-success col-xs-12" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    {{Form::open(array('route' => 'save','class' => 'form', 'method' => 'post'))}}
                            {{ Form::text('name',null, ["class"=>"form-control text-left", "placeholder"=>"Add new TASK"]) }}
                            {{ Form::date('date',null, ["class"=>"form-control text-left"]) }}
                            {{ Form::submit('save')}}
                    {{Form::close()}}

                    <hr>

                    Hey <b>{{ Auth::user()->name }}</b>, this is your todo list for today:

                    <br>

                    @if(\App\tasks::where('user', Auth::id())->count() == 0)
                        (empty)
                    @endif

                    @foreach($tasks as $k)
                        ({{ $k->date }}) - <a href="#subtask{{$k->id}}" data-toggle="modal" > {{ $k->name }} </a> <br>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>

@foreach(\App\tasks::where('user', Auth::id())->get() as $k)
<div class="modal fade" id="subtask{{$k->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">subtask</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                
            </div>
            <div class="modal-body" style="min-height: 450px;">
                    {{Form::open(array('route' => 'savesubtask','class' => 'form', 'method' => 'post'))}}
                    {{ Form::text('idtask', $k->id, ["class"=>"form-control text-left", 'readonly']) }}
                    {{ Form::text('nametask', $k->name, ["class"=>"form-control text-left", 'readonly']) }}

                    <hr>

                            {{ Form::text('name',null, ["class"=>"form-control text-left", "placeholder"=>"Add new SubTASK"]) }}
                            {{ Form::date('date',null, ["class"=>"form-control text-left"]) }}
                            {{ Form::submit('save')}}
                    {{Form::close()}}

                    <hr>

                    Subtasks: <br>

                    @if(\App\subtasks::where('idtasks', $k->id)->count() <= 0)
                        (empty)
                    @endif

                    @foreach(\App\subtasks::where('idtasks', $k->id)->orderBy('date','desc')->get() as $y)
                            ({{ $y->date }}) - {{ $y->name }} <br>
                    @endforeach

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection