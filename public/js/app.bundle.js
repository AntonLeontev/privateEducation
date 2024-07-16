(() => {
    var e = {
            297: () => {
                const t = document.getElementById("account-password-recall"),
                    n = document.getElementById("password-reacll-form"),
                    o = document.getElementById(
                        "account-password-new-info-msg"
                    ),
                    i = document.getElementById("password-new-info-msg-btn"),
                    s = document.getElementById("account-registration"),
                    l = document.getElementById(
                        "autorization-mode-btn-registration"
                    ),
                    r = document.getElementById("account-autorization"),
                    p = document.getElementById("autorization-error-msg"),
                    y = document.getElementById(
                        "registration-mode-btn-aurorization"
                    ),
                    v = document.getElementById(
                        "autorization-password-recall-btn"
                    ),
                    w = document.querySelectorAll(".tabs__button");
                w.forEach((e) => {
                    e.addEventListener("click", () => {
                        const t = document.querySelector(".tabs__item._active"),
                            n = document.querySelector(".tabs__button._active");
                        n && n.classList.remove("_active"),
                            t && t.classList.remove("_active");
                        const a = `#${e.getAttribute("data-tab")}`,
                            o = document.querySelector(a);
                        e.classList.add("_active"), o.classList.add("_active");
                    });
                }),
                    (function (e) {})(),
                    // y?.addEventListener("click", function () {
                    //     (r.style.display = "flex"), (s.style.display = "none");
                    // }),
                    // v?.addEventListener("click", function () {
                    //     (r.style.display = "none"), (t.style.display = "flex");
                    // }),
                    // i?.addEventListener("click", function () {
                    //     (o.style.display = "none"),
                    //         (r.style.display = "flex"),
                    //         (p.style.display = "none"),
                    //         n.reset();
                    // }),
                    // l?.addEventListener("click", function () {
                    //     (r.style.display = "none"), (s.style.display = "flex");
                    // }),
                    document.querySelectorAll("input").forEach((e) => {
                        e.addEventListener("focus", function () {
                            window.matchMedia("(orientation: portrait)")
                                .matches &&
                                Screen.lockOrientation("portrait-primary");
                        });
                    });
            },
            98: () => {
                const e = document.querySelectorAll(".polygon"),
                    t = document.querySelector(".menu"),
                    n = document.querySelector(".drawer"),
                    a = document.querySelector(".close"),
                    o = document.querySelectorAll(".column__audio"),
                    i = document.getElementById("dialog1");
                document
                    .querySelectorAll(".main__row .column .polygon button")
                    .forEach((e) => {
                        e.addEventListener("click", (e) => {
                            const t = e.target.closest("button"),
                                n = e.target
                                    .closest(".column")
                                    .querySelector(".column__top"),
                                a = getComputedStyle(n).backgroundColor;
                            t.classList.remove("column__hover"),
                                t.classList.add("column__active"),
                                a.includes("233, 117, 44, 0.3") &&
                                    n.classList.add("column__top_active_1"),
                                a.includes("125, 97, 155") &&
                                    n.classList.add("column__top_active_2"),
                                n.classList.remove(
                                    "column__st3-active",
                                    "column__st2-active"
                                );
                        }),
                            e.addEventListener("mouseout", (e) => {
                                const t = e.target.closest("button"),
                                    n = e.target
                                        .closest(".column")
                                        .querySelector(".column__top");
                                t.classList.remove(
                                    "column__active",
                                    "column__hover"
                                ),
                                    n.classList.remove(
                                        "column__top_active_2",
                                        "column__top_active_1"
                                    );
                            }),
                            e.addEventListener("mouseover", (e) => {
                                const t = e.target.closest("button");
                                e.target
                                    .closest(".column")
                                    .querySelector(".column__top"),
                                    t.classList.add("column__hover");
                            });
                    }),
                    e.forEach((e) => {
                        e.addEventListener("mouseover", (e) => {
                            const t = e.target
                                    .closest(".column")
                                    .querySelector(".column__top"),
                                n = getComputedStyle(t).backgroundColor;
                            "rgba(233, 117, 44, 0.3)" === n &&
                                t.classList.add("column__st2-active"),
                                "rgba(125, 97, 155, 0.3)" === n &&
                                    t.classList.add("column__st3-active");
                        }),
                            e.addEventListener("mouseout", (e) => {
                                e.target
                                    .closest(".column")
                                    .querySelector(".column__top")
                                    .classList.remove(
                                        "column__st3-active",
                                        "column__st2-active",
                                        "column__st2-2-active",
                                        "column__st3-2-active",
                                        "column__st2-3-active",
                                        "column__st3-3-active"
                                    );
                            });
                    }),
                    t.addEventListener("click", (e) => {
                        n.classList.contains("drawer__close")
                            ? (n.classList.remove("drawer__close"),
                              n.classList.add("drawer__open"))
                            : (n.classList.add("drawer__close"),
                              n.classList.remove("drawer__open"));
                    }),
                    a.addEventListener("click", (e) => {
                        n.classList.contains("drawer__close")
                            ? (n.classList.remove("drawer__close"),
                              n.classList.add("drawer__open"))
                            : (n.classList.add("drawer__close"),
                              n.classList.remove("drawer__open"));
                    });
                let s = document.querySelector(".container");
                function l(e) {
                    try {
                        e && (e.stopPropagation(), e.preventDefault());
                        let t,
                            n = document.body.clientWidth,
                            a = document.body.clientHeight;
                        (n > 1024 ||
                            (n > 700 &&
                                (() => {
                                    let e;
                                    const t =
                                        navigator.userAgent ||
                                        navigator.vendor ||
                                        (null === (e = window) || void 0 === e
                                            ? void 0
                                            : e.opera);
                                    return !/(ipad|tablet|(android(?!.*mobile))|(windows(?!.*phone)(.*touch))|kindle|playbook|silk|(puffin(?!.*(IP|AP|WP))))/.test(
                                        t.substr(0, 4)
                                    );
                                })() &&
                                window.matchMedia("(orientation: portrait)")
                                    .matches)) &&
                            ((t = n / a > 16 / 9 ? a / 1080 : n / 1920),
                            (s.style.transform = `scale(${t})`));
                    } catch (e) {
                        alert(e);
                    }
                }
                window.addEventListener("resize", () => {
                    (() => {
                        let e;
                        const t =
                            navigator.userAgent ||
                            navigator.vendor ||
                            (null === (e = window) || void 0 === e
                                ? void 0
                                : e.opera);
                        return !(
                            /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series([46])0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(
                                t
                            ) ||
                            /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br([ev])w|bumb|bw-([nu])|c55\/|capi|ccwa|cdm-|cell|chtm|cldc|cmd-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc-s|devi|dica|dmob|do([cp])o|ds(12|-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly([-_])|g1 u|g560|gene|gf-5|g-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd-([mpt])|hei-|hi(pt|ta)|hp( i|ip)|hs-c|ht(c([- _agpst])|tp)|hu(aw|tc)|i-(20|go|ma)|i230|iac([ \-/])|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja([tv])a|jbro|jemu|jigs|kddi|keji|kgt([ /])|klon|kpt |kwc-|kyo([ck])|le(no|xi)|lg( g|\/([klu])|50|54|-[a-w])|libw|lynx|m1-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t([- ov])|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30([02])|n50([025])|n7(0([01])|10)|ne(([cm])-|on|tf|wf|wg|wt)|nok([6i])|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan([adt])|pdxg|pg(13|-([1-8]|c))|phil|pire|pl(ay|uc)|pn-2|po(ck|rt|se)|prox|psio|pt-g|qa-a|qc(07|12|21|32|60|-[2-7]|i-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h-|oo|p-)|sdk\/|se(c([-01])|47|mc|nd|ri)|sgh-|shar|sie([-m])|sk-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h-|v-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl-|tdg-|tel([im])|tim-|t-mo|to(pl|sh)|ts(70|m-|m3|m5)|tx-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c([- ])|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas-|your|zeto|zte-/i.test(
                                t.substr(0, 4)
                            )
                        );
                    })() && l();
                }),
                    l(),
                    o.forEach((e) => {
                        e.addEventListener("click", () => {
                            i.style.visibility = "visible";
                        });
                    }),
                    i
                        ?.querySelector(".dialog__close")
                        .addEventListener("click", () => {
                            i.style.visibility = "hidden";
                        });
                const c = /iPhone|iPad|iPod/.test(navigator.platform);
                function d() {
                    if (c)
                        switch (screen.orientation.type) {
                            case "landscape-primary":
                                i.style.top = "7.3vw";
                                break;
                            case "portrait-primary":
                                i.style.top = "20.5vw";
                                break;
                            default:
                                console.log(
                                    "The orientation API isn't supported in this browser :("
                                );
                        }
                }
                d(),
                    screen.orientation.addEventListener("change", (e) => {
                        const t = e.target.type;
                        ("landscape-primary" === t ||
                            "portrait-primary" === t) &&
                            d();
                    });
            },
        },
        t = {};
    function n(a) {
        var o = t[a];
        if (void 0 !== o) return o.exports;
        var i = (t[a] = { exports: {} });
        return e[a](i, i.exports, n), i.exports;
    }
    (n.n = (e) => {
        var t = e && e.__esModule ? () => e.default : () => e;
        return n.d(t, { a: t }), t;
    }),
        (n.d = (e, t) => {
            for (var a in t)
                n.o(t, a) &&
                    !n.o(e, a) &&
                    Object.defineProperty(e, a, { enumerable: !0, get: t[a] });
        }),
        (n.o = (e, t) => Object.prototype.hasOwnProperty.call(e, t)),
        (() => {
            "use strict";
            n(98), n(297);
        })();
})();
