@extends('master')

@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/iCheck/all.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
@endsection
@section('js')
    @include('ckfinder::setup')
    <script src="{{ asset('adminlte/plugins/iCheck/icheck.min.js') }}"></script>
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
                        <h3 class="card-title">Cập nhật thông tin</h3>
                    </div>
                    {!! Form::model($paygate, ['method' => 'PATCH','route' => ['backend.paygates.update', $paygate->id]]) !!}
                    <div class="card-body p-0">
                        <div class="card-body row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Tên: </label>
                                    <input name="name" type="text" class="form-control" id="name"
                                           value="{{ $paygate->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="code">Mã cổng: </label>
                                    <input name="code" type="text" class="form-control" id="code"
                                           value="{{ $paygate->code }}" readonly="readonly">
                                </div>
                                <div class="form-group">
                                    <label for="currency_code">Tiền tệ cho cổng thanh toán: </label>

                                    <select class="form-control changemoney" name="currency_code">
                                        <option value="">== Chọn ==</option>
                                        @if(count($currencies) > 0)
                                            @foreach($currencies as $lc)
                                                <option value="{{$lc->code}}" @if($paygate->currency_id == $lc->id) selected @endif>{{$lc->name}} - {{$lc->code}}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                </div>


                                <div class="form-group row">

                                    <div>
                                        <img id="logo-icon" class="imgPreview" src="@if($paygate->avatar){{ url($paygate->avatar) }} @endif"/>
                                        <input type="hidden" name="avatar" id="avatar" class="inputImg" value="{{ old('avatar') }}"/>
                                    </div>
                                    <div style="margin-left: 15px">
                                        <button type="button" class="btn btn-default"
                                                onclick="selectFileWithCKFinder('avatar', 'logo-icon')">Chọn ảnh
                                        </button>

                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="description">Mô tả:</label>
                                    <textarea name="description" class="form-control" id="description">{{ $paygate->description }}</textarea>

                                </div>
                                @if( $configs )
                                    <div id="configField">
                                        @foreach($configs as $key=>$configp)
                                            <div class="form-group">
                                                <label for="{{ $key }}">{{ $key }}: </label>
                                                <input name="configs[{{ $key }}]" type="text" class="form-control"
                                                       id="{{ $key }}" value="{{ $configp }}">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label for="url">Url: </label>
                                    <input name="url" type="text" class="form-control" id="url"
                                           value="{{ $paygate->url }}">
                                </div>

                                <div class="form-group">

                                    <label for="payment">Cho phép quy đổi tiền tệ khi thanh toán</label>
                                    <input name="payment" type="checkbox" value="payment" data-toggle="toggle"
                                           style="display: none;"
                                           @if( $paygate->convert == 1 ) checked="checked" @endif>
                                    <div class="Switch Round @if($paygate->convert == 1) On @else Off @endif"
                                         style="vertical-align:top;margin-right:20px;margin-left: 10px">
                                        <div class="Toggle"></div>
                                    </div>

                                </div>

                                <div class="form-group">

                                    <label for="payment">Yêu cầu xác minh tài khoản mới cho thanh toán</label>
                                    <input name="payment" type="checkbox" value="payment" data-toggle="toggle"
                                           style="display: none;"
                                           @if( $paygate->verify == 1 ) checked="checked" @endif>
                                    <div class="Switch Round @if($paygate->verify == 1) On @else Off @endif"
                                         style="vertical-align:top;margin-right:20px;margin-left: 10px">
                                        <div class="Toggle"></div>
                                    </div>

                                </div>

                                <div class="form-group">

                                    <label for="payment">Cho thanh toán</label>
                                    <input name="payment" type="checkbox" value="payment" data-toggle="toggle"
                                           style="display: none;"
                                           @if( $paygate->payment == 1 ) checked="checked" @endif>
                                    <div class="Switch Round @if($paygate->payment == 1) On @else Off @endif"
                                         style="vertical-align:top;margin-right:20px;margin-left: 10px">
                                        <div class="Toggle"></div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="deposit">Cho nạp</label>
                                    <input name="deposit" type="checkbox" value="deposit" data-toggle="toggle"
                                           style="display: none;"
                                           @if( $paygate->deposit == 1 ) checked="checked" @endif>
                                    <div class="Switch Round @if($paygate->deposit == 1) On @else Off @endif"
                                         style="vertical-align:top;margin-right:20px;margin-left: 10px">
                                        <div class="Toggle"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="withdraw">Cho rút</label>
                                    <input name="withdraw" type="checkbox" value="withdraw" data-toggle="toggle"
                                           style="display: none;"
                                           @if( $paygate->withdraw == 1 ) checked="checked" @endif>
                                    <div class="Switch Round @if($paygate->withdraw == 1) On @else Off @endif"
                                         style="vertical-align:top;margin-right:20px;margin-left: 10px">
                                        <div class="Toggle"></div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="status">Trạng thái</label>
                                    <input name="status" type="checkbox" value="status" data-toggle="toggle"
                                           style="display: none;" @if( $paygate->status == 1 ) checked="checked" @endif>
                                    <div class="Switch Round @if($paygate->status == 1) On @else Off @endif"
                                         style="vertical-align:top;margin-left:10px;">
                                        <div class="Toggle"></div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="tags">Nhóm khách hàng được dùng:</label>
                                    <select name="groups[]" id="groups" class="form-control select2" multiple="multiple" data-placeholder="Thêm nhóm" >
                                        @foreach($groups as $group)
                                            <option value="{{ $group->id }}" @if(in_array($group->id, $selected_groups)) selected="selected" @endif>{{ $group->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <script type="text/javascript">
                                    $(function () {
                                        //Initialize Select2 Elements
                                        $('.select2').select2();
                                    })
                                </script>

                            </div>
                            <div class="col-md-8">

                                <fieldset class="border p-3">
                                    <legend  class="w-auto text-danger">Thanh toán</legend>

                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            @if($groups->count())
                                                @foreach( $groups as $group )
                                                    <th>Nhóm: {{ $group->name }}</th>
                                                @endforeach
                                            @endif

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><strong>Phí cố định (<span class="valuemoney">{{$paygate->currency_code}}</span>)</strong></td>
                                            @foreach($groups as $group)
                                                <td>
                                                    <input name="p_fixed_fees[{{$group->id}}]" type="number" step="0.01" class="form-control"
                                                           value="{{ $paygate->p_fixed_fees[$group->id] }}">
                                                </td>
                                            @endforeach
                                        </tr>

                                        <tr>
                                            <td><strong>Phí phần trăm (%)</strong></td>
                                            @foreach($groups as $group)
                                                <td>
                                                    <input name="p_percent_fees[{{$group->id}}]" type="number" step="0.01" class="form-control"
                                                           value="{{ $paygate->p_percent_fees[$group->id] }}">
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td><strong>Ngưỡng thanh toán không tính phí ({{$paygate->currency_code}})</strong></td>
                                            @foreach($groups as $group)
                                                <td>
                                                    <input name="p_nofees[{{$group->id}}]" type="number" step="0.01" class="form-control"
                                                           value="{{ $paygate->p_nofees[$group->id] }}">
                                                </td>
                                            @endforeach
                                        </tr>

                                        <tr>
                                            <td><strong>Số tiền thanh toán tối thiểu (<span class="valuemoney">{{$paygate->currency_code}}</span>)</strong> / <span class="text-muted"> xóa trắng là không giới hạn</span></td>
                                            @foreach($groups as $group)
                                                <td>
                                                    <input name="p_min[{{$group->id}}]" type="number" step="0.01" class="form-control"
                                                           value="{{ $paygate->p_min[$group->id] }}">
                                                </td>
                                            @endforeach
                                        </tr>

                                        <tr>
                                            <td><strong>Số tiền thanh toán đối đa (<span class="valuemoney">{{$paygate->currency_code}}</span>)</strong> / <span class="text-muted"> xóa trắng là không giới hạn</span></td>
                                            @foreach($groups as $group)
                                                <td>
                                                    <input name="p_max[{{$group->id}}]" type="number" step="0.01" class="form-control"
                                                           value="{{ $paygate->p_max[$group->id] }}">
                                                </td>
                                            @endforeach
                                        </tr>

                                        <tr>
                                            <td><strong>Giới hạn thanh toán ngày (<span class="valuemoney">{{$paygate->currency_code}}</span>)</strong> / <span class="text-muted"> xóa trắng là không giới hạn</span></td>
                                            @foreach($groups as $group)
                                                <td>
                                                    <input name="p_daily_limit[{{$group->id}}]" type="number" step="0.01" class="form-control"
                                                           value="{{ $paygate->p_daily_limit[$group->id] }}">
                                                </td>
                                            @endforeach
                                        </tr>
                                        </tbody>
                                    </table>

                                    <div class="form-group">
                                        <label>Cấm thanh toán tại các quốc gia (ví dụ: US,UK)</label>
                                        <input name="p_country_block" type="text" class="form-control"
                                               value="{{ $paygate->p_country_block }}">
                                    </div>

                                </fieldset>


                                <fieldset class="border p-3">
                                    <legend  class="w-auto text-danger">Nạp tiền</legend>

                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            @if($groups->count())
                                                @foreach( $groups as $group )
                                                    <th>Nhóm: {{ $group->name }}</th>
                                                @endforeach
                                            @endif

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><strong>Phí cố định (<span class="valuemoney">{{$paygate->currency_code}}</span>)</strong></td>
                                            @foreach($groups as $group)
                                                <td>
                                                    <input name="d_fixed_fees[{{$group->id}}]" type="number" step="0.01" class="form-control"
                                                           value="{{ $paygate->d_fixed_fees[$group->id] }}">
                                                </td>
                                            @endforeach
                                        </tr>

                                        <tr>
                                            <td><strong>Phí phần trăm (%)</strong></td>
                                            @foreach($groups as $group)
                                                <td>
                                                    <input name="d_percent_fees[{{$group->id}}]" type="number" step="0.01" class="form-control"
                                                           value="{{ $paygate->d_percent_fees[$group->id] }}">
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td><strong>Ngưỡng nạp không tính phí (<span class="valuemoney">{{$paygate->currency_code}}</span>)</strong></td>
                                            @foreach($groups as $group)
                                                <td>
                                                    <input name="d_nofees[{{$group->id}}]" type="number" step="0.01" class="form-control"
                                                           value="{{ $paygate->d_nofees[$group->id] }}">
                                                </td>
                                            @endforeach
                                        </tr>

                                        <tr>
                                            <td><strong>Số tiền nạp tối thiểu (<span class="valuemoney">{{$paygate->currency_code}}</span>)</strong> / <span class="text-muted"> xóa trắng là không giới hạn</span></td>
                                            @foreach($groups as $group)
                                                <td>
                                                    <input name="d_min[{{$group->id}}]" type="number" step="0.01" class="form-control"
                                                           value="{{ $paygate->d_min[$group->id] }}">
                                                </td>
                                            @endforeach
                                        </tr>

                                        <tr>
                                            <td><strong>Số tiền nạp đối đa (<span class="valuemoney">{{$paygate->currency_code}}</span>)</strong> / <span class="text-muted"> xóa trắng là không giới hạn</span></td>
                                            @foreach($groups as $group)
                                                <td>
                                                    <input name="d_max[{{$group->id}}]" type="number" step="0.01" class="form-control"
                                                           value="{{ $paygate->d_max[$group->id] }}">
                                                </td>
                                            @endforeach
                                        </tr>

                                        <tr>
                                            <td><strong>Giới hạn nạp ngày (<span class="valuemoney">{{$paygate->currency_code}}</span>)</strong> / <span class="text-muted"> xóa trắng là không giới hạn</span></td>
                                            @foreach($groups as $group)
                                                <td>
                                                    <input name="d_daily_limit[{{$group->id}}]" type="number" step="0.01" class="form-control"
                                                           value="{{ $paygate->d_daily_limit[$group->id] }}">
                                                </td>
                                            @endforeach
                                        </tr>
                                        </tbody>
                                    </table>

                                    <div class="form-group">
                                        <label>Cấm nạp tại các quốc gia (ví dụ: US,UK)</label>
                                        <input name="d_country_block" type="text" class="form-control"
                                               value="{{ $paygate->d_country_block }}">
                                    </div>

                                </fieldset>


                                <fieldset class="border p-3">
                                    <legend  class="w-auto text-danger">Rút tiền</legend>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            @if($groups->count())
                                                @foreach( $groups as $group )
                                                    <th>Nhóm: {{ $group->name }}</th>
                                                @endforeach
                                            @endif

                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>Phí cố định (<span class="valuemoney">{{$paygate->currency_code}}</span>)</strong></td>
                                                @foreach($groups as $group)
                                                    <td>
                                                    <input name="w_fixed_fees[{{$group->id}}]" type="number" step="0.01" class="form-control"
                                                           value="{{ $paygate->w_fixed_fees[$group->id] }}">
                                                    </td>
                                                @endforeach
                                            </tr>

                                            <tr>
                                                <td><strong>Phí phần trăm (%)</strong></td>
                                                @foreach($groups as $group)
                                                    <td>
                                                        <input name="w_percent_fees[{{$group->id}}]" type="number" step="0.01" class="form-control"
                                                               value="{{ $paygate->w_percent_fees[$group->id] }}">
                                                    </td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td><strong>Ngưỡng rút không tính phí (<span class="valuemoney">{{$paygate->currency_code}}</span>)</strong></td>
                                                @foreach($groups as $group)
                                                    <td>
                                                        <input name="w_nofees[{{$group->id}}]" type="number" step="0.01" class="form-control"
                                                               value="{{ $paygate->w_nofees[$group->id] }}">
                                                    </td>
                                                @endforeach
                                            </tr>

                                            <tr>
                                                <td><strong>Số tiền rút tối thiểu (<span class="valuemoney">{{$paygate->currency_code}}</span>)</strong> / <span class="text-muted"> xóa trắng là không giới hạn</span></td>
                                                @foreach($groups as $group)
                                                    <td>
                                                        <input name="w_min[{{$group->id}}]" type="number" step="0.01" class="form-control"
                                                               value="{{ $paygate->w_min[$group->id] }}">
                                                    </td>
                                                @endforeach
                                            </tr>

                                            <tr>
                                                <td><strong>Số tiền rút đối đa (<span class="valuemoney">{{$paygate->currency_code}}</span>)</strong> / <span class="text-muted"> xóa trắng là không giới hạn</span></td>
                                                @foreach($groups as $group)
                                                    <td>
                                                        <input name="w_max[{{$group->id}}]" type="number" step="0.01" class="form-control"
                                                               value="{{ $paygate->w_max[$group->id] }}">
                                                    </td>
                                                @endforeach
                                            </tr>

                                            <tr>
                                                <td><strong>Giới hạn rút ngày (<span class="valuemoney">{{$paygate->currency_code}}</span>)</strong> / <span class="text-muted"> xóa trắng là không giới hạn</span></td>
                                                @foreach($groups as $group)
                                                    <td>
                                                        <input name="w_daily_limit[{{$group->id}}]" type="number" step="0.01" class="form-control"
                                                               value="{{ $paygate->w_daily_limit[$group->id] }}">
                                                    </td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="form-group">
                                        <label>Cấm rút tại các quốc gia (ví dụ: US,UK)</label>
                                        <input name="w_country_block" type="text" class="form-control"
                                               value="{{ $paygate->w_country_block }}">
                                    </div>

                                </fieldset>


                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Lưu lại</button>
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
            $(".changemoney").on('change', function () {
                $(".valuemoney").text(this.value);
            });
        });
    </script>
@endsection
