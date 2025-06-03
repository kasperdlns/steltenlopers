let checkbox = document.querySelector("#checkbox");

checkbox.addEventListener("change", () => {
    let navUl = document.querySelector("nav ul"); // Selecteer de ul binnen de nav
    if (checkbox.checked) {
        navUl.style.left = "0%"; // Zet de ul terug naar de oorspronkelijke positie
    } else {
        navUl.style.left = "100%"; // Verplaats de ul naar rechts
    }
});


// headerfoto switch
let headerFoto = document.querySelector(".groepsfoto");

// count, zodat we weten welke foto we moeten laten zien
let count = 0;

// count laten optellen met seconden tot twee, bij twee weer terug naar 0
setInterval(() => {
    count++;
    if (count > 3) {
        count = 0;
    }
    headerFoto.src = `images/Header/header${count}.jpg`;
    headerFoto.alt = `header${count}`;
}, 5000);

//fotos vergroten
let gallery = document.querySelectorAll(".gallery img");
let overlay = document.querySelector(".overlay");
let groteAfbeelding = document.querySelector(".overlay img.groot");

gallery.forEach(img => {
    img.addEventListener("click", (e) => {
        groteAfbeelding.src = e.target.src;
        overlay.classList.remove("hidden");
    });
});

overlay.addEventListener("click", (e) => {
    if (e.target === overlay) {
        overlay.classList.add("hidden"); // overlay wordt verwijderd
        groteAfbeelding.src = ""; // img leegmaken
    };
});

//vorige en volgende foto, kruisje voor sluiten
let prev = document.querySelector('.prev');
let next = document.querySelector('.next');
let close = document.querySelector('.close');
let huidigeIndex = 0

gallery.forEach((img, index) => {
  img.addEventListener("click", (e) => {
    huidigeIndex = index; // sla de index op
    groteAfbeelding.src = e.target.src;
    overlay.classList.remove("hidden");
  });
});

next.addEventListener("click", () => {
    huidigeIndex++;
    if (huidigeIndex >= gallery.length) {
        huidigeIndex = 0; // terug naar begin
    }
    groteAfbeelding.src = gallery[huidigeIndex].src;
});

prev.addEventListener("click", () => {
    huidigeIndex--;
    if (huidigeIndex < 0) {
        huidigeIndex = gallery.length - 1; // naar laatste
    }
    groteAfbeelding.src = gallery[huidigeIndex].src;
});

close.addEventListener("click", function() {
        overlay.classList.add("hidden");
        groteAfbeelding.src = "";
});
