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
      <div class="input-group input-group-sm">
          <form action="" name="formSearch" method="GET" >
              <div class="input-group">
                  <select name="type" class="form-control" style="">
                      <option value="wallet" @if(app("request")->input("type")=="wallet") selected="selected" @endif>Theo số ví</option>
                      <option value="email" @if(app("request")->input("type")=="email") selected="selected" @endif>Theo email</option>
                      <option value="user_id" @if(app("request")->input("type")=="user_id") selected="selected" @endif>Theo ID thành viên</option>
                      <option value="phone" @if(app("request")->input("type")=="phone") selected="selected" @endif>Theo số điện thoại</option>
                      <option value="desc" @if(app("request")->input("type")=="desc") selected="selected" @endif>Theo số dư giảm dần</option>
                      <option value="asc" @if(app("request")->input("type")=="asc") selected="selected" @endif>Theo số dư tăng dần</option>

                  </select>
                  <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm" value="{{ app("request")->input("keyword") }}" />
                  <div class="input-group-append">
                      <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
                  </div>
              </div>
          </form>
      </div>

  </div>
  <!-- /.card-header -->
  <div class="card-body" style="padding-top: 0;">
    <div class="row table-responsive"><div class="col-sm-12">
    <table id="example1" class="table table-bordered table-striped dataTable">
      <thead>
        <tr>
            <th>Thành viên</th>
            <th>Địa chỉ ví</th>
            <th>Loại tiền tệ</th>
            <th>Số dư</th>
            <th>Trạng thái</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        @foreach($wallets as $wallet)
        <tr>
            <td>{!! App\User::getUserInfoWithID($wallet->user) !!}</td>
            <td>{{ $wallet->number }}</td>
            <td>{{ $wallet->currency_code }}</td>
            <td>{{ number_format($wallet->balance_decode) }} {{ $wallet->currency_code }}</td>
            <td>
                <div data-table="wallets" data-id="{{ $wallet->id }}" data-col="status" class="Switch Round @if($wallet->status == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                    <div class="Toggle" ></div>
                </div>

            </td>
            <td>{{ $wallet->created_at }}</td>
          <td>
            <div class="action-buttons">
             <a href="{{ url($backendUrl) }}/wallets/{{ $wallet->id }}/edit"><button type="button" class="btn btn-primary btn-sm"><i class="ace-icon fa fa-pencil bigger-130"></i> Nạp rút</button></a>
            </div>
          </td>
        </tr>
        @endforeach
      <tr>
          <td></td>
          <td></td>
          <td><strong>Tổng số dư:</strong></td>
          <td><strong> {{ number_format($count,0,'.','.') }} đ</strong></td>
          <td></td>
          <td></td>
          <td></td>
      </tr>
      </tbody>
    </table>
            <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="float-right" id="dynamic-table_paginate">
                    {{ $wallets->appends(request()->query())->links() }}
                </div>
            </div>
            </div>


  </div></div>

  </div>
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
