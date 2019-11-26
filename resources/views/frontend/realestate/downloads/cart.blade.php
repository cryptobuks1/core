@extends('frontend.'.$current_theme.'.app')
@section('title')

@section('customstyle')

@endsection

@section('content')


    <div id="wrap-inner">
        <div id="list-cart">
            <h3>Giỏ hàng</h3>
            @if(Cart::count()>=1)
                <form>
                    <table class="table table-bordered .table-responsive text-center">
                        <tr class="active">
                            <td width="11.111%">Ảnh mô tả</td>
                            <td width="22.222%">Tên sản phẩm</td>
                            <td width="22.222%">Số lượng</td>
                            <td width="16.6665%">Đơn giá</td>
                            <td width="16.6665%">Thành tiền</td>
                            <td width="11.112%">Xóa</td>
                        </tr>
                        @foreach($items as $item)
                            <tr>
                                <td><img class="img-responsive" src="{{asset('storage/avatar/'.$item->options->img)}}"></td>
                                <td>{{$item->name}}</td>
                                <td>
                                    <div class="form-group">
                                        <input class="form-control" type="number" value="{{$item->qty}}" onchange="updateCart(this.value,'{{$item->rowId}}')">
                                    </div>
                                </td>
                                <td><span class="price">{{number_format($item->price,0)}}</span></td>
                                <td><span class="price">{{number_format($item->price*$item->qty,0)}}</span></td>
                                <td><a href="{{asset('downloads/cart/delete/'.$item->rowId)}}">Xóa</a></td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="row" id="total-price">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            Tổng thanh toán: <span class="total-price">{{$total}}</span>

                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <a href="{{route('downloads.product')}}" class="my-btn btn">Mua tiếp</a>
                            <a href="{{asset('downloads/cart/delete/all')}}" class="my-btn btn">Xóa giỏ hàng</a>
                        </div>
                    </div>

                </form>
                <div id="xac-nhan">
                    <h3>Xác nhận mua hàng</h3>
                    <form action="{{route('cart.complete')}}" method="post">
                        <div class="form-group">
                            <label for="email">Email address:</label>
                            <input required type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="name">Họ và tên:</label>
                            <input required type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại:</label>
                            <input required type="number" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="form-group">
                            <label for="add">Địa chỉ:</label>
                            <input required type="text" class="form-control" id="add" name="add">
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-default">Thực hiện đơn hàng</button>
                        </div>
                        <input type="hidden" value="{{$total}}" name="total">
                        @csrf
                    </form>
                </div>
            @else
                <h2>Giỏ hàng rỗng</h2>
                <a href="{{route('downloads.product')}}"><button class="btn btn-primary">Quay lại mua hàng</button></a>
            @endif
        </div>

    </div>
    <script>
        function updateCart(qty,rowId) {
            $.get(
                '{{asset('downloads/cart/update')}}',
                {qty:qty,rowId:rowId},
                function () {
                    location.reload();
                }
            );
        }
    </script>
    <style>
        *{
            padding: 0;
            margin: 0;
        }
        body{
            font-family: arial;
            font-size: 14px;
            color: #666;
        }
        #header{
            background: #FF9600;
        }
        #logo, #search, #cart{
            height: 98px;
        }
        #logo h1{
            line-height: 98px;
        }
        #search input{
            margin-top: 30px;
            float: left;
        }
        #search input[type=text]{
            width: 300px;
            height: 35px;
            border: 1px solid #fff;
            background: transparent;
            color: #fff;
            font-size: 12px;
            padding-left: 15px;
            margin-left: 30px;
        }
        #search input[type=submit]{
            height: 35px;
            background: #fff;
            padding: 0 15px;
            border: none;
            color: #ff9600;
            font-size: 12px;
        }
        @media (min-width: 768px) {
            .navbar-form .input-group .form-control,
            .navbar-form .input-group .input-group-btn{
                width: 100%;
            }
        }
        #cart{
            color: #fff;
            line-height: 98px;
            font-weight: bold;
            position: relative;
        }
        #cart img{
            position: absolute;
            top: 0;
            left: 0;
        }
        #cart a:first-child{
            color: #fff;
        }
        #cart a:last-child{
            margin-left: 60px;
            color: #ff6600;
            position: absolute;
        }
        @media (min-width: 960px) and (max-width: 1210px){
            #cart{
                color: #fff;
                line-height: 98px;
                font-weight: bold;
                position: relative;
            }
            #cart img{
                position: absolute;
                top: 0;
                left: -30px;
            }
            #cart a:first-child{
                color: #fff;
            }
            #cart a:last-child{
                color: #ff6600;
                position: absolute;
                left: 50px;
            }
        }

        #body{
            margin-top: 15px;
        }
        /* #sidebar{
            padding-right: 11px;
        padding-left: 12px;
        } */
        #menu{
            background: #fbfbfb;
            border: 1px solid #ddd;

        }
        .menu-item{
            list-style: none;
            height: 40px;
            line-height: 40px;
            border-bottom: 1px solid #ddd;
            padding-left: 15px;
        }
        .menu-item a{
            color: #666;
        }
        .menu-item:first-child{
            background: #f5f5f5;
            text-transform: uppercase;
        }
        .menu-item:last-child{
            border: none;
        }
        .banner-l-item{
            margin-top: 15px;
            max-width: 100%;
        }
        .banner-l-item img{
            border: none;
            padding: 0;
            border-radius: 0;
        }
        @media (min-width: 750px) and (max-width: 992px){
            .menu-item:first-child{
                font-size: 12px;
                font-weight: bold;
            }
            .menu-item{
                font-size: 12px;
            }
            #banner-l-item img{
                min-width: 100%;
            }

        }
        .banner-t-item{
            margin-top: 15px;
        }

        .banner-t-item img{
            border: none;
            padding: 0;
            border-radius: 0;
        }

        #list-cart h3{
            margin-top: 15px;
            font-size: 24px;
            color: #ff9600;
            text-transform: uppercase;
        }
        #xac-nhan h3{
            margin-top: 15px;
            font-size: 24px;
            color: #ff9600;
            text-transform: uppercase;
        }
        /* table */
        .table .form-group{
            margin: 0px;
        }
        .table .form-control{
            border-radius: 0px;
            padding: 0px 9px;
        }
        .table td{
            vertical-align: middle !important;
        }
        .table td .price{
            color: red;
            font-weight: bold;
        }
        .table td a{
            color: #232323;
        }
        #total-price{
            font-weight: bold;
            font-size: 20px;
        }
        #total-price .total-price{
            color: red;
        }
        .form-group .btn{
            background: #ff9600;
            border-radius: 0px;
            color: #fff;
        }
        .form-control{
            border-radius: 0px;
        }
        /* end table */
        .price{
            font-weight: bold;
            color: #D60000;
        }
        #footer{
            margin-top: 15px;
        }
        #footer-t{
            background: #FF9600;
            color: #fff;
            padding: 15px 0 0 0;
        }

        #footer-t h3{
            font-size: 18px;
            text-transform: capitalize;
        }

        #footer-b{
            background: #FF6700;
            color: #fff;
            font-size: 13px;
            position: relative;
        }
        #footer-b p{
            margin: 0;
            height: 100px;
            line-height: 100px;
        }
        #scroll{
            position: absolute;
            top: 0;
            right: 0;
        }

        /* reponsive */
        @media (max-width: 992px) {
            #search{
                display: none;
            }
            #slider{
                display: none;
            }
            #cart{
                margin-left: 350px;
                color: #fff;
                line-height: 98px;
                font-weight: bold;
            }
            #cart a:first-child{
                color: #fff;
            }
            #cart a:last-child{
                color: #ff6600;
            }

            #menu{
                margin-bottom: 20px;
            }
            #v-banner{
                margin-bottom: 10px;
            }
            #h-banner img{
                padding: 10px 0px;
            }
            .list-product h3{
                text-align: center;
            }
            #footer-logo{
                text-align: left;
            }
        }
        @media (max-width: 768px) {
            #cart{
                display: none;
            }
            #header{
                text-align: center;
            }
            #scroll{
                display: none;
            }
        }

        nav a#pull {
            display: none;
        }
        @media only screen and (max-width : 480px) {
            nav {
                border-bottom: 0;
            }
            nav ul {
                display: none;
                height: auto;
            }
            #logo{
                position: relative;
            }
            nav a#pull {
                display: block;
                float: left;
                /* background-color: #ff9600; */
                /* width: 100%; */
                position: absolute;
                top: 50%;
            }
            nav a#pull:after {
                content:"";
                /* background: url('../img/home/nav.png') no-repeat; */
                width: 30px;
                height: 30px;
                display: inline-block;
                position: absolute;
                /* rightright: 15px; */
                top: 0px;
                right: 0;
            }
            #menu{
                border: 0;
            }
        }

        @media only screen and (max-width : 320px) {
            nav li {
                display: block;
                float: none;
                width: 100%;
            }
            #menu{
                border: 0;
            }
            /*  nav li a {
                 border-bottom: 1px solid #576979;
                 } */
        }

        .my-btn{
            color: #fff;
            border-radius: 0px;
            border-color: #ff9600;
            background: #ff9600;
        }
        .my-btn:last-child{
            background: #d9534f;
            border-color: #d43f3a;
        }
    </style>
@endsection


@section('js-footer')

@endsection
