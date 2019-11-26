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
                <h3 class="card-title">Sửa ngân hàng</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->

              {!! Form::model( ['method' => 'PATCH']) !!}

              <div class="card-body row">
                  <div class="card-body row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="code">Tên tỉnh/thành phố:</label>
                              <input required name="name_city" type="text" class="form-control" id="code" placeholder="Ví dụ: Hà Nội" value="{{ $data->name_city }}" >
                          </div>
                          <div class="form-group">
                              <label for="name">Tên viết tắt:</label>
                              <input required name="code" type="text" class="form-control" id="name" placeholder="Tên viết tắt" value="{{ $data->code }}" >
                          </div>
                          <div class="form-group">
                              <label for="acc_num">Quốc gia:</label>
                              <select class="form-control" name="country_code" id="" required>
                                  @foreach($coun as $coun)
                                      <option value="{{$coun->code}}" @if($data->country_code==$coun->code) selected @endif>{{$coun->name}}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="form-group">
                              <label for="card_num">Vùng miền(có thể để trống):</label>
                              <select class="form-control" name="region" id="">
                                  <option value="">Chọn vùng</option>
                                  <option value=""@if($data->region=='') selected @endif></option>
                                  <option value="Miền Bắc"@if($data->region=='Miền Bắc') selected @endif> Miền Bắc </option>
                                  <option value="Miền Trung"@if($data->region=='Miền Trung') selected @endif>Miền Trung</option>
                                  <option value="Miền Nam"@if($data->region=='Miền Nam') selected @endif>Miền Nam</option>
                              </select>
                          </div>


                          <div class="form-group">
                              <label for="branch">Sắp xếp(có thể để trống):</label>
                              <input name="sort" type="number" class="form-control" id="branch" placeholder="Sắp xếp" value="{{ $data->sort }}" >
                          </div>

                          <div class="form-group">
                              <label for="withdraw">Nổi bật:</label>
                              <select class="form-control" name="featured" id="">
                                  <option value="1"@if($data->featured==1) selected @endif> Nổi bật</option>
                                  <option value="0"@if($data->featured==0) selected @endif> Không nổi bật</option>
                              </select>
                          </div>

                          <div class="form-group">
                              <label for="withdraw">Nổi bật:</label>
                              <select class="form-control" name="status" id="">
                                  <option value="1"@if($data->status==1) selected @endif> Bật</option>
                                  <option value="0"@if($data->status==0) selected @endif> Tắt</option>
                              </select>
                          </div>

                      </div>



                  </div>

              </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.card -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
    <!-- /.card -->
    </div>
  <!-- /.col -->
  </div>
<!-- /.row -->
</section>
<!-- /.content -->
@endsection
