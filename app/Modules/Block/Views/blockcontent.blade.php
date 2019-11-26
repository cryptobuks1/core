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
      <a href="{{ url($backendUrl.'/blocks') }}"><button class="btn btn-warning"><i class="fa fa-list"></i> Danh sách khối</button></a>
      <a href="{{ url($backendUrl.'/blocks/content/create?block='.$block->id) }}"><button class="btn btn-success"><i class="fa fa-plus-circle"></i> Thêm nội dung</button></a>
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

  </div>
  <!-- /.card-header -->
  <form action="{{ url($backendUrl.'/blocks/content/actions') }}" method="POST">
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
          <th>Tên</th>
          <th>Ảnh</th>
          <th>Ngôn ngữ</th>
          <th>Icon</th>
          <th>Trạng thái</th>
          <th>Thứ tự</th>
          <th>Hành động</th>
        </tr>
      </thead>  
      <tbody>
      @if(count($contents) > 0)
      @foreach( $contents as $content )
        <tr>
          <td class="center"><label class="pos-rel">
              <input type="checkbox" class="ace mycheckbox" value="{{ $content->id }}" name="check[]">
              <span class="lbl"></span> </label>
          </td>
          <td>{{ $content->id }}</td>
          <td>{{ $content->title }}</td>
          <td><img src="{{url($content->image)}}" width="60px"></td>
          <td>{{ $content->lang}}</td>
          <td>{{ $content->icon}}</td>
          <td>
            <div data-table="block_content" data-id="{{ $content->id }}" data-col="status" class="Switch Round @if($content->status == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
              <div class="Toggle" ></div>
            </div>
          </td>
          <td>{{ $content->sort}}</td>
          <td>
            <div class="action-buttons">
             <a href="{{ url($backendUrl.'/blocks/'.$content->id.'/edit') }}"><span class="btn btn-sm btn-info"> <i title="Sửa" class="ace-icon fa fa-pencil bigger-130"></i> </span></a>
             <a href="#" name="{{ $content->title }}" link="{{ url($backendUrl.'/blocks/content/delete/'.$content->id) }}" class="deleteClick red id-btn-dialog2" data-toggle="modal" data-target="#deleteModal" ><span class="btn btn-sm btn-danger"> <i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></span></a>

            </div>
          </td>
        </tr>
      @endforeach
     @endif
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
            <h5 class="modal-title" id="exampleModalLabel">Xóa nội dung khối</h5>
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