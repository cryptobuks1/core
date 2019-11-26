@extends('master')

@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/iCheck/all.css') }}">
@endsection
@section('js')
    @include('ckfinder::setup')
    <script src="{{ asset('adminlte/plugins/iCheck/icheck.min.js') }}"></script>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')
                <div class="card">

                    <div class="card-header" style="border-bottom: 0">
                        <h3 class="card-title">Thêm cổng thanh toán</h3>
                    </div>
                    {!! Form::open(array('route' => 'backend.paygates.addpaygate','method'=>'POST')) !!}
                    <div class="card-body p-0">
                        <div class="card-body row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Tên cổng thanh toán: </label>
                                    <input name="name" type="text" class="form-control" id="name"
                                           value="{{ old('name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="name">Mã: </label>
                                    <input name="code" type="text" class="form-control" id="code"
                                           value="{{ $paygate->code }}" readonly="readonly">
                                </div>
                                <div class="form-group">
                                    <label for="name">Tiền tệ mặc định: </label>
                                    <input name="currency_code" type="text" class="form-control" id="currency_code"
                                           value="{{ $paygate->currency_code }}" readonly="readonly">
                                </div>
                                <div class="form-group">
                                    <label for="bankcode">Mã đại diện cho cổng này: </label>
                                    <select class="form-control" name="bankcode">
                                        <option value="">== Chọn ==</option>
                                        @if(count($bankcode) > 0)
                                            @foreach($bankcode as $lb)
                                        <option value="{{$lb}}">{{$lb}}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                </div>

                                <div class="form-group">
                                    <label for="description">Mô tả:</label>
                                    <textarea name="description" class="form-control" id="description"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="url">Url: </label>
                                    <input name="url" type="text" class="form-control" id="url"
                                           value="">
                                </div>

                                <div class="form-group">
                                    <label for="withdrawField">Các trường khi rút tiền (cách nhau dấu phẩy): </label>
                                    <input name="withdrawField" type="text" class="form-control" id="withdrawField"
                                           value="{{$paygate->withdrawField}}">
                                </div>

                                <div class="form-group">

                                    <label for="convert">Cho phép quy đổi tiền tệ khi thanh toán</label>
                                    <input name="convert" type="checkbox" value="convert" data-toggle="toggle"
                                           style="display: none;">
                                    <div class="Switch Round Off"
                                         style="vertical-align:top;margin-right:20px;margin-left: 10px">
                                        <div class="Toggle"></div>
                                    </div>

                                </div>

                                <div class="form-group">

                                    <label for="verify">Yêu cầu xác minh tài khoản mới cho thanh toán</label>
                                    <input name="verify" type="checkbox" value="verify" data-toggle="toggle"
                                           style="display: none;">
                                    <div class="Switch Round Off"
                                         style="vertical-align:top;margin-right:20px;margin-left: 10px">
                                        <div class="Toggle"></div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="payment">Cho thanh toán</label>
                                    <input name="payment" type="checkbox" value="payment" data-toggle="toggle"
                                           style="display: none;" checked="checked">
                                    <div class="Switch Round On"
                                         style="vertical-align:top;margin-right:20px;margin-left: 10px">
                                        <div class="Toggle"></div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="deposit">Cho nạp</label>
                                    <input name="deposit" type="checkbox" value="deposit" data-toggle="toggle"
                                           style="display: none;" checked="checked">
                                    <div class="Switch Round On"
                                         style="vertical-align:top;margin-right:20px;margin-left: 10px">
                                        <div class="Toggle"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="withdraw">Cho rút</label>
                                    <input name="withdraw" type="checkbox" value="withdraw" data-toggle="toggle"
                                           style="display: none;" checked="checked">
                                    <div class="Switch Round On"
                                         style="vertical-align:top;margin-right:20px;margin-left: 10px">
                                        <div class="Toggle"></div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="status">Trạng thái</label>
                                    <input name="status" type="checkbox" value="status" data-toggle="toggle"
                                           style="display: none;" checked="checked">
                                    <div class="Switch Round On"
                                         style="vertical-align:top;margin-left:10px;">
                                        <div class="Toggle"></div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Thêm cổng thanh toán</button>
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
    <!-- /.content -->
    <script type="text/javascript">
        $(document).ready(function () {
//iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            })
            //Red color scheme for iCheck
            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                checkboxClass: 'icheckbox_minimal-red',
                radioClass: 'iradio_minimal-red'
            })
            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            })

            $(".walletFeesAjax").on('input propertychange change', function () {
                $.ajax({
                    url: "{{ url('/').'/'.$backendUrl.'/wallet-fees' }}",
                    type: "post",
                    dataType: "text",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        val: $(this).val(),
                        group: $(this).attr('data-group'),
                        key: $(this).attr('data-key')
                    },
                    success: function (data) {
                        console.log(data);
                    }
                }).done(function () {

                });
            });
        });
    </script>
@endsection
