@extends('client.master')
@section('css')
<link rel="stylesheet" href="{{ asset('client/css/product/detail.css') }}">
@endsection
@section('content')
   <!-- Begin Li's Breadcrumb Area -->
   <div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="active">Chi tiết sản phẩm</li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->
<!-- content-wraper start -->
<div class="content-wraper">
    <div class="container">
        <div class="row single-product-area">
            <div class="col-lg-5 col-md-6">
               <!-- Product Details Left -->
                <div class="product-details-left">
                    <div class="product-details-images slider-navigation-1 xzoom-container">

                        <div class="div-img-product lg-image">
                            @if(empty($productItemSelected))
                            <a class="popup-img venobox vbox-item" data-fancybox="gallery" data-caption="{{ $product->name }}"
                                href="{{$product->getFirstMediaUrl('product') ?: asset('client/images/product/default-product.png')}}">
                                <img src="{{$product->getFirstMediaUrl('product') ?: asset('images/product/default-product.png')}}" class="xzoom" alt="product image">
                            </a>
                            @else
                            @php $mediaSelected = $productItemSelected->medias->first(); @endphp
                            <a class="popup-img venobox vbox-item" data-fancybox="gallery" data-caption="{{ $product->name }}"
                                href="{{$mediaSelected ? $mediaSelected->getUrl() : ($product->getFirstMediaUrl('product') ?: asset('images/product/default-product.png'))}}">
                                <img src="{{$mediaSelected ? $mediaSelected->getUrl() : ($product->getFirstMediaUrl('product') ?: asset('images/product/default-product.png'))}}" class="xzoom" alt="product image">
                            </a>
                            @endif
                        </div>

                    </div>

                    <div class="product-details-thumbs slider-thumbs-1">
                        {{-- <div class="sm-image"><img src="{{ asset('client/images/product/small-size/1.jpg') }}" alt="product image thumb"></div> --}}


                        @if (!$product->productItems->count())
                        @foreach($product->getMedia('products') as $media)
                        <div class="sm-image src-pro-variant">
                            {{-- <a data-caption="{{ $product->name }}"> --}}
                                <img class="xzoom-gallery" src="{{ ($media->getUrl()) }}">
                            {{-- </a> --}}
                        </div>
                        @endforeach
                        @else
                        @php
                        $hasShowMedia = [];
                        @endphp
                        @foreach ($product->productItems as $productItem)
                        @php
                        $variantOption = $productItem->variantOptions->first(function($vo) use ($productItem) {
                        return $vo->id == $productItem->first_variant_option_id;
                        });

                        $media = $variantOption->media->first();
                        @endphp
                        @if (in_array($variantOption->id, $hasShowMedia))
                        @continue
                        @endif
                        @php $hasShowMedia[] = $variantOption->id; @endphp
                        <div class="sm-image src-pro-variant" data-variant-option="{{ $variantOption->value }}">
                            {{-- <a data-caption="{{ $product->name }}"> --}}
                                <img class="xzoom-gallery"
                                    src="{{ $media ? $media->getUrl() : asset('images/product/default-product.png') }}">
                            {{-- </a> --}}
                        </div>
                        @endforeach
                        @endif

                    </div>
                </div>
                <!--// Product Details Left -->
            </div>

            <div class="col-lg-7 col-md-6">
                <div class="product-details-view-content pt-30">
                    <form id="create-cart">
                        <div class="product-info">
                            <h2>{{ $product->name }}</h2>
                            <span class="product-details-ref">Cửa hàng: {{ $product->seller->name }}</span>
                            <div class="rating-box pt-20">
                                <ul class="rating rating-with-review-item">
                                    <li><i class="fa fa-star-o"></i></li>
                                    <li><i class="fa fa-star-o"></i></li>
                                    <li><i class="fa fa-star-o"></i></li>
                                    <li><i class="fa fa-star-o"></i></li>
                                    <li><i class="fa fa-star-o"></i></li>
                                    <li class="review-item"><a>Yêu thích</a></li>
                                </ul>
                            </div>
                            <div class="price-pro">
                                @php
                                $comparativePrice = $productItemSelected
                                ? $productItemSelected->comparative_price_text
                                : $product->comparative_price_text;

                                $price = $productItemSelected
                                ? $productItemSelected->priceText
                                : $product->priceText;

                                $discount = $productItemSelected
                                ? $productItemSelected->comparativePriceDiscount
                                : $product->comparativePriceDiscount;
                                @endphp
                                <span class="comparative-price {{ !$comparativePrice ? 'hidden' : '' }}">
                                    {{ $comparativePrice }}
                                </span>
                                <span class="price">
                                    {{ $price }}
                                </span>
                                <span class="percentage-reduction {{ !$discount ? 'hidden' : '' }}">
                                    <span>{{$discount}}</span>% giảm
                                </span>

                            </div>

                            <div class="variant-pro">
                                @foreach($product->variants as $variantIndex => $variant)
                                <div class="div-variant">
                                    <span class="name-variant">{{ $variant->name }}</span>
                                    <div class="variant-option">
                                        @foreach($variant->variantOptions as $variantOption)
                                        <button onclick="selectVariantOption(this)" data-variant-index="{{ $variantIndex }}"
                                            data-variant-option="{{ $variantOption->value }}" type="button"
                                            class="button-variant-option {{ !empty($variantQuery[$variantIndex]) && $variantOption->value == $variantQuery[$variantIndex] ? 'variant-selected' : '' }}">
                                            {{ $variantOption->value }}
                                        </button>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            {{-- <div class="product-desc">
                                <p>
                                    <span>100% cotton double printed dress. Black and white striped top and orange high waisted skater skirt bottom. Lorem ipsum dolor sit amet, consectetur adipisicing elit. quibusdam corporis, earum facilis et nostrum dolorum accusamus similique eveniet quia pariatur.
                                    </span>
                                </p>
                            </div> --}}
                            {{-- <div class="product-variants">
                                <div class="produt-variants-size">
                                    <label>Dimension</label>
                                    <select class="nice-select">
                                        <option value="1" title="S" selected="selected">40x60cm</option>
                                        <option value="2" title="M">60x90cm</option>
                                        <option value="3" title="L">80x120cm</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="single-add-to-cart">
                                {{-- <form action="#" class="cart-quantity"> --}}
                                    <div class="quantity">
                                        <label>Số lượng</label>
                                        <div class="cart-plus-minus">
                                            <input id="amount-product-input" class="cart-plus-minus-box" value="1" type="text">
                                            <div class="dec qtybutton"><i class="fa fa-angle-down"></i></div>
                                            <div class="inc qtybutton"><i class="fa fa-angle-up"></i></div>
                                        </div>


                                    </div>
                                    <div class="cls-quantity">
                                        <span>
                                            {{ $productItemSelected ? $productItemSelected->quantity : $product->quantity}}
                                        </span>
                                        sản phẩm có sẵn
                                        <input id="product-item-id" type="number" class="hidden"
                                        value="{{$productItemSelected ? $productItemSelected->id : ''}}">
                                    </div>
                                    <div>
                                        @auth
                                            <button class="add-to-cart add-cart-product" type="button" data-id="{{$product->id}}">Thêm vào giỏ hàng</button>
                                        @else
                                            <a href="{{ route('login') }}">
                                                <button class="add-to-cart add-cart-product-no-login" type="button">Thêm vào giỏ hàng</button>
                                            </a>
                                        @endauth
                                    </div>
                                {{-- </form> --}}
                            </div>
                            <div class="product-additional-info pt-25">
                                <a class="wishlist-btn" href="wishlist.html"><i class="fa fa-heart-o"></i>Add to wishlist</a>
                                <div class="product-social-sharing pt-25">
                                    <ul>
                                        <li class="facebook"><a href="#"><i class="fa fa-facebook"></i>Facebook</a></li>
                                        <li class="twitter"><a href="#"><i class="fa fa-twitter"></i>Twitter</a></li>
                                        <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i>Google +</a></li>
                                        <li class="instagram"><a href="#"><i class="fa fa-instagram"></i>Instagram</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="block-reassurance">
                                <ul>
                                    <li>
                                        <div class="reassurance-item">
                                            <div class="reassurance-icon">
                                                <i class="fa fa-check-square-o"></i>
                                            </div>
                                            <p>Security policy (edit with Customer reassurance module)</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="reassurance-item">
                                            <div class="reassurance-icon">
                                                <i class="fa fa-truck"></i>
                                            </div>
                                            <p>Delivery policy (edit with Customer reassurance module)</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="reassurance-item">
                                            <div class="reassurance-icon">
                                                <i class="fa fa-exchange"></i>
                                            </div>
                                            <p> Return policy (edit with Customer reassurance module)</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wraper end -->
<!-- Begin Product Area -->
<div class="product-area pt-35">
    <div class="container">
        <div class="description-pro">
            <div class="title-description-pro">Mô tả sản phẩm</div>
            <ul>
                <li>{!! $product->content !!}</li>
            </ul>
            <div class="toggle_btn">
                <div class="toggle_btns">
                    <span class="toggle_text">Xem thêm nội dung</span>
                    <span class="arrow"><i class="fas fa-angle-down"></i> </span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product Area End Here -->
<!-- Begin Li's Laptop Product Area -->
<section class="product-area li-laptop-product pt-30 pb-50">
    <div class="container">
        <div class="row">
            <!-- Begin Li's Section Area -->
            <div class="col-lg-12">
                <div class="li-section-title">
                    <h2>
                        <span>15 other products in the same category:</span>
                    </h2>
                </div>
                <div class="row">
                    <div class="product-active owl-carousel">
                        <div class="col-lg-12">
                            <!-- single-product-wrap start -->
                            <div class="single-product-wrap">
                                <div class="product-image">
                                    <a href="single-product.html">
                                        <img src="{{ asset('client/images/product/large-size/1.jpg') }}" alt="Li's Product Image">
                                    </a>
                                    <span class="sticker">New</span>
                                </div>
                                <div class="product_desc">
                                    <div class="product_desc_info">
                                        <div class="product-review">
                                            <h5 class="manufacturer">
                                                <a href="product-details.html">Graphic Corner</a>
                                            </h5>
                                            <div class="rating-box">
                                                <ul class="rating">
                                                    <li><i class="fa fa-star-o"></i></li>
                                                    <li><i class="fa fa-star-o"></i></li>
                                                    <li><i class="fa fa-star-o"></i></li>
                                                    <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                    <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <h4><a class="product_name" href="single-product.html">Accusantium dolorem1</a></h4>
                                        <div class="price-box">
                                            <span class="new-price">$46.80</span>
                                        </div>
                                    </div>
                                    <div class="add-actions">
                                        <ul class="add-actions-link">
                                            <li class="add-cart active"><a href="#">Add to cart</a></li>
                                            <li><a href="#" title="quick view" class="quick-view-btn" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-eye"></i></a></li>
                                            <li><a class="links-details" href="wishlist.html"><i class="fa fa-heart-o"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- single-product-wrap end -->
                        </div>
                        <div class="col-lg-12">
                            <!-- single-product-wrap start -->
                            <div class="single-product-wrap">
                                <div class="product-image">
                                    <a href="single-product.html">
                                        <img src="{{ asset('client/images/product/large-size/2.jpg') }}" alt="Li's Product Image">
                                    </a>
                                    <span class="sticker">New</span>
                                </div>
                                <div class="product_desc">
                                    <div class="product_desc_info">
                                        <div class="product-review">
                                            <h5 class="manufacturer">
                                                <a href="product-details.html">Studio Design</a>
                                            </h5>
                                            <div class="rating-box">
                                                <ul class="rating">
                                                    <li><i class="fa fa-star-o"></i></li>
                                                    <li><i class="fa fa-star-o"></i></li>
                                                    <li><i class="fa fa-star-o"></i></li>
                                                    <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                    <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <h4><a class="product_name" href="single-product.html">Mug Today is a good day</a></h4>
                                        <div class="price-box">
                                            <span class="new-price new-price-2">$71.80</span>
                                            <span class="old-price">$77.22</span>
                                            <span class="discount-percentage">-7%</span>
                                        </div>
                                    </div>
                                    <div class="add-actions">
                                        <ul class="add-actions-link">
                                            <li class="add-cart active"><a href="#">Add to cart</a></li>
                                            <li><a href="#" title="quick view" class="quick-view-btn" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-eye"></i></a></li>
                                            <li><a class="links-details" href="wishlist.html"><i class="fa fa-heart-o"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- single-product-wrap end -->
                        </div>
                        <div class="col-lg-12">
                            <!-- single-product-wrap start -->
                            <div class="single-product-wrap">
                                <div class="product-image">
                                    <a href="single-product.html">
                                        <img src="{{ asset('client/images/product/large-size/3.jpg') }}" alt="Li's Product Image">
                                    </a>
                                    <span class="sticker">New</span>
                                </div>
                                <div class="product_desc">
                                    <div class="product_desc_info">
                                        <div class="product-review">
                                            <h5 class="manufacturer">
                                                <a href="product-details.html">Graphic Corner</a>
                                            </h5>
                                            <div class="rating-box">
                                                <ul class="rating">
                                                    <li><i class="fa fa-star-o"></i></li>
                                                    <li><i class="fa fa-star-o"></i></li>
                                                    <li><i class="fa fa-star-o"></i></li>
                                                    <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                    <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <h4><a class="product_name" href="single-product.html">Accusantium dolorem1</a></h4>
                                        <div class="price-box">
                                            <span class="new-price">$46.80</span>
                                        </div>
                                    </div>
                                    <div class="add-actions">
                                        <ul class="add-actions-link">
                                            <li class="add-cart active"><a href="#">Add to cart</a></li>
                                            <li><a href="#" title="quick view" class="quick-view-btn" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-eye"></i></a></li>
                                            <li><a class="links-details" href="wishlist.html"><i class="fa fa-heart-o"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- single-product-wrap end -->
                        </div>
                        <div class="col-lg-12">
                            <!-- single-product-wrap start -->
                            <div class="single-product-wrap">
                                <div class="product-image">
                                    <a href="single-product.html">
                                        <img src="{{ asset('client/images/product/large-size/4.jpg') }}" alt="Li's Product Image">
                                    </a>
                                    <span class="sticker">New</span>
                                </div>
                                <div class="product_desc">
                                    <div class="product_desc_info">
                                        <div class="product-review">
                                            <h5 class="manufacturer">
                                                <a href="product-details.html">Studio Design</a>
                                            </h5>
                                            <div class="rating-box">
                                                <ul class="rating">
                                                    <li><i class="fa fa-star-o"></i></li>
                                                    <li><i class="fa fa-star-o"></i></li>
                                                    <li><i class="fa fa-star-o"></i></li>
                                                    <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                    <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <h4><a class="product_name" href="single-product.html">Mug Today is a good day</a></h4>
                                        <div class="price-box">
                                            <span class="new-price new-price-2">$71.80</span>
                                            <span class="old-price">$77.22</span>
                                            <span class="discount-percentage">-7%</span>
                                        </div>
                                    </div>
                                    <div class="add-actions">
                                        <ul class="add-actions-link">
                                            <li class="add-cart active"><a href="#">Add to cart</a></li>
                                            <li><a href="#" title="quick view" class="quick-view-btn" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-eye"></i></a></li>
                                            <li><a class="links-details" href="wishlist.html"><i class="fa fa-heart-o"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- single-product-wrap end -->
                        </div>
                        <div class="col-lg-12">
                            <!-- single-product-wrap start -->
                            <div class="single-product-wrap">
                                <div class="product-image">
                                    <a href="single-product.html">
                                        <img src="{{ asset('client/images/product/large-size/5.jpg') }}" alt="Li's Product Image">
                                    </a>
                                    <span class="sticker">New</span>
                                </div>
                                <div class="product_desc">
                                    <div class="product_desc_info">
                                        <div class="product-review">
                                            <h5 class="manufacturer">
                                                <a href="product-details.html">Graphic Corner</a>
                                            </h5>
                                            <div class="rating-box">
                                                <ul class="rating">
                                                    <li><i class="fa fa-star-o"></i></li>
                                                    <li><i class="fa fa-star-o"></i></li>
                                                    <li><i class="fa fa-star-o"></i></li>
                                                    <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                    <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <h4><a class="product_name" href="single-product.html">Accusantium dolorem1</a></h4>
                                        <div class="price-box">
                                            <span class="new-price">$46.80</span>
                                        </div>
                                    </div>
                                    <div class="add-actions">
                                        <ul class="add-actions-link">
                                            <li class="add-cart active"><a href="#">Add to cart</a></li>
                                            <li><a href="#" title="quick view" class="quick-view-btn" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-eye"></i></a></li>
                                            <li><a class="links-details" href="wishlist.html"><i class="fa fa-heart-o"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- single-product-wrap end -->
                        </div>
                        <div class="col-lg-12">
                            <!-- single-product-wrap start -->
                            <div class="single-product-wrap">
                                <div class="product-image">
                                    <a href="single-product.html">
                                        <img src="{{ asset('client/images/product/large-size/6.jpg') }}" alt="Li's Product Image">
                                    </a>
                                    <span class="sticker">New</span>
                                </div>
                                <div class="product_desc">
                                    <div class="product_desc_info">
                                        <div class="product-review">
                                            <h5 class="manufacturer">
                                                <a href="product-details.html">Studio Design</a>
                                            </h5>
                                            <div class="rating-box">
                                                <ul class="rating">
                                                    <li><i class="fa fa-star-o"></i></li>
                                                    <li><i class="fa fa-star-o"></i></li>
                                                    <li><i class="fa fa-star-o"></i></li>
                                                    <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                    <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <h4><a class="product_name" href="single-product.html">Mug Today is a good day</a></h4>
                                        <div class="price-box">
                                            <span class="new-price new-price-2">$71.80</span>
                                            <span class="old-price">$77.22</span>
                                            <span class="discount-percentage">-7%</span>
                                        </div>
                                    </div>
                                    <div class="add-actions">
                                        <ul class="add-actions-link">
                                            <li class="add-cart active"><a href="#">Add to cart</a></li>
                                            <li><a href="#" title="quick view" class="quick-view-btn" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-eye"></i></a></li>
                                            <li><a class="links-details" href="wishlist.html"><i class="fa fa-heart-o"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- single-product-wrap end -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Li's Section Area End Here -->
        </div>
    </div>
    @include('client.cart.layouts.errors')
</section>
<!-- Li's Laptop Product Area End Here -->
@endsection
@section('js')
<!-- jquery -->
<script>
    const PRODUCT = {!! json_encode($product) !!}
    const PRODUCT_ITEMS = {!! json_encode($product->productItems) !!}
    const VARIANTS = {!! json_encode($product->variants) !!}
    const DEFAULT_IMAGE = "{{$product->getFirstMediaUrl('product') ?: asset('client/images/no-image.png')}}"
    const variantQuery = {!! json_encode($variantQuery) !!}
</script>
<script src="{{ asset('client/js/error.js') }}"></script>
<script src="{{ asset('client/js/cart/cart.js') }}"></script>
<script src="{{ asset('client/js/product/product.js') }}"></script>
<script>
    $(document).ready(function(){
        $(".toggle_btn").click(function(){
            $(this).toggleClass("active");
            $(this).parent().toggleClass("active");
            if($(".toggle_btn").hasClass("active")){
                $(".toggle_text").text("Thu gọn nội dung")
            }
            else{
                $(".toggle_text").text("Xem thêm nội dung")
            }
        })
    });
</script>
@endsection
