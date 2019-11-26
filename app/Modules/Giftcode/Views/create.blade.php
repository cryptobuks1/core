@extends('master')

@section('css')

@endsection
@section('js')
  @include('ckfinder::setup')
@endsection

@section('content')
<!-- Main content -->
<section class="content">
  @include('layouts.errors')

  <div class="row">

        <div class="col-md-3">
          <div class="card card-light">
            <div class="card-header">
              <h3 class="card-title">Thẻ nạp số dư</h3>
            </div>
            {!! Form::open(array('route' => 'giftcode.prepaid','method'=>'POST')) !!}
            <div class="card-body row">
              <div class="col-md-12">

                <div class="form-group">
                  <label for="name">Tên:</label>
                  <input name="name" type="text" class="form-control" id="name" placeholder="Tên" value="Thẻ nạp tiền" >
                </div>
                <div class="form-group">
                  <label for="qty">Số lượng:</label>
                  <input name="qty" type="number" class="form-control" id="qty" value="10">
                </div>

                <div class="form-group">
                  <label for="currency">Loại tiền tệ:</label>
                  <select class="form-control" name="currency">
                    @if(count($currency) > 0)
                    @foreach($currency as $cr)
                        <option value="{{$cr->id}}">{{$cr->name}} ({{$cr->code}})</option>
                      @endforeach
                    @endif
                  </select>
                </div>
                <div class="form-group">
                  <label for="value">Giá trị thẻ:</label>
                  <input name="value" type="number" class="form-control" id="value" value="100000">
                </div>

                <div class="form-group">
                  <label for="expired_at">Hạn sử dụng (ngày):</label>
                  <input name="expired_at" type="number" class="form-control" id="expired_at" value="90">
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Thêm</button>
            </div>
            {!! Form::close() !!}
          </div>

        </div>
        <div class="col-md-3">

          <div class="card card-light">
            <div class="card-header">
              <h3 class="card-title">Thẻ giảm giá</h3>
            </div>
            {!! Form::open(array('route' => 'giftcode.discount','method'=>'POST')) !!}
            <div class="card-body row">
              <div class="col-md-12">

                <div class="form-group">
                  <label for="name">Tên:</label>
                  <input name="name" type="text" class="form-control" id="name" placeholder="Thẻ giảm giá" value="Thẻ giảm giá" >
                </div>
                <div class="form-group">
                  <label for="url">Số lượng:</label>
                  <input name="qty" type="number" class="form-control" id="qty" value="10">
                </div>

                <div class="form-group">
                  <label for="discount">Giá trị giảm giá (%):</label>
                  <input name="discount" type="text" class="form-control" id="discount" value="10">
                </div>

                <div class="form-group">
                  <label for="model">Tên mô-đun:</label>
                  <select class="form-control" name="model">
                    <option value="">--- Chọn ---</option>
                    @if(count($listvendors) > 0)
                      @foreach($listvendors as $vendor)
                    <option value="{{$vendor}}">{{$vendor}}</option>
                      @endforeach
                      @endif
                  </select>
                </div>

                <div class="form-group">
                  <label for="url">Mã SKU</label>
                  <input name="sku" type="text" class="form-control" id="sku" value="">
                </div>

                <div class="form-group">
                  <label for="usetime">Số lần được sử dụng:</label>
                  <input name="usetime" type="number" class="form-control" id="usetime" value="1">
                </div>

                <div class="form-group">
                  <label for="expired_at">Hạn sử dụng (ngày):</label>
                  <input name="expired_at" type="number" class="form-control" id="expired_at" value="90">
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Thêm</button>
            </div>
            {!! Form::close() !!}
          </div>
        </div>
        <div class="col-md-3">

          <div class="card card-light">
            <div class="card-header">
              <h3 class="card-title">Thẻ gia hạn dịch vụ</h3>
            </div>
            {!! Form::open(array('route' => 'giftcode.renewservice','method'=>'POST')) !!}
            <div class="card-body row">
              <div class="col-md-12">

                <div class="form-group">
                  <label for="name">Tên:</label>
                  <input name="name" type="text" class="form-control" id="name" placeholder="Tên" value="Thẻ gia hạn" >
                </div>
                <div class="form-group">
                  <label for="url">Số lượng:</label>
                  <input name="qty" type="number" class="form-control" id="qty" value="10">
                </div>

                <div class="form-group">
                  <label for="model">Tên mô-đun:</label>
                  <select class="form-control" name="model">
                    <option value="">--- Chọn ---</option>
                    @if(count($listvendors) > 0)
                      @foreach($listvendors as $vendor)
                        <option value="{{$vendor}}">{{$vendor}}</option>
                      @endforeach
                    @endif
                  </select>
                </div>
                <div class="form-group">
                  <label for="sku">Mã SKU:</label>
                  <input name="sku" type="text" class="form-control" value="">
                </div>
                <div class="form-group">
                  <label for="premiumday">Ngày gia hạn:</label>
                  <input name="premiumday" type="number" class="form-control" id="sku" value="30">
                </div>

                <div class="form-group">
                  <label for="expired_at">Hạn sử dụng (ngày):</label>
                  <input name="expired_at" type="number" class="form-control" id="expired_at" value="90">
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Thêm</button>
            </div>
            {!! Form::close() !!}
          </div>

        </div>

    <div class="col-md-3">

      <div class="card card-light">
        <div class="card-header">
          <h3 class="card-title">Thẻ mua dịch vụ</h3>
        </div>
        {!! Form::open(array('route' => 'giftcode.buyservice','method'=>'POST')) !!}
        <div class="card-body row">
          <div class="col-md-12">

            <div class="form-group">
              <label for="name">Tên:</label>
              <input name="name" type="text" class="form-control" id="name" placeholder="Tên" value="Thẻ mua dịch vụ" >
            </div>
            <div class="form-group">
              <label for="url">Số lượng:</label>
              <input name="qty" type="number" class="form-control" id="qty" value="10">
            </div>

            <div class="form-group">
              <label for="model">Tên mô-đun:</label>
              <select class="form-control" name="model">
                <option value="">--- Chọn ---</option>
                @if(count($listvendors) > 0)
                  @foreach($listvendors as $vendor)
                    <option value="{{$vendor}}">{{$vendor}}</option>
                  @endforeach
                @endif
              </select>
            </div>
            <div class="form-group">
              <label for="sku">Mã SKU:</label>
              <input name="sku" type="text" class="form-control" value="">
            </div>
            <div class="form-group">
              <label for="expired_at">Hạn sử dụng (ngày):</label>
              <input name="expired_at" type="number" class="form-control" id="expired_at" value="90">
            </div>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Thêm</button>
        </div>
        {!! Form::close() !!}
      </div>

    </div>


    </div>
            <!-- /.card -->


    <!-- /.card -->
    </div>
  <!-- /.col -->
  </div>
<!-- /.row -->
</section>
<!-- /.content -->
@endsection