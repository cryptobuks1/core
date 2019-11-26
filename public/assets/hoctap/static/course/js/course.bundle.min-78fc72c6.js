function RumVideoTracking(e) {
    function t(e) { var t;
        E = {}, e = e || {}, I = e.trackingEnabled !== !1, I && ("object" == typeof e["web-tracking-obj"] ? h = e["web-tracking-obj"] : (h = webTrackingTransport, "object" == typeof h && (t = e["tracking-url"] || "https://www.linkedin.com/li/track", h.setTrackingUrl(t)))) }

    function n(e) { var t = { header: { time: e ? m : w }, requestHeader: { pageKey: l }, mobileHeader: null, mediaHeader: "object" == typeof j ? j : {}, mediaTrackingObject: { objectUrn: "string" == typeof v ? v : "", trackingId: y }, initializationStartTime: m },
            n = { eventName: e ? "MediaInitializationStartEvent" : "MediaInitializationEndEvent", appId: b }; if (e || (t.duration = w - m), I && "object" == typeof h) h.sendEvent(n, t);
        else if (!I) return { eventInfo: n, eventBody: t } }

    function r(e, t) { var n = E[e],
            r = { header: { time: t ? n.start : n.end }, requestHeader: { pageKey: l }, mobileHeader: null, mediaHeader: "object" == typeof j ? j : {}, mediaTrackingObject: { objectUrn: "string" == typeof v ? v : "", trackingId: y }, bufferingType: n.type, initializationStartTime: m, bufferingStartTime: n.start },
            i = { eventName: t ? "MediaBufferingStartEvent" : "MediaBufferingEndEvent", appId: b }; if (t || (r.duration = n.end - n.start, a(e)), I && "object" == typeof h) h.sendEvent(i, r);
        else if (!I) return { eventInfo: i, eventBody: r } }

    function i(e, t, n, r) { var i = { header: { time: r }, requestHeader: { pageKey: l }, mobileHeader: null, mediaHeader: "object" == typeof j ? j : {}, mediaTrackingObject: { objectUrn: "string" == typeof v ? v : "", trackingId: y }, errorType: e },
            o = { eventName: "MediaPlaybackErrorEvent", appId: b }; if ("string" == typeof t && (i.errorMessage = t), "object" == typeof n ? i.errorException = n : i.errorException = null, I && "object" == typeof h) h.sendEvent(o, i);
        else if (!I) return { eventInfo: o, eventBody: i } }

    function o(e, t) { var n = { header: { time: t }, requestHeader: { pageKey: l }, mobileHeader: null, mediaHeader: "object" == typeof j ? j : {}, mediaTrackingObject: { objectUrn: "string" == typeof v ? v : "", trackingId: y } },
            r = { eventName: "MediaBitrateChangedEvent", appId: b }; if ("object" == typeof e && (n = g(n, e)), I && "object" == typeof h) h.sendEvent(r, n);
        else if (!I) return { eventInfo: r, eventBody: n } }

    function a(e) { delete E[e] }

    function f(e) { if (I && (void 0 === y || void 0 === b)) throw new Error("must set videoTrackingId and applicationName before recording events"); if (!e && "number" != typeof m) throw new Error("videoInitializationStart not called") }

    function d(e, t) { if (I && (void 0 === y || void 0 === b)) throw new Error("must set videoTrackingId and applicationName before recording events"); if ("number" != typeof m) throw new Error("videoInitializationStart not called"); if ("number" != typeof e) throw new TypeError("bufferingId not a number"); if (t) { if ("object" == typeof E[e]) throw new Error("duplicate bufferingId") } else if ("object" != typeof E[e] || "number" != typeof E[e].start || "undefined" != typeof E[e].end || null !== E[e].type) throw new Error("incorrect bufferingId or wrong buffering type") }

    function c(e, t, n) { if (I && (void 0 === y || void 0 === b)) throw new Error("must set videoTrackingId and applicationName before recording events"); if ("string" != typeof e || !(e in k)) throw new Error("invalid error type. Expected one of: " + Object.keys(k)); if ("string" != typeof t && "undefined" != typeof t) throw new TypeError("error message is not a string or undefined"); if ("object" == typeof n) Object.keys(n).forEach(function(e) { if (!(e in T)) throw new Error("invalid field in the exception object") });
        else if ("undefined" != typeof n) throw new TypeError("error exception is not an object or undefined") }

    function u(e) { if (I && (void 0 === y || void 0 === b)) throw new Error("must set videoTrackingId and applicationName before recording events"); if ("object" == typeof e) N.forEach(function(t) { if (!(t in e)) throw new Error("key: " + t + " not in fields") });
        else if ("undefined" == typeof e) throw new TypeError("extraFields is not an object or undefined") }

    function p() { return window.performance && window.performance.timing && "function" == typeof window.performance.now ? Math.round(window.performance.now()) + window.performance.timing.navigationStart : (new Date).getTime() }

    function s(e) { return g(T, e) }

    function g(e, t) { for (var n in t) t.hasOwnProperty(n) && (e[n] = t[n]); return e } var y, b, l, v, m, w, E, h, j, I, k = { CUSTOM: !0, NETWORK: !0, DECODING: !0, SOURCE_FILE: !0, ENCRYPTION: !0, AUDIO: !0, RENDERING: !0 },
        T = { message: "", lineNumber: -1, columnNumber: -1, sourceFile: "", stackTrace: "", programLanguage: "JAVASCRIPT", type: "" },
        N = ["newBitrate", "viewingDisplaySize", "encodedDisplaySize", "audioCodec", "videoCodec", "newSegmentDuration", "targetSegmentDuration", "frameRate"];
    t(e), this.setVideoTrackingId = function(e) { y = e }, this.setApplicationName = function(e) { b = e, "string" != typeof l && (l = e) }, this.setPageKey = function(e) { l = e }, this.setVideoUrn = function(e) { v = e }, this.setMediaHeader = function(e) { j = e }, this.videoInitializationStart = function() { var e = !0; return m = p(), f(e), n(e) }, this.videoInitializationEnd = function() { var e = p(),
            t = !1; return f(t), w = e, n(t) }, this.bufferingStart = function(e) { var t = p(),
            n = !0; return d(e, n), E[e] = {}, E[e].start = t, E[e].type = null, r(e, n) }, this.bufferingEnd = function(e) { var t = p(),
            n = !1; return d(e, n), E[e].end = t, r(e, n) }, this.mediaPlaybackError = function(e, t, n) { var r, o = p(); return c(e, t, n), "object" == typeof n && (r = s(n)), i(e, t, r, o) }, this.bitrateChangedEvent = function(e) { var t = p(); return u(e), o(e, t) } }
var videoTrackingModule = function() {
    function e(e, n) { return "urn:li:lyndaVideo:(urn:li:lyndaCourse:" + e + "," + n + ")" }

    function n() { var e = d.player.data("conviva"); return "EDGECAST" === e.CdnName ? "ecst" : "akam" } var i = 500,
        a = { stopped: "stopped", waiting: "waiting", playing: "playing" },
        t = { 0: "CUSTOM", 1: "ABORTED", 2: "NETWORK", 3: "DECODING", 4: "SOURCE_FILE", 5: "ENCRYPTION" },
        d = {}; return d.videoRum, d.player, d.seeking = !1, d.initializationStarted = !1, d.isBuffering = !1, d.isPreloadNone = !1, d.state = a.stopped, d.bufferingStartTime, d.bufferingId, d.mediaHeader = {}, d.init = function(n, i, a, t) { "undefined" != typeof lynda && "undefined" != typeof lynda.rumTrackingEnabled && "undefined" != typeof lynda.videoRumTrackingEnabled && lynda.videoRumTrackingEnabled > 0 && "undefined" != typeof lynda.jsRumTrackingPageKey && "undefined" != typeof n && (d.videoRum = new RumVideoTracking({ "web-tracking-obj": lynda.webTrackingTransport, "tracking-url": lynda.jsTrackingUrl, trackingEnabled: lynda.videoRumTrackingEnabled }), d.initializationStarted = !1, d.initializationEnded = !1, d.videoRum.setApplicationName(lynda.rumTrackingAppId), d.videoRum.setVideoTrackingId(t), d.videoRum.setVideoUrn(e(i, a)), d.videoRum.setPageKey(lynda.jsRumTrackingPageKey), d.player = n, d.player.on("loadeddata", d.onLoadeddata), d.player.on("loadstart", d.onLoadstart), d.player.on("play", d.onPlay), d.player.on("pause", d.onPause), d.player.on("seeked", d.onSeeked), d.player.on("seeking", d.onSeeking), d.player.on("timeupdate", d.onTimeupdate), d.player.on("waiting", d.onWaiting), d.player.on("error", d.onError), d.isPreloadNone = "none" == d.player[0].preload, d.mediaHeader = { accountAccessType: lynda.isLoggedIn ? "PAID" : "FREE", playerType: "HTML5", playerVersion: "2.0", mediaSource: "lynda-learning", deliveryMode: "PROGRESSIVE" }) }, d.setInitializationStarted = function() { d.mediaHeader.cdnProvider = n(), d.videoRum.setMediaHeader(d.mediaHeader), d.initializationStarted || (d.videoRum.videoInitializationStart(), d.initializationStarted = !0) }, d.setInitializationEnded = function() { d.initializationEnded || d.isBuffering || (d.videoRum.videoInitializationEnd(), d.initializationEnded = !0) }, d.bufferingStart = function() { d.seeking || (d.isBuffering = !0, d.bufferingId = Date.now(), d.videoRum.bufferingStart(d.bufferingId)) }, d.bufferingEnd = function() {!d.seeking && d.isBuffering && (d.isBuffering = !1, d.videoRum.bufferingEnd(d.bufferingId), d.setInitializationEnded()) }, d.onLoadeddata = function() { d.setInitializationEnded() }, d.onLoadstart = function() { d.isPreloadNone || d.setInitializationStarted() }, d.onPlay = function() { d.isPreloadNone && d.setInitializationStarted(), d.state = a.playing }, d.onPause = function() { d.state = a.stopped }, d.onSeeked = function() { d.seeking = !1, d.bufferingEnd() }, d.onSeeking = function() { d.seeking = !0 }, d.onTimeupdate = function() { var e = "undefined" != typeof d.bufferingStartTime && Date.now() - d.bufferingStartTime < i;
        e || d.state !== a.waiting || (d.state = a.playing, d.bufferingEnd()) }, d.onWaiting = function() { d.state === a.playing && (d.state = a.waiting, d.bufferingStart(), d.bufferingStartTime = Date.now()) }, d.onError = function(e) { if ("undefined" != typeof d.videoRum.mediaPlaybackError) { var n = t[0],
                i = "VideoError: MEJS Player error";
            d.videoRum.mediaPlaybackError(n, i) } }, d }(videoTrackingModule || {});
