<?php

namespace App\Modules\Downloads\Controllers;
use App\Modules\Currency\Models\Currencies;
use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Http\Request;
use App\Modules\Downloads\Models\Downloads;
use App\Modules\Downloads\Models\DownloadCat;
use App\Modules\Downloads\Models\DownloadFiles;
use Auth;

class DownloadsController extends BackendController
{


    public function indexDanhMuc(){


        $data=DownloadCat::all();
        return view('Downloads::danhmuc',compact('data'));
    }
    public function index(){
        $data=Downloads::all();
        $data_cat=DownloadCat::all();
        $file=DownloadFiles::all();
        $currencies = Currencies::where('fiat', 1)->where('status',1)->get();
        return view('Downloads::index',compact('data','data_cat','file','currencies'));
    }
    public  function delete($id){
        Downloads::destroy($id);
        return back();
    }
    public function getEditDownload($id){
        $data=Downloads::find($id);
        $cat=DownloadCat::all();
        $files=DownloadFiles::where('download_id',$id)->get();
        $currencies = Currencies::where('fiat', 1)->where('status',1)->get();
        return view('Downloads::editfile',compact('data','cat','files','currencies'));
    }
    public function postEditDownload( Request $request, $id){

        $data=Downloads::find($id);
        $data->name=$request->name;
        $data->slug=str_slug($request->slug);
        $data->description=$request->description;
        $data->short_description=$request->short_description;
        $data->file_extension=$request->file_extension;
        $data->rating=$request->rating;
        $data->views=$request->views;
        $data->download=$request->download;
        $data->cat_id=$request->cat_id;
        $data->discount=$request->discount;
        $data->status=$request->status;
        $data->price=$request->price;
        $data->featured=$request->featured;
        $data->public=$request->public;
        if($request->hasFile('img')){
            $fileimage=$request->img->getClientOriginalName();
            $data->img=$fileimage;
            $request->img->storeAs('public/avatar',$fileimage);
        }
        $data->save();
        if($request->hasFile('filename')) {
            foreach($request->file('filename') as $file) {
                $filenameWithExt = $file->getClientOriginalName();
                $path = $file->storeAs('public/filename', $filenameWithExt);
                $file = new DownloadFiles([
                    'download_id' => $data->id,
                    'filename' => $filenameWithExt,
                    'user_id'=>$id,
                    'file_extension'=>$request->file_extension,
                    'file_description'=>$request->short_description,
                ]);
                $file->save();
                $data->save();
            }
        }

        $data->save();


        return redirect()->route('downnloads.index');
    }
    public function deleteFile($id){

        DownloadFiles::destroy($id);
        return back();
    }


}
