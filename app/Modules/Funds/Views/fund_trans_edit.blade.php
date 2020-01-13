@extends('master')

@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
    <style>
        .red{
            color: red;
        }
        .font-top{
            padding-left: 10px;
            display: block;
            font-size: 16px;
            display: block;
        }
        .font-top-left{
            display: block;
            font-size: 20px
        }
        .fund-info{
            font-size: 20px;
            display: block;
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
          $("#sender_fund_id").select2(
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
          $("#receiver_fund_id").select2(
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
          $("#fund-year").on('change', (function(e){
              var year = $(this).val();
            $("#year").text(year);
          }));
          $("#fund-day").on('change', (function(e){
              var year = $(this).val();
              $("#day").text(year);
          }));
          $("#fund-month").on('change', (function(e){
              var year = $(this).val();
              $("#month").text(year);
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
              <div class="card-header" style="text-align: center">
                <h3 class="card-title bg-success" style="padding: 5px; border-radius: 4px;">Chi tiết hóa đơn</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                {!! Form::model($tran, ['method' => 'PATCH','route' => ['fund-trans.update', $tran->id]]) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="card-body" style="padding-top: 0;">
                        <div class="row table-responsive">
                            <div class="col-md-12">
                                <div class="hoa-don" style="font-family: 'Times New Roman';margin: 30px; border: 1px solid #333333; width: 990px; padding: 30px">
                                    <table>
                                        <tbody style="margin: 40px">
                                        <tr>
                                            <td style="width: 15%"><img src="{{ url($settings['logo']) }}" alt=""/></td>
                                            <td  colspan="2"> <h4 style="padding-left: 10px">CÔNG TY CỔ PHẦN THƯƠNG MẠI XUẤT NHẬP KHẨU WIN</h4>
                                                <span class="font-top">Số 05 ngách 63/212/8 đường Lê Đức Thọ - Phường Mỹ Đình 2 - Quận Nam Từ Liêm - Hà Nội</span>
                                                <span class="font-top">Mã số thuế: 01083086771</span>
                                                <span class="font-top">Tel: 0943793984</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 15%"></td>
                                            <td style="text-align: center; padding-top: 30px; width: 50%" >
                                                <h2 style='text-transform: uppercase'>{{$tran->type}}</h2>
                                                <i><label style="font-size: 20px; transform: translateX(20px)">Ngày <input required name="day" id="fund-day" type="text" style="width: 25px; border: none;font-weight: 700" maxlength="2" value="{{$tran->day}}"> tháng <input required
                                                            type="text" id="fund-month" name="month" style="width: 25px; border: none;font-weight: 700" maxlength="2" value="{{$tran->month}}"> năm <input required name="year"  id="fund-year" type="text" style="width: 47px; border: none; font-weight: 700" maxlength="4" value="{{$tran->year}}"></label></i>
                                            </td>
                                            <td style="width: 35%">
                                                <span class="fund-info">Quyển số: <input type="text" style=" border: none; font-weight: 700; width: 200px"></span>
                                                <span class="fund-info">Số theo dõi: <label>{{$tran->order_code}}</label></span>
                                                <span class="fund-info">Mã đơn hàng: <label>{{$tran->id}}</label></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding-top: 10px" >
                                                <span class="fund-info">Họ và tên người @if($tran->type=='Phiếu chi')nhận @else gửi @endif tiền: {{$tran->name}}</span>
                                                <span class="fund-info">Số điện thoại: {{$tran->phone}}</span>
                                                <span class="fund-info">Địa chỉ: {{$tran->address}}</span>
                                                @if($tran->fees | $tran->tax)
                                                    <span class="fund-info">Số tiền @if($tran->type=='Phiếu chi')nhận @else gửi @endif: <label for="">{{number_format($tran->amount,0).' '.$tran->currency_code}}</label></span>
                                                    @if($tran->fees)
                                                        <span class="fund-info">Phí: <label for="">{{number_format($tran->fees,0).' '.$tran->currency_code}}</label></span>
                                                    @endif
                                                    @if($tran->tax)
                                                        <span class="fund-info">Thuế: <label for="">{{$tran->tax}}%({{number_format($tran->amount/100*$tran->tax).' '.$tran->currency_code}})</label></span>
                                                    @endif
                                                @endif
                                                <span class="fund-info" >Tổng tiền @if($tran->type=='Phiếu chi')nhận @else gửi @endif: <label for="" style="font-size: 20px">{{number_format($tran->total,0).' '.$tran->currency_code}}</label></span>
                                                <span class="fund-info">Viết bằng chữ: <label for="">{{$convert_total}} @if($tran->currency_code==='VND') đồng @endif </label></span>
                                                <span class="fund-info">Lý do: {{$tran->reason}}</span>
                                                <span class="fund-info">Ghi chú: {{$tran->description}}</span>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td style="padding-top: 10px; padding-left: 50px"> <span class="fund-info">Ngày <span id="day">{{$tran->day}}</span> tháng <span id="month">{{$tran->month}}</span> năm <span id="year">{{$tran->year}}</span></span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <div class="row fund-info" style="text-align: center; padding-top: 10px">
                                                    <div class="col-md-3 " >
                                                        <label for="">Giám đốc</label>
                                                        <p>(Ký,họ tên,đóng dấu)</p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">Thủ quỹ</label>
                                                        <p>(Ký,họ tên)</p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">Người lập phiếu</label>
                                                        <p>(Ký,họ tên)</p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">Người @if($tran->type=='Phiếu chi')nhận @else gửi @endif tiền</label>
                                                        <p>(Ký,họ tên)</p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="padding-top: 150px"><span class="fund-info">@if($tran->approved==1) Đã @if($tran->type=='Phiếu chi')nhận @else gửi @endif đủ số tiền(Viết bằng chữ): <label for="">{{$convert_total}} đồng</label> @else
                                                        <label class="badge badge-warning" style="font-size: 15px">Đợi duyệt</label>  @endif</span> </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div style="text-align: center; padding-bottom: 50px">
                                @if($tran->approved==1)
                                    <a href="{{url($backendUrl.'/fund/order/print/'.$tran->id)}}" type="button" class="btn btn-primary" id="in" title="Hãy lưu lại thông tin trước khi In"><i class="fa fa-print" aria-hidden="true"></i> In</a>
                                @endif
                            </div>

                        @if($check==true)
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="admin_note">Admin note:</label>
                                <textarea name="admin_note" id="" cols="" rows="5" placeholder="Nhập ghi chú" class="form-control">{{$tran->admin_note}}</textarea>
                            </div>
                        </div>
                        @endif
                        @csrf
                    </div>
                    <div class="row">
                        <div class="col-md-12" style=" padding-bottom: 20px">
                            <button type="submit" class="btn btn-success" onclick="this.disabled=true;this.value='Đang thực hiện...';this.form.submit();">@if($check==true)Chấp nhận @else Cập nhật @endif</button>
                            @if($check==true)
{{--                                //<button class="btn btn-primary">Chấp nhận</button>--}}
                                <a href="#" name="{{ $tran->type }}" link="{{ url($backendUrl.'/fund/order/delete/'.$tran->id) }}" class="deleteClick red id-btn-dialog2 btn btn-danger "data-toggle="modal" data-target="#deleteModal" > <i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i> Xóa phiếu</a>
                            @endif

                        <a href="{{route('fund-trans.order')}}" class="btn btn-warning">Đóng</a>
                        </div>

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
    <!-- Delete form -->
    <script type="text/javascript">
        $(document).ready(function(){
            $(".deleteClick").click(function(){
                var link = $(this).attr('link');
                var name = $(this).attr('name');
                $("#deleteForm").attr('action',link);
                $("#deleteMes").html("Delete : "+name+" ?");
            });
        });
    </script>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="deleteForm"  method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="deleteMes" class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <input type="hidden" name="_method" value="delete" />
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
    <!-- End Delete form-->
</section>
<!-- /.content -->
@endsection
