/*
        Main JS file & Webpack entry point.


*/



/*
    Requiring dependencies
*/

// SASS / CSS dependencies.
require('../scss/app.scss');

// Defining jQuery client-side.
const $ = require('jquery');
global.$ = global.jQuery = $;



/*
    SortableJS with jQuery binding.
*/

import 'jquery-sortablejs';



/*
    Full Bootstrap…
*/

import('bootstrap');



/*
    … or parts of it.

import('bootstrap/js/dist/alert');
import('bootstrap/js/dist/button');
//import('bootstrap/js/dist/carousel');
import('bootstrap/js/dist/collapse');
import('bootstrap/js/dist/dropdown');
//import('bootstrap/js/dist/index');
import('bootstrap/js/dist/modal');
import('bootstrap/js/dist/popover');
import('bootstrap/js/dist/scrollspy');
import('bootstrap/js/dist/tab');
//import('bootstrap/js/dist/toast');
//import('bootstrap/js/dist/tooltip');
import('bootstrap/js/dist/util');
*/



/*
    App specific.
*/

$( document ).ready( function( ) {

    console.log( "WebpackEncore is working." );

} );

