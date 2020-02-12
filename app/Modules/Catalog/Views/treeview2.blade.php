<ul>
    @foreach($children as $child)
        <li>
            {{ $child->name }} <a href=""><i class="fa fa-edit text-primary"></i> </a>
            @if(count($child->children))
                @include('Catalog::treeview',['children' => $child->children])
            @endif
        </li>
    @endforeach
</ul>