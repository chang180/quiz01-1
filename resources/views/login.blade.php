@extends('home')
@section('center')
@if(session('error'))
<div class="alert alert-danger w-50 mx-auto">{{session('error')}}</div>
@endif
   <form action="/login" method="post">
    @csrf
       <p class="text-center my-3">帳號<input class="border-bottom py-2" type="text" name="acc"></p>
       <p class="text-center my-3">密碼<input class="border-bottom py-2" type="text" name="pw"></p>
       <p class="text-center my-3"><button class="btn btn-primary mr-2">登入</button><button class="btn btn-warning" type="reset">重置</button></p>
   </form>
@endsection