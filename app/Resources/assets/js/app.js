/*
        Main JS file & Webpack entry point.


*/



/*
    Importing dependencies
*/

// SASS / CSS dependencies.
import '../scss/app.scss';

// Importing modules…
import $ from 'jquery';
import Syllabus from './syllabus';

// … and make them visible to external components.
global.$ = global.jQuery = $;
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

        //console.log( { event, jqXHR, ajaxSettings, thrownError } );
        alert( "Une erreur est survenue (" + jqXHR.status + ")." );

    } );

} );

