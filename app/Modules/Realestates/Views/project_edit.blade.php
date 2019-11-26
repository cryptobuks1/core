@extends('master')

@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker-bs3.css') }}">
    <style>
        #preview img{
            padding: 10px;
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

        $(document).ready(function(){
            $(".deleteClick").click(function(){
                var link = $(this).attr('link');
                var name = $(this).attr('name');
                $("#deleteForm").attr('action',link);
                $("#deleteMes").html("Delete : "+name+" ?");
            });
        });

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
                        {!! Form::model($data, ['method' => 'PATCH','route' => ['project.update', $data->id],'enctype' => 'multipart/form-data']) !!}

                            <div class="card-body row">
                                <div class="col-md-12" >
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="form_id">Tên dự án(<span class="red">*</span>):</label>
                                            <input type="text" required name="name" class="form-control" placeholder="Nhập tên nhóm dự án" value="{{$data->name}}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="group">Nhóm dự án:</label>
                                            <select name="group[]" id="group" class="form-control" multiple required>
                                                @foreach($group as $g_item)
                                                    <option value="{{$g_item->code}}"
                                                            @if(in_array($g_item->code, $data->group2)) selected @endif> {{$g_item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="city">Tỉnh/Thành(<span class="red">*</span>):</label>
                                            <select class="form-control" name="city" id="cities">
                                                <option value="">-- Chọn tỉnh/thành phố--</option>
                                            @foreach ($cities as $item)
                                                    <option value="{{$item->code}}" @if($item->code==$data->city)  selected @endif> {{$item->name_city}} </option>
                                            @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="province">Quận huyện(<span class="red">*</span>):</label>
                                            <select class="form-control" name="province" id="provinces">
                                                <option value="{{$data->province}}"> {{$data->province}} </option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="acreage">Tổng diện tích:</label>
                                            <input type="text"  name="acreage" class="form-control" placeholder="Nhập tổng diện tích" value="{{$data->acreage}}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="price">Giá:</label>
                                            <input type="text"  name="price" class="form-control" placeholder="Nhập tổng diện tích" value="{{$data->price}}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="address">Địa chỉ(<span class="red">*</span>):</label>
                                            <input type="text" required name="address" class="form-control" placeholder="Nhập địa chỉ"  value="{{$data->address}}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="investor">Chủ đầu tư:</label>
                                            <input type="text"  name="investor" class="form-control" placeholder="Nhập chủ đầu tư" value="{{$data->investor}}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="process">Tiến trình dự án:</label>
                                            <input type="text"  name="process" class="form-control" placeholder="Nhập tiến trình dự án" value="{{$data->process}}">
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
                                                    <img id="logo-icon" class="imgPreview" src="@if($data->image){{ url($data->image) }}@endif"/>
                                                    <input type="hidden" name="image" id="image" class="inputImg" value=""/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                                <label for="file_extension">Thêm ảnh:</label>
                                                <input type="file" multiple name="images[]" id="file-input" >
                                                <div id="preview" ></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Danh sách ảnh:</label>
                                            <table id="example1" class="table table-bordered table-striped dataTable">
                                                <tr style="text-align: center">
                                                    <th>file</th>
                                                    <th>xóa</th>
                                                </tr>
                                                @foreach($file as $file)
                                                    <tr>
                                                        <td><img src="@if(isset($file->img)){{asset('storage/avatar/'.$file->img)}} @endif" height="70" width="80"></td>
                                                        <td style="text-align: center"><a href="#" name="{{$file->img}}" link="{{ url($backendUrl.'/project/delete/file/'.$file->id) }}" class="deleteClick red id-btn-dialog2" data-toggle="modal" data-target="#deleteModal"> <i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>

                                            <div class="form-group">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Mô tả(<span class="red">*</span>):</label>
                                                <textarea name="description" id="content" class="form-control"
                                                          rows="30">{{ $data->description or old('description') }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label for="form_id">Trạng thái:</label>
                                            <select name="status" class="form-control">
                                                <option value="1" @if($data->status==1) selected @endif>Bật</option>
                                                <option value="0" @if($data->status==0) selected @endif>Tắt</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="form_id">Nổi bật:</label>
                                            <select name="featured" class="form-control">
                                                <option value="1" @if($data->featured==1) selected @endif>Nổi bật</option>
                                                <option value="0" @if($data->featured==0) selected @endif>Không nổi bật</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer form-group" >
                                    <input type="submit" class="btn btn-primary  " value="Cập nhật" >
                                    <a href="{{route('project.index')}}" class="btn btn-danger">Hủy</a>
                                </div>
                            </div>
                    @csrf

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
                    <div class="modal-footer ">

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
