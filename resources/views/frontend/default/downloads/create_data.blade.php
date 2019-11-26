@extends('frontend.'.$current_theme.'.app')
@section('title')

@section('customstyle')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.css">

@endsection

@section('content')
    <style>
        .form-group select{
            height: 40px;

        }
    </style>
    <!-- Main content -->
    <div class="col-sm-12  main">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">TÀI LIỆU</h1>
            </div>
        </div><!--/.row-->
        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">

                <div class="panel panel-primary">
                    <div class="panel-heading">Thêm tài liệu</div>
                    <div class="panel-body">
                        <form method="post" action="{{route('download.add')}}" enctype="multipart/form-data">
                            <div class="row"  style="margin-bottom:40px">
                                <div class="col-sm-10 col-sm-offset-1 col-xs-12">
                                    @include('layouts.errors')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group" >
                                                <label>Tên tài liệu</label>
                                                <input required type="text" name="name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" >
                                                <label>Phần mở rộng</label>
                                                <input required type="text" name="file_extension" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group" >
                                                <label>Ảnh nền</label>
                                                <input required id="img" type="file" name="img"  >
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group" >
                                                <label>Danh mục</label>
                                                <select  name="cat_id" class="form-control">
                                                    @if(count($data_cat)>0)
                                                        @foreach($data_cat as  $down_cat)
                                                            <option value="{{$down_cat->id}}">{{$down_cat->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        @if(count($currencies) >0)
                                            @foreach($currencies as  $currency)
                                        <div class="col-md-6">
                                            <div class="form-group" >
                                                <label>Giá {{$currency->code}}</label>
                                                <input required type="number" name="price[{{$currency->code}}]" class="form-control">
                                            </div>
                                        </div>
                                            @endforeach
                                        @endif

                                        <div class="col-md-6">
                                            <div class="form-group" >
                                                <label>Khuyến mãi</label>
                                                <input  type="text" name="discount" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group" >
                                                <label>Miêu tả ngắn ngọn</label>
                                                <textarea type="text" name="short_description" class="form-control"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group" >
                                                <label>Miêu tả chi tiết</label>
                                                <input id="description" type="hidden" name="description" >
                                                <trix-editor input="description" ></trix-editor>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" id="html-image" >
                                                <label>File tài liệu</label>
                                                <input type="file" name="filename[]" multiple="multiple" style="margin-bottom: 20px" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"  >
                                                <label>Phí tải</label>
                                                <select name="public" id="" class="form-control">
                                                    <option value=1>Mất phí</option>
                                                    <option value="0">Miễn phí</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button onclick="addNewImage()" type="button" class="btn btn-info">Thêm file</button>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="submit" name="submit" value="Thêm" class="btn btn-primary">
                                    <a href="{{route('downloads')}}" class="btn btn-danger">Hủy bỏ</a>
                                </div>
                            </div>
                            @csrf
                        </form>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div><!--/.row-->
    </div>	<!--/.main-->

@endsection


@section('js-footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.js"></script>
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
