import './bootstrap.js';
import flatpickr from "flatpickr";


document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.datepicker').forEach(function (el)  {
        flatpickr(el,{
            mode:'range'
        });
    });
});
