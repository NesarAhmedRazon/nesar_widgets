(function ($) {
  /**
   * @param $scope The Widget wrapper element as a jQuery element
   * @param $ The jQuery alias
   */

  var TabsHandeller = function ($scope, $) {
    let wrappers = document.getElementsByClassName("tabsContainer");
    Array.from(wrappers).forEach((e, i) => {
      e.setAttribute("id", "tabs_" + i);
      let listTab = e.getElementsByClassName("tabList");

      if (listTab.length != 0) {
        Array.from(listTab).forEach((ex, ix) => {
          let tabItem = ex.getElementsByClassName("tabItem");
          if (tabItem.lenght != 0) {
            Array.from(tabItem).forEach((et, it) => {
              et.setAttribute("id", "tab_" + i + "_" + it);
              et.addEventListener("click", function () {
                let id = this.getAttribute("id");
                removeA(e, id);
                addA(e, id);
              });
            });
          }
        });
      }
      let listCont = e.getElementsByClassName("tabContents");
      if (listCont.length != 0) {
        Array.from(listCont).forEach((ey, iy) => {
          let content = ey.getElementsByClassName("content");
          if (content.lenght != 0) {
            Array.from(content).forEach((ec, ic) => {
              ec.setAttribute("id", "tab_" + i + "_" + ic);
              let title = ec.querySelector(".tabItem");
              if (title) {
                title.addEventListener("click", function () {
                  let id = this.parentNode.getAttribute("id");
                  removeA(e, id);
                  addA(e, id);
                });
              }
            });
          }
        });
      }
    });
    function removeA(el, id) {
      curEl = el.querySelectorAll(".active");
      Array.from(curEl).forEach((e) => {
        let cid = e.getAttribute("id");
        if (cid != id) {
          e.classList.remove("active");
        }
      });
    }

    function addA(el, id) {
      let setEl = el.querySelectorAll("#" + id);
      Array.from(setEl).forEach((t) => {
        t.classList.add("active");
      });
    }
  };

  // Make sure you run this code under Elementor.
  $(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/nesar_w_tab.default",
      TabsHandeller
    );
  });
})(jQuery);
