@extends('layouts.layout')

@section('main')
    <div class="menu col-3">
        <div class="text-center py-2 border-bottom my-1">主選單區</div>
        @isset($menus)
            <ul class="list-group text-center h-75">
                @foreach ($menus as $menu)
                    <li class="list-group-item list-group-action py-1 bg-warning menu">
                        <a href="{{ $menu->href }}">{{ $menu->text }}</a>
                        @isset($menu->subs)
                            <ul class="list-group subs d-none offset-4 w-100">
                                @foreach ($menu->subs as $sub)
                                    <li class="list-group-item list-group-action py-1 bg-success"><a class="text-white"
                                            href="{{ $sub->href }}">{{ $sub->text }}</a></li>
                                @endforeach
                            </ul>
                        @endisset
                    </li>
                @endforeach
            </ul>
        @endisset
        <div class="viewer text-center">
            進站総人数：{{ $total }}
        </div>
    </div>
    <div class="main col-6">
        <marquee>{{ $ads ?? '' }}</marquee>
        @yield("center")
    </div>
    <div class="right col-3">
        <button class="btn btn-primary py-3 w-100">管理登入</button>
        <div class="text-center py-2 border-bottom my-1">主選單區</div>
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

    </script>
@endsection
