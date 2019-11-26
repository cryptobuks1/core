<?php
namespace App\Modules\Block\Controllers;

use Illuminate\Http\Request;
use App\Modules\Frontend\Controllers\FrontendController;
use App\Modules\Block\Models\Block;
use App\Modules\Block\Models\BlockContent;
use DB;
use Auth;

class BlockFrontController extends FrontendController
{

    public function index(){
        $blocks = $this->showByKey('cusfeedback');
        dd($blocks);

    }

    ///Show block theo vị trí
    public function showByPosition($position){

        $current_lang = cache()->get('language');
        $blocks = Block::where('position', $position)->where('status', 1)->where('lang', $current_lang)->get();

        $content = null;
        if(count($blocks) > 0){
            foreach ($blocks as $block){
                $content = BlockContent::where('block', $block->id)->where('status', 1)->where('lang', $current_lang)->get();
                $block->content = $content;
            }
        }

        return $blocks;
    }

    ///Show block theo key
    public function showByKey($key){

        $current_lang = cache()->get('language');
        $block = Block::where('key', $key)->where('status', 1)->where('lang', $current_lang)->first();

        if($block){
            $content = BlockContent::where('block', $block->id)->where('status', 1)->where('lang', $current_lang)->get();
            $block->content = $content;
        }

        return $block;
    }
}