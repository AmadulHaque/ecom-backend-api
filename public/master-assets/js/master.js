(() => {
  "use strict";
  const forms = document.querySelectorAll(".needs-validation");
  Array.from(forms).forEach((form) => {
    form.addEventListener(
      "submit",
      (event) => {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add("was-validated");
      },
      false
    );
  });
})();

// table cell width js code
document.querySelectorAll(".cell").forEach(function (cell) {
  const width = cell.getAttribute("data-width");
  if (width) {
    cell.style.width = width;
  }
});
// table cell width js code

// select box js code

$(document).ready(function () {
  $(".custom-select2").select2({
    theme: "bootstrap-5",
  });
  $(".custom-select2").on("select2:open", function (e) {
    $(".select2-search__field").get(0).focus();
  });
});
$(document).ready(function () {
  $(".custom-dropdown2").select2({
    theme: "bootstrap-5",
  });
  $(".custom-dropdown2").on("select2:open", function (e) {
    $(".select2-search__field").css("display", "none");
  });
});
$(".manyselect2").select2({
  theme: "bootstrap-5",
});
// select box js code

// description and summery js code
$("#summernote").summernote({
  placeholder: "Description..",
  tabsize: 2,
  height: 100,
});
$("#summery").summernote({
  placeholder: "summery..",
  tabsize: 2,
  height: 100,
});
// description and summery js code

// choice select js code

document.querySelectorAll(".choices-select").forEach(function (select) {
  new Choices(select, {
    searchEnabled: false,
    itemSelectText: "",
  });
});

// choice select js code

$(document).ready(function () {
  $(".modal-select2").select2({
    theme: "bootstrap-5",
    dropdownParent: $("#usermodalform"),
  });
  $(".modal-select2").on("select2:open", function (e) {
    $(".select2-search__field").get(0).focus();
  });
});
