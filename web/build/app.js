(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["app"],{

/***/ "./app/Resources/assets/js/app.js":
/*!****************************************!*\
  !*** ./app/Resources/assets/js/app.js ***!
  \****************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* WEBPACK VAR INJECTION */(function(__webpack_provided_window_dot_jQuery, global) {/* harmony import */ var _scss_sil_toolkit_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../scss/sil_toolkit.scss */ "./app/Resources/assets/scss/sil_toolkit.scss");
/* harmony import */ var _scss_sil_toolkit_scss__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_scss_sil_toolkit_scss__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _scss_app_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../scss/app.scss */ "./app/Resources/assets/scss/app.scss");
/* harmony import */ var _scss_app_scss__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_scss_app_scss__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var bootbox__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! bootbox */ "./node_modules/bootbox/dist/bootbox.all.min.js");
/* harmony import */ var bootbox__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(bootbox__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var bootstrap4_toggle__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! bootstrap4-toggle */ "./node_modules/bootstrap4-toggle/js/bootstrap4-toggle.js");
/* harmony import */ var bootstrap4_toggle__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(bootstrap4_toggle__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _sil_toolkit__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./sil_toolkit */ "./app/Resources/assets/js/sil_toolkit.js");
/* harmony import */ var _syllabus__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./syllabus */ "./app/Resources/assets/js/syllabus.js");
/* harmony import */ var jquery_sortablejs__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! jquery-sortablejs */ "./node_modules/jquery-sortablejs/jquery-sortable.js");
/* harmony import */ var jquery_sortablejs__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(jquery_sortablejs__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var bootstrap__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.js");
/* harmony import */ var bootstrap__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(bootstrap__WEBPACK_IMPORTED_MODULE_8__);
/*
        Main Webpack entry point.


*/

/*
    Importing dependencies
*/
// SASS / CSS dependencies.

 // Importing modules…





 // … and make them visible to external components.

global.$ = window.$ = global.jQuery = __webpack_provided_window_dot_jQuery = jquery__WEBPACK_IMPORTED_MODULE_2___default.a;
global.bootbox = bootbox__WEBPACK_IMPORTED_MODULE_3___default.a;
global.bootstrapToggle = bootstrap4_toggle__WEBPACK_IMPORTED_MODULE_4___default.a;
global.SILTools = _sil_toolkit__WEBPACK_IMPORTED_MODULE_5__["default"];
global.Syllabus = _syllabus__WEBPACK_IMPORTED_MODULE_6__["default"];
/*
    SortableJS with jQuery binding.
*/


/*
    Full Bootstrap…
*/


/*
    … or parts of it.

import 'bootstrap/js/dist/alert';
import 'bootstrap/js/dist/button';
//import 'bootstrap/js/dist/carousel';
import 'bootstrap/js/dist/collapse';
//import 'bootstrap/js/dist/dropdown';
//import 'bootstrap/js/dist/index';
import 'bootstrap/js/dist/modal';
//import 'bootstrap/js/dist/popover';
import 'bootstrap/js/dist/scrollspy';
import 'bootstrap/js/dist/tab';
//import 'bootstrap/js/dist/toast';
//import 'bootstrap/js/dist/tooltip';
import 'bootstrap/js/dist/util';
*/

/*
    Bootbox locale (fr).
        http://bootboxjs.com/documentation.html
*/

bootbox__WEBPACK_IMPORTED_MODULE_3___default.a.addLocale('fr', {
  OK: 'OK',
  CANCEL: 'Annuler',
  CONFIRM: 'Confirmer'
});
bootbox__WEBPACK_IMPORTED_MODULE_3___default.a.setLocale('fr');
/*
    AJAX error handler.
*/

jquery__WEBPACK_IMPORTED_MODULE_2___default()(document).ready(function () {
  jquery__WEBPACK_IMPORTED_MODULE_2___default()(document).ajaxError(function (event, jqXHR, ajaxSettings, thrownError) {
    console.log({
      event: event,
      jqXHR: jqXHR,
      ajaxSettings: ajaxSettings,
      thrownError: thrownError
    });
    _sil_toolkit__WEBPACK_IMPORTED_MODULE_5__["default"].alert({
      type: 'danger',
      text: "Une erreur est survenue (" + jqXHR.status + ")."
    });
  });
});
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js"), __webpack_require__(/*! ./../../../../node_modules/webpack/buildin/global.js */ "./node_modules/webpack/buildin/global.js")))

/***/ }),

/***/ "./app/Resources/assets/js/sil_toolkit.js":
/*!************************************************!*\
  !*** ./app/Resources/assets/js/sil_toolkit.js ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);
/******************************************************************************

        SIL tools module.

*/


