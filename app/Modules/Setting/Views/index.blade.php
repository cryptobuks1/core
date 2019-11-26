@extends('master')

@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
@endsection
@section('js')
    @include('ckfinder::setup')
    <script src="{{ asset('adminlte/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/ckeditor4101/ckeditor.js') }}"></script>
    <script>
        $(function () {
            CKEDITOR.replace('globalpopup_mes', {
                filebrowserBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
                filebrowserImageBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
                filebrowserFlashBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
            });
            CKEDITOR.config.extraPlugins = 'justify , colorbutton';

        });
    </script>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')


                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa fa-cogs"></i>
                            Danh sách cấu hình
                        </h3>
                    </div>
                    <div class="card-body">

                        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Tổng quan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-users-tab" data-toggle="pill" href="#custom-content-below-users" role="tab" aria-controls="custom-content-below-users" aria-selected="false">Người dùng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-security-tab" data-toggle="pill" href="#custom-content-below-security" role="tab" aria-controls="custom-content-below-security" aria-selected="false">Bảo mật</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-settings-tab" data-toggle="pill" href="#custom-content-below-settings" role="tab" aria-controls="custom-content-below-settings" aria-selected="false">Kết nối</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-design-tab" data-toggle="pill" href="#custom-content-below-design" role="tab" aria-controls="custom-content-below-design" aria-selected="false">Thiết kế</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="custom-content-below-tabContent" style="padding-top: 25px">
                            <div class="tab-pane fade active show" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                                @include('backend.config.general')
                            </div>
                            <div class="tab-pane fade" id="custom-content-below-users" role="tabpanel" aria-labelledby="custom-content-below-users-tab">
                                @include('backend.config.user')
                            </div>
                            <div class="tab-pane fade" id="custom-content-below-security" role="tabpanel" aria-labelledby="custom-content-below-security-tab">
                                @include('backend.config.security')
                            </div>
                            <div class="tab-pane fade" id="custom-content-below-settings" role="tabpanel" aria-labelledby="custom-content-below-settings-tab">
                                @include('backend.config.connection')
                            </div>
                            <div class="tab-pane fade" id="custom-content-below-design" role="tabpanel" aria-labelledby="custom-content-below-design-tab">
                                @include('backend.config.design')
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
