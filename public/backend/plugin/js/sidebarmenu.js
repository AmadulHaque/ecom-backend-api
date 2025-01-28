!(function (s) {
  "use strict";

  s("#side-menu").metisMenu(),
    s(".vertical-menu-btn").on("click", function (e) {
      e.preventDefault(),
        s("body").toggleClass("sidebar-enable"),
        992 <= s(window).width()
          ? s("body").toggleClass("vertical-collpsed")
          : s("body").removeClass("vertical-collpsed");
    }),
    s("#sidebar-menu a").each(function () {
      var e = window.location.href.split(/[?#]/)[0];
      this.href == e &&
        (s(this).addClass("active"),
        s(this).parent().addClass("mm-active"),
        s(this).parent().parent().addClass("mm-show"),
        s(this).parent().parent().prev().addClass("mm-active"),
        s(this).parent().parent().parent().addClass("mm-active"),
        s(this).parent().parent().parent().parent().addClass("mm-show"),
        s(this)
          .parent()
          .parent()
          .parent()
          .parent()
          .parent()
          .addClass("mm-active"),
        s(this)
          .parent()
          .parent()
          .parent()
          .parent()
          .parent()
          .parent()
          .addClass("mm-show"),
        s(this)
          .parent()
          .parent()
          .parent()
          .parent()
          .parent()
          .parent()
          .parent()
          .addClass("mm-active"));
    });
})(jQuery);
