/* =========================================================================
   TFG — Main JavaScript
   Theme toggle · mega-menu · mobile nav · search · Lenis smooth scroll ·
   GSAP scroll animations · custom cursor · magnetic hover · live chat FAB
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
			this.onScroll = this.onScroll.bind(this);
			window.addEventListener("scroll", this.onScroll, { passive: true });
			this.onScroll();
		},
		onScroll() {
			if (window.scrollY > 24) this.el.classList.add("is-scrolled");
			else this.el.classList.remove("is-scrolled");
		},
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
	   5. SMOOTH SCROLL (Lenis)
	   ---------------------------------------------------------------------- */
	const SmoothScroll = {
		init() {
			if (reduceMotion || typeof Lenis === "undefined") return;
			this.lenis = new Lenis({
				duration: 1.1,
				easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
				smoothWheel: true,
				smoothTouch: false,
			});
			const raf = (time) => {
				this.lenis.raf(time);
				requestAnimationFrame(raf);
			};
			requestAnimationFrame(raf);

			// GSAP ScrollTrigger integration
			if (typeof gsap !== "undefined" && typeof ScrollTrigger !== "undefined") {
				this.lenis.on("scroll", ScrollTrigger.update);
				gsap.ticker.add((time) => this.lenis.raf(time * 1000));
				gsap.ticker.lagSmoothing(0);
			}

			// Anchor links
			document.querySelectorAll('a[href^="#"]').forEach((a) => {
				a.addEventListener("click", (e) => {
					const id = a.getAttribute("href");
					if (id.length > 1) {
						const target = document.querySelector(id);
						if (target) {
							e.preventDefault();
							this.lenis.scrollTo(target, { offset: -88 });
						}
					}
				});
			});
		},
	};

	/* ----------------------------------------------------------------------
	   6. SCROLL ANIMATIONS (GSAP)
	   ---------------------------------------------------------------------- */
	const Animations = {
		init() {
			if (reduceMotion || typeof gsap === "undefined") return;
			if (typeof ScrollTrigger !== "undefined") gsap.registerPlugin(ScrollTrigger);

			// Generic reveal
			document.querySelectorAll("[data-reveal]").forEach((el) => {
				gsap.to(el, {
					opacity: 1,
					y: 0,
					duration: 0.9,
					ease: "power3.out",
					scrollTrigger: { trigger: el, start: "top 88%" },
				});
			});

			// Staggered groups
			document.querySelectorAll("[data-reveal-stagger]").forEach((group) => {
				const items = group.children;
				gsap.to(items, {
					opacity: 1,
					y: 0,
					duration: 0.8,
					ease: "power3.out",
					stagger: 0.1,
					scrollTrigger: { trigger: group, start: "top 85%" },
				});
			});

			// Image clip-path reveal
			document.querySelectorAll("[data-reveal-img]").forEach((el) => {
				gsap.to(el, {
					clipPath: "inset(0% 0 0 0)",
					duration: 1.2,
					ease: "power4.out",
					scrollTrigger: { trigger: el, start: "top 90%" },
				});
			});

			// Hero entrance (immediate)
			const hero = document.querySelector(".tfg-hero");
			if (hero) {
				const els = hero.querySelectorAll("[data-hero-anim]");
				if (els.length) {
					gsap.from(els, {
						opacity: 0,
						y: 30,
						duration: 1.1,
						ease: "power3.out",
						stagger: 0.15,
						delay: 0.2,
					});
				}
			}

			// Headline line-split reveal (lightweight, no SplitText dependency)
			document.querySelectorAll("[data-split-lines]").forEach((el) => {
				this.splitLines(el).forEach((line, i) => {
					gsap.from(line, {
						opacity: 0,
						y: 24,
						duration: 0.9,
						ease: "power3.out",
						delay: i * 0.1,
						scrollTrigger: { trigger: el, start: "top 85%" },
					});
				});
			});
		},

		// Naive line-wrap splitter: wraps each line by measuring word positions.
		splitLines(el) {
			const text = el.textContent;
			const words = text.split(/\s+/);
			el.innerHTML = "";
			const wordEls = words.map((w) => {
				const span = document.createElement("span");
				span.style.display = "inline-block";
				span.textContent = w + " ";
				el.appendChild(span);
				return span;
			});
			const lines = [];
			let currentLine = [];
			let lastTop = null;
			wordEls.forEach((w) => {
				const top = w.getBoundingClientRect().top;
				if (lastTop === null || Math.abs(top - lastTop) < 2) {
					currentLine.push(w);
				} else {
					lines.push(currentLine);
					currentLine = [w];
				}
				lastTop = top;
			});
			if (currentLine.length) lines.push(currentLine);
			// Wrap each line's words in a container span for animation.
			const lineEls = lines.map((line) => {
				const wrap = document.createElement("span");
				wrap.style.display = "block";
				wrap.style.overflow = "hidden";
				line.forEach((w) => {
					w.style.display = "inline-block";
					wrap.appendChild(w);
				});
				el.appendChild(wrap);
				return wrap;
			});
			return lineEls;
		},
	};

	/* ----------------------------------------------------------------------
	   7. CUSTOM CURSOR (desktop only)
	   ---------------------------------------------------------------------- */
	const Cursor = {
		init() {
			if (isTouch || reduceMotion) return;
			this.dot = document.querySelector(".tfg-cursor");
			this.ring = document.querySelector(".tfg-cursor-ring");
			if (!this.dot || !this.ring) return;
			this.mouse = { x: 0, y: 0 };
			this.ringPos = { x: 0, y: 0 };

			window.addEventListener("mousemove", (e) => {
				this.mouse.x = e.clientX;
				this.mouse.y = e.clientY;
				this.dot.style.transform = `translate(${e.clientX}px, ${e.clientY}px) translate(-50%, -50%)`;
			});

			const lerp = (a, b, n) => (1 - n) * a + n * b;
			const render = () => {
				this.ringPos.x = lerp(this.ringPos.x, this.mouse.x, 0.18);
				this.ringPos.y = lerp(this.ringPos.y, this.mouse.y, 0.18);
				this.ring.style.transform = `translate(${this.ringPos.x}px, ${this.ringPos.y}px) translate(-50%, -50%)`;
				requestAnimationFrame(render);
			};
			render();

			// Hover state on interactive elements
			document.querySelectorAll("a, button, [data-magnetic], input, textarea, select").forEach((el) => {
				el.addEventListener("mouseenter", () => {
					this.dot.classList.add("is-hover");
					this.ring.classList.add("is-hover");
				});
				el.addEventListener("mouseleave", () => {
					this.dot.classList.remove("is-hover");
					this.ring.classList.remove("is-hover");
				});
			});
		},
	};

	/* ----------------------------------------------------------------------
	   8. MAGNETIC HOVER (desktop only)
	   ---------------------------------------------------------------------- */
	const Magnetic = {
		init() {
			if (isTouch || reduceMotion) return;
			document.querySelectorAll("[data-magnetic]").forEach((el) => {
				el.addEventListener("mousemove", (e) => {
					const rect = el.getBoundingClientRect();
					const x = e.clientX - rect.left - rect.width / 2;
					const y = e.clientY - rect.top - rect.height / 2;
					el.style.transform = `translate(${x * 0.12}px, ${y * 0.12}px)`;
				});
				el.addEventListener("mouseleave", () => {
					el.style.transform = "";
				});
			});
		},
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
