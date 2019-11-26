<div class="table-responsive">
<table class="table table-bordered dataTable">
    <thead>
    <tr>
        <th>Mã giao dịch</th>
        <th>Trước GD</th>
        <th>Số tiền</th>
        <th>Sau GD</th>
        <th>Tiền tệ</th>
        <th>Ngày tạo</th>
        <th>Ghi chú</th>
        <th>Trạng thái</th>
    </tr>
    </thead>
    <tbody>

    @foreach( $list as $tran )
        <tr>
            <td>{{$tran->id}}</td>
            <td>{{number_format($tran->before_balance)}} {{$tran->currency_code}}</td>
            <td><span class="text-success"><b>{{$tran->operation}}{{number_format($tran->pay_amount)}} {{$tran->currency_code}}</b></span></td>
            <td>{{number_format($tran->after_balance)}} {{$tran->currency_code}}</td>
            <td>{{$tran->currency_code}}</td>
            <td>{{date('d-m-Y H:i', strtotime($tran->created_at))}}</td>
            <td>{{$tran->description}}</td>

            <td>
                <label class="badge badge-success">Hoàn thành</label>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
</div>
