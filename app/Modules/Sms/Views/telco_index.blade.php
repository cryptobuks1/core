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
    <h3 class="card-title">Lịch sử tin nhắn</h3>
    <div class="float-right" style="margin-right: 150px">
      <a href="{{ url($backendUrl.'/telco/create') }}"><button class="btn btn-success"><i class="fa fa-plus-circle"></i> Thêm</button></a>

    </div>

    <div class="card-tools ">
      <div class="input-group input-group-sm dataTables_filter" style="width: 150px;">
        <form action="" name="formSearch" method="GET" >
          <input type="text" name="phone" class="form-control float-right" placeholder="Số điện thoại" style="padding-right: 42px;">
          <div class="input-group-append" style="margin-left: 110px">
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
          </div>
        </form>
      </div>
    </div>

  </div>
  <!-- /.card-header -->
  <form action="{{ url($backendUrl.'/sms/action') }}" method="POST">
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
          <th>Quốc gia</th>
          <th>Mã quốc gia</th>
          <th>Key</th>
          <th>Số tiền</th>
          <th>Number</th>
          <th>Trạng thái</th>
          <th>Hành động</th>
        </tr>
      </thead>  
      <tbody>
      @if(count($smss) > 0)
        @foreach( $smss as $sms )
        <tr>
          <td class="center"><label class="pos-rel">
              <input type="checkbox" class="ace mycheckbox" value="{{ $sms->id }}" name="check[]">
              <span class="lbl"></span> </label>
          </td>
          <td>{{ $sms->id }}</td>
          <td>{{ $sms->name }}</td>
          <td>{{ $sms->country_code}}</td>
          <td>{{ $sms->dial_code}}</td>
          <td>{{ $sms->key}}</td>
          <td>
            @foreach($groups as $group)
              {{$group->name.': '.number_format($sms->price[$group->id]['VND'],0)}}VND <br>
              @endforeach
          </td>
          <td>{{ $sms->number_format}}</td>
          <td>
            <div data-table="sms_telco" data-id="{{ $sms->id }}" data-col="status" class="Switch Round @if($sms->status == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
              <div class="Toggle" ></div>
            </div>
          </td>
          <td>
            <div class="action-buttons">
              <a href="{{ url($backendUrl.'/telco/edit/'.$sms->id) }}"> <i title="Sửa" class="ace-icon fa fa-pencil bigger-130 btn btn-warning"></i> </a>  |
              <a href="#" name="{{ $sms->text }}" link="{{ url($backendUrl.'/telco/delete/'.$sms->id) }}" class="deleteClick red id-btn-dialog2 btn btn-danger" data-toggle="modal" data-target="#deleteModal" > <i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></a>
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
                <option value="">-- Hành động --</option>
                <option value="delete">Xóa đã chọn</option>
              </select>

            </div>
            <div class="col-md-6">
              <button type="submit" class="btn btn-warning"><i class="ace-icon fa fa-check-circle bigger-130"></i> Thực hiện</button>
            </div>

          </div>
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
            <h5 class="modal-title" id="exampleModalLabel">Delete Card</h5>
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