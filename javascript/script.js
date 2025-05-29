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
