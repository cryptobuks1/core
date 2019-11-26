@extends('master')
@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
@endsection

@section('js')
    <script src="{{ asset('adminlte/plugins/select2/select2.full.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.select2').select2()
        });
    </script>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="col-md-12">
                    <!-- general form elements -->

                    @include('layouts.errors')

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Create Webdata:</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {!! Form::open(array('route' => 'webdata.store','method'=>'POST')) !!}
                        <div class="card-body row">
                            <div class="form-group col-md-4">
                                <label for="name">Module:</label>
                                <input name="module" type="text" class="form-control" id="module" placeholder="Enter Module" value="{{ old('module') }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="name">Type:</label>
                                <input name="type" type="text" class="form-control" id="type" placeholder="Enter Type" value="{{ old('type') }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="guard_name">Key:</label>
                                <input name="key" type="text" class="form-control" id="key" placeholder="Guard Key" value="{{ old('key') }}">
                            </div>
                            <div class="form-group col-md-12">
                                <label>Description:</label>
                                <textarea name="description" class="form-control" id="description" placeholder="Description">{{ old('description') }}</textarea>
                            </div>


                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        {!! Form::close() !!}
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