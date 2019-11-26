<table class="table table-bordered table-striped dataTable">
    <thead class="thead-dark">
    <tr>
        <th>STT</th>
        <th>Tên dịch vụ</th>
        <th>Đơn giá</th>
        <th>SL</th>
        <th class="text-center">Tổng</th>
    </tr>

    </thead>
    <tbody>

    @foreach($items as $key => $item)
        <tr>
            <td>{{ $key+1 }} </td>
            <td data-th="product"><strong>{{ $item->product }} (-{{$item->discount}}%)</strong></td>
            <td data-th="price">{{$currency->symbol_left}}{{ number_format($item->price,$currency->decimal) }}{{$currency->symbol_right}}</td>
            <td data-th="qty">{{ $item->qty }}</td>
            <td data-th="subtotal"
                class="text-center">{{$currency->symbol_left}}{{ number_format($item->subtotal,$currency->decimal) }}{{$currency->symbol_right}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
