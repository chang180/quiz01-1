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
        <div class="text-center py-2 border-bottom my-1">校園映像區@{{ wtf }} </div>
        <div class="up" @click="switchImg('up')"></div>
        <div class="img" v-for='img of images' v-show="img.show"><img :src="img.img" alt=""></div>
        <div class="down" @click="switchImg('down')"></div>
    </div>
@endsection

@section('script')
    <script>

        // $(".mv").eq(0).removeClass('d-none')
        // let mvNum = $(".mv").length
        // let now = 0
        // setInterval(() => {
        //     $(".mv").eq(now).addClass('d-none')
        //     now++
        //     if (now == mvNum) now = 0
        //     $(".mv").eq(now).removeClass('d-none')

        // }, 3000);

        const app = {
            data() {
                const adstr = '{{ $ads }}'
                const bottom = '{{ $bottom }}'
                const titleImg = "{{ asset('storage/' . $title->img) }}"
                const title = '{{ $title->text }}'
                const total = '{{ $total }}'
                const menus = JSON.parse('{!! $menus !!}')
                const images = JSON.parse('{!! $images !!}')
                const ip = 0
                const mvims = JSON.parse('{!! $mvims !!} ')
                const newss=JSON.parse('{!! $news !!}')
                const more='{{$more??''}}'
                return {
                    adstr,
                    title,
                    titleImg,
                    bottom,
                    total,
                    menus,
                    images,
                    ip,
                    mvims,
                    newss,
                    more
                }
            },
            methods: {
                switchImg(type) {
                    switch (type) {
                        case 'up':
                            this.ip = (this.ip > 0) ? --this.ip : this.ip

                            break
                        case 'down':
                            this.ip = (this.ip < this.images.length - 3) ? ++this.ip : this.ip

                            break
                    }
                    this.images.map((img, idx) => {
                        if (idx >= this.ip && idx <= this.ip + 2) {
                            img.show = true
                        } else {
                            img.show = false
                        }
                        return img
                    })
                }
            },
            mounted() {
                let m = 1
                setInterval(() => {
                    this.mvims.map((mv, idx) => {
                        mv.show = (idx == m) ? true : false
                        return mv
                    })
                    m = (m + 1) % this.mvims.length
                }, 3000);
            }
            // mounted(){
            //     this.switchImg('up')
            // }
        }
        Vue.createApp(app).mount('#app')

    </script>
@endsection
