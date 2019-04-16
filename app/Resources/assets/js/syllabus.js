/******************************************************************************

        Syllabus module.

*/


import $ from 'jquery';
import SILTools from './sil_toolkit';



var Syllabus = ( function ( ) {


    "use strict";


    /**************************************************************************

            Private items.
    */


    var _ajaxTabContentLoader = function( $tabLink ) {

        var route = $tabLink.data( 'route' );

        if ( route !== "" ) {

            SILTools.spinner.fadeIn( {
                always: function( ) {
                    $.ajax( {
                        type: 'POST',
                        url: route,
                        context: $( '#panel_' + $tabLink.attr( 'id' ) )
                    } ).done( function( data ) {
                        if ( data.content !== undefined ) {
                            $( this ).html( data.content );
                            $tabLink.data( 'route', "" );
                        }
                        if ( data.alert !== undefined ) {
                            if ( data.alert.type !== undefined && data.alert.message !== undefined ) {
                                SILTools.alert( {
                                    type: data.alert.type,
                                    text: data.alert.message
                                } );
                            }
                        }
                    } ).always( function( ) {
                        SILTools.spinner.fadeOut( );
                    } );
                }
            } );
        }

    };


    var _refreshContent = function( renders ) {

        if ( renders !== undefined ) {
            renders.forEach( function( render ) {
                if ( render.element !== undefined &&
                        render.content !== undefined ) {
                    $( render.element ).html( render.content );
                }
            } );
        }

    };


    var _ajaxFormSubmission = function( form, isSubmit ) {

        var $form = $( form );

        if ( isSubmit === undefined || ! isSubmit ) {
            isSubmit = false;
        } else {
            isSubmit = true;
        }

        $form.find( '.cke' ).each( function( ) {
            CKEDITOR.instances[ $( this ).siblings( 'textarea' ).attr( 'id' ) ]
                    .updateElement( );
        } );

        $.ajax( {
            type: 'POST',
            enctype: 'multipart/form-data',
            processData: false, // Preventing default serialization.
            contentType: false, // No auto “contentType” header.
            url: $form.parent( '.tab-pane' ).data( 'submit-url' ),
            data: new FormData( form ),
            cache: false,
            timeout: 3000
        } ).done( function( response ) {
            if ( isSubmit ) {
                Syllabus.handleAjaxResponse( response );
            } else {
                _refreshContent( response.renders );
            }
        } ).always( function( ) {
            if ( isSubmit ) {
                SILTools.spinner.fadeOut( );
            }
        } );

    };



    /**************************************************************************

            Public items.
    */


    var tabsInit = function( ) {

        $( 'a[data-toggle="tab"]' ).on( 'hide.bs.tab', function( event ) {
            /*
                We could check if form has changed, show a “confirm” message
                to user and prevent tab change if “cancel” is chosen.
            */
            //event.preventDefault( );
            document.getElementById( "panel_" + event.target.id )
                    .getElementsByClassName( "submit" )[ 0 ].click( );
            _ajaxTabContentLoader( $( "#" + event.relatedTarget.id ) );
        } );

        $( '#tab-1' ).addClass( 'active' );
        _ajaxTabContentLoader( $( '#tab-1' ) );

    };


    var submitPanelForm = function( event, form ) {

        event.preventDefault( );

        SILTools.spinner.fadeIn( {
            always: _ajaxFormSubmission( form, true )
        } );

    };


    var handleAjaxResponse = function( response ) {
        if ( response.messages !== undefined ) {
            response.messages.forEach( function( message ) {
                if ( message.type !== undefined &&
                        message.message !== undefined ) {
                    SILTools.alert( {
                        type: message.type,
                        text: message.message
                    } );
                }
            } );
        }

        _refreshContent( response.renders );

    };


    /*
        Public pointers to exposed items.
    */

    return {
        tabsInit: tabsInit,
        submitPanelForm: submitPanelForm,
        handleAjaxResponse: handleAjaxResponse
    };



} ) ( );


export default Syllabus;

