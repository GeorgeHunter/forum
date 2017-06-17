<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{ $reply->id }}" class="panel panel-default">
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
            <div v-if="editing">
                <div class="form-group">
                    <textarea v-model="body" class="form-control"></textarea>
                </div>
                <button class="btn btn-xs btn-primary" @click="update">Update</button>
                <button class="btn btn-xs btn-danger" @click="editing = false">Cancel</button>
            </div>
            <div v-else v-text="body"></div>
        </div>

        @can ('update', $reply)
            <div class="panel-footer level">
                <button class="btn btn-info btn-xs mr-1" @click="editing = true" :disabled="editing">Edit</button>
                <form method="POST" action="/replies/{{ $reply->id }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                </form>
            </div>
        @endcan
    </div>
</reply>