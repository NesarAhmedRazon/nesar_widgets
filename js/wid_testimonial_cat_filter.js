let containerEl = document.querySelector(".tallyfy_containers");
let url = window.location.href;
if (url.includes("?")) {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const category = urlParams.get("cat");
  if (category !== null) {
    let item = document.querySelector("." + category);
    if (containerEl && item !== null) {
      let mixer = mixitup(containerEl, {
        load: {
          filter: "." + category,
        },
      });
    } else {
      if (containerEl) {
        let mixer = mixitup(containerEl);
      }
    }
  }
} else {
  if (containerEl) {
    let mixer = mixitup(containerEl);
  }
}
