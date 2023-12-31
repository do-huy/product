$(function (){
    $('.swiper-wrapper').slick({
        dots: false,
        infinite: false,
        speed: 700,
        slidesToShow: 6,
        slidesToScroll: 6,
        prevArrow: '<i class="fas fa-angle-left left_arrow">',
        nextArrow: '<i class="fas fa-angle-right right_arrow">',
        responsive: [
            {
                breakpoint: 992,
                settings: {
                slidesToShow: 4,
                slidesToScroll: 4,
                infinite: true,
                dots: false
                }
            },
            {
                breakpoint: 768,
                settings: {
                slidesToShow: 4,
                slidesToScroll: 4
                }
            },
            {
                breakpoint: 476,
                settings: {
                slidesToShow: 3,
                slidesToScroll: 3
                }
            },
            {
                breakpoint: 390,
                settings: {
                slidesToShow: 2,
                slidesToScroll: 2
                }
            },
        ]
    });
});
