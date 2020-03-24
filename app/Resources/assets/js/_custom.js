
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

    /**
     * Actions to execute when a ajax request is perform
     */
    $(document).ajaxStart(function(){
        $('.container-loader').show();
    });

    /**
     * Actions to execute when a ajax request send response
     */
    $(document).ajaxStop(function(){
        $('.container-loader').hide();
    });

    /**
     * Actions to execute when a ajax request failed
     */
    $( document ).ajaxError( function( event, jqXHR, ajaxSettings, thrownError ) {
        console.log( { event, jqXHR, ajaxSettings, thrownError } );
        SILTools.alert( {
            type: 'danger',
            text: "Une erreur est survenue (" + jqXHR.status + ")."
        } );

    } );

    $(document).on('click', '.help-button', function(){
        let message = $(this).parent().find('.help-message').html();
        bootbox.dialog({
            message: message,
            backdrop: true,
            onEscape: true
        });
    });

    //Trigger submit of a filter form when a select is changed
    $('.filter-form').find('select').change(function () {
        $('.filter-form').submit();
    });

    //show the admin notification if not empty
    let adminNotificationsElement = $('#data-notifications');
    let adminNotificationsLength = adminNotificationsElement.data('length');
    if (adminNotificationsLength > 0) {

        let adminNotifications = adminNotificationsElement.data('admin-notifications');

        let steps = [];
        let sweetNotifications = [];
        let i = 1;
        for (let key in adminNotifications) {
            let notification = adminNotifications[key];

            let buttonText = 'Terminé';

            if (i < adminNotificationsLength) {
                buttonText = 'Suivant &rarr;';
            }

            steps.push(i++);
            sweetNotifications.push({
                text: notification.message,
                confirmButtonText: buttonText,
                onClose: () => {
                    $.post(notification.path , {'_token': notification.token });
                }
            });
            Swal.mixin({
                showCloseButton: true,
                allowOutsideClick: false,
                progressSteps: steps,
            })
                .queue(sweetNotifications)
                .then((result) => {
                    console.log(result);
                    if (result.dismiss === Swal.DismissReason.close) {
                        $.post('/notification/seen' , {'_token': adminNotificationsElement.data('token-seen') });
                    }
                })
            ;
            }

        }


    //Autocomplete
    function initAutocomplete() {
        $('.autocomplete-input').each(function () {
            //todo: regenerate when resizing window
            //var width = $(this).outerWidth();

            $(this).autocomplete({
                serviceUrl: $(this).data('autocomplete-path'),
                //width: width,
            }).enable();
        });
    }
    initAutocomplete();

    /**
     * Form
     */

    $(document).on('click', '.remove-collection-widget', function(e) {
        e.preventDefault();
        var item = $(this).closest('.item-collection');

        item.slideUp(500, function() {
            $(this).remove();
        });

    });

});
