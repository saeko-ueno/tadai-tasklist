@extends('layouts.app')

@section('content')
    <div class="row">
        <aside class="col-xs-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $user->name }}</h3>
                </div>
                <div class="panel-body">
                <img class="media-object img-rounded img-responsive" src="{{ Gravatar::src($user->email, 500) }}" alt="">
                </div>
            </div>
        </aside>
        <div class="col-xs-8">
            
             @if (Auth::user()->id == $user->id)
                 
                {!! Form::open(['route' => 'tasks.store']) !!}
                  
                <div class='form-group'>
                    {!! Form::label('content', 'タスク:') !!}
                    {!! Form::text('content',null,['class'=>'form-control']) !!}
                </div>
    
                <div class='form-group'>
                    {!! Form::label('status','ステータス:')!!}
                    {!! Form::text('status',null,['class'=>'form-control'])!!}
                </div>
    
                    {!! Form::submit('投稿',['class'=>'btn btn-primary']) !!}

                {!! Form::close() !!}
            @endif
            @if (count($tasks) > 0)
                @include('tasks.tasks', ['tasks' => $tasks])
            @endif
        </div>
    </div>
@endsection