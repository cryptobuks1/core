! function(e) {
    function t(t, n) { if (e.cookie) { var a = e.cookie(t); if (a && a.length) { var o = new RegExp("," + n + ",", "g");
                a.search(o) < 0 && e.cookie(t, a + n + ",,", { raw: !0, path: "/" }) } else e.cookie(t, "x," + n + ",,", { raw: !0, path: "/" }) } else { var i = readCookie(t),
                a = i; if (null != a) { var o = new RegExp("," + n + ",", "g");
                a.search(o) < 0 && createCookie(t, a + n + ",", null) } else createCookie(t, "x," + n + ",", null) } }

    function n(t) { var n = { UP: 38, DOWN: 40, PAGEUP: 33, PAGEDOWN: 34 },
            a = e(".autocomplete-results li.current"); switch (t.keyCode) {
            case n.UP:
            case n.DOWN:
            case n.PAGEUP:
            case n.PAGEDOWN:
                a && a.length && B.val(a.find("a .term").text()) } }

    function a(e) { var t = D.find(".recent-search-items li");
        t.length > 0 && 0 === e.length ? (D.show(), D.find(".recent-search").show(), D.find(".autocomplete-results").children().remove()) : 0 === t.length && 0 === e.length && D.hide() }

    function o(e) { if (P.find(".form-group").length > 0) var t = Math.round(P.find(".form-group").outerWidth(!0)); "undefined" != typeof D && D.length > 0 && (D.css("left", "auto"), D.css("width", e ? t : "100%"), D.css("max-height", e ? "auto" : j.height() - D.offset().top)) }

    function i(t) { if (t && t.Name && 0 !== t.Name.length) { var n = [],
                a = e.cookie("recentSearches"); if (a) try { n = JSON.parse(a) } catch (o) {} _.find(n, { Name: t.Name.toLowerCase() }) || (t.Name = t.Name.toLowerCase(), n.unshift(t), s(_.take(n, 3))) } }

    function s(t) { return t ? void e.cookie("recentSearches", JSON.stringify(t), { expires: 30, path: "/" }) : e.removeCookie("recentSearches", { path: "/" }) }

    function r(t) { N.toggleClass("nav-opened"), t = e(t ? t : "#toggle-sidenav"), t.toggleClass("close-it"), T.hasClass("show-search") && T.removeClass("show-search") }

    function u() { return window.innerWidth > 1023 || W }

    function l(t) { return t && !U ? void e.get("/ajax/header/library", function(t) { if (t && t.html && 0 !== t.html.length) { U = !0; var n = e("#library-menu");
                n.find(".menu-items").html(t.html), n.find(".menu-table .arrow").removeClass("hide") } }).always(function() { m(), c(), g(), E(), h() }) : (c(), m(), g(), h(), void(U || E())) }

    function c() { var t = e(".main-subjects ul"),
            n = u();
        n ? (t.find("li").unbind("mouseenter").unbind("mouseleave"), t.find("li > a").attr("tabindex", "-1"), t.menuAim({ activate: f, deactivate: d }), f(".main-subjects ul > li:first-child")) : (t.find("li").unbind("mouseenter").unbind("mouseleave"), t.find("li > a").removeAttr("tabindex")) }

    function f(t) { e(t).siblings("li").removeClass("active"), e(t).siblings("li").find("button").attr("tabindex", "-1").attr("aria-selected", "false"), e(".subject-details").removeClass("active").attr("aria-hidden", "true"), e(t).addClass("active"), e(t).find("button").removeAttr("tabindex").attr("aria-selected", "true"); var n = e("> a", e(t)).data("details");
        e(n).addClass("active").attr("aria-hidden", "false") }

    function d(t) { e(t).removeClass("active"); var n = e("> a", e(t)).data("details");
        e(n).removeClass("active") }

    function g() { var e = window.innerHeight,
            t = u();
        t ? A.removeAttr("style") : A.height(e) }

    function h() { if (e("#submenu-search").length) { var t = u();
            t && !R ? (N.hasClass("member") && e("#submenu-profile").length ? e("#submenu-search").insertBefore("#submenu-profile") : e("#submenu-login").length && e("#submenu-search").insertBefore("#submenu-login"), R = !0, S = !1) : t || !e("#toggle-search").length || S || (e("#submenu-search").insertBefore("#toggle-search"), R = !1, S = !0) } }

    function m() { var t = u();
        t ? (e("#eyebrow .popover-trigger").removeClass("opened"), T.off("mouseenter", "#eyebrow .popover-trigger", b).on("mouseenter", "#eyebrow .popover-trigger", b).off("mouseleave", "#eyebrow .popover-trigger", v).on("mouseleave", "#eyebrow .popover-trigger", v), T.off("keypress", "#eyebrow .submenu-toggle", p).on("keypress", "#eyebrow .submenu-toggle", p).off("click", "#eyebrow .submenu-toggle", y).on("click", "#eyebrow .submenu-toggle", y), T.off("focus", "#eyebrow, .page-main, #main-content", w).on("focus", "#eyebrow, .page-main, #main-content", w)) : (k(), C()) }

    function b(t) { var n = e("keypress" === t.type || "click" === t.type ? e(t.target).hasClass("submenu-toggle") ? t.target : e(t.target).closest(".submenu-toggle") : this),
            a = e(n.find(".popover"));
        n.hasClass("submenu-toggle-cont") ? n = e(n.find(".submenu-toggle")) : n.hasClass("submenu-toggle") && (a = e(n.siblings(".popover"))), n.addClass("active").attr("aria-expanded", "true"); var o = !1; if (a.data("timeout") && (clearTimeout(a.data("timeout")), a.data("timeout", 0)), e(".popover").each(function(t, n) { return n = e(n), n[0].id === a[0].id && n.is(":visible") ? (o = !0, !0) : void n.hide() }), e("#autocomplete-results").hide(), !o) { var i = setTimeout(function() { a.show() }, 300);
            a.data("timeout", i) } }

    function v(t, n) { var a = "undefined" != typeof n ? n : e("keypress" === t.type ? e(t.target).hasClass("submenu-toggle") ? t.target : e(t.target).closest(".submenu-toggle") : this),
            o = e(a.find(".popover"));
        a.hasClass("submenu-toggle-cont") ? a = e(a.find(".submenu-toggle")) : a.hasClass("submenu-toggle") && (o = e(a.siblings(".popover"))), a.removeClass("active").attr("aria-expanded", "false"), o.data("timeout") && (clearTimeout(o.data("timeout")), o.data("timeout", 0)); var i = setTimeout(function() { o.hide() }, 300);
        o.data("timeout", i) }

    function p(e) { e.keyCode === O.ENTER && y(e) }

    function y(t) { var n = e(t.target),
            a = e(n.siblings(".popover"));
        a.is(":visible") ? v(t) : b(t) }

    function w(t) { var n = e(t.target),
            a = n.parents(".popover-trigger");
        (n.length && n.hasClass("submenu-toggle") || 0 == a.length) && e("#eyebrow .popover-trigger").each(function() { e(this).trigger("mouseleave") }) }

    function k() { T.off("mouseenter", "#eyebrow .popover-trigger", b).off("mouseleave", "#eyebrow .popover-trigger", v), e("#eyebrow .popover").removeAttr("style") }

    function C() { T.off("click", ".submenu-toggle", x).on("click", ".submenu-toggle", x) }

    function x(t) { e(this).parent(".submenu-toggle-cont").toggleClass("opened") }

    function E() { if (!I) { var t = e("#eyebrow .main-subjects ul");
            e("#submenu-library").on("keydown", function(n) { var a = e(this).attr("id"); if (a && a.length > 0) switch (n.which) {
                    case O.UP:
                    case O.DOWN:
                        var o = n.which === O.UP ? -1 : 1; if ("browse-library" === n.target.id || "submenu-library" !== a || "submenu-library" === a && n.target.classList.contains("submenu-expand")) "submenu-library" === a && t.trigger("libraryMenu.selection.change", o);
                        else if (e(n.target).parents(".subject-details").length > 0) { var i = e(n.target),
                                s = i.parents(".subject-details"),
                                r = s.find("a"),
                                u = r.length,
                                l = r.index(i);
                            1 === o ? (l + 1 === u && r[0].focus(), r.filter(":gt(" + l + "):first").focus()) : r.filter(":lt(" + l + "):last").focus() } return !1;
                    case O.TAB:
                        if (n.shiftKey && "submenu-library" === n.target.id) return !0; if ("submenu-library" === a) { if (n.shiftKey && n.target === e(".subject-details:visible a").first()[0]) return n.preventDefault(), t.find(".active").find("button").focus(), !1; if (!n.shiftKey && n.target === e(".subject-details:visible a").last()[0]) return n.preventDefault(), e(".subject-details:visible a:first").focus(), !1 } break;
                    case O.ENTER:
                    case O.RIGHT:
                        if (n.target.classList.contains("submenu-expand")) return e(".subject-details:visible a:first").focus(), !1; if (n.which === O.RIGHT && e(n.target).parents(".subject-details")) return !1; break;
                    case O.ESCAPE:
                    case O.LEFT:
                        if ("submenu-library" !== a || "browse-library" === n.target.id || n.target.classList.contains("submenu-expand")) { if (n.which === O.LEFT && e(n.target).parents(".subject-details")) return !1;
                            n.which !== O.LEFT && (v(n, e("#" + a)), e("#browse-library").focus()) } else e(".main-subjects li.active > button").focus(); return !1 } }), e("#submenu-account").on("keydown", function(t) { t.which === O.ESCAPE && (v(t, e("#submenu-account")), e("#submenu-profile-list").focus()) }), t.on("libraryMenu.selection.change", function(n, a) { var o = t.find(".active"),
                    i = t.find(":focus"); if (0 === i.length) o.find("button").focus();
                else { var s = t.find("li"); if (0 === s.index(o) && a === -1) return v(n, e("#submenu-library")), e("#browse-library").focus(), !1; if (s.index(o) == s.length - 1 && a > 0) var r = s.eq(0);
                    else var r = s.eq(s.index(o) + a);
                    f(r), e("button", r).focus() } }), I = !0 } } var N = e("html"),
        T = e("body"),
        j = e(window),
        A = e("#submenu-left"),
        P = (e("header"), e("#submenu-search")),
        L = e("#toggle-sidenav"),
        B = e("#header-search-field"),
        D = e("#autocomplete-results"),
        O = { ENTER: 13, UP: 38, DOWN: 40, LEFT: 37, RIGHT: 39, ESCAPE: 27, TAB: 9 },
        R = !1,
        S = !1,
        W = N.hasClass("logged-in-page") || N.hasClass("logged-out-page"); if (e(".close-cookie-banner").click(function() { var n = e(this),
                a = n.closest(".modal");
            e("#cookieConsentModal").modal("hide"), e(".cookie-content-banner").hide(); var o = a.attr("id") || "cookieConsentModal";
            o && t("cookieBanner", o) }), e.cookie) void 0 === e.cookie("cookieBanner") && e(".cookie-content-banner").removeClass("hide");
    else { var G = readCookie("cookieBanner");
        null == G && e(".cookie-content-banner").removeClass("hide") } e(".alert-banner .close-alert").click(function() { var n = e(this),
            a = n.closest(".alert-banner").hide();
        e(".top-cta").removeClass("no-top-spacing"); var o = a.attr("id");
        o && (o = o.replace("ams", ""), t("amkey", o)) }), T.on("autocomplete.show", function(e) { o(u()), a(B.val()) }), T.on("autocomplete.input", function(e, t) { a(t) }), T.on("autocomplete.blur", function() { D.hide() }), T.on("autocomplete.submit", function(e) { "undefined" != typeof _ && i({ Name: B.val() }) }), T.on("autocomplete.selection.click", function(t, n) { n = e(n); var a = { Name: n.text() },
            o = n.data("type");
        o && (a.Type = o); var s = n.data("id");
        s && (a.Id = +s), "undefined" != typeof _ && i(a) }), D.on("click", ".recent-search-clear", function() { D.find(".recent-search-items li").remove(), D.find(".recent-search").hide(), "undefined" != typeof _ && s(null) }), "undefined" != typeof _ ? B.on("keydown", _.debounce(function(t) { n(t), e(".autocomplete-results li a").attr("aria-selected", !1) }, 100)) : "undefined" != typeof debounce && B.on("keydown", debounce(function(t) { n(t), e(".autocomplete-results li a").attr("aria-selected", !1) }, 100)), e("#cover-wrapper").on("click", function() { r() }), L.on("click", function() { r(this) }), e("#toggle-search").on("click", function() { T.toggleClass("show-search"), T.hasClass("show-search") && B.focus() }), "ontouchstart" in window && e(".disable-link").attr("href", "javascript:void(0)"), j.resize(function() { var e = u();
        l(), e && (T.removeClass("show-search"), L.removeClass("close-it"), N.hasClass("nav-opened") && N.removeClass("nav-opened")), o(e) }); var U = !1;
    aquathar.isLoggedIn ? l(!0) : l(); var I = !1 }(jQuery);
! function(e) {
    function o(o) { e(o).find("input:not([type=hidden])").val(""), e(o).find("button[type=submit]").attr("disabled", "disabled").addClass("disabled"), e(o).find("textarea").val(""), e(".form-group.filled").removeClass("filled"), e(".form-group.has-error").removeClass("has-error"), e(".help-block").html("") }

    function a() { var e = !!navigator.cookieEnabled; return "undefined" != typeof navigator.cookieEnabled || e || (document.cookie = "testcookie", e = document.cookie.indexOf("testcookie") != -1), e }

    function i() { e("#feedback-success, #feedback-failure").hide().addClass("hide"), b.find("fieldset").show().removeClass("hide"), e(".feedback-footer").show(), o("#feedback-footer-form") } var t = e("body");
    t.on("click", "#back-to-top", function() { e(window).scrollTop(0) }); var r = e("#active-library"),
        d = e("#footerLibraryEN"),
        n = e("#footerLibraryDE"),
        s = e("#footerLibraryES"),
        l = e("#footerLibraryFR"),
        f = e("#footerLibraryEN, #footerLibraryDE, #footerLibraryES, #footerLibraryFR"); if (r.length > 0) { var c = r.val(); switch (f.removeClass("inactive-link"), d.attr("href", window.location.protocol + "//" + window.location.host), n.attr("href", window.location.protocol + "//" + window.location.host + "/de"), s.attr("href", window.location.protocol + "//" + window.location.host + "/es"), l.attr("href", window.location.protocol + "//" + window.location.host + "/fr"), c) {
            case "en":
                d.addClass("active-library inactive-link"), d.attr("href", ""); break;
            case "de":
                n.addClass("active-library inactive-link"), n.attr("href", ""); break;
            case "es":
                s.addClass("active-library inactive-link"), s.attr("href", ""); break;
            case "fr":
                l.addClass("active-library inactive-link"), l.attr("href", "") } } var b = e("#feedback-footer-form"),
        h = a() ? "1" : "0";
    b.find("#feedback-failure span").click(i), b.find(".close").click(function() { e("#feedback-footer-modal").modal("hide") }), e("#feedback-footer-modal").on("hide.bs.modal", i), e("#screen-resolution").val(screen.width + "x" + screen.height), e("#cookies-enabled").val(h), b.length && "function" == typeof b.validator && b.validator().on("input.bs.validator change.bs.validator focusout.bs.validator", function(o, a) { e("body").trigger("form.updateSubmit", "#feedback-footer-form") }).on("submit", function(o) { o.preventDefault(), e(this).find("button[type=submit]").attr("disabled", "disabled").addClass("disabled"), e.post("/ajax/support/feedback", e(this).serialize()).done(function(o) { b.find("fieldset").hide().addClass("hide"), e(".feedback-footer").hide(), "OK" == o.Status ? e("#feedback-success").removeClass("hide").show() : e("#feedback-failure").removeClass("hide").show() }).fail(function() { b.find("fieldset").hide().addClass("hide"), e(".feedback-footer").hide(), e("#feedback-failure").removeClass("hide").show() }) }) }(jQuery);
var lynda = lynda || {};
lynda.webTrackingTransport = { AJAX_METHOD: "POST", DEFAULT_PAGE_TYPE: "ajax", globalTrackingUrl: null, globalTrackingAppId: "no.app.id", lastDisplayMetric: null, lastActionMetric: null, queue: [], maxQueueSize: 1, queueTimeout: 1e3, timeoutId: null, csrfToken: "", setProperty: function(e, t) { if (t) return void(this[e] = t); var n = this.getMetaTag(e); return n ? void(this[e] = n.content) : void 0 }, setTrackingUrl: function(e) { this.setProperty("globalTrackingUrl", e) }, setAppId: function(e) { this.setProperty("globalTrackingAppId", e) }, setCsrfToken: function(e) { this.setProperty("csrfToken", e) }, getCookieString: function() { return document.cookie }, getCsrfToken: function() { for (var e = "JSESSIONID=", t = this.getCookieString().split(";"), n = 0; n < t.length; n++) { for (var r = t[n];
                " " === r.charAt(0);) r = r.substring(1); if (r.indexOf(e) !== -1) { var i = r.substring(e.length, r.length); return '"' === i[0] && '"' === i[i.length - 1] && (i = i.substring(1, i.length - 1)), i } } return "" }, createXmlHttpObject: function() { try { return new XMLHttpRequest } catch (e) {} return null }, ajax: function(e, t, n) { var r; return this.globalTrackingUrl ? (r = this.createXmlHttpObject(), void(r && (r.open(this.AJAX_METHOD, this.globalTrackingUrl, !0), r.withCredentials = !0, r.setRequestHeader("Content-type", "application/json"), this.csrfToken ? r.setRequestHeader("Csrf-Token", this.csrfToken) : r.setRequestHeader("Csrf-Token", this.getCsrfToken()), r.onreadystatechange = function() { if (4 === r.readyState) return 200 !== r.status && 304 !== r.status ? void(n && n("Request returned " + r.status)) : void("function" == typeof t && t(r)) }, 4 !== r.readyState && r.send(e)))) : void(n && n("Tracking url is not defined")) }, flush: function() { var e = this;
        this.ajax(JSON.stringify(this.queue), null, e.logError), this.queue = [], clearTimeout(this.timeoutId), this.timeoutId = null }, addToQueue: function(e) { if (this.queue.push(e), this.queue.length >= this.maxQueueSize) return this.flush(); if (!this.timeoutId) { var t = this;
            this.timeoutId = setTimeout(function() { t.flush() }, this.queueTimeout) } }, track: function(e) { return "object" != typeof e ? void this.logError("Track data must be an object") : (e = this.fillMissingData(e), void this.addToQueue(e)) }, trackWithCallback: function(e, t) { var n = this; if ("object" != typeof e) return void this.logError("Track data must be an object");
        e = this.fillMissingData(e); var r = JSON.stringify(e);
        this.ajax(r, function(e) { "function" == typeof t && t(null, e.responseText) }, function(e) { n.logError(e), "function" == typeof t && t(e) }) }, getTimestamp: function() { return Math.round((new Date).getTime() / 1e3) }, getTrackingCode: function(e) { return e.eventBody.trackingCode ? e.eventBody.trackingCode : "PageViewEvent" === e.eventInfo.eventName ? "full" === e.eventBody.pageType ? (this.lastDisplayMetric = e.eventBody.requestHeader.pageKey, this.lastActionMetric) : (this.lastActionMetric = e.eventBody.requestHeader.pageKey, this.lastDisplayMetric) : null }, fillMissingData: function(e) { if (!e.eventInfo) return this.logError("You must specify eventInfo"); if (e.eventInfo.appId || (e.eventInfo.appId = this.globalTrackingAppId), !e.eventBody) return this.logError("You must specify eventBody"); var t = this.getTrackingCode(e);
        null != t && (e.eventBody.trackingCode = t); var n = e.eventBody.trackingInfo || {};
        n.clientTimestamp || (n.clientTimestamp = this.getTimestamp()), e.eventBody.trackingInfo = n; var r = e.eventBody.requestHeader || {}; return r.pageKey || (r.pageKey = this.lastDisplayMetric), e.eventBody.requestHeader = r, e }, trackPageView: function(e) { var t, n, r, i; "string" == typeof e ? (t = e, i = this.DEFAULT_PAGE_TYPE) : (t = e.pageKey, i = e.pageType || this.DEFAULT_PAGE_TYPE, n = e.trackingCode, r = e.trackingInfo); var o = { eventInfo: { eventName: "PageViewEvent" }, eventBody: { requestHeader: { pageKey: t }, pageType: i } }; return n && (o.eventBody.trackingCode = n), r && (o.eventBody.trackingInfo = r), t ? void this.track(o) : this.logError("You must provide a pageKey") }, trackUnifiedAction: function(e) { if (!e.action) return this.logError("You must provide action"); if (!e.sponsoredFlag) return this.logError("You must provide sponsoredFlag"); var t = { eventInfo: { eventName: "UnifiedActionEvent" }, eventBody: e };
        this.track(t) }, trackArticleView: function(e) { if (!e.articleId) return this.logError("You must provide articleId"); var t = { eventInfo: { eventName: "ArticleViewEvent" }, eventBody: e };
        this.track(t) }, trackUnifiedImpression: function(e) { if (!e.results) return this.logError("You must provide results"); var t = { eventInfo: { eventName: "UnifiedImpressionEvent" }, eventBody: e };
        this.track(t) }, logError: function(e) { var t = window.console;
        t && t.error && t.error(e) }, getMetaTag: function(e) { var t, n, r, i = document.getElementById(e) || document.querySelector && document.querySelector("meta[name=" + e + "]"); if (i) return i; for (t = document.getElementsByTagName("meta"), r = t.length, n = 0; n < r; n++)
            if (t[n].getAttribute("name") === e) return t[n]; return null }, populateEventInfo: function(e) { return "string" == typeof e && (e = { eventName: e }), e && "object" == typeof e ? (e.appId || (e.appId = this.globalTrackingAppId), e) : (this.logError("Event info must be object"), {}) }, populateEventHeaders: function(e) { return e && "object" == typeof e ? e : (this.logError("Event body must be object"), {}) }, sendEvent: function(e, t) { this.addToQueue({ eventInfo: this.populateEventInfo(e), eventBody: this.populateEventHeaders(t) }) }, init: function() { this.setTrackingUrl(), this.setAppId() } }, lynda.webTrackingTransport.init();

function setupBrowser() { var n = _window.crypto || _window.msCrypto; if (!_rng && n && n.getRandomValues) try { var r = new Uint8Array(16);
        _whatwgRNG = _rng = function() { return n.getRandomValues(r), r }, _rng() } catch (e) {}
    if (!_rng) { var u = new Array(16);
        _mathRNG = _rng = function() { for (var n, r = 0; r < 16; r++) 0 === (3 & r) && (n = 4294967296 * Math.random()), u[r] = n >>> ((3 & r) << 3) & 255; return u }, "undefined" != typeof console && console.warn && console.warn("[SECURITY] node-uuid: crypto not usable, falling back to insecure Math.random()") } }

function setupNode() { if ("function" == typeof require) try { var n = require("crypto").randomBytes;
        _nodeRNG = _rng = n && function() { return n(16) }, _rng() } catch (r) {} }

