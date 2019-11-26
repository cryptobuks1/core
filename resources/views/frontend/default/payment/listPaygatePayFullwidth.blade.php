<style>
    #mtopup-form ul {
        padding: 0;
    }
    #mtopup-form li {
        padding:5px;
        list-style:none;
        display:inline-block;
    }
    #mtopup-form img{
        width:100%;
    }

    #mtopup-form  li.active{
        border:3px solid #42b873;
        padding:0px;
    }
    #mtopup-form input[type=radio]{
        display:none;
    }


</style>
<div class="clearfix" style="margin-bottom: 15px"></div>
<div class="text-left">
    <div class="title"><strong>Phương thức thanh toán:</strong></div>
    <div class="row">
    <div class="col-md-12">
    <select name="paygate_code" class="form-control" style="padding: 0px">
        @if(count($paygates)>0)
            @foreach($paygates as $paygate)
                <option value="{{$paygate['paygate']}}.{{$paygate['code']}}">{{$paygate['name']}}</option>
            @endforeach
        @endif
    </select>
    </div>
    </div>
</div>
<br>
