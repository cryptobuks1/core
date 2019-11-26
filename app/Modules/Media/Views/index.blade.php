@extends('master')


@section('css')

@endsection
@section('js')
    @include('ckfinder::setup')
    <script type="text/javascript">
        CKFinder.widget('ckfinder-widget', {
            width: '100%',
            height: 700
        });
    </script>
@endsection
@section("content")
    <section class="content">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')
                <div class="card">

                    <div class="card-header" style="border-bottom: 0">
                        <h3 class="card-title">Settings</h3>
                    </div>
                    <div id="ckfinder-widget" class="card-body p-0">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