function unparse(n, r) { var e = r || 0,
        u = _byteToHex; return u[n[e++]] + u[n[e++]] + u[n[e++]] + u[n[e++]] + "-" + u[n[e++]] + u[n[e++]] + "-" + u[n[e++]] + u[n[e++]] + "-" + u[n[e++]] + u[n[e++]] + "-" + u[n[e++]] + u[n[e++]] + u[n[e++]] + u[n[e++]] + u[n[e++]] + u[n[e++]] }

function v4(n, r, e) { var u = r && e || 0; "string" == typeof n && (r = "binary" === n ? new BufferClass(16) : null, n = null), n = n || {}; var o = n.random || (n.rng || _rng)(); if (o[6] = 15 & o[6] | 64, o[8] = 63 & o[8] | 128, r)
        for (var t = 0; t < 16; t++) r[u + t] = o[t]; return r || unparse(o) }
var _rng, _mathRNG, _nodeRNG, _whatwgRNG, _window = "undefined" != typeof window ? window : null;
_window ? setupBrowser() : setupNode();
for (var BufferClass = "function" == typeof Buffer ? Buffer : Array, _byteToHex = [], _hexToByte = {}, i = 0; i < 256; i++) _byteToHex[i] = (i + 256).toString(16).substr(1), _hexToByte[_byteToHex[i]] = i;
var uuid = v4;
uuid.v4 = v4, uuid.unparse = unparse, uuid.BufferClass = BufferClass, uuid._rng = _rng, uuid._mathRNG = _mathRNG, uuid._nodeRNG = _nodeRNG, uuid._whatwgRNG = _whatwgRNG, void 0 != lynda && (lynda.uuid = uuid);
! function(e) {
    function n(e, n) { if (n) { var a = t();
            a && window.sessionStorage.setItem("pageTrackingId", a), r("PageViewEvent", g = n) } }

    function a(e, n, a, t) { n && r(n, g, a, t) }

    function r(n, a, r, t) { var i = { eventInfo: { appId: o, appName: c, eventName: n, topicName: "Lynda" + n }, eventBody: { header: {}, requestHeader: { pageKey: a, path: window.location.href, referer: document.referrer, sessionId: u, browserId: y }, totalTime: -1, pageType: "ajax", trackingInfo: { clientTimestamp: "-1" } } }; "undefined" != typeof t && (i.eventInfo.topicName = t), r && (i.eventBody = e.extend(i.eventBody, r)), p && "" != p && (i.eventBody.header.applicationViewerUrn = p), window.sessionStorage.getItem("pageTrackingId") && (i.eventBody.header.pageInstance = { pageUrn: "urn:li:page:" + a, trackingId: window.sessionStorage.getItem("pageTrackingId") }); var d = e.cookie("litracktestid"); "undefined" != typeof d && d.length > 0 && (i.eventBody.header.testId = d), lynda.webTrackingTransport.track(i) }

    function t() { var e = new Array(16); return lynda.uuid.v4(null, e), i(e) }

    function i(e) { for (var n, a = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/", r = [], t = 0, i = e.length, d = i % 3, o = i - d; t < o;) n = e[t] << 16, n |= e[t + 1] << 8, n |= e[t + 2], r.push(a.charAt(n >>> 18 & 63)), r.push(a.charAt(n >>> 12 & 63)), r.push(a.charAt(n >>> 6 & 63)), r.push(a.charAt(63 & n)), t += 3; switch (d) {
            case 2:
                n = e[t] << 16, n |= e[t + 1] << 8, r.push(a.charAt(n >>> 18 & 63)), r.push(a.charAt(n >>> 12 & 63)), r.push(a.charAt(n >>> 6 & 63)), r.push("="); break;
            case 1:
                n = e[t] << 16, r.push(a.charAt(n >>> 18 & 63)), r.push(a.charAt(n >>> 12 & 63)), r.push("="), r.push("=") } return r.join("") } if ("undefined" != typeof lynda) { var d = e("body"),
            o = "com.lynda.web",
            c = "com.lynda.web",
            s = !!lynda.jsTrackingEnabled,
            p = lynda.jsTrackingUserUrn,
            g = lynda.jsTrackingPageKey,
            l = lynda.jsTrackingUrl,
            u = lynda.sessionId,
            y = lynda.browserId;
        s && l && g && lynda.webTrackingTransport && lynda.webTrackingTransport.track && (lynda.webTrackingTransport.setTrackingUrl(l), d.bind("li.track.page", n), d.bind("li.track.action", a), n(null, g), lynda.generateTrackingId = t) } }(jQuery);
var trackingModule = function() { var e = {},
        n = function(n) { return e.useDefaultPageKey() || "undefined" == typeof n ? "undefined" != typeof lynda.jsRumTrackingPageKey ? lynda.jsRumTrackingPageKey : "" : $.isFunction(n) ? n() : n }; return e.sendPageKey = function(e) { "use strict"; if ("function" == typeof RumTracking) { var a = "",
                i = "0",
                t = ""; if ("undefined" != typeof lynda && ("undefined" != typeof lynda.rumTrackingEnabled && (i = lynda.rumTrackingEnabled), a = n(e), "undefined" != typeof lynda.rumTrackingAppId && (t = lynda.rumTrackingAppId)), "undefined" != typeof a && "undefined" != typeof i && "1" == i) { var r = window.rumConfig || {};
                r["beacon-service"] = "tracking", r["navigation-timing-only"] = !0, r["is-single-page-app"] = !1, r["topic-name"] = "LyndaRealUserMonitoringEvent", r["beacon-url"] = "https://www.linkedin.com/lynda/tracking", r["app-id"] = t, r["enable-rs-timing"] = !0, r["rs-sample-rate"] = { "default": 0 }, r["request-sampling-rate"] = .05; var d = RumTracking(r);
                window.RUM2 = d, d.setPageKey(a) } } }, e.useDefaultPageKey = function() { return "undefined" == typeof lynda.jsTrackingPreventDefaultPageKey || !lynda.jsTrackingPreventDefaultPageKey }, e.useDefaultPageKey() && e.sendPageKey(), e }(trackingModule || {});
! function(a) {
    function e(a) { var e = a.closest("[data-ga-context] > *"); if (!e.length) return "";
        e = e.first(); var t = e.index() + 1,
            n = e.parent().data("gaContext"); return "Context " + n + ": Index " + t + ": " } var t = a("body"); if ("undefined" != typeof ga) { var n = a("[data-tracking-category]").data("trackingCategory");
        t.on("ga.event", function(a, e) { var t = { hitType: "event", eventCategory: e.category && e.category.length > 0 ? e.category : n, eventAction: e.action };
            e.label && (t.eventLabel = e.label), e.value && (t.eventValue = e.value), ga("send", t) }), t.on("ga.pageview", function(a, e) { ga("set", "page", e), ga("send", "pageview") }), t.on("click", ".ga", function(t) { var i = a(this),
                g = a(t.target).closest(".ga-no-bubble"); if ((!g.length || g.is(i)) && !i.hasClass("disabled") && !i.attr("disabled")) { var o = i.data("gaCategory"),
                    r = { hitType: "event", eventCategory: o && o.length > 0 ? o : n, eventAction: i.data("gaAction") }; if (i.data("gaLabel")) { r.eventLabel = i.data("gaLabel"); var l = i.closest("[data-tracking-context]");
                    l.length > 0 && (r.eventLabel += "-" + l.data("trackingContext")) } i.data("gaValue") && (r.eventValue = i.data("gaValue")), i.data("gaContextItem") || (r.eventLabel = e(i) + r.eventLabel), ga("send", r) } }), t.on("click", ".tl", function() { var e = a(this); if (!e.hasClass("disabled") && !e.attr("disabled")) try { var t = e.data("gaCategory"),
                    n = e.data("gaAction"),
                    i = e.data("gaLabel"),
                    g = e.data("gaType"),
                    o = e.data("gaPersona"); "undefined" != typeof i && "undefined" != typeof n && utag.link({ event_category: a.trim(t), event_action: a.trim(n), event_label: a.trim(i), event_type: a.trim(g), persona_kind: a.trim(o) }) } catch (r) {} }), t.on("li.track.impression", function(a, e, n) { t.trigger("ga.event", [{ action: "impression", label: e }]) }) } }(jQuery);
mejs.i18n.t = lynda.translate = function(n) { return lynda.translations && lynda.translations[n] || n };
! function(t) { MediaElementPlayer.prototype.buildcustomcc = function(a, n, c, i) { if (!t("html").hasClass("no-cc")) { var e = t(".mejs-captions-button button", n).append('<i class="lyndacon closed-captioning"></i>');
            e.attr("id", "player-cc"), e.attr("title", lynda.translate("Captions/Subtitles")) } } }(jQuery);
! function(t) { t.extend(mejs.MepDefaults, { startLanguage: "", tracksText: mejs.i18n.t("Captions/Subtitles"), hideCaptionsButtonWhenEmpty: !0, toggleCaptionsButtonWhenOnlyOne: !1, slidesSelector: "" }), t.extend(MediaElementPlayer.prototype, { hasChapters: !1, buildtracks: function(e, i, s, n) { if (0 !== e.tracks.length) { var a, o = this; if (o.domNode.textTracks)
                    for (a = o.domNode.textTracks.length - 1; a >= 0; a--) o.domNode.textTracks[a].mode = "hidden";
                e.chapters = t('<div class="mejs-chapters mejs-layer"></div>').prependTo(s).hide(), e.captions = t('<div class="mejs-captions-layer mejs-layer"><div class="mejs-captions-position mejs-captions-position-hover" role="log" aria-live="assertive" aria-atomic="false"><span class="mejs-captions-text"></span></div></div>').prependTo(s).hide(), e.captionsText = e.captions.find(".mejs-captions-text"), e.captionsButton = t('<div class="mejs-button mejs-captions-button"><button type="button" aria-controls="' + o.id + '" title="' + o.options.tracksText + '" aria-label="' + o.options.tracksText + '"></button><div class="mejs-captions-selector"><ul><li><input type="radio" name="' + e.id + '_captions" id="' + e.id + '_captions_none" value="none" checked="checked" /><label for="' + e.id + '_captions_none">' + mejs.i18n.t("None") + "</label></li></ul></div></div>").appendTo(i); var r = 0; for (a = 0; a < e.tracks.length; a++) "subtitles" == e.tracks[a].kind && r++; for (o.options.toggleCaptionsButtonWhenOnlyOne && 1 == r ? e.captionsButton.on("click", function() { t("body").trigger("ga.event", { action: "click", label: "player-cc-" + (e.captionsButton.find("i").hasClass("current") ? "off" : "on") }), e.container.toggleClass("show-captions"), null === e.selectedTrack ? lang = e.tracks[0].srclang : lang = "none", e.setTrack(lang) }) : (e.captionsButton.on("mouseenter focusin", function() { t(this).find(".mejs-captions-selector").css("visibility", "visible") }).on("click", "input[type=radio]", function() { lang = this.value, e.setTrack(lang) }), e.captionsButton.on("mouseleave focusout", function() { t(this).find(".mejs-captions-selector").css("visibility", "hidden") })), e.options.alwaysShowControls ? e.container.find(".mejs-captions-position").addClass("mejs-captions-position-hover") : e.container.bind("controlsshown", function() { e.container.find(".mejs-captions-position").addClass("mejs-captions-position-hover") }).bind("controlshidden", function() { n.paused || e.container.find(".mejs-captions-position").removeClass("mejs-captions-position-hover") }), e.trackToLoad = -1, e.selectedTrack = null, e.isLoadingTrack = !1, a = 0; a < e.tracks.length; a++) "subtitles" == e.tracks[a].kind && e.addTrackButton(e.tracks[a].srclang, e.tracks[a].label);
                e.loadNextTrack(), n.addEventListener("timeupdate", function(t) { e.displayCaptions() }, !1), "" !== e.options.slidesSelector && (e.slidesContainer = t(e.options.slidesSelector), n.addEventListener("timeupdate", function(t) { e.displaySlides() }, !1)), n.addEventListener("loadedmetadata", function(t) { e.displayChapters() }, !1), e.container.hover(function() { e.hasChapters && (e.chapters.css("visibility", "visible"), e.chapters.fadeIn(200).height(e.chapters.find(".mejs-chapter").outerHeight())) }, function() { e.hasChapters && !n.paused && e.chapters.fadeOut(200, function() { t(this).css("visibility", "hidden"), t(this).css("display", "block") }) }), null !== e.node.getAttribute("autoplay") && e.chapters.css("visibility", "hidden") } }, setTrack: function(e) { var i, s = this; if ("none" == e) s.selectedTrack = null, s.captionsButton && (s.captionsButton.removeClass("mejs-captions-enabled"), s.captionsButton.find("i").removeClass("current"), s.container.removeClass("show-captions"), s.captions.hide());
            else
                for (i = 0; i < s.tracks.length; i++)
                    if (s.tracks[i].srclang == e) { null === s.selectedTrack && s.captionsButton && (s.captionsButton.addClass("mejs-captions-enabled"), s.captionsButton.find("i").addClass("current"), s.container.addClass("show-captions")), s.selectedTrack = s.tracks[i], s.captions.attr("lang", s.selectedTrack.srclang), s.displayCaptions(); break } t(this.media).trigger("track.set", e) }, loadNextTrack: function() { var t = this;
            t.trackToLoad++, t.trackToLoad < t.tracks.length ? (t.isLoadingTrack = !0, t.loadTrack(t.trackToLoad)) : (t.isLoadingTrack = !1, t.checkForTracks()) }, loadTrack: function(e) { var i = this,
                s = i.tracks[e],
                n = function() { s.isLoaded = !0, i.enableTrackButton(s.srclang, s.label), i.loadNextTrack() };
            s.src && s.src.length ? t.ajax({ url: s.src, dataType: "text", success: function(t) { "string" == typeof t && /<tt\s+xml/gi.exec(t) ? s.entries = mejs.TrackFormatParser.dfxp.parse(t) : s.entries = mejs.TrackFormatParser.webvtt.parse(t), n(), "chapters" == s.kind && i.media.addEventListener("play", function(t) { i.media.duration > 0 && i.displayChapters(s) }, !1), "slides" == s.kind && i.setupSlides(s) }, error: function() { i.loadNextTrack() } }) : n() }, enableTrackButton: function(e, i) { var s = this; "" === i && (i = mejs.language.codes[e] || e), s.captionsButton.find("input[value=" + e + "]").prop("disabled", !1).siblings("label").html(i), s.options.startLanguage == e && t("#" + s.id + "_captions_" + e).prop("checked", !0).trigger("click"), s.adjustLanguageBox() }, addTrackButton: function(e, i) { var s = this; "" === i && (i = mejs.language.codes[e] || e), s.captionsButton.find("ul").append(t('<li><input type="radio" name="' + s.id + '_captions" id="' + s.id + "_captions_" + e + '" value="' + e + '" disabled="disabled" /><label for="' + s.id + "_captions_" + e + '">' + i + " (loading)</label></li>")), s.adjustLanguageBox(), s.container.find(".mejs-captions-translations option[value=" + e + "]").remove() }, adjustLanguageBox: function() { var t = this;
            t.captionsButton.find(".mejs-captions-selector").height(t.captionsButton.find(".mejs-captions-selector ul").outerHeight(!0) + t.captionsButton.find(".mejs-captions-translations").outerHeight(!0)) }, checkForTracks: function() { var t = this,
                e = !1; if (t.options.hideCaptionsButtonWhenEmpty) { for (i = 0; i < t.tracks.length; i++)
                    if ("subtitles" == t.tracks[i].kind) { e = !0; break } e || (t.captionsButton.hide(), t.setControlsSize()) } }, displayCaptions: function() { if ("undefined" != typeof this.tracks) { var t, e = this,
                    i = e.selectedTrack; if (null !== i && i.isLoaded) { for (t = 0; t < i.entries.times.length; t++)
                        if (e.media.currentTime >= i.entries.times[t].start && e.media.currentTime <= i.entries.times[t].stop) return e.captionsText.html(i.entries.text[t]).attr("class", "mejs-captions-text " + (i.entries.times[t].identifier || "")), void e.captions.show();
                    e.captions.hide() } else e.captions.hide() } }, setupSlides: function(t) { var e = this;
            e.slides = t, e.slides.entries.imgs = [e.slides.entries.text.length], e.showSlide(0) }, showSlide: function(e) { if ("undefined" != typeof this.tracks && "undefined" != typeof this.slidesContainer) { var i = this,
                    s = i.slides.entries.text[e],
                    n = i.slides.entries.imgs[e]; "undefined" == typeof n || "undefined" == typeof n.fadeIn ? i.slides.entries.imgs[e] = n = t('<img src="' + s + '">').on("load", function() { n.appendTo(i.slidesContainer).hide().fadeIn().siblings(":visible").fadeOut() }) : n.is(":visible") || n.is(":animated") || n.fadeIn().siblings(":visible").fadeOut() } }, displaySlides: function() { if ("undefined" != typeof this.slides) { var t, e = this,
                    i = e.slides; for (t = 0; t < i.entries.times.length; t++)
                    if (e.media.currentTime >= i.entries.times[t].start && e.media.currentTime <= i.entries.times[t].stop) return void e.showSlide(t) } }, displayChapters: function() { var t, e = this; for (t = 0; t < e.tracks.length; t++)
                if ("chapters" == e.tracks[t].kind && e.tracks[t].isLoaded) { e.drawChapters(e.tracks[t]), e.hasChapters = !0; break } }, drawChapters: function(e) { var i, s, n = this,
                a = 0,
                o = 0; for (n.chapters.empty(), i = 0; i < e.entries.times.length; i++) s = e.entries.times[i].stop - e.entries.times[i].start, a = Math.floor(s / n.media.duration * 100), (a + o > 100 || i == e.entries.times.length - 1 && a + o < 100) && (a = 100 - o), n.chapters.append(t('<div class="mejs-chapter" rel="' + e.entries.times[i].start + '" style="left: ' + o.toString() + "%;width: " + a.toString() + '%;"><div class="mejs-chapter-block' + (i == e.entries.times.length - 1 ? " mejs-chapter-block-last" : "") + '"><span class="ch-title">' + e.entries.text[i] + '</span><span class="ch-time">' + mejs.Utility.secondsToTimeCode(e.entries.times[i].start) + "&ndash;" + mejs.Utility.secondsToTimeCode(e.entries.times[i].stop) + "</span></div></div>")), o += a;
            n.chapters.find("div.mejs-chapter").click(function() { n.media.setCurrentTime(parseFloat(t(this).attr("rel"))), n.media.paused && n.media.play() }), n.chapters.show() } }), mejs.language = { codes: { af: "Afrikaans", sq: "Albanian", ar: "Arabic", be: "Belarusian", bg: "Bulgarian", ca: "Catalan", zh: "Chinese", "zh-cn": "Chinese Simplified", "zh-tw": "Chinese Traditional", hr: "Croatian", cs: "Czech", da: "Danish", nl: "Dutch", en: "English", et: "Estonian", fl: "Filipino", fi: "Finnish", fr: "French", gl: "Galician", de: "German", el: "Greek", ht: "Haitian Creole", iw: "Hebrew", hi: "Hindi", hu: "Hungarian", is: "Icelandic", id: "Indonesian", ga: "Irish", it: "Italian", ja: "Japanese", ko: "Korean", lv: "Latvian", lt: "Lithuanian", mk: "Macedonian", ms: "Malay", mt: "Maltese", no: "Norwegian", fa: "Persian", pl: "Polish", pt: "Portuguese", ro: "Romanian", ru: "Russian", sr: "Serbian", sk: "Slovak", sl: "Slovenian", es: "Spanish", sw: "Swahili", sv: "Swedish", tl: "Tagalog", th: "Thai", tr: "Turkish", uk: "Ukrainian", vi: "Vietnamese", cy: "Welsh", yi: "Yiddish" } }, mejs.TrackFormatParser = { webvtt: { pattern_timecode: /^((?:[0-9]{1,2}:)?[0-9]{2}:[0-9]{2}([,.][0-9]{1,3})?) --\> ((?:[0-9]{1,2}:)?[0-9]{2}:[0-9]{2}([,.][0-9]{3})?)(.*)$/, parse: function(e) { for (var i, s, n, a = 0, o = mejs.TrackFormatParser.split2(e, /\r?\n/), r = { text: [], times: [] }; a < o.length; a++) { if (i = this.pattern_timecode.exec(o[a]), i && a < o.length) { for (a - 1 >= 0 && "" !== o[a - 1] && (n = o[a - 1]), a++, s = o[a], a++;
                            "" !== o[a] && a < o.length;) s = s + "\n" + o[a], a++;
                        s = t.trim(s).replace(/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gi, "<a href='$1' target='_blank'>$1</a>"), r.text.push(s), r.times.push({ identifier: n, start: 0 === mejs.Utility.convertSMPTEtoSeconds(i[1]) ? .2 : mejs.Utility.convertSMPTEtoSeconds(i[1]), stop: mejs.Utility.convertSMPTEtoSeconds(i[3]), settings: i[5] }) } n = "" } return r } }, dfxp: { parse: function(e) { e = t(e).filter("tt"); var i, s, n = 0,
                    a = e.children("div").eq(0),
                    o = a.find("p"),
                    r = e.find("#" + a.attr("style")),
                    c = { text: [], times: [] }; if (r.length) { var l = r.removeAttr("id").get(0).attributes; if (l.length)
                        for (i = {}, n = 0; n < l.length; n++) i[l[n].name.split(":")[1]] = l[n].value } for (n = 0; n < o.length; n++) { var d, p = { start: null, stop: null, style: null }; if (o.eq(n).attr("begin") && (p.start = mejs.Utility.convertSMPTEtoSeconds(o.eq(n).attr("begin"))), !p.start && o.eq(n - 1).attr("end") && (p.start = mejs.Utility.convertSMPTEtoSeconds(o.eq(n - 1).attr("end"))), o.eq(n).attr("end") && (p.stop = mejs.Utility.convertSMPTEtoSeconds(o.eq(n).attr("end"))), !p.stop && o.eq(n + 1).attr("begin") && (p.stop = mejs.Utility.convertSMPTEtoSeconds(o.eq(n + 1).attr("begin"))), i) { d = ""; for (var h in i) d += h + ":" + i[h] + ";" } d && (p.style = d), 0 === p.start && (p.start = .2), c.times.push(p), s = t.trim(o.eq(n).html()).replace(/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gi, "<a href='$1' target='_blank'>$1</a>"), c.text.push(s), 0 === c.times.start && (c.times.start = 2) } return c } }, split2: function(t, e) { return t.split(e) } }, 3 != "x\n\ny".split(/\n/gi).length && (mejs.TrackFormatParser.split2 = function(t, e) { var i, s = [],
            n = ""; for (i = 0; i < t.length; i++) n += t.substring(i, i + 1), e.test(n) && (s.push(n.replace(e, "")), n = ""); return s.push(n), s }) }(mejs.$);
