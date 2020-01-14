/*
        Main Webpack entry point.


*/

/*
    Importing dependencies
*/

// SASS / CSS dependencies.
import '../scss/app.scss';

// Importing modules…
const $ = require('jquery');
global.$ = global.jQuery = $;

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

import select2 from 'select2';
global.select2 = select2;

import bootbox from 'bootbox';
global.bootbox = bootbox;

import 'jquery-sortablejs';
import Sortable from 'sortablejs';
global.Sortable = Sortable;

import bootstrapToggle from 'bootstrap4-toggle';
global.bootstrapToggle = bootstrapToggle;

import 'admin-lte';

import './_custom';
