@extends('master')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css"/>


    <style>
        .red{
            color: red;
        }
        #preview img{
            padding: 10px;
        }
    </style>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>

    <script>
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $(document).ready(function() {
          $("#tour-type").on('change', (function(e){
              var code= $(this).val();
              $.ajax({
                  type:'POST',
                  url:'{{ route('ajax.tour.type') }}',
                  data:{code:code},
                  success:function(data){
                      $('#tour-type2').html(data);
                  }
              });
              $('#tour-type').each(function() {
                      if ($(this).val() == 'domestic') {
                          $('.countries').hide();
                          $('#countries').val('');
                      } else if ($(this).val() == 'foreign') {
                          $('.countries').show();
                      }
              });
          }));
      });
  </script>
    <script>
        $(function () {
            $("#start_day, #end_day, #converge_time").datetimepicker({
                dateFormat: 'dd-mm-yy',
                timeFormat: 'HH:mm:ss',
                minDate:'0D',
                stepHour: 1,
                stepMinute: 5,
                stepSecond: 10
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
                    <h3 class="card-title">Thêm thông tin cho Tour: {{$tour->name}}</h3>
                </div>
              <!-- /.card-header -->
                {!! Form::open(array('route' => ['tour.details.store', $tour->id],'method'=>'POST','enctype'=>'multipart/form-data')) !!}
                    <div class="card-body row">
                        <div class="tt-chung col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 style="color: #00aced">
                                                Thông tin về thời gian
                                            </h4>
                                            <hr>
                                        </div>
                                        <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Ngày đi(<span class="red">*</span>):</label>
                                                    <input type="text" class="form-control" placeholder="Chọn ngày đi" id="start_day" name="start_day" value="{{ trim(date('d-m-Y H:i', time()))}}">
                                                </div>
                                        </div>
                                        <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Chuyến bay đi:</label>
                                                    <input type="text" class="form-control" placeholder="Nhập mã chuyến bay đi" id="ticket_start" name="ticket_start" value="{{old('ticket_start')}}">
                                                </div>
                                        </div>
                                        <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Ngày về(<span class="red">*</span>):</label>
                                                    <input type="text" class="form-control" placeholder="Chọn ngày về" id="end_day" name="end_day" value="{{ trim(date('d-m-Y H:i', time()))}}">
                                                </div>
                                        </div>
                                        <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Chuyến bay về:</label>
                                                    <input type="text" class="form-control" placeholder="Nhập mã chuyến bay về" id="ticket_end" name="ticket_end" value="{{old('ticket_end')}}">
                                                </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Thời gian tập chung(<span class="red">*</span>):</label>
                                                    <input type="text" name="converge_time" id="converge_time" class="form-control" placeholder="Nhập ngày tập chung" value="{{trim(date('d-m-Y H:i', time()))}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Địa điểm tập chung(<span class="red">*</span>):</label>
                                                <input type="text" name="converge_place" class="form-control" placeholder="Nhập địa điểm gian tập chung" value="{{old('converge_place')}}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 style="color: #00aced">
                                                Thông tin chi phí
                                            </h4>
                                            <hr>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                @foreach($currencies as $item)
                                                <div class="col-md-4">
                                                    <div class="col-md-12">
                                                        <div class="col-md-12">
                                                            <h5 style="color: #00aced">Giá Tour({{$item->code}})</h5>
                                                            <hr>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Giá người lớn từ 12 tuổi trở lên:</label>
                                                            <input type="text" name="price[{{$item->code}}][adults]" class="form-control" placeholder="Nhập giá"  value="0">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Giá trẻ em từ 2 tuổi đến dưới 12 tuổi:</label>
                                                            <input type="text" name="price[{{$item->code}}][children]" class="form-control" placeholder="Nhập giá" value="0">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Giá em bé dưới 2 tuổi:</label>
                                                            <input type="text" name="price[{{$item->code}}][kid]" class="form-control" placeholder="Nhập giá" value="0">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="col-md-12">
                                                            <h5 style="color: #00aced">Phí({{$item->code}})</h5>
                                                            <hr>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Phụ thu phòng đơn:</label>
                                                            <input type="text" name="fees[{{$item->code}}][room]" class="form-control" placeholder="Nhập phí" value="0">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Phụ thu visa tái nhập Việt Nam:</label>
                                                            <input type="text" name="fees[{{$item->code}}][visa]" class="form-control" placeholder="Nhập phí" value="0">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Các phí phát sinh khác:</label>
                                                            <input type="text" name="fees[{{$item->code}}][other]" class="form-control" placeholder="Nhập phí" value="0">
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            <hr>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 style="color: #00aced">Giá Land</h5>
                                                    <hr>
                                                </div>
                                                @foreach($currencies as $item)
                                                    <div class="col-md-4">
                                                        <div class="col-md-12">
                                                            <div class="col-md-12">
                                                                <h5 style="color: #00aced">Giá Tour Land({{$item->code}})</h5>
                                                                <hr>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Giá người lớn từ 12 tuổi trở lên:</label>
                                                                <input type="text" name="price_land[{{$item->code}}][adults]" class="form-control" placeholder="Nhập giá"  value="0">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Giá trẻ em từ 2 tuổi đến dưới 12 tuổi:</label>
                                                                <input type="text" name="price_land[{{$item->code}}][children]" class="form-control" placeholder="Nhập giá"  value="0">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Giá em bé dưới 2 tuổi:</label>
                                                                <input type="text" name="price_land[{{$item->code}}][kid]" class="form-control" placeholder="Nhập giá"  value="0">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="col-md-12">
                                                                <h5 style="color: #00aced">Phí Land({{$item->code}})</h5>
                                                                <hr>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Phụ thu phòng đơn:</label>
                                                                <input type="text" name="fees_land[{{$item->code}}][room]" class="form-control" placeholder="Nhập phí"  value="0">
                                                            </div>
                                                        </div>
                                                        @if($tour->type_tour=='foreign')
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Phụ thu visa tái nhập Việt Nam:</label>
                                                                    <input type="text" name="fees_land[{{$item->code}}][visa]" class="form-control" placeholder="Nhập phí"  value="0">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Các phí phát sinh khác:</label>
                                                                <input type="text" name="fees_land[{{$item->code}}][other]" class="form-control" placeholder="Nhập phí"  value="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <hr>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Khuyến Mãi(%)</label>
                                                <input type="text" class="form-control" name="discount" value="0" placeholder="Khuyến mãi theo %">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 style="color: #00aced">
                                                Thông tin chung khác
                                            </h4>
                                            <hr>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h5>Thông tin khách sạn</h5>
                                                            <hr>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Tên khách sạn:</label>
                                                                <input type="text" name="hotel[name]" class="form-control" placeholder="Nhập tên khách sạn" value="{{ old('hotel[name]')}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Địa chỉ khách sạn:</label>
                                                                <input type="text" name="hotel[address]" class="form-control" placeholder="Nhập đia chỉ khách sạn" value="{{ old('hotel[address]')}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Số điện thoại khách sạn:</label>
                                                                <input type="text" name="hotel[phone]" class="form-control" placeholder="Nhập SDT khách sạn" value="{{ old('hotel[phone]')}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Website khách sạn:</label>
                                                                <input type="text" name="hotel[website]" class="form-control" placeholder="Nhập website khách sạn" value="{{ old('hotel[website]')}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h5>Thông tin khác</h5>
                                                            <hr>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Nơi khởi hành(<span class="red">*</span>):</label>
                                                                <input type="text" name="start_place" class="form-control" placeholder="Nhập nơi khởi hành" value="{{old('start_place')}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Số người(<span class="red">*</span>):</label>
                                                                <input type="number" name="total" class="form-control" placeholder="Nhập số người" value="{{old('total')}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Hướng dẫn viên:</label>
                                                                <input type="text" name="tour_guide" class="form-control" placeholder="Tên hướng dẫn viên" value="{{old('tour_guide')}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- /.card-body -->
                    <div class="col-md-12">
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Thêm</button>
                            <a href="{{ url($backendUrl.'/tour/details/list/'.$tour->id) }}" class="btn btn-warning">Đóng</a>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
            <!-- /.card -->
              </div>

            <!-- /.card-body -->
      </div>
  </div>


</section>
<!-- /.content -->
@endsection
