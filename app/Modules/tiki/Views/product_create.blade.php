@extends('master')

@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}"
          xmlns="http://www.w3.org/1999/html">
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

@endsection

@section('content')
    <style>
        .header-product{
            background-color: #00c0ef;
            padding:5px 5px;
            border-radius: 4px;
        }
        .create-product{
            padding-top: 20px;
        }
        .form-control{
            width: 80%;
        }
    </style>
    <!-- Main content -->
    <section class="content">
        <div class="product">
            <div class="">
                <div class="header-product">
                    <h3>Thêm sản phẩm mới</h3>
                </div>
                <form action="" enctype='multipart/form-data' method="POST">
                    <div class="create-product">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Tên sản phẩm</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cats">Danh mục sản phẩm</label>
                                    <select name="cat_id" id="" class="form-control" >
                                        @foreach($cate as $cat)
                                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_branded">Tên hãng</label>
                                    <input type="text" name="product_branded" class="form-control" required >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Ảnh sản phẩm</label>
                                    <input type="file" name="image" class="form-control" style="border: none" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputprice">Giá nhập</label>
                                    <input type="number" name="inputprice" class="form-control" required >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Giá bán</label>
                                    <input type="number" name="price" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="special_price">Giá khuyến mại</label>
                                    <input type="number" name="special_price" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Trạng thái</label>
                                    <select name="status" id="" class="form-control">
                                        <option value="1">Bật</option>
                                        <option value="0">Tắt</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hotdeal">Nổi bật</label>
                                    <select name="hotdeal" id="" class="form-control">
                                        <option value="1">Bật</option>
                                        <option value="0">Tắt</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="approved">Phê duyệt</label>
                                    <select name="approved" id="" class="form-control">
                                        <option value="1">Bật</option>
                                        <option value="0">Tắt</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="short_description">Mô tả ngắn ngọn</label>
                                    <textarea name="short_description" id="" cols="30" rows="5" class="form-control" style="width: 90%" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Mô tả chi tiết:</label>
                                    <textarea name="description" id="content" class="form-control" rows="10" cols="80" required></textarea>
                                </div>
                            </div>

                                <div class="form-group" >
                                    <input type="submit" class="btn btn-primary" value="Thêm mới" >
                                    <a href="{{route('tiki.product')}}" class="btn btn-danger">Hủy</a>
                                </div>
                        </div>
                    </div>
{{--                    hết create-product--}}
                </form>
            </div>
        </div>
{{--        hết product--}}
    </section>
@endsection
