<?php

namespace App\Modules\Block\Widgets;


class Html
{
    public function showform($bname, $bcontent){

        $name = $bname;
        if(!$bcontent){
            $data = null;
        }else{
            $data = $bcontent;
        }

        $content = view('Block::widget.Html', compact('name', 'data'))->render();

        return $content;
    }
}