! function(e) {
    function t(t) { if (t = e(t), 0 !== t.length) { var o = t.data(); if (!e.isEmptyObject(o) && "undefined" != typeof o.tab && 0 !== o.tab.length) { var r = o.tab;
                e("#course-tabs li").removeClass("selected"), t.addClass("selected"), H.children("section").hide(), currentSection = e("#tab-" + r), e(currentSection).show() } } }

    function o() { e("video").hide(), setTimeout(r, 10) }

    function r() { e("video").show() }

    function a() { return e(".video-actions-cont").length > 0 && e(".video-actions-cont").length == e(".video-actions-cont .eye").length }

    function n() { if (!a()) { var t = e("#focused-learning-leave").text(); return t } }

    function c() { a() && e("#focused-learning-complete").modal("show") }

    function s() { var t = e("html").hasClass("member"),
            o = t ? 50 : 0,
            r = y.height() - o;
        t && S.height(r) }

    function l(t) { t = e(t); var o = e(t.parent()),
            r = t.outerHeight(),
            a = o.height(),
            i = o.find(".show-all"),
            n = t.prev();
        n.length && (r += n.outerHeight()), r > a && e(i).show() }

    function d(t) { var o = e(t).parent(),
            r = e(o).find(".show-all");
        e(o).removeClass("expanded"), e(r).hide() }

    function u(t, o, r) { r || (e('meta[property="og:url"]').attr("content", window.location.origin + o), history.pushState && history.pushState(t, t.id, o)) }

    function p(t) { e(".toc-items li").removeClass("current"); var o = w.triggerHandler("get.toc.elm", [t]); switch (o.addClass("current"), t.type) {
            case "video":
                if (o.find(".video-actions-cont i.watch-trigger").addClass("eye"), !L) return;
                e(".transcript-items .video-transcripts").remove(), e.get("/ajax/course/videotranscripts?courseId=" + +x + "&videoId=" + +t.id).done(function(o) { if (o.html && o.html.length > 0) { e(".transcript-items .video-transcripts").remove(); var r = e("<div />").append(o.html).find(".video-transcripts").html().trim().length; if (0 === r) return; var a = e(".transcript-items .current");
                        a.first().attr("data-video-id", t.id), a.first().attr("data-item-id", t.id), a.find(".video-transcript-cont").hasClass("hide") && a.find(".video-transcript-cont").removeClass("hide"), a.find(".video-transcript-cont").append(o.html), !k && window.innerWidth < 1024 && a.find(".video-transcript-cont").addClass("hide") } }); break;
            case "assessment":
        } }

    function v() { j.trigger("autoscroll.enable"), A.hide(), N.hide(), e("#search-course").val(""), e("#toc-content .show-all").show() }

    function h(t) { if (isNaN(t)) return !1; var o = "#tour-content-" + t,
            r = e(o),
            a = r.find(".img-url").data("imgurl"),
            i = "close-" + t,
            n = e(".tour-pagination .pagination-item").eq(t - 1);
        e(".course-modal-tour .tour-content-container").html(r.html()), e(".course-modal-tour .tour-image").removeAttr("src").attr("src", a), e(".tour-pagination .pagination-item").removeClass("selected"), n.addClass("selected"), e(".close-tour").data("ga-value", i) }

    function g(t) { var o = e("#btn-search-course");
        o.addClass("autocomplete-loading"), e("body").trigger("ga.event", { action: "search", label: "toc-search" }), e.get("/ajax/course/" + +x + "/search?searchTerm=" + t).done(function(t) { o.removeClass("autocomplete-loading"), j.trigger("autoscroll.disable"), N.html(t.html).show(), A.show(), e("#toc-content .show-all").hide() }) }

    function m() { var t = e(window).height() - (R.elements.bod + R.elements.cta + R.elements.title + R.elements.extra),
            o = 0;
        e(".scrolly").find(".card-cont").each(function(t) { t <= 3 && (o += e(this).outerHeight()) }), e("#suggested-courses").find(".carousel-content").css("max-height", X.per(t, 50)); var r = e("#video-container").outerHeight() + e(".video-description").outerHeight() + e(".overview-cont").outerHeight() - e("#suggested-courses").outerHeight() - e("#sidebar-nav").outerHeight();
        e("#sidebar").find(".tab-content").height(X.per(r, 70)), e(".course-toc").height((e("#toc-content").outerHeight() - e("#course-search").outerHeight() - 15).toString() + "px") }

    function f() { e.get(lynda.deferredContent).done(function(t) { e.isEmptyObject(t) ? (e(".tab-offline").hide(), e(".tab-exercise").hide(), e(".tab-code-practice").hide()) : (e("#tab-view-offline").html(t.viewofflinetab), e("#tab-exercise-files").html(t.exercisetab), e("#tab-code-practice").html(t.codepracticetab)) }) } var b = e("html"),
        w = e("body"),
        y = e(window),
        k = b.hasClass("no-touch"),
        C = e("#course-page"),
        x = +C.data("courseId"),
        I = (e("#video-container"), e("#courseplayer video.player")),
        j = e(".course-toc"),
        T = e("#toc-content"),
        H = e(".tab-container"),
        E = e("#transcripts-container"),
        S = (e(".toc-item-settings"), e("#sidebar")),
        N = e("#search-results-area"),
        O = e("#search-course"),
        V = e("#btn-search-course"),
        A = e("#course-search .clear-search"),
        W = !1,
        L = (e(".title-banner"), e(".course-actions button"), lynda.ccAvailable || !1),
        P = e("html").hasClass("non-member"),
        K = C.hasClass("course-popout");
    H.tabpanel(), e(".nav-tabs").tabpanel(), b.hasClass("retiring") && e("#course-retiring-modal").modal(), lynda && lynda.FocusedLearning && (w.addClass("focused-learning"), y.bind("beforeunload", n), w.on("course.ended", c)), w.on("course.video.change", function(e, t, o, r) { var a = { id: o, type: "video" },
            i = w.triggerHandler("get.toc.elm", [a]),
            n = i.find("a").get(0).pathname + i.find("a").get(0).search;
        u(a, n, r), p(a) }), K && w.css({ paddingTop: 0 }), e("#banner-thumbnail").click(function() { I.trigger("resume") }); var D = e("#video-desc-heading");
    D.text(D.data("text")), C.on("click", "#btn-reminders", function(t) { I.trigger("pause"), e(".popover").popover("hide"), I.trigger("showpostroll", e(this).data("url")) }), L && (E.on("autoscroll.enable", function() { e("#transcripts-container .autoscroll-container").removeClass("hide") }), E.on("autoscroll.disable", function() { e("#transcripts-container .autoscroll-container").addClass("hide") }), e(".autoscroll-enable").click(function() { E.trigger("autoscroll.enable") }), I.on("play", function() { var o = e(".transcript-items .current");
        W = !0, E.trigger("autoscroll.update", [o]), o.find(".video-transcript-cont").removeClass("hide"), K || t("#course-tabs .tab-transcript") }), w.on("click", "#search-results-area .search-items .search-item .search-body .transcript", function(t) { w.trigger("toggle.player.container", ["video-container"]), I.trigger("playVideoId", [e(this).attr("videoId"), e(this).data("duration")]) }), j.on("autoscroll.min autoscroll.mid", function(e) { j.removeClass("max-scroll") }), j.on("autoscroll.max", function(e) { j.addClass("max-scroll") }), E.on("autoscroll.max", function(e) { E.addClass("max-scroll") }), E.on("autoscroll.min autoscroll.mid", function(e) { E.removeClass("max-scroll") }), w.on("course.video.timeupdate", function(e, t, o) { w.trigger("transcript.timeupdate", [".transcript-items .transcripts.video-transcripts", parseFloat(t.currentTarget.currentTime)]) }), w.on("transcript.current.change", function(t, o) { e(o).is(":hidden") || E.trigger("autoscroll.update", [o]) }), w.on("transcript.select", function(e, t) { I.trigger("updatetime", [t]), w.trigger("toggle.player.container", ["video-container"]) })), w.on("note.play", function(e, t, o) { w.trigger("toggle.player.container", ["video-container"]), I.trigger("playVideoId", [t, o]) }), k ? w.on("click", "#btn-keyboard-shortcuts, .tour-shortcuts, .tour-question", function() { window.open(lynda.culturePrefix + "/courses/shortcuts", "Shortcuts", "height=560, width=960") }) : (e("#btn-more").remove(), e("#btn-downloads").remove()); var U = !1;
    e(".tour-auto-start").length && (U = !0), e("#course-modal-tour").modal({ show: U }), h(1), e("#course-modal-tour").on("hidden.bs.modal", function(t) { e.post("/ajax/course/tour-complete") }), K || (w.on("click", "#course-tabs li:not(.selected)", function(e) { w.trigger("course-tab.change", this) }), w.on("course-tab.change", function(e, o) { t(o) })), w.on("click", "#btn-take-tour", function(t) { e("#btn-more").popover("hide"), h(1), e("#course-modal-tour").modal("show") }), w.on("click", ".tour-pagination .pagination-item", function(t) { var o = e(this).index() + 1;
        h(o) }), w.on("click", ".course-tour-next", function(t) { var o = e(this).attr("data-step"),
            r = parseInt(o) + 1;
        h(r) }), w.on("click", function(e) { w.hasClass("hasPopout") && (w.removeClass("hasPopout"), w.trigger("close.popouts", e)) }), w.on("toggle.player.container", function(t, o) { var r = e(".player-content"),
            a = e("#" + o);
        a.hasClass("hide") && (r.each(function() { e(this).hasClass("hide") || e(this).addClass("hide") }), a.removeClass("hide")) }), O.on("keypress", function(t) { 13 == t.which && (t.preventDefault(), g(e("#search-course").val())) }), O.on("focus", function(e) { w.trigger("ga.event", { action: "focus", label: "toc-search", value: x }) }), V.on("click", function(t) { g(e("#search-course").val()), t.preventDefault() }), w.on("click", "#clear-search-text", v), A.on("click", v), T.on("click", ".item-name", function(t) { e(this).closest("li").find(".video-watched-cont i.watch-trigger").addClass("eye") }), T.on("click", ".booker", function(t) { var o = e(this),
            r = o.find("i"),
            a = r.hasClass("bookmarked"),
            i = +o.closest("li").data("videoId"); if (a) { var n = o.data("bookmarkId");
            e.ajax({ url: "/ajax/bookmark/" + +n, method: "DELETE" }) } else e.post("/ajax/bookmark/video/" + +i).done(function(e) { e && e.BookmarkId && o.data("bookmarkId", e.BookmarkId) });
        r.toggleClass("bookmarked bookmark-outline") }), w.on("click", ".tracking", function(t) { var o = e(this),
            r = {};
        e.each(o.data(), function(e) { 0 == e.indexOf("track") && (r[e.substring(5)] = o.data(e)) }), e.ajax({ type: "POST", url: "/ajax/course/tracking", dataType: "text", async: !0, cache: !1, data: "json=" + JSON.stringify(r) }) }), k && (e(".mejs-button:not(.mejs-volume-button) button").tooltip({ container: "#video-container", delay: { show: 100, hide: 0 } }), e("#player-mute-toggle").tooltip("disable"), w.on("click", ".mejs-button button", function() { e(this).tooltip("hide") })), j.find(".chapter-row").click(function(t) { var o = e(this).parent().find("ul"),
            r = e(this).find(".chapter-caret");
        r.hasClass("right") ? (o.show(), r.removeClass("right")) : (o.hide(), r.addClass("right")) }), w.on("click", ".show-all", function(t) { var o = e(this).parent();
        e(o).toggleClass("expanded") }), w.on("click", "#btn-layout", function() { I.trigger("theater.toggle") }), w.on("theater.toggle.done", function() { var t = e("#btn-layout"),
            o = t.find("i");
        o.removeClass("layout-toggle-solid layout-solid"), e("html").hasClass("theater-mode") ? o.addClass("layout-solid") : o.addClass("layout-toggle-solid") }), w.popover({ html: !0, animation: !1, container: ".standalone-course-buttons", selector: "#btn-exercise", placement: "bottom", template: '<div class="popover dark-pop exercise-popover course-popover" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>', content: function() { return e(".popover").not(this).popover("hide"), "<ul>" + e("#exercise-files-popover").clone().removeClass("hide").html() + "</ul>" } }), w.popover({ html: !0, animation: !1, container: ".standalone-course-buttons", selector: "#btn-standalone-more", placement: "bottom", template: '<div class="popover dark-pop more-popover course-popover" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>', content: function() { return e(".popover").not(this).popover("hide"), "<ul>" + e("#more-popover").clone().removeClass("hide").html() + "</ul>" } }), w.popover({ html: !0, animation: !1, container: ".course-actions", selector: "#btn-downloads", placement: "bottom", template: '<div class="popover dark-pop downloads-popover" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>', content: function() { return e(".popover").not(this).popover("hide"), "<ul>" + e("#downloads").clone().removeClass("hide").html() + "</ul>" } }), w.popover({ html: !0, animation: !1, container: ".course-actions", selector: "#exercise-files", placement: "left", viewport: { selector: "#course-page", padding: 50 }, template: '<div class="popover dark-pop exercise-popover course-popover" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>', content: function() { return e(".offline-viewing").popover("hide"), "<ul>" + e("#exercise-files-popover").clone().removeClass("hide").html() + "</ul>" } }), w.popover({ html: !0, animation: !1, container: ".course-actions", selector: "#btn-more", placement: "bottom", template: '<div class="popover dark-pop more-popover course-popover" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>', content: function() { return e(".popover").not(this).popover("hide"), "<ul>" + e("#more-popover").clone().removeClass("hide").html() + "</ul>" } }), w.popover({ html: !0, animation: !1, container: ".course-actions", selector: ".download-app-cta", placement: "left", template: "<div class='popover dark-pop offline-viewing'><div class='arrow'></div><div class='popover-content'></div></div>", viewport: { selector: ".main-content-area", "margin-top": "5px" }, content: function() { var t = e(this).data("hasOfflineViewingAccess"); if (t) { var o = e(this).data("fallbackUrl"); return w.on("deeplinking.failed", function() { window.location = o }), w.trigger("deeplinking.launch", ["lynda.com://course/" + x + "/download", !1]), !1 } return e(".exercise-popover").popover("hide"), e("#ov-upgrade-for-offline-viewing").clone().removeClass("hide").html() } }), e(".btn-group button").tooltip({ container: ".submenu-profile", delay: { show: 400, hide: 0 } }), w.popover({ html: !0, animation: !1, container: "#sidebar", selector: ".eye", placement: "bottom", template: '<div class="popover dark-pop eye-popover course-popover" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>', content: function() { j.trigger("autoscroll.disable"), e(".popover").not(this).popover("hide"), e(".eye-options").show(), e(".eye-confirm").addClass("hide"); var t = e(this).closest("li").data("videoId"); return '<ul data-video-id="' + t + '">' + e("#toc-eye-popover").clone().removeClass("hide").html() + "</ul>" } }), w.on("hidden.bs.popover", ".eye", function(e) { j.trigger("autoscroll.enable") }), H.on("click", ".tab-download-app-cta button", function(t) { var o = e(this).parent(),
            r = o.data("fallbackUrl"); return w.on("deeplinking.failed", function() { window.location = r }), w.trigger("ga.event", { action: "click", label: o.data("gaLabel"), value: o.data("gaValue") }), w.trigger("deeplinking.launch", ["lynda.com://course/" + x + "/download", !1]), !1 }), H.on("click", ".tab-upgrade-cta", function(t) { var o = e(this),
            r = o.data("href");
        window.location = r }), w.on("click", ".video-unwatched", function(t) { var o = e(".eye-popover ul").data("videoId");
        e.post("/ajax/video/" + o + "/clear"), e('.course-toc li[data-video-id="' + o + '"] i.eye').removeClass("eye"), e(".eye-popover").popover("hide"), j.trigger("autoscroll.enable") }), w.on("click", ".video-all-unwatched", function(t) { e(".eye-options").hide(), e(".eye-confirm").removeClass("hide").show(), j.trigger("autoscroll.enable") }), w.on("click", ".eye-confirm-cancel", function(t) { e(".eye-popover").popover("hide") }), w.on("click", "button.clear-course-history", function(t) { var o = e("#course-page").data("courseId");
        e.post("/ajax/course/" + o + "/clear"), e("i.eye").removeClass("eye"), e(".eye-popover").popover("hide") }); var q = "";
    q = P ? "ul.toc-items li.toc-video-item" : "ul.toc-items li.toc-video-item:not(.locked)", e(q).on("click", function(t) { return !!(e(t.target).is(".eye, .code, .video-name, .booker") || e(t.target).parents(".video-transcript-cont, .transcript-toggle, .booker").length > 0) || void e(this).find("a").trigger("click") }), e(".toc-items .toc-video-item.locked").on("click", function() { if (I.trigger("pause"), I.data("isLoggedIn") && !I.data("isExpired") || null === I[0].dataset.features.match(/customendplate/gi) || w.trigger("course.video.showendplate"), P) { var t = e(this),
                o = t.find("a").clone();
            o.find("span.new-updated").remove(); var r = { VideoId: t.data("itemId"), VideoTitle: e.trim(o.text()), CourseId: x, CourseTitle: e(".default-title").data("course") };
            setTimeout(function() { I.trigger("video.metadata.loaded", r) }, 100) } }), document.addEventListener("orientationchange", o), window.innerWidth > 1023 ? s() : l(".course-toc"), l(".course-description"), y.on("resize", _.debounce(function(t) { var o = e(".course-description"); if (o.find(".show-all").hide(), d(o), l(o), window.innerWidth > 1023) s();
        else { S.removeAttr("style"), l(".course-toc"); var r = e("#course-tabs li:visible"),
                a = !1; for (i = 0; i < r.length; i++) { var n = e(r[i]); if (n.hasClass("selected")) return a = !0 } a || e(".tab-overview").trigger("click") } }, 250)), y.on("resize", _.debounce(function(t) { var o = e(".toc-items .current"),
            r = e(".toc-container");
        W && (window.innerWidth > 1023 ? (o.find(".video-transcript-cont").removeClass("hide"), s(), d(r)) : o.find(".video-transcript-cont").addClass("hide")), !k && window.innerWidth < 1024 && o.find(".video-transcript-cont").addClass("hide") }, 250)); var z = e(".toc-items .current"),
        B = !!I.attr("autoplay");
    B && w.trigger("ga.event", { action: "auto-start", label: "player", value: x }), j.trigger("autoscroll.update", [z]), I.on("next previous", function() { j.trigger("autoscroll.enable"), j.trigger("autoscroll.update", [e(".toc-items .current")]), j.trigger("autoscroll.disable") }); var F = 78,
        $ = 67,
        J = 84,
        Q = ""; if (w.bind("keydown", function(t) { if (!("INPUT" === t.target.tagName || "TEXTAREA" === t.target.tagName || e(t.target).attr("contenteditable") || e(t.target).closest("form").length > 0)) { switch (t.keyCode) {
                    case J:
                        var o = t.ctrlKey || t.shiftKey || t.altKey || t.metaKey; if (o) return !0; if (!e("html").hasClass("member")) return !0;
                        I.trigger("theater.toggle"), Q = "player-theater-mode"; break;
                    case F:
                        var r = e("#notes-tab");
                        r.length && r.click(), Q = "N"; break;
                    case $:
                        var a = e("#toc-tab");
                        a.length && a.click(), Q = "C"; break;
                    default:
                        return !0 } return w.trigger("ga.event", { action: "keypress", label: Q, value: x }), !1 } }), e("html").hasClass("non-member")) { var R = { elements: { win: e(window).height(), bod: e("body header").outerHeight(), cta: e(".top-cta").outerHeight(), title: e(".title-banner").outerHeight(), extra: 32, content: e(".main-content-area").outerHeight() } },
            X = { per: function(e, t) { var o = .01 * t,
                        r = e * o; return r } };
        window.innerWidth > 1023 && m() } lynda && lynda.deferredContent && f(); var G = e("#nonmember-endplate-temp"); if (lynda && lynda.deferredEndplate && G.length && e.get(lynda.deferredEndplate).done(function(t) { e.isEmptyObject(t) || G.html(t.endplate) }), P && e("#toc .toc-video-item.current").hasClass("locked") ? e(".tab-transcript").trigger("click") : K || t("#course-tabs .tab-overview"), e("#course-page").data("video-page")) { var M = e("#toc .toc-video-item.current").find("a").clone();
        M.find("span.new-updated").remove(); var Y = { VideoTitle: e.trim(M.text()), CourseTitle: e(".default-title").data("course") };
        setTimeout(function() { I.trigger("video.metadata.loaded", Y) }, 100) } }(jQuery), $(function() { $('[data-toggle="tooltip"]').tooltip() });
