<?php
namespace App\Modules\Page\Controllers;

use App\Modules\Frontend\Controllers\FrontendController;
use Illuminate\Http\Request;
use Session;
use App;

use App\Modules\Page\Models\Page;

class PageFrontController extends FrontendController{

    public function __construct(){
        parent::__construct();
	}


	public function viewpage(Request $request){

        $slug = $request->s_slug;
        if(isset($slug)){

            $page = Page::where('slug', $slug)->first();

            if($page){
                return theme_view('pages.page',compact('page'));
            }else{
                return redirect()->route('home')->withErrors(['error' => 'Không tìm thấy trang này!']);
            }

        }else{
            return redirect()->route('home');
        }

    }
}