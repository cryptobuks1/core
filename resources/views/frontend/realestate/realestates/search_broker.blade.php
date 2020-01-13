<div class="col-md-12" style="padding-bottom: 10px">
    <div class="search">
        <h2>Tìm Kiếm</h2>
        <div class="row">
            <div class="col-md-12">
                <form action="" name="formSearch" method="GET" >
                    <div style="display: flex;" class="form-group">
                        <input type="text" name="keyword" class="form-control " placeholder="Search" style="margin-right: 10px; transform: translateY(3px)" value="@if(app("request")->input("keyword")){{ trim(app("request")->input("keyword"))}}@endif">
                        <button type="submit" class="btn btn-primary" ><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="col-md-12">
                <form action="" name="formSearch" method="GET" >
                    <div class="row">
                        <div class="col-md-2 col-xs-6">
                            <div class="form-group">
                                <select name="form" id="form" class="form-control">
                                    <option value="" @if(app("request")->input("form")=='') selected="selected" @endif>Chọn giao dịch</option>
                                    <option value="1" @if(app("request")->input("form")==1) selected="selected" @endif>Nhà đất bán</option>
                                    <option value="2" @if(app("request")->input("form")==2) selected="selected" @endif>Nhà đất thuê</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <div class="form-group">
                                <select name="type" id="type" class="form-control">
                                    <option value="" @if(app("request")->input("type")=='') selected="selected" @endif>--Chọn loại nhà đất--</option>
                                    @if(app("request")->input("type"))
                                        @foreach($types2 as $type)
                                            <option value="{{$type->id}}" @if(app("request")->input("type")==$type->id) selected="selected" @endif>{{$type->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <div class="form-group">
                                <select name="city" class="form-control" id="cities" style="height: 40px">
                                    <option value="" @if(app("request")->input("city")=='') selected="selected" @endif>-- Chọn tỉnh/thành --</option>
                                    @foreach($citys as $c_item)
                                        <option value="{{$c_item->code}}" @if(app("request")->input("city")==$c_item->code) selected="selected" @endif>{{$c_item->name_city}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <div class="form-group">
                                <select class="form-control" name="province" id="provinces" style="height: 40px;">
                                    <option value="" @if(app("request")->input("province")=='') selected="selected" @endif>-- Chọn quận/huyện --</option>
                                    @if(app("request")->input("city"))
                                        @foreach($pros as $p_item)
                                            <option value="{{$p_item->name}}" @if(app("request")->input("city")==$p_item->city_code && app("request")->input("province")==$p_item->name) selected="selected" @endif>{{$p_item->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1 col-xs-12" style="text-align: center">
                            <button type="submit" class="btn btn-primary" style="transform: translateX(-15px); height: 37px">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
