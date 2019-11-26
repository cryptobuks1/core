@extends('master')

@section('css')

@endsection

@section('js')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#datepicker" ).datepicker({
                dateFormat: 'dd-mm-yy',
                showButtonPanel: true
            });
            $( "#datepicker2" ).datepicker({
                dateFormat: 'dd-mm-yy',
                showButtonPanel: true
            });
        } );
    </script>

@endsection

@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')
                <div class="card table-responsive">
                    <!-- /.card-header -->

                    <div class="card-body" style="padding-top: 20px;">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <span class="text-danger">Tính từ 0h:00:00 đến thời điểm hiện tại {{ now() }}</span>
                                    <table id="example1" class="table table-bordered table-striped dataTable">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Số tiền</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                                <tr>
                                                    <td>Doanh số bán thẻ</td>
                                                    <td>-{{number_format($softcard)}}</td>
                                                </tr>

                                                <tr>
                                                    <td>Doanh số đổi thẻ cào</td>
                                                    <td>+{{number_format($charging)}}</td>
                                                </tr>

                                                <tr>
                                                    <td>Doanh số nạp cước</td>
                                                    <td>-{{number_format($mtopup)}}</td>
                                                </tr>

                                                <tr>
                                                    <td>Tổng số rút tiền từ ví</td>
                                                    <td>-{{number_format($withdraw)}}</td>
                                                </tr>

                                                <tr>
                                                    <td>Tổng số nạp tiền (gồm cả hoàn tiền)</td>
                                                    <td>+{{number_format($deposit)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Tổng số phí chuyển tiền</td>
                                                    <td>-{{number_format($fees)}}</td>
                                                </tr>


                                                <tr>
                                                    <td>Tổng số dư của khách hàng hiện tại</td>
                                                    <td><strong>{{number_format($cur_balance)}}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Biến động số dư của khách hàng</td>
                                                    <td><strong>{{number_format($softcard + $mtopup + $withdraw - $charging - $deposit + $fees)}}</strong></td>
                                                </tr>

                                                <tr>
                                                    <td>Tổng số dư của khách hàng lúc 0h:00:00</td>
                                                    <td><strong class="text-danger">{{number_format($cur_balance + $softcard + $mtopup + $withdraw - $charging - $deposit + $fees)}}</strong></td>
                                                </tr>
                                        </tbody>

                                    </table>

                                </div>
                            </div></div>

                    </div>

                    <!-- Delete form -->


                    <!-- End Delete form-->


                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection


