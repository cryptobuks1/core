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
    <h3 class="card-title">Sliders List</h3>
    <div class="float-right" style="margin-right: 350px">
      <a href="{{ url($backendUrl.'/sliders/create') }}"><button class="btn btn-success"><i class="fa fa-plus-circle"></i> Add New Slider</button></a>
    </div>
    <div class="card-tools ">
      <div class="input-group dataTables_filter" style="width:350px">
        <form action="" name="formSearch" method="GET" >
          <div class="input-group">
            <select name="type" class="form-control" style="">
              <option value="">-- Search Type --</option>
              <option value="slider_name" @if(app("request")->input("type")=="slider_name") selected="selected" @endif>By Name</option>
              <option value="slider_text" @if(app("request")->input("type")=="slider_text") selected="selected" @endif>By Text</option>
              <option value="status" @if(app("request")->input("type")=="status") selected="selected" @endif>By Status (0 is Inactive/1 is Active)</option>
            </select>
            <input type="text" name="keyword" class="form-control" placeholder="Search" value="{{ app("request")->input("keyword") }}" />
            <div class="input-group-append">
              <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
            </div>
          </div>
        </form>
      </div>
    </div>

  </div>
  <!-- /.card-header -->
  <form action="{{ url($backendUrl.'/sliders') }}" method="POST">
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
          <th>ID</th>
          <th>Slider Name</th>
          <th>Slider Text</th>
          <th>Sort Order</th>
          <th>Status</th>
          <th>Created Date</th>
          <th>Updated Date</th>
          <th>Action</th>
        </tr>
      </thead>  
      <tbody>
      @if(!count($sliders))
        <tr>
          <td colspan="9" class="text-center alert alert-info">Chưa có dữ liệu</td>
        </tr>
      @else
      @foreach( $sliders as $slide )
        <tr>
          <td class="center"><label class="pos-rel">
              <input type="checkbox" class="ace mycheckbox" value="{{ $slide->id }}" name="check[]">
              <span class="lbl"></span> </label>
          </td>
          <td>{{ $slide->id }}</td>
          <td>{{ $slide->slider_name }}</td>
          <td>{{ $slide->slider_text }}</td>
          <td>@if($slide->sort_order) {{ $slide->sort_order }} @else 0 @endif</td>
          <td>
              <div data-table="sliders" data-id="{{ $slide->id }}" data-col="status" class="Switch Round @if($slide->status == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                <div class="Toggle" ></div>
              </div>
          </td>
          <td>{{ $slide->created_at }}</td>
          <td>{{ $slide->updated_at }}</td>
          <td>
            <div class="action-buttons">
             <a href="{{ url($backendUrl.'/sliders/'.$slide->id.'/edit') }}"> <i title="Sửa" class="ace-icon fa fa-pencil bigger-130"></i> </a>  | 

             <a href="#" name="{{ $slide->name }}" link="{{ url($backendUrl.'/sliders/'.$slide->id) }}" class="deleteClick red id-btn-dialog2"data-toggle="modal" data-target="#deleteModal" > <i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></a>

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
            <?php $sliders->setPath('sliders'); ?>
             <?php echo $sliders->render(); ?>
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
            <h5 class="modal-title" id="exampleModalLabel">Delete Slider</h5>
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