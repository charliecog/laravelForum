<div class="card mt-3">
    <div class="card-header">
        <div class="level">
            <h6 class="flex">
                <a href="/profiles/{{$reply->owner->name}}">{{ $reply->owner->name }}</a> said {{ $reply->created_at->diffForHumans() }}...
            </h6>

            <div>
                <form method="post" action="/replies/{{ $reply->id }}/favourites">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-outline-primary" {{ $reply->isFavourited() ? 'disabled' : '' }}>
                        {{ $reply->favourites_count }} {{ Str::plural('Favourite', $reply->favourites_count) }}
                    </button>
                </form>
            </div>
        </div>

    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
