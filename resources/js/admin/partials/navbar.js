$("#sidebarToggler").on("click", function () {
    $("#sidebar").toggleClass("sidebar-active");
    $(this).toggleClass("active");
});

$("#navbarToggler").on("click", function () {
    $(this).toggleClass("active");
});

$("#submenu-toggler").on("click", function () {
    $("#submenu-list").toggleClass("collapse");
    $("#submenu-arrow").toggleClass("sidebar-submenu__arrow--rotate");
});

$("#logout-link").on("click", function (e) {
    e.preventDefault();
    $("#logout-form").submit();
});
