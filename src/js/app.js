document.addEventListener('DOMContentLoaded', function() {
    evenListeners();
    darkMode();
})

function evenListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener('click', navegacionResponsive);
}

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');


    navegacion.classList.toggle('mostrar'); //Si tiene esa clase la elimina y si no la añade
}

function darkMode() {
    //Verificacion de cambios en el sistema operativo para que opere el darkmode
    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');
       
    prefiereDarkMode.addEventListener('change', function() {
        if(prefiereDarkMode.matches) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    });


    const botonDarkMode = document.querySelector('.dark-mode-boton');

    botonDarkMode.addEventListener('click', function () {
        document.body.classList.toggle('dark-mode');
    })
}