! function(e) {
    function a(a) { e('.lyndacon.code[data-ga-value="' + a + '"]').length > 0 ? e(".mejs-button.mejs-code-practice").removeClass("hide").show() : e(".mejs-button.mejs-code-practice").hide() } MediaElementPlayer.prototype.buildcodepractice = function(t, c, i, n) { var o = e("body"); if (e("html").hasClass("inline-codepractice")) { var d = lynda.translate("Launch Practice"),
                l = lynda.translate("Practice code alongside the video"),
                r = +e("#course-page").data("initialVideoId");
            e('<div class="mejs-button mejs-code-practice hide"><button id="player-code-practice" class="launch-code-practice ga" data-ga-action="click" data-ga-label="player-practicelaunch" data-src="PlayerButton" type="button" aria-controls="' + this.id + '" aria-label="' + d + '" title="' + l + '"><span class="hidden-xs">' + d + "</span></button></div>").appendTo(c), o.trigger("ga.event", { action: "impression", label: "player-practiceenvironment" }), o.on("course.video.change", function(e, t, c, i) { a(c) }), a(r) } } }(jQuery);
! function(e) { MediaElementPlayer.prototype.buildcustomendplate = function(t, n, o, a) { var d = e("#endplate-temp"),
            l = d.html();
        d.remove(), t.customendplate = e(l).prependTo(o).hide(), e("body").on("course.video.showendplate", function() { var n = e("#nonmember-endplate-temp");
            n.length && (e("#endplate-placeholder").html(n.html()), n.remove()); var o = n.data("endplateLabel");
            e("body").trigger("ga.event", { action: "show", label: o }), t.customendplate.css({ display: "block" }), setTimeout(function() { t.customendplate.addClass("fadeIn") }, 20), e("body").trigger("lazy.init") }), e("body").on("course.video.hideendplate", function() { t.customendplate.css({ display: "none" }) }), e(a).on("play playing", function() { t.customendplate.hide().removeClass("fadeIn") }) } }(jQuery);
! function(e) { MediaElementPlayer.prototype.buildcustomfullscreen = function(l, n, a, t) { var i = e(".mejs-fullscreen-button button", n).append('<i class="lyndacon player-minimize-full-screen"></i><i class="lyndacon player-maximize-full-screen"></i>');
        i.attr("id", "player-fs"), i.attr("title", lynda.translate("Full screen (f)")), i.on("click", function() { e(".mejs-settings-layer,.mejs-playback-rate-layer").hide(), e("body").trigger("ga.event", { action: "click", label: "player-full-screen" }), e("#video-container").focus() }) } }(jQuery);
! function(e) { MediaElementPlayer.prototype.buildnext = function(t, n, a, i) { var l = lynda.translate("Next Video (l)");
        e('<div class="mejs-button mejs-next-button"><button id="player-next" type="button" aria-controls="' + this.id + '" aria-label="' + l + '" title="' + l + '" disabled="disabled"><i class="lyndacon player-next-video"></i></button></div>').appendTo(n).click(function() { e("#player-next:disabled").length || (e("body").trigger("ga.event", { action: "click", label: "player-next" }), e(i).trigger("next", t)) }) } }(jQuery);
! function(a) { MediaElementPlayer.prototype.buildcustomplaypause = function(e, p, l, t) {
        function s(a) { "play" === a ? y.removeClass("player-play").addClass("player-pause") : y.removeClass("player-pause").addClass("player-play"); var e = "play" === a ? lynda.translate("Pause (spacebar)") : lynda.translate("Play (spacebar)");
            n.attr({ title: e, "aria-label": e }) } var n = a(".mejs-playpause-button button", p).append('<i class="lyndacon player-pause"></i>');
        n.attr("id", "player-playpause"); var y = a(".mejs-playpause-button button i");
        this.options.playText, this.options.pauseText;
        s("pse"), n.on("click", function() { a("body").trigger("ga.event", { action: "click", label: "player-" + (t.paused ? "play" : "pause") }) }), a(t).on("play playing", function() { s("play") }), a(t).on("pause paused", function() { s("pse") }) } }(jQuery);
! function(t) { MediaElementPlayer.prototype.buildcustompopout = function(o, e, n, i) { var a = lynda.translate("The video is currently playing in a different window."),
            p = lynda.translate("Play video here instead"),
            s = lynda.translate("Popout Video (p)");
        o.customPopoutPanel = t('<div class="mejs-popout-layer mejs-layer"><div class="mejs-popout-layer-content popout">' + a + '<br><button id="btn-closePopout" type="button" class="btn btn-secondary "><i class="lyndacon"></i> <span>' + p + "</span></button></div></div>").prependTo(n).hide(), t('<div class="mejs-settings-section popout"><div class="mejs-button mejs-popout-button"><button id="player-popout" type="button" aria-controls="' + this.id + '" aria-label="' + s + '"><i class="lyndacon player-pop-out"></i>' + s + "</button></div></div>").appendTo(".mejs-settings-position").click(function() { t(".mejs-settings-layer").hide(), t("body").trigger("ga.event", { action: "click", label: "player-popout-open" }), t(i).trigger("popout", o) }), t("body").on("click", "#btn-closePopout", function() { t("body").trigger("ga.event", { action: "click", label: "player-popout-close" }), t(i).trigger("popoutClose", o) }) } }(jQuery);
! function(e) { MediaElementPlayer.prototype.buildcustompostroll = function(o, l, t, n) { var r = this.container;
        o.custompostroll = e("#postroll-template").remove().children().prependTo(t).hide(), element = e(n), element.on("showpostroll", function(l, n) { n = n || r.find('link[rel="postroll"]').attr("href"), n && e.ajax({ url: n, headers: { offset: (new Date).getTimezoneOffset() }, type: "POST" }).done(function(l) { e("body").trigger("ga.event", { action: "show", label: "player-postroll" }), o.custompostroll.show(), o.pause(), t.find(".mejs-postroll-layer-content").html(l.html), element.addClass("has-postroll"), element.trigger("postroll.show") }) }), element.on("play playing hidepostroll", function() { element.removeClass("has-postroll"), o.custompostroll.hide(), t.find(".mejs-postroll-layer-content").html("") }) } }(jQuery);
! function(e) { MediaElementPlayer.prototype.buildprevious = function(i, t, a, l) { var o = lynda.translate("Previous Video (j)");
        e('<div class="mejs-button mejs-previous-button"><button id="player-previous" type="button" aria-controls="' + this.id + '" aria-label="' + o + '" title="' + o + '" disabled="disabled"><i class="lyndacon player-prev-video"></i></button></div>').appendTo(t).click(function() { e("#player-previous:disabled").length || (e("body").trigger("ga.event", { action: "click", label: "player-back" }), e(l).trigger("previous")) }) } }(jQuery);
! function(a) { a.extend(mejs.MepDefaults, { playbackSpeed: 1, videoQuality: 540, continuousPlay: !0 }), a.extend(MediaElementPlayer.prototype, { buildsettings: function(t, e, i, s) {
            function l() { var t = a.cookie("player"); if (t) return JSON.parse(t) }

            function n(t, e) { e && e.stopPropagation(); var i = t && t.type ? t.type : "";
                g || "playerspeed" === i ? (o.hide(), g = !0, "playerspeed" !== i && f.removeClass("hasPopout")) : (a(".tooltip").hide(), o.show(), a(".mejs-settings-position").find("ul:first li:first a").focus(), f.addClass("hasPopout")), g = !g } var r = !1,
                d = '<div class="mejs-settings-layer">                            <div class="mejs-popout-menu mejs-settings-position">                                <div class="mejs-settings-section">                                    <p>' + lynda.translate("Video Quality") + '</p>                                    <ul class="stream-qualities">                                        <li><a data-quality="360" tabindex="0">360p</a></li>                                        <li><a data-quality="540" tabindex="0" class="current">540p</a></li>                                        <li><a data-quality="720" tabindex="0">720p HD</a></li>                                    </ul>                                </div>                                <hr class="hrContinuous"/>                                <div class="mejs-settings-section">                                    <div class="continuous-play">                                        <p>' + lynda.translate("Auto Play") + '</p>                                        <span><a data-continuous-play="true" tabindex="0" class="current">' + lynda.translate("ON") + '</a></span>                                        <span><a data-continuous-play="false" tabindex="0">' + lynda.translate("OFF") + '</a></span>                                    </div>                                </div>\t\t\t\t\t\t\t\t<hr class="hrFullscreen"/>                            </div>                        </div>';
            lynda && !lynda.hasPlayerSpeedMenu && (r = !0, d = '<div class="mejs-settings-layer">                            <div class="mejs-popout-menu mejs-settings-position">                                <div class="mejs-settings-section">                                    <p>' + lynda.translate("Playback Speed") + '</p>                                    <ul class="playback-rates">                                        <li><a data-playback-rate="2" tabindex="0">2x</a></li>                                        <li><a data-playback-rate="1.75" tabindex="0">1.75x</a></li>                                        <li><a data-playback-rate="1.5" tabindex="0">1.5x</a></li>                                        <li><a data-playback-rate="1.25" tabindex="0">1.25x</a></li>                                    </ul>                                    <ul class="playback-rates">                                        <li><a data-playback-rate="1" tabindex="0" class="current">1x</a></li>                                        <li><a data-playback-rate=".75" tabindex="0">.75x</a></li>                                        <li><a data-playback-rate=".5" tabindex="0">.5x</a></li>                                    </ul>                                </div>                                <hr />                                <div class="mejs-settings-section">                                    <p>' + lynda.translate("Video Quality") + '</p>                                    <ul class="stream-qualities">                                        <li><a data-quality="360" tabindex="0">360p</a></li>                                        <li><a data-quality="540" tabindex="0" class="current">540p</a></li>                                        <li><a data-quality="720" tabindex="0">720p HD</a></li>                                    </ul>                                </div>                                <hr class="hrContinuous"/>                                <div class="mejs-settings-section">                                    <div class="continuous-play">                                        <p>' + lynda.translate("Auto Play") + '</p>                                        <span><a data-continuous-play="true" tabindex="0" class="current">' + lynda.translate("ON") + '</a></span>                                        <span><a data-continuous-play="false" tabindex="0">' + lynda.translate("OFF") + '</a></span>                                    </div>                                </div>\t\t\t\t\t\t\t\t<hr class="hrFullscreen"/>                            </div>                        </div>'); var c = lynda.translate("Settings Menu"),
                u = a('<div class="mejs-button mejs-settings-button"><button id="player-settings" type="button" aria-controls="' + this.id + '" aria-label="' + c + '" title="' + c + '"><i class="lyndacon player-settings"></i></button></div>').appendTo(e),
                o = a(d).appendTo(i).hide(),
                p = l(); if (p) { if (p.quality) { var y = o.find(".stream-qualities");
                    y.find("a").removeClass("current"), y.find("a[data-quality=" + +p.quality + "]").addClass("current") } if (r && p.playbackRate) { var b = o.find(".playback-rates");
                    b.find("a").removeClass("current"), b.find('a[data-playback-rate="' + p.playbackRate.toString().replace("0.", ".") + '"]').addClass("current") } if ("undefined" != typeof p.continuousPlay) { var v = o.find(".continuous-play");
                    v.find("a").removeClass("current"), v.find("a[data-continuous-play=" + p.continuousPlay + "]").addClass("current") } } var g = !1,
                f = a("body");
            u.click(function(a) { f.trigger("settings.click", a), f.trigger("ga.event", { action: "click", label: "player-settings-" + (g ? "show" : "hide") }) }), o.bind("click", function(t) {!a("html").hasClass("mejs-fullscreen") || a(t.target).hasClass("mejs-settings-position") || t.target.tagName.match(/(button|a)/gi) || (o.hide(), g = !1) }), o.find(".mejs-settings-position").bind("mouseleave", function() { n() }), r && o.find(".playback-rates li a").click(function(e) { e.preventDefault(); var i = a(e.target);
                o.find(".playback-rates li a").removeClass("current"), i.addClass("current"), s.playbackRate = +i.data("playbackRate"), t.$media.trigger("settings.save", { playbackRate: s.playbackRate }), a("body").trigger("ga.event", { action: "click", label: "player-playback-rate-" + s.playbackRate }), a(s).trigger("playbackRate", s.playbackRate) }), o.find(".stream-qualities li a").click(function(e) { e.preventDefault(); var i = a(e.target);
                o.find(".stream-qualities li a").removeClass("current"), i.addClass("current"); var l = i.data("quality");
                t.$media.trigger("settings.save", { quality: l }), f.trigger("ga.event", { action: "click", label: "player-quality-" + l }), a(s).trigger("streamQuality", l) }), o.find(".continuous-play span a").click(function(e) { e.preventDefault(); var i = a(e.target);
                o.find(".continuous-play span a").removeClass("current"), i.addClass("current"); var l = i.data("continuousPlay");
                t.$media.trigger("settings.save", { continuousPlay: l }), f.trigger("ga.event", { action: "click", label: "player-continous-play-" + l }), a(s).trigger("continuousPlay", l) }), f.on("stream.qualities.available", function(t, e) { if (a.inArray("720", e) === -1) { var i = o.find(".stream-qualities"),
                        s = i.find("a[data-quality=720]");
                    s.hasClass("current") && (s.removeClass("current"), i.find("a[data-quality=540]").addClass("current")), setTimeout(function() { s.hide() }, 100) } }), f.on("settings.click playerspeed.click", function(a, t) { n(a, t) }), f.on("close.popouts", function(a, t) { o.hide(), g = !1 }) } }) }(jQuery);
! function(t) { t.extend(mejs.MepDefaults, { skipBackInterval: 30, skipBackText: lynda.translate("Skip back %1 seconds") }), t.extend(MediaElementPlayer.prototype, { buildskipback: function(e, a, i, n) { var s = this,
                l = s.options.skipBackText.replace("%1", s.options.skipBackInterval) + " " + lynda.translate("(left arrow)");
            t('<div class="mejs-button mejs-skip-back-button"><button id="player-skip-back" type="button" aria-controls="' + s.id + '" title="' + l + '" aria-label="' + l + '"><i class="lyndacon player-rewind"></i></button></div>').appendTo(a).click(function() { t("body").trigger("ga.event", { action: "click", label: "player-skip-back" }), n.setCurrentTime(Math.max(n.currentTime - s.options.skipBackInterval, 0)), t(this).find("button").blur(), t(n).trigger("seeked", e) }) } }) }(jQuery);
! function(a) { a.extend(mejs.MepDefaults, { playbackSpeed: 1 }), MediaElementPlayer.prototype.buildspeedcontrol = function(t, e, l, i) {
        function r() { var t = a.cookie("player"); if (t) return JSON.parse(t) }

        function s(t, e) { e && e.stopPropagation(); var l = t && t.type ? t.type : ""; if (k || "settings" === l) n.hide(), k = !0, "settings" !== l && u.removeClass("hasPopout");
            else { a(".tooltip").hide(); var i = n.find(".mejs-playback-rate-position");
                i.css({ left: (-i.outerWidth() / 2 + o.position().left + .3 * o.outerWidth()).toString() + "px" }), n.show(), u.addClass("hasPopout") } k = !k } if (!lynda || lynda.hasPlayerSpeedMenu) { var c = '<div class="mejs-playback-rate-layer">                       <div class="mejs-popout-menu mejs-playback-rate-position">                            <ul class="playback-rates">                                <li><a data-playback-rate="2">2x</a></li>                                <li><a data-playback-rate="1.75">1.75x</a></li>                                <li><a data-playback-rate="1.5">1.5x</a></li>                                <li><a data-playback-rate="1.25">1.25x</a></li>                                <li><a data-playback-rate="1" class="current">1x</a></li>                                <li><a data-playback-rate=".75">0.75x</a></li>                                <li><a data-playback-rate=".5">0.5x</a></li>                            </ul>                        </div>                    </div>',
                n = a(c).appendTo(l).hide(),
                p = lynda.translate("Playback Speed"),
                o = a('<div class="mejs-button mejs-playback-rate-button"><button id="playback-rate" type="button" aria-controls="' + this.id + '" aria-label="' + p + '" title="' + p + '"><span class="text"></span><span class="upArrow"></span></button></div>').appendTo(e),
                d = o.find("#playback-rate"),
                y = 1,
                b = r();
            b && b.playbackRate && (y = b.playbackRate, n.find(".playback-rates li a.current").removeClass("current"), n.find('a[data-playback-rate="' + y.toString().replace("0.", ".") + '"]').addClass("current")), d.find(".text").text(y + "x"); var k = !1,
                u = a("body");
            o.on("click", function(t) { u.trigger("playerspeed.click", t), a("body").trigger("ga.event", { action: "click", label: "player-playback-rate-menu" }) }), n.bind("click", function(t) {!a("html").hasClass("mejs-fullscreen") || a(t.target).hasClass("mejs-playback-rate-position") || t.target.tagName.match(/(button|a)/gi) || (n.hide(), k = !1) }), n.find(".mejs-playback-rate-position").on("mouseleave", function(a) { s(a) }), n.find(".playback-rates li a").click(function(e) { e.preventDefault(), e.stopPropagation(); var l = a(e.target);
                n.find(".playback-rates li a.current").removeClass("current"), l.addClass("current"), i.playbackRate = +l.data("playbackRate"), t.$media.trigger("settings.save", { playbackRate: i.playbackRate }), d.find(".text").text(i.playbackRate + "x"), a("body").trigger("ga.event", { action: "click", label: "player-playback-rate-" + i.playbackRate }), a(i).trigger("playbackRate", i.playbackRate) }), u.on("settings.click playerspeed.click", function(a, t) { s(a, t) }), u.on("close.popouts", function(a, t) { n.hide(), k = !1 }) } } }(jQuery);
! function(e) { MediaElementPlayer.prototype.buildcustomvolume = function(t, a, l, u) {
        function o(e) { e ? n.removeClass("player-volume").addClass("player-mute") : n.removeClass("player-mute").addClass("player-volume") }

        function r(t) { e.cookie("player", JSON.stringify(t), { expires: 365, path: "/" }) } var m = e(".mejs-volume-button button", a).append('<i class="lyndacon player-volume"></i>');
        m.attr("id", "player-mute-toggle"), m.attr("title", lynda.translate("Mute")), m.attr("aria-label", lynda.translate("Mute")); var n = e(".mejs-volume-button button i"),
            i = e.cookie("player"); if (i) { var d = JSON.parse(i);
            d && (d.volume && (u.volume = d.volume), u.muted = !!d.muted) } m.on("click", function() { e("body").trigger("ga.event", { action: "click", label: "player-" + (u.muted ? "mute" : "unmute") }); var t = lynda.translate(u.muted ? "Unmute" : "Mute");
            m.attr({ title: t, "aria-label": t }) }), u.addEventListener("volumechange", function(t) { var a = e.cookie("player"); if (a) { var l = JSON.parse(a);
                l.volume = u.volume, l.muted = !!u.muted, r(l) } else r({ volume: u.volume, muted: !!u.muted });
            o(!!u.muted) }, !1) } }(jQuery);
! function(a) { var t = a("body");
    a(document).on("keydown", function(a) { 9 !== a.keyCode || t.hasClass("keyboard-focus") || t.addClass("keyboard-focus") }), t.on("mousedown", function() { t.hasClass("keyboard-focus") && t.removeClass("keyboard-focus") }), a(".accessible-tabs").each(function() { var t = a(this),
            n = t.data();
        t.find(n.tabcontainer || "li").each(function() { var t = a(this);
            t.find(n.tabselector || "ul li").each(function(t) { var o = a(this);
                t < (n.tabsize || 10) ? o.attr("tabindex", 0) : o.attr("tabindex", -1), o.find(n.tabignore || "a").attr("tabindex", -1), o.closest(n.tabcontainer || "li").find(n.tabbutton || "button").attr("tabindex", 0) }) }) }) }(jQuery);
! function(e) {
    function n(n, t) { e("#alert").remove(), n.attr("id", "alert"), n.find(".alert-content").html(t), n.insertAfter(e("#eyebrow, .page-main>.title-banner").last()), n.on("click", ".close", function() { n.trigger("detach.ScrollToFixed"), n.remove() }); var r = n.scrollToFixed({ marginTop: 60, zIndex: 9700 });
        console.log("fixed", r) } var t = e("body"),
        r = e("#alert-template-info");
    alertTemplateWarning = e("#alert-template-warning"), alertTemplateDanger = e("#alert-template-danger"), t.on("alert.info", function(e, t) { n(r.children().clone(), t) }), t.on("alert.warning", function(e, t) { n(alertTemplateWarning.children().clone(), t) }), t.on("alert.danger", function(e, t) { n(alertTemplateDanger.children().clone(), t) }) }(jQuery);
! function(a) { var r = a("body"),
        n = a("[data-tracking-category]").data("trackingCategory");
    r.on("scrolly.scrollComplete", function() { a.fn.appear && a.fn.appear.run() }), a("[data-track-impression]").appear(function() { var t = a(this),
            e = t.data("trackImpressionName"); if (e && 0 !== e.length) { var o = { action: "impression", label: e },
                i = t.data("gaCategory");
            o.category = i && i.length ? i : n, r.trigger("ga.event", [o]) } }), a(function() { a.fn.appear && a.fn.appear.run() }) }(jQuery);
