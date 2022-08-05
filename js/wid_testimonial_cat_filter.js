let containerEl = document.querySelector(".tallyfy_containers");
let url = window.location.href;
if (url.includes("?")) {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const category = urlParams.get("cat");
  if (category !== null) {
    if (containerEl) {
      let mixer = mixitup(containerEl, {
        load: {
          filter: "." + category,
        },
      });
    }
  }
} else {
  if (containerEl) {
    let mixer = mixitup(containerEl);
  }
}
