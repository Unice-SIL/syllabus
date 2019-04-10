(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["vendors~select2"],{

/***/ "./node_modules/select2/dist/js/select2.js":
/*!*************************************************!*\
  !*** ./node_modules/select2/dist/js/select2.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;var require;var require;/*!
 * Select2 4.0.5
 * https://select2.github.io
 *
 * Released under the MIT license
 * https://github.com/select2/select2/blob/master/LICENSE.md
 */
(function (factory) {
  if (true) {
    // AMD. Register as an anonymous module.
    !(__WEBPACK_AMD_DEFINE_ARRAY__ = [__webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
  } else {}
} (function (jQuery) {
  // This is needed so we can catch the AMD loader configuration and use it
  // The inner file should be wrapped (by `banner.start.js`) in a function that
  // returns the AMD loader references.
  var S2 =(function () {
  // Restore the Select2 AMD loader so it can be used
  // Needed mostly in the language files, where the loader is not inserted
  if (jQuery && jQuery.fn && jQuery.fn.select2 && jQuery.fn.select2.amd) {
    var S2 = jQuery.fn.select2.amd;
  }
var S2;(function () { if (!S2 || !S2.requirejs) {
if (!S2) { S2 = {}; } else { require = S2; }
/**
 * @license almond 0.3.3 Copyright jQuery Foundation and other contributors.
 * Released under MIT license, http://github.com/requirejs/almond/LICENSE
 */
//Going sloppy to avoid 'use strict' string cost, but strict practices should
//be followed.
/*global setTimeout: false */

var requirejs, require, define;
(function (undef) {
    var main, req, makeMap, handlers,
        defined = {},
        waiting = {},
        config = {},
        defining = {},
        hasOwn = Object.prototype.hasOwnProperty,
        aps = [].slice,
        jsSuffixRegExp = /\.js$/;

    function hasProp(obj, prop) {
        return hasOwn.call(obj, prop);
    }

    /**
     * Given a relative module name, like ./something, normalize it to
     * a real name that can be mapped to a path.
     * @param {String} name the relative name
     * @param {String} baseName a real name that the name arg is relative
     * to.
     * @returns {String} normalized name
     */
    function normalize(name, baseName) {
        var nameParts, nameSegment, mapValue, foundMap, lastIndex,
            foundI, foundStarMap, starI, i, j, part, normalizedBaseParts,
            baseParts = baseName && baseName.split("/"),
            map = config.map,
            starMap = (map && map['*']) || {};

        //Adjust any relative paths.
        if (name) {
            name = name.split('/');
            lastIndex = name.length - 1;

            // If wanting node ID compatibility, strip .js from end
            // of IDs. Have to do this here, and not in nameToUrl
            // because node allows either .js or non .js to map
            // to same file.
            if (config.nodeIdCompat && jsSuffixRegExp.test(name[lastIndex])) {
                name[lastIndex] = name[lastIndex].replace(jsSuffixRegExp, '');
            }

            // Starts with a '.' so need the baseName
            if (name[0].charAt(0) === '.' && baseParts) {
                //Convert baseName to array, and lop off the last part,
                //so that . matches that 'directory' and not name of the baseName's
                //module. For instance, baseName of 'one/two/three', maps to
                //'one/two/three.js', but we want the directory, 'one/two' for
                //this normalization.
                normalizedBaseParts = baseParts.slice(0, baseParts.length - 1);
                name = normalizedBaseParts.concat(name);
            }

            //start trimDots
            for (i = 0; i < name.length; i++) {
                part = name[i];
                if (part === '.') {
                    name.splice(i, 1);
                    i -= 1;
                } else if (part === '..') {
                    // If at the start, or previous value is still ..,
                    // keep them so that when converted to a path it may
                    // still work when converted to a path, even though
                    // as an ID it is less than ideal. In larger point
                    // releases, may be better to just kick out an error.
                    if (i === 0 || (i === 1 && name[2] === '..') || name[i - 1] === '..') {
                        continue;
                    } else if (i > 0) {
                        name.splice(i - 1, 2);
                        i -= 2;
                    }
                }
            }
            //end trimDots

            name = name.join('/');
        }

        //Apply map config if available.
        if ((baseParts || starMap) && map) {
            nameParts = name.split('/');

            for (i = nameParts.length; i > 0; i -= 1) {
                nameSegment = nameParts.slice(0, i).join("/");

                if (baseParts) {
                    //Find the longest baseName segment match in the config.
                    //So, do joins on the biggest to smallest lengths of baseParts.
                    for (j = baseParts.length; j > 0; j -= 1) {
                        mapValue = map[baseParts.slice(0, j).join('/')];

                        //baseName segment has  config, find if it has one for
                        //this name.
                        if (mapValue) {
                            mapValue = mapValue[nameSegment];
                            if (mapValue) {
                                //Match, update name to the new value.
                                foundMap = mapValue;
                                foundI = i;
                                break;
                            }
                        }
                    }
                }

                if (foundMap) {
                    break;
                }

                //Check for a star map match, but just hold on to it,
                //if there is a shorter segment match later in a matching
                //config, then favor over this star map.
                if (!foundStarMap && starMap && starMap[nameSegment]) {
                    foundStarMap = starMap[nameSegment];
                    starI = i;
                }
            }

            if (!foundMap && foundStarMap) {
                foundMap = foundStarMap;
                foundI = starI;
            }

            if (foundMap) {
                nameParts.splice(0, foundI, foundMap);
                name = nameParts.join('/');
            }
        }

        return name;
    }

    function makeRequire(relName, forceSync) {
        return function () {
            //A version of a require function that passes a moduleName
            //value for items that may need to
            //look up paths relative to the moduleName
            var args = aps.call(arguments, 0);

            //If first arg is not require('string'), and there is only
            //one arg, it is the array form without a callback. Insert
            //a null so that the following concat is correct.
            if (typeof args[0] !== 'string' && args.length === 1) {
                args.push(null);
            }
            return req.apply(undef, args.concat([relName, forceSync]));
        };
    }

    function makeNormalize(relName) {
        return function (name) {
            return normalize(name, relName);
        };
    }

    function makeLoad(depName) {
        return function (value) {
            defined[depName] = value;
        };
    }

    function callDep(name) {
        if (hasProp(waiting, name)) {
            var args = waiting[name];
            delete waiting[name];
            defining[name] = true;
            main.apply(undef, args);
        }

        if (!hasProp(defined, name) && !hasProp(defining, name)) {
            throw new Error('No ' + name);
        }
        return defined[name];
    }

    //Turns a plugin!resource to [plugin, resource]
    //with the plugin being undefined if the name
    //did not have a plugin prefix.
    function splitPrefix(name) {
        var prefix,
            index = name ? name.indexOf('!') : -1;
        if (index > -1) {
            prefix = name.substring(0, index);
            name = name.substring(index + 1, name.length);
        }
        return [prefix, name];
    }

    //Creates a parts array for a relName where first part is plugin ID,
    //second part is resource ID. Assumes relName has already been normalized.
    function makeRelParts(relName) {
        return relName ? splitPrefix(relName) : [];
    }

    /**
     * Makes a name map, normalizing the name, and using a plugin
     * for normalization if necessary. Grabs a ref to plugin
     * too, as an optimization.
     */
    makeMap = function (name, relParts) {
        var plugin,
            parts = splitPrefix(name),
            prefix = parts[0],
            relResourceName = relParts[1];

        name = parts[1];

        if (prefix) {
            prefix = normalize(prefix, relResourceName);
            plugin = callDep(prefix);
        }

        //Normalize according
        if (prefix) {
            if (plugin && plugin.normalize) {
                name = plugin.normalize(name, makeNormalize(relResourceName));
            } else {
                name = normalize(name, relResourceName);
            }
        } else {
            name = normalize(name, relResourceName);
            parts = splitPrefix(name);
            prefix = parts[0];
            name = parts[1];
            if (prefix) {
                plugin = callDep(prefix);
            }
        }

        //Using ridiculous property names for space reasons
        return {
            f: prefix ? prefix + '!' + name : name, //fullName
            n: name,
            pr: prefix,
            p: plugin
        };
    };

    function makeConfig(name) {
        return function () {
            return (config && config.config && config.config[name]) || {};
        };
    }

    handlers = {
        require: function (name) {
            return makeRequire(name);
        },
        exports: function (name) {
            var e = defined[name];
            if (typeof e !== 'undefined') {
                return e;
            } else {
                return (defined[name] = {});
            }
        },
        module: function (name) {
            return {
                id: name,
                uri: '',
                exports: defined[name],
                config: makeConfig(name)
            };
        }
    };

    main = function (name, deps, callback, relName) {
        var cjsModule, depName, ret, map, i, relParts,
            args = [],
            callbackType = typeof callback,
            usingExports;

        //Use name if no relName
        relName = relName || name;
        relParts = makeRelParts(relName);

        //Call the callback to define the module, if necessary.
        if (callbackType === 'undefined' || callbackType === 'function') {
            //Pull out the defined dependencies and pass the ordered
            //values to the callback.
            //Default to [require, exports, module] if no deps
            deps = !deps.length && callback.length ? ['require', 'exports', 'module'] : deps;
            for (i = 0; i < deps.length; i += 1) {
                map = makeMap(deps[i], relParts);
                depName = map.f;

                //Fast path CommonJS standard dependencies.
                if (depName === "require") {
                    args[i] = handlers.require(name);
                } else if (depName === "exports") {
                    //CommonJS module spec 1.1
                    args[i] = handlers.exports(name);
                    usingExports = true;
                } else if (depName === "module") {
                    //CommonJS module spec 1.1
                    cjsModule = args[i] = handlers.module(name);
                } else if (hasProp(defined, depName) ||
                           hasProp(waiting, depName) ||
                           hasProp(defining, depName)) {
                    args[i] = callDep(depName);
                } else if (map.p) {
                    map.p.load(map.n, makeRequire(relName, true), makeLoad(depName), {});
                    args[i] = defined[depName];
                } else {
                    throw new Error(name + ' missing ' + depName);
                }
            }

            ret = callback ? callback.apply(defined[name], args) : undefined;

            if (name) {
                //If setting exports via "module" is in play,
                //favor that over return value and exports. After that,
                //favor a non-undefined return value over exports use.
                if (cjsModule && cjsModule.exports !== undef &&
                        cjsModule.exports !== defined[name]) {
                    defined[name] = cjsModule.exports;
                } else if (ret !== undef || !usingExports) {
                    //Use the return value from the function.
                    defined[name] = ret;
                }
            }
        } else if (name) {
            //May just be an object definition for the module. Only
            //worry about defining if have a module name.
            defined[name] = callback;
        }
    };

    requirejs = require = req = function (deps, callback, relName, forceSync, alt) {
        if (typeof deps === "string") {
            if (handlers[deps]) {
                //callback in this case is really relName
                return handlers[deps](callback);
            }
            //Just return the module wanted. In this scenario, the
            //deps arg is the module name, and second arg (if passed)
            //is just the relName.
            //Normalize module name, if it contains . or ..
            return callDep(makeMap(deps, makeRelParts(callback)).f);
        } else if (!deps.splice) {
            //deps is a config object, not an array.
            config = deps;
            if (config.deps) {
                req(config.deps, config.callback);
            }
            if (!callback) {
                return;
            }

            if (callback.splice) {
                //callback is an array, which means it is a dependency list.
                //Adjust args if there are dependencies
                deps = callback;
                callback = relName;
                relName = null;
            } else {
                deps = undef;
            }
        }

        //Support require(['a'])
        callback = callback || function () {};

        //If relName is a function, it is an errback handler,
        //so remove it.
        if (typeof relName === 'function') {
            relName = forceSync;
            forceSync = alt;
        }

        //Simulate async callback;
        if (forceSync) {
            main(undef, deps, callback, relName);
        } else {
            //Using a non-zero value because of concern for what old browsers
            //do, and latest browsers "upgrade" to 4 if lower value is used:
            //http://www.whatwg.org/specs/web-apps/current-work/multipage/timers.html#dom-windowtimers-settimeout:
            //If want a value immediately, use require('id') instead -- something
            //that works in almond on the global level, but not guaranteed and
            //unlikely to work in other AMD implementations.
            setTimeout(function () {
                main(undef, deps, callback, relName);
            }, 4);
        }

        return req;
    };

    /**
     * Just drops the config on the floor, but returns req in case
     * the config return value is used.
     */
    req.config = function (cfg) {
        return req(cfg);
    };

    /**
     * Expose module registry for debugging and tooling
     */
    requirejs._defined = defined;

    define = function (name, deps, callback) {
        if (typeof name !== 'string') {
            throw new Error('See almond README: incorrect module build, no module name');
        }

        //This module may not have dependencies
        if (!deps.splice) {
            //deps is not an array, so probably means
            //an object literal or factory function for
            //the value. Adjust args.
            callback = deps;
            deps = [];
        }

        if (!hasProp(defined, name) && !hasProp(waiting, name)) {
            waiting[name] = [name, deps, callback];
        }
    };

    define.amd = {
        jQuery: true
    };
}());

S2.requirejs = requirejs;S2.require = require;S2.define = define;
}
}());
S2.define("almond", function(){});

/* global jQuery:false, $:false */
S2.define('jquery',[],function () {
  var _$ = jQuery || $;

  if (_$ == null && console && console.error) {
    console.error(
      'Select2: An instance of jQuery or a jQuery-compatible library was not ' +
      'found. Make sure that you are including jQuery before Select2 on your ' +
      'web page.'
    );
  }

  return _$;
});

S2.define('select2/utils',[
  'jquery'
], function ($) {
  var Utils = {};

  Utils.Extend = function (ChildClass, SuperClass) {
    var __hasProp = {}.hasOwnProperty;

    function BaseConstructor () {
      this.constructor = ChildClass;
    }

    for (var key in SuperClass) {
      if (__hasProp.call(SuperClass, key)) {
        ChildClass[key] = SuperClass[key];
      }
    }

    BaseConstructor.prototype = SuperClass.prototype;
    ChildClass.prototype = new BaseConstructor();
    ChildClass.__super__ = SuperClass.prototype;

    return ChildClass;
  };

  function getMethods (theClass) {
    var proto = theClass.prototype;

    var methods = [];

    for (var methodName in proto) {
      var m = proto[methodName];

      if (typeof m !== 'function') {
        continue;
      }

      if (methodName === 'constructor') {
        continue;
      }

      methods.push(methodName);
    }

    return methods;
  }

  Utils.Decorate = function (SuperClass, DecoratorClass) {
    var decoratedMethods = getMethods(DecoratorClass);
    var superMethods = getMethods(SuperClass);

    function DecoratedClass () {
      var unshift = Array.prototype.unshift;

      var argCount = DecoratorClass.prototype.constructor.length;

      var calledConstructor = SuperClass.prototype.constructor;

      if (argCount > 0) {
        unshift.call(arguments, SuperClass.prototype.constructor);

        calledConstructor = DecoratorClass.prototype.constructor;
      }

      calledConstructor.apply(this, arguments);
    }

    DecoratorClass.displayName = SuperClass.displayName;

    function ctr () {
      this.constructor = DecoratedClass;
    }

    DecoratedClass.prototype = new ctr();

    for (var m = 0; m < superMethods.length; m++) {
        var superMethod = superMethods[m];

        DecoratedClass.prototype[superMethod] =
          SuperClass.prototype[superMethod];
    }

    var calledMethod = function (methodName) {
      // Stub out the original method if it's not decorating an actual method
      var originalMethod = function () {};

      if (methodName in DecoratedClass.prototype) {
        originalMethod = DecoratedClass.prototype[methodName];
      }

      var decoratedMethod = DecoratorClass.prototype[methodName];

      return function () {
        var unshift = Array.prototype.unshift;

        unshift.call(arguments, originalMethod);

        return decoratedMethod.apply(this, arguments);
      };
    };

    for (var d = 0; d < decoratedMethods.length; d++) {
      var decoratedMethod = decoratedMethods[d];

      DecoratedClass.prototype[decoratedMethod] = calledMethod(decoratedMethod);
    }

    return DecoratedClass;
  };

  var Observable = function () {
    this.listeners = {};
  };

  Observable.prototype.on = function (event, callback) {
    this.listeners = this.listeners || {};

    if (event in this.listeners) {
      this.listeners[event].push(callback);
    } else {
      this.listeners[event] = [callback];
    }
  };

  Observable.prototype.trigger = function (event) {
    var slice = Array.prototype.slice;
    var params = slice.call(arguments, 1);

    this.listeners = this.listeners || {};

    // Params should always come in as an array
    if (params == null) {
      params = [];
    }

    // If there are no arguments to the event, use a temporary object
    if (params.length === 0) {
      params.push({});
    }

    // Set the `_type` of the first object to the event
    params[0]._type = event;

    if (event in this.listeners) {
      this.invoke(this.listeners[event], slice.call(arguments, 1));
    }

    if ('*' in this.listeners) {
      this.invoke(this.listeners['*'], arguments);
    }
  };

  Observable.prototype.invoke = function (listeners, params) {
    for (var i = 0, len = listeners.length; i < len; i++) {
      listeners[i].apply(this, params);
    }
  };

  Utils.Observable = Observable;

  Utils.generateChars = function (length) {
    var chars = '';

    for (var i = 0; i < length; i++) {
      var randomChar = Math.floor(Math.random() * 36);
      chars += randomChar.toString(36);
    }

    return chars;
  };

  Utils.bind = function (func, context) {
    return function () {
      func.apply(context, arguments);
    };
  };

  Utils._convertData = function (data) {
    for (var originalKey in data) {
      var keys = originalKey.split('-');

      var dataLevel = data;

      if (keys.length === 1) {
        continue;
      }

      for (var k = 0; k < keys.length; k++) {
        var key = keys[k];

        // Lowercase the first letter
        // By default, dash-separated becomes camelCase
        key = key.substring(0, 1).toLowerCase() + key.substring(1);

        if (!(key in dataLevel)) {
          dataLevel[key] = {};
        }

        if (k == keys.length - 1) {
          dataLevel[key] = data[originalKey];
        }

        dataLevel = dataLevel[key];
      }

      delete data[originalKey];
    }

    return data;
  };

  Utils.hasScroll = function (index, el) {
    // Adapted from the function created by @ShadowScripter
    // and adapted by @BillBarry on the Stack Exchange Code Review website.
    // The original code can be found at
    // http://codereview.stackexchange.com/q/13338
    // and was designed to be used with the Sizzle selector engine.

    var $el = $(el);
    var overflowX = el.style.overflowX;
    var overflowY = el.style.overflowY;

    //Check both x and y declarations
    if (overflowX === overflowY &&
        (overflowY === 'hidden' || overflowY === 'visible')) {
      return false;
    }

    if (overflowX === 'scroll' || overflowY === 'scroll') {
      return true;
    }

    return ($el.innerHeight() < el.scrollHeight ||
      $el.innerWidth() < el.scrollWidth);
  };

  Utils.escapeMarkup = function (markup) {
    var replaceMap = {
      '\\': '&#92;',
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      '\'': '&#39;',
      '/': '&#47;'
    };

    // Do not try to escape the markup if it's not a string
    if (typeof markup !== 'string') {
      return markup;
    }

    return String(markup).replace(/[&<>"'\/\\]/g, function (match) {
      return replaceMap[match];
    });
  };

  // Append an array of jQuery nodes to a given element.
  Utils.appendMany = function ($element, $nodes) {
    // jQuery 1.7.x does not support $.fn.append() with an array
    // Fall back to a jQuery object collection using $.fn.add()
    if ($.fn.jquery.substr(0, 3) === '1.7') {
      var $jqNodes = $();

      $.map($nodes, function (node) {
        $jqNodes = $jqNodes.add(node);
      });

      $nodes = $jqNodes;
    }

    $element.append($nodes);
  };

  return Utils;
});

S2.define('select2/results',[
  'jquery',
  './utils'
], function ($, Utils) {
  function Results ($element, options, dataAdapter) {
    this.$element = $element;
    this.data = dataAdapter;
    this.options = options;

    Results.__super__.constructor.call(this);
  }

  Utils.Extend(Results, Utils.Observable);

  Results.prototype.render = function () {
    var $results = $(
      '<ul class="select2-results__options" role="tree"></ul>'
    );

    if (this.options.get('multiple')) {
      $results.attr('aria-multiselectable', 'true');
    }

    this.$results = $results;

    return $results;
  };

  Results.prototype.clear = function () {
    this.$results.empty();
  };

  Results.prototype.displayMessage = function (params) {
    var escapeMarkup = this.options.get('escapeMarkup');

    this.clear();
    this.hideLoading();

    var $message = $(
      '<li role="treeitem" aria-live="assertive"' +
      ' class="select2-results__option"></li>'
    );

    var message = this.options.get('translations').get(params.message);

    $message.append(
      escapeMarkup(
        message(params.args)
      )
    );

    $message[0].className += ' select2-results__message';

    this.$results.append($message);
  };

  Results.prototype.hideMessages = function () {
    this.$results.find('.select2-results__message').remove();
  };

  Results.prototype.append = function (data) {
    this.hideLoading();

    var $options = [];

    if (data.results == null || data.results.length === 0) {
      if (this.$results.children().length === 0) {
        this.trigger('results:message', {
          message: 'noResults'
        });
      }

      return;
    }

    data.results = this.sort(data.results);

    for (var d = 0; d < data.results.length; d++) {
      var item = data.results[d];

      var $option = this.option(item);

      $options.push($option);
    }

    this.$results.append($options);
  };

  Results.prototype.position = function ($results, $dropdown) {
    var $resultsContainer = $dropdown.find('.select2-results');
    $resultsContainer.append($results);
  };

  Results.prototype.sort = function (data) {
    var sorter = this.options.get('sorter');

    return sorter(data);
  };

  Results.prototype.highlightFirstItem = function () {
    var $options = this.$results
      .find('.select2-results__option[aria-selected]');

    var $selected = $options.filter('[aria-selected=true]');

    // Check if there are any selected options
    if ($selected.length > 0) {
      // If there are selected options, highlight the first
      $selected.first().trigger('mouseenter');
    } else {
      // If there are no selected options, highlight the first option
      // in the dropdown
      $options.first().trigger('mouseenter');
    }

    this.ensureHighlightVisible();
  };

  Results.prototype.setClasses = function () {
    var self = this;

    this.data.current(function (selected) {
      var selectedIds = $.map(selected, function (s) {
        return s.id.toString();
      });

      var $options = self.$results
        .find('.select2-results__option[aria-selected]');

      $options.each(function () {
        var $option = $(this);

        var item = $.data(this, 'data');

        // id needs to be converted to a string when comparing
        var id = '' + item.id;

        if ((item.element != null && item.element.selected) ||
            (item.element == null && $.inArray(id, selectedIds) > -1)) {
          $option.attr('aria-selected', 'true');
        } else {
          $option.attr('aria-selected', 'false');
        }
      });

    });
  };

  Results.prototype.showLoading = function (params) {
    this.hideLoading();

    var loadingMore = this.options.get('translations').get('searching');

    var loading = {
      disabled: true,
      loading: true,
      text: loadingMore(params)
    };
    var $loading = this.option(loading);
    $loading.className += ' loading-results';

    this.$results.prepend($loading);
  };

  Results.prototype.hideLoading = function () {
    this.$results.find('.loading-results').remove();
  };

  Results.prototype.option = function (data) {
    var option = document.createElement('li');
    option.className = 'select2-results__option';

    var attrs = {
      'role': 'treeitem',
      'aria-selected': 'false'
    };

    if (data.disabled) {
      delete attrs['aria-selected'];
      attrs['aria-disabled'] = 'true';
    }

    if (data.id == null) {
      delete attrs['aria-selected'];
    }

    if (data._resultId != null) {
      option.id = data._resultId;
    }

    if (data.title) {
      option.title = data.title;
    }

    if (data.children) {
      attrs.role = 'group';
      attrs['aria-label'] = data.text;
      delete attrs['aria-selected'];
    }

    for (var attr in attrs) {
      var val = attrs[attr];

      option.setAttribute(attr, val);
    }

    if (data.children) {
      var $option = $(option);

      var label = document.createElement('strong');
      label.className = 'select2-results__group';

      var $label = $(label);
      this.template(data, label);

      var $children = [];

      for (var c = 0; c < data.children.length; c++) {
        var child = data.children[c];

        var $child = this.option(child);

        $children.push($child);
      }

      var $childrenContainer = $('<ul></ul>', {
        'class': 'select2-results__options select2-results__options--nested'
      });

      $childrenContainer.append($children);

      $option.append(label);
      $option.append($childrenContainer);
    } else {
      this.template(data, option);
    }

    $.data(option, 'data', data);

    return option;
  };

  Results.prototype.bind = function (container, $container) {
    var self = this;

    var id = container.id + '-results';

    this.$results.attr('id', id);

    container.on('results:all', function (params) {
      self.clear();
      self.append(params.data);

      if (container.isOpen()) {
        self.setClasses();
        self.highlightFirstItem();
      }
    });

    container.on('results:append', function (params) {
      self.append(params.data);

      if (container.isOpen()) {
        self.setClasses();
      }
    });

    container.on('query', function (params) {
      self.hideMessages();
      self.showLoading(params);
    });

    container.on('select', function () {
      if (!container.isOpen()) {
        return;
      }

      self.setClasses();
      self.highlightFirstItem();
    });

    container.on('unselect', function () {
      if (!container.isOpen()) {
        return;
      }

      self.setClasses();
      self.highlightFirstItem();
    });

    container.on('open', function () {
      // When the dropdown is open, aria-expended="true"
      self.$results.attr('aria-expanded', 'true');
      self.$results.attr('aria-hidden', 'false');

      self.setClasses();
      self.ensureHighlightVisible();
    });

    container.on('close', function () {
      // When the dropdown is closed, aria-expended="false"
      self.$results.attr('aria-expanded', 'false');
      self.$results.attr('aria-hidden', 'true');
      self.$results.removeAttr('aria-activedescendant');
    });

    container.on('results:toggle', function () {
      var $highlighted = self.getHighlightedResults();

      if ($highlighted.length === 0) {
        return;
      }

      $highlighted.trigger('mouseup');
    });

    container.on('results:select', function () {
      var $highlighted = self.getHighlightedResults();

      if ($highlighted.length === 0) {
        return;
      }

      var data = $highlighted.data('data');

      if ($highlighted.attr('aria-selected') == 'true') {
        self.trigger('close', {});
      } else {
        self.trigger('select', {
          data: data
        });
      }
    });

    container.on('results:previous', function () {
      var $highlighted = self.getHighlightedResults();

      var $options = self.$results.find('[aria-selected]');

      var currentIndex = $options.index($highlighted);

      // If we are already at te top, don't move further
      if (currentIndex === 0) {
        return;
      }

      var nextIndex = currentIndex - 1;

      // If none are highlighted, highlight the first
      if ($highlighted.length === 0) {
        nextIndex = 0;
      }

      var $next = $options.eq(nextIndex);

      $next.trigger('mouseenter');

      var currentOffset = self.$results.offset().top;
      var nextTop = $next.offset().top;
      var nextOffset = self.$results.scrollTop() + (nextTop - currentOffset);

      if (nextIndex === 0) {
        self.$results.scrollTop(0);
      } else if (nextTop - currentOffset < 0) {
        self.$results.scrollTop(nextOffset);
      }
    });

    container.on('results:next', function () {
      var $highlighted = self.getHighlightedResults();

      var $options = self.$results.find('[aria-selected]');

      var currentIndex = $options.index($highlighted);

      var nextIndex = currentIndex + 1;

      // If we are at the last option, stay there
      if (nextIndex >= $options.length) {
        return;
      }

      var $next = $options.eq(nextIndex);

      $next.trigger('mouseenter');

      var currentOffset = self.$results.offset().top +
        self.$results.outerHeight(false);
      var nextBottom = $next.offset().top + $next.outerHeight(false);
      var nextOffset = self.$results.scrollTop() + nextBottom - currentOffset;

      if (nextIndex === 0) {
        self.$results.scrollTop(0);
      } else if (nextBottom > currentOffset) {
        self.$results.scrollTop(nextOffset);
      }
    });

    container.on('results:focus', function (params) {
      params.element.addClass('select2-results__option--highlighted');
    });

    container.on('results:message', function (params) {
      self.displayMessage(params);
    });

    if ($.fn.mousewheel) {
      this.$results.on('mousewheel', function (e) {
        var top = self.$results.scrollTop();

        var bottom = self.$results.get(0).scrollHeight - top + e.deltaY;

        var isAtTop = e.deltaY > 0 && top - e.deltaY <= 0;
        var isAtBottom = e.deltaY < 0 && bottom <= self.$results.height();

        if (isAtTop) {
          self.$results.scrollTop(0);

          e.preventDefault();
          e.stopPropagation();
        } else if (isAtBottom) {
          self.$results.scrollTop(
            self.$results.get(0).scrollHeight - self.$results.height()
          );

          e.preventDefault();
          e.stopPropagation();
        }
      });
    }

    this.$results.on('mouseup', '.select2-results__option[aria-selected]',
      function (evt) {
      var $this = $(this);

      var data = $this.data('data');

      if ($this.attr('aria-selected') === 'true') {
        if (self.options.get('multiple')) {
          self.trigger('unselect', {
            originalEvent: evt,
            data: data
          });
        } else {
          self.trigger('close', {});
        }

        return;
      }

      self.trigger('select', {
        originalEvent: evt,
        data: data
      });
    });

    this.$results.on('mouseenter', '.select2-results__option[aria-selected]',
      function (evt) {
      var data = $(this).data('data');

      self.getHighlightedResults()
          .removeClass('select2-results__option--highlighted');

      self.trigger('results:focus', {
        data: data,
        element: $(this)
      });
    });
  };

  Results.prototype.getHighlightedResults = function () {
    var $highlighted = this.$results
    .find('.select2-results__option--highlighted');

    return $highlighted;
  };

  Results.prototype.destroy = function () {
    this.$results.remove();
  };

  Results.prototype.ensureHighlightVisible = function () {
    var $highlighted = this.getHighlightedResults();

    if ($highlighted.length === 0) {
      return;
    }

    var $options = this.$results.find('[aria-selected]');

    var currentIndex = $options.index($highlighted);

    var currentOffset = this.$results.offset().top;
    var nextTop = $highlighted.offset().top;
    var nextOffset = this.$results.scrollTop() + (nextTop - currentOffset);

    var offsetDelta = nextTop - currentOffset;
    nextOffset -= $highlighted.outerHeight(false) * 2;

    if (currentIndex <= 2) {
      this.$results.scrollTop(0);
    } else if (offsetDelta > this.$results.outerHeight() || offsetDelta < 0) {
      this.$results.scrollTop(nextOffset);
    }
  };

  Results.prototype.template = function (result, container) {
    var template = this.options.get('templateResult');
    var escapeMarkup = this.options.get('escapeMarkup');

    var content = template(result, container);

    if (content == null) {
      container.style.display = 'none';
    } else if (typeof content === 'string') {
      container.innerHTML = escapeMarkup(content);
    } else {
      $(container).append(content);
    }
  };

  return Results;
});

S2.define('select2/keys',[

], function () {
  var KEYS = {
    BACKSPACE: 8,
    TAB: 9,
    ENTER: 13,
    SHIFT: 16,
    CTRL: 17,
    ALT: 18,
    ESC: 27,
    SPACE: 32,
    PAGE_UP: 33,
    PAGE_DOWN: 34,
    END: 35,
    HOME: 36,
    LEFT: 37,
    UP: 38,
    RIGHT: 39,
    DOWN: 40,
    DELETE: 46
  };

  return KEYS;
});

S2.define('select2/selection/base',[
  'jquery',
  '../utils',
  '../keys'
], function ($, Utils, KEYS) {
  function BaseSelection ($element, options) {
    this.$element = $element;
    this.options = options;

    BaseSelection.__super__.constructor.call(this);
  }

  Utils.Extend(BaseSelection, Utils.Observable);

  BaseSelection.prototype.render = function () {
    var $selection = $(
      '<span class="select2-selection" role="combobox" ' +
      ' aria-haspopup="true" aria-expanded="false">' +
      '</span>'
    );

    this._tabindex = 0;

    if (this.$element.data('old-tabindex') != null) {
      this._tabindex = this.$element.data('old-tabindex');
    } else if (this.$element.attr('tabindex') != null) {
      this._tabindex = this.$element.attr('tabindex');
    }

    $selection.attr('title', this.$element.attr('title'));
    $selection.attr('tabindex', this._tabindex);

    this.$selection = $selection;

    return $selection;
  };

  BaseSelection.prototype.bind = function (container, $container) {
    var self = this;

    var id = container.id + '-container';
    var resultsId = container.id + '-results';

    this.container = container;

    this.$selection.on('focus', function (evt) {
      self.trigger('focus', evt);
    });

    this.$selection.on('blur', function (evt) {
      self._handleBlur(evt);
    });

    this.$selection.on('keydown', function (evt) {
      self.trigger('keypress', evt);

      if (evt.which === KEYS.SPACE) {
        evt.preventDefault();
      }
    });

    container.on('results:focus', function (params) {
      self.$selection.attr('aria-activedescendant', params.data._resultId);
    });

    container.on('selection:update', function (params) {
      self.update(params.data);
    });

    container.on('open', function () {
      // When the dropdown is open, aria-expanded="true"
      self.$selection.attr('aria-expanded', 'true');
      self.$selection.attr('aria-owns', resultsId);

      self._attachCloseHandler(container);
    });

    container.on('close', function () {
      // When the dropdown is closed, aria-expanded="false"
      self.$selection.attr('aria-expanded', 'false');
      self.$selection.removeAttr('aria-activedescendant');
      self.$selection.removeAttr('aria-owns');

      self.$selection.focus();

      self._detachCloseHandler(container);
    });

    container.on('enable', function () {
      self.$selection.attr('tabindex', self._tabindex);
    });

    container.on('disable', function () {
      self.$selection.attr('tabindex', '-1');
    });
  };

  BaseSelection.prototype._handleBlur = function (evt) {
    var self = this;

    // This needs to be delayed as the active element is the body when the tab
    // key is pressed, possibly along with others.
    window.setTimeout(function () {
      // Don't trigger `blur` if the focus is still in the selection
      if (
        (document.activeElement == self.$selection[0]) ||
        ($.contains(self.$selection[0], document.activeElement))
      ) {
        return;
      }

      self.trigger('blur', evt);
    }, 1);
  };

  BaseSelection.prototype._attachCloseHandler = function (container) {
    var self = this;

    $(document.body).on('mousedown.select2.' + container.id, function (e) {
      var $target = $(e.target);

      var $select = $target.closest('.select2');

      var $all = $('.select2.select2-container--open');

      $all.each(function () {
        var $this = $(this);

        if (this == $select[0]) {
          return;
        }

        var $element = $this.data('element');

        $element.select2('close');
      });
    });
  };

  BaseSelection.prototype._detachCloseHandler = function (container) {
    $(document.body).off('mousedown.select2.' + container.id);
  };

  BaseSelection.prototype.position = function ($selection, $container) {
    var $selectionContainer = $container.find('.selection');
    $selectionContainer.append($selection);
  };

  BaseSelection.prototype.destroy = function () {
    this._detachCloseHandler(this.container);
  };

  BaseSelection.prototype.update = function (data) {
    throw new Error('The `update` method must be defined in child classes.');
  };

  return BaseSelection;
});

S2.define('select2/selection/single',[
  'jquery',
  './base',
  '../utils',
  '../keys'
], function ($, BaseSelection, Utils, KEYS) {
  function SingleSelection () {
    SingleSelection.__super__.constructor.apply(this, arguments);
  }

  Utils.Extend(SingleSelection, BaseSelection);

  SingleSelection.prototype.render = function () {
    var $selection = SingleSelection.__super__.render.call(this);

    $selection.addClass('select2-selection--single');

    $selection.html(
      '<span class="select2-selection__rendered"></span>' +
      '<span class="select2-selection__arrow" role="presentation">' +
        '<b role="presentation"></b>' +
      '</span>'
    );

    return $selection;
  };

  SingleSelection.prototype.bind = function (container, $container) {
    var self = this;

    SingleSelection.__super__.bind.apply(this, arguments);

    var id = container.id + '-container';

    this.$selection.find('.select2-selection__rendered').attr('id', id);
    this.$selection.attr('aria-labelledby', id);

    this.$selection.on('mousedown', function (evt) {
      // Only respond to left clicks
      if (evt.which !== 1) {
        return;
      }

      self.trigger('toggle', {
        originalEvent: evt
      });
    });

    this.$selection.on('focus', function (evt) {
      // User focuses on the container
    });

    this.$selection.on('blur', function (evt) {
      // User exits the container
    });

    container.on('focus', function (evt) {
      if (!container.isOpen()) {
        self.$selection.focus();
      }
    });

    container.on('selection:update', function (params) {
      self.update(params.data);
    });
  };

  SingleSelection.prototype.clear = function () {
    this.$selection.find('.select2-selection__rendered').empty();
  };

  SingleSelection.prototype.display = function (data, container) {
    var template = this.options.get('templateSelection');
    var escapeMarkup = this.options.get('escapeMarkup');

    return escapeMarkup(template(data, container));
  };

  SingleSelection.prototype.selectionContainer = function () {
    return $('<span></span>');
  };

  SingleSelection.prototype.update = function (data) {
    if (data.length === 0) {
      this.clear();
      return;
    }

    var selection = data[0];

    var $rendered = this.$selection.find('.select2-selection__rendered');
    var formatted = this.display(selection, $rendered);

    $rendered.empty().append(formatted);
    $rendered.prop('title', selection.title || selection.text);
  };

  return SingleSelection;
});

S2.define('select2/selection/multiple',[
  'jquery',
  './base',
  '../utils'
], function ($, BaseSelection, Utils) {
  function MultipleSelection ($element, options) {
    MultipleSelection.__super__.constructor.apply(this, arguments);
  }

  Utils.Extend(MultipleSelection, BaseSelection);

  MultipleSelection.prototype.render = function () {
    var $selection = MultipleSelection.__super__.render.call(this);

    $selection.addClass('select2-selection--multiple');

    $selection.html(
      '<ul class="select2-selection__rendered"></ul>'
    );

    return $selection;
  };

  MultipleSelection.prototype.bind = function (container, $container) {
    var self = this;

    MultipleSelection.__super__.bind.apply(this, arguments);

    this.$selection.on('click', function (evt) {
      self.trigger('toggle', {
        originalEvent: evt
      });
    });

    this.$selection.on(
      'click',
      '.select2-selection__choice__remove',
      function (evt) {
        // Ignore the event if it is disabled
        if (self.options.get('disabled')) {
          return;
        }

        var $remove = $(this);
        var $selection = $remove.parent();

        var data = $selection.data('data');

        self.trigger('unselect', {
          originalEvent: evt,
          data: data
        });
      }
    );
  };

  MultipleSelection.prototype.clear = function () {
    this.$selection.find('.select2-selection__rendered').empty();
  };

  MultipleSelection.prototype.display = function (data, container) {
    var template = this.options.get('templateSelection');
    var escapeMarkup = this.options.get('escapeMarkup');

    return escapeMarkup(template(data, container));
  };

  MultipleSelection.prototype.selectionContainer = function () {
    var $container = $(
      '<li class="select2-selection__choice">' +
        '<span class="select2-selection__choice__remove" role="presentation">' +
          '&times;' +
        '</span>' +
      '</li>'
    );

    return $container;
  };

  MultipleSelection.prototype.update = function (data) {
    this.clear();

    if (data.length === 0) {
      return;
    }

    var $selections = [];

    for (var d = 0; d < data.length; d++) {
      var selection = data[d];

      var $selection = this.selectionContainer();
      var formatted = this.display(selection, $selection);

      $selection.append(formatted);
      $selection.prop('title', selection.title || selection.text);

      $selection.data('data', selection);

      $selections.push($selection);
    }

    var $rendered = this.$selection.find('.select2-selection__rendered');

    Utils.appendMany($rendered, $selections);
  };

  return MultipleSelection;
});

S2.define('select2/selection/placeholder',[
  '../utils'
], function (Utils) {
  function Placeholder (decorated, $element, options) {
    this.placeholder = this.normalizePlaceholder(options.get('placeholder'));

    decorated.call(this, $element, options);
  }

  Placeholder.prototype.normalizePlaceholder = function (_, placeholder) {
    if (typeof placeholder === 'string') {
      placeholder = {
        id: '',
        text: placeholder
      };
    }

    return placeholder;
  };

  Placeholder.prototype.createPlaceholder = function (decorated, placeholder) {
    var $placeholder = this.selectionContainer();

    $placeholder.html(this.display(placeholder));
    $placeholder.addClass('select2-selection__placeholder')
                .removeClass('select2-selection__choice');

    return $placeholder;
  };

  Placeholder.prototype.update = function (decorated, data) {
    var singlePlaceholder = (
      data.length == 1 && data[0].id != this.placeholder.id
    );
    var multipleSelections = data.length > 1;

    if (multipleSelections || singlePlaceholder) {
      return decorated.call(this, data);
    }

    this.clear();

    var $placeholder = this.createPlaceholder(this.placeholder);

    this.$selection.find('.select2-selection__rendered').append($placeholder);
  };

  return Placeholder;
});

S2.define('select2/selection/allowClear',[
  'jquery',
  '../keys'
], function ($, KEYS) {
  function AllowClear () { }

  AllowClear.prototype.bind = function (decorated, container, $container) {
    var self = this;

    decorated.call(this, container, $container);

    if (this.placeholder == null) {
      if (this.options.get('debug') && window.console && console.error) {
        console.error(
          'Select2: The `allowClear` option should be used in combination ' +
          'with the `placeholder` option.'
        );
      }
    }

    this.$selection.on('mousedown', '.select2-selection__clear',
      function (evt) {
        self._handleClear(evt);
    });

    container.on('keypress', function (evt) {
      self._handleKeyboardClear(evt, container);
    });
  };

  AllowClear.prototype._handleClear = function (_, evt) {
    // Ignore the event if it is disabled
    if (this.options.get('disabled')) {
      return;
    }

    var $clear = this.$selection.find('.select2-selection__clear');

    // Ignore the event if nothing has been selected
    if ($clear.length === 0) {
      return;
    }

    evt.stopPropagation();

    var data = $clear.data('data');

    for (var d = 0; d < data.length; d++) {
      var unselectData = {
        data: data[d]
      };

      // Trigger the `unselect` event, so people can prevent it from being
      // cleared.
      this.trigger('unselect', unselectData);

      // If the event was prevented, don't clear it out.
      if (unselectData.prevented) {
        return;
      }
    }

    this.$element.val(this.placeholder.id).trigger('change');

    this.trigger('toggle', {});
  };

  AllowClear.prototype._handleKeyboardClear = function (_, evt, container) {
    if (container.isOpen()) {
      return;
    }

    if (evt.which == KEYS.DELETE || evt.which == KEYS.BACKSPACE) {
      this._handleClear(evt);
    }
  };

  AllowClear.prototype.update = function (decorated, data) {
    decorated.call(this, data);

    if (this.$selection.find('.select2-selection__placeholder').length > 0 ||
        data.length === 0) {
      return;
    }

    var $remove = $(
      '<span class="select2-selection__clear">' +
        '&times;' +
      '</span>'
    );
    $remove.data('data', data);

    this.$selection.find('.select2-selection__rendered').prepend($remove);
  };

  return AllowClear;
});

S2.define('select2/selection/search',[
  'jquery',
  '../utils',
  '../keys'
], function ($, Utils, KEYS) {
  function Search (decorated, $element, options) {
    decorated.call(this, $element, options);
  }

  Search.prototype.render = function (decorated) {
    var $search = $(
      '<li class="select2-search select2-search--inline">' +
        '<input class="select2-search__field" type="search" tabindex="-1"' +
        ' autocomplete="off" autocorrect="off" autocapitalize="none"' +
        ' spellcheck="false" role="textbox" aria-autocomplete="list" />' +
      '</li>'
    );

    this.$searchContainer = $search;
    this.$search = $search.find('input');

    var $rendered = decorated.call(this);

    this._transferTabIndex();

    return $rendered;
  };

  Search.prototype.bind = function (decorated, container, $container) {
    var self = this;

    decorated.call(this, container, $container);

    container.on('open', function () {
      self.$search.trigger('focus');
    });

    container.on('close', function () {
      self.$search.val('');
      self.$search.removeAttr('aria-activedescendant');
      self.$search.trigger('focus');
    });

    container.on('enable', function () {
      self.$search.prop('disabled', false);

      self._transferTabIndex();
    });

    container.on('disable', function () {
      self.$search.prop('disabled', true);
    });

    container.on('focus', function (evt) {
      self.$search.trigger('focus');
    });

    container.on('results:focus', function (params) {
      self.$search.attr('aria-activedescendant', params.id);
    });

    this.$selection.on('focusin', '.select2-search--inline', function (evt) {
      self.trigger('focus', evt);
    });

    this.$selection.on('focusout', '.select2-search--inline', function (evt) {
      self._handleBlur(evt);
    });

    this.$selection.on('keydown', '.select2-search--inline', function (evt) {
      evt.stopPropagation();

      self.trigger('keypress', evt);

      self._keyUpPrevented = evt.isDefaultPrevented();

      var key = evt.which;

      if (key === KEYS.BACKSPACE && self.$search.val() === '') {
        var $previousChoice = self.$searchContainer
          .prev('.select2-selection__choice');

        if ($previousChoice.length > 0) {
          var item = $previousChoice.data('data');

          self.searchRemoveChoice(item);

          evt.preventDefault();
        }
      }
    });

    // Try to detect the IE version should the `documentMode` property that
    // is stored on the document. This is only implemented in IE and is
    // slightly cleaner than doing a user agent check.
    // This property is not available in Edge, but Edge also doesn't have
    // this bug.
    var msie = document.documentMode;
    var disableInputEvents = msie && msie <= 11;

    // Workaround for browsers which do not support the `input` event
    // This will prevent double-triggering of events for browsers which support
    // both the `keyup` and `input` events.
    this.$selection.on(
      'input.searchcheck',
      '.select2-search--inline',
      function (evt) {
        // IE will trigger the `input` event when a placeholder is used on a
        // search box. To get around this issue, we are forced to ignore all
        // `input` events in IE and keep using `keyup`.
        if (disableInputEvents) {
          self.$selection.off('input.search input.searchcheck');
          return;
        }

        // Unbind the duplicated `keyup` event
        self.$selection.off('keyup.search');
      }
    );

    this.$selection.on(
      'keyup.search input.search',
      '.select2-search--inline',
      function (evt) {
        // IE will trigger the `input` event when a placeholder is used on a
        // search box. To get around this issue, we are forced to ignore all
        // `input` events in IE and keep using `keyup`.
        if (disableInputEvents && evt.type === 'input') {
          self.$selection.off('input.search input.searchcheck');
          return;
        }

        var key = evt.which;

        // We can freely ignore events from modifier keys
        if (key == KEYS.SHIFT || key == KEYS.CTRL || key == KEYS.ALT) {
          return;
        }

        // Tabbing will be handled during the `keydown` phase
        if (key == KEYS.TAB) {
          return;
        }

        self.handleSearch(evt);
      }
    );
  };

  /**
   * This method will transfer the tabindex attribute from the rendered
   * selection to the search box. This allows for the search box to be used as
   * the primary focus instead of the selection container.
   *
   * @private
   */
  Search.prototype._transferTabIndex = function (decorated) {
    this.$search.attr('tabindex', this.$selection.attr('tabindex'));
    this.$selection.attr('tabindex', '-1');
  };

  Search.prototype.createPlaceholder = function (decorated, placeholder) {
    this.$search.attr('placeholder', placeholder.text);
  };

  Search.prototype.update = function (decorated, data) {
    var searchHadFocus = this.$search[0] == document.activeElement;

    this.$search.attr('placeholder', '');

    decorated.call(this, data);

    this.$selection.find('.select2-selection__rendered')
                   .append(this.$searchContainer);

    this.resizeSearch();
    if (searchHadFocus) {
      this.$search.focus();
    }
  };

  Search.prototype.handleSearch = function () {
    this.resizeSearch();

    if (!this._keyUpPrevented) {
      var input = this.$search.val();

      this.trigger('query', {
        term: input
      });
    }

    this._keyUpPrevented = false;
  };

  Search.prototype.searchRemoveChoice = function (decorated, item) {
    this.trigger('unselect', {
      data: item
    });

    this.$search.val(item.text);
    this.handleSearch();
  };

  Search.prototype.resizeSearch = function () {
    this.$search.css('width', '25px');

    var width = '';

    if (this.$search.attr('placeholder') !== '') {
      width = this.$selection.find('.select2-selection__rendered').innerWidth();
    } else {
      var minimumWidth = this.$search.val().length + 1;

      width = (minimumWidth * 0.75) + 'em';
    }

    this.$search.css('width', width);
  };

  return Search;
});

S2.define('select2/selection/eventRelay',[
  'jquery'
], function ($) {
  function EventRelay () { }

  EventRelay.prototype.bind = function (decorated, container, $container) {
    var self = this;
    var relayEvents = [
      'open', 'opening',
      'close', 'closing',
      'select', 'selecting',
      'unselect', 'unselecting'
    ];

    var preventableEvents = ['opening', 'closing', 'selecting', 'unselecting'];

    decorated.call(this, container, $container);

    container.on('*', function (name, params) {
      // Ignore events that should not be relayed
      if ($.inArray(name, relayEvents) === -1) {
        return;
      }

      // The parameters should always be an object
      params = params || {};

      // Generate the jQuery event for the Select2 event
      var evt = $.Event('select2:' + name, {
        params: params
      });

      self.$element.trigger(evt);

      // Only handle preventable events if it was one
      if ($.inArray(name, preventableEvents) === -1) {
        return;
      }

      params.prevented = evt.isDefaultPrevented();
    });
  };

  return EventRelay;
});

S2.define('select2/translation',[
  'jquery',
  'require'
], function ($, require) {
  function Translation (dict) {
    this.dict = dict || {};
  }

  Translation.prototype.all = function () {
    return this.dict;
  };

  Translation.prototype.get = function (key) {
    return this.dict[key];
  };

  Translation.prototype.extend = function (translation) {
    this.dict = $.extend({}, translation.all(), this.dict);
  };

  // Static functions

  Translation._cache = {};

  Translation.loadPath = function (path) {
    if (!(path in Translation._cache)) {
      var translations = require(path);

      Translation._cache[path] = translations;
    }

    return new Translation(Translation._cache[path]);
  };

  return Translation;
});

S2.define('select2/diacritics',[

], function () {
  var diacritics = {
    '\u24B6': 'A',
    '\uFF21': 'A',
    '\u00C0': 'A',
    '\u00C1': 'A',
    '\u00C2': 'A',
    '\u1EA6': 'A',
    '\u1EA4': 'A',
    '\u1EAA': 'A',
    '\u1EA8': 'A',
    '\u00C3': 'A',
    '\u0100': 'A',
    '\u0102': 'A',
    '\u1EB0': 'A',
    '\u1EAE': 'A',
    '\u1EB4': 'A',
    '\u1EB2': 'A',
    '\u0226': 'A',
    '\u01E0': 'A',
    '\u00C4': 'A',
    '\u01DE': 'A',
    '\u1EA2': 'A',
    '\u00C5': 'A',
    '\u01FA': 'A',
    '\u01CD': 'A',
    '\u0200': 'A',
    '\u0202': 'A',
    '\u1EA0': 'A',
    '\u1EAC': 'A',
    '\u1EB6': 'A',
    '\u1E00': 'A',
    '\u0104': 'A',
    '\u023A': 'A',
    '\u2C6F': 'A',
    '\uA732': 'AA',
    '\u00C6': 'AE',
    '\u01FC': 'AE',
    '\u01E2': 'AE',
    '\uA734': 'AO',
    '\uA736': 'AU',
    '\uA738': 'AV',
    '\uA73A': 'AV',
    '\uA73C': 'AY',
    '\u24B7': 'B',
    '\uFF22': 'B',
    '\u1E02': 'B',
    '\u1E04': 'B',
    '\u1E06': 'B',
    '\u0243': 'B',
    '\u0182': 'B',
    '\u0181': 'B',
    '\u24B8': 'C',
    '\uFF23': 'C',
    '\u0106': 'C',
    '\u0108': 'C',
    '\u010A': 'C',
    '\u010C': 'C',
    '\u00C7': 'C',
    '\u1E08': 'C',
    '\u0187': 'C',
    '\u023B': 'C',
    '\uA73E': 'C',
    '\u24B9': 'D',
    '\uFF24': 'D',
    '\u1E0A': 'D',
    '\u010E': 'D',
    '\u1E0C': 'D',
    '\u1E10': 'D',
    '\u1E12': 'D',
    '\u1E0E': 'D',
    '\u0110': 'D',
    '\u018B': 'D',
    '\u018A': 'D',
    '\u0189': 'D',
    '\uA779': 'D',
    '\u01F1': 'DZ',
    '\u01C4': 'DZ',
    '\u01F2': 'Dz',
    '\u01C5': 'Dz',
    '\u24BA': 'E',
    '\uFF25': 'E',
    '\u00C8': 'E',
    '\u00C9': 'E',
    '\u00CA': 'E',
    '\u1EC0': 'E',
    '\u1EBE': 'E',
    '\u1EC4': 'E',
    '\u1EC2': 'E',
    '\u1EBC': 'E',
    '\u0112': 'E',
    '\u1E14': 'E',
    '\u1E16': 'E',
    '\u0114': 'E',
    '\u0116': 'E',
    '\u00CB': 'E',
    '\u1EBA': 'E',
    '\u011A': 'E',
    '\u0204': 'E',
    '\u0206': 'E',
    '\u1EB8': 'E',
    '\u1EC6': 'E',
    '\u0228': 'E',
    '\u1E1C': 'E',
    '\u0118': 'E',
    '\u1E18': 'E',
    '\u1E1A': 'E',
    '\u0190': 'E',
    '\u018E': 'E',
    '\u24BB': 'F',
    '\uFF26': 'F',
    '\u1E1E': 'F',
    '\u0191': 'F',
    '\uA77B': 'F',
    '\u24BC': 'G',
    '\uFF27': 'G',
    '\u01F4': 'G',
    '\u011C': 'G',
    '\u1E20': 'G',
    '\u011E': 'G',
    '\u0120': 'G',
    '\u01E6': 'G',
    '\u0122': 'G',
    '\u01E4': 'G',
    '\u0193': 'G',
    '\uA7A0': 'G',
    '\uA77D': 'G',
    '\uA77E': 'G',
    '\u24BD': 'H',
    '\uFF28': 'H',
    '\u0124': 'H',
    '\u1E22': 'H',
    '\u1E26': 'H',
    '\u021E': 'H',
    '\u1E24': 'H',
    '\u1E28': 'H',
    '\u1E2A': 'H',
    '\u0126': 'H',
    '\u2C67': 'H',
    '\u2C75': 'H',
    '\uA78D': 'H',
    '\u24BE': 'I',
    '\uFF29': 'I',
    '\u00CC': 'I',
    '\u00CD': 'I',
    '\u00CE': 'I',
    '\u0128': 'I',
    '\u012A': 'I',
    '\u012C': 'I',
    '\u0130': 'I',
    '\u00CF': 'I',
    '\u1E2E': 'I',
    '\u1EC8': 'I',
    '\u01CF': 'I',
    '\u0208': 'I',
    '\u020A': 'I',
    '\u1ECA': 'I',
    '\u012E': 'I',
    '\u1E2C': 'I',
    '\u0197': 'I',
    '\u24BF': 'J',
    '\uFF2A': 'J',
    '\u0134': 'J',
    '\u0248': 'J',
    '\u24C0': 'K',
    '\uFF2B': 'K',
    '\u1E30': 'K',
    '\u01E8': 'K',
    '\u1E32': 'K',
    '\u0136': 'K',
    '\u1E34': 'K',
    '\u0198': 'K',
    '\u2C69': 'K',
    '\uA740': 'K',
    '\uA742': 'K',
    '\uA744': 'K',
    '\uA7A2': 'K',
    '\u24C1': 'L',
    '\uFF2C': 'L',
    '\u013F': 'L',
    '\u0139': 'L',
    '\u013D': 'L',
    '\u1E36': 'L',
    '\u1E38': 'L',
    '\u013B': 'L',
    '\u1E3C': 'L',
    '\u1E3A': 'L',
    '\u0141': 'L',
    '\u023D': 'L',
    '\u2C62': 'L',
    '\u2C60': 'L',
    '\uA748': 'L',
    '\uA746': 'L',
    '\uA780': 'L',
    '\u01C7': 'LJ',
    '\u01C8': 'Lj',
    '\u24C2': 'M',
    '\uFF2D': 'M',
    '\u1E3E': 'M',
    '\u1E40': 'M',
    '\u1E42': 'M',
    '\u2C6E': 'M',
    '\u019C': 'M',
    '\u24C3': 'N',
    '\uFF2E': 'N',
    '\u01F8': 'N',
    '\u0143': 'N',
    '\u00D1': 'N',
    '\u1E44': 'N',
    '\u0147': 'N',
    '\u1E46': 'N',
    '\u0145': 'N',
    '\u1E4A': 'N',
    '\u1E48': 'N',
    '\u0220': 'N',
    '\u019D': 'N',
    '\uA790': 'N',
    '\uA7A4': 'N',
    '\u01CA': 'NJ',
    '\u01CB': 'Nj',
    '\u24C4': 'O',
    '\uFF2F': 'O',
    '\u00D2': 'O',
    '\u00D3': 'O',
    '\u00D4': 'O',
    '\u1ED2': 'O',
    '\u1ED0': 'O',
    '\u1ED6': 'O',
    '\u1ED4': 'O',
    '\u00D5': 'O',
    '\u1E4C': 'O',
    '\u022C': 'O',
    '\u1E4E': 'O',
    '\u014C': 'O',
    '\u1E50': 'O',
    '\u1E52': 'O',
    '\u014E': 'O',
    '\u022E': 'O',
    '\u0230': 'O',
    '\u00D6': 'O',
    '\u022A': 'O',
    '\u1ECE': 'O',
    '\u0150': 'O',
    '\u01D1': 'O',
    '\u020C': 'O',
    '\u020E': 'O',
    '\u01A0': 'O',
    '\u1EDC': 'O',
    '\u1EDA': 'O',
    '\u1EE0': 'O',
    '\u1EDE': 'O',
    '\u1EE2': 'O',
    '\u1ECC': 'O',
    '\u1ED8': 'O',
    '\u01EA': 'O',
    '\u01EC': 'O',
    '\u00D8': 'O',
    '\u01FE': 'O',
    '\u0186': 'O',
    '\u019F': 'O',
    '\uA74A': 'O',
    '\uA74C': 'O',
    '\u01A2': 'OI',
    '\uA74E': 'OO',
    '\u0222': 'OU',
    '\u24C5': 'P',
    '\uFF30': 'P',
    '\u1E54': 'P',
    '\u1E56': 'P',
    '\u01A4': 'P',
    '\u2C63': 'P',
    '\uA750': 'P',
    '\uA752': 'P',
    '\uA754': 'P',
    '\u24C6': 'Q',
    '\uFF31': 'Q',
    '\uA756': 'Q',
    '\uA758': 'Q',
    '\u024A': 'Q',
    '\u24C7': 'R',
    '\uFF32': 'R',
    '\u0154': 'R',
    '\u1E58': 'R',
    '\u0158': 'R',
    '\u0210': 'R',
    '\u0212': 'R',
    '\u1E5A': 'R',
    '\u1E5C': 'R',
    '\u0156': 'R',
    '\u1E5E': 'R',
    '\u024C': 'R',
    '\u2C64': 'R',
    '\uA75A': 'R',
    '\uA7A6': 'R',
    '\uA782': 'R',
    '\u24C8': 'S',
    '\uFF33': 'S',
    '\u1E9E': 'S',
    '\u015A': 'S',
    '\u1E64': 'S',
    '\u015C': 'S',
    '\u1E60': 'S',
    '\u0160': 'S',
    '\u1E66': 'S',
    '\u1E62': 'S',
    '\u1E68': 'S',
    '\u0218': 'S',
    '\u015E': 'S',
    '\u2C7E': 'S',
    '\uA7A8': 'S',
    '\uA784': 'S',
    '\u24C9': 'T',
    '\uFF34': 'T',
    '\u1E6A': 'T',
    '\u0164': 'T',
    '\u1E6C': 'T',
    '\u021A': 'T',
    '\u0162': 'T',
    '\u1E70': 'T',
    '\u1E6E': 'T',
    '\u0166': 'T',
    '\u01AC': 'T',
    '\u01AE': 'T',
    '\u023E': 'T',
    '\uA786': 'T',
    '\uA728': 'TZ',
    '\u24CA': 'U',
    '\uFF35': 'U',
    '\u00D9': 'U',
    '\u00DA': 'U',
    '\u00DB': 'U',
    '\u0168': 'U',
    '\u1E78': 'U',
    '\u016A': 'U',
    '\u1E7A': 'U',
    '\u016C': 'U',
    '\u00DC': 'U',
    '\u01DB': 'U',
    '\u01D7': 'U',
    '\u01D5': 'U',
    '\u01D9': 'U',
    '\u1EE6': 'U',
    '\u016E': 'U',
    '\u0170': 'U',
    '\u01D3': 'U',
    '\u0214': 'U',
    '\u0216': 'U',
    '\u01AF': 'U',
    '\u1EEA': 'U',
    '\u1EE8': 'U',
    '\u1EEE': 'U',
    '\u1EEC': 'U',
    '\u1EF0': 'U',
    '\u1EE4': 'U',
    '\u1E72': 'U',
    '\u0172': 'U',
    '\u1E76': 'U',
    '\u1E74': 'U',
    '\u0244': 'U',
    '\u24CB': 'V',
    '\uFF36': 'V',
    '\u1E7C': 'V',
    '\u1E7E': 'V',
    '\u01B2': 'V',
    '\uA75E': 'V',
    '\u0245': 'V',
    '\uA760': 'VY',
    '\u24CC': 'W',
    '\uFF37': 'W',
    '\u1E80': 'W',
    '\u1E82': 'W',
    '\u0174': 'W',
    '\u1E86': 'W',
    '\u1E84': 'W',
    '\u1E88': 'W',
    '\u2C72': 'W',
    '\u24CD': 'X',
    '\uFF38': 'X',
    '\u1E8A': 'X',
    '\u1E8C': 'X',
    '\u24CE': 'Y',
    '\uFF39': 'Y',
    '\u1EF2': 'Y',
    '\u00DD': 'Y',
    '\u0176': 'Y',
    '\u1EF8': 'Y',
    '\u0232': 'Y',
    '\u1E8E': 'Y',
    '\u0178': 'Y',
    '\u1EF6': 'Y',
    '\u1EF4': 'Y',
    '\u01B3': 'Y',
    '\u024E': 'Y',
    '\u1EFE': 'Y',
    '\u24CF': 'Z',
    '\uFF3A': 'Z',
    '\u0179': 'Z',
    '\u1E90': 'Z',
    '\u017B': 'Z',
    '\u017D': 'Z',
    '\u1E92': 'Z',
    '\u1E94': 'Z',
    '\u01B5': 'Z',
    '\u0224': 'Z',
    '\u2C7F': 'Z',
    '\u2C6B': 'Z',
    '\uA762': 'Z',
    '\u24D0': 'a',
    '\uFF41': 'a',
    '\u1E9A': 'a',
    '\u00E0': 'a',
    '\u00E1': 'a',
    '\u00E2': 'a',
    '\u1EA7': 'a',
    '\u1EA5': 'a',
    '\u1EAB': 'a',
    '\u1EA9': 'a',
    '\u00E3': 'a',
    '\u0101': 'a',
    '\u0103': 'a',
    '\u1EB1': 'a',
    '\u1EAF': 'a',
    '\u1EB5': 'a',
    '\u1EB3': 'a',
    '\u0227': 'a',
    '\u01E1': 'a',
    '\u00E4': 'a',
    '\u01DF': 'a',
    '\u1EA3': 'a',
    '\u00E5': 'a',
    '\u01FB': 'a',
    '\u01CE': 'a',
    '\u0201': 'a',
    '\u0203': 'a',
    '\u1EA1': 'a',
    '\u1EAD': 'a',
    '\u1EB7': 'a',
    '\u1E01': 'a',
    '\u0105': 'a',
    '\u2C65': 'a',
    '\u0250': 'a',
    '\uA733': 'aa',
    '\u00E6': 'ae',
    '\u01FD': 'ae',
    '\u01E3': 'ae',
    '\uA735': 'ao',
    '\uA737': 'au',
    '\uA739': 'av',
    '\uA73B': 'av',
    '\uA73D': 'ay',
    '\u24D1': 'b',
    '\uFF42': 'b',
    '\u1E03': 'b',
    '\u1E05': 'b',
    '\u1E07': 'b',
    '\u0180': 'b',
    '\u0183': 'b',
    '\u0253': 'b',
    '\u24D2': 'c',
    '\uFF43': 'c',
    '\u0107': 'c',
    '\u0109': 'c',
    '\u010B': 'c',
    '\u010D': 'c',
    '\u00E7': 'c',
    '\u1E09': 'c',
    '\u0188': 'c',
    '\u023C': 'c',
    '\uA73F': 'c',
    '\u2184': 'c',
    '\u24D3': 'd',
    '\uFF44': 'd',
    '\u1E0B': 'd',
    '\u010F': 'd',
    '\u1E0D': 'd',
    '\u1E11': 'd',
    '\u1E13': 'd',
    '\u1E0F': 'd',
    '\u0111': 'd',
    '\u018C': 'd',
    '\u0256': 'd',
    '\u0257': 'd',
    '\uA77A': 'd',
    '\u01F3': 'dz',
    '\u01C6': 'dz',
    '\u24D4': 'e',
    '\uFF45': 'e',
    '\u00E8': 'e',
    '\u00E9': 'e',
    '\u00EA': 'e',
    '\u1EC1': 'e',
    '\u1EBF': 'e',
    '\u1EC5': 'e',
    '\u1EC3': 'e',
    '\u1EBD': 'e',
    '\u0113': 'e',
    '\u1E15': 'e',
    '\u1E17': 'e',
    '\u0115': 'e',
    '\u0117': 'e',
    '\u00EB': 'e',
    '\u1EBB': 'e',
    '\u011B': 'e',
    '\u0205': 'e',
    '\u0207': 'e',
    '\u1EB9': 'e',
    '\u1EC7': 'e',
    '\u0229': 'e',
    '\u1E1D': 'e',
    '\u0119': 'e',
    '\u1E19': 'e',
    '\u1E1B': 'e',
    '\u0247': 'e',
    '\u025B': 'e',
    '\u01DD': 'e',
    '\u24D5': 'f',
    '\uFF46': 'f',
    '\u1E1F': 'f',
    '\u0192': 'f',
    '\uA77C': 'f',
    '\u24D6': 'g',
    '\uFF47': 'g',
    '\u01F5': 'g',
    '\u011D': 'g',
    '\u1E21': 'g',
    '\u011F': 'g',
    '\u0121': 'g',
    '\u01E7': 'g',
    '\u0123': 'g',
    '\u01E5': 'g',
    '\u0260': 'g',
    '\uA7A1': 'g',
    '\u1D79': 'g',
    '\uA77F': 'g',
    '\u24D7': 'h',
    '\uFF48': 'h',
    '\u0125': 'h',
    '\u1E23': 'h',
    '\u1E27': 'h',
    '\u021F': 'h',
    '\u1E25': 'h',
    '\u1E29': 'h',
    '\u1E2B': 'h',
    '\u1E96': 'h',
    '\u0127': 'h',
    '\u2C68': 'h',
    '\u2C76': 'h',
    '\u0265': 'h',
    '\u0195': 'hv',
    '\u24D8': 'i',
    '\uFF49': 'i',
    '\u00EC': 'i',
    '\u00ED': 'i',
    '\u00EE': 'i',
    '\u0129': 'i',
    '\u012B': 'i',
    '\u012D': 'i',
    '\u00EF': 'i',
    '\u1E2F': 'i',
    '\u1EC9': 'i',
    '\u01D0': 'i',
    '\u0209': 'i',
    '\u020B': 'i',
    '\u1ECB': 'i',
    '\u012F': 'i',
    '\u1E2D': 'i',
    '\u0268': 'i',
    '\u0131': 'i',
    '\u24D9': 'j',
    '\uFF4A': 'j',
    '\u0135': 'j',
    '\u01F0': 'j',
    '\u0249': 'j',
    '\u24DA': 'k',
    '\uFF4B': 'k',
    '\u1E31': 'k',
    '\u01E9': 'k',
    '\u1E33': 'k',
    '\u0137': 'k',
    '\u1E35': 'k',
    '\u0199': 'k',
    '\u2C6A': 'k',
    '\uA741': 'k',
    '\uA743': 'k',
    '\uA745': 'k',
    '\uA7A3': 'k',
    '\u24DB': 'l',
    '\uFF4C': 'l',
    '\u0140': 'l',
    '\u013A': 'l',
    '\u013E': 'l',
    '\u1E37': 'l',
    '\u1E39': 'l',
    '\u013C': 'l',
    '\u1E3D': 'l',
    '\u1E3B': 'l',
    '\u017F': 'l',
    '\u0142': 'l',
    '\u019A': 'l',
    '\u026B': 'l',
    '\u2C61': 'l',
    '\uA749': 'l',
    '\uA781': 'l',
    '\uA747': 'l',
    '\u01C9': 'lj',
    '\u24DC': 'm',
    '\uFF4D': 'm',
    '\u1E3F': 'm',
    '\u1E41': 'm',
    '\u1E43': 'm',
    '\u0271': 'm',
    '\u026F': 'm',
    '\u24DD': 'n',
    '\uFF4E': 'n',
    '\u01F9': 'n',
    '\u0144': 'n',
    '\u00F1': 'n',
    '\u1E45': 'n',
    '\u0148': 'n',
    '\u1E47': 'n',
    '\u0146': 'n',
    '\u1E4B': 'n',
    '\u1E49': 'n',
    '\u019E': 'n',
    '\u0272': 'n',
    '\u0149': 'n',
    '\uA791': 'n',
    '\uA7A5': 'n',
    '\u01CC': 'nj',
    '\u24DE': 'o',
    '\uFF4F': 'o',
    '\u00F2': 'o',
    '\u00F3': 'o',
    '\u00F4': 'o',
    '\u1ED3': 'o',
    '\u1ED1': 'o',
    '\u1ED7': 'o',
    '\u1ED5': 'o',
    '\u00F5': 'o',
    '\u1E4D': 'o',
    '\u022D': 'o',
    '\u1E4F': 'o',
    '\u014D': 'o',
    '\u1E51': 'o',
    '\u1E53': 'o',
    '\u014F': 'o',
    '\u022F': 'o',
    '\u0231': 'o',
    '\u00F6': 'o',
    '\u022B': 'o',
    '\u1ECF': 'o',
    '\u0151': 'o',
    '\u01D2': 'o',
    '\u020D': 'o',
    '\u020F': 'o',
    '\u01A1': 'o',
    '\u1EDD': 'o',
    '\u1EDB': 'o',
    '\u1EE1': 'o',
    '\u1EDF': 'o',
    '\u1EE3': 'o',
    '\u1ECD': 'o',
    '\u1ED9': 'o',
    '\u01EB': 'o',
    '\u01ED': 'o',
    '\u00F8': 'o',
    '\u01FF': 'o',
    '\u0254': 'o',
    '\uA74B': 'o',
    '\uA74D': 'o',
    '\u0275': 'o',
    '\u01A3': 'oi',
    '\u0223': 'ou',
    '\uA74F': 'oo',
    '\u24DF': 'p',
    '\uFF50': 'p',
    '\u1E55': 'p',
    '\u1E57': 'p',
    '\u01A5': 'p',
    '\u1D7D': 'p',
    '\uA751': 'p',
    '\uA753': 'p',
    '\uA755': 'p',
    '\u24E0': 'q',
    '\uFF51': 'q',
    '\u024B': 'q',
    '\uA757': 'q',
    '\uA759': 'q',
    '\u24E1': 'r',
    '\uFF52': 'r',
    '\u0155': 'r',
    '\u1E59': 'r',
    '\u0159': 'r',
    '\u0211': 'r',
    '\u0213': 'r',
    '\u1E5B': 'r',
    '\u1E5D': 'r',
    '\u0157': 'r',
    '\u1E5F': 'r',
    '\u024D': 'r',
    '\u027D': 'r',
    '\uA75B': 'r',
    '\uA7A7': 'r',
    '\uA783': 'r',
    '\u24E2': 's',
    '\uFF53': 's',
    '\u00DF': 's',
    '\u015B': 's',
    '\u1E65': 's',
    '\u015D': 's',
    '\u1E61': 's',
    '\u0161': 's',
    '\u1E67': 's',
    '\u1E63': 's',
    '\u1E69': 's',
    '\u0219': 's',
    '\u015F': 's',
    '\u023F': 's',
    '\uA7A9': 's',
    '\uA785': 's',
    '\u1E9B': 's',
    '\u24E3': 't',
    '\uFF54': 't',
    '\u1E6B': 't',
    '\u1E97': 't',
    '\u0165': 't',
    '\u1E6D': 't',
    '\u021B': 't',
    '\u0163': 't',
    '\u1E71': 't',
    '\u1E6F': 't',
    '\u0167': 't',
    '\u01AD': 't',
    '\u0288': 't',
    '\u2C66': 't',
    '\uA787': 't',
    '\uA729': 'tz',
    '\u24E4': 'u',
    '\uFF55': 'u',
    '\u00F9': 'u',
    '\u00FA': 'u',
    '\u00FB': 'u',
    '\u0169': 'u',
    '\u1E79': 'u',
    '\u016B': 'u',
    '\u1E7B': 'u',
    '\u016D': 'u',
    '\u00FC': 'u',
    '\u01DC': 'u',
    '\u01D8': 'u',
    '\u01D6': 'u',
    '\u01DA': 'u',
    '\u1EE7': 'u',
    '\u016F': 'u',
    '\u0171': 'u',
    '\u01D4': 'u',
    '\u0215': 'u',
    '\u0217': 'u',
    '\u01B0': 'u',
    '\u1EEB': 'u',
    '\u1EE9': 'u',
    '\u1EEF': 'u',
    '\u1EED': 'u',
    '\u1EF1': 'u',
    '\u1EE5': 'u',
    '\u1E73': 'u',
    '\u0173': 'u',
    '\u1E77': 'u',
    '\u1E75': 'u',
    '\u0289': 'u',
    '\u24E5': 'v',
    '\uFF56': 'v',
    '\u1E7D': 'v',
    '\u1E7F': 'v',
    '\u028B': 'v',
    '\uA75F': 'v',
    '\u028C': 'v',
    '\uA761': 'vy',
    '\u24E6': 'w',
    '\uFF57': 'w',
    '\u1E81': 'w',
    '\u1E83': 'w',
    '\u0175': 'w',
    '\u1E87': 'w',
    '\u1E85': 'w',
    '\u1E98': 'w',
    '\u1E89': 'w',
    '\u2C73': 'w',
    '\u24E7': 'x',
    '\uFF58': 'x',
    '\u1E8B': 'x',
    '\u1E8D': 'x',
    '\u24E8': 'y',
    '\uFF59': 'y',
    '\u1EF3': 'y',
    '\u00FD': 'y',
    '\u0177': 'y',
    '\u1EF9': 'y',
    '\u0233': 'y',
    '\u1E8F': 'y',
    '\u00FF': 'y',
    '\u1EF7': 'y',
    '\u1E99': 'y',
    '\u1EF5': 'y',
    '\u01B4': 'y',
    '\u024F': 'y',
    '\u1EFF': 'y',
    '\u24E9': 'z',
    '\uFF5A': 'z',
    '\u017A': 'z',
    '\u1E91': 'z',
    '\u017C': 'z',
    '\u017E': 'z',
    '\u1E93': 'z',
    '\u1E95': 'z',
    '\u01B6': 'z',
    '\u0225': 'z',
    '\u0240': 'z',
    '\u2C6C': 'z',
    '\uA763': 'z',
    '\u0386': '\u0391',
    '\u0388': '\u0395',
    '\u0389': '\u0397',
    '\u038A': '\u0399',
    '\u03AA': '\u0399',
    '\u038C': '\u039F',
    '\u038E': '\u03A5',
    '\u03AB': '\u03A5',
    '\u038F': '\u03A9',
    '\u03AC': '\u03B1',
    '\u03AD': '\u03B5',
    '\u03AE': '\u03B7',
    '\u03AF': '\u03B9',
    '\u03CA': '\u03B9',
    '\u0390': '\u03B9',
    '\u03CC': '\u03BF',
    '\u03CD': '\u03C5',
    '\u03CB': '\u03C5',
    '\u03B0': '\u03C5',
    '\u03C9': '\u03C9',
    '\u03C2': '\u03C3'
  };

  return diacritics;
});

S2.define('select2/data/base',[
  '../utils'
], function (Utils) {
  function BaseAdapter ($element, options) {
    BaseAdapter.__super__.constructor.call(this);
  }

  Utils.Extend(BaseAdapter, Utils.Observable);

  BaseAdapter.prototype.current = function (callback) {
    throw new Error('The `current` method must be defined in child classes.');
  };

  BaseAdapter.prototype.query = function (params, callback) {
    throw new Error('The `query` method must be defined in child classes.');
  };

  BaseAdapter.prototype.bind = function (container, $container) {
    // Can be implemented in subclasses
  };

  BaseAdapter.prototype.destroy = function () {
    // Can be implemented in subclasses
  };

  BaseAdapter.prototype.generateResultId = function (container, data) {
    var id = container.id + '-result-';

    id += Utils.generateChars(4);

    if (data.id != null) {
      id += '-' + data.id.toString();
    } else {
      id += '-' + Utils.generateChars(4);
    }
    return id;
  };

  return BaseAdapter;
});

S2.define('select2/data/select',[
  './base',
  '../utils',
  'jquery'
], function (BaseAdapter, Utils, $) {
  function SelectAdapter ($element, options) {
    this.$element = $element;
    this.options = options;

    SelectAdapter.__super__.constructor.call(this);
  }

  Utils.Extend(SelectAdapter, BaseAdapter);

  SelectAdapter.prototype.current = function (callback) {
    var data = [];
    var self = this;

    this.$element.find(':selected').each(function () {
      var $option = $(this);

      var option = self.item($option);

      data.push(option);
    });

    callback(data);
  };

  SelectAdapter.prototype.select = function (data) {
    var self = this;

    data.selected = true;

    // If data.element is a DOM node, use it instead
    if ($(data.element).is('option')) {
      data.element.selected = true;

      this.$element.trigger('change');

      return;
    }

    if (this.$element.prop('multiple')) {
      this.current(function (currentData) {
        var val = [];

        data = [data];
        data.push.apply(data, currentData);

        for (var d = 0; d < data.length; d++) {
          var id = data[d].id;

          if ($.inArray(id, val) === -1) {
            val.push(id);
          }
        }

        self.$element.val(val);
        self.$element.trigger('change');
      });
    } else {
      var val = data.id;

      this.$element.val(val);
      this.$element.trigger('change');
    }
  };

  SelectAdapter.prototype.unselect = function (data) {
    var self = this;

    if (!this.$element.prop('multiple')) {
      return;
    }

    data.selected = false;

    if ($(data.element).is('option')) {
      data.element.selected = false;

      this.$element.trigger('change');

      return;
    }

    this.current(function (currentData) {
      var val = [];

      for (var d = 0; d < currentData.length; d++) {
        var id = currentData[d].id;

        if (id !== data.id && $.inArray(id, val) === -1) {
          val.push(id);
        }
      }

      self.$element.val(val);

      self.$element.trigger('change');
    });
  };

  SelectAdapter.prototype.bind = function (container, $container) {
    var self = this;

    this.container = container;

    container.on('select', function (params) {
      self.select(params.data);
    });

    container.on('unselect', function (params) {
      self.unselect(params.data);
    });
  };

  SelectAdapter.prototype.destroy = function () {
    // Remove anything added to child elements
    this.$element.find('*').each(function () {
      // Remove any custom data set by Select2
      $.removeData(this, 'data');
    });
  };

  SelectAdapter.prototype.query = function (params, callback) {
    var data = [];
    var self = this;

    var $options = this.$element.children();

    $options.each(function () {
      var $option = $(this);

      if (!$option.is('option') && !$option.is('optgroup')) {
        return;
      }

      var option = self.item($option);

      var matches = self.matches(params, option);

      if (matches !== null) {
        data.push(matches);
      }
    });

    callback({
      results: data
    });
  };

  SelectAdapter.prototype.addOptions = function ($options) {
    Utils.appendMany(this.$element, $options);
  };

  SelectAdapter.prototype.option = function (data) {
    var option;

    if (data.children) {
      option = document.createElement('optgroup');
      option.label = data.text;
    } else {
      option = document.createElement('option');

      if (option.textContent !== undefined) {
        option.textContent = data.text;
      } else {
        option.innerText = data.text;
      }
    }

    if (data.id !== undefined) {
      option.value = data.id;
    }

    if (data.disabled) {
      option.disabled = true;
    }

    if (data.selected) {
      option.selected = true;
    }

    if (data.title) {
      option.title = data.title;
    }

    var $option = $(option);

    var normalizedData = this._normalizeItem(data);
    normalizedData.element = option;

    // Override the option's data with the combined data
    $.data(option, 'data', normalizedData);

    return $option;
  };

  SelectAdapter.prototype.item = function ($option) {
    var data = {};

    data = $.data($option[0], 'data');

    if (data != null) {
      return data;
    }

    if ($option.is('option')) {
      data = {
        id: $option.val(),
        text: $option.text(),
        disabled: $option.prop('disabled'),
        selected: $option.prop('selected'),
        title: $option.prop('title')
      };
    } else if ($option.is('optgroup')) {
      data = {
        text: $option.prop('label'),
        children: [],
        title: $option.prop('title')
      };

      var $children = $option.children('option');
      var children = [];

      for (var c = 0; c < $children.length; c++) {
        var $child = $($children[c]);

        var child = this.item($child);

        children.push(child);
      }

      data.children = children;
    }

    data = this._normalizeItem(data);
    data.element = $option[0];

    $.data($option[0], 'data', data);

    return data;
  };

  SelectAdapter.prototype._normalizeItem = function (item) {
    if (!$.isPlainObject(item)) {
      item = {
        id: item,
        text: item
      };
    }

    item = $.extend({}, {
      text: ''
    }, item);

    var defaults = {
      selected: false,
      disabled: false
    };

    if (item.id != null) {
      item.id = item.id.toString();
    }

    if (item.text != null) {
      item.text = item.text.toString();
    }

    if (item._resultId == null && item.id && this.container != null) {
      item._resultId = this.generateResultId(this.container, item);
    }

    return $.extend({}, defaults, item);
  };

  SelectAdapter.prototype.matches = function (params, data) {
    var matcher = this.options.get('matcher');

    return matcher(params, data);
  };

  return SelectAdapter;
});

S2.define('select2/data/array',[
  './select',
  '../utils',
  'jquery'
], function (SelectAdapter, Utils, $) {
  function ArrayAdapter ($element, options) {
    var data = options.get('data') || [];

    ArrayAdapter.__super__.constructor.call(this, $element, options);

    this.addOptions(this.convertToOptions(data));
  }

  Utils.Extend(ArrayAdapter, SelectAdapter);

  ArrayAdapter.prototype.select = function (data) {
    var $option = this.$element.find('option').filter(function (i, elm) {
      return elm.value == data.id.toString();
    });

    if ($option.length === 0) {
      $option = this.option(data);

      this.addOptions($option);
    }

    ArrayAdapter.__super__.select.call(this, data);
  };

  ArrayAdapter.prototype.convertToOptions = function (data) {
    var self = this;

    var $existing = this.$element.find('option');
    var existingIds = $existing.map(function () {
      return self.item($(this)).id;
    }).get();

    var $options = [];

    // Filter out all items except for the one passed in the argument
    function onlyItem (item) {
      return function () {
        return $(this).val() == item.id;
      };
    }

    for (var d = 0; d < data.length; d++) {
      var item = this._normalizeItem(data[d]);

      // Skip items which were pre-loaded, only merge the data
      if ($.inArray(item.id, existingIds) >= 0) {
        var $existingOption = $existing.filter(onlyItem(item));

        var existingData = this.item($existingOption);
        var newData = $.extend(true, {}, item, existingData);

        var $newOption = this.option(newData);

        $existingOption.replaceWith($newOption);

        continue;
      }

      var $option = this.option(item);

      if (item.children) {
        var $children = this.convertToOptions(item.children);

        Utils.appendMany($option, $children);
      }

      $options.push($option);
    }

    return $options;
  };

  return ArrayAdapter;
});

S2.define('select2/data/ajax',[
  './array',
  '../utils',
  'jquery'
], function (ArrayAdapter, Utils, $) {
  function AjaxAdapter ($element, options) {
    this.ajaxOptions = this._applyDefaults(options.get('ajax'));

    if (this.ajaxOptions.processResults != null) {
      this.processResults = this.ajaxOptions.processResults;
    }

    AjaxAdapter.__super__.constructor.call(this, $element, options);
  }

  Utils.Extend(AjaxAdapter, ArrayAdapter);

  AjaxAdapter.prototype._applyDefaults = function (options) {
    var defaults = {
      data: function (params) {
        return $.extend({}, params, {
          q: params.term
        });
      },
      transport: function (params, success, failure) {
        var $request = $.ajax(params);

        $request.then(success);
        $request.fail(failure);

        return $request;
      }
    };

    return $.extend({}, defaults, options, true);
  };

  AjaxAdapter.prototype.processResults = function (results) {
    return results;
  };

  AjaxAdapter.prototype.query = function (params, callback) {
    var matches = [];
    var self = this;

    if (this._request != null) {
      // JSONP requests cannot always be aborted
      if ($.isFunction(this._request.abort)) {
        this._request.abort();
      }

      this._request = null;
    }

    var options = $.extend({
      type: 'GET'
    }, this.ajaxOptions);

    if (typeof options.url === 'function') {
      options.url = options.url.call(this.$element, params);
    }

    if (typeof options.data === 'function') {
      options.data = options.data.call(this.$element, params);
    }

    function request () {
      var $request = options.transport(options, function (data) {
        var results = self.processResults(data, params);

        if (self.options.get('debug') && window.console && console.error) {
          // Check to make sure that the response included a `results` key.
          if (!results || !results.results || !$.isArray(results.results)) {
            console.error(
              'Select2: The AJAX results did not return an array in the ' +
              '`results` key of the response.'
            );
          }
        }

        callback(results);
      }, function () {
        // Attempt to detect if a request was aborted
        // Only works if the transport exposes a status property
        if ($request.status && $request.status === '0') {
          return;
        }

        self.trigger('results:message', {
          message: 'errorLoading'
        });
      });

      self._request = $request;
    }

    if (this.ajaxOptions.delay && params.term != null) {
      if (this._queryTimeout) {
        window.clearTimeout(this._queryTimeout);
      }

      this._queryTimeout = window.setTimeout(request, this.ajaxOptions.delay);
    } else {
      request();
    }
  };

  return AjaxAdapter;
});

S2.define('select2/data/tags',[
  'jquery'
], function ($) {
  function Tags (decorated, $element, options) {
    var tags = options.get('tags');

    var createTag = options.get('createTag');

    if (createTag !== undefined) {
      this.createTag = createTag;
    }

    var insertTag = options.get('insertTag');

    if (insertTag !== undefined) {
        this.insertTag = insertTag;
    }

    decorated.call(this, $element, options);

    if ($.isArray(tags)) {
      for (var t = 0; t < tags.length; t++) {
        var tag = tags[t];
        var item = this._normalizeItem(tag);

        var $option = this.option(item);

        this.$element.append($option);
      }
    }
  }

  Tags.prototype.query = function (decorated, params, callback) {
    var self = this;

    this._removeOldTags();

    if (params.term == null || params.page != null) {
      decorated.call(this, params, callback);
      return;
    }

    function wrapper (obj, child) {
      var data = obj.results;

      for (var i = 0; i < data.length; i++) {
        var option = data[i];

        var checkChildren = (
          option.children != null &&
          !wrapper({
            results: option.children
          }, true)
        );

        var optionText = (option.text || '').toUpperCase();
        var paramsTerm = (params.term || '').toUpperCase();

        var checkText = optionText === paramsTerm;

        if (checkText || checkChildren) {
          if (child) {
            return false;
          }

          obj.data = data;
          callback(obj);

          return;
        }
      }

      if (child) {
        return true;
      }

      var tag = self.createTag(params);

      if (tag != null) {
        var $option = self.option(tag);
        $option.attr('data-select2-tag', true);

        self.addOptions([$option]);

        self.insertTag(data, tag);
      }

      obj.results = data;

      callback(obj);
    }

    decorated.call(this, params, wrapper);
  };

  Tags.prototype.createTag = function (decorated, params) {
    var term = $.trim(params.term);

    if (term === '') {
      return null;
    }

    return {
      id: term,
      text: term
    };
  };

  Tags.prototype.insertTag = function (_, data, tag) {
    data.unshift(tag);
  };

  Tags.prototype._removeOldTags = function (_) {
    var tag = this._lastTag;

    var $options = this.$element.find('option[data-select2-tag]');

    $options.each(function () {
      if (this.selected) {
        return;
      }

      $(this).remove();
    });
  };

  return Tags;
});

S2.define('select2/data/tokenizer',[
  'jquery'
], function ($) {
  function Tokenizer (decorated, $element, options) {
    var tokenizer = options.get('tokenizer');

    if (tokenizer !== undefined) {
      this.tokenizer = tokenizer;
    }

    decorated.call(this, $element, options);
  }

  Tokenizer.prototype.bind = function (decorated, container, $container) {
    decorated.call(this, container, $container);

    this.$search =  container.dropdown.$search || container.selection.$search ||
      $container.find('.select2-search__field');
  };

  Tokenizer.prototype.query = function (decorated, params, callback) {
    var self = this;

    function createAndSelect (data) {
      // Normalize the data object so we can use it for checks
      var item = self._normalizeItem(data);

      // Check if the data object already exists as a tag
      // Select it if it doesn't
      var $existingOptions = self.$element.find('option').filter(function () {
        return $(this).val() === item.id;
      });

      // If an existing option wasn't found for it, create the option
      if (!$existingOptions.length) {
        var $option = self.option(item);
        $option.attr('data-select2-tag', true);

        self._removeOldTags();
        self.addOptions([$option]);
      }

      // Select the item, now that we know there is an option for it
      select(item);
    }

    function select (data) {
      self.trigger('select', {
        data: data
      });
    }

    params.term = params.term || '';

    var tokenData = this.tokenizer(params, this.options, createAndSelect);

    if (tokenData.term !== params.term) {
      // Replace the search term if we have the search box
      if (this.$search.length) {
        this.$search.val(tokenData.term);
        this.$search.focus();
      }

      params.term = tokenData.term;
    }

    decorated.call(this, params, callback);
  };

  Tokenizer.prototype.tokenizer = function (_, params, options, callback) {
    var separators = options.get('tokenSeparators') || [];
    var term = params.term;
    var i = 0;

    var createTag = this.createTag || function (params) {
      return {
        id: params.term,
        text: params.term
      };
    };

    while (i < term.length) {
      var termChar = term[i];

      if ($.inArray(termChar, separators) === -1) {
        i++;

        continue;
      }

      var part = term.substr(0, i);
      var partParams = $.extend({}, params, {
        term: part
      });

      var data = createTag(partParams);

      if (data == null) {
        i++;
        continue;
      }

      callback(data);

      // Reset the term to not include the tokenized portion
      term = term.substr(i + 1) || '';
      i = 0;
    }

    return {
      term: term
    };
  };

  return Tokenizer;
});

S2.define('select2/data/minimumInputLength',[

], function () {
  function MinimumInputLength (decorated, $e, options) {
    this.minimumInputLength = options.get('minimumInputLength');

    decorated.call(this, $e, options);
  }

  MinimumInputLength.prototype.query = function (decorated, params, callback) {
    params.term = params.term || '';

    if (params.term.length < this.minimumInputLength) {
      this.trigger('results:message', {
        message: 'inputTooShort',
        args: {
          minimum: this.minimumInputLength,
          input: params.term,
          params: params
        }
      });

      return;
    }

    decorated.call(this, params, callback);
  };

  return MinimumInputLength;
});

S2.define('select2/data/maximumInputLength',[

], function () {
  function MaximumInputLength (decorated, $e, options) {
    this.maximumInputLength = options.get('maximumInputLength');

    decorated.call(this, $e, options);
  }

  MaximumInputLength.prototype.query = function (decorated, params, callback) {
    params.term = params.term || '';

    if (this.maximumInputLength > 0 &&
        params.term.length > this.maximumInputLength) {
      this.trigger('results:message', {
        message: 'inputTooLong',
        args: {
          maximum: this.maximumInputLength,
          input: params.term,
          params: params
        }
      });

      return;
    }

    decorated.call(this, params, callback);
  };

  return MaximumInputLength;
});

S2.define('select2/data/maximumSelectionLength',[

], function (){
  function MaximumSelectionLength (decorated, $e, options) {
    this.maximumSelectionLength = options.get('maximumSelectionLength');

    decorated.call(this, $e, options);
  }

  MaximumSelectionLength.prototype.query =
    function (decorated, params, callback) {
      var self = this;

      this.current(function (currentData) {
        var count = currentData != null ? currentData.length : 0;
        if (self.maximumSelectionLength > 0 &&
          count >= self.maximumSelectionLength) {
          self.trigger('results:message', {
            message: 'maximumSelected',
            args: {
              maximum: self.maximumSelectionLength
            }
          });
          return;
        }
        decorated.call(self, params, callback);
      });
  };

  return MaximumSelectionLength;
});

S2.define('select2/dropdown',[
  'jquery',
  './utils'
], function ($, Utils) {
  function Dropdown ($element, options) {
    this.$element = $element;
    this.options = options;

    Dropdown.__super__.constructor.call(this);
  }

  Utils.Extend(Dropdown, Utils.Observable);

  Dropdown.prototype.render = function () {
    var $dropdown = $(
      '<span class="select2-dropdown">' +
        '<span class="select2-results"></span>' +
      '</span>'
    );

    $dropdown.attr('dir', this.options.get('dir'));

    this.$dropdown = $dropdown;

    return $dropdown;
  };

  Dropdown.prototype.bind = function () {
    // Should be implemented in subclasses
  };

  Dropdown.prototype.position = function ($dropdown, $container) {
    // Should be implmented in subclasses
  };

  Dropdown.prototype.destroy = function () {
    // Remove the dropdown from the DOM
    this.$dropdown.remove();
  };

  return Dropdown;
});

S2.define('select2/dropdown/search',[
  'jquery',
  '../utils'
], function ($, Utils) {
  function Search () { }

  Search.prototype.render = function (decorated) {
    var $rendered = decorated.call(this);

    var $search = $(
      '<span class="select2-search select2-search--dropdown">' +
        '<input class="select2-search__field" type="search" tabindex="-1"' +
        ' autocomplete="off" autocorrect="off" autocapitalize="none"' +
        ' spellcheck="false" role="textbox" />' +
      '</span>'
    );

    this.$searchContainer = $search;
    this.$search = $search.find('input');

    $rendered.prepend($search);

    return $rendered;
  };

  Search.prototype.bind = function (decorated, container, $container) {
    var self = this;

    decorated.call(this, container, $container);

    this.$search.on('keydown', function (evt) {
      self.trigger('keypress', evt);

      self._keyUpPrevented = evt.isDefaultPrevented();
    });

    // Workaround for browsers which do not support the `input` event
    // This will prevent double-triggering of events for browsers which support
    // both the `keyup` and `input` events.
    this.$search.on('input', function (evt) {
      // Unbind the duplicated `keyup` event
      $(this).off('keyup');
    });

    this.$search.on('keyup input', function (evt) {
      self.handleSearch(evt);
    });

    container.on('open', function () {
      self.$search.attr('tabindex', 0);

      self.$search.focus();

      window.setTimeout(function () {
        self.$search.focus();
      }, 0);
    });

    container.on('close', function () {
      self.$search.attr('tabindex', -1);

      self.$search.val('');
    });

    container.on('focus', function () {
      if (!container.isOpen()) {
        self.$search.focus();
      }
    });

    container.on('results:all', function (params) {
      if (params.query.term == null || params.query.term === '') {
        var showSearch = self.showSearch(params);

        if (showSearch) {
          self.$searchContainer.removeClass('select2-search--hide');
        } else {
          self.$searchContainer.addClass('select2-search--hide');
        }
      }
    });
  };

  Search.prototype.handleSearch = function (evt) {
    if (!this._keyUpPrevented) {
      var input = this.$search.val();

      this.trigger('query', {
        term: input
      });
    }

    this._keyUpPrevented = false;
  };

  Search.prototype.showSearch = function (_, params) {
    return true;
  };

  return Search;
});

S2.define('select2/dropdown/hidePlaceholder',[

], function () {
  function HidePlaceholder (decorated, $element, options, dataAdapter) {
    this.placeholder = this.normalizePlaceholder(options.get('placeholder'));

    decorated.call(this, $element, options, dataAdapter);
  }

  HidePlaceholder.prototype.append = function (decorated, data) {
    data.results = this.removePlaceholder(data.results);

    decorated.call(this, data);
  };

  HidePlaceholder.prototype.normalizePlaceholder = function (_, placeholder) {
    if (typeof placeholder === 'string') {
      placeholder = {
        id: '',
        text: placeholder
      };
    }

    return placeholder;
  };

  HidePlaceholder.prototype.removePlaceholder = function (_, data) {
    var modifiedData = data.slice(0);

    for (var d = data.length - 1; d >= 0; d--) {
      var item = data[d];

      if (this.placeholder.id === item.id) {
        modifiedData.splice(d, 1);
      }
    }

    return modifiedData;
  };

  return HidePlaceholder;
});

S2.define('select2/dropdown/infiniteScroll',[
  'jquery'
], function ($) {
  function InfiniteScroll (decorated, $element, options, dataAdapter) {
    this.lastParams = {};

    decorated.call(this, $element, options, dataAdapter);

    this.$loadingMore = this.createLoadingMore();
    this.loading = false;
  }

  InfiniteScroll.prototype.append = function (decorated, data) {
    this.$loadingMore.remove();
    this.loading = false;

    decorated.call(this, data);

    if (this.showLoadingMore(data)) {
      this.$results.append(this.$loadingMore);
    }
  };

  InfiniteScroll.prototype.bind = function (decorated, container, $container) {
    var self = this;

    decorated.call(this, container, $container);

    container.on('query', function (params) {
      self.lastParams = params;
      self.loading = true;
    });

    container.on('query:append', function (params) {
      self.lastParams = params;
      self.loading = true;
    });

    this.$results.on('scroll', function () {
      var isLoadMoreVisible = $.contains(
        document.documentElement,
        self.$loadingMore[0]
      );

      if (self.loading || !isLoadMoreVisible) {
        return;
      }

      var currentOffset = self.$results.offset().top +
        self.$results.outerHeight(false);
      var loadingMoreOffset = self.$loadingMore.offset().top +
        self.$loadingMore.outerHeight(false);

      if (currentOffset + 50 >= loadingMoreOffset) {
        self.loadMore();
      }
    });
  };

  InfiniteScroll.prototype.loadMore = function () {
    this.loading = true;

    var params = $.extend({}, {page: 1}, this.lastParams);

    params.page++;

    this.trigger('query:append', params);
  };

  InfiniteScroll.prototype.showLoadingMore = function (_, data) {
    return data.pagination && data.pagination.more;
  };

  InfiniteScroll.prototype.createLoadingMore = function () {
    var $option = $(
      '<li ' +
      'class="select2-results__option select2-results__option--load-more"' +
      'role="treeitem" aria-disabled="true"></li>'
    );

    var message = this.options.get('translations').get('loadingMore');

    $option.html(message(this.lastParams));

    return $option;
  };

  return InfiniteScroll;
});

S2.define('select2/dropdown/attachBody',[
  'jquery',
  '../utils'
], function ($, Utils) {
  function AttachBody (decorated, $element, options) {
    this.$dropdownParent = options.get('dropdownParent') || $(document.body);

    decorated.call(this, $element, options);
  }

  AttachBody.prototype.bind = function (decorated, container, $container) {
    var self = this;

    var setupResultsEvents = false;

    decorated.call(this, container, $container);

    container.on('open', function () {
      self._showDropdown();
      self._attachPositioningHandler(container);

      if (!setupResultsEvents) {
        setupResultsEvents = true;

        container.on('results:all', function () {
          self._positionDropdown();
          self._resizeDropdown();
        });

        container.on('results:append', function () {
          self._positionDropdown();
          self._resizeDropdown();
        });
      }
    });

    container.on('close', function () {
      self._hideDropdown();
      self._detachPositioningHandler(container);
    });

    this.$dropdownContainer.on('mousedown', function (evt) {
      evt.stopPropagation();
    });
  };

  AttachBody.prototype.destroy = function (decorated) {
    decorated.call(this);

    this.$dropdownContainer.remove();
  };

  AttachBody.prototype.position = function (decorated, $dropdown, $container) {
    // Clone all of the container classes
    $dropdown.attr('class', $container.attr('class'));

    $dropdown.removeClass('select2');
    $dropdown.addClass('select2-container--open');

    $dropdown.css({
      position: 'absolute',
      top: -999999
    });

    this.$container = $container;
  };

  AttachBody.prototype.render = function (decorated) {
    var $container = $('<span></span>');

    var $dropdown = decorated.call(this);
    $container.append($dropdown);

    this.$dropdownContainer = $container;

    return $container;
  };

  AttachBody.prototype._hideDropdown = function (decorated) {
    this.$dropdownContainer.detach();
  };

  AttachBody.prototype._attachPositioningHandler =
      function (decorated, container) {
    var self = this;

    var scrollEvent = 'scroll.select2.' + container.id;
    var resizeEvent = 'resize.select2.' + container.id;
    var orientationEvent = 'orientationchange.select2.' + container.id;

    var $watchers = this.$container.parents().filter(Utils.hasScroll);
    $watchers.each(function () {
      $(this).data('select2-scroll-position', {
        x: $(this).scrollLeft(),
        y: $(this).scrollTop()
      });
    });

    $watchers.on(scrollEvent, function (ev) {
      var position = $(this).data('select2-scroll-position');
      $(this).scrollTop(position.y);
    });

    $(window).on(scrollEvent + ' ' + resizeEvent + ' ' + orientationEvent,
      function (e) {
      self._positionDropdown();
      self._resizeDropdown();
    });
  };

  AttachBody.prototype._detachPositioningHandler =
      function (decorated, container) {
    var scrollEvent = 'scroll.select2.' + container.id;
    var resizeEvent = 'resize.select2.' + container.id;
    var orientationEvent = 'orientationchange.select2.' + container.id;

    var $watchers = this.$container.parents().filter(Utils.hasScroll);
    $watchers.off(scrollEvent);

    $(window).off(scrollEvent + ' ' + resizeEvent + ' ' + orientationEvent);
  };

  AttachBody.prototype._positionDropdown = function () {
    var $window = $(window);

    var isCurrentlyAbove = this.$dropdown.hasClass('select2-dropdown--above');
    var isCurrentlyBelow = this.$dropdown.hasClass('select2-dropdown--below');

    var newDirection = null;

    var offset = this.$container.offset();

    offset.bottom = offset.top + this.$container.outerHeight(false);

    var container = {
      height: this.$container.outerHeight(false)
    };

    container.top = offset.top;
    container.bottom = offset.top + container.height;

    var dropdown = {
      height: this.$dropdown.outerHeight(false)
    };

    var viewport = {
      top: $window.scrollTop(),
      bottom: $window.scrollTop() + $window.height()
    };

    var enoughRoomAbove = viewport.top < (offset.top - dropdown.height);
    var enoughRoomBelow = viewport.bottom > (offset.bottom + dropdown.height);

    var css = {
      left: offset.left,
      top: container.bottom
    };

    // Determine what the parent element is to use for calciulating the offset
    var $offsetParent = this.$dropdownParent;

    // For statically positoned elements, we need to get the element
    // that is determining the offset
    if ($offsetParent.css('position') === 'static') {
      $offsetParent = $offsetParent.offsetParent();
    }

    var parentOffset = $offsetParent.offset();

    css.top -= parentOffset.top;
    css.left -= parentOffset.left;

    if (!isCurrentlyAbove && !isCurrentlyBelow) {
      newDirection = 'below';
    }

    if (!enoughRoomBelow && enoughRoomAbove && !isCurrentlyAbove) {
      newDirection = 'above';
    } else if (!enoughRoomAbove && enoughRoomBelow && isCurrentlyAbove) {
      newDirection = 'below';
    }

    if (newDirection == 'above' ||
      (isCurrentlyAbove && newDirection !== 'below')) {
      css.top = container.top - parentOffset.top - dropdown.height;
    }

    if (newDirection != null) {
      this.$dropdown
        .removeClass('select2-dropdown--below select2-dropdown--above')
        .addClass('select2-dropdown--' + newDirection);
      this.$container
        .removeClass('select2-container--below select2-container--above')
        .addClass('select2-container--' + newDirection);
    }

    this.$dropdownContainer.css(css);
  };

  AttachBody.prototype._resizeDropdown = function () {
    var css = {
      width: this.$container.outerWidth(false) + 'px'
    };

    if (this.options.get('dropdownAutoWidth')) {
      css.minWidth = css.width;
      css.position = 'relative';
      css.width = 'auto';
    }

    this.$dropdown.css(css);
  };

  AttachBody.prototype._showDropdown = function (decorated) {
    this.$dropdownContainer.appendTo(this.$dropdownParent);

    this._positionDropdown();
    this._resizeDropdown();
  };

  return AttachBody;
});

S2.define('select2/dropdown/minimumResultsForSearch',[

], function () {
  function countResults (data) {
    var count = 0;

    for (var d = 0; d < data.length; d++) {
      var item = data[d];

      if (item.children) {
        count += countResults(item.children);
      } else {
        count++;
      }
    }

    return count;
  }

  function MinimumResultsForSearch (decorated, $element, options, dataAdapter) {
    this.minimumResultsForSearch = options.get('minimumResultsForSearch');

    if (this.minimumResultsForSearch < 0) {
      this.minimumResultsForSearch = Infinity;
    }

    decorated.call(this, $element, options, dataAdapter);
  }

  MinimumResultsForSearch.prototype.showSearch = function (decorated, params) {
    if (countResults(params.data.results) < this.minimumResultsForSearch) {
      return false;
    }

    return decorated.call(this, params);
  };

  return MinimumResultsForSearch;
});

S2.define('select2/dropdown/selectOnClose',[

], function () {
  function SelectOnClose () { }

  SelectOnClose.prototype.bind = function (decorated, container, $container) {
    var self = this;

    decorated.call(this, container, $container);

    container.on('close', function (params) {
      self._handleSelectOnClose(params);
    });
  };

  SelectOnClose.prototype._handleSelectOnClose = function (_, params) {
    if (params && params.originalSelect2Event != null) {
      var event = params.originalSelect2Event;

      // Don't select an item if the close event was triggered from a select or
      // unselect event
      if (event._type === 'select' || event._type === 'unselect') {
        return;
      }
    }

    var $highlightedResults = this.getHighlightedResults();

    // Only select highlighted results
    if ($highlightedResults.length < 1) {
      return;
    }

    var data = $highlightedResults.data('data');

    // Don't re-select already selected resulte
    if (
      (data.element != null && data.element.selected) ||
      (data.element == null && data.selected)
    ) {
      return;
    }

    this.trigger('select', {
        data: data
    });
  };

  return SelectOnClose;
});

S2.define('select2/dropdown/closeOnSelect',[

], function () {
  function CloseOnSelect () { }

  CloseOnSelect.prototype.bind = function (decorated, container, $container) {
    var self = this;

    decorated.call(this, container, $container);

    container.on('select', function (evt) {
      self._selectTriggered(evt);
    });

    container.on('unselect', function (evt) {
      self._selectTriggered(evt);
    });
  };

  CloseOnSelect.prototype._selectTriggered = function (_, evt) {
    var originalEvent = evt.originalEvent;

    // Don't close if the control key is being held
    if (originalEvent && originalEvent.ctrlKey) {
      return;
    }

    this.trigger('close', {
      originalEvent: originalEvent,
      originalSelect2Event: evt
    });
  };

  return CloseOnSelect;
});

S2.define('select2/i18n/en',[],function () {
  // English
  return {
    errorLoading: function () {
      return 'The results could not be loaded.';
    },
    inputTooLong: function (args) {
      var overChars = args.input.length - args.maximum;

      var message = 'Please delete ' + overChars + ' character';

      if (overChars != 1) {
        message += 's';
      }

      return message;
    },
    inputTooShort: function (args) {
      var remainingChars = args.minimum - args.input.length;

      var message = 'Please enter ' + remainingChars + ' or more characters';

      return message;
    },
    loadingMore: function () {
      return 'Loading more results…';
    },
    maximumSelected: function (args) {
      var message = 'You can only select ' + args.maximum + ' item';

      if (args.maximum != 1) {
        message += 's';
      }

      return message;
    },
    noResults: function () {
      return 'No results found';
    },
    searching: function () {
      return 'Searching…';
    }
  };
});

S2.define('select2/defaults',[
  'jquery',
  'require',

  './results',

  './selection/single',
  './selection/multiple',
  './selection/placeholder',
  './selection/allowClear',
  './selection/search',
  './selection/eventRelay',

  './utils',
  './translation',
  './diacritics',

  './data/select',
  './data/array',
  './data/ajax',
  './data/tags',
  './data/tokenizer',
  './data/minimumInputLength',
  './data/maximumInputLength',
  './data/maximumSelectionLength',

  './dropdown',
  './dropdown/search',
  './dropdown/hidePlaceholder',
  './dropdown/infiniteScroll',
  './dropdown/attachBody',
  './dropdown/minimumResultsForSearch',
  './dropdown/selectOnClose',
  './dropdown/closeOnSelect',

  './i18n/en'
], function ($, require,

             ResultsList,

             SingleSelection, MultipleSelection, Placeholder, AllowClear,
             SelectionSearch, EventRelay,

             Utils, Translation, DIACRITICS,

             SelectData, ArrayData, AjaxData, Tags, Tokenizer,
             MinimumInputLength, MaximumInputLength, MaximumSelectionLength,

             Dropdown, DropdownSearch, HidePlaceholder, InfiniteScroll,
             AttachBody, MinimumResultsForSearch, SelectOnClose, CloseOnSelect,

             EnglishTranslation) {
  function Defaults () {
    this.reset();
  }

  Defaults.prototype.apply = function (options) {
    options = $.extend(true, {}, this.defaults, options);

    if (options.dataAdapter == null) {
      if (options.ajax != null) {
        options.dataAdapter = AjaxData;
      } else if (options.data != null) {
        options.dataAdapter = ArrayData;
      } else {
        options.dataAdapter = SelectData;
      }

      if (options.minimumInputLength > 0) {
        options.dataAdapter = Utils.Decorate(
          options.dataAdapter,
          MinimumInputLength
        );
      }

      if (options.maximumInputLength > 0) {
        options.dataAdapter = Utils.Decorate(
          options.dataAdapter,
          MaximumInputLength
        );
      }

      if (options.maximumSelectionLength > 0) {
        options.dataAdapter = Utils.Decorate(
          options.dataAdapter,
          MaximumSelectionLength
        );
      }

      if (options.tags) {
        options.dataAdapter = Utils.Decorate(options.dataAdapter, Tags);
      }

      if (options.tokenSeparators != null || options.tokenizer != null) {
        options.dataAdapter = Utils.Decorate(
          options.dataAdapter,
          Tokenizer
        );
      }

      if (options.query != null) {
        var Query = require(options.amdBase + 'compat/query');

        options.dataAdapter = Utils.Decorate(
          options.dataAdapter,
          Query
        );
      }

      if (options.initSelection != null) {
        var InitSelection = require(options.amdBase + 'compat/initSelection');

        options.dataAdapter = Utils.Decorate(
          options.dataAdapter,
          InitSelection
        );
      }
    }

    if (options.resultsAdapter == null) {
      options.resultsAdapter = ResultsList;

      if (options.ajax != null) {
        options.resultsAdapter = Utils.Decorate(
          options.resultsAdapter,
          InfiniteScroll
        );
      }

      if (options.placeholder != null) {
        options.resultsAdapter = Utils.Decorate(
          options.resultsAdapter,
          HidePlaceholder
        );
      }

      if (options.selectOnClose) {
        options.resultsAdapter = Utils.Decorate(
          options.resultsAdapter,
          SelectOnClose
        );
      }
    }

    if (options.dropdownAdapter == null) {
      if (options.multiple) {
        options.dropdownAdapter = Dropdown;
      } else {
        var SearchableDropdown = Utils.Decorate(Dropdown, DropdownSearch);

        options.dropdownAdapter = SearchableDropdown;
      }

      if (options.minimumResultsForSearch !== 0) {
        options.dropdownAdapter = Utils.Decorate(
          options.dropdownAdapter,
          MinimumResultsForSearch
        );
      }

      if (options.closeOnSelect) {
        options.dropdownAdapter = Utils.Decorate(
          options.dropdownAdapter,
          CloseOnSelect
        );
      }

      if (
        options.dropdownCssClass != null ||
        options.dropdownCss != null ||
        options.adaptDropdownCssClass != null
      ) {
        var DropdownCSS = require(options.amdBase + 'compat/dropdownCss');

        options.dropdownAdapter = Utils.Decorate(
          options.dropdownAdapter,
          DropdownCSS
        );
      }

      options.dropdownAdapter = Utils.Decorate(
        options.dropdownAdapter,
        AttachBody
      );
    }

    if (options.selectionAdapter == null) {
      if (options.multiple) {
        options.selectionAdapter = MultipleSelection;
      } else {
        options.selectionAdapter = SingleSelection;
      }

      // Add the placeholder mixin if a placeholder was specified
      if (options.placeholder != null) {
        options.selectionAdapter = Utils.Decorate(
          options.selectionAdapter,
          Placeholder
        );
      }

      if (options.allowClear) {
        options.selectionAdapter = Utils.Decorate(
          options.selectionAdapter,
          AllowClear
        );
      }

      if (options.multiple) {
        options.selectionAdapter = Utils.Decorate(
          options.selectionAdapter,
          SelectionSearch
        );
      }

      if (
        options.containerCssClass != null ||
        options.containerCss != null ||
        options.adaptContainerCssClass != null
      ) {
        var ContainerCSS = require(options.amdBase + 'compat/containerCss');

        options.selectionAdapter = Utils.Decorate(
          options.selectionAdapter,
          ContainerCSS
        );
      }

      options.selectionAdapter = Utils.Decorate(
        options.selectionAdapter,
        EventRelay
      );
    }

    if (typeof options.language === 'string') {
      // Check if the language is specified with a region
      if (options.language.indexOf('-') > 0) {
        // Extract the region information if it is included
        var languageParts = options.language.split('-');
        var baseLanguage = languageParts[0];

        options.language = [options.language, baseLanguage];
      } else {
        options.language = [options.language];
      }
    }

    if ($.isArray(options.language)) {
      var languages = new Translation();
      options.language.push('en');

      var languageNames = options.language;

      for (var l = 0; l < languageNames.length; l++) {
        var name = languageNames[l];
        var language = {};

        try {
          // Try to load it with the original name
          language = Translation.loadPath(name);
        } catch (e) {
          try {
            // If we couldn't load it, check if it wasn't the full path
            name = this.defaults.amdLanguageBase + name;
            language = Translation.loadPath(name);
          } catch (ex) {
            // The translation could not be loaded at all. Sometimes this is
            // because of a configuration problem, other times this can be
            // because of how Select2 helps load all possible translation files.
            if (options.debug && window.console && console.warn) {
              console.warn(
                'Select2: The language file for "' + name + '" could not be ' +
                'automatically loaded. A fallback will be used instead.'
              );
            }

            continue;
          }
        }

        languages.extend(language);
      }

      options.translations = languages;
    } else {
      var baseTranslation = Translation.loadPath(
        this.defaults.amdLanguageBase + 'en'
      );
      var customTranslation = new Translation(options.language);

      customTranslation.extend(baseTranslation);

      options.translations = customTranslation;
    }

    return options;
  };

  Defaults.prototype.reset = function () {
    function stripDiacritics (text) {
      // Used 'uni range + named function' from http://jsperf.com/diacritics/18
      function match(a) {
        return DIACRITICS[a] || a;
      }

      return text.replace(/[^\u0000-\u007E]/g, match);
    }

    function matcher (params, data) {
      // Always return the object if there is nothing to compare
      if ($.trim(params.term) === '') {
        return data;
      }

      // Do a recursive check for options with children
      if (data.children && data.children.length > 0) {
        // Clone the data object if there are children
        // This is required as we modify the object to remove any non-matches
        var match = $.extend(true, {}, data);

        // Check each child of the option
        for (var c = data.children.length - 1; c >= 0; c--) {
          var child = data.children[c];

          var matches = matcher(params, child);

          // If there wasn't a match, remove the object in the array
          if (matches == null) {
            match.children.splice(c, 1);
          }
        }

        // If any children matched, return the new object
        if (match.children.length > 0) {
          return match;
        }

        // If there were no matching children, check just the plain object
        return matcher(params, match);
      }

      var original = stripDiacritics(data.text).toUpperCase();
      var term = stripDiacritics(params.term).toUpperCase();

      // Check if the text contains the term
      if (original.indexOf(term) > -1) {
        return data;
      }

      // If it doesn't contain the term, don't return anything
      return null;
    }

    this.defaults = {
      amdBase: './',
      amdLanguageBase: './i18n/',
      closeOnSelect: true,
      debug: false,
      dropdownAutoWidth: false,
      escapeMarkup: Utils.escapeMarkup,
      language: EnglishTranslation,
      matcher: matcher,
      minimumInputLength: 0,
      maximumInputLength: 0,
      maximumSelectionLength: 0,
      minimumResultsForSearch: 0,
      selectOnClose: false,
      sorter: function (data) {
        return data;
      },
      templateResult: function (result) {
        return result.text;
      },
      templateSelection: function (selection) {
        return selection.text;
      },
      theme: 'default',
      width: 'resolve'
    };
  };

  Defaults.prototype.set = function (key, value) {
    var camelKey = $.camelCase(key);

    var data = {};
    data[camelKey] = value;

    var convertedData = Utils._convertData(data);

    $.extend(this.defaults, convertedData);
  };

  var defaults = new Defaults();

  return defaults;
});

S2.define('select2/options',[
  'require',
  'jquery',
  './defaults',
  './utils'
], function (require, $, Defaults, Utils) {
  function Options (options, $element) {
    this.options = options;

    if ($element != null) {
      this.fromElement($element);
    }

    this.options = Defaults.apply(this.options);

    if ($element && $element.is('input')) {
      var InputCompat = require(this.get('amdBase') + 'compat/inputData');

      this.options.dataAdapter = Utils.Decorate(
        this.options.dataAdapter,
        InputCompat
      );
    }
  }

  Options.prototype.fromElement = function ($e) {
    var excludedData = ['select2'];

    if (this.options.multiple == null) {
      this.options.multiple = $e.prop('multiple');
    }

    if (this.options.disabled == null) {
      this.options.disabled = $e.prop('disabled');
    }

    if (this.options.language == null) {
      if ($e.prop('lang')) {
        this.options.language = $e.prop('lang').toLowerCase();
      } else if ($e.closest('[lang]').prop('lang')) {
        this.options.language = $e.closest('[lang]').prop('lang');
      }
    }

    if (this.options.dir == null) {
      if ($e.prop('dir')) {
        this.options.dir = $e.prop('dir');
      } else if ($e.closest('[dir]').prop('dir')) {
        this.options.dir = $e.closest('[dir]').prop('dir');
      } else {
        this.options.dir = 'ltr';
      }
    }

    $e.prop('disabled', this.options.disabled);
    $e.prop('multiple', this.options.multiple);

    if ($e.data('select2Tags')) {
      if (this.options.debug && window.console && console.warn) {
        console.warn(
          'Select2: The `data-select2-tags` attribute has been changed to ' +
          'use the `data-data` and `data-tags="true"` attributes and will be ' +
          'removed in future versions of Select2.'
        );
      }

      $e.data('data', $e.data('select2Tags'));
      $e.data('tags', true);
    }

    if ($e.data('ajaxUrl')) {
      if (this.options.debug && window.console && console.warn) {
        console.warn(
          'Select2: The `data-ajax-url` attribute has been changed to ' +
          '`data-ajax--url` and support for the old attribute will be removed' +
          ' in future versions of Select2.'
        );
      }

      $e.attr('ajax--url', $e.data('ajaxUrl'));
      $e.data('ajax--url', $e.data('ajaxUrl'));
    }

    var dataset = {};

    // Prefer the element's `dataset` attribute if it exists
    // jQuery 1.x does not correctly handle data attributes with multiple dashes
    if ($.fn.jquery && $.fn.jquery.substr(0, 2) == '1.' && $e[0].dataset) {
      dataset = $.extend(true, {}, $e[0].dataset, $e.data());
    } else {
      dataset = $e.data();
    }

    var data = $.extend(true, {}, dataset);

    data = Utils._convertData(data);

    for (var key in data) {
      if ($.inArray(key, excludedData) > -1) {
        continue;
      }

      if ($.isPlainObject(this.options[key])) {
        $.extend(this.options[key], data[key]);
      } else {
        this.options[key] = data[key];
      }
    }

    return this;
  };

  Options.prototype.get = function (key) {
    return this.options[key];
  };

  Options.prototype.set = function (key, val) {
    this.options[key] = val;
  };

  return Options;
});

S2.define('select2/core',[
  'jquery',
  './options',
  './utils',
  './keys'
], function ($, Options, Utils, KEYS) {
  var Select2 = function ($element, options) {
    if ($element.data('select2') != null) {
      $element.data('select2').destroy();
    }

    this.$element = $element;

    this.id = this._generateId($element);

    options = options || {};

    this.options = new Options(options, $element);

    Select2.__super__.constructor.call(this);

    // Set up the tabindex

    var tabindex = $element.attr('tabindex') || 0;
    $element.data('old-tabindex', tabindex);
    $element.attr('tabindex', '-1');

    // Set up containers and adapters

    var DataAdapter = this.options.get('dataAdapter');
    this.dataAdapter = new DataAdapter($element, this.options);

    var $container = this.render();

    this._placeContainer($container);

    var SelectionAdapter = this.options.get('selectionAdapter');
    this.selection = new SelectionAdapter($element, this.options);
    this.$selection = this.selection.render();

    this.selection.position(this.$selection, $container);

    var DropdownAdapter = this.options.get('dropdownAdapter');
    this.dropdown = new DropdownAdapter($element, this.options);
    this.$dropdown = this.dropdown.render();

    this.dropdown.position(this.$dropdown, $container);

    var ResultsAdapter = this.options.get('resultsAdapter');
    this.results = new ResultsAdapter($element, this.options, this.dataAdapter);
    this.$results = this.results.render();

    this.results.position(this.$results, this.$dropdown);

    // Bind events

    var self = this;

    // Bind the container to all of the adapters
    this._bindAdapters();

    // Register any DOM event handlers
    this._registerDomEvents();

    // Register any internal event handlers
    this._registerDataEvents();
    this._registerSelectionEvents();
    this._registerDropdownEvents();
    this._registerResultsEvents();
    this._registerEvents();

    // Set the initial state
    this.dataAdapter.current(function (initialData) {
      self.trigger('selection:update', {
        data: initialData
      });
    });

    // Hide the original select
    $element.addClass('select2-hidden-accessible');
    $element.attr('aria-hidden', 'true');

    // Synchronize any monitored attributes
    this._syncAttributes();

    $element.data('select2', this);
  };

  Utils.Extend(Select2, Utils.Observable);

  Select2.prototype._generateId = function ($element) {
    var id = '';

    if ($element.attr('id') != null) {
      id = $element.attr('id');
    } else if ($element.attr('name') != null) {
      id = $element.attr('name') + '-' + Utils.generateChars(2);
    } else {
      id = Utils.generateChars(4);
    }

    id = id.replace(/(:|\.|\[|\]|,)/g, '');
    id = 'select2-' + id;

    return id;
  };

  Select2.prototype._placeContainer = function ($container) {
    $container.insertAfter(this.$element);

    var width = this._resolveWidth(this.$element, this.options.get('width'));

    if (width != null) {
      $container.css('width', width);
    }
  };

  Select2.prototype._resolveWidth = function ($element, method) {
    var WIDTH = /^width:(([-+]?([0-9]*\.)?[0-9]+)(px|em|ex|%|in|cm|mm|pt|pc))/i;

    if (method == 'resolve') {
      var styleWidth = this._resolveWidth($element, 'style');

      if (styleWidth != null) {
        return styleWidth;
      }

      return this._resolveWidth($element, 'element');
    }

    if (method == 'element') {
      var elementWidth = $element.outerWidth(false);

      if (elementWidth <= 0) {
        return 'auto';
      }

      return elementWidth + 'px';
    }

    if (method == 'style') {
      var style = $element.attr('style');

      if (typeof(style) !== 'string') {
        return null;
      }

      var attrs = style.split(';');

      for (var i = 0, l = attrs.length; i < l; i = i + 1) {
        var attr = attrs[i].replace(/\s/g, '');
        var matches = attr.match(WIDTH);

        if (matches !== null && matches.length >= 1) {
          return matches[1];
        }
      }

      return null;
    }

    return method;
  };

  Select2.prototype._bindAdapters = function () {
    this.dataAdapter.bind(this, this.$container);
    this.selection.bind(this, this.$container);

    this.dropdown.bind(this, this.$container);
    this.results.bind(this, this.$container);
  };

  Select2.prototype._registerDomEvents = function () {
    var self = this;

    this.$element.on('change.select2', function () {
      self.dataAdapter.current(function (data) {
        self.trigger('selection:update', {
          data: data
        });
      });
    });

    this.$element.on('focus.select2', function (evt) {
      self.trigger('focus', evt);
    });

    this._syncA = Utils.bind(this._syncAttributes, this);
    this._syncS = Utils.bind(this._syncSubtree, this);

    if (this.$element[0].attachEvent) {
      this.$element[0].attachEvent('onpropertychange', this._syncA);
    }

    var observer = window.MutationObserver ||
      window.WebKitMutationObserver ||
      window.MozMutationObserver
    ;

    if (observer != null) {
      this._observer = new observer(function (mutations) {
        $.each(mutations, self._syncA);
        $.each(mutations, self._syncS);
      });
      this._observer.observe(this.$element[0], {
        attributes: true,
        childList: true,
        subtree: false
      });
    } else if (this.$element[0].addEventListener) {
      this.$element[0].addEventListener(
        'DOMAttrModified',
        self._syncA,
        false
      );
      this.$element[0].addEventListener(
        'DOMNodeInserted',
        self._syncS,
        false
      );
      this.$element[0].addEventListener(
        'DOMNodeRemoved',
        self._syncS,
        false
      );
    }
  };

  Select2.prototype._registerDataEvents = function () {
    var self = this;

    this.dataAdapter.on('*', function (name, params) {
      self.trigger(name, params);
    });
  };

  Select2.prototype._registerSelectionEvents = function () {
    var self = this;
    var nonRelayEvents = ['toggle', 'focus'];

    this.selection.on('toggle', function () {
      self.toggleDropdown();
    });

    this.selection.on('focus', function (params) {
      self.focus(params);
    });

    this.selection.on('*', function (name, params) {
      if ($.inArray(name, nonRelayEvents) !== -1) {
        return;
      }

      self.trigger(name, params);
    });
  };

  Select2.prototype._registerDropdownEvents = function () {
    var self = this;

    this.dropdown.on('*', function (name, params) {
      self.trigger(name, params);
    });
  };

  Select2.prototype._registerResultsEvents = function () {
    var self = this;

    this.results.on('*', function (name, params) {
      self.trigger(name, params);
    });
  };

  Select2.prototype._registerEvents = function () {
    var self = this;

    this.on('open', function () {
      self.$container.addClass('select2-container--open');
    });

    this.on('close', function () {
      self.$container.removeClass('select2-container--open');
    });

    this.on('enable', function () {
      self.$container.removeClass('select2-container--disabled');
    });

    this.on('disable', function () {
      self.$container.addClass('select2-container--disabled');
    });

    this.on('blur', function () {
      self.$container.removeClass('select2-container--focus');
    });

    this.on('query', function (params) {
      if (!self.isOpen()) {
        self.trigger('open', {});
      }

      this.dataAdapter.query(params, function (data) {
        self.trigger('results:all', {
          data: data,
          query: params
        });
      });
    });

    this.on('query:append', function (params) {
      this.dataAdapter.query(params, function (data) {
        self.trigger('results:append', {
          data: data,
          query: params
        });
      });
    });

    this.on('keypress', function (evt) {
      var key = evt.which;

      if (self.isOpen()) {
        if (key === KEYS.ESC || key === KEYS.TAB ||
            (key === KEYS.UP && evt.altKey)) {
          self.close();

          evt.preventDefault();
        } else if (key === KEYS.ENTER) {
          self.trigger('results:select', {});

          evt.preventDefault();
        } else if ((key === KEYS.SPACE && evt.ctrlKey)) {
          self.trigger('results:toggle', {});

          evt.preventDefault();
        } else if (key === KEYS.UP) {
          self.trigger('results:previous', {});

          evt.preventDefault();
        } else if (key === KEYS.DOWN) {
          self.trigger('results:next', {});

          evt.preventDefault();
        }
      } else {
        if (key === KEYS.ENTER || key === KEYS.SPACE ||
            (key === KEYS.DOWN && evt.altKey)) {
          self.open();

          evt.preventDefault();
        }
      }
    });
  };

  Select2.prototype._syncAttributes = function () {
    this.options.set('disabled', this.$element.prop('disabled'));

    if (this.options.get('disabled')) {
      if (this.isOpen()) {
        this.close();
      }

      this.trigger('disable', {});
    } else {
      this.trigger('enable', {});
    }
  };

  Select2.prototype._syncSubtree = function (evt, mutations) {
    var changed = false;
    var self = this;

    // Ignore any mutation events raised for elements that aren't options or
    // optgroups. This handles the case when the select element is destroyed
    if (
      evt && evt.target && (
        evt.target.nodeName !== 'OPTION' && evt.target.nodeName !== 'OPTGROUP'
      )
    ) {
      return;
    }

    if (!mutations) {
      // If mutation events aren't supported, then we can only assume that the
      // change affected the selections
      changed = true;
    } else if (mutations.addedNodes && mutations.addedNodes.length > 0) {
      for (var n = 0; n < mutations.addedNodes.length; n++) {
        var node = mutations.addedNodes[n];

        if (node.selected) {
          changed = true;
        }
      }
    } else if (mutations.removedNodes && mutations.removedNodes.length > 0) {
      changed = true;
    }

    // Only re-pull the data if we think there is a change
    if (changed) {
      this.dataAdapter.current(function (currentData) {
        self.trigger('selection:update', {
          data: currentData
        });
      });
    }
  };

  /**
   * Override the trigger method to automatically trigger pre-events when
   * there are events that can be prevented.
   */
  Select2.prototype.trigger = function (name, args) {
    var actualTrigger = Select2.__super__.trigger;
    var preTriggerMap = {
      'open': 'opening',
      'close': 'closing',
      'select': 'selecting',
      'unselect': 'unselecting'
    };

    if (args === undefined) {
      args = {};
    }

    if (name in preTriggerMap) {
      var preTriggerName = preTriggerMap[name];
      var preTriggerArgs = {
        prevented: false,
        name: name,
        args: args
      };

      actualTrigger.call(this, preTriggerName, preTriggerArgs);

      if (preTriggerArgs.prevented) {
        args.prevented = true;

        return;
      }
    }

    actualTrigger.call(this, name, args);
  };

  Select2.prototype.toggleDropdown = function () {
    if (this.options.get('disabled')) {
      return;
    }

    if (this.isOpen()) {
      this.close();
    } else {
      this.open();
    }
  };

  Select2.prototype.open = function () {
    if (this.isOpen()) {
      return;
    }

    this.trigger('query', {});
  };

  Select2.prototype.close = function () {
    if (!this.isOpen()) {
      return;
    }

    this.trigger('close', {});
  };

  Select2.prototype.isOpen = function () {
    return this.$container.hasClass('select2-container--open');
  };

  Select2.prototype.hasFocus = function () {
    return this.$container.hasClass('select2-container--focus');
  };

  Select2.prototype.focus = function (data) {
    // No need to re-trigger focus events if we are already focused
    if (this.hasFocus()) {
      return;
    }

    this.$container.addClass('select2-container--focus');
    this.trigger('focus', {});
  };

  Select2.prototype.enable = function (args) {
    if (this.options.get('debug') && window.console && console.warn) {
      console.warn(
        'Select2: The `select2("enable")` method has been deprecated and will' +
        ' be removed in later Select2 versions. Use $element.prop("disabled")' +
        ' instead.'
      );
    }

    if (args == null || args.length === 0) {
      args = [true];
    }

    var disabled = !args[0];

    this.$element.prop('disabled', disabled);
  };

  Select2.prototype.data = function () {
    if (this.options.get('debug') &&
        arguments.length > 0 && window.console && console.warn) {
      console.warn(
        'Select2: Data can no longer be set using `select2("data")`. You ' +
        'should consider setting the value instead using `$element.val()`.'
      );
    }

    var data = [];

    this.dataAdapter.current(function (currentData) {
      data = currentData;
    });

    return data;
  };

  Select2.prototype.val = function (args) {
    if (this.options.get('debug') && window.console && console.warn) {
      console.warn(
        'Select2: The `select2("val")` method has been deprecated and will be' +
        ' removed in later Select2 versions. Use $element.val() instead.'
      );
    }

    if (args == null || args.length === 0) {
      return this.$element.val();
    }

    var newVal = args[0];

    if ($.isArray(newVal)) {
      newVal = $.map(newVal, function (obj) {
        return obj.toString();
      });
    }

    this.$element.val(newVal).trigger('change');
  };

  Select2.prototype.destroy = function () {
    this.$container.remove();

    if (this.$element[0].detachEvent) {
      this.$element[0].detachEvent('onpropertychange', this._syncA);
    }

    if (this._observer != null) {
      this._observer.disconnect();
      this._observer = null;
    } else if (this.$element[0].removeEventListener) {
      this.$element[0]
        .removeEventListener('DOMAttrModified', this._syncA, false);
      this.$element[0]
        .removeEventListener('DOMNodeInserted', this._syncS, false);
      this.$element[0]
        .removeEventListener('DOMNodeRemoved', this._syncS, false);
    }

    this._syncA = null;
    this._syncS = null;

    this.$element.off('.select2');
    this.$element.attr('tabindex', this.$element.data('old-tabindex'));

    this.$element.removeClass('select2-hidden-accessible');
    this.$element.attr('aria-hidden', 'false');
    this.$element.removeData('select2');

    this.dataAdapter.destroy();
    this.selection.destroy();
    this.dropdown.destroy();
    this.results.destroy();

    this.dataAdapter = null;
    this.selection = null;
    this.dropdown = null;
    this.results = null;
  };

  Select2.prototype.render = function () {
    var $container = $(
      '<span class="select2 select2-container">' +
        '<span class="selection"></span>' +
        '<span class="dropdown-wrapper" aria-hidden="true"></span>' +
      '</span>'
    );

    $container.attr('dir', this.options.get('dir'));

    this.$container = $container;

    this.$container.addClass('select2-container--' + this.options.get('theme'));

    $container.data('element', this.$element);

    return $container;
  };

  return Select2;
});

S2.define('jquery-mousewheel',[
  'jquery'
], function ($) {
  // Used to shim jQuery.mousewheel for non-full builds.
  return $;
});

S2.define('jquery.select2',[
  'jquery',
  'jquery-mousewheel',

  './select2/core',
  './select2/defaults'
], function ($, _, Select2, Defaults) {
  if ($.fn.select2 == null) {
    // All methods that should return the element
    var thisMethods = ['open', 'close', 'destroy'];

    $.fn.select2 = function (options) {
      options = options || {};

      if (typeof options === 'object') {
        this.each(function () {
          var instanceOptions = $.extend(true, {}, options);

          var instance = new Select2($(this), instanceOptions);
        });

        return this;
      } else if (typeof options === 'string') {
        var ret;
        var args = Array.prototype.slice.call(arguments, 1);

        this.each(function () {
          var instance = $(this).data('select2');

          if (instance == null && window.console && console.error) {
            console.error(
              'The select2(\'' + options + '\') method was called on an ' +
              'element that is not using Select2.'
            );
          }

          ret = instance[options].apply(instance, args);
        });

        // Check if we should be returning `this`
        if ($.inArray(options, thisMethods) > -1) {
          return this;
        }

        return ret;
      } else {
        throw new Error('Invalid arguments for Select2: ' + options);
      }
    };
  }

  if ($.fn.select2.defaults == null) {
    $.fn.select2.defaults = Defaults;
  }

  return Select2;
});

  // Return the AMD loader configuration so it can be used outside of this file
  return {
    define: S2.define,
    require: S2.require
  };
}());

  // Autoload the jQuery bindings
  // We know that all of the modules exist above this, so we're safe
  var select2 = S2.require('jquery.select2');

  // Hold the AMD module references on the jQuery function that was just loaded
  // This allows Select2 to use the internal loader outside of this file, such
  // as in the language files.
  jQuery.fn.select2.amd = S2;

  // Return the Select2 instance for anyone who is importing it.
  return select2;
}));

/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ }),

/***/ "./node_modules/select2/src/scss/core.scss":
/*!*************************************************!*\
  !*** ./node_modules/select2/src/scss/core.scss ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// extracted by mini-css-extract-plugin

/***/ })

}]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvc2VsZWN0Mi9kaXN0L2pzL3NlbGVjdDIuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL3NlbGVjdDIvc3JjL3Njc3MvY29yZS5zY3NzPzdkODMiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7O0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLE1BQU0sSUFBMEM7QUFDaEQ7QUFDQSxJQUFJLGlDQUFPLENBQUMseUVBQVEsQ0FBQyxvQ0FBRSxPQUFPO0FBQUE7QUFBQTtBQUFBLG9HQUFDO0FBQy9CLEdBQUcsTUFBTSxFQXFCTjtBQUNILENBQUM7QUFDRDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxPQUFPLGNBQWM7QUFDckIsVUFBVSxTQUFTLEVBQUUsT0FBTyxjQUFjO0FBQzFDO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLG9CQUFvQjtBQUNwQixvQkFBb0I7QUFDcEIsbUJBQW1CO0FBQ25CLHFCQUFxQjtBQUNyQjtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLGVBQWUsT0FBTztBQUN0QixlQUFlLE9BQU87QUFDdEI7QUFDQSxpQkFBaUIsT0FBTztBQUN4QjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBLHVCQUF1QixpQkFBaUI7QUFDeEM7QUFDQTtBQUNBO0FBQ0E7QUFDQSxpQkFBaUI7QUFDakI7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxxQkFBcUI7QUFDckI7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBLHNDQUFzQyxPQUFPO0FBQzdDOztBQUVBO0FBQ0E7QUFDQTtBQUNBLDhDQUE4QyxPQUFPO0FBQ3JEOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsYUFBYTtBQUNiO0FBQ0E7QUFDQSxTQUFTO0FBQ1Q7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsU0FBUztBQUNUO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsYUFBYTtBQUNiLDBDQUEwQztBQUMxQztBQUNBLFNBQVM7QUFDVDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsdUJBQXVCLGlCQUFpQjtBQUN4QztBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLGlCQUFpQjtBQUNqQjtBQUNBO0FBQ0E7QUFDQSxpQkFBaUI7QUFDakI7QUFDQTtBQUNBLGlCQUFpQjtBQUNqQjtBQUNBO0FBQ0E7QUFDQSxpQkFBaUI7QUFDakIsdUZBQXVGO0FBQ3ZGO0FBQ0EsaUJBQWlCO0FBQ2pCO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLGlCQUFpQjtBQUNqQjtBQUNBO0FBQ0E7QUFDQTtBQUNBLFNBQVM7QUFDVDtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxTQUFTO0FBQ1Q7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxhQUFhO0FBQ2I7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLFNBQVM7QUFDVDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsYUFBYTtBQUNiOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxDQUFDOztBQUVELHlCQUF5QixxQkFBcUI7QUFDOUM7QUFDQSxDQUFDO0FBQ0QsZ0NBQWdDOztBQUVoQztBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxDQUFDOztBQUVEO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0Esc0JBQXNCOztBQUV0QjtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBOztBQUVBOztBQUVBLG1CQUFtQix5QkFBeUI7QUFDNUM7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUEsbUJBQW1CLDZCQUE2QjtBQUNoRDs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLEtBQUs7QUFDTDtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxvQkFBb0I7QUFDcEI7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSwyQ0FBMkMsU0FBUztBQUNwRDtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQSxtQkFBbUIsWUFBWTtBQUMvQjtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUEscUJBQXFCLGlCQUFpQjtBQUN0Qzs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0Esa0JBQWtCO0FBQ2xCLGlCQUFpQjtBQUNqQixnQkFBZ0I7QUFDaEIsZ0JBQWdCO0FBQ2hCLGtCQUFrQjtBQUNsQixrQkFBa0I7QUFDbEIsaUJBQWlCO0FBQ2pCOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxPQUFPOztBQUVQO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBLENBQUM7O0FBRUQ7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsU0FBUztBQUNUOztBQUVBO0FBQ0E7O0FBRUE7O0FBRUEsbUJBQW1CLHlCQUF5QjtBQUM1Qzs7QUFFQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7QUFDTDtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsT0FBTzs7QUFFUDtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxTQUFTO0FBQ1Q7QUFDQTtBQUNBLE9BQU87O0FBRVAsS0FBSztBQUNMOztBQUVBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBOztBQUVBLHFCQUFxQiwwQkFBMEI7QUFDL0M7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0EsT0FBTzs7QUFFUDs7QUFFQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7O0FBRUw7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7QUFDQTtBQUNBLEtBQUs7O0FBRUw7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLEtBQUs7O0FBRUw7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLEtBQUs7O0FBRUw7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLEtBQUs7O0FBRUw7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7O0FBRUw7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxLQUFLOztBQUVMO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0EsZ0NBQWdDO0FBQ2hDLE9BQU87QUFDUDtBQUNBO0FBQ0EsU0FBUztBQUNUO0FBQ0EsS0FBSzs7QUFFTDtBQUNBOztBQUVBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0EsT0FBTztBQUNQO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7O0FBRUE7O0FBRUE7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLE9BQU87QUFDUDtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxTQUFTO0FBQ1Q7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLE9BQU87QUFDUDs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLFdBQVc7QUFDWCxTQUFTO0FBQ1Qsa0NBQWtDO0FBQ2xDOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsT0FBTztBQUNQLEtBQUs7O0FBRUw7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsT0FBTztBQUNQLEtBQUs7QUFDTDs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLEtBQUs7QUFDTDtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQSxLQUFLO0FBQ0w7QUFDQTtBQUNBOztBQUVBO0FBQ0EsQ0FBQzs7QUFFRDs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0EsQ0FBQzs7QUFFRDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQTs7QUFFQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBLEtBQUs7O0FBRUw7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBLEtBQUs7O0FBRUw7QUFDQTtBQUNBLEtBQUs7O0FBRUw7QUFDQTtBQUNBLEtBQUs7QUFDTDs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0EsS0FBSztBQUNMOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTs7QUFFQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBLE9BQU87QUFDUCxLQUFLO0FBQ0w7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxDQUFDOztBQUVEO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxPQUFPO0FBQ1AsS0FBSzs7QUFFTDtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7O0FBRUw7QUFDQTtBQUNBLEtBQUs7QUFDTDs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxDQUFDOztBQUVEO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLE9BQU87QUFDUCxLQUFLOztBQUVMO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxTQUFTO0FBQ1Q7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLGtCQUFrQjtBQUNsQjtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQSxtQkFBbUIsaUJBQWlCO0FBQ3BDOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTs7QUFFQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQSxDQUFDOztBQUVEO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTtBQUNBLENBQUM7O0FBRUQ7QUFDQTtBQUNBO0FBQ0E7QUFDQSwwQkFBMEI7O0FBRTFCO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTs7QUFFQSxtQkFBbUIsaUJBQWlCO0FBQ3BDO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQSw2QkFBNkI7QUFDN0I7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0EsZ0JBQWdCO0FBQ2hCO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0EsQ0FBQzs7QUFFRDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTs7QUFFQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBLEtBQUs7O0FBRUw7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7O0FBRUE7QUFDQSxLQUFLOztBQUVMO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7O0FBRUE7O0FBRUE7O0FBRUE7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTs7QUFFQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxPQUFPO0FBQ1A7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0EsQ0FBQzs7QUFFRDtBQUNBO0FBQ0E7QUFDQSwwQkFBMEI7O0FBRTFCO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLE9BQU87O0FBRVA7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxLQUFLO0FBQ0w7O0FBRUE7QUFDQSxDQUFDOztBQUVEO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSwyQkFBMkI7QUFDM0I7O0FBRUE7O0FBRUE7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBLENBQUM7O0FBRUQ7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBLENBQUM7O0FBRUQ7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxDQUFDOztBQUVEO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTs7QUFFQTtBQUNBLEtBQUs7O0FBRUw7QUFDQTs7QUFFQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBLHVCQUF1QixpQkFBaUI7QUFDeEM7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLE9BQU87QUFDUCxLQUFLO0FBQ0w7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUEscUJBQXFCLHdCQUF3QjtBQUM3Qzs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBLEtBQUs7QUFDTDs7QUFFQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7QUFDTDs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0EsS0FBSztBQUNMOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7QUFDTDs7QUFFQTtBQUNBO0FBQ0EsT0FBTztBQUNQO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7QUFDTDtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUEscUJBQXFCLHNCQUFzQjtBQUMzQzs7QUFFQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBLHNCQUFzQjtBQUN0QjtBQUNBLEtBQUs7O0FBRUw7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUEsc0JBQXNCO0FBQ3RCOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBLENBQUM7O0FBRUQ7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsS0FBSzs7QUFFTDs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUEsbUJBQW1CLGlCQUFpQjtBQUNwQzs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSx1Q0FBdUM7O0FBRXZDOztBQUVBOztBQUVBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBLENBQUM7O0FBRUQ7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsMEJBQTBCO0FBQzFCO0FBQ0EsU0FBUztBQUNULE9BQU87QUFDUDtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBLHNCQUFzQjtBQUN0Qjs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxPQUFPO0FBQ1A7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0EsU0FBUztBQUNULE9BQU87O0FBRVA7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBLEtBQUs7QUFDTDtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxDQUFDOztBQUVEO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBLHFCQUFxQixpQkFBaUI7QUFDdEM7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUEscUJBQXFCLGlCQUFpQjtBQUN0Qzs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLFdBQVc7QUFDWDs7QUFFQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBLEtBQUs7QUFDTDs7QUFFQTtBQUNBLENBQUM7O0FBRUQ7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLE9BQU87O0FBRVA7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxPQUFPO0FBQ1A7O0FBRUE7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQSxrQ0FBa0M7QUFDbEM7QUFDQSxPQUFPOztBQUVQOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0EsQ0FBQzs7QUFFRDs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxPQUFPOztBQUVQO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBLENBQUM7O0FBRUQ7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxPQUFPOztBQUVQO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBLENBQUM7O0FBRUQ7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLFdBQVc7QUFDWDtBQUNBO0FBQ0E7QUFDQSxPQUFPO0FBQ1A7O0FBRUE7QUFDQSxDQUFDOztBQUVEO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBLENBQUM7O0FBRUQ7QUFDQTtBQUNBO0FBQ0E7QUFDQSxzQkFBc0I7O0FBRXRCO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTtBQUNBLEtBQUs7O0FBRUw7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQSxPQUFPO0FBQ1AsS0FBSzs7QUFFTDtBQUNBOztBQUVBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7O0FBRUw7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxTQUFTO0FBQ1Q7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0EsT0FBTztBQUNQOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0EsQ0FBQzs7QUFFRDs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBLGlDQUFpQyxRQUFRO0FBQ3pDOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQSxDQUFDOztBQUVEO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7O0FBRUw7QUFDQTtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7O0FBRUE7QUFDQTs7QUFFQSw0QkFBNEIsR0FBRyxRQUFROztBQUV2Qzs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTtBQUNBLENBQUM7O0FBRUQ7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxTQUFTOztBQUVUO0FBQ0E7QUFDQTtBQUNBLFNBQVM7QUFDVDtBQUNBLEtBQUs7O0FBRUw7QUFDQTtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0EsS0FBSztBQUNMOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLE9BQU87QUFDUCxLQUFLOztBQUVMO0FBQ0E7QUFDQTtBQUNBLEtBQUs7O0FBRUw7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBOztBQUVBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBLENBQUM7O0FBRUQ7O0FBRUE7QUFDQTtBQUNBOztBQUVBLG1CQUFtQixpQkFBaUI7QUFDcEM7O0FBRUE7QUFDQTtBQUNBLE9BQU87QUFDUDtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQSxDQUFDOztBQUVEOztBQUVBO0FBQ0EsNkJBQTZCOztBQUU3QjtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0EsS0FBSztBQUNMOztBQUVBO0FBQ0EsQ0FBQzs7QUFFRDs7QUFFQTtBQUNBLDZCQUE2Qjs7QUFFN0I7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0EsS0FBSztBQUNMOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMOztBQUVBO0FBQ0EsQ0FBQzs7QUFFRDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQSxLQUFLO0FBQ0w7QUFDQTtBQUNBLEtBQUs7QUFDTDtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBLEtBQUs7QUFDTDtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsQ0FBQzs7QUFFRDtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTs7QUFFQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBLCtCQUErQjs7QUFFL0I7QUFDQTtBQUNBO0FBQ0EsT0FBTztBQUNQO0FBQ0EsT0FBTztBQUNQO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLE9BQU87QUFDUDs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxPQUFPO0FBQ1A7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0EsT0FBTztBQUNQO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUEscUJBQXFCLDBCQUEwQjtBQUMvQztBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLFNBQVM7QUFDVDtBQUNBO0FBQ0E7QUFDQTtBQUNBLFdBQVc7QUFDWDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQSxLQUFLO0FBQ0w7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQSxxQ0FBcUM7O0FBRXJDO0FBQ0EsOENBQThDLFFBQVE7QUFDdEQ7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxPQUFPO0FBQ1A7QUFDQTtBQUNBLE9BQU87QUFDUDtBQUNBO0FBQ0EsT0FBTztBQUNQO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTs7QUFFQTtBQUNBOztBQUVBOztBQUVBO0FBQ0EsQ0FBQzs7QUFFRDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsT0FBTztBQUNQO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxPQUFPO0FBQ1A7QUFDQSxPQUFPO0FBQ1A7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBO0FBQ0EsaUNBQWlDO0FBQ2pDLEtBQUs7QUFDTDtBQUNBOztBQUVBLGdDQUFnQzs7QUFFaEM7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLE9BQU87QUFDUDtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0EsQ0FBQzs7QUFFRDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTs7QUFFQTs7QUFFQTs7QUFFQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTs7QUFFQTs7QUFFQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsT0FBTztBQUNQLEtBQUs7O0FBRUw7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7QUFDQSxLQUFLO0FBQ0w7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQSxnQ0FBZ0M7O0FBRWhDLHVDQUF1QyxPQUFPO0FBQzlDO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLFNBQVM7QUFDVCxPQUFPO0FBQ1AsS0FBSzs7QUFFTDtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLE9BQU87QUFDUDtBQUNBO0FBQ0E7QUFDQTtBQUNBLE9BQU87QUFDUCxLQUFLO0FBQ0w7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0EsS0FBSztBQUNMOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLEtBQUs7QUFDTDs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0EsK0JBQStCO0FBQy9COztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsU0FBUztBQUNULE9BQU87QUFDUCxLQUFLOztBQUVMO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxTQUFTO0FBQ1QsT0FBTztBQUNQLEtBQUs7O0FBRUw7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBLFNBQVM7QUFDVCwyQ0FBMkM7O0FBRTNDO0FBQ0EsU0FBUztBQUNULDJDQUEyQzs7QUFFM0M7QUFDQSxTQUFTO0FBQ1QsNkNBQTZDOztBQUU3QztBQUNBLFNBQVM7QUFDVCx5Q0FBeUM7O0FBRXpDO0FBQ0E7QUFDQSxPQUFPO0FBQ1A7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7QUFDTDs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBLGdDQUFnQztBQUNoQyxLQUFLO0FBQ0wsK0JBQStCO0FBQy9CO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7QUFDTCxxQkFBcUIsaUNBQWlDO0FBQ3REOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLFNBQVM7QUFDVCxPQUFPO0FBQ1A7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLEtBQUs7QUFDTDtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUEsNEJBQTRCO0FBQzVCOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBLDRCQUE0QjtBQUM1Qjs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSw0QkFBNEI7QUFDNUI7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQSxLQUFLOztBQUVMO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLE9BQU87QUFDUDs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7QUFDTDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7O0FBRUE7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTtBQUNBLENBQUM7O0FBRUQ7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLENBQUM7O0FBRUQ7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxpREFBaUQ7O0FBRWpEO0FBQ0EsU0FBUzs7QUFFVDtBQUNBLE9BQU87QUFDUDtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0EsU0FBUzs7QUFFVDtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBLE9BQU87QUFDUDtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxDQUFDOztBQUVEO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxDQUFDOztBQUVEO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0EsQ0FBQzs7Ozs7Ozs7Ozs7OztBQ2puTEQsdUMiLCJmaWxlIjoidmVuZG9yc35zZWxlY3QyLmpzIiwic291cmNlc0NvbnRlbnQiOlsiLyohXG4gKiBTZWxlY3QyIDQuMC41XG4gKiBodHRwczovL3NlbGVjdDIuZ2l0aHViLmlvXG4gKlxuICogUmVsZWFzZWQgdW5kZXIgdGhlIE1JVCBsaWNlbnNlXG4gKiBodHRwczovL2dpdGh1Yi5jb20vc2VsZWN0Mi9zZWxlY3QyL2Jsb2IvbWFzdGVyL0xJQ0VOU0UubWRcbiAqL1xuKGZ1bmN0aW9uIChmYWN0b3J5KSB7XG4gIGlmICh0eXBlb2YgZGVmaW5lID09PSAnZnVuY3Rpb24nICYmIGRlZmluZS5hbWQpIHtcbiAgICAvLyBBTUQuIFJlZ2lzdGVyIGFzIGFuIGFub255bW91cyBtb2R1bGUuXG4gICAgZGVmaW5lKFsnanF1ZXJ5J10sIGZhY3RvcnkpO1xuICB9IGVsc2UgaWYgKHR5cGVvZiBtb2R1bGUgPT09ICdvYmplY3QnICYmIG1vZHVsZS5leHBvcnRzKSB7XG4gICAgLy8gTm9kZS9Db21tb25KU1xuICAgIG1vZHVsZS5leHBvcnRzID0gZnVuY3Rpb24gKHJvb3QsIGpRdWVyeSkge1xuICAgICAgaWYgKGpRdWVyeSA9PT0gdW5kZWZpbmVkKSB7XG4gICAgICAgIC8vIHJlcXVpcmUoJ2pRdWVyeScpIHJldHVybnMgYSBmYWN0b3J5IHRoYXQgcmVxdWlyZXMgd2luZG93IHRvXG4gICAgICAgIC8vIGJ1aWxkIGEgalF1ZXJ5IGluc3RhbmNlLCB3ZSBub3JtYWxpemUgaG93IHdlIHVzZSBtb2R1bGVzXG4gICAgICAgIC8vIHRoYXQgcmVxdWlyZSB0aGlzIHBhdHRlcm4gYnV0IHRoZSB3aW5kb3cgcHJvdmlkZWQgaXMgYSBub29wXG4gICAgICAgIC8vIGlmIGl0J3MgZGVmaW5lZCAoaG93IGpxdWVyeSB3b3JrcylcbiAgICAgICAgaWYgKHR5cGVvZiB3aW5kb3cgIT09ICd1bmRlZmluZWQnKSB7XG4gICAgICAgICAgalF1ZXJ5ID0gcmVxdWlyZSgnanF1ZXJ5Jyk7XG4gICAgICAgIH1cbiAgICAgICAgZWxzZSB7XG4gICAgICAgICAgalF1ZXJ5ID0gcmVxdWlyZSgnanF1ZXJ5Jykocm9vdCk7XG4gICAgICAgIH1cbiAgICAgIH1cbiAgICAgIGZhY3RvcnkoalF1ZXJ5KTtcbiAgICAgIHJldHVybiBqUXVlcnk7XG4gICAgfTtcbiAgfSBlbHNlIHtcbiAgICAvLyBCcm93c2VyIGdsb2JhbHNcbiAgICBmYWN0b3J5KGpRdWVyeSk7XG4gIH1cbn0gKGZ1bmN0aW9uIChqUXVlcnkpIHtcbiAgLy8gVGhpcyBpcyBuZWVkZWQgc28gd2UgY2FuIGNhdGNoIHRoZSBBTUQgbG9hZGVyIGNvbmZpZ3VyYXRpb24gYW5kIHVzZSBpdFxuICAvLyBUaGUgaW5uZXIgZmlsZSBzaG91bGQgYmUgd3JhcHBlZCAoYnkgYGJhbm5lci5zdGFydC5qc2ApIGluIGEgZnVuY3Rpb24gdGhhdFxuICAvLyByZXR1cm5zIHRoZSBBTUQgbG9hZGVyIHJlZmVyZW5jZXMuXG4gIHZhciBTMiA9KGZ1bmN0aW9uICgpIHtcbiAgLy8gUmVzdG9yZSB0aGUgU2VsZWN0MiBBTUQgbG9hZGVyIHNvIGl0IGNhbiBiZSB1c2VkXG4gIC8vIE5lZWRlZCBtb3N0bHkgaW4gdGhlIGxhbmd1YWdlIGZpbGVzLCB3aGVyZSB0aGUgbG9hZGVyIGlzIG5vdCBpbnNlcnRlZFxuICBpZiAoalF1ZXJ5ICYmIGpRdWVyeS5mbiAmJiBqUXVlcnkuZm4uc2VsZWN0MiAmJiBqUXVlcnkuZm4uc2VsZWN0Mi5hbWQpIHtcbiAgICB2YXIgUzIgPSBqUXVlcnkuZm4uc2VsZWN0Mi5hbWQ7XG4gIH1cbnZhciBTMjsoZnVuY3Rpb24gKCkgeyBpZiAoIVMyIHx8ICFTMi5yZXF1aXJlanMpIHtcbmlmICghUzIpIHsgUzIgPSB7fTsgfSBlbHNlIHsgcmVxdWlyZSA9IFMyOyB9XG4vKipcbiAqIEBsaWNlbnNlIGFsbW9uZCAwLjMuMyBDb3B5cmlnaHQgalF1ZXJ5IEZvdW5kYXRpb24gYW5kIG90aGVyIGNvbnRyaWJ1dG9ycy5cbiAqIFJlbGVhc2VkIHVuZGVyIE1JVCBsaWNlbnNlLCBodHRwOi8vZ2l0aHViLmNvbS9yZXF1aXJlanMvYWxtb25kL0xJQ0VOU0VcbiAqL1xuLy9Hb2luZyBzbG9wcHkgdG8gYXZvaWQgJ3VzZSBzdHJpY3QnIHN0cmluZyBjb3N0LCBidXQgc3RyaWN0IHByYWN0aWNlcyBzaG91bGRcbi8vYmUgZm9sbG93ZWQuXG4vKmdsb2JhbCBzZXRUaW1lb3V0OiBmYWxzZSAqL1xuXG52YXIgcmVxdWlyZWpzLCByZXF1aXJlLCBkZWZpbmU7XG4oZnVuY3Rpb24gKHVuZGVmKSB7XG4gICAgdmFyIG1haW4sIHJlcSwgbWFrZU1hcCwgaGFuZGxlcnMsXG4gICAgICAgIGRlZmluZWQgPSB7fSxcbiAgICAgICAgd2FpdGluZyA9IHt9LFxuICAgICAgICBjb25maWcgPSB7fSxcbiAgICAgICAgZGVmaW5pbmcgPSB7fSxcbiAgICAgICAgaGFzT3duID0gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eSxcbiAgICAgICAgYXBzID0gW10uc2xpY2UsXG4gICAgICAgIGpzU3VmZml4UmVnRXhwID0gL1xcLmpzJC87XG5cbiAgICBmdW5jdGlvbiBoYXNQcm9wKG9iaiwgcHJvcCkge1xuICAgICAgICByZXR1cm4gaGFzT3duLmNhbGwob2JqLCBwcm9wKTtcbiAgICB9XG5cbiAgICAvKipcbiAgICAgKiBHaXZlbiBhIHJlbGF0aXZlIG1vZHVsZSBuYW1lLCBsaWtlIC4vc29tZXRoaW5nLCBub3JtYWxpemUgaXQgdG9cbiAgICAgKiBhIHJlYWwgbmFtZSB0aGF0IGNhbiBiZSBtYXBwZWQgdG8gYSBwYXRoLlxuICAgICAqIEBwYXJhbSB7U3RyaW5nfSBuYW1lIHRoZSByZWxhdGl2ZSBuYW1lXG4gICAgICogQHBhcmFtIHtTdHJpbmd9IGJhc2VOYW1lIGEgcmVhbCBuYW1lIHRoYXQgdGhlIG5hbWUgYXJnIGlzIHJlbGF0aXZlXG4gICAgICogdG8uXG4gICAgICogQHJldHVybnMge1N0cmluZ30gbm9ybWFsaXplZCBuYW1lXG4gICAgICovXG4gICAgZnVuY3Rpb24gbm9ybWFsaXplKG5hbWUsIGJhc2VOYW1lKSB7XG4gICAgICAgIHZhciBuYW1lUGFydHMsIG5hbWVTZWdtZW50LCBtYXBWYWx1ZSwgZm91bmRNYXAsIGxhc3RJbmRleCxcbiAgICAgICAgICAgIGZvdW5kSSwgZm91bmRTdGFyTWFwLCBzdGFySSwgaSwgaiwgcGFydCwgbm9ybWFsaXplZEJhc2VQYXJ0cyxcbiAgICAgICAgICAgIGJhc2VQYXJ0cyA9IGJhc2VOYW1lICYmIGJhc2VOYW1lLnNwbGl0KFwiL1wiKSxcbiAgICAgICAgICAgIG1hcCA9IGNvbmZpZy5tYXAsXG4gICAgICAgICAgICBzdGFyTWFwID0gKG1hcCAmJiBtYXBbJyonXSkgfHwge307XG5cbiAgICAgICAgLy9BZGp1c3QgYW55IHJlbGF0aXZlIHBhdGhzLlxuICAgICAgICBpZiAobmFtZSkge1xuICAgICAgICAgICAgbmFtZSA9IG5hbWUuc3BsaXQoJy8nKTtcbiAgICAgICAgICAgIGxhc3RJbmRleCA9IG5hbWUubGVuZ3RoIC0gMTtcblxuICAgICAgICAgICAgLy8gSWYgd2FudGluZyBub2RlIElEIGNvbXBhdGliaWxpdHksIHN0cmlwIC5qcyBmcm9tIGVuZFxuICAgICAgICAgICAgLy8gb2YgSURzLiBIYXZlIHRvIGRvIHRoaXMgaGVyZSwgYW5kIG5vdCBpbiBuYW1lVG9VcmxcbiAgICAgICAgICAgIC8vIGJlY2F1c2Ugbm9kZSBhbGxvd3MgZWl0aGVyIC5qcyBvciBub24gLmpzIHRvIG1hcFxuICAgICAgICAgICAgLy8gdG8gc2FtZSBmaWxlLlxuICAgICAgICAgICAgaWYgKGNvbmZpZy5ub2RlSWRDb21wYXQgJiYganNTdWZmaXhSZWdFeHAudGVzdChuYW1lW2xhc3RJbmRleF0pKSB7XG4gICAgICAgICAgICAgICAgbmFtZVtsYXN0SW5kZXhdID0gbmFtZVtsYXN0SW5kZXhdLnJlcGxhY2UoanNTdWZmaXhSZWdFeHAsICcnKTtcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgLy8gU3RhcnRzIHdpdGggYSAnLicgc28gbmVlZCB0aGUgYmFzZU5hbWVcbiAgICAgICAgICAgIGlmIChuYW1lWzBdLmNoYXJBdCgwKSA9PT0gJy4nICYmIGJhc2VQYXJ0cykge1xuICAgICAgICAgICAgICAgIC8vQ29udmVydCBiYXNlTmFtZSB0byBhcnJheSwgYW5kIGxvcCBvZmYgdGhlIGxhc3QgcGFydCxcbiAgICAgICAgICAgICAgICAvL3NvIHRoYXQgLiBtYXRjaGVzIHRoYXQgJ2RpcmVjdG9yeScgYW5kIG5vdCBuYW1lIG9mIHRoZSBiYXNlTmFtZSdzXG4gICAgICAgICAgICAgICAgLy9tb2R1bGUuIEZvciBpbnN0YW5jZSwgYmFzZU5hbWUgb2YgJ29uZS90d28vdGhyZWUnLCBtYXBzIHRvXG4gICAgICAgICAgICAgICAgLy8nb25lL3R3by90aHJlZS5qcycsIGJ1dCB3ZSB3YW50IHRoZSBkaXJlY3RvcnksICdvbmUvdHdvJyBmb3JcbiAgICAgICAgICAgICAgICAvL3RoaXMgbm9ybWFsaXphdGlvbi5cbiAgICAgICAgICAgICAgICBub3JtYWxpemVkQmFzZVBhcnRzID0gYmFzZVBhcnRzLnNsaWNlKDAsIGJhc2VQYXJ0cy5sZW5ndGggLSAxKTtcbiAgICAgICAgICAgICAgICBuYW1lID0gbm9ybWFsaXplZEJhc2VQYXJ0cy5jb25jYXQobmFtZSk7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIC8vc3RhcnQgdHJpbURvdHNcbiAgICAgICAgICAgIGZvciAoaSA9IDA7IGkgPCBuYW1lLmxlbmd0aDsgaSsrKSB7XG4gICAgICAgICAgICAgICAgcGFydCA9IG5hbWVbaV07XG4gICAgICAgICAgICAgICAgaWYgKHBhcnQgPT09ICcuJykge1xuICAgICAgICAgICAgICAgICAgICBuYW1lLnNwbGljZShpLCAxKTtcbiAgICAgICAgICAgICAgICAgICAgaSAtPSAxO1xuICAgICAgICAgICAgICAgIH0gZWxzZSBpZiAocGFydCA9PT0gJy4uJykge1xuICAgICAgICAgICAgICAgICAgICAvLyBJZiBhdCB0aGUgc3RhcnQsIG9yIHByZXZpb3VzIHZhbHVlIGlzIHN0aWxsIC4uLFxuICAgICAgICAgICAgICAgICAgICAvLyBrZWVwIHRoZW0gc28gdGhhdCB3aGVuIGNvbnZlcnRlZCB0byBhIHBhdGggaXQgbWF5XG4gICAgICAgICAgICAgICAgICAgIC8vIHN0aWxsIHdvcmsgd2hlbiBjb252ZXJ0ZWQgdG8gYSBwYXRoLCBldmVuIHRob3VnaFxuICAgICAgICAgICAgICAgICAgICAvLyBhcyBhbiBJRCBpdCBpcyBsZXNzIHRoYW4gaWRlYWwuIEluIGxhcmdlciBwb2ludFxuICAgICAgICAgICAgICAgICAgICAvLyByZWxlYXNlcywgbWF5IGJlIGJldHRlciB0byBqdXN0IGtpY2sgb3V0IGFuIGVycm9yLlxuICAgICAgICAgICAgICAgICAgICBpZiAoaSA9PT0gMCB8fCAoaSA9PT0gMSAmJiBuYW1lWzJdID09PSAnLi4nKSB8fCBuYW1lW2kgLSAxXSA9PT0gJy4uJykge1xuICAgICAgICAgICAgICAgICAgICAgICAgY29udGludWU7XG4gICAgICAgICAgICAgICAgICAgIH0gZWxzZSBpZiAoaSA+IDApIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIG5hbWUuc3BsaWNlKGkgLSAxLCAyKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIGkgLT0gMjtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIC8vZW5kIHRyaW1Eb3RzXG5cbiAgICAgICAgICAgIG5hbWUgPSBuYW1lLmpvaW4oJy8nKTtcbiAgICAgICAgfVxuXG4gICAgICAgIC8vQXBwbHkgbWFwIGNvbmZpZyBpZiBhdmFpbGFibGUuXG4gICAgICAgIGlmICgoYmFzZVBhcnRzIHx8IHN0YXJNYXApICYmIG1hcCkge1xuICAgICAgICAgICAgbmFtZVBhcnRzID0gbmFtZS5zcGxpdCgnLycpO1xuXG4gICAgICAgICAgICBmb3IgKGkgPSBuYW1lUGFydHMubGVuZ3RoOyBpID4gMDsgaSAtPSAxKSB7XG4gICAgICAgICAgICAgICAgbmFtZVNlZ21lbnQgPSBuYW1lUGFydHMuc2xpY2UoMCwgaSkuam9pbihcIi9cIik7XG5cbiAgICAgICAgICAgICAgICBpZiAoYmFzZVBhcnRzKSB7XG4gICAgICAgICAgICAgICAgICAgIC8vRmluZCB0aGUgbG9uZ2VzdCBiYXNlTmFtZSBzZWdtZW50IG1hdGNoIGluIHRoZSBjb25maWcuXG4gICAgICAgICAgICAgICAgICAgIC8vU28sIGRvIGpvaW5zIG9uIHRoZSBiaWdnZXN0IHRvIHNtYWxsZXN0IGxlbmd0aHMgb2YgYmFzZVBhcnRzLlxuICAgICAgICAgICAgICAgICAgICBmb3IgKGogPSBiYXNlUGFydHMubGVuZ3RoOyBqID4gMDsgaiAtPSAxKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICBtYXBWYWx1ZSA9IG1hcFtiYXNlUGFydHMuc2xpY2UoMCwgaikuam9pbignLycpXTtcblxuICAgICAgICAgICAgICAgICAgICAgICAgLy9iYXNlTmFtZSBzZWdtZW50IGhhcyAgY29uZmlnLCBmaW5kIGlmIGl0IGhhcyBvbmUgZm9yXG4gICAgICAgICAgICAgICAgICAgICAgICAvL3RoaXMgbmFtZS5cbiAgICAgICAgICAgICAgICAgICAgICAgIGlmIChtYXBWYWx1ZSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG1hcFZhbHVlID0gbWFwVmFsdWVbbmFtZVNlZ21lbnRdO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmIChtYXBWYWx1ZSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAvL01hdGNoLCB1cGRhdGUgbmFtZSB0byB0aGUgbmV3IHZhbHVlLlxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBmb3VuZE1hcCA9IG1hcFZhbHVlO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBmb3VuZEkgPSBpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBicmVhaztcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9XG5cbiAgICAgICAgICAgICAgICBpZiAoZm91bmRNYXApIHtcbiAgICAgICAgICAgICAgICAgICAgYnJlYWs7XG4gICAgICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICAgICAgLy9DaGVjayBmb3IgYSBzdGFyIG1hcCBtYXRjaCwgYnV0IGp1c3QgaG9sZCBvbiB0byBpdCxcbiAgICAgICAgICAgICAgICAvL2lmIHRoZXJlIGlzIGEgc2hvcnRlciBzZWdtZW50IG1hdGNoIGxhdGVyIGluIGEgbWF0Y2hpbmdcbiAgICAgICAgICAgICAgICAvL2NvbmZpZywgdGhlbiBmYXZvciBvdmVyIHRoaXMgc3RhciBtYXAuXG4gICAgICAgICAgICAgICAgaWYgKCFmb3VuZFN0YXJNYXAgJiYgc3Rhck1hcCAmJiBzdGFyTWFwW25hbWVTZWdtZW50XSkge1xuICAgICAgICAgICAgICAgICAgICBmb3VuZFN0YXJNYXAgPSBzdGFyTWFwW25hbWVTZWdtZW50XTtcbiAgICAgICAgICAgICAgICAgICAgc3RhckkgPSBpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgaWYgKCFmb3VuZE1hcCAmJiBmb3VuZFN0YXJNYXApIHtcbiAgICAgICAgICAgICAgICBmb3VuZE1hcCA9IGZvdW5kU3Rhck1hcDtcbiAgICAgICAgICAgICAgICBmb3VuZEkgPSBzdGFySTtcbiAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgaWYgKGZvdW5kTWFwKSB7XG4gICAgICAgICAgICAgICAgbmFtZVBhcnRzLnNwbGljZSgwLCBmb3VuZEksIGZvdW5kTWFwKTtcbiAgICAgICAgICAgICAgICBuYW1lID0gbmFtZVBhcnRzLmpvaW4oJy8nKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuXG4gICAgICAgIHJldHVybiBuYW1lO1xuICAgIH1cblxuICAgIGZ1bmN0aW9uIG1ha2VSZXF1aXJlKHJlbE5hbWUsIGZvcmNlU3luYykge1xuICAgICAgICByZXR1cm4gZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgLy9BIHZlcnNpb24gb2YgYSByZXF1aXJlIGZ1bmN0aW9uIHRoYXQgcGFzc2VzIGEgbW9kdWxlTmFtZVxuICAgICAgICAgICAgLy92YWx1ZSBmb3IgaXRlbXMgdGhhdCBtYXkgbmVlZCB0b1xuICAgICAgICAgICAgLy9sb29rIHVwIHBhdGhzIHJlbGF0aXZlIHRvIHRoZSBtb2R1bGVOYW1lXG4gICAgICAgICAgICB2YXIgYXJncyA9IGFwcy5jYWxsKGFyZ3VtZW50cywgMCk7XG5cbiAgICAgICAgICAgIC8vSWYgZmlyc3QgYXJnIGlzIG5vdCByZXF1aXJlKCdzdHJpbmcnKSwgYW5kIHRoZXJlIGlzIG9ubHlcbiAgICAgICAgICAgIC8vb25lIGFyZywgaXQgaXMgdGhlIGFycmF5IGZvcm0gd2l0aG91dCBhIGNhbGxiYWNrLiBJbnNlcnRcbiAgICAgICAgICAgIC8vYSBudWxsIHNvIHRoYXQgdGhlIGZvbGxvd2luZyBjb25jYXQgaXMgY29ycmVjdC5cbiAgICAgICAgICAgIGlmICh0eXBlb2YgYXJnc1swXSAhPT0gJ3N0cmluZycgJiYgYXJncy5sZW5ndGggPT09IDEpIHtcbiAgICAgICAgICAgICAgICBhcmdzLnB1c2gobnVsbCk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICByZXR1cm4gcmVxLmFwcGx5KHVuZGVmLCBhcmdzLmNvbmNhdChbcmVsTmFtZSwgZm9yY2VTeW5jXSkpO1xuICAgICAgICB9O1xuICAgIH1cblxuICAgIGZ1bmN0aW9uIG1ha2VOb3JtYWxpemUocmVsTmFtZSkge1xuICAgICAgICByZXR1cm4gZnVuY3Rpb24gKG5hbWUpIHtcbiAgICAgICAgICAgIHJldHVybiBub3JtYWxpemUobmFtZSwgcmVsTmFtZSk7XG4gICAgICAgIH07XG4gICAgfVxuXG4gICAgZnVuY3Rpb24gbWFrZUxvYWQoZGVwTmFtZSkge1xuICAgICAgICByZXR1cm4gZnVuY3Rpb24gKHZhbHVlKSB7XG4gICAgICAgICAgICBkZWZpbmVkW2RlcE5hbWVdID0gdmFsdWU7XG4gICAgICAgIH07XG4gICAgfVxuXG4gICAgZnVuY3Rpb24gY2FsbERlcChuYW1lKSB7XG4gICAgICAgIGlmIChoYXNQcm9wKHdhaXRpbmcsIG5hbWUpKSB7XG4gICAgICAgICAgICB2YXIgYXJncyA9IHdhaXRpbmdbbmFtZV07XG4gICAgICAgICAgICBkZWxldGUgd2FpdGluZ1tuYW1lXTtcbiAgICAgICAgICAgIGRlZmluaW5nW25hbWVdID0gdHJ1ZTtcbiAgICAgICAgICAgIG1haW4uYXBwbHkodW5kZWYsIGFyZ3MpO1xuICAgICAgICB9XG5cbiAgICAgICAgaWYgKCFoYXNQcm9wKGRlZmluZWQsIG5hbWUpICYmICFoYXNQcm9wKGRlZmluaW5nLCBuYW1lKSkge1xuICAgICAgICAgICAgdGhyb3cgbmV3IEVycm9yKCdObyAnICsgbmFtZSk7XG4gICAgICAgIH1cbiAgICAgICAgcmV0dXJuIGRlZmluZWRbbmFtZV07XG4gICAgfVxuXG4gICAgLy9UdXJucyBhIHBsdWdpbiFyZXNvdXJjZSB0byBbcGx1Z2luLCByZXNvdXJjZV1cbiAgICAvL3dpdGggdGhlIHBsdWdpbiBiZWluZyB1bmRlZmluZWQgaWYgdGhlIG5hbWVcbiAgICAvL2RpZCBub3QgaGF2ZSBhIHBsdWdpbiBwcmVmaXguXG4gICAgZnVuY3Rpb24gc3BsaXRQcmVmaXgobmFtZSkge1xuICAgICAgICB2YXIgcHJlZml4LFxuICAgICAgICAgICAgaW5kZXggPSBuYW1lID8gbmFtZS5pbmRleE9mKCchJykgOiAtMTtcbiAgICAgICAgaWYgKGluZGV4ID4gLTEpIHtcbiAgICAgICAgICAgIHByZWZpeCA9IG5hbWUuc3Vic3RyaW5nKDAsIGluZGV4KTtcbiAgICAgICAgICAgIG5hbWUgPSBuYW1lLnN1YnN0cmluZyhpbmRleCArIDEsIG5hbWUubGVuZ3RoKTtcbiAgICAgICAgfVxuICAgICAgICByZXR1cm4gW3ByZWZpeCwgbmFtZV07XG4gICAgfVxuXG4gICAgLy9DcmVhdGVzIGEgcGFydHMgYXJyYXkgZm9yIGEgcmVsTmFtZSB3aGVyZSBmaXJzdCBwYXJ0IGlzIHBsdWdpbiBJRCxcbiAgICAvL3NlY29uZCBwYXJ0IGlzIHJlc291cmNlIElELiBBc3N1bWVzIHJlbE5hbWUgaGFzIGFscmVhZHkgYmVlbiBub3JtYWxpemVkLlxuICAgIGZ1bmN0aW9uIG1ha2VSZWxQYXJ0cyhyZWxOYW1lKSB7XG4gICAgICAgIHJldHVybiByZWxOYW1lID8gc3BsaXRQcmVmaXgocmVsTmFtZSkgOiBbXTtcbiAgICB9XG5cbiAgICAvKipcbiAgICAgKiBNYWtlcyBhIG5hbWUgbWFwLCBub3JtYWxpemluZyB0aGUgbmFtZSwgYW5kIHVzaW5nIGEgcGx1Z2luXG4gICAgICogZm9yIG5vcm1hbGl6YXRpb24gaWYgbmVjZXNzYXJ5LiBHcmFicyBhIHJlZiB0byBwbHVnaW5cbiAgICAgKiB0b28sIGFzIGFuIG9wdGltaXphdGlvbi5cbiAgICAgKi9cbiAgICBtYWtlTWFwID0gZnVuY3Rpb24gKG5hbWUsIHJlbFBhcnRzKSB7XG4gICAgICAgIHZhciBwbHVnaW4sXG4gICAgICAgICAgICBwYXJ0cyA9IHNwbGl0UHJlZml4KG5hbWUpLFxuICAgICAgICAgICAgcHJlZml4ID0gcGFydHNbMF0sXG4gICAgICAgICAgICByZWxSZXNvdXJjZU5hbWUgPSByZWxQYXJ0c1sxXTtcblxuICAgICAgICBuYW1lID0gcGFydHNbMV07XG5cbiAgICAgICAgaWYgKHByZWZpeCkge1xuICAgICAgICAgICAgcHJlZml4ID0gbm9ybWFsaXplKHByZWZpeCwgcmVsUmVzb3VyY2VOYW1lKTtcbiAgICAgICAgICAgIHBsdWdpbiA9IGNhbGxEZXAocHJlZml4KTtcbiAgICAgICAgfVxuXG4gICAgICAgIC8vTm9ybWFsaXplIGFjY29yZGluZ1xuICAgICAgICBpZiAocHJlZml4KSB7XG4gICAgICAgICAgICBpZiAocGx1Z2luICYmIHBsdWdpbi5ub3JtYWxpemUpIHtcbiAgICAgICAgICAgICAgICBuYW1lID0gcGx1Z2luLm5vcm1hbGl6ZShuYW1lLCBtYWtlTm9ybWFsaXplKHJlbFJlc291cmNlTmFtZSkpO1xuICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICBuYW1lID0gbm9ybWFsaXplKG5hbWUsIHJlbFJlc291cmNlTmFtZSk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICBuYW1lID0gbm9ybWFsaXplKG5hbWUsIHJlbFJlc291cmNlTmFtZSk7XG4gICAgICAgICAgICBwYXJ0cyA9IHNwbGl0UHJlZml4KG5hbWUpO1xuICAgICAgICAgICAgcHJlZml4ID0gcGFydHNbMF07XG4gICAgICAgICAgICBuYW1lID0gcGFydHNbMV07XG4gICAgICAgICAgICBpZiAocHJlZml4KSB7XG4gICAgICAgICAgICAgICAgcGx1Z2luID0gY2FsbERlcChwcmVmaXgpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9XG5cbiAgICAgICAgLy9Vc2luZyByaWRpY3Vsb3VzIHByb3BlcnR5IG5hbWVzIGZvciBzcGFjZSByZWFzb25zXG4gICAgICAgIHJldHVybiB7XG4gICAgICAgICAgICBmOiBwcmVmaXggPyBwcmVmaXggKyAnIScgKyBuYW1lIDogbmFtZSwgLy9mdWxsTmFtZVxuICAgICAgICAgICAgbjogbmFtZSxcbiAgICAgICAgICAgIHByOiBwcmVmaXgsXG4gICAgICAgICAgICBwOiBwbHVnaW5cbiAgICAgICAgfTtcbiAgICB9O1xuXG4gICAgZnVuY3Rpb24gbWFrZUNvbmZpZyhuYW1lKSB7XG4gICAgICAgIHJldHVybiBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICByZXR1cm4gKGNvbmZpZyAmJiBjb25maWcuY29uZmlnICYmIGNvbmZpZy5jb25maWdbbmFtZV0pIHx8IHt9O1xuICAgICAgICB9O1xuICAgIH1cblxuICAgIGhhbmRsZXJzID0ge1xuICAgICAgICByZXF1aXJlOiBmdW5jdGlvbiAobmFtZSkge1xuICAgICAgICAgICAgcmV0dXJuIG1ha2VSZXF1aXJlKG5hbWUpO1xuICAgICAgICB9LFxuICAgICAgICBleHBvcnRzOiBmdW5jdGlvbiAobmFtZSkge1xuICAgICAgICAgICAgdmFyIGUgPSBkZWZpbmVkW25hbWVdO1xuICAgICAgICAgICAgaWYgKHR5cGVvZiBlICE9PSAndW5kZWZpbmVkJykge1xuICAgICAgICAgICAgICAgIHJldHVybiBlO1xuICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICByZXR1cm4gKGRlZmluZWRbbmFtZV0gPSB7fSk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH0sXG4gICAgICAgIG1vZHVsZTogZnVuY3Rpb24gKG5hbWUpIHtcbiAgICAgICAgICAgIHJldHVybiB7XG4gICAgICAgICAgICAgICAgaWQ6IG5hbWUsXG4gICAgICAgICAgICAgICAgdXJpOiAnJyxcbiAgICAgICAgICAgICAgICBleHBvcnRzOiBkZWZpbmVkW25hbWVdLFxuICAgICAgICAgICAgICAgIGNvbmZpZzogbWFrZUNvbmZpZyhuYW1lKVxuICAgICAgICAgICAgfTtcbiAgICAgICAgfVxuICAgIH07XG5cbiAgICBtYWluID0gZnVuY3Rpb24gKG5hbWUsIGRlcHMsIGNhbGxiYWNrLCByZWxOYW1lKSB7XG4gICAgICAgIHZhciBjanNNb2R1bGUsIGRlcE5hbWUsIHJldCwgbWFwLCBpLCByZWxQYXJ0cyxcbiAgICAgICAgICAgIGFyZ3MgPSBbXSxcbiAgICAgICAgICAgIGNhbGxiYWNrVHlwZSA9IHR5cGVvZiBjYWxsYmFjayxcbiAgICAgICAgICAgIHVzaW5nRXhwb3J0cztcblxuICAgICAgICAvL1VzZSBuYW1lIGlmIG5vIHJlbE5hbWVcbiAgICAgICAgcmVsTmFtZSA9IHJlbE5hbWUgfHwgbmFtZTtcbiAgICAgICAgcmVsUGFydHMgPSBtYWtlUmVsUGFydHMocmVsTmFtZSk7XG5cbiAgICAgICAgLy9DYWxsIHRoZSBjYWxsYmFjayB0byBkZWZpbmUgdGhlIG1vZHVsZSwgaWYgbmVjZXNzYXJ5LlxuICAgICAgICBpZiAoY2FsbGJhY2tUeXBlID09PSAndW5kZWZpbmVkJyB8fCBjYWxsYmFja1R5cGUgPT09ICdmdW5jdGlvbicpIHtcbiAgICAgICAgICAgIC8vUHVsbCBvdXQgdGhlIGRlZmluZWQgZGVwZW5kZW5jaWVzIGFuZCBwYXNzIHRoZSBvcmRlcmVkXG4gICAgICAgICAgICAvL3ZhbHVlcyB0byB0aGUgY2FsbGJhY2suXG4gICAgICAgICAgICAvL0RlZmF1bHQgdG8gW3JlcXVpcmUsIGV4cG9ydHMsIG1vZHVsZV0gaWYgbm8gZGVwc1xuICAgICAgICAgICAgZGVwcyA9ICFkZXBzLmxlbmd0aCAmJiBjYWxsYmFjay5sZW5ndGggPyBbJ3JlcXVpcmUnLCAnZXhwb3J0cycsICdtb2R1bGUnXSA6IGRlcHM7XG4gICAgICAgICAgICBmb3IgKGkgPSAwOyBpIDwgZGVwcy5sZW5ndGg7IGkgKz0gMSkge1xuICAgICAgICAgICAgICAgIG1hcCA9IG1ha2VNYXAoZGVwc1tpXSwgcmVsUGFydHMpO1xuICAgICAgICAgICAgICAgIGRlcE5hbWUgPSBtYXAuZjtcblxuICAgICAgICAgICAgICAgIC8vRmFzdCBwYXRoIENvbW1vbkpTIHN0YW5kYXJkIGRlcGVuZGVuY2llcy5cbiAgICAgICAgICAgICAgICBpZiAoZGVwTmFtZSA9PT0gXCJyZXF1aXJlXCIpIHtcbiAgICAgICAgICAgICAgICAgICAgYXJnc1tpXSA9IGhhbmRsZXJzLnJlcXVpcmUobmFtZSk7XG4gICAgICAgICAgICAgICAgfSBlbHNlIGlmIChkZXBOYW1lID09PSBcImV4cG9ydHNcIikge1xuICAgICAgICAgICAgICAgICAgICAvL0NvbW1vbkpTIG1vZHVsZSBzcGVjIDEuMVxuICAgICAgICAgICAgICAgICAgICBhcmdzW2ldID0gaGFuZGxlcnMuZXhwb3J0cyhuYW1lKTtcbiAgICAgICAgICAgICAgICAgICAgdXNpbmdFeHBvcnRzID0gdHJ1ZTtcbiAgICAgICAgICAgICAgICB9IGVsc2UgaWYgKGRlcE5hbWUgPT09IFwibW9kdWxlXCIpIHtcbiAgICAgICAgICAgICAgICAgICAgLy9Db21tb25KUyBtb2R1bGUgc3BlYyAxLjFcbiAgICAgICAgICAgICAgICAgICAgY2pzTW9kdWxlID0gYXJnc1tpXSA9IGhhbmRsZXJzLm1vZHVsZShuYW1lKTtcbiAgICAgICAgICAgICAgICB9IGVsc2UgaWYgKGhhc1Byb3AoZGVmaW5lZCwgZGVwTmFtZSkgfHxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgIGhhc1Byb3Aod2FpdGluZywgZGVwTmFtZSkgfHxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgIGhhc1Byb3AoZGVmaW5pbmcsIGRlcE5hbWUpKSB7XG4gICAgICAgICAgICAgICAgICAgIGFyZ3NbaV0gPSBjYWxsRGVwKGRlcE5hbWUpO1xuICAgICAgICAgICAgICAgIH0gZWxzZSBpZiAobWFwLnApIHtcbiAgICAgICAgICAgICAgICAgICAgbWFwLnAubG9hZChtYXAubiwgbWFrZVJlcXVpcmUocmVsTmFtZSwgdHJ1ZSksIG1ha2VMb2FkKGRlcE5hbWUpLCB7fSk7XG4gICAgICAgICAgICAgICAgICAgIGFyZ3NbaV0gPSBkZWZpbmVkW2RlcE5hbWVdO1xuICAgICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgICAgIHRocm93IG5ldyBFcnJvcihuYW1lICsgJyBtaXNzaW5nICcgKyBkZXBOYW1lKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIHJldCA9IGNhbGxiYWNrID8gY2FsbGJhY2suYXBwbHkoZGVmaW5lZFtuYW1lXSwgYXJncykgOiB1bmRlZmluZWQ7XG5cbiAgICAgICAgICAgIGlmIChuYW1lKSB7XG4gICAgICAgICAgICAgICAgLy9JZiBzZXR0aW5nIGV4cG9ydHMgdmlhIFwibW9kdWxlXCIgaXMgaW4gcGxheSxcbiAgICAgICAgICAgICAgICAvL2Zhdm9yIHRoYXQgb3ZlciByZXR1cm4gdmFsdWUgYW5kIGV4cG9ydHMuIEFmdGVyIHRoYXQsXG4gICAgICAgICAgICAgICAgLy9mYXZvciBhIG5vbi11bmRlZmluZWQgcmV0dXJuIHZhbHVlIG92ZXIgZXhwb3J0cyB1c2UuXG4gICAgICAgICAgICAgICAgaWYgKGNqc01vZHVsZSAmJiBjanNNb2R1bGUuZXhwb3J0cyAhPT0gdW5kZWYgJiZcbiAgICAgICAgICAgICAgICAgICAgICAgIGNqc01vZHVsZS5leHBvcnRzICE9PSBkZWZpbmVkW25hbWVdKSB7XG4gICAgICAgICAgICAgICAgICAgIGRlZmluZWRbbmFtZV0gPSBjanNNb2R1bGUuZXhwb3J0cztcbiAgICAgICAgICAgICAgICB9IGVsc2UgaWYgKHJldCAhPT0gdW5kZWYgfHwgIXVzaW5nRXhwb3J0cykge1xuICAgICAgICAgICAgICAgICAgICAvL1VzZSB0aGUgcmV0dXJuIHZhbHVlIGZyb20gdGhlIGZ1bmN0aW9uLlxuICAgICAgICAgICAgICAgICAgICBkZWZpbmVkW25hbWVdID0gcmV0O1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cbiAgICAgICAgfSBlbHNlIGlmIChuYW1lKSB7XG4gICAgICAgICAgICAvL01heSBqdXN0IGJlIGFuIG9iamVjdCBkZWZpbml0aW9uIGZvciB0aGUgbW9kdWxlLiBPbmx5XG4gICAgICAgICAgICAvL3dvcnJ5IGFib3V0IGRlZmluaW5nIGlmIGhhdmUgYSBtb2R1bGUgbmFtZS5cbiAgICAgICAgICAgIGRlZmluZWRbbmFtZV0gPSBjYWxsYmFjaztcbiAgICAgICAgfVxuICAgIH07XG5cbiAgICByZXF1aXJlanMgPSByZXF1aXJlID0gcmVxID0gZnVuY3Rpb24gKGRlcHMsIGNhbGxiYWNrLCByZWxOYW1lLCBmb3JjZVN5bmMsIGFsdCkge1xuICAgICAgICBpZiAodHlwZW9mIGRlcHMgPT09IFwic3RyaW5nXCIpIHtcbiAgICAgICAgICAgIGlmIChoYW5kbGVyc1tkZXBzXSkge1xuICAgICAgICAgICAgICAgIC8vY2FsbGJhY2sgaW4gdGhpcyBjYXNlIGlzIHJlYWxseSByZWxOYW1lXG4gICAgICAgICAgICAgICAgcmV0dXJuIGhhbmRsZXJzW2RlcHNdKGNhbGxiYWNrKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIC8vSnVzdCByZXR1cm4gdGhlIG1vZHVsZSB3YW50ZWQuIEluIHRoaXMgc2NlbmFyaW8sIHRoZVxuICAgICAgICAgICAgLy9kZXBzIGFyZyBpcyB0aGUgbW9kdWxlIG5hbWUsIGFuZCBzZWNvbmQgYXJnIChpZiBwYXNzZWQpXG4gICAgICAgICAgICAvL2lzIGp1c3QgdGhlIHJlbE5hbWUuXG4gICAgICAgICAgICAvL05vcm1hbGl6ZSBtb2R1bGUgbmFtZSwgaWYgaXQgY29udGFpbnMgLiBvciAuLlxuICAgICAgICAgICAgcmV0dXJuIGNhbGxEZXAobWFrZU1hcChkZXBzLCBtYWtlUmVsUGFydHMoY2FsbGJhY2spKS5mKTtcbiAgICAgICAgfSBlbHNlIGlmICghZGVwcy5zcGxpY2UpIHtcbiAgICAgICAgICAgIC8vZGVwcyBpcyBhIGNvbmZpZyBvYmplY3QsIG5vdCBhbiBhcnJheS5cbiAgICAgICAgICAgIGNvbmZpZyA9IGRlcHM7XG4gICAgICAgICAgICBpZiAoY29uZmlnLmRlcHMpIHtcbiAgICAgICAgICAgICAgICByZXEoY29uZmlnLmRlcHMsIGNvbmZpZy5jYWxsYmFjayk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBpZiAoIWNhbGxiYWNrKSB7XG4gICAgICAgICAgICAgICAgcmV0dXJuO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBpZiAoY2FsbGJhY2suc3BsaWNlKSB7XG4gICAgICAgICAgICAgICAgLy9jYWxsYmFjayBpcyBhbiBhcnJheSwgd2hpY2ggbWVhbnMgaXQgaXMgYSBkZXBlbmRlbmN5IGxpc3QuXG4gICAgICAgICAgICAgICAgLy9BZGp1c3QgYXJncyBpZiB0aGVyZSBhcmUgZGVwZW5kZW5jaWVzXG4gICAgICAgICAgICAgICAgZGVwcyA9IGNhbGxiYWNrO1xuICAgICAgICAgICAgICAgIGNhbGxiYWNrID0gcmVsTmFtZTtcbiAgICAgICAgICAgICAgICByZWxOYW1lID0gbnVsbDtcbiAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgZGVwcyA9IHVuZGVmO1xuICAgICAgICAgICAgfVxuICAgICAgICB9XG5cbiAgICAgICAgLy9TdXBwb3J0IHJlcXVpcmUoWydhJ10pXG4gICAgICAgIGNhbGxiYWNrID0gY2FsbGJhY2sgfHwgZnVuY3Rpb24gKCkge307XG5cbiAgICAgICAgLy9JZiByZWxOYW1lIGlzIGEgZnVuY3Rpb24sIGl0IGlzIGFuIGVycmJhY2sgaGFuZGxlcixcbiAgICAgICAgLy9zbyByZW1vdmUgaXQuXG4gICAgICAgIGlmICh0eXBlb2YgcmVsTmFtZSA9PT0gJ2Z1bmN0aW9uJykge1xuICAgICAgICAgICAgcmVsTmFtZSA9IGZvcmNlU3luYztcbiAgICAgICAgICAgIGZvcmNlU3luYyA9IGFsdDtcbiAgICAgICAgfVxuXG4gICAgICAgIC8vU2ltdWxhdGUgYXN5bmMgY2FsbGJhY2s7XG4gICAgICAgIGlmIChmb3JjZVN5bmMpIHtcbiAgICAgICAgICAgIG1haW4odW5kZWYsIGRlcHMsIGNhbGxiYWNrLCByZWxOYW1lKTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIC8vVXNpbmcgYSBub24temVybyB2YWx1ZSBiZWNhdXNlIG9mIGNvbmNlcm4gZm9yIHdoYXQgb2xkIGJyb3dzZXJzXG4gICAgICAgICAgICAvL2RvLCBhbmQgbGF0ZXN0IGJyb3dzZXJzIFwidXBncmFkZVwiIHRvIDQgaWYgbG93ZXIgdmFsdWUgaXMgdXNlZDpcbiAgICAgICAgICAgIC8vaHR0cDovL3d3dy53aGF0d2cub3JnL3NwZWNzL3dlYi1hcHBzL2N1cnJlbnQtd29yay9tdWx0aXBhZ2UvdGltZXJzLmh0bWwjZG9tLXdpbmRvd3RpbWVycy1zZXR0aW1lb3V0OlxuICAgICAgICAgICAgLy9JZiB3YW50IGEgdmFsdWUgaW1tZWRpYXRlbHksIHVzZSByZXF1aXJlKCdpZCcpIGluc3RlYWQgLS0gc29tZXRoaW5nXG4gICAgICAgICAgICAvL3RoYXQgd29ya3MgaW4gYWxtb25kIG9uIHRoZSBnbG9iYWwgbGV2ZWwsIGJ1dCBub3QgZ3VhcmFudGVlZCBhbmRcbiAgICAgICAgICAgIC8vdW5saWtlbHkgdG8gd29yayBpbiBvdGhlciBBTUQgaW1wbGVtZW50YXRpb25zLlxuICAgICAgICAgICAgc2V0VGltZW91dChmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgICAgICAgbWFpbih1bmRlZiwgZGVwcywgY2FsbGJhY2ssIHJlbE5hbWUpO1xuICAgICAgICAgICAgfSwgNCk7XG4gICAgICAgIH1cblxuICAgICAgICByZXR1cm4gcmVxO1xuICAgIH07XG5cbiAgICAvKipcbiAgICAgKiBKdXN0IGRyb3BzIHRoZSBjb25maWcgb24gdGhlIGZsb29yLCBidXQgcmV0dXJucyByZXEgaW4gY2FzZVxuICAgICAqIHRoZSBjb25maWcgcmV0dXJuIHZhbHVlIGlzIHVzZWQuXG4gICAgICovXG4gICAgcmVxLmNvbmZpZyA9IGZ1bmN0aW9uIChjZmcpIHtcbiAgICAgICAgcmV0dXJuIHJlcShjZmcpO1xuICAgIH07XG5cbiAgICAvKipcbiAgICAgKiBFeHBvc2UgbW9kdWxlIHJlZ2lzdHJ5IGZvciBkZWJ1Z2dpbmcgYW5kIHRvb2xpbmdcbiAgICAgKi9cbiAgICByZXF1aXJlanMuX2RlZmluZWQgPSBkZWZpbmVkO1xuXG4gICAgZGVmaW5lID0gZnVuY3Rpb24gKG5hbWUsIGRlcHMsIGNhbGxiYWNrKSB7XG4gICAgICAgIGlmICh0eXBlb2YgbmFtZSAhPT0gJ3N0cmluZycpIHtcbiAgICAgICAgICAgIHRocm93IG5ldyBFcnJvcignU2VlIGFsbW9uZCBSRUFETUU6IGluY29ycmVjdCBtb2R1bGUgYnVpbGQsIG5vIG1vZHVsZSBuYW1lJyk7XG4gICAgICAgIH1cblxuICAgICAgICAvL1RoaXMgbW9kdWxlIG1heSBub3QgaGF2ZSBkZXBlbmRlbmNpZXNcbiAgICAgICAgaWYgKCFkZXBzLnNwbGljZSkge1xuICAgICAgICAgICAgLy9kZXBzIGlzIG5vdCBhbiBhcnJheSwgc28gcHJvYmFibHkgbWVhbnNcbiAgICAgICAgICAgIC8vYW4gb2JqZWN0IGxpdGVyYWwgb3IgZmFjdG9yeSBmdW5jdGlvbiBmb3JcbiAgICAgICAgICAgIC8vdGhlIHZhbHVlLiBBZGp1c3QgYXJncy5cbiAgICAgICAgICAgIGNhbGxiYWNrID0gZGVwcztcbiAgICAgICAgICAgIGRlcHMgPSBbXTtcbiAgICAgICAgfVxuXG4gICAgICAgIGlmICghaGFzUHJvcChkZWZpbmVkLCBuYW1lKSAmJiAhaGFzUHJvcCh3YWl0aW5nLCBuYW1lKSkge1xuICAgICAgICAgICAgd2FpdGluZ1tuYW1lXSA9IFtuYW1lLCBkZXBzLCBjYWxsYmFja107XG4gICAgICAgIH1cbiAgICB9O1xuXG4gICAgZGVmaW5lLmFtZCA9IHtcbiAgICAgICAgalF1ZXJ5OiB0cnVlXG4gICAgfTtcbn0oKSk7XG5cblMyLnJlcXVpcmVqcyA9IHJlcXVpcmVqcztTMi5yZXF1aXJlID0gcmVxdWlyZTtTMi5kZWZpbmUgPSBkZWZpbmU7XG59XG59KCkpO1xuUzIuZGVmaW5lKFwiYWxtb25kXCIsIGZ1bmN0aW9uKCl7fSk7XG5cbi8qIGdsb2JhbCBqUXVlcnk6ZmFsc2UsICQ6ZmFsc2UgKi9cblMyLmRlZmluZSgnanF1ZXJ5JyxbXSxmdW5jdGlvbiAoKSB7XG4gIHZhciBfJCA9IGpRdWVyeSB8fCAkO1xuXG4gIGlmIChfJCA9PSBudWxsICYmIGNvbnNvbGUgJiYgY29uc29sZS5lcnJvcikge1xuICAgIGNvbnNvbGUuZXJyb3IoXG4gICAgICAnU2VsZWN0MjogQW4gaW5zdGFuY2Ugb2YgalF1ZXJ5IG9yIGEgalF1ZXJ5LWNvbXBhdGlibGUgbGlicmFyeSB3YXMgbm90ICcgK1xuICAgICAgJ2ZvdW5kLiBNYWtlIHN1cmUgdGhhdCB5b3UgYXJlIGluY2x1ZGluZyBqUXVlcnkgYmVmb3JlIFNlbGVjdDIgb24geW91ciAnICtcbiAgICAgICd3ZWIgcGFnZS4nXG4gICAgKTtcbiAgfVxuXG4gIHJldHVybiBfJDtcbn0pO1xuXG5TMi5kZWZpbmUoJ3NlbGVjdDIvdXRpbHMnLFtcbiAgJ2pxdWVyeSdcbl0sIGZ1bmN0aW9uICgkKSB7XG4gIHZhciBVdGlscyA9IHt9O1xuXG4gIFV0aWxzLkV4dGVuZCA9IGZ1bmN0aW9uIChDaGlsZENsYXNzLCBTdXBlckNsYXNzKSB7XG4gICAgdmFyIF9faGFzUHJvcCA9IHt9Lmhhc093blByb3BlcnR5O1xuXG4gICAgZnVuY3Rpb24gQmFzZUNvbnN0cnVjdG9yICgpIHtcbiAgICAgIHRoaXMuY29uc3RydWN0b3IgPSBDaGlsZENsYXNzO1xuICAgIH1cblxuICAgIGZvciAodmFyIGtleSBpbiBTdXBlckNsYXNzKSB7XG4gICAgICBpZiAoX19oYXNQcm9wLmNhbGwoU3VwZXJDbGFzcywga2V5KSkge1xuICAgICAgICBDaGlsZENsYXNzW2tleV0gPSBTdXBlckNsYXNzW2tleV07XG4gICAgICB9XG4gICAgfVxuXG4gICAgQmFzZUNvbnN0cnVjdG9yLnByb3RvdHlwZSA9IFN1cGVyQ2xhc3MucHJvdG90eXBlO1xuICAgIENoaWxkQ2xhc3MucHJvdG90eXBlID0gbmV3IEJhc2VDb25zdHJ1Y3RvcigpO1xuICAgIENoaWxkQ2xhc3MuX19zdXBlcl9fID0gU3VwZXJDbGFzcy5wcm90b3R5cGU7XG5cbiAgICByZXR1cm4gQ2hpbGRDbGFzcztcbiAgfTtcblxuICBmdW5jdGlvbiBnZXRNZXRob2RzICh0aGVDbGFzcykge1xuICAgIHZhciBwcm90byA9IHRoZUNsYXNzLnByb3RvdHlwZTtcblxuICAgIHZhciBtZXRob2RzID0gW107XG5cbiAgICBmb3IgKHZhciBtZXRob2ROYW1lIGluIHByb3RvKSB7XG4gICAgICB2YXIgbSA9IHByb3RvW21ldGhvZE5hbWVdO1xuXG4gICAgICBpZiAodHlwZW9mIG0gIT09ICdmdW5jdGlvbicpIHtcbiAgICAgICAgY29udGludWU7XG4gICAgICB9XG5cbiAgICAgIGlmIChtZXRob2ROYW1lID09PSAnY29uc3RydWN0b3InKSB7XG4gICAgICAgIGNvbnRpbnVlO1xuICAgICAgfVxuXG4gICAgICBtZXRob2RzLnB1c2gobWV0aG9kTmFtZSk7XG4gICAgfVxuXG4gICAgcmV0dXJuIG1ldGhvZHM7XG4gIH1cblxuICBVdGlscy5EZWNvcmF0ZSA9IGZ1bmN0aW9uIChTdXBlckNsYXNzLCBEZWNvcmF0b3JDbGFzcykge1xuICAgIHZhciBkZWNvcmF0ZWRNZXRob2RzID0gZ2V0TWV0aG9kcyhEZWNvcmF0b3JDbGFzcyk7XG4gICAgdmFyIHN1cGVyTWV0aG9kcyA9IGdldE1ldGhvZHMoU3VwZXJDbGFzcyk7XG5cbiAgICBmdW5jdGlvbiBEZWNvcmF0ZWRDbGFzcyAoKSB7XG4gICAgICB2YXIgdW5zaGlmdCA9IEFycmF5LnByb3RvdHlwZS51bnNoaWZ0O1xuXG4gICAgICB2YXIgYXJnQ291bnQgPSBEZWNvcmF0b3JDbGFzcy5wcm90b3R5cGUuY29uc3RydWN0b3IubGVuZ3RoO1xuXG4gICAgICB2YXIgY2FsbGVkQ29uc3RydWN0b3IgPSBTdXBlckNsYXNzLnByb3RvdHlwZS5jb25zdHJ1Y3RvcjtcblxuICAgICAgaWYgKGFyZ0NvdW50ID4gMCkge1xuICAgICAgICB1bnNoaWZ0LmNhbGwoYXJndW1lbnRzLCBTdXBlckNsYXNzLnByb3RvdHlwZS5jb25zdHJ1Y3Rvcik7XG5cbiAgICAgICAgY2FsbGVkQ29uc3RydWN0b3IgPSBEZWNvcmF0b3JDbGFzcy5wcm90b3R5cGUuY29uc3RydWN0b3I7XG4gICAgICB9XG5cbiAgICAgIGNhbGxlZENvbnN0cnVjdG9yLmFwcGx5KHRoaXMsIGFyZ3VtZW50cyk7XG4gICAgfVxuXG4gICAgRGVjb3JhdG9yQ2xhc3MuZGlzcGxheU5hbWUgPSBTdXBlckNsYXNzLmRpc3BsYXlOYW1lO1xuXG4gICAgZnVuY3Rpb24gY3RyICgpIHtcbiAgICAgIHRoaXMuY29uc3RydWN0b3IgPSBEZWNvcmF0ZWRDbGFzcztcbiAgICB9XG5cbiAgICBEZWNvcmF0ZWRDbGFzcy5wcm90b3R5cGUgPSBuZXcgY3RyKCk7XG5cbiAgICBmb3IgKHZhciBtID0gMDsgbSA8IHN1cGVyTWV0aG9kcy5sZW5ndGg7IG0rKykge1xuICAgICAgICB2YXIgc3VwZXJNZXRob2QgPSBzdXBlck1ldGhvZHNbbV07XG5cbiAgICAgICAgRGVjb3JhdGVkQ2xhc3MucHJvdG90eXBlW3N1cGVyTWV0aG9kXSA9XG4gICAgICAgICAgU3VwZXJDbGFzcy5wcm90b3R5cGVbc3VwZXJNZXRob2RdO1xuICAgIH1cblxuICAgIHZhciBjYWxsZWRNZXRob2QgPSBmdW5jdGlvbiAobWV0aG9kTmFtZSkge1xuICAgICAgLy8gU3R1YiBvdXQgdGhlIG9yaWdpbmFsIG1ldGhvZCBpZiBpdCdzIG5vdCBkZWNvcmF0aW5nIGFuIGFjdHVhbCBtZXRob2RcbiAgICAgIHZhciBvcmlnaW5hbE1ldGhvZCA9IGZ1bmN0aW9uICgpIHt9O1xuXG4gICAgICBpZiAobWV0aG9kTmFtZSBpbiBEZWNvcmF0ZWRDbGFzcy5wcm90b3R5cGUpIHtcbiAgICAgICAgb3JpZ2luYWxNZXRob2QgPSBEZWNvcmF0ZWRDbGFzcy5wcm90b3R5cGVbbWV0aG9kTmFtZV07XG4gICAgICB9XG5cbiAgICAgIHZhciBkZWNvcmF0ZWRNZXRob2QgPSBEZWNvcmF0b3JDbGFzcy5wcm90b3R5cGVbbWV0aG9kTmFtZV07XG5cbiAgICAgIHJldHVybiBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciB1bnNoaWZ0ID0gQXJyYXkucHJvdG90eXBlLnVuc2hpZnQ7XG5cbiAgICAgICAgdW5zaGlmdC5jYWxsKGFyZ3VtZW50cywgb3JpZ2luYWxNZXRob2QpO1xuXG4gICAgICAgIHJldHVybiBkZWNvcmF0ZWRNZXRob2QuYXBwbHkodGhpcywgYXJndW1lbnRzKTtcbiAgICAgIH07XG4gICAgfTtcblxuICAgIGZvciAodmFyIGQgPSAwOyBkIDwgZGVjb3JhdGVkTWV0aG9kcy5sZW5ndGg7IGQrKykge1xuICAgICAgdmFyIGRlY29yYXRlZE1ldGhvZCA9IGRlY29yYXRlZE1ldGhvZHNbZF07XG5cbiAgICAgIERlY29yYXRlZENsYXNzLnByb3RvdHlwZVtkZWNvcmF0ZWRNZXRob2RdID0gY2FsbGVkTWV0aG9kKGRlY29yYXRlZE1ldGhvZCk7XG4gICAgfVxuXG4gICAgcmV0dXJuIERlY29yYXRlZENsYXNzO1xuICB9O1xuXG4gIHZhciBPYnNlcnZhYmxlID0gZnVuY3Rpb24gKCkge1xuICAgIHRoaXMubGlzdGVuZXJzID0ge307XG4gIH07XG5cbiAgT2JzZXJ2YWJsZS5wcm90b3R5cGUub24gPSBmdW5jdGlvbiAoZXZlbnQsIGNhbGxiYWNrKSB7XG4gICAgdGhpcy5saXN0ZW5lcnMgPSB0aGlzLmxpc3RlbmVycyB8fCB7fTtcblxuICAgIGlmIChldmVudCBpbiB0aGlzLmxpc3RlbmVycykge1xuICAgICAgdGhpcy5saXN0ZW5lcnNbZXZlbnRdLnB1c2goY2FsbGJhY2spO1xuICAgIH0gZWxzZSB7XG4gICAgICB0aGlzLmxpc3RlbmVyc1tldmVudF0gPSBbY2FsbGJhY2tdO1xuICAgIH1cbiAgfTtcblxuICBPYnNlcnZhYmxlLnByb3RvdHlwZS50cmlnZ2VyID0gZnVuY3Rpb24gKGV2ZW50KSB7XG4gICAgdmFyIHNsaWNlID0gQXJyYXkucHJvdG90eXBlLnNsaWNlO1xuICAgIHZhciBwYXJhbXMgPSBzbGljZS5jYWxsKGFyZ3VtZW50cywgMSk7XG5cbiAgICB0aGlzLmxpc3RlbmVycyA9IHRoaXMubGlzdGVuZXJzIHx8IHt9O1xuXG4gICAgLy8gUGFyYW1zIHNob3VsZCBhbHdheXMgY29tZSBpbiBhcyBhbiBhcnJheVxuICAgIGlmIChwYXJhbXMgPT0gbnVsbCkge1xuICAgICAgcGFyYW1zID0gW107XG4gICAgfVxuXG4gICAgLy8gSWYgdGhlcmUgYXJlIG5vIGFyZ3VtZW50cyB0byB0aGUgZXZlbnQsIHVzZSBhIHRlbXBvcmFyeSBvYmplY3RcbiAgICBpZiAocGFyYW1zLmxlbmd0aCA9PT0gMCkge1xuICAgICAgcGFyYW1zLnB1c2goe30pO1xuICAgIH1cblxuICAgIC8vIFNldCB0aGUgYF90eXBlYCBvZiB0aGUgZmlyc3Qgb2JqZWN0IHRvIHRoZSBldmVudFxuICAgIHBhcmFtc1swXS5fdHlwZSA9IGV2ZW50O1xuXG4gICAgaWYgKGV2ZW50IGluIHRoaXMubGlzdGVuZXJzKSB7XG4gICAgICB0aGlzLmludm9rZSh0aGlzLmxpc3RlbmVyc1tldmVudF0sIHNsaWNlLmNhbGwoYXJndW1lbnRzLCAxKSk7XG4gICAgfVxuXG4gICAgaWYgKCcqJyBpbiB0aGlzLmxpc3RlbmVycykge1xuICAgICAgdGhpcy5pbnZva2UodGhpcy5saXN0ZW5lcnNbJyonXSwgYXJndW1lbnRzKTtcbiAgICB9XG4gIH07XG5cbiAgT2JzZXJ2YWJsZS5wcm90b3R5cGUuaW52b2tlID0gZnVuY3Rpb24gKGxpc3RlbmVycywgcGFyYW1zKSB7XG4gICAgZm9yICh2YXIgaSA9IDAsIGxlbiA9IGxpc3RlbmVycy5sZW5ndGg7IGkgPCBsZW47IGkrKykge1xuICAgICAgbGlzdGVuZXJzW2ldLmFwcGx5KHRoaXMsIHBhcmFtcyk7XG4gICAgfVxuICB9O1xuXG4gIFV0aWxzLk9ic2VydmFibGUgPSBPYnNlcnZhYmxlO1xuXG4gIFV0aWxzLmdlbmVyYXRlQ2hhcnMgPSBmdW5jdGlvbiAobGVuZ3RoKSB7XG4gICAgdmFyIGNoYXJzID0gJyc7XG5cbiAgICBmb3IgKHZhciBpID0gMDsgaSA8IGxlbmd0aDsgaSsrKSB7XG4gICAgICB2YXIgcmFuZG9tQ2hhciA9IE1hdGguZmxvb3IoTWF0aC5yYW5kb20oKSAqIDM2KTtcbiAgICAgIGNoYXJzICs9IHJhbmRvbUNoYXIudG9TdHJpbmcoMzYpO1xuICAgIH1cblxuICAgIHJldHVybiBjaGFycztcbiAgfTtcblxuICBVdGlscy5iaW5kID0gZnVuY3Rpb24gKGZ1bmMsIGNvbnRleHQpIHtcbiAgICByZXR1cm4gZnVuY3Rpb24gKCkge1xuICAgICAgZnVuYy5hcHBseShjb250ZXh0LCBhcmd1bWVudHMpO1xuICAgIH07XG4gIH07XG5cbiAgVXRpbHMuX2NvbnZlcnREYXRhID0gZnVuY3Rpb24gKGRhdGEpIHtcbiAgICBmb3IgKHZhciBvcmlnaW5hbEtleSBpbiBkYXRhKSB7XG4gICAgICB2YXIga2V5cyA9IG9yaWdpbmFsS2V5LnNwbGl0KCctJyk7XG5cbiAgICAgIHZhciBkYXRhTGV2ZWwgPSBkYXRhO1xuXG4gICAgICBpZiAoa2V5cy5sZW5ndGggPT09IDEpIHtcbiAgICAgICAgY29udGludWU7XG4gICAgICB9XG5cbiAgICAgIGZvciAodmFyIGsgPSAwOyBrIDwga2V5cy5sZW5ndGg7IGsrKykge1xuICAgICAgICB2YXIga2V5ID0ga2V5c1trXTtcblxuICAgICAgICAvLyBMb3dlcmNhc2UgdGhlIGZpcnN0IGxldHRlclxuICAgICAgICAvLyBCeSBkZWZhdWx0LCBkYXNoLXNlcGFyYXRlZCBiZWNvbWVzIGNhbWVsQ2FzZVxuICAgICAgICBrZXkgPSBrZXkuc3Vic3RyaW5nKDAsIDEpLnRvTG93ZXJDYXNlKCkgKyBrZXkuc3Vic3RyaW5nKDEpO1xuXG4gICAgICAgIGlmICghKGtleSBpbiBkYXRhTGV2ZWwpKSB7XG4gICAgICAgICAgZGF0YUxldmVsW2tleV0gPSB7fTtcbiAgICAgICAgfVxuXG4gICAgICAgIGlmIChrID09IGtleXMubGVuZ3RoIC0gMSkge1xuICAgICAgICAgIGRhdGFMZXZlbFtrZXldID0gZGF0YVtvcmlnaW5hbEtleV07XG4gICAgICAgIH1cblxuICAgICAgICBkYXRhTGV2ZWwgPSBkYXRhTGV2ZWxba2V5XTtcbiAgICAgIH1cblxuICAgICAgZGVsZXRlIGRhdGFbb3JpZ2luYWxLZXldO1xuICAgIH1cblxuICAgIHJldHVybiBkYXRhO1xuICB9O1xuXG4gIFV0aWxzLmhhc1Njcm9sbCA9IGZ1bmN0aW9uIChpbmRleCwgZWwpIHtcbiAgICAvLyBBZGFwdGVkIGZyb20gdGhlIGZ1bmN0aW9uIGNyZWF0ZWQgYnkgQFNoYWRvd1NjcmlwdGVyXG4gICAgLy8gYW5kIGFkYXB0ZWQgYnkgQEJpbGxCYXJyeSBvbiB0aGUgU3RhY2sgRXhjaGFuZ2UgQ29kZSBSZXZpZXcgd2Vic2l0ZS5cbiAgICAvLyBUaGUgb3JpZ2luYWwgY29kZSBjYW4gYmUgZm91bmQgYXRcbiAgICAvLyBodHRwOi8vY29kZXJldmlldy5zdGFja2V4Y2hhbmdlLmNvbS9xLzEzMzM4XG4gICAgLy8gYW5kIHdhcyBkZXNpZ25lZCB0byBiZSB1c2VkIHdpdGggdGhlIFNpenpsZSBzZWxlY3RvciBlbmdpbmUuXG5cbiAgICB2YXIgJGVsID0gJChlbCk7XG4gICAgdmFyIG92ZXJmbG93WCA9IGVsLnN0eWxlLm92ZXJmbG93WDtcbiAgICB2YXIgb3ZlcmZsb3dZID0gZWwuc3R5bGUub3ZlcmZsb3dZO1xuXG4gICAgLy9DaGVjayBib3RoIHggYW5kIHkgZGVjbGFyYXRpb25zXG4gICAgaWYgKG92ZXJmbG93WCA9PT0gb3ZlcmZsb3dZICYmXG4gICAgICAgIChvdmVyZmxvd1kgPT09ICdoaWRkZW4nIHx8IG92ZXJmbG93WSA9PT0gJ3Zpc2libGUnKSkge1xuICAgICAgcmV0dXJuIGZhbHNlO1xuICAgIH1cblxuICAgIGlmIChvdmVyZmxvd1ggPT09ICdzY3JvbGwnIHx8IG92ZXJmbG93WSA9PT0gJ3Njcm9sbCcpIHtcbiAgICAgIHJldHVybiB0cnVlO1xuICAgIH1cblxuICAgIHJldHVybiAoJGVsLmlubmVySGVpZ2h0KCkgPCBlbC5zY3JvbGxIZWlnaHQgfHxcbiAgICAgICRlbC5pbm5lcldpZHRoKCkgPCBlbC5zY3JvbGxXaWR0aCk7XG4gIH07XG5cbiAgVXRpbHMuZXNjYXBlTWFya3VwID0gZnVuY3Rpb24gKG1hcmt1cCkge1xuICAgIHZhciByZXBsYWNlTWFwID0ge1xuICAgICAgJ1xcXFwnOiAnJiM5MjsnLFxuICAgICAgJyYnOiAnJmFtcDsnLFxuICAgICAgJzwnOiAnJmx0OycsXG4gICAgICAnPic6ICcmZ3Q7JyxcbiAgICAgICdcIic6ICcmcXVvdDsnLFxuICAgICAgJ1xcJyc6ICcmIzM5OycsXG4gICAgICAnLyc6ICcmIzQ3OydcbiAgICB9O1xuXG4gICAgLy8gRG8gbm90IHRyeSB0byBlc2NhcGUgdGhlIG1hcmt1cCBpZiBpdCdzIG5vdCBhIHN0cmluZ1xuICAgIGlmICh0eXBlb2YgbWFya3VwICE9PSAnc3RyaW5nJykge1xuICAgICAgcmV0dXJuIG1hcmt1cDtcbiAgICB9XG5cbiAgICByZXR1cm4gU3RyaW5nKG1hcmt1cCkucmVwbGFjZSgvWyY8PlwiJ1xcL1xcXFxdL2csIGZ1bmN0aW9uIChtYXRjaCkge1xuICAgICAgcmV0dXJuIHJlcGxhY2VNYXBbbWF0Y2hdO1xuICAgIH0pO1xuICB9O1xuXG4gIC8vIEFwcGVuZCBhbiBhcnJheSBvZiBqUXVlcnkgbm9kZXMgdG8gYSBnaXZlbiBlbGVtZW50LlxuICBVdGlscy5hcHBlbmRNYW55ID0gZnVuY3Rpb24gKCRlbGVtZW50LCAkbm9kZXMpIHtcbiAgICAvLyBqUXVlcnkgMS43LnggZG9lcyBub3Qgc3VwcG9ydCAkLmZuLmFwcGVuZCgpIHdpdGggYW4gYXJyYXlcbiAgICAvLyBGYWxsIGJhY2sgdG8gYSBqUXVlcnkgb2JqZWN0IGNvbGxlY3Rpb24gdXNpbmcgJC5mbi5hZGQoKVxuICAgIGlmICgkLmZuLmpxdWVyeS5zdWJzdHIoMCwgMykgPT09ICcxLjcnKSB7XG4gICAgICB2YXIgJGpxTm9kZXMgPSAkKCk7XG5cbiAgICAgICQubWFwKCRub2RlcywgZnVuY3Rpb24gKG5vZGUpIHtcbiAgICAgICAgJGpxTm9kZXMgPSAkanFOb2Rlcy5hZGQobm9kZSk7XG4gICAgICB9KTtcblxuICAgICAgJG5vZGVzID0gJGpxTm9kZXM7XG4gICAgfVxuXG4gICAgJGVsZW1lbnQuYXBwZW5kKCRub2Rlcyk7XG4gIH07XG5cbiAgcmV0dXJuIFV0aWxzO1xufSk7XG5cblMyLmRlZmluZSgnc2VsZWN0Mi9yZXN1bHRzJyxbXG4gICdqcXVlcnknLFxuICAnLi91dGlscydcbl0sIGZ1bmN0aW9uICgkLCBVdGlscykge1xuICBmdW5jdGlvbiBSZXN1bHRzICgkZWxlbWVudCwgb3B0aW9ucywgZGF0YUFkYXB0ZXIpIHtcbiAgICB0aGlzLiRlbGVtZW50ID0gJGVsZW1lbnQ7XG4gICAgdGhpcy5kYXRhID0gZGF0YUFkYXB0ZXI7XG4gICAgdGhpcy5vcHRpb25zID0gb3B0aW9ucztcblxuICAgIFJlc3VsdHMuX19zdXBlcl9fLmNvbnN0cnVjdG9yLmNhbGwodGhpcyk7XG4gIH1cblxuICBVdGlscy5FeHRlbmQoUmVzdWx0cywgVXRpbHMuT2JzZXJ2YWJsZSk7XG5cbiAgUmVzdWx0cy5wcm90b3R5cGUucmVuZGVyID0gZnVuY3Rpb24gKCkge1xuICAgIHZhciAkcmVzdWx0cyA9ICQoXG4gICAgICAnPHVsIGNsYXNzPVwic2VsZWN0Mi1yZXN1bHRzX19vcHRpb25zXCIgcm9sZT1cInRyZWVcIj48L3VsPidcbiAgICApO1xuXG4gICAgaWYgKHRoaXMub3B0aW9ucy5nZXQoJ211bHRpcGxlJykpIHtcbiAgICAgICRyZXN1bHRzLmF0dHIoJ2FyaWEtbXVsdGlzZWxlY3RhYmxlJywgJ3RydWUnKTtcbiAgICB9XG5cbiAgICB0aGlzLiRyZXN1bHRzID0gJHJlc3VsdHM7XG5cbiAgICByZXR1cm4gJHJlc3VsdHM7XG4gIH07XG5cbiAgUmVzdWx0cy5wcm90b3R5cGUuY2xlYXIgPSBmdW5jdGlvbiAoKSB7XG4gICAgdGhpcy4kcmVzdWx0cy5lbXB0eSgpO1xuICB9O1xuXG4gIFJlc3VsdHMucHJvdG90eXBlLmRpc3BsYXlNZXNzYWdlID0gZnVuY3Rpb24gKHBhcmFtcykge1xuICAgIHZhciBlc2NhcGVNYXJrdXAgPSB0aGlzLm9wdGlvbnMuZ2V0KCdlc2NhcGVNYXJrdXAnKTtcblxuICAgIHRoaXMuY2xlYXIoKTtcbiAgICB0aGlzLmhpZGVMb2FkaW5nKCk7XG5cbiAgICB2YXIgJG1lc3NhZ2UgPSAkKFxuICAgICAgJzxsaSByb2xlPVwidHJlZWl0ZW1cIiBhcmlhLWxpdmU9XCJhc3NlcnRpdmVcIicgK1xuICAgICAgJyBjbGFzcz1cInNlbGVjdDItcmVzdWx0c19fb3B0aW9uXCI+PC9saT4nXG4gICAgKTtcblxuICAgIHZhciBtZXNzYWdlID0gdGhpcy5vcHRpb25zLmdldCgndHJhbnNsYXRpb25zJykuZ2V0KHBhcmFtcy5tZXNzYWdlKTtcblxuICAgICRtZXNzYWdlLmFwcGVuZChcbiAgICAgIGVzY2FwZU1hcmt1cChcbiAgICAgICAgbWVzc2FnZShwYXJhbXMuYXJncylcbiAgICAgIClcbiAgICApO1xuXG4gICAgJG1lc3NhZ2VbMF0uY2xhc3NOYW1lICs9ICcgc2VsZWN0Mi1yZXN1bHRzX19tZXNzYWdlJztcblxuICAgIHRoaXMuJHJlc3VsdHMuYXBwZW5kKCRtZXNzYWdlKTtcbiAgfTtcblxuICBSZXN1bHRzLnByb3RvdHlwZS5oaWRlTWVzc2FnZXMgPSBmdW5jdGlvbiAoKSB7XG4gICAgdGhpcy4kcmVzdWx0cy5maW5kKCcuc2VsZWN0Mi1yZXN1bHRzX19tZXNzYWdlJykucmVtb3ZlKCk7XG4gIH07XG5cbiAgUmVzdWx0cy5wcm90b3R5cGUuYXBwZW5kID0gZnVuY3Rpb24gKGRhdGEpIHtcbiAgICB0aGlzLmhpZGVMb2FkaW5nKCk7XG5cbiAgICB2YXIgJG9wdGlvbnMgPSBbXTtcblxuICAgIGlmIChkYXRhLnJlc3VsdHMgPT0gbnVsbCB8fCBkYXRhLnJlc3VsdHMubGVuZ3RoID09PSAwKSB7XG4gICAgICBpZiAodGhpcy4kcmVzdWx0cy5jaGlsZHJlbigpLmxlbmd0aCA9PT0gMCkge1xuICAgICAgICB0aGlzLnRyaWdnZXIoJ3Jlc3VsdHM6bWVzc2FnZScsIHtcbiAgICAgICAgICBtZXNzYWdlOiAnbm9SZXN1bHRzJ1xuICAgICAgICB9KTtcbiAgICAgIH1cblxuICAgICAgcmV0dXJuO1xuICAgIH1cblxuICAgIGRhdGEucmVzdWx0cyA9IHRoaXMuc29ydChkYXRhLnJlc3VsdHMpO1xuXG4gICAgZm9yICh2YXIgZCA9IDA7IGQgPCBkYXRhLnJlc3VsdHMubGVuZ3RoOyBkKyspIHtcbiAgICAgIHZhciBpdGVtID0gZGF0YS5yZXN1bHRzW2RdO1xuXG4gICAgICB2YXIgJG9wdGlvbiA9IHRoaXMub3B0aW9uKGl0ZW0pO1xuXG4gICAgICAkb3B0aW9ucy5wdXNoKCRvcHRpb24pO1xuICAgIH1cblxuICAgIHRoaXMuJHJlc3VsdHMuYXBwZW5kKCRvcHRpb25zKTtcbiAgfTtcblxuICBSZXN1bHRzLnByb3RvdHlwZS5wb3NpdGlvbiA9IGZ1bmN0aW9uICgkcmVzdWx0cywgJGRyb3Bkb3duKSB7XG4gICAgdmFyICRyZXN1bHRzQ29udGFpbmVyID0gJGRyb3Bkb3duLmZpbmQoJy5zZWxlY3QyLXJlc3VsdHMnKTtcbiAgICAkcmVzdWx0c0NvbnRhaW5lci5hcHBlbmQoJHJlc3VsdHMpO1xuICB9O1xuXG4gIFJlc3VsdHMucHJvdG90eXBlLnNvcnQgPSBmdW5jdGlvbiAoZGF0YSkge1xuICAgIHZhciBzb3J0ZXIgPSB0aGlzLm9wdGlvbnMuZ2V0KCdzb3J0ZXInKTtcblxuICAgIHJldHVybiBzb3J0ZXIoZGF0YSk7XG4gIH07XG5cbiAgUmVzdWx0cy5wcm90b3R5cGUuaGlnaGxpZ2h0Rmlyc3RJdGVtID0gZnVuY3Rpb24gKCkge1xuICAgIHZhciAkb3B0aW9ucyA9IHRoaXMuJHJlc3VsdHNcbiAgICAgIC5maW5kKCcuc2VsZWN0Mi1yZXN1bHRzX19vcHRpb25bYXJpYS1zZWxlY3RlZF0nKTtcblxuICAgIHZhciAkc2VsZWN0ZWQgPSAkb3B0aW9ucy5maWx0ZXIoJ1thcmlhLXNlbGVjdGVkPXRydWVdJyk7XG5cbiAgICAvLyBDaGVjayBpZiB0aGVyZSBhcmUgYW55IHNlbGVjdGVkIG9wdGlvbnNcbiAgICBpZiAoJHNlbGVjdGVkLmxlbmd0aCA+IDApIHtcbiAgICAgIC8vIElmIHRoZXJlIGFyZSBzZWxlY3RlZCBvcHRpb25zLCBoaWdobGlnaHQgdGhlIGZpcnN0XG4gICAgICAkc2VsZWN0ZWQuZmlyc3QoKS50cmlnZ2VyKCdtb3VzZWVudGVyJyk7XG4gICAgfSBlbHNlIHtcbiAgICAgIC8vIElmIHRoZXJlIGFyZSBubyBzZWxlY3RlZCBvcHRpb25zLCBoaWdobGlnaHQgdGhlIGZpcnN0IG9wdGlvblxuICAgICAgLy8gaW4gdGhlIGRyb3Bkb3duXG4gICAgICAkb3B0aW9ucy5maXJzdCgpLnRyaWdnZXIoJ21vdXNlZW50ZXInKTtcbiAgICB9XG5cbiAgICB0aGlzLmVuc3VyZUhpZ2hsaWdodFZpc2libGUoKTtcbiAgfTtcblxuICBSZXN1bHRzLnByb3RvdHlwZS5zZXRDbGFzc2VzID0gZnVuY3Rpb24gKCkge1xuICAgIHZhciBzZWxmID0gdGhpcztcblxuICAgIHRoaXMuZGF0YS5jdXJyZW50KGZ1bmN0aW9uIChzZWxlY3RlZCkge1xuICAgICAgdmFyIHNlbGVjdGVkSWRzID0gJC5tYXAoc2VsZWN0ZWQsIGZ1bmN0aW9uIChzKSB7XG4gICAgICAgIHJldHVybiBzLmlkLnRvU3RyaW5nKCk7XG4gICAgICB9KTtcblxuICAgICAgdmFyICRvcHRpb25zID0gc2VsZi4kcmVzdWx0c1xuICAgICAgICAuZmluZCgnLnNlbGVjdDItcmVzdWx0c19fb3B0aW9uW2FyaWEtc2VsZWN0ZWRdJyk7XG5cbiAgICAgICRvcHRpb25zLmVhY2goZnVuY3Rpb24gKCkge1xuICAgICAgICB2YXIgJG9wdGlvbiA9ICQodGhpcyk7XG5cbiAgICAgICAgdmFyIGl0ZW0gPSAkLmRhdGEodGhpcywgJ2RhdGEnKTtcblxuICAgICAgICAvLyBpZCBuZWVkcyB0byBiZSBjb252ZXJ0ZWQgdG8gYSBzdHJpbmcgd2hlbiBjb21wYXJpbmdcbiAgICAgICAgdmFyIGlkID0gJycgKyBpdGVtLmlkO1xuXG4gICAgICAgIGlmICgoaXRlbS5lbGVtZW50ICE9IG51bGwgJiYgaXRlbS5lbGVtZW50LnNlbGVjdGVkKSB8fFxuICAgICAgICAgICAgKGl0ZW0uZWxlbWVudCA9PSBudWxsICYmICQuaW5BcnJheShpZCwgc2VsZWN0ZWRJZHMpID4gLTEpKSB7XG4gICAgICAgICAgJG9wdGlvbi5hdHRyKCdhcmlhLXNlbGVjdGVkJywgJ3RydWUnKTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAkb3B0aW9uLmF0dHIoJ2FyaWEtc2VsZWN0ZWQnLCAnZmFsc2UnKTtcbiAgICAgICAgfVxuICAgICAgfSk7XG5cbiAgICB9KTtcbiAgfTtcblxuICBSZXN1bHRzLnByb3RvdHlwZS5zaG93TG9hZGluZyA9IGZ1bmN0aW9uIChwYXJhbXMpIHtcbiAgICB0aGlzLmhpZGVMb2FkaW5nKCk7XG5cbiAgICB2YXIgbG9hZGluZ01vcmUgPSB0aGlzLm9wdGlvbnMuZ2V0KCd0cmFuc2xhdGlvbnMnKS5nZXQoJ3NlYXJjaGluZycpO1xuXG4gICAgdmFyIGxvYWRpbmcgPSB7XG4gICAgICBkaXNhYmxlZDogdHJ1ZSxcbiAgICAgIGxvYWRpbmc6IHRydWUsXG4gICAgICB0ZXh0OiBsb2FkaW5nTW9yZShwYXJhbXMpXG4gICAgfTtcbiAgICB2YXIgJGxvYWRpbmcgPSB0aGlzLm9wdGlvbihsb2FkaW5nKTtcbiAgICAkbG9hZGluZy5jbGFzc05hbWUgKz0gJyBsb2FkaW5nLXJlc3VsdHMnO1xuXG4gICAgdGhpcy4kcmVzdWx0cy5wcmVwZW5kKCRsb2FkaW5nKTtcbiAgfTtcblxuICBSZXN1bHRzLnByb3RvdHlwZS5oaWRlTG9hZGluZyA9IGZ1bmN0aW9uICgpIHtcbiAgICB0aGlzLiRyZXN1bHRzLmZpbmQoJy5sb2FkaW5nLXJlc3VsdHMnKS5yZW1vdmUoKTtcbiAgfTtcblxuICBSZXN1bHRzLnByb3RvdHlwZS5vcHRpb24gPSBmdW5jdGlvbiAoZGF0YSkge1xuICAgIHZhciBvcHRpb24gPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdsaScpO1xuICAgIG9wdGlvbi5jbGFzc05hbWUgPSAnc2VsZWN0Mi1yZXN1bHRzX19vcHRpb24nO1xuXG4gICAgdmFyIGF0dHJzID0ge1xuICAgICAgJ3JvbGUnOiAndHJlZWl0ZW0nLFxuICAgICAgJ2FyaWEtc2VsZWN0ZWQnOiAnZmFsc2UnXG4gICAgfTtcblxuICAgIGlmIChkYXRhLmRpc2FibGVkKSB7XG4gICAgICBkZWxldGUgYXR0cnNbJ2FyaWEtc2VsZWN0ZWQnXTtcbiAgICAgIGF0dHJzWydhcmlhLWRpc2FibGVkJ10gPSAndHJ1ZSc7XG4gICAgfVxuXG4gICAgaWYgKGRhdGEuaWQgPT0gbnVsbCkge1xuICAgICAgZGVsZXRlIGF0dHJzWydhcmlhLXNlbGVjdGVkJ107XG4gICAgfVxuXG4gICAgaWYgKGRhdGEuX3Jlc3VsdElkICE9IG51bGwpIHtcbiAgICAgIG9wdGlvbi5pZCA9IGRhdGEuX3Jlc3VsdElkO1xuICAgIH1cblxuICAgIGlmIChkYXRhLnRpdGxlKSB7XG4gICAgICBvcHRpb24udGl0bGUgPSBkYXRhLnRpdGxlO1xuICAgIH1cblxuICAgIGlmIChkYXRhLmNoaWxkcmVuKSB7XG4gICAgICBhdHRycy5yb2xlID0gJ2dyb3VwJztcbiAgICAgIGF0dHJzWydhcmlhLWxhYmVsJ10gPSBkYXRhLnRleHQ7XG4gICAgICBkZWxldGUgYXR0cnNbJ2FyaWEtc2VsZWN0ZWQnXTtcbiAgICB9XG5cbiAgICBmb3IgKHZhciBhdHRyIGluIGF0dHJzKSB7XG4gICAgICB2YXIgdmFsID0gYXR0cnNbYXR0cl07XG5cbiAgICAgIG9wdGlvbi5zZXRBdHRyaWJ1dGUoYXR0ciwgdmFsKTtcbiAgICB9XG5cbiAgICBpZiAoZGF0YS5jaGlsZHJlbikge1xuICAgICAgdmFyICRvcHRpb24gPSAkKG9wdGlvbik7XG5cbiAgICAgIHZhciBsYWJlbCA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ3N0cm9uZycpO1xuICAgICAgbGFiZWwuY2xhc3NOYW1lID0gJ3NlbGVjdDItcmVzdWx0c19fZ3JvdXAnO1xuXG4gICAgICB2YXIgJGxhYmVsID0gJChsYWJlbCk7XG4gICAgICB0aGlzLnRlbXBsYXRlKGRhdGEsIGxhYmVsKTtcblxuICAgICAgdmFyICRjaGlsZHJlbiA9IFtdO1xuXG4gICAgICBmb3IgKHZhciBjID0gMDsgYyA8IGRhdGEuY2hpbGRyZW4ubGVuZ3RoOyBjKyspIHtcbiAgICAgICAgdmFyIGNoaWxkID0gZGF0YS5jaGlsZHJlbltjXTtcblxuICAgICAgICB2YXIgJGNoaWxkID0gdGhpcy5vcHRpb24oY2hpbGQpO1xuXG4gICAgICAgICRjaGlsZHJlbi5wdXNoKCRjaGlsZCk7XG4gICAgICB9XG5cbiAgICAgIHZhciAkY2hpbGRyZW5Db250YWluZXIgPSAkKCc8dWw+PC91bD4nLCB7XG4gICAgICAgICdjbGFzcyc6ICdzZWxlY3QyLXJlc3VsdHNfX29wdGlvbnMgc2VsZWN0Mi1yZXN1bHRzX19vcHRpb25zLS1uZXN0ZWQnXG4gICAgICB9KTtcblxuICAgICAgJGNoaWxkcmVuQ29udGFpbmVyLmFwcGVuZCgkY2hpbGRyZW4pO1xuXG4gICAgICAkb3B0aW9uLmFwcGVuZChsYWJlbCk7XG4gICAgICAkb3B0aW9uLmFwcGVuZCgkY2hpbGRyZW5Db250YWluZXIpO1xuICAgIH0gZWxzZSB7XG4gICAgICB0aGlzLnRlbXBsYXRlKGRhdGEsIG9wdGlvbik7XG4gICAgfVxuXG4gICAgJC5kYXRhKG9wdGlvbiwgJ2RhdGEnLCBkYXRhKTtcblxuICAgIHJldHVybiBvcHRpb247XG4gIH07XG5cbiAgUmVzdWx0cy5wcm90b3R5cGUuYmluZCA9IGZ1bmN0aW9uIChjb250YWluZXIsICRjb250YWluZXIpIHtcbiAgICB2YXIgc2VsZiA9IHRoaXM7XG5cbiAgICB2YXIgaWQgPSBjb250YWluZXIuaWQgKyAnLXJlc3VsdHMnO1xuXG4gICAgdGhpcy4kcmVzdWx0cy5hdHRyKCdpZCcsIGlkKTtcblxuICAgIGNvbnRhaW5lci5vbigncmVzdWx0czphbGwnLCBmdW5jdGlvbiAocGFyYW1zKSB7XG4gICAgICBzZWxmLmNsZWFyKCk7XG4gICAgICBzZWxmLmFwcGVuZChwYXJhbXMuZGF0YSk7XG5cbiAgICAgIGlmIChjb250YWluZXIuaXNPcGVuKCkpIHtcbiAgICAgICAgc2VsZi5zZXRDbGFzc2VzKCk7XG4gICAgICAgIHNlbGYuaGlnaGxpZ2h0Rmlyc3RJdGVtKCk7XG4gICAgICB9XG4gICAgfSk7XG5cbiAgICBjb250YWluZXIub24oJ3Jlc3VsdHM6YXBwZW5kJywgZnVuY3Rpb24gKHBhcmFtcykge1xuICAgICAgc2VsZi5hcHBlbmQocGFyYW1zLmRhdGEpO1xuXG4gICAgICBpZiAoY29udGFpbmVyLmlzT3BlbigpKSB7XG4gICAgICAgIHNlbGYuc2V0Q2xhc3NlcygpO1xuICAgICAgfVxuICAgIH0pO1xuXG4gICAgY29udGFpbmVyLm9uKCdxdWVyeScsIGZ1bmN0aW9uIChwYXJhbXMpIHtcbiAgICAgIHNlbGYuaGlkZU1lc3NhZ2VzKCk7XG4gICAgICBzZWxmLnNob3dMb2FkaW5nKHBhcmFtcyk7XG4gICAgfSk7XG5cbiAgICBjb250YWluZXIub24oJ3NlbGVjdCcsIGZ1bmN0aW9uICgpIHtcbiAgICAgIGlmICghY29udGFpbmVyLmlzT3BlbigpKSB7XG4gICAgICAgIHJldHVybjtcbiAgICAgIH1cblxuICAgICAgc2VsZi5zZXRDbGFzc2VzKCk7XG4gICAgICBzZWxmLmhpZ2hsaWdodEZpcnN0SXRlbSgpO1xuICAgIH0pO1xuXG4gICAgY29udGFpbmVyLm9uKCd1bnNlbGVjdCcsIGZ1bmN0aW9uICgpIHtcbiAgICAgIGlmICghY29udGFpbmVyLmlzT3BlbigpKSB7XG4gICAgICAgIHJldHVybjtcbiAgICAgIH1cblxuICAgICAgc2VsZi5zZXRDbGFzc2VzKCk7XG4gICAgICBzZWxmLmhpZ2hsaWdodEZpcnN0SXRlbSgpO1xuICAgIH0pO1xuXG4gICAgY29udGFpbmVyLm9uKCdvcGVuJywgZnVuY3Rpb24gKCkge1xuICAgICAgLy8gV2hlbiB0aGUgZHJvcGRvd24gaXMgb3BlbiwgYXJpYS1leHBlbmRlZD1cInRydWVcIlxuICAgICAgc2VsZi4kcmVzdWx0cy5hdHRyKCdhcmlhLWV4cGFuZGVkJywgJ3RydWUnKTtcbiAgICAgIHNlbGYuJHJlc3VsdHMuYXR0cignYXJpYS1oaWRkZW4nLCAnZmFsc2UnKTtcblxuICAgICAgc2VsZi5zZXRDbGFzc2VzKCk7XG4gICAgICBzZWxmLmVuc3VyZUhpZ2hsaWdodFZpc2libGUoKTtcbiAgICB9KTtcblxuICAgIGNvbnRhaW5lci5vbignY2xvc2UnLCBmdW5jdGlvbiAoKSB7XG4gICAgICAvLyBXaGVuIHRoZSBkcm9wZG93biBpcyBjbG9zZWQsIGFyaWEtZXhwZW5kZWQ9XCJmYWxzZVwiXG4gICAgICBzZWxmLiRyZXN1bHRzLmF0dHIoJ2FyaWEtZXhwYW5kZWQnLCAnZmFsc2UnKTtcbiAgICAgIHNlbGYuJHJlc3VsdHMuYXR0cignYXJpYS1oaWRkZW4nLCAndHJ1ZScpO1xuICAgICAgc2VsZi4kcmVzdWx0cy5yZW1vdmVBdHRyKCdhcmlhLWFjdGl2ZWRlc2NlbmRhbnQnKTtcbiAgICB9KTtcblxuICAgIGNvbnRhaW5lci5vbigncmVzdWx0czp0b2dnbGUnLCBmdW5jdGlvbiAoKSB7XG4gICAgICB2YXIgJGhpZ2hsaWdodGVkID0gc2VsZi5nZXRIaWdobGlnaHRlZFJlc3VsdHMoKTtcblxuICAgICAgaWYgKCRoaWdobGlnaHRlZC5sZW5ndGggPT09IDApIHtcbiAgICAgICAgcmV0dXJuO1xuICAgICAgfVxuXG4gICAgICAkaGlnaGxpZ2h0ZWQudHJpZ2dlcignbW91c2V1cCcpO1xuICAgIH0pO1xuXG4gICAgY29udGFpbmVyLm9uKCdyZXN1bHRzOnNlbGVjdCcsIGZ1bmN0aW9uICgpIHtcbiAgICAgIHZhciAkaGlnaGxpZ2h0ZWQgPSBzZWxmLmdldEhpZ2hsaWdodGVkUmVzdWx0cygpO1xuXG4gICAgICBpZiAoJGhpZ2hsaWdodGVkLmxlbmd0aCA9PT0gMCkge1xuICAgICAgICByZXR1cm47XG4gICAgICB9XG5cbiAgICAgIHZhciBkYXRhID0gJGhpZ2hsaWdodGVkLmRhdGEoJ2RhdGEnKTtcblxuICAgICAgaWYgKCRoaWdobGlnaHRlZC5hdHRyKCdhcmlhLXNlbGVjdGVkJykgPT0gJ3RydWUnKSB7XG4gICAgICAgIHNlbGYudHJpZ2dlcignY2xvc2UnLCB7fSk7XG4gICAgICB9IGVsc2Uge1xuICAgICAgICBzZWxmLnRyaWdnZXIoJ3NlbGVjdCcsIHtcbiAgICAgICAgICBkYXRhOiBkYXRhXG4gICAgICAgIH0pO1xuICAgICAgfVxuICAgIH0pO1xuXG4gICAgY29udGFpbmVyLm9uKCdyZXN1bHRzOnByZXZpb3VzJywgZnVuY3Rpb24gKCkge1xuICAgICAgdmFyICRoaWdobGlnaHRlZCA9IHNlbGYuZ2V0SGlnaGxpZ2h0ZWRSZXN1bHRzKCk7XG5cbiAgICAgIHZhciAkb3B0aW9ucyA9IHNlbGYuJHJlc3VsdHMuZmluZCgnW2FyaWEtc2VsZWN0ZWRdJyk7XG5cbiAgICAgIHZhciBjdXJyZW50SW5kZXggPSAkb3B0aW9ucy5pbmRleCgkaGlnaGxpZ2h0ZWQpO1xuXG4gICAgICAvLyBJZiB3ZSBhcmUgYWxyZWFkeSBhdCB0ZSB0b3AsIGRvbid0IG1vdmUgZnVydGhlclxuICAgICAgaWYgKGN1cnJlbnRJbmRleCA9PT0gMCkge1xuICAgICAgICByZXR1cm47XG4gICAgICB9XG5cbiAgICAgIHZhciBuZXh0SW5kZXggPSBjdXJyZW50SW5kZXggLSAxO1xuXG4gICAgICAvLyBJZiBub25lIGFyZSBoaWdobGlnaHRlZCwgaGlnaGxpZ2h0IHRoZSBmaXJzdFxuICAgICAgaWYgKCRoaWdobGlnaHRlZC5sZW5ndGggPT09IDApIHtcbiAgICAgICAgbmV4dEluZGV4ID0gMDtcbiAgICAgIH1cblxuICAgICAgdmFyICRuZXh0ID0gJG9wdGlvbnMuZXEobmV4dEluZGV4KTtcblxuICAgICAgJG5leHQudHJpZ2dlcignbW91c2VlbnRlcicpO1xuXG4gICAgICB2YXIgY3VycmVudE9mZnNldCA9IHNlbGYuJHJlc3VsdHMub2Zmc2V0KCkudG9wO1xuICAgICAgdmFyIG5leHRUb3AgPSAkbmV4dC5vZmZzZXQoKS50b3A7XG4gICAgICB2YXIgbmV4dE9mZnNldCA9IHNlbGYuJHJlc3VsdHMuc2Nyb2xsVG9wKCkgKyAobmV4dFRvcCAtIGN1cnJlbnRPZmZzZXQpO1xuXG4gICAgICBpZiAobmV4dEluZGV4ID09PSAwKSB7XG4gICAgICAgIHNlbGYuJHJlc3VsdHMuc2Nyb2xsVG9wKDApO1xuICAgICAgfSBlbHNlIGlmIChuZXh0VG9wIC0gY3VycmVudE9mZnNldCA8IDApIHtcbiAgICAgICAgc2VsZi4kcmVzdWx0cy5zY3JvbGxUb3AobmV4dE9mZnNldCk7XG4gICAgICB9XG4gICAgfSk7XG5cbiAgICBjb250YWluZXIub24oJ3Jlc3VsdHM6bmV4dCcsIGZ1bmN0aW9uICgpIHtcbiAgICAgIHZhciAkaGlnaGxpZ2h0ZWQgPSBzZWxmLmdldEhpZ2hsaWdodGVkUmVzdWx0cygpO1xuXG4gICAgICB2YXIgJG9wdGlvbnMgPSBzZWxmLiRyZXN1bHRzLmZpbmQoJ1thcmlhLXNlbGVjdGVkXScpO1xuXG4gICAgICB2YXIgY3VycmVudEluZGV4ID0gJG9wdGlvbnMuaW5kZXgoJGhpZ2hsaWdodGVkKTtcblxuICAgICAgdmFyIG5leHRJbmRleCA9IGN1cnJlbnRJbmRleCArIDE7XG5cbiAgICAgIC8vIElmIHdlIGFyZSBhdCB0aGUgbGFzdCBvcHRpb24sIHN0YXkgdGhlcmVcbiAgICAgIGlmIChuZXh0SW5kZXggPj0gJG9wdGlvbnMubGVuZ3RoKSB7XG4gICAgICAgIHJldHVybjtcbiAgICAgIH1cblxuICAgICAgdmFyICRuZXh0ID0gJG9wdGlvbnMuZXEobmV4dEluZGV4KTtcblxuICAgICAgJG5leHQudHJpZ2dlcignbW91c2VlbnRlcicpO1xuXG4gICAgICB2YXIgY3VycmVudE9mZnNldCA9IHNlbGYuJHJlc3VsdHMub2Zmc2V0KCkudG9wICtcbiAgICAgICAgc2VsZi4kcmVzdWx0cy5vdXRlckhlaWdodChmYWxzZSk7XG4gICAgICB2YXIgbmV4dEJvdHRvbSA9ICRuZXh0Lm9mZnNldCgpLnRvcCArICRuZXh0Lm91dGVySGVpZ2h0KGZhbHNlKTtcbiAgICAgIHZhciBuZXh0T2Zmc2V0ID0gc2VsZi4kcmVzdWx0cy5zY3JvbGxUb3AoKSArIG5leHRCb3R0b20gLSBjdXJyZW50T2Zmc2V0O1xuXG4gICAgICBpZiAobmV4dEluZGV4ID09PSAwKSB7XG4gICAgICAgIHNlbGYuJHJlc3VsdHMuc2Nyb2xsVG9wKDApO1xuICAgICAgfSBlbHNlIGlmIChuZXh0Qm90dG9tID4gY3VycmVudE9mZnNldCkge1xuICAgICAgICBzZWxmLiRyZXN1bHRzLnNjcm9sbFRvcChuZXh0T2Zmc2V0KTtcbiAgICAgIH1cbiAgICB9KTtcblxuICAgIGNvbnRhaW5lci5vbigncmVzdWx0czpmb2N1cycsIGZ1bmN0aW9uIChwYXJhbXMpIHtcbiAgICAgIHBhcmFtcy5lbGVtZW50LmFkZENsYXNzKCdzZWxlY3QyLXJlc3VsdHNfX29wdGlvbi0taGlnaGxpZ2h0ZWQnKTtcbiAgICB9KTtcblxuICAgIGNvbnRhaW5lci5vbigncmVzdWx0czptZXNzYWdlJywgZnVuY3Rpb24gKHBhcmFtcykge1xuICAgICAgc2VsZi5kaXNwbGF5TWVzc2FnZShwYXJhbXMpO1xuICAgIH0pO1xuXG4gICAgaWYgKCQuZm4ubW91c2V3aGVlbCkge1xuICAgICAgdGhpcy4kcmVzdWx0cy5vbignbW91c2V3aGVlbCcsIGZ1bmN0aW9uIChlKSB7XG4gICAgICAgIHZhciB0b3AgPSBzZWxmLiRyZXN1bHRzLnNjcm9sbFRvcCgpO1xuXG4gICAgICAgIHZhciBib3R0b20gPSBzZWxmLiRyZXN1bHRzLmdldCgwKS5zY3JvbGxIZWlnaHQgLSB0b3AgKyBlLmRlbHRhWTtcblxuICAgICAgICB2YXIgaXNBdFRvcCA9IGUuZGVsdGFZID4gMCAmJiB0b3AgLSBlLmRlbHRhWSA8PSAwO1xuICAgICAgICB2YXIgaXNBdEJvdHRvbSA9IGUuZGVsdGFZIDwgMCAmJiBib3R0b20gPD0gc2VsZi4kcmVzdWx0cy5oZWlnaHQoKTtcblxuICAgICAgICBpZiAoaXNBdFRvcCkge1xuICAgICAgICAgIHNlbGYuJHJlc3VsdHMuc2Nyb2xsVG9wKDApO1xuXG4gICAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICAgIGUuc3RvcFByb3BhZ2F0aW9uKCk7XG4gICAgICAgIH0gZWxzZSBpZiAoaXNBdEJvdHRvbSkge1xuICAgICAgICAgIHNlbGYuJHJlc3VsdHMuc2Nyb2xsVG9wKFxuICAgICAgICAgICAgc2VsZi4kcmVzdWx0cy5nZXQoMCkuc2Nyb2xsSGVpZ2h0IC0gc2VsZi4kcmVzdWx0cy5oZWlnaHQoKVxuICAgICAgICAgICk7XG5cbiAgICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgICAgZS5zdG9wUHJvcGFnYXRpb24oKTtcbiAgICAgICAgfVxuICAgICAgfSk7XG4gICAgfVxuXG4gICAgdGhpcy4kcmVzdWx0cy5vbignbW91c2V1cCcsICcuc2VsZWN0Mi1yZXN1bHRzX19vcHRpb25bYXJpYS1zZWxlY3RlZF0nLFxuICAgICAgZnVuY3Rpb24gKGV2dCkge1xuICAgICAgdmFyICR0aGlzID0gJCh0aGlzKTtcblxuICAgICAgdmFyIGRhdGEgPSAkdGhpcy5kYXRhKCdkYXRhJyk7XG5cbiAgICAgIGlmICgkdGhpcy5hdHRyKCdhcmlhLXNlbGVjdGVkJykgPT09ICd0cnVlJykge1xuICAgICAgICBpZiAoc2VsZi5vcHRpb25zLmdldCgnbXVsdGlwbGUnKSkge1xuICAgICAgICAgIHNlbGYudHJpZ2dlcigndW5zZWxlY3QnLCB7XG4gICAgICAgICAgICBvcmlnaW5hbEV2ZW50OiBldnQsXG4gICAgICAgICAgICBkYXRhOiBkYXRhXG4gICAgICAgICAgfSk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgc2VsZi50cmlnZ2VyKCdjbG9zZScsIHt9KTtcbiAgICAgICAgfVxuXG4gICAgICAgIHJldHVybjtcbiAgICAgIH1cblxuICAgICAgc2VsZi50cmlnZ2VyKCdzZWxlY3QnLCB7XG4gICAgICAgIG9yaWdpbmFsRXZlbnQ6IGV2dCxcbiAgICAgICAgZGF0YTogZGF0YVxuICAgICAgfSk7XG4gICAgfSk7XG5cbiAgICB0aGlzLiRyZXN1bHRzLm9uKCdtb3VzZWVudGVyJywgJy5zZWxlY3QyLXJlc3VsdHNfX29wdGlvblthcmlhLXNlbGVjdGVkXScsXG4gICAgICBmdW5jdGlvbiAoZXZ0KSB7XG4gICAgICB2YXIgZGF0YSA9ICQodGhpcykuZGF0YSgnZGF0YScpO1xuXG4gICAgICBzZWxmLmdldEhpZ2hsaWdodGVkUmVzdWx0cygpXG4gICAgICAgICAgLnJlbW92ZUNsYXNzKCdzZWxlY3QyLXJlc3VsdHNfX29wdGlvbi0taGlnaGxpZ2h0ZWQnKTtcblxuICAgICAgc2VsZi50cmlnZ2VyKCdyZXN1bHRzOmZvY3VzJywge1xuICAgICAgICBkYXRhOiBkYXRhLFxuICAgICAgICBlbGVtZW50OiAkKHRoaXMpXG4gICAgICB9KTtcbiAgICB9KTtcbiAgfTtcblxuICBSZXN1bHRzLnByb3RvdHlwZS5nZXRIaWdobGlnaHRlZFJlc3VsdHMgPSBmdW5jdGlvbiAoKSB7XG4gICAgdmFyICRoaWdobGlnaHRlZCA9IHRoaXMuJHJlc3VsdHNcbiAgICAuZmluZCgnLnNlbGVjdDItcmVzdWx0c19fb3B0aW9uLS1oaWdobGlnaHRlZCcpO1xuXG4gICAgcmV0dXJuICRoaWdobGlnaHRlZDtcbiAgfTtcblxuICBSZXN1bHRzLnByb3RvdHlwZS5kZXN0cm95ID0gZnVuY3Rpb24gKCkge1xuICAgIHRoaXMuJHJlc3VsdHMucmVtb3ZlKCk7XG4gIH07XG5cbiAgUmVzdWx0cy5wcm90b3R5cGUuZW5zdXJlSGlnaGxpZ2h0VmlzaWJsZSA9IGZ1bmN0aW9uICgpIHtcbiAgICB2YXIgJGhpZ2hsaWdodGVkID0gdGhpcy5nZXRIaWdobGlnaHRlZFJlc3VsdHMoKTtcblxuICAgIGlmICgkaGlnaGxpZ2h0ZWQubGVuZ3RoID09PSAwKSB7XG4gICAgICByZXR1cm47XG4gICAgfVxuXG4gICAgdmFyICRvcHRpb25zID0gdGhpcy4kcmVzdWx0cy5maW5kKCdbYXJpYS1zZWxlY3RlZF0nKTtcblxuICAgIHZhciBjdXJyZW50SW5kZXggPSAkb3B0aW9ucy5pbmRleCgkaGlnaGxpZ2h0ZWQpO1xuXG4gICAgdmFyIGN1cnJlbnRPZmZzZXQgPSB0aGlzLiRyZXN1bHRzLm9mZnNldCgpLnRvcDtcbiAgICB2YXIgbmV4dFRvcCA9ICRoaWdobGlnaHRlZC5vZmZzZXQoKS50b3A7XG4gICAgdmFyIG5leHRPZmZzZXQgPSB0aGlzLiRyZXN1bHRzLnNjcm9sbFRvcCgpICsgKG5leHRUb3AgLSBjdXJyZW50T2Zmc2V0KTtcblxuICAgIHZhciBvZmZzZXREZWx0YSA9IG5leHRUb3AgLSBjdXJyZW50T2Zmc2V0O1xuICAgIG5leHRPZmZzZXQgLT0gJGhpZ2hsaWdodGVkLm91dGVySGVpZ2h0KGZhbHNlKSAqIDI7XG5cbiAgICBpZiAoY3VycmVudEluZGV4IDw9IDIpIHtcbiAgICAgIHRoaXMuJHJlc3VsdHMuc2Nyb2xsVG9wKDApO1xuICAgIH0gZWxzZSBpZiAob2Zmc2V0RGVsdGEgPiB0aGlzLiRyZXN1bHRzLm91dGVySGVpZ2h0KCkgfHwgb2Zmc2V0RGVsdGEgPCAwKSB7XG4gICAgICB0aGlzLiRyZXN1bHRzLnNjcm9sbFRvcChuZXh0T2Zmc2V0KTtcbiAgICB9XG4gIH07XG5cbiAgUmVzdWx0cy5wcm90b3R5cGUudGVtcGxhdGUgPSBmdW5jdGlvbiAocmVzdWx0LCBjb250YWluZXIpIHtcbiAgICB2YXIgdGVtcGxhdGUgPSB0aGlzLm9wdGlvbnMuZ2V0KCd0ZW1wbGF0ZVJlc3VsdCcpO1xuICAgIHZhciBlc2NhcGVNYXJrdXAgPSB0aGlzLm9wdGlvbnMuZ2V0KCdlc2NhcGVNYXJrdXAnKTtcblxuICAgIHZhciBjb250ZW50ID0gdGVtcGxhdGUocmVzdWx0LCBjb250YWluZXIpO1xuXG4gICAgaWYgKGNvbnRlbnQgPT0gbnVsbCkge1xuICAgICAgY29udGFpbmVyLnN0eWxlLmRpc3BsYXkgPSAnbm9uZSc7XG4gICAgfSBlbHNlIGlmICh0eXBlb2YgY29udGVudCA9PT0gJ3N0cmluZycpIHtcbiAgICAgIGNvbnRhaW5lci5pbm5lckhUTUwgPSBlc2NhcGVNYXJrdXAoY29udGVudCk7XG4gICAgfSBlbHNlIHtcbiAgICAgICQoY29udGFpbmVyKS5hcHBlbmQoY29udGVudCk7XG4gICAgfVxuICB9O1xuXG4gIHJldHVybiBSZXN1bHRzO1xufSk7XG5cblMyLmRlZmluZSgnc2VsZWN0Mi9rZXlzJyxbXG5cbl0sIGZ1bmN0aW9uICgpIHtcbiAgdmFyIEtFWVMgPSB7XG4gICAgQkFDS1NQQUNFOiA4LFxuICAgIFRBQjogOSxcbiAgICBFTlRFUjogMTMsXG4gICAgU0hJRlQ6IDE2LFxuICAgIENUUkw6IDE3LFxuICAgIEFMVDogMTgsXG4gICAgRVNDOiAyNyxcbiAgICBTUEFDRTogMzIsXG4gICAgUEFHRV9VUDogMzMsXG4gICAgUEFHRV9ET1dOOiAzNCxcbiAgICBFTkQ6IDM1LFxuICAgIEhPTUU6IDM2LFxuICAgIExFRlQ6IDM3LFxuICAgIFVQOiAzOCxcbiAgICBSSUdIVDogMzksXG4gICAgRE9XTjogNDAsXG4gICAgREVMRVRFOiA0NlxuICB9O1xuXG4gIHJldHVybiBLRVlTO1xufSk7XG5cblMyLmRlZmluZSgnc2VsZWN0Mi9zZWxlY3Rpb24vYmFzZScsW1xuICAnanF1ZXJ5JyxcbiAgJy4uL3V0aWxzJyxcbiAgJy4uL2tleXMnXG5dLCBmdW5jdGlvbiAoJCwgVXRpbHMsIEtFWVMpIHtcbiAgZnVuY3Rpb24gQmFzZVNlbGVjdGlvbiAoJGVsZW1lbnQsIG9wdGlvbnMpIHtcbiAgICB0aGlzLiRlbGVtZW50ID0gJGVsZW1lbnQ7XG4gICAgdGhpcy5vcHRpb25zID0gb3B0aW9ucztcblxuICAgIEJhc2VTZWxlY3Rpb24uX19zdXBlcl9fLmNvbnN0cnVjdG9yLmNhbGwodGhpcyk7XG4gIH1cblxuICBVdGlscy5FeHRlbmQoQmFzZVNlbGVjdGlvbiwgVXRpbHMuT2JzZXJ2YWJsZSk7XG5cbiAgQmFzZVNlbGVjdGlvbi5wcm90b3R5cGUucmVuZGVyID0gZnVuY3Rpb24gKCkge1xuICAgIHZhciAkc2VsZWN0aW9uID0gJChcbiAgICAgICc8c3BhbiBjbGFzcz1cInNlbGVjdDItc2VsZWN0aW9uXCIgcm9sZT1cImNvbWJvYm94XCIgJyArXG4gICAgICAnIGFyaWEtaGFzcG9wdXA9XCJ0cnVlXCIgYXJpYS1leHBhbmRlZD1cImZhbHNlXCI+JyArXG4gICAgICAnPC9zcGFuPidcbiAgICApO1xuXG4gICAgdGhpcy5fdGFiaW5kZXggPSAwO1xuXG4gICAgaWYgKHRoaXMuJGVsZW1lbnQuZGF0YSgnb2xkLXRhYmluZGV4JykgIT0gbnVsbCkge1xuICAgICAgdGhpcy5fdGFiaW5kZXggPSB0aGlzLiRlbGVtZW50LmRhdGEoJ29sZC10YWJpbmRleCcpO1xuICAgIH0gZWxzZSBpZiAodGhpcy4kZWxlbWVudC5hdHRyKCd0YWJpbmRleCcpICE9IG51bGwpIHtcbiAgICAgIHRoaXMuX3RhYmluZGV4ID0gdGhpcy4kZWxlbWVudC5hdHRyKCd0YWJpbmRleCcpO1xuICAgIH1cblxuICAgICRzZWxlY3Rpb24uYXR0cigndGl0bGUnLCB0aGlzLiRlbGVtZW50LmF0dHIoJ3RpdGxlJykpO1xuICAgICRzZWxlY3Rpb24uYXR0cigndGFiaW5kZXgnLCB0aGlzLl90YWJpbmRleCk7XG5cbiAgICB0aGlzLiRzZWxlY3Rpb24gPSAkc2VsZWN0aW9uO1xuXG4gICAgcmV0dXJuICRzZWxlY3Rpb247XG4gIH07XG5cbiAgQmFzZVNlbGVjdGlvbi5wcm90b3R5cGUuYmluZCA9IGZ1bmN0aW9uIChjb250YWluZXIsICRjb250YWluZXIpIHtcbiAgICB2YXIgc2VsZiA9IHRoaXM7XG5cbiAgICB2YXIgaWQgPSBjb250YWluZXIuaWQgKyAnLWNvbnRhaW5lcic7XG4gICAgdmFyIHJlc3VsdHNJZCA9IGNvbnRhaW5lci5pZCArICctcmVzdWx0cyc7XG5cbiAgICB0aGlzLmNvbnRhaW5lciA9IGNvbnRhaW5lcjtcblxuICAgIHRoaXMuJHNlbGVjdGlvbi5vbignZm9jdXMnLCBmdW5jdGlvbiAoZXZ0KSB7XG4gICAgICBzZWxmLnRyaWdnZXIoJ2ZvY3VzJywgZXZ0KTtcbiAgICB9KTtcblxuICAgIHRoaXMuJHNlbGVjdGlvbi5vbignYmx1cicsIGZ1bmN0aW9uIChldnQpIHtcbiAgICAgIHNlbGYuX2hhbmRsZUJsdXIoZXZ0KTtcbiAgICB9KTtcblxuICAgIHRoaXMuJHNlbGVjdGlvbi5vbigna2V5ZG93bicsIGZ1bmN0aW9uIChldnQpIHtcbiAgICAgIHNlbGYudHJpZ2dlcigna2V5cHJlc3MnLCBldnQpO1xuXG4gICAgICBpZiAoZXZ0LndoaWNoID09PSBLRVlTLlNQQUNFKSB7XG4gICAgICAgIGV2dC5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgfVxuICAgIH0pO1xuXG4gICAgY29udGFpbmVyLm9uKCdyZXN1bHRzOmZvY3VzJywgZnVuY3Rpb24gKHBhcmFtcykge1xuICAgICAgc2VsZi4kc2VsZWN0aW9uLmF0dHIoJ2FyaWEtYWN0aXZlZGVzY2VuZGFudCcsIHBhcmFtcy5kYXRhLl9yZXN1bHRJZCk7XG4gICAgfSk7XG5cbiAgICBjb250YWluZXIub24oJ3NlbGVjdGlvbjp1cGRhdGUnLCBmdW5jdGlvbiAocGFyYW1zKSB7XG4gICAgICBzZWxmLnVwZGF0ZShwYXJhbXMuZGF0YSk7XG4gICAgfSk7XG5cbiAgICBjb250YWluZXIub24oJ29wZW4nLCBmdW5jdGlvbiAoKSB7XG4gICAgICAvLyBXaGVuIHRoZSBkcm9wZG93biBpcyBvcGVuLCBhcmlhLWV4cGFuZGVkPVwidHJ1ZVwiXG4gICAgICBzZWxmLiRzZWxlY3Rpb24uYXR0cignYXJpYS1leHBhbmRlZCcsICd0cnVlJyk7XG4gICAgICBzZWxmLiRzZWxlY3Rpb24uYXR0cignYXJpYS1vd25zJywgcmVzdWx0c0lkKTtcblxuICAgICAgc2VsZi5fYXR0YWNoQ2xvc2VIYW5kbGVyKGNvbnRhaW5lcik7XG4gICAgfSk7XG5cbiAgICBjb250YWluZXIub24oJ2Nsb3NlJywgZnVuY3Rpb24gKCkge1xuICAgICAgLy8gV2hlbiB0aGUgZHJvcGRvd24gaXMgY2xvc2VkLCBhcmlhLWV4cGFuZGVkPVwiZmFsc2VcIlxuICAgICAgc2VsZi4kc2VsZWN0aW9uLmF0dHIoJ2FyaWEtZXhwYW5kZWQnLCAnZmFsc2UnKTtcbiAgICAgIHNlbGYuJHNlbGVjdGlvbi5yZW1vdmVBdHRyKCdhcmlhLWFjdGl2ZWRlc2NlbmRhbnQnKTtcbiAgICAgIHNlbGYuJHNlbGVjdGlvbi5yZW1vdmVBdHRyKCdhcmlhLW93bnMnKTtcblxuICAgICAgc2VsZi4kc2VsZWN0aW9uLmZvY3VzKCk7XG5cbiAgICAgIHNlbGYuX2RldGFjaENsb3NlSGFuZGxlcihjb250YWluZXIpO1xuICAgIH0pO1xuXG4gICAgY29udGFpbmVyLm9uKCdlbmFibGUnLCBmdW5jdGlvbiAoKSB7XG4gICAgICBzZWxmLiRzZWxlY3Rpb24uYXR0cigndGFiaW5kZXgnLCBzZWxmLl90YWJpbmRleCk7XG4gICAgfSk7XG5cbiAgICBjb250YWluZXIub24oJ2Rpc2FibGUnLCBmdW5jdGlvbiAoKSB7XG4gICAgICBzZWxmLiRzZWxlY3Rpb24uYXR0cigndGFiaW5kZXgnLCAnLTEnKTtcbiAgICB9KTtcbiAgfTtcblxuICBCYXNlU2VsZWN0aW9uLnByb3RvdHlwZS5faGFuZGxlQmx1ciA9IGZ1bmN0aW9uIChldnQpIHtcbiAgICB2YXIgc2VsZiA9IHRoaXM7XG5cbiAgICAvLyBUaGlzIG5lZWRzIHRvIGJlIGRlbGF5ZWQgYXMgdGhlIGFjdGl2ZSBlbGVtZW50IGlzIHRoZSBib2R5IHdoZW4gdGhlIHRhYlxuICAgIC8vIGtleSBpcyBwcmVzc2VkLCBwb3NzaWJseSBhbG9uZyB3aXRoIG90aGVycy5cbiAgICB3aW5kb3cuc2V0VGltZW91dChmdW5jdGlvbiAoKSB7XG4gICAgICAvLyBEb24ndCB0cmlnZ2VyIGBibHVyYCBpZiB0aGUgZm9jdXMgaXMgc3RpbGwgaW4gdGhlIHNlbGVjdGlvblxuICAgICAgaWYgKFxuICAgICAgICAoZG9jdW1lbnQuYWN0aXZlRWxlbWVudCA9PSBzZWxmLiRzZWxlY3Rpb25bMF0pIHx8XG4gICAgICAgICgkLmNvbnRhaW5zKHNlbGYuJHNlbGVjdGlvblswXSwgZG9jdW1lbnQuYWN0aXZlRWxlbWVudCkpXG4gICAgICApIHtcbiAgICAgICAgcmV0dXJuO1xuICAgICAgfVxuXG4gICAgICBzZWxmLnRyaWdnZXIoJ2JsdXInLCBldnQpO1xuICAgIH0sIDEpO1xuICB9O1xuXG4gIEJhc2VTZWxlY3Rpb24ucHJvdG90eXBlLl9hdHRhY2hDbG9zZUhhbmRsZXIgPSBmdW5jdGlvbiAoY29udGFpbmVyKSB7XG4gICAgdmFyIHNlbGYgPSB0aGlzO1xuXG4gICAgJChkb2N1bWVudC5ib2R5KS5vbignbW91c2Vkb3duLnNlbGVjdDIuJyArIGNvbnRhaW5lci5pZCwgZnVuY3Rpb24gKGUpIHtcbiAgICAgIHZhciAkdGFyZ2V0ID0gJChlLnRhcmdldCk7XG5cbiAgICAgIHZhciAkc2VsZWN0ID0gJHRhcmdldC5jbG9zZXN0KCcuc2VsZWN0MicpO1xuXG4gICAgICB2YXIgJGFsbCA9ICQoJy5zZWxlY3QyLnNlbGVjdDItY29udGFpbmVyLS1vcGVuJyk7XG5cbiAgICAgICRhbGwuZWFjaChmdW5jdGlvbiAoKSB7XG4gICAgICAgIHZhciAkdGhpcyA9ICQodGhpcyk7XG5cbiAgICAgICAgaWYgKHRoaXMgPT0gJHNlbGVjdFswXSkge1xuICAgICAgICAgIHJldHVybjtcbiAgICAgICAgfVxuXG4gICAgICAgIHZhciAkZWxlbWVudCA9ICR0aGlzLmRhdGEoJ2VsZW1lbnQnKTtcblxuICAgICAgICAkZWxlbWVudC5zZWxlY3QyKCdjbG9zZScpO1xuICAgICAgfSk7XG4gICAgfSk7XG4gIH07XG5cbiAgQmFzZVNlbGVjdGlvbi5wcm90b3R5cGUuX2RldGFjaENsb3NlSGFuZGxlciA9IGZ1bmN0aW9uIChjb250YWluZXIpIHtcbiAgICAkKGRvY3VtZW50LmJvZHkpLm9mZignbW91c2Vkb3duLnNlbGVjdDIuJyArIGNvbnRhaW5lci5pZCk7XG4gIH07XG5cbiAgQmFzZVNlbGVjdGlvbi5wcm90b3R5cGUucG9zaXRpb24gPSBmdW5jdGlvbiAoJHNlbGVjdGlvbiwgJGNvbnRhaW5lcikge1xuICAgIHZhciAkc2VsZWN0aW9uQ29udGFpbmVyID0gJGNvbnRhaW5lci5maW5kKCcuc2VsZWN0aW9uJyk7XG4gICAgJHNlbGVjdGlvbkNvbnRhaW5lci5hcHBlbmQoJHNlbGVjdGlvbik7XG4gIH07XG5cbiAgQmFzZVNlbGVjdGlvbi5wcm90b3R5cGUuZGVzdHJveSA9IGZ1bmN0aW9uICgpIHtcbiAgICB0aGlzLl9kZXRhY2hDbG9zZUhhbmRsZXIodGhpcy5jb250YWluZXIpO1xuICB9O1xuXG4gIEJhc2VTZWxlY3Rpb24ucHJvdG90eXBlLnVwZGF0ZSA9IGZ1bmN0aW9uIChkYXRhKSB7XG4gICAgdGhyb3cgbmV3IEVycm9yKCdUaGUgYHVwZGF0ZWAgbWV0aG9kIG11c3QgYmUgZGVmaW5lZCBpbiBjaGlsZCBjbGFzc2VzLicpO1xuICB9O1xuXG4gIHJldHVybiBCYXNlU2VsZWN0aW9uO1xufSk7XG5cblMyLmRlZmluZSgnc2VsZWN0Mi9zZWxlY3Rpb24vc2luZ2xlJyxbXG4gICdqcXVlcnknLFxuICAnLi9iYXNlJyxcbiAgJy4uL3V0aWxzJyxcbiAgJy4uL2tleXMnXG5dLCBmdW5jdGlvbiAoJCwgQmFzZVNlbGVjdGlvbiwgVXRpbHMsIEtFWVMpIHtcbiAgZnVuY3Rpb24gU2luZ2xlU2VsZWN0aW9uICgpIHtcbiAgICBTaW5nbGVTZWxlY3Rpb24uX19zdXBlcl9fLmNvbnN0cnVjdG9yLmFwcGx5KHRoaXMsIGFyZ3VtZW50cyk7XG4gIH1cblxuICBVdGlscy5FeHRlbmQoU2luZ2xlU2VsZWN0aW9uLCBCYXNlU2VsZWN0aW9uKTtcblxuICBTaW5nbGVTZWxlY3Rpb24ucHJvdG90eXBlLnJlbmRlciA9IGZ1bmN0aW9uICgpIHtcbiAgICB2YXIgJHNlbGVjdGlvbiA9IFNpbmdsZVNlbGVjdGlvbi5fX3N1cGVyX18ucmVuZGVyLmNhbGwodGhpcyk7XG5cbiAgICAkc2VsZWN0aW9uLmFkZENsYXNzKCdzZWxlY3QyLXNlbGVjdGlvbi0tc2luZ2xlJyk7XG5cbiAgICAkc2VsZWN0aW9uLmh0bWwoXG4gICAgICAnPHNwYW4gY2xhc3M9XCJzZWxlY3QyLXNlbGVjdGlvbl9fcmVuZGVyZWRcIj48L3NwYW4+JyArXG4gICAgICAnPHNwYW4gY2xhc3M9XCJzZWxlY3QyLXNlbGVjdGlvbl9fYXJyb3dcIiByb2xlPVwicHJlc2VudGF0aW9uXCI+JyArXG4gICAgICAgICc8YiByb2xlPVwicHJlc2VudGF0aW9uXCI+PC9iPicgK1xuICAgICAgJzwvc3Bhbj4nXG4gICAgKTtcblxuICAgIHJldHVybiAkc2VsZWN0aW9uO1xuICB9O1xuXG4gIFNpbmdsZVNlbGVjdGlvbi5wcm90b3R5cGUuYmluZCA9IGZ1bmN0aW9uIChjb250YWluZXIsICRjb250YWluZXIpIHtcbiAgICB2YXIgc2VsZiA9IHRoaXM7XG5cbiAgICBTaW5nbGVTZWxlY3Rpb24uX19zdXBlcl9fLmJpbmQuYXBwbHkodGhpcywgYXJndW1lbnRzKTtcblxuICAgIHZhciBpZCA9IGNvbnRhaW5lci5pZCArICctY29udGFpbmVyJztcblxuICAgIHRoaXMuJHNlbGVjdGlvbi5maW5kKCcuc2VsZWN0Mi1zZWxlY3Rpb25fX3JlbmRlcmVkJykuYXR0cignaWQnLCBpZCk7XG4gICAgdGhpcy4kc2VsZWN0aW9uLmF0dHIoJ2FyaWEtbGFiZWxsZWRieScsIGlkKTtcblxuICAgIHRoaXMuJHNlbGVjdGlvbi5vbignbW91c2Vkb3duJywgZnVuY3Rpb24gKGV2dCkge1xuICAgICAgLy8gT25seSByZXNwb25kIHRvIGxlZnQgY2xpY2tzXG4gICAgICBpZiAoZXZ0LndoaWNoICE9PSAxKSB7XG4gICAgICAgIHJldHVybjtcbiAgICAgIH1cblxuICAgICAgc2VsZi50cmlnZ2VyKCd0b2dnbGUnLCB7XG4gICAgICAgIG9yaWdpbmFsRXZlbnQ6IGV2dFxuICAgICAgfSk7XG4gICAgfSk7XG5cbiAgICB0aGlzLiRzZWxlY3Rpb24ub24oJ2ZvY3VzJywgZnVuY3Rpb24gKGV2dCkge1xuICAgICAgLy8gVXNlciBmb2N1c2VzIG9uIHRoZSBjb250YWluZXJcbiAgICB9KTtcblxuICAgIHRoaXMuJHNlbGVjdGlvbi5vbignYmx1cicsIGZ1bmN0aW9uIChldnQpIHtcbiAgICAgIC8vIFVzZXIgZXhpdHMgdGhlIGNvbnRhaW5lclxuICAgIH0pO1xuXG4gICAgY29udGFpbmVyLm9uKCdmb2N1cycsIGZ1bmN0aW9uIChldnQpIHtcbiAgICAgIGlmICghY29udGFpbmVyLmlzT3BlbigpKSB7XG4gICAgICAgIHNlbGYuJHNlbGVjdGlvbi5mb2N1cygpO1xuICAgICAgfVxuICAgIH0pO1xuXG4gICAgY29udGFpbmVyLm9uKCdzZWxlY3Rpb246dXBkYXRlJywgZnVuY3Rpb24gKHBhcmFtcykge1xuICAgICAgc2VsZi51cGRhdGUocGFyYW1zLmRhdGEpO1xuICAgIH0pO1xuICB9O1xuXG4gIFNpbmdsZVNlbGVjdGlvbi5wcm90b3R5cGUuY2xlYXIgPSBmdW5jdGlvbiAoKSB7XG4gICAgdGhpcy4kc2VsZWN0aW9uLmZpbmQoJy5zZWxlY3QyLXNlbGVjdGlvbl9fcmVuZGVyZWQnKS5lbXB0eSgpO1xuICB9O1xuXG4gIFNpbmdsZVNlbGVjdGlvbi5wcm90b3R5cGUuZGlzcGxheSA9IGZ1bmN0aW9uIChkYXRhLCBjb250YWluZXIpIHtcbiAgICB2YXIgdGVtcGxhdGUgPSB0aGlzLm9wdGlvbnMuZ2V0KCd0ZW1wbGF0ZVNlbGVjdGlvbicpO1xuICAgIHZhciBlc2NhcGVNYXJrdXAgPSB0aGlzLm9wdGlvbnMuZ2V0KCdlc2NhcGVNYXJrdXAnKTtcblxuICAgIHJldHVybiBlc2NhcGVNYXJrdXAodGVtcGxhdGUoZGF0YSwgY29udGFpbmVyKSk7XG4gIH07XG5cbiAgU2luZ2xlU2VsZWN0aW9uLnByb3RvdHlwZS5zZWxlY3Rpb25Db250YWluZXIgPSBmdW5jdGlvbiAoKSB7XG4gICAgcmV0dXJuICQoJzxzcGFuPjwvc3Bhbj4nKTtcbiAgfTtcblxuICBTaW5nbGVTZWxlY3Rpb24ucHJvdG90eXBlLnVwZGF0ZSA9IGZ1bmN0aW9uIChkYXRhKSB7XG4gICAgaWYgKGRhdGEubGVuZ3RoID09PSAwKSB7XG4gICAgICB0aGlzLmNsZWFyKCk7XG4gICAgICByZXR1cm47XG4gICAgfVxuXG4gICAgdmFyIHNlbGVjdGlvbiA9IGRhdGFbMF07XG5cbiAgICB2YXIgJHJlbmRlcmVkID0gdGhpcy4kc2VsZWN0aW9uLmZpbmQoJy5zZWxlY3QyLXNlbGVjdGlvbl9fcmVuZGVyZWQnKTtcbiAgICB2YXIgZm9ybWF0dGVkID0gdGhpcy5kaXNwbGF5KHNlbGVjdGlvbiwgJHJlbmRlcmVkKTtcblxuICAgICRyZW5kZXJlZC5lbXB0eSgpLmFwcGVuZChmb3JtYXR0ZWQpO1xuICAgICRyZW5kZXJlZC5wcm9wKCd0aXRsZScsIHNlbGVjdGlvbi50aXRsZSB8fCBzZWxlY3Rpb24udGV4dCk7XG4gIH07XG5cbiAgcmV0dXJuIFNpbmdsZVNlbGVjdGlvbjtcbn0pO1xuXG5TMi5kZWZpbmUoJ3NlbGVjdDIvc2VsZWN0aW9uL211bHRpcGxlJyxbXG4gICdqcXVlcnknLFxuICAnLi9iYXNlJyxcbiAgJy4uL3V0aWxzJ1xuXSwgZnVuY3Rpb24gKCQsIEJhc2VTZWxlY3Rpb24sIFV0aWxzKSB7XG4gIGZ1bmN0aW9uIE11bHRpcGxlU2VsZWN0aW9uICgkZWxlbWVudCwgb3B0aW9ucykge1xuICAgIE11bHRpcGxlU2VsZWN0aW9uLl9fc3VwZXJfXy5jb25zdHJ1Y3Rvci5hcHBseSh0aGlzLCBhcmd1bWVudHMpO1xuICB9XG5cbiAgVXRpbHMuRXh0ZW5kKE11bHRpcGxlU2VsZWN0aW9uLCBCYXNlU2VsZWN0aW9uKTtcblxuICBNdWx0aXBsZVNlbGVjdGlvbi5wcm90b3R5cGUucmVuZGVyID0gZnVuY3Rpb24gKCkge1xuICAgIHZhciAkc2VsZWN0aW9uID0gTXVsdGlwbGVTZWxlY3Rpb24uX19zdXBlcl9fLnJlbmRlci5jYWxsKHRoaXMpO1xuXG4gICAgJHNlbGVjdGlvbi5hZGRDbGFzcygnc2VsZWN0Mi1zZWxlY3Rpb24tLW11bHRpcGxlJyk7XG5cbiAgICAkc2VsZWN0aW9uLmh0bWwoXG4gICAgICAnPHVsIGNsYXNzPVwic2VsZWN0Mi1zZWxlY3Rpb25fX3JlbmRlcmVkXCI+PC91bD4nXG4gICAgKTtcblxuICAgIHJldHVybiAkc2VsZWN0aW9uO1xuICB9O1xuXG4gIE11bHRpcGxlU2VsZWN0aW9uLnByb3RvdHlwZS5iaW5kID0gZnVuY3Rpb24gKGNvbnRhaW5lciwgJGNvbnRhaW5lcikge1xuICAgIHZhciBzZWxmID0gdGhpcztcblxuICAgIE11bHRpcGxlU2VsZWN0aW9uLl9fc3VwZXJfXy5iaW5kLmFwcGx5KHRoaXMsIGFyZ3VtZW50cyk7XG5cbiAgICB0aGlzLiRzZWxlY3Rpb24ub24oJ2NsaWNrJywgZnVuY3Rpb24gKGV2dCkge1xuICAgICAgc2VsZi50cmlnZ2VyKCd0b2dnbGUnLCB7XG4gICAgICAgIG9yaWdpbmFsRXZlbnQ6IGV2dFxuICAgICAgfSk7XG4gICAgfSk7XG5cbiAgICB0aGlzLiRzZWxlY3Rpb24ub24oXG4gICAgICAnY2xpY2snLFxuICAgICAgJy5zZWxlY3QyLXNlbGVjdGlvbl9fY2hvaWNlX19yZW1vdmUnLFxuICAgICAgZnVuY3Rpb24gKGV2dCkge1xuICAgICAgICAvLyBJZ25vcmUgdGhlIGV2ZW50IGlmIGl0IGlzIGRpc2FibGVkXG4gICAgICAgIGlmIChzZWxmLm9wdGlvbnMuZ2V0KCdkaXNhYmxlZCcpKSB7XG4gICAgICAgICAgcmV0dXJuO1xuICAgICAgICB9XG5cbiAgICAgICAgdmFyICRyZW1vdmUgPSAkKHRoaXMpO1xuICAgICAgICB2YXIgJHNlbGVjdGlvbiA9ICRyZW1vdmUucGFyZW50KCk7XG5cbiAgICAgICAgdmFyIGRhdGEgPSAkc2VsZWN0aW9uLmRhdGEoJ2RhdGEnKTtcblxuICAgICAgICBzZWxmLnRyaWdnZXIoJ3Vuc2VsZWN0Jywge1xuICAgICAgICAgIG9yaWdpbmFsRXZlbnQ6IGV2dCxcbiAgICAgICAgICBkYXRhOiBkYXRhXG4gICAgICAgIH0pO1xuICAgICAgfVxuICAgICk7XG4gIH07XG5cbiAgTXVsdGlwbGVTZWxlY3Rpb24ucHJvdG90eXBlLmNsZWFyID0gZnVuY3Rpb24gKCkge1xuICAgIHRoaXMuJHNlbGVjdGlvbi5maW5kKCcuc2VsZWN0Mi1zZWxlY3Rpb25fX3JlbmRlcmVkJykuZW1wdHkoKTtcbiAgfTtcblxuICBNdWx0aXBsZVNlbGVjdGlvbi5wcm90b3R5cGUuZGlzcGxheSA9IGZ1bmN0aW9uIChkYXRhLCBjb250YWluZXIpIHtcbiAgICB2YXIgdGVtcGxhdGUgPSB0aGlzLm9wdGlvbnMuZ2V0KCd0ZW1wbGF0ZVNlbGVjdGlvbicpO1xuICAgIHZhciBlc2NhcGVNYXJrdXAgPSB0aGlzLm9wdGlvbnMuZ2V0KCdlc2NhcGVNYXJrdXAnKTtcblxuICAgIHJldHVybiBlc2NhcGVNYXJrdXAodGVtcGxhdGUoZGF0YSwgY29udGFpbmVyKSk7XG4gIH07XG5cbiAgTXVsdGlwbGVTZWxlY3Rpb24ucHJvdG90eXBlLnNlbGVjdGlvbkNvbnRhaW5lciA9IGZ1bmN0aW9uICgpIHtcbiAgICB2YXIgJGNvbnRhaW5lciA9ICQoXG4gICAgICAnPGxpIGNsYXNzPVwic2VsZWN0Mi1zZWxlY3Rpb25fX2Nob2ljZVwiPicgK1xuICAgICAgICAnPHNwYW4gY2xhc3M9XCJzZWxlY3QyLXNlbGVjdGlvbl9fY2hvaWNlX19yZW1vdmVcIiByb2xlPVwicHJlc2VudGF0aW9uXCI+JyArXG4gICAgICAgICAgJyZ0aW1lczsnICtcbiAgICAgICAgJzwvc3Bhbj4nICtcbiAgICAgICc8L2xpPidcbiAgICApO1xuXG4gICAgcmV0dXJuICRjb250YWluZXI7XG4gIH07XG5cbiAgTXVsdGlwbGVTZWxlY3Rpb24ucHJvdG90eXBlLnVwZGF0ZSA9IGZ1bmN0aW9uIChkYXRhKSB7XG4gICAgdGhpcy5jbGVhcigpO1xuXG4gICAgaWYgKGRhdGEubGVuZ3RoID09PSAwKSB7XG4gICAgICByZXR1cm47XG4gICAgfVxuXG4gICAgdmFyICRzZWxlY3Rpb25zID0gW107XG5cbiAgICBmb3IgKHZhciBkID0gMDsgZCA8IGRhdGEubGVuZ3RoOyBkKyspIHtcbiAgICAgIHZhciBzZWxlY3Rpb24gPSBkYXRhW2RdO1xuXG4gICAgICB2YXIgJHNlbGVjdGlvbiA9IHRoaXMuc2VsZWN0aW9uQ29udGFpbmVyKCk7XG4gICAgICB2YXIgZm9ybWF0dGVkID0gdGhpcy5kaXNwbGF5KHNlbGVjdGlvbiwgJHNlbGVjdGlvbik7XG5cbiAgICAgICRzZWxlY3Rpb24uYXBwZW5kKGZvcm1hdHRlZCk7XG4gICAgICAkc2VsZWN0aW9uLnByb3AoJ3RpdGxlJywgc2VsZWN0aW9uLnRpdGxlIHx8IHNlbGVjdGlvbi50ZXh0KTtcblxuICAgICAgJHNlbGVjdGlvbi5kYXRhKCdkYXRhJywgc2VsZWN0aW9uKTtcblxuICAgICAgJHNlbGVjdGlvbnMucHVzaCgkc2VsZWN0aW9uKTtcbiAgICB9XG5cbiAgICB2YXIgJHJlbmRlcmVkID0gdGhpcy4kc2VsZWN0aW9uLmZpbmQoJy5zZWxlY3QyLXNlbGVjdGlvbl9fcmVuZGVyZWQnKTtcblxuICAgIFV0aWxzLmFwcGVuZE1hbnkoJHJlbmRlcmVkLCAkc2VsZWN0aW9ucyk7XG4gIH07XG5cbiAgcmV0dXJuIE11bHRpcGxlU2VsZWN0aW9uO1xufSk7XG5cblMyLmRlZmluZSgnc2VsZWN0Mi9zZWxlY3Rpb24vcGxhY2Vob2xkZXInLFtcbiAgJy4uL3V0aWxzJ1xuXSwgZnVuY3Rpb24gKFV0aWxzKSB7XG4gIGZ1bmN0aW9uIFBsYWNlaG9sZGVyIChkZWNvcmF0ZWQsICRlbGVtZW50LCBvcHRpb25zKSB7XG4gICAgdGhpcy5wbGFjZWhvbGRlciA9IHRoaXMubm9ybWFsaXplUGxhY2Vob2xkZXIob3B0aW9ucy5nZXQoJ3BsYWNlaG9sZGVyJykpO1xuXG4gICAgZGVjb3JhdGVkLmNhbGwodGhpcywgJGVsZW1lbnQsIG9wdGlvbnMpO1xuICB9XG5cbiAgUGxhY2Vob2xkZXIucHJvdG90eXBlLm5vcm1hbGl6ZVBsYWNlaG9sZGVyID0gZnVuY3Rpb24gKF8sIHBsYWNlaG9sZGVyKSB7XG4gICAgaWYgKHR5cGVvZiBwbGFjZWhvbGRlciA9PT0gJ3N0cmluZycpIHtcbiAgICAgIHBsYWNlaG9sZGVyID0ge1xuICAgICAgICBpZDogJycsXG4gICAgICAgIHRleHQ6IHBsYWNlaG9sZGVyXG4gICAgICB9O1xuICAgIH1cblxuICAgIHJldHVybiBwbGFjZWhvbGRlcjtcbiAgfTtcblxuICBQbGFjZWhvbGRlci5wcm90b3R5cGUuY3JlYXRlUGxhY2Vob2xkZXIgPSBmdW5jdGlvbiAoZGVjb3JhdGVkLCBwbGFjZWhvbGRlcikge1xuICAgIHZhciAkcGxhY2Vob2xkZXIgPSB0aGlzLnNlbGVjdGlvbkNvbnRhaW5lcigpO1xuXG4gICAgJHBsYWNlaG9sZGVyLmh0bWwodGhpcy5kaXNwbGF5KHBsYWNlaG9sZGVyKSk7XG4gICAgJHBsYWNlaG9sZGVyLmFkZENsYXNzKCdzZWxlY3QyLXNlbGVjdGlvbl9fcGxhY2Vob2xkZXInKVxuICAgICAgICAgICAgICAgIC5yZW1vdmVDbGFzcygnc2VsZWN0Mi1zZWxlY3Rpb25fX2Nob2ljZScpO1xuXG4gICAgcmV0dXJuICRwbGFjZWhvbGRlcjtcbiAgfTtcblxuICBQbGFjZWhvbGRlci5wcm90b3R5cGUudXBkYXRlID0gZnVuY3Rpb24gKGRlY29yYXRlZCwgZGF0YSkge1xuICAgIHZhciBzaW5nbGVQbGFjZWhvbGRlciA9IChcbiAgICAgIGRhdGEubGVuZ3RoID09IDEgJiYgZGF0YVswXS5pZCAhPSB0aGlzLnBsYWNlaG9sZGVyLmlkXG4gICAgKTtcbiAgICB2YXIgbXVsdGlwbGVTZWxlY3Rpb25zID0gZGF0YS5sZW5ndGggPiAxO1xuXG4gICAgaWYgKG11bHRpcGxlU2VsZWN0aW9ucyB8fCBzaW5nbGVQbGFjZWhvbGRlcikge1xuICAgICAgcmV0dXJuIGRlY29yYXRlZC5jYWxsKHRoaXMsIGRhdGEpO1xuICAgIH1cblxuICAgIHRoaXMuY2xlYXIoKTtcblxuICAgIHZhciAkcGxhY2Vob2xkZXIgPSB0aGlzLmNyZWF0ZVBsYWNlaG9sZGVyKHRoaXMucGxhY2Vob2xkZXIpO1xuXG4gICAgdGhpcy4kc2VsZWN0aW9uLmZpbmQoJy5zZWxlY3QyLXNlbGVjdGlvbl9fcmVuZGVyZWQnKS5hcHBlbmQoJHBsYWNlaG9sZGVyKTtcbiAgfTtcblxuICByZXR1cm4gUGxhY2Vob2xkZXI7XG59KTtcblxuUzIuZGVmaW5lKCdzZWxlY3QyL3NlbGVjdGlvbi9hbGxvd0NsZWFyJyxbXG4gICdqcXVlcnknLFxuICAnLi4va2V5cydcbl0sIGZ1bmN0aW9uICgkLCBLRVlTKSB7XG4gIGZ1bmN0aW9uIEFsbG93Q2xlYXIgKCkgeyB9XG5cbiAgQWxsb3dDbGVhci5wcm90b3R5cGUuYmluZCA9IGZ1bmN0aW9uIChkZWNvcmF0ZWQsIGNvbnRhaW5lciwgJGNvbnRhaW5lcikge1xuICAgIHZhciBzZWxmID0gdGhpcztcblxuICAgIGRlY29yYXRlZC5jYWxsKHRoaXMsIGNvbnRhaW5lciwgJGNvbnRhaW5lcik7XG5cbiAgICBpZiAodGhpcy5wbGFjZWhvbGRlciA9PSBudWxsKSB7XG4gICAgICBpZiAodGhpcy5vcHRpb25zLmdldCgnZGVidWcnKSAmJiB3aW5kb3cuY29uc29sZSAmJiBjb25zb2xlLmVycm9yKSB7XG4gICAgICAgIGNvbnNvbGUuZXJyb3IoXG4gICAgICAgICAgJ1NlbGVjdDI6IFRoZSBgYWxsb3dDbGVhcmAgb3B0aW9uIHNob3VsZCBiZSB1c2VkIGluIGNvbWJpbmF0aW9uICcgK1xuICAgICAgICAgICd3aXRoIHRoZSBgcGxhY2Vob2xkZXJgIG9wdGlvbi4nXG4gICAgICAgICk7XG4gICAgICB9XG4gICAgfVxuXG4gICAgdGhpcy4kc2VsZWN0aW9uLm9uKCdtb3VzZWRvd24nLCAnLnNlbGVjdDItc2VsZWN0aW9uX19jbGVhcicsXG4gICAgICBmdW5jdGlvbiAoZXZ0KSB7XG4gICAgICAgIHNlbGYuX2hhbmRsZUNsZWFyKGV2dCk7XG4gICAgfSk7XG5cbiAgICBjb250YWluZXIub24oJ2tleXByZXNzJywgZnVuY3Rpb24gKGV2dCkge1xuICAgICAgc2VsZi5faGFuZGxlS2V5Ym9hcmRDbGVhcihldnQsIGNvbnRhaW5lcik7XG4gICAgfSk7XG4gIH07XG5cbiAgQWxsb3dDbGVhci5wcm90b3R5cGUuX2hhbmRsZUNsZWFyID0gZnVuY3Rpb24gKF8sIGV2dCkge1xuICAgIC8vIElnbm9yZSB0aGUgZXZlbnQgaWYgaXQgaXMgZGlzYWJsZWRcbiAgICBpZiAodGhpcy5vcHRpb25zLmdldCgnZGlzYWJsZWQnKSkge1xuICAgICAgcmV0dXJuO1xuICAgIH1cblxuICAgIHZhciAkY2xlYXIgPSB0aGlzLiRzZWxlY3Rpb24uZmluZCgnLnNlbGVjdDItc2VsZWN0aW9uX19jbGVhcicpO1xuXG4gICAgLy8gSWdub3JlIHRoZSBldmVudCBpZiBub3RoaW5nIGhhcyBiZWVuIHNlbGVjdGVkXG4gICAgaWYgKCRjbGVhci5sZW5ndGggPT09IDApIHtcbiAgICAgIHJldHVybjtcbiAgICB9XG5cbiAgICBldnQuc3RvcFByb3BhZ2F0aW9uKCk7XG5cbiAgICB2YXIgZGF0YSA9ICRjbGVhci5kYXRhKCdkYXRhJyk7XG5cbiAgICBmb3IgKHZhciBkID0gMDsgZCA8IGRhdGEubGVuZ3RoOyBkKyspIHtcbiAgICAgIHZhciB1bnNlbGVjdERhdGEgPSB7XG4gICAgICAgIGRhdGE6IGRhdGFbZF1cbiAgICAgIH07XG5cbiAgICAgIC8vIFRyaWdnZXIgdGhlIGB1bnNlbGVjdGAgZXZlbnQsIHNvIHBlb3BsZSBjYW4gcHJldmVudCBpdCBmcm9tIGJlaW5nXG4gICAgICAvLyBjbGVhcmVkLlxuICAgICAgdGhpcy50cmlnZ2VyKCd1bnNlbGVjdCcsIHVuc2VsZWN0RGF0YSk7XG5cbiAgICAgIC8vIElmIHRoZSBldmVudCB3YXMgcHJldmVudGVkLCBkb24ndCBjbGVhciBpdCBvdXQuXG4gICAgICBpZiAodW5zZWxlY3REYXRhLnByZXZlbnRlZCkge1xuICAgICAgICByZXR1cm47XG4gICAgICB9XG4gICAgfVxuXG4gICAgdGhpcy4kZWxlbWVudC52YWwodGhpcy5wbGFjZWhvbGRlci5pZCkudHJpZ2dlcignY2hhbmdlJyk7XG5cbiAgICB0aGlzLnRyaWdnZXIoJ3RvZ2dsZScsIHt9KTtcbiAgfTtcblxuICBBbGxvd0NsZWFyLnByb3RvdHlwZS5faGFuZGxlS2V5Ym9hcmRDbGVhciA9IGZ1bmN0aW9uIChfLCBldnQsIGNvbnRhaW5lcikge1xuICAgIGlmIChjb250YWluZXIuaXNPcGVuKCkpIHtcbiAgICAgIHJldHVybjtcbiAgICB9XG5cbiAgICBpZiAoZXZ0LndoaWNoID09IEtFWVMuREVMRVRFIHx8IGV2dC53aGljaCA9PSBLRVlTLkJBQ0tTUEFDRSkge1xuICAgICAgdGhpcy5faGFuZGxlQ2xlYXIoZXZ0KTtcbiAgICB9XG4gIH07XG5cbiAgQWxsb3dDbGVhci5wcm90b3R5cGUudXBkYXRlID0gZnVuY3Rpb24gKGRlY29yYXRlZCwgZGF0YSkge1xuICAgIGRlY29yYXRlZC5jYWxsKHRoaXMsIGRhdGEpO1xuXG4gICAgaWYgKHRoaXMuJHNlbGVjdGlvbi5maW5kKCcuc2VsZWN0Mi1zZWxlY3Rpb25fX3BsYWNlaG9sZGVyJykubGVuZ3RoID4gMCB8fFxuICAgICAgICBkYXRhLmxlbmd0aCA9PT0gMCkge1xuICAgICAgcmV0dXJuO1xuICAgIH1cblxuICAgIHZhciAkcmVtb3ZlID0gJChcbiAgICAgICc8c3BhbiBjbGFzcz1cInNlbGVjdDItc2VsZWN0aW9uX19jbGVhclwiPicgK1xuICAgICAgICAnJnRpbWVzOycgK1xuICAgICAgJzwvc3Bhbj4nXG4gICAgKTtcbiAgICAkcmVtb3ZlLmRhdGEoJ2RhdGEnLCBkYXRhKTtcblxuICAgIHRoaXMuJHNlbGVjdGlvbi5maW5kKCcuc2VsZWN0Mi1zZWxlY3Rpb25fX3JlbmRlcmVkJykucHJlcGVuZCgkcmVtb3ZlKTtcbiAgfTtcblxuICByZXR1cm4gQWxsb3dDbGVhcjtcbn0pO1xuXG5TMi5kZWZpbmUoJ3NlbGVjdDIvc2VsZWN0aW9uL3NlYXJjaCcsW1xuICAnanF1ZXJ5JyxcbiAgJy4uL3V0aWxzJyxcbiAgJy4uL2tleXMnXG5dLCBmdW5jdGlvbiAoJCwgVXRpbHMsIEtFWVMpIHtcbiAgZnVuY3Rpb24gU2VhcmNoIChkZWNvcmF0ZWQsICRlbGVtZW50LCBvcHRpb25zKSB7XG4gICAgZGVjb3JhdGVkLmNhbGwodGhpcywgJGVsZW1lbnQsIG9wdGlvbnMpO1xuICB9XG5cbiAgU2VhcmNoLnByb3RvdHlwZS5yZW5kZXIgPSBmdW5jdGlvbiAoZGVjb3JhdGVkKSB7XG4gICAgdmFyICRzZWFyY2ggPSAkKFxuICAgICAgJzxsaSBjbGFzcz1cInNlbGVjdDItc2VhcmNoIHNlbGVjdDItc2VhcmNoLS1pbmxpbmVcIj4nICtcbiAgICAgICAgJzxpbnB1dCBjbGFzcz1cInNlbGVjdDItc2VhcmNoX19maWVsZFwiIHR5cGU9XCJzZWFyY2hcIiB0YWJpbmRleD1cIi0xXCInICtcbiAgICAgICAgJyBhdXRvY29tcGxldGU9XCJvZmZcIiBhdXRvY29ycmVjdD1cIm9mZlwiIGF1dG9jYXBpdGFsaXplPVwibm9uZVwiJyArXG4gICAgICAgICcgc3BlbGxjaGVjaz1cImZhbHNlXCIgcm9sZT1cInRleHRib3hcIiBhcmlhLWF1dG9jb21wbGV0ZT1cImxpc3RcIiAvPicgK1xuICAgICAgJzwvbGk+J1xuICAgICk7XG5cbiAgICB0aGlzLiRzZWFyY2hDb250YWluZXIgPSAkc2VhcmNoO1xuICAgIHRoaXMuJHNlYXJjaCA9ICRzZWFyY2guZmluZCgnaW5wdXQnKTtcblxuICAgIHZhciAkcmVuZGVyZWQgPSBkZWNvcmF0ZWQuY2FsbCh0aGlzKTtcblxuICAgIHRoaXMuX3RyYW5zZmVyVGFiSW5kZXgoKTtcblxuICAgIHJldHVybiAkcmVuZGVyZWQ7XG4gIH07XG5cbiAgU2VhcmNoLnByb3RvdHlwZS5iaW5kID0gZnVuY3Rpb24gKGRlY29yYXRlZCwgY29udGFpbmVyLCAkY29udGFpbmVyKSB7XG4gICAgdmFyIHNlbGYgPSB0aGlzO1xuXG4gICAgZGVjb3JhdGVkLmNhbGwodGhpcywgY29udGFpbmVyLCAkY29udGFpbmVyKTtcblxuICAgIGNvbnRhaW5lci5vbignb3BlbicsIGZ1bmN0aW9uICgpIHtcbiAgICAgIHNlbGYuJHNlYXJjaC50cmlnZ2VyKCdmb2N1cycpO1xuICAgIH0pO1xuXG4gICAgY29udGFpbmVyLm9uKCdjbG9zZScsIGZ1bmN0aW9uICgpIHtcbiAgICAgIHNlbGYuJHNlYXJjaC52YWwoJycpO1xuICAgICAgc2VsZi4kc2VhcmNoLnJlbW92ZUF0dHIoJ2FyaWEtYWN0aXZlZGVzY2VuZGFudCcpO1xuICAgICAgc2VsZi4kc2VhcmNoLnRyaWdnZXIoJ2ZvY3VzJyk7XG4gICAgfSk7XG5cbiAgICBjb250YWluZXIub24oJ2VuYWJsZScsIGZ1bmN0aW9uICgpIHtcbiAgICAgIHNlbGYuJHNlYXJjaC5wcm9wKCdkaXNhYmxlZCcsIGZhbHNlKTtcblxuICAgICAgc2VsZi5fdHJhbnNmZXJUYWJJbmRleCgpO1xuICAgIH0pO1xuXG4gICAgY29udGFpbmVyLm9uKCdkaXNhYmxlJywgZnVuY3Rpb24gKCkge1xuICAgICAgc2VsZi4kc2VhcmNoLnByb3AoJ2Rpc2FibGVkJywgdHJ1ZSk7XG4gICAgfSk7XG5cbiAgICBjb250YWluZXIub24oJ2ZvY3VzJywgZnVuY3Rpb24gKGV2dCkge1xuICAgICAgc2VsZi4kc2VhcmNoLnRyaWdnZXIoJ2ZvY3VzJyk7XG4gICAgfSk7XG5cbiAgICBjb250YWluZXIub24oJ3Jlc3VsdHM6Zm9jdXMnLCBmdW5jdGlvbiAocGFyYW1zKSB7XG4gICAgICBzZWxmLiRzZWFyY2guYXR0cignYXJpYS1hY3RpdmVkZXNjZW5kYW50JywgcGFyYW1zLmlkKTtcbiAgICB9KTtcblxuICAgIHRoaXMuJHNlbGVjdGlvbi5vbignZm9jdXNpbicsICcuc2VsZWN0Mi1zZWFyY2gtLWlubGluZScsIGZ1bmN0aW9uIChldnQpIHtcbiAgICAgIHNlbGYudHJpZ2dlcignZm9jdXMnLCBldnQpO1xuICAgIH0pO1xuXG4gICAgdGhpcy4kc2VsZWN0aW9uLm9uKCdmb2N1c291dCcsICcuc2VsZWN0Mi1zZWFyY2gtLWlubGluZScsIGZ1bmN0aW9uIChldnQpIHtcbiAgICAgIHNlbGYuX2hhbmRsZUJsdXIoZXZ0KTtcbiAgICB9KTtcblxuICAgIHRoaXMuJHNlbGVjdGlvbi5vbigna2V5ZG93bicsICcuc2VsZWN0Mi1zZWFyY2gtLWlubGluZScsIGZ1bmN0aW9uIChldnQpIHtcbiAgICAgIGV2dC5zdG9wUHJvcGFnYXRpb24oKTtcblxuICAgICAgc2VsZi50cmlnZ2VyKCdrZXlwcmVzcycsIGV2dCk7XG5cbiAgICAgIHNlbGYuX2tleVVwUHJldmVudGVkID0gZXZ0LmlzRGVmYXVsdFByZXZlbnRlZCgpO1xuXG4gICAgICB2YXIga2V5ID0gZXZ0LndoaWNoO1xuXG4gICAgICBpZiAoa2V5ID09PSBLRVlTLkJBQ0tTUEFDRSAmJiBzZWxmLiRzZWFyY2gudmFsKCkgPT09ICcnKSB7XG4gICAgICAgIHZhciAkcHJldmlvdXNDaG9pY2UgPSBzZWxmLiRzZWFyY2hDb250YWluZXJcbiAgICAgICAgICAucHJldignLnNlbGVjdDItc2VsZWN0aW9uX19jaG9pY2UnKTtcblxuICAgICAgICBpZiAoJHByZXZpb3VzQ2hvaWNlLmxlbmd0aCA+IDApIHtcbiAgICAgICAgICB2YXIgaXRlbSA9ICRwcmV2aW91c0Nob2ljZS5kYXRhKCdkYXRhJyk7XG5cbiAgICAgICAgICBzZWxmLnNlYXJjaFJlbW92ZUNob2ljZShpdGVtKTtcblxuICAgICAgICAgIGV2dC5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICB9XG4gICAgICB9XG4gICAgfSk7XG5cbiAgICAvLyBUcnkgdG8gZGV0ZWN0IHRoZSBJRSB2ZXJzaW9uIHNob3VsZCB0aGUgYGRvY3VtZW50TW9kZWAgcHJvcGVydHkgdGhhdFxuICAgIC8vIGlzIHN0b3JlZCBvbiB0aGUgZG9jdW1lbnQuIFRoaXMgaXMgb25seSBpbXBsZW1lbnRlZCBpbiBJRSBhbmQgaXNcbiAgICAvLyBzbGlnaHRseSBjbGVhbmVyIHRoYW4gZG9pbmcgYSB1c2VyIGFnZW50IGNoZWNrLlxuICAgIC8vIFRoaXMgcHJvcGVydHkgaXMgbm90IGF2YWlsYWJsZSBpbiBFZGdlLCBidXQgRWRnZSBhbHNvIGRvZXNuJ3QgaGF2ZVxuICAgIC8vIHRoaXMgYnVnLlxuICAgIHZhciBtc2llID0gZG9jdW1lbnQuZG9jdW1lbnRNb2RlO1xuICAgIHZhciBkaXNhYmxlSW5wdXRFdmVudHMgPSBtc2llICYmIG1zaWUgPD0gMTE7XG5cbiAgICAvLyBXb3JrYXJvdW5kIGZvciBicm93c2VycyB3aGljaCBkbyBub3Qgc3VwcG9ydCB0aGUgYGlucHV0YCBldmVudFxuICAgIC8vIFRoaXMgd2lsbCBwcmV2ZW50IGRvdWJsZS10cmlnZ2VyaW5nIG9mIGV2ZW50cyBmb3IgYnJvd3NlcnMgd2hpY2ggc3VwcG9ydFxuICAgIC8vIGJvdGggdGhlIGBrZXl1cGAgYW5kIGBpbnB1dGAgZXZlbnRzLlxuICAgIHRoaXMuJHNlbGVjdGlvbi5vbihcbiAgICAgICdpbnB1dC5zZWFyY2hjaGVjaycsXG4gICAgICAnLnNlbGVjdDItc2VhcmNoLS1pbmxpbmUnLFxuICAgICAgZnVuY3Rpb24gKGV2dCkge1xuICAgICAgICAvLyBJRSB3aWxsIHRyaWdnZXIgdGhlIGBpbnB1dGAgZXZlbnQgd2hlbiBhIHBsYWNlaG9sZGVyIGlzIHVzZWQgb24gYVxuICAgICAgICAvLyBzZWFyY2ggYm94LiBUbyBnZXQgYXJvdW5kIHRoaXMgaXNzdWUsIHdlIGFyZSBmb3JjZWQgdG8gaWdub3JlIGFsbFxuICAgICAgICAvLyBgaW5wdXRgIGV2ZW50cyBpbiBJRSBhbmQga2VlcCB1c2luZyBga2V5dXBgLlxuICAgICAgICBpZiAoZGlzYWJsZUlucHV0RXZlbnRzKSB7XG4gICAgICAgICAgc2VsZi4kc2VsZWN0aW9uLm9mZignaW5wdXQuc2VhcmNoIGlucHV0LnNlYXJjaGNoZWNrJyk7XG4gICAgICAgICAgcmV0dXJuO1xuICAgICAgICB9XG5cbiAgICAgICAgLy8gVW5iaW5kIHRoZSBkdXBsaWNhdGVkIGBrZXl1cGAgZXZlbnRcbiAgICAgICAgc2VsZi4kc2VsZWN0aW9uLm9mZigna2V5dXAuc2VhcmNoJyk7XG4gICAgICB9XG4gICAgKTtcblxuICAgIHRoaXMuJHNlbGVjdGlvbi5vbihcbiAgICAgICdrZXl1cC5zZWFyY2ggaW5wdXQuc2VhcmNoJyxcbiAgICAgICcuc2VsZWN0Mi1zZWFyY2gtLWlubGluZScsXG4gICAgICBmdW5jdGlvbiAoZXZ0KSB7XG4gICAgICAgIC8vIElFIHdpbGwgdHJpZ2dlciB0aGUgYGlucHV0YCBldmVudCB3aGVuIGEgcGxhY2Vob2xkZXIgaXMgdXNlZCBvbiBhXG4gICAgICAgIC8vIHNlYXJjaCBib3guIFRvIGdldCBhcm91bmQgdGhpcyBpc3N1ZSwgd2UgYXJlIGZvcmNlZCB0byBpZ25vcmUgYWxsXG4gICAgICAgIC8vIGBpbnB1dGAgZXZlbnRzIGluIElFIGFuZCBrZWVwIHVzaW5nIGBrZXl1cGAuXG4gICAgICAgIGlmIChkaXNhYmxlSW5wdXRFdmVudHMgJiYgZXZ0LnR5cGUgPT09ICdpbnB1dCcpIHtcbiAgICAgICAgICBzZWxmLiRzZWxlY3Rpb24ub2ZmKCdpbnB1dC5zZWFyY2ggaW5wdXQuc2VhcmNoY2hlY2snKTtcbiAgICAgICAgICByZXR1cm47XG4gICAgICAgIH1cblxuICAgICAgICB2YXIga2V5ID0gZXZ0LndoaWNoO1xuXG4gICAgICAgIC8vIFdlIGNhbiBmcmVlbHkgaWdub3JlIGV2ZW50cyBmcm9tIG1vZGlmaWVyIGtleXNcbiAgICAgICAgaWYgKGtleSA9PSBLRVlTLlNISUZUIHx8IGtleSA9PSBLRVlTLkNUUkwgfHwga2V5ID09IEtFWVMuQUxUKSB7XG4gICAgICAgICAgcmV0dXJuO1xuICAgICAgICB9XG5cbiAgICAgICAgLy8gVGFiYmluZyB3aWxsIGJlIGhhbmRsZWQgZHVyaW5nIHRoZSBga2V5ZG93bmAgcGhhc2VcbiAgICAgICAgaWYgKGtleSA9PSBLRVlTLlRBQikge1xuICAgICAgICAgIHJldHVybjtcbiAgICAgICAgfVxuXG4gICAgICAgIHNlbGYuaGFuZGxlU2VhcmNoKGV2dCk7XG4gICAgICB9XG4gICAgKTtcbiAgfTtcblxuICAvKipcbiAgICogVGhpcyBtZXRob2Qgd2lsbCB0cmFuc2ZlciB0aGUgdGFiaW5kZXggYXR0cmlidXRlIGZyb20gdGhlIHJlbmRlcmVkXG4gICAqIHNlbGVjdGlvbiB0byB0aGUgc2VhcmNoIGJveC4gVGhpcyBhbGxvd3MgZm9yIHRoZSBzZWFyY2ggYm94IHRvIGJlIHVzZWQgYXNcbiAgICogdGhlIHByaW1hcnkgZm9jdXMgaW5zdGVhZCBvZiB0aGUgc2VsZWN0aW9uIGNvbnRhaW5lci5cbiAgICpcbiAgICogQHByaXZhdGVcbiAgICovXG4gIFNlYXJjaC5wcm90b3R5cGUuX3RyYW5zZmVyVGFiSW5kZXggPSBmdW5jdGlvbiAoZGVjb3JhdGVkKSB7XG4gICAgdGhpcy4kc2VhcmNoLmF0dHIoJ3RhYmluZGV4JywgdGhpcy4kc2VsZWN0aW9uLmF0dHIoJ3RhYmluZGV4JykpO1xuICAgIHRoaXMuJHNlbGVjdGlvbi5hdHRyKCd0YWJpbmRleCcsICctMScpO1xuICB9O1xuXG4gIFNlYXJjaC5wcm90b3R5cGUuY3JlYXRlUGxhY2Vob2xkZXIgPSBmdW5jdGlvbiAoZGVjb3JhdGVkLCBwbGFjZWhvbGRlcikge1xuICAgIHRoaXMuJHNlYXJjaC5hdHRyKCdwbGFjZWhvbGRlcicsIHBsYWNlaG9sZGVyLnRleHQpO1xuICB9O1xuXG4gIFNlYXJjaC5wcm90b3R5cGUudXBkYXRlID0gZnVuY3Rpb24gKGRlY29yYXRlZCwgZGF0YSkge1xuICAgIHZhciBzZWFyY2hIYWRGb2N1cyA9IHRoaXMuJHNlYXJjaFswXSA9PSBkb2N1bWVudC5hY3RpdmVFbGVtZW50O1xuXG4gICAgdGhpcy4kc2VhcmNoLmF0dHIoJ3BsYWNlaG9sZGVyJywgJycpO1xuXG4gICAgZGVjb3JhdGVkLmNhbGwodGhpcywgZGF0YSk7XG5cbiAgICB0aGlzLiRzZWxlY3Rpb24uZmluZCgnLnNlbGVjdDItc2VsZWN0aW9uX19yZW5kZXJlZCcpXG4gICAgICAgICAgICAgICAgICAgLmFwcGVuZCh0aGlzLiRzZWFyY2hDb250YWluZXIpO1xuXG4gICAgdGhpcy5yZXNpemVTZWFyY2goKTtcbiAgICBpZiAoc2VhcmNoSGFkRm9jdXMpIHtcbiAgICAgIHRoaXMuJHNlYXJjaC5mb2N1cygpO1xuICAgIH1cbiAgfTtcblxuICBTZWFyY2gucHJvdG90eXBlLmhhbmRsZVNlYXJjaCA9IGZ1bmN0aW9uICgpIHtcbiAgICB0aGlzLnJlc2l6ZVNlYXJjaCgpO1xuXG4gICAgaWYgKCF0aGlzLl9rZXlVcFByZXZlbnRlZCkge1xuICAgICAgdmFyIGlucHV0ID0gdGhpcy4kc2VhcmNoLnZhbCgpO1xuXG4gICAgICB0aGlzLnRyaWdnZXIoJ3F1ZXJ5Jywge1xuICAgICAgICB0ZXJtOiBpbnB1dFxuICAgICAgfSk7XG4gICAgfVxuXG4gICAgdGhpcy5fa2V5VXBQcmV2ZW50ZWQgPSBmYWxzZTtcbiAgfTtcblxuICBTZWFyY2gucHJvdG90eXBlLnNlYXJjaFJlbW92ZUNob2ljZSA9IGZ1bmN0aW9uIChkZWNvcmF0ZWQsIGl0ZW0pIHtcbiAgICB0aGlzLnRyaWdnZXIoJ3Vuc2VsZWN0Jywge1xuICAgICAgZGF0YTogaXRlbVxuICAgIH0pO1xuXG4gICAgdGhpcy4kc2VhcmNoLnZhbChpdGVtLnRleHQpO1xuICAgIHRoaXMuaGFuZGxlU2VhcmNoKCk7XG4gIH07XG5cbiAgU2VhcmNoLnByb3RvdHlwZS5yZXNpemVTZWFyY2ggPSBmdW5jdGlvbiAoKSB7XG4gICAgdGhpcy4kc2VhcmNoLmNzcygnd2lkdGgnLCAnMjVweCcpO1xuXG4gICAgdmFyIHdpZHRoID0gJyc7XG5cbiAgICBpZiAodGhpcy4kc2VhcmNoLmF0dHIoJ3BsYWNlaG9sZGVyJykgIT09ICcnKSB7XG4gICAgICB3aWR0aCA9IHRoaXMuJHNlbGVjdGlvbi5maW5kKCcuc2VsZWN0Mi1zZWxlY3Rpb25fX3JlbmRlcmVkJykuaW5uZXJXaWR0aCgpO1xuICAgIH0gZWxzZSB7XG4gICAgICB2YXIgbWluaW11bVdpZHRoID0gdGhpcy4kc2VhcmNoLnZhbCgpLmxlbmd0aCArIDE7XG5cbiAgICAgIHdpZHRoID0gKG1pbmltdW1XaWR0aCAqIDAuNzUpICsgJ2VtJztcbiAgICB9XG5cbiAgICB0aGlzLiRzZWFyY2guY3NzKCd3aWR0aCcsIHdpZHRoKTtcbiAgfTtcblxuICByZXR1cm4gU2VhcmNoO1xufSk7XG5cblMyLmRlZmluZSgnc2VsZWN0Mi9zZWxlY3Rpb24vZXZlbnRSZWxheScsW1xuICAnanF1ZXJ5J1xuXSwgZnVuY3Rpb24gKCQpIHtcbiAgZnVuY3Rpb24gRXZlbnRSZWxheSAoKSB7IH1cblxuICBFdmVudFJlbGF5LnByb3RvdHlwZS5iaW5kID0gZnVuY3Rpb24gKGRlY29yYXRlZCwgY29udGFpbmVyLCAkY29udGFpbmVyKSB7XG4gICAgdmFyIHNlbGYgPSB0aGlzO1xuICAgIHZhciByZWxheUV2ZW50cyA9IFtcbiAgICAgICdvcGVuJywgJ29wZW5pbmcnLFxuICAgICAgJ2Nsb3NlJywgJ2Nsb3NpbmcnLFxuICAgICAgJ3NlbGVjdCcsICdzZWxlY3RpbmcnLFxuICAgICAgJ3Vuc2VsZWN0JywgJ3Vuc2VsZWN0aW5nJ1xuICAgIF07XG5cbiAgICB2YXIgcHJldmVudGFibGVFdmVudHMgPSBbJ29wZW5pbmcnLCAnY2xvc2luZycsICdzZWxlY3RpbmcnLCAndW5zZWxlY3RpbmcnXTtcblxuICAgIGRlY29yYXRlZC5jYWxsKHRoaXMsIGNvbnRhaW5lciwgJGNvbnRhaW5lcik7XG5cbiAgICBjb250YWluZXIub24oJyonLCBmdW5jdGlvbiAobmFtZSwgcGFyYW1zKSB7XG4gICAgICAvLyBJZ25vcmUgZXZlbnRzIHRoYXQgc2hvdWxkIG5vdCBiZSByZWxheWVkXG4gICAgICBpZiAoJC5pbkFycmF5KG5hbWUsIHJlbGF5RXZlbnRzKSA9PT0gLTEpIHtcbiAgICAgICAgcmV0dXJuO1xuICAgICAgfVxuXG4gICAgICAvLyBUaGUgcGFyYW1ldGVycyBzaG91bGQgYWx3YXlzIGJlIGFuIG9iamVjdFxuICAgICAgcGFyYW1zID0gcGFyYW1zIHx8IHt9O1xuXG4gICAgICAvLyBHZW5lcmF0ZSB0aGUgalF1ZXJ5IGV2ZW50IGZvciB0aGUgU2VsZWN0MiBldmVudFxuICAgICAgdmFyIGV2dCA9ICQuRXZlbnQoJ3NlbGVjdDI6JyArIG5hbWUsIHtcbiAgICAgICAgcGFyYW1zOiBwYXJhbXNcbiAgICAgIH0pO1xuXG4gICAgICBzZWxmLiRlbGVtZW50LnRyaWdnZXIoZXZ0KTtcblxuICAgICAgLy8gT25seSBoYW5kbGUgcHJldmVudGFibGUgZXZlbnRzIGlmIGl0IHdhcyBvbmVcbiAgICAgIGlmICgkLmluQXJyYXkobmFtZSwgcHJldmVudGFibGVFdmVudHMpID09PSAtMSkge1xuICAgICAgICByZXR1cm47XG4gICAgICB9XG5cbiAgICAgIHBhcmFtcy5wcmV2ZW50ZWQgPSBldnQuaXNEZWZhdWx0UHJldmVudGVkKCk7XG4gICAgfSk7XG4gIH07XG5cbiAgcmV0dXJuIEV2ZW50UmVsYXk7XG59KTtcblxuUzIuZGVmaW5lKCdzZWxlY3QyL3RyYW5zbGF0aW9uJyxbXG4gICdqcXVlcnknLFxuICAncmVxdWlyZSdcbl0sIGZ1bmN0aW9uICgkLCByZXF1aXJlKSB7XG4gIGZ1bmN0aW9uIFRyYW5zbGF0aW9uIChkaWN0KSB7XG4gICAgdGhpcy5kaWN0ID0gZGljdCB8fCB7fTtcbiAgfVxuXG4gIFRyYW5zbGF0aW9uLnByb3RvdHlwZS5hbGwgPSBmdW5jdGlvbiAoKSB7XG4gICAgcmV0dXJuIHRoaXMuZGljdDtcbiAgfTtcblxuICBUcmFuc2xhdGlvbi5wcm90b3R5cGUuZ2V0ID0gZnVuY3Rpb24gKGtleSkge1xuICAgIHJldHVybiB0aGlzLmRpY3Rba2V5XTtcbiAgfTtcblxuICBUcmFuc2xhdGlvbi5wcm90b3R5cGUuZXh0ZW5kID0gZnVuY3Rpb24gKHRyYW5zbGF0aW9uKSB7XG4gICAgdGhpcy5kaWN0ID0gJC5leHRlbmQoe30sIHRyYW5zbGF0aW9uLmFsbCgpLCB0aGlzLmRpY3QpO1xuICB9O1xuXG4gIC8vIFN0YXRpYyBmdW5jdGlvbnNcblxuICBUcmFuc2xhdGlvbi5fY2FjaGUgPSB7fTtcblxuICBUcmFuc2xhdGlvbi5sb2FkUGF0aCA9IGZ1bmN0aW9uIChwYXRoKSB7XG4gICAgaWYgKCEocGF0aCBpbiBUcmFuc2xhdGlvbi5fY2FjaGUpKSB7XG4gICAgICB2YXIgdHJhbnNsYXRpb25zID0gcmVxdWlyZShwYXRoKTtcblxuICAgICAgVHJhbnNsYXRpb24uX2NhY2hlW3BhdGhdID0gdHJhbnNsYXRpb25zO1xuICAgIH1cblxuICAgIHJldHVybiBuZXcgVHJhbnNsYXRpb24oVHJhbnNsYXRpb24uX2NhY2hlW3BhdGhdKTtcbiAgfTtcblxuICByZXR1cm4gVHJhbnNsYXRpb247XG59KTtcblxuUzIuZGVmaW5lKCdzZWxlY3QyL2RpYWNyaXRpY3MnLFtcblxuXSwgZnVuY3Rpb24gKCkge1xuICB2YXIgZGlhY3JpdGljcyA9IHtcbiAgICAnXFx1MjRCNic6ICdBJyxcbiAgICAnXFx1RkYyMSc6ICdBJyxcbiAgICAnXFx1MDBDMCc6ICdBJyxcbiAgICAnXFx1MDBDMSc6ICdBJyxcbiAgICAnXFx1MDBDMic6ICdBJyxcbiAgICAnXFx1MUVBNic6ICdBJyxcbiAgICAnXFx1MUVBNCc6ICdBJyxcbiAgICAnXFx1MUVBQSc6ICdBJyxcbiAgICAnXFx1MUVBOCc6ICdBJyxcbiAgICAnXFx1MDBDMyc6ICdBJyxcbiAgICAnXFx1MDEwMCc6ICdBJyxcbiAgICAnXFx1MDEwMic6ICdBJyxcbiAgICAnXFx1MUVCMCc6ICdBJyxcbiAgICAnXFx1MUVBRSc6ICdBJyxcbiAgICAnXFx1MUVCNCc6ICdBJyxcbiAgICAnXFx1MUVCMic6ICdBJyxcbiAgICAnXFx1MDIyNic6ICdBJyxcbiAgICAnXFx1MDFFMCc6ICdBJyxcbiAgICAnXFx1MDBDNCc6ICdBJyxcbiAgICAnXFx1MDFERSc6ICdBJyxcbiAgICAnXFx1MUVBMic6ICdBJyxcbiAgICAnXFx1MDBDNSc6ICdBJyxcbiAgICAnXFx1MDFGQSc6ICdBJyxcbiAgICAnXFx1MDFDRCc6ICdBJyxcbiAgICAnXFx1MDIwMCc6ICdBJyxcbiAgICAnXFx1MDIwMic6ICdBJyxcbiAgICAnXFx1MUVBMCc6ICdBJyxcbiAgICAnXFx1MUVBQyc6ICdBJyxcbiAgICAnXFx1MUVCNic6ICdBJyxcbiAgICAnXFx1MUUwMCc6ICdBJyxcbiAgICAnXFx1MDEwNCc6ICdBJyxcbiAgICAnXFx1MDIzQSc6ICdBJyxcbiAgICAnXFx1MkM2Ric6ICdBJyxcbiAgICAnXFx1QTczMic6ICdBQScsXG4gICAgJ1xcdTAwQzYnOiAnQUUnLFxuICAgICdcXHUwMUZDJzogJ0FFJyxcbiAgICAnXFx1MDFFMic6ICdBRScsXG4gICAgJ1xcdUE3MzQnOiAnQU8nLFxuICAgICdcXHVBNzM2JzogJ0FVJyxcbiAgICAnXFx1QTczOCc6ICdBVicsXG4gICAgJ1xcdUE3M0EnOiAnQVYnLFxuICAgICdcXHVBNzNDJzogJ0FZJyxcbiAgICAnXFx1MjRCNyc6ICdCJyxcbiAgICAnXFx1RkYyMic6ICdCJyxcbiAgICAnXFx1MUUwMic6ICdCJyxcbiAgICAnXFx1MUUwNCc6ICdCJyxcbiAgICAnXFx1MUUwNic6ICdCJyxcbiAgICAnXFx1MDI0Myc6ICdCJyxcbiAgICAnXFx1MDE4Mic6ICdCJyxcbiAgICAnXFx1MDE4MSc6ICdCJyxcbiAgICAnXFx1MjRCOCc6ICdDJyxcbiAgICAnXFx1RkYyMyc6ICdDJyxcbiAgICAnXFx1MDEwNic6ICdDJyxcbiAgICAnXFx1MDEwOCc6ICdDJyxcbiAgICAnXFx1MDEwQSc6ICdDJyxcbiAgICAnXFx1MDEwQyc6ICdDJyxcbiAgICAnXFx1MDBDNyc6ICdDJyxcbiAgICAnXFx1MUUwOCc6ICdDJyxcbiAgICAnXFx1MDE4Nyc6ICdDJyxcbiAgICAnXFx1MDIzQic6ICdDJyxcbiAgICAnXFx1QTczRSc6ICdDJyxcbiAgICAnXFx1MjRCOSc6ICdEJyxcbiAgICAnXFx1RkYyNCc6ICdEJyxcbiAgICAnXFx1MUUwQSc6ICdEJyxcbiAgICAnXFx1MDEwRSc6ICdEJyxcbiAgICAnXFx1MUUwQyc6ICdEJyxcbiAgICAnXFx1MUUxMCc6ICdEJyxcbiAgICAnXFx1MUUxMic6ICdEJyxcbiAgICAnXFx1MUUwRSc6ICdEJyxcbiAgICAnXFx1MDExMCc6ICdEJyxcbiAgICAnXFx1MDE4Qic6ICdEJyxcbiAgICAnXFx1MDE4QSc6ICdEJyxcbiAgICAnXFx1MDE4OSc6ICdEJyxcbiAgICAnXFx1QTc3OSc6ICdEJyxcbiAgICAnXFx1MDFGMSc6ICdEWicsXG4gICAgJ1xcdTAxQzQnOiAnRFonLFxuICAgICdcXHUwMUYyJzogJ0R6JyxcbiAgICAnXFx1MDFDNSc6ICdEeicsXG4gICAgJ1xcdTI0QkEnOiAnRScsXG4gICAgJ1xcdUZGMjUnOiAnRScsXG4gICAgJ1xcdTAwQzgnOiAnRScsXG4gICAgJ1xcdTAwQzknOiAnRScsXG4gICAgJ1xcdTAwQ0EnOiAnRScsXG4gICAgJ1xcdTFFQzAnOiAnRScsXG4gICAgJ1xcdTFFQkUnOiAnRScsXG4gICAgJ1xcdTFFQzQnOiAnRScsXG4gICAgJ1xcdTFFQzInOiAnRScsXG4gICAgJ1xcdTFFQkMnOiAnRScsXG4gICAgJ1xcdTAxMTInOiAnRScsXG4gICAgJ1xcdTFFMTQnOiAnRScsXG4gICAgJ1xcdTFFMTYnOiAnRScsXG4gICAgJ1xcdTAxMTQnOiAnRScsXG4gICAgJ1xcdTAxMTYnOiAnRScsXG4gICAgJ1xcdTAwQ0InOiAnRScsXG4gICAgJ1xcdTFFQkEnOiAnRScsXG4gICAgJ1xcdTAxMUEnOiAnRScsXG4gICAgJ1xcdTAyMDQnOiAnRScsXG4gICAgJ1xcdTAyMDYnOiAnRScsXG4gICAgJ1xcdTFFQjgnOiAnRScsXG4gICAgJ1xcdTFFQzYnOiAnRScsXG4gICAgJ1xcdTAyMjgnOiAnRScsXG4gICAgJ1xcdTFFMUMnOiAnRScsXG4gICAgJ1xcdTAxMTgnOiAnRScsXG4gICAgJ1xcdTFFMTgnOiAnRScsXG4gICAgJ1xcdTFFMUEnOiAnRScsXG4gICAgJ1xcdTAxOTAnOiAnRScsXG4gICAgJ1xcdTAxOEUnOiAnRScsXG4gICAgJ1xcdTI0QkInOiAnRicsXG4gICAgJ1xcdUZGMjYnOiAnRicsXG4gICAgJ1xcdTFFMUUnOiAnRicsXG4gICAgJ1xcdTAxOTEnOiAnRicsXG4gICAgJ1xcdUE3N0InOiAnRicsXG4gICAgJ1xcdTI0QkMnOiAnRycsXG4gICAgJ1xcdUZGMjcnOiAnRycsXG4gICAgJ1xcdTAxRjQnOiAnRycsXG4gICAgJ1xcdTAxMUMnOiAnRycsXG4gICAgJ1xcdTFFMjAnOiAnRycsXG4gICAgJ1xcdTAxMUUnOiAnRycsXG4gICAgJ1xcdTAxMjAnOiAnRycsXG4gICAgJ1xcdTAxRTYnOiAnRycsXG4gICAgJ1xcdTAxMjInOiAnRycsXG4gICAgJ1xcdTAxRTQnOiAnRycsXG4gICAgJ1xcdTAxOTMnOiAnRycsXG4gICAgJ1xcdUE3QTAnOiAnRycsXG4gICAgJ1xcdUE3N0QnOiAnRycsXG4gICAgJ1xcdUE3N0UnOiAnRycsXG4gICAgJ1xcdTI0QkQnOiAnSCcsXG4gICAgJ1xcdUZGMjgnOiAnSCcsXG4gICAgJ1xcdTAxMjQnOiAnSCcsXG4gICAgJ1xcdTFFMjInOiAnSCcsXG4gICAgJ1xcdTFFMjYnOiAnSCcsXG4gICAgJ1xcdTAyMUUnOiAnSCcsXG4gICAgJ1xcdTFFMjQnOiAnSCcsXG4gICAgJ1xcdTFFMjgnOiAnSCcsXG4gICAgJ1xcdTFFMkEnOiAnSCcsXG4gICAgJ1xcdTAxMjYnOiAnSCcsXG4gICAgJ1xcdTJDNjcnOiAnSCcsXG4gICAgJ1xcdTJDNzUnOiAnSCcsXG4gICAgJ1xcdUE3OEQnOiAnSCcsXG4gICAgJ1xcdTI0QkUnOiAnSScsXG4gICAgJ1xcdUZGMjknOiAnSScsXG4gICAgJ1xcdTAwQ0MnOiAnSScsXG4gICAgJ1xcdTAwQ0QnOiAnSScsXG4gICAgJ1xcdTAwQ0UnOiAnSScsXG4gICAgJ1xcdTAxMjgnOiAnSScsXG4gICAgJ1xcdTAxMkEnOiAnSScsXG4gICAgJ1xcdTAxMkMnOiAnSScsXG4gICAgJ1xcdTAxMzAnOiAnSScsXG4gICAgJ1xcdTAwQ0YnOiAnSScsXG4gICAgJ1xcdTFFMkUnOiAnSScsXG4gICAgJ1xcdTFFQzgnOiAnSScsXG4gICAgJ1xcdTAxQ0YnOiAnSScsXG4gICAgJ1xcdTAyMDgnOiAnSScsXG4gICAgJ1xcdTAyMEEnOiAnSScsXG4gICAgJ1xcdTFFQ0EnOiAnSScsXG4gICAgJ1xcdTAxMkUnOiAnSScsXG4gICAgJ1xcdTFFMkMnOiAnSScsXG4gICAgJ1xcdTAxOTcnOiAnSScsXG4gICAgJ1xcdTI0QkYnOiAnSicsXG4gICAgJ1xcdUZGMkEnOiAnSicsXG4gICAgJ1xcdTAxMzQnOiAnSicsXG4gICAgJ1xcdTAyNDgnOiAnSicsXG4gICAgJ1xcdTI0QzAnOiAnSycsXG4gICAgJ1xcdUZGMkInOiAnSycsXG4gICAgJ1xcdTFFMzAnOiAnSycsXG4gICAgJ1xcdTAxRTgnOiAnSycsXG4gICAgJ1xcdTFFMzInOiAnSycsXG4gICAgJ1xcdTAxMzYnOiAnSycsXG4gICAgJ1xcdTFFMzQnOiAnSycsXG4gICAgJ1xcdTAxOTgnOiAnSycsXG4gICAgJ1xcdTJDNjknOiAnSycsXG4gICAgJ1xcdUE3NDAnOiAnSycsXG4gICAgJ1xcdUE3NDInOiAnSycsXG4gICAgJ1xcdUE3NDQnOiAnSycsXG4gICAgJ1xcdUE3QTInOiAnSycsXG4gICAgJ1xcdTI0QzEnOiAnTCcsXG4gICAgJ1xcdUZGMkMnOiAnTCcsXG4gICAgJ1xcdTAxM0YnOiAnTCcsXG4gICAgJ1xcdTAxMzknOiAnTCcsXG4gICAgJ1xcdTAxM0QnOiAnTCcsXG4gICAgJ1xcdTFFMzYnOiAnTCcsXG4gICAgJ1xcdTFFMzgnOiAnTCcsXG4gICAgJ1xcdTAxM0InOiAnTCcsXG4gICAgJ1xcdTFFM0MnOiAnTCcsXG4gICAgJ1xcdTFFM0EnOiAnTCcsXG4gICAgJ1xcdTAxNDEnOiAnTCcsXG4gICAgJ1xcdTAyM0QnOiAnTCcsXG4gICAgJ1xcdTJDNjInOiAnTCcsXG4gICAgJ1xcdTJDNjAnOiAnTCcsXG4gICAgJ1xcdUE3NDgnOiAnTCcsXG4gICAgJ1xcdUE3NDYnOiAnTCcsXG4gICAgJ1xcdUE3ODAnOiAnTCcsXG4gICAgJ1xcdTAxQzcnOiAnTEonLFxuICAgICdcXHUwMUM4JzogJ0xqJyxcbiAgICAnXFx1MjRDMic6ICdNJyxcbiAgICAnXFx1RkYyRCc6ICdNJyxcbiAgICAnXFx1MUUzRSc6ICdNJyxcbiAgICAnXFx1MUU0MCc6ICdNJyxcbiAgICAnXFx1MUU0Mic6ICdNJyxcbiAgICAnXFx1MkM2RSc6ICdNJyxcbiAgICAnXFx1MDE5Qyc6ICdNJyxcbiAgICAnXFx1MjRDMyc6ICdOJyxcbiAgICAnXFx1RkYyRSc6ICdOJyxcbiAgICAnXFx1MDFGOCc6ICdOJyxcbiAgICAnXFx1MDE0Myc6ICdOJyxcbiAgICAnXFx1MDBEMSc6ICdOJyxcbiAgICAnXFx1MUU0NCc6ICdOJyxcbiAgICAnXFx1MDE0Nyc6ICdOJyxcbiAgICAnXFx1MUU0Nic6ICdOJyxcbiAgICAnXFx1MDE0NSc6ICdOJyxcbiAgICAnXFx1MUU0QSc6ICdOJyxcbiAgICAnXFx1MUU0OCc6ICdOJyxcbiAgICAnXFx1MDIyMCc6ICdOJyxcbiAgICAnXFx1MDE5RCc6ICdOJyxcbiAgICAnXFx1QTc5MCc6ICdOJyxcbiAgICAnXFx1QTdBNCc6ICdOJyxcbiAgICAnXFx1MDFDQSc6ICdOSicsXG4gICAgJ1xcdTAxQ0InOiAnTmonLFxuICAgICdcXHUyNEM0JzogJ08nLFxuICAgICdcXHVGRjJGJzogJ08nLFxuICAgICdcXHUwMEQyJzogJ08nLFxuICAgICdcXHUwMEQzJzogJ08nLFxuICAgICdcXHUwMEQ0JzogJ08nLFxuICAgICdcXHUxRUQyJzogJ08nLFxuICAgICdcXHUxRUQwJzogJ08nLFxuICAgICdcXHUxRUQ2JzogJ08nLFxuICAgICdcXHUxRUQ0JzogJ08nLFxuICAgICdcXHUwMEQ1JzogJ08nLFxuICAgICdcXHUxRTRDJzogJ08nLFxuICAgICdcXHUwMjJDJzogJ08nLFxuICAgICdcXHUxRTRFJzogJ08nLFxuICAgICdcXHUwMTRDJzogJ08nLFxuICAgICdcXHUxRTUwJzogJ08nLFxuICAgICdcXHUxRTUyJzogJ08nLFxuICAgICdcXHUwMTRFJzogJ08nLFxuICAgICdcXHUwMjJFJzogJ08nLFxuICAgICdcXHUwMjMwJzogJ08nLFxuICAgICdcXHUwMEQ2JzogJ08nLFxuICAgICdcXHUwMjJBJzogJ08nLFxuICAgICdcXHUxRUNFJzogJ08nLFxuICAgICdcXHUwMTUwJzogJ08nLFxuICAgICdcXHUwMUQxJzogJ08nLFxuICAgICdcXHUwMjBDJzogJ08nLFxuICAgICdcXHUwMjBFJzogJ08nLFxuICAgICdcXHUwMUEwJzogJ08nLFxuICAgICdcXHUxRURDJzogJ08nLFxuICAgICdcXHUxRURBJzogJ08nLFxuICAgICdcXHUxRUUwJzogJ08nLFxuICAgICdcXHUxRURFJzogJ08nLFxuICAgICdcXHUxRUUyJzogJ08nLFxuICAgICdcXHUxRUNDJzogJ08nLFxuICAgICdcXHUxRUQ4JzogJ08nLFxuICAgICdcXHUwMUVBJzogJ08nLFxuICAgICdcXHUwMUVDJzogJ08nLFxuICAgICdcXHUwMEQ4JzogJ08nLFxuICAgICdcXHUwMUZFJzogJ08nLFxuICAgICdcXHUwMTg2JzogJ08nLFxuICAgICdcXHUwMTlGJzogJ08nLFxuICAgICdcXHVBNzRBJzogJ08nLFxuICAgICdcXHVBNzRDJzogJ08nLFxuICAgICdcXHUwMUEyJzogJ09JJyxcbiAgICAnXFx1QTc0RSc6ICdPTycsXG4gICAgJ1xcdTAyMjInOiAnT1UnLFxuICAgICdcXHUyNEM1JzogJ1AnLFxuICAgICdcXHVGRjMwJzogJ1AnLFxuICAgICdcXHUxRTU0JzogJ1AnLFxuICAgICdcXHUxRTU2JzogJ1AnLFxuICAgICdcXHUwMUE0JzogJ1AnLFxuICAgICdcXHUyQzYzJzogJ1AnLFxuICAgICdcXHVBNzUwJzogJ1AnLFxuICAgICdcXHVBNzUyJzogJ1AnLFxuICAgICdcXHVBNzU0JzogJ1AnLFxuICAgICdcXHUyNEM2JzogJ1EnLFxuICAgICdcXHVGRjMxJzogJ1EnLFxuICAgICdcXHVBNzU2JzogJ1EnLFxuICAgICdcXHVBNzU4JzogJ1EnLFxuICAgICdcXHUwMjRBJzogJ1EnLFxuICAgICdcXHUyNEM3JzogJ1InLFxuICAgICdcXHVGRjMyJzogJ1InLFxuICAgICdcXHUwMTU0JzogJ1InLFxuICAgICdcXHUxRTU4JzogJ1InLFxuICAgICdcXHUwMTU4JzogJ1InLFxuICAgICdcXHUwMjEwJzogJ1InLFxuICAgICdcXHUwMjEyJzogJ1InLFxuICAgICdcXHUxRTVBJzogJ1InLFxuICAgICdcXHUxRTVDJzogJ1InLFxuICAgICdcXHUwMTU2JzogJ1InLFxuICAgICdcXHUxRTVFJzogJ1InLFxuICAgICdcXHUwMjRDJzogJ1InLFxuICAgICdcXHUyQzY0JzogJ1InLFxuICAgICdcXHVBNzVBJzogJ1InLFxuICAgICdcXHVBN0E2JzogJ1InLFxuICAgICdcXHVBNzgyJzogJ1InLFxuICAgICdcXHUyNEM4JzogJ1MnLFxuICAgICdcXHVGRjMzJzogJ1MnLFxuICAgICdcXHUxRTlFJzogJ1MnLFxuICAgICdcXHUwMTVBJzogJ1MnLFxuICAgICdcXHUxRTY0JzogJ1MnLFxuICAgICdcXHUwMTVDJzogJ1MnLFxuICAgICdcXHUxRTYwJzogJ1MnLFxuICAgICdcXHUwMTYwJzogJ1MnLFxuICAgICdcXHUxRTY2JzogJ1MnLFxuICAgICdcXHUxRTYyJzogJ1MnLFxuICAgICdcXHUxRTY4JzogJ1MnLFxuICAgICdcXHUwMjE4JzogJ1MnLFxuICAgICdcXHUwMTVFJzogJ1MnLFxuICAgICdcXHUyQzdFJzogJ1MnLFxuICAgICdcXHVBN0E4JzogJ1MnLFxuICAgICdcXHVBNzg0JzogJ1MnLFxuICAgICdcXHUyNEM5JzogJ1QnLFxuICAgICdcXHVGRjM0JzogJ1QnLFxuICAgICdcXHUxRTZBJzogJ1QnLFxuICAgICdcXHUwMTY0JzogJ1QnLFxuICAgICdcXHUxRTZDJzogJ1QnLFxuICAgICdcXHUwMjFBJzogJ1QnLFxuICAgICdcXHUwMTYyJzogJ1QnLFxuICAgICdcXHUxRTcwJzogJ1QnLFxuICAgICdcXHUxRTZFJzogJ1QnLFxuICAgICdcXHUwMTY2JzogJ1QnLFxuICAgICdcXHUwMUFDJzogJ1QnLFxuICAgICdcXHUwMUFFJzogJ1QnLFxuICAgICdcXHUwMjNFJzogJ1QnLFxuICAgICdcXHVBNzg2JzogJ1QnLFxuICAgICdcXHVBNzI4JzogJ1RaJyxcbiAgICAnXFx1MjRDQSc6ICdVJyxcbiAgICAnXFx1RkYzNSc6ICdVJyxcbiAgICAnXFx1MDBEOSc6ICdVJyxcbiAgICAnXFx1MDBEQSc6ICdVJyxcbiAgICAnXFx1MDBEQic6ICdVJyxcbiAgICAnXFx1MDE2OCc6ICdVJyxcbiAgICAnXFx1MUU3OCc6ICdVJyxcbiAgICAnXFx1MDE2QSc6ICdVJyxcbiAgICAnXFx1MUU3QSc6ICdVJyxcbiAgICAnXFx1MDE2Qyc6ICdVJyxcbiAgICAnXFx1MDBEQyc6ICdVJyxcbiAgICAnXFx1MDFEQic6ICdVJyxcbiAgICAnXFx1MDFENyc6ICdVJyxcbiAgICAnXFx1MDFENSc6ICdVJyxcbiAgICAnXFx1MDFEOSc6ICdVJyxcbiAgICAnXFx1MUVFNic6ICdVJyxcbiAgICAnXFx1MDE2RSc6ICdVJyxcbiAgICAnXFx1MDE3MCc6ICdVJyxcbiAgICAnXFx1MDFEMyc6ICdVJyxcbiAgICAnXFx1MDIxNCc6ICdVJyxcbiAgICAnXFx1MDIxNic6ICdVJyxcbiAgICAnXFx1MDFBRic6ICdVJyxcbiAgICAnXFx1MUVFQSc6ICdVJyxcbiAgICAnXFx1MUVFOCc6ICdVJyxcbiAgICAnXFx1MUVFRSc6ICdVJyxcbiAgICAnXFx1MUVFQyc6ICdVJyxcbiAgICAnXFx1MUVGMCc6ICdVJyxcbiAgICAnXFx1MUVFNCc6ICdVJyxcbiAgICAnXFx1MUU3Mic6ICdVJyxcbiAgICAnXFx1MDE3Mic6ICdVJyxcbiAgICAnXFx1MUU3Nic6ICdVJyxcbiAgICAnXFx1MUU3NCc6ICdVJyxcbiAgICAnXFx1MDI0NCc6ICdVJyxcbiAgICAnXFx1MjRDQic6ICdWJyxcbiAgICAnXFx1RkYzNic6ICdWJyxcbiAgICAnXFx1MUU3Qyc6ICdWJyxcbiAgICAnXFx1MUU3RSc6ICdWJyxcbiAgICAnXFx1MDFCMic6ICdWJyxcbiAgICAnXFx1QTc1RSc6ICdWJyxcbiAgICAnXFx1MDI0NSc6ICdWJyxcbiAgICAnXFx1QTc2MCc6ICdWWScsXG4gICAgJ1xcdTI0Q0MnOiAnVycsXG4gICAgJ1xcdUZGMzcnOiAnVycsXG4gICAgJ1xcdTFFODAnOiAnVycsXG4gICAgJ1xcdTFFODInOiAnVycsXG4gICAgJ1xcdTAxNzQnOiAnVycsXG4gICAgJ1xcdTFFODYnOiAnVycsXG4gICAgJ1xcdTFFODQnOiAnVycsXG4gICAgJ1xcdTFFODgnOiAnVycsXG4gICAgJ1xcdTJDNzInOiAnVycsXG4gICAgJ1xcdTI0Q0QnOiAnWCcsXG4gICAgJ1xcdUZGMzgnOiAnWCcsXG4gICAgJ1xcdTFFOEEnOiAnWCcsXG4gICAgJ1xcdTFFOEMnOiAnWCcsXG4gICAgJ1xcdTI0Q0UnOiAnWScsXG4gICAgJ1xcdUZGMzknOiAnWScsXG4gICAgJ1xcdTFFRjInOiAnWScsXG4gICAgJ1xcdTAwREQnOiAnWScsXG4gICAgJ1xcdTAxNzYnOiAnWScsXG4gICAgJ1xcdTFFRjgnOiAnWScsXG4gICAgJ1xcdTAyMzInOiAnWScsXG4gICAgJ1xcdTFFOEUnOiAnWScsXG4gICAgJ1xcdTAxNzgnOiAnWScsXG4gICAgJ1xcdTFFRjYnOiAnWScsXG4gICAgJ1xcdTFFRjQnOiAnWScsXG4gICAgJ1xcdTAxQjMnOiAnWScsXG4gICAgJ1xcdTAyNEUnOiAnWScsXG4gICAgJ1xcdTFFRkUnOiAnWScsXG4gICAgJ1xcdTI0Q0YnOiAnWicsXG4gICAgJ1xcdUZGM0EnOiAnWicsXG4gICAgJ1xcdTAxNzknOiAnWicsXG4gICAgJ1xcdTFFOTAnOiAnWicsXG4gICAgJ1xcdTAxN0InOiAnWicsXG4gICAgJ1xcdTAxN0QnOiAnWicsXG4gICAgJ1xcdTFFOTInOiAnWicsXG4gICAgJ1xcdTFFOTQnOiAnWicsXG4gICAgJ1xcdTAxQjUnOiAnWicsXG4gICAgJ1xcdTAyMjQnOiAnWicsXG4gICAgJ1xcdTJDN0YnOiAnWicsXG4gICAgJ1xcdTJDNkInOiAnWicsXG4gICAgJ1xcdUE3NjInOiAnWicsXG4gICAgJ1xcdTI0RDAnOiAnYScsXG4gICAgJ1xcdUZGNDEnOiAnYScsXG4gICAgJ1xcdTFFOUEnOiAnYScsXG4gICAgJ1xcdTAwRTAnOiAnYScsXG4gICAgJ1xcdTAwRTEnOiAnYScsXG4gICAgJ1xcdTAwRTInOiAnYScsXG4gICAgJ1xcdTFFQTcnOiAnYScsXG4gICAgJ1xcdTFFQTUnOiAnYScsXG4gICAgJ1xcdTFFQUInOiAnYScsXG4gICAgJ1xcdTFFQTknOiAnYScsXG4gICAgJ1xcdTAwRTMnOiAnYScsXG4gICAgJ1xcdTAxMDEnOiAnYScsXG4gICAgJ1xcdTAxMDMnOiAnYScsXG4gICAgJ1xcdTFFQjEnOiAnYScsXG4gICAgJ1xcdTFFQUYnOiAnYScsXG4gICAgJ1xcdTFFQjUnOiAnYScsXG4gICAgJ1xcdTFFQjMnOiAnYScsXG4gICAgJ1xcdTAyMjcnOiAnYScsXG4gICAgJ1xcdTAxRTEnOiAnYScsXG4gICAgJ1xcdTAwRTQnOiAnYScsXG4gICAgJ1xcdTAxREYnOiAnYScsXG4gICAgJ1xcdTFFQTMnOiAnYScsXG4gICAgJ1xcdTAwRTUnOiAnYScsXG4gICAgJ1xcdTAxRkInOiAnYScsXG4gICAgJ1xcdTAxQ0UnOiAnYScsXG4gICAgJ1xcdTAyMDEnOiAnYScsXG4gICAgJ1xcdTAyMDMnOiAnYScsXG4gICAgJ1xcdTFFQTEnOiAnYScsXG4gICAgJ1xcdTFFQUQnOiAnYScsXG4gICAgJ1xcdTFFQjcnOiAnYScsXG4gICAgJ1xcdTFFMDEnOiAnYScsXG4gICAgJ1xcdTAxMDUnOiAnYScsXG4gICAgJ1xcdTJDNjUnOiAnYScsXG4gICAgJ1xcdTAyNTAnOiAnYScsXG4gICAgJ1xcdUE3MzMnOiAnYWEnLFxuICAgICdcXHUwMEU2JzogJ2FlJyxcbiAgICAnXFx1MDFGRCc6ICdhZScsXG4gICAgJ1xcdTAxRTMnOiAnYWUnLFxuICAgICdcXHVBNzM1JzogJ2FvJyxcbiAgICAnXFx1QTczNyc6ICdhdScsXG4gICAgJ1xcdUE3MzknOiAnYXYnLFxuICAgICdcXHVBNzNCJzogJ2F2JyxcbiAgICAnXFx1QTczRCc6ICdheScsXG4gICAgJ1xcdTI0RDEnOiAnYicsXG4gICAgJ1xcdUZGNDInOiAnYicsXG4gICAgJ1xcdTFFMDMnOiAnYicsXG4gICAgJ1xcdTFFMDUnOiAnYicsXG4gICAgJ1xcdTFFMDcnOiAnYicsXG4gICAgJ1xcdTAxODAnOiAnYicsXG4gICAgJ1xcdTAxODMnOiAnYicsXG4gICAgJ1xcdTAyNTMnOiAnYicsXG4gICAgJ1xcdTI0RDInOiAnYycsXG4gICAgJ1xcdUZGNDMnOiAnYycsXG4gICAgJ1xcdTAxMDcnOiAnYycsXG4gICAgJ1xcdTAxMDknOiAnYycsXG4gICAgJ1xcdTAxMEInOiAnYycsXG4gICAgJ1xcdTAxMEQnOiAnYycsXG4gICAgJ1xcdTAwRTcnOiAnYycsXG4gICAgJ1xcdTFFMDknOiAnYycsXG4gICAgJ1xcdTAxODgnOiAnYycsXG4gICAgJ1xcdTAyM0MnOiAnYycsXG4gICAgJ1xcdUE3M0YnOiAnYycsXG4gICAgJ1xcdTIxODQnOiAnYycsXG4gICAgJ1xcdTI0RDMnOiAnZCcsXG4gICAgJ1xcdUZGNDQnOiAnZCcsXG4gICAgJ1xcdTFFMEInOiAnZCcsXG4gICAgJ1xcdTAxMEYnOiAnZCcsXG4gICAgJ1xcdTFFMEQnOiAnZCcsXG4gICAgJ1xcdTFFMTEnOiAnZCcsXG4gICAgJ1xcdTFFMTMnOiAnZCcsXG4gICAgJ1xcdTFFMEYnOiAnZCcsXG4gICAgJ1xcdTAxMTEnOiAnZCcsXG4gICAgJ1xcdTAxOEMnOiAnZCcsXG4gICAgJ1xcdTAyNTYnOiAnZCcsXG4gICAgJ1xcdTAyNTcnOiAnZCcsXG4gICAgJ1xcdUE3N0EnOiAnZCcsXG4gICAgJ1xcdTAxRjMnOiAnZHonLFxuICAgICdcXHUwMUM2JzogJ2R6JyxcbiAgICAnXFx1MjRENCc6ICdlJyxcbiAgICAnXFx1RkY0NSc6ICdlJyxcbiAgICAnXFx1MDBFOCc6ICdlJyxcbiAgICAnXFx1MDBFOSc6ICdlJyxcbiAgICAnXFx1MDBFQSc6ICdlJyxcbiAgICAnXFx1MUVDMSc6ICdlJyxcbiAgICAnXFx1MUVCRic6ICdlJyxcbiAgICAnXFx1MUVDNSc6ICdlJyxcbiAgICAnXFx1MUVDMyc6ICdlJyxcbiAgICAnXFx1MUVCRCc6ICdlJyxcbiAgICAnXFx1MDExMyc6ICdlJyxcbiAgICAnXFx1MUUxNSc6ICdlJyxcbiAgICAnXFx1MUUxNyc6ICdlJyxcbiAgICAnXFx1MDExNSc6ICdlJyxcbiAgICAnXFx1MDExNyc6ICdlJyxcbiAgICAnXFx1MDBFQic6ICdlJyxcbiAgICAnXFx1MUVCQic6ICdlJyxcbiAgICAnXFx1MDExQic6ICdlJyxcbiAgICAnXFx1MDIwNSc6ICdlJyxcbiAgICAnXFx1MDIwNyc6ICdlJyxcbiAgICAnXFx1MUVCOSc6ICdlJyxcbiAgICAnXFx1MUVDNyc6ICdlJyxcbiAgICAnXFx1MDIyOSc6ICdlJyxcbiAgICAnXFx1MUUxRCc6ICdlJyxcbiAgICAnXFx1MDExOSc6ICdlJyxcbiAgICAnXFx1MUUxOSc6ICdlJyxcbiAgICAnXFx1MUUxQic6ICdlJyxcbiAgICAnXFx1MDI0Nyc6ICdlJyxcbiAgICAnXFx1MDI1Qic6ICdlJyxcbiAgICAnXFx1MDFERCc6ICdlJyxcbiAgICAnXFx1MjRENSc6ICdmJyxcbiAgICAnXFx1RkY0Nic6ICdmJyxcbiAgICAnXFx1MUUxRic6ICdmJyxcbiAgICAnXFx1MDE5Mic6ICdmJyxcbiAgICAnXFx1QTc3Qyc6ICdmJyxcbiAgICAnXFx1MjRENic6ICdnJyxcbiAgICAnXFx1RkY0Nyc6ICdnJyxcbiAgICAnXFx1MDFGNSc6ICdnJyxcbiAgICAnXFx1MDExRCc6ICdnJyxcbiAgICAnXFx1MUUyMSc6ICdnJyxcbiAgICAnXFx1MDExRic6ICdnJyxcbiAgICAnXFx1MDEyMSc6ICdnJyxcbiAgICAnXFx1MDFFNyc6ICdnJyxcbiAgICAnXFx1MDEyMyc6ICdnJyxcbiAgICAnXFx1MDFFNSc6ICdnJyxcbiAgICAnXFx1MDI2MCc6ICdnJyxcbiAgICAnXFx1QTdBMSc6ICdnJyxcbiAgICAnXFx1MUQ3OSc6ICdnJyxcbiAgICAnXFx1QTc3Ric6ICdnJyxcbiAgICAnXFx1MjRENyc6ICdoJyxcbiAgICAnXFx1RkY0OCc6ICdoJyxcbiAgICAnXFx1MDEyNSc6ICdoJyxcbiAgICAnXFx1MUUyMyc6ICdoJyxcbiAgICAnXFx1MUUyNyc6ICdoJyxcbiAgICAnXFx1MDIxRic6ICdoJyxcbiAgICAnXFx1MUUyNSc6ICdoJyxcbiAgICAnXFx1MUUyOSc6ICdoJyxcbiAgICAnXFx1MUUyQic6ICdoJyxcbiAgICAnXFx1MUU5Nic6ICdoJyxcbiAgICAnXFx1MDEyNyc6ICdoJyxcbiAgICAnXFx1MkM2OCc6ICdoJyxcbiAgICAnXFx1MkM3Nic6ICdoJyxcbiAgICAnXFx1MDI2NSc6ICdoJyxcbiAgICAnXFx1MDE5NSc6ICdodicsXG4gICAgJ1xcdTI0RDgnOiAnaScsXG4gICAgJ1xcdUZGNDknOiAnaScsXG4gICAgJ1xcdTAwRUMnOiAnaScsXG4gICAgJ1xcdTAwRUQnOiAnaScsXG4gICAgJ1xcdTAwRUUnOiAnaScsXG4gICAgJ1xcdTAxMjknOiAnaScsXG4gICAgJ1xcdTAxMkInOiAnaScsXG4gICAgJ1xcdTAxMkQnOiAnaScsXG4gICAgJ1xcdTAwRUYnOiAnaScsXG4gICAgJ1xcdTFFMkYnOiAnaScsXG4gICAgJ1xcdTFFQzknOiAnaScsXG4gICAgJ1xcdTAxRDAnOiAnaScsXG4gICAgJ1xcdTAyMDknOiAnaScsXG4gICAgJ1xcdTAyMEInOiAnaScsXG4gICAgJ1xcdTFFQ0InOiAnaScsXG4gICAgJ1xcdTAxMkYnOiAnaScsXG4gICAgJ1xcdTFFMkQnOiAnaScsXG4gICAgJ1xcdTAyNjgnOiAnaScsXG4gICAgJ1xcdTAxMzEnOiAnaScsXG4gICAgJ1xcdTI0RDknOiAnaicsXG4gICAgJ1xcdUZGNEEnOiAnaicsXG4gICAgJ1xcdTAxMzUnOiAnaicsXG4gICAgJ1xcdTAxRjAnOiAnaicsXG4gICAgJ1xcdTAyNDknOiAnaicsXG4gICAgJ1xcdTI0REEnOiAnaycsXG4gICAgJ1xcdUZGNEInOiAnaycsXG4gICAgJ1xcdTFFMzEnOiAnaycsXG4gICAgJ1xcdTAxRTknOiAnaycsXG4gICAgJ1xcdTFFMzMnOiAnaycsXG4gICAgJ1xcdTAxMzcnOiAnaycsXG4gICAgJ1xcdTFFMzUnOiAnaycsXG4gICAgJ1xcdTAxOTknOiAnaycsXG4gICAgJ1xcdTJDNkEnOiAnaycsXG4gICAgJ1xcdUE3NDEnOiAnaycsXG4gICAgJ1xcdUE3NDMnOiAnaycsXG4gICAgJ1xcdUE3NDUnOiAnaycsXG4gICAgJ1xcdUE3QTMnOiAnaycsXG4gICAgJ1xcdTI0REInOiAnbCcsXG4gICAgJ1xcdUZGNEMnOiAnbCcsXG4gICAgJ1xcdTAxNDAnOiAnbCcsXG4gICAgJ1xcdTAxM0EnOiAnbCcsXG4gICAgJ1xcdTAxM0UnOiAnbCcsXG4gICAgJ1xcdTFFMzcnOiAnbCcsXG4gICAgJ1xcdTFFMzknOiAnbCcsXG4gICAgJ1xcdTAxM0MnOiAnbCcsXG4gICAgJ1xcdTFFM0QnOiAnbCcsXG4gICAgJ1xcdTFFM0InOiAnbCcsXG4gICAgJ1xcdTAxN0YnOiAnbCcsXG4gICAgJ1xcdTAxNDInOiAnbCcsXG4gICAgJ1xcdTAxOUEnOiAnbCcsXG4gICAgJ1xcdTAyNkInOiAnbCcsXG4gICAgJ1xcdTJDNjEnOiAnbCcsXG4gICAgJ1xcdUE3NDknOiAnbCcsXG4gICAgJ1xcdUE3ODEnOiAnbCcsXG4gICAgJ1xcdUE3NDcnOiAnbCcsXG4gICAgJ1xcdTAxQzknOiAnbGonLFxuICAgICdcXHUyNERDJzogJ20nLFxuICAgICdcXHVGRjREJzogJ20nLFxuICAgICdcXHUxRTNGJzogJ20nLFxuICAgICdcXHUxRTQxJzogJ20nLFxuICAgICdcXHUxRTQzJzogJ20nLFxuICAgICdcXHUwMjcxJzogJ20nLFxuICAgICdcXHUwMjZGJzogJ20nLFxuICAgICdcXHUyNEREJzogJ24nLFxuICAgICdcXHVGRjRFJzogJ24nLFxuICAgICdcXHUwMUY5JzogJ24nLFxuICAgICdcXHUwMTQ0JzogJ24nLFxuICAgICdcXHUwMEYxJzogJ24nLFxuICAgICdcXHUxRTQ1JzogJ24nLFxuICAgICdcXHUwMTQ4JzogJ24nLFxuICAgICdcXHUxRTQ3JzogJ24nLFxuICAgICdcXHUwMTQ2JzogJ24nLFxuICAgICdcXHUxRTRCJzogJ24nLFxuICAgICdcXHUxRTQ5JzogJ24nLFxuICAgICdcXHUwMTlFJzogJ24nLFxuICAgICdcXHUwMjcyJzogJ24nLFxuICAgICdcXHUwMTQ5JzogJ24nLFxuICAgICdcXHVBNzkxJzogJ24nLFxuICAgICdcXHVBN0E1JzogJ24nLFxuICAgICdcXHUwMUNDJzogJ25qJyxcbiAgICAnXFx1MjRERSc6ICdvJyxcbiAgICAnXFx1RkY0Ric6ICdvJyxcbiAgICAnXFx1MDBGMic6ICdvJyxcbiAgICAnXFx1MDBGMyc6ICdvJyxcbiAgICAnXFx1MDBGNCc6ICdvJyxcbiAgICAnXFx1MUVEMyc6ICdvJyxcbiAgICAnXFx1MUVEMSc6ICdvJyxcbiAgICAnXFx1MUVENyc6ICdvJyxcbiAgICAnXFx1MUVENSc6ICdvJyxcbiAgICAnXFx1MDBGNSc6ICdvJyxcbiAgICAnXFx1MUU0RCc6ICdvJyxcbiAgICAnXFx1MDIyRCc6ICdvJyxcbiAgICAnXFx1MUU0Ric6ICdvJyxcbiAgICAnXFx1MDE0RCc6ICdvJyxcbiAgICAnXFx1MUU1MSc6ICdvJyxcbiAgICAnXFx1MUU1Myc6ICdvJyxcbiAgICAnXFx1MDE0Ric6ICdvJyxcbiAgICAnXFx1MDIyRic6ICdvJyxcbiAgICAnXFx1MDIzMSc6ICdvJyxcbiAgICAnXFx1MDBGNic6ICdvJyxcbiAgICAnXFx1MDIyQic6ICdvJyxcbiAgICAnXFx1MUVDRic6ICdvJyxcbiAgICAnXFx1MDE1MSc6ICdvJyxcbiAgICAnXFx1MDFEMic6ICdvJyxcbiAgICAnXFx1MDIwRCc6ICdvJyxcbiAgICAnXFx1MDIwRic6ICdvJyxcbiAgICAnXFx1MDFBMSc6ICdvJyxcbiAgICAnXFx1MUVERCc6ICdvJyxcbiAgICAnXFx1MUVEQic6ICdvJyxcbiAgICAnXFx1MUVFMSc6ICdvJyxcbiAgICAnXFx1MUVERic6ICdvJyxcbiAgICAnXFx1MUVFMyc6ICdvJyxcbiAgICAnXFx1MUVDRCc6ICdvJyxcbiAgICAnXFx1MUVEOSc6ICdvJyxcbiAgICAnXFx1MDFFQic6ICdvJyxcbiAgICAnXFx1MDFFRCc6ICdvJyxcbiAgICAnXFx1MDBGOCc6ICdvJyxcbiAgICAnXFx1MDFGRic6ICdvJyxcbiAgICAnXFx1MDI1NCc6ICdvJyxcbiAgICAnXFx1QTc0Qic6ICdvJyxcbiAgICAnXFx1QTc0RCc6ICdvJyxcbiAgICAnXFx1MDI3NSc6ICdvJyxcbiAgICAnXFx1MDFBMyc6ICdvaScsXG4gICAgJ1xcdTAyMjMnOiAnb3UnLFxuICAgICdcXHVBNzRGJzogJ29vJyxcbiAgICAnXFx1MjRERic6ICdwJyxcbiAgICAnXFx1RkY1MCc6ICdwJyxcbiAgICAnXFx1MUU1NSc6ICdwJyxcbiAgICAnXFx1MUU1Nyc6ICdwJyxcbiAgICAnXFx1MDFBNSc6ICdwJyxcbiAgICAnXFx1MUQ3RCc6ICdwJyxcbiAgICAnXFx1QTc1MSc6ICdwJyxcbiAgICAnXFx1QTc1Myc6ICdwJyxcbiAgICAnXFx1QTc1NSc6ICdwJyxcbiAgICAnXFx1MjRFMCc6ICdxJyxcbiAgICAnXFx1RkY1MSc6ICdxJyxcbiAgICAnXFx1MDI0Qic6ICdxJyxcbiAgICAnXFx1QTc1Nyc6ICdxJyxcbiAgICAnXFx1QTc1OSc6ICdxJyxcbiAgICAnXFx1MjRFMSc6ICdyJyxcbiAgICAnXFx1RkY1Mic6ICdyJyxcbiAgICAnXFx1MDE1NSc6ICdyJyxcbiAgICAnXFx1MUU1OSc6ICdyJyxcbiAgICAnXFx1MDE1OSc6ICdyJyxcbiAgICAnXFx1MDIxMSc6ICdyJyxcbiAgICAnXFx1MDIxMyc6ICdyJyxcbiAgICAnXFx1MUU1Qic6ICdyJyxcbiAgICAnXFx1MUU1RCc6ICdyJyxcbiAgICAnXFx1MDE1Nyc6ICdyJyxcbiAgICAnXFx1MUU1Ric6ICdyJyxcbiAgICAnXFx1MDI0RCc6ICdyJyxcbiAgICAnXFx1MDI3RCc6ICdyJyxcbiAgICAnXFx1QTc1Qic6ICdyJyxcbiAgICAnXFx1QTdBNyc6ICdyJyxcbiAgICAnXFx1QTc4Myc6ICdyJyxcbiAgICAnXFx1MjRFMic6ICdzJyxcbiAgICAnXFx1RkY1Myc6ICdzJyxcbiAgICAnXFx1MDBERic6ICdzJyxcbiAgICAnXFx1MDE1Qic6ICdzJyxcbiAgICAnXFx1MUU2NSc6ICdzJyxcbiAgICAnXFx1MDE1RCc6ICdzJyxcbiAgICAnXFx1MUU2MSc6ICdzJyxcbiAgICAnXFx1MDE2MSc6ICdzJyxcbiAgICAnXFx1MUU2Nyc6ICdzJyxcbiAgICAnXFx1MUU2Myc6ICdzJyxcbiAgICAnXFx1MUU2OSc6ICdzJyxcbiAgICAnXFx1MDIxOSc6ICdzJyxcbiAgICAnXFx1MDE1Ric6ICdzJyxcbiAgICAnXFx1MDIzRic6ICdzJyxcbiAgICAnXFx1QTdBOSc6ICdzJyxcbiAgICAnXFx1QTc4NSc6ICdzJyxcbiAgICAnXFx1MUU5Qic6ICdzJyxcbiAgICAnXFx1MjRFMyc6ICd0JyxcbiAgICAnXFx1RkY1NCc6ICd0JyxcbiAgICAnXFx1MUU2Qic6ICd0JyxcbiAgICAnXFx1MUU5Nyc6ICd0JyxcbiAgICAnXFx1MDE2NSc6ICd0JyxcbiAgICAnXFx1MUU2RCc6ICd0JyxcbiAgICAnXFx1MDIxQic6ICd0JyxcbiAgICAnXFx1MDE2Myc6ICd0JyxcbiAgICAnXFx1MUU3MSc6ICd0JyxcbiAgICAnXFx1MUU2Ric6ICd0JyxcbiAgICAnXFx1MDE2Nyc6ICd0JyxcbiAgICAnXFx1MDFBRCc6ICd0JyxcbiAgICAnXFx1MDI4OCc6ICd0JyxcbiAgICAnXFx1MkM2Nic6ICd0JyxcbiAgICAnXFx1QTc4Nyc6ICd0JyxcbiAgICAnXFx1QTcyOSc6ICd0eicsXG4gICAgJ1xcdTI0RTQnOiAndScsXG4gICAgJ1xcdUZGNTUnOiAndScsXG4gICAgJ1xcdTAwRjknOiAndScsXG4gICAgJ1xcdTAwRkEnOiAndScsXG4gICAgJ1xcdTAwRkInOiAndScsXG4gICAgJ1xcdTAxNjknOiAndScsXG4gICAgJ1xcdTFFNzknOiAndScsXG4gICAgJ1xcdTAxNkInOiAndScsXG4gICAgJ1xcdTFFN0InOiAndScsXG4gICAgJ1xcdTAxNkQnOiAndScsXG4gICAgJ1xcdTAwRkMnOiAndScsXG4gICAgJ1xcdTAxREMnOiAndScsXG4gICAgJ1xcdTAxRDgnOiAndScsXG4gICAgJ1xcdTAxRDYnOiAndScsXG4gICAgJ1xcdTAxREEnOiAndScsXG4gICAgJ1xcdTFFRTcnOiAndScsXG4gICAgJ1xcdTAxNkYnOiAndScsXG4gICAgJ1xcdTAxNzEnOiAndScsXG4gICAgJ1xcdTAxRDQnOiAndScsXG4gICAgJ1xcdTAyMTUnOiAndScsXG4gICAgJ1xcdTAyMTcnOiAndScsXG4gICAgJ1xcdTAxQjAnOiAndScsXG4gICAgJ1xcdTFFRUInOiAndScsXG4gICAgJ1xcdTFFRTknOiAndScsXG4gICAgJ1xcdTFFRUYnOiAndScsXG4gICAgJ1xcdTFFRUQnOiAndScsXG4gICAgJ1xcdTFFRjEnOiAndScsXG4gICAgJ1xcdTFFRTUnOiAndScsXG4gICAgJ1xcdTFFNzMnOiAndScsXG4gICAgJ1xcdTAxNzMnOiAndScsXG4gICAgJ1xcdTFFNzcnOiAndScsXG4gICAgJ1xcdTFFNzUnOiAndScsXG4gICAgJ1xcdTAyODknOiAndScsXG4gICAgJ1xcdTI0RTUnOiAndicsXG4gICAgJ1xcdUZGNTYnOiAndicsXG4gICAgJ1xcdTFFN0QnOiAndicsXG4gICAgJ1xcdTFFN0YnOiAndicsXG4gICAgJ1xcdTAyOEInOiAndicsXG4gICAgJ1xcdUE3NUYnOiAndicsXG4gICAgJ1xcdTAyOEMnOiAndicsXG4gICAgJ1xcdUE3NjEnOiAndnknLFxuICAgICdcXHUyNEU2JzogJ3cnLFxuICAgICdcXHVGRjU3JzogJ3cnLFxuICAgICdcXHUxRTgxJzogJ3cnLFxuICAgICdcXHUxRTgzJzogJ3cnLFxuICAgICdcXHUwMTc1JzogJ3cnLFxuICAgICdcXHUxRTg3JzogJ3cnLFxuICAgICdcXHUxRTg1JzogJ3cnLFxuICAgICdcXHUxRTk4JzogJ3cnLFxuICAgICdcXHUxRTg5JzogJ3cnLFxuICAgICdcXHUyQzczJzogJ3cnLFxuICAgICdcXHUyNEU3JzogJ3gnLFxuICAgICdcXHVGRjU4JzogJ3gnLFxuICAgICdcXHUxRThCJzogJ3gnLFxuICAgICdcXHUxRThEJzogJ3gnLFxuICAgICdcXHUyNEU4JzogJ3knLFxuICAgICdcXHVGRjU5JzogJ3knLFxuICAgICdcXHUxRUYzJzogJ3knLFxuICAgICdcXHUwMEZEJzogJ3knLFxuICAgICdcXHUwMTc3JzogJ3knLFxuICAgICdcXHUxRUY5JzogJ3knLFxuICAgICdcXHUwMjMzJzogJ3knLFxuICAgICdcXHUxRThGJzogJ3knLFxuICAgICdcXHUwMEZGJzogJ3knLFxuICAgICdcXHUxRUY3JzogJ3knLFxuICAgICdcXHUxRTk5JzogJ3knLFxuICAgICdcXHUxRUY1JzogJ3knLFxuICAgICdcXHUwMUI0JzogJ3knLFxuICAgICdcXHUwMjRGJzogJ3knLFxuICAgICdcXHUxRUZGJzogJ3knLFxuICAgICdcXHUyNEU5JzogJ3onLFxuICAgICdcXHVGRjVBJzogJ3onLFxuICAgICdcXHUwMTdBJzogJ3onLFxuICAgICdcXHUxRTkxJzogJ3onLFxuICAgICdcXHUwMTdDJzogJ3onLFxuICAgICdcXHUwMTdFJzogJ3onLFxuICAgICdcXHUxRTkzJzogJ3onLFxuICAgICdcXHUxRTk1JzogJ3onLFxuICAgICdcXHUwMUI2JzogJ3onLFxuICAgICdcXHUwMjI1JzogJ3onLFxuICAgICdcXHUwMjQwJzogJ3onLFxuICAgICdcXHUyQzZDJzogJ3onLFxuICAgICdcXHVBNzYzJzogJ3onLFxuICAgICdcXHUwMzg2JzogJ1xcdTAzOTEnLFxuICAgICdcXHUwMzg4JzogJ1xcdTAzOTUnLFxuICAgICdcXHUwMzg5JzogJ1xcdTAzOTcnLFxuICAgICdcXHUwMzhBJzogJ1xcdTAzOTknLFxuICAgICdcXHUwM0FBJzogJ1xcdTAzOTknLFxuICAgICdcXHUwMzhDJzogJ1xcdTAzOUYnLFxuICAgICdcXHUwMzhFJzogJ1xcdTAzQTUnLFxuICAgICdcXHUwM0FCJzogJ1xcdTAzQTUnLFxuICAgICdcXHUwMzhGJzogJ1xcdTAzQTknLFxuICAgICdcXHUwM0FDJzogJ1xcdTAzQjEnLFxuICAgICdcXHUwM0FEJzogJ1xcdTAzQjUnLFxuICAgICdcXHUwM0FFJzogJ1xcdTAzQjcnLFxuICAgICdcXHUwM0FGJzogJ1xcdTAzQjknLFxuICAgICdcXHUwM0NBJzogJ1xcdTAzQjknLFxuICAgICdcXHUwMzkwJzogJ1xcdTAzQjknLFxuICAgICdcXHUwM0NDJzogJ1xcdTAzQkYnLFxuICAgICdcXHUwM0NEJzogJ1xcdTAzQzUnLFxuICAgICdcXHUwM0NCJzogJ1xcdTAzQzUnLFxuICAgICdcXHUwM0IwJzogJ1xcdTAzQzUnLFxuICAgICdcXHUwM0M5JzogJ1xcdTAzQzknLFxuICAgICdcXHUwM0MyJzogJ1xcdTAzQzMnXG4gIH07XG5cbiAgcmV0dXJuIGRpYWNyaXRpY3M7XG59KTtcblxuUzIuZGVmaW5lKCdzZWxlY3QyL2RhdGEvYmFzZScsW1xuICAnLi4vdXRpbHMnXG5dLCBmdW5jdGlvbiAoVXRpbHMpIHtcbiAgZnVuY3Rpb24gQmFzZUFkYXB0ZXIgKCRlbGVtZW50LCBvcHRpb25zKSB7XG4gICAgQmFzZUFkYXB0ZXIuX19zdXBlcl9fLmNvbnN0cnVjdG9yLmNhbGwodGhpcyk7XG4gIH1cblxuICBVdGlscy5FeHRlbmQoQmFzZUFkYXB0ZXIsIFV0aWxzLk9ic2VydmFibGUpO1xuXG4gIEJhc2VBZGFwdGVyLnByb3RvdHlwZS5jdXJyZW50ID0gZnVuY3Rpb24gKGNhbGxiYWNrKSB7XG4gICAgdGhyb3cgbmV3IEVycm9yKCdUaGUgYGN1cnJlbnRgIG1ldGhvZCBtdXN0IGJlIGRlZmluZWQgaW4gY2hpbGQgY2xhc3Nlcy4nKTtcbiAgfTtcblxuICBCYXNlQWRhcHRlci5wcm90b3R5cGUucXVlcnkgPSBmdW5jdGlvbiAocGFyYW1zLCBjYWxsYmFjaykge1xuICAgIHRocm93IG5ldyBFcnJvcignVGhlIGBxdWVyeWAgbWV0aG9kIG11c3QgYmUgZGVmaW5lZCBpbiBjaGlsZCBjbGFzc2VzLicpO1xuICB9O1xuXG4gIEJhc2VBZGFwdGVyLnByb3RvdHlwZS5iaW5kID0gZnVuY3Rpb24gKGNvbnRhaW5lciwgJGNvbnRhaW5lcikge1xuICAgIC8vIENhbiBiZSBpbXBsZW1lbnRlZCBpbiBzdWJjbGFzc2VzXG4gIH07XG5cbiAgQmFzZUFkYXB0ZXIucHJvdG90eXBlLmRlc3Ryb3kgPSBmdW5jdGlvbiAoKSB7XG4gICAgLy8gQ2FuIGJlIGltcGxlbWVudGVkIGluIHN1YmNsYXNzZXNcbiAgfTtcblxuICBCYXNlQWRhcHRlci5wcm90b3R5cGUuZ2VuZXJhdGVSZXN1bHRJZCA9IGZ1bmN0aW9uIChjb250YWluZXIsIGRhdGEpIHtcbiAgICB2YXIgaWQgPSBjb250YWluZXIuaWQgKyAnLXJlc3VsdC0nO1xuXG4gICAgaWQgKz0gVXRpbHMuZ2VuZXJhdGVDaGFycyg0KTtcblxuICAgIGlmIChkYXRhLmlkICE9IG51bGwpIHtcbiAgICAgIGlkICs9ICctJyArIGRhdGEuaWQudG9TdHJpbmcoKTtcbiAgICB9IGVsc2Uge1xuICAgICAgaWQgKz0gJy0nICsgVXRpbHMuZ2VuZXJhdGVDaGFycyg0KTtcbiAgICB9XG4gICAgcmV0dXJuIGlkO1xuICB9O1xuXG4gIHJldHVybiBCYXNlQWRhcHRlcjtcbn0pO1xuXG5TMi5kZWZpbmUoJ3NlbGVjdDIvZGF0YS9zZWxlY3QnLFtcbiAgJy4vYmFzZScsXG4gICcuLi91dGlscycsXG4gICdqcXVlcnknXG5dLCBmdW5jdGlvbiAoQmFzZUFkYXB0ZXIsIFV0aWxzLCAkKSB7XG4gIGZ1bmN0aW9uIFNlbGVjdEFkYXB0ZXIgKCRlbGVtZW50LCBvcHRpb25zKSB7XG4gICAgdGhpcy4kZWxlbWVudCA9ICRlbGVtZW50O1xuICAgIHRoaXMub3B0aW9ucyA9IG9wdGlvbnM7XG5cbiAgICBTZWxlY3RBZGFwdGVyLl9fc3VwZXJfXy5jb25zdHJ1Y3Rvci5jYWxsKHRoaXMpO1xuICB9XG5cbiAgVXRpbHMuRXh0ZW5kKFNlbGVjdEFkYXB0ZXIsIEJhc2VBZGFwdGVyKTtcblxuICBTZWxlY3RBZGFwdGVyLnByb3RvdHlwZS5jdXJyZW50ID0gZnVuY3Rpb24gKGNhbGxiYWNrKSB7XG4gICAgdmFyIGRhdGEgPSBbXTtcbiAgICB2YXIgc2VsZiA9IHRoaXM7XG5cbiAgICB0aGlzLiRlbGVtZW50LmZpbmQoJzpzZWxlY3RlZCcpLmVhY2goZnVuY3Rpb24gKCkge1xuICAgICAgdmFyICRvcHRpb24gPSAkKHRoaXMpO1xuXG4gICAgICB2YXIgb3B0aW9uID0gc2VsZi5pdGVtKCRvcHRpb24pO1xuXG4gICAgICBkYXRhLnB1c2gob3B0aW9uKTtcbiAgICB9KTtcblxuICAgIGNhbGxiYWNrKGRhdGEpO1xuICB9O1xuXG4gIFNlbGVjdEFkYXB0ZXIucHJvdG90eXBlLnNlbGVjdCA9IGZ1bmN0aW9uIChkYXRhKSB7XG4gICAgdmFyIHNlbGYgPSB0aGlzO1xuXG4gICAgZGF0YS5zZWxlY3RlZCA9IHRydWU7XG5cbiAgICAvLyBJZiBkYXRhLmVsZW1lbnQgaXMgYSBET00gbm9kZSwgdXNlIGl0IGluc3RlYWRcbiAgICBpZiAoJChkYXRhLmVsZW1lbnQpLmlzKCdvcHRpb24nKSkge1xuICAgICAgZGF0YS5lbGVtZW50LnNlbGVjdGVkID0gdHJ1ZTtcblxuICAgICAgdGhpcy4kZWxlbWVudC50cmlnZ2VyKCdjaGFuZ2UnKTtcblxuICAgICAgcmV0dXJuO1xuICAgIH1cblxuICAgIGlmICh0aGlzLiRlbGVtZW50LnByb3AoJ211bHRpcGxlJykpIHtcbiAgICAgIHRoaXMuY3VycmVudChmdW5jdGlvbiAoY3VycmVudERhdGEpIHtcbiAgICAgICAgdmFyIHZhbCA9IFtdO1xuXG4gICAgICAgIGRhdGEgPSBbZGF0YV07XG4gICAgICAgIGRhdGEucHVzaC5hcHBseShkYXRhLCBjdXJyZW50RGF0YSk7XG5cbiAgICAgICAgZm9yICh2YXIgZCA9IDA7IGQgPCBkYXRhLmxlbmd0aDsgZCsrKSB7XG4gICAgICAgICAgdmFyIGlkID0gZGF0YVtkXS5pZDtcblxuICAgICAgICAgIGlmICgkLmluQXJyYXkoaWQsIHZhbCkgPT09IC0xKSB7XG4gICAgICAgICAgICB2YWwucHVzaChpZCk7XG4gICAgICAgICAgfVxuICAgICAgICB9XG5cbiAgICAgICAgc2VsZi4kZWxlbWVudC52YWwodmFsKTtcbiAgICAgICAgc2VsZi4kZWxlbWVudC50cmlnZ2VyKCdjaGFuZ2UnKTtcbiAgICAgIH0pO1xuICAgIH0gZWxzZSB7XG4gICAgICB2YXIgdmFsID0gZGF0YS5pZDtcblxuICAgICAgdGhpcy4kZWxlbWVudC52YWwodmFsKTtcbiAgICAgIHRoaXMuJGVsZW1lbnQudHJpZ2dlcignY2hhbmdlJyk7XG4gICAgfVxuICB9O1xuXG4gIFNlbGVjdEFkYXB0ZXIucHJvdG90eXBlLnVuc2VsZWN0ID0gZnVuY3Rpb24gKGRhdGEpIHtcbiAgICB2YXIgc2VsZiA9IHRoaXM7XG5cbiAgICBpZiAoIXRoaXMuJGVsZW1lbnQucHJvcCgnbXVsdGlwbGUnKSkge1xuICAgICAgcmV0dXJuO1xuICAgIH1cblxuICAgIGRhdGEuc2VsZWN0ZWQgPSBmYWxzZTtcblxuICAgIGlmICgkKGRhdGEuZWxlbWVudCkuaXMoJ29wdGlvbicpKSB7XG4gICAgICBkYXRhLmVsZW1lbnQuc2VsZWN0ZWQgPSBmYWxzZTtcblxuICAgICAgdGhpcy4kZWxlbWVudC50cmlnZ2VyKCdjaGFuZ2UnKTtcblxuICAgICAgcmV0dXJuO1xuICAgIH1cblxuICAgIHRoaXMuY3VycmVudChmdW5jdGlvbiAoY3VycmVudERhdGEpIHtcbiAgICAgIHZhciB2YWwgPSBbXTtcblxuICAgICAgZm9yICh2YXIgZCA9IDA7IGQgPCBjdXJyZW50RGF0YS5sZW5ndGg7IGQrKykge1xuICAgICAgICB2YXIgaWQgPSBjdXJyZW50RGF0YVtkXS5pZDtcblxuICAgICAgICBpZiAoaWQgIT09IGRhdGEuaWQgJiYgJC5pbkFycmF5KGlkLCB2YWwpID09PSAtMSkge1xuICAgICAgICAgIHZhbC5wdXNoKGlkKTtcbiAgICAgICAgfVxuICAgICAgfVxuXG4gICAgICBzZWxmLiRlbGVtZW50LnZhbCh2YWwpO1xuXG4gICAgICBzZWxmLiRlbGVtZW50LnRyaWdnZXIoJ2NoYW5nZScpO1xuICAgIH0pO1xuICB9O1xuXG4gIFNlbGVjdEFkYXB0ZXIucHJvdG90eXBlLmJpbmQgPSBmdW5jdGlvbiAoY29udGFpbmVyLCAkY29udGFpbmVyKSB7XG4gICAgdmFyIHNlbGYgPSB0aGlzO1xuXG4gICAgdGhpcy5jb250YWluZXIgPSBjb250YWluZXI7XG5cbiAgICBjb250YWluZXIub24oJ3NlbGVjdCcsIGZ1bmN0aW9uIChwYXJhbXMpIHtcbiAgICAgIHNlbGYuc2VsZWN0KHBhcmFtcy5kYXRhKTtcbiAgICB9KTtcblxuICAgIGNvbnRhaW5lci5vbigndW5zZWxlY3QnLCBmdW5jdGlvbiAocGFyYW1zKSB7XG4gICAgICBzZWxmLnVuc2VsZWN0KHBhcmFtcy5kYXRhKTtcbiAgICB9KTtcbiAgfTtcblxuICBTZWxlY3RBZGFwdGVyLnByb3RvdHlwZS5kZXN0cm95ID0gZnVuY3Rpb24gKCkge1xuICAgIC8vIFJlbW92ZSBhbnl0aGluZyBhZGRlZCB0byBjaGlsZCBlbGVtZW50c1xuICAgIHRoaXMuJGVsZW1lbnQuZmluZCgnKicpLmVhY2goZnVuY3Rpb24gKCkge1xuICAgICAgLy8gUmVtb3ZlIGFueSBjdXN0b20gZGF0YSBzZXQgYnkgU2VsZWN0MlxuICAgICAgJC5yZW1vdmVEYXRhKHRoaXMsICdkYXRhJyk7XG4gICAgfSk7XG4gIH07XG5cbiAgU2VsZWN0QWRhcHRlci5wcm90b3R5cGUucXVlcnkgPSBmdW5jdGlvbiAocGFyYW1zLCBjYWxsYmFjaykge1xuICAgIHZhciBkYXRhID0gW107XG4gICAgdmFyIHNlbGYgPSB0aGlzO1xuXG4gICAgdmFyICRvcHRpb25zID0gdGhpcy4kZWxlbWVudC5jaGlsZHJlbigpO1xuXG4gICAgJG9wdGlvbnMuZWFjaChmdW5jdGlvbiAoKSB7XG4gICAgICB2YXIgJG9wdGlvbiA9ICQodGhpcyk7XG5cbiAgICAgIGlmICghJG9wdGlvbi5pcygnb3B0aW9uJykgJiYgISRvcHRpb24uaXMoJ29wdGdyb3VwJykpIHtcbiAgICAgICAgcmV0dXJuO1xuICAgICAgfVxuXG4gICAgICB2YXIgb3B0aW9uID0gc2VsZi5pdGVtKCRvcHRpb24pO1xuXG4gICAgICB2YXIgbWF0Y2hlcyA9IHNlbGYubWF0Y2hlcyhwYXJhbXMsIG9wdGlvbik7XG5cbiAgICAgIGlmIChtYXRjaGVzICE9PSBudWxsKSB7XG4gICAgICAgIGRhdGEucHVzaChtYXRjaGVzKTtcbiAgICAgIH1cbiAgICB9KTtcblxuICAgIGNhbGxiYWNrKHtcbiAgICAgIHJlc3VsdHM6IGRhdGFcbiAgICB9KTtcbiAgfTtcblxuICBTZWxlY3RBZGFwdGVyLnByb3RvdHlwZS5hZGRPcHRpb25zID0gZnVuY3Rpb24gKCRvcHRpb25zKSB7XG4gICAgVXRpbHMuYXBwZW5kTWFueSh0aGlzLiRlbGVtZW50LCAkb3B0aW9ucyk7XG4gIH07XG5cbiAgU2VsZWN0QWRhcHRlci5wcm90b3R5cGUub3B0aW9uID0gZnVuY3Rpb24gKGRhdGEpIHtcbiAgICB2YXIgb3B0aW9uO1xuXG4gICAgaWYgKGRhdGEuY2hpbGRyZW4pIHtcbiAgICAgIG9wdGlvbiA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ29wdGdyb3VwJyk7XG4gICAgICBvcHRpb24ubGFiZWwgPSBkYXRhLnRleHQ7XG4gICAgfSBlbHNlIHtcbiAgICAgIG9wdGlvbiA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ29wdGlvbicpO1xuXG4gICAgICBpZiAob3B0aW9uLnRleHRDb250ZW50ICE9PSB1bmRlZmluZWQpIHtcbiAgICAgICAgb3B0aW9uLnRleHRDb250ZW50ID0gZGF0YS50ZXh0O1xuICAgICAgfSBlbHNlIHtcbiAgICAgICAgb3B0aW9uLmlubmVyVGV4dCA9IGRhdGEudGV4dDtcbiAgICAgIH1cbiAgICB9XG5cbiAgICBpZiAoZGF0YS5pZCAhPT0gdW5kZWZpbmVkKSB7XG4gICAgICBvcHRpb24udmFsdWUgPSBkYXRhLmlkO1xuICAgIH1cblxuICAgIGlmIChkYXRhLmRpc2FibGVkKSB7XG4gICAgICBvcHRpb24uZGlzYWJsZWQgPSB0cnVlO1xuICAgIH1cblxuICAgIGlmIChkYXRhLnNlbGVjdGVkKSB7XG4gICAgICBvcHRpb24uc2VsZWN0ZWQgPSB0cnVlO1xuICAgIH1cblxuICAgIGlmIChkYXRhLnRpdGxlKSB7XG4gICAgICBvcHRpb24udGl0bGUgPSBkYXRhLnRpdGxlO1xuICAgIH1cblxuICAgIHZhciAkb3B0aW9uID0gJChvcHRpb24pO1xuXG4gICAgdmFyIG5vcm1hbGl6ZWREYXRhID0gdGhpcy5fbm9ybWFsaXplSXRlbShkYXRhKTtcbiAgICBub3JtYWxpemVkRGF0YS5lbGVtZW50ID0gb3B0aW9uO1xuXG4gICAgLy8gT3ZlcnJpZGUgdGhlIG9wdGlvbidzIGRhdGEgd2l0aCB0aGUgY29tYmluZWQgZGF0YVxuICAgICQuZGF0YShvcHRpb24sICdkYXRhJywgbm9ybWFsaXplZERhdGEpO1xuXG4gICAgcmV0dXJuICRvcHRpb247XG4gIH07XG5cbiAgU2VsZWN0QWRhcHRlci5wcm90b3R5cGUuaXRlbSA9IGZ1bmN0aW9uICgkb3B0aW9uKSB7XG4gICAgdmFyIGRhdGEgPSB7fTtcblxuICAgIGRhdGEgPSAkLmRhdGEoJG9wdGlvblswXSwgJ2RhdGEnKTtcblxuICAgIGlmIChkYXRhICE9IG51bGwpIHtcbiAgICAgIHJldHVybiBkYXRhO1xuICAgIH1cblxuICAgIGlmICgkb3B0aW9uLmlzKCdvcHRpb24nKSkge1xuICAgICAgZGF0YSA9IHtcbiAgICAgICAgaWQ6ICRvcHRpb24udmFsKCksXG4gICAgICAgIHRleHQ6ICRvcHRpb24udGV4dCgpLFxuICAgICAgICBkaXNhYmxlZDogJG9wdGlvbi5wcm9wKCdkaXNhYmxlZCcpLFxuICAgICAgICBzZWxlY3RlZDogJG9wdGlvbi5wcm9wKCdzZWxlY3RlZCcpLFxuICAgICAgICB0aXRsZTogJG9wdGlvbi5wcm9wKCd0aXRsZScpXG4gICAgICB9O1xuICAgIH0gZWxzZSBpZiAoJG9wdGlvbi5pcygnb3B0Z3JvdXAnKSkge1xuICAgICAgZGF0YSA9IHtcbiAgICAgICAgdGV4dDogJG9wdGlvbi5wcm9wKCdsYWJlbCcpLFxuICAgICAgICBjaGlsZHJlbjogW10sXG4gICAgICAgIHRpdGxlOiAkb3B0aW9uLnByb3AoJ3RpdGxlJylcbiAgICAgIH07XG5cbiAgICAgIHZhciAkY2hpbGRyZW4gPSAkb3B0aW9uLmNoaWxkcmVuKCdvcHRpb24nKTtcbiAgICAgIHZhciBjaGlsZHJlbiA9IFtdO1xuXG4gICAgICBmb3IgKHZhciBjID0gMDsgYyA8ICRjaGlsZHJlbi5sZW5ndGg7IGMrKykge1xuICAgICAgICB2YXIgJGNoaWxkID0gJCgkY2hpbGRyZW5bY10pO1xuXG4gICAgICAgIHZhciBjaGlsZCA9IHRoaXMuaXRlbSgkY2hpbGQpO1xuXG4gICAgICAgIGNoaWxkcmVuLnB1c2goY2hpbGQpO1xuICAgICAgfVxuXG4gICAgICBkYXRhLmNoaWxkcmVuID0gY2hpbGRyZW47XG4gICAgfVxuXG4gICAgZGF0YSA9IHRoaXMuX25vcm1hbGl6ZUl0ZW0oZGF0YSk7XG4gICAgZGF0YS5lbGVtZW50ID0gJG9wdGlvblswXTtcblxuICAgICQuZGF0YSgkb3B0aW9uWzBdLCAnZGF0YScsIGRhdGEpO1xuXG4gICAgcmV0dXJuIGRhdGE7XG4gIH07XG5cbiAgU2VsZWN0QWRhcHRlci5wcm90b3R5cGUuX25vcm1hbGl6ZUl0ZW0gPSBmdW5jdGlvbiAoaXRlbSkge1xuICAgIGlmICghJC5pc1BsYWluT2JqZWN0KGl0ZW0pKSB7XG4gICAgICBpdGVtID0ge1xuICAgICAgICBpZDogaXRlbSxcbiAgICAgICAgdGV4dDogaXRlbVxuICAgICAgfTtcbiAgICB9XG5cbiAgICBpdGVtID0gJC5leHRlbmQoe30sIHtcbiAgICAgIHRleHQ6ICcnXG4gICAgfSwgaXRlbSk7XG5cbiAgICB2YXIgZGVmYXVsdHMgPSB7XG4gICAgICBzZWxlY3RlZDogZmFsc2UsXG4gICAgICBkaXNhYmxlZDogZmFsc2VcbiAgICB9O1xuXG4gICAgaWYgKGl0ZW0uaWQgIT0gbnVsbCkge1xuICAgICAgaXRlbS5pZCA9IGl0ZW0uaWQudG9TdHJpbmcoKTtcbiAgICB9XG5cbiAgICBpZiAoaXRlbS50ZXh0ICE9IG51bGwpIHtcbiAgICAgIGl0ZW0udGV4dCA9IGl0ZW0udGV4dC50b1N0cmluZygpO1xuICAgIH1cblxuICAgIGlmIChpdGVtLl9yZXN1bHRJZCA9PSBudWxsICYmIGl0ZW0uaWQgJiYgdGhpcy5jb250YWluZXIgIT0gbnVsbCkge1xuICAgICAgaXRlbS5fcmVzdWx0SWQgPSB0aGlzLmdlbmVyYXRlUmVzdWx0SWQodGhpcy5jb250YWluZXIsIGl0ZW0pO1xuICAgIH1cblxuICAgIHJldHVybiAkLmV4dGVuZCh7fSwgZGVmYXVsdHMsIGl0ZW0pO1xuICB9O1xuXG4gIFNlbGVjdEFkYXB0ZXIucHJvdG90eXBlLm1hdGNoZXMgPSBmdW5jdGlvbiAocGFyYW1zLCBkYXRhKSB7XG4gICAgdmFyIG1hdGNoZXIgPSB0aGlzLm9wdGlvbnMuZ2V0KCdtYXRjaGVyJyk7XG5cbiAgICByZXR1cm4gbWF0Y2hlcihwYXJhbXMsIGRhdGEpO1xuICB9O1xuXG4gIHJldHVybiBTZWxlY3RBZGFwdGVyO1xufSk7XG5cblMyLmRlZmluZSgnc2VsZWN0Mi9kYXRhL2FycmF5JyxbXG4gICcuL3NlbGVjdCcsXG4gICcuLi91dGlscycsXG4gICdqcXVlcnknXG5dLCBmdW5jdGlvbiAoU2VsZWN0QWRhcHRlciwgVXRpbHMsICQpIHtcbiAgZnVuY3Rpb24gQXJyYXlBZGFwdGVyICgkZWxlbWVudCwgb3B0aW9ucykge1xuICAgIHZhciBkYXRhID0gb3B0aW9ucy5nZXQoJ2RhdGEnKSB8fCBbXTtcblxuICAgIEFycmF5QWRhcHRlci5fX3N1cGVyX18uY29uc3RydWN0b3IuY2FsbCh0aGlzLCAkZWxlbWVudCwgb3B0aW9ucyk7XG5cbiAgICB0aGlzLmFkZE9wdGlvbnModGhpcy5jb252ZXJ0VG9PcHRpb25zKGRhdGEpKTtcbiAgfVxuXG4gIFV0aWxzLkV4dGVuZChBcnJheUFkYXB0ZXIsIFNlbGVjdEFkYXB0ZXIpO1xuXG4gIEFycmF5QWRhcHRlci5wcm90b3R5cGUuc2VsZWN0ID0gZnVuY3Rpb24gKGRhdGEpIHtcbiAgICB2YXIgJG9wdGlvbiA9IHRoaXMuJGVsZW1lbnQuZmluZCgnb3B0aW9uJykuZmlsdGVyKGZ1bmN0aW9uIChpLCBlbG0pIHtcbiAgICAgIHJldHVybiBlbG0udmFsdWUgPT0gZGF0YS5pZC50b1N0cmluZygpO1xuICAgIH0pO1xuXG4gICAgaWYgKCRvcHRpb24ubGVuZ3RoID09PSAwKSB7XG4gICAgICAkb3B0aW9uID0gdGhpcy5vcHRpb24oZGF0YSk7XG5cbiAgICAgIHRoaXMuYWRkT3B0aW9ucygkb3B0aW9uKTtcbiAgICB9XG5cbiAgICBBcnJheUFkYXB0ZXIuX19zdXBlcl9fLnNlbGVjdC5jYWxsKHRoaXMsIGRhdGEpO1xuICB9O1xuXG4gIEFycmF5QWRhcHRlci5wcm90b3R5cGUuY29udmVydFRvT3B0aW9ucyA9IGZ1bmN0aW9uIChkYXRhKSB7XG4gICAgdmFyIHNlbGYgPSB0aGlzO1xuXG4gICAgdmFyICRleGlzdGluZyA9IHRoaXMuJGVsZW1lbnQuZmluZCgnb3B0aW9uJyk7XG4gICAgdmFyIGV4aXN0aW5nSWRzID0gJGV4aXN0aW5nLm1hcChmdW5jdGlvbiAoKSB7XG4gICAgICByZXR1cm4gc2VsZi5pdGVtKCQodGhpcykpLmlkO1xuICAgIH0pLmdldCgpO1xuXG4gICAgdmFyICRvcHRpb25zID0gW107XG5cbiAgICAvLyBGaWx0ZXIgb3V0IGFsbCBpdGVtcyBleGNlcHQgZm9yIHRoZSBvbmUgcGFzc2VkIGluIHRoZSBhcmd1bWVudFxuICAgIGZ1bmN0aW9uIG9ubHlJdGVtIChpdGVtKSB7XG4gICAgICByZXR1cm4gZnVuY3Rpb24gKCkge1xuICAgICAgICByZXR1cm4gJCh0aGlzKS52YWwoKSA9PSBpdGVtLmlkO1xuICAgICAgfTtcbiAgICB9XG5cbiAgICBmb3IgKHZhciBkID0gMDsgZCA8IGRhdGEubGVuZ3RoOyBkKyspIHtcbiAgICAgIHZhciBpdGVtID0gdGhpcy5fbm9ybWFsaXplSXRlbShkYXRhW2RdKTtcblxuICAgICAgLy8gU2tpcCBpdGVtcyB3aGljaCB3ZXJlIHByZS1sb2FkZWQsIG9ubHkgbWVyZ2UgdGhlIGRhdGFcbiAgICAgIGlmICgkLmluQXJyYXkoaXRlbS5pZCwgZXhpc3RpbmdJZHMpID49IDApIHtcbiAgICAgICAgdmFyICRleGlzdGluZ09wdGlvbiA9ICRleGlzdGluZy5maWx0ZXIob25seUl0ZW0oaXRlbSkpO1xuXG4gICAgICAgIHZhciBleGlzdGluZ0RhdGEgPSB0aGlzLml0ZW0oJGV4aXN0aW5nT3B0aW9uKTtcbiAgICAgICAgdmFyIG5ld0RhdGEgPSAkLmV4dGVuZCh0cnVlLCB7fSwgaXRlbSwgZXhpc3RpbmdEYXRhKTtcblxuICAgICAgICB2YXIgJG5ld09wdGlvbiA9IHRoaXMub3B0aW9uKG5ld0RhdGEpO1xuXG4gICAgICAgICRleGlzdGluZ09wdGlvbi5yZXBsYWNlV2l0aCgkbmV3T3B0aW9uKTtcblxuICAgICAgICBjb250aW51ZTtcbiAgICAgIH1cblxuICAgICAgdmFyICRvcHRpb24gPSB0aGlzLm9wdGlvbihpdGVtKTtcblxuICAgICAgaWYgKGl0ZW0uY2hpbGRyZW4pIHtcbiAgICAgICAgdmFyICRjaGlsZHJlbiA9IHRoaXMuY29udmVydFRvT3B0aW9ucyhpdGVtLmNoaWxkcmVuKTtcblxuICAgICAgICBVdGlscy5hcHBlbmRNYW55KCRvcHRpb24sICRjaGlsZHJlbik7XG4gICAgICB9XG5cbiAgICAgICRvcHRpb25zLnB1c2goJG9wdGlvbik7XG4gICAgfVxuXG4gICAgcmV0dXJuICRvcHRpb25zO1xuICB9O1xuXG4gIHJldHVybiBBcnJheUFkYXB0ZXI7XG59KTtcblxuUzIuZGVmaW5lKCdzZWxlY3QyL2RhdGEvYWpheCcsW1xuICAnLi9hcnJheScsXG4gICcuLi91dGlscycsXG4gICdqcXVlcnknXG5dLCBmdW5jdGlvbiAoQXJyYXlBZGFwdGVyLCBVdGlscywgJCkge1xuICBmdW5jdGlvbiBBamF4QWRhcHRlciAoJGVsZW1lbnQsIG9wdGlvbnMpIHtcbiAgICB0aGlzLmFqYXhPcHRpb25zID0gdGhpcy5fYXBwbHlEZWZhdWx0cyhvcHRpb25zLmdldCgnYWpheCcpKTtcblxuICAgIGlmICh0aGlzLmFqYXhPcHRpb25zLnByb2Nlc3NSZXN1bHRzICE9IG51bGwpIHtcbiAgICAgIHRoaXMucHJvY2Vzc1Jlc3VsdHMgPSB0aGlzLmFqYXhPcHRpb25zLnByb2Nlc3NSZXN1bHRzO1xuICAgIH1cblxuICAgIEFqYXhBZGFwdGVyLl9fc3VwZXJfXy5jb25zdHJ1Y3Rvci5jYWxsKHRoaXMsICRlbGVtZW50LCBvcHRpb25zKTtcbiAgfVxuXG4gIFV0aWxzLkV4dGVuZChBamF4QWRhcHRlciwgQXJyYXlBZGFwdGVyKTtcblxuICBBamF4QWRhcHRlci5wcm90b3R5cGUuX2FwcGx5RGVmYXVsdHMgPSBmdW5jdGlvbiAob3B0aW9ucykge1xuICAgIHZhciBkZWZhdWx0cyA9IHtcbiAgICAgIGRhdGE6IGZ1bmN0aW9uIChwYXJhbXMpIHtcbiAgICAgICAgcmV0dXJuICQuZXh0ZW5kKHt9LCBwYXJhbXMsIHtcbiAgICAgICAgICBxOiBwYXJhbXMudGVybVxuICAgICAgICB9KTtcbiAgICAgIH0sXG4gICAgICB0cmFuc3BvcnQ6IGZ1bmN0aW9uIChwYXJhbXMsIHN1Y2Nlc3MsIGZhaWx1cmUpIHtcbiAgICAgICAgdmFyICRyZXF1ZXN0ID0gJC5hamF4KHBhcmFtcyk7XG5cbiAgICAgICAgJHJlcXVlc3QudGhlbihzdWNjZXNzKTtcbiAgICAgICAgJHJlcXVlc3QuZmFpbChmYWlsdXJlKTtcblxuICAgICAgICByZXR1cm4gJHJlcXVlc3Q7XG4gICAgICB9XG4gICAgfTtcblxuICAgIHJldHVybiAkLmV4dGVuZCh7fSwgZGVmYXVsdHMsIG9wdGlvbnMsIHRydWUpO1xuICB9O1xuXG4gIEFqYXhBZGFwdGVyLnByb3RvdHlwZS5wcm9jZXNzUmVzdWx0cyA9IGZ1bmN0aW9uIChyZXN1bHRzKSB7XG4gICAgcmV0dXJuIHJlc3VsdHM7XG4gIH07XG5cbiAgQWpheEFkYXB0ZXIucHJvdG90eXBlLnF1ZXJ5ID0gZnVuY3Rpb24gKHBhcmFtcywgY2FsbGJhY2spIHtcbiAgICB2YXIgbWF0Y2hlcyA9IFtdO1xuICAgIHZhciBzZWxmID0gdGhpcztcblxuICAgIGlmICh0aGlzLl9yZXF1ZXN0ICE9IG51bGwpIHtcbiAgICAgIC8vIEpTT05QIHJlcXVlc3RzIGNhbm5vdCBhbHdheXMgYmUgYWJvcnRlZFxuICAgICAgaWYgKCQuaXNGdW5jdGlvbih0aGlzLl9yZXF1ZXN0LmFib3J0KSkge1xuICAgICAgICB0aGlzLl9yZXF1ZXN0LmFib3J0KCk7XG4gICAgICB9XG5cbiAgICAgIHRoaXMuX3JlcXVlc3QgPSBudWxsO1xuICAgIH1cblxuICAgIHZhciBvcHRpb25zID0gJC5leHRlbmQoe1xuICAgICAgdHlwZTogJ0dFVCdcbiAgICB9LCB0aGlzLmFqYXhPcHRpb25zKTtcblxuICAgIGlmICh0eXBlb2Ygb3B0aW9ucy51cmwgPT09ICdmdW5jdGlvbicpIHtcbiAgICAgIG9wdGlvbnMudXJsID0gb3B0aW9ucy51cmwuY2FsbCh0aGlzLiRlbGVtZW50LCBwYXJhbXMpO1xuICAgIH1cblxuICAgIGlmICh0eXBlb2Ygb3B0aW9ucy5kYXRhID09PSAnZnVuY3Rpb24nKSB7XG4gICAgICBvcHRpb25zLmRhdGEgPSBvcHRpb25zLmRhdGEuY2FsbCh0aGlzLiRlbGVtZW50LCBwYXJhbXMpO1xuICAgIH1cblxuICAgIGZ1bmN0aW9uIHJlcXVlc3QgKCkge1xuICAgICAgdmFyICRyZXF1ZXN0ID0gb3B0aW9ucy50cmFuc3BvcnQob3B0aW9ucywgZnVuY3Rpb24gKGRhdGEpIHtcbiAgICAgICAgdmFyIHJlc3VsdHMgPSBzZWxmLnByb2Nlc3NSZXN1bHRzKGRhdGEsIHBhcmFtcyk7XG5cbiAgICAgICAgaWYgKHNlbGYub3B0aW9ucy5nZXQoJ2RlYnVnJykgJiYgd2luZG93LmNvbnNvbGUgJiYgY29uc29sZS5lcnJvcikge1xuICAgICAgICAgIC8vIENoZWNrIHRvIG1ha2Ugc3VyZSB0aGF0IHRoZSByZXNwb25zZSBpbmNsdWRlZCBhIGByZXN1bHRzYCBrZXkuXG4gICAgICAgICAgaWYgKCFyZXN1bHRzIHx8ICFyZXN1bHRzLnJlc3VsdHMgfHwgISQuaXNBcnJheShyZXN1bHRzLnJlc3VsdHMpKSB7XG4gICAgICAgICAgICBjb25zb2xlLmVycm9yKFxuICAgICAgICAgICAgICAnU2VsZWN0MjogVGhlIEFKQVggcmVzdWx0cyBkaWQgbm90IHJldHVybiBhbiBhcnJheSBpbiB0aGUgJyArXG4gICAgICAgICAgICAgICdgcmVzdWx0c2Aga2V5IG9mIHRoZSByZXNwb25zZS4nXG4gICAgICAgICAgICApO1xuICAgICAgICAgIH1cbiAgICAgICAgfVxuXG4gICAgICAgIGNhbGxiYWNrKHJlc3VsdHMpO1xuICAgICAgfSwgZnVuY3Rpb24gKCkge1xuICAgICAgICAvLyBBdHRlbXB0IHRvIGRldGVjdCBpZiBhIHJlcXVlc3Qgd2FzIGFib3J0ZWRcbiAgICAgICAgLy8gT25seSB3b3JrcyBpZiB0aGUgdHJhbnNwb3J0IGV4cG9zZXMgYSBzdGF0dXMgcHJvcGVydHlcbiAgICAgICAgaWYgKCRyZXF1ZXN0LnN0YXR1cyAmJiAkcmVxdWVzdC5zdGF0dXMgPT09ICcwJykge1xuICAgICAgICAgIHJldHVybjtcbiAgICAgICAgfVxuXG4gICAgICAgIHNlbGYudHJpZ2dlcigncmVzdWx0czptZXNzYWdlJywge1xuICAgICAgICAgIG1lc3NhZ2U6ICdlcnJvckxvYWRpbmcnXG4gICAgICAgIH0pO1xuICAgICAgfSk7XG5cbiAgICAgIHNlbGYuX3JlcXVlc3QgPSAkcmVxdWVzdDtcbiAgICB9XG5cbiAgICBpZiAodGhpcy5hamF4T3B0aW9ucy5kZWxheSAmJiBwYXJhbXMudGVybSAhPSBudWxsKSB7XG4gICAgICBpZiAodGhpcy5fcXVlcnlUaW1lb3V0KSB7XG4gICAgICAgIHdpbmRvdy5jbGVhclRpbWVvdXQodGhpcy5fcXVlcnlUaW1lb3V0KTtcbiAgICAgIH1cblxuICAgICAgdGhpcy5fcXVlcnlUaW1lb3V0ID0gd2luZG93LnNldFRpbWVvdXQocmVxdWVzdCwgdGhpcy5hamF4T3B0aW9ucy5kZWxheSk7XG4gICAgfSBlbHNlIHtcbiAgICAgIHJlcXVlc3QoKTtcbiAgICB9XG4gIH07XG5cbiAgcmV0dXJuIEFqYXhBZGFwdGVyO1xufSk7XG5cblMyLmRlZmluZSgnc2VsZWN0Mi9kYXRhL3RhZ3MnLFtcbiAgJ2pxdWVyeSdcbl0sIGZ1bmN0aW9uICgkKSB7XG4gIGZ1bmN0aW9uIFRhZ3MgKGRlY29yYXRlZCwgJGVsZW1lbnQsIG9wdGlvbnMpIHtcbiAgICB2YXIgdGFncyA9IG9wdGlvbnMuZ2V0KCd0YWdzJyk7XG5cbiAgICB2YXIgY3JlYXRlVGFnID0gb3B0aW9ucy5nZXQoJ2NyZWF0ZVRhZycpO1xuXG4gICAgaWYgKGNyZWF0ZVRhZyAhPT0gdW5kZWZpbmVkKSB7XG4gICAgICB0aGlzLmNyZWF0ZVRhZyA9IGNyZWF0ZVRhZztcbiAgICB9XG5cbiAgICB2YXIgaW5zZXJ0VGFnID0gb3B0aW9ucy5nZXQoJ2luc2VydFRhZycpO1xuXG4gICAgaWYgKGluc2VydFRhZyAhPT0gdW5kZWZpbmVkKSB7XG4gICAgICAgIHRoaXMuaW5zZXJ0VGFnID0gaW5zZXJ0VGFnO1xuICAgIH1cblxuICAgIGRlY29yYXRlZC5jYWxsKHRoaXMsICRlbGVtZW50LCBvcHRpb25zKTtcblxuICAgIGlmICgkLmlzQXJyYXkodGFncykpIHtcbiAgICAgIGZvciAodmFyIHQgPSAwOyB0IDwgdGFncy5sZW5ndGg7IHQrKykge1xuICAgICAgICB2YXIgdGFnID0gdGFnc1t0XTtcbiAgICAgICAgdmFyIGl0ZW0gPSB0aGlzLl9ub3JtYWxpemVJdGVtKHRhZyk7XG5cbiAgICAgICAgdmFyICRvcHRpb24gPSB0aGlzLm9wdGlvbihpdGVtKTtcblxuICAgICAgICB0aGlzLiRlbGVtZW50LmFwcGVuZCgkb3B0aW9uKTtcbiAgICAgIH1cbiAgICB9XG4gIH1cblxuICBUYWdzLnByb3RvdHlwZS5xdWVyeSA9IGZ1bmN0aW9uIChkZWNvcmF0ZWQsIHBhcmFtcywgY2FsbGJhY2spIHtcbiAgICB2YXIgc2VsZiA9IHRoaXM7XG5cbiAgICB0aGlzLl9yZW1vdmVPbGRUYWdzKCk7XG5cbiAgICBpZiAocGFyYW1zLnRlcm0gPT0gbnVsbCB8fCBwYXJhbXMucGFnZSAhPSBudWxsKSB7XG4gICAgICBkZWNvcmF0ZWQuY2FsbCh0aGlzLCBwYXJhbXMsIGNhbGxiYWNrKTtcbiAgICAgIHJldHVybjtcbiAgICB9XG5cbiAgICBmdW5jdGlvbiB3cmFwcGVyIChvYmosIGNoaWxkKSB7XG4gICAgICB2YXIgZGF0YSA9IG9iai5yZXN1bHRzO1xuXG4gICAgICBmb3IgKHZhciBpID0gMDsgaSA8IGRhdGEubGVuZ3RoOyBpKyspIHtcbiAgICAgICAgdmFyIG9wdGlvbiA9IGRhdGFbaV07XG5cbiAgICAgICAgdmFyIGNoZWNrQ2hpbGRyZW4gPSAoXG4gICAgICAgICAgb3B0aW9uLmNoaWxkcmVuICE9IG51bGwgJiZcbiAgICAgICAgICAhd3JhcHBlcih7XG4gICAgICAgICAgICByZXN1bHRzOiBvcHRpb24uY2hpbGRyZW5cbiAgICAgICAgICB9LCB0cnVlKVxuICAgICAgICApO1xuXG4gICAgICAgIHZhciBvcHRpb25UZXh0ID0gKG9wdGlvbi50ZXh0IHx8ICcnKS50b1VwcGVyQ2FzZSgpO1xuICAgICAgICB2YXIgcGFyYW1zVGVybSA9IChwYXJhbXMudGVybSB8fCAnJykudG9VcHBlckNhc2UoKTtcblxuICAgICAgICB2YXIgY2hlY2tUZXh0ID0gb3B0aW9uVGV4dCA9PT0gcGFyYW1zVGVybTtcblxuICAgICAgICBpZiAoY2hlY2tUZXh0IHx8IGNoZWNrQ2hpbGRyZW4pIHtcbiAgICAgICAgICBpZiAoY2hpbGQpIHtcbiAgICAgICAgICAgIHJldHVybiBmYWxzZTtcbiAgICAgICAgICB9XG5cbiAgICAgICAgICBvYmouZGF0YSA9IGRhdGE7XG4gICAgICAgICAgY2FsbGJhY2sob2JqKTtcblxuICAgICAgICAgIHJldHVybjtcbiAgICAgICAgfVxuICAgICAgfVxuXG4gICAgICBpZiAoY2hpbGQpIHtcbiAgICAgICAgcmV0dXJuIHRydWU7XG4gICAgICB9XG5cbiAgICAgIHZhciB0YWcgPSBzZWxmLmNyZWF0ZVRhZyhwYXJhbXMpO1xuXG4gICAgICBpZiAodGFnICE9IG51bGwpIHtcbiAgICAgICAgdmFyICRvcHRpb24gPSBzZWxmLm9wdGlvbih0YWcpO1xuICAgICAgICAkb3B0aW9uLmF0dHIoJ2RhdGEtc2VsZWN0Mi10YWcnLCB0cnVlKTtcblxuICAgICAgICBzZWxmLmFkZE9wdGlvbnMoWyRvcHRpb25dKTtcblxuICAgICAgICBzZWxmLmluc2VydFRhZyhkYXRhLCB0YWcpO1xuICAgICAgfVxuXG4gICAgICBvYmoucmVzdWx0cyA9IGRhdGE7XG5cbiAgICAgIGNhbGxiYWNrKG9iaik7XG4gICAgfVxuXG4gICAgZGVjb3JhdGVkLmNhbGwodGhpcywgcGFyYW1zLCB3cmFwcGVyKTtcbiAgfTtcblxuICBUYWdzLnByb3RvdHlwZS5jcmVhdGVUYWcgPSBmdW5jdGlvbiAoZGVjb3JhdGVkLCBwYXJhbXMpIHtcbiAgICB2YXIgdGVybSA9ICQudHJpbShwYXJhbXMudGVybSk7XG5cbiAgICBpZiAodGVybSA9PT0gJycpIHtcbiAgICAgIHJldHVybiBudWxsO1xuICAgIH1cblxuICAgIHJldHVybiB7XG4gICAgICBpZDogdGVybSxcbiAgICAgIHRleHQ6IHRlcm1cbiAgICB9O1xuICB9O1xuXG4gIFRhZ3MucHJvdG90eXBlLmluc2VydFRhZyA9IGZ1bmN0aW9uIChfLCBkYXRhLCB0YWcpIHtcbiAgICBkYXRhLnVuc2hpZnQodGFnKTtcbiAgfTtcblxuICBUYWdzLnByb3RvdHlwZS5fcmVtb3ZlT2xkVGFncyA9IGZ1bmN0aW9uIChfKSB7XG4gICAgdmFyIHRhZyA9IHRoaXMuX2xhc3RUYWc7XG5cbiAgICB2YXIgJG9wdGlvbnMgPSB0aGlzLiRlbGVtZW50LmZpbmQoJ29wdGlvbltkYXRhLXNlbGVjdDItdGFnXScpO1xuXG4gICAgJG9wdGlvbnMuZWFjaChmdW5jdGlvbiAoKSB7XG4gICAgICBpZiAodGhpcy5zZWxlY3RlZCkge1xuICAgICAgICByZXR1cm47XG4gICAgICB9XG5cbiAgICAgICQodGhpcykucmVtb3ZlKCk7XG4gICAgfSk7XG4gIH07XG5cbiAgcmV0dXJuIFRhZ3M7XG59KTtcblxuUzIuZGVmaW5lKCdzZWxlY3QyL2RhdGEvdG9rZW5pemVyJyxbXG4gICdqcXVlcnknXG5dLCBmdW5jdGlvbiAoJCkge1xuICBmdW5jdGlvbiBUb2tlbml6ZXIgKGRlY29yYXRlZCwgJGVsZW1lbnQsIG9wdGlvbnMpIHtcbiAgICB2YXIgdG9rZW5pemVyID0gb3B0aW9ucy5nZXQoJ3Rva2VuaXplcicpO1xuXG4gICAgaWYgKHRva2VuaXplciAhPT0gdW5kZWZpbmVkKSB7XG4gICAgICB0aGlzLnRva2VuaXplciA9IHRva2VuaXplcjtcbiAgICB9XG5cbiAgICBkZWNvcmF0ZWQuY2FsbCh0aGlzLCAkZWxlbWVudCwgb3B0aW9ucyk7XG4gIH1cblxuICBUb2tlbml6ZXIucHJvdG90eXBlLmJpbmQgPSBmdW5jdGlvbiAoZGVjb3JhdGVkLCBjb250YWluZXIsICRjb250YWluZXIpIHtcbiAgICBkZWNvcmF0ZWQuY2FsbCh0aGlzLCBjb250YWluZXIsICRjb250YWluZXIpO1xuXG4gICAgdGhpcy4kc2VhcmNoID0gIGNvbnRhaW5lci5kcm9wZG93bi4kc2VhcmNoIHx8IGNvbnRhaW5lci5zZWxlY3Rpb24uJHNlYXJjaCB8fFxuICAgICAgJGNvbnRhaW5lci5maW5kKCcuc2VsZWN0Mi1zZWFyY2hfX2ZpZWxkJyk7XG4gIH07XG5cbiAgVG9rZW5pemVyLnByb3RvdHlwZS5xdWVyeSA9IGZ1bmN0aW9uIChkZWNvcmF0ZWQsIHBhcmFtcywgY2FsbGJhY2spIHtcbiAgICB2YXIgc2VsZiA9IHRoaXM7XG5cbiAgICBmdW5jdGlvbiBjcmVhdGVBbmRTZWxlY3QgKGRhdGEpIHtcbiAgICAgIC8vIE5vcm1hbGl6ZSB0aGUgZGF0YSBvYmplY3Qgc28gd2UgY2FuIHVzZSBpdCBmb3IgY2hlY2tzXG4gICAgICB2YXIgaXRlbSA9IHNlbGYuX25vcm1hbGl6ZUl0ZW0oZGF0YSk7XG5cbiAgICAgIC8vIENoZWNrIGlmIHRoZSBkYXRhIG9iamVjdCBhbHJlYWR5IGV4aXN0cyBhcyBhIHRhZ1xuICAgICAgLy8gU2VsZWN0IGl0IGlmIGl0IGRvZXNuJ3RcbiAgICAgIHZhciAkZXhpc3RpbmdPcHRpb25zID0gc2VsZi4kZWxlbWVudC5maW5kKCdvcHRpb24nKS5maWx0ZXIoZnVuY3Rpb24gKCkge1xuICAgICAgICByZXR1cm4gJCh0aGlzKS52YWwoKSA9PT0gaXRlbS5pZDtcbiAgICAgIH0pO1xuXG4gICAgICAvLyBJZiBhbiBleGlzdGluZyBvcHRpb24gd2Fzbid0IGZvdW5kIGZvciBpdCwgY3JlYXRlIHRoZSBvcHRpb25cbiAgICAgIGlmICghJGV4aXN0aW5nT3B0aW9ucy5sZW5ndGgpIHtcbiAgICAgICAgdmFyICRvcHRpb24gPSBzZWxmLm9wdGlvbihpdGVtKTtcbiAgICAgICAgJG9wdGlvbi5hdHRyKCdkYXRhLXNlbGVjdDItdGFnJywgdHJ1ZSk7XG5cbiAgICAgICAgc2VsZi5fcmVtb3ZlT2xkVGFncygpO1xuICAgICAgICBzZWxmLmFkZE9wdGlvbnMoWyRvcHRpb25dKTtcbiAgICAgIH1cblxuICAgICAgLy8gU2VsZWN0IHRoZSBpdGVtLCBub3cgdGhhdCB3ZSBrbm93IHRoZXJlIGlzIGFuIG9wdGlvbiBmb3IgaXRcbiAgICAgIHNlbGVjdChpdGVtKTtcbiAgICB9XG5cbiAgICBmdW5jdGlvbiBzZWxlY3QgKGRhdGEpIHtcbiAgICAgIHNlbGYudHJpZ2dlcignc2VsZWN0Jywge1xuICAgICAgICBkYXRhOiBkYXRhXG4gICAgICB9KTtcbiAgICB9XG5cbiAgICBwYXJhbXMudGVybSA9IHBhcmFtcy50ZXJtIHx8ICcnO1xuXG4gICAgdmFyIHRva2VuRGF0YSA9IHRoaXMudG9rZW5pemVyKHBhcmFtcywgdGhpcy5vcHRpb25zLCBjcmVhdGVBbmRTZWxlY3QpO1xuXG4gICAgaWYgKHRva2VuRGF0YS50ZXJtICE9PSBwYXJhbXMudGVybSkge1xuICAgICAgLy8gUmVwbGFjZSB0aGUgc2VhcmNoIHRlcm0gaWYgd2UgaGF2ZSB0aGUgc2VhcmNoIGJveFxuICAgICAgaWYgKHRoaXMuJHNlYXJjaC5sZW5ndGgpIHtcbiAgICAgICAgdGhpcy4kc2VhcmNoLnZhbCh0b2tlbkRhdGEudGVybSk7XG4gICAgICAgIHRoaXMuJHNlYXJjaC5mb2N1cygpO1xuICAgICAgfVxuXG4gICAgICBwYXJhbXMudGVybSA9IHRva2VuRGF0YS50ZXJtO1xuICAgIH1cblxuICAgIGRlY29yYXRlZC5jYWxsKHRoaXMsIHBhcmFtcywgY2FsbGJhY2spO1xuICB9O1xuXG4gIFRva2VuaXplci5wcm90b3R5cGUudG9rZW5pemVyID0gZnVuY3Rpb24gKF8sIHBhcmFtcywgb3B0aW9ucywgY2FsbGJhY2spIHtcbiAgICB2YXIgc2VwYXJhdG9ycyA9IG9wdGlvbnMuZ2V0KCd0b2tlblNlcGFyYXRvcnMnKSB8fCBbXTtcbiAgICB2YXIgdGVybSA9IHBhcmFtcy50ZXJtO1xuICAgIHZhciBpID0gMDtcblxuICAgIHZhciBjcmVhdGVUYWcgPSB0aGlzLmNyZWF0ZVRhZyB8fCBmdW5jdGlvbiAocGFyYW1zKSB7XG4gICAgICByZXR1cm4ge1xuICAgICAgICBpZDogcGFyYW1zLnRlcm0sXG4gICAgICAgIHRleHQ6IHBhcmFtcy50ZXJtXG4gICAgICB9O1xuICAgIH07XG5cbiAgICB3aGlsZSAoaSA8IHRlcm0ubGVuZ3RoKSB7XG4gICAgICB2YXIgdGVybUNoYXIgPSB0ZXJtW2ldO1xuXG4gICAgICBpZiAoJC5pbkFycmF5KHRlcm1DaGFyLCBzZXBhcmF0b3JzKSA9PT0gLTEpIHtcbiAgICAgICAgaSsrO1xuXG4gICAgICAgIGNvbnRpbnVlO1xuICAgICAgfVxuXG4gICAgICB2YXIgcGFydCA9IHRlcm0uc3Vic3RyKDAsIGkpO1xuICAgICAgdmFyIHBhcnRQYXJhbXMgPSAkLmV4dGVuZCh7fSwgcGFyYW1zLCB7XG4gICAgICAgIHRlcm06IHBhcnRcbiAgICAgIH0pO1xuXG4gICAgICB2YXIgZGF0YSA9IGNyZWF0ZVRhZyhwYXJ0UGFyYW1zKTtcblxuICAgICAgaWYgKGRhdGEgPT0gbnVsbCkge1xuICAgICAgICBpKys7XG4gICAgICAgIGNvbnRpbnVlO1xuICAgICAgfVxuXG4gICAgICBjYWxsYmFjayhkYXRhKTtcblxuICAgICAgLy8gUmVzZXQgdGhlIHRlcm0gdG8gbm90IGluY2x1ZGUgdGhlIHRva2VuaXplZCBwb3J0aW9uXG4gICAgICB0ZXJtID0gdGVybS5zdWJzdHIoaSArIDEpIHx8ICcnO1xuICAgICAgaSA9IDA7XG4gICAgfVxuXG4gICAgcmV0dXJuIHtcbiAgICAgIHRlcm06IHRlcm1cbiAgICB9O1xuICB9O1xuXG4gIHJldHVybiBUb2tlbml6ZXI7XG59KTtcblxuUzIuZGVmaW5lKCdzZWxlY3QyL2RhdGEvbWluaW11bUlucHV0TGVuZ3RoJyxbXG5cbl0sIGZ1bmN0aW9uICgpIHtcbiAgZnVuY3Rpb24gTWluaW11bUlucHV0TGVuZ3RoIChkZWNvcmF0ZWQsICRlLCBvcHRpb25zKSB7XG4gICAgdGhpcy5taW5pbXVtSW5wdXRMZW5ndGggPSBvcHRpb25zLmdldCgnbWluaW11bUlucHV0TGVuZ3RoJyk7XG5cbiAgICBkZWNvcmF0ZWQuY2FsbCh0aGlzLCAkZSwgb3B0aW9ucyk7XG4gIH1cblxuICBNaW5pbXVtSW5wdXRMZW5ndGgucHJvdG90eXBlLnF1ZXJ5ID0gZnVuY3Rpb24gKGRlY29yYXRlZCwgcGFyYW1zLCBjYWxsYmFjaykge1xuICAgIHBhcmFtcy50ZXJtID0gcGFyYW1zLnRlcm0gfHwgJyc7XG5cbiAgICBpZiAocGFyYW1zLnRlcm0ubGVuZ3RoIDwgdGhpcy5taW5pbXVtSW5wdXRMZW5ndGgpIHtcbiAgICAgIHRoaXMudHJpZ2dlcigncmVzdWx0czptZXNzYWdlJywge1xuICAgICAgICBtZXNzYWdlOiAnaW5wdXRUb29TaG9ydCcsXG4gICAgICAgIGFyZ3M6IHtcbiAgICAgICAgICBtaW5pbXVtOiB0aGlzLm1pbmltdW1JbnB1dExlbmd0aCxcbiAgICAgICAgICBpbnB1dDogcGFyYW1zLnRlcm0sXG4gICAgICAgICAgcGFyYW1zOiBwYXJhbXNcbiAgICAgICAgfVxuICAgICAgfSk7XG5cbiAgICAgIHJldHVybjtcbiAgICB9XG5cbiAgICBkZWNvcmF0ZWQuY2FsbCh0aGlzLCBwYXJhbXMsIGNhbGxiYWNrKTtcbiAgfTtcblxuICByZXR1cm4gTWluaW11bUlucHV0TGVuZ3RoO1xufSk7XG5cblMyLmRlZmluZSgnc2VsZWN0Mi9kYXRhL21heGltdW1JbnB1dExlbmd0aCcsW1xuXG5dLCBmdW5jdGlvbiAoKSB7XG4gIGZ1bmN0aW9uIE1heGltdW1JbnB1dExlbmd0aCAoZGVjb3JhdGVkLCAkZSwgb3B0aW9ucykge1xuICAgIHRoaXMubWF4aW11bUlucHV0TGVuZ3RoID0gb3B0aW9ucy5nZXQoJ21heGltdW1JbnB1dExlbmd0aCcpO1xuXG4gICAgZGVjb3JhdGVkLmNhbGwodGhpcywgJGUsIG9wdGlvbnMpO1xuICB9XG5cbiAgTWF4aW11bUlucHV0TGVuZ3RoLnByb3RvdHlwZS5xdWVyeSA9IGZ1bmN0aW9uIChkZWNvcmF0ZWQsIHBhcmFtcywgY2FsbGJhY2spIHtcbiAgICBwYXJhbXMudGVybSA9IHBhcmFtcy50ZXJtIHx8ICcnO1xuXG4gICAgaWYgKHRoaXMubWF4aW11bUlucHV0TGVuZ3RoID4gMCAmJlxuICAgICAgICBwYXJhbXMudGVybS5sZW5ndGggPiB0aGlzLm1heGltdW1JbnB1dExlbmd0aCkge1xuICAgICAgdGhpcy50cmlnZ2VyKCdyZXN1bHRzOm1lc3NhZ2UnLCB7XG4gICAgICAgIG1lc3NhZ2U6ICdpbnB1dFRvb0xvbmcnLFxuICAgICAgICBhcmdzOiB7XG4gICAgICAgICAgbWF4aW11bTogdGhpcy5tYXhpbXVtSW5wdXRMZW5ndGgsXG4gICAgICAgICAgaW5wdXQ6IHBhcmFtcy50ZXJtLFxuICAgICAgICAgIHBhcmFtczogcGFyYW1zXG4gICAgICAgIH1cbiAgICAgIH0pO1xuXG4gICAgICByZXR1cm47XG4gICAgfVxuXG4gICAgZGVjb3JhdGVkLmNhbGwodGhpcywgcGFyYW1zLCBjYWxsYmFjayk7XG4gIH07XG5cbiAgcmV0dXJuIE1heGltdW1JbnB1dExlbmd0aDtcbn0pO1xuXG5TMi5kZWZpbmUoJ3NlbGVjdDIvZGF0YS9tYXhpbXVtU2VsZWN0aW9uTGVuZ3RoJyxbXG5cbl0sIGZ1bmN0aW9uICgpe1xuICBmdW5jdGlvbiBNYXhpbXVtU2VsZWN0aW9uTGVuZ3RoIChkZWNvcmF0ZWQsICRlLCBvcHRpb25zKSB7XG4gICAgdGhpcy5tYXhpbXVtU2VsZWN0aW9uTGVuZ3RoID0gb3B0aW9ucy5nZXQoJ21heGltdW1TZWxlY3Rpb25MZW5ndGgnKTtcblxuICAgIGRlY29yYXRlZC5jYWxsKHRoaXMsICRlLCBvcHRpb25zKTtcbiAgfVxuXG4gIE1heGltdW1TZWxlY3Rpb25MZW5ndGgucHJvdG90eXBlLnF1ZXJ5ID1cbiAgICBmdW5jdGlvbiAoZGVjb3JhdGVkLCBwYXJhbXMsIGNhbGxiYWNrKSB7XG4gICAgICB2YXIgc2VsZiA9IHRoaXM7XG5cbiAgICAgIHRoaXMuY3VycmVudChmdW5jdGlvbiAoY3VycmVudERhdGEpIHtcbiAgICAgICAgdmFyIGNvdW50ID0gY3VycmVudERhdGEgIT0gbnVsbCA/IGN1cnJlbnREYXRhLmxlbmd0aCA6IDA7XG4gICAgICAgIGlmIChzZWxmLm1heGltdW1TZWxlY3Rpb25MZW5ndGggPiAwICYmXG4gICAgICAgICAgY291bnQgPj0gc2VsZi5tYXhpbXVtU2VsZWN0aW9uTGVuZ3RoKSB7XG4gICAgICAgICAgc2VsZi50cmlnZ2VyKCdyZXN1bHRzOm1lc3NhZ2UnLCB7XG4gICAgICAgICAgICBtZXNzYWdlOiAnbWF4aW11bVNlbGVjdGVkJyxcbiAgICAgICAgICAgIGFyZ3M6IHtcbiAgICAgICAgICAgICAgbWF4aW11bTogc2VsZi5tYXhpbXVtU2VsZWN0aW9uTGVuZ3RoXG4gICAgICAgICAgICB9XG4gICAgICAgICAgfSk7XG4gICAgICAgICAgcmV0dXJuO1xuICAgICAgICB9XG4gICAgICAgIGRlY29yYXRlZC5jYWxsKHNlbGYsIHBhcmFtcywgY2FsbGJhY2spO1xuICAgICAgfSk7XG4gIH07XG5cbiAgcmV0dXJuIE1heGltdW1TZWxlY3Rpb25MZW5ndGg7XG59KTtcblxuUzIuZGVmaW5lKCdzZWxlY3QyL2Ryb3Bkb3duJyxbXG4gICdqcXVlcnknLFxuICAnLi91dGlscydcbl0sIGZ1bmN0aW9uICgkLCBVdGlscykge1xuICBmdW5jdGlvbiBEcm9wZG93biAoJGVsZW1lbnQsIG9wdGlvbnMpIHtcbiAgICB0aGlzLiRlbGVtZW50ID0gJGVsZW1lbnQ7XG4gICAgdGhpcy5vcHRpb25zID0gb3B0aW9ucztcblxuICAgIERyb3Bkb3duLl9fc3VwZXJfXy5jb25zdHJ1Y3Rvci5jYWxsKHRoaXMpO1xuICB9XG5cbiAgVXRpbHMuRXh0ZW5kKERyb3Bkb3duLCBVdGlscy5PYnNlcnZhYmxlKTtcblxuICBEcm9wZG93bi5wcm90b3R5cGUucmVuZGVyID0gZnVuY3Rpb24gKCkge1xuICAgIHZhciAkZHJvcGRvd24gPSAkKFxuICAgICAgJzxzcGFuIGNsYXNzPVwic2VsZWN0Mi1kcm9wZG93blwiPicgK1xuICAgICAgICAnPHNwYW4gY2xhc3M9XCJzZWxlY3QyLXJlc3VsdHNcIj48L3NwYW4+JyArXG4gICAgICAnPC9zcGFuPidcbiAgICApO1xuXG4gICAgJGRyb3Bkb3duLmF0dHIoJ2RpcicsIHRoaXMub3B0aW9ucy5nZXQoJ2RpcicpKTtcblxuICAgIHRoaXMuJGRyb3Bkb3duID0gJGRyb3Bkb3duO1xuXG4gICAgcmV0dXJuICRkcm9wZG93bjtcbiAgfTtcblxuICBEcm9wZG93bi5wcm90b3R5cGUuYmluZCA9IGZ1bmN0aW9uICgpIHtcbiAgICAvLyBTaG91bGQgYmUgaW1wbGVtZW50ZWQgaW4gc3ViY2xhc3Nlc1xuICB9O1xuXG4gIERyb3Bkb3duLnByb3RvdHlwZS5wb3NpdGlvbiA9IGZ1bmN0aW9uICgkZHJvcGRvd24sICRjb250YWluZXIpIHtcbiAgICAvLyBTaG91bGQgYmUgaW1wbG1lbnRlZCBpbiBzdWJjbGFzc2VzXG4gIH07XG5cbiAgRHJvcGRvd24ucHJvdG90eXBlLmRlc3Ryb3kgPSBmdW5jdGlvbiAoKSB7XG4gICAgLy8gUmVtb3ZlIHRoZSBkcm9wZG93biBmcm9tIHRoZSBET01cbiAgICB0aGlzLiRkcm9wZG93bi5yZW1vdmUoKTtcbiAgfTtcblxuICByZXR1cm4gRHJvcGRvd247XG59KTtcblxuUzIuZGVmaW5lKCdzZWxlY3QyL2Ryb3Bkb3duL3NlYXJjaCcsW1xuICAnanF1ZXJ5JyxcbiAgJy4uL3V0aWxzJ1xuXSwgZnVuY3Rpb24gKCQsIFV0aWxzKSB7XG4gIGZ1bmN0aW9uIFNlYXJjaCAoKSB7IH1cblxuICBTZWFyY2gucHJvdG90eXBlLnJlbmRlciA9IGZ1bmN0aW9uIChkZWNvcmF0ZWQpIHtcbiAgICB2YXIgJHJlbmRlcmVkID0gZGVjb3JhdGVkLmNhbGwodGhpcyk7XG5cbiAgICB2YXIgJHNlYXJjaCA9ICQoXG4gICAgICAnPHNwYW4gY2xhc3M9XCJzZWxlY3QyLXNlYXJjaCBzZWxlY3QyLXNlYXJjaC0tZHJvcGRvd25cIj4nICtcbiAgICAgICAgJzxpbnB1dCBjbGFzcz1cInNlbGVjdDItc2VhcmNoX19maWVsZFwiIHR5cGU9XCJzZWFyY2hcIiB0YWJpbmRleD1cIi0xXCInICtcbiAgICAgICAgJyBhdXRvY29tcGxldGU9XCJvZmZcIiBhdXRvY29ycmVjdD1cIm9mZlwiIGF1dG9jYXBpdGFsaXplPVwibm9uZVwiJyArXG4gICAgICAgICcgc3BlbGxjaGVjaz1cImZhbHNlXCIgcm9sZT1cInRleHRib3hcIiAvPicgK1xuICAgICAgJzwvc3Bhbj4nXG4gICAgKTtcblxuICAgIHRoaXMuJHNlYXJjaENvbnRhaW5lciA9ICRzZWFyY2g7XG4gICAgdGhpcy4kc2VhcmNoID0gJHNlYXJjaC5maW5kKCdpbnB1dCcpO1xuXG4gICAgJHJlbmRlcmVkLnByZXBlbmQoJHNlYXJjaCk7XG5cbiAgICByZXR1cm4gJHJlbmRlcmVkO1xuICB9O1xuXG4gIFNlYXJjaC5wcm90b3R5cGUuYmluZCA9IGZ1bmN0aW9uIChkZWNvcmF0ZWQsIGNvbnRhaW5lciwgJGNvbnRhaW5lcikge1xuICAgIHZhciBzZWxmID0gdGhpcztcblxuICAgIGRlY29yYXRlZC5jYWxsKHRoaXMsIGNvbnRhaW5lciwgJGNvbnRhaW5lcik7XG5cbiAgICB0aGlzLiRzZWFyY2gub24oJ2tleWRvd24nLCBmdW5jdGlvbiAoZXZ0KSB7XG4gICAgICBzZWxmLnRyaWdnZXIoJ2tleXByZXNzJywgZXZ0KTtcblxuICAgICAgc2VsZi5fa2V5VXBQcmV2ZW50ZWQgPSBldnQuaXNEZWZhdWx0UHJldmVudGVkKCk7XG4gICAgfSk7XG5cbiAgICAvLyBXb3JrYXJvdW5kIGZvciBicm93c2VycyB3aGljaCBkbyBub3Qgc3VwcG9ydCB0aGUgYGlucHV0YCBldmVudFxuICAgIC8vIFRoaXMgd2lsbCBwcmV2ZW50IGRvdWJsZS10cmlnZ2VyaW5nIG9mIGV2ZW50cyBmb3IgYnJvd3NlcnMgd2hpY2ggc3VwcG9ydFxuICAgIC8vIGJvdGggdGhlIGBrZXl1cGAgYW5kIGBpbnB1dGAgZXZlbnRzLlxuICAgIHRoaXMuJHNlYXJjaC5vbignaW5wdXQnLCBmdW5jdGlvbiAoZXZ0KSB7XG4gICAgICAvLyBVbmJpbmQgdGhlIGR1cGxpY2F0ZWQgYGtleXVwYCBldmVudFxuICAgICAgJCh0aGlzKS5vZmYoJ2tleXVwJyk7XG4gICAgfSk7XG5cbiAgICB0aGlzLiRzZWFyY2gub24oJ2tleXVwIGlucHV0JywgZnVuY3Rpb24gKGV2dCkge1xuICAgICAgc2VsZi5oYW5kbGVTZWFyY2goZXZ0KTtcbiAgICB9KTtcblxuICAgIGNvbnRhaW5lci5vbignb3BlbicsIGZ1bmN0aW9uICgpIHtcbiAgICAgIHNlbGYuJHNlYXJjaC5hdHRyKCd0YWJpbmRleCcsIDApO1xuXG4gICAgICBzZWxmLiRzZWFyY2guZm9jdXMoKTtcblxuICAgICAgd2luZG93LnNldFRpbWVvdXQoZnVuY3Rpb24gKCkge1xuICAgICAgICBzZWxmLiRzZWFyY2guZm9jdXMoKTtcbiAgICAgIH0sIDApO1xuICAgIH0pO1xuXG4gICAgY29udGFpbmVyLm9uKCdjbG9zZScsIGZ1bmN0aW9uICgpIHtcbiAgICAgIHNlbGYuJHNlYXJjaC5hdHRyKCd0YWJpbmRleCcsIC0xKTtcblxuICAgICAgc2VsZi4kc2VhcmNoLnZhbCgnJyk7XG4gICAgfSk7XG5cbiAgICBjb250YWluZXIub24oJ2ZvY3VzJywgZnVuY3Rpb24gKCkge1xuICAgICAgaWYgKCFjb250YWluZXIuaXNPcGVuKCkpIHtcbiAgICAgICAgc2VsZi4kc2VhcmNoLmZvY3VzKCk7XG4gICAgICB9XG4gICAgfSk7XG5cbiAgICBjb250YWluZXIub24oJ3Jlc3VsdHM6YWxsJywgZnVuY3Rpb24gKHBhcmFtcykge1xuICAgICAgaWYgKHBhcmFtcy5xdWVyeS50ZXJtID09IG51bGwgfHwgcGFyYW1zLnF1ZXJ5LnRlcm0gPT09ICcnKSB7XG4gICAgICAgIHZhciBzaG93U2VhcmNoID0gc2VsZi5zaG93U2VhcmNoKHBhcmFtcyk7XG5cbiAgICAgICAgaWYgKHNob3dTZWFyY2gpIHtcbiAgICAgICAgICBzZWxmLiRzZWFyY2hDb250YWluZXIucmVtb3ZlQ2xhc3MoJ3NlbGVjdDItc2VhcmNoLS1oaWRlJyk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgc2VsZi4kc2VhcmNoQ29udGFpbmVyLmFkZENsYXNzKCdzZWxlY3QyLXNlYXJjaC0taGlkZScpO1xuICAgICAgICB9XG4gICAgICB9XG4gICAgfSk7XG4gIH07XG5cbiAgU2VhcmNoLnByb3RvdHlwZS5oYW5kbGVTZWFyY2ggPSBmdW5jdGlvbiAoZXZ0KSB7XG4gICAgaWYgKCF0aGlzLl9rZXlVcFByZXZlbnRlZCkge1xuICAgICAgdmFyIGlucHV0ID0gdGhpcy4kc2VhcmNoLnZhbCgpO1xuXG4gICAgICB0aGlzLnRyaWdnZXIoJ3F1ZXJ5Jywge1xuICAgICAgICB0ZXJtOiBpbnB1dFxuICAgICAgfSk7XG4gICAgfVxuXG4gICAgdGhpcy5fa2V5VXBQcmV2ZW50ZWQgPSBmYWxzZTtcbiAgfTtcblxuICBTZWFyY2gucHJvdG90eXBlLnNob3dTZWFyY2ggPSBmdW5jdGlvbiAoXywgcGFyYW1zKSB7XG4gICAgcmV0dXJuIHRydWU7XG4gIH07XG5cbiAgcmV0dXJuIFNlYXJjaDtcbn0pO1xuXG5TMi5kZWZpbmUoJ3NlbGVjdDIvZHJvcGRvd24vaGlkZVBsYWNlaG9sZGVyJyxbXG5cbl0sIGZ1bmN0aW9uICgpIHtcbiAgZnVuY3Rpb24gSGlkZVBsYWNlaG9sZGVyIChkZWNvcmF0ZWQsICRlbGVtZW50LCBvcHRpb25zLCBkYXRhQWRhcHRlcikge1xuICAgIHRoaXMucGxhY2Vob2xkZXIgPSB0aGlzLm5vcm1hbGl6ZVBsYWNlaG9sZGVyKG9wdGlvbnMuZ2V0KCdwbGFjZWhvbGRlcicpKTtcblxuICAgIGRlY29yYXRlZC5jYWxsKHRoaXMsICRlbGVtZW50LCBvcHRpb25zLCBkYXRhQWRhcHRlcik7XG4gIH1cblxuICBIaWRlUGxhY2Vob2xkZXIucHJvdG90eXBlLmFwcGVuZCA9IGZ1bmN0aW9uIChkZWNvcmF0ZWQsIGRhdGEpIHtcbiAgICBkYXRhLnJlc3VsdHMgPSB0aGlzLnJlbW92ZVBsYWNlaG9sZGVyKGRhdGEucmVzdWx0cyk7XG5cbiAgICBkZWNvcmF0ZWQuY2FsbCh0aGlzLCBkYXRhKTtcbiAgfTtcblxuICBIaWRlUGxhY2Vob2xkZXIucHJvdG90eXBlLm5vcm1hbGl6ZVBsYWNlaG9sZGVyID0gZnVuY3Rpb24gKF8sIHBsYWNlaG9sZGVyKSB7XG4gICAgaWYgKHR5cGVvZiBwbGFjZWhvbGRlciA9PT0gJ3N0cmluZycpIHtcbiAgICAgIHBsYWNlaG9sZGVyID0ge1xuICAgICAgICBpZDogJycsXG4gICAgICAgIHRleHQ6IHBsYWNlaG9sZGVyXG4gICAgICB9O1xuICAgIH1cblxuICAgIHJldHVybiBwbGFjZWhvbGRlcjtcbiAgfTtcblxuICBIaWRlUGxhY2Vob2xkZXIucHJvdG90eXBlLnJlbW92ZVBsYWNlaG9sZGVyID0gZnVuY3Rpb24gKF8sIGRhdGEpIHtcbiAgICB2YXIgbW9kaWZpZWREYXRhID0gZGF0YS5zbGljZSgwKTtcblxuICAgIGZvciAodmFyIGQgPSBkYXRhLmxlbmd0aCAtIDE7IGQgPj0gMDsgZC0tKSB7XG4gICAgICB2YXIgaXRlbSA9IGRhdGFbZF07XG5cbiAgICAgIGlmICh0aGlzLnBsYWNlaG9sZGVyLmlkID09PSBpdGVtLmlkKSB7XG4gICAgICAgIG1vZGlmaWVkRGF0YS5zcGxpY2UoZCwgMSk7XG4gICAgICB9XG4gICAgfVxuXG4gICAgcmV0dXJuIG1vZGlmaWVkRGF0YTtcbiAgfTtcblxuICByZXR1cm4gSGlkZVBsYWNlaG9sZGVyO1xufSk7XG5cblMyLmRlZmluZSgnc2VsZWN0Mi9kcm9wZG93bi9pbmZpbml0ZVNjcm9sbCcsW1xuICAnanF1ZXJ5J1xuXSwgZnVuY3Rpb24gKCQpIHtcbiAgZnVuY3Rpb24gSW5maW5pdGVTY3JvbGwgKGRlY29yYXRlZCwgJGVsZW1lbnQsIG9wdGlvbnMsIGRhdGFBZGFwdGVyKSB7XG4gICAgdGhpcy5sYXN0UGFyYW1zID0ge307XG5cbiAgICBkZWNvcmF0ZWQuY2FsbCh0aGlzLCAkZWxlbWVudCwgb3B0aW9ucywgZGF0YUFkYXB0ZXIpO1xuXG4gICAgdGhpcy4kbG9hZGluZ01vcmUgPSB0aGlzLmNyZWF0ZUxvYWRpbmdNb3JlKCk7XG4gICAgdGhpcy5sb2FkaW5nID0gZmFsc2U7XG4gIH1cblxuICBJbmZpbml0ZVNjcm9sbC5wcm90b3R5cGUuYXBwZW5kID0gZnVuY3Rpb24gKGRlY29yYXRlZCwgZGF0YSkge1xuICAgIHRoaXMuJGxvYWRpbmdNb3JlLnJlbW92ZSgpO1xuICAgIHRoaXMubG9hZGluZyA9IGZhbHNlO1xuXG4gICAgZGVjb3JhdGVkLmNhbGwodGhpcywgZGF0YSk7XG5cbiAgICBpZiAodGhpcy5zaG93TG9hZGluZ01vcmUoZGF0YSkpIHtcbiAgICAgIHRoaXMuJHJlc3VsdHMuYXBwZW5kKHRoaXMuJGxvYWRpbmdNb3JlKTtcbiAgICB9XG4gIH07XG5cbiAgSW5maW5pdGVTY3JvbGwucHJvdG90eXBlLmJpbmQgPSBmdW5jdGlvbiAoZGVjb3JhdGVkLCBjb250YWluZXIsICRjb250YWluZXIpIHtcbiAgICB2YXIgc2VsZiA9IHRoaXM7XG5cbiAgICBkZWNvcmF0ZWQuY2FsbCh0aGlzLCBjb250YWluZXIsICRjb250YWluZXIpO1xuXG4gICAgY29udGFpbmVyLm9uKCdxdWVyeScsIGZ1bmN0aW9uIChwYXJhbXMpIHtcbiAgICAgIHNlbGYubGFzdFBhcmFtcyA9IHBhcmFtcztcbiAgICAgIHNlbGYubG9hZGluZyA9IHRydWU7XG4gICAgfSk7XG5cbiAgICBjb250YWluZXIub24oJ3F1ZXJ5OmFwcGVuZCcsIGZ1bmN0aW9uIChwYXJhbXMpIHtcbiAgICAgIHNlbGYubGFzdFBhcmFtcyA9IHBhcmFtcztcbiAgICAgIHNlbGYubG9hZGluZyA9IHRydWU7XG4gICAgfSk7XG5cbiAgICB0aGlzLiRyZXN1bHRzLm9uKCdzY3JvbGwnLCBmdW5jdGlvbiAoKSB7XG4gICAgICB2YXIgaXNMb2FkTW9yZVZpc2libGUgPSAkLmNvbnRhaW5zKFxuICAgICAgICBkb2N1bWVudC5kb2N1bWVudEVsZW1lbnQsXG4gICAgICAgIHNlbGYuJGxvYWRpbmdNb3JlWzBdXG4gICAgICApO1xuXG4gICAgICBpZiAoc2VsZi5sb2FkaW5nIHx8ICFpc0xvYWRNb3JlVmlzaWJsZSkge1xuICAgICAgICByZXR1cm47XG4gICAgICB9XG5cbiAgICAgIHZhciBjdXJyZW50T2Zmc2V0ID0gc2VsZi4kcmVzdWx0cy5vZmZzZXQoKS50b3AgK1xuICAgICAgICBzZWxmLiRyZXN1bHRzLm91dGVySGVpZ2h0KGZhbHNlKTtcbiAgICAgIHZhciBsb2FkaW5nTW9yZU9mZnNldCA9IHNlbGYuJGxvYWRpbmdNb3JlLm9mZnNldCgpLnRvcCArXG4gICAgICAgIHNlbGYuJGxvYWRpbmdNb3JlLm91dGVySGVpZ2h0KGZhbHNlKTtcblxuICAgICAgaWYgKGN1cnJlbnRPZmZzZXQgKyA1MCA+PSBsb2FkaW5nTW9yZU9mZnNldCkge1xuICAgICAgICBzZWxmLmxvYWRNb3JlKCk7XG4gICAgICB9XG4gICAgfSk7XG4gIH07XG5cbiAgSW5maW5pdGVTY3JvbGwucHJvdG90eXBlLmxvYWRNb3JlID0gZnVuY3Rpb24gKCkge1xuICAgIHRoaXMubG9hZGluZyA9IHRydWU7XG5cbiAgICB2YXIgcGFyYW1zID0gJC5leHRlbmQoe30sIHtwYWdlOiAxfSwgdGhpcy5sYXN0UGFyYW1zKTtcblxuICAgIHBhcmFtcy5wYWdlKys7XG5cbiAgICB0aGlzLnRyaWdnZXIoJ3F1ZXJ5OmFwcGVuZCcsIHBhcmFtcyk7XG4gIH07XG5cbiAgSW5maW5pdGVTY3JvbGwucHJvdG90eXBlLnNob3dMb2FkaW5nTW9yZSA9IGZ1bmN0aW9uIChfLCBkYXRhKSB7XG4gICAgcmV0dXJuIGRhdGEucGFnaW5hdGlvbiAmJiBkYXRhLnBhZ2luYXRpb24ubW9yZTtcbiAgfTtcblxuICBJbmZpbml0ZVNjcm9sbC5wcm90b3R5cGUuY3JlYXRlTG9hZGluZ01vcmUgPSBmdW5jdGlvbiAoKSB7XG4gICAgdmFyICRvcHRpb24gPSAkKFxuICAgICAgJzxsaSAnICtcbiAgICAgICdjbGFzcz1cInNlbGVjdDItcmVzdWx0c19fb3B0aW9uIHNlbGVjdDItcmVzdWx0c19fb3B0aW9uLS1sb2FkLW1vcmVcIicgK1xuICAgICAgJ3JvbGU9XCJ0cmVlaXRlbVwiIGFyaWEtZGlzYWJsZWQ9XCJ0cnVlXCI+PC9saT4nXG4gICAgKTtcblxuICAgIHZhciBtZXNzYWdlID0gdGhpcy5vcHRpb25zLmdldCgndHJhbnNsYXRpb25zJykuZ2V0KCdsb2FkaW5nTW9yZScpO1xuXG4gICAgJG9wdGlvbi5odG1sKG1lc3NhZ2UodGhpcy5sYXN0UGFyYW1zKSk7XG5cbiAgICByZXR1cm4gJG9wdGlvbjtcbiAgfTtcblxuICByZXR1cm4gSW5maW5pdGVTY3JvbGw7XG59KTtcblxuUzIuZGVmaW5lKCdzZWxlY3QyL2Ryb3Bkb3duL2F0dGFjaEJvZHknLFtcbiAgJ2pxdWVyeScsXG4gICcuLi91dGlscydcbl0sIGZ1bmN0aW9uICgkLCBVdGlscykge1xuICBmdW5jdGlvbiBBdHRhY2hCb2R5IChkZWNvcmF0ZWQsICRlbGVtZW50LCBvcHRpb25zKSB7XG4gICAgdGhpcy4kZHJvcGRvd25QYXJlbnQgPSBvcHRpb25zLmdldCgnZHJvcGRvd25QYXJlbnQnKSB8fCAkKGRvY3VtZW50LmJvZHkpO1xuXG4gICAgZGVjb3JhdGVkLmNhbGwodGhpcywgJGVsZW1lbnQsIG9wdGlvbnMpO1xuICB9XG5cbiAgQXR0YWNoQm9keS5wcm90b3R5cGUuYmluZCA9IGZ1bmN0aW9uIChkZWNvcmF0ZWQsIGNvbnRhaW5lciwgJGNvbnRhaW5lcikge1xuICAgIHZhciBzZWxmID0gdGhpcztcblxuICAgIHZhciBzZXR1cFJlc3VsdHNFdmVudHMgPSBmYWxzZTtcblxuICAgIGRlY29yYXRlZC5jYWxsKHRoaXMsIGNvbnRhaW5lciwgJGNvbnRhaW5lcik7XG5cbiAgICBjb250YWluZXIub24oJ29wZW4nLCBmdW5jdGlvbiAoKSB7XG4gICAgICBzZWxmLl9zaG93RHJvcGRvd24oKTtcbiAgICAgIHNlbGYuX2F0dGFjaFBvc2l0aW9uaW5nSGFuZGxlcihjb250YWluZXIpO1xuXG4gICAgICBpZiAoIXNldHVwUmVzdWx0c0V2ZW50cykge1xuICAgICAgICBzZXR1cFJlc3VsdHNFdmVudHMgPSB0cnVlO1xuXG4gICAgICAgIGNvbnRhaW5lci5vbigncmVzdWx0czphbGwnLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgc2VsZi5fcG9zaXRpb25Ecm9wZG93bigpO1xuICAgICAgICAgIHNlbGYuX3Jlc2l6ZURyb3Bkb3duKCk7XG4gICAgICAgIH0pO1xuXG4gICAgICAgIGNvbnRhaW5lci5vbigncmVzdWx0czphcHBlbmQnLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgICAgc2VsZi5fcG9zaXRpb25Ecm9wZG93bigpO1xuICAgICAgICAgIHNlbGYuX3Jlc2l6ZURyb3Bkb3duKCk7XG4gICAgICAgIH0pO1xuICAgICAgfVxuICAgIH0pO1xuXG4gICAgY29udGFpbmVyLm9uKCdjbG9zZScsIGZ1bmN0aW9uICgpIHtcbiAgICAgIHNlbGYuX2hpZGVEcm9wZG93bigpO1xuICAgICAgc2VsZi5fZGV0YWNoUG9zaXRpb25pbmdIYW5kbGVyKGNvbnRhaW5lcik7XG4gICAgfSk7XG5cbiAgICB0aGlzLiRkcm9wZG93bkNvbnRhaW5lci5vbignbW91c2Vkb3duJywgZnVuY3Rpb24gKGV2dCkge1xuICAgICAgZXZ0LnN0b3BQcm9wYWdhdGlvbigpO1xuICAgIH0pO1xuICB9O1xuXG4gIEF0dGFjaEJvZHkucHJvdG90eXBlLmRlc3Ryb3kgPSBmdW5jdGlvbiAoZGVjb3JhdGVkKSB7XG4gICAgZGVjb3JhdGVkLmNhbGwodGhpcyk7XG5cbiAgICB0aGlzLiRkcm9wZG93bkNvbnRhaW5lci5yZW1vdmUoKTtcbiAgfTtcblxuICBBdHRhY2hCb2R5LnByb3RvdHlwZS5wb3NpdGlvbiA9IGZ1bmN0aW9uIChkZWNvcmF0ZWQsICRkcm9wZG93biwgJGNvbnRhaW5lcikge1xuICAgIC8vIENsb25lIGFsbCBvZiB0aGUgY29udGFpbmVyIGNsYXNzZXNcbiAgICAkZHJvcGRvd24uYXR0cignY2xhc3MnLCAkY29udGFpbmVyLmF0dHIoJ2NsYXNzJykpO1xuXG4gICAgJGRyb3Bkb3duLnJlbW92ZUNsYXNzKCdzZWxlY3QyJyk7XG4gICAgJGRyb3Bkb3duLmFkZENsYXNzKCdzZWxlY3QyLWNvbnRhaW5lci0tb3BlbicpO1xuXG4gICAgJGRyb3Bkb3duLmNzcyh7XG4gICAgICBwb3NpdGlvbjogJ2Fic29sdXRlJyxcbiAgICAgIHRvcDogLTk5OTk5OVxuICAgIH0pO1xuXG4gICAgdGhpcy4kY29udGFpbmVyID0gJGNvbnRhaW5lcjtcbiAgfTtcblxuICBBdHRhY2hCb2R5LnByb3RvdHlwZS5yZW5kZXIgPSBmdW5jdGlvbiAoZGVjb3JhdGVkKSB7XG4gICAgdmFyICRjb250YWluZXIgPSAkKCc8c3Bhbj48L3NwYW4+Jyk7XG5cbiAgICB2YXIgJGRyb3Bkb3duID0gZGVjb3JhdGVkLmNhbGwodGhpcyk7XG4gICAgJGNvbnRhaW5lci5hcHBlbmQoJGRyb3Bkb3duKTtcblxuICAgIHRoaXMuJGRyb3Bkb3duQ29udGFpbmVyID0gJGNvbnRhaW5lcjtcblxuICAgIHJldHVybiAkY29udGFpbmVyO1xuICB9O1xuXG4gIEF0dGFjaEJvZHkucHJvdG90eXBlLl9oaWRlRHJvcGRvd24gPSBmdW5jdGlvbiAoZGVjb3JhdGVkKSB7XG4gICAgdGhpcy4kZHJvcGRvd25Db250YWluZXIuZGV0YWNoKCk7XG4gIH07XG5cbiAgQXR0YWNoQm9keS5wcm90b3R5cGUuX2F0dGFjaFBvc2l0aW9uaW5nSGFuZGxlciA9XG4gICAgICBmdW5jdGlvbiAoZGVjb3JhdGVkLCBjb250YWluZXIpIHtcbiAgICB2YXIgc2VsZiA9IHRoaXM7XG5cbiAgICB2YXIgc2Nyb2xsRXZlbnQgPSAnc2Nyb2xsLnNlbGVjdDIuJyArIGNvbnRhaW5lci5pZDtcbiAgICB2YXIgcmVzaXplRXZlbnQgPSAncmVzaXplLnNlbGVjdDIuJyArIGNvbnRhaW5lci5pZDtcbiAgICB2YXIgb3JpZW50YXRpb25FdmVudCA9ICdvcmllbnRhdGlvbmNoYW5nZS5zZWxlY3QyLicgKyBjb250YWluZXIuaWQ7XG5cbiAgICB2YXIgJHdhdGNoZXJzID0gdGhpcy4kY29udGFpbmVyLnBhcmVudHMoKS5maWx0ZXIoVXRpbHMuaGFzU2Nyb2xsKTtcbiAgICAkd2F0Y2hlcnMuZWFjaChmdW5jdGlvbiAoKSB7XG4gICAgICAkKHRoaXMpLmRhdGEoJ3NlbGVjdDItc2Nyb2xsLXBvc2l0aW9uJywge1xuICAgICAgICB4OiAkKHRoaXMpLnNjcm9sbExlZnQoKSxcbiAgICAgICAgeTogJCh0aGlzKS5zY3JvbGxUb3AoKVxuICAgICAgfSk7XG4gICAgfSk7XG5cbiAgICAkd2F0Y2hlcnMub24oc2Nyb2xsRXZlbnQsIGZ1bmN0aW9uIChldikge1xuICAgICAgdmFyIHBvc2l0aW9uID0gJCh0aGlzKS5kYXRhKCdzZWxlY3QyLXNjcm9sbC1wb3NpdGlvbicpO1xuICAgICAgJCh0aGlzKS5zY3JvbGxUb3AocG9zaXRpb24ueSk7XG4gICAgfSk7XG5cbiAgICAkKHdpbmRvdykub24oc2Nyb2xsRXZlbnQgKyAnICcgKyByZXNpemVFdmVudCArICcgJyArIG9yaWVudGF0aW9uRXZlbnQsXG4gICAgICBmdW5jdGlvbiAoZSkge1xuICAgICAgc2VsZi5fcG9zaXRpb25Ecm9wZG93bigpO1xuICAgICAgc2VsZi5fcmVzaXplRHJvcGRvd24oKTtcbiAgICB9KTtcbiAgfTtcblxuICBBdHRhY2hCb2R5LnByb3RvdHlwZS5fZGV0YWNoUG9zaXRpb25pbmdIYW5kbGVyID1cbiAgICAgIGZ1bmN0aW9uIChkZWNvcmF0ZWQsIGNvbnRhaW5lcikge1xuICAgIHZhciBzY3JvbGxFdmVudCA9ICdzY3JvbGwuc2VsZWN0Mi4nICsgY29udGFpbmVyLmlkO1xuICAgIHZhciByZXNpemVFdmVudCA9ICdyZXNpemUuc2VsZWN0Mi4nICsgY29udGFpbmVyLmlkO1xuICAgIHZhciBvcmllbnRhdGlvbkV2ZW50ID0gJ29yaWVudGF0aW9uY2hhbmdlLnNlbGVjdDIuJyArIGNvbnRhaW5lci5pZDtcblxuICAgIHZhciAkd2F0Y2hlcnMgPSB0aGlzLiRjb250YWluZXIucGFyZW50cygpLmZpbHRlcihVdGlscy5oYXNTY3JvbGwpO1xuICAgICR3YXRjaGVycy5vZmYoc2Nyb2xsRXZlbnQpO1xuXG4gICAgJCh3aW5kb3cpLm9mZihzY3JvbGxFdmVudCArICcgJyArIHJlc2l6ZUV2ZW50ICsgJyAnICsgb3JpZW50YXRpb25FdmVudCk7XG4gIH07XG5cbiAgQXR0YWNoQm9keS5wcm90b3R5cGUuX3Bvc2l0aW9uRHJvcGRvd24gPSBmdW5jdGlvbiAoKSB7XG4gICAgdmFyICR3aW5kb3cgPSAkKHdpbmRvdyk7XG5cbiAgICB2YXIgaXNDdXJyZW50bHlBYm92ZSA9IHRoaXMuJGRyb3Bkb3duLmhhc0NsYXNzKCdzZWxlY3QyLWRyb3Bkb3duLS1hYm92ZScpO1xuICAgIHZhciBpc0N1cnJlbnRseUJlbG93ID0gdGhpcy4kZHJvcGRvd24uaGFzQ2xhc3MoJ3NlbGVjdDItZHJvcGRvd24tLWJlbG93Jyk7XG5cbiAgICB2YXIgbmV3RGlyZWN0aW9uID0gbnVsbDtcblxuICAgIHZhciBvZmZzZXQgPSB0aGlzLiRjb250YWluZXIub2Zmc2V0KCk7XG5cbiAgICBvZmZzZXQuYm90dG9tID0gb2Zmc2V0LnRvcCArIHRoaXMuJGNvbnRhaW5lci5vdXRlckhlaWdodChmYWxzZSk7XG5cbiAgICB2YXIgY29udGFpbmVyID0ge1xuICAgICAgaGVpZ2h0OiB0aGlzLiRjb250YWluZXIub3V0ZXJIZWlnaHQoZmFsc2UpXG4gICAgfTtcblxuICAgIGNvbnRhaW5lci50b3AgPSBvZmZzZXQudG9wO1xuICAgIGNvbnRhaW5lci5ib3R0b20gPSBvZmZzZXQudG9wICsgY29udGFpbmVyLmhlaWdodDtcblxuICAgIHZhciBkcm9wZG93biA9IHtcbiAgICAgIGhlaWdodDogdGhpcy4kZHJvcGRvd24ub3V0ZXJIZWlnaHQoZmFsc2UpXG4gICAgfTtcblxuICAgIHZhciB2aWV3cG9ydCA9IHtcbiAgICAgIHRvcDogJHdpbmRvdy5zY3JvbGxUb3AoKSxcbiAgICAgIGJvdHRvbTogJHdpbmRvdy5zY3JvbGxUb3AoKSArICR3aW5kb3cuaGVpZ2h0KClcbiAgICB9O1xuXG4gICAgdmFyIGVub3VnaFJvb21BYm92ZSA9IHZpZXdwb3J0LnRvcCA8IChvZmZzZXQudG9wIC0gZHJvcGRvd24uaGVpZ2h0KTtcbiAgICB2YXIgZW5vdWdoUm9vbUJlbG93ID0gdmlld3BvcnQuYm90dG9tID4gKG9mZnNldC5ib3R0b20gKyBkcm9wZG93bi5oZWlnaHQpO1xuXG4gICAgdmFyIGNzcyA9IHtcbiAgICAgIGxlZnQ6IG9mZnNldC5sZWZ0LFxuICAgICAgdG9wOiBjb250YWluZXIuYm90dG9tXG4gICAgfTtcblxuICAgIC8vIERldGVybWluZSB3aGF0IHRoZSBwYXJlbnQgZWxlbWVudCBpcyB0byB1c2UgZm9yIGNhbGNpdWxhdGluZyB0aGUgb2Zmc2V0XG4gICAgdmFyICRvZmZzZXRQYXJlbnQgPSB0aGlzLiRkcm9wZG93blBhcmVudDtcblxuICAgIC8vIEZvciBzdGF0aWNhbGx5IHBvc2l0b25lZCBlbGVtZW50cywgd2UgbmVlZCB0byBnZXQgdGhlIGVsZW1lbnRcbiAgICAvLyB0aGF0IGlzIGRldGVybWluaW5nIHRoZSBvZmZzZXRcbiAgICBpZiAoJG9mZnNldFBhcmVudC5jc3MoJ3Bvc2l0aW9uJykgPT09ICdzdGF0aWMnKSB7XG4gICAgICAkb2Zmc2V0UGFyZW50ID0gJG9mZnNldFBhcmVudC5vZmZzZXRQYXJlbnQoKTtcbiAgICB9XG5cbiAgICB2YXIgcGFyZW50T2Zmc2V0ID0gJG9mZnNldFBhcmVudC5vZmZzZXQoKTtcblxuICAgIGNzcy50b3AgLT0gcGFyZW50T2Zmc2V0LnRvcDtcbiAgICBjc3MubGVmdCAtPSBwYXJlbnRPZmZzZXQubGVmdDtcblxuICAgIGlmICghaXNDdXJyZW50bHlBYm92ZSAmJiAhaXNDdXJyZW50bHlCZWxvdykge1xuICAgICAgbmV3RGlyZWN0aW9uID0gJ2JlbG93JztcbiAgICB9XG5cbiAgICBpZiAoIWVub3VnaFJvb21CZWxvdyAmJiBlbm91Z2hSb29tQWJvdmUgJiYgIWlzQ3VycmVudGx5QWJvdmUpIHtcbiAgICAgIG5ld0RpcmVjdGlvbiA9ICdhYm92ZSc7XG4gICAgfSBlbHNlIGlmICghZW5vdWdoUm9vbUFib3ZlICYmIGVub3VnaFJvb21CZWxvdyAmJiBpc0N1cnJlbnRseUFib3ZlKSB7XG4gICAgICBuZXdEaXJlY3Rpb24gPSAnYmVsb3cnO1xuICAgIH1cblxuICAgIGlmIChuZXdEaXJlY3Rpb24gPT0gJ2Fib3ZlJyB8fFxuICAgICAgKGlzQ3VycmVudGx5QWJvdmUgJiYgbmV3RGlyZWN0aW9uICE9PSAnYmVsb3cnKSkge1xuICAgICAgY3NzLnRvcCA9IGNvbnRhaW5lci50b3AgLSBwYXJlbnRPZmZzZXQudG9wIC0gZHJvcGRvd24uaGVpZ2h0O1xuICAgIH1cblxuICAgIGlmIChuZXdEaXJlY3Rpb24gIT0gbnVsbCkge1xuICAgICAgdGhpcy4kZHJvcGRvd25cbiAgICAgICAgLnJlbW92ZUNsYXNzKCdzZWxlY3QyLWRyb3Bkb3duLS1iZWxvdyBzZWxlY3QyLWRyb3Bkb3duLS1hYm92ZScpXG4gICAgICAgIC5hZGRDbGFzcygnc2VsZWN0Mi1kcm9wZG93bi0tJyArIG5ld0RpcmVjdGlvbik7XG4gICAgICB0aGlzLiRjb250YWluZXJcbiAgICAgICAgLnJlbW92ZUNsYXNzKCdzZWxlY3QyLWNvbnRhaW5lci0tYmVsb3cgc2VsZWN0Mi1jb250YWluZXItLWFib3ZlJylcbiAgICAgICAgLmFkZENsYXNzKCdzZWxlY3QyLWNvbnRhaW5lci0tJyArIG5ld0RpcmVjdGlvbik7XG4gICAgfVxuXG4gICAgdGhpcy4kZHJvcGRvd25Db250YWluZXIuY3NzKGNzcyk7XG4gIH07XG5cbiAgQXR0YWNoQm9keS5wcm90b3R5cGUuX3Jlc2l6ZURyb3Bkb3duID0gZnVuY3Rpb24gKCkge1xuICAgIHZhciBjc3MgPSB7XG4gICAgICB3aWR0aDogdGhpcy4kY29udGFpbmVyLm91dGVyV2lkdGgoZmFsc2UpICsgJ3B4J1xuICAgIH07XG5cbiAgICBpZiAodGhpcy5vcHRpb25zLmdldCgnZHJvcGRvd25BdXRvV2lkdGgnKSkge1xuICAgICAgY3NzLm1pbldpZHRoID0gY3NzLndpZHRoO1xuICAgICAgY3NzLnBvc2l0aW9uID0gJ3JlbGF0aXZlJztcbiAgICAgIGNzcy53aWR0aCA9ICdhdXRvJztcbiAgICB9XG5cbiAgICB0aGlzLiRkcm9wZG93bi5jc3MoY3NzKTtcbiAgfTtcblxuICBBdHRhY2hCb2R5LnByb3RvdHlwZS5fc2hvd0Ryb3Bkb3duID0gZnVuY3Rpb24gKGRlY29yYXRlZCkge1xuICAgIHRoaXMuJGRyb3Bkb3duQ29udGFpbmVyLmFwcGVuZFRvKHRoaXMuJGRyb3Bkb3duUGFyZW50KTtcblxuICAgIHRoaXMuX3Bvc2l0aW9uRHJvcGRvd24oKTtcbiAgICB0aGlzLl9yZXNpemVEcm9wZG93bigpO1xuICB9O1xuXG4gIHJldHVybiBBdHRhY2hCb2R5O1xufSk7XG5cblMyLmRlZmluZSgnc2VsZWN0Mi9kcm9wZG93bi9taW5pbXVtUmVzdWx0c0ZvclNlYXJjaCcsW1xuXG5dLCBmdW5jdGlvbiAoKSB7XG4gIGZ1bmN0aW9uIGNvdW50UmVzdWx0cyAoZGF0YSkge1xuICAgIHZhciBjb3VudCA9IDA7XG5cbiAgICBmb3IgKHZhciBkID0gMDsgZCA8IGRhdGEubGVuZ3RoOyBkKyspIHtcbiAgICAgIHZhciBpdGVtID0gZGF0YVtkXTtcblxuICAgICAgaWYgKGl0ZW0uY2hpbGRyZW4pIHtcbiAgICAgICAgY291bnQgKz0gY291bnRSZXN1bHRzKGl0ZW0uY2hpbGRyZW4pO1xuICAgICAgfSBlbHNlIHtcbiAgICAgICAgY291bnQrKztcbiAgICAgIH1cbiAgICB9XG5cbiAgICByZXR1cm4gY291bnQ7XG4gIH1cblxuICBmdW5jdGlvbiBNaW5pbXVtUmVzdWx0c0ZvclNlYXJjaCAoZGVjb3JhdGVkLCAkZWxlbWVudCwgb3B0aW9ucywgZGF0YUFkYXB0ZXIpIHtcbiAgICB0aGlzLm1pbmltdW1SZXN1bHRzRm9yU2VhcmNoID0gb3B0aW9ucy5nZXQoJ21pbmltdW1SZXN1bHRzRm9yU2VhcmNoJyk7XG5cbiAgICBpZiAodGhpcy5taW5pbXVtUmVzdWx0c0ZvclNlYXJjaCA8IDApIHtcbiAgICAgIHRoaXMubWluaW11bVJlc3VsdHNGb3JTZWFyY2ggPSBJbmZpbml0eTtcbiAgICB9XG5cbiAgICBkZWNvcmF0ZWQuY2FsbCh0aGlzLCAkZWxlbWVudCwgb3B0aW9ucywgZGF0YUFkYXB0ZXIpO1xuICB9XG5cbiAgTWluaW11bVJlc3VsdHNGb3JTZWFyY2gucHJvdG90eXBlLnNob3dTZWFyY2ggPSBmdW5jdGlvbiAoZGVjb3JhdGVkLCBwYXJhbXMpIHtcbiAgICBpZiAoY291bnRSZXN1bHRzKHBhcmFtcy5kYXRhLnJlc3VsdHMpIDwgdGhpcy5taW5pbXVtUmVzdWx0c0ZvclNlYXJjaCkge1xuICAgICAgcmV0dXJuIGZhbHNlO1xuICAgIH1cblxuICAgIHJldHVybiBkZWNvcmF0ZWQuY2FsbCh0aGlzLCBwYXJhbXMpO1xuICB9O1xuXG4gIHJldHVybiBNaW5pbXVtUmVzdWx0c0ZvclNlYXJjaDtcbn0pO1xuXG5TMi5kZWZpbmUoJ3NlbGVjdDIvZHJvcGRvd24vc2VsZWN0T25DbG9zZScsW1xuXG5dLCBmdW5jdGlvbiAoKSB7XG4gIGZ1bmN0aW9uIFNlbGVjdE9uQ2xvc2UgKCkgeyB9XG5cbiAgU2VsZWN0T25DbG9zZS5wcm90b3R5cGUuYmluZCA9IGZ1bmN0aW9uIChkZWNvcmF0ZWQsIGNvbnRhaW5lciwgJGNvbnRhaW5lcikge1xuICAgIHZhciBzZWxmID0gdGhpcztcblxuICAgIGRlY29yYXRlZC5jYWxsKHRoaXMsIGNvbnRhaW5lciwgJGNvbnRhaW5lcik7XG5cbiAgICBjb250YWluZXIub24oJ2Nsb3NlJywgZnVuY3Rpb24gKHBhcmFtcykge1xuICAgICAgc2VsZi5faGFuZGxlU2VsZWN0T25DbG9zZShwYXJhbXMpO1xuICAgIH0pO1xuICB9O1xuXG4gIFNlbGVjdE9uQ2xvc2UucHJvdG90eXBlLl9oYW5kbGVTZWxlY3RPbkNsb3NlID0gZnVuY3Rpb24gKF8sIHBhcmFtcykge1xuICAgIGlmIChwYXJhbXMgJiYgcGFyYW1zLm9yaWdpbmFsU2VsZWN0MkV2ZW50ICE9IG51bGwpIHtcbiAgICAgIHZhciBldmVudCA9IHBhcmFtcy5vcmlnaW5hbFNlbGVjdDJFdmVudDtcblxuICAgICAgLy8gRG9uJ3Qgc2VsZWN0IGFuIGl0ZW0gaWYgdGhlIGNsb3NlIGV2ZW50IHdhcyB0cmlnZ2VyZWQgZnJvbSBhIHNlbGVjdCBvclxuICAgICAgLy8gdW5zZWxlY3QgZXZlbnRcbiAgICAgIGlmIChldmVudC5fdHlwZSA9PT0gJ3NlbGVjdCcgfHwgZXZlbnQuX3R5cGUgPT09ICd1bnNlbGVjdCcpIHtcbiAgICAgICAgcmV0dXJuO1xuICAgICAgfVxuICAgIH1cblxuICAgIHZhciAkaGlnaGxpZ2h0ZWRSZXN1bHRzID0gdGhpcy5nZXRIaWdobGlnaHRlZFJlc3VsdHMoKTtcblxuICAgIC8vIE9ubHkgc2VsZWN0IGhpZ2hsaWdodGVkIHJlc3VsdHNcbiAgICBpZiAoJGhpZ2hsaWdodGVkUmVzdWx0cy5sZW5ndGggPCAxKSB7XG4gICAgICByZXR1cm47XG4gICAgfVxuXG4gICAgdmFyIGRhdGEgPSAkaGlnaGxpZ2h0ZWRSZXN1bHRzLmRhdGEoJ2RhdGEnKTtcblxuICAgIC8vIERvbid0IHJlLXNlbGVjdCBhbHJlYWR5IHNlbGVjdGVkIHJlc3VsdGVcbiAgICBpZiAoXG4gICAgICAoZGF0YS5lbGVtZW50ICE9IG51bGwgJiYgZGF0YS5lbGVtZW50LnNlbGVjdGVkKSB8fFxuICAgICAgKGRhdGEuZWxlbWVudCA9PSBudWxsICYmIGRhdGEuc2VsZWN0ZWQpXG4gICAgKSB7XG4gICAgICByZXR1cm47XG4gICAgfVxuXG4gICAgdGhpcy50cmlnZ2VyKCdzZWxlY3QnLCB7XG4gICAgICAgIGRhdGE6IGRhdGFcbiAgICB9KTtcbiAgfTtcblxuICByZXR1cm4gU2VsZWN0T25DbG9zZTtcbn0pO1xuXG5TMi5kZWZpbmUoJ3NlbGVjdDIvZHJvcGRvd24vY2xvc2VPblNlbGVjdCcsW1xuXG5dLCBmdW5jdGlvbiAoKSB7XG4gIGZ1bmN0aW9uIENsb3NlT25TZWxlY3QgKCkgeyB9XG5cbiAgQ2xvc2VPblNlbGVjdC5wcm90b3R5cGUuYmluZCA9IGZ1bmN0aW9uIChkZWNvcmF0ZWQsIGNvbnRhaW5lciwgJGNvbnRhaW5lcikge1xuICAgIHZhciBzZWxmID0gdGhpcztcblxuICAgIGRlY29yYXRlZC5jYWxsKHRoaXMsIGNvbnRhaW5lciwgJGNvbnRhaW5lcik7XG5cbiAgICBjb250YWluZXIub24oJ3NlbGVjdCcsIGZ1bmN0aW9uIChldnQpIHtcbiAgICAgIHNlbGYuX3NlbGVjdFRyaWdnZXJlZChldnQpO1xuICAgIH0pO1xuXG4gICAgY29udGFpbmVyLm9uKCd1bnNlbGVjdCcsIGZ1bmN0aW9uIChldnQpIHtcbiAgICAgIHNlbGYuX3NlbGVjdFRyaWdnZXJlZChldnQpO1xuICAgIH0pO1xuICB9O1xuXG4gIENsb3NlT25TZWxlY3QucHJvdG90eXBlLl9zZWxlY3RUcmlnZ2VyZWQgPSBmdW5jdGlvbiAoXywgZXZ0KSB7XG4gICAgdmFyIG9yaWdpbmFsRXZlbnQgPSBldnQub3JpZ2luYWxFdmVudDtcblxuICAgIC8vIERvbid0IGNsb3NlIGlmIHRoZSBjb250cm9sIGtleSBpcyBiZWluZyBoZWxkXG4gICAgaWYgKG9yaWdpbmFsRXZlbnQgJiYgb3JpZ2luYWxFdmVudC5jdHJsS2V5KSB7XG4gICAgICByZXR1cm47XG4gICAgfVxuXG4gICAgdGhpcy50cmlnZ2VyKCdjbG9zZScsIHtcbiAgICAgIG9yaWdpbmFsRXZlbnQ6IG9yaWdpbmFsRXZlbnQsXG4gICAgICBvcmlnaW5hbFNlbGVjdDJFdmVudDogZXZ0XG4gICAgfSk7XG4gIH07XG5cbiAgcmV0dXJuIENsb3NlT25TZWxlY3Q7XG59KTtcblxuUzIuZGVmaW5lKCdzZWxlY3QyL2kxOG4vZW4nLFtdLGZ1bmN0aW9uICgpIHtcbiAgLy8gRW5nbGlzaFxuICByZXR1cm4ge1xuICAgIGVycm9yTG9hZGluZzogZnVuY3Rpb24gKCkge1xuICAgICAgcmV0dXJuICdUaGUgcmVzdWx0cyBjb3VsZCBub3QgYmUgbG9hZGVkLic7XG4gICAgfSxcbiAgICBpbnB1dFRvb0xvbmc6IGZ1bmN0aW9uIChhcmdzKSB7XG4gICAgICB2YXIgb3ZlckNoYXJzID0gYXJncy5pbnB1dC5sZW5ndGggLSBhcmdzLm1heGltdW07XG5cbiAgICAgIHZhciBtZXNzYWdlID0gJ1BsZWFzZSBkZWxldGUgJyArIG92ZXJDaGFycyArICcgY2hhcmFjdGVyJztcblxuICAgICAgaWYgKG92ZXJDaGFycyAhPSAxKSB7XG4gICAgICAgIG1lc3NhZ2UgKz0gJ3MnO1xuICAgICAgfVxuXG4gICAgICByZXR1cm4gbWVzc2FnZTtcbiAgICB9LFxuICAgIGlucHV0VG9vU2hvcnQ6IGZ1bmN0aW9uIChhcmdzKSB7XG4gICAgICB2YXIgcmVtYWluaW5nQ2hhcnMgPSBhcmdzLm1pbmltdW0gLSBhcmdzLmlucHV0Lmxlbmd0aDtcblxuICAgICAgdmFyIG1lc3NhZ2UgPSAnUGxlYXNlIGVudGVyICcgKyByZW1haW5pbmdDaGFycyArICcgb3IgbW9yZSBjaGFyYWN0ZXJzJztcblxuICAgICAgcmV0dXJuIG1lc3NhZ2U7XG4gICAgfSxcbiAgICBsb2FkaW5nTW9yZTogZnVuY3Rpb24gKCkge1xuICAgICAgcmV0dXJuICdMb2FkaW5nIG1vcmUgcmVzdWx0c+KApic7XG4gICAgfSxcbiAgICBtYXhpbXVtU2VsZWN0ZWQ6IGZ1bmN0aW9uIChhcmdzKSB7XG4gICAgICB2YXIgbWVzc2FnZSA9ICdZb3UgY2FuIG9ubHkgc2VsZWN0ICcgKyBhcmdzLm1heGltdW0gKyAnIGl0ZW0nO1xuXG4gICAgICBpZiAoYXJncy5tYXhpbXVtICE9IDEpIHtcbiAgICAgICAgbWVzc2FnZSArPSAncyc7XG4gICAgICB9XG5cbiAgICAgIHJldHVybiBtZXNzYWdlO1xuICAgIH0sXG4gICAgbm9SZXN1bHRzOiBmdW5jdGlvbiAoKSB7XG4gICAgICByZXR1cm4gJ05vIHJlc3VsdHMgZm91bmQnO1xuICAgIH0sXG4gICAgc2VhcmNoaW5nOiBmdW5jdGlvbiAoKSB7XG4gICAgICByZXR1cm4gJ1NlYXJjaGluZ+KApic7XG4gICAgfVxuICB9O1xufSk7XG5cblMyLmRlZmluZSgnc2VsZWN0Mi9kZWZhdWx0cycsW1xuICAnanF1ZXJ5JyxcbiAgJ3JlcXVpcmUnLFxuXG4gICcuL3Jlc3VsdHMnLFxuXG4gICcuL3NlbGVjdGlvbi9zaW5nbGUnLFxuICAnLi9zZWxlY3Rpb24vbXVsdGlwbGUnLFxuICAnLi9zZWxlY3Rpb24vcGxhY2Vob2xkZXInLFxuICAnLi9zZWxlY3Rpb24vYWxsb3dDbGVhcicsXG4gICcuL3NlbGVjdGlvbi9zZWFyY2gnLFxuICAnLi9zZWxlY3Rpb24vZXZlbnRSZWxheScsXG5cbiAgJy4vdXRpbHMnLFxuICAnLi90cmFuc2xhdGlvbicsXG4gICcuL2RpYWNyaXRpY3MnLFxuXG4gICcuL2RhdGEvc2VsZWN0JyxcbiAgJy4vZGF0YS9hcnJheScsXG4gICcuL2RhdGEvYWpheCcsXG4gICcuL2RhdGEvdGFncycsXG4gICcuL2RhdGEvdG9rZW5pemVyJyxcbiAgJy4vZGF0YS9taW5pbXVtSW5wdXRMZW5ndGgnLFxuICAnLi9kYXRhL21heGltdW1JbnB1dExlbmd0aCcsXG4gICcuL2RhdGEvbWF4aW11bVNlbGVjdGlvbkxlbmd0aCcsXG5cbiAgJy4vZHJvcGRvd24nLFxuICAnLi9kcm9wZG93bi9zZWFyY2gnLFxuICAnLi9kcm9wZG93bi9oaWRlUGxhY2Vob2xkZXInLFxuICAnLi9kcm9wZG93bi9pbmZpbml0ZVNjcm9sbCcsXG4gICcuL2Ryb3Bkb3duL2F0dGFjaEJvZHknLFxuICAnLi9kcm9wZG93bi9taW5pbXVtUmVzdWx0c0ZvclNlYXJjaCcsXG4gICcuL2Ryb3Bkb3duL3NlbGVjdE9uQ2xvc2UnLFxuICAnLi9kcm9wZG93bi9jbG9zZU9uU2VsZWN0JyxcblxuICAnLi9pMThuL2VuJ1xuXSwgZnVuY3Rpb24gKCQsIHJlcXVpcmUsXG5cbiAgICAgICAgICAgICBSZXN1bHRzTGlzdCxcblxuICAgICAgICAgICAgIFNpbmdsZVNlbGVjdGlvbiwgTXVsdGlwbGVTZWxlY3Rpb24sIFBsYWNlaG9sZGVyLCBBbGxvd0NsZWFyLFxuICAgICAgICAgICAgIFNlbGVjdGlvblNlYXJjaCwgRXZlbnRSZWxheSxcblxuICAgICAgICAgICAgIFV0aWxzLCBUcmFuc2xhdGlvbiwgRElBQ1JJVElDUyxcblxuICAgICAgICAgICAgIFNlbGVjdERhdGEsIEFycmF5RGF0YSwgQWpheERhdGEsIFRhZ3MsIFRva2VuaXplcixcbiAgICAgICAgICAgICBNaW5pbXVtSW5wdXRMZW5ndGgsIE1heGltdW1JbnB1dExlbmd0aCwgTWF4aW11bVNlbGVjdGlvbkxlbmd0aCxcblxuICAgICAgICAgICAgIERyb3Bkb3duLCBEcm9wZG93blNlYXJjaCwgSGlkZVBsYWNlaG9sZGVyLCBJbmZpbml0ZVNjcm9sbCxcbiAgICAgICAgICAgICBBdHRhY2hCb2R5LCBNaW5pbXVtUmVzdWx0c0ZvclNlYXJjaCwgU2VsZWN0T25DbG9zZSwgQ2xvc2VPblNlbGVjdCxcblxuICAgICAgICAgICAgIEVuZ2xpc2hUcmFuc2xhdGlvbikge1xuICBmdW5jdGlvbiBEZWZhdWx0cyAoKSB7XG4gICAgdGhpcy5yZXNldCgpO1xuICB9XG5cbiAgRGVmYXVsdHMucHJvdG90eXBlLmFwcGx5ID0gZnVuY3Rpb24gKG9wdGlvbnMpIHtcbiAgICBvcHRpb25zID0gJC5leHRlbmQodHJ1ZSwge30sIHRoaXMuZGVmYXVsdHMsIG9wdGlvbnMpO1xuXG4gICAgaWYgKG9wdGlvbnMuZGF0YUFkYXB0ZXIgPT0gbnVsbCkge1xuICAgICAgaWYgKG9wdGlvbnMuYWpheCAhPSBudWxsKSB7XG4gICAgICAgIG9wdGlvbnMuZGF0YUFkYXB0ZXIgPSBBamF4RGF0YTtcbiAgICAgIH0gZWxzZSBpZiAob3B0aW9ucy5kYXRhICE9IG51bGwpIHtcbiAgICAgICAgb3B0aW9ucy5kYXRhQWRhcHRlciA9IEFycmF5RGF0YTtcbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIG9wdGlvbnMuZGF0YUFkYXB0ZXIgPSBTZWxlY3REYXRhO1xuICAgICAgfVxuXG4gICAgICBpZiAob3B0aW9ucy5taW5pbXVtSW5wdXRMZW5ndGggPiAwKSB7XG4gICAgICAgIG9wdGlvbnMuZGF0YUFkYXB0ZXIgPSBVdGlscy5EZWNvcmF0ZShcbiAgICAgICAgICBvcHRpb25zLmRhdGFBZGFwdGVyLFxuICAgICAgICAgIE1pbmltdW1JbnB1dExlbmd0aFxuICAgICAgICApO1xuICAgICAgfVxuXG4gICAgICBpZiAob3B0aW9ucy5tYXhpbXVtSW5wdXRMZW5ndGggPiAwKSB7XG4gICAgICAgIG9wdGlvbnMuZGF0YUFkYXB0ZXIgPSBVdGlscy5EZWNvcmF0ZShcbiAgICAgICAgICBvcHRpb25zLmRhdGFBZGFwdGVyLFxuICAgICAgICAgIE1heGltdW1JbnB1dExlbmd0aFxuICAgICAgICApO1xuICAgICAgfVxuXG4gICAgICBpZiAob3B0aW9ucy5tYXhpbXVtU2VsZWN0aW9uTGVuZ3RoID4gMCkge1xuICAgICAgICBvcHRpb25zLmRhdGFBZGFwdGVyID0gVXRpbHMuRGVjb3JhdGUoXG4gICAgICAgICAgb3B0aW9ucy5kYXRhQWRhcHRlcixcbiAgICAgICAgICBNYXhpbXVtU2VsZWN0aW9uTGVuZ3RoXG4gICAgICAgICk7XG4gICAgICB9XG5cbiAgICAgIGlmIChvcHRpb25zLnRhZ3MpIHtcbiAgICAgICAgb3B0aW9ucy5kYXRhQWRhcHRlciA9IFV0aWxzLkRlY29yYXRlKG9wdGlvbnMuZGF0YUFkYXB0ZXIsIFRhZ3MpO1xuICAgICAgfVxuXG4gICAgICBpZiAob3B0aW9ucy50b2tlblNlcGFyYXRvcnMgIT0gbnVsbCB8fCBvcHRpb25zLnRva2VuaXplciAhPSBudWxsKSB7XG4gICAgICAgIG9wdGlvbnMuZGF0YUFkYXB0ZXIgPSBVdGlscy5EZWNvcmF0ZShcbiAgICAgICAgICBvcHRpb25zLmRhdGFBZGFwdGVyLFxuICAgICAgICAgIFRva2VuaXplclxuICAgICAgICApO1xuICAgICAgfVxuXG4gICAgICBpZiAob3B0aW9ucy5xdWVyeSAhPSBudWxsKSB7XG4gICAgICAgIHZhciBRdWVyeSA9IHJlcXVpcmUob3B0aW9ucy5hbWRCYXNlICsgJ2NvbXBhdC9xdWVyeScpO1xuXG4gICAgICAgIG9wdGlvbnMuZGF0YUFkYXB0ZXIgPSBVdGlscy5EZWNvcmF0ZShcbiAgICAgICAgICBvcHRpb25zLmRhdGFBZGFwdGVyLFxuICAgICAgICAgIFF1ZXJ5XG4gICAgICAgICk7XG4gICAgICB9XG5cbiAgICAgIGlmIChvcHRpb25zLmluaXRTZWxlY3Rpb24gIT0gbnVsbCkge1xuICAgICAgICB2YXIgSW5pdFNlbGVjdGlvbiA9IHJlcXVpcmUob3B0aW9ucy5hbWRCYXNlICsgJ2NvbXBhdC9pbml0U2VsZWN0aW9uJyk7XG5cbiAgICAgICAgb3B0aW9ucy5kYXRhQWRhcHRlciA9IFV0aWxzLkRlY29yYXRlKFxuICAgICAgICAgIG9wdGlvbnMuZGF0YUFkYXB0ZXIsXG4gICAgICAgICAgSW5pdFNlbGVjdGlvblxuICAgICAgICApO1xuICAgICAgfVxuICAgIH1cblxuICAgIGlmIChvcHRpb25zLnJlc3VsdHNBZGFwdGVyID09IG51bGwpIHtcbiAgICAgIG9wdGlvbnMucmVzdWx0c0FkYXB0ZXIgPSBSZXN1bHRzTGlzdDtcblxuICAgICAgaWYgKG9wdGlvbnMuYWpheCAhPSBudWxsKSB7XG4gICAgICAgIG9wdGlvbnMucmVzdWx0c0FkYXB0ZXIgPSBVdGlscy5EZWNvcmF0ZShcbiAgICAgICAgICBvcHRpb25zLnJlc3VsdHNBZGFwdGVyLFxuICAgICAgICAgIEluZmluaXRlU2Nyb2xsXG4gICAgICAgICk7XG4gICAgICB9XG5cbiAgICAgIGlmIChvcHRpb25zLnBsYWNlaG9sZGVyICE9IG51bGwpIHtcbiAgICAgICAgb3B0aW9ucy5yZXN1bHRzQWRhcHRlciA9IFV0aWxzLkRlY29yYXRlKFxuICAgICAgICAgIG9wdGlvbnMucmVzdWx0c0FkYXB0ZXIsXG4gICAgICAgICAgSGlkZVBsYWNlaG9sZGVyXG4gICAgICAgICk7XG4gICAgICB9XG5cbiAgICAgIGlmIChvcHRpb25zLnNlbGVjdE9uQ2xvc2UpIHtcbiAgICAgICAgb3B0aW9ucy5yZXN1bHRzQWRhcHRlciA9IFV0aWxzLkRlY29yYXRlKFxuICAgICAgICAgIG9wdGlvbnMucmVzdWx0c0FkYXB0ZXIsXG4gICAgICAgICAgU2VsZWN0T25DbG9zZVxuICAgICAgICApO1xuICAgICAgfVxuICAgIH1cblxuICAgIGlmIChvcHRpb25zLmRyb3Bkb3duQWRhcHRlciA9PSBudWxsKSB7XG4gICAgICBpZiAob3B0aW9ucy5tdWx0aXBsZSkge1xuICAgICAgICBvcHRpb25zLmRyb3Bkb3duQWRhcHRlciA9IERyb3Bkb3duO1xuICAgICAgfSBlbHNlIHtcbiAgICAgICAgdmFyIFNlYXJjaGFibGVEcm9wZG93biA9IFV0aWxzLkRlY29yYXRlKERyb3Bkb3duLCBEcm9wZG93blNlYXJjaCk7XG5cbiAgICAgICAgb3B0aW9ucy5kcm9wZG93bkFkYXB0ZXIgPSBTZWFyY2hhYmxlRHJvcGRvd247XG4gICAgICB9XG5cbiAgICAgIGlmIChvcHRpb25zLm1pbmltdW1SZXN1bHRzRm9yU2VhcmNoICE9PSAwKSB7XG4gICAgICAgIG9wdGlvbnMuZHJvcGRvd25BZGFwdGVyID0gVXRpbHMuRGVjb3JhdGUoXG4gICAgICAgICAgb3B0aW9ucy5kcm9wZG93bkFkYXB0ZXIsXG4gICAgICAgICAgTWluaW11bVJlc3VsdHNGb3JTZWFyY2hcbiAgICAgICAgKTtcbiAgICAgIH1cblxuICAgICAgaWYgKG9wdGlvbnMuY2xvc2VPblNlbGVjdCkge1xuICAgICAgICBvcHRpb25zLmRyb3Bkb3duQWRhcHRlciA9IFV0aWxzLkRlY29yYXRlKFxuICAgICAgICAgIG9wdGlvbnMuZHJvcGRvd25BZGFwdGVyLFxuICAgICAgICAgIENsb3NlT25TZWxlY3RcbiAgICAgICAgKTtcbiAgICAgIH1cblxuICAgICAgaWYgKFxuICAgICAgICBvcHRpb25zLmRyb3Bkb3duQ3NzQ2xhc3MgIT0gbnVsbCB8fFxuICAgICAgICBvcHRpb25zLmRyb3Bkb3duQ3NzICE9IG51bGwgfHxcbiAgICAgICAgb3B0aW9ucy5hZGFwdERyb3Bkb3duQ3NzQ2xhc3MgIT0gbnVsbFxuICAgICAgKSB7XG4gICAgICAgIHZhciBEcm9wZG93bkNTUyA9IHJlcXVpcmUob3B0aW9ucy5hbWRCYXNlICsgJ2NvbXBhdC9kcm9wZG93bkNzcycpO1xuXG4gICAgICAgIG9wdGlvbnMuZHJvcGRvd25BZGFwdGVyID0gVXRpbHMuRGVjb3JhdGUoXG4gICAgICAgICAgb3B0aW9ucy5kcm9wZG93bkFkYXB0ZXIsXG4gICAgICAgICAgRHJvcGRvd25DU1NcbiAgICAgICAgKTtcbiAgICAgIH1cblxuICAgICAgb3B0aW9ucy5kcm9wZG93bkFkYXB0ZXIgPSBVdGlscy5EZWNvcmF0ZShcbiAgICAgICAgb3B0aW9ucy5kcm9wZG93bkFkYXB0ZXIsXG4gICAgICAgIEF0dGFjaEJvZHlcbiAgICAgICk7XG4gICAgfVxuXG4gICAgaWYgKG9wdGlvbnMuc2VsZWN0aW9uQWRhcHRlciA9PSBudWxsKSB7XG4gICAgICBpZiAob3B0aW9ucy5tdWx0aXBsZSkge1xuICAgICAgICBvcHRpb25zLnNlbGVjdGlvbkFkYXB0ZXIgPSBNdWx0aXBsZVNlbGVjdGlvbjtcbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIG9wdGlvbnMuc2VsZWN0aW9uQWRhcHRlciA9IFNpbmdsZVNlbGVjdGlvbjtcbiAgICAgIH1cblxuICAgICAgLy8gQWRkIHRoZSBwbGFjZWhvbGRlciBtaXhpbiBpZiBhIHBsYWNlaG9sZGVyIHdhcyBzcGVjaWZpZWRcbiAgICAgIGlmIChvcHRpb25zLnBsYWNlaG9sZGVyICE9IG51bGwpIHtcbiAgICAgICAgb3B0aW9ucy5zZWxlY3Rpb25BZGFwdGVyID0gVXRpbHMuRGVjb3JhdGUoXG4gICAgICAgICAgb3B0aW9ucy5zZWxlY3Rpb25BZGFwdGVyLFxuICAgICAgICAgIFBsYWNlaG9sZGVyXG4gICAgICAgICk7XG4gICAgICB9XG5cbiAgICAgIGlmIChvcHRpb25zLmFsbG93Q2xlYXIpIHtcbiAgICAgICAgb3B0aW9ucy5zZWxlY3Rpb25BZGFwdGVyID0gVXRpbHMuRGVjb3JhdGUoXG4gICAgICAgICAgb3B0aW9ucy5zZWxlY3Rpb25BZGFwdGVyLFxuICAgICAgICAgIEFsbG93Q2xlYXJcbiAgICAgICAgKTtcbiAgICAgIH1cblxuICAgICAgaWYgKG9wdGlvbnMubXVsdGlwbGUpIHtcbiAgICAgICAgb3B0aW9ucy5zZWxlY3Rpb25BZGFwdGVyID0gVXRpbHMuRGVjb3JhdGUoXG4gICAgICAgICAgb3B0aW9ucy5zZWxlY3Rpb25BZGFwdGVyLFxuICAgICAgICAgIFNlbGVjdGlvblNlYXJjaFxuICAgICAgICApO1xuICAgICAgfVxuXG4gICAgICBpZiAoXG4gICAgICAgIG9wdGlvbnMuY29udGFpbmVyQ3NzQ2xhc3MgIT0gbnVsbCB8fFxuICAgICAgICBvcHRpb25zLmNvbnRhaW5lckNzcyAhPSBudWxsIHx8XG4gICAgICAgIG9wdGlvbnMuYWRhcHRDb250YWluZXJDc3NDbGFzcyAhPSBudWxsXG4gICAgICApIHtcbiAgICAgICAgdmFyIENvbnRhaW5lckNTUyA9IHJlcXVpcmUob3B0aW9ucy5hbWRCYXNlICsgJ2NvbXBhdC9jb250YWluZXJDc3MnKTtcblxuICAgICAgICBvcHRpb25zLnNlbGVjdGlvbkFkYXB0ZXIgPSBVdGlscy5EZWNvcmF0ZShcbiAgICAgICAgICBvcHRpb25zLnNlbGVjdGlvbkFkYXB0ZXIsXG4gICAgICAgICAgQ29udGFpbmVyQ1NTXG4gICAgICAgICk7XG4gICAgICB9XG5cbiAgICAgIG9wdGlvbnMuc2VsZWN0aW9uQWRhcHRlciA9IFV0aWxzLkRlY29yYXRlKFxuICAgICAgICBvcHRpb25zLnNlbGVjdGlvbkFkYXB0ZXIsXG4gICAgICAgIEV2ZW50UmVsYXlcbiAgICAgICk7XG4gICAgfVxuXG4gICAgaWYgKHR5cGVvZiBvcHRpb25zLmxhbmd1YWdlID09PSAnc3RyaW5nJykge1xuICAgICAgLy8gQ2hlY2sgaWYgdGhlIGxhbmd1YWdlIGlzIHNwZWNpZmllZCB3aXRoIGEgcmVnaW9uXG4gICAgICBpZiAob3B0aW9ucy5sYW5ndWFnZS5pbmRleE9mKCctJykgPiAwKSB7XG4gICAgICAgIC8vIEV4dHJhY3QgdGhlIHJlZ2lvbiBpbmZvcm1hdGlvbiBpZiBpdCBpcyBpbmNsdWRlZFxuICAgICAgICB2YXIgbGFuZ3VhZ2VQYXJ0cyA9IG9wdGlvbnMubGFuZ3VhZ2Uuc3BsaXQoJy0nKTtcbiAgICAgICAgdmFyIGJhc2VMYW5ndWFnZSA9IGxhbmd1YWdlUGFydHNbMF07XG5cbiAgICAgICAgb3B0aW9ucy5sYW5ndWFnZSA9IFtvcHRpb25zLmxhbmd1YWdlLCBiYXNlTGFuZ3VhZ2VdO1xuICAgICAgfSBlbHNlIHtcbiAgICAgICAgb3B0aW9ucy5sYW5ndWFnZSA9IFtvcHRpb25zLmxhbmd1YWdlXTtcbiAgICAgIH1cbiAgICB9XG5cbiAgICBpZiAoJC5pc0FycmF5KG9wdGlvbnMubGFuZ3VhZ2UpKSB7XG4gICAgICB2YXIgbGFuZ3VhZ2VzID0gbmV3IFRyYW5zbGF0aW9uKCk7XG4gICAgICBvcHRpb25zLmxhbmd1YWdlLnB1c2goJ2VuJyk7XG5cbiAgICAgIHZhciBsYW5ndWFnZU5hbWVzID0gb3B0aW9ucy5sYW5ndWFnZTtcblxuICAgICAgZm9yICh2YXIgbCA9IDA7IGwgPCBsYW5ndWFnZU5hbWVzLmxlbmd0aDsgbCsrKSB7XG4gICAgICAgIHZhciBuYW1lID0gbGFuZ3VhZ2VOYW1lc1tsXTtcbiAgICAgICAgdmFyIGxhbmd1YWdlID0ge307XG5cbiAgICAgICAgdHJ5IHtcbiAgICAgICAgICAvLyBUcnkgdG8gbG9hZCBpdCB3aXRoIHRoZSBvcmlnaW5hbCBuYW1lXG4gICAgICAgICAgbGFuZ3VhZ2UgPSBUcmFuc2xhdGlvbi5sb2FkUGF0aChuYW1lKTtcbiAgICAgICAgfSBjYXRjaCAoZSkge1xuICAgICAgICAgIHRyeSB7XG4gICAgICAgICAgICAvLyBJZiB3ZSBjb3VsZG4ndCBsb2FkIGl0LCBjaGVjayBpZiBpdCB3YXNuJ3QgdGhlIGZ1bGwgcGF0aFxuICAgICAgICAgICAgbmFtZSA9IHRoaXMuZGVmYXVsdHMuYW1kTGFuZ3VhZ2VCYXNlICsgbmFtZTtcbiAgICAgICAgICAgIGxhbmd1YWdlID0gVHJhbnNsYXRpb24ubG9hZFBhdGgobmFtZSk7XG4gICAgICAgICAgfSBjYXRjaCAoZXgpIHtcbiAgICAgICAgICAgIC8vIFRoZSB0cmFuc2xhdGlvbiBjb3VsZCBub3QgYmUgbG9hZGVkIGF0IGFsbC4gU29tZXRpbWVzIHRoaXMgaXNcbiAgICAgICAgICAgIC8vIGJlY2F1c2Ugb2YgYSBjb25maWd1cmF0aW9uIHByb2JsZW0sIG90aGVyIHRpbWVzIHRoaXMgY2FuIGJlXG4gICAgICAgICAgICAvLyBiZWNhdXNlIG9mIGhvdyBTZWxlY3QyIGhlbHBzIGxvYWQgYWxsIHBvc3NpYmxlIHRyYW5zbGF0aW9uIGZpbGVzLlxuICAgICAgICAgICAgaWYgKG9wdGlvbnMuZGVidWcgJiYgd2luZG93LmNvbnNvbGUgJiYgY29uc29sZS53YXJuKSB7XG4gICAgICAgICAgICAgIGNvbnNvbGUud2FybihcbiAgICAgICAgICAgICAgICAnU2VsZWN0MjogVGhlIGxhbmd1YWdlIGZpbGUgZm9yIFwiJyArIG5hbWUgKyAnXCIgY291bGQgbm90IGJlICcgK1xuICAgICAgICAgICAgICAgICdhdXRvbWF0aWNhbGx5IGxvYWRlZC4gQSBmYWxsYmFjayB3aWxsIGJlIHVzZWQgaW5zdGVhZC4nXG4gICAgICAgICAgICAgICk7XG4gICAgICAgICAgICB9XG5cbiAgICAgICAgICAgIGNvbnRpbnVlO1xuICAgICAgICAgIH1cbiAgICAgICAgfVxuXG4gICAgICAgIGxhbmd1YWdlcy5leHRlbmQobGFuZ3VhZ2UpO1xuICAgICAgfVxuXG4gICAgICBvcHRpb25zLnRyYW5zbGF0aW9ucyA9IGxhbmd1YWdlcztcbiAgICB9IGVsc2Uge1xuICAgICAgdmFyIGJhc2VUcmFuc2xhdGlvbiA9IFRyYW5zbGF0aW9uLmxvYWRQYXRoKFxuICAgICAgICB0aGlzLmRlZmF1bHRzLmFtZExhbmd1YWdlQmFzZSArICdlbidcbiAgICAgICk7XG4gICAgICB2YXIgY3VzdG9tVHJhbnNsYXRpb24gPSBuZXcgVHJhbnNsYXRpb24ob3B0aW9ucy5sYW5ndWFnZSk7XG5cbiAgICAgIGN1c3RvbVRyYW5zbGF0aW9uLmV4dGVuZChiYXNlVHJhbnNsYXRpb24pO1xuXG4gICAgICBvcHRpb25zLnRyYW5zbGF0aW9ucyA9IGN1c3RvbVRyYW5zbGF0aW9uO1xuICAgIH1cblxuICAgIHJldHVybiBvcHRpb25zO1xuICB9O1xuXG4gIERlZmF1bHRzLnByb3RvdHlwZS5yZXNldCA9IGZ1bmN0aW9uICgpIHtcbiAgICBmdW5jdGlvbiBzdHJpcERpYWNyaXRpY3MgKHRleHQpIHtcbiAgICAgIC8vIFVzZWQgJ3VuaSByYW5nZSArIG5hbWVkIGZ1bmN0aW9uJyBmcm9tIGh0dHA6Ly9qc3BlcmYuY29tL2RpYWNyaXRpY3MvMThcbiAgICAgIGZ1bmN0aW9uIG1hdGNoKGEpIHtcbiAgICAgICAgcmV0dXJuIERJQUNSSVRJQ1NbYV0gfHwgYTtcbiAgICAgIH1cblxuICAgICAgcmV0dXJuIHRleHQucmVwbGFjZSgvW15cXHUwMDAwLVxcdTAwN0VdL2csIG1hdGNoKTtcbiAgICB9XG5cbiAgICBmdW5jdGlvbiBtYXRjaGVyIChwYXJhbXMsIGRhdGEpIHtcbiAgICAgIC8vIEFsd2F5cyByZXR1cm4gdGhlIG9iamVjdCBpZiB0aGVyZSBpcyBub3RoaW5nIHRvIGNvbXBhcmVcbiAgICAgIGlmICgkLnRyaW0ocGFyYW1zLnRlcm0pID09PSAnJykge1xuICAgICAgICByZXR1cm4gZGF0YTtcbiAgICAgIH1cblxuICAgICAgLy8gRG8gYSByZWN1cnNpdmUgY2hlY2sgZm9yIG9wdGlvbnMgd2l0aCBjaGlsZHJlblxuICAgICAgaWYgKGRhdGEuY2hpbGRyZW4gJiYgZGF0YS5jaGlsZHJlbi5sZW5ndGggPiAwKSB7XG4gICAgICAgIC8vIENsb25lIHRoZSBkYXRhIG9iamVjdCBpZiB0aGVyZSBhcmUgY2hpbGRyZW5cbiAgICAgICAgLy8gVGhpcyBpcyByZXF1aXJlZCBhcyB3ZSBtb2RpZnkgdGhlIG9iamVjdCB0byByZW1vdmUgYW55IG5vbi1tYXRjaGVzXG4gICAgICAgIHZhciBtYXRjaCA9ICQuZXh0ZW5kKHRydWUsIHt9LCBkYXRhKTtcblxuICAgICAgICAvLyBDaGVjayBlYWNoIGNoaWxkIG9mIHRoZSBvcHRpb25cbiAgICAgICAgZm9yICh2YXIgYyA9IGRhdGEuY2hpbGRyZW4ubGVuZ3RoIC0gMTsgYyA+PSAwOyBjLS0pIHtcbiAgICAgICAgICB2YXIgY2hpbGQgPSBkYXRhLmNoaWxkcmVuW2NdO1xuXG4gICAgICAgICAgdmFyIG1hdGNoZXMgPSBtYXRjaGVyKHBhcmFtcywgY2hpbGQpO1xuXG4gICAgICAgICAgLy8gSWYgdGhlcmUgd2Fzbid0IGEgbWF0Y2gsIHJlbW92ZSB0aGUgb2JqZWN0IGluIHRoZSBhcnJheVxuICAgICAgICAgIGlmIChtYXRjaGVzID09IG51bGwpIHtcbiAgICAgICAgICAgIG1hdGNoLmNoaWxkcmVuLnNwbGljZShjLCAxKTtcbiAgICAgICAgICB9XG4gICAgICAgIH1cblxuICAgICAgICAvLyBJZiBhbnkgY2hpbGRyZW4gbWF0Y2hlZCwgcmV0dXJuIHRoZSBuZXcgb2JqZWN0XG4gICAgICAgIGlmIChtYXRjaC5jaGlsZHJlbi5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgcmV0dXJuIG1hdGNoO1xuICAgICAgICB9XG5cbiAgICAgICAgLy8gSWYgdGhlcmUgd2VyZSBubyBtYXRjaGluZyBjaGlsZHJlbiwgY2hlY2sganVzdCB0aGUgcGxhaW4gb2JqZWN0XG4gICAgICAgIHJldHVybiBtYXRjaGVyKHBhcmFtcywgbWF0Y2gpO1xuICAgICAgfVxuXG4gICAgICB2YXIgb3JpZ2luYWwgPSBzdHJpcERpYWNyaXRpY3MoZGF0YS50ZXh0KS50b1VwcGVyQ2FzZSgpO1xuICAgICAgdmFyIHRlcm0gPSBzdHJpcERpYWNyaXRpY3MocGFyYW1zLnRlcm0pLnRvVXBwZXJDYXNlKCk7XG5cbiAgICAgIC8vIENoZWNrIGlmIHRoZSB0ZXh0IGNvbnRhaW5zIHRoZSB0ZXJtXG4gICAgICBpZiAob3JpZ2luYWwuaW5kZXhPZih0ZXJtKSA+IC0xKSB7XG4gICAgICAgIHJldHVybiBkYXRhO1xuICAgICAgfVxuXG4gICAgICAvLyBJZiBpdCBkb2Vzbid0IGNvbnRhaW4gdGhlIHRlcm0sIGRvbid0IHJldHVybiBhbnl0aGluZ1xuICAgICAgcmV0dXJuIG51bGw7XG4gICAgfVxuXG4gICAgdGhpcy5kZWZhdWx0cyA9IHtcbiAgICAgIGFtZEJhc2U6ICcuLycsXG4gICAgICBhbWRMYW5ndWFnZUJhc2U6ICcuL2kxOG4vJyxcbiAgICAgIGNsb3NlT25TZWxlY3Q6IHRydWUsXG4gICAgICBkZWJ1ZzogZmFsc2UsXG4gICAgICBkcm9wZG93bkF1dG9XaWR0aDogZmFsc2UsXG4gICAgICBlc2NhcGVNYXJrdXA6IFV0aWxzLmVzY2FwZU1hcmt1cCxcbiAgICAgIGxhbmd1YWdlOiBFbmdsaXNoVHJhbnNsYXRpb24sXG4gICAgICBtYXRjaGVyOiBtYXRjaGVyLFxuICAgICAgbWluaW11bUlucHV0TGVuZ3RoOiAwLFxuICAgICAgbWF4aW11bUlucHV0TGVuZ3RoOiAwLFxuICAgICAgbWF4aW11bVNlbGVjdGlvbkxlbmd0aDogMCxcbiAgICAgIG1pbmltdW1SZXN1bHRzRm9yU2VhcmNoOiAwLFxuICAgICAgc2VsZWN0T25DbG9zZTogZmFsc2UsXG4gICAgICBzb3J0ZXI6IGZ1bmN0aW9uIChkYXRhKSB7XG4gICAgICAgIHJldHVybiBkYXRhO1xuICAgICAgfSxcbiAgICAgIHRlbXBsYXRlUmVzdWx0OiBmdW5jdGlvbiAocmVzdWx0KSB7XG4gICAgICAgIHJldHVybiByZXN1bHQudGV4dDtcbiAgICAgIH0sXG4gICAgICB0ZW1wbGF0ZVNlbGVjdGlvbjogZnVuY3Rpb24gKHNlbGVjdGlvbikge1xuICAgICAgICByZXR1cm4gc2VsZWN0aW9uLnRleHQ7XG4gICAgICB9LFxuICAgICAgdGhlbWU6ICdkZWZhdWx0JyxcbiAgICAgIHdpZHRoOiAncmVzb2x2ZSdcbiAgICB9O1xuICB9O1xuXG4gIERlZmF1bHRzLnByb3RvdHlwZS5zZXQgPSBmdW5jdGlvbiAoa2V5LCB2YWx1ZSkge1xuICAgIHZhciBjYW1lbEtleSA9ICQuY2FtZWxDYXNlKGtleSk7XG5cbiAgICB2YXIgZGF0YSA9IHt9O1xuICAgIGRhdGFbY2FtZWxLZXldID0gdmFsdWU7XG5cbiAgICB2YXIgY29udmVydGVkRGF0YSA9IFV0aWxzLl9jb252ZXJ0RGF0YShkYXRhKTtcblxuICAgICQuZXh0ZW5kKHRoaXMuZGVmYXVsdHMsIGNvbnZlcnRlZERhdGEpO1xuICB9O1xuXG4gIHZhciBkZWZhdWx0cyA9IG5ldyBEZWZhdWx0cygpO1xuXG4gIHJldHVybiBkZWZhdWx0cztcbn0pO1xuXG5TMi5kZWZpbmUoJ3NlbGVjdDIvb3B0aW9ucycsW1xuICAncmVxdWlyZScsXG4gICdqcXVlcnknLFxuICAnLi9kZWZhdWx0cycsXG4gICcuL3V0aWxzJ1xuXSwgZnVuY3Rpb24gKHJlcXVpcmUsICQsIERlZmF1bHRzLCBVdGlscykge1xuICBmdW5jdGlvbiBPcHRpb25zIChvcHRpb25zLCAkZWxlbWVudCkge1xuICAgIHRoaXMub3B0aW9ucyA9IG9wdGlvbnM7XG5cbiAgICBpZiAoJGVsZW1lbnQgIT0gbnVsbCkge1xuICAgICAgdGhpcy5mcm9tRWxlbWVudCgkZWxlbWVudCk7XG4gICAgfVxuXG4gICAgdGhpcy5vcHRpb25zID0gRGVmYXVsdHMuYXBwbHkodGhpcy5vcHRpb25zKTtcblxuICAgIGlmICgkZWxlbWVudCAmJiAkZWxlbWVudC5pcygnaW5wdXQnKSkge1xuICAgICAgdmFyIElucHV0Q29tcGF0ID0gcmVxdWlyZSh0aGlzLmdldCgnYW1kQmFzZScpICsgJ2NvbXBhdC9pbnB1dERhdGEnKTtcblxuICAgICAgdGhpcy5vcHRpb25zLmRhdGFBZGFwdGVyID0gVXRpbHMuRGVjb3JhdGUoXG4gICAgICAgIHRoaXMub3B0aW9ucy5kYXRhQWRhcHRlcixcbiAgICAgICAgSW5wdXRDb21wYXRcbiAgICAgICk7XG4gICAgfVxuICB9XG5cbiAgT3B0aW9ucy5wcm90b3R5cGUuZnJvbUVsZW1lbnQgPSBmdW5jdGlvbiAoJGUpIHtcbiAgICB2YXIgZXhjbHVkZWREYXRhID0gWydzZWxlY3QyJ107XG5cbiAgICBpZiAodGhpcy5vcHRpb25zLm11bHRpcGxlID09IG51bGwpIHtcbiAgICAgIHRoaXMub3B0aW9ucy5tdWx0aXBsZSA9ICRlLnByb3AoJ211bHRpcGxlJyk7XG4gICAgfVxuXG4gICAgaWYgKHRoaXMub3B0aW9ucy5kaXNhYmxlZCA9PSBudWxsKSB7XG4gICAgICB0aGlzLm9wdGlvbnMuZGlzYWJsZWQgPSAkZS5wcm9wKCdkaXNhYmxlZCcpO1xuICAgIH1cblxuICAgIGlmICh0aGlzLm9wdGlvbnMubGFuZ3VhZ2UgPT0gbnVsbCkge1xuICAgICAgaWYgKCRlLnByb3AoJ2xhbmcnKSkge1xuICAgICAgICB0aGlzLm9wdGlvbnMubGFuZ3VhZ2UgPSAkZS5wcm9wKCdsYW5nJykudG9Mb3dlckNhc2UoKTtcbiAgICAgIH0gZWxzZSBpZiAoJGUuY2xvc2VzdCgnW2xhbmddJykucHJvcCgnbGFuZycpKSB7XG4gICAgICAgIHRoaXMub3B0aW9ucy5sYW5ndWFnZSA9ICRlLmNsb3Nlc3QoJ1tsYW5nXScpLnByb3AoJ2xhbmcnKTtcbiAgICAgIH1cbiAgICB9XG5cbiAgICBpZiAodGhpcy5vcHRpb25zLmRpciA9PSBudWxsKSB7XG4gICAgICBpZiAoJGUucHJvcCgnZGlyJykpIHtcbiAgICAgICAgdGhpcy5vcHRpb25zLmRpciA9ICRlLnByb3AoJ2RpcicpO1xuICAgICAgfSBlbHNlIGlmICgkZS5jbG9zZXN0KCdbZGlyXScpLnByb3AoJ2RpcicpKSB7XG4gICAgICAgIHRoaXMub3B0aW9ucy5kaXIgPSAkZS5jbG9zZXN0KCdbZGlyXScpLnByb3AoJ2RpcicpO1xuICAgICAgfSBlbHNlIHtcbiAgICAgICAgdGhpcy5vcHRpb25zLmRpciA9ICdsdHInO1xuICAgICAgfVxuICAgIH1cblxuICAgICRlLnByb3AoJ2Rpc2FibGVkJywgdGhpcy5vcHRpb25zLmRpc2FibGVkKTtcbiAgICAkZS5wcm9wKCdtdWx0aXBsZScsIHRoaXMub3B0aW9ucy5tdWx0aXBsZSk7XG5cbiAgICBpZiAoJGUuZGF0YSgnc2VsZWN0MlRhZ3MnKSkge1xuICAgICAgaWYgKHRoaXMub3B0aW9ucy5kZWJ1ZyAmJiB3aW5kb3cuY29uc29sZSAmJiBjb25zb2xlLndhcm4pIHtcbiAgICAgICAgY29uc29sZS53YXJuKFxuICAgICAgICAgICdTZWxlY3QyOiBUaGUgYGRhdGEtc2VsZWN0Mi10YWdzYCBhdHRyaWJ1dGUgaGFzIGJlZW4gY2hhbmdlZCB0byAnICtcbiAgICAgICAgICAndXNlIHRoZSBgZGF0YS1kYXRhYCBhbmQgYGRhdGEtdGFncz1cInRydWVcImAgYXR0cmlidXRlcyBhbmQgd2lsbCBiZSAnICtcbiAgICAgICAgICAncmVtb3ZlZCBpbiBmdXR1cmUgdmVyc2lvbnMgb2YgU2VsZWN0Mi4nXG4gICAgICAgICk7XG4gICAgICB9XG5cbiAgICAgICRlLmRhdGEoJ2RhdGEnLCAkZS5kYXRhKCdzZWxlY3QyVGFncycpKTtcbiAgICAgICRlLmRhdGEoJ3RhZ3MnLCB0cnVlKTtcbiAgICB9XG5cbiAgICBpZiAoJGUuZGF0YSgnYWpheFVybCcpKSB7XG4gICAgICBpZiAodGhpcy5vcHRpb25zLmRlYnVnICYmIHdpbmRvdy5jb25zb2xlICYmIGNvbnNvbGUud2Fybikge1xuICAgICAgICBjb25zb2xlLndhcm4oXG4gICAgICAgICAgJ1NlbGVjdDI6IFRoZSBgZGF0YS1hamF4LXVybGAgYXR0cmlidXRlIGhhcyBiZWVuIGNoYW5nZWQgdG8gJyArXG4gICAgICAgICAgJ2BkYXRhLWFqYXgtLXVybGAgYW5kIHN1cHBvcnQgZm9yIHRoZSBvbGQgYXR0cmlidXRlIHdpbGwgYmUgcmVtb3ZlZCcgK1xuICAgICAgICAgICcgaW4gZnV0dXJlIHZlcnNpb25zIG9mIFNlbGVjdDIuJ1xuICAgICAgICApO1xuICAgICAgfVxuXG4gICAgICAkZS5hdHRyKCdhamF4LS11cmwnLCAkZS5kYXRhKCdhamF4VXJsJykpO1xuICAgICAgJGUuZGF0YSgnYWpheC0tdXJsJywgJGUuZGF0YSgnYWpheFVybCcpKTtcbiAgICB9XG5cbiAgICB2YXIgZGF0YXNldCA9IHt9O1xuXG4gICAgLy8gUHJlZmVyIHRoZSBlbGVtZW50J3MgYGRhdGFzZXRgIGF0dHJpYnV0ZSBpZiBpdCBleGlzdHNcbiAgICAvLyBqUXVlcnkgMS54IGRvZXMgbm90IGNvcnJlY3RseSBoYW5kbGUgZGF0YSBhdHRyaWJ1dGVzIHdpdGggbXVsdGlwbGUgZGFzaGVzXG4gICAgaWYgKCQuZm4uanF1ZXJ5ICYmICQuZm4uanF1ZXJ5LnN1YnN0cigwLCAyKSA9PSAnMS4nICYmICRlWzBdLmRhdGFzZXQpIHtcbiAgICAgIGRhdGFzZXQgPSAkLmV4dGVuZCh0cnVlLCB7fSwgJGVbMF0uZGF0YXNldCwgJGUuZGF0YSgpKTtcbiAgICB9IGVsc2Uge1xuICAgICAgZGF0YXNldCA9ICRlLmRhdGEoKTtcbiAgICB9XG5cbiAgICB2YXIgZGF0YSA9ICQuZXh0ZW5kKHRydWUsIHt9LCBkYXRhc2V0KTtcblxuICAgIGRhdGEgPSBVdGlscy5fY29udmVydERhdGEoZGF0YSk7XG5cbiAgICBmb3IgKHZhciBrZXkgaW4gZGF0YSkge1xuICAgICAgaWYgKCQuaW5BcnJheShrZXksIGV4Y2x1ZGVkRGF0YSkgPiAtMSkge1xuICAgICAgICBjb250aW51ZTtcbiAgICAgIH1cblxuICAgICAgaWYgKCQuaXNQbGFpbk9iamVjdCh0aGlzLm9wdGlvbnNba2V5XSkpIHtcbiAgICAgICAgJC5leHRlbmQodGhpcy5vcHRpb25zW2tleV0sIGRhdGFba2V5XSk7XG4gICAgICB9IGVsc2Uge1xuICAgICAgICB0aGlzLm9wdGlvbnNba2V5XSA9IGRhdGFba2V5XTtcbiAgICAgIH1cbiAgICB9XG5cbiAgICByZXR1cm4gdGhpcztcbiAgfTtcblxuICBPcHRpb25zLnByb3RvdHlwZS5nZXQgPSBmdW5jdGlvbiAoa2V5KSB7XG4gICAgcmV0dXJuIHRoaXMub3B0aW9uc1trZXldO1xuICB9O1xuXG4gIE9wdGlvbnMucHJvdG90eXBlLnNldCA9IGZ1bmN0aW9uIChrZXksIHZhbCkge1xuICAgIHRoaXMub3B0aW9uc1trZXldID0gdmFsO1xuICB9O1xuXG4gIHJldHVybiBPcHRpb25zO1xufSk7XG5cblMyLmRlZmluZSgnc2VsZWN0Mi9jb3JlJyxbXG4gICdqcXVlcnknLFxuICAnLi9vcHRpb25zJyxcbiAgJy4vdXRpbHMnLFxuICAnLi9rZXlzJ1xuXSwgZnVuY3Rpb24gKCQsIE9wdGlvbnMsIFV0aWxzLCBLRVlTKSB7XG4gIHZhciBTZWxlY3QyID0gZnVuY3Rpb24gKCRlbGVtZW50LCBvcHRpb25zKSB7XG4gICAgaWYgKCRlbGVtZW50LmRhdGEoJ3NlbGVjdDInKSAhPSBudWxsKSB7XG4gICAgICAkZWxlbWVudC5kYXRhKCdzZWxlY3QyJykuZGVzdHJveSgpO1xuICAgIH1cblxuICAgIHRoaXMuJGVsZW1lbnQgPSAkZWxlbWVudDtcblxuICAgIHRoaXMuaWQgPSB0aGlzLl9nZW5lcmF0ZUlkKCRlbGVtZW50KTtcblxuICAgIG9wdGlvbnMgPSBvcHRpb25zIHx8IHt9O1xuXG4gICAgdGhpcy5vcHRpb25zID0gbmV3IE9wdGlvbnMob3B0aW9ucywgJGVsZW1lbnQpO1xuXG4gICAgU2VsZWN0Mi5fX3N1cGVyX18uY29uc3RydWN0b3IuY2FsbCh0aGlzKTtcblxuICAgIC8vIFNldCB1cCB0aGUgdGFiaW5kZXhcblxuICAgIHZhciB0YWJpbmRleCA9ICRlbGVtZW50LmF0dHIoJ3RhYmluZGV4JykgfHwgMDtcbiAgICAkZWxlbWVudC5kYXRhKCdvbGQtdGFiaW5kZXgnLCB0YWJpbmRleCk7XG4gICAgJGVsZW1lbnQuYXR0cigndGFiaW5kZXgnLCAnLTEnKTtcblxuICAgIC8vIFNldCB1cCBjb250YWluZXJzIGFuZCBhZGFwdGVyc1xuXG4gICAgdmFyIERhdGFBZGFwdGVyID0gdGhpcy5vcHRpb25zLmdldCgnZGF0YUFkYXB0ZXInKTtcbiAgICB0aGlzLmRhdGFBZGFwdGVyID0gbmV3IERhdGFBZGFwdGVyKCRlbGVtZW50LCB0aGlzLm9wdGlvbnMpO1xuXG4gICAgdmFyICRjb250YWluZXIgPSB0aGlzLnJlbmRlcigpO1xuXG4gICAgdGhpcy5fcGxhY2VDb250YWluZXIoJGNvbnRhaW5lcik7XG5cbiAgICB2YXIgU2VsZWN0aW9uQWRhcHRlciA9IHRoaXMub3B0aW9ucy5nZXQoJ3NlbGVjdGlvbkFkYXB0ZXInKTtcbiAgICB0aGlzLnNlbGVjdGlvbiA9IG5ldyBTZWxlY3Rpb25BZGFwdGVyKCRlbGVtZW50LCB0aGlzLm9wdGlvbnMpO1xuICAgIHRoaXMuJHNlbGVjdGlvbiA9IHRoaXMuc2VsZWN0aW9uLnJlbmRlcigpO1xuXG4gICAgdGhpcy5zZWxlY3Rpb24ucG9zaXRpb24odGhpcy4kc2VsZWN0aW9uLCAkY29udGFpbmVyKTtcblxuICAgIHZhciBEcm9wZG93bkFkYXB0ZXIgPSB0aGlzLm9wdGlvbnMuZ2V0KCdkcm9wZG93bkFkYXB0ZXInKTtcbiAgICB0aGlzLmRyb3Bkb3duID0gbmV3IERyb3Bkb3duQWRhcHRlcigkZWxlbWVudCwgdGhpcy5vcHRpb25zKTtcbiAgICB0aGlzLiRkcm9wZG93biA9IHRoaXMuZHJvcGRvd24ucmVuZGVyKCk7XG5cbiAgICB0aGlzLmRyb3Bkb3duLnBvc2l0aW9uKHRoaXMuJGRyb3Bkb3duLCAkY29udGFpbmVyKTtcblxuICAgIHZhciBSZXN1bHRzQWRhcHRlciA9IHRoaXMub3B0aW9ucy5nZXQoJ3Jlc3VsdHNBZGFwdGVyJyk7XG4gICAgdGhpcy5yZXN1bHRzID0gbmV3IFJlc3VsdHNBZGFwdGVyKCRlbGVtZW50LCB0aGlzLm9wdGlvbnMsIHRoaXMuZGF0YUFkYXB0ZXIpO1xuICAgIHRoaXMuJHJlc3VsdHMgPSB0aGlzLnJlc3VsdHMucmVuZGVyKCk7XG5cbiAgICB0aGlzLnJlc3VsdHMucG9zaXRpb24odGhpcy4kcmVzdWx0cywgdGhpcy4kZHJvcGRvd24pO1xuXG4gICAgLy8gQmluZCBldmVudHNcblxuICAgIHZhciBzZWxmID0gdGhpcztcblxuICAgIC8vIEJpbmQgdGhlIGNvbnRhaW5lciB0byBhbGwgb2YgdGhlIGFkYXB0ZXJzXG4gICAgdGhpcy5fYmluZEFkYXB0ZXJzKCk7XG5cbiAgICAvLyBSZWdpc3RlciBhbnkgRE9NIGV2ZW50IGhhbmRsZXJzXG4gICAgdGhpcy5fcmVnaXN0ZXJEb21FdmVudHMoKTtcblxuICAgIC8vIFJlZ2lzdGVyIGFueSBpbnRlcm5hbCBldmVudCBoYW5kbGVyc1xuICAgIHRoaXMuX3JlZ2lzdGVyRGF0YUV2ZW50cygpO1xuICAgIHRoaXMuX3JlZ2lzdGVyU2VsZWN0aW9uRXZlbnRzKCk7XG4gICAgdGhpcy5fcmVnaXN0ZXJEcm9wZG93bkV2ZW50cygpO1xuICAgIHRoaXMuX3JlZ2lzdGVyUmVzdWx0c0V2ZW50cygpO1xuICAgIHRoaXMuX3JlZ2lzdGVyRXZlbnRzKCk7XG5cbiAgICAvLyBTZXQgdGhlIGluaXRpYWwgc3RhdGVcbiAgICB0aGlzLmRhdGFBZGFwdGVyLmN1cnJlbnQoZnVuY3Rpb24gKGluaXRpYWxEYXRhKSB7XG4gICAgICBzZWxmLnRyaWdnZXIoJ3NlbGVjdGlvbjp1cGRhdGUnLCB7XG4gICAgICAgIGRhdGE6IGluaXRpYWxEYXRhXG4gICAgICB9KTtcbiAgICB9KTtcblxuICAgIC8vIEhpZGUgdGhlIG9yaWdpbmFsIHNlbGVjdFxuICAgICRlbGVtZW50LmFkZENsYXNzKCdzZWxlY3QyLWhpZGRlbi1hY2Nlc3NpYmxlJyk7XG4gICAgJGVsZW1lbnQuYXR0cignYXJpYS1oaWRkZW4nLCAndHJ1ZScpO1xuXG4gICAgLy8gU3luY2hyb25pemUgYW55IG1vbml0b3JlZCBhdHRyaWJ1dGVzXG4gICAgdGhpcy5fc3luY0F0dHJpYnV0ZXMoKTtcblxuICAgICRlbGVtZW50LmRhdGEoJ3NlbGVjdDInLCB0aGlzKTtcbiAgfTtcblxuICBVdGlscy5FeHRlbmQoU2VsZWN0MiwgVXRpbHMuT2JzZXJ2YWJsZSk7XG5cbiAgU2VsZWN0Mi5wcm90b3R5cGUuX2dlbmVyYXRlSWQgPSBmdW5jdGlvbiAoJGVsZW1lbnQpIHtcbiAgICB2YXIgaWQgPSAnJztcblxuICAgIGlmICgkZWxlbWVudC5hdHRyKCdpZCcpICE9IG51bGwpIHtcbiAgICAgIGlkID0gJGVsZW1lbnQuYXR0cignaWQnKTtcbiAgICB9IGVsc2UgaWYgKCRlbGVtZW50LmF0dHIoJ25hbWUnKSAhPSBudWxsKSB7XG4gICAgICBpZCA9ICRlbGVtZW50LmF0dHIoJ25hbWUnKSArICctJyArIFV0aWxzLmdlbmVyYXRlQ2hhcnMoMik7XG4gICAgfSBlbHNlIHtcbiAgICAgIGlkID0gVXRpbHMuZ2VuZXJhdGVDaGFycyg0KTtcbiAgICB9XG5cbiAgICBpZCA9IGlkLnJlcGxhY2UoLyg6fFxcLnxcXFt8XFxdfCwpL2csICcnKTtcbiAgICBpZCA9ICdzZWxlY3QyLScgKyBpZDtcblxuICAgIHJldHVybiBpZDtcbiAgfTtcblxuICBTZWxlY3QyLnByb3RvdHlwZS5fcGxhY2VDb250YWluZXIgPSBmdW5jdGlvbiAoJGNvbnRhaW5lcikge1xuICAgICRjb250YWluZXIuaW5zZXJ0QWZ0ZXIodGhpcy4kZWxlbWVudCk7XG5cbiAgICB2YXIgd2lkdGggPSB0aGlzLl9yZXNvbHZlV2lkdGgodGhpcy4kZWxlbWVudCwgdGhpcy5vcHRpb25zLmdldCgnd2lkdGgnKSk7XG5cbiAgICBpZiAod2lkdGggIT0gbnVsbCkge1xuICAgICAgJGNvbnRhaW5lci5jc3MoJ3dpZHRoJywgd2lkdGgpO1xuICAgIH1cbiAgfTtcblxuICBTZWxlY3QyLnByb3RvdHlwZS5fcmVzb2x2ZVdpZHRoID0gZnVuY3Rpb24gKCRlbGVtZW50LCBtZXRob2QpIHtcbiAgICB2YXIgV0lEVEggPSAvXndpZHRoOigoWy0rXT8oWzAtOV0qXFwuKT9bMC05XSspKHB4fGVtfGV4fCV8aW58Y218bW18cHR8cGMpKS9pO1xuXG4gICAgaWYgKG1ldGhvZCA9PSAncmVzb2x2ZScpIHtcbiAgICAgIHZhciBzdHlsZVdpZHRoID0gdGhpcy5fcmVzb2x2ZVdpZHRoKCRlbGVtZW50LCAnc3R5bGUnKTtcblxuICAgICAgaWYgKHN0eWxlV2lkdGggIT0gbnVsbCkge1xuICAgICAgICByZXR1cm4gc3R5bGVXaWR0aDtcbiAgICAgIH1cblxuICAgICAgcmV0dXJuIHRoaXMuX3Jlc29sdmVXaWR0aCgkZWxlbWVudCwgJ2VsZW1lbnQnKTtcbiAgICB9XG5cbiAgICBpZiAobWV0aG9kID09ICdlbGVtZW50Jykge1xuICAgICAgdmFyIGVsZW1lbnRXaWR0aCA9ICRlbGVtZW50Lm91dGVyV2lkdGgoZmFsc2UpO1xuXG4gICAgICBpZiAoZWxlbWVudFdpZHRoIDw9IDApIHtcbiAgICAgICAgcmV0dXJuICdhdXRvJztcbiAgICAgIH1cblxuICAgICAgcmV0dXJuIGVsZW1lbnRXaWR0aCArICdweCc7XG4gICAgfVxuXG4gICAgaWYgKG1ldGhvZCA9PSAnc3R5bGUnKSB7XG4gICAgICB2YXIgc3R5bGUgPSAkZWxlbWVudC5hdHRyKCdzdHlsZScpO1xuXG4gICAgICBpZiAodHlwZW9mKHN0eWxlKSAhPT0gJ3N0cmluZycpIHtcbiAgICAgICAgcmV0dXJuIG51bGw7XG4gICAgICB9XG5cbiAgICAgIHZhciBhdHRycyA9IHN0eWxlLnNwbGl0KCc7Jyk7XG5cbiAgICAgIGZvciAodmFyIGkgPSAwLCBsID0gYXR0cnMubGVuZ3RoOyBpIDwgbDsgaSA9IGkgKyAxKSB7XG4gICAgICAgIHZhciBhdHRyID0gYXR0cnNbaV0ucmVwbGFjZSgvXFxzL2csICcnKTtcbiAgICAgICAgdmFyIG1hdGNoZXMgPSBhdHRyLm1hdGNoKFdJRFRIKTtcblxuICAgICAgICBpZiAobWF0Y2hlcyAhPT0gbnVsbCAmJiBtYXRjaGVzLmxlbmd0aCA+PSAxKSB7XG4gICAgICAgICAgcmV0dXJuIG1hdGNoZXNbMV07XG4gICAgICAgIH1cbiAgICAgIH1cblxuICAgICAgcmV0dXJuIG51bGw7XG4gICAgfVxuXG4gICAgcmV0dXJuIG1ldGhvZDtcbiAgfTtcblxuICBTZWxlY3QyLnByb3RvdHlwZS5fYmluZEFkYXB0ZXJzID0gZnVuY3Rpb24gKCkge1xuICAgIHRoaXMuZGF0YUFkYXB0ZXIuYmluZCh0aGlzLCB0aGlzLiRjb250YWluZXIpO1xuICAgIHRoaXMuc2VsZWN0aW9uLmJpbmQodGhpcywgdGhpcy4kY29udGFpbmVyKTtcblxuICAgIHRoaXMuZHJvcGRvd24uYmluZCh0aGlzLCB0aGlzLiRjb250YWluZXIpO1xuICAgIHRoaXMucmVzdWx0cy5iaW5kKHRoaXMsIHRoaXMuJGNvbnRhaW5lcik7XG4gIH07XG5cbiAgU2VsZWN0Mi5wcm90b3R5cGUuX3JlZ2lzdGVyRG9tRXZlbnRzID0gZnVuY3Rpb24gKCkge1xuICAgIHZhciBzZWxmID0gdGhpcztcblxuICAgIHRoaXMuJGVsZW1lbnQub24oJ2NoYW5nZS5zZWxlY3QyJywgZnVuY3Rpb24gKCkge1xuICAgICAgc2VsZi5kYXRhQWRhcHRlci5jdXJyZW50KGZ1bmN0aW9uIChkYXRhKSB7XG4gICAgICAgIHNlbGYudHJpZ2dlcignc2VsZWN0aW9uOnVwZGF0ZScsIHtcbiAgICAgICAgICBkYXRhOiBkYXRhXG4gICAgICAgIH0pO1xuICAgICAgfSk7XG4gICAgfSk7XG5cbiAgICB0aGlzLiRlbGVtZW50Lm9uKCdmb2N1cy5zZWxlY3QyJywgZnVuY3Rpb24gKGV2dCkge1xuICAgICAgc2VsZi50cmlnZ2VyKCdmb2N1cycsIGV2dCk7XG4gICAgfSk7XG5cbiAgICB0aGlzLl9zeW5jQSA9IFV0aWxzLmJpbmQodGhpcy5fc3luY0F0dHJpYnV0ZXMsIHRoaXMpO1xuICAgIHRoaXMuX3N5bmNTID0gVXRpbHMuYmluZCh0aGlzLl9zeW5jU3VidHJlZSwgdGhpcyk7XG5cbiAgICBpZiAodGhpcy4kZWxlbWVudFswXS5hdHRhY2hFdmVudCkge1xuICAgICAgdGhpcy4kZWxlbWVudFswXS5hdHRhY2hFdmVudCgnb25wcm9wZXJ0eWNoYW5nZScsIHRoaXMuX3N5bmNBKTtcbiAgICB9XG5cbiAgICB2YXIgb2JzZXJ2ZXIgPSB3aW5kb3cuTXV0YXRpb25PYnNlcnZlciB8fFxuICAgICAgd2luZG93LldlYktpdE11dGF0aW9uT2JzZXJ2ZXIgfHxcbiAgICAgIHdpbmRvdy5Nb3pNdXRhdGlvbk9ic2VydmVyXG4gICAgO1xuXG4gICAgaWYgKG9ic2VydmVyICE9IG51bGwpIHtcbiAgICAgIHRoaXMuX29ic2VydmVyID0gbmV3IG9ic2VydmVyKGZ1bmN0aW9uIChtdXRhdGlvbnMpIHtcbiAgICAgICAgJC5lYWNoKG11dGF0aW9ucywgc2VsZi5fc3luY0EpO1xuICAgICAgICAkLmVhY2gobXV0YXRpb25zLCBzZWxmLl9zeW5jUyk7XG4gICAgICB9KTtcbiAgICAgIHRoaXMuX29ic2VydmVyLm9ic2VydmUodGhpcy4kZWxlbWVudFswXSwge1xuICAgICAgICBhdHRyaWJ1dGVzOiB0cnVlLFxuICAgICAgICBjaGlsZExpc3Q6IHRydWUsXG4gICAgICAgIHN1YnRyZWU6IGZhbHNlXG4gICAgICB9KTtcbiAgICB9IGVsc2UgaWYgKHRoaXMuJGVsZW1lbnRbMF0uYWRkRXZlbnRMaXN0ZW5lcikge1xuICAgICAgdGhpcy4kZWxlbWVudFswXS5hZGRFdmVudExpc3RlbmVyKFxuICAgICAgICAnRE9NQXR0ck1vZGlmaWVkJyxcbiAgICAgICAgc2VsZi5fc3luY0EsXG4gICAgICAgIGZhbHNlXG4gICAgICApO1xuICAgICAgdGhpcy4kZWxlbWVudFswXS5hZGRFdmVudExpc3RlbmVyKFxuICAgICAgICAnRE9NTm9kZUluc2VydGVkJyxcbiAgICAgICAgc2VsZi5fc3luY1MsXG4gICAgICAgIGZhbHNlXG4gICAgICApO1xuICAgICAgdGhpcy4kZWxlbWVudFswXS5hZGRFdmVudExpc3RlbmVyKFxuICAgICAgICAnRE9NTm9kZVJlbW92ZWQnLFxuICAgICAgICBzZWxmLl9zeW5jUyxcbiAgICAgICAgZmFsc2VcbiAgICAgICk7XG4gICAgfVxuICB9O1xuXG4gIFNlbGVjdDIucHJvdG90eXBlLl9yZWdpc3RlckRhdGFFdmVudHMgPSBmdW5jdGlvbiAoKSB7XG4gICAgdmFyIHNlbGYgPSB0aGlzO1xuXG4gICAgdGhpcy5kYXRhQWRhcHRlci5vbignKicsIGZ1bmN0aW9uIChuYW1lLCBwYXJhbXMpIHtcbiAgICAgIHNlbGYudHJpZ2dlcihuYW1lLCBwYXJhbXMpO1xuICAgIH0pO1xuICB9O1xuXG4gIFNlbGVjdDIucHJvdG90eXBlLl9yZWdpc3RlclNlbGVjdGlvbkV2ZW50cyA9IGZ1bmN0aW9uICgpIHtcbiAgICB2YXIgc2VsZiA9IHRoaXM7XG4gICAgdmFyIG5vblJlbGF5RXZlbnRzID0gWyd0b2dnbGUnLCAnZm9jdXMnXTtcblxuICAgIHRoaXMuc2VsZWN0aW9uLm9uKCd0b2dnbGUnLCBmdW5jdGlvbiAoKSB7XG4gICAgICBzZWxmLnRvZ2dsZURyb3Bkb3duKCk7XG4gICAgfSk7XG5cbiAgICB0aGlzLnNlbGVjdGlvbi5vbignZm9jdXMnLCBmdW5jdGlvbiAocGFyYW1zKSB7XG4gICAgICBzZWxmLmZvY3VzKHBhcmFtcyk7XG4gICAgfSk7XG5cbiAgICB0aGlzLnNlbGVjdGlvbi5vbignKicsIGZ1bmN0aW9uIChuYW1lLCBwYXJhbXMpIHtcbiAgICAgIGlmICgkLmluQXJyYXkobmFtZSwgbm9uUmVsYXlFdmVudHMpICE9PSAtMSkge1xuICAgICAgICByZXR1cm47XG4gICAgICB9XG5cbiAgICAgIHNlbGYudHJpZ2dlcihuYW1lLCBwYXJhbXMpO1xuICAgIH0pO1xuICB9O1xuXG4gIFNlbGVjdDIucHJvdG90eXBlLl9yZWdpc3RlckRyb3Bkb3duRXZlbnRzID0gZnVuY3Rpb24gKCkge1xuICAgIHZhciBzZWxmID0gdGhpcztcblxuICAgIHRoaXMuZHJvcGRvd24ub24oJyonLCBmdW5jdGlvbiAobmFtZSwgcGFyYW1zKSB7XG4gICAgICBzZWxmLnRyaWdnZXIobmFtZSwgcGFyYW1zKTtcbiAgICB9KTtcbiAgfTtcblxuICBTZWxlY3QyLnByb3RvdHlwZS5fcmVnaXN0ZXJSZXN1bHRzRXZlbnRzID0gZnVuY3Rpb24gKCkge1xuICAgIHZhciBzZWxmID0gdGhpcztcblxuICAgIHRoaXMucmVzdWx0cy5vbignKicsIGZ1bmN0aW9uIChuYW1lLCBwYXJhbXMpIHtcbiAgICAgIHNlbGYudHJpZ2dlcihuYW1lLCBwYXJhbXMpO1xuICAgIH0pO1xuICB9O1xuXG4gIFNlbGVjdDIucHJvdG90eXBlLl9yZWdpc3RlckV2ZW50cyA9IGZ1bmN0aW9uICgpIHtcbiAgICB2YXIgc2VsZiA9IHRoaXM7XG5cbiAgICB0aGlzLm9uKCdvcGVuJywgZnVuY3Rpb24gKCkge1xuICAgICAgc2VsZi4kY29udGFpbmVyLmFkZENsYXNzKCdzZWxlY3QyLWNvbnRhaW5lci0tb3BlbicpO1xuICAgIH0pO1xuXG4gICAgdGhpcy5vbignY2xvc2UnLCBmdW5jdGlvbiAoKSB7XG4gICAgICBzZWxmLiRjb250YWluZXIucmVtb3ZlQ2xhc3MoJ3NlbGVjdDItY29udGFpbmVyLS1vcGVuJyk7XG4gICAgfSk7XG5cbiAgICB0aGlzLm9uKCdlbmFibGUnLCBmdW5jdGlvbiAoKSB7XG4gICAgICBzZWxmLiRjb250YWluZXIucmVtb3ZlQ2xhc3MoJ3NlbGVjdDItY29udGFpbmVyLS1kaXNhYmxlZCcpO1xuICAgIH0pO1xuXG4gICAgdGhpcy5vbignZGlzYWJsZScsIGZ1bmN0aW9uICgpIHtcbiAgICAgIHNlbGYuJGNvbnRhaW5lci5hZGRDbGFzcygnc2VsZWN0Mi1jb250YWluZXItLWRpc2FibGVkJyk7XG4gICAgfSk7XG5cbiAgICB0aGlzLm9uKCdibHVyJywgZnVuY3Rpb24gKCkge1xuICAgICAgc2VsZi4kY29udGFpbmVyLnJlbW92ZUNsYXNzKCdzZWxlY3QyLWNvbnRhaW5lci0tZm9jdXMnKTtcbiAgICB9KTtcblxuICAgIHRoaXMub24oJ3F1ZXJ5JywgZnVuY3Rpb24gKHBhcmFtcykge1xuICAgICAgaWYgKCFzZWxmLmlzT3BlbigpKSB7XG4gICAgICAgIHNlbGYudHJpZ2dlcignb3BlbicsIHt9KTtcbiAgICAgIH1cblxuICAgICAgdGhpcy5kYXRhQWRhcHRlci5xdWVyeShwYXJhbXMsIGZ1bmN0aW9uIChkYXRhKSB7XG4gICAgICAgIHNlbGYudHJpZ2dlcigncmVzdWx0czphbGwnLCB7XG4gICAgICAgICAgZGF0YTogZGF0YSxcbiAgICAgICAgICBxdWVyeTogcGFyYW1zXG4gICAgICAgIH0pO1xuICAgICAgfSk7XG4gICAgfSk7XG5cbiAgICB0aGlzLm9uKCdxdWVyeTphcHBlbmQnLCBmdW5jdGlvbiAocGFyYW1zKSB7XG4gICAgICB0aGlzLmRhdGFBZGFwdGVyLnF1ZXJ5KHBhcmFtcywgZnVuY3Rpb24gKGRhdGEpIHtcbiAgICAgICAgc2VsZi50cmlnZ2VyKCdyZXN1bHRzOmFwcGVuZCcsIHtcbiAgICAgICAgICBkYXRhOiBkYXRhLFxuICAgICAgICAgIHF1ZXJ5OiBwYXJhbXNcbiAgICAgICAgfSk7XG4gICAgICB9KTtcbiAgICB9KTtcblxuICAgIHRoaXMub24oJ2tleXByZXNzJywgZnVuY3Rpb24gKGV2dCkge1xuICAgICAgdmFyIGtleSA9IGV2dC53aGljaDtcblxuICAgICAgaWYgKHNlbGYuaXNPcGVuKCkpIHtcbiAgICAgICAgaWYgKGtleSA9PT0gS0VZUy5FU0MgfHwga2V5ID09PSBLRVlTLlRBQiB8fFxuICAgICAgICAgICAgKGtleSA9PT0gS0VZUy5VUCAmJiBldnQuYWx0S2V5KSkge1xuICAgICAgICAgIHNlbGYuY2xvc2UoKTtcblxuICAgICAgICAgIGV2dC5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICB9IGVsc2UgaWYgKGtleSA9PT0gS0VZUy5FTlRFUikge1xuICAgICAgICAgIHNlbGYudHJpZ2dlcigncmVzdWx0czpzZWxlY3QnLCB7fSk7XG5cbiAgICAgICAgICBldnQucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgfSBlbHNlIGlmICgoa2V5ID09PSBLRVlTLlNQQUNFICYmIGV2dC5jdHJsS2V5KSkge1xuICAgICAgICAgIHNlbGYudHJpZ2dlcigncmVzdWx0czp0b2dnbGUnLCB7fSk7XG5cbiAgICAgICAgICBldnQucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgfSBlbHNlIGlmIChrZXkgPT09IEtFWVMuVVApIHtcbiAgICAgICAgICBzZWxmLnRyaWdnZXIoJ3Jlc3VsdHM6cHJldmlvdXMnLCB7fSk7XG5cbiAgICAgICAgICBldnQucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgfSBlbHNlIGlmIChrZXkgPT09IEtFWVMuRE9XTikge1xuICAgICAgICAgIHNlbGYudHJpZ2dlcigncmVzdWx0czpuZXh0Jywge30pO1xuXG4gICAgICAgICAgZXZ0LnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIH1cbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIGlmIChrZXkgPT09IEtFWVMuRU5URVIgfHwga2V5ID09PSBLRVlTLlNQQUNFIHx8XG4gICAgICAgICAgICAoa2V5ID09PSBLRVlTLkRPV04gJiYgZXZ0LmFsdEtleSkpIHtcbiAgICAgICAgICBzZWxmLm9wZW4oKTtcblxuICAgICAgICAgIGV2dC5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICB9XG4gICAgICB9XG4gICAgfSk7XG4gIH07XG5cbiAgU2VsZWN0Mi5wcm90b3R5cGUuX3N5bmNBdHRyaWJ1dGVzID0gZnVuY3Rpb24gKCkge1xuICAgIHRoaXMub3B0aW9ucy5zZXQoJ2Rpc2FibGVkJywgdGhpcy4kZWxlbWVudC5wcm9wKCdkaXNhYmxlZCcpKTtcblxuICAgIGlmICh0aGlzLm9wdGlvbnMuZ2V0KCdkaXNhYmxlZCcpKSB7XG4gICAgICBpZiAodGhpcy5pc09wZW4oKSkge1xuICAgICAgICB0aGlzLmNsb3NlKCk7XG4gICAgICB9XG5cbiAgICAgIHRoaXMudHJpZ2dlcignZGlzYWJsZScsIHt9KTtcbiAgICB9IGVsc2Uge1xuICAgICAgdGhpcy50cmlnZ2VyKCdlbmFibGUnLCB7fSk7XG4gICAgfVxuICB9O1xuXG4gIFNlbGVjdDIucHJvdG90eXBlLl9zeW5jU3VidHJlZSA9IGZ1bmN0aW9uIChldnQsIG11dGF0aW9ucykge1xuICAgIHZhciBjaGFuZ2VkID0gZmFsc2U7XG4gICAgdmFyIHNlbGYgPSB0aGlzO1xuXG4gICAgLy8gSWdub3JlIGFueSBtdXRhdGlvbiBldmVudHMgcmFpc2VkIGZvciBlbGVtZW50cyB0aGF0IGFyZW4ndCBvcHRpb25zIG9yXG4gICAgLy8gb3B0Z3JvdXBzLiBUaGlzIGhhbmRsZXMgdGhlIGNhc2Ugd2hlbiB0aGUgc2VsZWN0IGVsZW1lbnQgaXMgZGVzdHJveWVkXG4gICAgaWYgKFxuICAgICAgZXZ0ICYmIGV2dC50YXJnZXQgJiYgKFxuICAgICAgICBldnQudGFyZ2V0Lm5vZGVOYW1lICE9PSAnT1BUSU9OJyAmJiBldnQudGFyZ2V0Lm5vZGVOYW1lICE9PSAnT1BUR1JPVVAnXG4gICAgICApXG4gICAgKSB7XG4gICAgICByZXR1cm47XG4gICAgfVxuXG4gICAgaWYgKCFtdXRhdGlvbnMpIHtcbiAgICAgIC8vIElmIG11dGF0aW9uIGV2ZW50cyBhcmVuJ3Qgc3VwcG9ydGVkLCB0aGVuIHdlIGNhbiBvbmx5IGFzc3VtZSB0aGF0IHRoZVxuICAgICAgLy8gY2hhbmdlIGFmZmVjdGVkIHRoZSBzZWxlY3Rpb25zXG4gICAgICBjaGFuZ2VkID0gdHJ1ZTtcbiAgICB9IGVsc2UgaWYgKG11dGF0aW9ucy5hZGRlZE5vZGVzICYmIG11dGF0aW9ucy5hZGRlZE5vZGVzLmxlbmd0aCA+IDApIHtcbiAgICAgIGZvciAodmFyIG4gPSAwOyBuIDwgbXV0YXRpb25zLmFkZGVkTm9kZXMubGVuZ3RoOyBuKyspIHtcbiAgICAgICAgdmFyIG5vZGUgPSBtdXRhdGlvbnMuYWRkZWROb2Rlc1tuXTtcblxuICAgICAgICBpZiAobm9kZS5zZWxlY3RlZCkge1xuICAgICAgICAgIGNoYW5nZWQgPSB0cnVlO1xuICAgICAgICB9XG4gICAgICB9XG4gICAgfSBlbHNlIGlmIChtdXRhdGlvbnMucmVtb3ZlZE5vZGVzICYmIG11dGF0aW9ucy5yZW1vdmVkTm9kZXMubGVuZ3RoID4gMCkge1xuICAgICAgY2hhbmdlZCA9IHRydWU7XG4gICAgfVxuXG4gICAgLy8gT25seSByZS1wdWxsIHRoZSBkYXRhIGlmIHdlIHRoaW5rIHRoZXJlIGlzIGEgY2hhbmdlXG4gICAgaWYgKGNoYW5nZWQpIHtcbiAgICAgIHRoaXMuZGF0YUFkYXB0ZXIuY3VycmVudChmdW5jdGlvbiAoY3VycmVudERhdGEpIHtcbiAgICAgICAgc2VsZi50cmlnZ2VyKCdzZWxlY3Rpb246dXBkYXRlJywge1xuICAgICAgICAgIGRhdGE6IGN1cnJlbnREYXRhXG4gICAgICAgIH0pO1xuICAgICAgfSk7XG4gICAgfVxuICB9O1xuXG4gIC8qKlxuICAgKiBPdmVycmlkZSB0aGUgdHJpZ2dlciBtZXRob2QgdG8gYXV0b21hdGljYWxseSB0cmlnZ2VyIHByZS1ldmVudHMgd2hlblxuICAgKiB0aGVyZSBhcmUgZXZlbnRzIHRoYXQgY2FuIGJlIHByZXZlbnRlZC5cbiAgICovXG4gIFNlbGVjdDIucHJvdG90eXBlLnRyaWdnZXIgPSBmdW5jdGlvbiAobmFtZSwgYXJncykge1xuICAgIHZhciBhY3R1YWxUcmlnZ2VyID0gU2VsZWN0Mi5fX3N1cGVyX18udHJpZ2dlcjtcbiAgICB2YXIgcHJlVHJpZ2dlck1hcCA9IHtcbiAgICAgICdvcGVuJzogJ29wZW5pbmcnLFxuICAgICAgJ2Nsb3NlJzogJ2Nsb3NpbmcnLFxuICAgICAgJ3NlbGVjdCc6ICdzZWxlY3RpbmcnLFxuICAgICAgJ3Vuc2VsZWN0JzogJ3Vuc2VsZWN0aW5nJ1xuICAgIH07XG5cbiAgICBpZiAoYXJncyA9PT0gdW5kZWZpbmVkKSB7XG4gICAgICBhcmdzID0ge307XG4gICAgfVxuXG4gICAgaWYgKG5hbWUgaW4gcHJlVHJpZ2dlck1hcCkge1xuICAgICAgdmFyIHByZVRyaWdnZXJOYW1lID0gcHJlVHJpZ2dlck1hcFtuYW1lXTtcbiAgICAgIHZhciBwcmVUcmlnZ2VyQXJncyA9IHtcbiAgICAgICAgcHJldmVudGVkOiBmYWxzZSxcbiAgICAgICAgbmFtZTogbmFtZSxcbiAgICAgICAgYXJnczogYXJnc1xuICAgICAgfTtcblxuICAgICAgYWN0dWFsVHJpZ2dlci5jYWxsKHRoaXMsIHByZVRyaWdnZXJOYW1lLCBwcmVUcmlnZ2VyQXJncyk7XG5cbiAgICAgIGlmIChwcmVUcmlnZ2VyQXJncy5wcmV2ZW50ZWQpIHtcbiAgICAgICAgYXJncy5wcmV2ZW50ZWQgPSB0cnVlO1xuXG4gICAgICAgIHJldHVybjtcbiAgICAgIH1cbiAgICB9XG5cbiAgICBhY3R1YWxUcmlnZ2VyLmNhbGwodGhpcywgbmFtZSwgYXJncyk7XG4gIH07XG5cbiAgU2VsZWN0Mi5wcm90b3R5cGUudG9nZ2xlRHJvcGRvd24gPSBmdW5jdGlvbiAoKSB7XG4gICAgaWYgKHRoaXMub3B0aW9ucy5nZXQoJ2Rpc2FibGVkJykpIHtcbiAgICAgIHJldHVybjtcbiAgICB9XG5cbiAgICBpZiAodGhpcy5pc09wZW4oKSkge1xuICAgICAgdGhpcy5jbG9zZSgpO1xuICAgIH0gZWxzZSB7XG4gICAgICB0aGlzLm9wZW4oKTtcbiAgICB9XG4gIH07XG5cbiAgU2VsZWN0Mi5wcm90b3R5cGUub3BlbiA9IGZ1bmN0aW9uICgpIHtcbiAgICBpZiAodGhpcy5pc09wZW4oKSkge1xuICAgICAgcmV0dXJuO1xuICAgIH1cblxuICAgIHRoaXMudHJpZ2dlcigncXVlcnknLCB7fSk7XG4gIH07XG5cbiAgU2VsZWN0Mi5wcm90b3R5cGUuY2xvc2UgPSBmdW5jdGlvbiAoKSB7XG4gICAgaWYgKCF0aGlzLmlzT3BlbigpKSB7XG4gICAgICByZXR1cm47XG4gICAgfVxuXG4gICAgdGhpcy50cmlnZ2VyKCdjbG9zZScsIHt9KTtcbiAgfTtcblxuICBTZWxlY3QyLnByb3RvdHlwZS5pc09wZW4gPSBmdW5jdGlvbiAoKSB7XG4gICAgcmV0dXJuIHRoaXMuJGNvbnRhaW5lci5oYXNDbGFzcygnc2VsZWN0Mi1jb250YWluZXItLW9wZW4nKTtcbiAgfTtcblxuICBTZWxlY3QyLnByb3RvdHlwZS5oYXNGb2N1cyA9IGZ1bmN0aW9uICgpIHtcbiAgICByZXR1cm4gdGhpcy4kY29udGFpbmVyLmhhc0NsYXNzKCdzZWxlY3QyLWNvbnRhaW5lci0tZm9jdXMnKTtcbiAgfTtcblxuICBTZWxlY3QyLnByb3RvdHlwZS5mb2N1cyA9IGZ1bmN0aW9uIChkYXRhKSB7XG4gICAgLy8gTm8gbmVlZCB0byByZS10cmlnZ2VyIGZvY3VzIGV2ZW50cyBpZiB3ZSBhcmUgYWxyZWFkeSBmb2N1c2VkXG4gICAgaWYgKHRoaXMuaGFzRm9jdXMoKSkge1xuICAgICAgcmV0dXJuO1xuICAgIH1cblxuICAgIHRoaXMuJGNvbnRhaW5lci5hZGRDbGFzcygnc2VsZWN0Mi1jb250YWluZXItLWZvY3VzJyk7XG4gICAgdGhpcy50cmlnZ2VyKCdmb2N1cycsIHt9KTtcbiAgfTtcblxuICBTZWxlY3QyLnByb3RvdHlwZS5lbmFibGUgPSBmdW5jdGlvbiAoYXJncykge1xuICAgIGlmICh0aGlzLm9wdGlvbnMuZ2V0KCdkZWJ1ZycpICYmIHdpbmRvdy5jb25zb2xlICYmIGNvbnNvbGUud2Fybikge1xuICAgICAgY29uc29sZS53YXJuKFxuICAgICAgICAnU2VsZWN0MjogVGhlIGBzZWxlY3QyKFwiZW5hYmxlXCIpYCBtZXRob2QgaGFzIGJlZW4gZGVwcmVjYXRlZCBhbmQgd2lsbCcgK1xuICAgICAgICAnIGJlIHJlbW92ZWQgaW4gbGF0ZXIgU2VsZWN0MiB2ZXJzaW9ucy4gVXNlICRlbGVtZW50LnByb3AoXCJkaXNhYmxlZFwiKScgK1xuICAgICAgICAnIGluc3RlYWQuJ1xuICAgICAgKTtcbiAgICB9XG5cbiAgICBpZiAoYXJncyA9PSBudWxsIHx8IGFyZ3MubGVuZ3RoID09PSAwKSB7XG4gICAgICBhcmdzID0gW3RydWVdO1xuICAgIH1cblxuICAgIHZhciBkaXNhYmxlZCA9ICFhcmdzWzBdO1xuXG4gICAgdGhpcy4kZWxlbWVudC5wcm9wKCdkaXNhYmxlZCcsIGRpc2FibGVkKTtcbiAgfTtcblxuICBTZWxlY3QyLnByb3RvdHlwZS5kYXRhID0gZnVuY3Rpb24gKCkge1xuICAgIGlmICh0aGlzLm9wdGlvbnMuZ2V0KCdkZWJ1ZycpICYmXG4gICAgICAgIGFyZ3VtZW50cy5sZW5ndGggPiAwICYmIHdpbmRvdy5jb25zb2xlICYmIGNvbnNvbGUud2Fybikge1xuICAgICAgY29uc29sZS53YXJuKFxuICAgICAgICAnU2VsZWN0MjogRGF0YSBjYW4gbm8gbG9uZ2VyIGJlIHNldCB1c2luZyBgc2VsZWN0MihcImRhdGFcIilgLiBZb3UgJyArXG4gICAgICAgICdzaG91bGQgY29uc2lkZXIgc2V0dGluZyB0aGUgdmFsdWUgaW5zdGVhZCB1c2luZyBgJGVsZW1lbnQudmFsKClgLidcbiAgICAgICk7XG4gICAgfVxuXG4gICAgdmFyIGRhdGEgPSBbXTtcblxuICAgIHRoaXMuZGF0YUFkYXB0ZXIuY3VycmVudChmdW5jdGlvbiAoY3VycmVudERhdGEpIHtcbiAgICAgIGRhdGEgPSBjdXJyZW50RGF0YTtcbiAgICB9KTtcblxuICAgIHJldHVybiBkYXRhO1xuICB9O1xuXG4gIFNlbGVjdDIucHJvdG90eXBlLnZhbCA9IGZ1bmN0aW9uIChhcmdzKSB7XG4gICAgaWYgKHRoaXMub3B0aW9ucy5nZXQoJ2RlYnVnJykgJiYgd2luZG93LmNvbnNvbGUgJiYgY29uc29sZS53YXJuKSB7XG4gICAgICBjb25zb2xlLndhcm4oXG4gICAgICAgICdTZWxlY3QyOiBUaGUgYHNlbGVjdDIoXCJ2YWxcIilgIG1ldGhvZCBoYXMgYmVlbiBkZXByZWNhdGVkIGFuZCB3aWxsIGJlJyArXG4gICAgICAgICcgcmVtb3ZlZCBpbiBsYXRlciBTZWxlY3QyIHZlcnNpb25zLiBVc2UgJGVsZW1lbnQudmFsKCkgaW5zdGVhZC4nXG4gICAgICApO1xuICAgIH1cblxuICAgIGlmIChhcmdzID09IG51bGwgfHwgYXJncy5sZW5ndGggPT09IDApIHtcbiAgICAgIHJldHVybiB0aGlzLiRlbGVtZW50LnZhbCgpO1xuICAgIH1cblxuICAgIHZhciBuZXdWYWwgPSBhcmdzWzBdO1xuXG4gICAgaWYgKCQuaXNBcnJheShuZXdWYWwpKSB7XG4gICAgICBuZXdWYWwgPSAkLm1hcChuZXdWYWwsIGZ1bmN0aW9uIChvYmopIHtcbiAgICAgICAgcmV0dXJuIG9iai50b1N0cmluZygpO1xuICAgICAgfSk7XG4gICAgfVxuXG4gICAgdGhpcy4kZWxlbWVudC52YWwobmV3VmFsKS50cmlnZ2VyKCdjaGFuZ2UnKTtcbiAgfTtcblxuICBTZWxlY3QyLnByb3RvdHlwZS5kZXN0cm95ID0gZnVuY3Rpb24gKCkge1xuICAgIHRoaXMuJGNvbnRhaW5lci5yZW1vdmUoKTtcblxuICAgIGlmICh0aGlzLiRlbGVtZW50WzBdLmRldGFjaEV2ZW50KSB7XG4gICAgICB0aGlzLiRlbGVtZW50WzBdLmRldGFjaEV2ZW50KCdvbnByb3BlcnR5Y2hhbmdlJywgdGhpcy5fc3luY0EpO1xuICAgIH1cblxuICAgIGlmICh0aGlzLl9vYnNlcnZlciAhPSBudWxsKSB7XG4gICAgICB0aGlzLl9vYnNlcnZlci5kaXNjb25uZWN0KCk7XG4gICAgICB0aGlzLl9vYnNlcnZlciA9IG51bGw7XG4gICAgfSBlbHNlIGlmICh0aGlzLiRlbGVtZW50WzBdLnJlbW92ZUV2ZW50TGlzdGVuZXIpIHtcbiAgICAgIHRoaXMuJGVsZW1lbnRbMF1cbiAgICAgICAgLnJlbW92ZUV2ZW50TGlzdGVuZXIoJ0RPTUF0dHJNb2RpZmllZCcsIHRoaXMuX3N5bmNBLCBmYWxzZSk7XG4gICAgICB0aGlzLiRlbGVtZW50WzBdXG4gICAgICAgIC5yZW1vdmVFdmVudExpc3RlbmVyKCdET01Ob2RlSW5zZXJ0ZWQnLCB0aGlzLl9zeW5jUywgZmFsc2UpO1xuICAgICAgdGhpcy4kZWxlbWVudFswXVxuICAgICAgICAucmVtb3ZlRXZlbnRMaXN0ZW5lcignRE9NTm9kZVJlbW92ZWQnLCB0aGlzLl9zeW5jUywgZmFsc2UpO1xuICAgIH1cblxuICAgIHRoaXMuX3N5bmNBID0gbnVsbDtcbiAgICB0aGlzLl9zeW5jUyA9IG51bGw7XG5cbiAgICB0aGlzLiRlbGVtZW50Lm9mZignLnNlbGVjdDInKTtcbiAgICB0aGlzLiRlbGVtZW50LmF0dHIoJ3RhYmluZGV4JywgdGhpcy4kZWxlbWVudC5kYXRhKCdvbGQtdGFiaW5kZXgnKSk7XG5cbiAgICB0aGlzLiRlbGVtZW50LnJlbW92ZUNsYXNzKCdzZWxlY3QyLWhpZGRlbi1hY2Nlc3NpYmxlJyk7XG4gICAgdGhpcy4kZWxlbWVudC5hdHRyKCdhcmlhLWhpZGRlbicsICdmYWxzZScpO1xuICAgIHRoaXMuJGVsZW1lbnQucmVtb3ZlRGF0YSgnc2VsZWN0MicpO1xuXG4gICAgdGhpcy5kYXRhQWRhcHRlci5kZXN0cm95KCk7XG4gICAgdGhpcy5zZWxlY3Rpb24uZGVzdHJveSgpO1xuICAgIHRoaXMuZHJvcGRvd24uZGVzdHJveSgpO1xuICAgIHRoaXMucmVzdWx0cy5kZXN0cm95KCk7XG5cbiAgICB0aGlzLmRhdGFBZGFwdGVyID0gbnVsbDtcbiAgICB0aGlzLnNlbGVjdGlvbiA9IG51bGw7XG4gICAgdGhpcy5kcm9wZG93biA9IG51bGw7XG4gICAgdGhpcy5yZXN1bHRzID0gbnVsbDtcbiAgfTtcblxuICBTZWxlY3QyLnByb3RvdHlwZS5yZW5kZXIgPSBmdW5jdGlvbiAoKSB7XG4gICAgdmFyICRjb250YWluZXIgPSAkKFxuICAgICAgJzxzcGFuIGNsYXNzPVwic2VsZWN0MiBzZWxlY3QyLWNvbnRhaW5lclwiPicgK1xuICAgICAgICAnPHNwYW4gY2xhc3M9XCJzZWxlY3Rpb25cIj48L3NwYW4+JyArXG4gICAgICAgICc8c3BhbiBjbGFzcz1cImRyb3Bkb3duLXdyYXBwZXJcIiBhcmlhLWhpZGRlbj1cInRydWVcIj48L3NwYW4+JyArXG4gICAgICAnPC9zcGFuPidcbiAgICApO1xuXG4gICAgJGNvbnRhaW5lci5hdHRyKCdkaXInLCB0aGlzLm9wdGlvbnMuZ2V0KCdkaXInKSk7XG5cbiAgICB0aGlzLiRjb250YWluZXIgPSAkY29udGFpbmVyO1xuXG4gICAgdGhpcy4kY29udGFpbmVyLmFkZENsYXNzKCdzZWxlY3QyLWNvbnRhaW5lci0tJyArIHRoaXMub3B0aW9ucy5nZXQoJ3RoZW1lJykpO1xuXG4gICAgJGNvbnRhaW5lci5kYXRhKCdlbGVtZW50JywgdGhpcy4kZWxlbWVudCk7XG5cbiAgICByZXR1cm4gJGNvbnRhaW5lcjtcbiAgfTtcblxuICByZXR1cm4gU2VsZWN0Mjtcbn0pO1xuXG5TMi5kZWZpbmUoJ2pxdWVyeS1tb3VzZXdoZWVsJyxbXG4gICdqcXVlcnknXG5dLCBmdW5jdGlvbiAoJCkge1xuICAvLyBVc2VkIHRvIHNoaW0galF1ZXJ5Lm1vdXNld2hlZWwgZm9yIG5vbi1mdWxsIGJ1aWxkcy5cbiAgcmV0dXJuICQ7XG59KTtcblxuUzIuZGVmaW5lKCdqcXVlcnkuc2VsZWN0MicsW1xuICAnanF1ZXJ5JyxcbiAgJ2pxdWVyeS1tb3VzZXdoZWVsJyxcblxuICAnLi9zZWxlY3QyL2NvcmUnLFxuICAnLi9zZWxlY3QyL2RlZmF1bHRzJ1xuXSwgZnVuY3Rpb24gKCQsIF8sIFNlbGVjdDIsIERlZmF1bHRzKSB7XG4gIGlmICgkLmZuLnNlbGVjdDIgPT0gbnVsbCkge1xuICAgIC8vIEFsbCBtZXRob2RzIHRoYXQgc2hvdWxkIHJldHVybiB0aGUgZWxlbWVudFxuICAgIHZhciB0aGlzTWV0aG9kcyA9IFsnb3BlbicsICdjbG9zZScsICdkZXN0cm95J107XG5cbiAgICAkLmZuLnNlbGVjdDIgPSBmdW5jdGlvbiAob3B0aW9ucykge1xuICAgICAgb3B0aW9ucyA9IG9wdGlvbnMgfHwge307XG5cbiAgICAgIGlmICh0eXBlb2Ygb3B0aW9ucyA9PT0gJ29iamVjdCcpIHtcbiAgICAgICAgdGhpcy5lYWNoKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICB2YXIgaW5zdGFuY2VPcHRpb25zID0gJC5leHRlbmQodHJ1ZSwge30sIG9wdGlvbnMpO1xuXG4gICAgICAgICAgdmFyIGluc3RhbmNlID0gbmV3IFNlbGVjdDIoJCh0aGlzKSwgaW5zdGFuY2VPcHRpb25zKTtcbiAgICAgICAgfSk7XG5cbiAgICAgICAgcmV0dXJuIHRoaXM7XG4gICAgICB9IGVsc2UgaWYgKHR5cGVvZiBvcHRpb25zID09PSAnc3RyaW5nJykge1xuICAgICAgICB2YXIgcmV0O1xuICAgICAgICB2YXIgYXJncyA9IEFycmF5LnByb3RvdHlwZS5zbGljZS5jYWxsKGFyZ3VtZW50cywgMSk7XG5cbiAgICAgICAgdGhpcy5lYWNoKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgICB2YXIgaW5zdGFuY2UgPSAkKHRoaXMpLmRhdGEoJ3NlbGVjdDInKTtcblxuICAgICAgICAgIGlmIChpbnN0YW5jZSA9PSBudWxsICYmIHdpbmRvdy5jb25zb2xlICYmIGNvbnNvbGUuZXJyb3IpIHtcbiAgICAgICAgICAgIGNvbnNvbGUuZXJyb3IoXG4gICAgICAgICAgICAgICdUaGUgc2VsZWN0MihcXCcnICsgb3B0aW9ucyArICdcXCcpIG1ldGhvZCB3YXMgY2FsbGVkIG9uIGFuICcgK1xuICAgICAgICAgICAgICAnZWxlbWVudCB0aGF0IGlzIG5vdCB1c2luZyBTZWxlY3QyLidcbiAgICAgICAgICAgICk7XG4gICAgICAgICAgfVxuXG4gICAgICAgICAgcmV0ID0gaW5zdGFuY2Vbb3B0aW9uc10uYXBwbHkoaW5zdGFuY2UsIGFyZ3MpO1xuICAgICAgICB9KTtcblxuICAgICAgICAvLyBDaGVjayBpZiB3ZSBzaG91bGQgYmUgcmV0dXJuaW5nIGB0aGlzYFxuICAgICAgICBpZiAoJC5pbkFycmF5KG9wdGlvbnMsIHRoaXNNZXRob2RzKSA+IC0xKSB7XG4gICAgICAgICAgcmV0dXJuIHRoaXM7XG4gICAgICAgIH1cblxuICAgICAgICByZXR1cm4gcmV0O1xuICAgICAgfSBlbHNlIHtcbiAgICAgICAgdGhyb3cgbmV3IEVycm9yKCdJbnZhbGlkIGFyZ3VtZW50cyBmb3IgU2VsZWN0MjogJyArIG9wdGlvbnMpO1xuICAgICAgfVxuICAgIH07XG4gIH1cblxuICBpZiAoJC5mbi5zZWxlY3QyLmRlZmF1bHRzID09IG51bGwpIHtcbiAgICAkLmZuLnNlbGVjdDIuZGVmYXVsdHMgPSBEZWZhdWx0cztcbiAgfVxuXG4gIHJldHVybiBTZWxlY3QyO1xufSk7XG5cbiAgLy8gUmV0dXJuIHRoZSBBTUQgbG9hZGVyIGNvbmZpZ3VyYXRpb24gc28gaXQgY2FuIGJlIHVzZWQgb3V0c2lkZSBvZiB0aGlzIGZpbGVcbiAgcmV0dXJuIHtcbiAgICBkZWZpbmU6IFMyLmRlZmluZSxcbiAgICByZXF1aXJlOiBTMi5yZXF1aXJlXG4gIH07XG59KCkpO1xuXG4gIC8vIEF1dG9sb2FkIHRoZSBqUXVlcnkgYmluZGluZ3NcbiAgLy8gV2Uga25vdyB0aGF0IGFsbCBvZiB0aGUgbW9kdWxlcyBleGlzdCBhYm92ZSB0aGlzLCBzbyB3ZSdyZSBzYWZlXG4gIHZhciBzZWxlY3QyID0gUzIucmVxdWlyZSgnanF1ZXJ5LnNlbGVjdDInKTtcblxuICAvLyBIb2xkIHRoZSBBTUQgbW9kdWxlIHJlZmVyZW5jZXMgb24gdGhlIGpRdWVyeSBmdW5jdGlvbiB0aGF0IHdhcyBqdXN0IGxvYWRlZFxuICAvLyBUaGlzIGFsbG93cyBTZWxlY3QyIHRvIHVzZSB0aGUgaW50ZXJuYWwgbG9hZGVyIG91dHNpZGUgb2YgdGhpcyBmaWxlLCBzdWNoXG4gIC8vIGFzIGluIHRoZSBsYW5ndWFnZSBmaWxlcy5cbiAgalF1ZXJ5LmZuLnNlbGVjdDIuYW1kID0gUzI7XG5cbiAgLy8gUmV0dXJuIHRoZSBTZWxlY3QyIGluc3RhbmNlIGZvciBhbnlvbmUgd2hvIGlzIGltcG9ydGluZyBpdC5cbiAgcmV0dXJuIHNlbGVjdDI7XG59KSk7XG4iLCIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW4iXSwic291cmNlUm9vdCI6IiJ9