! function(e) {
    function t(t) {
        function o() { if (x && x.abort(), null !== E) { c(); var t = "";
                t = "function" == typeof E ? E({ val: encodeURIComponent(u.val()), limit: T }) : E.replace("<%= val %>", encodeURIComponent(u.val())).replace("<%= limit %>", T), x = e.get(t).done(l).always(c) } }

        function l(t) { if (h.length) { if (a.trigger("autocomplete.cancel"), h.empty(), t && t.html.length) { var n = e(t.html).find("li");
                    n.length ? (h.html(t.html), p.length && p.clone().show().appendTo(h.find(".autocomplete-results"))) : f.length && f.clone().show().appendTo(h), i(n.length) } else f.length && (f.clone().show().appendTo(h), i(0));
                a.trigger("autocomplete.show") } }

        function c() { b.length && b.toggleClass("autocomplete-loading") }

        function i(t) { if (y.length && null != t) { r(); var n; switch (t) {
                    case 0:
                        n = f; break;
                    case 1:
                        n = m; break;
                    default:
                        n = v } n.length && y.html(e("<span/>").text(n.html())) } }

        function r() { y.length && y.empty() } var u = e(t).attr("autocomplete", "off"),
            s = u.closest("form"),
            d = u.siblings(".clear-search"),
            g = e("#header-search-field"),
            h = e(u.data("resultsContainer")),
            f = e(u.data("noResultsContainer")),
            p = e(u.data("noExactMatchContainer")),
            m = e(u.data("oneResultContainer")),
            v = e(u.data("manyResultsContainer")),
            y = e("#live-region"),
            w = e(".autocomplete-results"),
            C = ".autocomplete-results a",
            b = e(u.data("loadingIconContainer")),
            k = u.data("minCharacters") || 0,
            E = "undefined" != typeof _ ? _.template(u.data("urlTemplate")) : u.data("urlTemplate"),
            T = u.data("limit") || 50,
            R = u.data("delay") || 0,
            x = null,
            D = null;
        s.length && s.on("submit", function(e) { a.trigger("autocomplete.submit", [e]) }), "undefined" != typeof _ ? u.on("input", _.debounce(function(e) { a.trigger("autocomplete.input", [u.val()]) }, R)) : "undefined" != typeof debounce && u.on("input", debounce(function(e) { a.trigger("autocomplete.input", [u.val()]) }, R)), u.on("keydown", function(e) { switch (e.which) {
                case n.ESCAPE:
                    return a.trigger("autocomplete.cancel"), !1;
                case n.UP:
                case n.DOWN:
                    return a.trigger("autocomplete.selection.change", [e.which === n.UP ? -1 : 1]), !1;
                case n.ENTER:
                    return a.trigger("autocomplete.cancel"), s.submit(), !1 } }), e("#autocomplete-results").on("click", "a", function(t) { a.trigger("search.track.ac.click", { clickedItem: e(this) }) }), u.on("focus", function(e) { a.trigger("autocomplete.focus"), a.trigger("autocomplete.show") }); var P = !1;
        u.on("focusout", function(e) { return P ? (P = !1, !1) : (a.trigger("autocomplete.blur"), a.trigger("autocomplete.cancel"), void h.hide()) }), h.length && (h.on("mousedown", function(e) { P = !0 }), h.on("click", "a", function(e) { a.trigger("autocomplete.selection.click", [this]) }), h.on("mouseover", "a", function(e) { h.find("li").removeClass("current") })), a.on("autocomplete.submit", function(e, t) { d.length && d.hide(), D && D.length > 0 && (t.preventDefault(), D.find("a").get(0).click()) }), a.on("autocomplete.clear", function(e) { e.preventDefault(), u.val(""), d.hide(), D = null, h.empty() }), a.on("autocomplete.input", function(e, t) { return 0 === t.length || t.length <= k ? (a.trigger("autocomplete.cancel"), w.length && w.hide(), void(d.length && d.hide())) : (d.length && d.show(), void o()) }), a.on("autocomplete.show", function(t) { if (h.length && (h.show(), g.attr("aria-expanded", !0)), w.length) { w.show(); var n = e('a[data-type="6"]');
                e.each(n, function() { var t = e(this).data("term"); "undefined" != typeof _gaq && "undefined" != typeof analyticsEvent ? analyticsEvent("search", "path result shown", t) : "undefined" != typeof ga && a.trigger("ga.event", [{ category: "search", action: "path result shown", label: t }]) }), a.trigger("search.track.ac.impression", [C, u.val()]) } }), a.on("autocomplete.cancel", function(e) { h.hide(), g.attr("aria-expanded", !1), x && x.abort() }), a.on("autocomplete.selection.change", function(t, n) { if (h.length) { var a = h.find(".current"),
                    o = h.find("li");
                e(o).find("a").attr("aria-selected", !1), g.attr("aria-activedescendant", ""), 0 === a.length ? D = o.first().addClass("current").focus() : (o.removeClass("current"), D = o.eq(o.index(a) + n).addClass("current").focus()); var l = e(e(D).find("a"));
                l.attr("aria-selected", !0), g.attr("aria-activedescendant", l.attr("id")) } }), d.length && d.on("click", function(e) { e.preventDefault(), u.val(""), h.empty(), d.hide() }) } var n = { ENTER: 13, UP: 38, DOWN: 40, ESCAPE: 27, TAB: 9 },
        a = e("body");
    e(".autocomplete").each(function(e, n) { t(n) }), a.on("autocomplete.init", function(e, n) { t(n) }) }(jQuery);

! function(e) { e("body").on("click", ".bookmark-this-page", function(i) { var o = window.location.href,
            t = document.title; if ("addToHomescreen" in window && window.addToHomescreen.isCompatible) addToHomescreen({ autostart: !1, startDelay: 0 }).show(!0);
        else if (window.sidebar && window.sidebar.addPanel) window.sidebar.addPanel(t, o, "");
        else { if (window.sidebar && /Firefox/i.test(navigator.userAgent) || window.opera && window.print) return e(this).attr({ href: o, title: t, rel: "sidebar" }).off(i), !0;
            window.external && "AddFavorite" in window.external ? window.external.AddFavorite(o, t) : alert("Press " + (/Mac/i.test(navigator.userAgent) ? "Cmd" : "Ctrl") + "+D to bookmark this page.") } return !1 }) }(jQuery);
! function(e) { var a = { debug: !1, loaded: !1, video: { videoId: "Pvf5HVUQ2Jw", width: 552, height: 310, defaultWidth: 552, defaultHeight: 310, shrinkWidth: 485, shrinkHeight: 264, autoplay: 1, controls: 1, autohide: 1, wmode: "opaque", rel: 0 }, animation: { delay: 2e3, duration: 1e3, type: "linear", breakpoint: 375, med_breakpoint: 1024, large_breakpoint: 1196, small_banner_phone: 158, small_banner_phablet: 144, large_banner: 112, large_banner_2: 180 }, urls: { view: "/ajax/migrationsplashviewed/", log: "/ajax/logaction/" }, breakpoints: { banners: 768, resizeBanners: 1025 }, settings: { seen: 3, sleep: 7 }, elements: { splash: ".splash-overlay", banners: { left_rail: ".small-deal", right_rail: ".large-deal" }, tagalong: ".tagalong-banner" }, cookieName: { splashes: "splashes", tagAlong: "tagAlong", banners: "banners" }, notify: function(o, i) { if (a.debug) console.log(o);
            else { var n = e.cookie ? e.cookie("cm") : readCookie("cm");
                null !== n && void 0 !== n && "true" === n ? null !== i && void 0 !== i || console.log(o) : null !== n && void 0 !== n && "verbose" === n && console.log(o) } }, seenIt: function(o, i, n, s) { var t = "",
                l = e.cookie ? e.cookie(i) : readCookie(i); if (a.notify(o, i, n), "splash" === o ? t = "started" : "tagAlong" === o ? t = "seen" : "banners" === o && (t = s ? a.settings.seen : void 0 == l ? 1 : Number(l) + 1), e.cookie)
                if (l && l.length) { a.notify("fresh cookie saved for you!"); var d = new RegExp(n, "g");
                    l.search(d) < 0 && e.cookie(i, t, { raw: !0, path: "/", expires: a.settings.sleep }) } else a.notify("no cookie saved for you!"), e.cookie(i, t, { raw: !0, path: "/", expires: a.settings.sleep });
            else if (null != l) { a.notify("old cookie saved for you!"); var d = new RegExp(n, "g");
                l.search(d) < 0 && createCookie(i, t, a.settings.sleep) } else createCookie(i, t, a.settings.sleep) }, reloadIt: function() { e(".splash-video-thumb").show(), e(".splash-video-content").hide().html('<div id="player"></div>') }, moveIt: function(o, i) { a.notify("splash moved to pane " + i), e(".migration > .splash-overlay").find(".pane").fadeOut(), e(".migration > .splash-wrapper").find(".pane").removeClass("splashOpen"), e("#pane-" + i).addClass("splashOpen").fadeIn(), a.reloadIt() }, logIt: function(o, i) { e.ajax({ dataType: "json", url: a.urls.log, data: { screenType: o, actionType: i, paymentType: e(".migration > .splash-overlay").data("payment-type") } }).done(function() { a.notify("logging a " + i + " for " + o) }).fail(function(e) { a.notify("logging call failed"), a.notify(e) }) }, viewedIt: function() { e.ajax({ dataType: "json", url: a.urls.view }).done(function() { a.notify("successfully viewed splash page") }).fail(function(e) { a.notify("failed to log viewed for splash page"), a.notify(e) }) }, playIt: function() {
            function o() { t = new YT.Player("player", { playerVars: { autoplay: a.video.autoplay, controls: a.video.controls, autohide: a.video.autohide, wmode: a.video.wmode, width: a.video.width, height: a.video.height, rel: a.video.rel }, videoId: a.video.videoId }), a.loaded = !0 } if (e(".splash-video-thumb").hide(), e(".splash-video-content").show(), a.loaded === !1) { var i = document.createElement("script");
                i.src = "https://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"; var n = document.getElementsByTagName("script")[0];
                n.parentNode.insertBefore(i, n); var s = document.createElement("script");
                s.src = "https://www.youtube.com/player_api", n.parentNode.insertBefore(s, n) } var t;
            window.setTimeout(function() { o(), a.logIt("splash-video", "viewed") }, 500) }, listen: function() { a.notify("listing for events"), e("body").on("click", ".tagalong-close", function() { a.notify("tagAlong Hidden"), a.lowerIt("tagAlong"), a.logIt("toast", "dismissed") }), e("body").on("showTagAlong", function() { var o = e(this),
                    i = o.data();
                a.notify("tagAlong Shown"), a.raiseIt("tagAlong", i.open, "raised", !1) }), e("body").on("click", ".splash-nav-item", function() { var o = e(this),
                    i = o.data();
                a.moveIt(o, i.pane), a.logIt("splash_step_" + i.pane, "impression"), a.logIt("splash-nav", "click") }), e("body").on("click", ".splash-close", function() { a.lowerIt("splash"), a.logIt("splash", "dismissed") }), e("body").on("click", ".splash", function() { var o = e(this),
                    i = o.data(),
                    n = e(o).parent().hasClass("tagalong-banner") ? "tagAlong" : "splash"; "main" === i.location && a.seenIt("banners", a.cookieName.banners, "migrationBanners", !0), a.raiseIt("splash", i.open, n, !1), a.logIt(i.source, "click") }), e("body").on("click", ".splash-video", function() { var o = e(this),
                    i = o.data(); "main" === i.location && a.seenIt("banners", a.cookieName.banners, "migrationBanners", !0), a.raiseIt("splash", 1, "splash", !0), a.logIt(i.source, "click") }), e("body").on("click", ".splash-video-thumb img", function() { a.playIt() }), e("body").on("showSplash", function() { var o = e(this),
                    i = o.data();
                a.notify("Splash Shown"), a.raiseIt("splash", i.open, "splash", !1) }), e("body").on("click", ".initiate-migration", function() { a.logIt("splash_step_2", "click") }), e("body").on("keyup", function(e) { 27 === e.which && (a.lowerIt("splash"), a.logIt("splash", "dismissed")) }), e(".footer-splash").on("click", function() { window.scrollTo(0, 0), a.logIt("splash_step_1", "impression") }), e(".migration > .splash-bg").addClass("loaded"), e("html").hasClass("legacy") && (e(".migration > .splash-bg").addClass("legacy"), e(".migration > .splash-overlay").addClass("legacy"), e(".splash-cta").addClass("em-button yellow")); var o = "splashtooltip";
            e("body").on("mouseenter", ".splash-tooltip-trigger", function() { if (e("#" + o).length) e("#" + o).fadeIn();
                else { var a = e(this),
                        i = a.data(),
                        n = i.content,
                        s = a.offset(),
                        t = e("<div>").addClass("splash-tooltip").attr("id", o).html(n).css("left", s.left - 8).css("top", s.top + 30);
                    e("body").append(t) } }), e("body").on("mouseleave", ".splash-tooltip-trigger", function() { e("#" + o).fadeOut() }), e(window).resize(function() { e(window).width() > a.breakpoints.resizeBanners ? (e(".ud").removeClass("fadein").show(), e(".sd").hide(), e(".large-deal").addClass("show-deal").removeClass("hide-deal"), e(".small-deal").removeClass("show-deal").addClass("hide-deal")) : (e(".sd").removeClass("fadein").addClass("addTop").show(), e(".ud").hide(), e(".large-deal").removeClass("show-deal").addClass("hide-deal"), e(".small-deal").addClass("show-deal").removeClass("hide-deal")) }), e("body").on("click", ".splash-collapsable", function() { e(this).find("h3 i").removeClass("rotate").removeClass("down-arrow").removeClass("up-arrow"), e(this).find("section").hasClass("opened") ? (e(this).find("section").removeClass("opened"), e(this).find("h3 i").removeClass("rotate").removeClass("up-arrow").addClass("down-arrow")) : (e(this).find("h3 i").removeClass("down-arrow").addClass("up-arrow"), e(this).find("section").addClass("opened")), e("#pane-2").height() > window.innerHeight ? (e(".migration > .splash-wrapper").addClass("splash-supersticky"), a.video.width = a.video.shrinkWidth, a.video.height = a.video.shrinkHeight) : (e(".migration > .splash-wrapper").removeClass("splash-supersticky"), a.video.width = a.video.defaultWidth, a.video.height = a.video.defaultHeight) }); var i = navigator.userAgent.match(/(Windows|Macintosh|CrOS)/i);
            i && e("#pane-3").trigger("click") }, watchIt: function() {
            function o(o, i) { o ? (a.notify(i + " condition is true", !0), e(".migration > .splash-wrapper").removeClass("splash-supersticky").addClass("shrinkWrap"), a.video.width = a.video.shrinkWidth, a.video.height = a.video.shrinkHeight) : (a.notify(i + " condition is false", !0), e(".migration > .splash-wrapper").removeClass("shrinkWrap"), a.video.width = a.video.defaultWidth, a.video.height = a.video.defaultHeight) } a.notify("watching body for resize"), e(window).on("scroll", function(i) { a.notify(i.isTrigger ? " triggerd" : " scroll", !0), o(e(window).scrollTop() < 300, "scroll"), i.isTrigger || (clearTimeout(this._timer), this._timer = setTimeout(function() { e(window).trigger("scroll") }, 250)) }) }, animateIt: function(o) { var i = e(o),
                n = i.parent();
            setTimeout(function() { n.animate({ height: ".large-deal" === o ? i.hasClass("unlock-deal") ? a.animation.large_banner : a.animation.large_banner_2 : window.innerWidth < a.animation.breakpoint || window.innerWidth > a.animation.med_breakpoint && window.innerWidth < a.animation.large_breakpoint ? a.animation.small_banner_phone : a.animation.small_banner_phablet }, a.animation.duration, a.animation.type, function() { n.css("visibility", "visible").addClass("addTop"), i.fadeIn() }) }, a.animation.delay) }, checkIt: function(o) { if ("banners" === o) window.innerWidth < a.breakpoints.banners ? (a.logIt("left_rail", "impression"), a.animateIt(".small-deal")) : (a.logIt("banner", "impression"), a.seenIt("banners", a.cookieName.banners, "migrationBanners", !1), a.animateIt(".large-deal"));
            else if ("size" === o) { var i = e("body").hasClass("pane-1") ? 1 : 2;
                a.notify("body had pane - " + i), e("#pane-" + i).height() > window.innerHeight ? (a.notify("pane is taller than body"), a.video.width = a.video.shrinkWidth, a.video.height = a.video.shrinkHeight, e(".migration > .splash-wrapper").addClass("shrinkWrap")) : a.notify("body is taller than pane"), a.watchIt() } else { var n = e.cookie ? e.cookie(a.cookieName.tagAlong) : readCookie(a.cookieName.tagAlong); "seen" === n && null != n || 0 !== e("#homepage").length || e("body").hasClass("notoast") || a.raiseIt("tagAlong", e(".tagalong-banner").find(".splash").first().data("open"), "raised", !1) } }, raiseIt: function(o, i, n, s) { var t = (e.cookie ? e.cookie(a.cookieName[o]) : readCookie(a.cookieName[o]), e("body").data("bucket")); "splash" === o ? (a.notify("splash raised"), a.moveIt(self, i), "tagAlong" === n && (a.seenIt("tagAlong", a.cookieName.tagAlong, "migrationTagAlong", !1), a.lowerIt("tagAlong")), a.seenIt("splash", a.cookieName.splashes, "migrationSplash", !1), a.viewedIt(), window.scrollTo(0, 0), e("#cancellation-page").length && (e(".upsells-header").hide(), e(".upsells-content").hide(), e(".cancellation-header").show(), e(".cancellation-content").show(), a.logIt("cancellation", "click")), a.logIt("splash_step_1", "impression"), e(".migration > .splash-bg").fadeIn(400, function() { e(".migration > .splash-overlay").show(), a.checkIt("size"), s && window.setTimeout(function() { a.playIt() }, 500) })) : e(a.elements.tagalong).length && (a.notify("tagAlong raised"), e(".tagalong-banner").find(".bucket").hide(), e(".tagalong-banner").find(".bucket" + t).show(), e(".tagalong-banner").removeClass("slide_right").addClass("slide_left"), a.logIt("toast", "impression")) }, lowerIt: function(o) { "splash" === o ? (a.notify("splash lowered"), e(".splash-overlay").hide(), e(".splash-bg").fadeOut()) : (a.notify("tagAlong lowered"), a.seenIt("tagAlong", a.cookieName.tagAlong, "migrationTagAlong", !1), e(".tagalong-banner").removeClass("slide_left").addClass("slide_right")) }, boot: function() { e(document).ready(function() { a.listen(), (e(".large-deal").length || e(".small-deal").length) && a.checkIt("banners"), a.checkIt("tagAlong") }) } };
    a.boot() }(jQuery);
! function(o) {
    function t() { var t = o(this).scrollTop(),
            e = o(this).innerHeight(),
            n = this.scrollHeight;
        t + e >= n ? o(this).addClass("container-scroll-complete") : o(this).removeClass("container-scroll-complete") } o(".container-fade-bottom.js").each(function(e, n) { o(n).on("scroll", t) }) }(jQuery);
! function(e, t) {
    function a(e, a, o, i, n) { c || (t.LivePass.toggleTraces(s.toggleTraces), t.LivePass.init(s.serviceUrl, s.customerId), c = !0), l && (t.LivePass.cleanupMonitoringSession(e.get(0)), l.cleanup(), l = null), r(e, a, o, i, n) }

    function r(e, a, r, n, c) { var v = i(a.CourseId, a.VideoId, a.CourseTitle, a.VideoTitle),
            u = t.ConvivaContentInfo.createInfoForLightSession(v);
        u.cdnName = r, u.streamUrl = c, u.isLive = !1, u.bitrate = n, u.playerName = s.playerName, u.deviceType = t.ConvivaContentInfo.DEVICE_TYPE_PC, u.viewerId = a.UserId, u.tags = { courseId: a.CourseId, movieId: a.VideoId, category: a.Subjects, subCategory: a.Topics, quality: n, playerVersion: o(), userId: a.UserId, author: a.Author, courseName: a.CourseTitle, skillLevel: a.SkillLevel, publicationYear: a.ReleaseYear, software: a.Software }, l = t.LivePass.createSession(e.get(0), u), l.setContentLength(a.Duration) }

    function o() { var e = new Date; return "html5_" + (e.getMonth() + 1) + e.getDate() + e.getFullYear() }

    function i(e, t, a, r) { var o = "[" + +e + "-" + +t + "] " + a + " - " + r; return o.length > 128 && (o = o.substr(0, 128)), o } if (t && t.LivePass) { var n = window.location.search.indexOf("convivaDebug=1") > -1,
            s = { playerName: "lynda.com MEJS", customerId: n ? "c3.Lynda-Test" : "c3.Lynda", serviceUrl: n ? "https://lynda-test.testonly.conviva.com" : "https://livepass.conviva.com", toggleTraces: n },
            l = null,
            c = !1;
        e(".player[data-conviva]").on("playUrl", function(t, r, o, i, n, s, l) { var c = e(this);
            e.get("/ajax/player/conviva?courseId=" + +i + "&videoId=" + +n, function(e) { a(c, e, s, l, r), c.trigger("video.metadata.loaded", e) }) }).on("streamQuality", function(e, t) { l && l.setCurrentBitrate(t) }).on("course.video.error", function(a, r, o, i, n, c) { var v = e(this);
            l ? l.reportError(t.ConvivaLightSession.ERROR_STREAMING_FAILURE) : (l = t.LivePass.createSession(v.get(0), { playerName: s.playerName, cdnName: i, bitrate: n, streamUrl: c }), l.reportError(t.ConvivaLightSession.ERROR_STREAMING_FAILURE)) }) } }(jQuery, Conviva);
! function(e) { e.ajaxSettings.beforeSend = function(e, n) { "GET" !== n.type && lynda["-_-"] && e.setRequestHeader("-_-", lynda["-_-"]) } }(jQuery);
! function(n) {
    function e() { clearTimeout(y), clearTimeout(b), clearTimeout(w) }

    function t() {
        (document.webkitHidden || document.hidden || document.msHidden) && e() }

    function o() { document.location = v }

    function a(n) { var e = document.createElement("iframe");
        e.style.border = "none", e.style.width = "1px", e.style.height = "1px", e.src = d, l.append(e); var t = !0,
            o = setInterval(function() { t = document.hasFocus(), t || (clearInterval(o), l.trigger("deeplinking.success")) }, 100);
        y = setTimeout(function() { t && c(n) }, 7e3) }

    function i(n) { document.location = d, y = setTimeout(function() { c(n) }, 2500) }

    function c(n) { n ? document.location = u() : l.trigger("deeplinking.failed") }

    function u() { switch (!0) {
            case A:
                return p;
            case I:
                return h;
            case T:
                return g;
            case k:
                return f;
            default:
                return m } }

    function r(n) { var e = n.split("?"); return n = e.shift() + "?", e.push("anticache=" + (new Date).getTime()), n + e.join("&") }

    function s(n, e) { e = e !== !1, (A || I) && (e = !0), n = r(n), v = v.replace("{scheme}", n), d = n, b = setInterval(t, 200), I && navigator.userAgent.match(/Chrome/) ? o() : (T || k) && document.hasFocus ? a(e) : i(e) } var l = n("body"),
        d = "",
        m = "",
        p = "http://itunes.apple.com/us/app/lynda.com/id356169777",
        h = "https://play.google.com/store/apps/details?id=com.lynda.android.root",
        g = "http://apps.microsoft.com/windows/en-us/app/lynda/8b185bc1-b1a9-46b2-a596-1f3de3824778",
        f = "https://itunes.apple.com/us/app/lynda.com/id985958984?l=de&ls=1&mt=12",
        v = "intent://scan/#Intent;scheme={scheme};package=com.lynda.android.root;end",
        y = null,
        b = null,
        w = null,
        A = null != navigator.userAgent.match(/(iPhone|iPod|iPad)/),
        T = null != navigator.userAgent.match(/Windows/),
        k = null != navigator.userAgent.match(/Macintosh/i),
        I = null != navigator.userAgent.match(/Android/);
    l.on("deeplinking.launch", function(n, e, t) { s(e, t) }) }(jQuery);
var dropdowns = { start: function() { $(".dropdown").each(function(n, o) { var e = $(o),
                d = e.find("ul");
            e.on("click", function(n) { $(this).toggleClass("opened"), $(this).hasClass("opened") ? $(this).trigger("dropdown.open") : $(this).trigger("dropdown.close") }), e.on("dropdown.open", function() { d.show() }), e.on("dropdown.close", function() { d.hide() }), d.find("li").on("click", function(n) { var o = $(this);
                d.find("li").removeClass("selected"), o.addClass("selected"), e.find("span").text(o.text()), e.trigger("dropdown.change", [o, o.data("value")]); var t = e.find("input");
                t.length && t.val(o.data("value")), e.removeClass("opened"), e.trigger("dropdown.close"); var r = o.find("a").attr("href"); if (!r || "" == r) return !1 }) }) } };
dropdowns.start();
! function(e) { e(".filters").each(function(t, i) {
        function r(t) { n.removeClass("active"), t.addClass("active"), f.show(); var i = t.find(".filter-content");
            i.length > 0 && (f.html(i.get(0).outerHTML), f.find(".filter-content").removeClass("hide")), "undefined" != typeof hideFilters && !!hideFilters == !1 || n.each(function(t, i) { var r = e(i).data("target");
                r && r !== filterTarget && e(r).hide() }) } var a = e(i),
            n = a.find(".filter"),
            f = e(a.data("target")); if (0 !== n.length && 0 !== f.length) { a.data("hideFilters");
            n.on("click", function() { var t = e(this); if (t.hasClass("active")) return !1; var i = t.data("url");
                i ? e.get(i).done(function(e) { t.trigger("filter.beforechange", t), r(t), f.html(e.html), t.trigger("filter.change", t) }) : (t.trigger("filter.beforechange", t), r(t), t.trigger("filter.change", t)) }) } }) }(jQuery);
