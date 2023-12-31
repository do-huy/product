<div class="left-menu">
    <div class="menubar-content">
        <nav class="animated bounceInDown">
            <ul id="sidebar">
                <li class="active">
                    <a href="{{ route('dashboard.index') }}"><i class="fas fa-home"></i>Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('user.index') }}"><i class="fas fa-user"></i>Tài khoản</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-street-view"></i>Vai trò</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-tools"></i>Quyền</a>
                </li>
                <li>
                    <a href="{{ route('product.index') }}"><i class="fas fa-tshirt"></i>Sản phẩm</a>
                </li>
                <li>
                    <a href="{{ route('carousel.index') }}"><i class="fas fa-sliders-h"></i></i>Carousel / Slide</a>
                </li>
                <li>
                    <a href="{{ route('category.index') }}"><i class="fas fa-grip-horizontal"></i>Danh mục</a>
                </li>
                <li>
                    <a href="{{ route('subCategory.index') }}"><i class="fas fa-grip-horizontal"></i>Danh mục phụ</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-cart-plus"></i>Đơn hàng</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-pen-alt"></i>Tạo đơn hàng</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-laptop-house"></i>Kho hàng</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-dollar-sign"></i>Thống kê</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-file-invoice-dollar"></i>Kế toán</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-ad"></i>Quảng cáo</a>
                </li>
                <li>
                    <a href="#"><i class="fas fa-ad"></i>Giao hàng nhanh [GHN]</a>
                </li>
                {{-- <li class="sub-menu">
                    <a href="#"><i class="fas fa-cogs"></i>Cài đặt
                        <div class="fa fa-caret-down right"></div>
                    </a>
                    <ul class="left-menu-dp">
                        <li><a href="#"><i class="fas fa-user-circle"></i>Tài khoản</a></li>
                        <li><a href="#"><i class="fas fa-user-circle"></i>Thông tin</a></li>
                    </ul>

                </li> --}}

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                    @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        this.closest('form').submit();">
                            <i class="fas fa-sign-out-alt"></i>Đăng xuất
                        </a>
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</div>
