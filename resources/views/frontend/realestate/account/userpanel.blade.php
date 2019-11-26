
<li><a href="{{ url('profile')}}" class="hover_item"><i class="fa fa-angle-right"></i> <strong>Thông tin tài khoản</strong></a></li>
<li><a href="{{ url('wallet/list') }}" class="hover_item"><i class="fa fa-angle-right"></i> <strong>Ví điện tử</strong></a></li>
<li><a href="{{ url('history/softcard') }}" class="hover_item"><i class="fa fa-angle-right"></i> <strong>Lịch sử mua thẻ</strong></a></li>
<li><a href="{{ url('wallet/deposit') }}" class="hover_item"><i class="fa fa-angle-right"></i> <strong>Nạp tiền</strong></a></li>
<li><a href="{{ url('wallet/withdraw') }}" class="hover_item"><i class="fa fa-angle-right"></i> <strong>Rút tiền</strong></a></li>
<li><a href="{{ url('transfer') }}" class="hover_item"><i class="fa fa-angle-right"></i> <strong>Chuyển tiền</strong></a></li>
<li><a href="{{ url('user/localbank') }}" class="hover_item"><i class="fa fa-angle-right"></i> <strong>Tài khoản ngân hàng</strong></a></li>
<li><a href="{{ url('change-password') }}" class="hover_item"><i class="fa fa-angle-right"></i> <strong>Đổi mật khẩu</strong></a></li>
<li><a class="hover_item" href="{{ route('frontend.account.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-angle-right"></i> <strong>@lang('profiles.logout')</strong></a></li>
{!! Form::open(array('route' => 'logout','method'=>'POST', 'id'=>'logout-form', 'style'=>"display: none;")) !!}{!! Form::close() !!}
