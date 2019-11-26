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
                        <h3 class="card-title">Thông tin kết nối</h3>
                        <div class="float-right">
                            <a href="{{ url($backendUrl.'/web/create') }}"><button class="btn btn-success"><i class="fa fa-plus-circle"></i> Kho liên kết</button></a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="padding-top: 0;">
                        <div class="row"><div class="col-sm-12">

                                {!! Form::model($driver, ['method' => 'PATCH','route' => ['sendmail-driver-update', $driver->id]]) !!}
                                <div class="card-body row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Tên:</label>
                                            <input name="name" type="text" class="form-control" id="name" placeholder="Tên" value="{{$driver->name}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="driver">Provider:</label>
                                            <input name="driver" type="text" class="form-control" id="driver" placeholder="Driver" value="{{$driver->driver}}" readonly="readonly">
                                        </div>

                                        @foreach($configitem as $key =>$conf)

                                        <div class="form-group">
                                            <label for="{{$key}}">{{$key}}:</label>
                                            <input name="configs[{{$key}}]" type="text" class="form-control" id="{{$key}}" value="{{$conf}}">
                                        </div>

                                        @endforeach

                                        <div class="form-group">
                                            <label for="status">Status:</label>
                                            <input name="status" id="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;" @if($driver->status == 1) checked="checked" @endif>
                                            <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                                                <div class="Toggle"></div>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                {!! Form::close() !!}

                            </div></div>

                    </div>
                </div>

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