! function(t) {
    function e(t) { return u.find("> .panel > section").eq(t).find(".step").data("title") }

    function n() { var e = 0,
            n = a(); return t.each(n, function(t, n) { u.hasClass(n) && (e = t) }), e }

    function s(t) { return o[t] }

    function a() { var e = "default"; return t.each(r.flows, function(t) { u.hasClass(t) && (e = t, l = t) }), r.flows[e] } var o, i, r, l, f = (t(document), t("body")),
        u = t(".step-container"),
        c = t(".step-container .panel");
    f.on("flow.setup", function(e, s) { r = s, o = a(), i = n(), t(window).on("popstate", function(t) { var e = null !== t.originalEvent.state ? +t.originalEvent.state.step : 0;
            f.trigger("flow.changestep", [e]) }), f.trigger("flow.setup.complete", [o, i]) }), f.on("flow.changestep", function(n, a) { var o = s(i),
            r = s(a);
        (a > i || 0 === a) && history.pushState && history.pushState({ step: a }, e(a), "/" + s(a)), u.removeClass(o).addClass(r); var l = e(a);
        document.title = "Lynda.com" + (l ? " " + l : ""), i = a; var c = u.find(".step").eq(a);
        t("html").hasClass("no-touch") && c.hasClass("focus-first") && c.find("input, select, textarea").first().focus(), f.trigger("flow.viewstep", [i]) }); var d = -1;
    f.on("flow.ignorestep", function(t, e) { return e < 0 ? void(d = -1) : void(d = e) }), c.on("click", ".change-step", function(e) { var n = t(this); if (n.hasClass("disabled") || n.is("[disabled]")) return !1; if (d > -1 && i + 1 === d) return f.trigger("flow.stepignored", d), !1; var c = n.data();
        c.flow && (u.removeClass(l).addClass(c.flow), u.removeClass(s(i)), l = c.flow, o = r.flows[c.flow], i = r.flows[c.flow].indexOf(c.url)), e.preventDefault(); var p = i + 1; "undefined" != typeof c.validate && 1 == c.validate ? f.trigger("flow.validate", [p, a(), s(i)]) : p < o.length && f.trigger("flow.changestep", [p]) }), i > 0 && history.pushState && history.pushState({ step: i }, e(i), "/" + s(i)) }(jQuery);
! function(a) {
    function n(a) { a.attr("disabled", !1) }

    function t(a) { a.attr("disabled", !0) } var r = a("body");
    a(".animated-form input:not([type=hidden])").val(""), r.on("focus", ".animated-form input", function(n) { var t = a(n.currentTarget);
        t.parents(".animated-form").addClass("filled") }), r.on("blur", ".animated-form input", function(n) { var t = a(n.currentTarget); "" !== t.val() && null != t.val() || t.parents(".animated-form").removeClass("filled") }), r.on("form.updateSubmit", function(r, e) { var i = !0,
            o = a(e),
            u = o.find(":submit"),
            d = o.find(".form-group");
        a(".message-cont").hide(), d.each(function() { i = i && !a(this).hasClass("has-error") }), i ? n(u) : t(u) }), a("textarea[maxlength]").bind("input propertychange", function() { var n = a(this),
            t = n.attr("maxlength");
        n.val().length > t && n.val(n.val().substring(0, t)) }) }(jQuery);
! function(e) {
    function t() { gapi.client.setApiKey(u) }

    function i(e, i, o) { s = i || "Default File Content", fileTitle = o || "Default File Name", c ? (c.registerOnAuthorizationCallback(n), c.authorize()) : (c = new t, c.registerOnAuthorizationCallback(n), c.authorize()) }

    function n() { var e = { title: fileTitle },
            t = new o;
        t.registerOnFileAddedCallback(uploadSuccess), t.addFile(e, s, null, !0) }

    function o() { this.boundary = "-------314159265358979323846", this.delimiter = "\r\n--" + this.boundary + "\r\n", this.closeDelimiter = "\r\n--" + this.boundary + "--" } var r, l = e("body"),
        a = e("[data-google-drive-client-id]").data("googleDriveClientId"),
        u = e("[data-google-drive-api-key]").data("googleDriveApiKey"),
        d = e("[data-google-drive-scope]").data("googleDriveScope"),
        c = null,
        s = fileTitle = "";
    uploadSuccess = function() { l.trigger("google.drive.export.success") }, t.prototype = { authorize: function() { this.clientAuth(!0) }, registerOnAuthorizationCallback: function(e) { r = e }, callback: null, handleAuthResult: function(e) { e && (e.error ? c.clientAuth(!1) : "function" == typeof r && r()) }, clientAuth: function(e) { gapi.auth.authorize({ client_id: a, scope: d, immediate: e }, this.handleAuthResult) } }, l.on("google.drive.upload", i); var p;
    o.prototype.registerOnFileAddedCallback = function(e) { p = e }, o.prototype.addFile = function(e, t, i, n) { var o = btoa(unescape(encodeURIComponent(t))),
            r = i || "text/html",
            a = 1 == n ? "true" : "false",
            u = this.delimiter + "Content-Type: application/json\r\n\r\n" + JSON.stringify(e) + this.delimiter + "Content-Type: " + r + "\r\nContent-Transfer-Encoding: base64\r\n\r\n" + o + this.closeDelimiter,
            d = gapi.client.request({ path: "/upload/drive/v2/files", method: "POST", params: { uploadType: "multipart", convert: a }, headers: { "Content-Type": 'multipart/mixed; boundary="' + this.boundary + '"' }, body: u });
        d.execute(function(e) { e.error ? l.trigger("google.drive.export.error") : "function" == typeof p && p() }) } }(jQuery);
! function(i) { i(".infinite").each(function(n, a) {
        function t() { if (!g && !s) { var n = e.find(".card-item").length,
                    a = r + "?start=" + n + "&limit=" + d;
                i.each(i("[data-infinite-param]"), function(n, t) { var t = i(t),
                        e = t.data("infiniteParam"),
                        r = t.data("infiniteParamDelimiter"),
                        l = t.hasClass("dropdown") ? t.find(".selected") : t,
                        o = l.val && l.val().length > 0 ? l.val() : l.attr("data-value");
                    r ? e.split(r).forEach(function(i, n) { a += "&" + i + "=" + o.split(r)[n] }) : a += "&" + e + "=" + o }), p && (a += "&" + p.name + "=" + p.value), g = !0, e.append("<li class='infinite-loading'><i class='svg loading-grey'></i></li>"), i.get(a).done(function(n) { n.html ? (e.append(n.html), c++, i("body").trigger("infinite.scroll.after", e, c)) : (s = !0, i("body").trigger("infinite.scroll.complete", e)) }).always(function() { e.find(".infinite-loading").remove(), g = !1 }) } } var e = i(a),
            r = e.data("refreshUrl"),
            l = e.data("triggerId"),
            o = i(l ? "#" + l : "#page-bottom"),
            d = e.data("pageSize") || 20,
            f = e.data("bypassCountCheck"),
            c = 1,
            g = !1,
            s = !1,
            p = null;
        o.appear(), o.on("appear", function(n, a) { var l = e.find(".card").length;!f && l < d || (i("body").trigger("infinite.scroll.before", e), r && r.length > 0 ? t() : i("body").trigger("infinite.scroll", e)) }), i("body").on("infinite.reset", function() { c = 1 }), i("body").on("infinite.context.update", function(i, n, a) { n && a && (p = { name: n, value: a }) }) }) }(jQuery);
! function(n, t) {!t || n("html").hasClass("member") || !t.primaryContentId || !t.primaryContentType }($, lynda);
! function(o) { var e = o("body"),
        n = o("header[role='banner']"),
        a = o("#jp-banner"),
        d = o("#jp-popUp"),
        l = (o("#jp"), "None"); "undefined" != typeof lynda && "undefined" != typeof lynda.showJPBanner && (l = lynda.showJPBanner), e.on("click", ".dont-show-again", function() { window.localStorage.disableJPPopUp = !0 }), e.on("click", ".close-x, .dont-show-again", function() { window.localStorage.disableJP = !0, d.remove(), a.remove() }), "JpBanner" == l && (a.insertAfter(n), a.addClass("show responsive-alert")), "JpPopUp" == l && d.addClass("show"), window.localStorage && (window.localStorage.disableJPPopUp && d.remove(), window.localStorage.disableJP && (d.remove(), a.remove())) }(jQuery);
! function(a) {
    function t() {
        function t(a, t) { a && t && a.attr("src", t).removeAttr("data-lazy-error-src").addClass("load-error") } a("html").addClass("loaded"), a("[data-lazy-src], [data-lazy-srcset]").each(function() { var r = a(this),
                e = r.attr("data-lazy-src") ? "src" : "srcset",
                l = r.data("lazy-error-src");
            l && r.one("error", function() { t(r, l) }), r.appear(function() { r.off("appear"); var a = r.attr("data-lazy-" + e);
                a && a.length ? r.attr(e, a) : l && l.length && t(r, l), r.removeAttr("data-lazy-" + e) }) }), a(".lazy-bg-container [data-lazy-bg-img]").each(function() { var t = a(this),
                r = t.data("lazy-bg-img"); if (r && 0 !== r.length) { var e = t.data("lazy-bg-sizes"); if (e && e.length)
                    for (var l = e.split("-"), n = 0; n < l.length; n++) t.addClass(l[n]);
                t.appear(function() { t.off("appear"), t.data("lazy-bg") ? t.css("background", t.data("lazy-bg") + ", url(" + r + ")") : t.css("background-image", "url(" + r + ")"), e && e.length && t.removeAttr("style"), t.removeAttr("data-lazy-bg-img data-lazy-bg") }) } }) } a("body").on("lazy.init", t), a("body").trigger("lazy.init") }(jQuery);
! function(e) { var t = "listplayerPlugin";
    e("body").on("listPlayer.add", function(r, i, a) { var n = e(i);
        n.addClass("plugin_" + t).data("lpId", (new Date).getTime() + a).data("currentPriority", 0).data("popped", !1); var l = null,
            o = { id: 0, type: null, course: 0 },
            d = [];
        n.find(".lp-toc-container").find(".lp-item").each(function(t, r) { var i = e.extend({}, o, { type: e(r).data("itemType"), id: e(r).data("itemId"), course: e(r).data("courseId") });
            d.push(i) }), n.data("lpItems", JSON.stringify(d)), n.on("listPlayer.getItemFromToc", function(t, r) { var i = e(this).find(".lp-toc-container"),
                a = i.find('.lp-item[data-item-id="' + r.id + '"][data-item-type="' + r.type + '"]'); return a }).on("listPlayer.updateNavButtonsState", function(t) { var r = e(this).triggerHandler("listPlayer.getPreviousItem"),
                i = e(this).triggerHandler("listPlayer.getNextItem");
            e(this).find("#player-previous, #player-next").attr("disabled", "disabled"), r.id !== n.data("currentItemId") && e(this).find("#player-previous").removeAttr("disabled"), i.id !== n.data("currentItemId") && e(this).find("#player-next").removeAttr("disabled") }).on("listPlayer.isLastItem", function(t, r) { if (r) return r === n.data("currentItemId"); var i = e(this).triggerHandler("listPlayer.getNextItem"); return i.id === n.data("currentItemId") }).on("listPlayer.getNextItem", function() { var t = [],
                r = e(this).data("lpItems"); try { r = JSON.parse(r) } catch (i) { console.error("Error in retrieving items") } if (e.each(r, function(e, r) { r.id === n.data("currentItemId") && t.push({ index: e, type: r.type, id: r.id }) }), t.length) { var a = ++t[0].index; return a === r.length && (a = r.length - 1), r[a] } console.log("Error in nextItem call") }).on("listPlayer.getPreviousItem", function() { var t = [],
                r = e(this).data("lpItems"); try { r = JSON.parse(r) } catch (i) { console.error("Error in retrieving items") } if (e.each(r, function(e, r) { r.id === n.data("currentItemId") && t.push({ index: e, type: r.type, id: r.id }) }), t.length) { var a = --t[0].index; return a < 0 && (a = 0), r[a] } console.log("Error in getPreviousItem call") }).on("listPlayer.playItemUrl", function(t, r, i, a) { if (r) return void e(this).trigger("listPlayer.item.error", [i]);
            e(this).trigger("listPlayer.item.change", [i, n.data("popped")]); var l = []; try { l = JSON.parse(n.data("cdns")) } catch (t) { console.error("Error in retrieving CDN info.") } n.find(".lp-player-container").find("video.player").trigger("playUrl", [l[n.data("currentPriority")].urls[n.find(".lp-player-container").find("video.player").data("quality") || 540], a, i.course, i.id]) }).on("listPlayer.playItem", function(t, r, i) { n.data("currentItemId", r.id), e.post("/ajax/listPlayer/playItem", r).done(function(e) { var t = e;
                n.data("cdns", JSON.stringify(t)), n.trigger("listPlayer.playItemUrl", [0 === t.length ? "No stream information available" : null, r, i]) }).fail(function(e) { n.trigger("listPlayer.playItemUrl", e, r) }) }), n.find(".lp-player-container").on("click.listPlayer.playerContainer", ".preroll-controls-play", function() { var e = n.find(".lp-toc-container"),
                t = e.find(".lp-item.current"); if (!t.length) { var r = e.find(".lp-item:first");
                t = r } t.find(".lp-item-link").find(".item-name").trigger("click") }).on("click.listPlayer.playerContainer", ".postroll-controls-replay", function(t) { var r = n.find(".lp-toc-container"),
                i = r.find('.lp-item[data-last-viewed="true"]'),
                a = e.extend({}, o, { id: i.data("itemId"), type: i.data("itemType"), course: i.data("courseId") });
            clearInterval(l), n.trigger("listPlayer.playItem", a) }).on("click.listPlayer.playerContainer", ".postroll-controls-next", function(e) { clearInterval(l); var t = n.find(".lp-toc-container"),
                r = t.find(".lp-item.upnext");
            r.length && r.find(".lp-item-link").find(".item-name").trigger("click") }), n.find(".lp-toc-container").on("listPlayer.updatetoc", function(t, r) { var i = e(this),
                a = n.triggerHandler("listPlayer.getItemFromToc", [r]);
            i.find(".lp-item").removeClass("current").removeClass("upnext"), a.addClass("current"), i.trigger("autoscroll.enable"), i.trigger("autoscroll.update", a) }), n.find(".lp-toc-container").on("click.listPlayer", ".item-name", function(t) { t.preventDefault(); var r = e(this).closest(".lp-item"),
                i = e.extend({}, o, { type: r.data("itemType"), id: r.data("itemId"), course: r.data("courseId") });
            n.trigger("listPlayer.playItem", i) }), n.find(".lp-player-container").find("video.player").on("loadstart.listPlayer", function() { console.log("loadstart"); var t = n.find(".lp-toc-container"),
                r = n.find(".lp-player-container").find("video.player").find("track").data("initial"),
                i = t.find(".lp-item.current"),
                a = e.extend({}, o, { id: i.data("itemId"), type: i.data("itemType"), course: i.data("courseId") }); if (r) return n.trigger("listPlayer.onload", a), void n.find(".lp-player-container").find("video.player").find("track").data("initial", null) }).on("play.listPlayer", function(t) { console.log("play"); var r = n.find(".lp-toc-container"),
                i = r.find(".lp-item.current"),
                a = e.extend({}, o, { id: i.data("itemId"), type: i.data("itemType"), course: i.data("courseId") });
            n.find(".lp-player-container").find(".mejs-time-float").hide(), n.trigger("listPlayer.updateNavButtonsState"), r.trigger("listPlayer.updatetoc", a), 0 === t.target.currentTime && n.find(".lp-player-container").find("video.player").data("logViews") && e.get("/ajax/listPlayer/viewedItem?itemId=" + +a.id + "&itemType=" + a.type, function(e) { i.attr("data-viewed", !0) }) }).on("playing.listPlayer", function(e) { n.find(".lp-player-container").find("video.player").get(0).playbackRate = n.find(".lp-player-container").find("video.player").data("playbackRate") || 1 }).on("next.listPlayer", function() { console.log("next"); var e = n.triggerHandler("listPlayer.getNextItem");
            n.triggerHandler("listPlayer.isLastItem", [e.id]) || n.trigger("listPlayer.playItem", e) }).on("previous.listPlayer", function() { console.log("previous"); var e = n.triggerHandler("listPlayer.getPreviousItem");
            e.id !== n.data("currentItemId") && n.trigger("listPlayer.playItem", e) }).on("ended.listPlayer", function() { console.log("ended"), n.trigger("listPlayer.video.ended") }).on("timeupdate.listPlayer", function(t) { var r = n.find(".lp-toc-container"),
                i = r.find(".lp-item.current");
            e.extend({}, o, { id: i.data("itemId"), type: i.data("itemType"), course: i.data("courseId") }) }).on("streamQuality.listPlayer", function(t, r) { n.find(".lp-player-container").find("video.player").data("quality", r || 540); var i = n.find(".lp-toc-container"),
                a = i.find(".lp-item.current"),
                l = e.extend({}, o, { id: a.data("itemId"), type: a.data("itemType"), course: a.data("courseId") }),
                d = []; try { d = JSON.parse(n.data("cdns")) } catch (t) { console.error("Error in retrieving CDN info.") } 0 === d.length ? n.trigger("listPlayer.playItem", [l, n.find(".lp-player-container").find("video.player").get(0).currentTime]) : n.trigger("listPlayer.playItemUrl", [null, l, n.find(".lp-player-container").find("video.player").get(0).currentTime]) }).on("continuousPlay.listPlayer", function(e, t) { n.find(".lp-player-container").find("video.player").data("continuousPlay", t) }).on("playbackRate.listPlayer", function(e, t) { n.find(".lp-player-container").find("video.player").data("playbackRate", t || 1) }).on("error.listPlayer", function(t) { var r = n.find(".lp-toc-container"),
                i = r.find(".lp-item.current"),
                a = e.extend({}, o, { id: i.data("itemId"), type: i.data("itemType"), course: i.data("courseId") });
            n.trigger("listPlayer.item.error", a) }).on("updatetime.listPlayer", function(e, t) { var r = n.find(".lp-player-container").find("video.player").get(0);
            r.currentTime = t, r.play() }), n.on("listPlayer.onload", function(t, r) { console.log("listPlayer.onload"); var i = n.find(".lp-toc-container"),
                a = n.find(".lp-player-container").find('link[rel="preroll"]').attr("href"),
                l = e(this).triggerHandler("listPlayer.getItemFromToc", [r]);
            l.length || (l = i.find(".lp-item:first")); var d = e.extend({}, o, { id: l.data("itemId"), type: l.data("itemType"), course: l.data("courseId") });
            n.data("currentItemId", d.id), a += "/" + d.course + "/" + d.id, e("body").trigger("before.video.start", a) }).on("listPlayer.video.ended", function(t) { var r = e(this).triggerHandler("listPlayer.getNextItem"),
                i = n.find(".lp-toc-container"); if (r) { var a = i.find(".lp-item.current"),
                    o = e(this).triggerHandler("listPlayer.getItemFromToc", [r]),
                    d = i.find('.lp-item[data-last-viewed="true"]');
                d.removeAttr("data-last-viewed"), a.attr("data-last-viewed", !0).removeClass("current"), o.addClass("upnext"), i.trigger("autoscroll.enable"), i.trigger("autoscroll.update", o) } var c = n.find(".lp-player-container").find('link[rel="postroll"]').attr("href");
            e.ajax({ url: c, success: function(e, t) { if (n.find(".lp-player-container").find(".mejs-postroll-layer-content").html(e.html), n.find(".lp-player-container").find("video.player").data("continuousPlay")) { var r = n.find(".lp-player-container").find(".postroll-default"),
                            i = r.find(".postroll-controls-next").find(".countdown").find(".countdown-time"),
                            a = n.find(".lp-toc-container");
                        r.data("countdown-time", n.find(".lp-player-container").data("nextVideoCountdown")), i.text(n.find(".lp-player-container").data("nextVideoCountdown"));
                        l = setInterval(function() { var e = parseInt(r.data("countdown-time"));
                            e = --e, i.text(e), r.data("countdown-time", e), e <= 0 && (clearInterval(l), a.find(".lp-item.upnext").find(".item-name").trigger("click")) }, 1e3) } } }), n.find(".lp-player-container").find(".mejs-postroll-layer.mejs-layer").show() }).on("listPlayer.item.change", function(e, t, r) { console.log("listPlayer.item.change"); var i = n.find(".lp-toc-container");
            i.trigger("listPlayer.updatetoc", t) }).on("listPlayer.item.error", function(e, t) { console.log("listPlayer.item.error", t) }) }), e.fn[t] = function() { return this.each(function(r) { e(this).hasClass("plugin_" + t) || e("body").trigger("listPlayer.add", [this, r]) }) }, e(function() { e(".lp").listplayerPlugin() }) }(jQuery);
! function(a) { a(function() { a("html").hasClass("legacy") && (a(".reactivation > .splash-bg").addClass("legacy"), a(".reactivation > .splash-overlay").addClass("legacy")) }); var i;
    (a("body").hasClass("am-overlay") || "True" === a("body").data("am")) && (a("body").on("click", ".am-link", function(o) { a("body").trigger("ga.event", { category: "acquisition migration", label: "acquisition migration: overlay opened", action: "impression" }); var e = a(this);
        o.preventDefault(), a(".video-modal").is(":visible") && a(".video-modal").hide(), window.scrollTo(0, 0), a(".aquisition > .migration-overlay-bg").fadeIn(), a(".aquisition > .migration-overlay").fadeIn(), i = setTimeout(function() { window.location = e.attr("href") }, 3e3) }), a("body").on("click", ".re-link", function(i) { a("body").trigger("ga.event", { category: "reactivation migration", label: "reactivation migration: overlay opened", action: "impression" }); var o = a(this);
        i.preventDefault(), a(".video-modal").is(":visible") && a(".video-modal").hide(), window.scrollTo(0, 0), a(".reactivation > .splash-bg").length ? (a(".reactivation > .splash-bg").addClass("loaded"), a(".reactivation > .splash-bg").fadeIn(400, function() { a(".reactivation > .splash-overlay").show(), a("#pane-reactivation").addClass("splashOpen").fadeIn() })) : window.location = o.attr("href") }), a("body").on("click", ".reactivation .btn", function(o) { var e = a(this);
        o.preventDefault(), a(".reactivation > .splash-overlay").hide(), a(".reactivation > .splash-bg").fadeOut(), a(".aquisition > .migration-overlay-bg").fadeIn(), a(".aquisition > .migration-overlay").fadeIn(), i = setTimeout(function() { window.location = e.attr("href") }, 3e3) }), "True" == a(".re-link").data("auto-redirect") && a(".re-link").click(), a("body").on("click", ".am-close", function(o) { clearTimeout(i), a("body").trigger("ga.event", { category: "acquisition migration", label: "acquisition migration: overlay closed", action: "impression" }), a(".migration-overlay-bg").fadeOut(), a(".migration-overlay").fadeOut() })) }(jQuery);
! function(e, t) { var n, a, r, o, i, s = { videoHeight: "100%", videoWidth: "100%", enableAutosize: !0, alwaysShowControls: !0, iPadUseNativeControls: !1, iPhoneUseNativeControls: !0, enableKeyboard: !0, pauseOtherPlayers: !0, skipBackInterval: 10, pluginPath: "/static/3rdparty/mejs/", keyActions: [], toggleCaptionsButtonWhenOnlyOne: !0, startLanguage: "", timeAndDurationSeparator: "<span> / </span>", features: "playpause,skipback,previous,next,progress,current,duration,volume,tracks,settings,fullscreen,customplaypause,customvolume,customfullscreen,customcc,custompopout".split(",") },
        c = 11,
        d = e("body");
    e(".player").each(function(l, u) {
        function p(s, c) { r && r[0] && r[0] === s || (r = e(s), a = r.parent(), o = a.find(".mejs-time-indicator"), i = a.find(".mejs-time-float-custom"), n = a.parents(".mejs-inner").find(".player")); var d = a.offset(),
                l = c.pageX - d.left,
                u = l - 23,
                p = r.width(),
                f = n.get(0).player.media.duration * (u / (p - 23));
            isNaN(f) || i.text(t.Utility.secondsToTimeCode(f, n.get(0).player.options)), u > p - 26 || u < -21 || (u > p - 46 ? i.css({ right: (u - p + 23).toString() + "px" }) : u < 0 ? i.css({ left: (-u).toString() + "px" }) : i.removeAttr("style"), o.css({ left: u.toString() + "px" })) }

        function f(t) { var n = e.cookie("player"); try { var a = e.extend(!0, {}, JSON.parse(n), t);
                e.cookie("player", JSON.stringify(a), { expires: 365, path: "/" }) } catch (r) {} }

        function g() { var t = e.cookie("player"); if (t) return JSON.parse(t) }

        function m(t) { var n = "";
            t.target && (n += "BASE URI: " + t.target.baseURI, n += " CURRENT SRC: " + t.target.currentSrc, n += " BROWSER UA: " + navigator.userAgent), y({ code: 9900, message: "VideoError: MEJS Player error", data: n }), k && e(k.media).trigger("video.error") }

        function y(t) { var n = "sessionId: " + lynda.sessionId + " browserId: " + lynda.browserId + " " + t.data;
            e.post("/ajax/player/log/error", { code: t.code, message: t.message, data: n }) } var v = e(u).data();
        v.features && v.features.length && (s.features = v.features.split(","), delete v.features), v = e.extend(!0, {}, s, v), v.error = m; var k = new t.MediaElementPlayer(u, v);
        e(k.container).on("exitedfullscreen", function(e) { "undefined" != typeof k.container[0] && setTimeout(function() { "undefined" != typeof t.players[k.container[0].id] && "undefined" != typeof t.players[k.container[0].id].setControlsSize && t.players[k.container[0].id].setControlsSize() }, 100) }), e(k.media).on("playUrl", function(t, n, a, r, o) {
            function i(e) { a >= 0 && (e.target.currentTime = a), e.target.removeEventListener("loadeddata", i) } k.isLoaded = !1; var s = n || e(k.media).data("src"); if (s && s.length && (n = s, e(k.media).data("src", "")), k.setSrc(n), k.play(), a) try { k.setCurrentTime(a) } catch (d) { d.code === c && e(k.media).one("playing", function() { k.setCurrentTime(a) }) } k.media.addEventListener("loadeddata", i) }).on("click", function(t) { e("body").trigger("ga.event", { action: "pause", label: "player-video-click-pause" }) }).on("seeked", function(t) { e("body").trigger("ga.event", { action: "seeked", label: "player-seeked" }), e(k).trigger("seeked") }).on("reset", function(e) { k.pause(), k.setCurrentTime(0) }).on("track.load", function(e, t) { if (k.tracks && k.tracks.length) { var n = k.tracks[0];
                n.src = t, n.isLoaded = !1, n.mode = "hidden", k.loadTrack(0) } }).on("track.set", function(e, t) { t && f({ ccLang: t }) }).on("loadedmetadata", function() { setTimeout(function() { var e = g();
                e && e.ccLang && k.setTrack(e.ccLang) }, 100) }).on("fullscreen", function() { k.enterFullScreen() }).on("settings.save", function(e, t) { f(t) }).on("log.message", function(e, t) { y(t) }).on("settings.get", function() { return g() }), e(k.container).on("mousemove", ".mejs-time-rail", function(e) { if (!d.hasClass("hasPopout")) { var t = { context: this, mouseEvent: e };
                d.trigger("player.timerail.adjust", t) } }), d.on("player.timerail.adjust", function(e, t) { p(t.context, t.mouseEvent) }) }) }(jQuery, window.mejs);
! function(t) { var e, o = t("body"),
        l = null,
        a = null;
    o.on("keyup", ".add-pl-name", function(e) { var o = t(e.currentTarget),
            l = o.val(),
            a = o.parents("form"); if (l.length > 0) { var i = a.find(".add-pl-btn");
            i.hasClass("disabled") && i.removeClass("disabled").attr("disabled", !1) } }), o.popover({ html: !0, container: "body", selector: ".copy-playlist", placement: "auto top", template: "<div class='popover dark-pop copy-pl-flyout'><div class='arrow'></div><h4 class='popover-title'></h4><div class='popover-content'></div></div>", content: function() { return t(".popover").not(this).popover("destroy"), t(".copy-playlist-confirm").clone().removeClass("hide").html() } }).on("shown.bs.popover", function(o) { var l = t(o.target),
            a = l.closest("li").find(".playlist-title").text();
        t(".popover").find("#copy-pl-name").val(a), e = l.data("playlistId") }).on("hide.bs.popover", function(e) { t(".copy-playlist-cont").removeClass("slider") }), o.popover({ html: !0, container: "body", selector: ".delete-playlist-item", placement: function(e, o) { var l = t(o).data("popover-position"); return void 0 != l && null != l ? l : "auto top" }, template: "<div class='popover dark-pop delete-pl-flyout'><div class='arrow'></div><div class='popover-content'></div></div>", content: function() { return t(".popover").not(this).popover("destroy"), t("#playlist-confirm-item-delete").clone().removeClass("hide").html() } }).on("shown.bs.popover", function(e) { var o = t(e.target);
        o.hasClass("delete-playlist-item") && o.parent(".action-buttons").addClass("active-popover-button") }).on("hide.bs.popover", function(e) { var l = t(e.target);
        l.hasClass("delete-playlist-item") && o.trigger("card.deactivate") }), o.on("focus", ".delete-playlist-item, .view-certificate", function(e) { var o = t(e.target);
        o.parent(".action-buttons").addClass("active-popover-button") }), o.on("blur", ".delete-playlist-item, .view-certificate", function(t) { o.trigger("card.deactivate") }), o.on("click", ".cancel-copy-playlist, .cancel-success-playlist", function(e) { t(".copy-playlist").popover("destroy"), e.preventDefault() }), o.on("click", ".playlist-confirm-cancel", function(e) { t(".delete-playlist-item").popover("destroy"), o.trigger("card.deactivate") }), o.on("click", ".playlist-delete-action", function(a) { null !== l && (t(".delete-pl-flyout").popover("hide"), l.addClass("removed-item"), setTimeout(function() { l.remove() }, 400), t.ajax({ url: "/ajax/playlist", data: { playlistId: e }, method: "DELETE" }).done(function(t) { 0 === t.playlists.PlaylistDeleteErrors && (o.trigger("playlist.delete", [e]), l = null) })) }), o.on("click", ".copy-pl-btn", function(e) { var l = t(e.target).closest("form");
        o.trigger("playlist.copy", [l]) }), o.on("click", ".goto-pl-btn", function() { null != a && (window.location.href = "/playlist/" + a) }), o.on("playlist.copy", function(l, i) { a = null, t.post("/ajax/playlist/copy", { playlistId: e, name: i.find("#copy-pl-name").val(), description: i.find("#copy-pl-desc").val() }).done(function(e) { var l = +e.PlaylistSaveErrors; if (0 === l || 8 === l) { var i = +e.PlaylistId;
                o.trigger("playlist.add", [i]), a = i, t(".copy-playlist-cont").addClass("slider") } }) }), o.on("keypress", ".copy-playlist-form", function(e) { if (13 === +e.keyCode) { e.preventDefault(); var l = t(this).closest("form");
            o.trigger("playlist.copy", [l]) } }), o.on("card.deactivate", function() { t(".active-popover-button").removeClass("active-popover-button") }) }(jQuery);
! function(a) {
    function t(t) { var l = a(t);
        0 !== l.length && (x = !!l.data("itemLevel"), a("html").hasClass("remove-pl") || l.popover("destroy").popover({ html: !0, animation: !1, placement: function(t, l) { x = !!a(l).data("itemLevel"), !x && a(l).data("videoId") && (currentVideoId = a(l).data("videoId")), y(a(l), a(t)); var e = a(l).data("popover-position"); return void 0 != e && null != e ? e : a(window).width() < 768 ? "auto bottom" : "auto right" }, template: '<div class="popover popover-instance dark-pop pl-flyout' + (x ? " pl-flyout-item-level" : "") + '"><div class="arrow"></div><div class="popover-content"></div></div>', content: function() { return a(".popover").not(this).popover("hide"), a(".pl-flyout").clone().removeClass("hide").html() } }).on("shown.bs.popover", function(t) { if (a(t.target).hasClass("playlist-control")) { f(), j && (j = !1); var l = a(t.target);
                I = a(".pl-flyout.popover-instance"), I && I.find(".add-new-playlist button").focus(), x = !!l.data("itemLevel") && !!l.data("itemLevel"), currentVideoId = currentVideoId, l.addClass("active-popover-button"), h.trigger("playlist.popover.available", l) } }).on("hide.bs.popover", function(t) { a(t.target).hasClass("playlist-control") && (contextItem = null, a(".active-popover-button").removeClass("active-popover-button"), a(".playlist-control-cont").removeClass("slider")) }), h.trigger("playlist.control.initComplete", l)) }

    function l() { a(".playlist-control").popover("hide"), a(".playlist-control-cont").removeClass("slider") }

    function e(a, t, l) { if (I && x) { var e = I.find("li[data-playlist-id=" + +a + "]"),
                i = e.find(".playlist-item-types button[data-item-type=" + t + "]"); "delete" === l ? i.removeClass("btn-primary").addClass("btn-secondary") : "add" === l && i.removeClass("btn-secondary").addClass("btn-primary"), i.find("i").toggleClass("hide"); var s = e.find(".playlist-item-types"),
                n = e.find(".playlist-item-status-icon");
            s.find(".btn-primary").length > 0 ? n.removeClass("plus-sign").addClass("checkmark") : n.addClass("plus-sign").removeClass("checkmark"), C ? s.hide() : s.addClass("fadeOut"), m() } }

    function i(t, l, e, i) { x || i.find(".playlist-item-status-icon").removeClass("checkmark").addClass("svg loading-white"), a.ajax({ url: "/ajax/playlist/item", data: { itemId: +t, playlistId: +e, itemType: l }, method: "DELETE" }).done(function(a) { return a.pl.Success ? (i.removeClass("added"), x && i.removeClass("btn-primary").addClass("btn-secondary"), void h.trigger("playlist.item.delete", [+e, +t, l])) : void i.find(".playlist-item-status-icon").removeClass("svg loading-white").addClass("checkmark") }) }

    function s(t, l, e, i) { x || i.find(".playlist-item-status-icon").removeClass("plus-sign").addClass("svg loading-white"), a.post("/ajax/playlist/item", { itemId: +t, playlistId: +e, itemType: l }).done(function(a) { var s = +a.pl.PlaylistItemSaveErrors; return 0 === s || 1 === s ? (i.addClass("added"), void h.trigger("playlist.item.add", [+e, +t, +l])) : void i.find(".playlist-item-status-icon").removeClass("svg loading-white").addClass("plus-sign") }) }

    function n() { if (I) { var t = I.find(".add-pl-name"),
                l = t.val(),
                e = I.find(".add-pl-desc").val(),
                i = +k.data("courseId") || 0,
                s = g; if (0 === i) + k.data("videoId") > 0 ? (s = b, i = +k.data("videoId"), d(l, e, i, s)) : o(l, e);
            else { if (x) { var n = a(".create-playlist .playlist-item-types button.btn-primary");
                    s = +n.data("itemType") || g, i = s === b ? currentVideoId : i } d(l, e, i, s) } } }

    function o(t, e) { a.ajax({ url: "/ajax/playlist", data: { name: t, description: "Optional" === e ? "" : e }, method: "PUT" }).done(function(a) { var l = +a.pl.PlaylistId;
            0 === +a.pl.PlaylistSaveErrors ? h.trigger("playlist.add", [+l, t, e]) : console.log(a.pl.PlaylistSaveErrorsString) }).always(l) }

    function d(t, l, e, i) { a.post("/ajax/playlist/createplaylistwithitem", { name: t, description: "Optional" === l ? "" : l, itemId: +e, itemType: i }).done(function(s) { var n = +s.pl.PlaylistItemSaveErrors,
                o = +s.pl.PlaylistId; if (0 === n && (k.addClass("added"), h.trigger("playlist.add", [+o, t, l, +e, i]), h.trigger("playlist.item.add", [+o, +e, i]), a(".playlist-control-cont").removeClass("slider"), x)) { E = null, f(), a(".add-pl-name, .add-pl-desc").val(""); var d = a(".pl-flyout-item-level.popover-instance .create-playlist .playlist-item-types button");
                d.removeClass("btn-primary").addClass("btn-secondary"), d.last().addClass("btn-primary").removeClass("btn-secondary") } }) }

    function r() { if (I) { var a = I.find(".playlists-flyout-menu");
            a.length > 0 && a.children().length > 4 ? a.addClass("fl-scroll") : a.removeClass("fl-scroll") } }

    function p(t, l, e, i) { if (k) { if (i === g) { var s = [],
                    n = k.data("playlistIds");
                n && (s = n.toString().split(",")), s.length > 0 && (s = s.map(Number)), "add" === t && s.indexOf(l) === -1 ? s.push(l) : "delete" === t && s.splice(a.inArray(l, s), 1), k.data("playlistIds", s.join(",")) } if (x || i === b) { if (I) { var o = I.find("li[data-playlist-id=" + +l + "]");
                    c(o, t, e) } var d = a(".pl-flyout-item-level:not(.popover-instance)"); if (d) { var r = d.find("li[data-playlist-id=" + +l + "]");
                    c(r, t, e) } } } }

    function c(t, l, e) { var i = [],
            s = t.data("playlistItemIds");
        s && (i = s.toString().split(",")), i.length > 0 && (i = i.map(Number)), "add" === l ? i.push(e) : "delete" === l && i.splice(a.inArray(e, i), 1), t.data("playlistItemIds", i.join(",")), t.attr("data-playlist-item-ids", i.join(",")) }

    function y(t, l) { if (t && l && (k = t, I = l), a("html").hasClass("remove-pl") && u(), k && I) { var e = k.data("playlistIds");
            e ? (e = e.toString().split(","), e.forEach(function(a) { var t = I.find("li[data-playlist-id=" + +a + "]");
                t.length > 0 && (t.addClass("added"), t.find(".playlist-item-status-icon").removeClass("plus-sign").addClass("checkmark")) })) : I.find(".playlist-item-status-icon.checkmark").removeClass("checkmark").addClass("plus-sign"); var i = +k.data("itemType") || g; if (x || i === b) { x && a(".pl-flyout-item-level.popover-instance .update-playlists .playlist-item-types button").removeClass("btn-primary").addClass("btn-secondary"); var s = +k.data("courseId");
                I.find("li").each(function(t, l) { var e = a(l).data("playlistItemIds"); if (!e) return !0; var n = e.toString().split(","); if (n.length > 0 && (n = n.map(Number)), n.indexOf(currentVideoId) > -1 && (i === b && a(l).addClass("added"), a(l).find(".playlist-item-status-icon").removeClass("plus-sign").addClass("checkmark"), x)) { var o = a(l).find(".playlist-item-types button[data-item-type=" + b + "]");
                        o.removeClass("btn-secondary").addClass("btn-primary"), o.find("i").removeClass("hide") } if (n.indexOf(s) > -1) { var d = a(l).find(".playlist-item-types button[data-item-type=" + g + "]");
                        d.removeClass("btn-secondary").addClass("btn-primary"), d.find("i").removeClass("hide") } }) } m() } }

    function m() { if (k && I) { var a = k.hasClass("playlist-status-icon") ? k : k.find(".playlist-status-icon");
            0 === I.find(".playlist-item-status-icon.checkmark").length ? (a.hasClass("checkmark") && a.removeClass("checkmark").addClass("plus-sign"), a.siblings(".single-bookmark").removeClass("bookmarked").addClass("bookmark-outline")) : (a.addClass("checkmark").removeClass("plus-sign"), a.siblings(".single-bookmark").addClass("bookmarked").removeClass("bookmark-outline")) } }

    function u() { if (k) { var a = k.find(".single-bookmark");
            k.is("#btn-single-bookmark") ? k.hasClass("added") ? a.addClass("active").removeClass("inactive") : a.removeClass("active").addClass("inactive") : k.hasClass("added") ? a.addClass("bookmarked").removeClass("bookmark-outline") : a.removeClass("bookmarked").addClass("bookmark-outline") } }

    function v() { if (I) { var a = I.find("button").first();
            a && a[0] && a[0].focus && a[0].focus() } }

    function f() { if (w || !k) return v(); if (I) { var t = I.find(".popover-content .playlists-flyout-menu"); if (t) { if (null !== E) return t.html(E), h.trigger("playlist.popover.refresh"), v();
                w = !0, j && t.addClass("loading"), a.get("/ajax/playlists").done(function(a) { a && a.html && 0 !== a.html.length && (t.html(a.html), E = a.html, t.removeClass("loading"), h.trigger("playlist.popover.refresh")) }).always(function() { w = !1, v() }) } } } var h = a("body"),
        C = !a("html").hasClass("no-touch"),
        g = 1,
        b = 3,
        k = null,
        I = null,
        w = !1,
        E = null,
        j = !0,
        x = !1;
    currentVideoId = 0, h.on("playlist.popover.available", function(t, l) { var e = a(l ? l : this);
        a(".add-playlist-btn"), e.data("screenVersion") || "total";
        k = e, r(), I && 0 === I.find(".add-new-playlist").length && I.find(".playlist-control-cont").css({ height: "auto" }) }), h.on("playlist.popover.refresh", function() { y(k, I), r() }), h.on("click", ".playlists-flyout-menu li:not(.add-new-playlist)", function(t) { var l = a(this),
            e = +l.data("playlistId"),
            n = +k.data("courseId") || 0,
            o = g; if (0 === n && +k.data("videoId") > 0 && (n = +k.data("videoId"), o = b), x) { var d = l.find(".playlist-item-types"); return C ? d.show() : d.removeClass("fadeOut"), a(".playlists-flyout-menu .playlist-item-types").not(d).addClass("hide"), void d.toggleClass("hide") } l.hasClass("added") ? i(n, o, e, l) : s(n, o, e, l) }), h.on("click", ".action-playlist", function(a) { if (a.originalEvent && a.originalEvent.path)
            for (var t = 0; t < a.originalEvent.path.length; t++) { if ("course-list" === a.originalEvent.path[t].id) { lynda.jsPlaylistPosition = "courseList"; break } if ("featured-courses" === a.originalEvent.path[t].id) { lynda.jsPlaylistPosition = "featuredCourses"; break } } a.preventDefault() }), a(document).on("click", ".remove-pl .action-playlist, #btn-single-bookmark", function() { var t = a(this);
        k = t, popoverTriggerEle = null; var l = a(".playlists-flyout-menu").find("li[data-playlist-id]").first().data("playlist-id"),
            e = a(this).data("course-id");
        t.hasClass("added") ? i(e, g, l, t) : s(e, g, l, t) }), h.on("playlist.add", function(a, t, l, e) { E = null, h.trigger("ga.event", { action: "add", label: "playlist", value: t }), p("add", t, 0, g), r() }), h.on("playlist.item.add", function(a, t, l, i) { E = null, h.trigger("ga.event", { action: "add", label: "playlist-item", value: l }), p("add", t, l, i), e(t, i, "add"), r() }), h.on("playlist.item.delete", function(a, t, l, i) { E = null, h.trigger("ga.event", { action: "delete", label: "playlist-item", value: l }), p("delete", t, l, i), e(t, i, "delete"), r() }), h.on("click", ".update-playlists .playlists-flyout-menu .playlist-item-types button", function(t) { var l = a(this).closest(".playlist-item-types"); if (C) l.show();
        else if (l.hasClass("fadeOut")) return l.removeClass("fadeOut"), !1; var e = a(this).data("itemType") || g,
            n = a(this).closest("li[data-playlist-id]"),
            o = n.data("playlistId"),
            d = e === g ? +k.data("courseId") : currentVideoId,
            r = a(this).hasClass("btn-primary"); return r ? i(d, e, o, n) : s(d, e, o, n), a(this).blur(), !1 }), h.on("click", ".create-playlist .playlist-item-types button", function(t) { a(".create-playlist .playlist-item-types button").removeClass("btn-primary").addClass("btn-secondary"), a(this).addClass("btn-primary").removeClass("btn-secondary") }), h.on("course.video.change", function(a, t, l) { currentVideoId = l, y(k, I) }), h.on("playlist.rename playlist.delete playlist.add playlist.item.add playlist.item.delete", f), h.on("click", ".playlist-control-close, .cancel-add-playlist", l), h.on("click", ".add-new-playlist", function() { a(".playlist-control-cont").addClass("slider"), a(".add-pl-name").focus(), a(".create-new-playlist .playlist-item-types")[x ? "removeClass" : "addClass"]("hide") }), h.on("click", ".playlist-control-title, .back-to-list", function() { a(".playlist-control-cont").removeClass("slider"), a(".add-pl-name").blur() }), h.on("click", ".add-pl-btn", function(a) { if (a.preventDefault(), I) { var t = I.find(".add-pl-name");
            t.length > 0 && t.val().length > 0 && n() } }), h.on("keyup", ".add-pl-name", function(a) { if (I) { var t = I.find(".add-pl-name"); if (t.length > 0 && t.val().length > 0) { var l = I.find(".add-pl-btn");
                l.hasClass("disabled") && l.removeClass("disabled").attr("disabled", !1) } } }).on("keypress", ".pl-flyout.popover input", function(a) { if (13 === +a.keyCode) { if (!I) return;
            a.preventDefault(); var t = I.find(".add-pl-name");
            t.length > 0 && t.val().length > 0 && n() } }), h.on("keydown", ".playlist-control", function(t) { var l = a(this);
        l && l[0] && l[0].click && 13 == t.keyCode && (t.preventDefault(), a(this)[0].click()) }), h.on("playlist.control.init", function(l) { a(".playlist-control").each(function(a, l) { t(l) }) }), h.trigger("playlist.control.init") }(jQuery);
! function(l) { l("body").on("click", ".playlist-follow", function(o) { var s = l(this),
            a = +s.data("playlistId"),
            i = s.closest(".playlist-follow").first();
        s.hasClass("following") ? l.post("/ajax/playlist/unfollow", { subscriptionId: s.data("subscriptionId") }) : l.post("/ajax/playlist/follow", { playlistId: a }), i.toggleClass("following"), i.children(".follow-icon").toggleClass("plus-sign checkmark") }) }(jQuery);
