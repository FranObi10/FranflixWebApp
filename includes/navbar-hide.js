  document.addEventListener("DOMContentLoaded", function () {
    window.onscroll = function() {
      var navbar = document.getElementById("navbar");
      var logo = document.getElementById("logo");
      if (window.pageYOffset > 0) {
        navbar.style.display = "none";
        logo.style.display = "none";
      } else {
        navbar.style.display = "block";
        logo.style.display = "block";
      }
    };
});