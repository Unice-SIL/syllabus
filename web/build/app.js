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

  var _saveForm = function _saveForm($tabLink) {
    _sil_toolkit__WEBPACK_IMPORTED_MODULE_1__["default"].spinner.fadeIn({
      always: function always() {
        jquery__WEBPACK_IMPORTED_MODULE_0___default.a.ajax({
          type: 'POST',
          url: "",
          data: form.serialize()
        }).done(function (response) {
          Syllabus.handleAjaxResponse(response);
        }).always(function () {
          _sil_toolkit__WEBPACK_IMPORTED_MODULE_1__["default"].spinner.fadeOut();
        });
      }
    });
  };

  var _saveCurrentTabContent = function _saveCurrentTabContent(tabLink) {
    var $panel = jquery__WEBPACK_IMPORTED_MODULE_0___default()('#panel_' + tabLink.id),
        url = $panel.data('submit-url'),
        form = document.getElementsByName($panel.find('form').attr('name'))[0],
        data = new FormData(form);
    /*
    for ( instance in CKEDITOR.instances ) {
        CKEDITOR.instances[ instance ].updateElement( );
    } //*/

    jquery__WEBPACK_IMPORTED_MODULE_0___default.a.ajax({
      type: 'POST',
      enctype: 'multipart/form-data',
      processData: false,
      // Important!
      contentType: false,
      url: url,
      data: data,
      cache: false,
      timeout: 600000 //} ).done( function( response ) {
      //    handleAjaxResponse( response );

    });
  };
  /**************************************************************************
           Public items.
  */


  var tabLoaderInit = function tabLoaderInit() {
    jquery__WEBPACK_IMPORTED_MODULE_0___default()('a[data-toggle="tab"]').on('click', function () {
      _ajaxTabContentLoader(jquery__WEBPACK_IMPORTED_MODULE_0___default()(this));
    }).on('hide.bs.tab', function (event) {
      _saveCurrentTabContent(event.target);
    });
    ;
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hcHAvUmVzb3VyY2VzL2Fzc2V0cy9qcy9hcHAuanMiLCJ3ZWJwYWNrOi8vLy4vYXBwL1Jlc291cmNlcy9hc3NldHMvanMvc2lsX3Rvb2xraXQuanMiLCJ3ZWJwYWNrOi8vLy4vYXBwL1Jlc291cmNlcy9hc3NldHMvanMvc3lsbGFidXMuanMiLCJ3ZWJwYWNrOi8vLy4vYXBwL1Jlc291cmNlcy9hc3NldHMvc2Nzcy9hcHAuc2NzcyIsIndlYnBhY2s6Ly8vLi9hcHAvUmVzb3VyY2VzL2Fzc2V0cy9zY3NzL3NpbF90b29sa2l0LnNjc3MiXSwibmFtZXMiOlsiZ2xvYmFsIiwiJCIsIndpbmRvdyIsImpRdWVyeSIsImJvb3Rib3giLCJib290c3RyYXBUb2dnbGUiLCJTSUxUb29scyIsIlN5bGxhYnVzIiwiYWRkTG9jYWxlIiwiT0siLCJDQU5DRUwiLCJDT05GSVJNIiwic2V0TG9jYWxlIiwiZG9jdW1lbnQiLCJyZWFkeSIsImFqYXhFcnJvciIsImV2ZW50IiwianFYSFIiLCJhamF4U2V0dGluZ3MiLCJ0aHJvd25FcnJvciIsImNvbnNvbGUiLCJsb2ciLCJhbGVydCIsInR5cGUiLCJ0ZXh0Iiwic3RhdHVzIiwiTVNfQkVGT1JFX0FMRVJUX0RJU01JU1MiLCJOT05fQVVUT19ESVNNSVNTSUJMRV9BTEVSVF9UWVBFUyIsIl8kbG9hZGluZ1NwaW5uZXIiLCJfJGFsZXJ0Q29udGFpbmVyIiwiX21lc3NhZ2VzIiwiX3JlbW92ZUl0ZW0iLCJpdGVtIiwiZWxlbSIsInJlbW92ZSIsIl9yZXNldE1lc3NhZ2VzIiwiX2Rpc3BsYXlBbGxCU0FsZXJ0cyIsImtleSIsIm1lc3NhZ2UiLCJpbmRleCIsIiRidXR0b24iLCIkYWxlcnQiLCJwcmVwZW5kIiwiYXBwZW5kIiwiaW5jbHVkZXMiLCJzbGlkZURvd24iLCJkZWxheSIsInNsaWRlVXAiLCJhbHdheXMiLCJhbGVydERhdGEiLCJ1bmRlZmluZWQiLCJoYXNPd25Qcm9wZXJ0eSIsImtlZXAiLCJwdXNoIiwic3Bpbm5lciIsIl9hamF4VGFiQ29udGVudExvYWRlciIsIiR0YWJMaW5rIiwicm91dGUiLCJkYXRhIiwiZmFkZUluIiwiYWpheCIsInVybCIsImNvbnRleHQiLCJhdHRyIiwiZG9uZSIsImNvbnRlbnQiLCJodG1sIiwiZmFkZU91dCIsIl9zYXZlRm9ybSIsImZvcm0iLCJzZXJpYWxpemUiLCJyZXNwb25zZSIsImhhbmRsZUFqYXhSZXNwb25zZSIsIl9zYXZlQ3VycmVudFRhYkNvbnRlbnQiLCJ0YWJMaW5rIiwiJHBhbmVsIiwiaWQiLCJnZXRFbGVtZW50c0J5TmFtZSIsImZpbmQiLCJGb3JtRGF0YSIsImVuY3R5cGUiLCJwcm9jZXNzRGF0YSIsImNvbnRlbnRUeXBlIiwiY2FjaGUiLCJ0aW1lb3V0IiwidGFiTG9hZGVySW5pdCIsIm9uIiwidGFyZ2V0IiwiYWRkQ2xhc3MiLCJtZXNzYWdlcyIsImZvckVhY2giXSwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7Ozs7OztBQVFBOzs7QUFJQTtBQUNBO0NBR0E7O0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Q0FHQTs7QUFDQUEsTUFBTSxDQUFDQyxDQUFQLEdBQVdDLE1BQU0sQ0FBQ0QsQ0FBUCxHQUFXRCxNQUFNLENBQUNHLE1BQVAsR0FBZ0JELG9DQUFBLEdBQWdCRCw2Q0FBdEQ7QUFDQUQsTUFBTSxDQUFDSSxPQUFQLEdBQWlCQSw4Q0FBakI7QUFDQUosTUFBTSxDQUFDSyxlQUFQLEdBQXlCQSx3REFBekI7QUFDQUwsTUFBTSxDQUFDTSxRQUFQLEdBQWtCQSxvREFBbEI7QUFDQU4sTUFBTSxDQUFDTyxRQUFQLEdBQWtCQSxpREFBbEI7QUFJQTs7OztBQUlBO0FBSUE7Ozs7QUFJQTtBQUlBOzs7Ozs7Ozs7Ozs7Ozs7Ozs7QUFvQkE7Ozs7O0FBS0FILDhDQUFPLENBQUNJLFNBQVIsQ0FBbUIsSUFBbkIsRUFBeUI7QUFDakJDLElBQUUsRUFBUSxJQURPO0FBRWpCQyxRQUFNLEVBQUksU0FGTztBQUdqQkMsU0FBTyxFQUFHO0FBSE8sQ0FBekI7QUFLQVAsOENBQU8sQ0FBQ1EsU0FBUixDQUFtQixJQUFuQjtBQUlBOzs7O0FBSUFYLDZDQUFDLENBQUVZLFFBQUYsQ0FBRCxDQUFjQyxLQUFkLENBQXFCLFlBQVk7QUFFN0JiLCtDQUFDLENBQUVZLFFBQUYsQ0FBRCxDQUFjRSxTQUFkLENBQXlCLFVBQVVDLEtBQVYsRUFBaUJDLEtBQWpCLEVBQXdCQyxZQUF4QixFQUFzQ0MsV0FBdEMsRUFBb0Q7QUFFekVDLFdBQU8sQ0FBQ0MsR0FBUixDQUFhO0FBQUVMLFdBQUssRUFBTEEsS0FBRjtBQUFTQyxXQUFLLEVBQUxBLEtBQVQ7QUFBZ0JDLGtCQUFZLEVBQVpBLFlBQWhCO0FBQThCQyxpQkFBVyxFQUFYQTtBQUE5QixLQUFiO0FBQ0FiLHdEQUFRLENBQUNnQixLQUFULENBQWdCO0FBQ1pDLFVBQUksRUFBRSxRQURNO0FBRVpDLFVBQUksRUFBRSw4QkFBOEJQLEtBQUssQ0FBQ1EsTUFBcEMsR0FBNkM7QUFGdkMsS0FBaEI7QUFLSCxHQVJEO0FBVUgsQ0FaRCxFOzs7Ozs7Ozs7Ozs7O0FDdEZBO0FBQUE7QUFBQTtBQUFBOzs7OztBQU9BOztBQUlBLElBQUluQixRQUFRLEdBQUssWUFBYTtBQUcxQjtBQUdBOzs7O0FBTUEsTUFBTW9CLHVCQUF1QixHQUFHLElBQWhDO0FBQUEsTUFDSUMsZ0NBQWdDLEdBQUcsQ0FDM0I7QUFDQTtBQUNBLFVBSDJCLENBRHZDOztBQU9BLE1BQUlDLGdCQUFnQixHQUFHM0IsNkNBQUMsQ0FBRSxrQkFBRixDQUF4QjtBQUFBLE1BQ0k0QixnQkFBZ0IsR0FBRzVCLDZDQUFDLENBQUUsbUJBQUYsQ0FEeEI7QUFBQSxNQUVJNkIsU0FBUyxHQUFHLEVBRmhCOztBQUtBLE1BQUlDLFdBQVcsR0FBRyxTQUFkQSxXQUFjLENBQVVDLElBQVYsRUFBaUI7QUFFL0IvQixpREFBQyxDQUFFK0IsSUFBSSxDQUFDQyxJQUFQLENBQUQsQ0FBZUMsTUFBZjtBQUVILEdBSkQ7O0FBT0EsTUFBSUMsY0FBYyxHQUFHLFNBQWpCQSxjQUFpQixHQUFZO0FBRTdCTCxhQUFTLEdBQUc7QUFDUixlQUFTLEVBREQ7QUFFUixjQUFRLEVBRkE7QUFHUixtQkFBYSxFQUhMO0FBSVIsaUJBQVcsRUFKSDtBQUtSLGlCQUFXLEVBTEg7QUFNUixjQUFRLEVBTkE7QUFPUixpQkFBVyxFQVBIO0FBUVIsZ0JBQVU7QUFSRixLQUFaO0FBV0gsR0FiRDs7QUFnQkEsTUFBSU0sbUJBQW1CLEdBQUcsU0FBdEJBLG1CQUFzQixHQUFZO0FBRWxDLFNBQU0sSUFBSUMsR0FBVixJQUFpQlAsU0FBakIsRUFBNkI7QUFFekIsVUFBSVEsT0FBTyxHQUFHUixTQUFTLENBQUVPLEdBQUYsQ0FBdkI7O0FBRUEsV0FBTSxJQUFJRSxLQUFWLElBQW1CRCxPQUFuQixFQUE2QjtBQUV6QixZQUFJRSxPQUFPLEdBQUd2Qyw2Q0FBQyxDQUFFLFVBQUYsRUFBYztBQUNyQixrQkFBUSxRQURhO0FBRXJCLG1CQUFTLE9BRlk7QUFHckIsMEJBQWdCLE9BSEs7QUFJckIsd0JBQWMsT0FKTztBQUtyQixrQkFBUTtBQUxhLFNBQWQsQ0FBZjtBQUFBLFlBT0l3QyxNQUFNLEdBQUd4Qyw2Q0FBQyxDQUFFLE9BQUYsRUFBVztBQUNqQixtQkFBUyw2Q0FBNkNvQyxHQURyQztBQUVqQixrQkFBUUMsT0FBTyxDQUFFQyxLQUFGLENBRkU7QUFHakIsaUJBQU87QUFBRSx1QkFBVztBQUFiO0FBSFUsU0FBWCxDQVBkOztBQWFBVix3QkFBZ0IsQ0FBQ2EsT0FBakIsQ0FBMEJELE1BQU0sQ0FBQ0UsTUFBUCxDQUFlSCxPQUFmLENBQTFCOztBQUVBLFlBQUtiLGdDQUFnQyxDQUFDaUIsUUFBakMsQ0FBMkNQLEdBQTNDLENBQUwsRUFBd0Q7QUFFcERJLGdCQUFNLENBQUNJLFNBQVA7QUFFSCxTQUpELE1BSU87QUFFSEosZ0JBQU0sQ0FBQ0ksU0FBUCxHQUFvQkMsS0FBcEIsQ0FBMkJwQix1QkFBM0IsRUFDU3FCLE9BRFQsQ0FDa0I7QUFDTkMsa0JBQU0sRUFBRWpCO0FBREYsV0FEbEI7QUFLSDtBQUNKO0FBQ0o7O0FBRURJLGtCQUFjO0FBRWpCLEdBeENEO0FBNENBOzs7O0FBTUE7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FBcUJBLE1BQUliLEtBQUssR0FBRyxTQUFSQSxLQUFRLENBQVUyQixTQUFWLEVBQXNCO0FBRTlCLFFBQUtBLFNBQVMsS0FBS0MsU0FBbkIsRUFBK0I7QUFFM0JkLHlCQUFtQjtBQUV0QixLQUpELE1BSU87QUFFSCxVQUFLYSxTQUFTLENBQUMxQixJQUFWLEtBQW1CMkIsU0FBbkIsQ0FDRztBQURILFNBRU0sQ0FBRXBCLFNBQVMsQ0FBQ3FCLGNBQVYsQ0FBMEJGLFNBQVMsQ0FBQzFCLElBQXBDLENBRmIsRUFFMEQ7QUFDdEQwQixpQkFBUyxDQUFDMUIsSUFBVixHQUFpQixRQUFqQjtBQUNIOztBQUVELFVBQUswQixTQUFTLENBQUN6QixJQUFWLEtBQW1CMEIsU0FBeEIsRUFBb0M7QUFDaENELGlCQUFTLENBQUN6QixJQUFWLEdBQWlCLDBCQUFqQjtBQUNIOztBQUVELFVBQUt5QixTQUFTLENBQUNHLElBQVYsS0FBbUJGLFNBQXhCLEVBQW9DO0FBQ2hDRCxpQkFBUyxDQUFDRyxJQUFWLEdBQWlCLEtBQWpCO0FBQ0g7O0FBRUR0QixlQUFTLENBQUVtQixTQUFTLENBQUMxQixJQUFaLENBQVQsQ0FBNEI4QixJQUE1QixDQUFrQ0osU0FBUyxDQUFDekIsSUFBNUM7O0FBRUEsVUFBSyxDQUFFeUIsU0FBUyxDQUFDRyxJQUFqQixFQUF3QjtBQUNwQmhCLDJCQUFtQjtBQUN0QjtBQUVKO0FBRUosR0E5QkQ7QUFrQ0E7Ozs7O0FBS0FELGdCQUFjO0FBR2Q7Ozs7O0FBSUEsU0FBTztBQUNIbUIsV0FBTyxFQUFFMUIsZ0JBRE47QUFFSE4sU0FBSyxFQUFFQTtBQUZKLEdBQVA7QUFPSCxDQTNLYyxFQUFmOztBQThLZWhCLHVFQUFmLEU7Ozs7Ozs7Ozs7OztBQ3pMQTtBQUFBO0FBQUE7QUFBQTtBQUFBOzs7OztBQU9BO0FBQ0E7O0FBSUEsSUFBSUMsUUFBUSxHQUFLLFlBQWE7QUFHMUI7QUFHQTs7OztBQU1BLE1BQUlnRCxxQkFBcUIsR0FBRyxTQUF4QkEscUJBQXdCLENBQVVDLFFBQVYsRUFBcUI7QUFFN0MsUUFBSUMsS0FBSyxHQUFHRCxRQUFRLENBQUNFLElBQVQsQ0FBZSxPQUFmLENBQVo7O0FBRUEsUUFBS0QsS0FBSyxLQUFLLEVBQWYsRUFBb0I7QUFFaEJuRCwwREFBUSxDQUFDZ0QsT0FBVCxDQUFpQkssTUFBakIsQ0FBeUI7QUFDckJYLGNBQU0sRUFBRSxrQkFBWTtBQUNoQi9DLHVEQUFDLENBQUMyRCxJQUFGLENBQVE7QUFDSnJDLGdCQUFJLEVBQUUsTUFERjtBQUVKc0MsZUFBRyxFQUFFSixLQUZEO0FBR0pLLG1CQUFPLEVBQUU3RCw2Q0FBQyxDQUFFLFlBQVl1RCxRQUFRLENBQUNPLElBQVQsQ0FBZSxJQUFmLENBQWQ7QUFITixXQUFSLEVBSUlDLElBSkosQ0FJVSxVQUFVTixJQUFWLEVBQWlCO0FBQ3ZCLGdCQUFHQSxJQUFJLENBQUNPLE9BQUwsS0FBaUJmLFNBQXBCLEVBQStCO0FBQzNCakQsMkRBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUWlFLElBQVIsQ0FBYVIsSUFBSSxDQUFDTyxPQUFsQjtBQUNBVCxzQkFBUSxDQUFDRSxJQUFULENBQWMsT0FBZCxFQUF1QixFQUF2QjtBQUNIOztBQUNELGdCQUFHQSxJQUFJLENBQUNwQyxLQUFMLEtBQWU0QixTQUFsQixFQUE2QjtBQUN6QixrQkFBSVEsSUFBSSxDQUFDcEMsS0FBTCxDQUFXQyxJQUFYLEtBQW9CMkIsU0FBcEIsSUFBaUNRLElBQUksQ0FBQ3BDLEtBQUwsQ0FBV2dCLE9BQVgsS0FBdUJZLFNBQTVELEVBQXVFO0FBQ25FNUMsb0VBQVEsQ0FBQ2dCLEtBQVQsQ0FBZ0I7QUFDWkMsc0JBQUksRUFBRW1DLElBQUksQ0FBQ3BDLEtBQUwsQ0FBV0MsSUFETDtBQUVaQyxzQkFBSSxFQUFFa0MsSUFBSSxDQUFDcEMsS0FBTCxDQUFXZ0I7QUFGTCxpQkFBaEI7QUFJSDtBQUNKO0FBQ0osV0FqQkQsRUFpQklVLE1BakJKLENBaUJZLFlBQVc7QUFDbkIxQyxnRUFBUSxDQUFDZ0QsT0FBVCxDQUFpQmEsT0FBakI7QUFDSCxXQW5CRDtBQW9CSDtBQXRCb0IsT0FBekI7QUF3Qkg7QUFFSixHQWhDRDs7QUFtQ0EsTUFBSUMsU0FBUyxHQUFHLFNBQVpBLFNBQVksQ0FBVVosUUFBVixFQUFxQjtBQUVqQ2xELHdEQUFRLENBQUNnRCxPQUFULENBQWlCSyxNQUFqQixDQUF5QjtBQUNyQlgsWUFBTSxFQUFFLGtCQUFVO0FBQ2QvQyxxREFBQyxDQUFDMkQsSUFBRixDQUFPO0FBQ0hyQyxjQUFJLEVBQUUsTUFESDtBQUVIc0MsYUFBRyxFQUFFLEVBRkY7QUFHSEgsY0FBSSxFQUFFVyxJQUFJLENBQUNDLFNBQUw7QUFISCxTQUFQLEVBSUdOLElBSkgsQ0FJUSxVQUFTTyxRQUFULEVBQWtCO0FBQ3RCaEUsa0JBQVEsQ0FBQ2lFLGtCQUFULENBQTRCRCxRQUE1QjtBQUNILFNBTkQsRUFNR3ZCLE1BTkgsQ0FNVSxZQUFVO0FBQ2hCMUMsOERBQVEsQ0FBQ2dELE9BQVQsQ0FBaUJhLE9BQWpCO0FBQ0gsU0FSRDtBQVNIO0FBWG9CLEtBQXpCO0FBY0gsR0FoQkQ7O0FBbUJBLE1BQUlNLHNCQUFzQixHQUFHLFNBQXpCQSxzQkFBeUIsQ0FBVUMsT0FBVixFQUFvQjtBQUU3QyxRQUFJQyxNQUFNLEdBQUcxRSw2Q0FBQyxDQUFFLFlBQVl5RSxPQUFPLENBQUNFLEVBQXRCLENBQWQ7QUFBQSxRQUNJZixHQUFHLEdBQUdjLE1BQU0sQ0FBQ2pCLElBQVAsQ0FBYSxZQUFiLENBRFY7QUFBQSxRQUVJVyxJQUFJLEdBQUd4RCxRQUFRLENBQUNnRSxpQkFBVCxDQUE0QkYsTUFBTSxDQUFDRyxJQUFQLENBQWEsTUFBYixFQUFzQmYsSUFBdEIsQ0FBNEIsTUFBNUIsQ0FBNUIsRUFBb0UsQ0FBcEUsQ0FGWDtBQUFBLFFBR0lMLElBQUksR0FBRyxJQUFJcUIsUUFBSixDQUFhVixJQUFiLENBSFg7QUFLQTs7Ozs7QUFLQXBFLGlEQUFDLENBQUMyRCxJQUFGLENBQVE7QUFDSnJDLFVBQUksRUFBRSxNQURGO0FBRUp5RCxhQUFPLEVBQUUscUJBRkw7QUFHSkMsaUJBQVcsRUFBRSxLQUhUO0FBR2dCO0FBQ3BCQyxpQkFBVyxFQUFFLEtBSlQ7QUFLSnJCLFNBQUcsRUFBRUEsR0FMRDtBQU1KSCxVQUFJLEVBQUVBLElBTkY7QUFPSnlCLFdBQUssRUFBRSxLQVBIO0FBUUpDLGFBQU8sRUFBRSxNQVJMLENBU1I7QUFDQTs7QUFWUSxLQUFSO0FBYUgsR0F6QkQ7QUE2QkE7Ozs7O0FBTUEsTUFBSUMsYUFBYSxHQUFHLFNBQWhCQSxhQUFnQixHQUFZO0FBRTVCcEYsaURBQUMsQ0FBRSxzQkFBRixDQUFELENBQTRCcUYsRUFBNUIsQ0FBZ0MsT0FBaEMsRUFBeUMsWUFBWTtBQUNqRC9CLDJCQUFxQixDQUFFdEQsNkNBQUMsQ0FBRSxJQUFGLENBQUgsQ0FBckI7QUFDSCxLQUZELEVBRUlxRixFQUZKLENBRVEsYUFGUixFQUV1QixVQUFVdEUsS0FBVixFQUFrQjtBQUNyQ3lELDRCQUFzQixDQUFFekQsS0FBSyxDQUFDdUUsTUFBUixDQUF0QjtBQUNILEtBSkQ7QUFJSTtBQUVKdEYsaURBQUMsQ0FBRSxRQUFGLENBQUQsQ0FBY3VGLFFBQWQsQ0FBd0IsUUFBeEI7QUFDQXZGLGlEQUFDLENBQUUsUUFBRixDQUFELENBQWN1RixRQUFkLENBQXdCLHFCQUF4Qjs7QUFFQWpDLHlCQUFxQixDQUFFdEQsNkNBQUMsQ0FBRSxRQUFGLENBQUgsQ0FBckI7QUFFSCxHQWJEOztBQWdCQSxNQUFJdUUsa0JBQWtCLEdBQUcsU0FBckJBLGtCQUFxQixDQUFVRCxRQUFWLEVBQXFCO0FBQzFDLFFBQUdBLFFBQVEsQ0FBQ2tCLFFBQVQsS0FBc0J2QyxTQUF6QixFQUFvQztBQUNoQ3FCLGNBQVEsQ0FBQ2tCLFFBQVQsQ0FBa0JDLE9BQWxCLENBQTBCLFVBQVNwRCxPQUFULEVBQWlCO0FBQ3ZDLFlBQUlBLE9BQU8sQ0FBQ2YsSUFBUixLQUFpQjJCLFNBQWpCLElBQThCWixPQUFPLENBQUNBLE9BQVIsS0FBb0JZLFNBQXRELEVBQWlFO0FBQzdENUMsOERBQVEsQ0FBQ2dCLEtBQVQsQ0FBZ0I7QUFDWkMsZ0JBQUksRUFBRWUsT0FBTyxDQUFDZixJQURGO0FBRVpDLGdCQUFJLEVBQUVjLE9BQU8sQ0FBQ0E7QUFGRixXQUFoQjtBQUlIO0FBQ0osT0FQRDtBQVFIO0FBQ0Q7Ozs7Ozs7OztBQVFILEdBbkJEO0FBc0JBOzs7OztBQUlBLFNBQU87QUFDSCtDLGlCQUFhLEVBQUVBLGFBRFo7QUFFSGIsc0JBQWtCLEVBQUVBO0FBRmpCLEdBQVA7QUFPSCxDQXRKYyxFQUFmOztBQXlKZWpFLHVFQUFmLEU7Ozs7Ozs7Ozs7O0FDcktBLHVDOzs7Ozs7Ozs7OztBQ0FBLHVDIiwiZmlsZSI6ImFwcC5qcyIsInNvdXJjZXNDb250ZW50IjpbIi8qXG4gICAgICAgIE1haW4gV2VicGFjayBlbnRyeSBwb2ludC5cblxuXG4qL1xuXG5cblxuLypcbiAgICBJbXBvcnRpbmcgZGVwZW5kZW5jaWVzXG4qL1xuXG4vLyBTQVNTIC8gQ1NTIGRlcGVuZGVuY2llcy5cbmltcG9ydCAnLi4vc2Nzcy9zaWxfdG9vbGtpdC5zY3NzJztcbmltcG9ydCAnLi4vc2Nzcy9hcHAuc2Nzcyc7XG5cbi8vIEltcG9ydGluZyBtb2R1bGVz4oCmXG5pbXBvcnQgJCBmcm9tICdqcXVlcnknO1xuaW1wb3J0IGJvb3Rib3ggZnJvbSAnYm9vdGJveCc7XG5pbXBvcnQgYm9vdHN0cmFwVG9nZ2xlIGZyb20gJ2Jvb3RzdHJhcDQtdG9nZ2xlJztcbmltcG9ydCBTSUxUb29scyBmcm9tICcuL3NpbF90b29sa2l0JztcbmltcG9ydCBTeWxsYWJ1cyBmcm9tICcuL3N5bGxhYnVzJztcblxuLy8g4oCmIGFuZCBtYWtlIHRoZW0gdmlzaWJsZSB0byBleHRlcm5hbCBjb21wb25lbnRzLlxuZ2xvYmFsLiQgPSB3aW5kb3cuJCA9IGdsb2JhbC5qUXVlcnkgPSB3aW5kb3cualF1ZXJ5ID0gJDtcbmdsb2JhbC5ib290Ym94ID0gYm9vdGJveDtcbmdsb2JhbC5ib290c3RyYXBUb2dnbGUgPSBib290c3RyYXBUb2dnbGU7XG5nbG9iYWwuU0lMVG9vbHMgPSBTSUxUb29scztcbmdsb2JhbC5TeWxsYWJ1cyA9IFN5bGxhYnVzO1xuXG5cblxuLypcbiAgICBTb3J0YWJsZUpTIHdpdGggalF1ZXJ5IGJpbmRpbmcuXG4qL1xuXG5pbXBvcnQgJ2pxdWVyeS1zb3J0YWJsZWpzJztcblxuXG5cbi8qXG4gICAgRnVsbCBCb290c3RyYXDigKZcbiovXG5cbmltcG9ydCAnYm9vdHN0cmFwJztcblxuXG5cbi8qXG4gICAg4oCmIG9yIHBhcnRzIG9mIGl0LlxuXG5pbXBvcnQgJ2Jvb3RzdHJhcC9qcy9kaXN0L2FsZXJ0JztcbmltcG9ydCAnYm9vdHN0cmFwL2pzL2Rpc3QvYnV0dG9uJztcbi8vaW1wb3J0ICdib290c3RyYXAvanMvZGlzdC9jYXJvdXNlbCc7XG5pbXBvcnQgJ2Jvb3RzdHJhcC9qcy9kaXN0L2NvbGxhcHNlJztcbi8vaW1wb3J0ICdib290c3RyYXAvanMvZGlzdC9kcm9wZG93bic7XG4vL2ltcG9ydCAnYm9vdHN0cmFwL2pzL2Rpc3QvaW5kZXgnO1xuaW1wb3J0ICdib290c3RyYXAvanMvZGlzdC9tb2RhbCc7XG4vL2ltcG9ydCAnYm9vdHN0cmFwL2pzL2Rpc3QvcG9wb3Zlcic7XG5pbXBvcnQgJ2Jvb3RzdHJhcC9qcy9kaXN0L3Njcm9sbHNweSc7XG5pbXBvcnQgJ2Jvb3RzdHJhcC9qcy9kaXN0L3RhYic7XG4vL2ltcG9ydCAnYm9vdHN0cmFwL2pzL2Rpc3QvdG9hc3QnO1xuLy9pbXBvcnQgJ2Jvb3RzdHJhcC9qcy9kaXN0L3Rvb2x0aXAnO1xuaW1wb3J0ICdib290c3RyYXAvanMvZGlzdC91dGlsJztcbiovXG5cblxuXG4vKlxuICAgIEJvb3Rib3ggbG9jYWxlIChmcikuXG4gICAgICAgIGh0dHA6Ly9ib290Ym94anMuY29tL2RvY3VtZW50YXRpb24uaHRtbFxuKi9cblxuYm9vdGJveC5hZGRMb2NhbGUoICdmcicsIHtcbiAgICAgICAgT0sgICAgICA6ICdPSycsXG4gICAgICAgIENBTkNFTCAgOiAnQW5udWxlcicsXG4gICAgICAgIENPTkZJUk0gOiAnQ29uZmlybWVyJ1xuICAgIH0gKTtcbmJvb3Rib3guc2V0TG9jYWxlKCAnZnInICk7XG5cblxuXG4vKlxuICAgIEFKQVggZXJyb3IgaGFuZGxlci5cbiovXG5cbiQoIGRvY3VtZW50ICkucmVhZHkoIGZ1bmN0aW9uKCApIHtcblxuICAgICQoIGRvY3VtZW50ICkuYWpheEVycm9yKCBmdW5jdGlvbiggZXZlbnQsIGpxWEhSLCBhamF4U2V0dGluZ3MsIHRocm93bkVycm9yICkge1xuXG4gICAgICAgIGNvbnNvbGUubG9nKCB7IGV2ZW50LCBqcVhIUiwgYWpheFNldHRpbmdzLCB0aHJvd25FcnJvciB9ICk7XG4gICAgICAgIFNJTFRvb2xzLmFsZXJ0KCB7XG4gICAgICAgICAgICB0eXBlOiAnZGFuZ2VyJyxcbiAgICAgICAgICAgIHRleHQ6IFwiVW5lIGVycmV1ciBlc3Qgc3VydmVudWUgKFwiICsganFYSFIuc3RhdHVzICsgXCIpLlwiXG4gICAgICAgIH0gKTtcblxuICAgIH0gKTtcblxufSApO1xuXG4iLCIvKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqXG5cbiAgICAgICAgU0lMIHRvb2xzIG1vZHVsZS5cblxuKi9cblxuXG5pbXBvcnQgJCBmcm9tICdqcXVlcnknO1xuXG5cblxudmFyIFNJTFRvb2xzID0gKCBmdW5jdGlvbiAoICkge1xuXG5cbiAgICBcInVzZSBzdHJpY3RcIjtcblxuXG4gICAgLyoqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqXG5cbiAgICAgICAgICAgIFByaXZhdGUgaXRlbXMuXG4gICAgKi9cblxuXG4gICAgY29uc3QgTVNfQkVGT1JFX0FMRVJUX0RJU01JU1MgPSA1MDAwLFxuICAgICAgICBOT05fQVVUT19ESVNNSVNTSUJMRV9BTEVSVF9UWVBFUyA9IFtcbiAgICAgICAgICAgICAgICAvLydpbmZvJyxcbiAgICAgICAgICAgICAgICAvLyd3YXJuaW5nJyxcbiAgICAgICAgICAgICAgICAnZGFuZ2VyJ1xuICAgICAgICAgICAgXTtcblxuICAgIHZhciBfJGxvYWRpbmdTcGlubmVyID0gJCggJyNsb2FkaW5nX3NwaW5uZXInICksXG4gICAgICAgIF8kYWxlcnRDb250YWluZXIgPSAkKCAnI2FsZXJ0c19jb250YWluZXInICksXG4gICAgICAgIF9tZXNzYWdlcyA9IHsgfTtcblxuXG4gICAgdmFyIF9yZW1vdmVJdGVtID0gZnVuY3Rpb24oIGl0ZW0gKSB7XG5cbiAgICAgICAgJCggaXRlbS5lbGVtICkucmVtb3ZlKCApO1xuXG4gICAgfTtcblxuXG4gICAgdmFyIF9yZXNldE1lc3NhZ2VzID0gZnVuY3Rpb24oICkge1xuXG4gICAgICAgIF9tZXNzYWdlcyA9IHtcbiAgICAgICAgICAgICdsaWdodCc6IFsgXSxcbiAgICAgICAgICAgICdkYXJrJzogWyBdLFxuICAgICAgICAgICAgJ3NlY29uZGFyeSc6IFsgXSxcbiAgICAgICAgICAgICdwcmltYXJ5JzogWyBdLFxuICAgICAgICAgICAgJ3N1Y2Nlc3MnOiBbIF0sXG4gICAgICAgICAgICAnaW5mbyc6IFsgXSxcbiAgICAgICAgICAgICd3YXJuaW5nJzogWyBdLFxuICAgICAgICAgICAgJ2Rhbmdlcic6IFsgXVxuICAgICAgICB9O1xuXG4gICAgfTtcblxuXG4gICAgdmFyIF9kaXNwbGF5QWxsQlNBbGVydHMgPSBmdW5jdGlvbiggKSB7XG5cbiAgICAgICAgZm9yICggdmFyIGtleSBpbiBfbWVzc2FnZXMgKSB7XG5cbiAgICAgICAgICAgIHZhciBtZXNzYWdlID0gX21lc3NhZ2VzWyBrZXkgXTtcblxuICAgICAgICAgICAgZm9yICggdmFyIGluZGV4IGluIG1lc3NhZ2UgKSB7XG5cbiAgICAgICAgICAgICAgICB2YXIgJGJ1dHRvbiA9ICQoIFwiPGJ1dHRvbj5cIiwge1xuICAgICAgICAgICAgICAgICAgICAgICAgJ3R5cGUnOiBcImJ1dHRvblwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgJ2NsYXNzJzogXCJjbG9zZVwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgJ2RhdGEtZGlzbWlzcyc6IFwiYWxlcnRcIixcbiAgICAgICAgICAgICAgICAgICAgICAgICdhcmlhLWxhYmVsJzogXCJDbG9zZVwiLFxuICAgICAgICAgICAgICAgICAgICAgICAgJ2h0bWwnOiAnPHNwYW4gYXJpYS1oaWRkZW49XCJ0cnVlXCI+JnRpbWVzOzwvc3Bhbj4nXG4gICAgICAgICAgICAgICAgICAgIH0gKSxcbiAgICAgICAgICAgICAgICAgICAgJGFsZXJ0ID0gJCggXCI8ZGl2PlwiLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICAnY2xhc3MnOiBcImFsZXJ0IGFsZXJ0LWRpc21pc3NpYmxlIGZhZGUgc2hvdyBhbGVydC1cIiArIGtleSxcbiAgICAgICAgICAgICAgICAgICAgICAgICdodG1sJzogbWVzc2FnZVsgaW5kZXggXSxcbiAgICAgICAgICAgICAgICAgICAgICAgICdjc3MnOiB7ICdkaXNwbGF5JzogJ25vbmUnIH1cbiAgICAgICAgICAgICAgICAgICAgfSApO1xuXG4gICAgICAgICAgICAgICAgXyRhbGVydENvbnRhaW5lci5wcmVwZW5kKCAkYWxlcnQuYXBwZW5kKCAkYnV0dG9uICkgKTtcblxuICAgICAgICAgICAgICAgIGlmICggTk9OX0FVVE9fRElTTUlTU0lCTEVfQUxFUlRfVFlQRVMuaW5jbHVkZXMoIGtleSApICkge1xuXG4gICAgICAgICAgICAgICAgICAgICRhbGVydC5zbGlkZURvd24oICk7XG5cbiAgICAgICAgICAgICAgICB9IGVsc2Uge1xuXG4gICAgICAgICAgICAgICAgICAgICRhbGVydC5zbGlkZURvd24oICkuZGVsYXkoIE1TX0JFRk9SRV9BTEVSVF9ESVNNSVNTIClcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAuc2xpZGVVcCgge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBhbHdheXM6IF9yZW1vdmVJdGVtLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0gKTtcblxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuXG4gICAgICAgIF9yZXNldE1lc3NhZ2VzKCApO1xuXG4gICAgfTtcblxuXG5cbiAgICAvKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKipcblxuICAgICAgICAgICAgUHVibGljIGl0ZW1zLlxuICAgICovXG5cblxuICAgIC8qKlxuICAgICAqIEFkZHMgQlMgYWxlcnRzIGluIOKAnF8kYWxlcnRDb250YWluZXLigJ0uXG4gICAgICpcbiAgICAgKiBFeGFtcGxlcyBvZiB1c2U6XG4gICAgICogICAgICBhbGVydCggeyB0eXBlOiAnaW5mbycsIHRleHQ6IFwi4oCcQmxhYmxhLlwiIH0gKTtcbiAgICAgKiAgICAgICAgICAtPiBkaXNwbGF5cyDigJxCbGFibGEu4oCdIGluIGFuIOKAnGluZm/igJ0gYWxlcnQgYXMgd2VsbCBhcyBhbGwgb3RoZXJcbiAgICAgKiAgICAgICAgICBwcmV2aW91c2x5IGJ1ZmZlcmVkIGFsZXJ0cywgZmx1c2hlcyBidWZmZXIuXG4gICAgICogICAgICBhbGVydCggeyB0eXBlOiAnd2FybmluZycsIHRleHQ6IFwiQmx1Ymx1LlwiLCBrZWVwOiB0cnVlIH0gKTtcbiAgICAgKiAgICAgICAgICAtPiBhZGRzIGEgd2FybmluZyBhbGVydCB3aXRoIOKAnEJsYWJsYS7igJ0gdGV4dCBpbiB0aGUgYnVmZmVyLFxuICAgICAqICAgICAgICAgIGRpc3BsYXlzIG5vdGhpbmcuXG4gICAgICogICAgICBhbGVydCggKTtcbiAgICAgKiAgICAgICAgICAtPiBkaXNwbGF5cyBhbGwgcHJldmlvdXNseSBidWZmZXJlZCBhbGVydHMsIGZsdXNoZXMgYnVmZmVyLlxuICAgICAqXG4gICAgICogQHBhcmFtIHtvYmplY3R9IGFsZXJ0RGF0YTpcbiAgICAgKiAgICAgIHR5cGUgLT4gb25lIG9mIHRoZSBCb290c3RyYXAgY29udGV4dHVhbCBjbGFzc2VzO1xuICAgICAqICAgICAgdGV4dCAtPiB0aGUgdGV4dCB0byBkaXNwbGF5O1xuICAgICAqICAgICAga2VlcCAtPiDigJx0cnVl4oCdIHRvIHNpbXBseSBhZGQgYWxlcnQgdG8gYnVmZmVyLFxuICAgICAqICAgICAgICAgICAgICDigJxmYWxzZeKAnSB0byBkaXNwbGF5IGFsbCBwcmV2aW91c2x5IGJ1ZmZlcmVkIGFsZXJ0c1xuICAgICAqICAgICAgICAgICAgICBhbmQgZmx1c2ggYnVmZmVyLlxuICAgICAqXG4gICAgICovXG4gICAgdmFyIGFsZXJ0ID0gZnVuY3Rpb24oIGFsZXJ0RGF0YSApIHtcblxuICAgICAgICBpZiAoIGFsZXJ0RGF0YSA9PT0gdW5kZWZpbmVkICkge1xuXG4gICAgICAgICAgICBfZGlzcGxheUFsbEJTQWxlcnRzKCApO1xuXG4gICAgICAgIH0gZWxzZSB7XG5cbiAgICAgICAgICAgIGlmICggYWxlcnREYXRhLnR5cGUgPT09IHVuZGVmaW5lZFxuICAgICAgICAgICAgICAgICAgICAvL3x8ICEgKCBhbGVydERhdGEudHlwZSBpbiBfbWVzc2FnZXMgKVxuICAgICAgICAgICAgICAgICAgICB8fCAhIF9tZXNzYWdlcy5oYXNPd25Qcm9wZXJ0eSggYWxlcnREYXRhLnR5cGUgKSApIHtcbiAgICAgICAgICAgICAgICBhbGVydERhdGEudHlwZSA9ICdkYW5nZXInO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBpZiAoIGFsZXJ0RGF0YS50ZXh0ID09PSB1bmRlZmluZWQgKSB7XG4gICAgICAgICAgICAgICAgYWxlcnREYXRhLnRleHQgPSBcIlVuZSBlcnJldXIgZXN0IHN1cnZlbnVlLlwiO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBpZiAoIGFsZXJ0RGF0YS5rZWVwID09PSB1bmRlZmluZWQgKSB7XG4gICAgICAgICAgICAgICAgYWxlcnREYXRhLmtlZXAgPSBmYWxzZTtcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgX21lc3NhZ2VzWyBhbGVydERhdGEudHlwZSBdLnB1c2goIGFsZXJ0RGF0YS50ZXh0ICk7XG5cbiAgICAgICAgICAgIGlmICggISBhbGVydERhdGEua2VlcCApIHtcbiAgICAgICAgICAgICAgICBfZGlzcGxheUFsbEJTQWxlcnRzKCApO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgIH1cblxuICAgIH07XG5cblxuXG4gICAgLyoqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqXG5cbiAgICAgICAgICAgIEluaXQuXG4gICAgKi9cblxuICAgIF9yZXNldE1lc3NhZ2VzKCApO1xuXG5cbiAgICAvKlxuICAgICAgICBQdWJsaWMgcG9pbnRlcnMgdG8gZXhwb3NlZCBpdGVtcy5cbiAgICAqL1xuXG4gICAgcmV0dXJuIHtcbiAgICAgICAgc3Bpbm5lcjogXyRsb2FkaW5nU3Bpbm5lcixcbiAgICAgICAgYWxlcnQ6IGFsZXJ0XG4gICAgfTtcblxuXG5cbn0gKSAoICk7XG5cblxuZXhwb3J0IGRlZmF1bHQgU0lMVG9vbHM7XG5cbiIsIi8qKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKipcblxuICAgICAgICBTeWxsYWJ1cyBtb2R1bGUuXG5cbiovXG5cblxuaW1wb3J0ICQgZnJvbSAnanF1ZXJ5JztcbmltcG9ydCBTSUxUb29scyBmcm9tICcuL3NpbF90b29sa2l0JztcblxuXG5cbnZhciBTeWxsYWJ1cyA9ICggZnVuY3Rpb24gKCApIHtcblxuXG4gICAgXCJ1c2Ugc3RyaWN0XCI7XG5cblxuICAgIC8qKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKlxuXG4gICAgICAgICAgICBQcml2YXRlIGl0ZW1zLlxuICAgICovXG5cblxuICAgIHZhciBfYWpheFRhYkNvbnRlbnRMb2FkZXIgPSBmdW5jdGlvbiggJHRhYkxpbmsgKSB7XG5cbiAgICAgICAgdmFyIHJvdXRlID0gJHRhYkxpbmsuZGF0YSggJ3JvdXRlJyApO1xuXG4gICAgICAgIGlmICggcm91dGUgIT09IFwiXCIgKSB7XG5cbiAgICAgICAgICAgIFNJTFRvb2xzLnNwaW5uZXIuZmFkZUluKCB7XG4gICAgICAgICAgICAgICAgYWx3YXlzOiBmdW5jdGlvbiggKSB7XG4gICAgICAgICAgICAgICAgICAgICQuYWpheCgge1xuICAgICAgICAgICAgICAgICAgICAgICAgdHlwZTogJ1BPU1QnLFxuICAgICAgICAgICAgICAgICAgICAgICAgdXJsOiByb3V0ZSxcbiAgICAgICAgICAgICAgICAgICAgICAgIGNvbnRleHQ6ICQoICcjcGFuZWxfJyArICR0YWJMaW5rLmF0dHIoICdpZCcgKSApXG4gICAgICAgICAgICAgICAgICAgIH0gKS5kb25lKCBmdW5jdGlvbiggZGF0YSApIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKGRhdGEuY29udGVudCAhPT0gdW5kZWZpbmVkKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJCh0aGlzKS5odG1sKGRhdGEuY29udGVudCk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgJHRhYkxpbmsuZGF0YSgncm91dGUnLCBcIlwiKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKGRhdGEuYWxlcnQgIT09IHVuZGVmaW5lZCkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmIChkYXRhLmFsZXJ0LnR5cGUgIT09IHVuZGVmaW5lZCAmJiBkYXRhLmFsZXJ0Lm1lc3NhZ2UgIT09IHVuZGVmaW5lZCkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBTSUxUb29scy5hbGVydCgge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdHlwZTogZGF0YS5hbGVydC50eXBlLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdGV4dDogZGF0YS5hbGVydC5tZXNzYWdlXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0gKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIH0gKS5hbHdheXMoIGZ1bmN0aW9uKCApe1xuICAgICAgICAgICAgICAgICAgICAgICAgU0lMVG9vbHMuc3Bpbm5lci5mYWRlT3V0KCApO1xuICAgICAgICAgICAgICAgICAgICB9ICk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSApO1xuICAgICAgICB9XG5cbiAgICB9O1xuXG5cbiAgICB2YXIgX3NhdmVGb3JtID0gZnVuY3Rpb24oICR0YWJMaW5rICkge1xuXG4gICAgICAgIFNJTFRvb2xzLnNwaW5uZXIuZmFkZUluKCB7XG4gICAgICAgICAgICBhbHdheXM6IGZ1bmN0aW9uKCl7XG4gICAgICAgICAgICAgICAgJC5hamF4KHtcbiAgICAgICAgICAgICAgICAgICAgdHlwZTogJ1BPU1QnLFxuICAgICAgICAgICAgICAgICAgICB1cmw6IFwiXCIsXG4gICAgICAgICAgICAgICAgICAgIGRhdGE6IGZvcm0uc2VyaWFsaXplKClcbiAgICAgICAgICAgICAgICB9KS5kb25lKGZ1bmN0aW9uKHJlc3BvbnNlKXtcbiAgICAgICAgICAgICAgICAgICAgU3lsbGFidXMuaGFuZGxlQWpheFJlc3BvbnNlKHJlc3BvbnNlKTtcbiAgICAgICAgICAgICAgICB9KS5hbHdheXMoZnVuY3Rpb24oKXtcbiAgICAgICAgICAgICAgICAgICAgU0lMVG9vbHMuc3Bpbm5lci5mYWRlT3V0KCApO1xuICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcblxuICAgIH07XG5cblxuICAgIHZhciBfc2F2ZUN1cnJlbnRUYWJDb250ZW50ID0gZnVuY3Rpb24oIHRhYkxpbmsgKSB7XG5cbiAgICAgICAgdmFyICRwYW5lbCA9ICQoICcjcGFuZWxfJyArIHRhYkxpbmsuaWQgKSxcbiAgICAgICAgICAgIHVybCA9ICRwYW5lbC5kYXRhKCAnc3VibWl0LXVybCcgKSxcbiAgICAgICAgICAgIGZvcm0gPSBkb2N1bWVudC5nZXRFbGVtZW50c0J5TmFtZSggJHBhbmVsLmZpbmQoICdmb3JtJyApLmF0dHIoICduYW1lJyApIClbIDAgXSxcbiAgICAgICAgICAgIGRhdGEgPSBuZXcgRm9ybURhdGEoZm9ybSk7XG5cbiAgICAgICAgLypcbiAgICAgICAgZm9yICggaW5zdGFuY2UgaW4gQ0tFRElUT1IuaW5zdGFuY2VzICkge1xuICAgICAgICAgICAgQ0tFRElUT1IuaW5zdGFuY2VzWyBpbnN0YW5jZSBdLnVwZGF0ZUVsZW1lbnQoICk7XG4gICAgICAgIH0gLy8qL1xuXG4gICAgICAgICQuYWpheCgge1xuICAgICAgICAgICAgdHlwZTogJ1BPU1QnLFxuICAgICAgICAgICAgZW5jdHlwZTogJ211bHRpcGFydC9mb3JtLWRhdGEnLFxuICAgICAgICAgICAgcHJvY2Vzc0RhdGE6IGZhbHNlLCAvLyBJbXBvcnRhbnQhXG4gICAgICAgICAgICBjb250ZW50VHlwZTogZmFsc2UsXG4gICAgICAgICAgICB1cmw6IHVybCxcbiAgICAgICAgICAgIGRhdGE6IGRhdGEsXG4gICAgICAgICAgICBjYWNoZTogZmFsc2UsXG4gICAgICAgICAgICB0aW1lb3V0OiA2MDAwMDBcbiAgICAgICAgLy99ICkuZG9uZSggZnVuY3Rpb24oIHJlc3BvbnNlICkge1xuICAgICAgICAvLyAgICBoYW5kbGVBamF4UmVzcG9uc2UoIHJlc3BvbnNlICk7XG4gICAgICAgIH0gKTtcblxuICAgIH1cblxuXG5cbiAgICAvKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKipcblxuICAgICAgICAgICAgUHVibGljIGl0ZW1zLlxuICAgICovXG5cblxuICAgIHZhciB0YWJMb2FkZXJJbml0ID0gZnVuY3Rpb24oICkge1xuXG4gICAgICAgICQoICdhW2RhdGEtdG9nZ2xlPVwidGFiXCJdJyApLm9uKCAnY2xpY2snLCBmdW5jdGlvbiggKSB7XG4gICAgICAgICAgICBfYWpheFRhYkNvbnRlbnRMb2FkZXIoICQoIHRoaXMgKSApO1xuICAgICAgICB9ICkub24oICdoaWRlLmJzLnRhYicsIGZ1bmN0aW9uKCBldmVudCApIHtcbiAgICAgICAgICAgIF9zYXZlQ3VycmVudFRhYkNvbnRlbnQoIGV2ZW50LnRhcmdldCApO1xuICAgICAgICB9ICk7O1xuXG4gICAgICAgICQoICcjdGFiLTEnICkuYWRkQ2xhc3MoICdhY3RpdmUnICk7XG4gICAgICAgICQoICcjdGFiLTEnICkuYWRkQ2xhc3MoICdzeWxsYWJ1cy10YWItYWN0aXZlJyApO1xuXG4gICAgICAgIF9hamF4VGFiQ29udGVudExvYWRlciggJCggJyN0YWItMScgKSApO1xuXG4gICAgfTtcblxuXG4gICAgdmFyIGhhbmRsZUFqYXhSZXNwb25zZSA9IGZ1bmN0aW9uKCByZXNwb25zZSApIHtcbiAgICAgICAgaWYocmVzcG9uc2UubWVzc2FnZXMgIT09IHVuZGVmaW5lZCkge1xuICAgICAgICAgICAgcmVzcG9uc2UubWVzc2FnZXMuZm9yRWFjaChmdW5jdGlvbihtZXNzYWdlKXtcbiAgICAgICAgICAgICAgICBpZiAobWVzc2FnZS50eXBlICE9PSB1bmRlZmluZWQgJiYgbWVzc2FnZS5tZXNzYWdlICE9PSB1bmRlZmluZWQpIHtcbiAgICAgICAgICAgICAgICAgICAgU0lMVG9vbHMuYWxlcnQoIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHR5cGU6IG1lc3NhZ2UudHlwZSxcbiAgICAgICAgICAgICAgICAgICAgICAgIHRleHQ6IG1lc3NhZ2UubWVzc2FnZVxuICAgICAgICAgICAgICAgICAgICB9ICk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICAgICAgLypcbiAgICAgICAgaWYocmVzcG9uc2UucmVuZGVycyAhPT0gdW5kZWZpbmVkKSB7XG4gICAgICAgICAgICByZXNwb25zZS5yZW5kZXJzLmZvckVhY2goZnVuY3Rpb24ocmVuZGVyKSB7XG4gICAgICAgICAgICAgICAgaWYgKHJlbmRlci5lbGVtZW50ICE9PSB1bmRlZmluZWQgJiYgcmVuZGVyLmNvbnRlbnQgIT09IHVuZGVmaW5lZCkge1xuICAgICAgICAgICAgICAgICAgICAkKHJlbmRlci5lbGVtZW50KS5odG1sKHJlbmRlci5jb250ZW50KTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfSAvLyovXG4gICAgfVxuXG5cbiAgICAvKlxuICAgICAgICBQdWJsaWMgcG9pbnRlcnMgdG8gZXhwb3NlZCBpdGVtcy5cbiAgICAqL1xuXG4gICAgcmV0dXJuIHtcbiAgICAgICAgdGFiTG9hZGVySW5pdDogdGFiTG9hZGVySW5pdCxcbiAgICAgICAgaGFuZGxlQWpheFJlc3BvbnNlOiBoYW5kbGVBamF4UmVzcG9uc2VcbiAgICB9O1xuXG5cblxufSApICggKTtcblxuXG5leHBvcnQgZGVmYXVsdCBTeWxsYWJ1cztcblxuIiwiLy8gZXh0cmFjdGVkIGJ5IG1pbmktY3NzLWV4dHJhY3QtcGx1Z2luIiwiLy8gZXh0cmFjdGVkIGJ5IG1pbmktY3NzLWV4dHJhY3QtcGx1Z2luIl0sInNvdXJjZVJvb3QiOiIifQ==