<div class="col-md-12">
    <div class="form-group">
        <label for="title">Name:</label>
        <input name="id" type="hidden" class="form-control" value="{{ $id }}" />
        <input name="name" type="text" class="form-control" id="name" placeholder="Menu Name" @if(isset($menu)) value="{{ $menu->name }}" @endif />
    </div>

    <div class="form-group">
        <label for="title">Link:</label>
        <input name="url" type="text" class="form-control" id="url" placeholder="Menu Link" @if(isset($menu)) value="{{ $menu->url }}" @endif />
    </div>

    @if(!isset($menu) || (isset($menu) && $menu->parent_id==0))
    <div class="form-group">
        <label for="menu_type">Menu type:</label>
        <select class="form-control" name="menu_type" id="menu_type">
            <option value="">-- Select menu type --</option>
            @foreach(config('menu.type') as $type)
                <option value="{{ $type['value'] }}" @if(isset($menu) && $menu->menu_type==$type['value']) selected="selected" @endif>{{ $type['name'] }}</option>
            @endforeach
        </select>
    </div>
    @endif

    <div class="form-group">
        <label for="title">Parent menu:</label>
        <select class="form-control" name="parent_id" id="parent_id">
            <option value="0">-- Select parent menu --</option>
            {!! $selectHtml !!}
        </select>
    </div>

    <div class="form-group">
        <label for="title">Sort Order:</label>
        <input name="sort_order" type="text" class="form-control" id="sort_order" placeholder="Menu Position" @if(isset($menu)) value="{{ $menu->sort_order }}" @endif />
    </div>
        
    <div class="form-group">
        <label for="title">Status:</label>
        <select class="form-control" name="status" id="status">
            <option value="1" @if(isset($menu) && $menu->status==1) selected="selected" @endif>Enable</option>
            <option value="0" @if(isset($menu) && $menu->status==0) selected="selected" @endif>Disable</option>
        </select>
    </div>
</div>
<div class="col-md-12">
    <button type="submit" class="btn-submit btn btn-primary">Save</button>
</div>