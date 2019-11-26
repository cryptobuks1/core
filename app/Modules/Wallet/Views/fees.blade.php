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


                    <div class="card-body row">
                        {!! Form::model($wfee, ['method' => 'PATCH','route' => ['bk.wallet.updatefee', $wfee->id]]) !!}


                        <fieldset class="border p-3">
                            <legend class="w-auto text-danger">Cấu hình tổng</legend>
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
                                    <td><strong>Tổng số tiền nạp trong ngày ({{$wfee->currency_code}})</strong></td>
                                    @foreach($groups as $group)
                                        <td>
                                            <input name="total_daily_deposit[{{$group->id}}]" type="number" step="0.01"
                                                   class="form-control"
                                                   value="{{ $wfee->total_daily_deposit[$group->id] }}">
                                        </td>
                                    @endforeach
                                </tr>

                                <tr>
                                    <td><strong>Tổng số tiền rút trong ngày ({{$wfee->currency_code}})</strong></td>
                                    @foreach($groups as $group)
                                        <td>
                                            <input name="total_daily_withdraw[{{$group->id}}]" type="number" step="0.01"
                                                   class="form-control"
                                                   value="{{ $wfee->total_daily_withdraw[$group->id] }}">
                                        </td>
                                    @endforeach
                                </tr>
                                </tbody>
                            </table>


                            <table class="table table-bordered table-striped">
                                <tbody>
                                <tr>
                                    <td><strong>Thông báo nạp tiền</strong></td>
                                    <td>
                                        <textarea name="deposit_info" class="form-control" type="text">{{ $wfee->deposit_info }}</textarea>
                                    </td>
                                </tr>

                                <tr>
                                    <td><strong>Thông báo rút tiền</strong></td>
                                    <td>
                                        <textarea name="withdraw_info" class="form-control" type="text">{{ $wfee->withdraw_info }}</textarea>
                                    </td>
                                </tr>

                                </tbody>
                            </table>


                        </fieldset>

        <fieldset class="border p-3">
                            <legend class="w-auto text-danger">Phí chuyển tiền</legend>
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
                                    <td><strong>Phí cố định ({{$wfee->currency_code}})</strong></td>
                                    @foreach($groups as $group)
                                        <td>
                                            <input name="t_fixed_fees[{{$group->id}}]" type="number" step="0.01"
                                                   class="form-control"
                                                   value="{{ $wfee->t_fixed_fees[$group->id] }}">
                                        </td>
                                    @endforeach
                                </tr>

                                <tr>
                                    <td><strong>Phí phần trăm (%)</strong></td>
                                    @foreach($groups as $group)
                                        <td>
                                            <input name="t_percent_fees[{{$group->id}}]" type="number" step="0.01"
                                                   class="form-control"
                                                   value="{{ $wfee->t_percent_fees[$group->id] }}">
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td><strong>Ngưỡng chuyển tiền không tính phí ({{$wfee->currency_code}})</strong>
                                    </td>
                                    @foreach($groups as $group)
                                        <td>
                                            <input name="t_nofees[{{$group->id}}]" type="number" step="0.01"
                                                   class="form-control"
                                                   value="{{ $wfee->t_nofees[$group->id] }}">
                                        </td>
                                    @endforeach
                                </tr>

                                <tr>
                                    <td><strong>Số tiền chuyển tối thiểu ({{$wfee->currency_code}})</strong> / <span
                                                class="text-muted"> xóa trắng là không giới hạn</span></td>
                                    @foreach($groups as $group)
                                        <td>
                                            <input name="t_min[{{$group->id}}]" type="number" step="0.01"
                                                   class="form-control"
                                                   value="{{ $wfee->t_min[$group->id] }}">
                                        </td>
                                    @endforeach
                                </tr>

                                <tr>
                                    <td><strong>Số tiền chuyển đối đa ({{$wfee->currency_code}})</strong> / <span
                                                class="text-muted"> xóa trắng là không giới hạn</span></td>
                                    @foreach($groups as $group)
                                        <td>
                                            <input name="t_max[{{$group->id}}]" type="number" step="0.01"
                                                   class="form-control"
                                                   value="{{ $wfee->t_max[$group->id] }}">
                                        </td>
                                    @endforeach
                                </tr>

                                <tr>
                                    <td><strong>Giới hạn chuyển ngày ({{$wfee->currency_code}})</strong> / <span
                                                class="text-muted"> xóa trắng là không giới hạn</span></td>
                                    @foreach($groups as $group)
                                        <td>
                                            <input name="t_daily_limit[{{$group->id}}]" type="number" step="0.01"
                                                   class="form-control"
                                                   value="{{ $wfee->t_daily_limit[$group->id] }}">
                                        </td>
                                    @endforeach
                                </tr>
                                </tbody>
                            </table>

                        </fieldset>


                        <fieldset class="border p-3">
                            <legend class="w-auto text-danger">Phí thanh toán</legend>
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
                                    <td><strong>Phí cố định ({{$wfee->currency_code}})</strong></td>
                                    @foreach($groups as $group)
                                        <td>
                                            <input name="p_fixed_fees[{{$group->id}}]" type="number" step="0.01"
                                                   class="form-control"
                                                   value="{{ $wfee->p_fixed_fees[$group->id] }}">
                                        </td>
                                    @endforeach
                                </tr>

                                <tr>
                                    <td><strong>Phí phần trăm (%)</strong></td>
                                    @foreach($groups as $group)
                                        <td>
                                            <input name="p_percent_fees[{{$group->id}}]" type="number" step="0.01"
                                                   class="form-control"
                                                   value="{{ $wfee->p_percent_fees[$group->id] }}">
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td><strong>Ngưỡng thanh toán không tính phí ({{$wfee->currency_code}})</strong>
                                    </td>
                                    @foreach($groups as $group)
                                        <td>
                                            <input name="p_nofees[{{$group->id}}]" type="number" step="0.01"
                                                   class="form-control"
                                                   value="{{ $wfee->p_nofees[$group->id] }}">
                                        </td>
                                    @endforeach
                                </tr>

                                <tr>
                                    <td><strong>Số tiền thanh toán tối thiểu ({{$wfee->currency_code}})</strong> / <span
                                                class="text-muted"> xóa trắng là không giới hạn</span></td>
                                    @foreach($groups as $group)
                                        <td>
                                            <input name="p_min[{{$group->id}}]" type="number" step="0.01"
                                                   class="form-control"
                                                   value="{{ $wfee->p_min[$group->id] }}">
                                        </td>
                                    @endforeach
                                </tr>

                                <tr>
                                    <td><strong>Số tiền thanh toán đối đa ({{$wfee->currency_code}})</strong> / <span
                                                class="text-muted"> xóa trắng là không giới hạn</span></td>
                                    @foreach($groups as $group)
                                        <td>
                                            <input name="p_max[{{$group->id}}]" type="number" step="0.01"
                                                   class="form-control"
                                                   value="{{ $wfee->p_max[$group->id] }}">
                                        </td>
                                    @endforeach
                                </tr>

                                <tr>
                                    <td><strong>Giới hạn thanh toán ngày ({{$wfee->currency_code}})</strong> / <span
                                                class="text-muted"> xóa trắng là không giới hạn</span></td>
                                    @foreach($groups as $group)
                                        <td>
                                            <input name="p_daily_limit[{{$group->id}}]" type="number" step="0.01"
                                                   class="form-control"
                                                   value="{{ $wfee->p_daily_limit[$group->id] }}">
                                        </td>
                                    @endforeach
                                </tr>
                                </tbody>
                            </table>

                        </fieldset>


                        <br>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>

                        {!! Form::close() !!}
                    </div>


                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