! function(t) { var e = t("body"),
        i = t(".toc-container"),
        n = [];
    i.on("click", ".item-name", function(t) { t.preventDefault() }), i.on("click", ".video-name", function(i) { e.trigger("play.video.by.id", [+t(this).closest("li").data("videoId")]) }), t(".toc-items li[data-item-id]").each(function(e, i) { var r = t(i),
            d = { id: r.data("itemId"), type: r.data("itemType"), isLocked: r.hasClass("locked") };
        n.push(d) }), e.on("get.toc.index", function(t, e, i) { for (var r = { index: -1, id: e, type: i }, d = (n.length, 0); d < n.length; d++) { var a = n[d];
            a.type === i && a.id === e && (r = { index: d, id: a.id, type: a.type }) } return r }), e.on("get.current.item", function(t) { return i.find(".toc-items li.current") }), e.on("get.toc", function(t, i, r) { var d = (n.length, e.triggerHandler("get.toc.index", [i, r])); return e.triggerHandler("get.toc.elm", [d]) }), e.on("prev.toc", function(t) { var i = e.triggerHandler("get.current.item"),
            r = e.triggerHandler("get.toc.index", [i.data("itemId"), i.data("itemType")]); if (r.index !== -1) { for (var d = null, a = r.index - 1; a >= 0; a--)
                if (n[a].isLocked === !1) { d = n[a]; break } if (d) return e.triggerHandler("get.toc.elm", [d]) } }), e.on("next.toc", function(t) { var i = e.triggerHandler("get.current.item"),
            r = e.triggerHandler("get.toc.index", [i.data("itemId"), i.data("itemType")]),
            d = e.triggerHandler("is.last.toc", [r.id, r.type]); if (!d) { var a = e.triggerHandler("get.toc.index", [r.id, r.type]); if (a.index !== -1) { for (var o = null, c = a.index + 1, g = n.length; c < g; c++)
                    if (n[c].isLocked === !1) { o = n[c]; break } if (o) return e.triggerHandler("get.toc.elm", [o]) } } }), e.on("is.last.toc", function(t, i, r) { var d = n.length,
            a = e.triggerHandler("get.toc.index", [i, r]); return a.index == d - 1 }), e.on("get.toc.elm", function(e, i) { return t('.toc-items li[data-item-id="' + i.id + '"][data-item-type="' + i.type + '"]') }), e.on("get.transcript.elm", function(e, i) { return t('.transcript-items li[data-item-id="' + i.id + '"][data-item-type="' + i.type + '"]') }) }(jQuery);
