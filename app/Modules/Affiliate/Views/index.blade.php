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
          <h3 class="card-title">Tìm kiếm</h3>

          <div class="card-tools " style="float: left;position: relative;right: 0px;left: 20px;">
            <div class="input-group input-group-sm dataTables_filter" style="">
              <form action="" name="formSearch" method="GET" >
                <div class="input-group">
                  <select name="type" class="form-control" style="">
                    <option value="serial"
                            @if(app("request")->input("type")=="affiliate_code") selected="selected" @endif>
                      Mã giới thiệu
                    </option>
                    <option value="code"
                            @if(app("request")->input("type")=="module") selected="selected" @endif>
                      Theo mô-đun
                    </option>
                    <option value="email"
                            @if(app("request")->input("type")=="user_id") selected="selected" @endif>
                      Theo User ID
                    </option>
                    <option value="phone"
                            @if(app("request")->input("type")=="order_code") selected="selected" @endif>
                      Mã đơn hàng
                    </option>
                  </select>
                  <input type="text" name="keyword" class="form-control"
                         placeholder="Nhập vào đây"
                         value="{{ app("request")->input("keyword") }}"/>
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <div class="float-right" style="">

            <a href="{{ url($backendUrl.'/affiliates') }}">
              <button class="btn btn-success"><i class="fa fa-list" aria-hidden="true"></i> Danh sách
              </button>
            </a>
            <a href="{{ url($backendUrl.'/affiliates/setting') }}">
              <button class="btn btn-primary"><i class="fa fa-cog"></i> Cấu hình</button>
            </a>
          </div>
        </div>

        <!-- /.card-header -->
        <div class="card-body" style="padding-top: 0;">
          <div class="row">
            <div class="col-sm-12">

              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped ">
                  <thead>
                  <tr>
                    <th>TT</th>
                    <th>Mã giới thiệu</th>
                    <th>Mã đơn hàng</th>
                    <th>Doanh thu</th>
                    <th>Huê hồng</th>
                    <th>Người nhận</th>
                    <th>Mô-đun</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Ngày thanh toán</th>
                    <th>Hành động</th>

                  </tr>
                  </thead>
                  <tbody>
                  @if(!count($affiliates))
                    <tr>
                      <td colspan="11" class="text-center alert alert-light">Chưa có dữ liệu
                      </td>
                    </tr>
                  @else
                    @foreach( $affiliates as $affiliate )
                      <tr class="irow" data-id="{{ $affiliate->id }}">

                        <td>{{$affiliate->affiliate_code}}</td>
                        <td>{{$affiliate->order_code .' '. $affiliate->currency_code}}</td>
                        <td>{{$affiliate->amount .' '. $affiliate->currency_code}}</td>
                        <td>{!! App\User::getUserInfo($charging->user) !!}</td>
                        <td>{{$affiliate->module}}</td>
                        <td>
                          @if($affiliate->status == 1)
                            <label class="badge badge-success">Đã thanh toán</label>
                          @elseif($affiliate->status == 2)
                            <label class="badge badge-success">Truy hồi</label>
                          @elseif($affiliate->status == 3)
                            <label class="badge badge-danger">Hủy bỏ</label>
                          @elseif($affiliate->status == 4)
                            <label class="badge badge-danger">Giả mạo</label>
                          @elseif($affiliate->status == 99)
                            <label class="badge badge-warning">Chờ thanh toán</label>
                          @else
                            <label class="badge badge-warning">Không rõ</label>
                          @endif
                        </td>
                        <td>{{ $affiliate->payment_at }}</td>
                        <td>{{ $affiliate->created_at }}</td>
                        <td></td>

                      </tr>
                    @endforeach
                  @endif
                  </tbody>


                </table>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="float-right" id="dynamic-table_paginate">
                {{$affiliates->appends(request()->query())->links()}}
              </div>
            </div>
          </div>
        </div>

        <!-- Delete form -->
        <script type="text/javascript">
            $(document).ready(function(){
                $(".deleteClick").click(function(){
                    var link = $(this).attr('link');
                    var name = $(this).attr('name');
                    $("#deleteForm").attr('action',link);
                    $("#deleteMes").html("Delete : "+name+" ?");
                });
            });
        </script>
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form id="deleteForm" action="" method="POST">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div id="deleteMes" class="modal-body">

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                  </button>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <input type="hidden" name="_method" value="delete" />
                {{ csrf_field() }}
              </form>
            </div>
          </div>
        </div>
        <!-- End Delete form-->


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