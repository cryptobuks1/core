@extends('master')

@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/select2.min.css') }}">
@endsection

@section('js')
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/select2/select2.full.min.js') }}"></script>

    <!-- SlimScroll -->
    <script src="{{ asset('adminlte/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('adminlte/plugins/fastclick/fastclick.js') }}"></script>
    @include('ckfinder::setup')
    <script src="{{ asset('adminlte/plugins/ckeditor4101/ckeditor.js') }}"></script>
    <script>
        $(function () {
            CKEDITOR.replace('content', {
                filebrowserBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
                filebrowserImageBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
                filebrowserFlashBrowseUrl: '{{ url(env('BACKEND_URI').'/ckfinderpopup') }}',
            });
            CKEDITOR.config.extraPlugins = 'justify , colorbutton';
        });
    </script>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="border-bottom: 0">
                        <h3 class="card-title">Danh sách thương hiệu</h3>
                        <div class="float-right">
                            {{--<a href="{{ route('product-branded.index' }}"><button class="btn btn-success"><i class="fa fa-plus-circle"></i> Thêm mới</button></a>--}}
                        </div>

                        <div class="float-right">
                            <select id="ls-group" class="form-control" style="margin-right: 10px;">
                                <option value="">Chọn nhóm</option>
                                @foreach($cats as $g)
                                    <option value="{{$g->id}}" @if($g->id == app('request')->input('g') ) selected="selected"@endif >{{$g->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="float-right">
                            <label style="padding-top: 10px;">Chọn nhóm:</label>
                        </div>

                    </div>
                    <!-- /.card-header -->


                    <div class="card-body" style="padding-top: 0;">
                        <div class="row"><div class="col-sm-12">
                                <table id="example1" class="table table-bordered">
                                    <thead>
                                    <tr class="success">
                                        <th>Id</th>
                                        <th>Group</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($items)
                                    @foreach($items as $cat)
                                        <tr>
                                            <td>{{ $cat->id }}</td>
                                            <td>
                                                @if(count($cat->cat_id)>0)
                                                    @foreach($cat->cat_id as $val)
                                                        <span class="badge badge-success">{{$Categories->getName($val)}}</span>
                                                        @endforeach
                                                    @endif
                                            </td>
                                            <td>{{$cat->name}}</td>
                                            <td>{{ $cat->slug }}</td>
                                            <td>
                                                <div data-table="product_branded" data-id="{{ $cat->id }}"
                                                     data-col="status"
                                                     class="Switch Round @if($cat->status == 1) On @else Off @endif "
                                                     style="vertical-align:top;margin-left:10px;">
                                                    <div class="Toggle"></div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{url($backendUrl.'/product-branded?id='.$cat->id)}}" style="display:inline;padding:2px 5px 3px 5px;">
                                                    <span class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></span></a>
                                                <a href="#" name="{{ $cat->name }}" link="{{ url($backendUrl.'/product-branded/'.$cat->id) }}" class="deleteClick red id-btn-dialog2" data-toggle="modal" data-target="#deleteModal">
                                                    <span class="btn-sm btn btn-danger"><i title="Delete" class="ace-icon fa fa-trash-o bigger-130"></i></span></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        $(".deleteClick").click(function () {
                                            var link = $(this).attr('link');
                                            var name = $(this).attr('name');
                                            $("#deleteForm").attr('action', link);
                                            $("#deleteMes").html("Delete : " + name + " ?");
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
                                                <input type="hidden" name="_method" value="delete"/>
                                                {{ csrf_field() }}
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-4">
                {!! $formContent !!}
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->

    <script>
        $(document).ready(function(){
            $("#ls-group").on('change', function(){
                var group = $(this).val();
                window.location = "{{ url($backendUrl.'/product-branded?g=') }}"+group;
            });
        });
    </script>
@endsection
