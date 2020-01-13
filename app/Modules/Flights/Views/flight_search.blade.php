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
              {!! Form::open(array('route' => 'flight.search','method'=>'POST','enctype' => 'multipart/form-data')) !!}
                <div class="card-body row">
                    <div class="col-md-12">
                        <h3 style="color: #00aced">CHECK IN TRỰC TUYẾN</h3>
                        <br>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label id="lb-fund1">Điểm khởi hành(<span class="red">*</span>):</label>
                                    <select id="departure" class="form-control select2 inv_id" name="StartPoint" required>
                                        <option value="" >Nhập điểm khởi hành</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Thời gian khởi hành(<span class="red">*</span>):</label>
                                    <input type="text" class="form-control"  placeholder="Chọn thời gian khởi hành" id="departure_time" name="DepartDate" value="{{ trim(date('d-m-Y', time()))}}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label id="lb-fund1">Điểm đến(<span class="red">*</span>):</label>
                                    <select id="arrival" class="form-control select2 inv_id" name="EndPoint" required>
                                        <option value="">Điểm đến</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ngày về:</label>
                                    <input type="text" class="form-control" placeholder="Chọn thời gian đáp cánh" id="arrival_time" name="DepartDate2" value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label id="lb-fund1">Chọn hãng hàng không:</label>
                                    <select id="airline" class="form-control select2 inv_id" name="Airline">
                                        <option value="" >Chọn hãng hàng không</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
{{--                    <div class="col-md-12">--}}
{{--                        <div class="col-md-6">--}}
{{--                            <div class="form-group">--}}
{{--                                <label>Loại tiền</label>--}}
{{--                                <select name="currency_id" id="" class="form-control">--}}
{{--                                    @foreach($currencies as $currency)--}}
{{--                                        <option value="{{$currency->id}}">{{$currency->code}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Người lớn trên 12 tuổi</label>
                            <input type="number" name="Adt" value="1" max="10" min="1" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Người lớn trên 12 tuổi</label>
                            <input type="number" name="Chd" value="0" max="10" min="0" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Người lớn trên 12 tuổi</label>
                            <input type="number" name="Inf" value="0" max="10" min="0" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- /.card-body -->
                    <div class="col-md-12">
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" style=" margin: 10px"><i class="fa fa-search"> </i> Tìm kiếm</button>
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
            $("#airline").select2(
                {
                    tags: true,
                    ajax: {
                        url: "{{ url($backendUrl.'/inventory/search/airline')  }}",
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

            {{--$("#departure").on('change', (function(e){--}}
            {{--    var departure = $(this).val();--}}
            {{--    console.log(departure);--}}
            {{--    $("#arrival").select2(--}}
            {{--        {--}}
            {{--            tags: true,--}}
            {{--            ajax: {--}}
            {{--                url: "{{ url($backendUrl.'/inventory/search/arrival')  }}",--}}
            {{--                type: "POST",--}}
            {{--                dataType: 'json',--}}
            {{--                delay: 150,--}}
            {{--                data: function (params) {--}}
            {{--                    return {--}}
            {{--                        searchTerm: params.term, // search term--}}
            {{--                        code: departure // search term--}}
            {{--                    };--}}
            {{--                },--}}
            {{--                processResults: function (response) {--}}
            {{--                    return {--}}
            {{--                        results: response--}}
            {{--                    };--}}
            {{--                },--}}
            {{--                cache: true--}}
            {{--            }--}}
            {{--        }--}}
            {{--    );--}}
            {{--}));--}}
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
