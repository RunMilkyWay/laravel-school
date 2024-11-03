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
    typeText("animated-text", textEffectTranslations.welcomeMessage, 50);
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

document.addEventListener("DOMContentLoaded", function() {
    // Select the alert with the specific class
    const alert = document.querySelector('.auto-dismiss-alert');

    // Set a timer to remove the alert after 3 seconds
    if (alert) {
        setTimeout(function() {
            alert.classList.remove('show'); // Remove show class to trigger fade out
            alert.classList.add('fade');    // Adds fade class for Bootstrap effect
        }, 2000); // 3000 milliseconds = 3 seconds
    }
});

function openCreateUserModal() {
    document.getElementById('form-title').innerText = formTitleTranslations.create;
    document.getElementById('user-form').reset();
    document.getElementById('user-id').value = '';
    document.getElementById('user-form').action = storeRoute;
    document.getElementById('form-submit').innerText = formTitleTranslations.createUser;

    const methodInput = document.querySelector('#user-form input[name="_method"]');
    if (methodInput) methodInput.remove();
}

function fillEditForm(user) {
    document.getElementById('form-title').innerText = formTitleTranslations.edit;

    document.getElementById('user-id').value = user.id;
    document.getElementById('name').value = user.name;
    document.getElementById('email').value = user.email;
    document.getElementById('type_id').value = user.type_id;

    document.getElementById('form-submit').innerText = formTitleTranslations.updateUser;
    document.getElementById('user-form').action = `${updateRoute}/${user.id}`;
    document.getElementById('user-form').method = 'POST';

    const existingMethodInput = document.querySelector('#user-form input[name="_method"]');
    if (existingMethodInput) existingMethodInput.remove();

    const methodInput = document.createElement('input');
    methodInput.setAttribute('type', 'hidden');
    methodInput.setAttribute('name', '_method');
    methodInput.setAttribute('value', 'PUT');
    document.getElementById('user-form').appendChild(methodInput);
}

window.openCreateUserModal = openCreateUserModal;
window.fillEditForm = fillEditForm;
