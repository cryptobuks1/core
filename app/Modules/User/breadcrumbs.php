<?php

Breadcrumbs::for('userpanel', function ($trail) {
    $trail->parent('home');
    $trail->push('Bảng điều khiển', route('user.profile'));
});

Breadcrumbs::for('verifyphone', function ($trail) {
    $trail->parent('userpanel');
    $trail->push('Xác thực số điện thoại', route('frontend.account.verifyphone'));
});

Breadcrumbs::for('verifydocument', function ($trail) {
    $trail->parent('userpanel');
    $trail->push('Xác minh giấy tờ', route('frontend.account.verifydocument'));
});


Breadcrumbs::for('changepass', function ($trail) {
    $trail->parent('userpanel');
    $trail->push('Đổi mật khẩu', route('user.changepassword'));
});

Breadcrumbs::for('localbank', function ($trail) {
    $trail->parent('userpanel');
    $trail->push('Tài khoản ngân hàng', route('user.localbank'));
});