! function(t) { var r = t("body");
    r.on("transcript.timeupdate", function(n, a, e) { var i = t(a + " .transcript"),
            c = t(a + " .transcript.current"),
            s = i.filter(function(r, n) { var a = parseFloat(t(n).data("duration")); return e > a }).last(); if (0 !== s.length) { var u = t(s).get(0);
            u && u !== c.get(0) && (r.trigger("transcript.current.change", s), i.not(s).removeClass("current"), s.addClass("current")) } }), r.on("click", ".transcripts .transcript", function(n) { r.trigger("transcript.select", t(this).data("duration")) }) }(jQuery);
! function(e) {
    function t(t, r, a, n) { e.cookie("codeplaygrounddiscoverymodalskip", "1", { expires: 365, path: "/" }), n = "undefined" != typeof n && null !== n ? n : r ? "ToC" : "TopBtn"; var i = "/code/" + q + "/environment/?courseId=" + R + (t ? "&videoId=" + t : "") + (!r && a ? "&default=1" : "") + "&src=" + n; return C && !C.closed ? (C.focus(), C.location = i, !1) : (C = window.open(i, "", "scrollbars=no, menubar=no, status=no, titlebar=no, toolbar=no, location=no, resizable=yes, width=940, height=593"), !1) }

    function r(r) { lynda.jsTrackingEnabled && "undefined" != typeof lynda.generateTrackingId && (j = lynda.generateTrackingId(), videoTrackingModule.init(V, R, r, j)); var a = !!e('ul.course-toc li[data-video-id="' + r + '"] .practice-environment').length;
        a ? e("#btn-practice-environment").off("click").on("click", function() { t(r, !1, !1) }) : e("#btn-practice-environment").off("click").on("click", function() { t(e(this).data("peVideoId"), !1, !0) }), e(".view-offline-tab .tab-download-app-cta").data("video-id", r) }

    function a() { clearTimeout(T), y(), T = setTimeout(function() { Y.fadeOut(500, "swing", n) }, 3e3) }

    function n() { 0 === e(".mejs-container-fullscreen").length && y() }

    function i() { var t = e.cookie("player"); if (t) return JSON.parse(t) }

    function o(t) { if (!isNaN(X) && X > 0 && t > 0) { var r = parseInt(t); if (r % X === 0 && r !== G) { G = r; var a = m(); if (!a) return;
                e("body").trigger("li.track.action", ["PlayerPositionChangedEvent", { state: a, mediaTrackingObject: v() }]) } } }

    function s() { for (var e, t = [], r = window.location.href.slice(window.location.href.indexOf("?") + 1).split("&"), a = 0; a < r.length; a++) e = r[a].split("="), t.push(e[0]), t[e[0]] = e[1]; return t }

    function c() { var t = x.triggerHandler("prev.toc"),
            r = x.triggerHandler("next.toc");
        e("#player-previous, #player-next").attr("disabled", "disabled"), "undefined" != typeof t && t.length && e("#player-previous").removeAttr("disabled"), "undefined" != typeof r && r.length && e("#player-next").removeAttr("disabled") }

    function l(e, t, r) { if (e) return void("undefined" != typeof n && x.trigger("course.video.error", [e, R, t, n.name, K, n.urls[K]]));
        x.trigger("course.video.change", [R, t, z]), z && (z = null); var a = "",
            n = U[D]; if (n.urls[K]) a = n.urls[K];
        else { var i = Object.keys(n.urls),
                o = i.length > 0 ? i.length - 1 : 0;
            a = n.urls[i[o]] } Y.is(":visible") || (y(), c()), x.trigger("toggle.player.container", ["video-container"]), V.trigger("playUrl", [a, r, R, t, n.name, K]) }

    function d(t) { t && (e(".headline-course-title").text(t.CourseTitle), e(".headline-from").text(function() { return this.getAttribute("data-text") }), e("h1.default-title").text(t.VideoTitle), e(".headline-from-holder").show(), e("title").html(t.VideoTitle)) }

    function u(t, r) { var a = e(".video-description");
        t && r && a.length && e.get("/ajax/course/" + t.toString() + "/" + r.toString() + "/getvideodesc").done(function(t) { if (!e.isEmptyObject(t)) { a.html(t.videodesc); var r = e("#video-desc-heading");
                r.html(r.data("text")) } }) }

    function g(t, a) { A = t, r(t), y(), x.trigger("course.video.hideendplate"), V.trigger("hidepostroll"), e("#banner-thumbnail").hide(), e("#courseplayer").removeClass("hide"); var n = !!e('ul.course-toc li[data-video-id="' + A + '"]').hasClass("locked"); return n ? (V.data("isLoggedIn") && !V.data("isExpired") || x.trigger("course.video.showendplate"), Y.hide(), x.trigger("course.video.change", [R, t, z]), void(z && (z = null))) : void("undefined" != typeof t && e.get("/ajax/course/" + +R + "/" + +t + "/play").done(function(e) { U = e, D = 0, l(0 === U.length ? "No stream information available" : null, t, a) }).fail(function(e) { l(e, t) })) }

    function f() { e("body").trigger("stream.qualities.available", [V.data("conviva").QualitiesAvailable]) }

    function p() { return "urn:li:lyndaVideo:(urn:li:lyndaCourse:" + R + "," + A + ")" }

    function m() { var e = V.get(0); if (!isNaN(e.duration)) { var t = { mediaUrn: p(), length: Math.round(e.duration), timeElapsed: Math.round(e.currentTime), volume: 100 * +e.volume, speed: e.playbackRate, mediaViewTrackingId: "", isPlaying: !e.paused, bitrate: K }; return t } }

    function v() { return { objectUrn: p(), trackingId: j } }

    function h() { var e = V.get(0);
        e.played.length ? e.play() : g(A) }

    function y() { e("#courseplayer").removeClass("controls-hidden"), Y.show() }

    function b() { if (!Re) { Re = !0; var t = e("#courseplayer"),
                r = e("#banner-thumbnail");
            t.length && r.length && (t.removeClass("hide"), r.addClass("hide")) } }

    function k(t) { e(".playback-rates li a[data-playback-rate='" + String(t).replace("0.", ".") + "']").click() }

    function w() { x.on("keydown", "#video-container", function(e) { var t = V.get(0),
                r = e.ctrlKey || e.shiftKey || e.altKey || e.metaKey,
                a = e.ctrlKey || e.altKey || e.metaKey; switch (e.keyCode) {
                case ee:
                    if (r) return !0;
                    b(), y(), t.paused ? V.trigger("resume") : t.pause(), Ne = "spacebar"; break;
                case te:
                    "undefined" != typeof e.target && e.target.click(); break;
                case re:
                    var n = t.currentTime; if (e.shiftKey && !a) { var i = O;
                        i -= .25, i < .5 && (i = .5), k(i), Ne = "shift-left" } else { if (r) return !0;
                        n -= 10, Ne = "left" } V.trigger("updatetime", n), y(); break;
                case ae:
                    var n = t.currentTime; if (e.shiftKey && !a) { var i = O;
                        i += .25, i > 2 && (i = 2), k(i), Ne = "shift-right" } else { if (r) return !0;
                        n += 10, Ne = "right" } V.trigger("updatetime", n), y(); break;
                case ne:
                case ie:
                case oe:
                case se:
                case ce:
                case le:
                case de:
                case ue:
                case ge:
                case fe:
                case pe:
                case me:
                case ve:
                case he:
                case ye:
                case be:
                case ke:
                case we:
                case Ce:
                case Te:
                    if (r) return !0; var o, s = t.duration,
                        c = s / 10;
                    o = e.keyCode < 58 ? e.keyCode - 48 : e.keyCode - 96; var n = o * c;
                    isNaN(n) && (n = 0), V.trigger("updatetime", n), Ne = "number-" + o, y(); break;
                case Ie:
                    if (r) return !0;
                    V.trigger("fullscreen"), Ne = "F"; break;
                case je:
                case Pe:
                    if (r) return !0;
                    V.trigger("updatetime", 0), Ne = "home", e.keyCode == je && (Ne = "O"); break;
                case Oe:
                    var s = t.duration - .5;
                    V.trigger("updatetime", s), Ne = "end"; break;
                case xe:
                    if (r) return !0;
                    V.trigger("previous"), Ne = "J"; break;
                case Ee:
                    if (r) return !0;
                    V.trigger("pause"), Ne = "K"; break;
                case Ve:
                    if (r) return !0;
                    V.trigger("next"), Ne = "L"; break;
                case Se:
                    if (r) return !0;
                    N || V.trigger("popout"), Ne = "P"; break;
                case Ke:
                    if (r) return !0; var l = t.volume + .05;
                    l > 1 && (l = 1), t.volume = l, Ne = "up-arrow"; break;
                case Le:
                    if (r) return !0; var l = t.volume - .05;
                    l < 0 && (l = 0), t.volume = l, Ne = "down-arrow"; break;
                default:
                    return !0 } return x.trigger("ga.event", { action: "keypress", label: Ne, value: R }), !1 }) } var C, T, I, j, x = e("body"),
        E = e(window),
        V = e("#courseplayer video.player"),
        S = V.data("continuousPlay"),
        P = V.data("autostart"),
        O = V.data("playbackRate") || 1,
        K = V.data("quality") || 540,
        L = e("#course-page"),
        N = L.hasClass("course-popout"),
        R = +L.data("courseId"),
        q = L.data("environmentId"),
        A = +L.data("initialVideoId"),
        H = +L.data("initialVideoId"),
        M = V.data("logViews") || !0,
        Q = !1,
        D = (e(".course-toc"), 0),
        U = [],
        z = null,
        W = null,
        F = e("html").hasClass("no-touch"),
        J = !1,
        Z = (new Date).toISOString(),
        B = 0,
        G = -1,
        X = lynda.playerTrackingFrequency,
        Y = (lynda.recommendLogMax, e(".mejs-controls")),
        _ = V.data("isComplete") || !1;
    e("html").hasClass("non-member");
    x.on("launch.code.environment", function(e, r, a, n) { t(r, a, n) }), x.on("click", ".launch-code-practice", function() { var r = !!e('ul.course-toc li[data-video-id="' + A + '"] .practice-environment').length,
            a = "undefined" != typeof e(this).data("src") ? e(this).data("src") : null;
        r ? t(A, !1, !1, a) : t(e(this).data("peVideoId"), !1, !0, a) }), x.on("click", ".practice-environments-retiring", function() { e("#practice-environments-retiring-modal").modal() }), x.on("current.video.changed", r), r(A), e(".course-toc i.code").on("click", function() { var r = e(this).closest("li").data("videoId");
        t(r, !0, !1) }), S = !!S, e(".mejs-time-total").append('<div class="mejs-time-indicator"><span class="mejs-time-handle-custom"></span><span class="mejs-time-float-custom"></span></div>'), E.on("popstate", function(e) { if (null !== e.originalEvent.state) { var t = e.originalEvent.state && e.originalEvent.state.id ? +e.originalEvent.state.id : H;
            z = !0, g(t) } }), V.on("loadstart", function() { if (f(), Q = !1, lynda.ccAvailable) { var t = V.find("track").data("initial");
            t ? V.find("track").data("initial", null) : V.trigger("track.load", "/ajax/player/transcript?courseId=" + R + "&videoId=" + A), e(".mejs-time").attr("tabindex", -1) } }), N && (f(), e("#courseplayer").find(".view-mode").hide(), e("#courseplayer").find(".mejs-container").addClass("is-popout")), V.on("play", function(t) { var r = e("#social-share-certificate-banner");
        1 === r.length && r.hide(), e("#courseplayer").find(".mejs-time-float").hide(), 0 === t.target.currentTime && M && !Q && (e.ajax({ url: "/ajax/course/player/video/view?videoId=" + A, cache: !1, success: function(t) { if (t.IsComplete) { _ = !0; var r = e("#course-tabs").parent();
                    e.get("/course/certificate/" + R).done(function(t) { e(t.html).insertBefore(r) }) } if ("undefined" != typeof t.LmsContent && null !== t.LmsContent && t.LmsContent.length > 0) { var a = t.LmsContent;
                    JSON.parse(a).IsUseCors ? x.trigger("lms.request", [a]) : "undefined" != typeof flashReady && null !== flashReady && flashReady && x.trigger("lms.request", [a]) } } }), e("i.popover-trigger[data-videoid=" + A + "]").addClass("eye"), "undefined" != typeof opener && opener && e("i.popover-trigger[data-ga-value=" + A + "]", window.opener.document).addClass("eye"), Q = !0), B != A && (Z = (new Date).toISOString(), G = -1) }).on("playing", function(e) { c(), V.get(0).playbackRate = O }).on("next", function() { var e = x.triggerHandler("next.toc"); if (e) { if (x.triggerHandler("is.last.toc", [e.id, e.type])) return;
            e.find(".item-name").trigger("click") } }).on("previous", function() { var e = x.triggerHandler("prev.toc");
        e && e.find(".item-name").trigger("click") }).on("ended", function() { if (V.data("isLoggedIn") && !V.data("isExpired") || null === V[0].dataset.features.match(/customendplate/gi)) { var t = x.triggerHandler("is.last.toc", [A, "video"]); if (t) return x.trigger("course.ended"), V.trigger("showpostroll"), void(V.data("isLoggedIn") && null !== V[0].dataset.features.match(/customendplate/gi) && _ && (x.trigger("course.video.showendplate"), e.post("/ajax/user/saw-ratings", { pageKey: x.attr("data-jstracking-page-key") ? x.attr("data-jstracking-page-key") : lynda.jsTrackingPageKey }))); if (!S) return;
            e(this).trigger("next") } else x.trigger("course.video.showendplate") }).on("timeupdate", function(e) { x.trigger("course.video.timeupdate", [e, A]), o(e.currentTarget.currentTime) }).on("streamQuality", function(e, t) { K = t, 0 === U.length ? g(A, V.get(0).currentTime) : l(null, A, V.get(0).currentTime) }).on("getCurrentVideoId", function() { x.trigger("course.get.video.id", A) }).on("continuousPlay", function(e, t) { S = t }).on("playbackRate", function(e, t) { O = t }).on("error", function(t) { var r = U[D];
        e(this).trigger("course.video.error", [R, A, r.name, K, r.urls[K]]) }).on("updatetime", function(e, t) { var r = V.get(0);
        J ? (r.setCurrentTime(t), r.play()) : g(A, t) }).on("seeked", function(e) { var t = V.get(0),
            r = t.currentTime;
        x.trigger("li.track.action", ["PlayerSeekEvent", { previousTimeElapsed: r, state: m(), mediaTrackingObject: v() }]) }).on("playVideoId", function(e, t, r) { g(t, r || 0) }).on("popout", function(t) { V.get(0).pause(); var r = V.innerHeight() / V.innerWidth(),
            a = 1130,
            n = e("#courseplayer .mejs-controls"),
            i = Math.ceil(a * r) + n.height();
        navigator.userAgent.match(/(?=.*\bsafari\b)(?=.*\bmac\s+os\s+x).*/gi) && (i += 45); var o = parseInt(V.get(0).currentTime, 10),
            s = window.screenLeft ? window.screenLeft : window.screenX,
            c = window.screenTop ? window.screenTop : window.screenY,
            l = s + window.innerWidth / 2 - a / 2,
            d = c + window.innerHeight / 2 - i / 2;
        W = window.open(lynda.culturePrefix + "/course/popout/" + R + "/" + A + "?tc=" + o, "", "resizable=yes, height = " + i + ", width = " + a + ", top=" + d + ", left=" + l), e(".mejs-popout-layer").show(), Y.prepend('<div class="controls-overlay"></div>') }).on("popoutClose", function(t) { e(".mejs-popout-layer").hide(), e(".mejs-controls .controls-overlay").remove(), "undefined" != typeof W && null !== W && W.jQuery(W).trigger("popoutCloseSelf") }).on("theater.toggle", function(t) { e("html").toggleClass("theater-mode"), V.trigger("resize"); var r = e("html").hasClass("theater-mode"),
            a = i() || {};
        a.theaterMode = r, V.trigger("settings.save", [a]), x.trigger("theater.toggle.done") }).on("video.metadata.loaded", function(e, t) { d(t), u(t.CourseId, t.VideoId) }).on("play pause loadedmetadata", function() { var e = m();
        e && x.trigger("li.track.action", ["PlayerPlayPauseEvent", { reason: "USER_TRIGGERED", state: e, mediaTrackingObject: v() }]) }).on("loadedmetadata", function(e) { J = !0 }).on("video.error", function(e) { var t, r = V.data("conviva"),
            a = r.QualitiesAvailable; if (a) { for (t = 0; t < a.length && parseInt(a[t]) !== K; t++); if (t > 0) { var n = K;
                K = parseInt(a[t - 1]), V.trigger("log.message", { code: 9901, message: "VideoError: Changing video quality", data: "Quality changed from " + n + " to " + K + ". VideoId: " + A }), l(!1, A, 0) } else if ("undefined" != typeof U && D + 1 !== U.length) { var o = D;
                D += 1; var s = i() || {};
                K = "undefined" != typeof s.quality ? s.quality : 540, V.trigger("log.message", { code: 9902, message: "VideoError: Changing CDN", data: "CDN changed from " + U[o].name + " to " + U[D].name }), l(!1, A, 0) } } }), window.onunload = function() { "undefined" != typeof opener && opener && opener.jQuery(opener).trigger("popoutClosing", [V.get(0).currentTime, A]) }, E.on("popoutClosing", function(t, r, a) { e(".mejs-controls .controls-overlay").remove(), e(".mejs-popout-layer").hide(), V.trigger("playVideoId", [a, r]) }), E.on("popoutCloseSelf", function() { self.close() }), x.on("play.video.by.id", function(e, t) { g(t) }), e(document).on("webkitfullscreenchange mozfullscreenchange fullscreenchange MSFullscreenChange", function(e) { clearTimeout(T), clearTimeout(I), y() }), x.on("mousemove", ".mejs-container-fullscreen", function() { I && clearTimeout(I), y(), I = setTimeout(function() { I = 0, x.hasClass("hasPopout") || Y.fadeOut(500, "swing", n) }, 3e3) }), x.on("mouseenter", ".mejs-container-fullscreen", function(e) { a() }), x.on("mouseleave", ".mejs-container-fullscreen", function(e) { clearTimeout(T), Y.fadeOut(500, "swing", n) }), x.on("click", ".postroll-controls-replay", function(e) { var t = x.triggerHandler("prev.toc");
        t.length && t.find(".item-name").trigger("click") }), x.on("updatePercent", function() { var t, r, a, n, i = document.querySelector(".banner-play-icon"),
            o = e(".banner-play-label"); if (o && i && document.documentElement.clientWidth >= 752) { i.style.left = -(o.outerWidth() / 2).toString() + "px", i.style.opacity = 1; var s = i.getAttribute("data-play-percent"); if (!s) return; if (s = parseInt(s, 10), t = e(".arc.part1"), r = e(".arc.part2"), a = e(".clip"), 100 === s) return t.hide(), r.hide(), void a.hide();
            s > 50 ? (n = Math.round(360 * (s - 50) / 100) + 180, a.css({ clip: "rect(auto auto auto auto)" }), t.css({ transform: "rotateZ(180deg)" }), r.css({ transform: "rotateZ(" + n + "deg)" }), r.show()) : (n = Math.round(360 * s / 100), t.css({ transform: "rotateZ(" + n + "deg)" }), r.hide(), a.removeAttr("style")) } else i && (i.style.opacity = 1) }), F && w(); var $ = s();
    $ && $.tc ? setTimeout(function() { var t = e("#courseplayer video.player"),
            r = parseInt($.tc, 10);
        t.trigger("playVideoId", [A, r]) }, 500) : P && (V.trigger("playVideoId", [A, 0]), P = !1); var ee = 32,
        te = 13,
        re = 37,
        ae = 39,
        ne = 48,
        ie = 49,
        oe = 50,
        se = 51,
        ce = 52,
        le = 53,
        de = 54,
        ue = 55,
        ge = 56,
        fe = 57,
        pe = 96,
        me = 97,
        ve = 98,
        he = 99,
        ye = 100,
        be = 101,
        ke = 102,
        we = 103,
        Ce = 104,
        Te = 105,
        Ie = 70,
        je = 79,
        xe = 74,
        Ee = 75,
        Ve = 76,
        Se = 80,
        Pe = 36,
        Oe = 35,
        Ke = 38,
        Le = 40,
        Ne = "",
        Re = !1;
    V.on("resume", h), V.on("postroll.show", b), x.trigger("updatePercent") }(jQuery);
