@extends('master')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
    <style>
        .red{
            color: red;
        }
        #preview img{
            padding: 10px;
        }
        .tags-input-wrapper{
            background: transparent;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc
        }
        .tags-input-wrapper input{
            border: none;
            background: transparent;
            outline: none;
            width: 140px;
            margin-left: 8px;
        }
        .tags-input-wrapper .tag{
            display: inline-block;
            background-color: #fa0e7e;
            color: white;
            border-radius: 40px;
            padding: 0px 3px 0px 7px;
            margin-right: 5px;
            margin-bottom:5px;
            box-shadow: 0 5px 15px -2px rgba(250 , 14 , 126 , .7)
        }
        .tags-input-wrapper .tag a {
            margin: 0 7px 3px;
            display: inline-block;
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="col-md-12">
            <!-- general form elements -->

           @include('layouts.errors')

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Thêm sân bay</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                {!! Form::model($data, ['method' => 'PATCH','route' => ['flight.station.update', $data->id],'enctype' => 'multipart/form-data']) !!}
                <div class="card-body row">
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tên sân bay(<span class="red">*</span>):</label>
                                <input type="text" name="name" class="form-control" placeholder="Nhập tên sân bay" required value="{{$data->name or old('name')}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tên tiếng anh(<span class="red">*</span>):</label>
                                <input type="text" name="name_en" class="form-control" placeholder="Nhập tên sân bay bằng tiếng anh" required value="{{$data->name_en or old('name_en')}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Mã code sân bay(<span class="red">*</span>):</label>
                                <input type="text" name="code" class="form-control" placeholder="Nhập mã code" style="text-transform: uppercase" maxlength="10" required value="{{$data->code or old('code')}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="url">Ảnh đại diện(<span class="red">*</span>):</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-default"
                                                onclick="selectFileWithCKFinder('image', 'logo-icon')">Chọn ảnh
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <img id="logo-icon" class="imgPreview" src="@if($data->image) {{url($data->image)}} @endif"/>
                                        <input type="hidden" name="image" id="image" class="inputImg" value=""/>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Loại sân bay(<span class="red">*</span>):</label>
                                <select name="local" id="" class="form-control">
                                    <option value="1" @if($data->local == 1) selected  @endif>Sân bay nội địa</option>
                                    <option value="2" @if($data->local == 2) selected  @endif>Sân bay quốc tế</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="info1" id="lb-fund1">Quốc gia(<span class="red">*</span>):</label>
                                <select id="country" class="form-control select2 inv_id" name="country" >
                                    @foreach($countries as $item)
                                        <option value="{{$item->code}}" @if($item->code == $data->country) selected @endif>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br>
                        </div>
                        <div class="col-md-12" style="transform: translateY(-14px);">
                            <div class="form-group">
                                <label for="info1" id="lb-fund1">Thành phố(<span class="red">*</span>):</label>
                                <select id="city" class="form-control" name="city" >
                                    <option value="">-- Chọn thành phố --</option>
                                    @foreach($cities as $item)
                                        <option value="{{$item->code}}" @if($item->code == $data->city) selected @endif >{{$item->name_city}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br>
                        </div>
                        <div class="col-md-12" style="transform: translateY(-14px);">
                            <div class="form-group">
                                <label for="info1" id="lb-fund1">Khu vực(<span class="red">*</span>):</label>
                                <select id="area" class="form-control" name="area" >
                                    <option value="1" @if($data->area == 1) selected  @endif>Việt Nam</option>
                                    <option value="2" @if($data->area == 2) selected  @endif>Châu Á</option>
                                    <option value="3" @if($data->area == 3) selected  @endif>Châu Âu</option>
                                    <option value="4" @if($data->area == 4) selected  @endif>Châu ÚC</option>
                                    <option value="5" @if($data->area == 5) selected  @endif>Châu Mỹ</option>
                                    <option value="6" @if($data->area == 6) selected  @endif>Châu Phi</option>
                                    <option value="7" @if($data->area == 7) selected  @endif>Khu vực khác</option>
                                </select>
                            </div>
                            <br>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Tags Search</label>
                            <input type="text" id="tag-input1" name="search_tags" class="form-control tags-input-wrapper" value="{{$data->search_tags or old('search_tags')}}">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="note">Mô tả(<span class="red">*</span>):</label>
                            <textarea name="description" id="content" class="form-control"
                                      rows="30" required>{{$data->description or old('description') }}</textarea>
                        </div>
                    </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Trạng thái:</label>
                                <input name="status" id="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;" @if($data->status == 1 ) checked="checked" @endif >
                                <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                                    <div class="Toggle"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
                    <div class="col-md-12">
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" style=" margin: 10px"><i class="fa fa-pencil"> </i> Cập nhật</button>
                            <a href="{{route('flight.station.index')}}" class="btn btn-warning" style=" margin: 10px"><i class="fa fa-times" aria-hidden="true"></i> Đóng</a>
                        </div>
                    </div>
                    @csrf
                {!! Form::close() !!}
            </div>
            <!-- /.card -->
      </div>
    </div>
</section>
<!-- /.content -->
@endsection
@section('js')
    @include('ckfinder::setup')
    <script src="{{ asset('adminlte/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/ckeditor4101/ckeditor.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script>
        $(function () {
            CKEDITOR.replace('content', {
                filebrowserBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
                filebrowserImageBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
                filebrowserFlashBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
            });
            CKEDITOR.config.extraPlugins = 'justify , colorbutton';
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            $("#country").on('change', (function(e){
                var code = $(this).val();
                console.log(code);
                $.ajax({
                    type:'POST',
                    url:'{{ route('ajax.flight.cities') }}',
                    data:{code:code},
                    success:function(data){
                        $('#city').html(data);
                    }
                });
            }));

        });
        $(document).ready(function () {
            $("#country").select2(
                {
                    tags: true,
                    ajax: {
                        url: "{{ url($backendUrl.'/inventory/search/counties')  }}",
                        type: "POST",
                        dataType: 'json',
                        delay: 150,
                        data: function (params) {
                            return {
                                searchTerm: params.term // search term
                            };
                        },
                        processResults: function (response) {
                            return {
                                results: response
                            };
                        },
                        cache: true
                    }
                }
            );
        });

    </script>
{{--    <script !src="">--}}
{{--        (function(){--}}

{{--            var TagsInput = function(opts){--}}
{{--                this.options = Object.assign(TagsInput.defaults , opts);--}}
{{--                this.orignal_input = document.getElementById(opts.selector);--}}
{{--                this.arr = [];--}}
{{--                this.wrapper = document.createElement('div');--}}
{{--                this.input = document.createElement('input');--}}
{{--                buildUI(this);--}}
{{--                addEvents(this);--}}
{{--            }--}}


{{--            TagsInput.prototype.addTag = function(string){--}}

{{--                if(this.anyErrors(string))--}}
{{--                    return ;--}}

{{--                this.arr.push(string);--}}
{{--                var tagInput = this;--}}


{{--                var tag = document.createElement('span');--}}
{{--                tag.className = this.options.tagClass;--}}
{{--                tag.innerText = string;--}}

{{--                var closeIcon = document.createElement('a');--}}
{{--                closeIcon.innerHTML = '&times;';--}}
{{--                closeIcon.addEventListener('click' , function(e){--}}
{{--                    e.preventDefault();--}}
{{--                    var tag = this.parentNode;--}}

{{--                    for(var i =0 ;i < tagInput.wrapper.childNodes.length ; i++){--}}
{{--                        if(tagInput.wrapper.childNodes[i] == tag)--}}
{{--                            tagInput.deleteTag(tag , i);--}}
{{--                    }--}}
{{--                })--}}


{{--                tag.appendChild(closeIcon);--}}
{{--                this.wrapper.insertBefore(tag , this.input);--}}
{{--                this.orignal_input.value = this.arr.join(',');--}}

{{--                return this;--}}
{{--            }--}}



{{--            TagsInput.prototype.deleteTag = function(tag , i){--}}
{{--                tag.remove();--}}
{{--                this.arr.splice( i , 1);--}}
{{--                this.orignal_input.value =  this.arr.join(',');--}}
{{--                return this;--}}
{{--            }--}}


{{--            TagsInput.prototype.anyErrors = function(string){--}}
{{--                if( this.options.max != null && this.arr.length >= this.options.max ){--}}
{{--                    console.log('max tags limit reached');--}}
{{--                    return true;--}}
{{--                }--}}

{{--                if(!this.options.duplicate && this.arr.indexOf(string) != -1 ){--}}
{{--                    console.log('duplicate found " '+string+' " ')--}}
{{--                    return true;--}}
{{--                }--}}

{{--                return false;--}}
{{--            }--}}


{{--            TagsInput.prototype.addData = function(array){--}}
{{--                var plugin = this;--}}

{{--                array.forEach(function(string){--}}
{{--                    plugin.addTag(string);--}}
{{--                })--}}
{{--                return this;--}}
{{--            }--}}


{{--            TagsInput.prototype.getInputString = function(){--}}
{{--                return this.arr.join(',');--}}
{{--            }--}}


{{--            // Private function to initialize the UI Elements--}}
{{--            function buildUI(tags){--}}
{{--                tags.wrapper.append(tags.input);--}}
{{--                tags.wrapper.classList.add(tags.options.wrapperClass);--}}
{{--                tags.orignal_input.setAttribute('hidden' , 'true');--}}
{{--                tags.orignal_input.parentNode.insertBefore(tags.wrapper , tags.orignal_input);--}}
{{--            }--}}



{{--            function addEvents(tags){--}}
{{--                tags.wrapper.addEventListener('click' ,function(){--}}
{{--                    tags.input.focus();--}}
{{--                });--}}
{{--                tags.input.addEventListener('keydown' , function(e){--}}
{{--                    var str = tags.input.value.trim();--}}
{{--                    if( !!(~[9 , 13 , 188].indexOf( e.keyCode ))  )--}}
{{--                    {--}}
{{--                        tags.input.value = "";--}}
{{--                        if(str != "")--}}
{{--                            tags.addTag(str);--}}
{{--                    }--}}
{{--                });--}}
{{--            }--}}


{{--            TagsInput.defaults = {--}}
{{--                selector : '',--}}
{{--                wrapperClass : 'tags-input-wrapper',--}}
{{--                tagClass : 'tag',--}}
{{--                max : null,--}}
{{--                duplicate: false--}}
{{--            }--}}


{{--            window.TagsInput = TagsInput;--}}

{{--        })();--}}

{{--        var tagInput1 = new TagsInput({--}}
{{--            selector: 'tag-input1',--}}
{{--            duplicate : false,--}}
{{--            max : 10--}}
{{--        });--}}

{{--    </script>--}}
@endsection
