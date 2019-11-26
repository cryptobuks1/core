@extends('master')

@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-12">
            @include('layouts.errors')
            <div class="card">

                <div class="card-header" style="border-bottom: 0">
                    <h3 class="card-title">Wallet Settings</h3>
                </div>

                <div class="card-body">
                    <div class=" alert alert-danger">
                        <strong>Error!</strong> System not currency!<br/>
                        <strong>Please create currency before make Setting system wallet!</strong>
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
@endsection
