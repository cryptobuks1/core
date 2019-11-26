! function(t) {
    t(".see-more").click(function() {
        var e = t(this),
            n = t(e.attr("href"));
        n.find(".card-cont").removeClass("hidden-sm"), n.find(".card-cont").removeClass("hidden-xs"), e.hide()
    }), t(document).ready(function() {
        function e() { l || (l = t(".tab-pane.active").find(".card"), d = 0, r = l.length > S ? S : l.length), l[d].className && t(l[d]).addClass("rotate-in"), d += 1, d < r ? setTimeout(function() { e() }, 100) : l = null }

        function n(e) { t(".testimonial-holder.active").addClass("inactive"), p.removeClass("active"), t(b[e]).addClass("active"), t(p[e]).addClass("active") }

        function a(e) { e = t(e), e.addClass("no-transition").removeClass("active inactive"), setTimeout(function() { e.removeClass("no-transition") }, 20) }

        function i() {
            var t = C[I],
                n = document.createElement("img");
            n.src = t, k.append(n), I += 1, I === S && m === !1 && (e(), m = !0), I < C.length && setTimeout(function() { i() }, w)
        }

        function o() { u = setInterval(function() { g || (n(v), v += 1, v > 2 && (v = 0)) }, 1e4) }

        function c() { clearInterval(u), g = !0 }

        function s(e) {
            var n;
            switch (!0) {
                case null !== typeof e && e === !0:
                    n = t(".tab-pane"), E = !0;
                    break;
                case E === !1:
                    n = t(".tab-pane.active");
                    break;
                default:
                    n = t(".tab-pane:not(.active)")
            }
            C = [], n.each(function(e, n) { t(n).find("img").each(function(e, n) { if (C.push(t(n).data("src")), e >= S - 1) return !1 }) }), i()
        }
        var r, u, d = 0,
            l = null,
            m = !1,
            h = t(document),
            f = {},
            v = 1,
            p = t(".ticker div"),
            g = !1,
            b = t(".testimonial-holder"),
            C = [],
            k = t("#image-preloader"),
            w = 20,
            E = !1,
            T = !0,
            y = t("#top-courses"),
            // I = (y.offset().top - .75 * y.height(), 0),
            N = window.innerWidth > 0 ? window.innerWidth : screen.width,
            S = N >= 1024 ? 8 : 4;
        t("#autocomplete-results");

        h.on("click", ".tabs li a", function(n) {
            var a = t(n.target),
                i = t("#" + a[0].id.replace(/^lnk/, "btn"));
            t(".browse-all-cta.active").removeClass("active"), i.addClass("active"), l = null, e()
        }), h.on("click touch", ".ticker div", function() {
            var e = t(this);
            e.hasClass("active") || (n(parseInt(e.data("item"), 10)), v = parseInt(e.data("item"), 10) + 1, v = v > 2 ? 0 : v, c(), ("ontouchstart" in document.documentElement || "ontouchstart" in window) && setTimeout(function() { o() }, 1e4))
        })
    })
}(jQuery);
