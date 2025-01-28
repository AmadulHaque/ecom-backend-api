(function ($) {
  "use strict";


  // Sticky Navbar
  $(window).scroll(function () {
    if ($(this).scrollTop() > 0) {
      $(".navbar-wrapper").addClass("nav-sticky");
    } else {
      $(".navbar-wrapper").removeClass("nav-sticky");
    }
  });

  //Mobile Nav Hide Show
  if ($(".mobile-menu").length) {
    // Menu Toggle Btn for mobile-nav-toggler
    $(".mobile-nav-toggler").on("click", function () {
      // Get the nav-menu content and append it to menu-outer
      var navMenuContent = $(".app-wrapper .navbar .nav-menu").html();
      $(".mobile-menu .mobile-menu-nav .menu-outer")
        .empty()
        .append(navMenuContent);

      // Show the mobile menu
      $("body").addClass("mobile-menu-visible");
    });

    // Menu Toggle Btn for profilebtn
    $(".profile").on("click", function () {
      // Get the sidebar content and append it to menu-outer
      var sidebarContent = $(".dashboard-wrapper .sidebarMenu").html();
      $(".mobile-menu .mobile-menu-nav .menu-outer")
        .empty()
        .append(sidebarContent);

      // Show the mobile menu
      $("body").addClass("mobile-menu-visible");
    });

    // Close the mobile menu on backdrop or close button click
    $(".mobile-menu .menu-backdrop, .mobile-menu .close-btn").on(
      "click",
      function () {
        $("body").removeClass("mobile-menu-visible");
      }
    );
  }
})(jQuery);
