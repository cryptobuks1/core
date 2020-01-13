@extends('master')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
    <style>
        .red{
            color: red;
        }
        #preview img {
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
                <h3 class="card-title">Đặt vé</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                {!! Form::model($data, ['method' => 'PATCH','route' => ['front.flight.search', $data->id],'enctype' => 'multipart/form-data']) !!}
               <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Chuyến bay từ <span class="red">{{$city1->name_city}}</span> đến <span class="red">{{$city2->name_city}}</span></h4>
                            <h5>Khởi hành lúc <span class="red">{{\Carbon\Carbon::parse($data->departure_time)->format('H:i d-m-Y')}}</span> và hạ cánh lúc <span class="red">{{\Carbon\Carbon::parse($data->arrival_time)->format('H:i d-m-Y')}}</span></h5>
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <h3>Điền thông tin</h3>
                            <br>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Họ và tên:</label>
                                            <input type="text" name="user_info[]" class="form-control" placeholder="Nhập tên của người mua">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Số điện thoại(*):</label>
                                            <input type="text" name="user_info[phone]" class="form-control" placeholder="Nhập số điện thoại của người bay">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Email:</label>
                                            <input type="email" name="user_info[email]" class="form-control" placeholder="Nhập email của người bay">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Hành lý ký gửi:</label>
                                            <select name="luggage" class="form-control">
                                                <option value="0">Mua thêm hành lý ký gửi</option>
                                                <option value="200000">15kg - 200,000 VNĐ</option>
                                                <option value="220000">20kg - 220,000 VNĐ</option>
                                                <option value="310000">25kg - 310,000 VNĐ</option>
                                                <option value="440000">30kg - 440,000 VNĐ</option>
                                                <option value="505000">35kg - 505,000 VNĐ</option>
                                                <option value="570000">40kg - 570,000 VNĐ</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="file" name="importFile" id="importFile" class="form-control-file">
                            </div>

                        </div>
                    </div>
               </div>
                <!-- /.card-body -->
                    <div class="col-md-12">
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" style=" margin: 10px"><i class="fa fa-check"> </i> Xác nhận</button>
                            <a href="{{route('flight.airline.index')}}" class="btn btn-warning" style=" margin: 10px"><i class="fa fa-times" aria-hidden="true"></i> Đóng</a>
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
        $(document).ready(function () {
            $("#departure").select2(
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

            $("#departure").on('change', (function(e){
                var departure = $(this).val();
                console.log(departure);
                $("#arrival").select2(
                    {
                        tags: true,
                        ajax: {
                            url: "{{ url($backendUrl.'/inventory/search/arrival')  }}",
                            type: "POST",
                            dataType: 'json',
                            delay: 150,
                            data: function (params) {
                                return {
                                    searchTerm: params.term, // search term
                                    code: departure // search term
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
            }));
        });
    </script>
    <script>
        $(function () {
            $("#departure_time, #arrival_time").datepicker({
                dateFormat: 'dd-mm-yy',
                minDate:'0D',
            });
        });
    </script>
@endsection
