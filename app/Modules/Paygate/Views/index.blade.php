@extends('master')

@section('css')

@endsection

@section('js')
@endsection

@section('content')
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-12">
      @include('layouts.errors')
<div class="card">

  <div class="card-header" style="border-bottom: 0">
    <h3 class="card-title">Danh sách đã cài đặt</h3>
  </div>
  <!-- /.card-header -->
  <form action="{{ url($backendUrl.'/paygates/actions') }}" method="POST">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div class="card-body" style="padding-top: 0;">
    <div class="row"><div class="col-sm-12">
    <table id="example1" class="table table-bordered table-striped dataTable">
      <thead>
        <tr>
          <th class="center sorting_disabled" rowspan="1" colspan="1" aria-label="">
            <label class="pos-rel">
              <input type="checkbox" class="ace" id="checkall">
              <span class="lbl"></span> </label>
          </th>
          <th>Tên</th>
          <th>Mã</th>
          <th>Tiền tệ</th>
          <th>Cho thanh toán</th>
          <th>Cho nạp tiền</th>
          <th>Cho rút tiền</th>
          <th>Trạng thái</th>
          <th>Ngày tạo</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>

      @foreach( $paygates as $paygate )
        <tr>
          <td class="center"><label class="pos-rel">
              <input type="checkbox" class="ace mycheckbox" value="{{ $paygate->id }}" name="check[]">
              <span class="lbl"></span> </label>
          </td>
          <td>{{ $paygate->name }}</td>
          <td>{{ $paygate->code }}</td>
          <td>{{ $paygate->currency_code }}</td>
            <td>
                @if($paygate->default['payment'])
                <div data-table="paygates" data-id="{{ $paygate->id }}" data-col="payment" class="Switch Round @if($paygate->payment == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                    <div class="Toggle" ></div>
                </div>
                    @endif
            </td>
            <td>
                @if($paygate->default['deposit'])
                <div data-table="paygates" data-id="{{ $paygate->id }}" data-col="deposit" class="Switch Round @if($paygate->deposit == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                    <div class="Toggle" ></div>
                </div>
                    @endif
            </td>

            <td>
                @if($paygate->default['withdraw'])
                <div data-table="paygates" data-id="{{ $paygate->id }}" data-col="withdraw" class="Switch Round @if($paygate->withdraw == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                    <div class="Toggle" ></div>
                </div>
                    @endif
            </td>

            <td>
                <div data-table="paygates" data-id="{{ $paygate->id }}" data-col="status" class="Switch Round @if($paygate->status == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                    <div class="Toggle" ></div>
                </div>
            </td>

            <td>{{ $paygate->created_at }}</td>
          <td>
            <div class="action-buttons">
             <a href="{{ url($backendUrl.'/paygates/'.$paygate->id.'/edit') }}"> <span class="btn btn-sm btn-info"><i title="Sửa" class="ace-icon fa fa-pencil bigger-130"></i></span></a>

                <a href="#" name="{{ $paygate->name }}" link="{{ url($backendUrl.'/paygates/'.$paygate->id) }}" class="deleteClick red id-btn-dialog2" data-toggle="modal" data-target="#deleteModal" > <span class="btn btn-sm btn-danger"><i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></span></a>

            </div>
          </td>
        </tr>
      @endforeach
      </tbody>

    </table>
  </div></div>

      </div>
 </form>


    <div class="card-body" style="padding-top: 0;">
        <div class="card-header" style="border-bottom: 0">
            <h3 class="card-title">Danh sách cổng thanh toán</h3>
        </div>


    @if( $listGateway )
        <table class="table table-bordered">
            <tbody>
            <tr>
                <th style="width: 10px">#</th>
                <th>Tên</th>
                <th>Mã cổng</th>
                <th>Tiền tệ mặc định</th>
                <th>Hỗ trợ thanh toán</th>
                <th>Phiên bản</th>
                <th style="width: 40px">Hành động</th>
            </tr>
            @foreach( $listGateway as $index => $gateway )
                <tr>
                    <td>{{ $index }}</td>
                    <td>{{ $gateway['name'] }}</td>
                    <td>{{ $gateway['code'] }}</td>
                    <td>{{ $gateway['currency_code'] }}</td>
                    <td>{{ $gateway['bankcode'] }}</td>
                    <td>{{ $gateway['version'] }}</td>
                    <td>
                        <a href="{{url($backendUrl.'/paygates/add/'.$gateway['code'])}}">
                            <span type="submit" class="btn btn-sm btn-success"><i class="ace-icon fa fa-check-circle"></i> Thêm</span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
@endif
    </div>


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
        <form id="deleteForm" action="" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
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
  <!-- /.card-body -->
</div>
<!-- /.card -->
</div>
  <!-- /.col -->
</div>
<!-- /.row -->
</section>
<!-- /.content -->
@endsection
