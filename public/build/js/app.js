// menu emergente en pantallas moviles
const mobileMenuBtn = document.querySelector('#mobile-menu');
const sidebar = document.querySelector('.sidebar');

if (mobileMenuBtn) {
    mobileMenuBtn.addEventListener('click',() => {
        sidebar.classList.add('mostrar');
    });
}

