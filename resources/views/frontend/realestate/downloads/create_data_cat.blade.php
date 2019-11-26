@extends('frontend.'.$current_theme.'.app')
@section('title')
@section('customstyle')
@section('content')
    <!-- Main content -->
    <div class="col-sm-12 main">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Danh Mục</h1>
            </div>
        </div><!--/.row-->

        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">

                <div class="panel panel-primary">
                    <div class="panel-heading">Danh Mục Tài Liệu</div>
                    <div class="panel-body">
                        <form method="post"action="{{route('download.add')}}" enctype="multipart/form-data">
                            <div class="row" style="margin-bottom:40px">
                                <div class="col-sm-10 col-sm-offset-1 col-xs-12">
                                    <div class="form-group" >
                                        <label>Tên danh mục</label>
                                        <input required type="text" name="name" class="form-control">
                                    </div>
                                    <div class="form-group" >
                                        <label>Trạng thái</label>
                                        <select required name="status" class="form-control" style="height: 40px">
                                            <option value="1">Bật</option>
                                            <option value="0">Tắt</option>
                                        </select>
                                    </div>

                                    <div class="form-group" >
                                        <label>Miêu tả</label>
                                        <textarea class="ckeditor" required name="description" style="width: 100%; height: 90px"></textarea>
                                    </div>
                                    <div class="form-group" >
                                        <label>Danh mục nổi bật</label><br>
                                        Có: <input type="radio" name="featured" value="1">
                                        Không: <input type="radio" checked name="featured" value="0">
                                    </div>
                                    <input type="submit" name="submit" value="Thêm" class="btn btn-primary">
                                    <a href="{{route('downloads.cat')}}" class="btn btn-danger">Hủy bỏ</a>
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
    <script >
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
