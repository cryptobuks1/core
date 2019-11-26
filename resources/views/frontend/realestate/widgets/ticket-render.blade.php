<h1><span class="text-uppercase">{{ $title }}</span></h1>

{!! Form::open(array('route' => 'frontend.post.send.request','method'=>'POST','enctype'=>'multipart/form-data')) !!}
<div class="controls">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="form_title">Tiêu đề</label>
                <input id="form_title" name="title" class="form-control" placeholder="Tiêu đề">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="form_name">Họ và tên *</label>
                <input id="form_name" type="text" name="name" class="form-control" placeholder="Nhập họ và tên"
                       required="required" @if(auth()->check()) value="{{auth()->user()->name}}" @endif>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="form_phone">Số điện thoại *</label>
                <input type="tel" name="phone" class="form-control" placeholder="Nhập số điện thoại"
                       required="required" @if(auth()->check()) value="{{auth()->user()->phone}}" @endif>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="form_email">Email</label>
                <input id="form_email" type="email" name="email" class="form-control" placeholder="Nhập địa chỉ email" @if(auth()->check()) value="{{auth()->user()->email}}" @endif>
            </div>
        </div>

        @if(count($other_infos) > 0)
            @foreach($other_infos as $other_info)
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="form_{{$other_info->key}}">{{$other_info->title}}</label>

                        @if($other_info->type == 'input')
                            <input type="text" name="other_info[{{$other_info->key}}]" class="form-control"
                                   placeholder="{{$other_info->placeholder}}"
                                   @if($other_info->required == 1) required="required" @endif>
                        @elseif($other_info->type == 'select')
                            <select class="form-control" name="other_info[{{$other_info->key}}]" style="padding: 0">
                                @php $select = explode(",", $other_info->value); @endphp
                                @if(count($select) > 0)
                                @foreach($select as $sl)
                                    <option value="{{$sl}}">{{$sl}}</option>
                                    @endforeach
                                @endif
                            </select>
                        @elseif($other_info->type == 'textarea')
                            <textarea id="form_{{$other_info->key}}" name="other_info[{{$other_info->key}}]"
                                      class="form-control" placeholder="{{$other_info->placeholder}}" rows="4"
                                      @if($other_info->required == 1) required @endif></textarea>
                        @elseif($other_info->type == 'radio')
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
        <div class="col-md-12">
            <div class="form-group">
                <label for="form_message">Nội dung</label>
                <textarea id="form_message" name="message" class="form-control" placeholder="Thông tin thêm"
                          rows="4"></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <input name="current_url" type="hidden" value="{{base64_encode(url()->current())}}">
            <button type="submit" class="btn btn-success btn-lg" value="submit"><i class="fa fa-paper-plane"></i> {{$submit}}</button>
        </div>
    </div>

</div>

{!! Form::close() !!}

