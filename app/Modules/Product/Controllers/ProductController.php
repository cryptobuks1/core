<?php

namespace App\Modules\Product\Controllers;

use App\Modules\Categories\Models\Categories;
use App\Modules\Currency\Models\Currencies;
use App\Modules\Group\Models\Group;
use App\Modules\Language\Models\Language;
use App\Modules\Product\Models\ProductBrand;
use App\Modules\Product\Models\ProductPrice;
use App\Modules\Seo\Models\Seo;
use App\Modules\Slug\Models\Slug;
use Illuminate\Http\Request;

use App\Modules\Backend\Controllers\BackendController;
use Auth;
use View;
use DB;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\ProductGallery;
use App\Modules\Product\Models\ProductOption;
use App\Modules\Product\Models\ProductOptionValue;
use App\Modules\Product\Models\ProductCategories;
use Storage;

class ProductController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $title = 'Quản lý sản phẩm';
        View::share ('title', $title );
    }

	public function index(Request $request)
	{
		$product = Product::orderBy('id','DESC')->paginate(20);

		if($request->input('keyword')!='')
        {
            $keyword = $request->input('keyword');
            $title  = "Search: ".$keyword;
            $typeSearch = $request->input('type');
            $title  = "Search: ";
            if($typeSearch!==''){
                switch ($typeSearch) {
                    case 'description':
                        $title .= 'Description = ';
                        break;
                    case 'status':
                        $title .= 'Status = ';
                        break;
                    default:
                        $title .= 'Name = ';
                        break;
                }
                if($typeSearch=='status'){
                    $product = Product::where($typeSearch, $keyword)->orderBy('id','DESC')->paginate(10);

                }else{
                    $product = Product::where($typeSearch, 'LIKE', '%'.$keyword.'%')->orderBy('id','DESC')->paginate(10);

                }

            }else{
                $product = Product::where('name', 'LIKE', '%'.$keyword.'%')
                                ->orWhere('description', 'LIKE', '%'.$keyword.'%')
                                ->paginate(10);

            }
            $title .= $keyword;
        }

        foreach ($product as $item){
            $images = static::getProductGallery($item->id);
            $item->image = '';
            if(count($images) > 0){
                $item->image = $images[0];
            }

            if($item->cats){
                $catts = Categories::whereIn('id', $item->cats)->select('name')->get();
                $item->catts = $catts;
            }else{
                $item->catts = null;
            }

        }

		return view("Product::index", compact('product'));
	}

	public function create()
	{
		if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
            $seo_cat = Categories::select('name', 'url_key','id')->get();
            $cats = Categories::pluck('name', 'id')->toArray();
            $brands = ProductBrand::where('status',1)->get();
            $categories = static::getCategories();

            $currencies = Currencies::where('fiat', 1)->where('status', 1)->get();
            $langs = Language::where('status', 1)->orderBy('default', 'DESC')->get();
            $groups = Group::where('status', 1)->get();

            return view('Product::create',compact('categories', 'seo_cat','brands', 'cats','currencies', 'langs', 'groups'));
        }else{
            echo 'Not Access';
            die() ;
        }
	}


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'sku' => 'required|unique:product,sku',
        ]);
        $input = $request->all();

        if($request->has('images') && is_array($request->images)){
            $i=0;
            foreach ($request->images as $img){
                if ($img){
                    $imagelink = explode('storage',$img);
                    $input['images'][$i] = '/storage'.$imagelink[1];
                    $i++;
                }
            }
        }

        $lang = cache()->get('language');
        if(!$input['product_uri']){
            $input['product_uri'] = 'uncategory';
        }else{
            $input['product_uri'] = $request->product_uri;
        }

        $slugobj = new \App\Helpers\SlugHelper;
        $input['product_slug'] = $slugobj->slug($request->product_slug);

        if(! Slug::checkSlug($input['product_slug'])){
            return redirect()->back()->withErrors(['error' => 'Đường dẫn SEO đã tồn tại, vui lòng chỉnh sửa lại']);
        }

        DB::beginTransaction();

        ///Seo onpage
        $meta['link'] = $input['product_uri'].'/'.$input['product_slug'];
        $meta['title'] = $input['name'];
        $meta['description'] = (isset($input['short_description'])) ? $input['short_description'] : $input['name'];
        $meta['language'] = (isset($input['language']) && $input['language']) ? $input['language'] : $lang;
        $seo_id = Seo::createMeta($meta);

        $input['seo'] = $seo_id;
        $product = Product::create($input);

        if(isset($request->catalogs) && count($request->catalogs)){
            foreach ($request->catalogs as $cate_id) {
                $pro_cate = new ProductCategories(array(
                    'category_id' => $cate_id,
                    'product_id' => $product->id,
                    'product_type' => Product::PRODUCT_TYPE_DEFAULT,
                ));
                $pro_cate->save();
            }
        }

        DB::commit();
        /* save Gallery Data */
        if($request->input('images')){
            foreach ($input['images'] as $number_img => $image) {
                if ($image) {
                    $is_thumb = 0;
                    if ($number_img == $request->is_thumb)
                        $is_thumb = 1;
                    (isset($request->img_label[$number_img]) && $request->img_label[$number_img]) ? $img_label = $request->img_label[$number_img] : $img_label = '';
                    (isset($request->img_order[$number_img]) && $request->img_order[$number_img]) ? $img_order = $request->img_order[$number_img] : $img_order = 0;
                    (isset($request->img_status[$number_img]) && $request->img_status[$number_img] > 0) ? $img_status = 1 : $img_status = 0;
                    $gallery = new ProductGallery(array(
                        'product_id' => $product->id,
                        'product_type' => Product::PRODUCT_TYPE_DEFAULT,
                        'value' => $image,
                        'label' => $img_label,
                        'is_thumb' => $is_thumb,
                        'sort_order' => $img_order,
                        'status' => $img_status,
                    ));
                    $gallery->save();
                }
            }
        }

        return redirect()->route('product.index')
            ->with('success','Product created successfully');
    }

    public function edit($id)
    {
        if(allow('edit') === true)
        {
            $brands = ProductBrand::where('status',1)->get();
            $product = Product::find($id);
            $gallery = $this->getProductGallery($id);
            $seo_cat = Categories::select('name', 'url_key','id')->get();
            $Branded = new ProductBrand();

            $ProductPrice = new ProductPrice();

            $currencies = Currencies::where('fiat', 1)->where('status', 1)->get();
            $langs = Language::where('status', 1)->orderBy('default', 'DESC')->get();
            $cats = Categories::pluck('name', 'id')->toArray();
            $groups = Group::where('status', 1)->get();
            if($product->cats){
                $current_cats = $product->cats;
            }else{
                $current_cats = [];
            }

            return view('Product::edit',compact('brands','ProductPrice','currencies','groups','product','categories','gallery','seo_cat','Branded', 'cats', 'current_cats', 'langs'));
        }else{
            return 'Not Access';
        }
    }

	public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'sku' => 'required|max:100|unique:product,sku,'.$id
        ]);

        /* update Product Data */
        if(!isset($request->is_instock)) $request->is_instock = 0;
        if(!isset($request->status)) $request->status = 0;


        $product = Product::find($id);
        $product->name = $request->name;
        $product->product_uri = ($request->product_uri) ? $request->product_uri : 'uncategory';
        $product->product_slug = $request->product_slug;
        $product->sku = $request->sku;
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        $product->listedprice = $request->listedprice;
        $product->inputprice = $request->inputprice;
        $product->price = $request->price;
        $product->custom_layout = $request->custom_layout;
        $product->qty = $request->qty;
        $product->is_instock = isset($request->is_instock)?1:0;
        $product->status = isset($request->status)?1:0;
        $product->weight = $request->weight;
        $product->barcode = $request->barcode;
        $product->language = $request->language;
        $product->cats = $request->cats;
        $product->volume = $request->volume;

        $product->update();

        /* update Categories Data */
        if(isset($request->catalogs) && count($request->catalogs)){
            /* delete category if not select */
            ProductCategories::where('product_id',$id)
                                ->where('product_type',Product::PRODUCT_TYPE_DEFAULT)
                                ->whereNotIn('category_id',$request->catalogs)
                                ->delete();
            /* create new category for product */
            foreach ($request->catalogs as $cate_id) {
                if ($cate_id){
                ProductCategories::updateOrCreate(array(
                    'category_id' => $cate_id,
                    'product_id' => $id,
                    'product_type' => Product::PRODUCT_TYPE_DEFAULT,
                ));
                }
            }
        }else{
            /* delete all categories */
            ProductCategories::where('product_id',$id)
                                ->where('product_type',Product::PRODUCT_TYPE_DEFAULT)
                                ->delete();
        }

        /* update Gallery Data */
        /* get all exists gallery */
        $countGallery = ProductGallery::where('product_id',$id)
                                        ->where('product_type',Product::PRODUCT_TYPE_DEFAULT)
                                        ->count();
        if(isset($request->gallery_exists) && count($request->gallery_exists)){
            /* delete gallery if not exists */
            $deleteGallery = ProductGallery::where('product_id',$id)
                                        ->where('product_type',Product::PRODUCT_TYPE_DEFAULT)
                                        ->whereNotIn('id',$request->gallery_exists)
                                        ->get();
            $this->deleteProductGallery($deleteGallery);

            /* Add new and update gallery exists */
            foreach ($request->gallery_exists as $number_img => $galleryId) {
                $is_thumb = 0;
                if($number_img==$request->is_thumb){
                    $is_thumb = 1;
                }
                (isset($request->img_label[$number_img]) && $request->img_label[$number_img]) ? $img_label = $request->img_label[$number_img] : $img_label = '';
                (isset($request->img_order[$number_img]) && $request->img_order[$number_img]) ? $img_order = $request->img_order[$number_img] : $img_order = 0;
                (isset($request->img_status[$number_img]) && $request->img_status[$number_img]>0) ? $img_status = 1 : $img_status = 0;
                if($galleryId){
                    /* update gallery */
                    $gallery = ProductGallery::find($galleryId);
                    $gallery->label = $img_label;
                    $gallery->is_thumb = $is_thumb;
                    $gallery->sort_order = $img_order;
                    $gallery->status = $img_status;
                    $gallery->save();
                }else{
                    /* add new gallery */
                    if(is_object($request->images[$number_img])){
                        $filename = $request->images[$number_img]->store('product/images','public');
                        $gallery = new ProductGallery(array(
                            'product_id' => $id,
                            'product_type' => Product::PRODUCT_TYPE_DEFAULT,
                            'value' => $filename,
                            'label' => $img_label,
                            'is_thumb' => $is_thumb,
                            'sort_order' => $img_order,
                            'status' => $img_status,
                        ));
                        $gallery->save();
                    }
                }
            }
        }elseif($countGallery){
            /* delete all gallery */
            $existsGallery = ProductGallery::where('product_id',$id)
                                        ->where('product_type',Product::PRODUCT_TYPE_DEFAULT)
                                        ->get();
            $this->deleteProductGallery($existsGallery);

        }

        if($request->images && is_array($request->images)){

            foreach ($request->images as $key => $img){

                if($img){
                    $imagelink = explode('storage',$img);

                    if($key==$request->is_thumb)
                        $is_thumb = 1;
                    (isset($request->img_label[$key]) && $request->img_label[$key]) ? $img_label = $request->img_label[$key] : $img_label = '';
                    (isset($request->img_order[$key]) && $request->img_order[$key]) ? $img_order = $request->img_order[$key] : $img_order = 0;
                    (isset($request->img_status[$key]) && $request->img_status[$key]>0) ? $img_status = 1 : $img_status = 0;
                    $gallery = new ProductGallery(array(
                        'product_id' => $id,
                        'product_type' => Product::PRODUCT_TYPE_DEFAULT,
                        'value' => '/storage'.$imagelink[1],
                        'label' => $img_label,
                        'is_thumb' => $is_thumb,
                        'sort_order' => $img_order,
                        'status' => $img_status,
                    ));
                    $gallery->save();
                }

            }
        }

        return redirect()->route('product.index')
                        ->with('success','Product updated successfully');
    }

    public function destroy($id)
    {
        if(allow('delete') === true)
        {
            DB::beginTransaction();

            /* delete product gallery */
            $images = ProductGallery::where('product_id',$id)
                            ->where('product_type',Product::PRODUCT_TYPE_DEFAULT)
                            ->get();
            foreach ($images as $image) {
                Storage::delete($image->value);
                ProductGallery::find($image->id)->delete();
            }

            ProductOptionValue::where('product_id',$id)->delete();

            Product::find($id)->delete();

            DB::commit();

            return redirect()->route('product.index')
                        ->with('success','Product deleted successfully');
        }else{
            return 'Not Access';

        }
    }

	public function actions(Request $request)
    {
        $val    = $request->check;
        $action = $request->action;
        if(empty($val)){
            return redirect()->route('product.index')->withErrors(['message' =>'Không có mục nào được chọn.']);
        }

        foreach ($val as $value) {
            $this->_runAction($value, $action);
        }
        return redirect()->route('product.index')->with('success','Product '.$action.' successfully');
    }

    private function _runAction($id, $action)
    {
        switch ($action) {
            case 'delete':
                $this->destroy($id);
                break;
            
            default:
                break;
        }
        return null;
    }

    public static function getProductOptions($id){
        $result = array();
        $options = Product::find($id)->options()
                                    ->orderBy('sort_order','ASC')
                                    ->get()
                                    ->toArray();
        if(count($options)){
            foreach ($options as $key => $option) {
                $result[$key] = $option;
                $values = ProductOption::find($option['id'])->values()
                                                        ->orderBy('sort_order','ASC')
                                                        ->get()
                                                        ->toArray();
                if(count($values)){
                    // foreach ($values as $value) {
                    //     $sort_values[] = $value;
                    // }
                    $result[$key]['values'] = $values;
                }
            }
        }
        return $result;
    }

    public static function getProductGallery($id){
        $gallery = Product::find($id)->gallery()
                                    ->where('product_type',Product::PRODUCT_TYPE_DEFAULT)
                                    ->orderBy('sort_order','ASC')
                                    ->get()
                                    ->toArray();
        return $gallery;
    }

    public static function deleteProductOptions($options){
        foreach ($options as $key => $option) {
            /* delete values of option */
            $values = ProductOptionValue::where('option_id',$option->id)->delete();
            /* delete item */
            $deleted = ProductOption::find($option->id)->delete();
        }
        return true;
    }

    public static function deleteProductGallery($gallery){
        foreach ($gallery as $key => $image) {
            /* delete image file */
            Storage::delete($image->value);

            /* delete gallery */
            $img = ProductGallery::find($image->id)->delete();
        }
        return true;
    }

    public static function getCategories($cid=array()){
        $cateList = \App\Modules\Categories\Controllers\CategoriesController::getCateListArray();
        $selectHtml = \App\Modules\Categories\Controllers\CategoriesController::buildSelectParent($cateList,$cid);
        return $selectHtml;
    }

    public static function getProductCategories($id){
        $categories = Product::find($id)->categories()
                                    ->where('product_type',Product::PRODUCT_TYPE_DEFAULT)
                                    ->orderBy('sort_order','ASC')
                                    ->pluck('category_id')
                                    ->toArray();
        return $categories;
    }
    public function ajaxBranded(Request $request){
       $cate = Categories::where('url_key',$request->slug)->first();
       if (!$cate){
           return false;
       }
       $results = ProductBrand::where('cat_id','like','%"'.$cate->id.'"%')->get();
       $html = view('Product::branded.ajax',compact('results'))->render();
       return $html;
    }
    public function settingPrice(Request $request){
        if (count($request->price)>0){
            foreach ($request->price as $group => $val ){
                $check = ProductPrice::where('group',$group)->where('product_id',$request->id)->first();
                $currency = Currencies::find($request->currency);
                if ($check){
                    $check->price = isset($val)?$val:0;
                    if ($currency){
                        $check->currency_id = $request->currency;
                        $check->currency_code = $currency->code;
                    }
                    $check->save();
                }else{
                    if ($currency){
                        ProductPrice::create([
                           'group' => $group,
                            'product_id' => $request->id,
                            'price' => isset($val)?$val:0,
                            'currency_id' => $currency->id,
                            'currency_code' => $currency->code,
                            'checksum' => md5($group.$request->id)
                        ]);
                    }
                }
            }
            return redirect()->back()->with('success','Cập nhập giá thành công');
        }
        return redirect()->back();
    }

    public function options(Request $request, $id){

        $product = Product::find($id);
        if($product){
            $currencies = Currencies::where('fiat', 1)->where('status', 1)->get();
            $groups = Group::where('status', 1)->get();
            $options = ProductOption::orderBy('id', 'DESC')->paginate(5);
            $langs = Language::where('status', 1)->orderBy('default', 'DESC')->get();

            $opvalues = ProductOptionValue::where('product_id', $id)->orderBy('id', 'DESC')->paginate(25);
            foreach ($opvalues as $opvalue){

            }

            return view('Product::options', compact('options', 'product', 'groups', 'currencies', 'langs', 'opvalues'));
        }else{
            return redirect()->back()->withErrors(['error' => 'Sản phẩm không tồn tại']);
        }

    }
    public function postOptionValue(Request $request){

        $this->validate($request, [
           'name' => 'required',
           'sku' => 'required|unique:product_option_value',
           'product_id' => 'required|numeric',
           'option' => 'required',
        ]);
        $lang = cache()->get('language');
        $product = Product::find($request->product_id);
        if($product){

            $option = ProductOption::find($request->option);
            if($option){
                $value = new ProductOptionValue;
                $value->name = $request->name;
                $value->sku = $product->sku.'_'.str_slug($request->sku);
                $value->option_name = $option->name;
                $value->option_id = $request->option;
                $value->product_id = $request->product_id;
                $value->lang = ($request->lang) ? $request->lang : $lang;
                $value->sort_order = $request->sort_order;
                $value->price = $request->price;
                $value->save();

                return redirect()->back()->with('success' , 'Thêm tùy chọn thành công');

            }else{
                return redirect()->back()->withErrors(['error' => 'Tùy chọn không tồn tại']);
            }
        }else{
            return redirect()->back()->withErrors(['error' => 'Sản phẩm không tồn tại']);
        }

    }
    public function deleteOptionValue($id){
        try{
            $optionvalue = ProductOptionValue::destroy($id);
            return redirect()->back()->with('success','Xóa thành công');
        }catch (\Exception $ex){
            return redirect()->back()->withErrors('Xóa thất bại! ');
        }
    }
    public function editOptionValue($product,$id){
        $product = Product::find($product);
        if($product){
            $currencies = Currencies::where('fiat', 1)->where('status', 1)->get();
            $groups = Group::where('status', 1)->get();
            $options = ProductOption::orderBy('id', 'DESC')->paginate(5);
            $langs = Language::where('status', 1)->orderBy('default', 'DESC')->get();
            $opvalues = ProductOptionValue::where('product_id', $product->id)->orderBy('id', 'DESC')->paginate(25);
            $optionitem = ProductOptionValue::find($id);
            return view('Product::options-edit', compact('options', 'product', 'groups', 'currencies', 'langs', 'opvalues','optionitem'));
        }else{
            return redirect()->back()->withErrors(['error' => 'Sản phẩm không tồn tại']);
        }
    }
    public function updateOptionValue(Request $request, $id){
        $this->validate($request, [
            'name' => 'required',
            'product_id' => 'required|numeric',
            'option' => 'required',
        ]);
        $opvalue = ProductOptionValue::find($id);
        $option = ProductOption::find($request->option);
        if ($opvalue && $option){
            $opvalue->name = $request->name;
            $opvalue->option_name = $option->name;
            $opvalue->option_id = $request->option;
            $opvalue->lang = $request->lang;
            $opvalue->sort_order = $request->sort_order;
            $opvalue->price = $request->price;
            $opvalue->save();
            return redirect()->route('backend.product.options',$opvalue->product_id)->with('success','Chỉnh sửa thành công');
        }
        return redirect()->back()->withErrors('Chỉnh sửa thất bại');
    }




}