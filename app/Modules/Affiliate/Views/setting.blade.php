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
                @include('layouts.errors')
                <div class="card">

                    <div class="card-header" style="border-bottom: 0">
                        <h3 class="card-title">Tìm kiếm</h3>
                        <div class="card-tools " style="float: left;position: relative;right: 0px;left: 20px;">
                            <div class="input-group input-group-sm dataTables_filter" style="">
                                <form action="" name="formSearch" method="GET">
                                    <div class="input-group">
                                        <select name="type" class="form-control" style="">
                                            <option value="serial"
                                                    @if(app("request")->input("type")=="affiliate_code") selected="selected" @endif>
                                                Mã giới thiệu
                                            </option>
                                            <option value="code"
                                                    @if(app("request")->input("type")=="module") selected="selected" @endif>
                                                Theo mô-đun
                                            </option>
                                            <option value="email"
                                                    @if(app("request")->input("type")=="user_id") selected="selected" @endif>
                                                Theo User ID
                                            </option>
                                            <option value="phone"
                                                    @if(app("request")->input("type")=="order_code") selected="selected" @endif>
                                                Mã đơn hàng
                                            </option>
                                        </select>
                                        <input type="text" name="keyword" class="form-control"
                                               placeholder="Nhập vào đây"
                                               value="{{ app("request")->input("keyword") }}"/>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="float-right" style="">

                            <a href="{{ url($backendUrl.'/affiliates') }}">
                                <button class="btn btn-success"><i class="fa fa-list" aria-hidden="true"></i> Danh sách
                                </button>
                            </a>
                            <a href="{{ url($backendUrl.'/affiliates/setting') }}">
                                <button class="btn btn-primary"><i class="fa fa-cog"></i> Cấu hình</button>
                            </a>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body" style="padding-top: 0;">
                        <div class="row">
                            <div class="col-sm-12">
                                <form action="" class="" method="POST" enctype="multipart/form-data">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-striped ">
                                            <tbody>
                                            @if(isset($setting['active']))
                                            <tr>
                                                <td>Bật chức năng Affiliate</td>
                                                <td>
                                                    <select class="form-control" name="active">
                                                        <option value="on" @if($setting['active'] == 'on') selected @endif>Bật</option>
                                                        <option value="off" @if($setting['active'] == 'off') selected @endif>Tắt</option>
                                                    </select>

                                                </td>
                                            </tr>
                                            @endif
                                            @if(isset($setting['payout']))
                                            <tr>
                                                <td>Số ngày thanh toán kể từ lúc tạo</td>
                                                <td>
                                                    <input name="payout" class="form-control" value="{{$setting['payout'] or 7}}">
                                                </td>
                                            </tr>
                                            @endif
                                            </tbody>
                                        </table>

                                        <table class="table table-striped ">
                                            <tbody>
                                            @if(count($plugs) > 0)
                                                @foreach($plugs as $module => $val)
                                                    <tr>
                                                        <td>Mức huê hồng tính trên đơn hàng <strong>{{$module}}</strong></td>
                                                        <td>
                                                            @foreach($val as $type => $percent)
                                                                <label>{{$type}} (%)</label>
                                                                <input name="{{$module}}[{{$type}}]" class="form-control"
                                                                       value="{{$percent or 0}}">
                                                        </td>
                                                        <td>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                        <div class="input-group">
                                            <button class="btn btn-primary btn-lg">Lưu cấu hình</button>
                                        </div>
                                    </div>
                                    {!! csrf_field() !!}
                                </form>
                            </div>
                        </div>
                    </div>
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