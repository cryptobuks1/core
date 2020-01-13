@extends('master')

@section('css')

@endsection
@section('js')
    <script !src="">
        $(document).ready(function() {
            $("#type").on('change', (function(e) {
                var code = $(this).val();
                $('#type').each(function () {
                    if ($(this).val() == 'tour' | $(this).val() == 'flight' ) {
                        $('.s-hotel').hide();
                        $('#s-hotel').val('');
                    } else if ($(this).val() == 'hotel') {
                        $('.s-hotel').show();
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
    <div class="col-12">
      <div class="col-md-12">
            <!-- general form elements -->
           @include('layouts.errors')
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Loại dịch vụ</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::open(array('route' => 'tour.service.store','method'=>'POST')) !!}
                <div class="card-body row">
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Tên dịch vụ:</label>
                                <input name="name" type="text" required class="form-control" id="code" placeholder="Nhập tên" value="{{ old('name') }}" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="type">Module:</label>
                                <select name="type"  class="form-control" id="type">
                                    <option value="hotel">Khách sạn</option>
                                    <option value="tour">Du lịch</option>
                                    <option value="flight">Đặt vé</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 s-hotel">
                            <div class="form-group">
                                <label>Loại dịch vụ:</label>
                                <select name="type_services"  class="form-control" id="s-hotel">
                                    <option value="">Chọn dịch vụ</option>
                                    <option value="basic">Dịch vụ cơ bản</option>
                                    <option value="convenient">Dịch vụ tiện nghi</option>
                                    <option value="other">Dịch vụ khác</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="status">Trạng thái:</label>
                                <input name="status" id="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;" checked="checked">
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
                            <button type="submit" class="btn btn-primary">Thêm</button>
                            <a href="{{route('tour.type.index')}}" class="btn btn-warning">Đóng</a>
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
