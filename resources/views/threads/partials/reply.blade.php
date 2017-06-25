<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{ $reply->id }}" class="panel panel-default">
        <div class="panel-heading">
            <div class="level">
                <div class="flex">

                    <a href="{{ route('profile', $reply->owner) }}">{{ $reply->owner->name }}</a>
                    said {{ $reply->created_at->diffForHumans() }}
                </div>
                <div>
                    <favourite :reply="{{ $reply }}"></favourite>
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
                <button class="btn btn-danger btn-xs mr-1" @click="destroy">Delete</button>
            </div>
        @endcan
    </div>
</reply>