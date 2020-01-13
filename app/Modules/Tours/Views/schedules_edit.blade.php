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
<script src="{{ asset('adminlte/plugins/ckeditor4101/ckeditor.js') }}"></script>
<script>
    $(function () {
        CKEDITOR.replace('content', {
            filebrowserBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
            filebrowserImageBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
            filebrowserFlashBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
        });
        CKEDITOR.config.extraPlugins = 'justify , colorbutton';
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
    <h3 class="card-title">Lịch trình</h3>
  </div>
  <!-- /.card-header -->
    {!! Form::model($data, ['method' => 'PATCH','route' => ['tour.schedules.update', $data->id]]) !!}
    <div class="card-body row">
        <div class="tt-chung col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <h3 style="color:#00aced;">Cập nhật  lịch trình</h3>
                    <hr>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Thứ tự lịch trình:</label>
                        <input type="number" name="sort" class="form-control" placeholder="Nhập thứ tự lịch trình" value="{{$data->sort or old('sort')}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Lịch trình:</label>
                        <input type="text" name="place" class="form-control" placeholder="Nhập địa điểm của ngày hôm đó" value="{{$data->place or old('place')}}">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="status">Trạng thái:</label>
                        <input name="status" id="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;"  @if($data->status == 1) checked="checked" @endif>
                        <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                            <div class="Toggle"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="note">Mô tả:</label>
                        <textarea name="description" id="content" class="form-control"
                                  rows="30">{{$data->description or old('description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="col-md-12">
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ url($backendUrl.'/tour/schedules/'.$data->tour_id) }}" class="btn btn-warning">Đóng</a>
        </div>
    </div>
{!! Form::close() !!}
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
