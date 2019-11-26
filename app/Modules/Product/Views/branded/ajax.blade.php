@if($results)
    @foreach($results as $key => $val)
        <option value="{{$val->id}}">{{$val->name}}</option>
        @endforeach
    @endif