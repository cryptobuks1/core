<table id="cart" class="table table-hover table-condensed">
    <thead>
    <tr>
        <th>STT</th>
        <th>Tên dịch vụ</th>
        <th>Loại</th>
        <th>Cần nạp</th>
        <th class="text-center">Thành tiền</th>
    </tr>

    </thead>
    <tbody>

    @foreach($items as $key => $item)
        <tr>
            <td>{{$key+1}}</td>
            <td data-th="product">Nạp cước thuê bao<strong> {{ $item->phone_number }}</strong></td>
            <td data-th="price">{{ $item->service_code }}</td>
            <td data-th="price">{{ number_format($item->declared_value, $currency->decimal) }}đ</td>
            <td data-th="subtotal"
                class="text-center">{{$currency->symbol_left}}{{ number_format($item->amount, $currency->decimal) }}{{$currency->symbol_right}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="clearfix"></div>







