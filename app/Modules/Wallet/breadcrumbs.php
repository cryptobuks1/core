<?php

Breadcrumbs::for('wallet', function ($trail) {
    $trail->parent('home');
    $trail->push('Ví điện tử', route('user.wallet'));
});

Breadcrumbs::for('wtransaction', function ($trail) {
    $trail->parent('wallet');
    $trail->push('Lịch sử ví', route('wallet.transaction'));
});

Breadcrumbs::for('depositwallet', function ($trail) {
    $trail->parent('wallet');
    $trail->push('Nạp tiền vào ví', route('frontend.wallet.deposit'));
});

Breadcrumbs::for('withdrawwallet', function ($trail) {
    $trail->parent('wallet');
    $trail->push('Rút tiền từ ví', route('frontend.wallet.withdraw'));
});

Breadcrumbs::for('transfer', function ($trail) {
    $trail->parent('wallet');
    $trail->push('Chuyển tiền', route('wallet.transfer'));
});