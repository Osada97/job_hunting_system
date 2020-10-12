const tobut = document.querySelector(".mob-nav h3");
const mobnav = document.querySelector(".mob-nav ul");
let status = false;

tobut.addEventListener('click', () => {
    if (status == false) {
        mobnav.style.display = "Block";
        mobnav.classList.add('anshow');
        mobnav.classList.remove('anihide');
        status = true;
    }
    else {
        mobnav.classList.remove('anshow');
        mobnav.classList.add('anihide');
        document.querySelector(".mob-nav ul").addEventListener('transitionend', (event) => {

            if (event.propertyName === 'transform') {
                mobnav.style.display = "none";
            }

        });
        status = false;

    }
});

const tobut2 = document.querySelector(".mob-nav2 h3");
const mobnav2 = document.querySelector(".mob-nav2 ul");
let status2 = false;

tobut2.addEventListener('click', () => {
    if (status2 == false) {
        mobnav2.style.display = "Block";
        mobnav2.classList.add('anshow');
        status2 = true;
    }
    else {
        mobnav2.classList.remove('anshow');
        mobnav2.classList.add('anihide');
        document.querySelector(".mob-nav ul li").addEventListener('transitionend', () => {
            if (event.propertyName === 'transform') {
                mobnav2.style.display = "none";
            }
        });
        status2 = false;

    }
});