! function(o) { var e = o("body");
    e.on("click", function(e) { var n = o(e.target),
            t = n.closest(".popover").length > 0,
            r = n.closest(".popover-trigger").length > 0 || n.hasClass("btn"),
            p = n.closest("[role=menuitem]").length > 0;
        t === !1 && r === !1 && p === !1 && o(".popover").popover("hide") }), e.on("keydown", function(e) { 27 === e.keyCode && o(".popover").popover("hide") }) }(jQuery);
! function(a) { a("body").on("click", ".rating input", function() { var t = a(this).closest(".rating"),
            e = t.find("input:checked").val(),
            i = t.data("urn"),
            n = t.data("previousValue") || void 0; if (void 0 != i && (void 0 == n || e != n)) { var r = a("body").attr("data-jstracking-page-key");
            void 0 === r && (r = lynda.jsTrackingPageKey), a.post("/ajax/user/ratings", { urn: i, value: e, pageKey: r }).done(function(n) { "ok" === n.Status ? t.data("previousValue", e) : t.find("input:checked").attr("checked", !1), a("body").trigger("user.ratings.rated", { urn: i, value: e }) }) } }) }(jQuery);
! function(e) {
    function t(e, t, n) { var r = document.createElement("input");
        r.type = "text", r.name = t, r.value = n, e.appendChild(r) }

    function n(e) { var t = new Date; return new Date(t.getMonth() + 1 + "/" + t.getDate() + "/" + t.getFullYear() + " " + e) }

    function r(e, t, n, r, a, u) { var o = r.length > 0 ? "&recur=" + r : ""; return encodeURI("https://calendar.google.com/calendar/render?action=TEMPLATE&text=" + e + "&details=" + t + "&location=Lynda.com&url=" + n + o + "&dates=" + a + "/" + u) }

    function a(e, t, n, r, a, u) { var o = r.length > 0 ? "&rpat=" + r : ""; return encodeURI("https://calendar.yahoo.com/?v=60&view=d&type=20&title=" + e + "&desc=" + t + "&in_loc=Lynda.com&url=" + n + o + "&st=" + a + "&dur=" + u) }

    function u(e) { var t = e.toISOString(); return t = t.replace(/-/g, ""), t = t.replace(/:/g, ""), t = t.replace(".000", "") }

    function o(e) { return e.getFullYear() + "" + m(e.getMonth() + 1, 2) + m(e.getDate(), 2) + "T" + m(e.getHours(), 2) + m(e.getMinutes(), 2) + "00" }

    function i(e) { var t = [],
            n = [],
            r = []; return e.sunday && (t.push(0), n.push("SU"), r.push("SUNDAY")), e.monday && (t.push(1), n.push("MO"), r.push("MONDAY")), e.tuesday && (t.push(2), n.push("TU"), r.push("TUESDAY")), e.wednesday && (t.push(3), n.push("WE"), r.push("WEDNESDAY")), e.thursday && (t.push(4), n.push("TH"), r.push("THURSDAY")), e.friday && (t.push(5), n.push("FR"), r.push("FRIDAY")), e.saturday && (t.push(6), n.push("SA"), r.push("SATURDAY")), { dayNumbers: t, dayLetters: n, dayWords: r } }

    function d(e, t) { for (var n = ["SU", "MO", "TU", "WE", "TH", "FR", "SA"], r = [], a = 0; a < e.length; a++) { var u = e[a];
            r.push(n[(u + t) % 7]) } return r }

    function s(e) { var t = e.getFullYear(); return 0 == (3 & t) && (t % 100 != 0 || t % 400 == 0) }

    function l(e) { var t = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334],
            n = e.getMonth(),
            r = e.getDate(),
            a = t[n] + r; return n > 1 && s(e) && a++, a }

    function c(e) { var t = ""; return e.length > 0 && (t = "RRULE:FREQ=WEEKLY;WKST=SU;BYDAY=" + e.join()), t }

    function p(e) { var t = ""; return e.length > 0 && (t = "1wk" + e.join("")), t }

    function h(e) { return m(e, 4) }

    function m(e, t) { return _.padLeft(e, t, "0") } var g = e("body");
    g.on("reminders.calendar.create", function(s, m) { if ("undefined" != typeof m) { var g = n(m.time),
                y = new Date(g.getUTCFullYear(), g.getUTCMonth(), g.getUTCDate(), g.getUTCHours(), g.getUTCMinutes(), g.getUTCSeconds()),
                f = l(y) - l(g);
            g.getTime() <= Date.now() && g.setDate(g.getDate() + 1); var D = i(m),
                T = d(D.dayNumbers, f),
                v = D.dayNumbers.join(); if (v.length > 0)
                for (; v.indexOf(g.getDay()) === -1;) g.setDate(g.getDate() + 1); var U = (new Date).getTime(),
                E = Math.floor(99999 * Math.random()),
                M = "reminder-" + E + "-" + U + "@lynda.com",
                S = new Date(g.getTime());
            S.setMinutes(g.getMinutes() + +m.duration); var w = ""; if ("google" === m.client) w = r(m.summary, m.details, m.url, c(T), o(g), o(S)), window.open(w);
            else if ("yahoo" === m.client) w = a(m.summary, m.details, m.url, p(D.dayLetters), u(g), h(m.duration)), window.open(w);
            else { var Y = c(D.dayLetters),
                    A = o(g),
                    C = o(S),
                    R = document.createElement("form");
                R.method = "POST", R.action = "/reminders/calendar/ics/download"; var L = document.createElement("input");
                L.type = "hidden", L.name = "-_-", L.value = lynda["-_-"], R.appendChild(L), t(R, "uid", M), t(R, "timestamp", U), t(R, "startTime", A), t(R, "endTime", C), t(R, "summary", m.summary), t(R, "details", m.details), t(R, "url", m.url), t(R, "repetition", Y), document.body.appendChild(R), R.submit() } e("body").trigger("li.track.action", ["ReminderCreationEvent", { courseUrn: m.courseUrn, daysOfTheWeek: D.dayWords, startDate: g.getTime(), reminderDurationInMinutes: m.duration, calendarClient: m.client.toUpperCase() }]) } }) }(jQuery);
! function() { var e = window.performance; if (e && e.timing && lynda.requestId && lynda.renderTime) { var n = e.navigation,
            i = { requestId: lynda.requestId, loggingModule: lynda.loggingModule, timing: JSON.parse(JSON.stringify(e.timing)), perfNav: n ? { navTypeID: n.type, redirectCount: n.redirectCount } : null };
        i.timing.renderTime = lynda.renderTime, $.post("/ajax/timing/request", i) } }();
! function(t) {
    function n(n) {
        function i(t, n) { c.stop(!0), c.animate({ scrollLeft: t + "px" }, n || 500, "swing", function() { r(), e.trigger("scrolly.scrollComplete", c) }), e.trigger("scrolly.flip", c) }

        function l(t, n) { t.position().left < 0 || t.position().left >= n ? t.attr("data-active", 0) : t.attr("data-active", 1) }

        function r() { var n = parseInt(c.css("marginLeft")),
                e = parseInt(c.css("marginRight")),
                i = c.outerWidth(),
                r = 0;
            w = t.map(c.find(">li").toArray(), function(e) { var e = t(e),
                    r = e.outerWidth(!0),
                    o = Math.floor(c.scrollLeft() + e.position().left) + n,
                    a = o - n,
                    s = o + r,
                    f = e.find("." + g),
                    d = f.length ? f.first() : e; return l(e, i), { scrollLeft: a, left: o, width: r, right: s, firstItemOnPage: d } }); var o = w[0].left; if (O = t.grep(w, function(t) { if (t.right > o) return o = t.left + i, !0 }), r = w[w.length - 1].right, O.length > 1) { var a = O.pop();
                O.push({ scrollLeft: r - i - e, right: r, firstItemOnPage: a.firstItemOnPage }) } }

        function o(t, n) { n && t.hasClass("disabled") ? t.removeClass("disabled") : n || t.hasClass("disabled") || t.addClass("disabled") }

        function a() { o(m, b > 0), o(v, b < O.length - 1) }

        function s() { var n = c.scrollLeft(),
                e = t.grep(O, function(t) { if (t.scrollLeft >= n) return !0 })[0];
            e && (b = I = O.indexOf(e)) }

        function f() { s(), a(); var n = g && g.length ? c.find("li:not(.prepended) ." + g) : c.children(),
                e = O[b].firstItemOnPage,
                i = n.index(e); if (i && (M = Math.abs(i - x) || 1, x = i), b >= O.length - 1 - h && !y && !C && d) { y = !0; var l = d + (d.indexOf("?") > -1 ? "&" : "?") + "start=" + n.length + "&limit=" + M * u;
                L && (l += "&" + L.identifier + "=" + L.selectedValue), t.get(l).done(function(t) { t.html || (C = !0), c.append(t.html), r(), f() }).always(function() { y = !1 }) } } var c = t(n),
            d = c.data("pagingUrl"),
            g = c.data("itemClass"),
            u = 2,
            h = 2,
            p = t(c.data("pagingContainer")),
            m = p.find(".slider-left"),
            v = p.find(".slider-right"),
            y = !1,
            C = !1,
            L = null,
            b = 0,
            I = 0,
            O = [],
            w = [],
            x = 0,
            M = 0;
        r(), c.on("scrolly.filter.before", function(t, n) { L = n }).on("scrolly.filtered scrolly.items.update", function(t) { c.scrollLeft(0), b = 0, I = 0, a() }), c.on("scroll", _.debounce(f, e.hasClass("no-touch") ? 0 : 250)), t(window).on("resize", _.debounce(function() { r(), i(O[b].scrollLeft, 0) }, 250)), p.find(".flipper").click(function(n) { r(); var e = t(n.currentTarget).hasClass("slider-left") ? I - 1 : I + 1;
            e = Math.min(Math.max(parseInt(e), 0), O.length - 1), e !== I && (I = e, i(O[I].scrollLeft)) }), r(), c.length && a(), e.trigger("scrolly.initComplete", c) } var e = t("body");
    e.on("scrolly.init", function(t, e) { n(e) }), t(".scrolly").each(function(t, e) { n(e) }) }(jQuery);
! function(e) { e(".carousel-filter").each(function(r, l) { var o = e(l),
            t = e(o.data("carouselSelector")); return t && 0 !== t.length ? void o.on("dropdown.change", function(r, l, n) { var i = o.data("filterIdentifier"),
                c = t.data("filterUrl");
            t.trigger("scrolly.filter.before", { selectedValue: n, identifier: i }), e.get(c + (n ? (c.indexOf("?") < 0 ? "?" : "&") + i + "=" + n : "")).done(function(e) { var r = e.html.replace(/(\r\n|\n|\r)/gm, "");
                console.log("scrolly", t), t.html(r), t.trigger("scrolly.filtered") }) }) : void console.log("scrolly filter could not find an associated scrolly.") }) }(jQuery);
! function(t) { var e = t("body"),
        a = lynda.translate("+ Show More"),
        n = lynda.translate("- Show Less"),
        i = lynda.translate("<%= showText %> results for <%= title %>");
    t(".show-more").each(function(a, n) { n = t(n); var i = n.data("pageSize") || 20,
            l = n.data("moreUrl"); if (l && 0 !== l.length) { var r = n.siblings(".show-more-container"); if (r && 0 !== r.length) { var o = r.find("button"); if (o && 0 !== o.length) { var s = r.find(".show-more-spinner"); if (s && 0 !== s.length) { n.find(".card-cont").length < i && r.addClass("hide"); var d = !1,
                            h = !1,
                            c = "";
                        e.on("more.url", function(t, e) { c = e }), o.on("click", function() { if (!d && !h) { var a = n.find(".card-cont").length,
                                    o = l + "?start=" + a + "&limit=" + i;
                                t.each(t("[data-more-param]"), function(e, a) { var a = t(a),
                                        n = a.data("moreParam"),
                                        i = a.data("moreParamDelimiter"),
                                        l = a.hasClass("dropdown") ? a.find(".selected") : a,
                                        r = l.val && l.val().length > 0 ? l.val() : l.attr("data-value");
                                    i ? n.split(i).forEach(function(t, e) { o += "&" + t + "=" + r.split(i)[e] }) : o += "&" + n + "=" + r }), c.length > 0 && (o += c), d = !0, s.removeClass("hide"), t.get(o).done(function(t) { t.html && 0 !== _.trim(t.html).length ? (n.append(t.html), e.trigger("more.load", n)) : (h = !0, e.trigger("more.done", n), r.addClass("hide")) }).always(function() { s.addClass("hide"), d = !1 }) } }) } } } } }), e.on("click", ".truncate+.show-more", function(e) { e.preventDefault(), t(this).hide().prev().removeClass("truncate") }), e.on("click", ".truncate +p .show-more", function(e) { e.preventDefault(), t(this).hide().parent().prev().removeClass("truncate") }), e.on("init-truncated-list", function(e, n) { var l = t(n),
            r = l.data("filterMax"),
            o = l.find("li").length,
            s = l.data("sectionTitle");
        o > r && 0 === l.find(".filter-toggle").length && l.find("li:gt(" + (r - 1) + ")").hide().end().append('<li class="show-more-toggle"><button class="btn btn-link"><span class="sr-only">' + _.template(i)({ showText: a, title: s }) + '</span><span aria-hidden="true">' + a + "</span></button></li>") }), t(".truncated-list").each(function(t, a) { e.trigger("init-truncated-list", a) }), e.on("click", ".show-more-toggle", function(e) { e.preventDefault(); var l = t(this),
            r = l.find("button"),
            o = l.closest(".truncated-list"),
            s = o.data("filterMax"); if (r.length) { var d = o.data("sectionTitle"),
                h = r.find('span[class="sr-only"]'),
                c = r.find('span[aria-hidden="true"]');
            o.toggleClass("opened"), l.siblings(":gt(" + (s - 1) + ")").toggle(), r.toggleClass("more"), r.hasClass("more") ? (h.html(_.template(i)({ showText: n, title: d })), c.html(n), r.attr("aria-expanded", !0), o.find(".first-hidden").focus()) : (h.html(_.template(i)({ showText: a, title: d })), c.html(a), r.attr("aria-expanded", !1)) } }) }(jQuery);
! function(t) {
    function e() { var e = t("li.toc-video-item.current"),
            a = e.data("video-id"),
            r = e.data("video-freeview"),
            i = t("#embed-share-url"),
            n = i.data("course-url"),
            s = i.data("course-title"),
            l = i.data("course-description"),
            d = i.data("author-id"),
            c = i.data("author-name");
        t(".video-locked-msg").addClass("hide"), r || (t(".video-locked-msg").removeClass("hide"), a = t("#course-page").data("initial-video-id"), t(".embed-tab").data("ga-label", "embed-tab-locked"), i.find("button").data("ga-label", "embed-share-url-copy-locked")); var u = o(a, n, s, l, d, c);
        t(".embed-share-html").val(u); var p = t(".toc-video-item.current a").text().trim();
        t(".embed-video-title").text(p) }

    function o(t, e, o, a, r, i) { return "<iframe width='560' height='315' src='https://www.lynda.com/player/embed/" + t + "?fs=3&w=560&h=315&ps=paused&utm_medium=referral&utm_source=embed+video&utm_campaign=ldc-website&utm_content=vid-" + t + "' mozallowfullscreen='true' webkitallowfullscreen='true' allowfullscreen='true' frameborder='0'></iframe><div style=\"margin-bottom:10px\"><strong><a href=\"" + e + '" title="' + a + '">' + o + '</a></strong> by <a href="https://www.lynda.com/author/' + r + '">' + i + "</a></div>" } if (0 !== t(".social-share-control").length) { var a = t("body"),
            r = null,
            i = navigator.userAgent.toLowerCase(),
            n = /safari/.test(i) && !/chrome/.test(i),
            s = (a.popover({ html: !0, animation: !1, container: ".course-actions", selector: ".social-share-control", placement: function(e, o) { var a = t(o).data("popover-position"); return void 0 != a && null != a ? a : t(window).width() < 768 ? "auto bottom" : "auto right" }, template: "<div class='popover dark-pop ss-flyout social-share-popover'><div class='arrow'></div><div class='popover-content'></div></div>", content: function() { return t(".popover").not(this).popover("hide"), t(".ss-flyout").clone().removeClass("hide").html() } }).on("shown.bs.popover", function(o) { if (t(o.target).hasClass("social-share-control")) { var a = t(o.target);
                    r = t(".ss-flyout.popover"); var i = t("#org-share-url input").val(); if (i) { var s = i.split("?").pop(),
                            l = window.location.protocol + "//" + window.location.host + window.location.pathname + "?" + s;
                        i != l ? (t("#org-share-video").removeClass("hide"), t("#org-share-video input").val(l).select()) : t("#org-share-url input").select() } n && t(".org-share").addClass("hide-copy-button"), a.addClass("active-popover-button"), n && t(".share-controls").addClass("no-button"), e() } }), { linkedin: "https://www.linkedin.com/cws/share?url=<%= url %>&trk=<%= source %>", facebook: "https://facebook.com/sharer.php?u=<%= url %>&t=<%= description %>", twitter: "https://twitter.com/intent/tweet?text=<%= title %><%= twitterHandle %> +<%= url %>&via=<%= source %>" });
        a.on("click", ".share-item", function(e) { var o = t(this),
                a = t(this).data("network"); if (t(this).hasClass("share-cert")) var r = t(".cert-options").data("ga-url") + "&utm_medium=certificateshare&utm_source=" + a,
                i = t(".cert-options").data("ga-title") + lynda.OpenGraphCertTitle;
            else var r = t('meta[property="og:url"]').attr("content"),
                i = t('meta[property="og:title"]').attr("content"); var n = t('meta[name="twitter:creator"]').attr("content"),
                l = "";
            null != n && (l = " by @" + n); var d = t('meta[property="og:description"]').attr("content"),
                c = _.template(s[a]),
                u = t('meta[name="twitter:hashtags"]').attr("content"),
                p = u;
            null != u && (p = u.replace(" + ", " & #")); var d = t('meta[property="og:description"]').attr("content"),
                c = _.template(s[a]),
                u = t('meta[name="twitter:hashtags"]').attr("content"),
                p = u;
            null != u && (p = u.replace(" + ", " & #")); var h = ""; if ("twitter" === o.data("network")) { var m = _.template(o.data("twitterTitle"));
                h = m({ hashTag: p, title: i }) } var v = c({ url: encodeURIComponent(r), title: encodeURIComponent(h), description: encodeURIComponent(d), twitterHandle: encodeURI(l), source: "lynda" });
            window.open(v, "shareDialog", "width=626,height=436") }); var l, d = []; if (t("#org-share-url").length > 0 && void 0 !== typeof Clipboard && (l = new Clipboard("#org-share-url button"), d.push(l)), t("#org-share-video").length > 0 && void 0 !== typeof Clipboard && (l = new Clipboard("#org-share-video button"), d.push(l)), t("#public-share-url").length > 0 && void 0 !== typeof Clipboard && (l = new Clipboard("#public-share-url button"), d.push(l)), t("#embed-share-url").length > 0 && void 0 !== typeof Clipboard && (l = new Clipboard("#embed-share-url button"), d.push(l)), d.length > 0)
            for (var c = 0, u = d.length; c < u; c++) d[c].on("success", function(e) { var o = t("#clipboardConfirmation");
                o.addClass("show").text(e.trigger.getAttribute("data-confirm")), setTimeout(function() { o.addClass("fadeOut"), a.one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function(t) { "clipboardConfirmation" === t.target.id && o.removeClass("show fadeOut") }) }, 3e3) }).on("error", function() { var e = t("#clipboardConfirmation");
                e.addClass("show").text(e.data("error")) });
        a.on("click", ".social-share-popover input", function() { this.setSelectionRange(0, this.value.length) }), a.on("click", ".fader", function() { t(this).siblings("input").select() }), a.on("click focus", ".share-controls .lyndacon.link", function() { var e = t(this).siblings("button");
            e.is(":visible") ? e.click() : e.siblings("input").select() }) } }(jQuery);
! function(t) { t("[data-sticky-container]").each(function(n, i) {
        function o() { var n = a.offset().top;
            s(); for (var i = 0; i < c.length; i++)
                for (var o = t(c[i]), d = o.find(e), f = n, r = 0, u = 0; u < d.length; u++) { var p = t(d[u]),
                        y = p.outerHeight(),
                        k = p.parent(),
                        l = k.offset().top,
                        h = l + k.outerHeight(); if (l < f) { var g = h - (r += y) - n;
                        k.css("paddingTop", y), p.addClass("sticky").css("z-index", "").css({ top: -n + f + (g < 0 ? g : 0), width: k.outerWidth(), "z-index": +p.css("z-index") + d.length - u }), f += y } } }

        function s() { a.find(".sticky").removeClass("sticky").parent().css("paddingTop", "") } var a = t(i),
            c = a.find(a.data("stickyContainer")),
            e = a.data("stickyHeader");
        a.on("sticky.on", function() { a.on("scroll sticky.update", o), o() }), a.on("sticky.off", function() { a.off("scroll sticky.update", o), s() }) }) }(jQuery);
! function(t) {
    function a(a) { var e = t(a); if (e.data("tabs.init") !== !0) { var n = e.find("[data-url]");
            t(this).on("shown.bs.tab", function(a) { t(this).trigger("collapsedTab.change", t(this).find(".active").text()) }), 0 !== n.length && (n.on("show.bs.tab", function(a) { var e = t(this),
                    n = e.data("url");
                t.get(n).done(function(a) { e.trigger("tab.beforechange", e); var n = e.attr("href"),
                        i = t(n);
                    0 !== i.length && (i.html(a.html), e.trigger("tab.change", e)) }) }), e.data("tabs.init", !0)) } }

    function e(a) { var e = t(a); if (e.data("collapsed-tabs") !== !0) { var n = e.find("ul.tabs");
            e.on("click", ".collapsed-tabs-display", function(a) { var e = t(this).closest(".collapsed-tabs");
                e.toggleClass("opened"), e.hasClass("opened") ? e.trigger("collapsedTab.open") : e.trigger("collapsedTab.close") }), e.on("collapsedTab.open", function() { window.innerWidth < 768 && n.removeClass("hidden-xs") }), e.on("collapsedTab.close", function() { window.innerWidth < 768 && n.addClass("hidden-xs") }), e.on("collapsedTab.change", function(a, e) { t(this).find("span.collapsed-tabs-active").text(e) }), e.find("li").on("click", function(a) { if (window.innerWidth < 768) { var i = t(this);
                    n.find("li").removeClass("active"), e.trigger("collapsedTab.change", [i.text()]), e.removeClass("opened"), e.trigger("collapsedTab.close") } }), e.data("collapsed-tabs", !0) } } t.fn.tabpanel = function() { $container = t(this), $container.find("ul").attr("role", "tablist"), $container.find('[role="tablist"] li').attr("role", "presentation"), t('[role="tablist"] li > a').attr({ tabindex: "-1" }), t('[role="tablist"] li > a:not([role])').attr({ role: "tab" }), t('[role="tablist"] li > a:not([aria-controls])').each(function() { t(this).attr("aria-controls", t(this).attr("href").substring(1)) }), t('[role="tablist"] li:first-child a').attr({ "aria-selected": "true", tabindex: "0" }), $container.find("section").attr({ role: "tabpanel" }), $container.find("section > *:first-child").attr({ tabindex: "0" }), t('[role="tabpanel"]:not(:first-of-type)').attr({ "aria-hidden": "true" }), $container.find('[role="tab"]').on("keydown", function(a) { var e, n = t(this),
                i = t(this).parents("li").prev().children('[role="tab"]'),
                r = t(this).parents("li").next().children('[role="tab"]'); switch (a.keyCode) {
                case 37:
                    e = i; break;
                case 39:
                    e = r; break;
                default:
                    e = !1 } e.length && (n.attr({ tabindex: "-1", "aria-selected": null }), e.attr({ tabindex: "0", "aria-selected": !0 }).focus()), $container.find('[role="tabpanel"]').attr("aria-hidden", "true"), t("#" + t(document.activeElement).attr("href").substring(1)).attr("aria-hidden", null) }), $container.find('[role="tab"]').on("click", function(a) { a.preventDefault(), t(this).parents('[role="tablist"]').find('[role="tab"]').attr({ tabindex: "-1", "aria-selected": null }), t(this).attr({ "aria-selected": !0, tabindex: "0" }), $container.find('[role="tabpanel"]').attr("aria-hidden", "true"), t("#" + t(this).attr("href").substring(1)).attr("aria-hidden", null) }) }; var n = t("body");
    n.on("tabs.init", function(e, i, r) { i = t(i || n), i.find(".tabs").andSelf().filter(".tabs").each(function(t, e) { a(e) }) }), n.on("collapsed-tabs.init", function(a, i, r) { i = t(i || n), i.find(".collapsed-tabs").andSelf().filter(".collapsed-tabs").each(function(t, a) { e(a) }) }), n.trigger("tabs.init"), n.trigger("collapsed-tabs.init") }(jQuery);
