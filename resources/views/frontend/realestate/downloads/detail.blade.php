@extends('frontend.'.$current_theme.'.app')
@section('title')

@section('customstyle')

@endsection

@section('content')


    <div id="wrap-inner">
        <div id="product-info">
            <div class="clearfix"></div>
            <h3>{{$data->name}}</h3>
            <div class="row">
                <div id="product-img" class="col-xs-12 col-sm-12 col-md-3 text-center">
                    <img width="100%" height="100%" src="{{asset('/storage/avatar/'.$data->img)}}">
                </div>
                <div id="product-details" class="col-xs-12 col-sm-12 col-md-9">
                    <p>Giá: <span class="price">@if(count($currencies) >0){{number_format($data->price['VND']) }} VND<br>@endif </p>
                    <p>Danh mục:  @foreach($cat as $cat)
                                        @if($cat->id==$data->cat_id)
                                            {{$cat->name}}
                                        @endif
                                   @endforeach</p>
                    <p>Khuyến mại: {{$data->disccout}}</p>
                    <p>Miêu tả ngắn: {{$data->short_description}}</p>

                    <p class="add-cart text-center"><a href="{{asset('downloads/cart/add/'.$data->id)}}">Thêm vào giỏ hàng</a></p>
                </div>
            </div>
        </div>
        <div id="product-detail">
            <h3>Danh sách file</h3>
            @foreach($files as $file)

                <table>
                    <tr>
                        <td>{{$file->filename}}</td>
                    </tr>
                </table>

            @endforeach
        </div>
        <div id="product-detail">
            <h3>Chi tiết sản phẩm</h3>
            <p class="text-justify">{{strip_tags($data->description)}}</p>
        </div>
        <div id="comment">
            <h3>Bình luận</h3>
            <div class="col-md-9 comment">
                <form method="post">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input required type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="name">Tên:</label>
                        <input required type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="cm">Bình luận:</label>
                        <textarea required rows="10" id="cm" class="form-control" name="contents"></textarea>
                    </div>
                    <div class="form-group text-right">
                        <div class="form-group">
                            <input type="submit" class="btn btn-default" value="Gửi">
                        </div>

                    </div>
                    @csrf
                </form>
            </div>
        </div>
        <div id="comment-list">

           {{--  @foreach($data as $news)
                <ul>
                    <li class="com-title">
                        {{$news->com_name}}
                        <br>
                        <span>{{date('d/m/Y H:i',strtotime($news->created_at))}}</span>
                    </li>
                    <li class="com-details">
                        {{$news->com_content}}
                    </li>
                </ul>
            @endforeach --}}

        </div>
    </div>
    <!-- end main -->
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
    background: url('../img/home/cart.png') no-repeat center;
    color: #fff;
    line-height: 98px;
    font-weight: bold;
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
        margin-left: 300px;
        background: url('../img/home/icon-cart.png') no-repeat center;
        color: #fff;
        line-height: 98px;
        font-weight: bold;
    }
    #cart a:first-child{
        margin-left: -70px;
        color: #fff;
    }
    #cart a:last-child{
        margin-left: 50px;
        color: #ff6600;
    }

    #menu{
        margin-bottom: 20px;
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


.btn-danger {
    color: #fff;
    background-color: #ff9600;
    border-color: #fff;
}

.btn-danger:hover {
    color: #fff;
    background-color: #ff9600;
    border-color: #fff;
}

/* details */
#product-info h3{
    margin-top: 15px;
    font-size: 24px;
    color: #ff9600;
    text-transform: uppercase;
}
#product-details{
    padding-left: 5%;
}
#product-details p{
    padding-bottom: 12px;
}
#product-details p:first-child{
    font-size: 18px;
}
#product-details p:last-child{
    height: 65px;
    line-height: 65px;
    padding: 0px;
    background: -webkit-linear-gradient(#fe0000, #d10000);
    background: -moz-linear-gradient(#fe0000, #d10000);
}
#product-details p:last-child a{
    color: #fff;
    font-weight: bold;
    font-size: 18px;
    display: inherit ;
    /* padding: 20px 60px; */
    /* width: 100%; */
}
#product-details p:last-child a:hover{
    text-decoration: none;
}
#product-details .price{
    color: #ce0000;
    font-size: 30px;
    font-weight: bold;
}
#product-detail h3{
    margin-top: 15px;
    font-size: 24px;
    color: #ff9600;
    text-transform: uppercase;
}
#comment h3{
    margin-top: 15px;
    font-size: 24px;
    color: #ff9600;
    text-transform: uppercase;
}
.form-control{
    border-radius: 0px;
}
.btn{
    border-radius: 0px;
    background: #ff9600;
    color: #fff;
}
.btn:hover{
    background: #ff9600;
}
.comment{
    padding: 0px;
}
#comment-list ul{
    border-bottom: 1px dotted #cdcdcd;
    padding-bottom: 10px;
}
#comment-list li{
    list-style: none;
    color: #666;
    line-height: 22px;
    font-size: 12px;
}
li.com-title{
    color: #000;
    font-weight: bold;
    text-transform: capitalize;
}
li.com-title span{
    font-weight: normal;
    color: #999;
}
.comment-list{
    margin-top: 25px;
    text-align: justify;
}
/* end details */
    </style>
@endsection


@section('js-footer')



@endsection
