/******************************************************************************

        Syllabus module.

*/


import $ from 'jquery';



var Syllabus = ( function ( ) {


    "use strict";


    /**************************************************************************

            Private items.
    */


    const MS_BEFORE_DISMISS = 4000,
        USER_DISMISSIBLE_ALERTS = [
                //'primary',
                //'success',
                //'warning',
                'danger'
            ];

    var _$alertContainer = $( '#js-alerts_container' ),
        _messages = { };


    var _removeItem = function( item ) {

        $( item.elem ).remove( );

    };


    var _resetMessages = function( ) {

        _messages = {
            'light': [ ],
            'dark': [ ],
            'secondary': [ ],
            'primary': [ ],
            'info': [ ],
            'success': [ ],
            'warning': [ ],
            'danger': [ ]
        };

    };


    var _ajaxTabContentLoader = function( $tabLink ) {

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

    };


    var _displayAllAlerts = function( ) {

        for ( var key in _messages ) {

            var message = _messages[ key ];

            for ( var index in message ) {

                var $alert = null;

                if ( USER_DISMISSIBLE_ALERTS.includes( key ) ) {

                    var $button = $( "<button>", {
                            'type': "button",
                            'class': "close",
                            'data-dismiss': "alert",
                            'aria-label': "Close",
                            'html': '<span aria-hidden="true">&times;</span>'
                        } );

                    $alert = $( "<div>", {
                        'class': "alert alert-dismissible fade show alert-" + key,
                        'html': message[ index ],
                        'css': { 'display': 'none' }
                    } );

                    _$alertContainer.prepend( $alert.append( $button ) );
                    $alert.slideDown( );

                } else {

                    $alert = $( "<div>", {
                            'class': "alert alert-" + key,
                            'html': message[ index ],
                            'css': { 'display': 'none' }
                        } );

                    _$alertContainer.prepend( $alert );
                    $alert.slideDown( ).delay( MS_BEFORE_DISMISS )
                            .slideUp( {
                                always: _removeItem,
                            } );

                }
            }
        }

        _resetMessages( );

    };



    /**************************************************************************

            Public items.
    */


    var alert = function( type, text, keep ) {

        if ( type === true ) {

            _displayAllAlerts( );

        } else {

            //if ( type === undefined || ! ( type in _messages ) ) {
            if ( type === undefined || ! _messages.hasOwnProperty( type ) ) {
                type = 'danger';
            }

            if ( text === undefined ) {
                text = "Une erreur est survenue.";
            }

            _messages[ type ].push( text );

            if ( ! keep ) {
                _displayAllAlerts( );
            }

        }

    };


    var tabLoaderInit = function( ) {

        $( 'main > .row:first-child > div > ul.nav' )
                .on( 'click', 'li.nav-item > a', function( ) {

            _ajaxTabContentLoader( $( this ) );

        } );

        $( '#tab-1' ).addClass( 'active' );
        _ajaxTabContentLoader( $( '#tab-1' ) );

    };



    /**************************************************************************

            Init.
    */

    _resetMessages( );


    /*
        Public pointers to exposed items.
    */

    return {
        alert: alert,
        tabLoaderInit: tabLoaderInit
    };


} ) ( );


export default Syllabus;

