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

                    <div class="card-header">
                        <h3 class="card-title">Danh sách</h3>
                        <div class="pull-right"><a href="{{ url($backendUrl.'/language/cache/'.$code) }}"><button class="btn btn-info"><i class="ace-icon fa fa-save"></i> Xuất bản {{$code}} khi dịch xong</button></a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="stock" class="table table-bordered table-striped dataTable">
                                <thead>
                                <tr>
                                    <th>Ngôn ngữ</th>
                                    <th>Loại</th>
                                    <th>Tệp tin</th>
                                    <th>Từ khóa</th>
                                    <th>Nội dung (tự động lưu)</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($trans) > 0)
                                    @foreach( $trans as $tran )
                                            <tr>
                                                <td>{{$tran->lang_code}}</td>
                                                <td>{{$tran->type}}</td>
                                                <td>{{$tran->filename}}</td>
                                                <td>{{$tran->lang_key}}</td>
                                                <td><input name="contentt" data-id="{{$tran->id}}" value="{{$tran->content}}" class="form-control translate"></td>

                                            </tr>
                                    @endforeach
                                @endif

                                </tbody>
                            </table>
                        </div>
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

    <script type="application/javascript">
        $(document).ready(function () {
            $(".translate").on('change', function (e) {
                var contentt = $(this).val();
                var id = $(this).attr("data-id");
                $.ajax({
                    url: "{{route('backend.language.ajax.translate')}}",
                    method: "post",
                    data: {
                        id: id,
                        contentt: contentt,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {

                    }

                });

            });


        });
    </script>

@endsection
