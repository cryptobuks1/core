<?php

namespace App\Console\Commands;

use App\Modules\Order\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdatVietcombank extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:vietcombank';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cap nhat trang thai giao dich qua vietcombank';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        //Tự động Hủy các đơn hàng có thời gian đợi lớn hơn 15 phút
        $formatted = Carbon::now()->subMinute(15)->toDateTimeString();
        $orders = Order::where('created_at', '<', $formatted)->where('paygate_code', 'Vietcombank')->whereIn('payment', ['unpaid','none'])->get();

        if(count($orders) > 0){
            foreach ($orders as $order){
                $order->payment = 'canceled';
                $order->status = 'canceled';
                $order->update();
            }
        }

        ///Kiểm tra và cập nhật đơn hàng
        $status = \App\Modules\Paygate\Gateways\Vietcombank\Vietcombank::checkTransaction();

        if($status == 1){
            $this->info('Cap nhat don hang thanh cong');
        }
    }
}
