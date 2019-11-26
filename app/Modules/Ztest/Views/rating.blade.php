@extends('frontend.'.$current_theme.'.app')
@section('title')
@section('customstyle')

@section('content')
<!-- Main content -->
<section class="content">
    <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
    <style>
        .rating i:hover{
            cursor: pointer;
        }
        .rating i{
            font-size: 1rem;
            color: gray;

        }
        .list-text{
            display: inline-block;
            margin-left: 10px;
            position: relative;
            background: #52b858;
            color: #fff;
            padding: 2px 8px;
            box-sizing: border-box;
            font-size: 12px;
            border-radius: 2px;
            margin-bottom: 10px;
            display: none;
        }
        .list-text:after{
            right: 100%;
            top:30%;
            border:solid transparent;
            content: "";
            height: 0;
            width: 0;
            position: absolute;
            border-color: rgba(82,184,88,0);
            pointer-events: none;
            border-right-color: #52b858;
            border-width: 6px;
            border-top: 6px;
        }
        .list-star .rating_active{
            color: #ff9705;
        }
        .avg-rating .active{
            color: #ff9705;
        }
        .avg-rating i{
            font-size: 1rem;
            color: gray;

        }

    </style>
     <div class="avg-rating">
        @php
        $star=number_format($avgStar,2);
        @endphp
        Average Rating :
        @for($i=1;$i<=5;$i++)
            <i class="fa fa-star {{$i<=$star ? 'active':''}}" data-key="{{$i}}"></i>
        @endfor
        <span >{{$star}}</span>

    </div>
    <br>
    <h3>Gửi đánh giá</h3>
    <a href="#" class="btn btn-primary js_rating_action">Gửi đánh giá của bạn</a>

    <div class="rating hide" >
        <form action="{{route('test.rating')}}" method="post">
        <div style="display: flex; margin-top: 10px" >
            <p >Chọn đánh giá của bạn:</p>
            <span style="margin: 0 15px" class="list-star">
                    @for($i=1;$i<=5;$i++)
                 <i class="fa fa-star" data-key="{{$i}}"></i>
                @endfor

            </span>
            <span class="list-text"></span>
            <input type="hidden" value="" class="number_rating" name="number_rating">
            <input type="hidden" name="user_id" value="{{$user_id}}">

        </div>
        <div class="form-group">
            <label>Tên của bạn:</label>
            <input style="width: 300px" type="text" class="form-control" name="name" value="" placeholder="Nhập tên của bạn">
        </div>
        <div class="form-group">
            <label>Nhận sét về sản phẩm:</label>
            <textarea style="width: 500px" name="comment" class="form-control" id="comment" placeholder="Nhập nhận sestt của bạn về sản phẩm"></textarea>
        </div>
        <div class="form-group">
             <button class="btn btn-primary">  Gửi đánh giá </button>
        </div>
         @csrf
         </form>
    </div>
</section>
<script>
     $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    $(document).ready(function() {

        listRating={
            '1':'Không thích',
            '2':'Tạm được',
            '3':'Bình thường',
            '4':'Tốt',
            '5':'Rất tốt'
        };
        let listStar=$('.list-star .fa');
        listStar.mouseover(function(event) {
            let $this=$(this);
            let number=$this.attr('data-key');
            listStar.removeClass('rating_active');

            $.each(listStar, function(key,value){
                if(key+1<= number){
                    $(this).addClass('rating_active');

                }
                else{
                }
            });
            $('.number_rating').val(number);
            $('.list-text').text(listRating[number]).show();
            console.log($this.attr('data-key'));
        });

        $('.js_rating_action').click(function(event) {
            event.preventDefault();
            $('.rating').slideToggle('slow');
            if($('.rating').hasClass('hide')){
                $('.rating').addClass('active').removeClass('hide');
            }
            else{
                $('.rating').addClass('hide').removeClass('active');
            }
        });
        $('.js_rating_action').click(function(event) {
            event.preventDefault();
        });
    });

</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.js_rating_product').click(function(event) {
            event.preventDefault();
            let number=$('.number_rating').val();
            console.log(number);
            let comment=$('#comment').val();
            if(comment && number){
                $.ajax({
                    url:'{{route('test.rating')}}',
                    type:'POST',
                    data:{number:number,comment:comment},
                    dataType: 'json',
                    success: function(data){
                    }
                })
            }
        });
    });

</script>

@endsection


@section('js-footer')
@endsection
