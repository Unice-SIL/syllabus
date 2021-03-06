/******************************************************************************

 Syllabus module.

 */

import Sortable from 'sortablejs';
import 'jquery-sortablejs';

var Syllabus = ( function ( ) {


    "use strict";


    /**************************************************************************

     Private items.
     */


    var _ajaxTabContentLoader = function( tabLinkId ) {

        var $tabLink = $( '#' + tabLinkId ),
            route = $tabLink.data( 'route' );

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


    var _refreshContent = function( renders ) {

        if ( renders !== undefined ) {
            renders.forEach( function( render ) {
                if ( render.element !== undefined &&
                    render.content !== undefined ) {
                    $( render.element ).html( render.content );
                }
            } );
        }

    };


    var _ajaxFormSubmission = function( form, isSubmit ) {

        var $form = $( form ),
            ckeInstance = null;

        if ( isSubmit === undefined || ! isSubmit ) {
            isSubmit = false;
        } else {
            isSubmit = true;
        }

        $form.find( '.cke' ).each( function( ) {
            ckeInstance = $( this ).siblings( 'textarea' ).attr( 'id' );
            CKEDITOR.instances[ ckeInstance ].destroy( );
        } );

        $.ajax( {
            type: 'POST',
            enctype: 'multipart/form-data',
            processData: false, // Preventing default serialization.
            contentType: false, // No auto “contentType” header.
            url: $form.parent( '.tab-pane' ).data( 'submit-url' ),
            data: new FormData( form ),
            cache: false,
            timeout: 10000
        } ).done( function( response ) {
            if ( isSubmit ) {
                Syllabus.handleAjaxResponse( response );
            } else {
                _refreshContent( response.renders );
            }
        } ).always( function( ) {
            if ( isSubmit ) {
                SILTools.spinner.fadeOut( );
            }
        } );

    };



    /**************************************************************************

     Public items.
     */


    var temporaryItem = null,
        ckeConfig = {
            "toolbar": [
                [
                    "RemoveFormat",
                    "-",
                    "Bold",
                    "Italic",
                    "Underline"
                ],
                "-",
                [
                    "Outdent",
                    "Indent",
                    "-",
                    "NumberedList",
                    "BulletedList"
                ],
                "-",
                [
                    "Link"
                ]
            ],
            "removeButtons": null,
            "removePlugins": "elementspath",
            "resize_enabled": false
        };

    var addFormToCollection = function( collection, placeholder ) {
        if(!placeholder) placeholder = '__name__';
        var prototype = collection.data( 'prototype' ),
            regex = new RegExp(placeholder, 'g'),
            index = collection.data( 'index' ),
            newForm = prototype.replace(regex, index ),
            form = $( newForm );
        collection.data( 'index', index + 1 );
        collection.append( form );

        return form;

    };



    var handleAjaxResponse = function( response ) {
        if ( response.messages !== undefined ) {
            response.messages.forEach( function( message ) {
                if ( message.type !== undefined &&
                    message.message !== undefined ) {
                    SILTools.alert( {
                        type: message.type,
                        text: message.message
                    } );
                }
            } );
        }

        _refreshContent( response.renders );

    };

    /**
     *
     * @param response
     * @param $modal_app_body
     * @returns {boolean}
     */
    function handleAjaxResponseModal(response, $modal_app_body)
    {
        let status = (response.status) ? response.status : false;
        let content = (response.content) ? response.content : null;
        let message = (response.message)? response.message : null;
        if(response.status !== true)
        {
            let type = 'danger';
            let text = "Une erreur est survenue";
            if(message)
            {
                type = (message.type)? message.type : type;
                text = (message.text)? message.text : text;
                if(content && $modal_app_body) $modal_app_body.html(content);
            }
            else
            {
                text = (content)? content : text;
            }
            if(type !== 'none')
            {
                SILTools.alert( {
                    type: type,
                    text: text
                } );
            }
        }
        return status;
    }

    var handleModalAction = function (
        $modal_app,
        $modal_app_title,
        $modal_app_body,
        title,
        url,
        event
    ) {
        $.get(
            url
        ).done(function(response){
            if(handleAjaxResponseModal(response, $modal_app_body)) {
                $modal_app_title.html(title);
                $modal_app_body.html(response.content);
                $modal_app.modal('show');
                $modal_app.data('action-event', event);
            }
        });
    };

    var removeListElement = function( $element ) {

        $element.fadeOut( {
            always: function( ) {
                $element.find( '.cke' ).each( function( ) {
                    CKEDITOR.instances[ $( this ).siblings( 'textarea' ).attr( 'id' ) ].destroy( );
                } );
                $element.remove( );
            }
        } );
    };


    var setMediaFrameAttributes = function( mediaFrame ) {

        if ( mediaFrame ) {
            // Unnecessary attributes removal.
            mediaFrame.removeAttribute( 'width' );
            mediaFrame.removeAttribute( 'height' );
            // Feature policy removal.
            mediaFrame.removeAttribute( 'allow' );
            // Deprecated attributes removal.
            mediaFrame.removeAttribute( 'align' );
            mediaFrame.removeAttribute( 'frameborder' );
            mediaFrame.removeAttribute( 'longdesc' );
            mediaFrame.removeAttribute( 'marginheight' );
            mediaFrame.removeAttribute( 'marginwidth' );
            mediaFrame.removeAttribute( 'scrolling' );
            // Non standard attributes removal.
            mediaFrame.removeAttribute( 'mozbrowser' );
            // Style reset.
            mediaFrame.setAttribute( 'style', "padding:0;margin:0;border:0" );
            // BS “embed” class.
            mediaFrame.classList.add( 'embed-responsive-item' );
        }

    };


    var submitPanelForm = function( event, form ) {

        event.preventDefault( );

        SILTools.spinner.fadeIn( {
            always: _ajaxFormSubmission( form, true )
        } );

    };


    var tabsInit = function( ) {

        $( 'a[data-toggle="tab"]' ).on( 'hide.bs.tab', function( event ) {
            _ajaxFormSubmission( $( '#panel_' + event.target.id ).find( 'form' )[ 0 ] );
            _ajaxTabContentLoader( event.relatedTarget.id );
        } );

        _ajaxTabContentLoader( 'tab-1' );

    };

    /*
        Sortable
     */

    var sortable = function ($list) {
        let url = $list.data('url');
        new Sortable($list.get(0), {
            animation: 150,
            onEnd: function (evt) {
                if (evt.oldIndex !== evt.newIndex)
                {
                    let sortList = $list.find('.item-sortable').map(function () {
                        return $(this).data('id');
                    }).get();
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {data: sortList}
                    });
                }
            }
        });
    };


    /*
        Public pointers to exposed items.
    */

    return {
        addFormToCollection: addFormToCollection,
        ckeConfig: ckeConfig,
        handleAjaxResponse: handleAjaxResponse,
        handleAjaxResponseModal: handleAjaxResponseModal,
        handleModalAction: handleModalAction,
        removeListElement: removeListElement,
        setMediaFrameAttributes: setMediaFrameAttributes,
        submitPanelForm: submitPanelForm,
        tabsInit: tabsInit,
        sortable: sortable,
    };



} ) ( );


export default Syllabus;

