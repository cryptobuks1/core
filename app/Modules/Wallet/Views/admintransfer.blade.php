@extends('master')

@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
@endsection
@section('js')
    <script src="{{ asset('adminlte/plugins/select2/select2.full.min.js') }}"></script>

@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')
                <div class="card">

                    <div class="card-header" style="border-bottom: 0">
                        <h3 class="card-title">Nạp rút tiền ví thành viên</h3>
                    </div>

                    <div class="card-body p-0">
                        <form action="" method="POST" >
                            <div class="card-body row">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Thông tin giao dịch</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Loại giao dịch:</td>
                                            <td><label class="radio-inline"><input type="radio" name="transfer" value ="deposit" checked>Nạp tiền</label>   <label class="radio-inline"><input type="radio" name="transfer" value ="withdraw">Rút tiền</label></td>
                                    </tr>
                                    <tr>
                                        <td>Tên tài khoản:</td>
                                        <td><input id="get-wallet-input" type="input" placeholder="Nhập Email hoặc số điện thoại" class="form-control getWalletAjax" data-key="fixed_fees" data-group="fixed_fees"  name="account" value="" /></td>
                                    </tr>

                                    <tr>
                                        <td>Số Ví:</td>
                                        <td><select id="wallet-num" class="form-control getWalletAjax">



                                            </select>
                                            <i>Số dư hiện tại: <b>1.000.000 VND</b>. Trạng thái ví: <b>Hoạt động</b></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Số tiền giao dịch:</td>
                                            <td><input type="input" class="form-control" name="amount" value="" /></td>
                                    </tr>
                                    <tr>
                                        <td>Phí:</td>
                                        <td>0 VND + 0% <br/> Số tiền gồm phí: <b>1.000.000 đ</b></td>
                                    </tr>
                                    <tr>
                                        <td>Ghi chú:</td>
                                        <td>
                                            <textarea name="description" id="description" class="form-control" placeholder="Description"></textarea>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>

                                                <button type="submit" class="btn btn-primary">Thực hiện</button>

                                        </td>
                                    </tr>
                                    </tbody>
                                </table>



                            </div>
                            <!-- /.card-body -->
                            {!! csrf_field() !!}




                        </form>


                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
    <script type="text/javascript">
        $(document).ready(function(){
            $("#get-wallet-input").on('change', function(e){
                ele = $(this);
                $.ajax({
                    url: "{{ url('/').'/'.$backendUrl.'/wallet-getnumber' }}",
                    type : "post",
                    data : {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        wallet : ele.val(),
                    },
                    success:function(data) {
                        data = $.parseJSON(data)
                        if(data.error==''){
                            $('#wallet-num').html(data.html);
                        }
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $(".walletFeesAjax").on('input propertychange change', function(){
                $.ajax({
                    url: "{{ url('/').'/'.$backendUrl.'/wallet-fees' }}",
                    type : "post",
                    dataType:"text",
                    data : {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        val : $(this).val(),
                        group : $(this).attr('data-group'),
                        key: $(this).attr('data-key')
                    },
                    success:function(data) {
                        console.log(data);
                    }
                }).done(function() {

                });
            });
        });
    </script>
@endsection
