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
import 'bootstrap/js/dist/scrollspy';
import 'bootstrap/js/dist/tab';
import 'bootstrap/js/dist/toast';
import 'bootstrap/js/dist/tooltip';
import 'bootstrap/js/dist/util';
import 'jquery.autocomplete';

import select2 from 'select2';
global.select2 = select2;
import 'select2/dist/js/i18n/fr';

import bootbox from 'bootbox';
global.bootbox = bootbox;

import Sortable from 'sortablejs';
global.Sortable = Sortable;
import 'jquery-sortablejs';

import bootstrapToggle from 'bootstrap4-toggle';
global.bootstrapToggle = bootstrapToggle;

import Swal from 'sweetalert2';
global.Swal = Swal;

import Slick from 'slick-carousel';
global.Slick = Slick;

import 'admin-lte';
require('admin-lte/plugins/jquery-knob/jquery.knob.min');

import './_custom';

import './light_version';