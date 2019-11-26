<?php

Breadcrumbs::for('tin-tuc', function ($trail) {
    $trail->parent('home');
    $trail->push('Tin tức', route('frontend.news.index'));
});
Breadcrumbs::for('chi-tiet', function ($trail, $news) {
    $trail->parent('tin-tuc');
    $trail->push($news->title, route('frontend.news.view', $news->news_slug));
});