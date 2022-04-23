// vendors
require('bootstrap');
window.$ = require('jquery');
window.dt = require('datatables.net');

// components
require('./components/sidebar')
require('./components/datatable')
require('./components/modal-delete')
require('./components/alert')
require('./components/button')

// custom
require('./custom/validation')

// pages
require('./pages/customers')
