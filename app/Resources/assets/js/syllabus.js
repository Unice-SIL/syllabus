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


    var _ajaxTabContentLoader = function( tabLinkId ) {

        var $tabLink = $( '#' + tabLinkId ),
            route = $tabLink.data( 'route' );

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

        var $form = $( form ),
            ckeInstance = null;

        if ( isSubmit === undefined || ! isSubmit ) {
            isSubmit = false;
        } else {
            isSubmit = true;
        }
        /*
        $form.find( '.cke' ).each( function( ) {
            ckeInstance = $( this ).siblings( 'textarea' ).attr( 'id' );
            CKEDITOR.instances[ ckeInstance ].destroy( );
        } ); //*/

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


    var temporaryItem = null,
        ckeConfig = {
            "toolbar": [
                [
                  "RemoveFormat",
                  "-",
                  "Bold",
                  "Italic",
                  "Underline"
                ],
                "-",
                [
                  "Outdent",
                  "Indent",
                  "-",
                  "NumberedList",
                  "BulletedList"
                ]
            ],
            "removeButtons": null,
            "removePlugins": "elementspath",
            "resize_enabled": false
        };


    var addFormToCollection = function( collection ) {

        var prototype = collection.data( 'prototype' ),
            index = collection.data( 'index' ),
            newForm = prototype.replace( /__name__/g, index ),
            form = $( newForm );

        collection.data( 'index', index + 1 );
        collection.append( form );

        return form;

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


    var removeListElement = function( $element ) {

        $element.fadeOut( {
            always: function( ) {
                $element.find( '.cke' ).each( function( ) {
                    CKEDITOR.instances[ $( this ).siblings( 'textarea' ).attr( 'id' ) ].destroy( );
                } );
                $element.remove( );
            }
        } );

    };


    var setMediaFrameAttributes = function( mediaFrame ) {

        if ( mediaFrame ) {
            // Unnecessary attributes removal.
            mediaFrame.removeAttribute( 'width' );
            mediaFrame.removeAttribute( 'height' );
            // Feature policy removal.
            mediaFrame.removeAttribute( 'allow' );
            // Deprecated attributes removal.
            mediaFrame.removeAttribute( 'align' );
            mediaFrame.removeAttribute( 'frameborder' );
            mediaFrame.removeAttribute( 'longdesc' );
            mediaFrame.removeAttribute( 'marginheight' );
            mediaFrame.removeAttribute( 'marginwidth' );
            mediaFrame.removeAttribute( 'scrolling' );
            // Non standard attributes removal.
            mediaFrame.removeAttribute( 'mozbrowser' );
            // Style reset.
            mediaFrame.setAttribute( 'style', "padding:0;margin:0;border:0" );
            // BS “embed” class.
            mediaFrame.classList.add( 'embed-responsive-item' );
        }

    };


    var submitPanelForm = function( event, form ) {

        event.preventDefault( );

        SILTools.spinner.fadeIn( {
            always: _ajaxFormSubmission( form, true )
        } );

    };


    var tabsInit = function( ) {

        $( 'a[data-toggle="tab"]' ).on( 'hide.bs.tab', function( event ) {
            _ajaxFormSubmission( $( '#panel_' + event.target.id ).find( 'form' )[ 0 ] );
            _ajaxTabContentLoader( event.relatedTarget.id );
        } );

        _ajaxTabContentLoader( 'tab-1' );

    };



    /*
        Public pointers to exposed items.
    */

    return {
        addFormToCollection: addFormToCollection,
        ckeConfig: ckeConfig,
        handleAjaxResponse: handleAjaxResponse,
        removeListElement: removeListElement,
        setMediaFrameAttributes: setMediaFrameAttributes,
        submitPanelForm: submitPanelForm,
        tabsInit: tabsInit
    };



} ) ( );


export default Syllabus;

