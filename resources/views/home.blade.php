@extends('layouts.layout')

@section('main')
    <div class="menu col-3">
        <div class="text-center py-2 border-bottom my-1">主選單區</div>
        <ul class="list-group">
            <li class="list-group-item list-group-action py-1 bg-warning menu" v-for="menu of menus"
                @mouseover='menu.show=true' @mouseleave='menu.show=false'>
                <a :href="menu.href">
                    @{{ menu . text }}
                </a>
                <ul class="list-group subs offset-4 w-100" v-if="menu.subs.length>0" v-show="menu.show">
                    <li class="list-group-item list-group-action py-1 bg-success" v-for="sub of menu.subs">
                        <a class="text-white" :href="sub.href">@{{ sub . text }} </a>
                    </li>
                </ul>
            </li>
        </ul>

        <div class="viewer text-center">
            進站總人數：@{{ site.total }}
        </div>
    </div>
    <div class="main col-6">
        <marquee>@{{ site.ads }}</marquee>
        @yield("center")
    </div>
    <div class="right col-3">
        @guest
            <a href="/login" class="btn btn-primary py-3 w-100 my-2">管理登入</a>
        @endguest
        @auth
            <a href="/admin" class="btn btn-success py-3 w-100 my-2">返回管理({{ $user->acc }}) </a>
        @endauth
        <div class="text-center py-2 border-bottom my-1">校園映像區@{{ wtf }} </div>
        <div class="up" @click="switchImg('up')"></div>
        <div class="img" v-for='img of images.data' v-show="img.show"><img :src="img.img" class="mx-auto"></div>
        <div class="down" @click="switchImg('down')"></div>
    </div>
@endsection


