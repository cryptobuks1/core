@if(isset($footer_menu) && count($footer_menu))
    @foreach($footer_menu as $fmenu)
        <div class="col-md-4 col-xs-6">
            <div class="listFooter">
                <div>
                    <h3 class="title divider-bottom">{{ $fmenu['data']['name'] }}</h3>
                </div>
                @if($fmenu['data']['children_count'])
                    <ul class="list-group list-group-flush">
                        @foreach($fmenu['childs'] as $child)
                            <li><a href="{{ $child['data']['url'] }}"><i class="material-icons list-style">fiber_manual_record</i>{{ $child['data']['name'] }}
                                </a></li>
                        @endforeach
                    </ul>
                @endif

            </div>
        </div>
    @endforeach
@endif