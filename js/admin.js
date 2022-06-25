window.onload = function () {
  let list = document.getElementById("post_list");
  let oldselect = document.getElementById("old_type");
  let newType = document.getElementById("new_type");
  oldselect.addEventListener("change", async function (e) {
    //console.log(list.length);
    list.innerHTML = "";
    let ops = newType.getElementsByTagName("option");
    for (let i = 0; i < ops.length; i++) {
      if (ops[i].value.toLowerCase() == e.target.value.toLowerCase()) {
        ops[i].disabled = true;
      } else {
        ops[i].disabled = false;
      }
    }
    let fData = new URLSearchParams({
      action: "get_all_post",
      nonce: post_datas.nonce,
      loged_in: post_datas.is_user_logged_in,
      post_type: e.target.value,
    });

    const response = await fetch(post_datas.ajaxurl, {
      method: "POST",
      type: "POST",
      dataType: "html",
      credentials: "same-origin",
      body: fData.toString(),
      headers: new Headers({
        "Content-Type": "application/x-www-form-urlencoded",
      }),
    }).catch((error) => {
      // console.log("[WP Pageviews Plugin]");
      // console.error(error);
    });
    ///
    var data = await response.json();
    let posts = JSON.parse(JSON.stringify(data));
    if (posts.length !== 0) {
      Object.entries(posts).map((item) => {
        list.innerHTML +=
          '<div class="field_set"><input class="post" type="checkbox" name="choose_content_post" value="' +
          item[1].ID +
          '" /><label  for="choose_content_post"><strong>' +
          item[1].post_title +
          "</strong> : /" +
          item[1].post_name +
          "</label></div>";
        console.log(item[1]);
      });

      toggle_select(list);
      enable_button();
    } else {
      list.innerHTML =
        '<div class="field_set"><label >No Post Found</label></div>';
    }
  });

  function enable_button() {
    // Enable Move Button on Checked
    let checkboxes = document.getElementsByClassName("post");
    let subBtn = document.getElementById("nw_submit_button");
    for (var i = 0; i < checkboxes.length; i++) {
      checkboxes[i].addEventListener("change", function () {
        if (chck_posts(checkboxes)) {
          subBtn.disabled = false;
        } else {
          subBtn.disabled = true;
        }
      });
    }
  }
  function chck_posts(checkboxes) {
    for (var i = 0; i < checkboxes.length; i++) {
      if (checkboxes[i].checked) {
        return true;
      }
    }
  }

  // Move THe Post
  move_post();
  function move_post() {
    let subBtn = document.getElementById("nw_submit_button");
    subBtn.addEventListener("click", async function (e) {
      e.preventDefault();
      let chk = document.getElementsByClassName("post");

      let postType = newType.value;
      let post_ids = [];
      for (var i = 0; i < chk.length; i++) {
        if (chk[i].checked) {
          post_ids.push(chk[i].value);
        }
      }

      if (postType !== "disabled") {
        let fData = new URLSearchParams({
          action: "move_post",
          loged_in: post_datas.is_user_logged_in,
          post: post_ids,
          type: postType,
        });

        const response = await fetch(post_datas.ajaxurl, {
          method: "POST",
          type: "POST",
          dataType: "html",
          credentials: "same-origin",
          body: fData.toString(),
          headers: new Headers({
            "Content-Type": "application/x-www-form-urlencoded",
          }),
        }).catch((error) => {
          // console.error(error);
        });
        let data = await response.json();

        Object.entries(data).map((item) => {
          if (item[1] == "ok") {
            for (let i = 0; i < chk.length; i++) {
              if (chk[i].value == item[0]) {
                chk[i].parentNode.remove();
                subBtn.disabled = true;
              }
            }
          } else {
            alert("Problem Moving:" + item[0]);
            subBtn.disabled = false;
          }
        });
      } else {
        newType.classList.toggle("warning");
        setTimeout(function () {
          newType.classList.remove("warning"); // Hide it after the timeout
        }, 700);
      }
    });
  }

  function toggle_select(list) {
    let parent = list.parentNode;
    const selkt = document.createElement("div");
    selkt.classList.add("field_set");
    selkt.classList.add("toggler");
    selkt.innerHTML =
      '<input class="post" id="select_all" type="checkbox" name="select_all"/><label  for="choose_content_post">Select All</label>';
    parent.insertBefore(selkt, list);

    let checkboxes = document.getElementsByClassName("post");
    let inp = document.getElementById("select_all");
    inp.addEventListener("change", function () {
      for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = inp.checked;
      }
    });
  }
};
