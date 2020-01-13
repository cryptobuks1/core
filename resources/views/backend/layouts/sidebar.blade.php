<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ url('/').$settings['backendlogo'] }}" alt="Administrator">
    </a>
<div class="clearfix"></div>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ url($backendUrl)}}" id="dashboard" class="nav-link ">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>Bảng quản trị

                        </p>
                    </a>
                </li>

                <!-- News -->
                <li class="nav-item has-treeview">
                    <a href="{{ url($backendUrl.'/news') }}" id="users" class="nav-link">
                        <i class="nav-icon fa fa-newspaper-o"></i>
                        <p>Tin tức</p>
                    </a>
                </li>


                <!-- User -->
                <li class="nav-item has-treeview">
                    <a href="{{ url($backendUrl.'/users') }}" id="users" class="nav-link">
                        <i class="nav-icon fa fa-users"></i>
                        <p>Tài khoản <i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/users') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Người dùng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/groups') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Nhóm</p>
                            </a>
                        </li>
                        @role("SUPER_ADMIN")
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/admins') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Quản trị</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/roles') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Vai trò</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/permissions') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Quyền hạn</p>
                            </a>
                        </li>
                            @endrole
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/login-logs') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Lịch sử đăng nhập</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <!-- Wallet-->
                <li class="nav-item has-treeview">
                    <a href="#" id="users" class="nav-link">
                        <i class="nav-icon fa fa-google-wallet"></i>
                        <p>Ví điện tử<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/wallets') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Danh sách ví</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/wallet/orderdeposit') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Đơn nạp tiền</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/wallet/orderwithdraw') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Đơn rút tiền</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/transaction') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Lịch sử ví</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/transfer-history') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Lịch sử chuyển tiền</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/wallet-settings') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Cấu hình ví</p>
                            </a>
                        </li>

                    </ul>
                </li>


                <!-- Localbank-->
                <li class="nav-item has-treeview">
                    <a href="#" id="users" class="nav-link">
                        <i class="nav-icon fa fa-university"></i>
                        <p>Ngân hàng<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/localbank') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Của hệ thống</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/localbank/users') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Của khách hàng</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- SMS-->
                <li class="nav-item has-treeview">
                    <a href="#" id="users" class="nav-link">
                        <i class="nav-icon fa fa-envelope"></i>
                        <p>SMS<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/sms') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Lịch sử SMS</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/sms/provider') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Cấu hình SMS</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/sms/telco') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Quản lý nhà mạng</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @role("SUPER_ADMIN")
                <!-- Công cụ-->
                <li class="nav-item has-treeview">
                    <a href="#" id="users" class="nav-link">
                        <i class="nav-icon fa fa-wrench"></i>
                        <p>Công cụ<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/seo') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Seo onepage</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/tools') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Xóa dữ liệu</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/#') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Sitemap</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/feeds') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Feeds</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole

                @role("SUPER_ADMIN")
                <!-- Other Module-->
                <li class="nav-item has-treeview">
                    <a href="#" id="users" class="nav-link">
                        <i class="nav-icon fa fa-cubes"></i>
                        <p>Mô-đun khác<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/chargings/matches') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Khớp thẻ</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/menu') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Menu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/pages') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Trang tĩnh</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/sliders') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Trình diễn ảnh</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/webdata') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Webdata</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/categories') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Categories</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/weblinks') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Trao đổi banner</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/merchants') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Đối tác kết nối</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole
                @role("SUPER_ADMIN")
                <!-- Setting -->
                <li class="nav-item has-treeview">
                    <a href="#" id="users" class="nav-link">
                        <i class="nav-icon fa fa-cog"></i>
                        <p>Cấu hình hệ thống<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/settings/general') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Cài đặt</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/currencies') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Tiền tệ</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/paygates') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Cổng thanh toán</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/medias') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Thư viện ảnh</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/seo') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Seo onpage</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/language') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Ngôn ngữ</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/sendmail/setting') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Cấu hình mail</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/tagslist') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Tags</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole
                <li class="nav-item has-treeview">
                    <a href="#" id="users" class="nav-link">
                        <i class="nav-icon fa fa-cog"></i>
                        <p>Vị Trí<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/localisation/country') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Quốc gia</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/localisation/city') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Tỉnh/Thành phố</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/localisation/provinces') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Quận/Huyện</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" id="users" class="nav-link">
                        <i class="nav-icon fa fa-cog"></i>
                        <p>DownLoads<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/downloads/danh-muc') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Danh mục</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/downloads/') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>File download</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" id="users" class="nav-link">
                        <i class="nav-icon fa fa-cog"></i>
                        <p>Địa ốc<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/type/index') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Phân loại</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/realestates/index') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Thông tin bài đăng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/realestates/order') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Order</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/vip/index') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Vip</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/group/index') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Nhóm dự án</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/project/index') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Dự án</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/broker/index') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Môi Giới</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/search/index') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Search</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" id="users" class="nav-link">
                        <i class="nav-icon fa fa-cog"></i>
                        <p>Tiki<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/tiki/category') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/tiki/product') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Product</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" id="users" class="nav-link">
                        <i class="nav-icon fa fa-cog"></i>
                        <p>Quản lý quỹ<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/fund/index') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Tài khoản quỹ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/fund/list-order') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Tạo phiếu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/fund/reason/index') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Lý do</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" id="users" class="nav-link">
                        <i class="nav-icon fa fa-cog"></i>
                        <p>Tour du lịch<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/tour/') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Tour</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/tour/type') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Loại tour</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/tour/service/') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Dịch vụ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/tour/place/') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Địa điểm du lịch</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" id="users" class="nav-link">
                        <i class="nav-icon fa fa-cog"></i>
                        <p>Khách sạn<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/hotel/') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Hotel</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" id="users" class="nav-link">
                        <i class="nav-icon fa fa-cog"></i>
                        <p>Đặt vé máy bay<i class="right fa fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/flight/') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Đặt vé</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/flight/airline') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Hãng bay</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/flight/station') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Sân bay</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url($backendUrl.'/flight/route') }}" class="nav-link">
                                <i class="fa fa-angle-right nav-icon"></i>
                                <p>Đường bay</p>
                            </a>
                        </li>

                    </ul>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
