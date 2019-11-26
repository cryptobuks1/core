<div class="col-md-3">
    <div class="row">
        <div class="col-md-12">
            <ul id="menu">
                <li id="menu-item" ><a href="{{ asset('realestates/du-an/') }}" style="font-size: 25px; color: #00c0ef; font-weight: 600">DỰ ÁN</a></li>
                @foreach($group as $g_item)
                <li id="menu-item"><a href="{{ asset('realestates/du-an/group/'.$g_item->slug.'/'.$g_item->id) }}">{{$g_item->name}}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-12">
            <label for="">TÌM DỰ ÁN</label>
            <div class="card-header" style="border-bottom: 0">
                <div class="card-tools " style="float: left;position: relative;right: 0px;left: 0px;">
                    <div class="input-group input-group-sm dataTables_filter" style="">
                        <form action="" name="formSearch" method="GET" >
                            <div class="input-group">
                                <select name="city" class="form-control" id="cities" style="height: 40px">
                                    <option value="">-- Chọn tỉnh/thành phố --</option>
                                    @foreach($city as $c_item)
                                    <option value="{{$c_item->code}}" @if(app("request")->input("city")==$c_item->code) selected="selected" @endif>{{$c_item->name_city}}</option>
                                    @endforeach
                                </select>
                                <select class="form-control" name="province" id="provinces" style="height: 40px;">
                                    <option value="">-- Chọn quận/huyện --</option>
                                    @if(app("request")->input("city"))
                                    @foreach($pro as $p_item)
                                    <option value="{{$p_item->name}}" @if(app("request")->input("city")==$p_item->city_code && app("request")->input("province")==$p_item->name) selected="selected" @endif>{{$p_item->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <input type="text" class="form-control" placeholder="Nhập tên dự án" name="name" value="@if(app("request")->input("name")){{ trim(app("request")->input("name"))}}  @endif" style="height: 40px">
                                <div class="input-group-append">
                                    <button type="submit" name="submit" value="filter" class="btn btn-warning"><i class="fa fa-search"></i>Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
