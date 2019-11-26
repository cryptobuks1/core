@extends('master')

@section('css')

@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bar-rating/1.2.2/jquery.barrating.min.js"></script>

@endsection

@section('content')
<!-- Main content -->
<section class="content">
  <div class="row">
    <form class="col-12">
      @include('layouts.errors')
                <div class="form-group">
                    <label for="">Đánh giá</label>
                    <div class="post-action">
                        <!-- Rating -->
                       <span style="width: 80%;background-color: gold; position: relative;">
                           <select class='rating' id='rating' data-id='rating_{{$user_id}}' style="position: absolute;">
                            <option value="1" >1</option>
                            <option value="2" >2</option>
                            <option value="3" >3</option>
                            <option value="4" >4</option>
                            <option value="5" >5</option>
                        </select>
                       </span> 
                        <div style='clear: both;'></div>
                        Average Rating : <span >{{number_format($avgStar, 1, ',', ' ')}}</span>
                    </div>
                </div>
    </form>
{{--   </div> --}}

<div class="rating">
    <div>
        <button class="btn btn-primary">Gửi đánh giá</button>
    </div>
</div>


</section>
        <script type='text/javascript'>
        </script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $(document).ready(function(){
                $('.rating').barrating({
                    theme: 'fontawesome-stars',
                    onSelect: function(value, text, event) {
                        // Get element id by data-id attribute
                        var el = this;
                        var el_id = el.$elem.data('id');
                        // rating was selected by a user
                        if (typeof(event) !== 'undefined') {
                            var split_id = el_id.split("_");
                            var postid = split_id[1]; // postid
                            // AJAX Request
                            $.ajax({
                                url: '{{route('test.votes')}}',
                                type: 'post',
                                data: {postid:postid,rating:value},
                                dataType: 'json',
                                success: function(data){
                                    // Update average
                                    $('#avgrating_'+postid).text(average);
                                }
                            });
                        }
                    }
                });
            });
        </script>
<!-- /.content -->
@endsection
