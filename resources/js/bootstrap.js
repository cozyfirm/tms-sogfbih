import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import $ from 'jquery';
window.jQuery = window.$ = $;

import select2 from 'select2';
select2();


// import 'jquery-ui/ui/widgets/button'; // Import specific widgets as needed
// import 'jquery-ui/ui/widgets/dialog';  // Example for dialog
// import 'jquery-ui/ui/widgets/tabs';    // Example for tabs

// import 'jquery-ui/ui/widgets/datepicker';
// import 'jquery-ui/themes/base/theme.css'; // Optional: Include jQuery UI CSS