! function(e) {
    function t(e) { a() }

    function o(t) { e(".popover").popover("hide") }

    function n(t) { t.preventDefault(), e.post(e(this).attr("href")).error(function() { v.trigger("course.notes.export.error") }).done(function(e) { v.trigger("google.drive.upload", [e.Content, e.Title]) }) }

    function r(t) { t.preventDefault(); var o = e(this).data("enoteAuth");
        e.post(e(this).attr("href")).error(function() { v.trigger("course.notes.export.error") }).done(function(t) { t.Success ? v.trigger("course.notes.export.success") : t.NeedAuthorizationToken ? e.post(o).error(function() { v.trigger("course.notes.export.error") }).done(function(t) { e("<button id='enote_temp_btn'></button>").hide().appendTo("body").click(function() { window.open(t, "enoteAuth", "toolbar=no,menubar=no,location=no"), e(this).remove() }).click() }) : v.trigger("course.notes.export.error") }) }

    function a() { k = y }

    function s(t) { t.preventDefault(), e(this).closest(".chapter").toggleClass("collapsed") }

    function i(t) { e.get("/ajax/course/" + m + "/notes").done(function(o) { var n = e(o.html).filter(".note");
            e("#notes-export").toggleClass("hide", 0 === n.length), n.each(function() { f(e(this), t) }), v.trigger("course.notes.load"), e('#notes-content [data-toggle="tooltip"]').tooltip() }), C.hide(), b.removeClass("hidden") }

    function d(t) { if (13 === +t.keyCode && !t.shiftKey || "focusout" === t.type) { if (t.preventDefault(), !h) { var o = e("[data-initial-video-id]"); if (o.length && (h = o.data("initialVideoId")), 0 === h) return } var n = e(this).closest(".note"),
                r = n.data("noteId"),
                a = e(this).find("textarea").val() || n.find(".note-content").html(); if (0 === a.length) return;
            e(".note.new").removeClass("new"), e.post("/ajax/course/" + m + "/note", { noteId: r || 0, courseId: m, videoId: h, timeInSeconds: k, content: a.replace(/\n/g, "<br />") }).done(function(e) { n.hasClass("create") ? i(e.Id) : (n.find(".note-content").blur(), n.addClass("new"), setTimeout(function() { n.removeClass("new") }, 2e3)) }), n.hasClass("create") && e(this).find("textarea").val("").blur() } }

    function c(t) { t.preventDefault(); var o = e(this).closest(".note");
        v.trigger("note.play", [o.data("videoId"), o.data("seconds")]) }

    function l(t) { t.preventDefault(), e(this).closest(".note").find(".note-content").focus() }

    function u(t) { t.preventDefault(); var o = e(this).closest(".note"),
            n = o.data("noteId");
        v.trigger("ga.event", { action: "click", label: "notes-delete", value: n }), e.ajax({ url: "/ajax/course/note/" + +n, method: "DELETE" }), p(o) }

    function p(e) { var t = e.data("videoId"),
            o = e.data("noteId"),
            n = x.find(".chapter[data-video-ids*='" + t + "']"),
            r = x.find(".chapter-notes[data-video-ids*='" + t + "']");
        e.remove(), r.children().length || (r.addClass("hidden"), n.addClass("hidden")), v.trigger("course.note.delete", [o, t]) }

    function f(t, o) { var n = t.data("videoId"); if (n) { var r = t.data("noteId"),
                a = x.find(".note[data-note-id='" + r + "']"); if (a.length) a.html(t.html());
            else { var s = x.find(".chapter[data-video-ids*='" + n + "']"),
                    i = x.find(".chapter-notes[data-video-ids*='" + n + "']");
                i.append(t), i.removeClass("hidden"), s.removeClass("hidden") } r === o && (e(".note.new").removeClass("new"), t.addClass("new")) } } var h, v = e("body"),
        g = e("html").hasClass("no-touch"),
        m = +e("#course-page").data("courseId"),
        x = e("#course-notes"),
        C = e("#placeholder-notes"),
        b = e("#notes-content .note.create form"),
        k = 0,
        y = 0;
    x.on("click", ".note .delete", u), x.on("click", ".note .note-content", l), x.on("click", ".note .play", c), e("#notes-tab").one("click", function() { i(0) }), v.on("keypress", ".note .note-content, .note.create form", d), v.on("keydown", ".note-content, #new-note", function(t) { var o = t.keyCode || t.which; if (27 === +o) { var n = e(t.currentTarget);
            n.blur(); var r = n.attr("id");
            r && n.val("") } }), v.on("click", ".notes-export-download", function(t) { if (g) { t.preventDefault(); var o = document.getElementById("export-download-frame") || document.createElement("iframe");
            o.id = "export-download-frame", o.style.display = "none", document.body.appendChild(o), o.src = e(this).attr("href") } }), v.on("focus", ".note.create textarea", t), v.on("click", ".chapter, .toggle", s), v.on("click", ".notes-export", o), v.on("click", '.notes-export[data-type="gdoc"]', n), v.on("click", '.notes-export[data-type="enote"]', r), v.on("course.notes.export.error,google.drive.export.error", function(t) { v.trigger("alert.danger", [e("#export-error-message").html()]) }), v.on("course.notes.export.success,google.drive.export.success", function(t) { v.trigger("alert.danger", [e("#export-success-message").html()]) }), v.on("course.video.timeupdate", function(e, t, o) { y = parseInt(t.currentTarget.currentTime), h = o }), v.on("keypress paste", "[contenteditable=true]", function(e) { if (this.innerText.length >= +this.getAttribute("maxlength")) return e.preventDefault(), !1 }), v.popover({ html: !0, animation: !1, container: "body", selector: "#notes-export", placement: "bottom", template: '<div class="popover dark-pop notes-export-popover"><div class="arrow"></div><div class="popover-content"></div></div>', content: function() { return e(".popover").not(this).popover("hide"), e("#course-notes-download").clone().removeClass("hidden").html() } }), v.on("course.notes.load course.note.delete", function() { var t = e("#course-notes .note[data-note-id]").length,
            o = e("#getting-started-notes");
        0 == t ? o.show() : o.hide(), e("#notes-tab span").text(t), e("#notes-export").toggleClass("hide", 0 === t) }) }(jQuery);
