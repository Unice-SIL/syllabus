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



    /**************************************************************************

            Public items.
    */


    var tabsInit = function( ) {

        $( 'a[data-toggle="tab"]' ).on( 'click', function( ) {
            _ajaxTabContentLoader( $( this ) );
        } ).on( 'hide.bs.tab', function( event ) {
            document.getElementById( "panel_" + event.target.id )
                    .getElementsByClassName( "submit" )[ 0 ].click( );
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
        tabsInit: tabsInit,
        handleAjaxResponse: handleAjaxResponse
    };



} ) ( );


export default Syllabus;