var SILTools = function () {
  "use strict";
  /**************************************************************************
           Private items.
  */

  var MS_BEFORE_ALERT_DISMISS = 5000,
      NON_AUTO_DISMISSIBLE_ALERT_TYPES = [//'info',
  //'warning',
  'danger'];

  var _$loadingSpinner = jquery__WEBPACK_IMPORTED_MODULE_0___default()('#loading_spinner'),
      _$alertContainer = jquery__WEBPACK_IMPORTED_MODULE_0___default()('#alerts_container'),
      _messages = {};

  var _removeItem = function _removeItem(item) {
    jquery__WEBPACK_IMPORTED_MODULE_0___default()(item.elem).remove();
  };

  var _resetMessages = function _resetMessages() {
    _messages = {
      'light': [],
      'dark': [],
      'secondary': [],
      'primary': [],
      'success': [],
      'info': [],
      'warning': [],
      'danger': []
    };
  };

  var _displayAllBSAlerts = function _displayAllBSAlerts() {
    for (var key in _messages) {
      var message = _messages[key];

      for (var index in message) {
        var $button = jquery__WEBPACK_IMPORTED_MODULE_0___default()("<button>", {
          'type': "button",
          'class': "close",
          'data-dismiss': "alert",
          'aria-label': "Close",
          'html': '<span aria-hidden="true">&times;</span>'
        }),
            $alert = jquery__WEBPACK_IMPORTED_MODULE_0___default()("<div>", {
          'class': "alert alert-dismissible fade show alert-" + key,
          'html': message[index],
          'css': {
            'display': 'none'
          }
        });

        _$alertContainer.prepend($alert.append($button));

        if (NON_AUTO_DISMISSIBLE_ALERT_TYPES.includes(key)) {
          $alert.slideDown();
        } else {
          $alert.slideDown().delay(MS_BEFORE_ALERT_DISMISS).slideUp({
            always: _removeItem
          });
        }
      }
    }

    _resetMessages();
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


  var alert = function alert(alertData) {
    if (alertData === undefined) {
      _displayAllBSAlerts();
    } else {
      if (alertData.type === undefined //|| ! ( alertData.type in _messages )
      || !_messages.hasOwnProperty(alertData.type)) {
        alertData.type = 'danger';
      }

      if (alertData.text === undefined) {
        alertData.text = "Une erreur est survenue.";
      }

      if (alertData.keep === undefined) {
        alertData.keep = false;
      }

      _messages[alertData.type].push(alertData.text);

      if (!alertData.keep) {
        _displayAllBSAlerts();
      }
    }
  };
  /**************************************************************************
           Init.
  */


  _resetMessages();
  /*
      Public pointers to exposed items.
  */


  return {
    spinner: _$loadingSpinner,
    alert: alert
  };
}();

/* harmony default export */ __webpack_exports__["default"] = (SILTools);

/***/ }),

/***/ "./app/Resources/assets/js/syllabus.js":
/*!*********************************************!*\
  !*** ./app/Resources/assets/js/syllabus.js ***!
  \*********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _sil_toolkit__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./sil_toolkit */ "./app/Resources/assets/js/sil_toolkit.js");
/******************************************************************************

        Syllabus module.

*/



