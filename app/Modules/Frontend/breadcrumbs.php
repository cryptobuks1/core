<?php

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Trang chủ', route('home'));
});

Breadcrumbs::for('default', function ($trail,$title) {
    $trail->parent('home');
    $trail->push($title, route('home'));
});