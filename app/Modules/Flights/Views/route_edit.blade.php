@extends('master')

@section('css')
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
                <h3 class="card-title">Thêm đường bay</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                {!! Form::model($data, ['method' => 'PATCH','route' => ['flight.route.update', $data->id],'enctype' => 'multipart/form-data']) !!}
                <div class="card-body row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Tên đường bay</label>
                            <input type="text" name="name" placeholder="Nhập tên" class="form-control" value="{{$data->name or old( 'name')}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                            <div class="form-group">
                                <label id="lb-fund1">Điểm khởi hành(<span class="red">*</span>):</label>
                                <select id="departure" class="form-control select2 inv_id" name="departure_station"  >
                                    <option value="" >Nhập điểm khởi hành</option>
                                    @foreach ($stations as $key => $item)
                                        @foreach($countries as $country)
                                            @foreach($cities as $city)
                                                <option value="{{$item->code}}" @if($item->code == $data->departure_station && $item->country == $country->code && $city->country_code == $item->country && $city->code == $item->city) selected @endif>{{$city->name_city.' - '.$country->name.'('.$item->name.')'}}</option>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                    </div>
                    <div class="col-md-6">
                            <div class="form-group">
                                <label id="lb-fund1">Điểm đến(<span class="red">*</span>):</label>
                                <select id="arrival" class="form-control select2 inv_id" name="arrival_station" >
                                    <option value="" >Nhập điểm đến</option>
                                    @foreach ($stations as $key => $item)
                                        @foreach($countries as $country)
                                            @foreach($cities as $city)
                                                <option value="{{$item->code}}" @if($item->code == $data->arrival_station && $item->country == $country->code && $city->country_code == $item->country && $city->code == $item->city) selected @endif>{{$city->name_city.' - '.$country->name.'('.$item->name.')'}}</option>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                    </div>
                    <div class="col-md-12">
                        <hr>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tags">Hãng hàng không(<span class="red">*</span>):</label>
                            <select name="airline[]" id="airline" class="form-control select2"
                                    multiple="multiple" data-placeholder="Chọn hãng hàng không">
                                @foreach($airlines as $item)
                                    <option value="{{ $item->code }}"@if($data->airline) @if(in_array($item->code, $data->airline)) selected @endif @endif>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                //Initialize Select2 Elements
                                $('.select2').select2();
                            })
                        </script>
                    </div>
{{--                    <div class="col-md-6">--}}
{{--                        <div class="form-group">--}}
{{--                            <label>Mã đường bay(<span class="red">*</span>):</label>--}}
{{--                            <input type="text" name="code" class="form-control" placeholder="Nhập mã code đường bay" value="{{$data->code or old('code')}}" style="text-transform: uppercase">--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Loại đường bay(<span class="red">*</span>):</label>
                            <select  class="form-control" name="local" >
                                <option value="1" @if($data->local == 1) selected @endif>Đường bay nội địa</option>
                                <option value="2" @if($data->local == 2) selected @endif>Đường bay quốc tế</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Khoảng cách(km):</label>
                            <input type="text" name="range" class="form-control" placeholder="Nhập  khoảng cách đường bay" value="{{$data->range or old('range')}}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="status">Trạng thái:</label>
                            <input name="status" id="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;" @if($data->status == 1 ) checked="checked" @endif>
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
                            <a href="{{route('flight.route.index')}}" class="btn btn-warning" style=" margin: 10px"><i class="fa fa-times" aria-hidden="true"></i> Đóng</a>
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
    <script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

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
        $(document).ready(function () {
            $("#departure,#arrival").select2(
                {
                    tags: true,
                    ajax: {
                        url: "{{ url($backendUrl.'/inventory/search/departure')  }}",
                        type: "POST",
                        dataType: 'json',
                        delay: 150,
                        data: function (params) {
                            return {
                                searchTerm: params.term // search term
                            };
                        },
                        processResults: function (response) {
                            return {
                                results: response
                            };
                        },
                        cache: true
                    }
                }
            );
        });
        $(document).ready(function () {
            $("#airline").select2(
                {
                    tags: true,
                    ajax: {
                        url: "{{ url($backendUrl.'/inventory/search/service')  }}",
                        type: "POST",
                        dataType: 'json',
                        delay: 150,
                        data: function (params) {
                            return {
                                searchTerm: params.term // search term
                            };
                        },
                        processResults: function (response) {
                            return {
                                results: response
                            };
                        },
                        cache: true
                    }
                }
            );
        });
    </script>
@endsection
