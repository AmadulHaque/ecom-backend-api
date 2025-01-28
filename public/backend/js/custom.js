const tooltipTriggerList = document.querySelectorAll(
  '[data-bs-toggle="tooltip"]'
);
const tooltipList = [...tooltipTriggerList].map(
  (tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl)
);

// ---Date Picker
// ---Date Picker
const getDatePickerTitle = (elem) => {
  const label = elem.nextElementSibling;
  let titleText = "";
  if (label && label.tagName === "LABEL") {
    titleText = label.textContent;
  } else {
    titleText = elem.getAttribute("aria-label") || "";
  }
  return titleText;
};

const elems = document.querySelectorAll(".datepicker_input");
for (const elem of elems) {
  const datepicker = new Datepicker(elem, {
    format: "dd-mm-yyyy",
    title: getDatePickerTitle(elem),
  });
}

// ---Date Picker
// ---Date Picker


/* ====== Mobile Left Side Bar ======= */
const sideBar = document.querySelector(".layout-left");
const leftSideBar = document.querySelector(".mobile-nav-toggler");
const sidebarBackdrop = document.querySelector(".sidebar-backdrop");

leftSideBar?.addEventListener("click", () => {
  sideBar.classList.toggle("show");
});
sidebarBackdrop?.addEventListener("click", () => {
  sideBar.classList.remove("show");
});

/* ====== Mobile Left Side Bar ======= */