<div class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <div class="flex">
                {{ $heading }}
            </div>
            <div>
                {{ $extra }}
            </div>
        </div>
    </div>

    @if (!empty($body))
        <div class="panel-body">
            {{ $body }}
        </div>
    @endif
</div>