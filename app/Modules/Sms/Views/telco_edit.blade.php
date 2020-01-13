@extends('master')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
    <style>
        .red{
            color: red;
        }
        #preview img{
            padding: 10px;
        }
    </style>
@endsection
@section('content')
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="col-md-12">
            <!-- general form elements -->

           @include('layouts.errors')

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Thêm Telco</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                {!! Form::model($telco, ['method' => 'PATCH','route' => ['backend.telco.update', $telco->id],'enctype' => 'multipart/form-data']) !!}
                <div class="card-body row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tên nhà mạng(<span class="red">*</span>):</label>
                            <input type="text" name="name" placeholder="Nhập tên nhà mạng" class="form-control" value="{{$telco->name or old('name')}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Chọn quốc gia(<span class="red">*</span>):</label>
                            <select name="country_code" class="form-control">
                                @foreach($countries as $country)
                                    <option value="{{$country->code}}" @if($country->code == $telco->country_code) selected @endif>{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Mã key(<span class="red">*</span>):</label>
                            <input type="text" name="key" placeholder="Nhập mã key" class="form-control" value="{{$telco->key or old('key')}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Number:</label>
                            <input type="text" name="number_format" placeholder="Nhập number" class="form-control" value="{{$telco->number_format or old('number_format')}}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            @foreach($groups as $group)
                                @foreach($currencies as $currency)
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Số tiền {{$group->name}}({{$currency->code}}):</label>
                                            <input type="text" name="price[{{$group->id}}][{{$currency->code}}]" class="form-control" value="{{$telco->price[$group->id][$currency->code] or old('price['.$group->id.']['.$currency->code.']')}}">
                                        </div>
                                    </div>
                                @endforeach
                            <div class="col-md-12">
                                <hr>
                            </div>

                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="note">Mô tả:</label>
                            <textarea name="description"  class="form-control"
                                      rows="10">{{$telco->description or old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Trạng thái:</label>
                            <input name="status" id="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;" @if($telco->status == 1) checked="checked" @endif >
                            <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                                <div class="Toggle"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                    <div class="col-md-12">
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" style=" margin: 10px"><i class="fa fa-pencil"> </i> Cập nhật</button>
                            <a href="{{route('backend.telco.index')}}" class="btn btn-warning" style=" margin: 10px"><i class="fa fa-times" aria-hidden="true"></i> Đóng</a>
                        </div>
                    </div>
                    @csrf
                {!! Form::close() !!}
            </div>
            <!-- /.card -->
      </div>
    </div>
  </div>

</section>
<!-- /.content -->
@endsection
@section('js')
    @include('ckfinder::setup')
    <script src="{{ asset('adminlte/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/ckeditor4101/ckeditor.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

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
        $(document).ready(function() {
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
            $('#title').focusout(function () {
                var pname = $(this).val();
                $.ajax({
                    url: '{{url('/').'/'.$backendUrl.'/make/ajaxslug'}}',
                    method: "post",
                    data: {
                        title: pname,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data) {
                            $("#news_slug").attr('value', data);
                        }
                    }

                });

            });
        });


    </script>
@endsection
