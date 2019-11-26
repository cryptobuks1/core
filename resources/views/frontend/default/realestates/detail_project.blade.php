@extends('frontend.'.$current_theme.'.common')
@section('title')
@section('customstyle')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
@section('customstyle')

    <style>
        .title{
            text-transform: uppercase;
            font-size: 2rem;
            color: #00A6C7;
            padding-left: 150px;
        }
        .carousel-item img, .carousel.slide{
            max-width: 640px;
            height: 350px;
        }
        carousel-inner{
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="detail">
        <div class="top-header">
            <div class="title">
                <label for="">{{$data->name}}</label>
            </div>
        </div>
        {{--        hết top-header --}}
        <div class="mid-project">
                <div class="anh-to"  style="padding-top: 20px">

                    {{--               slide--}}

                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img style="width: 100%; max-height: 500px;" class="d-block w-100" src="@if($data->image){{ url($data->image) }}@endif" alt="">
                            </div>
                            @if(count($img)>0)
                                @foreach($img as $item)
                                    <div class="carousel-item">
                                        <img class="d-block w-100" src="{{asset('storage/avatar/'.$item->img)}}" alt="">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
{{--                                    het slide--}}
                </div>

            <div class="thong-tin" style="padding-top: 15px">
                <p><label for="">Tên dự án:</label> <span style="font-weight: 700; font-size: 15px; color:#00bb00 "> {{$data->name}}</span></p>
                <p><label for="">Chủ đầu tư:</label> <span> {{$data->investor}}</span></p>
                <p><label for="">Địa chỉ:</label> <span> {{$data->address}}</span></p>
                @if($data->acreage)
                <p><label for="">Địa chỉ:</label> <span> {{$data->acreage}} mét vuông</span></p>
                @endif
                @if($data->group)
                    <p><label for="">Loai hình phát triển:</label> <span>
                            @if(count($group) >0)
                                @foreach($group as $g_item)
                                    @for($i=0; $i<count($data->group2);$i++)
                                        @if($g_item->code== $data->group2[$i])
                                            <table>
                                                <tr>
                                                    <td> {{$g_item->name}}</td>
                                                </tr>
                                            </table>

                                        @endif
                                    @endfor
                                @endforeach
                            @endif
                        </span></p>
                @endif

            </div>
        </div>
        {{--            hết mid-project--}}
        <div class="thong-tin-du-an">
            <div>
                <h3>Thông tin dự án {{$data->name}}</h3>
            </div>
            <div>
                {!!  htmlspecialchars_decode($data->description) !!}
            </div>
        </div>
    </div>
    {{--hết detail--}}
@endsection
@section('js-footer')
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>



@endsection
