@extends('frontend.'.$current_theme.'.app')
@section('title')
@section('customstyle')

@section('customstyle')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

@endsection

@section('content')



    <section class="content">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')
                <div class="card">
                    <div class="card-header" style="border-bottom: 0">
                        <h3 class="card-title">Danh sách sách tài liệu</h3>
                        <div class="float-right" style="margin-right: 150px">
                            <a href="{{ route('download.add') }}"><button class="btn btn-success"><i class="fa fa-plus-circle"></i> Thêm tài  liệu</button></a>
                        </div>
                        <div class="card-tools ">
                            <div class="input-group input-group-sm dataTables_filter" style="width: 150px;">
                            </div>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <form action="" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="card-body" style="padding-top: 50px;">
                                    <div class="col-sm-12">
                                        <table id="example1" class="table table-bordered table-striped dataTable" >
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tên tài liệu</th>
                                                <th>Ảnh nền</th>
                                                <th>Danh mục</th>
                                                <th>Giá</th>
                                                <th>Miêu tả ngắn ngọn</th>
                                                <th>Khuyến mãi</th>
                                                <th>Đánh giá</th>
                                                <th>Trạng thái</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @if(!count($data))
                                                    <tr>
                                                        <td colspan="12" class="text-center alert alert-info">Chưa có dữ liệu
                                                        </td>
                                                    </tr>
                                                @else
                                                @foreach( $data as $data )

                                                        <td style="text-align: center; line-height: 70px">{{$data->id }}</td>
                                                        <td >{{$data->name}}</td>
                                                        <td>
                                                            <img src="@if(isset($data->img)){{asset('storage/avatar/'.$data->img)}} @endif" height="70" width="80">
                                                        </td>
                                                        <td>
                                                            @foreach($data_cat as $cat)
                                                                @if($cat->id==$data->cat_id)
                                                                    {{$cat->name}}
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @if(count($currencies) >0)
                                                                @foreach($currencies as  $currency)
                                                                    {{number_format($data->price[$currency->code]).' '.$currency->code}}<br>
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                        <td>{{strip_tags($data->short_description)}}</td>
                                                        <td style="text-align: center;">{{$data->discount}}</td>
                                                        <td style="text-align: center;">@if($data->rating) <span style="color: gold; font-weight: 700;font-size: 3rem "> {{$data->rating}}</span>  @else <span style="color: gray; font-weight: 600">Chưa  có đánh giá</span> @endif</td>
                                                        <td id="status"  data-key="{{$data->status}}"style="width: 10%; font-size: 15px; font-weight: 700; text-align: center" >
                                                            @if($data->status===1)
                                                                <span style="color: green"> Đã duyệt</span>
                                                            @else  <span style="color: gray; ">Chưa duyệt</span> @endif</td>
                                                        <td style="width: 10%;text-align: center; font-size: 2rem;">
                                                            <div class="action-buttons">
                                                                <a href="{{asset('downloads/edit/'.$data->id)}}"><span class="btn btn-warning" > <i title="Sửa"
                                                                                                                                                    class="ace-icon fa fa-pencil bigger-130" ></i></span>
                                                                    </a>
                                                                <a href="{{asset('downloads/destroy/'.$data->id)}}" name="{{$data->name}}"> <span class="btn btn-danger"><i title="Delete"
                                                                                                                                                                            class="ace-icon fa fa-trash-o bigger-130"></i></span> </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                         </form>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- Main content -->

@endsection


@section('js-footer')
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <script>

@endsection
