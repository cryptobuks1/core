<?php

namespace App\Modules\Language\Controllers;

use App\Modules\Language\Models\Language;
use App\Modules\Language\Models\Translation;
use Illuminate\Http\Request;
use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use DB;
use File;
use Cache;
use Lang;
use Artisan;

class LanguageController extends BackendController
{
    public function index()
    {

        $title = "Cấu hình ngôn ngữ";
        /// Đã được cài đặt
        $listinstalled = Language::all();

        //// Chưa được cài đặt
        $path = resource_path('lang');
        $listLang = array_map('basename', File::directories($path));

        $list_not_installed = [];
        foreach ($listLang as $value) {
            $checkinstalled = Language::where('code', $value)->first();
            if (!$checkinstalled) {
                $list_not_installed[] = [
                    'name' => 'Ngôn ngữ ' . $value,
                    'code' => $value,
                ];
            }

        }

        return view('Language::index', compact('title', 'list_not_installed', 'listinstalled'));

    }


    public function install($code)
    {
        $path = resource_path('lang');
        $listLang = array_map('basename', File::directories($path));
        if (in_array($code, $listLang)) {
            $lang = Language::where('code', $code)->first();
            if (!$lang) {
                $input = [
                    'name' => 'Ngôn ngữ ' . $code,
                    'code' => $code,
                    'flag' => $code . '.png',
                    'default' => 0,
                    'hreflang' => null,
                    'charset' => null,
                    'status' => 0,
                    'sort' => 0,
                    'installed' => 1
                ];
                $result = DB::table('languages')->insert($input);
                if ($result) {

                    return redirect()->route('backend.language.setting')->with('success', 'Cài đặt ngôn ngữ thành công. Bạn cần sửa lại thông tin kết nối!');

                } else {
                    return 'Error insert data';
                }
            } else {
                return $code . ' đã được cài đặt';
            }
        } else {
            return 'Cài đặt thất bại. Ngôn ngữ không tồn tại trong hệ thống';
        }
    }

    public function uninstall($code)
    {
        $lang = Language::where('code', $code)->first();

        if ($lang) {
            $lang->delete();
            return redirect()->back()->with('success', 'Xóa thành công ngôn ngữ ' . $code);
        } else {
            return redirect()->back()->withErrors(['error' => 'Xóa thất bại']);
        }
    }

    public function updatelang($id)
    {
        $title = "Cấu hình ngôn ngữ";
        $lang = Language::find($id);
        if ($lang) {
            return view('Language::update', compact('title', 'lang'));
        } else {
            return redirect()->back()->withErrors(['error' => 'Không tồn tại ngôn ngữ này']);
        }
    }


    public function postupdatelang(Request $request)
    {
        $id = $request->id;
        $lang = Language::find($id);
        if ($lang) {
            $input = $request->all();

            if ($request->default) {
                $input['default'] = 1;
            } else {
                $input['default'] = 0;
            }

            if ($request->status) {
                $input['status'] = 1;
            } else {
                $input['status'] = 0;
            }
            $input['update'] = now();

            $lang->update($input);
            return redirect()->route('backend.language.setting')->with('success', 'Cập nhật ngôn ngữ thành công');
        } else {
            return redirect()->back()->withErrors(['error' => 'Không cập nhật được ngôn ngữ này']);
        }
    }

    ///List các file lang ra
    public function langFile($lang_code)
    {

        $lang = Language::where('code', $lang_code)->first();
        if(!$lang){
            return redirect()->back()->withErrors(['error' => 'Không tồn tại ngôn ngữ này']);
        }
        $title = 'Biên dịch tệp tin '.$lang->name;
        $files = null;

        $file_infos = File::allFiles(resource_path('lang/') . $lang_code);
        foreach ($file_infos as $key => $file_info) {
            $files[$key]['basename'] = pathinfo($file_info)['basename'];
            $files[$key]['code'] = $lang_code;
            $files[$key]['filename'] = $lang_code.'_'.pathinfo($file_info)['filename'];
        }
        $code = $lang_code;
        return view('Language::langfile', compact('title', 'files', 'code'));
    }

