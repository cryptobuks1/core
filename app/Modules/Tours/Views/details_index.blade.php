@extends('master')

@section('css')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css"/>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('adminlte/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('adminlte/plugins/fastclick/fastclick.js') }}"></script>
<script>
    $(function () {
        $("#start_day, #end_day, #converge_time").datetimepicker({
            dateFormat: 'dd-mm-yy',
            timeFormat: 'HH:mm:ss',
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
      @include('layouts.errors')
<div class="card">
  <div class="card-header" style="border-bottom: 0">
      <div class="row">
          <div class="col-md-12">
              <h3 class="card-title">Lịch bay {{$tour->name}}</h3>
          </div>
      </div>
    <div class="float-right" style="margin-right: 150px">
      <a href="{{ url($backendUrl.'/tour/detail/create/'.$tour->id) }}"><button class="btn btn-success"><i class="fa fa-plus-circle"></i> Thêm</button></a> |
        <a href="{{ url($backendUrl.'/tour') }}"><button class="btn btn-warning">Quay lại</button></a>
    </div>
    <div class="card-tools ">
      <div class="input-group input-group-sm dataTables_filter" style="width: 150px;">
        <form action="" name="formSearch" method="GET" >
          <input type="text" name="keyword" class="form-control float-right" placeholder="Search" style="padding-right: 42px;">
          <div class="input-group-append" style="margin-left: 110px">
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
          </div>
        </form>
      </div>
    </div>
      <div class="card-tools " style="float: left;position: relative;right: 0px;left: 0px; padding-top: 20px">
          <div class="input-group input-group-sm dataTables_filter" style="">
              <form action="" name="formSearch" method="GET" >
                  <div class="input-group">
                              <input type="text" class="form-control" placeholder="Từ ngày" id="start_day" name="start_day" value="@if(app("request")->input("start_day")){{ trim(app("request")->input("start_day"))}}@endif">
                              <input type="text" class="form-control" placeholder="Đến ngày" id="end_day" name="end_day" value="@if(app("request")->input("end_day")){{ trim(app("request")->input("end_day"))}}@endif">
                      <div class="input-group-append">
                          <button type="submit" name="submit" value="filter" class="btn btn-warning"><i class="fa fa-search"></i> Lọc</button>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>
  <!-- /.card-header -->
  <form action="" method="POST">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div class="card-body" style="padding-top: 0;">
    <div class="row table-responsive"><div class="col-sm-12">
    <table id="example1" class="table table-bordered table-striped dataTable">
      <thead>
        <tr>
          <th class="center sorting_disabled" rowspan="1" colspan="1" aria-label="">
            <label class="pos-rel">
              <input type="checkbox" class="ace" id="checkall">
              <span class="lbl"></span> </label>
            </th>
            <th>Ngày đi</th>
            <th>Ngày về</th>
            <th>Giá cơ bản</th>
            <th>Nơi khởi hành</th>
            <th>Số người</th>
            <th>Trạng thái</th>
            <th>Action</th>
        </tr>
      </thead>
      <tbody>
      @if(count($datas)>0)
        @foreach( $datas as $data )
        <tr>
            <td class="center"><label class="pos-rel">
                <input type="checkbox" class="ace mycheckbox" value="{{ $data->id }}" name="check[]">
                <span class="lbl"></span> </label>
            </td>
            <td>{{\Carbon\Carbon::parse($data->start_day)->format('d-m-Y H:i')}}</td>
            <td>{{\Carbon\Carbon::parse($data->end_day)->format('d-m-Y H:i')}}</td>
            <td>@if(isset($data->price['VND']["adults"]))
                {{number_format($data->price['VND']["adults"])}} VND
                @endif
            </td>
            <td></td>
            <td>{{$data->total}} người</td>
            <td>
               <div data-table="tour_details" data-id="{{ $data->id }}" data-col="status" class="Switch Round @if($data->status == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                   <div class="Toggle" ></div>
               </div>
            </td>
            <td>
            <div class="action-buttons" >
                <span style="display: flex">
                   <a href="{{ url($backendUrl.'/tour/detail/edit/'.$data->id) }}"> <i title="Sửa" class="ace-icon fa fa-pencil bigger-130 btn btn-warning"></i> </a>  ||
                <a href="#" name="{{ $data->name }}" link="{{ url($backendUrl.'/tour/detail/delete/'.$data->id) }}" class="deleteClick red id-btn-dialog2 btn btn-danger"data-toggle="modal" data-target="#deleteModal" > <i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></a>
                </span>
            </div>
          </td>
        </tr>
      @endforeach
      @else
        <span>Không có dữ liệu</span>
      @endif
      </tbody>
    </table>
  </div></div>
{{$datas->links()}}
  </div></form>
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
