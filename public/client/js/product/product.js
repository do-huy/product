// Initialize the Fancybox plugin
$(function () {
    $(document).ready(function () {
        var width = 485;
        var height = 485;
        function initializeFancybox() {
            $('[data-fancybox]').fancybox({
                loop: true,
                thumbs: {
                    autoStart: true,
                },
                buttons: [
                    "zoom",
                    "share",
                    "slideShow",
                    "fullScreen",
                    // "download",
                    "thumbs",
                    "close",
                ],
                animationEffect: "zoom-in-out",
                transitionEffect: "zoom-in-out",
                width: width,
                height: height,
                autoSize: false,
            });
        }
        // Call the initializeFancybox function when the page loads
        initializeFancybox();
    });
});

$(function () {
    $(document).ready(function () {
        // This line of code declares a variable called `slickVariant` and assigns it the ID of the element with the ID `slick-variant`.
        const slickVariant = $('#slick-variant');
        // This line of code declares a variable called `prevArrow` and assigns it the HTML markup for the previous arrow
        const prevArrow = '<i class="fas fa-angle-left left_arrow">';
        // This line of code declares a variable called `nextArrow` and assigns it the HTML markup for the next arrow.
        const nextArrow = '<i class="fas fa-angle-right right_arrow">';

        // This line of code declares an object called `slickOptions` and assigns it a set of settings for the slick slider.
        const slickOptions = {
            dots: false,
            infinite: false,
            speed: 500,
            slidesToShow: 6,
            slidesToScroll: 1,
            prevArrow: prevArrow,
            nextArrow: nextArrow,
            responsive: [
                {
                    breakpoint: 986,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 7,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 500,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 432,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 350,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                    }
                },
            ]
        };

        // This line of code calls the `slick()` method on the element with the ID `slick-variant` and passes it the `slickOptions` object.
        slickVariant.slick(slickOptions);
    });
});

const selectVariantOption = (element) => {
    const option$ = $(element);
    const variantIndex = option$.data('variant-index')
    const variantOption = option$.data('variant-option')

    if (option$.hasClass('variant-selected')) {
        option$.removeClass('variant-selected');
        // variantQuery.splice(variantIndex, 1)
        variantQuery[variantIndex] = null;
    } else {
        option$.addClass('variant-selected');
        if (!variantQuery.includes(variantOption)) {
            variantQuery[variantIndex] = variantOption;
        }
    }

    setUrl();
    showProductItem();
}

const setUrl = () => {
    const urlParams = new URLSearchParams();
    for (let i = 0; i < variantQuery.length; i++) {
        if (variantQuery[i]) {
            urlParams.set(`variantQuery[${i}]`, variantQuery[i]);
        }
    }

    const url = `${window.location.origin}${window.location.pathname}?${urlParams.toString()}${window.location.hash}`;

    window.history.replaceState(null, '', decodeURIComponent(url));
}

const showProductItem = () => {
    $('#amount-product-input').val(1);
    const productItemSelected = PRODUCT_ITEMS.find(pItem => {
        return isEqual(pItem.variant_options.map(vOption => vOption.value), variantQuery);
    });

    // active option button
    $('.button-variant-option').each(function () {
        $(this).removeClass('variant-selected');
        if (variantQuery[$(this).data('variant-index')] == $(this).data('variant-option')) {
            $(this).addClass('variant-selected');
        }
    })

    if (!productItemSelected) {
        highlightImage(DEFAULT_IMAGE);
        $('#product-item-id').val('')
        $('.price-pro > span.price').text(PRODUCT.price_text)
        setComparativePrice(PRODUCT.comparative_price_text)
        setDiscount(PRODUCT.comparative_price_discount)
        return;
    }

    const variantOptionHasImage = productItemSelected.variant_options.find(
        vop => vop.id == productItemSelected.first_variant_option_id
    );
    const imageUrl = variantOptionHasImage.media[0]?.original_url ?? null;

    highlightImage(imageUrl || DEFAULT_IMAGE);

    console.log(productItemSelected);
    $('#product-item-id').val(productItemSelected.id)
    $('.price-pro > span.price').text(productItemSelected.price_text)
    setComparativePrice(productItemSelected.comparative_price_text)
    setDiscount(productItemSelected.comparative_price_discount)

    $('.cls-quantity > span').text(formatNumber(productItemSelected.quantity))
}

const isEqual = (array1, array2) => {
    if (array1.length === array2.length) {
        return array1.every(element => {
            if (array2.includes(element)) {
                return true;
            }

            return false;
        });
    }

    return false;
}

const highlightImage = (url) => {
    // image
    $('.div-img-product a').attr('href', url);
    $('.div-img-product img').attr('src', url);
}

const formatNumber = (number) => Number(number).toLocaleString('en-US', { maximumFractionDigits: 2 })

const setDiscount = (discount) => {
    if (!discount) {
        $('.price-pro > span.percentage-reduction > span').addClass('hidden');
    } else {
        $('.price-pro > span.percentage-reduction > span').removeClass('hidden');
    }

    $('.price-pro > span.percentage-reduction > span').text(discount)
}

const setComparativePrice = (comparePriceText) => {
    if (!comparePriceText) {
        $('.price-pro > span.comparative-price').addClass('hidden');
    } else {
        $('.price-pro > span.comparative-price').removeClass('hidden');
    }

    $('.price-pro > span.comparative-price').text(comparePriceText)
}

$('body').on('click', '.src-pro-variant', function () {
    $('.src-pro-variant').removeClass('on-show');
    $(this).addClass('on-show');

    const variantOption = $(this).data('variant-option');
    if (variantOption) {
        $(`.button-variant-option[data-variant-index="0"][data-variant-option="${variantOption}"]`).click();
    } else {
        highlightImage($('img', this).attr('src'));
    }
})
