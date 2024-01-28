// toggle active nav item


const navLinks = document.querySelectorAll('.main-nav-item')

navLinks.forEach(navLink => {
    console.log(navLink)
    navLink.addEventListener('click', ()=> {
        navLink.classList.add('active');
})})

console.log(navLinks)

