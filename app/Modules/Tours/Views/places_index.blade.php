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
    <h3 class="card-title">Lý do tạo phiếu</h3>
    <div class="float-right" style="margin-right: 150px">
      <a href="{{ url($backendUrl.'/tour/place/create') }}"><button class="btn btn-success"><i class="fa fa-plus-circle"></i> Thêm</button></a>
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
            <th>Ảnh</th>
            <th>Tên địa điểm</th>
            <th>Địa chỉ</th>
            <th>Trong/Ngoài nước</th>
            <th>Loại Tour</th>
            <th>Trạng thái</th>
            <th>Action</th>
        </tr>
      </thead>
      <tbody>
      @if(count($places)>0)
        @foreach( $places as $place )
        <tr>
            <td class="center"><label class="pos-rel">
              <input type="checkbox" class="ace mycheckbox" value="{{ $place->id }}" name="check[]">
              <span class="lbl"></span> </label>
            </td>
            <td>{{$place->id}}</td>
            <td><img id="logo-icon" class="imgPreview" style="max-width: 150px" src="@if($place->avatar){{ url($place->avatar) }}@endif"/></td>
            <td>{{$place->name}}</td>
            <td>  @foreach($countries as $country)
                    @if($country->code==$place->country)
                        @foreach($cities as $city)
                            @if($city->country_code == $country->code && $city->code== $place->city)
                                @if($place->province){{ $place->province.'-'}} @endif {{$city->name_city.'-'.$country->name}}
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </td>
            <td>@if($place->type=='domestic') Trong nước @else Nước ngoài @endif</td>
            <td>
                @foreach($types as $item)
                    @if($item->id == $place->type_tour)
                        {{$item->name}}
                    @endif
                @endforeach
            </td>
            <td>
                <div data-table="tour_places" data-id="{{ $place->id }}" data-col="status" class="Switch Round @if($place->status == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                    <div class="Toggle" ></div>
                </div>
            </td>
            <td>
                <div class="action-buttons">
                    <a href="{{ url($backendUrl.'/tour/place/edit/'.$place->id) }}"> <i title="Sửa" class="ace-icon fa fa-pencil bigger-130 btn btn-warning"></i> </a>  |
                    <a href="#" name="{{ $place->name }}" link="{{ url($backendUrl.'/tour/place/delete/'.$place->id) }}" class="deleteClick red id-btn-dialog2 btn btn-danger"data-toggle="modal" data-target="#deleteModal" > <i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></a>
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
{{--{{$types->links()}}--}}
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