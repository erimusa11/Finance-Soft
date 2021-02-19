
$(document).ready(function() {
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    var url = window.location;
    // for sidebar menu but not for treeview submenu
    $('ul.navbar-nav a').filter(function() {
        return this.href == url;
    }).parent().siblings().removeClass('active').end().addClass('active');
    // for treeview which is like a submenu
    $('ul.nav-item a').filter(function() {
            return this.href == url;
        }).parentsUntil(".navbar-nav > .nav-item").siblings().removeClass('active menu-open').end()
        .addClass('active menu-open');
});
