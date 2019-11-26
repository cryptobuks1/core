<?php

Breadcrumbs::for('page', function ($trail,$news) {
    $trail->parent('home');
    $trail->push($news->title,route('frontend.staticpage.view', $news->slug));
});
