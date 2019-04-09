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
        _$alertContainer = $( '#alerts_container' ),
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
     *      alert( { type: 'info', text: "“Blabla." } );
     *          -> displays “Blabla.” in an “info” alert as well as all other
     *          previously buffered alerts, flushes buffer.
     *      alert( { type: 'warning', text: "Blublu.", keep: true } );
     *          -> adds a warning alert with “Blabla.” text in the buffer,
     *          displays nothing.
     *      alert( );
     *          -> displays all previously buffered alerts, flushes buffer.
     *
     * @param {object} alertData:
     *      type -> one of the Bootstrap contextual classes;
     *      text -> the text to display;
     *      keep -> “true” to simply add alert to buffer,
     *              “false” to display all previously buffered alerts
     *              and flush buffer.
     *
     */
    var alert = function( alertData ) {

        if ( alertData === undefined ) {

            _displayAllBSAlerts( );

        } else {

            if ( alertData.type === undefined
                    //|| ! ( alertData.type in _messages )
                    || ! _messages.hasOwnProperty( alertData.type ) ) {
                alertData.type = 'danger';
            }

            if ( alertData.text === undefined ) {
                alertData.text = "Une erreur est survenue.";
            }

            if ( alertData.keep === undefined ) {
                alertData.keep = false;
            }

            _messages[ alertData.type ].push( alertData.text );

            if ( ! alertData.keep ) {
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

