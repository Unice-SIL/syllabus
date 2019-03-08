/******************************************************************************

        Syllabus namespace & module.

*/


var Syllabus = ( function ( Syllabus ) {


    "use strict";


    function ajaxTabContentLoader( $tabLink ) {

        var id = $tabLink.attr( 'id' ),
            route = $tabLink.data( 'route' );

        if ( route !== "" ) {

            $( '#loading_spinner' ).fadeIn( 'slow', function( ) {

                $.ajax( {
                    type: 'POST',
                    url: route,
                    context: $( '#panel_' + id )
                } ).done( function( data ) {
                    $( this ).html( data );
                    $tabLink.data( 'route', "" );
                } ).always( function( ){
                    $( '#loading_spinner' ).fadeOut( 'slow' );
                } ).fail( function( jqXHR, textStatus ){
                    alert( "Request failed: " + textStatus + "." );
                } );

            } );
        }

    }


    function logInfo( text ) {

        console.log( text );

    }


    return {
        tabLoader: ajaxTabContentLoader
    };


} ( Syllabus || { } ) );


export default Syllabus;
