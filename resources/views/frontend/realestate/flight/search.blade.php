@extends('frontend.'.$current_theme.'.app')
@section('title')
@section('customstyle')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
    <style>
        .red{
            color: red;
        }
        #preview img {
            padding: 10px;
        }
        .form-control{
            padding: 0;
            border-radius: 3px;
        }
    </style>

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">



@endsection

@section('content')

    <div class="create-broker" style="padding: 10px; background-color: #00aced; border-radius: 10px">
        <div class="broker-top">
            <h2>TÌM CHUYẾN BAY</h2>
        </div>
        <div id="main-broker" class="container" >
            <div class="content-wap">
                @include('layouts.errors')
                {!! Form::open(array('route' => 'front.flight.list','method'=>'POST','enctype' => 'multipart/form-data')) !!}
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label id="lb-fund1" style="display: block">Điểm khởi hành(<span class="red">*</span>):</label>
                                <select id="departure" class="form-control select2 inv_id" name="StartPoint" required>
                                    <option value="" >Điểm khởi hành</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Ngày khởi hành(<span class="red">*</span>):</label>
                                <input type="text" class="form-control"  placeholder="Chọn ngày khởi hành" id="departure_time" name="DepartDate" value="{{  trim(date('d/m/Y', time()))}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label id="lb-fund1" style="display: block">Điểm đến(<span class="red">*</span>):</label>
                                <select id="arrival" class="form-control select2 inv_id" name="EndPoint" required>
                                    <option value="">Điểm đến</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label >Ngày về:</label>
                                <input type="text" class="form-control" placeholder="Chọn ngày về" id="arrival_time" name="DepartDate2" value="{{old('DepartDate2')}}">
                            </div>
                        </div>
                    </div>
                    {{--<div class="row">--}}
                        {{--<div class="col-md-5">--}}
                            {{--<div class="form-group">--}}
                                {{--<label id="lb-fund1" style="display: block">Chọn hãng hàng không:</label>--}}
                                {{--<select id="airline" class="form-control select2 inv_id" name="Airline">--}}
                                    {{--<option value="" >Chọn hãng hàng không</option>--}}
                                {{--</select>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                        <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Người lớn trên 12 tuổi</label>
                                <input type="number" name="Adt" value="1" max="10" min="1" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Từ 2 đến dưới 20 tuổi</label>
                                <input type="number" name="Chd" value="0" max="10" min="0" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Dưới 2 tuổi</label>
                                <input type="number" name="Inf" value="0" max="10" min="0" class="form-control">
                            </div>
                        </div>
                    </div>

                <!-- /.card-body -->
                <div class="col-md-12">
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" style=" margin: 10px"><i class="fa fa-search"> </i> Tìm kiếm</button>
{{--                        <a href="{{route('flight.airline.index')}}" class="btn btn-warning" style=" margin: 10px"><i class="fa fa-times" aria-hidden="true"></i> Đóng</a>--}}
                    </div>
                </div>
                @csrf
                {!! Form::close() !!}
            </div>
{{--            hết content-wap--}}
        </div>
{{--        hết main-create-broker--}}
    </div>
{{--    hêt create_broker--}}

@endsection

@section('js-footer')
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
                        url: "{{ route('ajax.flight.departure2')  }}",
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
                        url: "{{ route('ajax.flight.airline2')  }}",
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
            $("#departure_time").datepicker({
                dateFormat: 'dd/mm/yy',
                minDate:'0D',
            });
        });
        $("#departure_time").on('change', (function(e) {
            var departure = $('#departure_time').val();
            console.log(departure);
            $("#arrival_time").datepicker({
                dateFormat: 'dd/mm/yy',
                minDate: departure,
            });
        }));
    </script>
@endsection
