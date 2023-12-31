<div class="slider-with-banner">
    <div class="container">
        <div class="row">
            <!-- Begin Slider Area -->
            <div class="col-lg-8 col-md-8">
                <div class="slider-area">
                    <div class="slider-active owl-carousel">
                        <!-- Begin Single Slide Area -->
                        @foreach($carousels as $carousel)
                        <div class="single-slide align-center-left  animation-style-01 bg-1" style="background-image: url({{ $carousel->getFirstMediaUrl('carousel')  ?: asset('client/images/no-image.png') }});">
                            <div class="slider-progress"></div>
                            <div class="slider-content">
                                <h5>Ưu đãi giảm giá <span>freeship</span> tuần này</h5>
                                <h2>Tất cả sản phẩm</h2>
                                <h3>Giảm <span>20%</span></h3>
                                <div class="default-btn slide-btn">
                                    <a class="links" href="{{ $carousel->link }}">Mua ngay</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <!-- Single Slide Area End Here -->
                    </div>
                </div>
            </div>
            <!-- Slider Area End Here -->
            <!-- Begin Li Banner Area -->
            <div class="col-lg-4 col-md-4 text-center pt-xs-30">
                <div class="li-banner">
                    <a href="#">
                        <img src="{{ asset('client/images/banner/banner.png') }}" alt="">
                    </a>
                </div>
                <div class="li-banner mt-15 mt-sm-30 mt-xs-30">
                    <a href="#">
                        <img src="{{ asset('client/images/banner/banner3.png') }}" alt="">
                    </a>
                </div>
            </div>
            <!-- Li Banner Area End Here -->
        </div>
    </div>
</div>


<section class="category-home">
    <div class="container">
        <div class="title-category-home">
            <h3>Danh mục</h3>
        </div>
        <div class="category-slider">
            <div class="swiper-wrapper">
                @foreach($categories as $category)
                <div class="item-category">
                    <a href="">
                        <div class="item">
                            <img class="size" class="size" src="{{ $category->getFirstMediaUrl('category') ?:  asset('client/images/no-image.png') }} " alt="">
                            <h5>{{ $category->name }}</h5>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</section>
