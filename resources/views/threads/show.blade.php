@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $thread->title }}</div>

                    <div class="panel-body">
                        {{ $thread->body }}
                    </div>
                </div>
            </div>

            @foreach($thread->replies as $reply)

                <div class="col-md-7 col-md-offset-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">{{ $reply->owner->name }} said {{ $reply->created_at->diffForHumans() }}</div>

                        <div class="panel-body">
                            {{ $reply->body }}
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    </div>
@endsection