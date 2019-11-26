@extends('master')

@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker-bs3.css') }}">

@endsection
@section('js')
    @include('ckfinder::setup')
    <script src="{{ asset('adminlte/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jQueryUI/jquery-ui.min.1.12.1.js') }}"></script>

    <script src="{{ asset('adminlte/plugins/ckeditor4101/ckeditor.js') }}"></script>
    <script>
        $(function() {
            CKEDITOR.replace( 'content', {
                filebrowserBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
                filebrowserImageBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
                filebrowserFlashBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
            } );
            CKEDITOR.config.extraPlugins = 'justify , colorbutton';
        });
    </script>
    <script>
        function changeImg(input){
            //Nếu như tồn thuộc tính file, đồng nghĩa người dùng đã chọn file mới
            if(input.files && input.files[0]){
                var reader = new FileReader();
                //Sự kiện file đã được load vào website
                reader.onload = function(e){
                    //Thay đổi đường dẫn ảnh
                    $('#avatar').attr('src',e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(document).ready(function() {
            $('#avatar').click(function(){
                $('#img').click();
            });
        });
        $(document).ready(function() {
            $('#file').change(function(){
                var a =  $('#file').val();
                console.log(a);
                $('#filename').hide();

            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".deleteClick").click(function(){
                var link = $(this).attr('link');
                var name = $(this).attr('name');
                $("#deleteForm").attr('action',link);
                $("#deleteMes").html("Delete : "+name+" ?");
            });
        });

    </script>
    <script>
        function addNewImage() {
            let htmlImage = document.getElementById('html-image');
            let inputImage = document.createElement("input");

            inputImage.setAttribute('type', 'file');
            inputImage.setAttribute('name', 'filename[]');
            inputImage.setAttribute('multiple', '');
            htmlImage.appendChild(inputImage);
            inputImage.style.marginBottom = "20px";
        }
    </script>

@endsection

@section('content')
    <style>
         table td{
            font-size: 15px;
        }
    </style>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="col-md-12">
                    <!-- general form elements -->

                    @include('layouts.errors')

                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Sửa file downnload</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
{{--                        {!! Form::model( [$data,'route'=>['download.edit',$data->id],'method' => 'PATCH','enctype' => 'multipart/form-data']) !!}--}}
                        <form  method="post" enctype='multipart/form-data'>
                            <div class="card-body row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="name">Tên file:</label>
                                            <input name="name" type="text" class="form-control" id="title" placeholder="File Name" value="{{$data->name or old('name')}}" >
                                        </div>
                                        <div class="col-md-6">
                                            <label for="slug">Đường dẫn SEO:</label>
                                            <input name="slug" type="text" class="form-control" id="news_slug" placeholder="Đường dẫn SEO" value="{{$data->slug or old('slug')}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="url">Ảnh:</label>
                                            <div class="row">
                                                <div class="" >
                                                    <input id="img" type="file" name="img" class="form-control hidden" onchange="changeImg(this)" style="border: none">
                                                    <img id="avatar" class="imgPreview thumbnail" src="{{asset('storage/avatar/'.$data->img)}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4" id="html-image"  >
                                            <label style="font-size: 15px">Thêm file:</label>
                                            <input type="file" name="filename[]" multiple="multiple" style="border: none;padding-bottom: 10px"  class="form-control" >

                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <button onclick="addNewImage()" type="button" class="btn btn-info">Thêm file</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding-top: 30px">
                                    <h3>Danh sách file</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table id="example1" class="table table-bordered table-striped dataTable">
                                                <tr style="text-align: center">
                                                    <th>file</th>
                                                    <th>xóa</th>
                                                </tr>
                                                @foreach($files as $file)
                                                    <tr>
                                                        <td>{{$file->filename}}</td>
                                                        <td style="text-align: center"><a href="#" name="{{$file->filename}}" link="{{ url($backendUrl.'/file/delete/'.$file->id) }}" class="deleteClick red id-btn-dialog2" data-toggle="modal" data-target="#deleteModal"> <i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>

                                            <div class="form-group">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <div class="form-group " >
                                            <label for="file_extension">File mở rộng:</label>
                                            <input type="text" name="file_extension" value="{{$data->file_extension}}" class="form-control">
                                        </div>

                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group" >
                                                <label>Danh mục</label>
                                                <select  name="cat_id" class="form-control">
                                                    @if(count($cat)>0)
                                                        @foreach($cat as  $down_cat)
                                                            <option value="{{$down_cat->id}}">{{$down_cat->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        @if(count($currencies) >0)
                                            @foreach($currencies as  $currency)
                                        <div class="col-md-3">
                                                <label>Giá {{$currency->code}}</label>
                                                <input required type="number" name="price[{{$currency->code}}]" class="form-control" value="{{$data->price[$currency->code]}}">
                                        </div>
                                                @endforeach
                                            @endif
                                        <div class="col-md-3">
                                            <label for="discount">Khuyễn mãi:</label>
                                            <input name="discount" type="text" class="form-control" id="view_count" value="{{$data->discount or old('discount')}}" >
                                        </div>
                                        <div class="col-md-3">
                                            <label for="rating">Đánh giá:</label>
                                            <input name="rating" type="text" class="form-control" id="view_count" value="{{$data->rating or old('rating')}}" >
                                        </div>
                                        <div class="col-md-3">
                                            <label for="view">Lượt xem:</label>
                                            <input name="views" type="text" class="form-control" id="view_count" value="{{$data->views or old('views')}}" >
                                        </div>
                                        <div class="col-md-3">
                                            <label for="download">Lượt tải:</label>
                                            <input name="download" type="text" class="form-control" id="view_count" value="{{$data->download or old('download')}}" >
                                        </div>


                                        <div class="col-md-3">
                                            <label for="status">Trạng thái:</label>
                                            <select class="form-control" name="status" id="status" >
                                                <option value="1" @if($data['status'] == 1) selected="selected" @endif>Bật</option>
                                                <option value="0" @if($data['status'] == 0) selected="selected" @endif>Tắt</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="featured">Nổi bật:</label>
                                            <select class="form-control" name="featured" id="status" >
                                                <option value="1" @if($data['featured'] == 1) selected="selected" @endif>Bật</option>
                                                <option value="0" @if($data['featured'] == 0) selected="selected" @endif>Tắt</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group"  >
                                                <label>Phí tải</label>
                                                <select name="public" id="" class="form-control">
                                                    <option value='1' @if($data->public==1) selected @endif>Mất phí</option>
                                                    <option value="0" @if($data->public==0) selected @endif>Miễn phí</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                        <div class="form-control" >
                                            <label for="short_description">Mô tả ngắn:</label>
                                            <textarea name="short_description" id="short_description" class="form-control" rows="3">{{$data->short_description}}</textarea>
                                        </div>

                                        <div class="form-control">
                                            <label for="description">Nội dung:</label>
                                            <textarea name="description" id="content" class="form-control" rows="10" cols="80">{{$data->description}}</textarea>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                                        </div>
                                </div>
                            <!-- /.card-body -->

                    @csrf
                </form>
{{--                        {!! Form::close() !!}--}}
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
