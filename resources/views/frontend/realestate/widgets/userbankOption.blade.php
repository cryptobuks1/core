<select id="#paymentlist" name="bankinfo_id" class="form-control" style="padding: 0px">
    @foreach($listuserbank as $userbank)
        <option value="{{$userbank->id}}">{!! $userbank->name. ' ' .$userbank->branch.' / STK: '.$userbank->acc_num.', CTK: '.$userbank->acc_name !!}</option>
    @endforeach
</select>