    public function translate(Request $request){
        $filename = $request->filename;
        if(!isset($filename)){
            return redirect()->back()->withErrors(['error' => 'Không tồn tại tệp tin này']);
        }
        $file = explode("_", $filename);

        $trans = Translation::where('filename', $file[1])->where('lang_code',$file[0])->get();
        $lang = Language::where('code', $file[0])->first();
        if(!$lang){
            return redirect()->back()->withErrors(['error' => 'Không tồn tại ngôn ngữ này']);
        }
        $title = 'Biên dịch '. $file[1].' ('.$lang->name.')';
        $code = $file[0];
        return view('Language::translate', compact('title', 'trans', 'code'));
    }

    public function importlang($code){

        $file_infos = File::allFiles(resource_path('lang/') . $code);
        foreach ($file_infos as $key => $file_info) {
            $file = pathinfo($file_info)['filename'];

            $translations = Lang::get($file, [],$code, false);

            if(is_array($translations) && count($translations) > 0){
                foreach ($translations as $key => $translation){

                    $check = Translation::where('key', $code.'_'.$file.'_'.$key)->first();

                    if(is_array($translation)){
                        $content = json_encode($translation);
                        $type = 'array';
                    }else{
                        $content = $translation;
                        $type = 'string';
                    }
                    if($check){
                        continue;
                    }else{
                        $trans = new Translation;
                        $trans->lang_code = $code;
                        $trans->lang_key = $file.'.'.$key;
                        $trans->key = $code.'_'.$file.'_'.$key;
                        $trans->filename = $file;
                        $trans->content = $content;
                        $trans->type = $type;
                        $trans->save();
                        unset($tran);
                    }
                }

            }

        }

        Cache::forget('langcache_'.$code);

        return redirect()->back()->with('success', 'Cập nhật ngôn ngữ vào CSDL thành công');

    }


    public function resetlang($code){

        $file_infos = File::allFiles(resource_path('lang/') . $code);
        foreach ($file_infos as $key => $file_info) {
            $file = pathinfo($file_info)['filename'];

            $translations = Lang::get($file, [],$code, false);

            if(is_array($translations) && count($translations) > 0){
                foreach ($translations as $key => $translation){

                    $check = Translation::where('key', $code.'_'.$file.'_'.$key)->first();

                    if(is_array($translation)){
                        $content = json_encode($translation);
                        $type = 'array';
                    }else{
                        $content = $translation;
                        $type = 'string';
                    }
                    if($check){
                        $check->content = $content;
                        $check->update();
                    }else{
                        $trans = new Translation;
                        $trans->lang_code = $code;
                        $trans->lang_key = $file.'.'.$key;
                        $trans->key = $code.'_'.$file.'_'.$key;
                        $trans->filename = $file;
                        $trans->content = $content;
                        $trans->type = $type;
                        $trans->save();
                        unset($tran);
                    }
                }

            }

        }

        $lang = \App\Modules\Language\Models\Translation::where('lang_code', $code)->pluck('content','lang_key');
        Cache::forever('langcache_'.$code, $lang);

        return redirect()->back()->with('success', 'Ghi đè ngôn ngữ từ tệp tin vào CSDL thành công');

    }

    public function cachelang($code){

        $lang = \App\Modules\Language\Models\Translation::where('lang_code', $code)->pluck('content','lang_key');
        Cache::forget('langcache_'.$code);
        Cache::forever('langcache_'.$code, $lang);
        Artisan::call('view:clear');
        return redirect()->back()->with('success', 'Xuất bản thành công thành công');

    }


    public function updatetranslate(Request $request){

        if(isset($request->id)){
            $tran = Translation::find($request->id);
            if($tran){
                $tran->content = $request->contentt;
                $tran->update();
            }
        }
    }


}