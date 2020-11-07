{{-- <input type="{{$type}}" name="{{$name}}" @isset($value) value="{{$value}}" @endisset> --}}
<input type="{{$type}}" name="{{$name}}" value="{{$value??''}}">