@extends('master')

@section('css')

@endsection
@section('js')
  @include('ckfinder::setup')
@endsection

@section('content')
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="col-md-12">
            <!-- general form elements -->

           @include('layouts.errors')

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Thêm lý do cho tạo phiếu</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                {!! Form::model($reason, ['method' => 'PATCH','route' => ['reason.update', $reason->id]]) !!}
                <div class="card-body row">
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="type">Loại Phiếu:</label>
                                <select name="type"  class="form-control" required>
                                    <option value="Phiếu thu" @if($reason->type=='Phiếu thu') selected @endif>Phiếu thu</option>
                                    <option value="Phiếu chi" @if($reason->type=='Phiếu chi') selected @endif>Phiếu chi</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Lý do:</label>
                                <input name="name" type="text" required class="form-control" id="code" placeholder="Nhập lý do" value="{{ $reason->name or old('name') }}" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="status">Trạng thái:</label>
                                <input name="status" id="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;" @if($reason->status == 1) checked="checked" @endif>
                                <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                                    <div class="Toggle"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- /.card-body -->
                    <div class="col-md-12">
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="{{route('reason.index')}}" class="btn btn-warning">Đóng</a>
                        </div>
                    </div>
                    @csrf
                {!! Form::close() !!}
            </div>
            <!-- /.card -->
              </div>
              <!-- /.card-body -->
            </div>
    <!-- /.card -->

    </div>
    <!-- /.card -->

</section>
<!-- /.content -->
@endsection
