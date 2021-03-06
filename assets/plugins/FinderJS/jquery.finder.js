/*
The MIT License (MIT)

Copyright (c) 2015 Mark Matyas

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.


*/

(function(f) {
    if (typeof exports === "object" && typeof module !== "undefined") {
        module.exports = f()
    } else if (typeof define === "function" && define.amd) {
        define([], f)
    } else {
        var g;
        if (typeof window !== "undefined") {
            g = window
        } else if (typeof global !== "undefined") {
            g = global
        } else if (typeof self !== "undefined") {
            g = self
        } else {
            g = this
        }
        g.finder = f()
    }
}
)(function() {
    var define, module, exports;
    return (function e(t, n, r) {
        function s(o, u) {
            if (!n[o]) {
                if (!t[o]) {
                    var a = typeof require == "function" && require;
                    if (!u && a)
                        return a(o, !0);
                    if (i)
                        return i(o, !0);
                    var f = new Error("Cannot find module '" + o + "'");
                    throw f.code = "MODULE_NOT_FOUND",
                    f
                }
                var l = n[o] = {
                    exports: {}
                };
                t[o][0].call(l.exports, function(e) {
                    var n = t[o][1][e];
                    return s(n ? n : e)
                }, l, l.exports, e, t, n, r)
            }
            return n[o].exports
        }
        var i = typeof require == "function" && require;
        for (var o = 0; o < r.length; o++)
            s(r[o]);
        return s
    }
    )({
        "/Users/mmatyas/projects/finderjs/index.js": [function(require, module, exports) {
            "use strict";
            function finder(e, t, n) {
                var i = new EventEmitter
                  , a = extend(defaults, {
                    container: e,
                    emitter: i
                }, n);
                return a.className = extend(defaults.className, n ? n.className : {}),
                "function" == typeof t && (a.data = t),
                e.addEventListener("click", finder.clickEvent.bind(null, a, i)),
                e.addEventListener("keydown", finder.keydownEvent.bind(null, e, a, i)),
                i.on("item-selected", finder.itemSelected.bind(null, a, i)),
                i.on("create-column", finder.addColumn.bind(null, e, a, i)),
                i.on("navigate", finder.navigate.bind(null, a, i)),
                _.addClass(e, a.className.container),
                finder.createColumn(t, a, i),
                e.setAttribute("tabindex", 0),
                i
            }
            var extend = require("xtend")
              , document = require("global/document")
              , EventEmitter = require("eventemitter3")
              , isArray = require("x-is-array")
              , _ = require("./util")
              , defaults = {
                className: {
                    container: "fjs-container",
                    col: "fjs-col",
                    list: "fjs-list",
                    item: "fjs-item",
                    active: "fjs-active",
                    children: "fjs-has-children",
                    url: "fjs-url",
                    itemPrepend: "fjs-item-prepend",
                    itemContent: "fjs-item-content",
                    itemAppend: "fjs-item-append"
                }
            };
            module.exports = finder,
            finder.addColumn = function(e, t, n, i) {
                e.appendChild(i),
                n.emit("column-created", i)
            }
            ,
            finder.itemSelected = function(e, t, n) {
                var i = n.item
                  , a = i._item
                  , l = n.col
                  , r = a.children || e.data
                  , s = l.getElementsByClassName(e.className.active);
                s.length && _.removeClass(s[0], e.className.active),
                _.addClass(i, e.className.active),
                _.nextSiblings(l).map(_.remove),
                r ? finder.createColumn(r, e, t, a) : a.url ? document.location.href = a.url : t.emit("leaf-selected", a)
            }
            ,
            finder.clickEvent = function(e, t, n) {
                var i = n.target
                  , a = _.closest(i, function(t) {
                    return _.hasClass(t, e.className.col)
                })
                  , l = _.closest(i, function(t) {
                    return _.hasClass(t, e.className.item)
                });
                _.stop(n),
                l && t.emit("item-selected", {
                    col: a,
                    item: l
                })
            }
            ,
            finder.keydownEvent = function(e, t, n, i) {
                var a = {
                    38: "up",
                    39: "right",
                    40: "down",
                    37: "left"
                };
                i.keyCode in a && (_.stop(i),
                n.emit("navigate", {
                    direction: a[i.keyCode],
                    container: e
                }))
            }
            ,
            finder.navigate = function(e, t, n) {
                var i, a, l = finder.findLastActive(n.container, e), r = null, s = n.direction;
                l ? (i = l.item,
                a = l.col,
                "up" === s && i.previousSibling ? r = i.previousSibling : "down" === s && i.nextSibling ? r = i.nextSibling : "right" === s && a.nextSibling ? (a = a.nextSibling,
                r = _.first(a, "." + e.className.item)) : "left" === s && a.previousSibling && (a = a.previousSibling,
                r = _.first(a, "." + e.className.active) || _.first(a, "." + e.className.item))) : (a = _.first(n.container, "." + e.className.col),
                r = _.first(a, "." + e.className.item)),
                r && t.emit("item-selected", {
                    col: a,
                    item: r
                })
            }
            ,
            finder.findLastActive = function(e, t) {
                var n, i, a = e.getElementsByClassName(t.className.active);
                return a.length ? (n = a[a.length - 1],
                i = _.closest(n, function(e) {
                    return _.hasClass(e, t.className.col)
                }),
                {
                    col: i,
                    item: n
                }) : null
            }
            ,
            finder.createColumn = function(e, t, n, i) {
                function a(e) {
                    finder.createColumn(e, t, n, i)
                }
                var l, r;
                if ("function" == typeof e)
                    e.call(null, i, t, a);
                else {
                    if (!isArray(e))
                        throw new Error("Unknown data type");
                    r = finder.createList(e, t),
                    l = _.el("div"),
                    l.appendChild(r),
                    _.addClass(l, t.className.col),
                    n.emit("create-column", l)
                }
            }
            ,
            finder.createList = function(e, t) {
                var n, i = _.el("ul"), a = e.map(finder.createItem.bind(null, t));
                return n = a.reduce(function(e, t) {
                    return e.appendChild(t),
                    e
                }, document.createDocumentFragment()),
                i.appendChild(n),
                _.addClass(i, t.className.list),
                i
            }
            ,
            finder.createItemContent = function(e, t) {
                var n = document.createDocumentFragment()
                  , i = _.el("div." + e.className.itemPrepend)
                  , a = _.el("div." + e.className.itemContent)
                  , l = _.el("div." + e.className.itemAppend);
                return n.appendChild(i),
                a.appendChild(document.createTextNode(t.label)),
                n.appendChild(a),
                n.appendChild(l),
                n
            }
            ,
            finder.createItem = function(e, t) {
                var n = document.createDocumentFragment()
                  , i = [e.className.item]
                  , a = _.el("li")
                  , l = _.el("a")
                  , r = e.createItemContent || finder.createItemContent;
                return n = r.call(null, e, t),
                l.appendChild(n),
                l.href = "",
                l.setAttribute("tabindex", -1),
                t.url && (l.href = t.url,
                i.push(e.className.url)),
                t.className && i.push(t.className),
                t.children && i.push(e.className.children),
                _.addClass(a, i),
                a.appendChild(l),
                a._item = t,
                a
            }
            ;
        }
        , {
            "./util": "/Users/mmatyas/projects/finderjs/util.js",
            "eventemitter3": "/Users/mmatyas/projects/finderjs/node_modules/eventemitter3/index.js",
            "global/document": "/Users/mmatyas/projects/finderjs/node_modules/global/document.js",
            "x-is-array": "/Users/mmatyas/projects/finderjs/node_modules/x-is-array/index.js",
            "xtend": "/Users/mmatyas/projects/finderjs/node_modules/xtend/immutable.js"
        }],
        "/Users/mmatyas/projects/finderjs/node_modules/browserify/node_modules/browser-resolve/empty.js": [function(require, module, exports) {
        }
        , {}],
        "/Users/mmatyas/projects/finderjs/node_modules/eventemitter3/index.js": [function(require, module, exports) {
            "use strict";
            function EE(e, t, n) {
                this.fn = e,
                this.context = t,
                this.once = n || !1
            }
            function EventEmitter() {}
            var prefix = "function" != typeof Object.create ? "~" : !1;
            EventEmitter.prototype._events = void 0,
            EventEmitter.prototype.listeners = function(e, t) {
                var n = prefix ? prefix + e : e
                  , r = this._events && this._events[n];
                if (t)
                    return !!r;
                if (!r)
                    return [];
                if (r.fn)
                    return [r.fn];
                for (var i = 0, s = r.length, o = new Array(s); s > i; i++)
                    o[i] = r[i].fn;
                return o
            }
            ,
            EventEmitter.prototype.emit = function(e, t, n, r, i, s) {
                var o = prefix ? prefix + e : e;
                if (!this._events || !this._events[o])
                    return !1;
                var f, v, c = this._events[o], h = arguments.length;
                if ("function" == typeof c.fn) {
                    switch (c.once && this.removeListener(e, c.fn, void 0, !0),
                    h) {
                    case 1:
                        return c.fn.call(c.context),
                        !0;
                    case 2:
                        return c.fn.call(c.context, t),
                        !0;
                    case 3:
                        return c.fn.call(c.context, t, n),
                        !0;
                    case 4:
                        return c.fn.call(c.context, t, n, r),
                        !0;
                    case 5:
                        return c.fn.call(c.context, t, n, r, i),
                        !0;
                    case 6:
                        return c.fn.call(c.context, t, n, r, i, s),
                        !0
                    }
                    for (v = 1,
                    f = new Array(h - 1); h > v; v++)
                        f[v - 1] = arguments[v];
                    c.fn.apply(c.context, f)
                } else {
                    var p, a = c.length;
                    for (v = 0; a > v; v++)
                        switch (c[v].once && this.removeListener(e, c[v].fn, void 0, !0),
                        h) {
                        case 1:
                            c[v].fn.call(c[v].context);
                            break;
                        case 2:
                            c[v].fn.call(c[v].context, t);
                            break;
                        case 3:
                            c[v].fn.call(c[v].context, t, n);
                            break;
                        default:
                            if (!f)
                                for (p = 1,
                                f = new Array(h - 1); h > p; p++)
                                    f[p - 1] = arguments[p];
                            c[v].fn.apply(c[v].context, f)
                        }
                }
                return !0
            }
            ,
            EventEmitter.prototype.on = function(e, t, n) {
                var r = new EE(t,n || this)
                  , i = prefix ? prefix + e : e;
                return this._events || (this._events = prefix ? {} : Object.create(null)),
                this._events[i] ? this._events[i].fn ? this._events[i] = [this._events[i], r] : this._events[i].push(r) : this._events[i] = r,
                this
            }
            ,
            EventEmitter.prototype.once = function(e, t, n) {
                var r = new EE(t,n || this,!0)
                  , i = prefix ? prefix + e : e;
                return this._events || (this._events = prefix ? {} : Object.create(null)),
                this._events[i] ? this._events[i].fn ? this._events[i] = [this._events[i], r] : this._events[i].push(r) : this._events[i] = r,
                this
            }
            ,
            EventEmitter.prototype.removeListener = function(e, t, n, r) {
                var i = prefix ? prefix + e : e;
                if (!this._events || !this._events[i])
                    return this;
                var s = this._events[i]
                  , o = [];
                if (t)
                    if (s.fn)
                        (s.fn !== t || r && !s.once || n && s.context !== n) && o.push(s);
                    else
                        for (var f = 0, v = s.length; v > f; f++)
                            (s[f].fn !== t || r && !s[f].once || n && s[f].context !== n) && o.push(s[f]);
                return o.length ? this._events[i] = 1 === o.length ? o[0] : o : delete this._events[i],
                this
            }
            ,
            EventEmitter.prototype.removeAllListeners = function(e) {
                return this._events ? (e ? delete this._events[prefix ? prefix + e : e] : this._events = prefix ? {} : Object.create(null),
                this) : this
            }
            ,
            EventEmitter.prototype.off = EventEmitter.prototype.removeListener,
            EventEmitter.prototype.addListener = EventEmitter.prototype.on,
            EventEmitter.prototype.setMaxListeners = function() {
                return this
            }
            ,
            EventEmitter.prefixed = prefix,
            "undefined" != typeof module && (module.exports = EventEmitter);

        }
        , {}],
        "/Users/mmatyas/projects/finderjs/node_modules/global/document.js": [function(require, module, exports) {
            (function(global) {
                var topLevel = "undefined" != typeof global ? global : "undefined" != typeof window ? window : {}
                  , minDoc = require("min-document");
                if ("undefined" != typeof document)
                    module.exports = document;
                else {
                    var doccy = topLevel["__GLOBAL_DOCUMENT_CACHE@4"];
                    doccy || (doccy = topLevel["__GLOBAL_DOCUMENT_CACHE@4"] = minDoc),
                    module.exports = doccy
                }

            }
            ).call(this, typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
        }
        , {
            "min-document": "/Users/mmatyas/projects/finderjs/node_modules/browserify/node_modules/browser-resolve/empty.js"
        }],
        "/Users/mmatyas/projects/finderjs/node_modules/x-is-array/index.js": [function(require, module, exports) {
            function isArray(r) {
                return "[object Array]" === toString.call(r)
            }
            var nativeIsArray = Array.isArray
              , toString = Object.prototype.toString;
            module.exports = nativeIsArray || isArray;

        }
        , {}],
        "/Users/mmatyas/projects/finderjs/node_modules/xtend/immutable.js": [function(require, module, exports) {
            function extend() {
                for (var r = {}, e = 0; e < arguments.length; e++) {
                    var n = arguments[e];
                    for (var t in n)
                        n.hasOwnProperty(t) && (r[t] = n[t])
                }
                return r
            }
            module.exports = extend;

        }
        , {}],
        "/Users/mmatyas/projects/finderjs/util.js": [function(require, module, exports) {
            "use strict";
            function isElement(e) {
                try {
                    return e instanceof Element
                } catch (r) {
                    return !(!e || 1 !== e.nodeType)
                }
            }
            function el(e) {
                var r, n = [], t = e;
                return isElement(e) ? e : (n = e.split("."),
                n.length > 1 && (t = n[0]),
                r = document.createElement(t),
                addClass(r, n.slice(1)),
                r)
            }
            function frag() {
                return document.createDocumentFragment()
            }
            function text(e) {
                return document.createTextNode(e)
            }
            function remove(e) {
                return "remove"in e ? e.remove() : e.parentNode.removeChild(e),
                e
            }
            function closest(e, r) {
                for (var n = e; n; ) {
                    if (r(n))
                        return n;
                    n = n.parentNode
                }
                return null
            }
            function addClass(e, r) {
                function n(e, r) {
                    e.className ? hasClass(e, r) || (e.className += " " + r) : e.className = r
                }
                var t = r;
                return isArray(r) || (t = r.trim().split(/\s+/)),
                t.forEach(n.bind(null, e)),
                e
            }
            function removeClass(e, r) {
                function n(e, r) {
                    var n = new RegExp("(?:^|\\s)" + r + "(?!\\S)","g");
                    e.className = e.className.replace(n, "").trim()
                }
                var t = r;
                return isArray(r) || (t = r.trim().split(/\s+/)),
                t.forEach(n.bind(null, e)),
                e
            }
            function hasClass(e, r) {
                return e && "className"in e ? -1 !== e.className.split(/\s+/).indexOf(r) : !1
            }
            function nextSiblings(e) {
                for (var r = e.nextSibling, n = []; r; )
                    n.push(r),
                    r = r.nextSibling;
                return n
            }
            function previousSiblings(e) {
                for (var r = e.previousSibling, n = []; r; )
                    n.push(r),
                    r = r.previousSibling;
                return n
            }
            function stop(e) {
                return e.stopPropagation(),
                e.preventDefault(),
                e
            }
            function first(e, r) {
                return e.querySelector(r)
            }
            function append(e, r) {
                var n = frag()
                  , r = isArray(r) ? r : [r];
                return r.forEach(n.appendChild.bind(n)),
                e.appendChild(n),
                e
            }
            var document = require("global/document")
              , isArray = require("x-is-array");
            module.exports = {
                el: el,
                frag: frag,
                text: text,
                closest: closest,
                addClass: addClass,
                removeClass: removeClass,
                hasClass: hasClass,
                nextSiblings: nextSiblings,
                previousSiblings: previousSiblings,
                remove: remove,
                stop: stop,
                first: first,
                append: append
            };

        }
        , {
            "global/document": "/Users/mmatyas/projects/finderjs/node_modules/global/document.js",
            "x-is-array": "/Users/mmatyas/projects/finderjs/node_modules/x-is-array/index.js"
        }]
    }, {}, ["/Users/mmatyas/projects/finderjs/index.js"])("/Users/mmatyas/projects/finderjs/index.js")
});

'use strict';

/**
 * jQuery wrapper for finderjs
 * @author Mark Matyas
 */

;(function jQuery($) {
    var name = 'finderjs';

    $.fn[name] = function _finderjs(data, options) {
        return this.each(function each() {
            if (!$.data(this, '_' + name)) {
                $.data(this, '_' + name, finder(this, data, options));
            }
        });
    }
    ;
}
)(jQuery);
