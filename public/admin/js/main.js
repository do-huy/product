// === Left sidebar js ===

$(document).on('click', '#sidebar li', function() {
    $(this).addClass('active').siblings().removeClass('active')
});

// === Left menu sidebar dp toggle js ===

$('.sub-menu ul').hide();
$(".sub-menu a").click(function() {
    $(this).parent(".sub-menu").children("ul").slideToggle("100");
    $(this).find(".right").toggleClass("fa-caret-up fa-caret-down")
});

// === Sidebar toggle ===
$(document).ready(function() {
    $("#toggleSidebar").click(function() {
        $(".left-menu").toggleClass("hide");
        $(".content-wrapper").toggleClass("hide");
    });
});


// === Datatables ===
$(document).ready( function () {
    $('#order-table').DataTable();
} );
