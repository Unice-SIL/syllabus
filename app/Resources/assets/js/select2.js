/*
        Select2Entity Webpack entry point.


*/



/*
    Importing dependencies
*/

// SASS / CSS dependencies.
import '../../../../node_modules/select2/src/scss/core.scss';

// Importing modules…
import $ from 'jquery';
import select2 from 'select2';

// … and make them visible to external components.
global.$ = window.$ = global.jQuery = window.jQuery = $;
global.select2 = select2;



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


