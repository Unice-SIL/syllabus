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
import bootbox from 'bootbox';
import bootstrapToggle from 'bootstrap4-toggle';
import select2 from 'select2';
import SILTools from './sil_toolkit';
import Syllabus from './syllabus';

// … and make them visible to external components.
global.$ = window.$ = global.jQuery = window.jQuery = $;
global.bootbox = bootbox;
global.bootstrapToggle = bootstrapToggle;
global.select2 = select2;
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
    Select2 locale (fr).
        https://select2.org/i18n
*/

( function( ) {

    if ( jQuery && jQuery.fn && jQuery.fn.select2 && jQuery.fn.select2.amd ) {
        var e = jQuery.fn.select2.amd;
    }

    return e.define(
        "select2/i18n/fr",
        [ ],
        function( ) {

            return {
                inputTooLong: function( args ) {
                    var overChars = args.input.length - args.maximum,
                        message = 'Supprimez ' + overChars + ' caractère';

                    if ( overChars !== 1 ) {
                        message += 's.';
                    } else {
                        message += '.';
                    }

                    return message;
                },
                inputTooShort: function( args ) {
                    var remainingChars = args.minimum - args.input.length,
                        message = 'Saisissez ' + remainingChars + ' caractère';

                    if  (remainingChars !== 1 ) {
                        message += 's.';
                    } else {
                        message += '.';
                    }

                    return message;
                },
                loadingMore: function( ) {
                    return 'Chargement de résultats supplémentaires…';
                },
                maximumSelected: function( args ) {
                    var message = 'Vous pouvez seulement sélectionner ' +
                        args.maximum + ' élément';

                    if ( args.maximum !== 1 ) {
                        message += 's.';
                    } else {
                        message += '.';
                    }

                    return message;
                },
                noResults: function( ) {
                    return 'Aucun résultat.';
                },
                searching: function( ) {
                    return 'Recherche en cours…';
                }
            }

        } ), {
        define: e.define,
        require: e.require
    }
} ) ( );



/*
    Bootbox locale (fr).
        http://bootboxjs.com/documentation.html
*/

bootbox.addLocale( 'fr', {
        OK      : 'OK',
        CANCEL  : 'Annuler',
        CONFIRM : 'Confirmer'
    } );
bootbox.setLocale( 'fr' );



/*
    AJAX error handler.
*/

$( document ).ready( function( ) {

    $( document ).ajaxError( function( event, jqXHR, ajaxSettings, thrownError ) {

        console.log( { event, jqXHR, ajaxSettings, thrownError } );
        SILTools.alert( {
            type: 'danger',
            text: "Une erreur est survenue (" + jqXHR.status + ")."
        } );

    } );

} );

