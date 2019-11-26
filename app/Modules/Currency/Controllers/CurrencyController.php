<?php
namespace App\Modules\Currency\Controllers;

use Illuminate\Http\Request;
use App\Modules\Backend\Controllers\BackendController;
use Illuminate\Database\Eloquent\Model;
use View;
use App\Modules\Currency\Models\Currencies;
use DB;
class CurrencyController extends BackendController
{

    public function __construct()
    {
        parent::__construct();
        $title = 'Currencies Management';
        View::share ('title', $title );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $currencies =Currencies::orderBy('id','DESC')->paginate(10);
        if($request->input('keyword'))
        {
            $keyword = $request->input('keyword');
            $title  = "Search: ".$keyword;
            $currencies = Currencies::where('name', 'LIKE', '%'.$keyword.'%')->orderBy('id','DESC')->paginate(10);
        }
        return view('Currency::index', compact('currencies'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
            $currencyList = DB::table('currencies_code')->get();
            foreach($currencyList as $icurrency)
            {
                $lsCurrency[$icurrency->code]  = $icurrency->code.' - '.$icurrency->name;
            }
            return view('Currency::create', compact('lsCurrency'));
        }else{
            echo 'Not Access';
            return ;
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'decimal' => 'required|numeric',
            'value' => 'required|numeric',
            'seperator' => 'required',
            'sort' => 'required',
        ]);

        $input = $request->all();
        ( isset($input['fiat']) ) ? $input['fiat'] = 1 : $input['fiat'] = 0;
        ///Chống trùng fiat
        if($input['fiat'] == 1){
            $input['checksum'] = md5($input['code'].$input['fiat']);
        }else{
            $input['checksum'] = null;
        }

        ( isset($input['homepage']) ) ? $input['homepage'] = 1 : $input['homepage'] = 0;
        ( isset($input['default']) ) ? $input['default'] = 1 : $input['default'] = 0;
        ( isset($input['status']) ) ? $input['status'] = 1 : $input['status'] = 0;

        try{
            Currencies::create($input);
            return redirect()->route('currencies.index')
                ->with('success','Thêm loại tiền tệ thành công!');
        }catch (\Exception $e){
            return redirect()->back()
                ->withErrors(['error' => 'Lỗi có thể là do FIAT của loại tiền tệ này đã có, hãy tắt FIAT rồi lưu lại!']);
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
            $currency = Currencies::find($id);
            $currencyList = DB::table('currencies_code')->get();
            foreach($currencyList as $icurrency)
            {
                $lsCurrency[$icurrency->code]  = $icurrency->code.' - '.$icurrency->name;
            }
            return view('Currency::edit', compact('currency','lsCurrency'));
        }else{
            echo 'Not Access';
            return ;
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'decimal' => 'required|numeric',
            'value' => 'required|numeric',
            'seperator' => 'required',
            'sort' => 'required',
        ]);

        $input = $request->all();

        ( isset($input['fiat']) ) ? $input['fiat'] = 1 : $input['fiat'] = 0;
        ///Chống trùng fiat
        if($input['fiat'] == 1){
            $input['checksum'] = md5($input['code'].$input['fiat']);
        }else{
            $input['checksum'] = null;
        }

        ( isset($input['homepage']) ) ? $input['homepage'] = 1 : $input['homepage'] = 0;
        ( isset($input['default']) ) ? $input['default'] = 1 : $input['default'] = 0;
        ( isset($input['status']) ) ? $input['status'] = 1 : $input['status'] = 0;

        $currency = Currencies::findOrFail($id);
        $currency->fill($input)->save();

        return redirect()->route('currencies.index')
                        ->with('success','Currency created successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if( auth()->user()->hasRole('SUPER_ADMIN|ADMIN') )
        {
            Currencies::find($id)->delete();
            return redirect()->route('currencies.index')
                        ->with('success','Currencies deleted successfully');
        }else{
            return redirect()->route('currencies.index')
                        ->withErrors(['message' =>'Not access.']);
        }
    }

    public function actions(Request $request)
    {
        $val    = $request->check;
        $action = $request->action;
        if(empty($val)){
            return redirect()->route('currencies.index')->withErrors(['message' =>'Không có mục nào được chọn.']);
        }

        foreach ($val as $value) {
            $user = Currencies::find($value);
            $this->_runAction($value, $action);
        }
        return redirect()->route('currencies.index')->with('success','GroupProject  '.$action.' successfully');
    }

    private function _runAction($id, $action)
    {
        switch ($action) {
            case 'delete':
                $this->destroy($id);
                break;

            default:
                break;
        }
        return null;
    }

}
