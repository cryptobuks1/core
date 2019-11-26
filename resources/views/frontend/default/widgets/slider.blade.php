@if(isset($sliders) && count($sliders))
    <div id="myCarousel" class="carousel slider slide" data-ride="carousel" @if(isset($settings['slide_bg'])&& $settings['slide_bg'] != '' ) style="background: {{$settings['slide_bg']}}" @else style="background: #03021d" @endif>
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="container section-slider slide">
        <div class="carousel-inner">
            @foreach($sliders as $key=> $slider)
                <div @if($key==0)class="item active" @else class="item" @endif>

                    <div class="col-sm-5 pull-right"><img src="{{asset($slider->slider_image)}}"
                                                          alt="{{ $slider->slider_name }}"/></div>
                    <div class="container">
                        <div class="caption col-sm-7">
                            <h3>{{ $slider->slider_name }}</h3>
                            <p>{{ $slider->slider_text }}</p>
                            <?php if ($slider->slider_btn_text != '') $btnTxt = $slider->slider_btn_text; else $btnTxt = 'Xem chi tiết'; ?>
                            <a href="{{ $slider->slider_btn_url }}"
                               class="btn btn-second text-uppercase">{{ $btnTxt }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        </div>
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>

@endif