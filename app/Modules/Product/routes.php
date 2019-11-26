<?php

$namespace = 'App\Modules\Product\Controllers';

$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Product', 'namespace' => $namespace], function () {
    Route::resource('product','ProductController');
    Route::resource('product-branded','BrandController');
    Route::post('product/actions','ProductController@actions');
    Route::post('setting/price/product','ProductController@settingPrice')->name('backend.setting.price.product');
    Route::post('product/ajaxslug', 'ProductController@ajaxSlug');
    Route::post('product/ajaxbranded', 'ProductController@ajaxbranded')->name('backend.ajax.branded');
    Route::get('product/{id}/options', 'ProductController@options')->name('backend.product.options');
    Route::post('product/option/create/value', 'ProductController@postOptionValue')->name('backend.product.optionvalue.create');
    Route::get('product/{product}/option/edit/{id}', 'ProductController@editOptionValue')->name('backend.product.optionvalue.edit');
    Route::delete('product/{id}/option/value/delete', 'ProductController@deleteOptionValue')->name('backend.product.optionvalue.delete');
    Route::PATCH('product/option/update/{id}', 'ProductController@updateOptionValue')->name('backend.product.optionvalue.update');

});

//Frontend
Route::group(['middleware' => ['web'], 'module'=>'Product', 'namespace' => $namespace], function () {
    Route::get('san-pham', ['as'=>'frontend.all.product.view', 'uses'=>'ProductFrontController@viewAllProduct']);
    Route::get('{product_uri}', ['as'=>'frontend.product.catview', 'uses'=>'ProductFrontController@ProductCatView']);
    Route::get('{product_uri}/{product_slug}.html', ['as'=>'frontend.product.view.uri.slug', 'uses'=>'ProductFrontController@viewProduct']);
    Route::get('search/{search}',['as'=>'fontend.search.view','uses'=>'ProductFrontController@viewSearchProduct']);
    Route::post('search/s/',['as'=>'fontend.search.view','uses'=>'ProductFrontController@searchProduct']);

    Route::get('product/quickbuy', ['as'=>'frontend.product.quickbuy', 'uses'=>'ProductFrontController@quickBuy']);
    Route::get('/product/checkout',['as'=>'frontend.product.checkout', 'uses'=>'MtopupFrontController@viewPageCheckout']);

    ///Giỏ hàng
    Route::get('product/cart', ['as'=>'frontend.product.cart', 'uses'=>'ProductFrontController@cart']);
    Route::post('product/cart', ['as'=>'frontend.product.post.cart', 'uses'=>'ProductFrontController@postCart']);
    Route::post('product/ajaxcheckout', ['as'=>'product.ajaxpost', 'uses'=>'ProductFrontController@postAjxcheckout']);
    Route::post('ajax-district',['as'=>'frontend.ajax.district','uses'=>'ProductFrontController@ajaxDistrict']);
});

// Frontend Breadcrumbs

Breadcrumbs::for('san-pham', function ($trail) {
    $trail->parent('home');
    $trail->push('Sản phẩm', route('frontend.all.product.view'));
});
Breadcrumbs::for('danh-muc-san-pham', function ($trail,$cate) {
    $trail->parent('home');
    $trail->push($cate->name, route('frontend.product.catview',$cate->url_key));
});
Breadcrumbs::for('product-view', function ($trail,$product,$cate) {
    $trail->parent('danh-muc-san-pham',$cate);
    $trail->push($product->name);
});