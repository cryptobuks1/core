
@if($parent_id)
<ul class="nav nav-treeview sub-nav" style="margin-left:20px;">
@else
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" data-follow-link="true">
@endif

@if(count($root_menu))
	@foreach ($root_menu as $root)
		<li id="menu-item-{{ $root->id }}" class="nav-item @if($root->children_count) has-treeview menu-open @endif @if(!$root->status) status-disable @endif ">
			<span style="cursor:pointer;" class="nav-link @if($root->id==$selected) active @endif ">
				<p>{{ $root->name }} - {{ $root->menu_type }} @if($root->children_count)<i class="right fa fa-angle-left"></i> @endif </p>
				<a href="#" data-confirm="" title="Sửa" data-menu-id="{{ $root->id }}" data-action-type="edit" class="menu-item-action-btn float-right" style="right:35px;margin-top:-10px"><i class="ace-icon fa fa-pencil bigger-130"></i></a>
	            <a href="#" data-confirm="Delete menu: {{ $root->name }} ?"  data-menu-id="{{ $root->id }}" data-action-type="delete" title="Xoá" class="menu-item-action-btn float-right" style="right:60px;margin-top:-10px"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>
	            @if($parent_id!=0)
	            <a ref="#" data-confirm="Move up menu: {{ $root->name }} ?" data-menu-id="{{ $root->id }}" data-action-type="moveup" title="Move up" class="menu-item-action-btn float-right" style="right:85px;margin-top:-10px"><i class="ace-icon fa fa-level-up bigger-130"></i></a>
	            @endif
			</span>
			@if($root->children_count)
				{!! app('App\Modules\Menu\Controllers\MenuController')::getTreeHtml($root->id,$selected) !!}
	        @endif
		</li>
	@endforeach
@else
	<li class="nav-item">
		<p class="alert alert-info">Chưa có menu nào được tạo!!!</p>
	</li>
@endif
</ul></ul>