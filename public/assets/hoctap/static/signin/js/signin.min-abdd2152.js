! function(n) {
    function o() { n("html").hasClass("ie") && n(".form-control").each(function(o, t) { var t = n(t);
            t.is("[placeholder]") && (t.wrap('<div class="fake-ie-placeholder"></div>'), t.parent().prepend('<span class="fake-ie-placeholder-text">' + t.prop("placeholder") + "</span>"), t.removeAttr("placeholder"), t.on("keyup", function(n) { this.setAttribute("value", this.value) })) }) }

    function t() { "/signin" == window.location.pathname && v.trigger("ga.event", { action: "signin-impression", label: "lumberjack" }) }

    function i() { "/signin" != window.location.pathname && "/signin/organization" != window.location.pathname || v.trigger("ga.event", { action: "signin-cta", label: "lumberjack" }) }

    function e() { n("#signin-page form").off("focusout.bs.validator") }

    function a() { var o = n(".has-error").filter(':not([type="hidden"])').first();
        o.prop("disabled", !1).focus().filter("has-error").tooltip("show") }

    function r(n, o) { n.addClass("has-error").data("tooltip", !1).tooltip({ trigger: "focus", container: n.closest(".panel"), viewport: n.parent(), html: !0 }).attr("title", o).tooltip("fixTitle") }

    function s(n) { n.removeClass("has-error").tooltip("destroy") }

    function l() { n(".has-error").removeClass("has-error"), n(".tooltip").tooltip("destroy") }

    function c(n) { d("Form", n) }

    function p() { d("Done", "") }

    function d(o, t) { var i = n("#forgot-pwd"),
            e = n("#password-input"),
            a = "Help" == t ? i : e,
            r = i.data("maskedEm"),
            s = i.data("popover" + o + "Button");
        button = "Form" === o ? '<button id="resetpwd-btn" class="btn btn-md btn-dark-standard"><span>' + s + '</span><i class="loading"></i></button>' : '<a href="/signin/resetpwd" data-wizardli id="resetpwd-tryagain">' + s + "</a>", content = "<h4>" + i.data("popover" + o + "Title") + "</h4><p>" + i.data("popover" + o + "Content" + t).replace("{0}", r ? r : "the email address for this account") + "</p>" + button, i.data("bs.popover") && i.popover("destroy"), e.data("bs.popover") && e.popover("destroy"), a.popover({ animation: !1, container: a.closest(".row"), content: content, html: !0, placement: n(window).width() < 768 ? "bottom" : "right", title: "", trigger: "manual", viewport: "#signin-page" }), a.popover("show"), x = { anchor: a, why: t, step: o } }

    function u() { var o;
        x && x.anchor && (o = x.anchor.data("bs.popover").tip()) && n(o).is(":visible") && d(x.step, x.why) }

    function f(o) { var t = n("#password-input").data("bs.popover");
        t && (o ? t.tip().addClass("processing") : t.tip().removeClass("processing")) }

    function g() { n("#signin-page .popover").each(function() { var o = n(this).data("bs.popover");
            o && o.tip().remove() }), x = null }

    function h(n) { n && v.trigger("ga.event", { action: "signin-redirect", label: n }) } var m, w, v = n("body"),
        b = "signin-tooltip",
        k = 2,
        y = "",
        C = n.cookie(b);
    y = void 0 == C ? 0 : Number(C), y >= k ? n(".social-login-help").hide() : (n(".social-login-help").show(), n.cookie(b, y + 1, { raw: !0, path: "/", expires: 60 })), v.on("change", "#remember-me", function() { v.trigger("ga.event", { action: "click", label: n(this).is(":checked") ? "rememberme-check" : "rememberme-uncheck" }) }).on("input change focusout focusin", '#signin-page form input:not([type="submit"], button):enabled:visible', function(o) { var t = n("#signin-page form"); if (!t.data("bs.validator")) { if (n("html").hasClass("ie") && !m) return void(m = !0);
            m = !1, t.validator(), e() } }).on("focusin", "input:text, input:password", function(o) { if (this.setSelectionRange) { var t = 2 * n(this).val().length;
            this.setSelectionRange(t, t) } }).on("submit", "[data-form-name]", function(o) { v.trigger("ga.event", { action: "submit", label: n(this).data("formName") + "-submit" }) }).on("invalid.bs.validator", "#signin-page form", function(o) {!o.detail || o.detail && !o.detail.length || (o.preventDefault(), r(n(o.relatedTarget), o.detail[0]), a()) }).on("click", '#signin-page form [type="submit"]', function(n) { a() }).on("valid.bs.validator", "#signin-page form", function(o) { s(n(o.relatedTarget)) }).on("wizardli.submit", function(o, t, i) { l(), "/signin" === window.location.pathname && v.trigger("wizardli.state.replace", [window.location.pathname, null, n("#signin-page form").serialize(), n("html title").text()]), t.addClass("processing").children().prop("disabled", !0), i.done(function(n) { n && n.RedirectUrl && (w = !0, "/signin/password" === window.location.pathname && h("ldc-signin"), window.location = n.RedirectUrl) }).fail(function(o) { o = JSON.parse(o.responseText), o && (n.each(o, function(n, o) { var i = t.find('[name="' + n + '"]');
                r(i, o), "password" === n && c("Fail"), "email" !== n && "password" !== n && "org" !== n || v.trigger("ga.event", { action: "error", label: n + "-error" }) }), a()) }).always(function() { w || t.removeClass("processing").children().prop("disabled", !1) }) }).on("wizardli.section.update", function(n, i) { l(), g(), t(), o() }).on("click", ".password-toggle", function(o) { var t = n(this);
        t.toggleClass("on"); var i = t.hasClass("on");
        t.attr("aria-pressed", (!i).toString()), n("#password-input").attr("type", i ? "text" : "password") }).on("click", "#forgot-pwd", function(n) { n.preventDefault(), c("Help") }).on("click", "#resetpwd-btn", function(o) { f(!0), n.post("/ajax/signin/resetpwdsend", { un: n('input[name="email"]').val() }).done(function(n) { f(!1), p() }).error(function(o) { f(!1), r(n("resetpwd-btn"), n("#forgot-pwd").data("popoverError" + o.type)) }) }).on("click", "#resetpwd-tryagain", function(n) { f(!0) }).on("click", "#linkedin_button", function(o) { o.preventDefault(), l(); var t = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ":" + window.location.port : ""),
            i = window.open(t + n(this).attr("href"), "linkedinOauth", "width=400,height=650");
        i.opener = window, i.focus() }).on("click", "#linkedin_button", function(n) { i() }).on("submit", "#signin-page form", function(n) { i() }).on("click", "#close-tooltip", function(o) { n(".social-login-help").hide(), n.cookie(b, k + 1, { raw: !0, path: "/", expires: 60 }) }), n(window).resize(function() { l(), u() }), o(), n("[autofocus]:not(:focus)").eq(0).focus(), t(); var x = null;! function(n) {
        function o(o) { i(!1); var t = n("#form-social-login");
            t.find('[name="socid"]').val(o), t.submit() }

        function t() { i(!1); var o = n("#linkedin_button");
            r(o, o.data("error")) }

        function i(o) { var t = n("form[data-form-name='signin']");
            o ? t.addClass("processing") : t.removeClass("processing") } window.linkedIn = { loginSuccess: function(e) { e && e.memberId ? "True" === e.hasLyndaAccount || "True" === e.hasLyndaEntitlement ? (i(!0), n.post("/ajax/user/signin/li", { redirectTo: "" }).done(function(n) { if (n && n.HasErrors === !1) { if (n.UserID) { var i = n.RedirectUrl; return i && i.length || (i = "/"), h("li-signin"), window.location = i } o(e.memberId) } else t() })) : o(e.memberId) : t() } } }(n) }(jQuery);
