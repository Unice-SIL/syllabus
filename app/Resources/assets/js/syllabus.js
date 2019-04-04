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
                                SILTools.alert(data.alert.type, data.alert.message, false);
                            }
                        }
                    } ).always( function( ){
                        SILTools.spinner.fadeOut( );
                    } );
                }
            } );
        }

    };



    /**************************************************************************

            Public items.
    */


    var tabLoaderInit = function( ) {

        $( 'main > .row:first-child > div > ul.nav' )
                .on( 'click', 'li.nav-item > a', function( ) {

            _ajaxTabContentLoader( $( this ) );

            saveCurrentTabContent( $( this ) );

        } );

        $( '#tab-1' ).addClass( 'active' );
        $( '#tab-1' ).addClass( 'syllabus-tab-active' );
        _ajaxTabContentLoader( $( '#tab-1' ) );

    };

    var saveCurrentTabContent = function( tab ) {
        if(!tab["0"].classList.contains('syllabus-tab-active')){
            var active_tab_button = document.getElementsByClassName('syllabus-tab-active')[0];
            var active_tab = document.getElementById("panel_"+active_tab_button.id);
            var sumbit_button = active_tab.getElementsByClassName("submit")[0];
            sumbit_button.click();
            active_tab_button.classList.remove('syllabus-tab-active');
            tab.addClass( 'syllabus-tab-active' );
        }

    }

    var disablePublishButton = function( id ) {
        if(response.messages !== undefined) {
            response.messages.forEach(function(message){
                if (message.type !== undefined && message.message !== undefined) {
                    SILTools.alert(message.type, message.message, false);
                }
            });
        }
        if(response.render !== undefined && response.render !== null) {
            $(id).html(response.render);
        }
        if(response.canBePublish !== undefined) {
            if(response.canBePublish === true){
                $('#publishButton').removeAttr("disabled");
            }else{
                $('#publishButton').attr("disabled", 'disable');
            }
        }
    }


    /*
        Public pointers to exposed items.
    */

    return {
        tabLoaderInit: tabLoaderInit
    };



} ) ( );


export default Syllabus;

