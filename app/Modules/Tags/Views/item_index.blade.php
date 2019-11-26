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
    <h3 class="card-title">List Tag</h3>
    <div class="card-tools ">
      <div class="input-group dataTables_filter" style="">
        <form action="" name="formSearch" method="GET" >
          <div class="input-group">
            <select name="type" class="form-control" style="">
              <option value="">-- Search Type --</option>
              <option value="tag_id" @if(app("request")->input("type")=="tag_id") selected="selected" @endif>By Tag Id</option>
              <option value="item_id" @if(app("request")->input("type")=="item_id") selected="selected" @endif>By Item Id</option>
              <option value="type" @if(app("request")->input("type")=="type") selected="selected" @endif>By Item Type</option>
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
  <form action="{{ url($backendUrl.'/tagitems') }}" method="POST">
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
          <th>Tag Id</th>
          <th>Item Id</th>
          <th>Item Type</th>
          <th>Created Date</th>
          <th>Updated Date</th>
          <th>Action</th>
        </tr>
      </thead>  
      <tbody>
      @if(!count($items))
        <tr>
          <td colspan="7" class="text-center">Empty data !!!</td>
        </tr>
      @else
      @foreach( $items as $item )
        <tr>
          <td class="center"><label class="pos-rel">
              <input type="checkbox" class="ace mycheckbox" value="{{ $item->id }}" name="check[]">
              <span class="lbl"></span> </label>
          </td>
          <td>{{ $item->tag_id }}</td>
          <td>{{ $item->item_id }}</td>
          <td>{{ config('tags.data.'.$item->type.'.name') }}</td>
          <td>{{ $item->created_at }}</td>
          <td>{{ $item->updated_at }}</td>
          <td>
            <div class="action-buttons">
             <a href="{{ url($backendUrl.'/tagitems/'.$item->id.'/edit') }}"> <i title="Sửa" class="ace-icon fa fa-pencil bigger-130"></i> </a>  | 

             <a href="#" name="{{ $item->label }}" link="{{ url($backendUrl.'/tagitems/'.$item->id) }}" class="deleteClick red id-btn-dialog2"data-toggle="modal" data-target="#deleteModal" > <i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></a>

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
            <?php $items->setPath('items'); ?>
             <?php echo $items->render(); ?>
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
            <h5 class="modal-title" id="exampleModalLabel">Delete Tag</h5>
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