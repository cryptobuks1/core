@extends('master')

@section('css')
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
@endsection
@section('js')
  <script>
      ///Loại bỏ nút Enter
      $(document).keypress(
          function(event){
              if (event.which == '13') {
                  event.preventDefault();
              }
          });
  </script>
  <script src="{{ asset('adminlte/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
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
                <h3 class="card-title">Sửa đối tác kết nối</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

              {!! Form::model($merchant, ['method' => 'PATCH','route' => ['merchants.update', $merchant->id]]) !!}
              <div class="card-body row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">Tên đối tác:</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="Name" value="{{ $merchant->name }}" >
                  </div>
                  <div class="form-group">
                    <label for="user">Khách hàng:</label>
                    <input name="user" type="text" class="form-control" id="user" placeholder="User ID" value="{{ $merchant->user }}" >
                  </div>

                  <div class="form-group">
                    <label for="partner_id">Partner ID:</label>
                    <input name="partner_id" type="text" class="form-control" id="partner_id" placeholder="Partner ID" value="{{ $merchant->partner_id }}" >
                  </div>
                  <div class="form-group">
                    <label for="partner_key">Partner Key:</label>
                    <input name="partner_key" type="text" class="form-control" id="partner_key" placeholder="Partner Key" value="{{ $merchant->partner_key }}" >
                  </div>
                  <div class="form-group">
                    <label for="wallet_num">Địa chỉ ví:</label>
                    <input name="wallet_num" type="text" class="form-control" id="wallet_num" placeholder="Ví dụ: 00555666888" value="{{ $merchant->wallet_num }}" >
                  </div>

                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="ips">IP đối tác:</label><br>
                    <input name="ips" type="text" class="form-control" data-role="tagsinput" placeholder="Nhập IP đối tác" value="{{ $merchant->ips }}">
                  </div>
                  <div class="form-group">
                    <label for="website">Callback URL:</label>
                    <input name="callback" type="text" class="form-control" id="callback" placeholder="http://" value="{{ $merchant->callback }}">
                  </div>
                  <div class="form-group">
                    <label for="callback_type">Kiểu gọi:</label>
                    <select name="callback_type" class="form-control">
                      <option value="POST" @if($merchant->callback_type == "POST") selected @endif>POST (mặc định)</option>
                      <option value="GET" @if($merchant->callback_type == "GET") selected @endif>GET</option>
                      <option value="PUT" @if($merchant->callback_type == "PUT") selected @endif>PUT</option>
                      <option value="DELETE" @if($merchant->callback_type == "DELETE") selected @endif>DELETE</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="description">Mô tả về đối tác:</label>
                    <textarea name="description" id="description" class="form-control" placeholder="Mô tả">{{ $merchant->description }}</textarea>
                  </div>

                  <div class="form-group">
                    <label for="status">Status:</label>
                    <input name="status" id="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;" @if($merchant->status ==1)checked="checked @endif">
                    <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                      <div class="Toggle"></div>
                    </div>
                  </div>

                </div>

              </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
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
    </div>
  <!-- /.col -->
  </div>
<!-- /.row -->
</section>
<!-- /.content -->
@endsection