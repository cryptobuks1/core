@extends('master')

@section('css')

@endsection
@section('js')
  @include('ckfinder::setup')
@endsection

@section('content')
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="col-md-12">
            <!-- general form elements -->

           @include('layouts.errors')

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Thêm ngân hàng</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::open(array('route' => 'localbank.store','method'=>'POST')) !!}
                <div class="card-body row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="code">Mã ngân hàng:</label>
                      <input name="code" type="text" class="form-control" id="code" placeholder="Ví dụ: VCB" value="{{ old('code') }}" >
                    </div>
                    <div class="form-group">
                      <label for="name">Tên ngân hàng:</label>
                      <input name="name" type="text" class="form-control" id="name" placeholder="Name" value="{{ old('name') }}" >
                    </div>
                    <div class="form-group">
                      <label for="acc_num">Số tài khoản:</label>
                      <input name="acc_num" type="text" class="form-control" id="acc_num" placeholder="Account number" value="{{ old('acc_num') }}" >
                    </div>
                    <div class="form-group">
                      <label for="card_num">Số thẻ ATM (không bắt buộc):</label>
                      <input name="card_num" type="text" class="form-control" id="card_num" placeholder="ATM card" value="{{ old('card_num') }}" >
                    </div>
                    <div class="form-group">
                      <label for="acc_name">Tên tài khoản:</label>
                      <input name="acc_name" type="text" class="form-control" id="acc_name" placeholder="Account name" value="{{ old('acc_name') }}" >
                    </div>

                    <div class="form-group">
                      <label for="branch">Chi nhánh:</label>
                      <input name="branch" type="text" class="form-control" id="branch" placeholder="Branch" value="{{ old('branch') }}" >
                    </div>
                    <div class="form-group">
                      <label for="link">Website:</label>
                      <input name="link" type="text" class="form-control" id="link" placeholder="https://" value="{{ old('link') }}" >
                    </div>
                  </div>

                  <div class="col-md-6">

                    <div class="form-group row">
                      <label for="icon">Ảnh logo:</label>

                      <div>
                        <img id="logo-icon" class="imgPreview" src="{{ old('icon') }}"/>
                        <input type="hidden" name="icon" id="icon" class="inputImg" value=""/>
                      </div>
                      <div style="margin-left: 15px">
                        <button type="button" class="btn btn-default"
                                onclick="selectFileWithCKFinder('icon', 'logo-icon')">Chọn ảnh
                        </button>

                      </div>


                    </div>
                    <div class="form-group">
                      <label for="info">Mô tả:</label>
                      <textarea name="info" id="info" class="form-control" placeholder="Info">{{ old('info') }}</textarea>
                    </div>

                    <div class="form-group">
                      <label for="deposit">Cho nạp:</label>
                      <input name="deposit" id="deposit" type="checkbox" value="deposit" data-toggle="toggle" style="display: none;" checked="checked">
                      <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                        <div class="Toggle"></div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="withdraw">Cho rút:</label>
                      <input name="withdraw" id="withdraw" type="checkbox" value="withdraw" data-toggle="toggle" style="display: none;" checked="checked">
                      <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                        <div class="Toggle"></div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="status">Trạng thái:</label>
                      <input name="status" id="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;" checked="checked">
                      <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                        <div class="Toggle"></div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="name">Thứ tự:</label>
                      <input name="sort" type="text" class="form-control" id="sort" value="0">
                    </div>

                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Thêm ngân hàng</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.card -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
