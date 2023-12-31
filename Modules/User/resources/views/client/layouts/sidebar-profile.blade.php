<div class="li-blog-sidebar-wrapper">
    <div class="li-blog-sidebar pt-25">
        <h4 class="li-blog-sidebar-title">Quản lý tài khoản</h4>
        <ul class="li-blog-archive">
            <li><a href="{{ route('client.profile.index') }}"><i class="fas fa-user"></i> <span class="pd-profile">Thông tin tài khoản</span></a></li>
            <li><a href="{{ route('client.profile.password') }}"><i class="fas fa-unlock-alt"></i> <span class="pd-profile">Đổi mật khẩu</span></a></li>
            <li><a href="{{ route('client.profile.address') }}"><i class="fas fa-map-marker-alt"></i> <span class="pd-profile">Sổ địa chỉ</span></a></li>
            <li><a href="#"><i class="fas fa-bell"></i> <span class="pd-profile">Thông báo (14)</span></a></li>
            <li><a href="{{ route('client.bill.index') }}"><i class="fas fa-bookmark"></i> <span class="pd-profile">Đơn hàng của bạn</span></a></li>
        </ul>
    </div>
</div>
