
import SILTools from './sil_toolkit';
global.SILTools = SILTools;

//const Syllabus = require('./syllabus');
import Syllabus from './syllabus';
global.Syllabus = Syllabus;

import './admin';

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


$(document).ready(function () {

    //Trigger submit of a filter form when a select is changed
    $('.filter-form').find('select').change(function () {
        $('.filter-form').submit();
    });

    //Autocomplete
    function initAutocomplete() {
        $('.autocomplete-input').each(function () {
            //todo: regenerate when resizing window
            var width = $(this).outerWidth();

            $(this).autocomplete({
                serviceUrl: $(this).data('autocomplete-path'),
                //width: width,
            }).enable();
        });
    }
    initAutocomplete();
});
