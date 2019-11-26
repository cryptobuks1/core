@extends('master')

@section('css')
@endsection

@section('js')

<script>
  $(function () {
    //$("#example1").DataTable();
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
    <h3 class="card-title">Danh sách</h3>
    <div class="float-right" style="margin-right: 350px">
      <a href="{{ url($backendUrl.'/pages/create') }}"><button class="btn btn-success"><i class="fa fa-plus-circle"></i> Thêm mới</button></a>
    </div>
    <div class="card-tools ">
      <div class="input-group input-group-sm dataTables_filter" style="width: 350px;">
        <form action="" name="formSearch" method="GET" >
          <div class="input-group">
            <select name="type" class="form-control" style="">
              <option value="">-- Search Type --</option>
              <option value="title" @if(app("request")->input("type")=="title") selected="selected" @endif>Theo tên</option>
              <option value="author" @if(app("request")->input("type")=="author") selected="selected" @endif>Theo tác giả</option>
              <option value="language" @if(app("request")->input("type")=="language") selected="selected" @endif>Theo ngôn ngữ</option>
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
  <form action="{{ url($backendUrl.'/static-page/action') }}" method="POST">
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
          <th>Tiêu đề</th>
          <th>Ngôn ngữ</th>
          <th>Trạng thái</th>
          <th>Ngày tạo</th>
          <th>Hành động</th>
        </tr>
      </thead>  
      <tbody>

      @if(!count($staticPage))
        <tr>
          <td colspan="10" class="text-center">Empty data !!!</td>
        </tr>
      @else
      @foreach( $staticPage as $post )
        <tr>
          <td class="center"><label class="pos-rel">
              <input type="checkbox" class="ace mycheckbox" value="{{ $post->id }}" name="check[]">
              <span class="lbl"></span> </label>
          </td>
          <td>{{ $post->id }}</td>
          <td><a href="{{url($post->slug)}}" target="_blank">{{ $post->title }}</a></td>
          <td>{{ $post->language }}</td>
          <td>
              @if($post->status)
                <label class="badge badge-success">Đang bật</label>
              @else
                <label class="badge badge-danger">Đang tắt</label>
              @endif
          </td>
          <td>{{ $post->created_at }}</td>
          <td>
            <div class="action-buttons">
             <a href="{{ url($backendUrl.'/pages/'.$post->id.'/edit') }}"><span class="btn btn-sm btn-info"> <i title="Sửa" class="ace-icon fa fa-pencil bigger-130"></i> </span></a>

              <a href="#" name="{{ $post->title }}" link="{{ url($backendUrl.'/pages/'.$post->id) }}" class="deleteClick red id-btn-dialog2" data-toggle="modal" data-target="#deleteModal" ><span class="btn btn-sm btn-danger"> <i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></span></a>

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
            <?php $staticPage->setPath('staticPage'); ?>
             <?php echo $staticPage->render(); ?>
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
            <h5 class="modal-title" id="exampleModalLabel">Delete News</h5>
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