const divMenu = document.querySelector('div.menu');
const navbar = document.querySelector('nav');
const header = document.querySelector('header');
const logo = document.querySelector('div.logo');

divMenu.addEventListener('click', () => {
    navbar.classList.toggle('active');
    header.classList.toggle('size');
    logo.classList.toggle('hide');
})