{!! Form::open(array('route' => 'softcard.postcheckout','method'=>'POST','enctype'=>'multipart/form-data')) !!}
<div class="panel panel-info">
    <div class="panel-heading" style="padding-bottom: 5px; padding-top: 5px">
        <div class="">
            <h5><i class="fa fa-shopping-cart" aria-hidden="true"></i> Giỏ hàng</h5>
        </div>
    </div>
    <div class="panel-body">
        @if(Cart::instance('Softcard')->count())
            @foreach(Cart::instance('Softcard')->content() as $row)
                <div class="row">
                    <div class="col-name">
                        <h5 class="product-name"><strong>{{ $row->name }}</strong></h5>
                            <small>Chiết khấu: {{ $row->options->discount }}%</small>

                    </div>
                    <div class="col-qty">
                        <input name="qty-{{ $row->id }}" class="input-number form-control shopping-cart-qty" type="text"
                               min="1" max="99" value="{{ $row->qty }}" data-row="{{ $row->rowId }}"
                        data-id="{{ $row->id }}" />
                        <span class="btn-number fa fa-minus-square" aria-hidden="true" data-type="minus"
                              data-field="qty-{{ $row->id }}"></span>
                        <span class="btn-number fa fa-plus-square" aria-hidden="true" data-type="plus"
                              data-field="qty-{{ $row->id }}"></span>
                    </div>
                    <div class="col-price text-right">
                        <h5><strong>{{ number_format($row->total,0,',',',') }} {{ session()->get('currency')->symbol_right }}</strong></h5>
                    </div>
                    <div class="col-action">
                        <button class="cell-delete-item btn btn-sm btn-danger" type="button" data-sku="{{ $row->id }}"
                                data-row="{{ $row->rowId }}"><i class="fa fa-trash" title="Xoá sản phẩm"></i></button>
                    </div>
                </div>
                <hr/>
            @endforeach

            <div class="row">
                <div class="col-xs-8">
                    <h4 class="text-right">Tổng</h4>
                </div>
                <div class="col-xs-4">
                    <h4 class="text-right"><strong>{{ Cart::instance('Softcard')->total(0,',',',') }} {{ session()->get('currency')->symbol_right }}</strong></h4>
                </div>
            </div>
            <hr/>
            <div class="row payment-method">
                <div class="col-xs-12">
                    {!! $paygates !!}
                </div>
                <div class="col-xs-12">
                    <div class="noti-message">Bằng việc chọn 'Thanh toán', bạn đồng ý với <a
                                href="#">chính sách cung cấp, hủy và hoàn trả dịch vụ</a></div>
                </div>
            </div>
    </div>
    <div class="panel-footer">
        <div class="row text-center">
            <div class="col-sm-12">
                <button class="col-sm-12 button btn btn-third" type="submit">THANH TOÁN</button>
            </div>
        </div>
    </div>
    @else
        <div class="row">
            <div class="text-danger text-center">Giỏ hàng đang trống!</div>
        </div>
    @endif
</div>
{!! Form::close() !!}