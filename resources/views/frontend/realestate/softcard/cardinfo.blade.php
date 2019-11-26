<script src="{{ asset('adminlte/js/clipboard.min.js') }}"></script>

<script>
    var clipboard = new ClipboardJS('.copyrow');

    clipboard.on('success', function (e) {
        console.log(e);

    });

    clipboard.on('error', function (e) {
        console.log(e);
    });
</script>

<h4><span class="text-uppercase">Thông tin mã thẻ</span></h4>
<table class="table table-bordered">
    <thead>
    <tr>
        <th>#</th>
        <th>Tên sản phẩm</th>
        <th>Mã nạp</th>
        <th>Se-ri</th>
        <th>Hết hạn</th>
    </tr>
    </thead>
    <tbody>


    @php $all = [] @endphp
    @foreach($listcard as $key => $item)
        <tr>

            <td>{{$key + 1 }}</td>
            <td><h4>{{ $item->name }}</h4></td>
            <td>
                <h4>{{ $item->code }}
                    <button class="copyrow btn btn-secondary btn-xs"
                            data-clipboard-text="{{ $item->code }}"
                            data-toggle="tooltip" title="Copy">
                        <i class="fa fa-clone" aria-hidden="true"></i>
                    </button>
                </h4>
            </td>
            <td>
                <h4>{{ $item->serial }}
                    <button class="copyrow btn btn-secondary btn-xs" data-clipboard-text="{{ $item->serial }}"
                            data-toggle="tooltip" title="Copy">
                        <i class="fa fa-clone" aria-hidden="true"></i>
                    </button>
                </h4>
            </td>

            <td>
                <h4>{{ $item->expire }}
                </h4>
            </td>

            @php $all[] = 'Loại thẻ: '.$item->name. ' - Số Seri: '.$item->serial.' - Mã nạp: '.$item->code @endphp

        </tr>
    @endforeach


    </tbody>
</table>
<br>

<a href="{{route('frontend.softcard.success', $item->order_code )}}?export=excel"><button type="button" class="btn btn-success">Xuất Excel</button></a>
<a href="{{route('frontend.softcard.print', $item->order_code )}}"><button type="button" class="btn btn-info">In nhiệt</button></a>
<button type="button" class="copyrow btn btn-warning"
        data-clipboard-text="@foreach($all as $item){{$item}}&#13;&#10;@endforeach">Sao chép toàn bộ
</button>

<a href="{{route('page.softcard')}}">
<button class="btn btn-danger pull-right">Mua hàng tiếp</button>
    </a>