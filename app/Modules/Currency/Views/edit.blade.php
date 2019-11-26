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
      <div class="col-md-12">
            <!-- general form elements -->

           @include('layouts.errors')

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Create Currency</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {!! Form::model($currency, ['method' => 'PATCH','route' => ['currencies.update', $currency->id]]) !!}
                <div class="card-body row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Name:</label>
                      <input name="name" type="text" class="form-control" id="name" placeholder="Name" value="{{ $currency->name or old('name') }}" >
                    </div>
                    <div class="form-group">
                      <label for="code">Code:</label>
                      {!! Form::select('code',$lsCurrency,$currency->code, array('class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                      <label for="decimal">Decimal:</label>
                      <input name="decimal" type="text" class="form-control" id="decimal" placeholder="Enter Decimal" value="{{ $currency->decimal or  old('decimal') }}">
                    </div>

                    <div class="form-group">
                      <label for="symbol_left">Symbol Left:</label>
                      <input name="symbol_left" type="text" class="form-control" id="url" placeholder="Enter Symbol Left" value="{{ $currency->symbol_left or old('symbol_left') }}">
                    </div>

                    <div class="form-group">
                      <label for="symbol_right">Symbol Right:</label>
                      <input name="symbol_right" type="text" class="form-control" id="symbol_right" placeholder="Enter Symbol Right" value="{{ $currency->symbol_right or old('symbol_right') }}">
                    </div>

                    
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="value">Rate USD:</label>
                      <input name="value" type="text" class="form-control" id="value" placeholder="Enter rate USD" value="{{ $currency->value or  old('value') }}">
                    </div>
                    <div class="form-group">
                      <label for="seperator">Seperator:</label>
                      {!! Form::select('seperator', array('comma'=>'Comma','space'=>'Space','dot'=>'Dot'),$currency->seperator, array('class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                      <label for="sort">Sort:</label>
                      <input name="sort" type="text" class="form-control" id="sort" placeholder="Enter Sort" value="{{ $currency->sort or  old('sort') }}">
                    </div>

                    <div class="form-group">
                      <label for="fiat">Fiat currency:</label>
                      <input name="fiat" type="checkbox" value="fiat" data-toggle="toggle" style="display: none;" @if( $currency->fiat == 1 ) checked="checked" @endif>
                        <div class="Switch Round" style="vertical-align:top;margin-left:10px;">
                            <div class="Toggle"></div>
                        </div>
                    </div>
                    <div class="form-group">
                      <label for="homepage">Show Homepage:</label>
                        <input name="homepage" id="homepage" type="checkbox" value="homepage" data-toggle="toggle" style="display: none;" @if( $currency->homepage == 1 ) checked="checked" @endif>
                        <div class="Switch Round" style="vertical-align:top;margin-left:10px;">
                            <div class="Toggle"></div>
                        </div>
                    </div>
                    <div class="form-group">
                      <label for="default">Default:</label>
                        <input name="default" id="default" type="checkbox" value="default" data-toggle="toggle" style="display: none;" @if( $currency->default == 1 ) checked="checked" @endif>
                        <div class="Switch Round" style="vertical-align:top;margin-left:10px;">
                            <div class="Toggle"></div>
                        </div>
                    </div>                   

                    <div class="form-group">
                      <label for="status">Status:</label>
                        <input name="status" id="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;" checked="checked">
                        <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                            <div class="Toggle"></div>
                        </div>
                    </div>
                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.card -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
    <!-- /.card -->
    </div>
  <!-- /.col -->
  </div>
<!-- /.row -->
</section>
<!-- /.content -->
@endsection