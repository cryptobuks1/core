@extends('frontend.'.$current_theme.'.app')
@section('title')
@section('customstyle')

@section('customstyle')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .lb-header {
            background-color: #00c0ef;
            padding: 4px 4px 2px 4px;
            border-radius: 3px;
            color: white;
        }
        .ds-tin-rao{
            border: 1px solid gray;
        }
        a:hover{
            text-decoration: none;
        }
        .binh-thuong{
            font-weight: 700; color: gray; font-size: 15px;
        }
        .noi-bat{
            font-weight: 700; color: orangered; font-size: 15px;
        }
        .search li.active{
            background-color: greenyellow;
            border: 1px solid greenyellow;
        }
        .title-top h2{
            text-align: center;
            text-transform: uppercase;
            color: #00c0ef;
        }
    </style>

@endsection

@section('content')
    @include('frontend.default.realestates.menu')
    <div class="tin-rao">
        <div class="row">
            <div class="col-md-12">
                <div class="title-top">
                    <h2>Trang chủ</h2>
                </div>
            </div>
            <div class="col-md-3">
                @include('frontend.default.realestates.menu_search')
            </div>
            <div class="col-md-9">
                <div >
                    <label for="" class="lb-header"> Tin rao nổi bật</label>
                </div>
                @if(count($data2)>0)
                <div class="ds-tin-rao">
                    @foreach($data2 as $item)
                    <div class="item">
                        <div class="row">
                            <div class="item-tin-rao" style="padding: 5px 5px">
                                <div class="col-md-4">
                                    <a href="{{asset('realestates/tin/'.$item->id.'/'.$item->slug)}}"><img style="width: 100%; height: 200px" src="@if(isset($item->image)){{asset('storage/avatar/'.$item->image)}} @endif" alt=""></a>
                                </div>
                                <div class="col-md-8">
                                    <div class="title">
                                        <a href="{{asset('realestates/tin/'.$item->id.'/'.$item->slug)}}">
                                                @if($item->featured==1 ) <p class="noi-bat"><span> </span> {{$item->title}}</p>
                                                @else <p class="binh-thuong">{{$item->title}}</p> @endif
                                        </a>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="">Giá</label>
                                        </div>
                                        <div class="col-md-9">: @if($item->price) {{number_format($item->price)}} VNĐ @else Theo thỏa thuận. @endif</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="">Diện tích</label>
                                        </div>
                                        <div class="col-md-9">: @if($item->acreage) {{$item->acreage}} mét vuông @else Chưa có thông tin về diện tích. @endif</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="">Địa chỉ</label>
                                        </div>
                                        <div class="col-md-9">: <span style="color: #00c0ef">{{$item->address}}</span></div>
                                    </div>
                                    <div>
                                        <span style="float: right">{{$item->created_at}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <hr>
                    @endforeach
                </div>
                @else
                    <span>Không có tin rao nổi bật nào.</span>
                @endif
            </div>
        </div>
    </div>

    <div class="tin-rao" style="padding-top: 30px">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-9">
                <div >
                    <label for="" class="lb-header"> Tin rao mới</label>
                </div>
                @if(count($data1)>0)
                <div class="ds-tin-rao">
                    @foreach($data1 as $item)

                        <div class="item">
                            <div class="row">
                                <div class="item-tin-rao" style="padding: 5px 5px">
                                    <div class="col-md-4">

                                        <a href="{{asset('realestates/tin/'.$item->id.'/'.$item->slug)}}"><img style="width: 100%; height: 200px" src="@if(isset($item->image)){{asset('storage/avatar/'.$item->image)}} @endif" alt=""></a>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="title">
                                            <a href="{{asset('realestates/tin/'.$item->id.'/'.$item->slug)}}">
                                                @if($item->featured==1 ) <p class="noi-bat"><span> </span> {{$item->title}}</p>
                                                @else <p class="binh-thuong">{{$item->title}}</p> @endif
                                            </a>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="">Giá</label>
                                            </div>
                                            <div class="col-md-9">: @if($item->price) {{number_format($item->price,0)}} VNĐ @else Theo thỏa thuận. @endif</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="">Diện tích</label>
                                            </div>
                                            <div class="col-md-9">: @if($item->acreage) {{$item->acreage,0}} mét vuông @else Chưa có thông tin về diện tích. @endif</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="">Địa chỉ</label>
                                            </div>
                                            <div class="col-md-9">: <span style="color: #00c0ef">{{$item->address}}</span></div>
                                        </div>
                                        <div>
                                            <span style="float: right">{{$item->created_at}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
                @else
                Không có tin rao mới nào.
                @endif
            </div>
        </div>
    </div>


@endsection


@section('js-footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script >
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
                    url:'{{ route('ajax.project') }}',
                    data:{code:city_code},
                    success:function(data){
                        $('#provinces').html(data);
                    }
                });
            }));
        });
    </script>




@endsection
