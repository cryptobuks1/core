<?php

namespace App\Modules\Sendmail\Controllers;

use App\Modules\Sendmail\Models\Sendmaildriver;
use App\User;
use Illuminate\Http\Request;

use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use DB;
use Config;
use File;
use App\Modules\Sendmail\Models\Sendmail;
use Mail;
use App\Modules\Sendmail\Drivers\Smtp;

class SendmailController extends BackendController
{

    public function index(){

        return 'Chuc nang dang duoc phat trien';
    }


    ////Hàm này dùng để gửi mail thông báo từ hệ thống cho khách hàng
    public function sendmail($subject,$content,$to)
    {

        $settings = Sendmail::first();

        $from_email = $settings->from_email;
        $from_name = $settings->from_name;

        $client = User::where('email', $to)->first();
        if($client){
            $name = $client->name;
        }else{
            $name = 'Khách hàng';
        }

        $logoconfig = DB::table('settings')->where('key', 'logo')->first();
        $logo = url('/').$logoconfig->value;

        $data = [
            'subject' => $subject,
            'content' => $content,
            'from_email' => $from_email,
            'from_name' => $from_name,
            'to' => $to,
            'logo' =>$logo
        ];

        Mail::send('Sendmail::emailtemplate', ['subject' => $subject, 'content' => $content, 'data' => $data, 'name' => $name, 'logo' => $logo], function ($message) use ($data)
        {

            $message->from($data['from_email'], $data['from_name']);
            $message->to($data['to']);
            $message->subject($data['subject']);

        });

        return response()->json(['success' => 'Email đã được gửi thành công!']);
    }

    public function setting()
    {
        $title ='Cấu hình Mail';
        $mailset = DB::table('sendmail_setting')->first();
        $driver = DB::table('sendmail_driver')->where('status', 1)->select('driver', 'name')->get();

        /// Mail đã được cài đặt
        $listinstalled = Sendmaildriver::all();

        //// Kho chưa được cài đặt
        $path = app_path('Modules//Sendmail//Drivers');
        $listDriver = array_map('basename', File::directories($path) );


        $list_not_installed = [];
        foreach ($listDriver as $value){
            $checkinstalled = Sendmaildriver::where('driver', $value)->first();

            if(file_exists($path.'/'.$value.'/'.$value.'.php') && !$checkinstalled) {

                $list_not_installed[] = [
                    'name' => 'Gửi mail bằng '.$value,
                    'driver' => $value,
                ];
            }

        }


        return view('Sendmail::setting', compact('title', 'mailset', 'driver', 'listinstalled', 'list_not_installed'));
    }

    public function postsetting(Request $request){

        $mailset = Sendmail::first();
        $mailset->from_email = $request->input('from_email');
        $mailset->from_name = $request->input('from_name');
        $mailset->driver = $request->input('driver');
        $mailset->save();

        return redirect()->route('sendmail-setting')
            ->with('success','Cập nhật cấu hình thành công');
    }



    public function install($name) {
        $path = app_path('Modules//Sendmail//Drivers');
        $listDriver = array_map('basename', File::directories($path) );

        if(in_array($name, $listDriver)){

            $driver = Sendmaildriver::where('driver', $name)->first();

            if(!$driver) {

                $ns = '\App\Modules\Sendmail\Drivers\\'. $name.'\\'.$name;
                $configp = new $ns;

                $input = [
                    'name' =>'Gửi mail bằng '.$name,
                    'driver' => $name,
                    'configs' => json_encode($configp->config),
                    'status' => 0,
                    'installed' => 1
                ];

                $result = DB::table('sendmail_driver')->insert($input);

                if($result){

                    return redirect()->route('sendmail-setting')->with('success', 'Cài đặt thành công. Bạn cần sửa lại thông tin kết nối!');

                }else {
                    return 'Error insert data';
                }

            }else {

                return $name.' đã được cài đặt';
            }

        }else {

            return 'Cài đặt thất bại. Driver không tồn tại trong hệ thống';

        }


    }

    public function updatedriver($id){
        $title = 'Cập nhật cấu hình mail';
        $driver = Sendmaildriver::find($id);
        if($driver){
            $configitem = json_decode($driver->configs);


            return view('Sendmail::updatedriver', compact('title', 'driver','configitem'));
        } else {

            return 'Không tìm thấy cấu hình của kho thẻ này';
        }

    }

    public function postupdatedriver(Request $request, $id){

        $conf = $request->all();
        $update['name'] = $conf['name'];
        $update['driver'] = $conf['driver'];
        if(isset($conf['configs'])) {

            $update['configs'] = json_encode($conf['configs']);
        }


        if(isset($conf['status']))
        {
            $update['status'] = 1;
        }else{
            $update['status'] = 0;
        }

        DB::table('sendmail_driver')->where('id', $id)->update($update);
        return redirect()->route('sendmail-setting')
            ->with('success','Cập nhật cấu hình '.$conf['driver'].' thành công');


    }



}
