@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="row">

                    <div class="col-md-12">
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

                    <div class="col-md-11 col-md-offset-1">
                        @foreach($replies as $reply)
                            @include('threads.partials.reply')
                        @endforeach

                        {{ $replies->links() }}

                        @if (auth()->check())
                            <form method="POST" action="/threads/{{ $thread->channel->slug }}/{{ $thread->id }}/replies">
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
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>This thread was created {{ $thread->created_at->diffForHumans() }} by
                            <a href="#">{{ $thread->creator->name }}</a> and currently has {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count ) }}.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection