{!! Form::open(array('route' => 'frontend.giftcode.redeem','method'=>'POST')) !!}
<label>Nhập mã quà tặng:</label>
<div class="form-group">
    <input type="text" class="form-control" name="giftcode" placeholder="GCxxxxxxxxx">
</div>
<button class="btn btn-success" type="submit">Nạp mã quà tặng</button>
{!! Form::close() !!}