var Syllabus = function () {
  "use strict";
  /**************************************************************************
           Private items.
  */

  var _ajaxTabContentLoader = function _ajaxTabContentLoader($tabLink) {
    var route = $tabLink.data('route');

    if (route !== "") {
      _sil_toolkit__WEBPACK_IMPORTED_MODULE_1__["default"].spinner.fadeIn({
        always: function always() {
          jquery__WEBPACK_IMPORTED_MODULE_0___default.a.ajax({
            type: 'POST',
            url: route,
            context: jquery__WEBPACK_IMPORTED_MODULE_0___default()('#panel_' + $tabLink.attr('id'))
          }).done(function (data) {
            if (data.content !== undefined) {
              jquery__WEBPACK_IMPORTED_MODULE_0___default()(this).html(data.content);
              $tabLink.data('route', "");
            }

            if (data.alert !== undefined) {
              if (data.alert.type !== undefined && data.alert.message !== undefined) {
                _sil_toolkit__WEBPACK_IMPORTED_MODULE_1__["default"].alert({
                  type: data.alert.type,
                  text: data.alert.message
                });
              }
            }
          }).always(function () {
            _sil_toolkit__WEBPACK_IMPORTED_MODULE_1__["default"].spinner.fadeOut();
          });
        }
      });
    }
  };

  var _saveCurrentTabContent = function _saveCurrentTabContent(tabLink) {
    var $panel = jquery__WEBPACK_IMPORTED_MODULE_0___default()('#panel_' + tabLink.id),
        form = document.getElementsByName($panel.find('form').attr('name'))[0];
    jquery__WEBPACK_IMPORTED_MODULE_0___default()(form).find('textarea').each(function (index) {
      CKEDITOR.instances[jquery__WEBPACK_IMPORTED_MODULE_0___default()(this).attr('id')].updateElement();
    });
    jquery__WEBPACK_IMPORTED_MODULE_0___default.a.ajax({
      type: 'POST',
      enctype: 'multipart/form-data',
      processData: false,
      // Preventing default data parse behavior.
      contentType: false,
      url: $panel.data('submit-url'),
      data: new FormData(form),
      cache: false,
      timeout: 5000
      /*
      } ).done( function( ) {
      SILTools.alert( {
      type: 'info',
      text: "Les données de l'onglet précédent ont été sauvegardées."
      } ); //*/

    });
  };
  /**************************************************************************
           Public items.
  */


  var tabsInit = function tabsInit() {
    jquery__WEBPACK_IMPORTED_MODULE_0___default()('a[data-toggle="tab"]').on('click', function () {
      _ajaxTabContentLoader(jquery__WEBPACK_IMPORTED_MODULE_0___default()(this));
    }).on('hide.bs.tab', function (event) {
      _saveCurrentTabContent(event.target);
    });
    ;
    jquery__WEBPACK_IMPORTED_MODULE_0___default()('#tab-1').addClass('active');

    _ajaxTabContentLoader(jquery__WEBPACK_IMPORTED_MODULE_0___default()('#tab-1'));
  };

  var handleAjaxResponse = function handleAjaxResponse(response) {
    if (response.messages !== undefined) {
      response.messages.forEach(function (message) {
        if (message.type !== undefined && message.message !== undefined) {
          _sil_toolkit__WEBPACK_IMPORTED_MODULE_1__["default"].alert({
            type: message.type,
            text: message.message
          });
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

  };
  /*
      Public pointers to exposed items.
  */


  return {
    tabsInit: tabsInit,
    handleAjaxResponse: handleAjaxResponse
  };
}();

/* harmony default export */ __webpack_exports__["default"] = (Syllabus);

/***/ }),

/***/ "./app/Resources/assets/scss/app.scss":
/*!********************************************!*\
  !*** ./app/Resources/assets/scss/app.scss ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ }),

/***/ "./app/Resources/assets/scss/sil_toolkit.scss":
/*!****************************************************!*\
  !*** ./app/Resources/assets/scss/sil_toolkit.scss ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ })

},[["./app/Resources/assets/js/app.js","runtime","vendors~app~select2","vendors~app"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hcHAvUmVzb3VyY2VzL2Fzc2V0cy9qcy9hcHAuanMiLCJ3ZWJwYWNrOi8vLy4vYXBwL1Jlc291cmNlcy9hc3NldHMvanMvc2lsX3Rvb2xraXQuanMiLCJ3ZWJwYWNrOi8vLy4vYXBwL1Jlc291cmNlcy9hc3NldHMvanMvc3lsbGFidXMuanMiLCJ3ZWJwYWNrOi8vLy4vYXBwL1Jlc291cmNlcy9hc3NldHMvc2Nzcy9hcHAuc2Nzcz8yMTg4Iiwid2VicGFjazovLy8uL2FwcC9SZXNvdXJjZXMvYXNzZXRzL3Njc3Mvc2lsX3Rvb2xraXQuc2Nzcz9hZjVjIl0sIm5hbWVzIjpbImdsb2JhbCIsIiQiLCJ3aW5kb3ciLCJqUXVlcnkiLCJib290Ym94IiwiYm9vdHN0cmFwVG9nZ2xlIiwiU0lMVG9vbHMiLCJTeWxsYWJ1cyIsImFkZExvY2FsZSIsIk9LIiwiQ0FOQ0VMIiwiQ09ORklSTSIsInNldExvY2FsZSIsImRvY3VtZW50IiwicmVhZHkiLCJhamF4RXJyb3IiLCJldmVudCIsImpxWEhSIiwiYWpheFNldHRpbmdzIiwidGhyb3duRXJyb3IiLCJjb25zb2xlIiwibG9nIiwiYWxlcnQiLCJ0eXBlIiwidGV4dCIsInN0YXR1cyIsIk1TX0JFRk9SRV9BTEVSVF9ESVNNSVNTIiwiTk9OX0FVVE9fRElTTUlTU0lCTEVfQUxFUlRfVFlQRVMiLCJfJGxvYWRpbmdTcGlubmVyIiwiXyRhbGVydENvbnRhaW5lciIsIl9tZXNzYWdlcyIsIl9yZW1vdmVJdGVtIiwiaXRlbSIsImVsZW0iLCJyZW1vdmUiLCJfcmVzZXRNZXNzYWdlcyIsIl9kaXNwbGF5QWxsQlNBbGVydHMiLCJrZXkiLCJtZXNzYWdlIiwiaW5kZXgiLCIkYnV0dG9uIiwiJGFsZXJ0IiwicHJlcGVuZCIsImFwcGVuZCIsImluY2x1ZGVzIiwic2xpZGVEb3duIiwiZGVsYXkiLCJzbGlkZVVwIiwiYWx3YXlzIiwiYWxlcnREYXRhIiwidW5kZWZpbmVkIiwiaGFzT3duUHJvcGVydHkiLCJrZWVwIiwicHVzaCIsInNwaW5uZXIiLCJfYWpheFRhYkNvbnRlbnRMb2FkZXIiLCIkdGFiTGluayIsInJvdXRlIiwiZGF0YSIsImZhZGVJbiIsImFqYXgiLCJ1cmwiLCJjb250ZXh0IiwiYXR0ciIsImRvbmUiLCJjb250ZW50IiwiaHRtbCIsImZhZGVPdXQiLCJfc2F2ZUN1cnJlbnRUYWJDb250ZW50IiwidGFiTGluayIsIiRwYW5lbCIsImlkIiwiZm9ybSIsImdldEVsZW1lbnRzQnlOYW1lIiwiZmluZCIsImVhY2giLCJDS0VESVRPUiIsImluc3RhbmNlcyIsInVwZGF0ZUVsZW1lbnQiLCJlbmN0eXBlIiwicHJvY2Vzc0RhdGEiLCJjb250ZW50VHlwZSIsIkZvcm1EYXRhIiwiY2FjaGUiLCJ0aW1lb3V0IiwidGFic0luaXQiLCJvbiIsInRhcmdldCIsImFkZENsYXNzIiwiaGFuZGxlQWpheFJlc3BvbnNlIiwicmVzcG9uc2UiLCJtZXNzYWdlcyIsImZvckVhY2giXSwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7Ozs7OztBQVFBOzs7QUFJQTtBQUNBO0NBR0E7O0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Q0FHQTs7QUFDQUEsTUFBTSxDQUFDQyxDQUFQLEdBQVdDLE1BQU0sQ0FBQ0QsQ0FBUCxHQUFXRCxNQUFNLENBQUNHLE1BQVAsR0FBZ0JELG9DQUFBLEdBQWdCRCw2Q0FBdEQ7QUFDQUQsTUFBTSxDQUFDSSxPQUFQLEdBQWlCQSw4Q0FBakI7QUFDQUosTUFBTSxDQUFDSyxlQUFQLEdBQXlCQSx3REFBekI7QUFDQUwsTUFBTSxDQUFDTSxRQUFQLEdBQWtCQSxvREFBbEI7QUFDQU4sTUFBTSxDQUFDTyxRQUFQLEdBQWtCQSxpREFBbEI7QUFJQTs7OztBQUlBO0FBSUE7Ozs7QUFJQTtBQUlBOzs7Ozs7Ozs7Ozs7Ozs7Ozs7QUFvQkE7Ozs7O0FBS0FILDhDQUFP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Ozs7Ozs7QUNoSkEsdUM7Ozs7Ozs7Ozs7O0FDQUEsdUMiLCJmaWxlIjoiYXBwLmpzIiwic291cmNlc0NvbnRlbnQiOlsiLypcbiAgICAgICAgTWFpbiBXZWJwYWNrIGVudHJ5IHBvaW50LlxuXG5cbiovXG5cblxuXG4vKlxuICAgIEltcG9ydGluZyBkZXBlbmRlbmNpZXNcbiovXG5cbi8vIFNBU1MgLyBDU1MgZGVwZW5kZW5jaWVzLlxuaW1wb3J0ICcuLi9zY3NzL3NpbF90b29sa2l0LnNjc3MnO1xuaW1wb3J0ICcuLi9zY3NzL2FwcC5zY3NzJztcblxuLy8gSW1wb3J0aW5nIG1vZHVsZXPigKZcbmltcG9ydCAkIGZyb20gJ2pxdWVyeSc7XG5pbXBvcnQgYm9vdGJveCBmcm9tICdib290Ym94JztcbmltcG9ydCBib290c3RyYXBUb2dnbGUgZnJvbSAnYm9vdHN0cmFwNC10b2dnbGUnO1xuaW1wb3J0IFNJTFRvb2xzIGZyb20gJy4vc2lsX3Rvb2xraXQnO1xuaW1wb3J0IFN5bGxhYnVzIGZyb20gJy4vc3lsbGFidXMnO1xuXG4vLyDigKYgYW5kIG1ha2UgdGhlbSB2aXNpYmxlIHRvIGV4dGVybmFsIGNvbXBvbmVudHMuXG5nbG9iYWwuJCA9IHdpbmRvdy4kID0gZ2xvYmFsLmpRdWVyeSA9IHdpbmRvdy5qUXVlcnkgPSAkO1xuZ2xvYmFsLmJvb3Rib3ggPSBib290Ym94O1xuZ2xvYmFsLmJvb3RzdHJhcFRvZ2dsZSA9IGJvb3RzdHJhcFRvZ2dsZTtcbmdsb2JhbC5TSUxUb29scyA9IFNJTFRvb2xzO1xuZ2xvYmFsLlN5bGxhYnVzID0gU3lsbGFidXM7XG5cblxuXG4vKlxuICAgIFNvcnRhYmxlSlMgd2l0aCBqUXVlcnkgYmluZGluZy5cbiovXG5cbmltcG9ydCAnanF1ZXJ5LXNvcnRhYmxlanMnO1xuXG5cblxuLypcbiAgICBGdWxsIEJvb3RzdHJhcOKAplxuKi9cblxuaW1wb3J0ICdib290c3RyYXAnO1xuXG5cblxuLypcbiAgICDigKYgb3IgcGFydHMgb2YgaXQuXG5cbmltcG9ydCAnYm9vdHN0cmFwL2pzL2Rpc3QvYWxlcnQnO1xuaW1wb3J0ICdib290c3RyYXAvanMvZGlzdC9idXR0b24nO1xuLy9pbXBvcnQgJ2Jvb3RzdHJhcC9qcy9kaXN0L2Nhcm91c2VsJztcbmltcG9ydCAnYm9vdHN0cmFwL2pzL2Rpc3QvY29sbGFwc2UnO1xuLy9pbXBvcnQgJ2Jvb3RzdHJhcC9qcy9kaXN0L2Ryb3Bkb3duJztcbi8vaW1wb3J0ICdib290c3RyYXAvanMvZGlzdC9pbmRleCc7XG5pbXBvcnQgJ2Jvb3RzdHJhcC9qcy9kaXN0L21vZGFsJztcbi8vaW1wb3J0ICdib290c3RyYXAvanMvZGlzdC9wb3BvdmVyJztcbmltcG9ydCAnYm9vdHN0cmFwL2pzL2Rpc3Qvc2Nyb2xsc3B5JztcbmltcG9ydCAnYm9vdHN0cmFwL2pzL2Rpc3QvdGFiJztcbi8vaW1wb3J0ICdib290c3RyYXAvanMvZGlzdC90b2FzdCc7XG4vL2ltcG9ydCAnYm9vdHN0cmFwL2pzL2Rpc3QvdG9vbHRpcCc7XG5pbXBvcnQgJ2Jvb3RzdHJhcC9qcy9kaXN0L3V0aWwnO1xuKi9cblxuXG5cbi8qXG4gICAgQm9vdGJveCBsb2NhbGUgKGZyKS5cbiAgICAgICAgaHR0cDovL2Jvb3Rib3hqcy5jb20vZG9jdW1lbnRhdGlvbi5odG1sXG4qL1xuXG5ib290Ym94LmFkZExvY2FsZSggJ2ZyJywge1xuICAgICAgICBPSyAgICAgIDogJ09LJyxcbiAgICAgICAgQ0FOQ0VMICA6ICdBbm51bGVyJyxcbiAgICAgICAgQ09ORklSTSA6ICdDb25maXJtZXInXG4gICAgfSApO1xuYm9vdGJveC5zZXRMb2NhbGUoICdmcicgKTtcblxuXG5cbi8qXG4gICAgQUpBWCBlcnJvciBoYW5kbGVyLlxuKi9cblxuJCggZG9jdW1lbnQgKS5yZWFkeSggZnVuY3Rpb24oICkge1xuXG4gICAgJCggZG9jdW1lbnQgKS5hamF4RXJyb3IoIGZ1bmN0aW9uKCBldmVudCwganFYSFIsIGFqYXhTZXR0aW5ncywgdGhyb3duRXJyb3IgKSB7XG5cbiAgICAgICAgY29uc29sZS5sb2coIHsgZXZlbnQsIGpxWEhSLCBhamF4U2V0dGluZ3MsIHRocm93bkVycm9yIH0gKTtcbiAgICAgICAgU0lMVG9vbHMuYWxlcnQoIHtcbiAgICAgICAgICAgIHR5cGU6ICdkYW5nZXInLFxuICAgICAgICAgICAgdGV4dDogXCJVbmUgZXJyZXVyIGVzdCBzdXJ2ZW51ZSAoXCIgKyBqcVhIUi5zdGF0dXMgKyBcIikuXCJcbiAgICAgICAgfSApO1xuXG4gICAgfSApO1xuXG59ICk7XG5cbiIsIi8qKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKipcblxuICAgICAgICBTSUwgdG9vbHMgbW9kdWxlLlxuXG4qL1xuXG5cbmltcG9ydCAkIGZyb20gJ2pxdWVyeSc7XG5cblxuXG52YXIgU0lMVG9vbHMgPSAoIGZ1bmN0aW9uICggKSB7XG5cblxuICAgIFwidXNlIHN0cmljdFwiO1xuXG5cbiAgICAvKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKipcblxuICAgICAgICAgICAgUHJpdmF0ZSBpdGVtcy5cbiAgICAqL1xuXG5cbiAgICBjb25zdCBNU19CRUZPUkVfQUxFUlRfRElTTUlTUyA9IDUwMDAsXG4gICAgICAgIE5PTl9BVVRPX0RJU01JU1NJQkxFX0FMRVJUX1RZUEVTID0gW1xuICAgICAgICAgICAgICAgIC8vJ2luZm8nLFxuICAgICAgICAgICAgICAgIC8vJ3dhcm5pbmcnLFxuICAgICAgICAgICAgICAgICdkYW5nZXInXG4gICAgICAgICAgICBdO1xuXG4gICAgdmFyIF8kbG9hZGluZ1NwaW5uZXIgPSAkKCAnI2xvYWRpbmdfc3Bpbm5lcicgKSxcbiAgICAgICAgXyRhbGVydENvbnRhaW5lciA9ICQoICcjYWxlcnRzX2NvbnRhaW5lcicgKSxcbiAgICAgICAgX21lc3NhZ2VzID0geyB9O1xuXG5cbiAgICB2YXIgX3JlbW92ZUl0ZW0gPSBmdW5jdGlvbiggaXRlbSApIHtcblxuICAgICAgICAkKCBpdGVtLmVsZW0gKS5yZW1vdmUoICk7XG5cbiAgICB9O1xuXG5cbiAgICB2YXIgX3Jlc2V0TWVzc2FnZXMgPSBmdW5jdGlvbiggKSB7XG5cbiAgICAgICAgX21lc3NhZ2VzID0ge1xuICAgICAgICAgICAgJ2xpZ2h0JzogWyBdLFxuICAgICAgICAgICAgJ2RhcmsnOiBbIF0sXG4gICAgICAgICAgICAnc2Vjb25kYXJ5JzogWyBdLFxuICAgICAgICAgICAgJ3ByaW1hcnknOiBbIF0sXG4gICAgICAgICAgICAnc3VjY2Vzcyc6IFsgXSxcbiAgICAgICAgICAgICdpbmZvJzogWyBdLFxuICAgICAgICAgICAgJ3dhcm5pbmcnOiBbIF0sXG4gICAgICAgICAgICAnZGFuZ2VyJzogWyBdXG4gICAgICAgIH07XG5cbiAgICB9O1xuXG5cbiAgICB2YXIgX2Rpc3BsYXlBbGxCU0FsZXJ0cyA9IGZ1bmN0aW9uKCApIHtcblxuICAgICAgICBmb3IgKCB2YXIga2V5IGluIF9tZXNzYWdlcyApIHtcblxuICAgICAgICAgICAgdmFyIG1lc3NhZ2UgPSBfbWVzc2FnZXNbIGtleSBdO1xuXG4gICAgICAgICAgICBmb3IgKCB2YXIgaW5kZXggaW4gbWVzc2FnZSApIHtcblxuICAgICAgICAgICAgICAgIHZhciAkYnV0dG9uID0gJCggXCI8YnV0dG9uPlwiLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICAndHlwZSc6IFwiYnV0dG9uXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAnY2xhc3MnOiBcImNsb3NlXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAnZGF0YS1kaXNtaXNzJzogXCJhbGVydFwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgJ2FyaWEtbGFiZWwnOiBcIkNsb3NlXCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAnaHRtbCc6ICc8c3BhbiBhcmlhLWhpZGRlbj1cInRydWVcIj4mdGltZXM7PC9zcGFuPidcbiAgICAgICAgICAgICAgICAgICAgfSApLFxuICAgICAgICAgICAgICAgICAgICAkYWxlcnQgPSAkKCBcIjxkaXY+XCIsIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICdjbGFzcyc6IFwiYWxlcnQgYWxlcnQtZGlzbWlzc2libGUgZmFkZSBzaG93IGFsZXJ0LVwiICsga2V5LFxuICAgICAgICAgICAgICAgICAgICAgICAgJ2h0bWwnOiBtZXNzYWdlWyBpbmRleCBdLFxuICAgICAgICAgICAgICAgICAgICAgICAgJ2Nzcyc6IHsgJ2Rpc3BsYXknOiAnbm9uZScgfVxuICAgICAgICAgICAgICAgICAgICB9ICk7XG5cbiAgICAgICAgICAgICAgICBfJGFsZXJ0Q29udGFpbmVyLnByZXBlbmQoICRhbGVydC5hcHBlbmQoICRidXR0b24gKSApO1xuXG4gICAgICAgICAgICAgICAgaWYgKCBOT05fQVVUT19ESVNNSVNTSUJMRV9BTEVSVF9UWVBFUy5pbmNsdWRlcygga2V5ICkgKSB7XG5cbiAgICAgICAgICAgICAgICAgICAgJGFsZXJ0LnNsaWRlRG93biggKTtcblxuICAgICAgICAgICAgICAgIH0gZWxzZSB7XG5cbiAgICAgICAgICAgICAgICAgICAgJGFsZXJ0LnNsaWRlRG93biggKS5kZWxheSggTVNfQkVGT1JFX0FMRVJUX0RJU01JU1MgKVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC5zbGlkZVVwKCB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGFsd2F5czogX3JlbW92ZUl0ZW0sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfSApO1xuXG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuICAgICAgICB9XG5cbiAgICAgICAgX3Jlc2V0TWVzc2FnZXMoICk7XG5cbiAgICB9O1xuXG5cblxuICAgIC8qKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKlxuXG4gICAgICAgICAgICBQdWJsaWMgaXRlbXMuXG4gICAgKi9cblxuXG4gICAgLyoqXG4gICAgICogQWRkcyBCUyBhbGVydHMgaW4g4oCcXyRhbGVydENvbnRhaW5lcuKAnS5cbiAgICAgKlxuICAgICAqIEV4YW1wbGVzIG9mIHVzZTpcbiAgICAgKiAgICAgIGFsZXJ0KCB7IHR5cGU6ICdpbmZvJywgdGV4dDogXCLigJxCbGFibGEuXCIgfSApO1xuICAgICAqICAgICAgICAgIC0+IGRpc3BsYXlzIOKAnEJsYWJsYS7igJ0gaW4gYW4g4oCcaW5mb+KAnSBhbGVydCBhcyB3ZWxsIGFzIGFsbCBvdGhlclxuICAgICAqICAgICAgICAgIHByZXZpb3VzbHkgYnVmZmVyZWQgYWxlcnRzLCBmbHVzaGVzIGJ1ZmZlci5cbiAgICAgKiAgICAgIGFsZXJ0KCB7IHR5cGU6ICd3YXJuaW5nJywgdGV4dDogXCJCbHVibHUuXCIsIGtlZXA6IHRydWUgfSApO1xuICAgICAqICAgICAgICAgIC0+IGFkZHMgYSB3YXJuaW5nIGFsZXJ0IHdpdGgg4oCcQmxhYmxhLuKAnSB0ZXh0IGluIHRoZSBidWZmZXIsXG4gICAgICogICAgICAgICAgZGlzcGxheXMgbm90aGluZy5cbiAgICAgKiAgICAgIGFsZXJ0KCApO1xuICAgICAqICAgICAgICAgIC0+IGRpc3BsYXlzIGFsbCBwcmV2aW91c2x5IGJ1ZmZlcmVkIGFsZXJ0cywgZmx1c2hlcyBidWZmZXIuXG4gICAgICpcbiAgICAgKiBAcGFyYW0ge29iamVjdH0gYWxlcnREYXRhOlxuICAgICAqICAgICAgdHlwZSAtPiBvbmUgb2YgdGhlIEJvb3RzdHJhcCBjb250ZXh0dWFsIGNsYXNzZXM7XG4gICAgICogICAgICB0ZXh0IC0+IHRoZSB0ZXh0IHRvIGRpc3BsYXk7XG4gICAgICogICAgICBrZWVwIC0+IOKAnHRydWXigJ0gdG8gc2ltcGx5IGFkZCBhbGVydCB0byBidWZmZXIsXG4gICAgICogICAgICAgICAgICAgIOKAnGZhbHNl4oCdIHRvIGRpc3BsYXkgYWxsIHByZXZpb3VzbHkgYnVmZmVyZWQgYWxlcnRzXG4gICAgICogICAgICAgICAgICAgIGFuZCBmbHVzaCBidWZmZXIuXG4gICAgICpcbiAgICAgKi9cbiAgICB2YXIgYWxlcnQgPSBmdW5jdGlvbiggYWxlcnREYXRhICkge1xuXG4gICAgICAgIGlmICggYWxlcnREYXRhID09PSB1bmRlZmluZWQgKSB7XG5cbiAgICAgICAgICAgIF9kaXNwbGF5QWxsQlNBbGVydHMoICk7XG5cbiAgICAgICAgfSBlbHNlIHtcblxuICAgICAgICAgICAgaWYgKCBhbGVydERhdGEudHlwZSA9PT0gdW5kZWZpbmVkXG4gICAgICAgICAgICAgICAgICAgIC8vfHwgISAoIGFsZXJ0RGF0YS50eXBlIGluIF9tZXNzYWdlcyApXG4gICAgICAgICAgICAgICAgICAgIHx8ICEgX21lc3NhZ2VzLmhhc093blByb3BlcnR5KCBhbGVydERhdGEudHlwZSApICkge1xuICAgICAgICAgICAgICAgIGFsZXJ0RGF0YS50eXBlID0gJ2Rhbmdlcic7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIGlmICggYWxlcnREYXRhLnRleHQgPT09IHVuZGVmaW5lZCApIHtcbiAgICAgICAgICAgICAgICBhbGVydERhdGEudGV4dCA9IFwiVW5lIGVycmV1ciBlc3Qgc3VydmVudWUuXCI7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIGlmICggYWxlcnREYXRhLmtlZXAgPT09IHVuZGVmaW5lZCApIHtcbiAgICAgICAgICAgICAgICBhbGVydERhdGEua2VlcCA9IGZhbHNlO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBfbWVzc2FnZXNbIGFsZXJ0RGF0YS50eXBlIF0ucHVzaCggYWxlcnREYXRhLnRleHQgKTtcblxuICAgICAgICAgICAgaWYgKCAhIGFsZXJ0RGF0YS5rZWVwICkge1xuICAgICAgICAgICAgICAgIF9kaXNwbGF5QWxsQlNBbGVydHMoICk7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgfVxuXG4gICAgfTtcblxuXG5cbiAgICAvKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKipcblxuICAgICAgICAgICAgSW5pdC5cbiAgICAqL1xuXG4gICAgX3Jlc2V0TWVzc2FnZXMoICk7XG5cblxuICAgIC8qXG4gICAgICAgIFB1YmxpYyBwb2ludGVycyB0byBleHBvc2VkIGl0ZW1zLlxuICAgICovXG5cbiAgICByZXR1cm4ge1xuICAgICAgICBzcGlubmVyOiBfJGxvYWRpbmdTcGlubmVyLFxuICAgICAgICBhbGVydDogYWxlcnRcbiAgICB9O1xuXG5cblxufSApICggKTtcblxuXG5leHBvcnQgZGVmYXVsdCBTSUxUb29scztcblxuIiwiLyoqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKlxuXG4gICAgICAgIFN5bGxhYnVzIG1vZHVsZS5cblxuKi9cblxuXG5pbXBvcnQgJCBmcm9tICdqcXVlcnknO1xuaW1wb3J0IFNJTFRvb2xzIGZyb20gJy4vc2lsX3Rvb2xraXQnO1xuXG5cblxudmFyIFN5bGxhYnVzID0gKCBmdW5jdGlvbiAoICkge1xuXG5cbiAgICBcInVzZSBzdHJpY3RcIjtcblxuXG4gICAgLyoqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqXG5cbiAgICAgICAgICAgIFByaXZhdGUgaXRlbXMuXG4gICAgKi9cblxuXG4gICAgdmFyIF9hamF4VGFiQ29udGVudExvYWRlciA9IGZ1bmN0aW9uKCAkdGFiTGluayApIHtcblxuICAgICAgICB2YXIgcm91dGUgPSAkdGFiTGluay5kYXRhKCAncm91dGUnICk7XG5cbiAgICAgICAgaWYgKCByb3V0ZSAhPT0gXCJcIiApIHtcblxuICAgICAgICAgICAgU0lMVG9vbHMuc3Bpbm5lci5mYWRlSW4oIHtcbiAgICAgICAgICAgICAgICBhbHdheXM6IGZ1bmN0aW9uKCApIHtcbiAgICAgICAgICAgICAgICAgICAgJC5hamF4KCB7XG4gICAgICAgICAgICAgICAgICAgICAgICB0eXBlOiAnUE9TVCcsXG4gICAgICAgICAgICAgICAgICAgICAgICB1cmw6IHJvdXRlLFxuICAgICAgICAgICAgICAgICAgICAgICAgY29udGV4dDogJCggJyNwYW5lbF8nICsgJHRhYkxpbmsuYXR0ciggJ2lkJyApIClcbiAgICAgICAgICAgICAgICAgICAgfSApLmRvbmUoIGZ1bmN0aW9uKCBkYXRhICkge1xuICAgICAgICAgICAgICAgICAgICAgICAgaWYgKCBkYXRhLmNvbnRlbnQgIT09IHVuZGVmaW5lZCApIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAkKCB0aGlzICkuaHRtbCggZGF0YS5jb250ZW50ICk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRhYkxpbmsuZGF0YSggJ3JvdXRlJywgXCJcIiApO1xuICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgaWYgKCBkYXRhLmFsZXJ0ICE9PSB1bmRlZmluZWQgKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYgKCBkYXRhLmFsZXJ0LnR5cGUgIT09IHVuZGVmaW5lZCAmJiBkYXRhLmFsZXJ0Lm1lc3NhZ2UgIT09IHVuZGVmaW5lZCApIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgU0lMVG9vbHMuYWxlcnQoIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHR5cGU6IGRhdGEuYWxlcnQudHlwZSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHRleHQ6IGRhdGEuYWxlcnQubWVzc2FnZVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9ICk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICB9ICkuYWx3YXlzKCBmdW5jdGlvbiggKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICBTSUxUb29scy5zcGlubmVyLmZhZGVPdXQoICk7XG4gICAgICAgICAgICAgICAgICAgIH0gKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9ICk7XG4gICAgICAgIH1cblxuICAgIH07XG5cblxuICAgIHZhciBfc2F2ZUN1cnJlbnRUYWJDb250ZW50ID0gZnVuY3Rpb24oIHRhYkxpbmsgKSB7XG5cbiAgICAgICAgdmFyICRwYW5lbCA9ICQoICcjcGFuZWxfJyArIHRhYkxpbmsuaWQgKSxcbiAgICAgICAgICAgIGZvcm0gPSBkb2N1bWVudC5nZXRFbGVtZW50c0J5TmFtZSggJHBhbmVsLmZpbmQoICdmb3JtJyApLmF0dHIoICduYW1lJyApIClbIDAgXTtcblxuICAgICAgICAkKCBmb3JtICkuZmluZCggJ3RleHRhcmVhJyApLmVhY2goIGZ1bmN0aW9uKCBpbmRleCApIHtcbiAgICAgICAgICAgIENLRURJVE9SLmluc3RhbmNlc1sgJCggdGhpcyApLmF0dHIoICdpZCcgKSBdLnVwZGF0ZUVsZW1lbnQoICk7XG4gICAgICAgIH0gKTtcblxuICAgICAgICAkLmFqYXgoIHtcbiAgICAgICAgICAgIHR5cGU6ICdQT1NUJyxcbiAgICAgICAgICAgIGVuY3R5cGU6ICdtdWx0aXBhcnQvZm9ybS1kYXRhJyxcbiAgICAgICAgICAgIHByb2Nlc3NEYXRhOiBmYWxzZSwgLy8gUHJldmVudGluZyBkZWZhdWx0IGRhdGEgcGFyc2UgYmVoYXZpb3IuXG4gICAgICAgICAgICBjb250ZW50VHlwZTogZmFsc2UsXG4gICAgICAgICAgICB1cmw6ICRwYW5lbC5kYXRhKCAnc3VibWl0LXVybCcgKSxcbiAgICAgICAgICAgIGRhdGE6IG5ldyBGb3JtRGF0YSggZm9ybSApLFxuICAgICAgICAgICAgY2FjaGU6IGZhbHNlLFxuICAgICAgICAgICAgdGltZW91dDogNTAwMCAvKlxuICAgICAgICB9ICkuZG9uZSggZnVuY3Rpb24oICkge1xuICAgICAgICAgICAgU0lMVG9vbHMuYWxlcnQoIHtcbiAgICAgICAgICAgICAgICB0eXBlOiAnaW5mbycsXG4gICAgICAgICAgICAgICAgdGV4dDogXCJMZXMgZG9ubsOpZXMgZGUgbCdvbmdsZXQgcHLDqWPDqWRlbnQgb250IMOpdMOpIHNhdXZlZ2FyZMOpZXMuXCJcbiAgICAgICAgICAgIH0gKTsgLy8qL1xuICAgICAgICB9ICk7XG5cbiAgICB9XG5cblxuXG4gICAgLyoqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqXG5cbiAgICAgICAgICAgIFB1YmxpYyBpdGVtcy5cbiAgICAqL1xuXG5cbiAgICB2YXIgdGFic0luaXQgPSBmdW5jdGlvbiggKSB7XG5cbiAgICAgICAgJCggJ2FbZGF0YS10b2dnbGU9XCJ0YWJcIl0nICkub24oICdjbGljaycsIGZ1bmN0aW9uKCApIHtcbiAgICAgICAgICAgIF9hamF4VGFiQ29udGVudExvYWRlciggJCggdGhpcyApICk7XG4gICAgICAgIH0gKS5vbiggJ2hpZGUuYnMudGFiJywgZnVuY3Rpb24oIGV2ZW50ICkge1xuICAgICAgICAgICAgX3NhdmVDdXJyZW50VGFiQ29udGVudCggZXZlbnQudGFyZ2V0ICk7XG4gICAgICAgIH0gKTs7XG5cbiAgICAgICAgJCggJyN0YWItMScgKS5hZGRDbGFzcyggJ2FjdGl2ZScgKTtcbiAgICAgICAgX2FqYXhUYWJDb250ZW50TG9hZGVyKCAkKCAnI3RhYi0xJyApICk7XG5cbiAgICB9O1xuXG5cbiAgICB2YXIgaGFuZGxlQWpheFJlc3BvbnNlID0gZnVuY3Rpb24oIHJlc3BvbnNlICkge1xuICAgICAgICBpZihyZXNwb25zZS5tZXNzYWdlcyAhPT0gdW5kZWZpbmVkKSB7XG4gICAgICAgICAgICByZXNwb25zZS5tZXNzYWdlcy5mb3JFYWNoKGZ1bmN0aW9uKG1lc3NhZ2Upe1xuICAgICAgICAgICAgICAgIGlmIChtZXNzYWdlLnR5cGUgIT09IHVuZGVmaW5lZCAmJiBtZXNzYWdlLm1lc3NhZ2UgIT09IHVuZGVmaW5lZCkge1xuICAgICAgICAgICAgICAgICAgICBTSUxUb29scy5hbGVydCgge1xuICAgICAgICAgICAgICAgICAgICAgICAgdHlwZTogbWVzc2FnZS50eXBlLFxuICAgICAgICAgICAgICAgICAgICAgICAgdGV4dDogbWVzc2FnZS5tZXNzYWdlXG4gICAgICAgICAgICAgICAgICAgIH0gKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgICAgICAvKlxuICAgICAgICBpZihyZXNwb25zZS5yZW5kZXJzICE9PSB1bmRlZmluZWQpIHtcbiAgICAgICAgICAgIHJlc3BvbnNlLnJlbmRlcnMuZm9yRWFjaChmdW5jdGlvbihyZW5kZXIpIHtcbiAgICAgICAgICAgICAgICBpZiAocmVuZGVyLmVsZW1lbnQgIT09IHVuZGVmaW5lZCAmJiByZW5kZXIuY29udGVudCAhPT0gdW5kZWZpbmVkKSB7XG4gICAgICAgICAgICAgICAgICAgICQocmVuZGVyLmVsZW1lbnQpLmh0bWwocmVuZGVyLmNvbnRlbnQpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9IC8vKi9cbiAgICB9XG5cblxuICAgIC8qXG4gICAgICAgIFB1YmxpYyBwb2ludGVycyB0byBleHBvc2VkIGl0ZW1zLlxuICAgICovXG5cbiAgICByZXR1cm4ge1xuICAgICAgICB0YWJzSW5pdDogdGFic0luaXQsXG4gICAgICAgIGhhbmRsZUFqYXhSZXNwb25zZTogaGFuZGxlQWpheFJlc3BvbnNlXG4gICAgfTtcblxuXG5cbn0gKSAoICk7XG5cblxuZXhwb3J0IGRlZmF1bHQgU3lsbGFidXM7XG5cbiIsIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpbiIsIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpbiJdLCJzb3VyY2VSb290IjoiIn0=