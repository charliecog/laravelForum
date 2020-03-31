@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{ $thread->creator->name }}</a> posted:
                        {{ $thread->title }}
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>

                @foreach ($replies as $reply)
                    @include('threads.reply')
                @endforeach

                <div class="mt-3">
                    {{ $replies->links() }}
                </div>


                @if(auth()->check())
                    <div class="form-group mt-3">
                        <form method="POST" action="{{ $thread->path() . '/replies' }}" >
                            {{ csrf_field() }}
                            <textarea name="body" id="body" class="form-control" placeholder="Have something to say?" rows="5"></textarea>
                            <button type="submit" class="btn btn-dark mt-1">Post</button>
                        </form>
                    </div>
                @else
                    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> or <a href="{{ route('register') }}"> register</a> to participate in this discussion</p>
                @endif

            </div>

            <div class="col-md-4">

                <div class="card">
                    <div class="card-body">
                        <p>
                            This thread was published {{ $thread->created_at->diffForHumans() }}
                            by <a href="#">{{ $thread->creator->name }}</a>,
                            and currently has {{ $thread->replies_count }} {{ Str::plural('comment', $thread->replies_count) }}.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection