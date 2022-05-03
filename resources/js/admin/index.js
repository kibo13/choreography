// vendors
require('bootstrap');
window.$ = require('jquery');
window.dt = require('datatables.net');

// components
require('./components/sidebar')
require('./components/datatable')
require('./components/modal-delete')
require('./components/modal-check')
require('./components/alert')
require('./components/button')
require('./components/image')

// custom
require('./custom/validation')
require('./custom/calculation')

// pages
require('./pages/users')
require('./pages/groups')
