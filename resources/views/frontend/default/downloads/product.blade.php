@extends('frontend.'.$current_theme.'.app')
@section('title')

@section('customstyle')

@endsection

@section('content')
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

#cart a:first-child{
	color: #fff;
}
#cart a:last-child{
	margin-left: 55px;
	color: #ff6600;
}
@media (min-width: 960px) and (max-width: 1210px){
	#cart a:first-child{
		color: #fff;
	}
	#cart a:last-child{
		margin-left: 40px;
		color: #ff6600;
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

.products h3{
	margin-top: 15px;
	font-size: 18px;
	color: #ff9600;
	text-transform: uppercase;
}

.product-list{
	margin: 0;
}

.product-item{
	border: 1px solid #ddd;
	text-align: center;
	padding: 15px;
	position: relative;
}
.product-item img{
	border: none;
	padding: 0;
	border-radius: 0;
}
.product-item:hover .marsk{
	display: block;
}
.product-item img{
	margin-bottom: 15px;
}
.product-item a{
	color: #666;
}
.price{
	font-weight: bold;
	color: #D60000;
}
.marsk{
	background: #000;
	position: absolute;
	width: 100%;
	height: 100%;
	top: 0;
	left: 0;
	opacity: 0.75;
	display: none;
}
.marsk a{
	color: #fff;
	position: absolute;
	top: 50%;
	/* left: 0;right:0; margin: auto;width: 100%; cho width de thanh block, vi width là block, a la inline */
	margin-left:-37px;
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



</style>
<div class="container-fuild">
	<h1>Tài liệu</h1>
	<div class="row">
		<div id="wrap-inner">
						<div class="products">
							<h3>sản phẩm nổi bật</h3>
							<div class="product-list row" >
                               		 @foreach ($items as $item)
                                    <div class="product-item col-md-4 col-sm-6 col-xs-12" style="padding-bottom: 10px ">
                                        <a href="#"><img width="100px" height="150px" src="{{asset('storage/avatar/'.$item->img)}}" class="img-thumbnail"></a>
                                        <div style="float: bottom">
                                            <p><a href="#"></a>{{$item->name}}</p>
                                            <p class="price"> @if(count($currencies) >0)
                                                                    {{number_format($item->price['VND'])}} VND<br>
                                                            @endif</p>
                                            <div class="marsk">
                                                <a href="{{ asset('downloads/detail/'.$item->id) }}">Xem chi tiết</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
							</div>
						</div>
						<div class="products">
							<h3>sản phẩm mới</h3>
							<div class="product-list row">

                                    @foreach ($data as $item)
                                    <div class="product-item col-md-4 col-sm-6 col-xs-12">
                                        <a href="#"><img width="100px" height="150px" src="{{asset('storage/avatar/'.$item->img)}}" class="img-thumbnail"></a>
                                        <div style="float: bottom">
                                            <p><a href="#"></a>{{$item->name}}</p>
                                            <p class="price"> @if(count($currencies) >0)
                                                                    {{number_format($item->price['VND']) }} VND<br>
                                                            @endif</p>
                                            <div class="marsk">
                                                <a href="{{ asset('downloads/detail/'.$item->id) }}">Xem chi tiết</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

							</div>
						</div>
		</div>
	</div>
</div>


@endsection


@section('js-footer')



@endsection
