<header>
    <!-- Begin Header Top Area -->
    <div class="header-top">
        <div class="container">
            <div class="row">
                <!-- Begin Header Top Left Area -->
                <div class="col-lg-3 col-md-4">
                    <div class="header-top-left">
                        <ul class="phone-wrap">
                            <li><span>Hotline:</span><a href="#"> (+84) 033 979 5553</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Header Top Left Area End Here -->
                <!-- Begin Header Top Right Area -->
                <div class="col-lg-9 col-md-8">
                    <div class="header-top-right">
                        <ul class="ht-menu">
                            <!-- Begin Setting Area -->
                            @auth
                                <li>
                                    <div class="ht-setting-trigger"><span>{{ Auth::user()->name }}</span></div>
                                    <div class="setting ht-setting">
                                        <ul class="ht-setting-list">
                                            <li><a href="{{ route('client.profile.index') }}">Quản lý tài khoản</a></li>
                                            <li><a href="{{ route('client.bill.index') }}">Đơn hàng của tôi</a></li>

                                            <li>
                                                <form method="POST" action="{{ route('logout') }}" >
                                                @csrf
                                                    <a class="logout-client" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    this.closest('form').submit();">Đăng xuất</a>
                                                </form>
                                            </li>

                                        </ul>
                                    </div>
                                </li>
                            @else
                                <li>
                                    <a  href="{{ route('login') }}"><div class=""><span>Đăng nhập</span></div></a>
                                </li>
                            @endauth
                            <!-- Setting Area End Here -->
                            <!-- Begin Language Area -->
                            <li>
                                <span class="language-selector-wrapper">Bán hàng cùng sene</span>
                            </li>
                            <!-- Language Area End Here -->
                        </ul>
                    </div>
                </div>
                <!-- Header Top Right Area End Here -->
            </div>
        </div>
    </div>
    <!-- Header Top Area End Here -->
    <!-- Begin Header Middle Area -->
    <div class="header-middle pl-sm-0 pr-sm-0 pl-xs-0 pr-xs-0">
        <div class="container">
            <div class="row">
                <!-- Begin Header Logo Area -->
                <div class="col-lg-3">
                    <div class="logo pb-sm-30 pb-xs-30">
                        <a href="{{ route('home') }}">
                            <img width="140" src="{{ asset('client/images/sene.png') }}" alt="">
                        </a>
                    </div>
                </div>
                <!-- Header Logo Area End Here -->
                <!-- Begin Header Middle Right Area -->
                <div class="col-lg-9 pl-0 ml-sm-15 ml-xs-15">
                    <!-- Begin Header Middle Searchbox Area -->
                    <form action="#" class="hm-searchbox">
                        <input type="text" placeholder="Tìm kiếm sản phẩm ...">
                        <button class="li-btn" type="submit"><i class="fa fa-search"></i></button>
                    </form>
                    <!-- Header Middle Searchbox Area End Here -->
                    <!-- Begin Header Middle Right Area -->
                    <div class="header-middle-right">
                        <ul class="hm-menu">
                            <!-- Begin Header Middle Wishlist Area -->
                            <li class="hm-wishlist">
                                <a href="wishlist.html">
                                    <span class="cart-item-count wishlist-item-count">0</span>
                                    <i class="fa fa-heart-o"></i>
                                </a>
                            </li>
                            <!-- Header Middle Wishlist Area End Here -->
                            <!-- Begin Header Mini Cart Area -->
                            <li class="hm-minicart">
                                <a href="{{ route('client.cart.detail') }}">
                                    <div class="hm-minicart-trigger-cart">
                                        <span class="item-icon"></span>
                                        <span class="item-text">Giỏ hàng
                                            <span class="cart-item-count">{{ Auth::check()? Auth::user()->amountCart :'0' }}</span>
                                        </span>
                                    </div>
                                    <span></span>
                                </a>
                            </li>
                            <!-- Header Mini Cart Area End Here -->
                        </ul>
                    </div>
                    <!-- Header Middle Right Area End Here -->
                </div>
                <!-- Header Middle Right Area End Here -->
            </div>
        </div>
    </div>
    <!-- Header Middle Area End Here -->
    <!-- Begin Header Bottom Area -->
    <div class="header-bottom header-sticky d-none d-lg-block d-xl-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Begin Header Bottom Menu Area -->
                    <div class="hb-menu">
                        <nav>
                            <ul>
                                <li class="dropdown-holder"><a href="{{ route('home') }}">Trang chủ</a></li>
                                <li class="megamenu-holder"><a href="#">Về chúng tôi</a>
                                </li>
                                <li class="dropdown-holder"><a href="#">Liên hệ</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <!-- Header Bottom Menu Area End Here -->
                </div>
            </div>
        </div>
    </div>
    <!-- Header Bottom Area End Here -->
    <!-- Begin Mobile Menu Area -->
    <div class="mobile-menu-area d-lg-none d-xl-none col-12">
        <div class="container">
            <div class="row">
                <div class="mobile-menu">
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Menu Area End Here -->
</header>
