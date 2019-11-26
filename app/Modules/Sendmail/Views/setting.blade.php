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
                        <h3 class="card-title">Cấu hình mail hiện tại</h3>
                        <div class="float-right">
                            <a href="{{ url($backendUrl.'/webl/create') }}"><button class="btn btn-success"><i class="fa fa-plus-circle"></i> Quản lý gửi Email</button></a>
                        </div>
                    </div>


                    <div class="card-body" style="padding-top: 0;">
                        <div class="row"><div class="col-sm-12">

                                {!! Form::model($mailset, ['method' => 'PATCH','route' => ['sendmail-setting']]) !!}
                                <div class="card-body row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="from_email">Email gửi thư:</label>
                                            <input name="from_email" type="text" class="form-control" id="from_email" placeholder="Email" value="{{$mailset->from_email}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="from_name">Tên người gửi:</label>
                                            <input name="from_name" type="text" class="form-control" id="from_name" placeholder="Tên" value="{{$mailset->from_name}}">
                                        </div>

                                        <div class="form-group">
                                            <label for="driver">Hình thức gửi mail:</label>
                                            <select name="driver" class="form-control" id="driver">
                                                @foreach($driver as $list)
                                                <option value="{{$list->driver}}" @if($list->driver == $mailset->driver) selected @endif>{{$list->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>


                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Lưu cấu hình</button>
                                </div>
                                {!! Form::close() !!}

                            </div></div>

                    </div>





                    <div class="card-header">
                        <h3 class="card-title">Mail đã cài</h3>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="padding-top: 0;">
                        <div class="row"><div class="col-sm-12">
                                <table id="stock" class="table table-bordered table-striped dataTable">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên</th>
                                        <th>Driver</th>
                                         <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach( $listinstalled as $listin )
                                        <tr>

                                            <td>{{$listin->id}}</td>
                                            <td>{{$listin->name}}</td>
                                            <td>{{$listin->driver}}</td>

                                            <td>
                                                <div data-table="sendmail_driver" data-id="{{ $listin->id }}" data-col="status" class="Switch Round @if($listin->status == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                                                    <div class="Toggle" ></div>
                                                </div>

                                            </td>

                                            <td>
                                                <div class="action-buttons">
                                                    <a href="{{ url($backendUrl.'/sendmail/driver/'.$listin->id.'/update') }}"> <i title="Sửa" class="ace-icon fa fa-pencil bigger-130"></i> </a>

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
                        <h3 class="card-title">Mail chưa cài đặt</h3>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body" style="padding-top: 0;">
                        <div class="row"><div class="col-sm-12">
                                <table id="stock" class="table table-bordered table-striped dataTable">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên</th>
                                        <th>Driver</th>
                                        <th>Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach( $list_not_installed as $key => $list )
                                        <tr>

                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $list['name'] }}</td>
                                            <td>{{ $list['driver'] }}</td>



                                            <td>
                                                <div class="action-buttons">
                                                    <a href="{{ url($backendUrl.'/sendmail/install/'.$list['driver']) }}"><button type="button" class="btn btn-warning btn-sm">Cài đặt</button> </a>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>


                                </table>
                            </div></div>

                    </div>




                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection