<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

{!! Form::model($withdraw, ['method' => 'POST','route' => ['ajax.withdraw.approve', $withdraw->id]]) !!}
    <div class="modal-header">
        <h5 class="modal-title" id="ModalTitle">Xử lý rút tiền</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div id="modalContent" class="modal-body table-responsive">
        <table class="table table-striped">
            <tbody><tr>
                <th>Mã đơn</th>
                <th>Khách hàng</th>
                <th>Số tiền rút</th>
                <th>Ngày lập</th>
                <th>TK nhận</th>
                <th>Thanh toán từ ví</th>
                <th>Trạng thái</th>
            </tr>
            <tr>
                <td>{{ $withdraw->id }}</td>
                <td><b>{{ App\User::find($withdraw->payer_id)->name }}</b><br>{{ App\User::find($withdraw->payer_id)->username }}</td>
                <td>{{ number_format($withdraw->net_amount) }} {{ $withdraw->currency_code }}</td>
                <td>{{ $withdraw->created_at }}</td>
                <td>{!!  $withdraw->payer_info  !!}</td>
                <td>

                    @if($withdraw->payment == 'paid')
                        <label class="badge badge-success">ĐÃ THANH TOÁN</label>
                    @elseif($withdraw->payment == 'unpaid')
                        <label class="badge badge-warning">CHƯA THANH TOÁN</label>
                    @elseif($withdraw->payment == 'none')
                        <label class="badge badge-dark">NHÁP</label>
                    @elseif($withdraw->payment == 'canceled')
                        <label class="badge badge-danger">HỦY BỎ</label>
                    @endif

                </td>
                <td>

                    @if($withdraw->status == 'completed')
                        <label class="badge badge-success">HOÀN THÀNH</label>
                    @elseif($withdraw->status == 'pending')
                        <label class="badge badge-warning">CHỜ XỬ LÝ</label>
                    @elseif($withdraw->status == 'none')
                        <label class="badge badge-dark">NHÁP</label>
                    @elseif($withdraw->status == 'canceled')
                        <label class="badge badge-danger">BỊ HỦY</label>
                    @endif


                </td>
            </tr>
            </tbody></table>
    </div>
    <div class="modal-footer1" style="padding: 0 15px; padding-bottom: 50px;">

        <div class="float-left">
            <button type="submit" name="submit" value="CANCEL" class="btn btn-danger" data-toggle="tooltip" title="Hủy đơn hàng và KHÔNG HOÀN TIỀN vào ví">Hủy không hoàn tiền</button>
            <button type="submit" name="submit" value="CANCELREFUND" class="btn btn-warning" data-toggle="tooltip" title="Hủy đơn hàng và hoàn tiền vào ví">Hủy và hoàn tiền</button>

        </div>
        <div class="float-right">
            <button type="submit" name="submit" value="COMPLETE" class="btn btn-success" data-toggle="tooltip" title="Bạn đã chắc chắn chuyển tiền cho khách hàng chưa?. Nhấn vào đây là hoàn thành đơn hàng này.">Hoàn thành đơn hàng</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
        </div>

    </div>
{!! Form::close() !!}
