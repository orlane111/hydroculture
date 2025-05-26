// Animation clic sur "Ajouter au panier"
const buttons = document.querySelectorAll('.add-to-cart');
buttons.forEach(btn => {
    btn.addEventListener('click', () => {
        btn.textContent = "✔️ Ajouté !";
        btn.disabled = true;
        setTimeout(() => {
            btn.textContent = "Ajouter au panier";
            btn.disabled = false;
        }, 1500);
    });
});

// Menu hamburger
const menuBtn = document.getElementById('menuBtn');
const dropdownMenu = document.getElementById('dropdownMenu');

menuBtn.addEventListener('click', function() {
    this.classList.toggle('active');
    dropdownMenu.classList.toggle('active');
});

document.addEventListener('click', function(e) {
    if (!menuBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
        menuBtn.classList.remove('active');
        dropdownMenu.classList.remove('active');
    }
});