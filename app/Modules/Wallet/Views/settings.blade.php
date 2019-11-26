@extends('master')

@section('css')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
@endsection
@section('js')
<script src="{{ asset('adminlte/plugins/select2/select2.full.min.js') }}"></script>

@endsection

@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-12">
            @include('layouts.errors')
            <div class="card">

                <div class="card-header" style="border-bottom: 0">
                    <h3 class="card-title">Danh sách ví điện tử</h3>
                </div>

                <div id="Settings" class="table-responsive">
                    <table class="table table-bordered table-striped ">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>ID tiền tệ</th>
                            <th>Mã tiền tệ</th>
                            <th>Mã cổng</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($wallets) > 0)
                        @foreach( $wallets as $wallet )
                            <tr>

                                <td>{{ $wallet->id }}</td>
                                <td>{{ $wallet->description }}</td>
                                <td>{{ $wallet->currency_id}}</td>
                                <td>{{ $wallet->currency_code}}</td>
                                <td>{{ $wallet->paygate_code}}</td>
                                <td>
                                    <div data-table="wallet_settings" data-id="{{ $wallet->id }}" data-col="status" class="Switch Round @if($wallet->status == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                                        <div class="Toggle" ></div>
                                    </div>

                                </td>
                                <td>{{ $wallet->created_at }}</td>
                                <td>
                                    <a href="{{route('bk.wallet.updatefee', $wallet->code)}}"><span class="btn btn-sm btn-success">Cấu hình phí</span></a>
                                </td>

                            </tr>
                        @endforeach
                            @endif

                        </tbody>


                    </table>
                </div>

                <div class="card-header" style="border-bottom: 0">
                    <h3 class="card-title">Thêm ví điện tử</h3>
                </div>
                <div class="card-body p-0">
                        <form action="{{route('bk.wallet.create')}}" method="POST">
                        <div class="card-body row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="name">Tiền tệ (chỉ có loại FIAT mới tạo được ví):</label>
                             
                              {!! Form::select('currency', $lsCurrency,[], array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                              <label for="description">Mô tả:</label>
                              <textarea name="description" class="form-control">Ví điện tử</textarea>
                            </div>

                              <div class="form-group">
                                  <label for="sort">Thứ tự:</label>
                                  <input name="sort" class="form-control" value="0">
                              </div>

                          </div>
                          
                        </div>
                        <!-- /.card-body -->
        
                        <div class="card-footer">
                          <button type="submit" class="btn btn-primary">Thêm ví</button>
                        </div>
                        {!! csrf_field() !!}
                        </form>

                    
                </div>
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
