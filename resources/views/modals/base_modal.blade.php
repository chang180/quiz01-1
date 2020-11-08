<!-- Modal -->
<form action="{{ $action }}" method="post" enctype="multipart/form-data">
    @csrf
    @isset($method)
    @method($method)
    @endisset
    <div class="modal fade" id="baseModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="ModalCenter" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalCenter">{{ $modal_header }} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="m-auto">
                        @foreach ($modal_body as $row)
                            <tr>
                                <td class="text-right">{{ $row['label'] }}</td>
                                <td>
                                    @switch($row['tag'])
                                        @case('input')
                                        @include('layouts.input',$row)
                                        @break
                                        @case('img')
                                        @include('layouts.img',$row)
                                        @break
                                        @case('textarea')
                                        @break
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary">重置</button>
                    <button class="btn btn-primary">儲存</button>
                </div>
            </div>
        </div>
    </div>
</form>
