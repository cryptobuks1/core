@extends('frontend.'.$current_theme.'.common')
@section('breadcrumbs', Breadcrumbs::render('localbank'))
@section('content')
    @theme_include('errors.errors')
    <h4><span class="text-uppercase">Bước 2: Xác minh thông tin</span></h4>

    <table id="mytable" class="table table-bordred table-striped">

        <thead>
        <th>Ngân hàng</th>
        <th>Số tài khoản</th>
        <th>Chủ tài khoản</th>
        <th>Chi nhánh</th>
        <th>Trạng thái</th>
        <th></th>
        </thead>
        <tbody>
            <tr>
                <td>{{ $bank->code }}</td>
                <td>{{ $bank->acc_num }}</td>
                <td>{{ $bank->acc_name }}</td>
                <td>{{ $bank->branch }}</td>
                <td>
                    <span class="label label-warning">Đang duyệt</span>
                </td>
            </tr>
        </tbody>
    </table>

    <h4><span class="text-uppercase">Mã bảo mật</span></h4>

    {!! Form::open(array('route' => 'user.localbank.verify','method'=>'POST')) !!}
    <div class="card-body row">
        <div class="col-md-12">
            {!! $twofactor !!}
            <div class="form-group">
                <input name="id" type="hidden" class="form-control" value="{{ $bank->id }}">
                <input name="hash" type="hidden" class="form-control" value="{{ $hash }}">
            </div>

        </div>

    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Xác thực</button>
    </div>
    {!! Form::close() !!}


@endsection
