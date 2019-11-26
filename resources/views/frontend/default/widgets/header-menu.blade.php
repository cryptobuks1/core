<style>
    @media (min-width: 768px) {
        .navigation ul > li:hover > ul {
            border-top: 2px solid {{ $settings['footer_bg'] }}  !important;
        }
        a.hover_item:hover {
            color: #f1f1f1;
            background: {{ $settings['footer_bg'] }}  !important;
        }
        .navigation > ul > li > a::before, .navigation > ul > li > span::before {
            background: {{ $settings['footer_bg'] }}  !important;
        }
        .navigation ul > li ul:before{
            border-bottom: 4px dashed {{ $settings['footer_bg'] }}  !important;
        }
    }

</style>

<div class="navigation nav-left">
    <ul>
        @if(isset($menu) && count($menu))
            @foreach($menu as $item)
                <li class="mb-md-3">
                    <a @if(strpos($item['data']['url'],'http')) href="{{ $item['data']['url'] }}"
                       @else href="{{ url($item['data']['url']) }}" @endif @if(isset($settings['footer_bg']) && $settings['footer_bg'] != '') style="color: {{$settings['footer_bg']}}" @endif>{{ $item['data']['name'] }}</a>@if($item['data']['children_count'] > 0)
                        <ul>
                            @foreach($item['childs'] as $child)
                                <li>
                                    <a class="hover_item" @if(strpos($child['data']['url'],'http')) href="{{ $child['data']['url'] }}"
                                       @else href="{{ url($child['data']['url']) }}" @endif >{{$child['data']['name']}}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        @endif
    </ul>
</div>

