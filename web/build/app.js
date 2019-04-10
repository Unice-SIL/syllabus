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

  var _saveCurrentTabContent = function _saveCurrentTabContent(tab) {
    if (!tab["0"].classList.contains('syllabus-tab-active')) {
      var active_tab_button = document.getElementsByClassName('syllabus-tab-active')[0];
      var active_tab = document.getElementById("panel_" + active_tab_button.id);
      var sumbit_button = active_tab.getElementsByClassName("submit")[0];
      sumbit_button.click();
      active_tab_button.classList.remove('syllabus-tab-active');
      tab.addClass('syllabus-tab-active');
    }
  };
  /**************************************************************************
           Public items.
  */


  var tabLoaderInit = function tabLoaderInit() {
    jquery__WEBPACK_IMPORTED_MODULE_0___default()('main > .row:first-child > div > ul.nav').on('click', 'li.nav-item > a', function () {
      _ajaxTabContentLoader(jquery__WEBPACK_IMPORTED_MODULE_0___default()(this));

      _saveCurrentTabContent(jquery__WEBPACK_IMPORTED_MODULE_0___default()(this));
    });
    jquery__WEBPACK_IMPORTED_MODULE_0___default()('#tab-1').addClass('active');
    jquery__WEBPACK_IMPORTED_MODULE_0___default()('#tab-1').addClass('syllabus-tab-active');

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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hcHAvUmVzb3VyY2VzL2Fzc2V0cy9qcy9hcHAuanMiLCJ3ZWJwYWNrOi8vLy4vYXBwL1Jlc291cmNlcy9hc3NldHMvanMvc2lsX3Rvb2xraXQuanMiLCJ3ZWJwYWNrOi8vLy4vYXBwL1Jlc291cmNlcy9hc3NldHMvanMvc3lsbGFidXMuanMiLCJ3ZWJwYWNrOi8vLy4vYXBwL1Jlc291cmNlcy9hc3NldHMvc2Nzcy9hcHAuc2Nzcz8yMTg4Iiwid2VicGFjazovLy8uL2FwcC9SZXNvdXJjZXMvYXNzZXRzL3Njc3Mvc2lsX3Rvb2xraXQuc2Nzcz9hZjVjIl0sIm5hbWVzIjpbImdsb2JhbCIsIiQiLCJ3aW5kb3ciLCJqUXVlcnkiLCJib290Ym94IiwiYm9vdHN0cmFwVG9nZ2xlIiwiU0lMVG9vbHMiLCJTeWxsYWJ1cyIsImFkZExvY2FsZSIsIk9LIiwiQ0FOQ0VMIiwiQ09ORklSTSIsInNldExvY2FsZSIsImRvY3VtZW50IiwicmVhZHkiLCJhamF4RXJyb3IiLCJldmVudCIsImpxWEhSIiwiYWpheFNldHRpbmdzIiwidGhyb3duRXJyb3IiLCJjb25zb2xlIiwibG9nIiwiYWxlcnQiLCJ0eXBlIiwidGV4dCIsInN0YXR1cyIsIk1TX0JFRk9SRV9BTEVSVF9ESVNNSVNTIiwiTk9OX0FVVE9fRElTTUlTU0lCTEVfQUxFUlRfVFlQRVMiLCJfJGxvYWRpbmdTcGlubmVyIiwiXyRhbGVydENvbnRhaW5lciIsIl9tZXNzYWdlcyIsIl9yZW1vdmVJdGVtIiwiaXRlbSIsImVsZW0iLCJyZW1vdmUiLCJfcmVzZXRNZXNzYWdlcyIsIl9kaXNwbGF5QWxsQlNBbGVydHMiLCJrZXkiLCJtZXNzYWdlIiwiaW5kZXgiLCIkYnV0dG9uIiwiJGFsZXJ0IiwicHJlcGVuZCIsImFwcGVuZCIsImluY2x1ZGVzIiwic2xpZGVEb3duIiwiZGVsYXkiLCJzbGlkZVVwIiwiYWx3YXlzIiwiYWxlcnREYXRhIiwidW5kZWZpbmVkIiwiaGFzT3duUHJvcGVydHkiLCJrZWVwIiwicHVzaCIsInNwaW5uZXIiLCJfYWpheFRhYkNvbnRlbnRMb2FkZXIiLCIkdGFiTGluayIsInJvdXRlIiwiZGF0YSIsImZhZGVJbiIsImFqYXgiLCJ1cmwiLCJjb250ZXh0IiwiYXR0ciIsImRvbmUiLCJjb250ZW50IiwiaHRtbCIsImZhZGVPdXQiLCJfc2F2ZUN1cnJlbnRUYWJDb250ZW50IiwidGFiIiwiY2xhc3NMaXN0IiwiY29udGFpbnMiLCJhY3RpdmVfdGFiX2J1dHRvbiIsImdldEVsZW1lbnRzQnlDbGFzc05hbWUiLCJhY3RpdmVfdGFiIiwiZ2V0RWxlbWVudEJ5SWQiLCJpZCIsInN1bWJpdF9idXR0b24iLCJjbGljayIsImFkZENsYXNzIiwidGFiTG9hZGVySW5pdCIsIm9uIiwiaGFuZGxlQWpheFJlc3BvbnNlIiwicmVzcG9uc2UiLCJtZXNzYWdlcyIsImZvckVhY2giXSwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7Ozs7OztBQVFBOzs7QUFJQTtBQUNBO0NBR0E7O0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Q0FHQTs7QUFDQUEsTUFBTSxDQUFDQyxDQUFQLEdBQVdDLE1BQU0sQ0FBQ0QsQ0FBUCxHQUFXRCxNQUFNLENBQUNHLE1BQVAsR0FBZ0JELG9DQUFBLEdBQWdCRCw2Q0FBdEQ7QUFDQUQsTUFBTSxDQUFDSSxPQUFQLEdBQWlCQSw4Q0FBakI7QUFDQUosTUFBTSxDQUFDSyxlQUFQLEdBQXlCQSx3REFBekI7QUFDQUwsTUFBTSxDQUFDTSxRQUFQLEdBQWtCQSxvREFBbEI7QUFDQU4sTUFBTSxDQUFDTyxRQUFQLEdBQWtCQSxpREFBbEI7QUFJQTs7OztBQUlBO0FBSUE7Ozs7QUFJQTtBQUlBOzs7Ozs7Ozs7Ozs7Ozs7Ozs7QUFvQkE7Ozs7O0FBS0FILDhDQUFPLENBQUNJLFNBQVIsQ0FBbUIsSUFBbkIsRUFBeUI7QUFDakJDLElBQUUs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QUFDQTlFLGlEQUFDLENBQUUsUUFBRixDQUFELENBQWM4RSxRQUFkLENBQXdCLHFCQUF4Qjs7QUFDQXhCLHlCQUFxQixDQUFFdEQsNkNBQUMsQ0FBRSxRQUFGLENBQUgsQ0FBckI7QUFFSCxHQWREOztBQWlCQSxNQUFJaUYsa0JBQWtCLEdBQUcsU0FBckJBLGtCQUFxQixDQUFVQyxRQUFWLEVBQXFCO0FBQzFDLFFBQUdBLFFBQVEsQ0FBQ0MsUUFBVCxLQUFzQmxDLFNBQXpCLEVBQW9DO0FBQ2hDaUMsY0FBUSxDQUFDQyxRQUFULENBQWtCQyxPQUFsQixDQUEwQixVQUFTL0MsT0FBVCxFQUFpQjtBQUN2QyxZQUFJQSxPQUFPLENBQUNmLElBQVIsS0FBaUIyQixTQUFqQixJQUE4QlosT0FBTyxDQUFDQSxPQUFSLEtBQW9CWSxTQUF0RCxFQUFpRTtBQUM3RDVDLDhEQUFRLENBQUNnQixLQUFULENBQWdCO0FBQ1pDLGdCQUFJLEVBQUVlLE9BQU8sQ0FBQ2YsSUFERjtBQUVaQyxnQkFBSSxFQUFFYyxPQUFPLENBQUNBO0FBRkYsV0FBaEI7QUFJSDtBQUNKLE9BUEQ7QUFRSDtBQUNEOzs7Ozs7Ozs7QUFRSCxHQW5CRDtBQXNCQTs7Ozs7QUFJQSxTQUFPO0FBQ0gwQyxpQkFBYSxFQUFFQSxhQURaO0FBRUhFLHNCQUFrQixFQUFFQTtBQUZqQixHQUFQO0FBT0gsQ0FwSGMsRUFBZjs7QUF1SGUzRSx1RUFBZixFOzs7Ozs7Ozs7OztBQ25JQSx1Qzs7Ozs7Ozs7Ozs7QUNBQSx1QyIsImZpbGUiOiJhcHAuanMiLCJzb3VyY2VzQ29udGVudCI6WyIvKlxuICAgICAgICBNYWluIFdlYnBhY2sgZW50cnkgcG9pbnQuXG5cblxuKi9cblxuXG5cbi8qXG4gICAgSW1wb3J0aW5nIGRlcGVuZGVuY2llc1xuKi9cblxuLy8gU0FTUyAvIENTUyBkZXBlbmRlbmNpZXMuXG5pbXBvcnQgJy4uL3Njc3Mvc2lsX3Rvb2xraXQuc2Nzcyc7XG5pbXBvcnQgJy4uL3Njc3MvYXBwLnNjc3MnO1xuXG4vLyBJbXBvcnRpbmcgbW9kdWxlc+KAplxuaW1wb3J0ICQgZnJvbSAnanF1ZXJ5JztcbmltcG9ydCBib290Ym94IGZyb20gJ2Jvb3Rib3gnO1xuaW1wb3J0IGJvb3RzdHJhcFRvZ2dsZSBmcm9tICdib290c3RyYXA0LXRvZ2dsZSc7XG5pbXBvcnQgU0lMVG9vbHMgZnJvbSAnLi9zaWxfdG9vbGtpdCc7XG5pbXBvcnQgU3lsbGFidXMgZnJvbSAnLi9zeWxsYWJ1cyc7XG5cbi8vIOKApiBhbmQgbWFrZSB0aGVtIHZpc2libGUgdG8gZXh0ZXJuYWwgY29tcG9uZW50cy5cbmdsb2JhbC4kID0gd2luZG93LiQgPSBnbG9iYWwualF1ZXJ5ID0gd2luZG93LmpRdWVyeSA9ICQ7XG5nbG9iYWwuYm9vdGJveCA9IGJvb3Rib3g7XG5nbG9iYWwuYm9vdHN0cmFwVG9nZ2xlID0gYm9vdHN0cmFwVG9nZ2xlO1xuZ2xvYmFsLlNJTFRvb2xzID0gU0lMVG9vbHM7XG5nbG9iYWwuU3lsbGFidXMgPSBTeWxsYWJ1cztcblxuXG5cbi8qXG4gICAgU29ydGFibGVKUyB3aXRoIGpRdWVyeSBiaW5kaW5nLlxuKi9cblxuaW1wb3J0ICdqcXVlcnktc29ydGFibGVqcyc7XG5cblxuXG4vKlxuICAgIEZ1bGwgQm9vdHN0cmFw4oCmXG4qL1xuXG5pbXBvcnQgJ2Jvb3RzdHJhcCc7XG5cblxuXG4vKlxuICAgIOKApiBvciBwYXJ0cyBvZiBpdC5cblxuaW1wb3J0ICdib290c3RyYXAvanMvZGlzdC9hbGVydCc7XG5pbXBvcnQgJ2Jvb3RzdHJhcC9qcy9kaXN0L2J1dHRvbic7XG4vL2ltcG9ydCAnYm9vdHN0cmFwL2pzL2Rpc3QvY2Fyb3VzZWwnO1xuaW1wb3J0ICdib290c3RyYXAvanMvZGlzdC9jb2xsYXBzZSc7XG4vL2ltcG9ydCAnYm9vdHN0cmFwL2pzL2Rpc3QvZHJvcGRvd24nO1xuLy9pbXBvcnQgJ2Jvb3RzdHJhcC9qcy9kaXN0L2luZGV4JztcbmltcG9ydCAnYm9vdHN0cmFwL2pzL2Rpc3QvbW9kYWwnO1xuLy9pbXBvcnQgJ2Jvb3RzdHJhcC9qcy9kaXN0L3BvcG92ZXInO1xuaW1wb3J0ICdib290c3RyYXAvanMvZGlzdC9zY3JvbGxzcHknO1xuaW1wb3J0ICdib290c3RyYXAvanMvZGlzdC90YWInO1xuLy9pbXBvcnQgJ2Jvb3RzdHJhcC9qcy9kaXN0L3RvYXN0Jztcbi8vaW1wb3J0ICdib290c3RyYXAvanMvZGlzdC90b29sdGlwJztcbmltcG9ydCAnYm9vdHN0cmFwL2pzL2Rpc3QvdXRpbCc7XG4qL1xuXG5cblxuLypcbiAgICBCb290Ym94IGxvY2FsZSAoZnIpLlxuICAgICAgICBodHRwOi8vYm9vdGJveGpzLmNvbS9kb2N1bWVudGF0aW9uLmh0bWxcbiovXG5cbmJvb3Rib3guYWRkTG9jYWxlKCAnZnInLCB7XG4gICAgICAgIE9LICAgICAgOiAnT0snLFxuICAgICAgICBDQU5DRUwgIDogJ0FubnVsZXInLFxuICAgICAgICBDT05GSVJNIDogJ0NvbmZpcm1lcidcbiAgICB9ICk7XG5ib290Ym94LnNldExvY2FsZSggJ2ZyJyApO1xuXG5cblxuLypcbiAgICBBSkFYIGVycm9yIGhhbmRsZXIuXG4qL1xuXG4kKCBkb2N1bWVudCApLnJlYWR5KCBmdW5jdGlvbiggKSB7XG5cbiAgICAkKCBkb2N1bWVudCApLmFqYXhFcnJvciggZnVuY3Rpb24oIGV2ZW50LCBqcVhIUiwgYWpheFNldHRpbmdzLCB0aHJvd25FcnJvciApIHtcblxuICAgICAgICBjb25zb2xlLmxvZyggeyBldmVudCwganFYSFIsIGFqYXhTZXR0aW5ncywgdGhyb3duRXJyb3IgfSApO1xuICAgICAgICBTSUxUb29scy5hbGVydCgge1xuICAgICAgICAgICAgdHlwZTogJ2RhbmdlcicsXG4gICAgICAgICAgICB0ZXh0OiBcIlVuZSBlcnJldXIgZXN0IHN1cnZlbnVlIChcIiArIGpxWEhSLnN0YXR1cyArIFwiKS5cIlxuICAgICAgICB9ICk7XG5cbiAgICB9ICk7XG5cbn0gKTtcblxuIiwiLyoqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKlxuXG4gICAgICAgIFNJTCB0b29scyBtb2R1bGUuXG5cbiovXG5cblxuaW1wb3J0ICQgZnJvbSAnanF1ZXJ5JztcblxuXG5cbnZhciBTSUxUb29scyA9ICggZnVuY3Rpb24gKCApIHtcblxuXG4gICAgXCJ1c2Ugc3RyaWN0XCI7XG5cblxuICAgIC8qKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKlxuXG4gICAgICAgICAgICBQcml2YXRlIGl0ZW1zLlxuICAgICovXG5cblxuICAgIGNvbnN0IE1TX0JFRk9SRV9BTEVSVF9ESVNNSVNTID0gNTAwMCxcbiAgICAgICAgTk9OX0FVVE9fRElTTUlTU0lCTEVfQUxFUlRfVFlQRVMgPSBbXG4gICAgICAgICAgICAgICAgLy8naW5mbycsXG4gICAgICAgICAgICAgICAgLy8nd2FybmluZycsXG4gICAgICAgICAgICAgICAgJ2RhbmdlcidcbiAgICAgICAgICAgIF07XG5cbiAgICB2YXIgXyRsb2FkaW5nU3Bpbm5lciA9ICQoICcjbG9hZGluZ19zcGlubmVyJyApLFxuICAgICAgICBfJGFsZXJ0Q29udGFpbmVyID0gJCggJyNhbGVydHNfY29udGFpbmVyJyApLFxuICAgICAgICBfbWVzc2FnZXMgPSB7IH07XG5cblxuICAgIHZhciBfcmVtb3ZlSXRlbSA9IGZ1bmN0aW9uKCBpdGVtICkge1xuXG4gICAgICAgICQoIGl0ZW0uZWxlbSApLnJlbW92ZSggKTtcblxuICAgIH07XG5cblxuICAgIHZhciBfcmVzZXRNZXNzYWdlcyA9IGZ1bmN0aW9uKCApIHtcblxuICAgICAgICBfbWVzc2FnZXMgPSB7XG4gICAgICAgICAgICAnbGlnaHQnOiBbIF0sXG4gICAgICAgICAgICAnZGFyayc6IFsgXSxcbiAgICAgICAgICAgICdzZWNvbmRhcnknOiBbIF0sXG4gICAgICAgICAgICAncHJpbWFyeSc6IFsgXSxcbiAgICAgICAgICAgICdzdWNjZXNzJzogWyBdLFxuICAgICAgICAgICAgJ2luZm8nOiBbIF0sXG4gICAgICAgICAgICAnd2FybmluZyc6IFsgXSxcbiAgICAgICAgICAgICdkYW5nZXInOiBbIF1cbiAgICAgICAgfTtcblxuICAgIH07XG5cblxuICAgIHZhciBfZGlzcGxheUFsbEJTQWxlcnRzID0gZnVuY3Rpb24oICkge1xuXG4gICAgICAgIGZvciAoIHZhciBrZXkgaW4gX21lc3NhZ2VzICkge1xuXG4gICAgICAgICAgICB2YXIgbWVzc2FnZSA9IF9tZXNzYWdlc1sga2V5IF07XG5cbiAgICAgICAgICAgIGZvciAoIHZhciBpbmRleCBpbiBtZXNzYWdlICkge1xuXG4gICAgICAgICAgICAgICAgdmFyICRidXR0b24gPSAkKCBcIjxidXR0b24+XCIsIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICd0eXBlJzogXCJidXR0b25cIixcbiAgICAgICAgICAgICAgICAgICAgICAgICdjbGFzcyc6IFwiY2xvc2VcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICdkYXRhLWRpc21pc3MnOiBcImFsZXJ0XCIsXG4gICAgICAgICAgICAgICAgICAgICAgICAnYXJpYS1sYWJlbCc6IFwiQ2xvc2VcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICdodG1sJzogJzxzcGFuIGFyaWEtaGlkZGVuPVwidHJ1ZVwiPiZ0aW1lczs8L3NwYW4+J1xuICAgICAgICAgICAgICAgICAgICB9ICksXG4gICAgICAgICAgICAgICAgICAgICRhbGVydCA9ICQoIFwiPGRpdj5cIiwge1xuICAgICAgICAgICAgICAgICAgICAgICAgJ2NsYXNzJzogXCJhbGVydCBhbGVydC1kaXNtaXNzaWJsZSBmYWRlIHNob3cgYWxlcnQtXCIgKyBrZXksXG4gICAgICAgICAgICAgICAgICAgICAgICAnaHRtbCc6IG1lc3NhZ2VbIGluZGV4IF0sXG4gICAgICAgICAgICAgICAgICAgICAgICAnY3NzJzogeyAnZGlzcGxheSc6ICdub25lJyB9XG4gICAgICAgICAgICAgICAgICAgIH0gKTtcblxuICAgICAgICAgICAgICAgIF8kYWxlcnRDb250YWluZXIucHJlcGVuZCggJGFsZXJ0LmFwcGVuZCggJGJ1dHRvbiApICk7XG5cbiAgICAgICAgICAgICAgICBpZiAoIE5PTl9BVVRPX0RJU01JU1NJQkxFX0FMRVJUX1RZUEVTLmluY2x1ZGVzKCBrZXkgKSApIHtcblxuICAgICAgICAgICAgICAgICAgICAkYWxlcnQuc2xpZGVEb3duKCApO1xuXG4gICAgICAgICAgICAgICAgfSBlbHNlIHtcblxuICAgICAgICAgICAgICAgICAgICAkYWxlcnQuc2xpZGVEb3duKCApLmRlbGF5KCBNU19CRUZPUkVfQUxFUlRfRElTTUlTUyApXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgLnNsaWRlVXAoIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgYWx3YXlzOiBfcmVtb3ZlSXRlbSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9ICk7XG5cbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9XG4gICAgICAgIH1cblxuICAgICAgICBfcmVzZXRNZXNzYWdlcyggKTtcblxuICAgIH07XG5cblxuXG4gICAgLyoqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqXG5cbiAgICAgICAgICAgIFB1YmxpYyBpdGVtcy5cbiAgICAqL1xuXG5cbiAgICAvKipcbiAgICAgKiBBZGRzIEJTIGFsZXJ0cyBpbiDigJxfJGFsZXJ0Q29udGFpbmVy4oCdLlxuICAgICAqXG4gICAgICogRXhhbXBsZXMgb2YgdXNlOlxuICAgICAqICAgICAgYWxlcnQoIHsgdHlwZTogJ2luZm8nLCB0ZXh0OiBcIuKAnEJsYWJsYS5cIiB9ICk7XG4gICAgICogICAgICAgICAgLT4gZGlzcGxheXMg4oCcQmxhYmxhLuKAnSBpbiBhbiDigJxpbmZv4oCdIGFsZXJ0IGFzIHdlbGwgYXMgYWxsIG90aGVyXG4gICAgICogICAgICAgICAgcHJldmlvdXNseSBidWZmZXJlZCBhbGVydHMsIGZsdXNoZXMgYnVmZmVyLlxuICAgICAqICAgICAgYWxlcnQoIHsgdHlwZTogJ3dhcm5pbmcnLCB0ZXh0OiBcIkJsdWJsdS5cIiwga2VlcDogdHJ1ZSB9ICk7XG4gICAgICogICAgICAgICAgLT4gYWRkcyBhIHdhcm5pbmcgYWxlcnQgd2l0aCDigJxCbGFibGEu4oCdIHRleHQgaW4gdGhlIGJ1ZmZlcixcbiAgICAgKiAgICAgICAgICBkaXNwbGF5cyBub3RoaW5nLlxuICAgICAqICAgICAgYWxlcnQoICk7XG4gICAgICogICAgICAgICAgLT4gZGlzcGxheXMgYWxsIHByZXZpb3VzbHkgYnVmZmVyZWQgYWxlcnRzLCBmbHVzaGVzIGJ1ZmZlci5cbiAgICAgKlxuICAgICAqIEBwYXJhbSB7b2JqZWN0fSBhbGVydERhdGE6XG4gICAgICogICAgICB0eXBlIC0+IG9uZSBvZiB0aGUgQm9vdHN0cmFwIGNvbnRleHR1YWwgY2xhc3NlcztcbiAgICAgKiAgICAgIHRleHQgLT4gdGhlIHRleHQgdG8gZGlzcGxheTtcbiAgICAgKiAgICAgIGtlZXAgLT4g4oCcdHJ1ZeKAnSB0byBzaW1wbHkgYWRkIGFsZXJ0IHRvIGJ1ZmZlcixcbiAgICAgKiAgICAgICAgICAgICAg4oCcZmFsc2XigJ0gdG8gZGlzcGxheSBhbGwgcHJldmlvdXNseSBidWZmZXJlZCBhbGVydHNcbiAgICAgKiAgICAgICAgICAgICAgYW5kIGZsdXNoIGJ1ZmZlci5cbiAgICAgKlxuICAgICAqL1xuICAgIHZhciBhbGVydCA9IGZ1bmN0aW9uKCBhbGVydERhdGEgKSB7XG5cbiAgICAgICAgaWYgKCBhbGVydERhdGEgPT09IHVuZGVmaW5lZCApIHtcblxuICAgICAgICAgICAgX2Rpc3BsYXlBbGxCU0FsZXJ0cyggKTtcblxuICAgICAgICB9IGVsc2Uge1xuXG4gICAgICAgICAgICBpZiAoIGFsZXJ0RGF0YS50eXBlID09PSB1bmRlZmluZWRcbiAgICAgICAgICAgICAgICAgICAgLy98fCAhICggYWxlcnREYXRhLnR5cGUgaW4gX21lc3NhZ2VzIClcbiAgICAgICAgICAgICAgICAgICAgfHwgISBfbWVzc2FnZXMuaGFzT3duUHJvcGVydHkoIGFsZXJ0RGF0YS50eXBlICkgKSB7XG4gICAgICAgICAgICAgICAgYWxlcnREYXRhLnR5cGUgPSAnZGFuZ2VyJztcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgaWYgKCBhbGVydERhdGEudGV4dCA9PT0gdW5kZWZpbmVkICkge1xuICAgICAgICAgICAgICAgIGFsZXJ0RGF0YS50ZXh0ID0gXCJVbmUgZXJyZXVyIGVzdCBzdXJ2ZW51ZS5cIjtcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgaWYgKCBhbGVydERhdGEua2VlcCA9PT0gdW5kZWZpbmVkICkge1xuICAgICAgICAgICAgICAgIGFsZXJ0RGF0YS5rZWVwID0gZmFsc2U7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIF9tZXNzYWdlc1sgYWxlcnREYXRhLnR5cGUgXS5wdXNoKCBhbGVydERhdGEudGV4dCApO1xuXG4gICAgICAgICAgICBpZiAoICEgYWxlcnREYXRhLmtlZXAgKSB7XG4gICAgICAgICAgICAgICAgX2Rpc3BsYXlBbGxCU0FsZXJ0cyggKTtcbiAgICAgICAgICAgIH1cblxuICAgICAgICB9XG5cbiAgICB9O1xuXG5cblxuICAgIC8qKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKlxuXG4gICAgICAgICAgICBJbml0LlxuICAgICovXG5cbiAgICBfcmVzZXRNZXNzYWdlcyggKTtcblxuXG4gICAgLypcbiAgICAgICAgUHVibGljIHBvaW50ZXJzIHRvIGV4cG9zZWQgaXRlbXMuXG4gICAgKi9cblxuICAgIHJldHVybiB7XG4gICAgICAgIHNwaW5uZXI6IF8kbG9hZGluZ1NwaW5uZXIsXG4gICAgICAgIGFsZXJ0OiBhbGVydFxuICAgIH07XG5cblxuXG59ICkgKCApO1xuXG5cbmV4cG9ydCBkZWZhdWx0IFNJTFRvb2xzO1xuXG4iLCIvKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqXG5cbiAgICAgICAgU3lsbGFidXMgbW9kdWxlLlxuXG4qL1xuXG5cbmltcG9ydCAkIGZyb20gJ2pxdWVyeSc7XG5pbXBvcnQgU0lMVG9vbHMgZnJvbSAnLi9zaWxfdG9vbGtpdCc7XG5cblxuXG52YXIgU3lsbGFidXMgPSAoIGZ1bmN0aW9uICggKSB7XG5cblxuICAgIFwidXNlIHN0cmljdFwiO1xuXG5cbiAgICAvKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKipcblxuICAgICAgICAgICAgUHJpdmF0ZSBpdGVtcy5cbiAgICAqL1xuXG5cbiAgICB2YXIgX2FqYXhUYWJDb250ZW50TG9hZGVyID0gZnVuY3Rpb24oICR0YWJMaW5rICkge1xuXG4gICAgICAgIHZhciByb3V0ZSA9ICR0YWJMaW5rLmRhdGEoICdyb3V0ZScgKTtcblxuICAgICAgICBpZiAoIHJvdXRlICE9PSBcIlwiICkge1xuXG4gICAgICAgICAgICBTSUxUb29scy5zcGlubmVyLmZhZGVJbigge1xuICAgICAgICAgICAgICAgIGFsd2F5czogZnVuY3Rpb24oICkge1xuICAgICAgICAgICAgICAgICAgICAkLmFqYXgoIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHR5cGU6ICdQT1NUJyxcbiAgICAgICAgICAgICAgICAgICAgICAgIHVybDogcm91dGUsXG4gICAgICAgICAgICAgICAgICAgICAgICBjb250ZXh0OiAkKCAnI3BhbmVsXycgKyAkdGFiTGluay5hdHRyKCAnaWQnICkgKVxuICAgICAgICAgICAgICAgICAgICB9ICkuZG9uZSggZnVuY3Rpb24oIGRhdGEgKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICBpZihkYXRhLmNvbnRlbnQgIT09IHVuZGVmaW5lZCkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICQodGhpcykuaHRtbChkYXRhLmNvbnRlbnQpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICR0YWJMaW5rLmRhdGEoJ3JvdXRlJywgXCJcIik7XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICBpZihkYXRhLmFsZXJ0ICE9PSB1bmRlZmluZWQpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoZGF0YS5hbGVydC50eXBlICE9PSB1bmRlZmluZWQgJiYgZGF0YS5hbGVydC5tZXNzYWdlICE9PSB1bmRlZmluZWQpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgU0lMVG9vbHMuYWxlcnQoIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHR5cGU6IGRhdGEuYWxlcnQudHlwZSxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHRleHQ6IGRhdGEuYWxlcnQubWVzc2FnZVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9ICk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICB9ICkuYWx3YXlzKCBmdW5jdGlvbiggKXtcbiAgICAgICAgICAgICAgICAgICAgICAgIFNJTFRvb2xzLnNwaW5uZXIuZmFkZU91dCggKTtcbiAgICAgICAgICAgICAgICAgICAgfSApO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0gKTtcbiAgICAgICAgfVxuXG4gICAgfTtcblxuXG4gICAgdmFyIF9zYXZlQ3VycmVudFRhYkNvbnRlbnQgPSBmdW5jdGlvbiggdGFiICkge1xuICAgICAgICBpZighdGFiW1wiMFwiXS5jbGFzc0xpc3QuY29udGFpbnMoJ3N5bGxhYnVzLXRhYi1hY3RpdmUnKSl7XG4gICAgICAgICAgICB2YXIgYWN0aXZlX3RhYl9idXR0b24gPSBkb2N1bWVudC5nZXRFbGVtZW50c0J5Q2xhc3NOYW1lKCdzeWxsYWJ1cy10YWItYWN0aXZlJylbMF07XG4gICAgICAgICAgICB2YXIgYWN0aXZlX3RhYiA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKFwicGFuZWxfXCIrYWN0aXZlX3RhYl9idXR0b24uaWQpO1xuICAgICAgICAgICAgdmFyIHN1bWJpdF9idXR0b24gPSBhY3RpdmVfdGFiLmdldEVsZW1lbnRzQnlDbGFzc05hbWUoXCJzdWJtaXRcIilbMF07XG4gICAgICAgICAgICBzdW1iaXRfYnV0dG9uLmNsaWNrKCk7XG4gICAgICAgICAgICBhY3RpdmVfdGFiX2J1dHRvbi5jbGFzc0xpc3QucmVtb3ZlKCdzeWxsYWJ1cy10YWItYWN0aXZlJyk7XG4gICAgICAgICAgICB0YWIuYWRkQ2xhc3MoICdzeWxsYWJ1cy10YWItYWN0aXZlJyApO1xuICAgICAgICB9XG4gICAgfVxuXG5cblxuICAgIC8qKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKlxuXG4gICAgICAgICAgICBQdWJsaWMgaXRlbXMuXG4gICAgKi9cblxuXG4gICAgdmFyIHRhYkxvYWRlckluaXQgPSBmdW5jdGlvbiggKSB7XG5cbiAgICAgICAgJCggJ21haW4gPiAucm93OmZpcnN0LWNoaWxkID4gZGl2ID4gdWwubmF2JyApXG4gICAgICAgICAgICAgICAgLm9uKCAnY2xpY2snLCAnbGkubmF2LWl0ZW0gPiBhJywgZnVuY3Rpb24oICkge1xuXG4gICAgICAgICAgICBfYWpheFRhYkNvbnRlbnRMb2FkZXIoICQoIHRoaXMgKSApO1xuICAgICAgICAgICAgX3NhdmVDdXJyZW50VGFiQ29udGVudCggJCggdGhpcyApICk7XG5cbiAgICAgICAgfSApO1xuXG4gICAgICAgICQoICcjdGFiLTEnICkuYWRkQ2xhc3MoICdhY3RpdmUnICk7XG4gICAgICAgICQoICcjdGFiLTEnICkuYWRkQ2xhc3MoICdzeWxsYWJ1cy10YWItYWN0aXZlJyApO1xuICAgICAgICBfYWpheFRhYkNvbnRlbnRMb2FkZXIoICQoICcjdGFiLTEnICkgKTtcblxuICAgIH07XG5cblxuICAgIHZhciBoYW5kbGVBamF4UmVzcG9uc2UgPSBmdW5jdGlvbiggcmVzcG9uc2UgKSB7XG4gICAgICAgIGlmKHJlc3BvbnNlLm1lc3NhZ2VzICE9PSB1bmRlZmluZWQpIHtcbiAgICAgICAgICAgIHJlc3BvbnNlLm1lc3NhZ2VzLmZvckVhY2goZnVuY3Rpb24obWVzc2FnZSl7XG4gICAgICAgICAgICAgICAgaWYgKG1lc3NhZ2UudHlwZSAhPT0gdW5kZWZpbmVkICYmIG1lc3NhZ2UubWVzc2FnZSAhPT0gdW5kZWZpbmVkKSB7XG4gICAgICAgICAgICAgICAgICAgIFNJTFRvb2xzLmFsZXJ0KCB7XG4gICAgICAgICAgICAgICAgICAgICAgICB0eXBlOiBtZXNzYWdlLnR5cGUsXG4gICAgICAgICAgICAgICAgICAgICAgICB0ZXh0OiBtZXNzYWdlLm1lc3NhZ2VcbiAgICAgICAgICAgICAgICAgICAgfSApO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9XG4gICAgICAgIC8qXG4gICAgICAgIGlmKHJlc3BvbnNlLnJlbmRlcnMgIT09IHVuZGVmaW5lZCkge1xuICAgICAgICAgICAgcmVzcG9uc2UucmVuZGVycy5mb3JFYWNoKGZ1bmN0aW9uKHJlbmRlcikge1xuICAgICAgICAgICAgICAgIGlmIChyZW5kZXIuZWxlbWVudCAhPT0gdW5kZWZpbmVkICYmIHJlbmRlci5jb250ZW50ICE9PSB1bmRlZmluZWQpIHtcbiAgICAgICAgICAgICAgICAgICAgJChyZW5kZXIuZWxlbWVudCkuaHRtbChyZW5kZXIuY29udGVudCk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSk7XG4gICAgICAgIH0gLy8qL1xuICAgIH1cblxuXG4gICAgLypcbiAgICAgICAgUHVibGljIHBvaW50ZXJzIHRvIGV4cG9zZWQgaXRlbXMuXG4gICAgKi9cblxuICAgIHJldHVybiB7XG4gICAgICAgIHRhYkxvYWRlckluaXQ6IHRhYkxvYWRlckluaXQsXG4gICAgICAgIGhhbmRsZUFqYXhSZXNwb25zZTogaGFuZGxlQWpheFJlc3BvbnNlXG4gICAgfTtcblxuXG5cbn0gKSAoICk7XG5cblxuZXhwb3J0IGRlZmF1bHQgU3lsbGFidXM7XG5cbiIsIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpbiIsIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpbiJdLCJzb3VyY2VSb290IjoiIn0=