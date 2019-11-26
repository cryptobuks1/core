@extends('frontend.'.$current_theme.'.common')
@section('breadcrumbs', Breadcrumbs::render('userpanel'))
@section('content')
    <h4><span class="text-uppercase">Thông tin tài khoản</span></h4>
    @theme_include('errors.errors')
    <div class="blockContent">
        <div class="row">
            <div class=" col-md-12">
                <table class="table">
                    <tbody>
                    <tr>
                        <td>Tên đăng nhập:</td>
                        <td><strong>{{ $user->username }}</strong></td>
                    </tr>
                    <tr>
                        <td>Họ và tên:</td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td>Điện thoại:</td>
                        <td>{{ $user->phone }}</td>
                    </tr>
                    <tr>
                        <td>Nhóm:</td>
                        <td>@if($userGroup) {{$userGroup->name}} @endif</td>
                    </tr>
                    <tr>
                        <td>Xác thực số điện thoại:</td>
                        <td>@if($user->verify_phone == 1)
                                <div class="text-success">Đã xác thực</div>@else
                                <a href="{{route('frontend.account.verifyphone')}}"><button class="btn btn-sm btn-danger">Chưa xác thực</button></a>@endif</td>
                    </tr>

                    <tr>
                        <td>Xác thực email:</td>
                        <td>@if($user->verify_email == 1)
                                <div class="text-success">Đã xác thực</div>@else
                                <button class="btn btn-sm btn-danger">Chưa xác thực</button>@endif</td>
                    </tr>

                    <tr>
                        <td>Xác thực giấy tờ:</td>
                        <td>@if($user->verify_document == 1)
                                <div class="text-success">Đã xác thực</div>@else
                                <button class="btn btn-sm btn-danger">Chưa xác thực</button>@endif</td>
                    </tr>

                    <tr>
                        <td>Ngày đăng ký:</td>
                        <td>{{ $user->created_at }}</td>
                    </tr>
                    <tr>
                        <td>Ví điện tử:</td>
                        <td>
                            @if(count($wallets) > 0)
                                @foreach($wallets as $wallet)
                                    {{$wallet['number']}} (<span
                                            class="text-success"><b>{{$wallet['balance']}} {{$wallet['currency_code']}}</b></span>
                                    )<br>

                                @endforeach
                            @endif
                        </td>

                    </tr>

                    </tbody>
                </table>

                <a href="{{route('edit.profile')}}" class="btn btn-success">Sửa thông tin</a>
                <a href="{{url('change-password')}}" class="btn btn-warning">Đổi mật khẩu</a>
            </div>
        </div>
        <br>
        <br>
        <h4><span class="text-uppercase">Lịch sử đăng nhập</span></h4>
        <div class="row">
            <div class=" col-md-12">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped ">
                        <thead>
                        <tr>
                            <th>IP</th>
                            <th>Ngày tạo</th>
                            <th>Agent</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $logs as $log )
                            <tr class="irow" data-id="{{ $log->id }}">
                                <td>{{ $log->ip }}</td>
                                <td>{{ $log->created_at }}</td>
                                <td>{{ $log->user_agent }}</td>

                            </tr>
                        @endforeach

                        </tbody>


                    </table>
                </div>

            </div>
        </div>


    </div>

@endsection
