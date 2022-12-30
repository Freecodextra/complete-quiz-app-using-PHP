const modes = document.querySelectorAll('header .extra .mode i');
const moon = document.querySelector('.bi-moon');
const sun = document.querySelector('.bi-brightness-high-fill');
const dropBtns = document.querySelectorAll('nav .nav-body .links .drop-btn');
const dropMenus = document.querySelectorAll('nav .nav-body .links .drop-down');
const dash = document.querySelector('header .header-logo .dash');
const nav = document.querySelector('nav');
const main = document.querySelector('main');
const profile = document.querySelector('header .extra .profile');
const profileMenu = document.querySelector('header .extra .profile .accounts');
const notify = document.querySelector('header .extra .notification');
const notifyMenu = document.querySelector('header .extra .notification .card');
const notifyFooter = document.querySelector('header .extra .notification .card .card-footer');
const overlay = document.querySelector(".overlay");
// DARK MODE SWITCH
var light = "light";
if (localStorage.getItem("saveMode") === "light") {
    $(':root').css({
        "--bg": "#f0f0f1",
        "--white": "#fff",
        "--gray": "#ddd",
        "--dark" : "#000"
    });
    moon.classList.add('hide');
    sun.classList.remove('hide');
} else {
    $(':root').css({
        "--bg": "#2c3333",
        "--white": "#3c4048",
        "--gray": "#2c3333",
        "--dark-gray": "#aaa",
        "--dark" : "#fff"
    });
    moon.classList.remove('hide');
    sun.classList.add('hide');
}
modes.forEach(mode => {
    mode.addEventListener('click', () => {
        if (mode.classList.contains('bi-moon')) {
            moon.classList.add('hide');
            sun.classList.remove('hide');
            light = "light";
            localStorage.setItem("saveMode", light);
            $(':root').css({
                "--bg": "#f0f0f1",
                "--white": "#fff",
                "--gray": "#ddd",
                "--dark" : "#000"
            });
            // console.log(localStorage.getItem("saveMode"));
        } else { 
            moon.classList.remove('hide');
            sun.classList.add('hide');
            light = "dark";
            localStorage.setItem("saveMode", light);
            $(':root').css({
                "--bg": "#2c3333",
                "--white": "#3c4048",
                "--gray": "#2c3333",
                "--dark-gray": "#aaa",
                "--dark" : "#fff"
            });
            // console.log(localStorage.getItem("saveMode"));
        }
    })
})
// NOTIFICATIONS AND PROFILE
profile.onclick = function () {
    profileMenu.style.display = "block";
    notifyMenu.style.display = "none";
};
notify.onclick = function () {
    notifyMenu.style.display = "block";
    profileMenu.style.display = "none";
}
// notifyFooter.onclick = () => {
//     notifyMenu.style.display = "none";
//     profileMenu.style.display = "block";
// }
// DROP DOWN BUTTON
dropBtns.forEach(dropBtn => {
    dropBtn.onclick = function () {
        dropMenus.forEach(dropMenu => {
            if (dropMenu.classList.contains(dropBtn.classList[2])) {
                dropMenu.classList.toggle('down');
            }
        });
    };
});
// COLLAPSING THE SIDE NAV
dash.onclick = function () {
    nav.classList.toggle('nav-collapse');
    overlay.style.display = "block";
}
overlay.onclick = () => {
    nav.classList.add('nav-collapse');
    overlay.style.display = "none";
}
main.onclick = function () {
    notifyMenu.style.display = "none";
    profileMenu.style.display = "none";
}

//  GET CURRENT URL
function getUrl(href) {
    var url = href.split("/");
    var currentPage = url[url.length-1].split("?");
    return currentPage[0];
}
var pages = document.querySelectorAll("nav .nav-body ul a");
pages.forEach((page,index) => {
    page.setAttribute("id", index);
    if (getUrl(page.href) === getUrl(window.location.href)) {
        page.className = "active";
    } else if (getUrl(page.href) !== getUrl(window.location.href)) {
    }
    page.className = page.className.replace(" ","active");
}); 


