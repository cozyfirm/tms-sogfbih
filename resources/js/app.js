import './bootstrap';

// import 'jquery-ui/ui/widgets/datepicker'; // Make sure this line is present
// import 'jquery-ui/themes/base/theme.css'; // Optional: Include the theme CSS

import 'bootstrap-datepicker/dist/css/bootstrap-datepicker.css';
import 'bootstrap-datepicker';


/* Import Admin JavaScript data */
import './admin/layout/menu.js';
import './admin/layout/filters.js';


/* Import Submit script */
import "./style/submit.js";

/**
 *  Import public scripts such as:
 *      1. Auth scripts
 */

import './public-part/auth/auth.js';

$(document).ready(function() {
    $(".datepicker").datepicker({
        format: 'dd.mm.yyyy',
        autoclose: true,
    }); // Initialize the datepicker

    /* Global linking */
    $(".go-to").click(function (){
        window.location = $(this).attr('link');
    });


    $('.select2').select2({
        placeholder: 'Select or add options',
        tags: true // Enable adding new options
    });
});
