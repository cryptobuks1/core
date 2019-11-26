@extends('frontend.'.$current_theme.'.common')
@section('breadcrumbs', Breadcrumbs::render('localbank'))

@section('content')
    @theme_include('errors.errors')

    <script type="text/javascript">
        setInterval("my_function();", 5000);
        function my_function() {
            $('#refresh').load(location.href + ' #status');
        }
    </script>
    <script src="{{ asset('adminlte/js/clipboard.min.js') }}"></script>
    <script>
        var clipboard = new ClipboardJS('.copyaccnum');

        clipboard.on('success', function (e) {
            console.log(e);

        });

        clipboard.on('error', function (e) {
            console.log(e);
        });
    </script>

    <script>
        var clipboard = new ClipboardJS('.copyamount');

        clipboard.on('success', function (e) {
            console.log(e);

        });

        clipboard.on('error', function (e) {
            console.log(e);
        });
    </script>

    <script>
        var clipboard = new ClipboardJS('.copymes');

        clipboard.on('success', function (e) {
            console.log(e);

        });

        clipboard.on('error', function (e) {
            console.log(e);
        });
    </script>

    <h4><span class="text-uppercase">CHUYỂN TIỀN BẰNG VIETCOMBANK INTERNET BANKING</span></h4>
    <section class="">

        <table class="table">
            <tbody>
            <tr>
                <td width="30%">Mã đơn hàng:</td>
                <td><strong class="text-success">{{$order->order_code}}</strong>
                </td>
            </tr>
            <tr>
                <td width="30%">Ngân hàng:</td>
                <td><b>Ngân hàng ngoại thương Việt Nam (Vietcombank)</b>
                </td>
            </tr>
            <tr>
                <td width="30%">Số tài khoản:</td>
                <td><b>{{$adminbank->account_number}}</b>
                    <button class="copyaccnum btn btn-light btn-sm"
                            data-clipboard-text="{{ $adminbank->account_number }}">Copy
                    </button>
                </td>
            </tr>
            <tr>
                <td width="30%">Chủ tài khoản:</td>
                <td><b>{{$adminbank->account_name}}</b>
                </td>
            </tr>
            <tr>
                <td>Số tiền:</td>
                <td><b>{{ number_format($order->pay_amount) }} {{ $order->currency_code }}</b>
                    <button class="copyamount btn btn-light btn-sm"
                            data-clipboard-text="{{ number_format($order->pay_amount, 0)}}">Copy
                    </button>
                </td>
            </tr>
            <tr>
                <td>Nội dung chuyển khoản:</td>
                <td><b>{{ $order->description }}</b>
                    <button class="copymes btn btn-light btn-sm"
                            data-clipboard-text="{{ $order->order_code }}++CAN_THAN_LUA_DAO++GOI:{{$phone}}">Copy
                    </button>
                </td>
            </tr>

            <tr>
                <td>Trạng thái:</td>
                <td>
                    <div id="refresh">
                        <div id="status">

                        @if($order->status == 'completed')
                            <span class="label label-success">HOÀN THÀNH</span>
                        @elseif($order->status == 'pending')
                            <span class="label label-warning">CHỜ XỬ LÝ</span>
                        @elseif($order->status == 'none')
                            <span class="label label-default">CHỜ THANH TOÁN</span>
                        @elseif($order->status == 'canceled')
                            <span class="label label-danger">ĐÃ HỦY</span>
                        @else
                            <span class="label label-default">CHƯA RÕ</span>
                        @endif
                    </div>
                    </div>
                </td>
            </tr>

            <tr>
                <td>Lưu ý:</td>
                <td><i class="text-danger">BẠN HÃY COPY CHÍNH XÁC SỐ TIỀN VÀ NỘI DUNG THANH TOÁN ĐỂ GIAO DỊCH ĐƯỢC THỰC
                        HIỆN TỰ ĐỘNG 24/24!</i><br>
                    <span class="text-danger">Vui lòng sử dụng tài khoản Internet Banking của Vietcombank để chuyển khoản. Thời gian bạn thực hiện chuyển khoản tối đa là 15 phút. Quá thời gian quy định hệ thống sẽ không xác nhận tự động.</span><br>
                    <span class="text-danger">Nội dung chuyển khoản chúng tôi có khuyến cáo dòng chữ "CẨN THẬN LỪA ĐẢO" để đề phòng đối tượng xấu lợi dụng chiếm đoạt tài sản của bạn.</span><br>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="text-center">
            <a href="https://vietcombank.com.vn/IBanking2015/" target="_blank">
                <button class="btn btn-lg btn-warning">Nhấn vào đây để gửi tiền!</button>
            </a>
        </div>

    </section>
@endsection
