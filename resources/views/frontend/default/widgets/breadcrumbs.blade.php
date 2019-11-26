<div class="heading-page">
    <div class="container">
        @if (isset($breadcrumbs) && count($breadcrumbs))
            <ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
                @foreach ($breadcrumbs as $key => $breadcrumb)
                    <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="{{ $breadcrumb->url }}"><span itemprop="name">{{ $breadcrumb->title }}</span></a>
                        <span itemprop="position" content="{{$key+1}}"></span>
                    </li>
                @endforeach
            </ol>
        @endif
    </div>
</div>