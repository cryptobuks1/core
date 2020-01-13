@extends('master')

@section('css')

@endsection
@section('js')
  @include('ckfinder::setup')
  <script>
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $(document).ready(function() {
          $("#bank_code").on('change', (function(e){
              var bank= $(this).val();
              $.ajax({
                  type:'POST',
                  url:'{{ route('ajax.bank_num') }}',
                  data:{code_num:bank},
                  success:function(data){
                      $('#acc_num').html(data);
                  }
              });
              $.ajax({
                  type:'POST',
                  url:'{{ route('ajax.bank_name') }}',
                  data:{code_name:bank},
                  success:function(data){
                      $('#acc_name').html(data);
                  }
              });
          }));
      });
      $(document).ready(function() {
          $("#balance").keyup (function(e){
              var number= $(this).val();
              $.ajax({
                  type:'POST',
                  url:'{{ route('ajax.fund.number') }}',
                  data:{code:number},
                  success:function(data){
                      $('#balance-number').html(data);
                  }
              });
          });
          $('#type').each(function() {
              $('#type').change(function() {
                  if ($(this).val() == 'cash') {
                      $('.bank').hide();
                      $('.bank-info').removeAttr('required');
                  } else if ($(this).val() == 'bank') {
                      $('.bank').show();
                      $('.bank-info').addAttr('required');

                  }
              });
          });
      });

  </script>
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
                    <h3 class="card-title">Thêm</h3>
                </div>
              <!-- /.card-header -->
              <!-- form start -->

                {!! Form::open(array('route' => 'fund.store','method'=>'POST')) !!}
                    <div class="card-body row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Tên:</label>
                      <input name="name" type="text" required class="form-control" id="code" placeholder="Name" value="{{ old('name') }}" >
                    </div>
                  </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label >Loại:</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="bank">Tài khoản ngân hàng</option>
                                <option value="cash">Tài khoản tiền mặt</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 bank">
                        <div class="form-group">
                            <label for="type">Ngân hàng:</label>
                            <select name="bank_code" id="bank_code" class="form-control bank-info" required >
                                <option value="">Chọn ngân hàng</option>
                                @foreach($localbanks as $bank)
                                <option value="{{$bank->paygate_code}}">{{$bank->name}}</option>
                                @endforeach
                                <option value="Cash">Tiền mặt</option>
                            </select>
                        </div>
                    </div>
                      <div class="col-md-6 bank">
                          <div class="form-group">
                              <label for="acc_num">Số tài khoản:</label>
                              <span id="">
                                  <input name="acc_number" type="text" required class="form-control bank-info" placeholder="Account number" value="{{ old('acc_num') }}" >
                              </span>
                          </div>
                      </div>
                    <div class="col-md-6 bank">
                        <div class="form-group">
                            <label for="acc_name">Tên chủ tài khoản:</label>
                            <span id="">
                                <input name="acc_name" type="text" required class="form-control bank-info" placeholder="Account name" value="{{ old('acc_name') }}" >
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6 bank">
                        <div class="form-group">
                            <label for="acc_branch">Chi nhánh:</label>
                            <input name="acc_branch" type="text" required class="form-control bank-info" id="acc_branch" placeholder="Branch" value="{{ old('acc_branch') }}" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row" style="display: flex">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="balance">Số dư:</label>
                                    <input name="balance" type="text" class="form-control" id="balance" placeholder="Balance" value="{{ old('balance') }}" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Đơn vị tiền:</label>
                                    <select name="currency_code"  class="form-control" required>
                                        @foreach($currencies as $item)
                                            <option value="{{$item->code}}">{{$item->code}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="status">Trạng thái:</label>
                        <select name="status"  class="form-control">
                            <option value="Bật">Bật</option>
                            <option value="Tắt">Tắt</option>
                        </select>
                      </div>
                    </div>
                </div>
                <!-- /.card-body -->
                    <div class="col-md-12">
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Thêm</button>
                            <a href="{{route('fund.index')}}" class="btn btn-warning">Đóng</a>
                        </div>
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
