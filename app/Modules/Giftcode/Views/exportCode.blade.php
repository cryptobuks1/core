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
    <div class="row">
        <div class="col-sm-12 table-responsive">
            <textarea name="" id="" cols="30" class="form-control" rows="10">@if(count($arrayCode) > 0)<?php foreach($arrayCode as $value){?> {{ $value }}, <?php } ?>@else Mã sản phẩm này không có Giftcode @endif
            </textarea>
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