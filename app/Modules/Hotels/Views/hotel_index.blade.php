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
        $("#cities").on('change', (function(e){
                var city_code = $(this).val();
                $.ajax({
                    type:'POST',
                    url:'{{ route('ajax.cities') }}',
                    data:{code:city_code},
                    success:function(data){
                        $('#provinces').html(data);
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
      <h3 class="card-title" style="text-transform: uppercase">Danh sách khách sạn</h3>
    <div class="col-12">
      @include('layouts.errors')
<div class="card">
  <div class="card-header" style="border-bottom: 0">
          <div class="float-right" style="margin-right: 150px">
              <a href="{{ url($backendUrl.'/hotel/create') }}"><button class="btn btn-success"><i class="fa fa-plus-circle"></i> Thêm</button></a>
          </div>
          <div class="card-tools ">
              <div class="input-group input-group-sm dataTables_filter" style="width: 150px;">
                  <form action="" name="formSearch" method="GET" >
                      <input type="text" name="keyword" class="form-control float-right" placeholder="Search" style="padding-right: 42px;" value="@if(app("request")->input("keyword")){{ trim(app("request")->input("keyword"))}} @endif">
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
                      <select class="form-control" name="city" id="cities" >
                          <option value="" @if(app("request")->input("city")== "") selected="selected" @endif>-- Chọn tỉnh/thành phố--</option>
                          @foreach ($cities as $item)
                              <option value="{{$item->code}}" @if( app("request")->input("city") == $item->code) selected="selected" @endif > {{$item->name_city}} </option>
                          @endforeach
                      </select>
                      <select class="form-control" name="province" id="provinces" >
                          <option value="" @if(app("request")->input("province") == "") selected="selected" @endif>-- Chọn quận/huyện --</option>
                          @foreach ($province as $item)
                              <option value="{{$item->name}}" @if(app("request")->input("city") == $item->city_code && app("request")->input("province") == $item->name) selected="selected" @endif> {{$item->name}} </option>
                          @endforeach
                      </select>
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
            <th>ID</th>
            <th>Mã phòng</th>
            <th>Tên khách sạn</th>
            <th>Tỉnh/Thành</th>
            <th>Quận/Huyện</th>
            <th>Địa chỉ</th>
            <th>Danh sách phòng</th>
            <th>Trạng thái</th>
            <th>Nổi bật</th>
            <th>Action</th>
        </tr>
      </thead>
      <tbody>
      @if(count($hotels)>0)
        @foreach( $hotels as $hotel )
        <tr>
            <td class="center"><label class="pos-rel">
                <input type="checkbox" class="ace mycheckbox" value="{{ $hotel->id }}" name="check[]">
                <span class="lbl"></span> </label>
            </td>
            <td>{{$hotel->id}}</td>
            <td>{{$hotel->code}}</td>
            <td>{{$hotel->name}}</td>
            <td>
                @foreach($cities as $item)
                    @if($item->code == $hotel->city)
                        {{$item->name_city}}
                    @endif
                @endforeach
            </td>
            <td>
                @foreach($cities as $item)
                    @foreach($provinces as $pro)
                        @if($item->code == $pro->city_code && $pro->name == $hotel->province)
                            {{$pro->name}}
                        @endif
                    @endforeach
                @endforeach
            </td>
            <td>{{$hotel->address}}</td>
            <td style="text-align: center"><a href="{{ url($backendUrl.'/room/'.$hotel->id) }}"> <i title="Lịch trình" class="ace-icon fa fa-list-alt bigger-130 btn btn-primary"></i> </a></td>
            <td>
                <div data-table="hotels" data-id="{{ $hotel->id }}" data-col="status" class="Switch Round @if($hotel->status == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                    <div class="Toggle" ></div>
                </div>
            </td>
            <td>
                <div data-table="hotels" data-id="{{ $hotel->id }}" data-col="featured" class="Switch Round @if($hotel->featured == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                    <div class="Toggle" ></div>
                </div>
            </td>
            <td>
                <div class="action-buttons" >
                    <span style="display: flex">
                       <a href="{{ url($backendUrl.'/hotel/edit/'.$hotel->id) }}"> <i title="Sửa" class="ace-icon fa fa-pencil bigger-130 btn btn-warning"></i> </a>  ||
                    <a href="#" name="{{ $hotel->name }}" link="{{ url($backendUrl.'/hotel/delete/'.$hotel->id) }}" class="deleteClick red id-btn-dialog2 btn btn-danger"data-toggle="modal" data-target="#deleteModal" > <i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></a>
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
{{$hotels->links()}}
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
