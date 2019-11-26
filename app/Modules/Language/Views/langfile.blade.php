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
                        <h3 class="card-title">Danh sách</h3>
                        <div class="pull-right"><a href="{{ url($backendUrl.'/language/import/'.$code) }}"><button class="btn btn-warning"><i title="Uninstall" class="ace-icon fa fa-refresh"></i> Cập nhật CSDL</button></a>
                        <a href="{{ url($backendUrl.'/language/reset/'.$code) }}"><button class="btn btn-danger"><i title="Uninstall" class="ace-icon fa fa-refresh"></i> Ghi đè CSDL</button></a></div>
                    </div>
                    <!-- /.card-header -->
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="stock" class="table table-bordered table-striped dataTable">
                                <thead>
                                <tr>
                                    <th>Tên file</th>
                                    <th>Ngôn ngữ</th>
                                    <th>Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($files) > 0)
                                    @foreach( $files as $file )
                                            <tr>
                                                <td>{{$file['basename']}}</td>
                                                <td>{{$file['code']}}</td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="{{ url($backendUrl.'/language/translate/'.$file['filename']) }}"><span class="btn btn-sm btn-warning"> <i
                                                                        title="Biên dịch"
                                                                        class="ace-icon fa fa-pencil bigger-130"></i></span></a>
                                                    </div>
                                                </td>
                                            </tr>
                                    @endforeach
                                @endif

                                </tbody>


                            </table>
                        </div>
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
