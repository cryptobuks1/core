<?php

namespace App\Modules\Downloads\Controllers;
use App\Modules\Currency\Models\Currencies;
use App\Modules\Frontend\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Modules\Downloads\Models\Downloads;
use App\Modules\Downloads\Models\DownloadCat;
use App\Modules\Downloads\Models\DownloadFiles;
use App\Modules\Downloads\Requests\DownloadRequest;
use App\Modules\Downloads\Models\FileUpload;
use Auth;

class DownloadsFrontController extends FrontendController
{

    public function getCreateData(){
        $data_cat = DownloadCat::all();
        $currencies = Currencies::where('fiat', 1)->where('status',1)->get();
        return theme_view('downloads.create_data',compact('data_cat', 'currencies'));

    }
    public function postCreateData(Request $request){
        $user_id = Auth::user()->id;
        $fileavatar=$request->img->getClientOriginalName();
        $data = new Downloads;
        $data->name=$request->name;
        $data->user_id=$user_id;
        $data->slug=str_slug($request->name);
        $data->description=$request->description;
        $data->short_description=$request->short_description;
        $data->file_extension=$request->file_extension;
        $data->img= $fileavatar;
        $data->cat_id=$request->cat_id;
        $data->price=$request->price;
        $data->discount=$request->discount;
        $data->public=$request->public;
        $data->save();
        if($request->hasFile('filename')) {
            foreach($request->file('filename') as $file) {
                $filenameWithExt = $file->getClientOriginalName();
                $path = $file->storeAs('public/filename', $filenameWithExt);
                $file = new DownloadFiles([
                    'download_id' => $data->id,
                    'filename' => $filenameWithExt,
                    'user_id'=>$user_id,
                    'public'=>$request->public,
                    'file_extension'=>$request->file_extension,
                    'file_description'=>$request->short_description,
                ]);
                $file->save();
                $data->filename = $file['filename'];
                $data->save();
            }
        }
        $request->img->storeAs('public/avatar',$fileavatar);
        return redirect()->route('downloads')->with('success', 'Thêm thành công.');
    }
    public function  getCreateDataCat(){
        return theme_view('downloads.create_data_cat');
    }
    public function postCreateDataCat(Request $request){
        $data= new DownloadCat;
        $data->name = $request->name;
        $data->slug=str_slug($request->name);
        $data->status=$request->status;
        $data->description=$request->description;
        $data->featured=$request->featured;
        $data->save();
        return back();
    }
    public function downloadCat(){

        $data=DownloadCat::all();
        return theme_view('downloads.downloadcat',compact('data'));
    }
    public function downloads(){
        $data=Downloads::all();
        $data_cat=DownloadCat::all();
        $file=DownloadFiles::all();
        $currencies = Currencies::where('fiat', 1)->where('status',1)->get();
        return theme_view('downloads.downloads',compact('data','data_cat','file','currencies'));
    }
    public function delete($id){
        Downloads::destroy($id);
        return back()->with('success','Xóa thành công');
    }
    public function edit($id){
        $data=Downloads::find($id);
        $cat=DownloadCat::all();
        $files=DownloadFiles::where('download_id',$id)->get();
        $currencies = Currencies::where('fiat', 1)->where('status',1)->get();

        return theme_view('downloads.edit',compact('data','cat','files','currencies'));
    }
    public function postEdit(Request $request,$id){
        $data=Downloads::find($id);
        $data->name=$request->name;
        $data->slug=str_slug($request->slug);
        $data->description=$request->description;
        $data->short_description=$request->short_description;
        $data->file_extension=$request->file_extension;
        $data->cat_id=$request->cat_id;
        $data->discount=$request->discount;
        $data->public=$request->public;
        $data->price=$request->price;
        if($request->hasFile('img')){
            $fileimage=$request->img->getClientOriginalName();
            $data->img=$fileimage;
            $request->img->storeAs('public/avatar',$fileimage);
        }
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


        return redirect()->route('downloads');
    }
    public function destroyFile($id){

        DownloadFiles::destroy($id);
        return back();
    }

    public function product()
    {
        $data=Downloads::orderBy('id','desc')->paginate(6);
        $items=Downloads::where('featured',1)->orderBy('id','desc')->paginate(6);
        $currencies = Currencies::where('fiat', 1)->where('status',1)->get();
        return theme_view('downloads.product',compact('data','items','currencies'));
    }
    public function detail($id)
    {
        $data=Downloads::find($id);
        $cat=DownloadCat::all();
        $files=DownloadFiles::where('download_id',$id)->get();
        $currencies = Currencies::where('fiat', 1)->where('status',1)->get();
        return theme_view('downloads.detail',compact('data','cat','currencies','files'));
    }
}
