@extends('master')
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
                            <h3 class="card-title">Edit Webdata: {{ $webdata->key }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {!! Form::model($webdata, ['method' => 'PATCH','route' => ['webdata.update', $webdata->id]]) !!}
                        <div class="card-body row">
                            <div class="form-group col-md-4">
                                <label for="name">Module:</label>
                                <input name="module" type="text" class="form-control" id="module" placeholder="Enter module" value="{{ $webdata->module or old('module') }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="guard_name">Type:</label>
                                <input name="type" type="text" class="form-control" id="type" placeholder="Type" value="{{ $webdata->type or old('type') }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="guard_name">Key:</label>
                                <input name="key" type="text" class="form-control" id="key" placeholder="Key" value="{{ $webdata->key or old('key') }}">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="description">Description:</label>
                                <textarea name="description" class="form-control" id="description" placeholder="Description">{{ $webdata->description or old('description') }}</textarea>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary float-right">Submit</button>
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