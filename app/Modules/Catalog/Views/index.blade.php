@extends('master')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/treeview.css') }}">
@endsection

@section('js')
  <script src="{{ asset('js/treeview.js') }}"></script>
@endsection

@section('content')

<!-- Main content -->
<section class="content">
  @include('layouts.errors')
  <div class="row" style="padding: 10px">
           <div class="col-md-6">
             <div class="card card-info">
               <div class="card-header">
                 <h3 class="card-title">Danh mục</h3>
               </div>
               <br>
               <ul class="tree">
                 @foreach($catalogs as $category)
                   <li>
                     <i class="fa fa-plus-circle"></i> {{ $category->name }} <a href="{{$category->id}}"><i class="fa fa-edit text-primary"></i> </a>

                     @if(count($category->children))
                       @include('Catalog::treeview',['children' => $category->children])
                     @endif
                   </li>
                 @endforeach
               </ul>
               <br>
             </div>
           </div>

           <div class="col-md-6">
             <div class="card card-success">
               <div class="card-header">
                 <h3 class="card-title">Thêm danh mục</h3>
               </div>
               <!-- /.card-header -->
               <!-- form start -->
               {!! Form::open(array('route' => 'catalogs.store','method'=>'POST')) !!}
               <div class="card-body row">
                 <div class="col-md-12">
                   <div class="form-group">
                     <label for="name">Tên:</label>
                     <input name="name" type="text" class="form-control" id="name" placeholder="Tên" value="{{ old('name') }}" >
                   </div>
                   <div class="form-group">
                     <label for="slug">Đường dẫn seo:</label>
                     <input name="slug" type="text" class="form-control" id="slug" placeholder="Đường dẫn seo" value="{{ old('slug') }}">
                   </div>

                   <div class="form-group">
                     <label for="parent_id">Thư mục cha:</label>
                     <select class="form-control" name="parent_id">
                       <option value="1"> -- Thư mục gốc -- </option>
                       @if(count($cats) > 0)
                         @foreach($cats as $cat)
                           <option value="{{$cat->id}}">{{$cat->name}}</option>
                         @endforeach
                       @endif
                     </select>
                   </div>

                   <div class="form-group">
                     <label for="lang">Ngôn ngữ:</label>
                     <select class="form-control" name="lang">
                       @if(count($langs) > 0)
                         @foreach($langs as $lang)
                           <option value="{{$lang->code}}">{{$lang->name}}</option>
                         @endforeach
                       @endif
                     </select>
                   </div>

                   <div class="form-group">
                     <label for="description">Mô tả:</label>
                     <textarea name="description" id="description" class="form-control" placeholder="Description">{{ old('description') }}</textarea>
                   </div>
                   <div class="form-group">
                     <label for="sort">Sắp xếp:</label>
                     <input name="sort" type="number" class="form-control" id="sort" value="1">
                   </div>
                   <div class="form-group">
                     <label for="status">Trạng thái</label>
                     <input name="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;" checked="checked">
                     <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                       <div class="Toggle"></div>
                     </div>
                   </div>

                   <div class="form-group">
                     <label for="hidden">Ẩn:</label>
                     <input name="hidden" type="checkbox" value="hidden" data-toggle="toggle" style="display: none;">
                     <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                       <div class="Toggle"></div>
                     </div>
                   </div>

                   <div class="form-group">
                     <label for="featured">Nổi bật</label>
                     <input name="featured" type="checkbox" value="featured" data-toggle="toggle" style="display: none;">
                     <div class="Switch Round On" style="vertical-align:top;margin-left:10px;">
                       <div class="Toggle"></div>
                     </div>
                   </div>


                 </div>

               </div>
               <!-- /.card-body -->

               <div class="card-footer">
                 <button type="submit" class="btn btn-primary">Thêm mới</button>
               </div>
               {!! Form::close() !!}
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


<!-- /.card -->
</div>
</section>
<!-- /.content -->
@endsection