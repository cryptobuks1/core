@extends('master')

@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
    <style>
        .red{
            color: red;
        }
    </style>
@endsection
@section('js')

  @include('ckfinder::setup')

  <script>
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $(document).ready(function () {
          $("#info1").select2(
              {
                  tags: true,
                  ajax: {
                      url: "{{ url($backendUrl.'/inventory/search/sender')  }}",
                      type: "GET",
                      dataType: 'json',
                      delay: 150,
                      data: function (params) {
                          return {
                              searchTerm: params.term // search term
                          };
                      },
                      processResults: function (response) {
                          return {
                              results: response
                          };
                      },
                      cache: true
                  }
              }
          );
          $("#info2").select2(
              {
                  tags: true,
                  ajax: {
                      url: "{{ url($backendUrl.'/inventory/search/receiver')  }}",
                      type: "GET",
                      dataType: 'json',
                      delay: 150,
                      data: function (params) {
                          return {
                              searchTerm: params.term // search term
                          };
                      },
                      processResults: function (response) {
                          return {
                              results: response
                          };
                      },
                      cache: true
                  }
              }
          );
      });
      $(document).ready(function () {
          $('#type').each(function() {
              $('#type').change(function() {
                  if ($(this).val() == 'Phiếu thu') {
                       $('#lb-fund1').text('Người nộp:');
                       $('#lb-fund2').text('Tài khoản thụ hưởng:');
                  } else if ($(this).val() == 'Phiếu chi') {
                      $('#lb-fund1').text('Người nhận:');
                      $('#lb-fund2').text('Tài khoản trích nợ:');
                  }
              });
          });
          $('#currcency_code').each(function() {
              $('#currcency_code').change(function() {
                  var a =$(this).val();
                      $('#fees').text(a);

              });
          });
      });
      $(document).ready(function() {
          $("#info1").on('change', (function(e){
              $('.info-user').remove();
              var fund= $(this).val();
              $.ajax({
                  type:'POST',
                  url:'{{ route('ajax.infouser') }}',
                  data:{code:fund},
                  success:function(data){
                      $('.customer').html(data);
                  }
              });

          }));
          $("#info2").on('change', (function(e){
              var fund= $(this).val();
              $.ajax({
                  type:'POST',
                  url:'{{ route('ajax.currency') }}',
                  data:{code:fund},
                  success:function(data){
                      $('.currency').html(data);
                  }
              });

          }));
      });
      $(document).ready(function() {
          $("#type").on('change', (function(e){
              var code = $(this).val();
              $.ajax({
                  type:'POST',
                  url:'{{ route('ajax.fund.reason') }}',
                  data:{code:code},
                  success:function(data){
                      $('#reason').html(data);
                  }
              });
          }));
      });
  </script>
@endsection

@section('content')
<!-- Main content -->
<section class="content">
    <script src="{{ asset('adminlte/plugins/select2/select2.full.min.js') }}"></script>
  <div class="row">
    <div class="col-12">
      <div class="col-md-12">
            <!-- general form elements -->
           @include('layouts.errors')
            <div class="card">
              <div class="card-header">
                <h2 style="color:#0b6998;">Tạo phiếu</h2>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::open(array('route' => 'fund-trans.post','method'=>'POST')) !!}
                <div class="card-body row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Chọn loại phiếu(<span class="red">*</span>):</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="Phiếu thu">PHIẾU THU</option>
                                    <option value="Phiếu chi">PHIẾU CHI</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="order_code">Mã Hóa Đơn</label>
                                    <input type="text" name="order_coder" value="{{$order_code}}" class="form-control" readonly required >
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="col-md-6">
                        <h3 style="color: #00aced">Thông tin khách hàng</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="info1" id="lb-fund1">Người nộp(<span class="red">*</span>):</label>
                                    <select id="info1" class="form-control select2 inv_id" name="info1" >
                                        <option value="" >Nhập tên tài khoản</option>
                                        <option value="123" >Khách hàng mới...</option>
                                    </select>
                                </div>
                                <br>
                            </div>
                            <div class="col-md-12 customer">
                                <div class="info-user">
                                    <div class="form-group">
                                        <label>Tên(<span class="red">*</span>):</label>
                                        <input type="text" name="name" class="form-control" placeholder="Nhập tên khách" required value="{{old('name')}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Số điện thoại(<span class="red">*</span>):</label>
                                        <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại" required value="{{old('phone')}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Địa chỉ(<span class="red">*</span>):</label>
                                        <input type="text" name="address" class="form-control" placeholder="Nhập địa chỉ" required value="{{old('address')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 style="color: #00aced">Thông tin phiếu</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="info2" id="lb-fund2">Tài khoản thụ hưởng(<span class="red">*</span>):</label>
                                    <select id="info2" class="form-control select2 inv_id" name="info2" required>
                                        <option value="">Nhập tên tài khoản</option>
                                    </select>
                                </div>
                                <br>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Lý do(<span class="red">*</span>):</label>
                                    <select name="reason" id="reason" class="form-control" required>
                                        <option value="Phiếu thu">-- Nhấp chọn --</option>
                                        @foreach($types as $type)
                                            <option value="{{$type->name}}">{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row" style="display: flex">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label for="amount">Số Tiền(<span class="red">*</span>):</label>
                                            <input name="amount" type="text" required class="form-control" id="amount" placeholder="Nhập số tiền muốn chuyển" value="{{ old('amount') }}" >
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="" style="padding-bottom: 18px"></label>
                                            <p style="font-size: 20px " class="currency"><label for=""> VND</label></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="fees">Phí(<span class="currency">VND</span>):</label>
                                    <input type="text" name="fees" id=""  class="form-control" placeholder="Nhập phí" value="{{old('fees')}}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tax">Thuế(%):</label>
                                    <input type="text" name="tax" id="" class="form-control" placeholder="Nhập thuế" value="{{old('tax')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Ghi chú(<span class="red">*</span>):</label>
                                    <textarea name="description" id="" cols="" rows="5" placeholder="Nhập ghi chú" class="form-control" required></textarea>
                                </div>
                            </div>
                            @if($check==true)
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="admin_note">Admin note:</label>
                                        <textarea name="admin_note" id="" cols="" rows="5" placeholder="Admin nhập ghi chú" class="form-control"></textarea>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                    <div class="col-md-12">
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success" onclick="this.disabled=true;this.value='Đang thực hiện...';this.form.submit();">Chấp nhận</button>
                            <a href="{{route('fund-trans.order')}}" class="btn btn-warning">Đóng</a>
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
