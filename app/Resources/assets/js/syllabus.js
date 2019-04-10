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
                        if(data.content !== undefined) {
                            $(this).html(data.content);
                            $tabLink.data('route', "");
                        }
                        if(data.alert !== undefined) {
                            if (data.alert.type !== undefined && data.alert.message !== undefined) {
                                SILTools.alert( {
                                    type: data.alert.type,
                                    text: data.alert.message
                                } );
                            }
                        }
                    } ).always( function( ){
                        SILTools.spinner.fadeOut( );
                    } );
                }
            } );
        }

    };


    var _saveCurrentTabContent = function( tab ) {
        if(!tab["0"].classList.contains('syllabus-tab-active')){
            var active_tab_button = document.getElementsByClassName('syllabus-tab-active')[0];
            var active_tab = document.getElementById("panel_"+active_tab_button.id);
            var sumbit_button = active_tab.getElementsByClassName("submit")[0];
            sumbit_button.click();
            active_tab_button.classList.remove('syllabus-tab-active');
            tab.addClass( 'syllabus-tab-active' );
        }
    }



    /**************************************************************************

            Public items.
    */


    var tabLoaderInit = function( ) {

        $( 'main > .row:first-child > div > ul.nav' )
                .on( 'click', 'li.nav-item > a', function( ) {

            _ajaxTabContentLoader( $( this ) );
            _saveCurrentTabContent( $( this ) );

        } );

        $( '#tab-1' ).addClass( 'active' );
        $( '#tab-1' ).addClass( 'syllabus-tab-active' );
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
        if(response.renders !== undefined) {
            response.renders.forEach(function(render) {
                if (render.element !== undefined && render.content !== undefined) {
                    $(render.element).html(render.content);
                }
            });
        }
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

