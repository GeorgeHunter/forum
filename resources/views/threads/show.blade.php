@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="#">{{ $thread->creator->name }}</a> posted:
                        {{ $thread->title }}
                    </div>

                    <div class="panel-body">
                        {{ $thread->body }}
                    </div>
                </div>
            </div>

            <div class="col-md-7 col-md-offset-3">
                @foreach($thread->replies as $reply)
                    @include('threads.partials.reply')
                @endforeach
            </div>

            <div class="col-md-7 col-md-offset-3">
                @if (auth()->check())
                    <form method="POST" action="/threads/{{ $thread->id }}/replies">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="Have something to say?" rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Post</button>
                    </form>
                @else
                    <p>Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion</p>
                @endif
            </div>

        </div>
    </div>
@endsection