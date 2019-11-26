<table class="table table-bordered table-striped dataTable">
    <thead class="thead-dark">
    <tr>
        <th>STT</th>
        <th>Tên dịch vụ</th>
        <th>Đơn giá</th>
        <th class="text-center">Tổng</th>
    </tr>

    </thead>
    <tbody>
    @foreach($items as $key => $item)
        <tr>
            <td>{{ $key+1 }} </td>
            <td data-th="product"><strong>{{ $item->vip_name }}</strong></td>
            <td data-th="price">{{ number_format($item->price,0) }}</td>
            <td data-th="subtotal"
                class="text-center">{{ number_format($item->price,0)}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
