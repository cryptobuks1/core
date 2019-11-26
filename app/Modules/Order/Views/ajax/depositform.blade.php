<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

{!! Form::model($deposit, ['method' => 'POST','route' => ['ajax.deposit.approve', $deposit->id]]) !!}
    <div class="modal-header">
        <h5 class="modal-title" id="ModalTitle">Xử lý nạp tiền</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div id="modalContent" class="modal-body table-responsive">
        <table class="table table-striped">
            <tbody><tr>
                <th>Mã đơn</th>
                <th>Khách hàng</th>
                <th>Số tiền nạp</th>
                <th>Ngày lập</th>
                <th>Thanh toán</th>
                <th>Trạng thái</th>
            </tr>
            <tr>
                <td>{{ $deposit->id }}</td>
                <td><b>{{ App\User::find($deposit->payee_id)->name }}</b><br>{{ App\User::find($deposit->payee_id)->username }}</td>
                <td>{{ number_format($deposit->net_amount) }} {{ $deposit->currency_code }}</td>
                <td>{{ $deposit->created_at }}</td>
                <td>

                    @if($deposit->payment == 'paid')
                        <label class="badge badge-success">ĐÃ THANH TOÁN</label>
                    @elseif($deposit->payment == 'unpaid')
                        <label class="badge badge-warning">CHƯA THANH TOÁN</label>
                    @elseif($deposit->payment == 'none')
                        <label class="badge badge-dark">NHÁP</label>
                    @elseif($deposit->payment == 'canceled')
                        <label class="badge badge-danger">HỦY BỎ</label>
                    @endif
                    <br>{{ $deposit->paygate_code }}
                </td>
                <td>

                    @if($deposit->status == 'completed')
                        <label class="badge badge-success">HOÀN THÀNH</label>
                    @elseif($deposit->status == 'pending')
                        <label class="badge badge-warning">CHỜ XỬ LÝ</label>
                    @elseif($deposit->status == 'none')
                        <label class="badge badge-dark">NHÁP</label>
                    @elseif($deposit->status == 'canceled')
                        <label class="badge badge-danger">BỊ HỦY</label>
                    @endif


                </td>
            </tr>
            </tbody></table>
    </div>
    <div class="modal-footer1" style="padding: 0 15px; padding-bottom: 50px;">

        <div class="float-left">
            <button type="submit" name="submit" value="DELETE" class="btn btn-danger" data-toggle="tooltip" title="Xóa đơn hàng nạp tiền">Xóa đơn hàng</button>

        </div>
        <div class="float-right">
            <button type="submit" name="submit" value="COMPLETE" class="btn btn-success" data-toggle="tooltip" title="Bạn phải chắc đã nhận được tiền của khách gửi. Khách sẽ được cộng tiền vào ví trên web.">Hoàn thành đơn hàng</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
        </div>

    </div>
{!! Form::close() !!}
