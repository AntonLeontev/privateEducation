const polygons = document.querySelectorAll(".polygon");
const audios = document.querySelectorAll(".column__audio");
const dialog = document.getElementById("dialog1");
const buttons = document.querySelectorAll(".main__row .column .polygon button");

const menu = document.querySelector(".menu");
const drawer = document.querySelector(".drawer");
const close = document.querySelector(".close");

buttons.forEach((column) => {
    column.addEventListener("click", (e) => {
        const button = e.target.closest("button");
        const top = e.target.closest(".column").querySelector(".column__top");
        const color = getComputedStyle(top).backgroundColor;

        button.classList.remove("column__hover");
        // button.classList.add("column__active");

        // if (color.includes("233, 117, 44, 0.3")) {
        //     top.classList.add("column__top_active_1");
        // }
        // if (color.includes("125, 97, 155")) {
        //     top.classList.add("column__top_active_2");
        // }
        top.classList.remove("column__st3-active", "column__st2-active");
    });
    column.addEventListener("mouseout", (e) => {
        const button = e.target.closest("button");
        const top = e.target.closest(".column").querySelector(".column__top");

        button.classList.remove("column__active", "column__hover");
        top.classList.remove("column__top_active_2", "column__top_active_1");
    });
    column.addEventListener("mouseover", (e) => {
        const button = e.target.closest("button");
        // const top = e.target.closest(".column").querySelector(".column__top");

        button.classList.add("column__hover");
    });
});

polygons.forEach((polygon) => {
    polygon.addEventListener("mouseover", (e) => {
        const top = e.target.closest(".column").querySelector(".column__top");
        const color = getComputedStyle(top).backgroundColor;
        if (color === "rgba(233, 117, 44, 0.3)") {
            top.classList.add("column__st2-active");
        }
        if (color === "rgba(125, 97, 155, 0.3)") {
            top.classList.add("column__st3-active");
        }
    });
    polygon.addEventListener("mouseout", (e) => {
        const top = e.target.closest(".column").querySelector(".column__top");
        top.classList.remove(
            "column__st3-active",
            "column__st2-active",
            "column__st2-2-active",
            "column__st3-2-active",
            "column__st2-3-active",
            "column__st3-3-active"
        );
    });
});

menu.addEventListener("click", (e) => {
    if (drawer.classList.contains("drawer__close")) {
        drawer.classList.remove("drawer__close");
        drawer.classList.add("drawer__open");
    } else {
        drawer.classList.add("drawer__close");
        drawer.classList.remove("drawer__open");
    }
});
close.addEventListener("click", (e) => {
    if (drawer.classList.contains("drawer__close")) {
        drawer.classList.remove("drawer__close");
        drawer.classList.add("drawer__open");
    } else {
        drawer.classList.add("drawer__close");
        drawer.classList.remove("drawer__open");
    }
});

const isDesktop = () => {
    let _window;

    const navigatorAgent =
        navigator.userAgent ||
        navigator.vendor ||
        ((_window = window) === null || _window === void 0
            ? void 0
            : _window.opera);
    return !(
        /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series([46])0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(
            navigatorAgent
        ) ||
        /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br([ev])w|bumb|bw-([nu])|c55\/|capi|ccwa|cdm-|cell|chtm|cldc|cmd-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc-s|devi|dica|dmob|do([cp])o|ds(12|-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly([-_])|g1 u|g560|gene|gf-5|g-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd-([mpt])|hei-|hi(pt|ta)|hp( i|ip)|hs-c|ht(c([- _agpst])|tp)|hu(aw|tc)|i-(20|go|ma)|i230|iac([ \-/])|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja([tv])a|jbro|jemu|jigs|kddi|keji|kgt([ /])|klon|kpt |kwc-|kyo([ck])|le(no|xi)|lg( g|\/([klu])|50|54|-[a-w])|libw|lynx|m1-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t([- ov])|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30([02])|n50([025])|n7(0([01])|10)|ne(([cm])-|on|tf|wf|wg|wt)|nok([6i])|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan([adt])|pdxg|pg(13|-([1-8]|c))|phil|pire|pl(ay|uc)|pn-2|po(ck|rt|se)|prox|psio|pt-g|qa-a|qc(07|12|21|32|60|-[2-7]|i-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h-|oo|p-)|sdk\/|se(c([-01])|47|mc|nd|ri)|sgh-|shar|sie([-m])|sk-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h-|v-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl-|tdg-|tel([im])|tim-|t-mo|to(pl|sh)|ts(70|m-|m3|m5)|tx-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c([- ])|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas-|your|zeto|zte-/i.test(
            navigatorAgent.substr(0, 4)
        )
    );
};

const isTablet = () => {
    let _window;

    const navigatorAgent =
        navigator.userAgent ||
        navigator.vendor ||
        ((_window = window) === null || _window === void 0
            ? void 0
            : _window.opera);
    return !/(ipad|tablet|(android(?!.*mobile))|(windows(?!.*phone)(.*touch))|kindle|playbook|silk|(puffin(?!.*(IP|AP|WP))))/.test(
        navigatorAgent.substr(0, 4)
    );
};

let cont = document.querySelector(".container");
window.addEventListener("resize", () => {
    if (isDesktop()) {
        scale();
    }
});

function scale(event) {
    try {
        if (event) {
            event.stopPropagation();
            event.preventDefault();
        }
        let width = document.body.clientWidth;
        let height = document.body.clientHeight;
        let coeff;

        if (
            width > 1024 ||
            (width > 700 &&
                isTablet() &&
                window.matchMedia("(orientation: portrait)").matches)
        ) {
            if (width / height > 16 / 9) {
                coeff = height / 1080;
            } else {
                coeff = width / 1920;
            }
            cont.style.transform = `scale(${coeff})`;
        }
    } catch (e) {
        alert(e);
    }
}

scale();
// audios.forEach((audio) => {
//     audio.addEventListener("click", () => {
//         dialog.style.visibility = "visible";
//     });
// });
// const dialogClose = dialog.querySelector(".dialog__close");
// dialogClose.addEventListener("click", () => {
//     dialog.style.visibility = "hidden";
// });

// =====================================================================================
// Исправление позиционирования модалки для Ios
// Без этих манипуляций она чуть выше и не соответствует макету

const isIOS = /iPhone|iPad|iPod/.test(navigator.platform);

function dialogPositionForIos() {
    if (isIOS) {
        switch (screen.orientation.type) {
            case "landscape-primary":
                dialog.style.top = "7.3vw";
                break;
            case "portrait-primary":
                dialog.style.top = "20.5vw";
                break;
            default:
                console.log(
                    "The orientation API isn't supported in this browser :("
                );
        }
    }
}

dialogPositionForIos();

// Прослушка события смены ориентации экрана

screen.orientation.addEventListener("change", (event) => {
    const type = event.target.type;
    if (type === "landscape-primary") {
        dialogPositionForIos();
    } else if (type === "portrait-primary") {
        dialogPositionForIos();
    }
});
// =====================================================================================
