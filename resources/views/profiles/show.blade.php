@extends('layouts.app')

@section('content')


    <div class="page-header">
        <div class="container">
            <h1>{{ $profileUser->name }} <small>Since: {{ $profileUser->created_at->diffForHumans() }}</small></h1>
        </div>

    </div>

    <div class="container">
        @foreach($threads as $thread)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="level">
                        <div class="flex">
                            <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> posted:
                            {{ $thread->title }}
                        </div>
                        <div>
                            {{ $thread->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    {{ $thread->body }}
                </div>
            </div>
        @endforeach
        {{ $threads->links() }}
    </div>

@stop