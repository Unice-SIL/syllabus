window.onscroll = function () {stickyMenu()};

let navbar = document.getElementById("student-sidebar");

let sticky = navbar.offsetTop;

function stickyMenu() {
    if (window.pageYOffset >= sticky) {
        navbar.classList.add("sticky");
    }
    else {
        navbar.classList.remove("sticky");
    }

}