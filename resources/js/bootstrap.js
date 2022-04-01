require('bootstrap');
window._ = require('lodash');
window.Popper = require("popper.js").default;
window.$ = window.jQuery = require("jquery");
window.dt = require('datatables.net');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
