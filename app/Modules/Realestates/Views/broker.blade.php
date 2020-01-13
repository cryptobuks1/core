@extends('master')

@section('css')
@endsection

@section('js')
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
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')
                <div class="card" style="">
                    <div class="card-header" style="border-bottom: 0 ;padding-bottom: 20px">
                        <h3 class="card-title">Danh mục dự án</h3>
                        <div class="card-tools " >
                            <div class="input-group input-group-sm dataTables_filter" style="width: 150px;">
                                <form action="" name="formSearch" method="GET" >
                                    <input type="text" name="keyword" class="form-control float-right" placeholder="Search" style="padding-right: 42px;">
                                    <div class="input-group-append" style="margin-left: 110px">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search" ></i></button>
                                    </div>
                                </form>
                            </div>
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
                                            <th>ID User</th>
                                            <th>Tên môi giới</th>
                                            <th>Địa chỉ</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Lĩnh vực</th>
                                            <th>Trạng thái</th>
                                            <th>Nổi bật</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($brokers as $broker)
                                            <tr>
                                                <td>{{$broker->id}}</td>
                                                <td>{{$broker->user_id}}</td>
                                                <td style="width: 10%">{{$broker->name}}</td>
                                                <td style="width: 15%">{{$broker->address}}</td>
                                                <td>{{$broker->phone}}</td>
                                                <td>{{$broker->email}}</td>
                                                <td style="width:20%">
                                                    @foreach($broker->fields as $item)
                                                        @foreach($types as $type)
                                                            @if($item==$type->id)
                                                                <p><strong>- {{$type->name}}</strong></p>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <div data-table="realestates_broker" data-id="{{ $broker->id }}" data-col="status" class="Switch Round @if($broker->status == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                                                        <div class="Toggle" ></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div data-table="realestates_broker" data-id="{{ $broker->id }}" data-col="featured" class="Switch Round @if($broker->featured == 1) On @else Off @endif " style="vertical-align:top;margin-left:10px;">
                                                        <div class="Toggle" ></div>
                                                    </div>
                                                </td>
                                                <td style="text-align: center; width: 10%">
                                                    <a href="{{ url($backendUrl.'/broker/edit/'.$broker->id)}}"> <span class="btn btn-warning"><i title="Sửa" class="ace-icon fa fa-pencil bigger-130"></i></span> </a>
                                                    <a href="#" name="{{ $broker->name }}" link="{{ url($backendUrl.'/broker/delete/'.$broker->id)}}" class="deleteClick red id-btn-dialog2"data-toggle="modal" data-target="#deleteModal" > <span class="btn btn-danger"><i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></span></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{$brokers->links()}}
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->


    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="deleteForm" action="" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Danh Mục</h5>
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
