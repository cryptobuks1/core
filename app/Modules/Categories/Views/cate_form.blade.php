<div class="col-md-12">
    <div class="form-group">
        <label for="name">Name:</label>
        <input name="id" type="hidden" class="form-control" value="{{ $id }}" />
        <input name="name" type="text" class="form-control" id="name" placeholder="Category Name" @if(isset($cate)) value="{{ $cate->name }}" @endif />
    </div>

    <div class="form-group">
        <label for="url_key">Link:</label>
        <input name="url_key" type="text" class="form-control" id="url_key" placeholder="Category Url" @if(isset($cate)) value="{{ $cate->url_key }}" @endif />
    </div>

    <div class="form-group">
        <label for="description">Description:</label>
        <textarea name="description" id="description" class="form-control" rows="5"> @if(isset($cate)) {{ $cate->description }} @endif</textarea>
    </div>

    <div class="form-group">
        <label for="title">Parent Category:</label>
        <select class="form-control" name="parent_id" id="parent_id">
            <option value="0">-- Select parent category --</option>
            {!! $selectHtml !!}
        </select>
    </div>

    <!-- <div class="form-group">
        <label for="title">Custom layout:</label>
        <select class="form-control" name="custom_layout" id="custom_layout">
            <option value="0">Default</option>
            <option value="1">1 Column</option>
            <option value="2">2 Columns left</option>
            <option value="3">2 Columns right</option>
            <option value="4">3 Columns</option>
        </select>
    </div> -->

    <div class="form-group">
        <label for="title">Sort Order:</label>
        <input name="sort_order" type="text" class="form-control" id="sort_order" placeholder="Menu Position" @if(isset($cate)) value="{{ $cate->sort_order }}" @endif />
    </div>
        
    <div class="form-group">
        <label for="title">Status:</label>
        <select class="form-control" name="status" id="status">
            <option value="1" @if(isset($cate) && $cate->status==1) selected="selected" @endif>Enable</option>
            <option value="0" @if(isset($cate) && $cate->status==0) selected="selected" @endif>Disable</option>
        </select>
    </div>
</div>
<div class="col-md-12">
    <button type="submit" class="btn-submit btn btn-primary">Save</button>
</div>