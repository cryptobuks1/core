@extends('frontend.'.$current_theme.'.app')
@section('title')
@section('customstyle')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.css">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/font-awesome/css/font-awesome.css') }}">

    <link rel="stylesheet" href="{{ asset('adminlte/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/myadmin.css') }}">


@endsection

@section('content')
    <style>
        table td{
            font-size: 12px;
        }
        input{
        }
    </style>
    <!-- Main content -->
    <section class="content" style="width: 100%; font-size: 15px">
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
                                                <div class="" style="padding-left: 20px">
                                                    <input id="img" type="file" name="img" class="form-control hidden" onchange="changeImg(this)" style="border: none">
                                                    <img id="avatar"  class="imgPreview thumbnail" src="{{asset('storage/avatar/'.$data->img)}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4" id="html-image"  >
                                            <div class="form-group" id="html-image" >
                                                <label>File tài liệu</label>
                                                <input type="file" name="filename[]" multiple="multiple" style="margin-bottom: 10px" >
                                            </div>
                                            </div>
                                        <div class="col-md-4">
                                            <div class="form-group" style="padding-top: 20px">
                                                <button onclick="addNewImage()" type="button" class="btn btn-info">Thêm file</button>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding-top: 30px">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3>Danh sách file</h3>
                                            <div style="width: 100%">
                                                <table id="example1" class="table table-bordered table-striped dataTable" style="width: 100%">
                                                    <tr style="text-align: center">
                                                        <th>file</th>
                                                        <th>xóa</th>
                                                    </tr>
                                                    @foreach($files as $file)
                                                        <tr>
                                                            <td>{{$file->filename}}</td>
                                                            <td style="text-align: center; "><a href="{{asset('/file/destroy/'.$file->id)}}"   > <i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group " >
                                                    <label for="file_extension">File mở rộng:</label>
                                                    <input type="text" name="file_extension" value="{{$data->file_extension}}" class="form-control">
                                                </div>

                                            </div>
                                            <div class="col-md-12">
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
                                                    <div class="col-md-12">
                                                        <label>Giá {{$currency->code}}</label>
                                                        <input required type="number" name="price[{{$currency->code}}]" class="form-control" value="{{$data->price[$currency->code]}}">
                                                    </div>
                                                @endforeach
                                            @endif

                                            <div class="col-md-12">
                                                <label for="discount">Khuyễn mãi:</label>
                                                <input name="discount" type="text" class="form-control" id="view_count" value="{{$data->discount or old('discount')}}" >
                                            </div>
                                                <div class=" col-md-12"  >
                                                    <label>Phí tải</label>
                                                    <select name="public" id="" class="form-control">
                                                        <option value='1' @if($data->public==1) selected @endif>Mất phí</option>
                                                        <option value="0" @if($data->public==0) selected @endif>Miễn phí</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="form-group col-md-6 " >
                                                    <label for="short_description">Mô tả ngắn:</label>
                                                    <textarea name="short_description" id="short_description" class="form-control" rows="3">{{$data->short_description}}</textarea>
                                                </div>

                                                <div class="form-group col-md-12 ">
                                                    <label>Miêu tả chi tiết</label>
                                                    <input id="description" type="hidden" name="description" value="{{$data->description}}" style="width: 100%">
                                                    <trix-editor  input="description" ></trix-editor>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                <div class="card-footer">
                                    <button style="width: 90px; height: 50px; font-size: 17px" type="submit" class="btn btn-primary">Cập nhật</button>
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


@endsection
@section('js-footer')
    @include('ckfinder::setup')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.js"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>



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
    </script>
@endsection

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->

