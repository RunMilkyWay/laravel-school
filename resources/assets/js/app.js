import './bootstrap.js';
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';

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
    typeText("animated-text", "Welcome to Conference World!", 100);
});
