<section class="company-section section-gray">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <a class="logo-footer">
                    <img src="{{ url($settings['logo']) }}" alt="" />
                </a>
            </div>
            <div class="col-sm-5">
                <div class="addressBlock">
                    <div class="info-pg">
                        <h5 class="heading">Thông tin liên hệ</h5>
                        <div class="content">
                            <div>
                                <i class="fa fa-map-marker"></i>
                                <span>@if(isset($settings['address'])) {{ $settings['address'] }} @endif</span>
                            </div>
                            <div>
                                <i class="fa fa-envelope"> </i>
                                <span>@if(isset($settings['email'])) {{ $settings['email'] }} @endif</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="addressBlock">
                    <div class="info-pg">
                        <h5 class="heading">Điện thoại</h5>
                        <div class="content">
                            <div>
                                <i class="fa fa-phone"></i>
                                <span>@if(isset($settings['phone'])) {{ $settings['phone'] }} @endif</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>