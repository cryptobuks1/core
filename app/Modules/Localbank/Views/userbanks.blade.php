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

@endsection

@section('content')
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-12">
      @include('layouts.errors')
<div class="card">
  
  <div class="card-header" style="border-bottom: 0">
    <h3 class="card-title">Danh sách ngân hàng</h3>
    <div class="card-tools ">
      <div class="input-group input-group-sm dataTables_filter" style="width: 350px;">
        <form action="" name="formSearch" method="GET" >
          <div class="input-group">
            <select name="type" class="form-control" style="">
         <option value="username" @if(app("request")->input("type")=="username") selected="selected" @endif>Email hoặc ĐT</option>
           </select>
            <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm" value="{{ app("request")->input("keyword") }}" />
            <div class="input-group-append">
              <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
            </div>
          </div>
        </form>
      </div>
    </div>

  </div>
  <!-- /.card-header -->
  <form action="{{ url($backendUrl.'/localbank/actions') }}" method="POST">
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
          <th>Khách hàng</th>
          <th>Mã</th>
          <th>Ngân hàng</th>
          <th>Số TK</th>
          <th>Chủ TK</th>
          <th>Chi nhánh</th>
          <th>Phê duyệt</th>
          <th>Ngày tạo</th>
          <th>Hành động</th>
        </tr>
      </thead>  
      <tbody>
      @foreach( $list_user_banks as $list_user_bank )
        <tr>
          <td class="center"><label class="pos-rel">
              <input type="checkbox" class="ace mycheckbox" value="{{ $list_user_bank->id }}" name="check[]">
              <span class="lbl"></span> </label>
          </td>
          <td>{!! App\User::getUserInfo($list_user_bank->user_id) !!}</td>
          <td>{{ $list_user_bank->code }}</td>
          <td>{{ $list_user_bank->name }}</td>
          <td>{{ $list_user_bank->acc_num }}</td>
          <td>{{ $list_user_bank->acc_name }}</td>
          <td>{{ $list_user_bank->branch}}</td>
          <td>
            <div data-table="localbanks_user" data-id="{{ $list_user_bank->id }}" data-col="approved" class="Switch Round @if($list_user_bank->approved == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
              <div class="Toggle" ></div>
            </div>
          </td>
          <td>{{ $list_user_bank->created_at}}</td>
          <td>
            <div class="action-buttons">
             <a href="#" name="{{ $list_user_bank->acc_num}} - {{ $list_user_bank->acc_name}}" link="{{ url($backendUrl.'/localbank/delbankuser/'.$list_user_bank->id) }}" class="deleteClick red id-btn-dialog2" data-toggle="modal" data-target="#deleteModal" > <i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></a>

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
          {{$list_user_banks->links()}}
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
          $("#deleteMes").html("Xóa : "+name+" ?");
        });
      });
    </script>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form id="deleteForm" action="" method="get">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Xóa ngân hàng của khách hàng</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div id="deleteMes" class="modal-body">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            <button type="submit" class="btn btn-primary">Xác nhận xóa</button>
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