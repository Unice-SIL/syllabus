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


    var _saveCurrentTabContent = function( tabLink ) {

        var $panel = $( '#panel_' + tabLink.id ),
            form = document.getElementsByName( $panel.find( 'form' ).attr( 'name' ) )[ 0 ];

        $( form ).find( 'textarea' ).each( function( index ) {
            CKEDITOR.instances[ $( this ).attr( 'id' ) ].updateElement( );
        } );

        $.ajax( {
            type: 'POST',
            enctype: 'multipart/form-data',
            processData: false, // Preventing default data parse behavior.
            contentType: false,
            url: $panel.data( 'submit-url' ),
            data: new FormData( form ),
            cache: false,
            timeout: 5000 /*
        } ).done( function( ) {
            SILTools.alert( {
                type: 'info',
                text: "Les données de l'onglet précédent ont été sauvegardées."
            } ); //*/
        } );

    }



    /**************************************************************************

            Public items.
    */


    var tabLoaderInit = function( ) {

        $( 'a[data-toggle="tab"]' ).on( 'click', function( ) {
            _ajaxTabContentLoader( $( this ) );
        } ).on( 'hide.bs.tab', function( event ) {
            _saveCurrentTabContent( event.target );
        } );;

        $( '#tab-1' ).addClass( 'active' );
        _ajaxTabContentLoader( $( '#tab-1' ) );

    };


    var handleAjaxResponse = function( response ) {
        if(response.messages !== undefined) {
            response.messages.forEach(function(message){
                if (message.type !== undefined && message.message !== undefined) {
                    SILTools.alert( {
                        type: message.type,
                        text: message.message
                    } );
                }
            });
        }
        /*
        if(response.renders !== undefined) {
            response.renders.forEach(function(render) {
                if (render.element !== undefined && render.content !== undefined) {
                    $(render.element).html(render.content);
                }
            });
        } //*/
    }


    /*
        Public pointers to exposed items.
    */

    return {
        tabLoaderInit: tabLoaderInit,
        handleAjaxResponse: handleAjaxResponse
    };



} ) ( );


export default Syllabus;

