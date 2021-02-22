$( document ).ready( function( ) {
    let sticky = "";
    let navbar = document.getElementById("student-sidebar");

    if (navbar)
    {
        sticky = navbar.offsetTop;
        window.onscroll = function () {stickyMenu()};
    }

    function stickyMenu() {
        if (sticky) {
            if (window.pageYOffset >= sticky) {
                navbar.classList.add("sticky");
            } else {
                navbar.classList.remove("sticky");
            }
        }
    }
});