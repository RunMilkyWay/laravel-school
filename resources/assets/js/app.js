import './bootstrap.js';
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'starback';

function typeText(elementId, text, speed = 100) {
    const animatedText = document.getElementById(elementId);
    let index = 0;

    function type() {
        if (index < text.length) {
            animatedText.innerHTML += text.charAt(index);
            index++;
            setTimeout(type, speed);
        }
    }

    type();
}

document.addEventListener("DOMContentLoaded", function() {
    typeText("animated-text", "Welcome to the Conference Room!", 100);
});

document.addEventListener("DOMContentLoaded", function () {
    // Check if the user is on the welcome page and if redirection is needed
    const welcomeWrapper = document.querySelector("#welcome-wrapper[data-redirect='true']");

    if (welcomeWrapper && document.body.classList.contains("authenticated")) {
        setTimeout(function() {
            window.location.href = "/dashboard"; // Adjust route if needed
        }, 2000);
    }
});


