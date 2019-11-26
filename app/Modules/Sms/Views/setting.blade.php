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

@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title">SMS đã cài đặt</h3>
                        <div class="float-right">
                            <a href="{{ url($backendUrl.'/sms') }}"><button class="btn btn-success"><i class="fa fa-plus-circle"></i> Lịch sử SMS</button></a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                        <div class="card-body" style="padding-top: 0;">
                            <div class="row table-responsive"><div class="col-sm-12">
                                    <table id="stock" class="table table-bordered table-striped dataTable">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>BrandName</th>
                                            <th>Provider</th>
                                            <th>Balance</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach( $listinstalled as $listin )
                                            <tr>

                                                <td>{{$listin->id}}</td>
                                                <td>{{$listin->name}}</td>
                                                <td>{{$listin->brandname}}</td>
                                                <td>{{$listin->provider}}</td>
                                                <td>{{$listin->balance}}</td>
                                                <td>
                                                    <div data-table="stockcards_setting" data-id="{{ $listin->id }}" data-col="status" class="Switch Round @if($listin->status == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                                                        <div class="Toggle" ></div>
                                                    </div>

                                                </td>

                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="{{ url($backendUrl.'/sms/provider/'.$listin->id.'/update') }}"> <i title="Sửa" class="ace-icon fa fa-pencil bigger-130"></i> </a>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>


                                    </table>
                                </div></div>

                        </div>

                    <!-- Delete form -->

                    <!-- End Delete form-->


                    <div class="card-header">
                        <h3 class="card-title">SMS chưa cài đặt</h3>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body" style="padding-top: 0;">
                        <div class="row"><div class="col-sm-12">
                                <table id="stock" class="table table-bordered table-striped dataTable">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên kho</th>
                                        <th>Mã</th>

                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach( $list_not_installed as $key => $list )
                                        <tr>

                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $list['name'] }}</td>
                                            <td>{{ $list['provider'] }}</td>



                                            <td>
                                                <div class="action-buttons">
                                                    <a href="{{ url($backendUrl.'/sms/install/'.$list['provider']) }}"><button type="button" class="btn btn-warning btn-sm">Cài đặt</button> </a>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>


                                </table>
                            </div></div>

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
@endsection