! function(o) { $body = o("body"), $body.on && $body.on("click", ".lms-download-trigger", function(o) { switch (lynda.lmsProtocol) {
            case "aicc":
                o.data === !0 ? window.location = lynda.AiccExportAsIndividualItems : lynda.AiccExportAsWholePlaylist ? window.location = lynda.AiccExportAsWholePlaylist : window.location = lynda.AiccExport; break;
            case "lti":
                o.data === !0 ? window.location = lynda.LtiExportAsIndividualItems : lynda.LtiExportAsWholePlaylist ? window.location = lynda.LtiExportAsWholePlaylist : window.location = lynda.LtiExport; break;
            default:
                return !1 } }) }(jQuery);
! function(s) {
    function e(e, t) { s.get("/ajax/assessment/start/" + r + "?sessionId=" + e + "&assessmentType=" + d).done(function(e) { e.isIncomplete ? (h.data("session-id", e.prevSessionId), s(t).popover({ html: !0, animation: !1, container: "#assessment-holder", template: '<div class="popover dark-pop resume-assessment-popover" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>', content: function() { return s(".popover").not(this).popover("hide"), s("#resume-assessments-popover-cont").clone().removeClass("hide").html() } }), s(t).popover("show")) : e && e.html && e.html.length && h.html(e.html) }) }

    function t() { var e = h.data("session-id");
        s.get("/ajax/assessment/results/" + r + "?sessionId=" + e + "&assessmentType=" + d).done(function(s) { s && s.html && s.html.length && h.html(s.html) }) }

    function n(e) { s.get("/ajax/assessment/resume/" + r + "/" + e + "?assessmentType=" + d).done(function(s) { s && s.html && s.html.length && h.html(s.html) }) }

    function a(t, n) { s.get("/ajax/assessment/session/end/" + r + "/" + t).done(function(s) { t = (new Date).getTime(), h.data("session-id", t), e(t, n) }) }

    function o(s) { switch (s) {
            case "pre":
                return 1;
            case "post":
                return 2;
            default:
                return 4 } }

    function i(s) { if (c && !c.closed) return c.focus(), !1; var e = 1024,
            t = 730,
            n = window.screenLeft ? window.screenLeft : window.screenX,
            a = window.screenTop ? window.screenTop : window.screenY,
            o = n + window.innerWidth / 2 - e / 2,
            i = a + window.innerHeight / 2 - t / 2; return c = window.open("/exam/popout/" + s + "/" + r, "Practice Exam", "scrollbars=yes, menubar=no, status=no, titlebar=no, toolbar=no, location=no, resizable=yes, height=" + t + ", width = " + e + ", top=" + i + ", left=" + o), !1 } var r, d, c, l = s("body"),
        m = s("#assessment-container"),
        h = s("#assessment-holder"),
        u = s("#courseplayer video.player"),
        p = s(".toc-container");
    p.on("click", ".assessment-item", function(e) { var t = s(this),
            n = t.closest("li"),
            a = t.data("entityId");
        r = t.data("assessmentId"), d = o(n.data("assessment-type")), u.length && u.get(0).pause(), s(".transcript-items .video-transcripts").remove(), s(".toc-items li").removeClass("current"), n.addClass("current"), s.get("/ajax/assessment/" + a + "/" + r + "?assessmentType=" + d).done(function(s) { h.length && s && s.html && s.html.length && (h.html(s.html), l.trigger("toggle.player.container", ["assessment-container"])) }).error(function(e) { s("#banner-thumbnail").is(":visible") && s("#banner-thumbnail").hide(), u.length && u.get(0).play() }) }), m.length && (m.on("click", ".start-assessment, .retake-assessment", function() { r = s(this).data("assessmentId"), d = o(s(this).data("assessmentType")); var t = null;
        t = (new Date).getTime(), h.data("session-id", t), e(t, this) }), m.on("click", ".skip-to-next-chapter", function() { u.trigger("next") }), m.on("click", ".next", function() { var e = s(".assessment-section"),
            t = e.data("currentQuesId"),
            n = e.data("last-ques") === !0,
            a = h.data("session-id");
        n ? s.get("/ajax/assessment/results/" + r + "?sessionId=" + a + "&assessmentType=" + d).done(function(e) { e && e.html && e.html.length && (h.html(e.html), s('.assessment-watched-cont[data-assessment-id="' + r + '"]').find("i").addClass("checkmark"), "undefined" != typeof opener && opener && s('.assessment-watched-cont[data-assessment-id="' + r + '"]', window.opener.document).find("i").addClass("checkmark")) }) : s.get("/ajax/assessment/next/" + r + "/" + t + "?sessionId=" + a + "&assessmentType=" + d).done(function(s) { s && s.html && s.html.length && h.html(s.html) }) }), m.on("click", ".prev", function() { var e = s(".assessment-section"),
            t = e.data("currentQuesId"),
            n = h.data("session-id");
        s.get("/ajax/assessment/prev/" + r + "/" + t + "?sessionId=" + n + "&assessmentType=" + d).done(function(s) { s && s.html && s.html.length && h.html(s.html) }) }), m.on("click", ".last", function() { var e = s(".assessment-section"),
            t = e.data("currentQuesId"),
            n = h.data("session-id");
        s.get("/ajax/assessment/last/" + r + "/" + t + "?sessionId=" + n + "&assessmentType=" + d).done(function(s) { s && s.html && s.html.length && h.html(s.html) }) }), m.on("click", "#assessment-question .optn", function() { var e = s(this),
            t = s(".assessment-section"),
            n = t.data("currentQuesId"),
            a = e.data("optionId"),
            o = h.data("session-id"); "undefined" != typeof a && "undefined" != typeof n && s.get("/ajax/assessment/validate/" + r + "/" + n + "/" + a + "?sessionId=" + o + "&assessmentType=" + d).done(function(t) { if (t && t.status && "ok" == t.status) { if (t.isCorrectAnswer) e.addClass("correct"), e.find(".opt-icon").addClass("checkmark");
                else { var n = s('.answers [data-option-id="' + t.correctAnswer.OptionId + '"]');
                    e.addClass("wrong"), e.find(".opt-icon").addClass("close-x"), n.addClass("correct"), n.find(".opt-icon").addClass("checkmark") } s("#assessment-question .optn").attr("disabled", "disabled"), s(".next").removeAttr("disabled") } else t && t.message && console.log(t.message) }) })), l.on("click", "#resume-assessment", function(e) { var t = h.data("session-id");
        s(".start-assessment").popover("destroy"), n(t, this) }), l.on("click", "#restart-assessment", function(e) { var t = h.data("session-id");
        s(".start-assessment").popover("destroy"), a(t, this) }), l.on("click", ".take-practice-exam", function() { r = s(this).data("assessmentId"); var e = s(this).data("courseId");
        i(e) }), l.on("click", "#get-results", function() { s(".modal").modal("hide"), t() }), l.on("click", function(e) { s(".resume-assessment-popover").not(this).popover("destroy") }), s(window).on("resize", _.debounce(function(e) { s(".toc-items li.toc-assessment-item").length && (window.innerWidth < 768 ? l.trigger("toggle.player.container", ["video-container"]) : s(".toc-item.current").hasClass("toc-assessment-item") && m.hasClass("hide") && l.trigger("toggle.player.container", ["assessment-container"])) }, 250)) }(jQuery);
