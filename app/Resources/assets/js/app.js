/*
        Main JS file & Webpack entry point.


*/



/*
    Importing dependencies
*/

// SASS / CSS dependencies.
import '../scss/sil_toolkit.scss';
import '../scss/app.scss';

// Importing modules…
import $ from 'jquery';
import SILTools from './sil_toolkit';
import Syllabus from './syllabus';

// … and make them visible to external components.
global.$ = global.jQuery = $;
global.SILTools = SILTools;
global.Syllabus = Syllabus;



/*
    SortableJS with jQuery binding.
*/

import 'jquery-sortablejs';



/*
    Full Bootstrap…
*/

import 'bootstrap';



/*
    … or parts of it.

import 'bootstrap/js/dist/alert';
import 'bootstrap/js/dist/button';
//import 'bootstrap/js/dist/carousel';
import 'bootstrap/js/dist/collapse';
//import 'bootstrap/js/dist/dropdown';
//import 'bootstrap/js/dist/index';
import 'bootstrap/js/dist/modal';
//import 'bootstrap/js/dist/popover';
import 'bootstrap/js/dist/scrollspy';
import 'bootstrap/js/dist/tab';
//import 'bootstrap/js/dist/toast';
//import 'bootstrap/js/dist/tooltip';
import 'bootstrap/js/dist/util';
*/



/*
    AJAX error handler.
*/

$( document ).ready( function( ) {

    $( document ).ajaxError( function( event, jqXHR, ajaxSettings, thrownError ) {

        console.log( { event, jqXHR, ajaxSettings, thrownError } );
        SILTools.alert( 'danger', "Une erreur est survenue (" + jqXHR.status + ")." );

    } );

} );

