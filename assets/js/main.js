/* =========================================================================
   TFG — Main JavaScript
   Theme toggle · mega-menu · mobile nav · search · live chat FAB
   (Smooth scroll + custom cursor + magnetic hover REMOVED by request —
    they were causing scroll friction and felt janky.)
   ========================================================================= */

(function () {
	"use strict";

	const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
	const isTouch = window.matchMedia("(hover: none), (pointer: coarse)").matches;

	/* ----------------------------------------------------------------------
	   1. THEME TOGGLE (dark/light, persisted)
	   ---------------------------------------------------------------------- */
	const ThemeToggle = {
		init() {
			this.root = document.documentElement;
			this.buttons = document.querySelectorAll("[data-theme-toggle]");
			this.buttons.forEach((btn) => btn.addEventListener("click", () => this.toggle()));
		},
		current() {
			return this.root.getAttribute("data-theme") || "dark";
		},
		toggle() {
			const next = this.current() === "dark" ? "light" : "dark";
			this.root.setAttribute("data-theme", next);
			try { localStorage.setItem("tfg-theme", next); } catch (e) {}
			document.cookie = "tfg-theme=" + next + ";path=/;max-age=31536000;SameSite=Lax";
			this.buttons.forEach((b) => b.setAttribute("aria-pressed", next === "light"));
		},
	};

	/* ----------------------------------------------------------------------
	   2. HEADER scroll state
	   ---------------------------------------------------------------------- */
	const Header = {
		init() {
			this.el = document.querySelector(".tfg-header");
			if (!this.el) return;
			// Header is now solid (not an overlay) — no scroll-state class needed.
			// Left as a no-op for backwards compatibility.
		};

	/* ----------------------------------------------------------------------
	   3. MOBILE MENU
	   ---------------------------------------------------------------------- */
	const MobileMenu = {
		init() {
			this.burger = document.querySelector(".tfg-burger");
			this.menu = document.querySelector(".tfg-mobile-menu");
			if (!this.burger || !this.menu) return;
			this.burger.addEventListener("click", () => this.toggle());
			this.menu.querySelectorAll(".tfg-mobile-menu__toggle").forEach((t) => {
				t.addEventListener("click", (e) => {
					e.preventDefault();
					t.closest(".tfg-mobile-menu__item").classList.toggle("is-open");
				});
			});
			this.menu.querySelectorAll("a").forEach((a) => {
				if (!a.classList.contains("tfg-mobile-menu__toggle")) {
					a.addEventListener("click", () => this.close());
				}
			});
		},
		toggle() {
			const open = this.menu.classList.toggle("is-open");
			this.burger.classList.toggle("is-open", open);
			document.body.classList.toggle("tfg-lock", open);
			this.burger.setAttribute("aria-expanded", open);
		},
		close() {
			this.menu.classList.remove("is-open");
			this.burger.classList.remove("is-open");
			document.body.classList.remove("tfg-lock");
			this.burger.setAttribute("aria-expanded", "false");
		},
	};

	/* ----------------------------------------------------------------------
	   4. SEARCH OVERLAY
	   ---------------------------------------------------------------------- */
	const Search = {
		init() {
			this.btn = document.querySelector(".tfg-search-btn");
			this.overlay = document.querySelector(".tfg-search-overlay");
			if (!this.btn || !this.overlay) return;
			this.input = this.overlay.querySelector("input");
			this.close = this.overlay.querySelector(".tfg-search-overlay__close");
			this.btn.addEventListener("click", () => this.open());
			this.close && this.close.addEventListener("click", () => this.closeOverlay());
			document.addEventListener("keydown", (e) => {
				if (e.key === "Escape") this.closeOverlay();
			});
		},
		open() {
			this.overlay.classList.add("is-open");
			document.body.classList.add("tfg-lock");
			setTimeout(() => this.input && this.input.focus(), 100);
		},
		closeOverlay() {
			this.overlay.classList.remove("is-open");
			document.body.classList.remove("tfg-lock");
		},
	};

	/* ----------------------------------------------------------------------
	   5. SMOOTH SCROLL — REMOVED by request (caused scroll friction)
	   Native browser scrolling is used instead.
	   ---------------------------------------------------------------------- */
	const SmoothScroll = {
		init() { /* disabled */ },
	};

	/* ----------------------------------------------------------------------
	   6. REVEAL — show all elements immediately (scroll animations removed)
	   The CSS sets [data-reveal] to opacity:0; this flips them visible right
	   away so content is never stuck invisible.
	   ---------------------------------------------------------------------- */
	const Animations = {
		init() {
			document.querySelectorAll("[data-reveal], [data-reveal-stagger], [data-reveal-img], [data-hero-anim], [data-split-lines]").forEach((el) => {
				el.style.opacity = "1";
				el.style.transform = "none";
				el.style.clipPath = "none";
			});
		},
	};

	/* ----------------------------------------------------------------------
	   7. CUSTOM CURSOR — REMOVED by request (felt janky)
	   ---------------------------------------------------------------------- */
	const Cursor = {
		init() {
			// Hide any cursor elements from the DOM
			document.querySelectorAll(".tfg-cursor, .tfg-cursor-ring").forEach((el) => el.remove());
		},
	};

	/* ----------------------------------------------------------------------
	   8. MAGNETIC HOVER — REMOVED by request
	   ---------------------------------------------------------------------- */
	const Magnetic = {
		init() { /* disabled */ },
	};

	/* ----------------------------------------------------------------------
	   9. NEWSLETTER (AJAX)
	   ---------------------------------------------------------------------- */
	const Newsletter = {
		init() {
			document.querySelectorAll("[data-newsletter]").forEach((form) => {
				form.addEventListener("submit", (e) => {
					e.preventDefault();
					const input = form.querySelector("input[type=email]");
					const msg = form.parentElement.querySelector(".tfg-newsletter__msg");
					const data = new FormData();
					data.append("action", "tfg_newsletter");
					data.append("nonce", (window.TFG && window.TFG.nonce) || "");
					data.append("email", input.value);

					fetch((window.TFG && window.TFG.ajaxUrl) || "/wp-admin/admin-ajax.php", {
						method: "POST",
						body: data,
					})
						.then((r) => r.json())
						.then((res) => {
							if (msg) {
								msg.textContent = res.data && res.data.message ? res.data.message : "";
								msg.style.display = "block";
							}
							if (res.success) input.value = "";
						})
						.catch(() => {
							if (msg) msg.textContent = "Something went wrong. Please try again.";
						});
				});
			});
		},
	};

	/* ----------------------------------------------------------------------
	   10. FORM: message counter + URL param prefill
	   ---------------------------------------------------------------------- */
	const Form = {
		init() {
			// Character counter for fallback form
			document.querySelectorAll("textarea[data-counter]").forEach((ta) => {
				const max = ta.getAttribute("maxlength") || 180;
				const counter = ta.parentElement.querySelector(".tfg-counter .cur");
				const update = () => {
					if (counter) counter.textContent = String(ta.value.length);
				};
				ta.addEventListener("input", update);
				update();
			});

			// Prefill from URL params (?interest=..., ?broker=...)
			const params = new URLSearchParams(window.location.search);
			const interest = params.get("interest");
			const broker = params.get("broker");
			if (interest) {
				const sel = document.querySelector("select[name='interest']");
				if (sel) {
					const opt = Array.from(sel.options).find((o) => o.value === interest || o.textContent.toLowerCase().includes(interest.toLowerCase()));
					if (opt) sel.value = opt.value;
				}
			}

			// Forminator success scroll
			if (document.querySelector(".forminator-success") || window.location.search.includes("submitted=1")) {
				setTimeout(() => {
					const form = document.querySelector(".tfg-form, .forminator-custom-form");
					if (form) form.scrollIntoView({ behavior: "smooth", block: "center" });
				}, 200);
			}
		},
	};

	/* ----------------------------------------------------------------------
	   11. LIVE CHAT FAB (fallback if no provider snippet configured)
	   ---------------------------------------------------------------------- */
	const LiveChat = {
		init() {
			// If a real chat snippet is injected via Customizer, hide our FAB.
			if (window.TFG && window.TFG.liveChat && window.TFG.liveChat.trim().length > 0) return;
			const fab = document.querySelector(".tfg-chat-fab");
			if (!fab) return;
			fab.addEventListener("click", () => {
				// Open contact page as fallback, or trigger a mailto.
				window.location.href = "/contact/";
			});
		},
	};

	/* ----------------------------------------------------------------------
	   12. TOAST helper (exposed globally)
	   ---------------------------------------------------------------------- */
	window.TFGToast = function (message, duration = 3000) {
		let toast = document.querySelector(".tfg-toast");
		if (!toast) {
			toast = document.createElement("div");
			toast.className = "tfg-toast";
			document.body.appendChild(toast);
		}
		toast.textContent = message;
		toast.classList.add("is-show");
		clearTimeout(toast._t);
		toast._t = setTimeout(() => toast.classList.remove("is-show"), duration);
	};

	/* ----------------------------------------------------------------------
	   INIT
	   ---------------------------------------------------------------------- */
	document.addEventListener("DOMContentLoaded", () => {
		ThemeToggle.init();
		Header.init();
		MobileMenu.init();
		Search.init();
		SmoothScroll.init();
		Animations.init();
		Cursor.init();
		Magnetic.init();
		Newsletter.init();
		Form.init();
		LiveChat.init();
	});
})();
