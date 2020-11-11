@extends('layouts.layout')

@section('main')
    @include('layouts.backend_sidebar')
    <div class="main col-9 p-0 d-flex flex-wrap align-items-start">
        <div class="col-8 border py-2 text-center">後台管理區</div>
        <a href="/logout"><button class="col-4 btn btn-light py-3 text-center border">管理登出</button></a>
        <div class="border w-100 p-1" style="height:500px;overflow:auto;">
            <h5 class="text-center border-bottom py-3">
                @if ($module !== 'Total' && $module !== 'Bottom')
                    <button class="btn btn-sm btn-primary float-left" id="addRow">新增</button>
                @endif


                {{ $header }}
            </h5>

            <table class="table border-none text-center">
                <tr>
                    @isset($cols)
                        @foreach ($cols as $col)
                            <td>{{ $col }}</td>
                        @endforeach
                    @endisset
                </tr>
                @isset($rows)
                    @foreach ($rows as $row)
                        <tr>
                            @foreach ($row as $item)
                                <td>
                                    @switch($item['tag'])
                                        @case('img')
                                        @include('layouts.img',$item)
                                        @break
                                        @case('embed')
                                        @include('layouts.embed',$item)
                                        @break
                                        @case('button')
                                        @include('layouts.button',$item)
                                        @break
                                        @default
                                        {!! nl2br($item['text']) !!}
                                    @endswitch
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                @endisset
                @if ($module == 'Total' || $module == 'Bottom')
                    <tr>
                        <td>{{ $col[0] }} </td>
                        <td>{{ $row[0]['text'] }} </td>
                        <td>@include('layouts.button',$row[1])</td>
                    </tr>
                @endif
                @isset($all)
                <td>
                    {{$all->links()}}
                </td>
                @endisset
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#addRow').on('click', function() {
            $.get("/modals/add{{$module}}/{{$menu_id??''}}", function(modal) {
                $("#modal").html(modal)
                $("#baseModal").modal("show")
                $("#baseModal").on("hidden.bs.modal", function() {
                    $("#baseModal").modal('dispose')
                    $("modal").html('')
                })
            })
        })

        $(".edit").on('click', function() {
            let id = $(this).data('id')
            $.get(`/modals/{{ strtolower($module) }}/${id}`, function(modal) {
                $("#modal").html(modal)
                $("#baseModal").modal("show")
                $("#baseModal").on("hidden.bs.modal", function() {
                    $("#baseModal").modal('dispose')
                    $("modal").html('')
                })
            })
        })

        $(".delete").on('click', function() {
            let id = $(this).data('id')
            let _this = $(this)
            $.ajax({
                type: 'delete',
                url: `/admin/{{ strtolower($module) }}/${id}`,
                success: function() {
                    _this.parents('tr').remove()
                },
            })
        })

        $(".show").on('click', function() {
            let id = $(this).data('id')
            let _this = $(this)
            $.ajax({
                type: 'patch',
                url: `/admin/{{ strtolower($module) }}/sh/${id}`,
                @if($module=='Title')
                success: function(img) {
                    
                    if (_this.text() == '顯示') {
                        $(".show").each((idx,dom)=>{
                            if($(dom).text=='隱藏'){
                                $(dom).text('顯示')
                                return false
                            }
                        })
                        _this.text('顯藏')
                    } else {
                        $(".show").text("隱藏")
                        _this.text('顯示')
                    }
                    $(".header img").attr("src","/storage/"+img);
                }

                @else
                success: function() {
                    // location.reload()
                    
                    if (_this.text() == '顯示') {
                        _this.text('顯藏')
                    } else {
                        _this.text('顯示')
                    }
                }
                @endif
            })
        })

        $(".sub").on('click', function() {
            let id = $(this).data('id')
            location.href = `/admin/submenu/${id}`
        })

    </script>
@endsection
