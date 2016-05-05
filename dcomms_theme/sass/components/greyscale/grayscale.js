(function () {
  function d() {
  }

  function b(i, h) {
    for (var j = i.length; j--;) {
      if (i[j].listener === h) {
        return j
      }
    }
    return -1
  }

  function g(h) {
    return function () {
      return this[h].apply(this, arguments)
    }
  }

  var a = d.prototype, c = this, f = c.EventEmitter;
  a.getListeners = function (k) {
    var j, l, h = this._getEvents();
    if ("object" == typeof k) {
      j = {};
      for (l in h) {
        h.hasOwnProperty(l) && k.test(l) && (j[l] = h[l])
      }
    }
    else {
      j = h[k] || (h[k] = [])
    }
    return j
  }, a.flattenListeners = function (i) {
    var h, j = [];
    for (h = 0; i.length > h; h += 1) {
      j.push(i[h].listener)
    }
    return j
  }, a.getListenersAsObject = function (i) {
    var h, j = this.getListeners(i);
    return j instanceof Array && (h = {}, h[i] = j), h || j
  }, a.addListener = function (k, m) {
    var h, j = this.getListenersAsObject(k), l = "object" == typeof m;
    for (h in j) {
      j.hasOwnProperty(h) && -1 === b(j[h], m) && j[h].push(l ? m : {listener: m, once: !1})
    }
    return this
  }, a.on = g("addListener"), a.addOnceListener = function (i, h) {
    return this.addListener(i, {listener: h, once: !0})
  }, a.once = g("addOnceListener"), a.defineEvent = function (h) {
    return this.getListeners(h), this
  }, a.defineEvents = function (i) {
    for (var h = 0; i.length > h; h += 1) {
      this.defineEvent(i[h])
    }
    return this
  }, a.removeListener = function (k, m) {
    var h, j, l = this.getListenersAsObject(k);
    for (j in l) {
      l.hasOwnProperty(j) && (h = b(l[j], m), -1 !== h && l[j].splice(h, 1))
    }
    return this
  }, a.off = g("removeListener"), a.addListeners = function (i, h) {
    return this.manipulateListeners(!1, i, h)
  }, a.removeListeners = function (i, h) {
    return this.manipulateListeners(!0, i, h)
  }, a.manipulateListeners = function (m, j, q) {
    var h, l, p = m ? this.removeListener : this.addListener, k = m ? this.removeListeners : this.addListeners;
    if ("object" != typeof j || j instanceof RegExp) {
      for (h = q.length; h--;) {
        p.call(this, j, q[h])
      }
    }
    else {
      for (h in j) {
        j.hasOwnProperty(h) && (l = j[h]) && ("function" == typeof l ? p.call(this, h, l) : k.call(this, h, l))
      }
    }
    return this
  }, a.removeEvent = function (k) {
    var j, l = typeof k, h = this._getEvents();
    if ("string" === l) {
      delete h[k]
    }
    else {
      if ("object" === l) {
        for (j in h) {
          h.hasOwnProperty(j) && k.test(j) && delete h[j]
        }
      }
      else {
        delete this._events
      }
    }
    return this
  }, a.removeAllListeners = g("removeEvent"), a.emitEvent = function (m, j) {
    var q, h, l, p, k = this.getListenersAsObject(m);
    for (l in k) {
      if (k.hasOwnProperty(l)) {
        for (h = k[l].length; h--;) {
          q = k[l][h], q.once === !0 && this.removeListener(m, q.listener), p = q.listener.apply(this,
            j || []), p === this._getOnceReturnValue() && this.removeListener(m, q.listener)
        }
      }
    }
    return this
  }, a.trigger = g("emitEvent"), a.emit = function (i) {
    var h = Array.prototype.slice.call(arguments, 1);
    return this.emitEvent(i, h)
  }, a.setOnceReturnValue = function (h) {
    return this._onceReturnValue = h, this
  }, a._getOnceReturnValue = function () {
    return this.hasOwnProperty("_onceReturnValue") ? this._onceReturnValue : !0
  }, a._getEvents = function () {
    return this._events || (this._events = {})
  }, d.noConflict = function () {
    return c.EventEmitter = f, d
  }, "function" == typeof define && define.amd ? define("eventEmitter/EventEmitter", [], function () {
    return d
  }) : "object" == typeof module && module.exports ? module.exports = d : this.EventEmitter = d
}).call(this), function (d) {
  function b(e) {
    var h = d.event;
    return h.target = h.target || h.srcElement || e, h
  }

  var g = document.documentElement, a = function () {
  };
  g.addEventListener ? a = function (i, h, j) {
    i.addEventListener(h, j, !1)
  } : g.attachEvent && (a = function (j, k, h) {
    j[k + h] = h.handleEvent ? function () {
      var e = b(j);
      h.handleEvent.call(h, e)
    } : function () {
      var e = b(j);
      h.call(j, e)
    }, j.attachEvent("on" + k, j[k + h])
  });
  var c = function () {
  };
  g.removeEventListener ? c = function (i, h, j) {
    i.removeEventListener(h, j, !1)
  } : g.detachEvent && (c = function (k, j, l) {
    k.detachEvent("on" + j, k[j + l]);
    try {
      delete k[j + l]
    }
    catch (h) {
      k[j + l] = void 0
    }
  });
  var f = {bind: a, unbind: c};
  "function" == typeof define && define.amd ? define("eventie/eventie", f) : d.eventie = f
}(this), function (b, a) {
  "function" == typeof define && define.amd ? define(["eventEmitter/EventEmitter", "eventie/eventie"], function (d, c) {
    return a(b, d, c)
  }) : "object" == typeof exports ? module.exports = a(b, require("eventEmitter"),
    require("eventie")) : b.imagesLoaded = a(b, b.EventEmitter, b.eventie)
}(this, function (p, A, j) {
  function k(c, a) {
    for (var d in a) {
      c[d] = a[d]
    }
    return c
  }

  function b(a) {
    return "[object Array]" === q.call(a)
  }

  function g(d) {
    var c = [];
    if (b(d)) {
      c = d
    }
    else {
      if ("number" == typeof d.length) {
        for (var f = 0, a = d.length; a > f; f++) {
          c.push(d[f])
        }
      }
      else {
        c.push(d)
      }
    }
    return c
  }

  function B(d, a, f) {
    if (!(this instanceof B)) {
      return new B(d, a)
    }
    "string" == typeof d && (d = document.querySelectorAll(d)), this.elements = g(d), this.options = k({},
      this.options), "function" == typeof a ? f = a : k(this.options, a), f && this.on("always",
      f), this.getImages(), x && (this.jqDeferred = new x.Deferred);
    var c = this;
    setTimeout(function () {
      c.check()
    })
  }

  function w(a) {
    this.img = a
  }

  function m(a) {
    this.src = a, y[a] = this
  }

  var x = p.jQuery, z = p.console, l = z !== void 0, q = Object.prototype.toString;
  B.prototype = new A, B.prototype.options = {}, B.prototype.getImages = function () {
    this.images = [];
    for (var h = 0, c = this.elements.length; c > h; h++) {
      var v = this.elements[h];
      "IMG" === v.nodeName && this.addImage(v);
      for (var a = v.querySelectorAll("img"), f = 0, u = a.length; u > f; f++) {
        var d = a[f];
        this.addImage(d)
      }
    }
  }, B.prototype.addImage = function (c) {
    var a = new w(c);
    this.images.push(a)
  }, B.prototype.check = function () {
    function f(n, i) {
      return c.options.debug && l && z.log("confirm", n, i), c.progress(n), s++, s === a && c.complete(), !0
    }

    var c = this, s = 0, a = this.images.length;
    if (this.hasAnyBroken = !1, !a) {
      return this.complete(), void 0
    }
    for (var d = 0; a > d; d++) {
      var h = this.images[d];
      h.on("confirm", f), h.check()
    }
  }, B.prototype.progress = function (c) {
    this.hasAnyBroken = this.hasAnyBroken || !c.isLoaded;
    var a = this;
    setTimeout(function () {
      a.emit("progress", a, c), a.jqDeferred && a.jqDeferred.notify && a.jqDeferred.notify(a, c)
    })
  }, B.prototype.complete = function () {
    var c = this.hasAnyBroken ? "fail" : "done";
    this.isComplete = !0;
    var a = this;
    setTimeout(function () {
      if (a.emit(c, a), a.emit("always", a), a.jqDeferred) {
        var d = a.hasAnyBroken ? "reject" : "resolve";
        a.jqDeferred[d](a)
      }
    })
  }, x && (x.fn.imagesLoaded = function (c, a) {
    var d = new B(this, c, a);
    return d.jqDeferred.promise(x(this))
  }), w.prototype = new A, w.prototype.check = function () {
    var c = y[this.img.src] || new m(this.img.src);
    if (c.isConfirmed) {
      return this.confirm(c.isLoaded, "cached was confirmed"), void 0
    }
    if (this.img.complete && void 0 !== this.img.naturalWidth) {
      return this.confirm(0 !== this.img.naturalWidth, "naturalWidth"), void 0
    }
    var a = this;
    c.on("confirm", function (d, f) {
      return a.confirm(d.isLoaded, f), !0
    }), c.check()
  }, w.prototype.confirm = function (c, a) {
    this.isLoaded = c, this.emit("confirm", this, a)
  };
  var y = {};
  return m.prototype = new A, m.prototype.check = function () {
    if (!this.isChecked) {
      var a = new Image;
      j.bind(a, "load", this), j.bind(a, "error", this), a.src = this.src, this.isChecked = !0
    }
  }, m.prototype.handleEvent = function (c) {
    var a = "on" + c.type;
    this[a] && this[a](c)
  }, m.prototype.onload = function (a) {
    this.confirm(!0, "onload"), this.unbindProxyEvents(a)
  }, m.prototype.onerror = function (a) {
    this.confirm(!1, "onerror"), this.unbindProxyEvents(a)
  }, m.prototype.confirm = function (c, a) {
    this.isConfirmed = !0, this.isLoaded = c, this.emit("confirm", this, a)
  }, m.prototype.unbindProxyEvents = function (a) {
    j.unbind(a.target, "load", this), j.unbind(a.target, "error", this)
  }, B
});
var grayscale = function () {
  var g = {
    colorProps: ["color", "backgroundColor", "borderBottomColor", "borderTopColor", "borderLeftColor",
                 "borderRightColor", "backgroundImage"], externalImageHandler: {
      init: function (i, a) {
        if (i.nodeName.toLowerCase() === "img") {
        }
        else {
          b(i).backgroundImageSRC = a;
          i.style.backgroundImage = ""
        }
      }, reset: function (a) {
        if (a.nodeName.toLowerCase() === "img") {
        }
        else {
          a.style.backgroundImage = "url(" + (b(a).backgroundImageSRC || "") + ")"
        }
      }
    }
  }, k = function () {
    try {
      window.console.log.apply(console, arguments)
    }
    catch (a) {
    }
  }, d = function (a) {
    return (new RegExp("https?://(?!" + window.location.hostname + ")")).test(a)
  }, b = function () {
    var i = [0], a = "data" + +(new Date);
    return function (o) {
      var m = o[a], e = i.length;
      if (!m) {
        m = o[a] = e;
        i[m] = {}
      }
      return i[m]
    }
  }(), f = function (v, A, m) {
    var B = document.createElement("canvas"), z = B.getContext(
      "2d"), y = v.naturalHeight || v.offsetHeight || v.height, r = v.naturalWidth || v.offsetWidth || v.width, o;
    B.height = y;
    B.width = r;
    z.drawImage(v, 0, 0);
    try {
      o = z.getImageData(0, 0, r, y)
    }
    catch (x) {
    }
    if (A) {
      f.preparing = true;
      var q = 0;
      (function () {
        if (!f.preparing) {
          return
        }
        if (q === y) {
          z.putImageData(o, 0, 0, 0, 0, r, y);
          m ? b(m).BGdataURL = B.toDataURL() : b(v).dataURL = B.toDataURL()
        }
        for (var a = 0; a < r; a++) {
          var e = (q * r + a) * 4;
          o.data[e] = o.data[e + 1] = o.data[e + 2] = c(o.data[e], o.data[e + 1], o.data[e + 2])
        }
        q++;
        setTimeout(arguments.callee, 0)
      })();
      return
    }
    else {
      f.preparing = false
    }
    for (var q = 0; q < y; q++) {
      for (var i = 0; i < r; i++) {
        var w = (q * r + i) * 4;
        o.data[w] = o.data[w + 1] = o.data[w + 2] = c(o.data[w], o.data[w + 1], o.data[w + 2])
      }
    }
    z.putImageData(o, 0, 0, 0, 0, r, y);
    return B
  }, l = function (m, a) {
    var o = document.defaultView && document.defaultView.getComputedStyle ? document.defaultView.getComputedStyle(m,
      null)[a] : m.currentStyle[a];
    if (o && /^#[A-F0-9]/i.test(o)) {
      var i = o.match(/[A-F0-9]{2}/ig);
      o = "rgb(" + parseInt(i[0], 16) + "," + parseInt(i[1], 16) + "," + parseInt(i[2], 16) + ")"
    }
    return o
  }, c = function (i, a, m) {
    return parseInt(0.2125 * i + 0.7154 * a + 0.0721 * m, 10)
  }, j = function (i) {
    var a = Array.prototype.slice.call(i.getElementsByTagName("*"));
    a.unshift(i);
    return a
  };
  var h = function (u) {
    if (u && u[0] && u.length && u[0].nodeName) {
      var F = Array.prototype.slice.call(u), B = -1, H = F.length;
      while (++B < H) {
        h.call(this, F[B])
      }
      return
    }
    u = u || document.documentElement;
    if (!document.createElement("canvas").getContext) {
      u.style.filter = "progid:DXImageTransform.Microsoft.BasicImage(grayscale=1)";
      u.style.zoom = 1;
      return
    }
    var C = j(u), z = -1, G = C.length;
    while (++z < G) {
      var r = C[z];
      if (r.nodeName.toLowerCase() === "img") {
        var A = r.getAttribute("src");
        if (!A) {
          continue
        }
        if (d(A)) {
          g.externalImageHandler.init(r, A)
        }
        else {
          b(r).realSRC = A;
          try {
            r.src = b(r).dataURL || f(r).toDataURL()
          }
          catch (D) {
            g.externalImageHandler.init(r, A)
          }
        }
      }
      else {
        for (var n = 0, I = g.colorProps.length; n < I; n++) {
          var q = g.colorProps[n], s = l(r, q);
          if (!s) {
            continue
          }
          if (r.style[q]) {
            b(r)[q] = s
          }
          if (s.substring(0, 4) === "rgb(") {
            var e = c.apply(null, s.match(/\d+/g));
            r.style[q] = s = "rgb(" + e + "," + e + "," + e + ")";
            continue
          }
          if (s.indexOf("url(") > -1) {
            var o = /\(['"]?(.+?)['"]?\)/, a = s.match(o)[1];
            if (d(a)) {
              g.externalImageHandler.init(r, a);
              b(r).externalBG = true;
              continue
            }
            try {
              var i = b(r).BGdataURL || function () {
                  var m = document.createElement("img");
                  m.src = a;
                  return f(m).toDataURL()
                }();
              r.style[q] = s.replace(o, function (p, m) {
                return "(" + i + ")"
              })
            }
            catch (D) {
              g.externalImageHandler.init(r, a)
            }
          }
        }
      }
    }
  };
  h.reset = function (A) {
    if (A && A[0] && A.length && A[0].nodeName) {
      var r = Array.prototype.slice.call(A), B = -1, e = r.length;
      while (++B < e) {
        h.reset.call(this, r[B])
      }
      return
    }
    A = A || document.documentElement;
    if (!document.createElement("canvas").getContext) {
      A.style.filter = "progid:DXImageTransform.Microsoft.BasicImage(grayscale=0)";
      return
    }
    var w = j(A), q = -1, y = w.length;
    while (++q < y) {
      var u = w[q];
      if (u.nodeName.toLowerCase() === "img") {
        var a = u.getAttribute("src");
        if (d(a)) {
          g.externalImageHandler.reset(u, a)
        }
        u.src = b(u).realSRC || a
      }
      else {
        for (var x = 0, z = g.colorProps.length; x < z; x++) {
          if (b(u).externalBG) {
            g.externalImageHandler.reset(u)
          }
          var n = g.colorProps[x];
          u.style[n] = b(u)[n] || ""
        }
      }
    }
  };
  h.prepare = function (w) {
    if (w && w[0] && w.length && w[0].nodeName) {
      var A = Array.prototype.slice.call(w), i = -1, u = A.length;
      while (++i < u) {
        h.prepare.call(null, A[i])
      }
      return
    }
    w = w || document.documentElement;
    if (!document.createElement("canvas").getContext) {
      return
    }
    var q = j(w), y = -1, r = q.length;
    while (++y < r) {
      var a = q[y];
      if (b(a).skip) {
        return
      }
      if (a.nodeName.toLowerCase() === "img") {
        if (a.getAttribute("src") && !d(a.src)) {
          f(a, true)
        }
      }
      else {
        var x = l(a, "backgroundImage");
        if (x.indexOf("url(") > -1) {
          var z = /\(['"]?(.+?)['"]?\)/, n = x.match(z)[1];
          if (!d(n)) {
            var s = document.createElement("img");
            s.src = n;
            f(s, true, a)
          }
        }
      }
    }
  };
  return h
}();

(function ($, Drupal) {

  'use strict';

  Drupal.behaviors.GrayScale = {
    attach: function (context, settings) {
      $(document).imagesLoaded(function () {
        var f = ["msTouchAction", "msWrapFlow"];
        var k = ["msTextCombineHorizontal"];
        var j = document;
        var l = j.body;
        var o = l.style;
        var m = null;
        var n;
        for (var h = 0; h < f.length; h++) {
          n = f[h];
          if (o[n] != undefined) {
            m = "ie10"
          }
        }
        for (var h = 0; h < k.length; h++) {
          n = k[h];
          if (o[n] != undefined) {
            m = "ie11"
          }
        }
        if (m == "ie10" || m == "ie11") {
          if (Modernizr.cssfilters) {
            $("body").addClass("edge")
          }
          else {
            $("body").addClass("ie11");
            $(".grayscale img").each(function () {
              var b = $(this);
              b.css({position: "absolute"}).wrap("<div class='img_wrapper' style='display: inline-block'>").clone().addClass(
                "img_grayscale ieImage").css({position: "absolute", "z-index": "5", opacity: "0"}).insertBefore(b).queue(
                function () {
                  var d = $(this);
                  d.parent().css({width: this.width, height: this.height});
                  d.dequeue()
                });
              this.src = g(this.src)
            });
            $(".grayscale img").hover(function () {
              $(this).parent().find("img:first").stop().animate({opacity: 1}, 200)
            }, function () {
              $(".img_grayscale").stop().animate({opacity: 0}, 200)
            });
            function g(b) {
              var p = document.createElement("canvas");
              var v = p.getContext("2d");
              var q = new Image();
              q.src = b;
              p.width = q.width;
              p.height = q.height;
              v.drawImage(q, 0, 0);
              var d = v.getImageData(0, 0, p.width, p.height);
              for (var t = 0; t < d.height; t++) {
                for (var u = 0; u < d.width; u++) {
                  var r = (t * 4) * d.width + u * 4;
                  var s = (d.data[r] + d.data[r + 1] + d.data[r + 2]) / 3;
                  d.data[r] = s;
                  d.data[r + 1] = s;
                  d.data[r + 2] = s
                }
              }
              v.putImageData(d, 0, 0, 0, 0, d.width, d.height);
              return p.toDataURL()
            }
          }
        }
        if (!Modernizr.cssfilters) {
          var e = $(".grayscale img"), c = e.length, a = 0;
          e.one("load", function () {
            a++;
            if (a == c) {
              grayscale($(".grayscale img"));
              $(".grayscale img").hover(function () {
                grayscale.reset($(this))
              }, function () {
                grayscale($(this))
              })
            }
          }).each(function () {
            if (this.complete) {
              $(this).trigger("load")
            }
          })
        }
      });
    }
  };

})(jQuery, Drupal);
