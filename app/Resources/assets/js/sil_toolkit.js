/******************************************************************************

        SIL tools module.

*/


import $ from 'jquery';



var SILTools = ( function ( ) {


    "use strict";


    /**************************************************************************

            Private items.
    */


    const MS_BEFORE_ALERT_DISMISS = 4000,
        USER_DISMISSIBLE_ALERT_TYPES = [
                //'primary',
                //'success',
                'warning',
                'danger'
            ];

    var _$loadingSpinner = $( '#loading_spinner' ),
        _$alertContainer = $( '#js-alerts_container' ),
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


    var _displayAllBSAlerts = function( ) {

        for ( var key in _messages ) {

            var message = _messages[ key ];

            for ( var index in message ) {

                var $alert = null;

                if ( USER_DISMISSIBLE_ALERT_TYPES.includes( key ) ) {

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
                    $alert.slideDown( ).delay( MS_BEFORE_ALERT_DISMISS )
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


    /**
     * Adds BS alerts in “_$alertContainer”.
     *
     * Examples of use:
     *      alert( 'info', "Blabla." );
     *          -> displays “Blabla.” in an “info” alert as well as all other
     *          previously buffered alerts, flushes buffer.
     *      alert( 'danger', "Blublu.", true );
     *          -> adds a “danger” alert in the buffer, displays nothing.
     *      alert( true );
     *          -> displays all previously buffered alerts, flushes buffer.
     *      alert( );
     *          -> displays a default “danger” alert as well as all other
     *          previously buffered alerts, flushes buffer.
     *
     * @param {string/boolean} type:
     *      one of the Bootstrap contextual classes, or “true” to display all
     *      previously buffered alerts and flush buffer.
     * @param {string} text: the text to display.
     * @param {boolean} keep: wether or not.
     */
    var alert = function( type, text, keep ) {

        if ( type === true ) {

            _displayAllBSAlerts( );

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
                _displayAllBSAlerts( );
            }

        }

    };



    /**************************************************************************

            Init.
    */

    _resetMessages( );


    /*
        Public pointers to exposed items.
    */

    return {
        spinner: _$loadingSpinner,
        alert: alert
    };



} ) ( );


export default SILTools;