! function(e) {
    function t(t) { t && e.ajax({ url: t, headers: { offset: (new Date).getTimezoneOffset() }, type: "POST" }).done(function(t) { t && t.html && e("#reminders").replaceWith(t.html), o() }) }

    function o() { var t = e("#reminders"),
            o = t.data("view"),
            r = t.data("variation");
        t.length && o && r && n("impression", o + " " + r) }

    function n(e, t) { e && t && r.trigger("ga.event", { category: "Reminders", action: e, label: t }) } var r = e("body"),
        i = e("#course-page"),
        a = e("#courseplayer video.player"),
        s = '<div class="popover dark-pop <%= name %>" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
        c = e("#btn-more.reminders-show-hopscotch i");
    e(window).resize(_.debounce(function() { e("#reminders .popover").popover("hide") }, 150)), i.on("click", "#reminders [data-client]", function(o) { e("#reminders .popover").popover("hide"); var i = _.object(e("#reminders form").serializeArray().map(function(e) { return [e.name, e.value] })),
            a = e(this).data("client");
        r.trigger("reminders.calendar.create", { client: a, monday: "on" === i.monday, tuesday: "on" === i.tuesday, wednesday: "on" === i.wednesday, thursday: "on" === i.thursday, friday: "on" === i.friday, saturday: "on" === i.saturday, sunday: "on" === i.sunday, duration: i.duration, time: i.time, summary: i.summary, details: i.details, url: i.url, courseUrn: i.courseUrn }), n("click", "Client - " + a), t(e("#reminders form").attr("action")) }), i.on("click", "#reminders .day-of-week", function(t) { var o = e(this).attr("for");
        n("click", "Day " + (e("#" + o).is(":checked") ? "Off" : "On") + " - " + o) }), i.on("click", "#reminders .customize-reminder", function(o) { o.preventDefault(), t(e(this).attr("href")) }), i.on("click", "#try-reminders-close", function(e) { e.preventDefault(), n("click", "Tooltip Got It"), c.popover("hide") }), i.on("click", "#reminders .no-thanks", function(t) { t.preventDefault(), n("click", "No Thanks " + e("#reminders").data("variation")), a.trigger("resume") }), i.on("click", "#reminders .resume", function(e) { e.preventDefault(), n("click", "Resume"), a.trigger("resume") }), a.on("postroll.show", function() { o() }), i.on("click", ".time-custom-option", function(t) { var o = e(this),
            r = o.data("value");
        e(".select-time span").text(r), e('#reminders [name="time"]').val(r), e(".popover").popover("hide"), e("#course-page .time-custom-option").removeClass("selected"), e('#course-page .time-custom-option[data-value="' + r + '"]').addClass("selected"), n("click", "Time Select - " + r) }), i.on("submit", "#reminders form", function(e) { e.preventDefault() }), c.on("shown.bs.popover", function() { e("body").trigger("lazy.init"), n("impression", "Hopscotch") }).popover({ html: !0, animation: !1, trigger: "manual", placement: "bottom", container: "#course-page .title-buttons", viewport: "#course-page", template: _.template(s)({ name: "try-reminders-pop" }), content: function() { return e(".popover").not(this).popover("hide"), e("#try-reminders-popover").clone().removeClass("hide").html() } }).popover("show"), i.popover({ html: !0, animation: !1, selector: "#reminders .select-time", container: "#course-page", placement: "bottom", template: _.template(s)({ name: "select-times-pop" }), content: function() { return e(".popover").not(this).popover("hide"), e("#select-times-popover").clone().removeClass("hide").html() } }).on("shown.bs.popover", "#reminders .select-time", function() { var t = e("#course-page .select-times-pop"),
            o = t.find(".time-custom-option.selected"),
            n = t.find(".time-custom-select");
        n.animate({ scrollTop: o.position().top + o.height() / 2 - n.height() / 2 }, 0) }), i.popover({ html: !0, animation: !1, container: "#reminders", selector: "#reminders .create-reminder", placement: "top", template: _.template(s)({ name: "clients-pop" }), content: function() { return e(".popover").not(this).popover("hide"), e("#calendar-client-popover").clone().removeClass("hide").html() } }) }(jQuery);
