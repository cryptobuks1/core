@extends('master')

@section('css')
@endsection

@section('js')

@endsection

@section('content')
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-12">
      @include('layouts.errors')
<div class="card">
  
  <div class="card-header" style="border-bottom: 0">
    <h3 class="card-title">Danh sách</h3>
    <div class="float-right" style="margin-right: 440px">
      <a href="{{ url($backendUrl.'/giftcode/create') }}"><button class="btn btn-success"><i class="fa fa-plus-circle"></i> Thêm Giftcode</button></a>
    </div>
    <div class="card-tools ">
      <div class="input-group input-group-sm dataTables_filter pull-left" style="width: 150px; margin-right:15px;">
        <form action="{{ url($backendUrl. '/giftcode/fillterSKU') }}" name="formSearch" method="POST" >
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="text" name="keyword" class="form-control float-right" placeholder="SKU search" style="padding-right: 42px;">
          <div class="input-group-append" style="margin-left: 110px">
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
          </div>
        </form>
      </div>
      <div class="input-group input-group-sm dataTables_filter pull-left" style="width: 150px; margin-right:110px;">
        <form action="{{ url($backendUrl. '/exportCode') }}" name="formSearch" method="POST" >
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="text" name="keyword" class="form-control float-right" placeholder="SKU search" style="padding-right: 42px;">
          <div class="input-group-append" style="margin-left: 110px">
            <button type="submit" class="btn btn-default">Export Gift Code</button>
          </div>
        </form>
      </div>
    </div>

  </div>
  <!-- /.card-header -->
  <form action="{{ url($backendUrl.'/giftcode/actions') }}" method="POST">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div class="card-body" style="padding-top: 0;">
    <div class="row"><div class="col-sm-12 table-responsive">
    <table id="example1" class="table table-bordered table-striped dataTable">
      <thead>
        <tr>
          <th class="center sorting_disabled" rowspan="1" colspan="1" aria-label=""> 
            <label class="pos-rel">
              <input type="checkbox" class="ace" id="checkall">
              <span class="lbl"></span> </label>
          </th>
          <th>ID</th>
          <th>Tên</th>
          <th>Mã Giftcode</th>
          <th>Loại</th>
          <th>Model</th>
          <th>SKU</th>
          <th>Giá trị</th>
          <th>Giảm giá</th>
          <th>Lần sử dụng</th>
          <th>Kích hoạt</th>
          <th>Ngày hết hạn</th>
          <th>Ngày tạo</th>
          <th>Trạng thái</th>
          <th>Hành động</th>
        </tr>
      </thead>  
      <tbody>
      @foreach( $giftcodes as $giftcode )
        <tr>
          <td class="center"><label class="pos-rel">
              <input type="checkbox" class="ace mycheckbox" value="{{ $giftcode->id }}" name="check[]">
              <span class="lbl"></span> </label>
          </td>
          <td>{{ $giftcode->id }}</td>
          <td>{{ $giftcode->name }}</td>
          <td><strong>{{ $giftcode->code }}</strong></td>
          <td>{{ $giftcode->type }}</td>
          <td>{{ $giftcode->model }}</td>
          <td>{{ $giftcode->sku}}</td>
          <td>@if($giftcode->value){{ number_format($giftcode->value)}} {{ $giftcode->currency_code}} @endif</td>
          <td>@if($giftcode->discount){{ $giftcode->discount}}% @endif</td>
          <td>{{ $giftcode->used_time}}</td>
          <td>
            <div data-table="giftcode" data-id="{{ $giftcode->id }}" data-col="active" class="Switch Round @if($giftcode->active == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
              <div class="Toggle" ></div>
            </div>

          </td>
          <td>{{ $giftcode->expired_at }} <br><span class="small text-success">(còn {{$giftcode->remain}} ngày) </span></td>
          <td>{{ $giftcode->created_at }}</td>
          <td>

            @if($giftcode->status == 1)
              <label class="badge badge-success">Chưa dùng</label>
            @elseif($giftcode->status == 2)
              <label class="badge badge-danger">Đã dùng</label>
            @elseif($giftcode->status == 3)
              <label class="badge badge-dark">Hết hạn</label>
            @endif

          </td>

          <td>
            <div class="action-buttons">
             <a href="{{ url($backendUrl.'/giftcode/'.$giftcode->id) }}" class=""><span class="btn btn-sm btn-danger"><i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></span></a>

            </div>
          </td>
        </tr>
      @endforeach
     
      </tbody>
      
    
    </table>
  </div></div>
    <div class="row">
      <div class="col-sm-12 col-md-5">
      </div>
      <div class="col-sm-12 col-md-7">
        <div class="float-right" id="dynamic-table_paginate">
          <?php $giftcodes->setPath('giftcode'); ?>
          <?php echo $giftcodes->render(); ?>
        </div>
      </div>
    </div>
  </div></form>
  <!-- /.card-body -->
</div>
<!-- /.card -->
</div>
  <!-- /.col -->
</div>
<!-- /.row -->
</section>
<!-- /.content -->
@endsection