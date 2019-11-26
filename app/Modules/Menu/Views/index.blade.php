@extends('master')

@section('meta')
@endsection

@section('css')
<style type="text/css">
  #menu-tree-wrapper .nav-item.status-disable > .nav-link{
    background: #e6e6e6;
    color: #a3a3a3;
  }
  #menu-tree-wrapper .nav-item.status-disable > .nav-link:hover{
    color: #007bff;
  }
  #menu-form-wrapper select option.status-disable{
    background: #e6e6e6;
    color: #a3a3a3;
  }
  #menu-tree-wrapper .nav-item >.nav-link{
    border: 1px solid #ccc;
  }
  #menu-tree-wrapper .nav-item.menu-open >.nav-link{
    background: #292929;
    color: #fff;
  }
  #menu-tree-wrapper .nav-item >.nav-link a{
    color: inherit !important;
  }
  #menu-tree-wrapper .nav-item.menu-open >.nav-link a:hover{
    /*color: #fff;*/
  }
  #menu-tree-wrapper .nav-link.active{
    background: #007bff !important;
  }
  #menu-tree-wrapper .nav-link.active a{
    color: #fff;
  }
  section.content{
    position: relative;
  }
  .overlay{
    display: none;
    position: absolute;
    width: 100%;
    height: 100%;
    z-index: 99;
    text-align: center;
    background: rgba(255,255,255,0.7);
  }
  .overlay > i.fa{
    position: absolute;
    top: 50%;
    font-size: 30px;
    margin: -15px 0 0 -15px;
  }
</style>
@endsection

@section('js')
<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $("form#menu-form").on('submit',function(e){
    e.preventDefault();
    form_data = $(this).serialize();

    $.ajax({
      url: '{{ route("menu.ajaxpost") }}',
      method:'POST',
      data: form_data,
      beforeSend:function(){
        $('#form-message').html('');
        $('.overlay').show();
      },
      success:function(data){
        data = $.parseJSON(data);
        if(data.error_message.length > 0){
          errorHTML = '<div class="alert alert-danger error-messages "><ul>';
          for (var i = 0; i < data.error_message.length; i++) {
            errorHTML += '<li>'+data.error_message[i]+'</li>';
          }
          errorHTML += '</ul></div>';
          $('#form-message').html(errorHTML);
        }else{
          successHTML = '<div class="alert alert-success success-messages"><ul><li>'+data.success_message+'</li></ul></div>';
          $('#menu-tree-wrapper').html(data.tree_html);
          $('#menu-form-wrapper').html(data.form_html);
          // $('#menu-form input[name="id"]').val(data.id);
          $('#menu-form-title').html(data.form_title);
          $('#form-message').html(successHTML);
        }
            $('.overlay').fadeOut(1000);
      }
    });
  });
  $(document).ready(function(){
    $('body').on('click','.menu-item-action-btn',function(e){
      e.preventDefault();
      id = $(this).data('menu-id');
      type = $(this).data('action-type');
      confirmText = $(this).data('confirm');
      if(confirmText!=''){
        var actionConfirm = confirm(confirmText);
      }
      if(confirmText=='' || actionConfirm==true){
        $.ajax({
          url: '{{ route("menu.ajaxitemaction") }}',
          method: 'POST',
          data: {type:type,id:id},
          beforeSend:function(){
            $('#form-message').html('');
            $('.overlay').show();
          },
          success:function(data){
            data = $.parseJSON(data);
            $('#menu-tree-wrapper').html(data.tree_html);
            $('#menu-form-wrapper').html(data.form_html);
            $('#menu-form-title').html(data.form_title);

            $('.overlay').fadeOut(1000);
          }
        });
      }
    });

    $('body').on('click','.render-new-form',function(e){
      e.preventDefault();
      $.ajax({
        url: '{{ route("menu.ajaxrenderform") }}',
        method: 'POST',
        data: {form:'new'},
        beforeSend:function(){
          $('#form-message').html('');
          $('.overlay').show();
        },
        success:function(data){
          data = $.parseJSON(data);
          $('#menu-form-wrapper').html(data.form_html);
          $('#menu-form-title').html(data.form_title);

            $('.overlay').fadeOut(1000);
        }
      });
    });
  });

</script>
@endsection

@section('content')
<!-- Main content -->
<section class="content">
  <div class="row">
    @include('layouts.errors')

    <div class="col-sm-6 col-md-6">
      <div class="card card-primary">
        <div class="card-header" style="">
          <h3 class="card-title">Menu tree</h3>
        </div>
        <div class="card-body sidebar-primary" style="">
          <div id="menu-tree-wrapper" class="nav-sidebar">
            {!! $tree_html !!}
          </div>
        </div>
      </div>
    </div>
      
    <div class="col-sm-6 col-md-6">
      <div class="card card-primary card-menu-form">
        <div class="card-header" style="">
          <h3 id="menu-form-title" class="card-title">{{ $form_title }}</h3>
          <div class="float-right">
            <a href="#"><button class="btn btn-success btn-sm render-new-form"><i class="fa fa-plus-circle"></i> Add New Menu</button></a>
          </div>
        </div>
        <div class="card-body">
          <div id="form-message"></div>
            {!! Form::open(array('route' => 'menu.store','method'=>'POST','id'=>'menu-form')) !!}
          <div id="menu-form-wrapper" style="">
              {!! $form_html !!}
          </div>
            {!! Form::close() !!}
        </div>
      </div>
    </div>
    <div class="overlay" style="display: none;">
      <i class="fa fa-refresh fa-spin"></i>
    </div>
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->
@endsection