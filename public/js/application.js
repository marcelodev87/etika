"use strict";


function init() {
    middleAuthBox();
}

window.addEventListener("resize", function () {
    init();
});

init();

// auth form middle screen
function middleAuthBox() {
    var box = document.getElementById('middleAuthBox');
    if (box) {
        var screenHeight = window.innerHeight;
        var boxHeight = box.clientHeight;
        var marginHeight = (screenHeight - boxHeight) / 2;
        box.style.marginTop = marginHeight + 'px';
    }
}

