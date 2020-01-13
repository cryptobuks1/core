@extends('master')

@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker-bs3.css') }}">
    <style>
        #preview img{
            padding: 10px;
        }
        .red{
            color: red;
        }
    </style>
@endsection
@section('js')
    @include('ckfinder::setup')
    <script src="{{ asset('adminlte/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/ckeditor4101/ckeditor.js') }}"></script>
    <script>
        $(function () {
            CKEDITOR.replace('content', {
                filebrowserBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
                filebrowserImageBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
                filebrowserFlashBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
            });
            CKEDITOR.config.extraPlugins = 'justify , colorbutton';
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#cities").on('change', (function(e){
            var city_code = $(this).val();
            $.ajax({
                type:'POST',
                url:'{{ route('ajax.cities') }}',
                data:{code:city_code},
                success:function(data){
                    $('#provinces').html(data);
                }
            });
        }));
        function previewImages() {
            var $preview = $('#preview').empty();
            if (this.files) $.each(this.files, readAndPreview);
            function readAndPreview(i, file) {
                if (!/\.(jpe?g|png|gif)$/i.test(file.name)){
                    return alert(file.name +" is not an image");
                } // else...
                var reader = new FileReader();
                $(reader).on("load", function() {
                    $preview.append($("<img/>", {src:this.result, height:170}));
                });
                reader.readAsDataURL(file);
            }
        }
        $('#file-input').on("change", previewImages);
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

                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Thêm nhóm dự án</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form  method="post" enctype='multipart/form-data' >
                            <div class="card-body row">
                                <div class="col-md-12" >
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="form_id">Tên dự án(<span class="red">*</span>):</label>
                                            <input type="text" required name="name" class="form-control" placeholder="Nhập tên nhóm dự án">
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label for="group">Nhóm dự án(<span class="red">*</span>):</label>
                                            <select name="group[]" id="group" class="form-control" multiple>
                                                @foreach($data as $item)
                                                    <option value="{{$item->code}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="city">Tỉnh/Thành(<span class="red">*</span>):</label>
                                            <select class="form-control" name="city" id="cities">
                                                <option value="">-- Chọn tỉnh/thành phố--</option>
                                            @foreach ($cities as $item)
                                                    <option value="{{$item->code}}"> {{$item->name_city}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="province">Quận huyện(<span class="red">*</span>):</label>
                                            <select class="form-control" name="province" id="provinces">
                                                <option value="">-- Chọn quận/uyện --</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="acreage">Tổng diện tích:</label>
                                            <input type="text"  name="acreage" class="form-control" placeholder="Nhập tổng diện tích">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="price">Giá:</label>
                                            <input type="text"  name="price" class="form-control" placeholder="Nhập tổng diện tích">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="address">Địa chỉ(<span class="red">*</span>):</label>
                                            <input type="text" required name="address" class="form-control" placeholder="Nhập địa chỉ">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="investor">Chủ đầu tư:</label>
                                            <input type="text"  name="investor" class="form-control" placeholder="Nhập chủ đầu tư">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="process">Tiến trình dự án:</label>
                                            <input type="text"  name="process" class="form-control" placeholder="Nhập tiến trình dự án">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="url">Ảnh đại diện(<span class="red">*</span>):</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <button type="button" class="btn btn-default"
                                                            onclick="selectFileWithCKFinder('image', 'logo-icon')">Chọn ảnh
                                                    </button>
                                                </div>
                                                <div class="col-md-6">
                                                    <img id="logo-icon" class="imgPreview" src="{{ old('image') }}"/>
                                                    <input type="hidden" name="image" id="image" class="inputImg" value="" required/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                                <label for="file_extension">Chọn ảnh:</label>
                                            <input type="file" multiple name="images[]" id="file-input" >
                                            <div id="preview" ></div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Mô tả(<span class="red">*</span>):</label>
                                                <textarea name="description" id="content" class="form-control"
                                                          rows="30">{{ old('description') }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label for="form_id">Trạng thái:</label>
                                            <select name="status" class="form-control">
                                                <option value="1">Bật</option>
                                                <option value="0">Tắt</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="form_id">Nổi bật:</label>
                                            <select name="featured" class="form-control">
                                                <option value="1">Bật</option>
                                                <option value="0">Tắt</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                    <div class="card-footer form-group" >
                                        <input type="submit" class="btn btn-primary " value="Thêm Mới" >
                                        <a href="{{route('project.index')}}" class="btn btn-danger">Hủy</a>
                                    </div>
                            </div>
                    @csrf
                </form>

                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="deleteForm" action="" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete File</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="deleteMes" class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Delete</button>
                    </div>
                    <input type="hidden" name="_method" value="delete" />
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
    <!-- End Delete form-->

@endsection
