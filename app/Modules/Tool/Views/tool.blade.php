@extends('master')

@section('css')

@endsection
@section('js')

@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="col-md-12">
                    <!-- general form elements -->

                    @include('layouts.errors')

                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="card card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title">Xóa dữ liệu tẩy thẻ chậm</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    {!! Form::open(array('route' => 'tool.delete.charging','method'=>'POST')) !!}
                                    <div class="card-body row">
                                        <div class="col-md-12">

                                            <div class="form-group">
                                                <label for="charging_month">Chọn thời gian muốn xóa</label>
                                                <select class="form-control" name="charging_month" required>
                                                    <option value=""></option>
                                                    <option value="7d">Xóa những thẻ cũ hơn 7 ngày</option>
                                                    <option value="1m">Xóa những thẻ cũ hơn 1 tháng</option>
                                                    <option value="3m">Xóa những thẻ cũ hơn 3 tháng</option>
                                                    <option value="6m">Xóa những thẻ cũ hơn 6 tháng</option>
                                                    <option value="12m">Xóa những thẻ cũ hơn 12 tháng</option>
                                                </select>
                                            </div>
                                                <div>Nếu dữ liệu quá nhiều gây timeout, bạn có thể xóa làm nhiều lần.</div>

                                        </div>

                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Thực hiện</button>
                                    </div>
                                    {!! Form::close() !!}
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Xóa dữ liệu nạp cước</h3>
                                    </div>


                                    {!! Form::open(array('route' => 'tool.delete.mtopup','method'=>'POST')) !!}
                                    <div class="card-body row">
                                        <div class="col-md-12">

                                            <div class="form-group">
                                                <label for="mtopup_month">Chọn thời gian muốn xóa</label>
                                                <select class="form-control" name="mtopup_month" required>
                                                    <option value=""></option>
                                                    <option value="7d">Xóa nạp cước cũ hơn 7 ngày</option>
                                                    <option value="1m">Xóa nạp cước cũ hơn 1 tháng</option>
                                                    <option value="3m">Xóa nạp cước cũ hơn 3 tháng</option>
                                                    <option value="6m">Xóa nạp cước cũ hơn 6 tháng</option>
                                                    <option value="12m">Xóa nạp cước cũ hơn 12 tháng</option>
                                                </select>
                                            </div>
                                            <div>Nếu dữ liệu quá nhiều gây timeout, bạn có thể xóa làm nhiều lần.</div>

                                        </div>

                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Thực hiện</button>
                                    </div>
                                    {!! Form::close() !!}

                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">

                                <div class="card card-danger">
                                    <div class="card-header">
                                        <h3 class="card-title">Xóa dữ liệu tổng hợp (nguy hiểm)</h3>
                                    </div>

                                    {!! Form::open(array('route' => 'tool.delete.order','method'=>'POST')) !!}
                                    <div class="card-body row">
                                        <div class="col-md-12">

                                            <div class="form-group">
                                                <label for="mtopup_month">Chọn thời gian muốn xóa</label>
                                                <select class="form-control" name="order_month" required>
                                                    <option value=""></option>
                                                    <option value="7d">Xóa đơn hàng cũ hơn 7 ngày</option>
                                                    <option value="1m">Xóa đơn hàng cũ hơn 1 tháng</option>
                                                    <option value="3m">Xóa đơn hàng cũ hơn 3 tháng</option>
                                                    <option value="6m">Xóa đơn hàng cũ hơn 6 tháng</option>
                                                    <option value="12m">Xóa đơn hàng cũ hơn 12 tháng</option>
                                                </select>
                                            </div>
                                            <div>Sẽ xóa: đơn hàng, giao dịch, nạp rút tiền, mua thẻ, tẩy thẻ, nạp cước, khớp...</div>

                                        </div>

                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Thực hiện</button>
                                    </div>
                                    {!! Form::close() !!}

                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="card card-dark">
                                    <div class="card-header">
                                        <h3 class="card-title">Xóa dữ liệu log</h3>
                                    </div>

                                    {!! Form::open(array('route' => 'tool.delete.trash','method'=>'POST')) !!}
                                    <div class="card-body row">
                                        <div class="col-md-12">

                                            <div class="form-group">
                                                <label for="trash_month">Chọn thời gian muốn xóa</label>
                                                <select class="form-control" name="trash_month" required>
                                                    <option value=""></option>
                                                    <option value="7d">Xóa đơn hàng cũ hơn 7 ngày</option>
                                                    <option value="1m">Xóa đơn hàng cũ hơn 1 tháng</option>
                                                    <option value="3m">Xóa đơn hàng cũ hơn 3 tháng</option>
                                                    <option value="6m">Xóa đơn hàng cũ hơn 6 tháng</option>
                                                    <option value="12m">Xóa đơn hàng cũ hơn 12 tháng</option>
                                                </select>
                                            </div>
                                            <div>Sẽ xóa các loại log: sms, log user...</div>

                                        </div>

                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Thực hiện</button>
                                    </div>
                                    {!! Form::close() !!}

                                </div>

                            </div>


                        </div>

                        <div class="row">

                            <div class="col-md-6">

                                <div class="card card-danger">
                                    <div class="card-header">
                                        <h3 class="card-title">Xóa dữ liệu thành viên (nguy hiểm)</h3>
                                    </div>

                                    {!! Form::open(array('route' => 'tool.delete.user','method'=>'POST')) !!}
                                    <div class="card-body row">
                                        <div class="col-md-12">

                                            <div class="form-group">
                                                <label for="trash_month">Nhập email hoặc phone của thành viên</label>
                                                <input name="user" class="form-control">

                                            </div>
                                            <div>Sẽ xóa cứng tất cả dữ liệu của 1 thành viên</div>

                                        </div>

                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Thực hiện</button>
                                    </div>
                                    {!! Form::close() !!}

                                </div>

                            </div>


                            <div class="col-md-6">
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">Sao lưu dữ liệu website</h3>
                                    </div>

                                    <div class="card-body row">

                                            <div>Dữ liệu website sẽ được lưu xuống máy của bạn để lưu trữ.</div>

                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <a href="{{route('database.export')}}" target="_blank"><button type="submit" class="btn btn-primary">Sao lưu</button></a>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>

                    <!-- /.card -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div>
        <!-- /.card -->
        </div>
        <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->



@endsection


