@extends('master')

@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap4.css') }}">
@endsection

@section('js')
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('adminlte/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('adminlte/plugins/fastclick/fastclick.js') }}"></script>

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

                    <div class="card-header" style="border-bottom: 0">
                        <div class="card-tools " style="float: left;position: relative;right: 0px;left: 0px;">
                            <div class="input-group input-group-sm dataTables_filter" style="">
                                <form action="" name="formSearch" method="GET" >
                                    <div class="input-group">
                                        <select name="service_code" class="form-control" style="">
                                            <option value="" @if(app("request")->input("service_code")=="") selected="selected" @endif>Loại thẻ</option>
                                            @if(count($servicecodes))
                                            @foreach($servicecodes as $servicecode)
                                            <option value="{{$servicecode->service_code}}" @if(app("request")->input("service_code")==$servicecode->service_code) selected="selected" @endif>{{$servicecode->service_code}}</option>
                                                @endforeach
                                                @endif
                                        </select>

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i> Lọc</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="padding-top: 0;">
                        <div class="row"><div class="col-sm-12">
                                <div class="table-responsive">

                                    <table id="example1" class="table table-bordered table-striped dataTable">
                                        <thead>
                                        <tr>

                                            <th>ID</th>
                                            <th>Sản phẩm</th>
                                            <th>Mã dịch vụ</th>
                                            <th>Mệnh giá</th>
                                            <th>Số tồn</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach( $stocks as $stock )
                                            <tr>

                                                <td>{{ $stock->id }}</td>
                                                <td>{{ $stock->name }}</td>
                                                <td>{{ $stock->service_code }}</td>
                                                <td>{{ number_format($stock->value) }}</td>
                                                <td>@if($stock->available > 5) <div class="text-success"><strong>{{ number_format($stock->available) }}</strong></div>@else <div class="text-danger">{{ number_format($stock->available) }}</div> @endif</td>

                                            </tr>
                                        @endforeach

                                        </tbody>

                                    </table>

                                </div>
                            </div></div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="float-right" id="dynamic-table_paginate">
                                    {{$stocks->links()}}
                                </div>
                            </div>

                        </div>
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


