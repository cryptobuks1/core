<?php

namespace App\Modules\Sms\Controllers;

use App\Modules\Sms\Models\Sms;
use App\Modules\Sms\Models\SmsProvider;
use Illuminate\Http\Request;
use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use DB;
use File;
use Carbon\Carbon;


class SmsController extends BackendController
{

    public function index(Request $request)
    {
        $title = "Quản lý tin nhắn";
        $smss = Sms::orderBy('id', 'DESC')->paginate(25);

        if($request->phone){

            $smss = Sms::where('phone', $request->phone)->orderBy('id', 'DESC')->paginate(25);
        }

        return view("Sms::index", compact('title', 'smss'));
    }


    ///$dial_country có thể = NULL
    /// Số điện thoại phải bắt đầu bằng số 0
    /// $module là tên module hoặc id của order, trans
    /// $type = Otp hoặc Odp
    public function sendSms($dial_country = null, $phone, $secret , $content, $provider, $type, $modulename, $model_id, $user_id = null){

        $sms = new Sms;
        $sms->phone = $phone;
        $sms->text =  $content;
        $sms->secret =  $secret;
        $sms->modulename =  $modulename;
        $sms->model_id =  $model_id;
        $sms->type =  $type;
        if($type == 'Odp'){
              /// Tính đến hết ngày
            $sms->expired_at = Carbon::tomorrow();

            /// Tính trong vòng 24h
           // $sms->expired_at = date('Y-m-d H:i:s', time() + 24 * 60 * 60);
        }


        $sms->user_id = $user_id;
        $sms->save();

        $path = app_path('Modules//Sms//Providers');
        if( ! file_exists($path.'/'.$provider.'/'.$provider.'.php')) {
            return false;
        }else{
            $classPath = '\App\Modules\Sms\Providers\\'.$provider.'\\'.$provider;
            $SmsService = new $classPath;

            $response = $SmsService->send($dial_country, $phone, $content);

            /// Ghi log
            $sms->log = json_encode($response);
            $sms->update();

            return $response;
        }

    }

    public function destroy($id)
    {
        if (auth()->user()->hasRole('SUPER_ADMIN|BACKEND')) {
            Sms::find($id)->delete();
            return redirect()->back()
                ->with('success', 'Sms deleted successfully');
        } else {
            return redirect()->back()
                ->withErrors(['message' => 'Not access.']);
        }
    }


    public function provider()
    {

        $title = "Cấu hình phương thức gửi SMS";

        $listinstalled = SmsProvider::all();

        //// SMS chưa được cài đặt
        $path = app_path('Modules//Sms//Providers');
        $listProvider = array_map('basename', File::directories($path));
        $list_not_installed = [];
        foreach ($listProvider as $value) {
            $checkinstalled = SmsProvider::where('provider', $value)->first();

            if (file_exists($path . '/' . $value . '/' . $value . '.php') && !$checkinstalled) {

                $list_not_installed[] = [
                    'name' => 'Nhà cung cấp ' . $value,
                    'provider' => $value,
                ];
            }

        }

        return view('Sms::setting', compact('title', 'list_not_installed', 'listinstalled'));

    }


    public function install($name)
    {
        $path = app_path('Modules//Sms//Providers');
        $listProvider = array_map('basename', File::directories($path));

        if (in_array($name, $listProvider)) {

            $provider = SmsProvider::where('provider', $name)->first();

            if (!$provider) {

                $ns = '\App\Modules\Sms\Providers\\' . $name . '\\' . $name;


                $configp = new $ns;

                $input = [
                    'name' => 'Nhà cung cấp ' . $name,
                    'provider' => $name,
                    'brandname' => NULL,
                    'configs' => json_encode($configp->config),
                    'balance' => NULL,
                    'status' => 0,
                    'installed' => 1
                ];


                $result = DB::table('sms_provider')->insert($input);
                if ($result) {

                    return redirect()->route('backend.sms.provider')->with('success', 'Cài đặt sms thành công. Bạn cần sửa lại thông tin kết nối!');

                } else {
                    return 'Error insert data';
                }

            } else {

                return $name . ' đã được cài đặt';
            }

        } else {

            return 'Cài đặt thất bại. Mã nhà cung cấp không tồn tại trong hệ thống';

        }


    }

    public function updatesetting($id)
    {
        $title = 'Cập nhật cấu hình SMS';
        $sms_provider = SmsProvider::find($id);
        if ($sms_provider) {
            $configitem = json_decode($sms_provider->configs);


            return view('Sms::updatesettings', compact('title', 'sms_provider', 'configitem'));
        } else {

            return 'Không tìm thấy cấu hình của sms này';
        }

    }

    public function postupdatesetting(Request $request, $id)
    {

        $conf = $request->all();
        $update['name'] = $conf['name'];
        $update['provider'] = $conf['provider'];
        $update['brandname'] = $conf['brandname'];
        if (isset($conf['configs'])) {

            $update['configs'] = json_encode($conf['configs']);
        }


        if (isset($conf['status'])) {
            $update['status'] = 1;
        } else {
            $update['status'] = 0;
        }

        DB::table('sms_provider')->where('id', $id)->update($update);
        return redirect()->route('backend.sms.provider')
            ->with('success', 'Cập nhật cấu hình ' . $conf['provider'] . ' thành công');


    }

    public function action(Request $request)
    {

        if (!isset($request->check)) {
            return redirect()->back()->withErrors(['error' => 'Bạn chưa chọn đối tượng để thực hiện!']);
        }

        if (isset($request->action) && $request->action == 'delete') {


            if (auth()->user()->hasRole('SUPER_ADMIN')) {

                // Thực hiện xóa đồng loạt

                $ids = $request->check;
                try {
                    Sms::destroy($ids);

                    return redirect()->back()->with('success', 'Bạn đã xóa thành công các đối tượng đã chọn!');
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors(['error' => $e->getMessage()]);
                }

            } else {
                return redirect()->route('stockcards')
                    ->withErrors(['message' => 'Not access.']);
            }


        } else {
            return redirect()->back();
        }
    }


}
