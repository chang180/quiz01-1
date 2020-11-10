@extends('home')
@section('center')

    <h5 class="text-center py-2 border-bottom">更多最新消息</h5>
    <ul class="list-group position-relative mt-2">
        @foreach ($news as $key => $new)
        <li class="list-group-item list-gorup-item-action p-1 new">{{$key+1}}.{{mb_substr($new->text,0,20,'utf8')}}...
            <div class="border border-dark rounded-shadow text-white offset-4 w-75 bg-secondary text-5 position-absolute d-none" style="z-index:1"><pre class="text-white">{{$new->text}}</pre></div>
        </li>
        @endforeach
    </ul>
    {{$news->links()}}
@endsection
