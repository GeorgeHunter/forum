<div class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <div class="flex">

                <a href="{{ route('profile', $reply->owner) }}">{{ $reply->owner->name }}</a>
                said {{ $reply->created_at->diffForHumans() }}
            </div>
            <div>
                <form method="POST" action="/replies/{{ $reply->id }}/favourite">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-default" {{ $reply->isFavourited() ? 'disabled' : '' }}>{{ $reply->favourites_count }} {{ str_plural('Favourite', $reply->favourites_count) }}</button>
                </form>
            </div>
        </div>
    </div>

    <div class="panel-body">
        {{ $reply->body }}
    </div>
</div>