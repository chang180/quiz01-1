<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>校園科技大學校園資訊系統</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.2/tailwind.css' />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <div class="container mx-auto" id="app">
        <div class="header w-100" v-if="show">
            <router-link :to="'/'" :title="site.title.text"><img :src="site.title.img" class="w-100"></router-link>
        </div>
        <div class="main d-flex" style="height:568px;" v-if="show">
            <div class="menu col-3">
                <menus :menus="menus" :total="site.total"></menus>
            </div>
            <div class="main col-6">
                <marquee>@{{ site . ads }}</marquee>


                <router-view :mvims='mvims' name='mvim'></router-view>
                <router-view ></router-view>
            </div>
            <div class="right col-3">
                <login-btn :auth="auth"></login-btn>
                <images :images="images" title="校園映像"></images>
            </div>
        </div>
        <div class="footer w-100" v-if="show">
            <div class="bg-yellow-300 text-center" style="line-height:100px">@{{ site . bottom }}</div>
        </div>
    </div>

    <div id="modal"></div>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous">
    </script>
    <script src="{{ asset('./js/app.js') }}"></script>
</body>

</html>
