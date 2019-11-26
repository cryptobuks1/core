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

                    <div class="card-header">
                        <h3 class="card-title">Ngôn ngữ đã cài đặt</h3>
                    </div>
                    <!-- /.card-header -->
                        <div class="card-body" style="padding-top: 0;">
                            <div class="row"><div class="col-sm-12">
                                    <table id="stock" class="table table-bordered table-striped dataTable">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Ngôn ngữ</th>
                                            <th>Mã</th>
                                            <th>Cờ</th>
                                            <th>Mặc định</th>
                                            <th>Trạng thái</th>
                                            <th>Thứ tự</th>
                                            <th>Hành động</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach( $listinstalled as $listin )
                                            <tr>

                                                <td>{{$listin->id}}</td>
                                                <td>{{$listin->name}}</td>
                                                <td>{{$listin->code}}</td>
                                                <td><img src="{{ asset('images/lang/'.$listin->flag) }}"></td>
                                                <td>
                                                    <div data-table="languages" data-id="{{ $listin->id }}" data-col="default" class="Switch Round @if($listin->default == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                                                        <div class="Toggle" ></div>
                                                    </div>

                                                </td>

                                                <td>
                                                    <div data-table="languages" data-id="{{ $listin->id }}" data-col="status" class="Switch Round @if($listin->status == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                                                        <div class="Toggle" ></div>
                                                    </div>

                                                </td>
                                                <td>{{$listin->sort}}</td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="{{ url($backendUrl.'/language/'.$listin->id.'/update') }}"><span class="btn btn-sm btn-info"> <i title="Sửa" class="ace-icon fa fa-pencil bigger-130"></i> </span></a>
                                                        <a href="{{ url($backendUrl.'/language/uninstall/'.$listin->code) }}" class="red id-btn-dialog2"> <span class="btn btn-sm btn-danger"><i title="Uninstall" class="ace-icon fa fa-trash-o bigger-130"></i></span></a>
                                                        <a href="{{ url($backendUrl.'/language/files/'.$listin->code) }}"><span class="btn btn-sm btn-success"> <i title="Biên dịch" class="ace-icon fa fa-language bigger-130"></i> Dịch</span></a>
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
                        <h3 class="card-title">Chưa cài đặt</h3>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body" style="padding-top: 0;">
                        <div class="row"><div class="col-sm-12">
                                <table id="stock" class="table table-bordered table-striped dataTable">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên</th>
                                        <th>Mã</th>

                                        <th>Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach( $list_not_installed as $key => $list )
                                        <tr>

                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $list['name'] }}</td>
                                            <td>{{ $list['code'] }}</td>



                                            <td>
                                                <div class="action-buttons">
                                                    <a href="{{ url($backendUrl.'/language/install/'.$list['code']) }}"><button type="button" class="btn btn-warning btn-sm">Cài đặt</button> </a>

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
