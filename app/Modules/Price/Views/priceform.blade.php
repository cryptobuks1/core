<label>Nhập giá bán:</label>
<div class="input-group form-group">
  @foreach($currencies as $currency)
  <input name="{{$currency->code.$currency->id}}" type="text" class="form-control" id="" placeholder="Giá bán">
  <div class="input-group-append">
    <span class="input-group-text">{{$currency->code}}</span>
  </div>
  @endforeach
</div>