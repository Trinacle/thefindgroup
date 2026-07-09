/* =========================================================================
   TFG — Main JavaScript (UI layer)
   Theme toggle · header · mobile nav · search · newsletter · form · live chat
   Animation/reveal/parallax/count-up handled separately by cinema.js.
   ========================================================================= */

(function () {
	"use strict";

	/* ----------------------------------------------------------------------
	   1. THEME TOGGLE (dark/light, persisted)
	   ---------------------------------------------------------------------- */
	var ThemeToggle = {
		init: function () {
			this.root = document.documentElement;
			this.buttons = document.querySelectorAll("[data-theme-toggle]");
			var self = this;
			this.buttons.forEach(function (btn) {
				btn.addEventListener("click", function () { self.toggle(); });
			});
		},
		current: function () {
			return this.root.getAttribute("data-theme") || "dark";
		},
		toggle: function () {
			var next = this.current() === "dark" ? "light" : "dark";
			this.root.setAttribute("data-theme", next);
			try { localStorage.setItem("tfg-theme", next); } catch (e) {}
			document.cookie = "tfg-theme=" + next + ";path=/;max-age=31536000;SameSite=Lax";
			var self = this;
			this.buttons.forEach(function (b) {
				b.setAttribute("aria-pressed", String(next === "light"));
			});
		},
	};

	/* ----------------------------------------------------------------------
	   2. HEADER (solid — no scroll state needed, kept minimal)
	   ---------------------------------------------------------------------- */
	var Header = {
		init: function () {
			// Header is solid obsidian; no scroll-state class toggling needed.
		},
	};

	/* ----------------------------------------------------------------------
	   3. MOBILE MENU
	   ---------------------------------------------------------------------- */
	var MobileMenu = {
		init: function () {
			this.burger = document.querySelector(".tfg-burger");
			this.menu = document.querySelector(".tfg-mobile-menu");
			if (!this.burger || !this.menu) return;
			var self = this;

			this.burger.addEventListener("click", function () { self.toggle(); });

			this.menu.querySelectorAll(".tfg-mobile-menu__toggle").forEach(function (t) {
				t.addEventListener("click", function (e) {
					e.preventDefault();
					t.closest(".tfg-mobile-menu__item").classList.toggle("is-open");
				});
			});

			this.menu.querySelectorAll("a").forEach(function (a) {
				if (!a.classList.contains("tfg-mobile-menu__toggle")) {
					a.addEventListener("click", function () { self.close(); });
				}
			});
		},
		toggle: function () {
			var open = this.menu.classList.toggle("is-open");
			this.burger.classList.toggle("is-open", open);
			document.body.classList.toggle("tfg-lock", open);
			this.burger.setAttribute("aria-expanded", String(open));
		},
		close: function () {
			this.menu.classList.remove("is-open");
			this.burger.classList.remove("is-open");
			document.body.classList.remove("tfg-lock");
			this.burger.setAttribute("aria-expanded", "false");
		},
	};

	/* ----------------------------------------------------------------------
	   4. SEARCH OVERLAY
	   ---------------------------------------------------------------------- */
	var Search = {
		init: function () {
			this.btn = document.querySelector(".tfg-search-btn");
			this.overlay = document.querySelector(".tfg-search-overlay");
			if (!this.btn || !this.overlay) return;
			this.input = this.overlay.querySelector("input");
			this.closeBtn = this.overlay.querySelector(".tfg-search-overlay__close");
			var self = this;

			this.btn.addEventListener("click", function () { self.open(); });
			if (this.closeBtn) {
				this.closeBtn.addEventListener("click", function () { self.closeOverlay(); });
			}
			document.addEventListener("keydown", function (e) {
				if (e.key === "Escape") self.closeOverlay();
			});
		},
		open: function () {
			this.overlay.classList.add("is-open");
			document.body.classList.add("tfg-lock");
			var input = this.input;
			setTimeout(function () { if (input) input.focus(); }, 100);
		},
		closeOverlay: function () {
			this.overlay.classList.remove("is-open");
			document.body.classList.remove("tfg-lock");
		},
	};

	/* ----------------------------------------------------------------------
	   5. NEWSLETTER (AJAX)
	   ---------------------------------------------------------------------- */
	var Newsletter = {
		init: function () {
			document.querySelectorAll("[data-newsletter]").forEach(function (form) {
				form.addEventListener("submit", function (e) {
					e.preventDefault();
					var input = form.querySelector("input[type=email]");
					var msg = form.parentElement.querySelector(".tfg-newsletter__msg");
					var data = new FormData();
					data.append("action", "tfg_newsletter");
					data.append("nonce", (window.TFG && window.TFG.nonce) || "");
					data.append("email", input.value);

					fetch((window.TFG && window.TFG.ajaxUrl) || "/wp-admin/admin-ajax.php", {
						method: "POST",
						body: data,
					})
						.then(function (r) { return r.json(); })
						.then(function (res) {
							if (msg) {
								msg.textContent = (res.data && res.data.message) ? res.data.message : "";
								msg.style.display = "block";
							}
							if (res.success) input.value = "";
						})
						.catch(function () {
							if (msg) msg.textContent = "Something went wrong. Please try again.";
						});
				});
			});
		},
	};

	/* ----------------------------------------------------------------------
	   6. FORM — char counter + URL param prefill
	   ---------------------------------------------------------------------- */
	var Form = {
		init: function () {
			document.querySelectorAll("textarea[data-counter]").forEach(function (ta) {
				var max = ta.getAttribute("maxlength") || 180;
				var counter = ta.parentElement.querySelector(".tfg-counter .cur");
				function update() {
					if (counter) counter.textContent = String(ta.value.length);
				}
				ta.addEventListener("input", update);
				update();
			});

			var params = new URLSearchParams(window.location.search);
			var interest = params.get("interest");
			if (interest) {
				var sel = document.querySelector("select[name='interest']");
				if (sel) {
					var opts = Array.from(sel.options);
					var match = opts.find(function (o) {
						return o.value === interest || o.textContent.toLowerCase().indexOf(interest.toLowerCase()) !== -1;
					});
					if (match) sel.value = match.value;
				}
			}

			if (document.querySelector(".forminator-success") || window.location.search.indexOf("submitted=1") !== -1) {
				setTimeout(function () {
					var form = document.querySelector(".tfg-form, .forminator-custom-form");
					if (form) form.scrollIntoView({ behavior: "smooth", block: "center" });
				}, 200);
			}
		},
	};

	/* ----------------------------------------------------------------------
	   7. LIVE CHAT FAB (fallback)
	   ---------------------------------------------------------------------- */
	var LiveChat = {
		init: function () {
			if (window.TFG && window.TFG.liveChat && window.TFG.liveChat.trim().length > 0) return;
			var fab = document.querySelector(".tfg-chat-fab");
			if (!fab) return;
			fab.addEventListener("click", function () {
				window.location.href = "/contact/";
			});
		},
	};

	/* ----------------------------------------------------------------------
	   8. TOAST helper (global)
	   ---------------------------------------------------------------------- */
	window.TFGToast = function (message, duration) {
		duration = duration || 3000;
		var toast = document.querySelector(".tfg-toast");
		if (!toast) {
			toast = document.createElement("div");
			toast.className = "tfg-toast";
			document.body.appendChild(toast);
		}
		toast.textContent = message;
		toast.classList.add("is-show");
		clearTimeout(toast._t);
		toast._t = setTimeout(function () { toast.classList.remove("is-show"); }, duration);
	};

	/* ----------------------------------------------------------------------
	   INIT
	   ---------------------------------------------------------------------- */
	document.addEventListener("DOMContentLoaded", function () {
		ThemeToggle.init();
		Header.init();
		MobileMenu.init();
		Search.init();
		Newsletter.init();
		Form.init();
		LiveChat.init();
	});
})();
