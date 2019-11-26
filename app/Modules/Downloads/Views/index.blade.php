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
                        <h3 class="card-title">Danh mục downloads</h3>
                        <div class="float-right" style="margin-right: 150px">
                        </div>


                    </div>
                    <!-- /.card-header -->
                    <form action="" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="card-body" style="padding-top: 0;">
                            <div class="row table-responsive"><div class="col-sm-12">
                                    <table id="example1" class="table table-bordered table-striped dataTable">
                                        <thead>

                                        <th>ID</th>
                                        <th>Tên tài liệu</th>
                                        <th>Ảnh nền</th>
                                        <th>Danh mục</th>
                                        <th>Giá</th>
                                        <th>Miêu tả ngắn ngọn</th>
                                        <th>Khuyến mãi</th>
                                        <th>Trạng thái</th>
                                        <th>Nổi bật</th>
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

                                                <td>{{$data->id }}</td>
                                                <td>{{$data->name}}</td>
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
                                                <td>{{$data->discount}}</td>
                                                <td>
                                                    <div data-table="downloads" data-id="{{ $data->id }}" data-col="status" class="Switch Round @if($data-> status == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                                                        <div class="Toggle" ></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div data-table="downloads" data-id="{{ $data->id }}" data-col="featured" class="Switch Round @if($data-> featured == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                                                        <div class="Toggle" ></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="{{ url($backendUrl.'/downloads/edit/'.$data->id) }}">
                                                            <span class="btn btn-warning"><i title="Sửa"
                                                                     class="ace-icon fa fa-pencil bigger-130"></i> </span>  </a>
                                                        <a href="#" name="{{$data->name}}" link="{{ url($backendUrl.'/downloads/delete/'.$data->id) }}" class="deleteClick red id-btn-dialog2" data-toggle="modal" data-target="#deleteModal"> <span class="btn btn-danger"> <i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></span> </a>
                                                    </div>
                                                </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
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
    <!-- /.content -->
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
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <input type="hidden" name="_method" value="delete" />
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
    <!-- End Delete form-->
@endsection
