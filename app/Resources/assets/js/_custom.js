
const SILTools = require('./sil_toolkit');
const Syllabus = require('./syllabus');

import './admin';


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
