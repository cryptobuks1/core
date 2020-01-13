@extends('master')

@section('css')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap4.css') }}">
@endsection

@section('js')
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('adminlte/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('adminlte/plugins/fastclick/fastclick.js') }}"></script>

<script !src="">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        $("#type").on('change', (function(e) {
            var code = $(this).val();
            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.tour.type') }}',
                data: {code: code},
                success: function (data) {
                    $('#type_tour').html(data);
                }
            });
        }));
    });
</script>

@endsection

@section('content')
<!-- Main content -->
<section class="content">
  <div class="row">
      <h3 class="card-title" style="text-transform: uppercase">Danh sách phòng khách sạn: {{$hotel->name}}</h3>
    <div class="col-12">
      @include('layouts.errors')
<div class="card">
  <div class="card-header" style="border-bottom: 0">
          <div class="float-right" style="margin-right: 150px">
              <a href="{{ url($backendUrl.'/room/create/'.$hotel->id) }}"><button class="btn btn-success"><i class="fa fa-plus-circle"></i> Thêm</button></a> | <a href="{{ url($backendUrl.'/hotel') }}"><button class="btn btn-warning">Quay lại</button></a>
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
{{--      <div class="card-tools " style="float: left;position: relative;right: 0px;left: 0px; padding-top: 20px">--}}
{{--          <div class="input-group input-group-sm dataTables_filter" style="">--}}
{{--              <form action="" name="formSearch" method="GET" >--}}
{{--                  <div class="input-group">--}}
{{--                      <select name="type" class="form-control" style="" id="type">--}}
{{--                          <option value="" @if(app("request")->input("type")== "") selected="selected" @endif>--Lọc theo loại du lịch--</option>--}}
{{--                          <option value="domestic" @if(app("request")->input("type")== 'domestic') selected="selected" @endif>Trong nước</option>--}}
{{--                          <option value="foreign" @if(app("request")->input("type")== 'foreign') selected="selected" @endif>Ngoài nước</option>--}}
{{--                      </select>--}}
{{--                      <select name="type_tour" id="type_tour" class="form-control">--}}
{{--                          <option value="" @if(app("request")->input("type_tour")== "") selected="selected" @endif>--Lọc theo loại Tour--</option>--}}
{{--                          @if(app("request")->input("type"))--}}
{{--                              @foreach($type_tours as $item)--}}
{{--                                  <option value="{{$item->id}}" @if(app("request")->input("type")==$item->type && app("request")->input("type_tour")==$item->id) selected="selected" @endif>{{$item->name}}</option>--}}
{{--                              @endforeach--}}
{{--                          @endif--}}
{{--                      </select>--}}
{{--                      <div class="input-group-append">--}}
{{--                          <button type="submit" name="submit" value="filter" class="btn btn-warning"><i class="fa fa-search"></i> Lọc</button>--}}
{{--                      </div>--}}
{{--                  </div>--}}
{{--              </form>--}}
{{--          </div>--}}
{{--      </div>--}}

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
            <th>ID</th>
            <th>Mã phòng</th>
            <th>Tên phòng</th>
            <th>Gía</th>
            <th>Số người tối đa</th>
            <th>Trạng thái</th>
            <th>Action</th>
        </tr>
      </thead>
      <tbody>
      @if(count($rooms)>0)
        @foreach( $rooms as $room )
        <tr>
            <td class="center"><label class="pos-rel">
                <input type="checkbox" class="ace mycheckbox" value="{{ $room->id }}" name="check[]">
                <span class="lbl"></span> </label>
            </td>
            <td>{{$room->id}}</td>
            <td>{{$room->code}}</td>
            <td>{{$room->name}}</td>
            <td>{{number_format($room->price['VND'])}} VND</td>
            <td>{{$room->room['total']}} người</td>
            <td>
                <div data-table="hotel_room" data-id="{{ $room->id }}" data-col="status" class="Switch Round @if($room->status == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                    <div class="Toggle" ></div>
                </div>
            </td>
            <td>
                <div class="action-buttons" >
                    <span style="display: flex">
                       <a href="{{ url($backendUrl.'/room/edit/'.$room->id) }}"> <i title="Sửa" class="ace-icon fa fa-pencil bigger-130 btn btn-warning"></i> </a>  ||
                    <a href="#" name="{{ $room->name }}" link="{{ url($backendUrl.'/room/delete/'.$room->id) }}" class="deleteClick red id-btn-dialog2 btn btn-danger"data-toggle="modal" data-target="#deleteModal" > <i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></a>
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
{{$rooms->links()}}
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
