@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>{{ $thread->title }}</h3></div>
                    <hr>

                    <div class="panel-body">
                        {{ $thread->body }}
                    </div>
                </div>
                <br>
                <div class="panel-heading float-right"><h4><a href="#">{{ $thread->creator->name }}</a> posted {{ $thread->created_at->diffForHumans() }}...</h4></div>
            </div>
        </div>
        <hr>
        <br>
        <div class="row">
            <div class="col-md-12">
                @foreach($thread->replies as $reply)
                    @include('reply')
                @endforeach
            </div>
        </div>
        @auth
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{ $thread->path() . '/replies' }}">
                    @csrf

                    <div class="form-group">
                            <textarea class="form-control" name="body" placeholder="Have something to say?"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary mb-2">Post</button>
                </form>
            </div>
        </div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion!</p>
                </div>
            </div>
        @endauth
    </div>

@endsection