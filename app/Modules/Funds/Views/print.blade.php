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
            font-size: 20px;
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
      $(document).ready(function () {
          window.print();
      });
  </script>
@endsection

@section('content')
<!-- Main content -->
<section class="content">
    <script src="{{ asset('adminlte/plugins/select2/select2.full.min.js') }}"></script>
                                <div class="hoa-don" style=" width: 990px; font-family: 'Times New Roman'">
                                    <table  >
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
                                                <i><label style="font-size: 20px; transform: translateX(20px)">Ngày <input  name="day" type="text" style="width: 25px; border: none;font-weight: 700" maxlength="2" value="{{$tran->day}}"> tháng <input
                                                            type="text" name="month" style="width: 25px; border: none;font-weight: 700" maxlength="2" value="{{$tran->month}}"> năm <input name="year" type="text" style="width: 47px; border: none; font-weight: 700" maxlength="4" value="{{$tran->year}}"></label></i>
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
                                                <span class="fund-info">Viết bằng chữ: <label for="" style="text-transform: inherit">{{$convert_total}} @if($tran->currency_code==='VND')đồng @endif </label></span>
                                                <span class="fund-info">Lý do: {{$tran->reason}}</span>
                                                <span class="fund-info">Ghi chú: {{$tran->description}}</span>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td style="padding-top: 10px ;padding-left: 50px" > <span class="fund-info">Ngày <input type="text" style="width: 20px; border: none" maxlength="2" value="{{$tran->day}}"> tháng <input
                                                        type="text" style="width: 20px; border: none" maxlength="2" value="{{$tran->month}}"> năm <input type="text" maxlength="4" style="width: 40px; border: none" value="{{$tran->year}}"></span></td>
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
                                            <td colspan="3"  style="padding-top: 150px"><span class="fund-info">@if($tran->approved==1) Đã @if($tran->type=='Phiếu chi')nhận @else gửi @endif đủ số tiền(Viết bằng chữ): <label for="">{{$convert_total}} đồng</label> @else
                                                        <label class="badge badge-warning" style="font-size: 15px">Đợi duyệt</label>  @endif</span> </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>


</section>
<!-- /.content -->
@endsection
