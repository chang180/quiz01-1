@extends('home')
@section('center')
    <div class="mvims h-50">
            <div class="mv text-center" v-for="mv of mvims" v-show="mv.show">
                <img :src="mv.img" class="mx-auto">
            </div>
    </div>
    <div class="h-25">
        <div class="text-center py-2 border-bottom my-1">最新消息區
                <a class="float-right" :href="more" v-show="more">More...</a>
        </div>
        <ul class="list-group">
                <li class="list-group-item list-gorup-item-action p-1 new" v-for="news of newss" @mouseover="news.show=true" @mouseleave="news.show=false">
                    @{{ news.short }}
                    <div class="border border-dark rounded-shadow text-white offset-4 w-75 bg-secondary text-5 position-absolute"
                        style="z-index:1" v-show="news.show">
                        <pre class="text-white" v-html='news.text'></pre>
                    </div>
                </li>
        </ul>

    </div>
@endsection