! function(n) { n(".thumb-shuffle").each(function(t, e) { var r = n(e),
            u = null;
        r.on("mouseenter", function(t) { var e = n(t.currentTarget).find(".thumbnail"); if (0 !== e.length) { var r = e.data("thumbUrls"); if (r) { var f = r.split(","); if (1 !== f.length) { var a = function() { var t = e.children(),
                                r = n.map(t, function(n) { return n.currentSrc }),
                                u = f.filter(function(n) { return r.indexOf(n) === -1 && _.startsWith(n, "/ajax") === !1 });
                            u.length > 0 && (t = _.shuffle(t), n.each(_.shuffle(u).slice(0, 2), function(e, r) { n(t[e]).attr("src", r) })) };
                        u = setInterval(a, 1500), a() } } } }), r.on("mouseleave", function() { "undefined" != typeof u && clearInterval(u) }) }) }(jQuery);
! function(e) { e(".tiles-container").find(".tiles").find(".see-all-tiles").on("click", function() { var i = e(this).closest(".tiles");
        i.toggleClass("opened"), e(this).find(".tiles-toggle-icon").toggleClass("arrow-right").toggleClass("arrow-down") }) }(jQuery);

function supportsNavigationTiming() { return !(!window.performance || !window.performance.timing) }
if (lynda.timing && supportsNavigationTiming()) { var timing = window.performance.timing,
        timingModel = { log: function(e, t, i, n) { "info" === e ? console.info("* " + t + " = " + i + " - " + n) : "error" === e ? console.error("* " + t + " = " + i + " - " + n) : console.log("* " + t + " = " + i + " - " + n) }, calc: function(e, t) { var i = "",
                    n = ""; if (0 === e || 0 === t) i = "0s (0)";
                else { var o = e - t;
                    i = o / 1e3 + "s (" + o + ")" } for (var a = 13 - i.length, r = 0; r < a; r++) n += " "; return i + n } },
        timingMetrics = { userTime: timingModel.calc(timing.loadEventEnd, timing.navigationStart), fetchTime: timingModel.calc(timing.responseEnd, timing.fetchStart), unload: timingModel.calc(timing.unloadEventEnd, timing.unloadEventStart), redirectTime: timingModel.calc(timing.redirectEnd, timing.redirectStart), appCacheTime: timingModel.calc(timing.domainLookupStart, timing.fetchStart), dns: timingModel.calc(timing.domainLookupEnd, timing.domainLookupStart), connectionTime: timingModel.calc(timing.connectEnd, timing.connectStart), sslTime: timingModel.calc(timing.connectEnd, timing.secureConnectionStart), requestTime: timingModel.calc(timing.responseEnd, timing.requestStart), responseTime: timingModel.calc(timing.responseEnd, timing.responseStart), renderTime: timingModel.calc(timing.domComplete, timing.domLoading), pageInteractive: timingModel.calc(timing.domInteractive, timing.domLoading), contentLoaded: timingModel.calc(timing.domContentLoadedEventEnd, timing.domLoading), fileDownload: timingModel.calc(timing.domContentLoadedEventEnd, timing.domContentLoadedEventStart), loadEvent: timingModel.calc(timing.loadEventEnd, timing.loadEventStart), clientTime: timingModel.calc(timing.loadEventEnd, timing.domLoading), serverTime: timingModel.calc(timing.responseEnd, timing.navigationStart), ttfb: timingModel.calc(timing.responseStart, timing.navigationStart), processing: timingModel.calc(timing.loadEventStart, timing.domLoading) },
        timingData = { client: { render: { type: "log", name: "Render Time", metric: timingMetrics.unload, message: "Time to render the page" }, interactivity: { type: "log", name: "Page Interactivity Time", metric: timingMetrics.unload, message: "Time til page is interactive" }, content: { type: "log", name: "Content Time", metric: timingMetrics.unload, message: "Content fully downloaded" }, file: { type: "log", name: "File Download Time", metric: timingMetrics.unload, message: "time taken for the unload event" }, load: { type: "log", name: "Page Load event", metric: timingMetrics.loadEvent, message: "Duration of the load event - Try to keep the total number under 100, if its over it means something is blocking page load." } }, server: { redirect: { type: "log", name: "Redirect Time", metric: timingMetrics.redirectTime, message: "time taken for redirects" }, unload: { type: "log", name: "Unload Time", metric: timingMetrics.unload, message: "time taken for the unload event" }, appCache: { type: "log", name: "AppCache Time", metric: timingMetrics.appCacheTime, message: "time taken for the app cache" }, dns: { type: "log", name: "DNS Time", metric: timingMetrics.dns, message: "The time taken to perform a DNS lookup" }, connection: { type: "log", name: "Connection Time", metric: timingMetrics.connectionTime, message: "The time taken to connect to the server" }, ssl: { type: "log", name: "SSL Time", metric: timingMetrics.sslTime, message: "time taken for ssl connection" }, request: { type: "log", name: "Request Time", metric: timingMetrics.requestTime, message: "The total time taken to send a request to the server and receive the response" }, response: { type: "log", name: "Response Time", metric: timingMetrics.responseTime, message: "The total time taken to recieve the response" }, ttfb: { type: "log", name: "Time to first byte", metric: timingMetrics.ttfb, message: "Time to first byte on the server" } }, page: { fetch: { type: "log", name: "Fetch Time", metric: timingMetrics.fetchTime, message: "Time to complete the document fetch (including accessing any caches, etc.)" }, client: { type: "log", name: "Client Time", metric: timingMetrics.clientTime, message: "The time spent on clientside" }, server: { type: "log", name: "Server Time", metric: timingMetrics.serverTime, message: "The time spent on serverside" }, page: { type: "log", name: "Page Load Time", metric: timingMetrics.userTime, message: "The total page load delay experienced by the user." } } }; if (lynda.timingDisplay || "block" === lynda.timingDisplay) { var box = document.createElement("div");
        box.setAttribute("id", "sitespeedreport"); var headerTag = document.createElement("h3"),
            header = document.createTextNode("Sitespeed Report");
        headerTag.style.color = "white", headerTag.appendChild(header), box.appendChild(headerTag), box.style.border = "1px solid #333", box.style.backgroundColor = "#1e1e1e", box.style.color = "#999", box.style.width = "250px", box.style.height = "auto", box.style.borderRadius = "10px", box.style.position = "fixed", box.style.padding = "20px", box.style.top = "30px", box.style.left = "30px", box.style.zIndex = "1000000", box.style.opacity = "0.85"; var pageHeaderTag = document.createElement("h3"),
            pageHeader = document.createTextNode("Page Data");
        pageHeaderTag.style.color = "white", pageHeaderTag.appendChild(pageHeader), box.appendChild(pageHeaderTag); for (var index in timingData.page) { var kiddo = document.createElement("p");
            kiddo.innerHTML = "* " + timingData.page[index].name + " = <span>" + timingData.page[index].metric + "</span>", box.appendChild(kiddo) } var serverHeaderTag = document.createElement("h3"),
            serverHeader = document.createTextNode("Server Data");
        serverHeaderTag.style.color = "white", serverHeaderTag.appendChild(serverHeader), box.appendChild(serverHeaderTag); for (var index in timingData.server) { var kiddo2 = document.createElement("p");
            kiddo2.innerHTML = "* " + timingData.server[index].name + " = <span>" + timingData.server[index].metric + "</span>", box.appendChild(kiddo2) } var clientHeaderTag = document.createElement("h3"),
            clientHeader = document.createTextNode("Client Data");
        clientHeaderTag.style.color = "white", clientHeaderTag.appendChild(clientHeader), box.appendChild(clientHeaderTag); for (var index in timingData.client) { var kiddo3 = document.createElement("p");
            kiddo3.innerHTML = "* " + timingData.client[index].name + " = <span>" + timingData.client[index].metric + "</span>", box.appendChild(kiddo3) } var spans = box.getElementsByTagName("span"),
            i; for (i = 0; i < spans.length; i++) spans[i].style.color = "#bada55"; var optionsTag = document.createElement("h3"),
            options = document.createTextNode("Querystring Options");
        optionsTag.style.color = "white", optionsTag.appendChild(options), box.appendChild(optionsTag); var optionsTagList = document.createElement("ul");
        box.appendChild(optionsTagList); var optionsTagListItem1 = document.createElement("li"),
            options = document.createTextNode("- Display (true,block,false): Shows this display");
        optionsTagListItem1.style.color = "white", optionsTagListItem1.appendChild(options), optionsTagList.appendChild(optionsTagListItem1); var optionsTagListItem2 = document.createElement("li"),
            options = document.createTextNode("- Table (true,false): Shows a table in the console output");
        optionsTagListItem2.style.color = "white", optionsTagListItem2.appendChild(options), optionsTagList.appendChild(optionsTagListItem2); var optionsTagListItem3 = document.createElement("li"),
            options = document.createTextNode("- Verbose (true,false): Shows all resources on the page");
        optionsTagListItem3.style.color = "white", optionsTagListItem3.appendChild(options), optionsTagList.appendChild(optionsTagListItem3); var footerTag = document.createElement("p"),
            footer = document.createTextNode("Check the console for extra data and messages");
        footerTag.style.color = "white", footerTag.appendChild(footer), box.appendChild(footer), document.body.appendChild(box) } if (console.log("***********Timing Overview****************"), console.log(" _____________  _____________  _____________  _____________  _____________  _____________  _____________  _____________  _____________"), console.log("|             ||             ||             ||             ||             ||             ||             ||             ||             |"), console.log("|redirect     ||unload       ||app cache    ||dns          ||tcp          ||request      ||response     ||processing   ||onload       |"), console.log("|" + timingMetrics.redirectTime + "||" + timingMetrics.unload + "||" + timingMetrics.appCacheTime + "||" + timingMetrics.dns + "||" + timingMetrics.connectionTime + "||" + timingMetrics.requestTime + "||" + timingMetrics.responseTime + "||" + timingMetrics.processing + "||" + timingMetrics.loadEvent + "|"), console.log("|_____________||_____________||_____________||_____________||_____________||_____________||_____________||_____________||_____________|"), console.log("***********Start Timing****************"), console.log("* Performance timing dump"), console.log(timing), console.log("******************** Server related *******************"), lynda.timingTable) console.table(timingData.server);
    else
        for (var index in timingData.server) timingModel.log(timingData.server[index].type, timingData.server[index].name, timingData.server[index].metric, timingData.server[index].message); if (console.log("******************** Client related *******************"), lynda.timingTable) console.table(timingData.client);
    else
        for (var index in timingData.client) timingModel.log(timingData.client[index].type, timingData.client[index].name, timingData.client[index].metric, timingData.client[index].message); if (console.log("******************** Page related *******************"), lynda.timingTable) console.table(timingData.page);
    else
        for (var index in timingData.page) timingModel.log(timingData.page[index].type, timingData.page[index].name, timingData.page[index].metric, timingData.page[index].message); if (console.log("***********End Timing****************"), window.performance.getEntries().length > 0) { console.log("***********Start Resources****************"), console.log("* Types of objects on your page"); for (var scripts = [], styles = [], ajax = [], images = [], other = [], i = 0; i < window.performance.getEntries().length; i++) { var type = window.performance.getEntries()[i].initiatorType,
                item = window.performance.getEntries()[i]; "xmlhttprequest" === type ? ajax.push(item) : "img" === type ? images.push(item) : "script" === type ? scripts.push(item) : "css" === type || "link" === type ? styles.push(item) : other.push(item) } if (console.log("---Scripts (" + scripts.length + ")---"), lynda.timingVerbose && console.log(scripts), console.log("---CSS Files (" + styles.length + ")---"), lynda.timingVerbose && console.log(styles), console.log("---Ajax Requests (" + ajax.length + ")---"), lynda.timingVerbose && console.log(ajax), console.log("---Images (" + images.length + ")---"), lynda.timingVerbose && console.log(images), console.log("---Other (" + other.length + ")---"), lynda.timingVerbose && console.log(other), lynda.timingVerbose)
            for (var i = 0; i < window.performance.getEntries().length; i++) { var type = window.performance.getEntries()[i].initiatorType,
                    name = "";
                name = "xmlhttprequest" === type ? "* Ajax request - " : "img" === type ? "* Image request - " : "script" === type ? "* Script request - " : "css" === type || "link" === type ? "* CSS request - " : "* Other - ", console.log(name + window.performance.getEntries()[i].initiatorType + " (" + window.performance.getEntries()[i].name + ")") } console.log("***********End Resources****************") } }! function(t) { var o = { debug: !1, notify: function(t) { o.debug && console.log(t) }, listen: function() { t("body").on("click", ".toast-close", function() { o.lowerToast() }), t("body").on("click", ".toaster", function() { o.raiseToast(t(this).data()) }), t("body").on("showToast", function(t, n) { o.notify("Toast Shown"), o.raiseToast(n) }) }, getHTML: function(n) { o.notify(n); var s = o.template(n); if (s) { o.notify(s); var e = t(".toast-container." + (n.position || "bl") + " ul"),
                    a = t(".toast-container." + (n.position || "bl"));
                e.append(s), a.removeClass("toast-closed") } }, raiseToast: function(t) { o.notify("toast raised"), o.getHTML(t), setTimeout(function() { o.notify("Its been " + t.delay + " and I am closing toast"), o.lowerToast() }, t.delay || 7e3) }, lowerToast: function() { o.notify("toast lowered"); var n = t(".toast");
            o.notify(n), n.hasClass("animate-in") ? (n.removeClass("animate-in regular").addClass("animate-out"), setTimeout(function() { n.remove() }, 500)) : n.remove() }, template: function(t) { return '<li id="toast-' + Date.now() + '" class="toast ' + (t.position || "bl") + " " + (t.animated ? " animate-in " + ("bl" === t.position || "br" === t.position ? "fromBottom" : "fromTop") : "regular") + " " + (t.type || "info") + '" style="width: ' + (t.width || 450) + 'px;"><aside class="toast-type"><i class="lyndacon ' + (t.type ? ("info" === t.type ? "info" : "") + "" + ("success" === t.type ? "checkmark-success" : "") + ("error" === t.type ? "close-x" : "") : "info") + '"  aria-hiddden="true">&nbsp;</i></aside><section class="toast-message"><p>' + (t.message || "") + '</p><button class="toast-close"><i class="lyndacon close-x" aria-hidden="true"></i></button></section></li>' }, boot: function() { t(document).ready(function() { o.listen() }) } };
    o.boot() }(jQuery);
! function(a) {
    function t(a, t) { void 0 !== t && null !== t && (t.site_version = utag_data.site_version, utag_data.site_section && (t.site_section = utag_data.site_section), !t.page_name && utag_data.page_name && (t.page_name = utag_data.page_name), utag_data.page_type && (t.page_type = utag_data.page_type), utag.view(t)) }

    function e(a, t) { void 0 !== t && null !== t && (utag_data.site_version && (t.site_version = utag_data.site_version), utag_data.site_section && (t.site_section = utag_data.site_section), utag_data.page_name && (t.page_name = utag_data.page_name), utag_data.page_type && (t.page_type = utag_data.page_type), utag.link(t)) } var n = a("body");
    n.on("udo.link", e), n.on("udo.view", t), a("[data-utag-event-type]").click(function(t) { var n = {};
        _.forIn(a(this).data(), function(a, t) { void 0 !== a && null !== a && _.startsWith(t, "utag") && (n[_.snakeCase(t.substr(4))] = a) }), e(t, n) }) }(jQuery);
! function(e) {
    function a(e) { o.find(".preview-sidebar")[e ? "addClass" : "removeClass"]("sidebar-loading autocomplete-loading") }

    function t(e) { var a = o.find(".preview-course-details");
        a[e ? "removeClass" : "addClass"]("hide"), setTimeout(function() { e ? a.removeClass("fade-out").addClass("fade-in") : a.removeClass("fade-in").addClass("fade-out") }, 1) }

    function i() { t(!1), l && o.find("video").get(0).pause(), o.find(".pod-watching-cont").removeClass("hide"), o.find(".course-description").html(""), o.find(".modal-title, .author-name, .level-text, .pod-duration, .pod-viewers, .date-updated, .date-released").text(""), o.find(".author-image").attr("src", ""), o.find(".level").attr("class", "level"), o.find(".continue-button").closest("button").unbind("click") }

    function d(e) { o.modal("hide"), i(), o.hasClass("path-modal") || r.trigger("ga.event", { action: "click", label: "preview-close" }) } var o = e(".video-modal"); if (o && 0 !== o.length) { var r = e("body"),
            n = o.find("video.player");
        r.on("click", ".video-launch", function(a) { a.preventDefault(), modalData = e(this).data(), o.data(modalData), (modalData.videoSrc || modalData.videoId) && o.modal("show") }); var l = !1;
        o.on("shown.bs.modal", function(r) { e(window).trigger("resize"); var s = +o.data("videoId"),
                u = +o.data("courseId"),
                c = o.data("playerCallback"); if (c && n.on("ended", window[c]), !s && !u) { var v = o.data("videoSrc"); if (void 0 != v) { var f = o.data("videoTitle"); return o.find(".modal-title").text(f), n.trigger("playUrl", [v]) } return d() } i(), l = !0, a(!0), e.get("/ajax/video/preview?videoId=" + s + "&courseId=" + u, function(i) { var d = 540,
                    r = i.Video.PrioritizedStreams[0][d];
                n.trigger("playUrl", [r, null, u, s]), n.trigger("track.load", "/ajax/player/transcript?courseId=" + u + "&videoId=" + s), n.on("error", function(a) { e(this).trigger("log.message", { code: 9903, message: "VideoError: Preview video failed", data: "Course ID: " + u + " Video ID: " + s + " CDN Name: " + i.Video.PrioritizedCdnNames[0] + " Quality: " + d + " URL: " + r }) }), o.find(".author-image").attr("src", i.Course.Authors[0].ThumbnailUrl), o.find(".course-description").html(i.Course.Description), o.find(".modal-title").text(i.Course.Title), o.find(".author-name").text(i.Course.Authors[0].Fullname), o.find(".level").addClass("level-" + i.Course.Level.toLowerCase()), o.find(".level-text").text(i.Course.Level), o.find(".pod-duration").text(i.Course.FormattedDuration), o.find(".pod-viewers").parent()[0 === +i.Course.Viewers ? "hide" : "show"](), o.find(".pod-viewers").text(i.Course.Viewers.toLocaleString()), o.find(".continue-button").unbind("click").click(function() { window.location = i.Course.Url }), o.find(".date-updated").text(i.Course.DeltaDate), o.find(".date-released").text(i.Course.DateReleasedUtc), i.Course.ClosedCaptionsAvailable || o.find(".mejs-captions-button").hide(), t(!0), a(!1) }) }), o.on("hidden.bs.modal", d), o.find(".nav-close").click(d) } }(jQuery);
! function(t) {
    function i(t, i, a) { var e = { url: t, method: i || "post", data: a || {} }; return e }

    function a(a, n, o, d, l) { e && e.abort(); var u = i(a, n, o); return lynda.culturePrefix && ~u.url.indexOf(lynda.culturePrefix) && (u.url = u.url.replace(lynda.culturePrefix, "")), e = t[u.method](lynda.culturePrefix + "/ajax" + u.url, o).done(function(i) { if (i) { var a = t("[data-wizardli-section]").each(function() { var a = t(this),
                        e = a.data("wizardliSection"),
                        n = i[e]; if (d ? a.addClass("wizardli-back") : a.removeClass("wizardli-back"), i.viewId && a.attr("data-wizardli-view-id", i.viewId), n) { oldContent = a.find(".wizardli-new-content"), oldContent.length || (oldContent = t("<span>"), oldContent.append(a.contents().detach())), oldContent.children().prop("disabled", !0), oldContent.removeClass("wizardli-new-content").one("webkitAnimationEnd oanimationend msAnimationEnd animationend", function(i) { t(this).remove() }).appendTo(a).addClass("wizardli-old-content").filter(":not(:animated)").remove();
                        t("<span>").html(n).appendTo(a).addClass("wizardli-new-content");
                        t(window).scrollTop(0) } }); if (t("[autofocus]").focus(), i.pageTitle) { var e = lynda.culturePrefix + (i.url || u.url);!l && history.pushState(u, i.pageTitle, e), document.title = i.pageTitle, r.trigger("wizardli.section.update", [a]), r.trigger("ga.pageview", [e]) } i.token && (lynda["-_-"] = i.token) } }) } if (t("[data-wizardli-section], [data-wizardli]").length && history && history.pushState && history.back) { var e, n, r = t("body");
        t(window).on("popstate", function(t) { if (t.originalEvent) { if (!t.originalEvent.state && !n) return n = !0; var e = t.originalEvent.state || i(window.location.pathname);
                e.url && e.method && e.data && a(e.url, e.method, e.data, !0, !0) } }), r.on("wizardli.state.replace", function(t, a, e, n, r) { history.replaceState(i(a, e, n), r, a) }).on("click", ":not(form)[data-wizardli]", function(i) { i.preventDefault(); var e = t(this); return "back" === e.data("wizardli") ? void history.back() : void r.trigger("wizardli.link", [e, a(e.attr("href"))]) }).on("submit", "form[data-wizardli]", function(i) { if (!i.isDefaultPrevented()) { i.preventDefault(); var e = t(this);
                r.trigger("wizardli.submit", [e, a(e.attr("action"), e.attr("method"), e.serialize())]) } }) } }(jQuery);
