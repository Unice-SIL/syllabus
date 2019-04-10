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
  /**************************************************************************
           Public items.
  */


  var tabLoaderInit = function tabLoaderInit() {
    jquery__WEBPACK_IMPORTED_MODULE_0___default()('main > .row:first-child > div > ul.nav').on('click', 'li.nav-item > a', function () {
      _ajaxTabContentLoader(jquery__WEBPACK_IMPORTED_MODULE_0___default()(this));

      saveCurrentTabContent(jquery__WEBPACK_IMPORTED_MODULE_0___default()(this));
    });
    jquery__WEBPACK_IMPORTED_MODULE_0___default()('#tab-1').addClass('active');
    jquery__WEBPACK_IMPORTED_MODULE_0___default()('#tab-1').addClass('syllabus-tab-active');

    _ajaxTabContentLoader(jquery__WEBPACK_IMPORTED_MODULE_0___default()('#tab-1'));
  };

  var saveCurrentTabContent = function saveCurrentTabContent(tab) {
    if (!tab["0"].classList.contains('syllabus-tab-active')) {
      var active_tab_button = document.getElementsByClassName('syllabus-tab-active')[0];
      var active_tab = document.getElementById("panel_" + active_tab_button.id);
      var sumbit_button = active_tab.getElementsByClassName("submit")[0];
      sumbit_button.click();
      active_tab_button.classList.remove('syllabus-tab-active');
      tab.addClass('syllabus-tab-active');
    }
  };

  var handleAjaxResponse = function handleAjaxResponse(response) {
    if (response.messages !== undefined) {
      response.messages.forEach(function (message) {
        if (message.type !== undefined && message.message !== undefined) {
          _sil_toolkit__WEBPACK_IMPORTED_MODULE_1__["default"].alert({
            type: message.type,
            text: message.message,
            keep: false
          });
        }
      });
    }

    if (response.renders !== undefined) {
      response.renders.forEach(function (render) {
        if (render.element !== undefined && render.content !== undefined) {
          jquery__WEBPACK_IMPORTED_MODULE_0___default()(render.element).html(render.content);
        }
      });
    }
  };
  /*
      Public pointers to exposed items.
  */


  return {
    tabLoaderInit: tabLoaderInit,
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hcHAvUmVzb3VyY2VzL2Fzc2V0cy9qcy9hcHAuanMiLCJ3ZWJwYWNrOi8vLy4vYXBwL1Jlc291cmNlcy9hc3NldHMvanMvc2lsX3Rvb2xraXQuanMiLCJ3ZWJwYWNrOi8vLy4vYXBwL1Jlc291cmNlcy9hc3NldHMvanMvc3lsbGFidXMuanMiLCJ3ZWJwYWNrOi8vLy4vYXBwL1Jlc291cmNlcy9hc3NldHMvc2Nzcy9hcHAuc2Nzcz8yMTg4Iiwid2VicGFjazovLy8uL2FwcC9SZXNvdXJjZXMvYXNzZXRzL3Njc3Mvc2lsX3Rvb2xraXQuc2Nzcz9hZjVjIl0sIm5hbWVzIjpbImdsb2JhbCIsIiQiLCJ3aW5kb3ciLCJqUXVlcnkiLCJib290Ym94IiwiYm9vdHN0cmFwVG9nZ2xlIiwiU0lMVG9vbHMiLCJTeWxsYWJ1cyIsImFkZExvY2FsZSIsIk9LIiwiQ0FOQ0VMIiwiQ09ORklSTSIsInNldExvY2FsZSIsImRvY3VtZW50IiwicmVhZHkiLCJhamF4RXJyb3IiLCJldmVudCIsImpxWEhSIiwiYWpheFNldHRpbmdzIiwidGhyb3duRXJyb3IiLCJjb25zb2xlIiwibG9nIiwiYWxlcnQiLCJ0eXBlIiwidGV4dCIsInN0YXR1cyIsIk1TX0JFRk9SRV9BTEVSVF9ESVNNSVNTIiwiTk9OX0FVVE9fRElTTUlTU0lCTEVfQUxFUlRfVFlQRVMiLCJfJGxvYWRpbmdTcGlubmVyIiwiXyRhbGVydENvbnRhaW5lciIsIl9tZXNzYWdlcyIsIl9yZW1vdmVJdGVtIiwiaXRlbSIsImVsZW0iLCJyZW1vdmUiLCJfcmVzZXRNZXNzYWdlcyIsIl9kaXNwbGF5QWxsQlNBbGVydHMiLCJrZXkiLCJtZXNzYWdlIiwiaW5kZXgiLCIkYnV0dG9uIiwiJGFsZXJ0IiwicHJlcGVuZCIsImFwcGVuZCIsImluY2x1ZGVzIiwic2xpZGVEb3duIiwiZGVsYXkiLCJzbGlkZVVwIiwiYWx3YXlzIiwiYWxlcnREYXRhIiwidW5kZWZpbmVkIiwiaGFzT3duUHJvcGVydHkiLCJrZWVwIiwicHVzaCIsInNwaW5uZXIiLCJfYWpheFRhYkNvbnRlbnRMb2FkZXIiLCIkdGFiTGluayIsInJvdXRlIiwiZGF0YSIsImZhZGVJbiIsImFqYXgiLCJ1cmwiLCJjb250ZXh0IiwiYXR0ciIsImRvbmUiLCJjb250ZW50IiwiaHRtbCIsImZhZGVPdXQiLCJ0YWJMb2FkZXJJbml0Iiwib24iLCJzYXZlQ3VycmVudFRhYkNvbnRlbnQiLCJhZGRDbGFzcyIsInRhYiIsImNsYXNzTGlzdCIsImNvbnRhaW5zIiwiYWN0aXZlX3RhYl9idXR0b24iLCJnZXRFbGVtZW50c0J5Q2xhc3NOYW1lIiwiYWN0aXZlX3RhYiIsImdldEVsZW1lbnRCeUlkIiwiaWQiLCJzdW1iaXRfYnV0dG9uIiwiY2xpY2siLCJoYW5kbGVBamF4UmVzcG9uc2UiLCJyZXNwb25zZSIsIm1lc3NhZ2VzIiwiZm9yRWFjaCIsInJlbmRlcnMiLCJyZW5kZXIiLCJlbGVtZW50Il0sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7O0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBOzs7Ozs7QUFRQTs7O0FBSUE7QUFDQTtDQUdBOztBQUNBO0FBQ0E7QUFDQTtBQUNBO0NBR0E7O0FBQ0FBLE1BQU0sQ0FBQ0MsQ0FBUCxHQUFXQyxNQUFNLENBQUNELENBQVAsR0FBV0QsTUFBTSxDQUFDRyxNQUFQLEdBQWdCRCxvQ0FBQSxHQUFnQkQsNkNBQXREO0FBQ0FELE1BQU0sQ0FBQ0ksT0FBUCxHQUFpQkEsOENBQWpCO0FBQ0FKLE1BQU0sQ0FBQ0ssZUFBUCxHQUF5QkEsd0RBQXpCO0FBQ0FMLE1BQU0sQ0FBQ00sUUFBUCxHQUFrQkEsb0RBQWxCO0FBQ0FOLE1BQU0sQ0FBQ08sUUFBUCxHQUFrQkEsaURBQWxCO0FBSUE7Ozs7QUFJQTtBQUlBOzs7O0FBSUE7QUFJQTs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FBb0JBOzs7OztBQUtBSCw4Q0FBTyxDQUFDSSxTQUFSLENB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LEVBQUVBO0FBRmpCLEdBQVA7QUFPSCxDQXBIYyxFQUFmOztBQXVIZTNFLHVFQUFmLEU7Ozs7Ozs7Ozs7O0FDbklBLHVDOzs7Ozs7Ozs7OztBQ0FBLHVDIiwiZmlsZSI6ImFwcC5qcyIsInNvdXJjZXNDb250ZW50IjpbIi8qXG4gICAgICAgIE1haW4gV2VicGFjayBlbnRyeSBwb2ludC5cblxuXG4qL1xuXG5cblxuLypcbiAgICBJbXBvcnRpbmcgZGVwZW5kZW5jaWVzXG4qL1xuXG4vLyBTQVNTIC8gQ1NTIGRlcGVuZGVuY2llcy5cbmltcG9ydCAnLi4vc2Nzcy9zaWxfdG9vbGtpdC5zY3NzJztcbmltcG9ydCAnLi4vc2Nzcy9hcHAuc2Nzcyc7XG5cbi8vIEltcG9ydGluZyBtb2R1bGVz4oCmXG5pbXBvcnQgJCBmcm9tICdqcXVlcnknO1xuaW1wb3J0IGJvb3Rib3ggZnJvbSAnYm9vdGJveCc7XG5pbXBvcnQgYm9vdHN0cmFwVG9nZ2xlIGZyb20gJ2Jvb3RzdHJhcDQtdG9nZ2xlJztcbmltcG9ydCBTSUxUb29scyBmcm9tICcuL3NpbF90b29sa2l0JztcbmltcG9ydCBTeWxsYWJ1cyBmcm9tICcuL3N5bGxhYnVzJztcblxuLy8g4oCmIGFuZCBtYWtlIHRoZW0gdmlzaWJsZSB0byBleHRlcm5hbCBjb21wb25lbnRzLlxuZ2xvYmFsLiQgPSB3aW5kb3cuJCA9IGdsb2JhbC5qUXVlcnkgPSB3aW5kb3cualF1ZXJ5ID0gJDtcbmdsb2JhbC5ib290Ym94ID0gYm9vdGJveDtcbmdsb2JhbC5ib290c3RyYXBUb2dnbGUgPSBib290c3RyYXBUb2dnbGU7XG5nbG9iYWwuU0lMVG9vbHMgPSBTSUxUb29scztcbmdsb2JhbC5TeWxsYWJ1cyA9IFN5bGxhYnVzO1xuXG5cblxuLypcbiAgICBTb3J0YWJsZUpTIHdpdGggalF1ZXJ5IGJpbmRpbmcuXG4qL1xuXG5pbXBvcnQgJ2pxdWVyeS1zb3J0YWJsZWpzJztcblxuXG5cbi8qXG4gICAgRnVsbCBCb290c3RyYXDigKZcbiovXG5cbmltcG9ydCAnYm9vdHN0cmFwJztcblxuXG5cbi8qXG4gICAg4oCmIG9yIHBhcnRzIG9mIGl0LlxuXG5pbXBvcnQgJ2Jvb3RzdHJhcC9qcy9kaXN0L2FsZXJ0JztcbmltcG9ydCAnYm9vdHN0cmFwL2pzL2Rpc3QvYnV0dG9uJztcbi8vaW1wb3J0ICdib290c3RyYXAvanMvZGlzdC9jYXJvdXNlbCc7XG5pbXBvcnQgJ2Jvb3RzdHJhcC9qcy9kaXN0L2NvbGxhcHNlJztcbi8vaW1wb3J0ICdib290c3RyYXAvanMvZGlzdC9kcm9wZG93bic7XG4vL2ltcG9ydCAnYm9vdHN0cmFwL2pzL2Rpc3QvaW5kZXgnO1xuaW1wb3J0ICdib290c3RyYXAvanMvZGlzdC9tb2RhbCc7XG4vL2ltcG9ydCAnYm9vdHN0cmFwL2pzL2Rpc3QvcG9wb3Zlcic7XG5pbXBvcnQgJ2Jvb3RzdHJhcC9qcy9kaXN0L3Njcm9sbHNweSc7XG5pbXBvcnQgJ2Jvb3RzdHJhcC9qcy9kaXN0L3RhYic7XG4vL2ltcG9ydCAnYm9vdHN0cmFwL2pzL2Rpc3QvdG9hc3QnO1xuLy9pbXBvcnQgJ2Jvb3RzdHJhcC9qcy9kaXN0L3Rvb2x0aXAnO1xuaW1wb3J0ICdib290c3RyYXAvanMvZGlzdC91dGlsJztcbiovXG5cblxuXG4vKlxuICAgIEJvb3Rib3ggbG9jYWxlIChmcikuXG4gICAgICAgIGh0dHA6Ly9ib290Ym94anMuY29tL2RvY3VtZW50YXRpb24uaHRtbFxuKi9cblxuYm9vdGJveC5hZGRMb2NhbGUoICdmcicsIHtcbiAgICAgICAgT0sgICAgICA6ICdPSycsXG4gICAgICAgIENBTkNFTCAgOiAnQW5udWxlcicsXG4gICAgICAgIENPTkZJUk0gOiAnQ29uZmlybWVyJ1xuICAgIH0gKTtcbmJvb3Rib3guc2V0TG9jYWxlKCAnZnInICk7XG5cblxuXG4vKlxuICAgIEFKQVggZXJyb3IgaGFuZGxlci5cbiovXG5cbiQoIGRvY3VtZW50ICkucmVhZHkoIGZ1bmN0aW9uKCApIHtcblxuICAgICQoIGRvY3VtZW50ICkuYWpheEVycm9yKCBmdW5jdGlvbiggZXZlbnQsIGpxWEhSLCBhamF4U2V0dGluZ3MsIHRocm93bkVycm9yICkge1xuXG4gICAgICAgIGNvbnNvbGUubG9nKCB7IGV2ZW50LCBqcVhIUiwgYWpheFNldHRpbmdzLCB0aHJvd25FcnJvciB9ICk7XG4gICAgICAgIFNJTFRvb2xzLmFsZXJ0KCB7XG4gICAgICAgICAgICB0eXBlOiAnZGFuZ2VyJyxcbiAgICAgICAgICAgIHRleHQ6IFwiVW5lIGVycmV1ciBlc3Qgc3VydmVudWUgKFwiICsganFYSFIuc3RhdHVzICsgXCIpLlwiXG4gICAgICAgIH0gKTtcblxuICAgIH0gKTtcblxufSApO1xuXG4iLCIvKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqXG5cbiAgICAgICAgU0lMIHRvb2xzIG1vZHVsZS5cblxuKi9cblxuXG5pbXBvcnQgJCBmcm9tICdqcXVlcnknO1xuXG5cblxudmFyIFNJTFRvb2xzID0gKCBmdW5jdGlvbiAoICkge1xuXG5cbiAgICBcInVzZSBzdHJpY3RcIjtcblxuXG4gICAgLyoqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqXG5cbiAgICAgICAgICAgIFByaXZhdGUgaXRlbXMuXG4gICAgKi9cblxuXG4gICAgY29uc3QgTVNfQkVGT1JFX0FMRVJUX0RJU01JU1MgPSA1MDAwLFxuICAgICAgICBOT05fQVVUT19ESVNNSVNTSUJMRV9BTEVSVF9UWVBFUyA9IFtcbiAgICAgICAgICAgICAgICAvLydpbmZvJyxcbiAgICAgICAgICAgICAgICAvLyd3YXJuaW5nJyxcbiAgICAgICAgICAgICAgICAnZGFuZ2VyJ1xuICAgICAgICAgICAgXTtcblxuICAgIHZhciBfJGxvYWRpbmdTcGlubmVyID0gJCggJyNsb2FkaW5nX3NwaW5uZXInICksXG4gICAgICAgIF8kYWxlcnRDb250YWluZXIgPSAkKCAnI2FsZXJ0c19jb250YWluZXInICksXG4gICAgICAgIF9tZXNzYWdlcyA9IHsgfTtcblxuXG4gICAgdmFyIF9yZW1vdmVJdGVtID0gZnVuY3Rpb24oIGl0ZW0gKSB7XG5cbiAgICAgICAgJCggaXRlbS5lbGVtICkucmVtb3ZlKCApO1xuXG4gICAgfTtcblxuXG4gICAgdmFyIF9yZXNldE1lc3NhZ2VzID0gZnVuY3Rpb24oICkge1xuXG4gICAgICAgIF9tZXNzYWdlcyA9IHtcbiAgICAgICAgICAgICdsaWdodCc6IFsgXSxcbiAgICAgICAgICAgICdkYXJrJzogWyBdLFxuICAgICAgICAgICAgJ3NlY29uZGFyeSc6IFsgXSxcbiAgICAgICAgICAgICdwcmltYXJ5JzogWyBdLFxuICAgICAgICAgICAgJ3N1Y2Nlc3MnOiBbIF0sXG4gICAgICAgICAgICAnaW5mbyc6IFsgXSxcbiAgICAgICAgICAgICd3YXJuaW5nJzogWyBdLFxuICAgICAgICAgICAgJ2Rhbmdlcic6IFsgXVxuICAgICAgICB9O1xuXG4gICAgfTtcblxuXG4gICAgdmFyIF9kaXNwbGF5QWxsQlNBbGVydHMgPSBmdW5jdGlvbiggKSB7XG5cbiAgICAgICAgZm9yICggdmFyIGtleSBpbiBfbWVzc2FnZXMgKSB7XG5cbiAgICAgICAgICAgIHZhciBtZXNzYWdlID0gX21lc3NhZ2VzWyBrZXkgXTtcblxuICAgICAgICAgICAgZm9yICggdmFyIGluZGV4IGluIG1lc3NhZ2UgKSB7XG5cbiAgICAgICAgICAgICAgICB2YXIgJGJ1dHRvbiA9ICQoIFwiPGJ1dHRvbj5cIiwge1xuICAgICAgICAgICAgICAgICAgICAgICAgJ3R5cGUnOiBcImJ1dHRvblwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgJ2NsYXNzJzogXCJjbG9zZVwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgJ2RhdGEtZGlzbWlzcyc6IFwiYWxlcnRcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICdhcmlhLWxhYmVsJzogXCJDbG9zZVwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgJ2h0bWwnOiAnPHNwYW4gYXJpYS1oaWRkZW49XCJ0cnVlXCI+JnRpbWVzOzwvc3Bhbj4nXG4gICAgICAgICAgICAgICAgICAgIH0gKSxcbiAgICAgICAgICAgICAgICAgICAgJGFsZXJ0ID0gJCggXCI8ZGl2PlwiLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICAnY2xhc3MnOiBcImFsZXJ0IGFsZXJ0LWRpc21pc3NpYmxlIGZhZGUgc2hvdyBhbGVydC1cIiArIGtleSxcbiAgICAgICAgICAgICAgICAgICAgICAgICdodG1sJzogbWVzc2FnZVsgaW5kZXggXSxcbiAgICAgICAgICAgICAgICAgICAgICAgICdjc3MnOiB7ICdkaXNwbGF5JzogJ25vbmUnIH1cbiAgICAgICAgICAgICAgICAgICAgfSApO1xuXG4gICAgICAgICAgICAgICAgXyRhbGVydENvbnRhaW5lci5wcmVwZW5kKCAkYWxlcnQuYXBwZW5kKCAkYnV0dG9uICkgKTtcblxuICAgICAgICAgICAgICAgIGlmICggTk9OX0FVVE9fRElTTUlTU0lCTEVfQUxFUlRfVFlQRVMuaW5jbHVkZXMoIGtleSApICkge1xuXG4gICAgICAgICAgICAgICAgICAgICRhbGVydC5zbGlkZURvd24oICk7XG5cbiAgICAgICAgICAgICAgICB9IGVsc2Uge1xuXG4gICAgICAgICAgICAgICAgICAgICRhbGVydC5zbGlkZURvd24oICkuZGVsYXkoIE1TX0JFRk9SRV9BTEVSVF9ESVNNSVNTIClcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAuc2xpZGVVcCgge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBhbHdheXM6IF9yZW1vdmVJdGVtLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0gKTtcblxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuXG4gICAgICAgIF9yZXNldE1lc3NhZ2VzKCApO1xuXG4gICAgfTtcblxuXG5cbiAgICAvKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKipcblxuICAgICAgICAgICAgUHVibGljIGl0ZW1zLlxuICAgICovXG5cblxuICAgIC8qKlxuICAgICAqIEFkZHMgQlMgYWxlcnRzIGluIOKAnF8kYWxlcnRDb250YWluZXLigJ0uXG4gICAgICpcbiAgICAgKiBFeGFtcGxlcyBvZiB1c2U6XG4gICAgICogICAgICBhbGVydCggeyB0eXBlOiAnaW5mbycsIHRleHQ6IFwi4oCcQmxhYmxhLlwiIH0gKTtcbiAgICAgKiAgICAgICAgICAtPiBkaXNwbGF5cyDigJxCbGFibGEu4oCdIGluIGFuIOKAnGluZm/igJ0gYWxlcnQgYXMgd2VsbCBhcyBhbGwgb3RoZXJcbiAgICAgKiAgICAgICAgICBwcmV2aW91c2x5IGJ1ZmZlcmVkIGFsZXJ0cywgZmx1c2hlcyBidWZmZXIuXG4gICAgICogICAgICBhbGVydCggeyB0eXBlOiAnd2FybmluZycsIHRleHQ6IFwiQmx1Ymx1LlwiLCBrZWVwOiB0cnVlIH0gKTtcbiAgICAgKiAgICAgICAgICAtPiBhZGRzIGEgd2FybmluZyBhbGVydCB3aXRoIOKAnEJsYWJsYS7igJ0gdGV4dCBpbiB0aGUgYnVmZmVyLFxuICAgICAqICAgICAgICAgIGRpc3BsYXlzIG5vdGhpbmcuXG4gICAgICogICAgICBhbGVydCggKTtcbiAgICAgKiAgICAgICAgICAtPiBkaXNwbGF5cyBhbGwgcHJldmlvdXNseSBidWZmZXJlZCBhbGVydHMsIGZsdXNoZXMgYnVmZmVyLlxuICAgICAqXG4gICAgICogQHBhcmFtIHtvYmplY3R9IGFsZXJ0RGF0YTpcbiAgICAgKiAgICAgIHR5cGUgLT4gb25lIG9mIHRoZSBCb290c3RyYXAgY29udGV4dHVhbCBjbGFzc2VzO1xuICAgICAqICAgICAgdGV4dCAtPiB0aGUgdGV4dCB0byBkaXNwbGF5O1xuICAgICAqICAgICAga2VlcCAtPiDigJx0cnVl4oCdIHRvIHNpbXBseSBhZGQgYWxlcnQgdG8gYnVmZmVyLFxuICAgICAqICAgICAgICAgICAgICDigJxmYWxzZeKAnSB0byBkaXNwbGF5IGFsbCBwcmV2aW91c2x5IGJ1ZmZlcmVkIGFsZXJ0c1xuICAgICAqICAgICAgICAgICAgICBhbmQgZmx1c2ggYnVmZmVyLlxuICAgICAqXG4gICAgICovXG4gICAgdmFyIGFsZXJ0ID0gZnVuY3Rpb24oIGFsZXJ0RGF0YSApIHtcblxuICAgICAgICBpZiAoIGFsZXJ0RGF0YSA9PT0gdW5kZWZpbmVkICkge1xuXG4gICAgICAgICAgICBfZGlzcGxheUFsbEJTQWxlcnRzKCApO1xuXG4gICAgICAgIH0gZWxzZSB7XG5cbiAgICAgICAgICAgIGlmICggYWxlcnREYXRhLnR5cGUgPT09IHVuZGVmaW5lZFxuICAgICAgICAgICAgICAgICAgICAvL3x8ICEgKCBhbGVydERhdGEudHlwZSBpbiBfbWVzc2FnZXMgKVxuICAgICAgICAgICAgICAgICAgICB8fCAhIF9tZXNzYWdlcy5oYXNPd25Qcm9wZXJ0eSggYWxlcnREYXRhLnR5cGUgKSApIHtcbiAgICAgICAgICAgICAgICBhbGVydERhdGEudHlwZSA9ICdkYW5nZXInO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBpZiAoIGFsZXJ0RGF0YS50ZXh0ID09PSB1bmRlZmluZWQgKSB7XG4gICAgICAgICAgICAgICAgYWxlcnREYXRhLnRleHQgPSBcIlVuZSBlcnJldXIgZXN0IHN1cnZlbnVlLlwiO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBpZiAoIGFsZXJ0RGF0YS5rZWVwID09PSB1bmRlZmluZWQgKSB7XG4gICAgICAgICAgICAgICAgYWxlcnREYXRhLmtlZXAgPSBmYWxzZTtcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgX21lc3NhZ2VzWyBhbGVydERhdGEudHlwZSBdLnB1c2goIGFsZXJ0RGF0YS50ZXh0ICk7XG5cbiAgICAgICAgICAgIGlmICggISBhbGVydERhdGEua2VlcCApIHtcbiAgICAgICAgICAgICAgICBfZGlzcGxheUFsbEJTQWxlcnRzKCApO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgIH1cblxuICAgIH07XG5cblxuXG4gICAgLyoqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqXG5cbiAgICAgICAgICAgIEluaXQuXG4gICAgKi9cblxuICAgIF9yZXNldE1lc3NhZ2VzKCApO1xuXG5cbiAgICAvKlxuICAgICAgICBQdWJsaWMgcG9pbnRlcnMgdG8gZXhwb3NlZCBpdGVtcy5cbiAgICAqL1xuXG4gICAgcmV0dXJuIHtcbiAgICAgICAgc3Bpbm5lcjogXyRsb2FkaW5nU3Bpbm5lcixcbiAgICAgICAgYWxlcnQ6IGFsZXJ0XG4gICAgfTtcblxuXG5cbn0gKSAoICk7XG5cblxuZXhwb3J0IGRlZmF1bHQgU0lMVG9vbHM7XG5cbiIsIi8qKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKipcblxuICAgICAgICBTeWxsYWJ1cyBtb2R1bGUuXG5cbiovXG5cblxuaW1wb3J0ICQgZnJvbSAnanF1ZXJ5JztcbmltcG9ydCBTSUxUb29scyBmcm9tICcuL3NpbF90b29sa2l0JztcblxuXG5cbnZhciBTeWxsYWJ1cyA9ICggZnVuY3Rpb24gKCApIHtcblxuXG4gICAgXCJ1c2Ugc3RyaWN0XCI7XG5cblxuICAgIC8qKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKlxuXG4gICAgICAgICAgICBQcml2YXRlIGl0ZW1zLlxuICAgICovXG5cblxuICAgIHZhciBfYWpheFRhYkNvbnRlbnRMb2FkZXIgPSBmdW5jdGlvbiggJHRhYkxpbmsgKSB7XG5cbiAgICAgICAgdmFyIHJvdXRlID0gJHRhYkxpbmsuZGF0YSggJ3JvdXRlJyApO1xuXG4gICAgICAgIGlmICggcm91dGUgIT09IFwiXCIgKSB7XG5cbiAgICAgICAgICAgIFNJTFRvb2xzLnNwaW5uZXIuZmFkZUluKCB7XG4gICAgICAgICAgICAgICAgYWx3YXlzOiBmdW5jdGlvbiggKSB7XG4gICAgICAgICAgICAgICAgICAgICQuYWpheCgge1xuICAgICAgICAgICAgICAgICAgICAgICAgdHlwZTogJ1BPU1QnLFxuICAgICAgICAgICAgICAgICAgICAgICAgdXJsOiByb3V0ZSxcbiAgICAgICAgICAgICAgICAgICAgICAgIGNvbnRleHQ6ICQoICcjcGFuZWxfJyArICR0YWJMaW5rLmF0dHIoICdpZCcgKSApXG4gICAgICAgICAgICAgICAgICAgIH0gKS5kb25lKCBmdW5jdGlvbiggZGF0YSApIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKGRhdGEuY29udGVudCAhPT0gdW5kZWZpbmVkKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJCh0aGlzKS5odG1sKGRhdGEuY29udGVudCk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRhYkxpbmsuZGF0YSgncm91dGUnLCBcIlwiKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKGRhdGEuYWxlcnQgIT09IHVuZGVmaW5lZCkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmIChkYXRhLmFsZXJ0LnR5cGUgIT09IHVuZGVmaW5lZCAmJiBkYXRhLmFsZXJ0Lm1lc3NhZ2UgIT09IHVuZGVmaW5lZCkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBTSUxUb29scy5hbGVydCgge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdHlwZTogZGF0YS5hbGVydC50eXBlLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdGV4dDogZGF0YS5hbGVydC5tZXNzYWdlXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0gKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIH0gKS5hbHdheXMoIGZ1bmN0aW9uKCApe1xuICAgICAgICAgICAgICAgICAgICAgICAgU0lMVG9vbHMuc3Bpbm5lci5mYWRlT3V0KCApO1xuICAgICAgICAgICAgICAgICAgICB9ICk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSApO1xuICAgICAgICB9XG5cbiAgICB9O1xuXG5cblxuICAgIC8qKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKlxuXG4gICAgICAgICAgICBQdWJsaWMgaXRlbXMuXG4gICAgKi9cblxuXG4gICAgdmFyIHRhYkxvYWRlckluaXQgPSBmdW5jdGlvbiggKSB7XG5cbiAgICAgICAgJCggJ21haW4gPiAucm93OmZpcnN0LWNoaWxkID4gZGl2ID4gdWwubmF2JyApXG4gICAgICAgICAgICAgICAgLm9uKCAnY2xpY2snLCAnbGkubmF2LWl0ZW0gPiBhJywgZnVuY3Rpb24oICkge1xuXG4gICAgICAgICAgICBfYWpheFRhYkNvbnRlbnRMb2FkZXIoICQoIHRoaXMgKSApO1xuXG4gICAgICAgICAgICBzYXZlQ3VycmVudFRhYkNvbnRlbnQoICQoIHRoaXMgKSApO1xuXG4gICAgICAgIH0gKTtcblxuICAgICAgICAkKCAnI3RhYi0xJyApLmFkZENsYXNzKCAnYWN0aXZlJyApO1xuICAgICAgICAkKCAnI3RhYi0xJyApLmFkZENsYXNzKCAnc3lsbGFidXMtdGFiLWFjdGl2ZScgKTtcbiAgICAgICAgX2FqYXhUYWJDb250ZW50TG9hZGVyKCAkKCAnI3RhYi0xJyApICk7XG5cbiAgICB9O1xuXG4gICAgdmFyIHNhdmVDdXJyZW50VGFiQ29udGVudCA9IGZ1bmN0aW9uKCB0YWIgKSB7XG4gICAgICAgIGlmKCF0YWJbXCIwXCJdLmNsYXNzTGlzdC5jb250YWlucygnc3lsbGFidXMtdGFiLWFjdGl2ZScpKXtcbiAgICAgICAgICAgIHZhciBhY3RpdmVfdGFiX2J1dHRvbiA9IGRvY3VtZW50LmdldEVsZW1lbnRzQnlDbGFzc05hbWUoJ3N5bGxhYnVzLXRhYi1hY3RpdmUnKVswXTtcbiAgICAgICAgICAgIHZhciBhY3RpdmVfdGFiID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoXCJwYW5lbF9cIithY3RpdmVfdGFiX2J1dHRvbi5pZCk7XG4gICAgICAgICAgICB2YXIgc3VtYml0X2J1dHRvbiA9IGFjdGl2ZV90YWIuZ2V0RWxlbWVudHNCeUNsYXNzTmFtZShcInN1Ym1pdFwiKVswXTtcbiAgICAgICAgICAgIHN1bWJpdF9idXR0b24uY2xpY2soKTtcbiAgICAgICAgICAgIGFjdGl2ZV90YWJfYnV0dG9uLmNsYXNzTGlzdC5yZW1vdmUoJ3N5bGxhYnVzLXRhYi1hY3RpdmUnKTtcbiAgICAgICAgICAgIHRhYi5hZGRDbGFzcyggJ3N5bGxhYnVzLXRhYi1hY3RpdmUnICk7XG4gICAgICAgIH1cblxuICAgIH1cblxuICAgIHZhciBoYW5kbGVBamF4UmVzcG9uc2UgPSBmdW5jdGlvbiggcmVzcG9uc2UgKSB7XG4gICAgICAgIGlmKHJlc3BvbnNlLm1lc3NhZ2VzICE9PSB1bmRlZmluZWQpIHtcbiAgICAgICAgICAgIHJlc3BvbnNlLm1lc3NhZ2VzLmZvckVhY2goZnVuY3Rpb24obWVzc2FnZSl7XG4gICAgICAgICAgICAgICAgaWYgKG1lc3NhZ2UudHlwZSAhPT0gdW5kZWZpbmVkICYmIG1lc3NhZ2UubWVzc2FnZSAhPT0gdW5kZWZpbmVkKSB7XG4gICAgICAgICAgICAgICAgICAgIFNJTFRvb2xzLmFsZXJ0KCB7XG4gICAgICAgICAgICAgICAgICAgICAgICB0eXBlOiBtZXNzYWdlLnR5cGUsXG4gICAgICAgICAgICAgICAgICAgICAgICB0ZXh0OiBtZXNzYWdlLm1lc3NhZ2UsXG4gICAgICAgICAgICAgICAgICAgICAgICBrZWVwOiBmYWxzZVxuICAgICAgICAgICAgICAgICAgICB9ICk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICAgICAgaWYocmVzcG9uc2UucmVuZGVycyAhPT0gdW5kZWZpbmVkKSB7XG4gICAgICAgICAgICByZXNwb25zZS5yZW5kZXJzLmZvckVhY2goZnVuY3Rpb24ocmVuZGVyKSB7XG4gICAgICAgICAgICAgICAgaWYgKHJlbmRlci5lbGVtZW50ICE9PSB1bmRlZmluZWQgJiYgcmVuZGVyLmNvbnRlbnQgIT09IHVuZGVmaW5lZCkge1xuICAgICAgICAgICAgICAgICAgICAkKHJlbmRlci5lbGVtZW50KS5odG1sKHJlbmRlci5jb250ZW50KTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH1cblxuXG4gICAgLypcbiAgICAgICAgUHVibGljIHBvaW50ZXJzIHRvIGV4cG9zZWQgaXRlbXMuXG4gICAgKi9cblxuICAgIHJldHVybiB7XG4gICAgICAgIHRhYkxvYWRlckluaXQ6IHRhYkxvYWRlckluaXQsXG4gICAgICAgIGhhbmRsZUFqYXhSZXNwb25zZTogaGFuZGxlQWpheFJlc3BvbnNlXG4gICAgfTtcblxuXG5cbn0gKSAoICk7XG5cblxuZXhwb3J0IGRlZmF1bHQgU3lsbGFidXM7XG5cbiIsIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpbiIsIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpbiJdLCJzb3VyY2VSb290IjoiIn0=