
// JS script to hide the navbar when I scroll down page
document.addEventListener("DOMContentLoaded", function () {
  window.onscroll = function() {
    var navbar = document.getElementById("navbar");
    var logo = document.getElementById("logo");
    var searchForm = document.getElementById("search-form");
    if (window.pageYOffset > 0) {
      navbar.style.display = "none";
      logo.style.display = "none";
      searchForm.style.display = "none";
    } else {
      navbar.style.display = "block";
      logo.style.display = "block";
      searchForm.style.display = "block";
    }
  };
});
