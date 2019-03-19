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

        } );

        $( '#tab-1' ).addClass( 'active' );
        _ajaxTabContentLoader( $( '#tab-1' ) );

    };


    /*
        Public pointers to exposed items.
    */

    return {
        tabLoaderInit: tabLoaderInit
    };



} ) ( );


export default Syllabus;

