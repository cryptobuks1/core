<?php

namespace App\Modules\Product\Controllers;

use App\Modules\Categories\Models\Categories;
use App\Modules\Product\Models\ProductBrand;
use Illuminate\Http\Request;
use App\Modules\Backend\Controllers\BackendController;
use Auth;
use View;
use DB;
use Storage;

class BrandController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $title = 'Quản lý sản phẩm';
        View::share ('title', $title );
    }

   public function index(Request $request){
        $cats = Categories::where('status',1)->get();
        $items = ProductBrand::orderBy('id','DESC')->paginate(20);
        $Categories = new Categories();
        if (isset($request->id)){
            $item = ProductBrand::find($request->id);
            if (!$item){
                return redirect()->back();
            }
            $formContent = view("Product::branded.edit", compact('cats','item'))->render();
        }else{
            $formContent = view("Product::branded.create", compact('cats'))->render();
        }
        return view('Product::branded.index',compact('cats','items','formContent','Categories'));
   }
   public function create(){

   }
   public function store(Request $request){
        $input = $request->all();
        if ($request->image){
            $imagelink = explode('storage',$request->image);
            $input['image'] = '/storage'.$imagelink[1];
        }
        $input['status'] = isset($request->status)?1:0;
       ProductBrand::create($input);
        return redirect()->route('product-branded.index')->with('success','Thêm mới thành công');
   }
   public function edit($id){

   }
   public function update(Request $request, $id){
        $item = ProductBrand::find($id);
        if (!$item){
            return redirect()->back();
        }
        $item->name = $request->name;
        $item->slug = $request->slug;
        $item->description = $request->description;
        $item->status = isset($request->status)?1:0;
        $item->cat_id = $request->cat_id;
        if ($request->image){
            $imagelink = explode('storage',$request->image);
            $item->image = '/storage'.$imagelink[1];
        }
        $item->save();
       return redirect()->route('product-branded.index')->with('success','Chỉnh sửa thành công');
   }
   public function destroy($id){
       ProductBrand::destroy($id);
    return redirect()->back()->with('success','Xóa thành công');
   }
}