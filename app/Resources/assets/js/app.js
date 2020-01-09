/*
        Main Webpack entry point.


*/

/*
    Importing dependencies
*/

// SASS / CSS dependencies.
import '../scss/app.scss';

// Importing modules…
const $ = jQuery = require('jquery');
global.$ = $;

import 'bootstrap/js/dist/alert';
import 'bootstrap/js/dist/button';
//import 'bootstrap/js/dist/carousel';
import 'bootstrap/js/dist/collapse';
import 'bootstrap/js/dist/dropdown';
import 'bootstrap/js/dist/index';
import 'bootstrap/js/dist/modal';
import 'bootstrap/js/dist/popover';
//import 'bootstrap/js/dist/scrollspy';
import 'bootstrap/js/dist/tab';
import 'bootstrap/js/dist/toast';
import 'bootstrap/js/dist/tooltip';
import 'bootstrap/js/dist/util';
import 'jquery.autocomplete';

const select2 = require('select2');
const bootbox = require('bootbox');
const bootstrapToggle = require('bootstrap4-toggle');
require('jquery-sortablejs');
const Sortable = require('sortablejs');

require('bootstrap4-toggle/css/bootstrap4-toggle.min.css');

require('admin-lte');

require('./_custom');
