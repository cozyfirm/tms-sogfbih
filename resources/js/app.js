import './bootstrap';

// import 'jquery-ui/ui/widgets/datepicker'; // Make sure this line is present
// import 'jquery-ui/themes/base/theme.css'; // Optional: Include the theme CSS

import 'bootstrap-datepicker/dist/css/bootstrap-datepicker.css';
import 'bootstrap-datepicker';


/* Import Admin JavaScript data */
import './admin/layout/menu.js';
import './admin/layout/filters.js';

/**
 *  Core scripts
 */
import "./admin/app/core/show-hide-elements.js";
import "./admin/app/core/notifications.js";

/**
 *  Trainings scripts
 */
import "./admin/app/trainings/instances/instances.js";
import "./admin/app/trainings/add-author.js";
import "./admin/app/trainings/instances/add-trainer.js";
import "./admin/app/trainings/instances/events.js";
import "./admin/app/trainings/instances/preview-location.js";
import "./admin/app/trainings/instances/applications.js";
import "./admin/app/trainings/instances/presence.js";

/* Import Submit script */
import "./style/submit.js";

/**
 *  User data scripts
 */
import "./user-data/user-data.js";

/**
 *  Import public scripts such as:
 *      1. Auth scripts
 */

import './public-part/auth/auth.js';

/**
 *  Import shared scripts
 */
import './admin/app/shared/files/file-upload.js';

/**
 *  Analysis data
 */
import './admin/app/other/analysis/analysis.js';
import './public-part/analysis/evaluation.js';

$(document).ready(function() {
    $(".datepicker").datepicker({
        format: 'dd.mm.yyyy',
        autoclose: true,
    }); // Initialize the datepicker

    /* Global linking */
    $(".go-to").click(function (){
        let link = $(this).attr('link');

        setTimeout(function (){
            window.location = link;
        }, 100);
    });


    $('.select2').select2({
        placeholder: 'Select or add options',
        tags: true // Enable adding new options
    });
    $('.single-select2').select2({
        placeholder: "Odaberite", // Optional placeholder
        language: {
            noResults: function () {
                return "Nema pronađenih rezultata";
            }
        },
        escapeMarkup: function (markup) {
            return markup; // Allow custom HTML (if needed)
        }
    });
});
