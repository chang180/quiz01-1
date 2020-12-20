@extends('layouts.layout')

@section('main')
    <div class="menu col-3">
        <div class="text-center py-2 border-bottom my-1">主選單區</div>
        <ul class="list-group">
            <li class="list-group-item list-group-action py-1 bg-warning menu" v-for="menu of menus" @mouseover='menu.show=true' @mouseleave='menu.show=false'>
                <a :href="menu.href">
                    @{{ menu . text }}
                </a>
                <ul class="list-group subs offset-4 w-100" v-if="menu.subs.length>0" v-show="menu.show" >
                    <li class="list-group-item list-group-action py-1 bg-success" v-for="sub of menu.subs">
                        <a class="text-white" :href="sub.href">@{{ sub.text }} </a>
                    </li>
                </ul>
            </li>
        </ul>

        <div class="viewer text-center">
            進站總人數：@{{ total }}
        </div>
    </div>
    <div class="main col-6">
        <marquee>@{{ adstr }}</marquee>
        @yield("center")
    </div>
    <div class="right col-3">
        @guest
            <a href="/login" class="btn btn-primary py-3 w-100 my-2">管理登入</a>
        @endguest
        @auth
            <a href="/admin" class="btn btn-success py-3 w-100 my-2">返回管理({{ $user->acc }}) </a>
        @endauth
        <div class="text-center py-2 border-bottom my-1">主選單區@{{ wtf }} </div>
        <div class="up"></div>
        @isset($images)
            @foreach ($images as $img)
                <div class="img"><img src="{{ asset('storage/' . $img->img) }}" alt=""></div>
            @endforeach
        @endisset
        <div class="down"></div>
    </div>
@endsection

@section('script')
    <script>


        $(".new").hover(function() {
            $(this).children('.border').removeClass('d-none')
        }, function() {
            $(this).children('.border').addClass('d-none')
        })

        $(".menu").hover(function() {
            $(this).children(".subs").removeClass("d-none");
        }, function() {
            $(this).children(".subs").addClass("d-none");
        })

        let num = $(".img").length;
        let p = 0;
        $(".img").each((idx, dom) => {
            if (idx < 3) {
                $(dom).show()
            }
        })

        $(".up,.down").on("click", function() {
            $(".img").hide()
            switch ($(this).attr('class')) {
                case 'up':
                    p = (p > 0) ? --p : p
                    break;
                case 'down':
                    p = (p <= num - 3) ? ++p : p
                    break
            }
            $(".img").each((idx, dom) => {
                if (idx >= p && idx <= p + 2) {
                    $(dom).show()
                }
            })
        })

        $(".mv").eq(0).removeClass('d-none')
        let mvNum = $(".mv").length
        let now = 0
        setInterval(() => {
            $(".mv").eq(now).addClass('d-none')
            now++
            if (now == mvNum) now = 0
            $(".mv").eq(now).removeClass('d-none')

        }, 3000);

        const app = {
            data() {
                const adstr = '{{ $ads }}'
                const bottom = '{{ $bottom }}'
                const titleImg = "{{ asset('storage/' . $title->img) }}"
                const title = '{{ $title->text }}'
                const total = '{{ $total }}'
                const menus = JSON.parse('{!!  $menus !!}')
                return {
                    adstr,
                    title,
                    titleImg,
                    bottom,
                    total,
                    menus
                }
            }
        }
        Vue.createApp(app).mount('#app')     

    </script>
@endsection
