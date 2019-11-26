<?php
Breadcrumbs::for('checkout', function ($trail) {
    $trail->parent('home');
    $trail->push('Thanh toán', route('frontend.order.checkout'));
});

Breadcrumbs::for('orderuser', function ($trail) {
    $trail->parent('home');
    $trail->push('Lịch sử đơn hàng', route('frontend.user.order'));
});