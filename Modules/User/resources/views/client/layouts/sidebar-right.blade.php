<div class="row ">
    <div class="col-lg-12">
        <div class="li-blog-single-item pb-30 pt-25">
            <h4 class="title-form-profile">Cập nhập</h4>

            <div class="security-phone pb-30">
                <div class="security-phone-item">
                    <span><i class="fas fa-phone-volume"></i> Số điện thoại | <a class="update-but-profile" href="{{ route('client.profile.phone') }}"> Cập nhập</a></span>
                </div>
                <div class="security-phone-item-update">
                   <span> {{ Auth::user()->phone }}</span>
                </div>
            </div>
            <div class="security-email">
                <div class="security-email-item">
                    <span><i class="fas fa-envelope"></i> Email | <a class="update-but-profile" href="{{ route('client.profile.email') }}">Cập nhập</a></span>
                </div>
                <div class="security-email-item-update">
                    <span>{{ Auth::user()->email }}</span>
                </div>
            </div>

        </div>
    </div>
</div>
