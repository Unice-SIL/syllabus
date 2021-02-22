$( document ).ready( function( ) {
    window.onscroll = function () {stickyMenu()};

    let navbar = document.getElementById("student-sidebar");

    if (navbar)
    {
        let sticky = navbar.offsetTop;
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