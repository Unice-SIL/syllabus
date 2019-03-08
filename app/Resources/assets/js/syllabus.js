/******************************************************************************

        Syllabus module.

*/


var Syllabus = ( function ( ) {


    "use strict";


    /**************************************************************************

            Private items.
    */


    function _ajaxTabContentLoader( $tabLink ) {

        var route = $tabLink.data( 'route' );

        if ( route !== "" ) {

            $( '#loading_spinner' ).fadeIn( {
                always: function( ) {
                    $.ajax( {
                        type: 'POST',
                        url: route,
                        context: $( '#panel_' + $tabLink.attr( 'id' ) )
                    } ).done( function( data ) {
                        $( this ).html( data );
                        $tabLink.data( 'route', "" );
                    } ).always( function( ){
                        $( '#loading_spinner' ).fadeOut( );
                    } );
                }
            } );
        }

    }



    /**************************************************************************

            Public items.
    */


    function tabLoaderInit( ) {

        $( 'main > .row:first-child > div > ul.nav' )
                .on( 'click', 'li.nav-item > a', function( ) {

            _ajaxTabContentLoader( $( this ) );

        } );

        $( '#tab-1' ).addClass( 'active' );
        _ajaxTabContentLoader( $( '#tab-1' ) );

    }



    /*
        Public pointers to exposed items.
    */

    return {
        tabLoaderInit: tabLoaderInit
    };



} ) ( );



export default Syllabus;

