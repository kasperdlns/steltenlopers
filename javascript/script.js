document.addEventListener("DOMContentLoaded", function () {
    // Hamburger menu
    let checkbox = document.querySelector("#checkbox");
    if (checkbox) {
        checkbox.addEventListener("change", () => {
            let navUl = document.querySelector("nav ul");
            if (navUl) {
                navUl.style.left = checkbox.checked ? "0%" : "100%";
            }
        });
    }

    // Headerfoto slideshow
    let headerFoto = document.querySelector(".groepsfoto");
    let count = 0;
    if (headerFoto) {
        setInterval(() => {
            count++;
            if (count > 3) count = 0;
            headerFoto.src = `images/Header/header${count}.jpg`;
            headerFoto.alt = `header${count}`;
        }, 5000);
    }

    // Gallery: foto's vergroten
    let gallery = document.querySelectorAll(".gallery img");
    let overlay = document.querySelector(".overlay");
    let groteAfbeelding = document.querySelector(".overlay img.groot");
    let prev = document.querySelector(".prev");
    let next = document.querySelector(".next");
    let close = document.querySelector(".close");
    let huidigeIndex = 0;

    if (gallery.length > 0 && overlay && groteAfbeelding) {
        gallery.forEach((img, index) => {
            img.addEventListener("click", (e) => {
                huidigeIndex = index;
                groteAfbeelding.src = e.target.src;
                overlay.classList.remove("hidden");
            });
        });

        overlay.addEventListener("click", (e) => {
            if (e.target === overlay) {
                overlay.classList.add("hidden");
                groteAfbeelding.src = "";
            }
        });

        if (next) {
            next.addEventListener("click", () => {
                huidigeIndex = (huidigeIndex + 1) % gallery.length;
                groteAfbeelding.src = gallery[huidigeIndex].src;
            });
        }

        if (prev) {
            prev.addEventListener("click", () => {
                huidigeIndex = (huidigeIndex - 1 + gallery.length) % gallery.length;
                groteAfbeelding.src = gallery[huidigeIndex].src;
            });
        }

        if (close) {
            close.addEventListener("click", () => {
                overlay.classList.add("hidden");
                groteAfbeelding.src = "";
            });
        }
    }


    const popup = document.getElementById("eventPopup");
    const closeBtn = document.getElementById("closePopup");

    // show popup when page loaded
    popup.classList.remove("hidden");

    // close popup on click
    closeBtn.addEventListener("click", () => {
        popup.classList.add("hidden");
    });



});
