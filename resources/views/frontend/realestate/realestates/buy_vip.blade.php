@extends('frontend.'.$current_theme.'.app')
@section('title')
@section('customstyle')
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/myadmin.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
@section('customstyle')

    <!-- Google Font: Source Sans Pro -->


@endsection

@section('content')

    <style>
        .form-control{
            font-size: 12px;
        }
        table td{
            font-size: 15px;
        }

        .blue{
            color: #00c0ef;
        }

    </style>
    <section class="content">

        @include('frontend.default.realestates.menu')
        <div class="row">
            <div class="col-md-12">

            </div>
        </div>
            <div class="card-body row" >
                <div class="card card-default col-md-12">
                    <div class="card-header header-min">
                        <h3 class="card-title">Mua Vip</h3>
                    </div>
                    @include('layouts.errors')
                    <form action="" method="post">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Loại rao tin </label>
                                        <select name="type_news" id="vip" class="form-control" style="height: 38px">
                                            <option value="">Chọn gói vip</option>
                                            @foreach($vip as $item)
                                                <option value="{{$item->level}}">{{$item->name}} - Giá: {{$item->price}} VNĐ/{{$item->day}} Ngày</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="col-group">
                                        <label for="">Ngày bắt đầu</label>
                                        <input type="text"  name="start_date" id="start_date" required readonly value="{{$data->start_date}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4  ">
                                    @if($check==true)
                                        <div class="col-group">
                                            <label for="">Ngày kết thúc( Đã hết hạn)</label>
                                            <span id="end_date"> <input type="text"  name="end_date" id="end_date"  readonly required value="{{$data->end_date}}" class="form-control"></span>
                                            <span id=""> <input type="hidden"  name="" id="end"  readonly required value="{{$today}}" class="form-control"></span>

                                        </div>
                                    @else
                                        <div class="col-group">
                                            <label for="">Ngày kết thúc</label>
                                            <span id="end_date"> <input type="text"  name="end_date" id="end_date"  readonly required value="{{$data->end_date}} " class="form-control"></span>
                                            <span id=""> <input type="hidden"  name="" id="end"  readonly required value="{{$data->end_date}}" class="form-control"></span>

                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-12">
                                    <div class="col-group">
                                        {!! $paygates !!}
                                    </div>
                                </div>
                                <div style="display: flex; padding-left: 5px" class="col-md-12">
                                    <label for="">Tin thường: </label><p>Là loại tin đăng bằng chữ <span class="blue">màu xanh</span>, khung <span class="blue">màu xanh</span></p>
                                </div>
                                <div style="display: block" class="col-md-12">
                                    <p> <i class="fa fa-arrow-circle-right" aria-hidden="true" style="padding-right: 5px; color: gold"></i>
                                        Quý khách nên chọn đăng tin Vip để có hiệu quả cao hơn, ví dụ: tin Vip1 có lượt xem trung bình cao hơn 20 lần so với tin thường
                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-primary" value="Mua" style="font-size: 20px">
                                    <a href="{{route('tin.rao')}}" type="submit" class="btn btn-danger"  style="font-size: 20px">Hủy</a>
                                </div>
                            </div>
                        </div>
                        @csrf
                    </form>

                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- Main content -->

@endsection


@section('js-footer')
    <script >
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            $("#vip").on('change', (function (e) {
                var vip = $('#vip').val();
                var end_date = $('#end_date').val();
                var end=$('#end').val();
                var start_date = $('#start_date').val();
                console.log(start_date);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('ajax.time') }}',
                    data: { vip: vip,end_date:end_date,start_date:start_date, end:end},
                    success: function (data) {
                        $('#end_date').html(data);
                    }
                });
            }));
        });
    </script>

@endsection
