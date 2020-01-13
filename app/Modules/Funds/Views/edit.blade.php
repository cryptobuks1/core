@extends('master')

@section('css')

@endsection
@section('js')
    @include('ckfinder::setup')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            $("#bank_code").on('change', (function(e){
                var bank= $(this).val();
                $.ajax({
                    type:'POST',
                    url:'{{ route('ajax.bank_num') }}',
                    data:{code_num:bank},
                    success:function(data){
                        $('#acc_num').html(data);
                    }
                });
                $.ajax({
                    type:'POST',
                    url:'{{ route('ajax.bank_name') }}',
                    data:{code_name:bank},
                    success:function(data){
                        $('#acc_name').html(data);
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
                            <h3 class="card-title">Sửa</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {!! Form::model($fund, ['method' => 'PATCH','route' => ['fund.update', $fund->id]]) !!}
                        <div class="card-body row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Tên:</label>
                                    <input name="name" type="text" required class="form-control" id="code" placeholder="Name" value="{{ $fund->name or old('name') }}" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label >Loại:</label>
                                    <select name="type" id="type" class="form-control" required>
                                        <option value="bank" @if($fund->type =='bank') selected @endif >Tài khoản ngân hàng</option>
                                        <option value="cash" @if($fund->type =='cash') selected @endif >Tài khoản tiền mặt</option>
                                    </select>
                                </div>
                            </div>
                            @if($fund->type=='bank')
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Ngân hàng:</label>
                                    <select name="bank_code" id="bank_code" class="form-control" required>
                                        <option value="">Chọn ngân hàng</option>
                                        @foreach($localbanks as $bank)
                                            <option value="{{$bank->paygate_code}}" @if($fund->bank_code==$bank->paygate_code) selected @endif>{{$bank->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="acc_num">Số tài khoản:</label>
                                    <span id="">
                                  <input name="acc_number" type="text"  class="form-control" placeholder="Account number" value="{{$fund->acc_number or old('acc_num') }}" >
                              </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="acc_name">Tên chủ tài khoản:</label>
                                    <span id="">
                                <input name="acc_name" type="text"  class="form-control" placeholder="Account name" value="{{$fund->acc_name or old('acc_name') }}" >
                            </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="acc_branch">Chi nhánh:</label>
                                    <input name="acc_branch" type="text" required class="form-control" id="acc_branch" placeholder="Branch" value="{{ $fund->acc_branch or old('acc_branch') }}" >
                                </div>
                            </div>
                            @endif
                            <div class="col-md-6">
                                <div class="row" style="display: flex">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="balance">Giá:</label>
                                            <input name="balance" type="text" class="form-control" id="balance" placeholder="Balance" value="{{$fund->balance or old('balance') }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Đơn vị tiền:</label>
                                            <select name="currency_code" id="" class="form-control" required>
                                                @foreach($currencies as $item)
                                                    <option value="{{$item->code}}" @if($item->code==$fund->currency_code) selected @endif>{{$item->code}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Trạng thái:</label>
                                    <select name="status" id="" class="form-control">
                                        <option value="Bật" @if($fund->status=='Bật')selected @endif>Bật</option>
                                        <option value="Tắt" @if($fund->status=='Tắt')selected @endif>Tắt</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="col-md-12">
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                                <a href="{{route('fund.index')}}" class="btn btn-warning">Đóng</a>
                            </div>
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
    </section>
    <!-- /.content -->
@endsection
