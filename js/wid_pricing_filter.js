let priceTable = document.getElementsByClassName("priceTable");
let filter = document.getElementsByClassName("filter");
// filter.addEventListener("click", startFilter);

for (var i = 0; i < filter.length; i++) {
  filter[i].addEventListener(
    "click",
    function () {
      let filterID = this.id;
      this.classList.add("active");
      let priceList = priceTable[0].firstChild;
      let filterNode = this.parentNode.firstChild;

      do {
        if (filterNode.nodeType === 3) continue; // text node
        if (filterNode.id == filterID) filterNode.classList.add("active");
        if (filterNode.id != filterID) filterNode.classList.remove("active");
      } while ((filterNode = filterNode.nextSibling));

      do {
        if (priceList.nodeType === 3) continue; // text node
        if (!priceList.hasAttribute("id")) continue;
        if (priceList.id == filterID) priceList.classList.add("active");
        if (priceList.id !== filterID) priceList.classList.remove("active");
      } while ((priceList = priceList.nextSibling));
    },
    true
  );
}
