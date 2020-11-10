@extends('home')
@section('center')
    <div class="mvims" style="height:265px">
    @foreach($mvims as $mv)
<div class="mv text-center d-none">
<img src="{{asset('/storage/'.$mv->img)}}">
</div>
    @endforeach
    </div>
    <div class="news" style="height:265px;">
        <div class="text-center py-2 border-bottom my-1">最新消息區
            @isset($more)
        <a class="float-right" href="{{$more}}">More...</a>
        @endisset
        </div>
<ul class="list-group position-relative">
    @foreach($news as $key=>$new)
<li class="list-group-item list-gorup-action p-1 new">{{$key+1}}.{{mb_substr($new->text,0,10,'utf8')}}...
    <div class="border border-dark rounded-shadow text-white offset-4 w-75 bg-secondary text-5 position-absolute d-none"><pre class="text-white">{{$new->text}}</pre></div>
</li>
    @endforeach
</ul>

    </div>
@endsection