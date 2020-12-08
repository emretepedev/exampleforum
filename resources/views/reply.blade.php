<div class="panel panel-default">
    <div class="panel-body">
        {{ $reply->body }}
    </div>
    <div class="panel-heading float-right"><h4><a href="#">{{ $reply->owner->name }}</a> said {{ $reply->created_at->diffForHumans() }}...</h4></div>
</div>
<br>
<hr>