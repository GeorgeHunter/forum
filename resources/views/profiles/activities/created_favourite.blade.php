@component ('profiles.activities.activity')

    @slot ('heading')
        {{ $profileUser->name }} favourited a reply in <a href="{{ $activity->subject->favourited->path() }}">{{ $activity->subject->favourited->thread->title }}</a>
    @endslot

    @slot ('extra')
        {{ $activity->subject->created_at->diffForHumans() }}
    @endslot

    @slot ('body')
        {{ $activity->subject->favourited->body }}
    @endslot

@endcomponent