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
    <h3 class="card-title">Danh sách</h3>
    <div class="float-right" style="margin-right: 150px">
      <a href="{{ url($backendUrl.'/ticket/create') }}"><button class="btn btn-success"><i class="fa fa-plus-circle"></i> Tạo vé hỗ trợ</button></a>
    </div>
    <div class="card-tools ">
      <div class="input-group input-group-sm dataTables_filter" style="width: 150px;">
        <form action="" name="formSearch" method="GET" >
          <input type="text" name="keyword" class="form-control float-right" placeholder="Mã hỗ trợ" style="padding-right: 42px;">
          <div class="input-group-append" style="margin-left: 110px">
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
          </div>
        </form>
      </div>
    </div>

  </div>
  <!-- /.card-header -->
  <form action="{{ url($backendUrl.'/tickets/actions') }}" method="POST">
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
          <th>Tiêu đề</th>
          <th>Tên người gửi</th>
          <th>Điện thoại</th>
          <th>Email</th>
          <th>Thành phố</th>
          <th>Ngôn ngữ</th>
          <th>Ngày tạo</th>
          <th>Trạng thái</th>
          <th>Đánh giá</th>
          <th>Phản hồi</th>
          <th>Hành động</th>
        </tr>
      </thead>  
      <tbody>
      @foreach( $tickets as $ticket )
        <tr>
          <td class="center"><label class="pos-rel">
              <input type="checkbox" class="ace mycheckbox" value="{{ $ticket->id }}" name="check[]">
              <span class="lbl"></span> </label>
          </td>
          <td><strong>{{ $ticket->title }}</strong> [{{ $ticket->code }}]</td>
          <td>{{ $ticket->name }}</td>
          <td>{{ $ticket->phone }}</td>
          <td>{{ $ticket->email}}</td>
          <td>{{ $ticket->city}}</td>
          <td>{{ $ticket->lang}}</td>
          <td>{{ $ticket->created_at }}</td>
          <td>
            @if($ticket->status == 'closed')
              <label class="badge badge-danger">Đã đóng</label>
            @elseif($ticket->status == 'pending')
              <label class="badge badge-success">Đang mở</label>
            @elseif($ticket->status == 'verify')
              <label class="badge badge-dark">Đợi xác minh</label>
            @elseif($ticket->status == 'canceled')
              <label class="badge badge-warning">Đã hủy</label>
            @else
              <label class="badge badge-dark">Không rõ</label>
            @endif
          </td>
          <td>{{ $ticket->vote}}</td>
          <td>{{  $ticket->admin}}</td>

          <td width="15%">
            <div class="action-buttons">
             <a href="{{ url($backendUrl.'/tickets/'.$ticket->id.'/view') }}"><span class="btn btn-sm btn-info"> <i title="Sửa" class="ace-icon fa fa-eye bigger-130"></i> Xem</span></a>
              <a href="#" name="{{ $ticket->code }}" link="{{ url($backendUrl.'/tickets/'.$ticket->id) }}" class="deleteClick red id-btn-dialog2"data-toggle="modal" data-target="#deleteModal" ><span class="btn btn-sm btn-danger"> <i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i> Xóa</span></a>
            </div>
          </td>
        </tr>
      @endforeach
     
      </tbody>
      
    
    </table>
  </div></div>
    <div class="row">
      <div class="col-sm-12 col-md-5">
        <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
          <div class="form-group row">
            <div class="col-md-4">
              <select name="action" class="form-control">
                <option value=""></option>
                <option value="on">Bật đã chọn</option>
                <option value="off">Tắt đã chọn</option>
                <option value="delete">Xóa đã chọn</option>
              </select>

            </div>
            <div class="col-md-6">
              <button type="submit" class="btn btn-warning"><i class="ace-icon fa fa-check-circle bigger-130"></i> Thực hiện</button>
            </div>

          </div>
        </div>

      </div>
      <div class="col-sm-12 col-md-7">
        <div class="float-right" id="dynamic-table_paginate">
          <?php $tickets->setPath('weblinks'); ?>
          <?php echo $tickets->render(); ?>
        </div>
      </div>
    </div>
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