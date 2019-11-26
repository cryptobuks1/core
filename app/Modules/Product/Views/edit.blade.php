@extends('master')

@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
@endsection

@section('js')
    @include('ckfinder::setup')
    <script src="{{ asset('adminlte/plugins/ckeditor4101/ckeditor.js') }}"></script>
    <script>
        $(function () {
            CKEDITOR.replace('description', {
                filebrowserBrowseUrl: '{{ url('adminnc/ckfinderpopup') }}',
                filebrowserImageBrowseUrl: '{{ url('adminnc/ckfinderpopup') }}',
                filebrowserFlashBrowseUrl: '{{ url('adminnc/ckfinderpopup') }}',
            });
            CKEDITOR.config.extraPlugins = 'justify';
        });
    </script>
    <script src="{{ asset('adminlte/plugins/select2/select2.full.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2()
        });
    </script>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="col-md-12">
                    <!-- general form elements -->

                    @include('layouts.errors')

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit: {{ $product->name }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        {!! Form::model($product, ['method' => 'PATCH','route' => ['product.update', $product->id],'enctype'=>'multipart/form-data']) !!}
                        <div class="card-body row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Tên sản phẩm:</label>
                                    <input name="name" type="text" class="form-control" id="name" placeholder="Name"
                                           value="{{$product->name or old('name') }}">
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="product_uri">Đường dẫn gốc:</label>
                                <select name="product_uri" class="form-control" id="cat_id">
                                    <option value="">Không chọn</option>
                                    @if(count($seo_cat)>0)
                                        @foreach($seo_cat as $cati)
                                            <option value="{{$cati->url_key}}"
                                                    @if($cati->url_key == $product->product_uri) selected @endif>{{$cati->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-8 form-group">
                                <label for="product_slug">Đường dẫn SEO:</label>
                                <input name="product_slug" type="text" class="form-control" id="product_slug"
                                       placeholder="Ví dụ: bia-chai-ha-noi-330ml"
                                       value="{{$product->product_slug or old('product_slug') }}">
                            </div>

                            <div class="col-md-6 form-group ">
                                <label for="cats">Danh mục:</label>
                                {!! Form::select('cats[]', $cats,$current_cats, array('class' => 'form-control select2','multiple')) !!}

                            </div>

                            <div class="col-md-3 form-group">
                                <label for="catalogs">Thương hiệu:</label>
                                <select class="form-control" name="product_branded">
                                    @foreach($brands as $brand)
                                        <option value="{{$brand->id}}"
                                                @if($brand->id == $product->product_branded) selected @endif>{{$brand->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 form-group ">
                                <label for="custom_layout">Bố cục trang chi tiết:</label>
                                <select class="form-control" name="custom_layout" id="custom_layout">
                                    @foreach(config('view.page_layout') as $ly_code => $ly_text)
                                        <option value="{{$ly_code}}"
                                                @if(old('custom_layout')==$ly_code) selected="selected" @endif>{{$ly_text}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 form-group ">
                                <label for="custom_layout">Ngôn ngữ:</label>
                                <select class="form-control" name="language" id="language">
                                    @if(count($langs))
                                        @foreach($langs as $lang)
                                            <option value="{{$lang->code}}"
                                                    @if($product->language == $lang->code) selected="selected" @endif>{{$lang->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="qty">Số lượng:</label>
                                <input name="qty" type="text" class="form-control" id="qty" placeholder="Quantity"
                                       value="{{ $product->qty or old('qty') }}">
                            </div>
                            <div class="col-md-3 form-group ">
                                <label for="sku">Sku:</label>
                                <input name="sku" type="text" class="form-control" id="sku" placeholder="Sku"
                                       value="{{$product->sku or old('sku') }}">
                            </div>
                            <div class="col-md-3 form-group ">
                                <label for="weight">Khối lượng (gr):</label>
                                <input name="weight" type="text" class="form-control" id="weight" placeholder="weight"
                                       value="{{$product->weight or old('weight') }}">
                            </div>
                            <div class="col-md-3 form-group ">
                                <label for="volume">Thể tích (ml):</label>
                                <input name="volume" type="text" class="form-control" id="volume" placeholder="volume"
                                       value="{{$product->volume or  old('volume') }}">
                            </div>
                            <div class="col-md-3 form-group ">
                                <label for="barcode">Mã vạch:</label>
                                <input name="barcode" type="text" class="form-control" id="barcode"
                                       placeholder="barcode"
                                       value="{{$product->barcode or  old('barcode') }}">
                            </div>

                            <div class="col-md-2 form-group">
                                <label for="is_instock" style="width: 100%">Còn hàng:</label>
                                <input name="is_instock" id="is_instock" type="checkbox" value="1"
                                       data-toggle="toggle" style="display: none;"
                                       @if($product->is_instock == 1) checked="checked" @endif>
                                <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                                    <div class="Toggle"></div>
                                </div>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="status" style="width: 100%">Kích hoạt:</label>
                                <input name="status" id="status" type="checkbox" value="1" data-toggle="toggle"
                                       style="display: none;" @if($product->status == 1) checked="checked" @endif>
                                <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                                    <div class="Toggle"></div>
                                </div>
                            </div>

                            <div class="form-group col-md-12">

                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        @if($currencies->count())
                                            @foreach( $currencies as $cur )
                                                <th>{{ $cur->code }}</th>
                                            @endforeach
                                        @endif

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><strong>Giá niêm yết</strong></td>
                                        @foreach($currencies as $cur)
                                            <td>
                                                <input name="listedprice[{{$cur->code}}]" type="text" class="form-control"
                                                       placeholder="Giá bán chưa chiết khấu"
                                                       value="{{$product->listedprice[$cur->code]}}">
                                            </td>
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td><strong>Giá nhập</strong></td>
                                        @foreach($currencies as $cur)
                                            <td>
                                                <input name="inputprice[{{$cur->code}}]" type="text"
                                                       class="form-control"
                                                       placeholder="Giá nhập hàng"
                                                       value="{{$product->inputprice[$cur->code]}}">
                                            </td>
                                        @endforeach
                                    </tr>
                                    </tbody>
                                </table>


                            </div>

                            <div class="form-group col-md-12">
                                <label for="status" style="width: 100%">Giá bán:</label>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        @if($groups->count())
                                            @foreach( $groups as $group )
                                                <th>{{ $group->name }}</th>
                                            @endforeach
                                        @endif

                                    </tr>

                                    </thead>
                                    <tbody>
                                    @if(count($currencies))
                                        @foreach($currencies as $cur)
                                            <tr>
                                                <td><strong>{{$cur->code}}</strong></td>
                                                @foreach($groups as $group)
                                                    <td>
                                                        <input name="price[{{$cur->code}}][{{$group->id}}]" type="text" class="form-control"
                                                               placeholder="Giá bán {{$cur->code}}" value="{{$product->price[$cur->code][$group->id]}}">
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>


                            </div>

                            <div class="form-group col-md-12">
                                <label for="short_description">Mô tả ngắn:</label>
                                <textarea name="short_description" id="short_description"
                                          class="form-control include-ckeditor"
                                          rows="5">{{$product->short_description or  old('short_description') }}</textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="description">Mô tả chi tiết:</label>
                                <textarea name="description" id="description" class="form-control"
                                          rows="10">{{$product->description}} {{ old('description') }}</textarea>
                            </div>

                            <div class="form-group col-md-12">
                                <div class="form-group">
                                    <label for="images">Images:</label>
                                    <button id="add-new-img" class="btn btn-success float-right btn-sm" type="button"
                                            title="Add New Option"><i class="fa fa-plus-circle"></i> Thêm ảnh
                                    </button>
                                </div>
                                <table id="img-table" class="table table-striped table-sm">
                                    <tr class="thead-light">
                                        <th scope="col" width="100">Chọn ảnh</th>
                                        <th></th>
                                        <th scope="col">Mô tả</th>
                                        <th scope="col" class="text-center" style="width: 100px">Sắp xếp</th>
                                        <th scope="col" class="text-center">Ảnh chính</th>
                                        <th scope="col" class="text-center">Bật</th>
                                        <th scope="col" class="text-center" style="width:100px;"></th>
                                    </tr>
                                    <?php $numberImg = 1; ?>
                                    @if(count($gallery))
                                        @foreach($gallery as $key => $img)
                                            <tr class="images-row">
                                                <td>
                                                    <input type="hidden" name="gallery_exists[{{ $numberImg }}]"
                                                           value="{{ $img['id'] }}"/>
                                                    <img src="{{ asset($img['value']) }}" alt="{{ $img['label'] }}"
                                                         class="img-thumbnail" width="100" height="100"/>
                                                </td>
                                                <td></td>
                                                <td>
                                                    <input name="img_label[{{ $numberImg }}]" type="text"
                                                           class="form-control " placeholder="Image Label"
                                                           value="{{ $img['label'] }}"/>
                                                </td>
                                                <td class="text-center">
                                                    <input name="img_order[{{ $numberImg }}]" type="text"
                                                           class="form-control" placeholder="Position"
                                                           value="{{ $img['sort_order'] }}"/>
                                                </td>
                                                <td class="text-center">
                                                    <input name="is_thumb" type="radio" class="form-control"
                                                           value="{{ $numberImg }}"
                                                           @if($img['is_thumb']) checked="checked" @endif />
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" name="img_status[{{ $numberImg }}]"
                                                           value="1" @if($img['status']) checked="checked" @endif>
                                                </td>
                                                <td class="text-center">
                                                    <button id="" class="remove-img btn btn-danger btn-sm"
                                                            type="button" title="Remove Image"><i
                                                                class="fa fa-times-circle"></i></button>
                                                </td>
                                            </tr>
                                            <?php $numberImg++; ?>
                                        @endforeach
                                    @else
                                        <tr class="images-row">
                                            <td>
                                                <button type="button" class="btn btn-default"
                                                        onclick="selectFileWithCKFinder('images', 'logo-icon')">Chọn
                                                    ảnh
                                                </button>
                                            </td>
                                            <td>
                                                <img id="logo-icon" width="50" class="imgPreview"
                                                     src="{{ old('images') }}"/>
                                                <input type="hidden" name="images[{{ $numberImg }}]"
                                                       id="images" class="inputImg" value=""/>
                                            </td>
                                            <td>
                                                <input name="img_label[{{ $numberImg }}]" type="text"
                                                       class="form-control " placeholder="Image Label">
                                            </td>
                                            <td class="text-center">
                                                <input name="img_order[{{ $numberImg }}]" type="text"
                                                       class="form-control" placeholder="Position">
                                            </td>
                                            <td class="text-center">
                                                <input type="radio" name="is_thumb" value="1" checked>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" name="img_status[{{ $numberImg }}]" value="1"
                                                       checked>
                                            </td>
                                            <td class="text-center"></td>
                                        </tr>
                                    @endif
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            var countImage = {{ $numberImg }} +1;
                                            $("#add-new-img").click(function () {
                                                console.log(countImage)
                                                $("#img-table tbody").append('<tr class="images-row"><td><button type="button" class="btn btn-default" onclick="selectFileWithCKFinder(\'images[' + countImage + ']\', \'logo-icon' + countImage + '\')">Chọn ảnh</button></td><td> <img id="logo-icon' + countImage + '" width="50" class="imgPreview" src=""/><input type="hidden" name="images[' + countImage + ']" id="images[' + countImage + ']" class="inputImg" value=""/></td><td><input name="img_label[' + countImage + ']" type="text" class="form-control " placeholder="Image Label"></td><td class="text-center"><input name="img_order[' + countImage + ']" type="text" class="form-control" placeholder="Position"></td><td class="text-center"><input type="radio" name="is_thumb" value="' + countImage + '" ></td><td class="text-center"><input type="checkbox" name="img_status[' + countImage + ']" value="1" checked></td><td class="text-center"><button id="" class="remove-img btn btn-danger btn-sm" type="button" title="Remove Image"><i class="fa fa-times-circle"></i></button></td></tr>');
                                                countImage++;
                                            });
                                            $("body").on("click", ".remove-img", function () {
                                                $(this).parents("tr.images-row").remove();
                                            });
                                        });
                                    </script>
                                </table>
                                <div id="img-clone" class="hide">
                                </div>
                            </div>

                            <!-- /.card-body -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div>
        <!-- /.card -->
        </div>
        <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <script type="text/javascript">
        $(document).ready(function () {

            $('#name').focusout(function () {
                var pname = $(this).val();
                $.ajax({
                    url: '{{url('/').'/'.$backendUrl.'/make/ajaxslug'}}',
                    method: "post",
                    data: {
                        title: pname,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data) {
                            $("#product_slug").attr('value', data);
                        }
                    }

                });

            });
            //ajax branded
            $('#cat_id').change(function () {
                var slug = $(this).val();
                $.ajax({
                    url: '{{route('backend.ajax.branded')}}',
                    method: "post",
                    data: {
                        slug: slug,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        $('#branded').html(data)
                    }

                });
            })
        });

    </script>
    <!-- /.content -->
@endsection