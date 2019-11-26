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
                        <h3 class="card-title">Thông tin ví</h3>
                    </div>

                    <div class="card-body p-0">

                        {!! Form::model($wallet, ['method' => 'PATCH','route' => ['wallet.postUpdate', $wallet->id], 'autocomplete' =>'off']) !!}

                            <div class="col-md-6" style="display: inline-block; float: left">
                                <table class="table table-striped">
                                    <tbody>
                                    <tr>
                                        <td>Thành viên:</td>
                                        <td>
                                            <b>{{ App\User::getName($wallet->user)  }}</b>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Địa chỉ ví:</td>
                                        <td>
                                            <b>{{ $wallet->number  }}</b>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Loại ví:</td>
                                        <td>
                                            <b>{{ $wallet->currency_code  }}</b>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Số dư khả dụng:</td>
                                        <td>
                                            <b>{{ number_format($wallet->balance_decode)  }} {{ $wallet->currency_code  }}</b>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Ngày tạo:</td>
                                        <td>
                                            <b>{{ $wallet->created_at  }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cập nhật lần cuối:</td>
                                        <td>
                                            <b>{{ $wallet->updated_at  }}</b>
                                        </td>
                                    </tr>


                                    </tbody></table></div>


                            <div class="col-md-6" style="display: inline-block;">
                                <table class="table table-striped ">
                                    <tbody>
                                    <tr>
                                        <td>Trạng thái:</td>
                                        <td>
                                            <input name="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;" @if( $wallet->status == 1 ) checked="checked" @endif>
                                            <div class="Switch Round @if($wallet->status == 1) On @else Off @endif" style="vertical-align:top;margin-left:10px;">
                                                <div class="Toggle"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hình thức:</td>
                                        <td>

                                            <label class="radio-inline"><input type="radio" name="action" value ="+" checked>Nạp tiền</label>
                                            <label class="radio-inline"><input type="radio" name="action" value ="-">Rút tiền</label>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Số tiền:</td>
                                        <td>
                                            <div class="input-group mb-3" style="margin-bottom: 0px !important;">
                                                <input id="formattedNumberField" type="text" name="balance" class="form-control" placeholder="Số tiền" aria-label="Recipient's username" aria-describedby="basic-addon2">

                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Số tiền gồm phí:</td>
                                        <td>
                                         <span class="input-group-text" id="basic-addon2"><b><span id="showit">0</span> {{ $wallet->currency_code }}</b></span>

                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Mô tả giao dịch:</td>
                                        <td>
                                            <div class="input-group mb-3" style="margin-bottom: 0px !important;">
                                                <textarea name="description" class="form-control" placeholder="Nội dung ...">ví {{$wallet->number}} thời gian {{ date('d-m-Y H:i:s') }}</textarea>
                                            </div>
                                        </td>
                                    </tr>


                                    <tr>

                                        <td>
                                            <div class="input-group">
                                                <button type="submit" class="btn btn-success" onclick="this.disabled=true;this.value='Đang thực hiện...';this.form.submit();">Thực hiện giao dịch</button>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>

                        {!! Form::close() !!}
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <script>
        $("#formattedNumberField").on('keyup', function(){
            var n = parseInt($(this).val().replace(/\D/g,''),10);
            $("#showit").html(n.toLocaleString());
        });
    </script>
    <!-- /.content -->
@endsection
