/* =========================================================================
   TFG — Cinema Engine
   IntersectionObserver reveals · count-up · parallax · scroll progress ·
   scene dots. Lightweight vanilla JS. No GSAP, no Lenis.
   ========================================================================= */

(function () {
	"use strict";

	var reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

	/* ----------------------------------------------------------------------
	   1. REVEAL — IntersectionObserver adds .is-visible when 85% in view
	   ---------------------------------------------------------------------- */
	var Reveal = {
		init: function () {
			if (reduceMotion) {
				// Reduced motion: make everything visible immediately
				document.querySelectorAll(
					"[data-reveal], [data-reveal-stagger], [data-reveal-left], [data-reveal-right], [data-reveal-scale], [data-reveal-img]"
				).forEach(function (el) {
					el.classList.add("is-visible");
				});
				return;
			}

			if (!("IntersectionObserver" in window)) {
				// No IO support: show everything
				document.querySelectorAll(
					"[data-reveal], [data-reveal-stagger], [data-reveal-left], [data-reveal-right], [data-reveal-scale], [data-reveal-img]"
				).forEach(function (el) {
					el.classList.add("is-visible");
				});
				return;
			}

			var observer = new IntersectionObserver(
				function (entries, obs) {
					entries.forEach(function (entry) {
						if (entry.isIntersecting) {
							entry.target.classList.add("is-visible");
							obs.unobserve(entry.target); // reveal once
						}
					});
				},
				{
					threshold: 0.15,
					rootMargin: "0px 0px -10% 0px",
				}
			);

			var els = document.querySelectorAll(
				"[data-reveal], [data-reveal-stagger], [data-reveal-left], [data-reveal-right], [data-reveal-scale], [data-reveal-img]"
			);
			els.forEach(function (el) {
				observer.observe(el);
			});
		},
	};

	/* ----------------------------------------------------------------------
	   2. COUNT-UP — animates numbers from 0 to final value
	   ---------------------------------------------------------------------- */
	var CountUp = {
		init: function () {
			var nums = document.querySelectorAll("[data-countup]");
			if (!nums.length) return;

			if (reduceMotion || !("IntersectionObserver" in window)) {
				nums.forEach(function (el) {
					el.textContent = el.getAttribute("data-countup");
					el.classList.add("is-counted");
				});
				return;
			}

			var observer = new IntersectionObserver(
				function (entries, obs) {
					entries.forEach(function (entry) {
						if (entry.isIntersecting) {
							CountUp.animate(entry.target);
							obs.unobserve(entry.target);
						}
					});
				},
				{ threshold: 0.5 }
			);

			nums.forEach(function (el) {
				observer.observe(el);
			});
		},

		animate: function (el) {
			var raw = el.getAttribute("data-countup");
			var prefix = "";
			var suffix = "";
			var decimals = 0;

			// Extract prefix (e.g. "$", "€") and suffix (e.g. "+", "K", "%")
			var match = raw.match(/^([^\d.-]*)([\d.,]+)(.*)$/);
			if (match) {
				prefix = match[1];
				var numStr = match[2].replace(/,/g, "");
				suffix = match[3];
				decimals = (numStr.split(".")[1] || "").length;
				var target = parseFloat(numStr);

				var duration = 1600;
				var start = null;

				function step(timestamp) {
					if (!start) start = timestamp;
					var progress = Math.min((timestamp - start) / duration, 1);
					// easeOutExpo for a refined deceleration
					var eased = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
					var current = target * eased;
					var formatted;
					if (decimals > 0) {
						formatted = current.toFixed(decimals);
					} else {
						formatted = Math.round(current).toString();
						// Add thousands separators
						formatted = formatted.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
					}
					el.textContent = prefix + formatted + suffix;
					if (progress < 1) {
						requestAnimationFrame(step);
					} else {
						el.textContent = raw; // ensure exact final value
						el.classList.add("is-counted");
					}
				}
				requestAnimationFrame(step);
			} else {
				el.textContent = raw;
				el.classList.add("is-counted");
			}
		},
	};

	/* ----------------------------------------------------------------------
	   3. PARALLAX — subtle translateY on [data-parallax] elements
	   Uses scroll position, throttled via requestAnimationFrame.
	   ---------------------------------------------------------------------- */
	var Parallax = {
		init: function () {
			if (reduceMotion) return;
			var els = document.querySelectorAll("[data-parallax]");
			if (!els.length) return;
			if (!("IntersectionObserver" in window)) return;

			var active = [];
			var ticking = false;

			var observer = new IntersectionObserver(
				function (entries) {
					entries.forEach(function (entry) {
						if (entry.isIntersecting) {
							if (active.indexOf(entry.target) === -1) active.push(entry.target);
						} else {
							var idx = active.indexOf(entry.target);
							if (idx > -1) active.splice(idx, 1);
						}
					});
				},
				{ threshold: 0, rootMargin: "20% 0px 20% 0px" }
			);

			els.forEach(function (el) {
				observer.observe(el);
			});

			var speed = function (el) {
				return parseFloat(el.getAttribute("data-parallax")) || 0.15;
			};

			function update() {
				active.forEach(function (el) {
					var rect = el.getBoundingClientRect();
					var winH = window.innerHeight;
					// How far the element center is from viewport center (-1 to 1)
					var center = rect.top + rect.height / 2 - winH / 2;
					var offset = center / winH; // -0.5 to 0.5 typically
					var shift = -offset * 60 * speed(el); // max ~30px movement
					el.style.setProperty("--parallax", shift.toFixed(2) + "px");
				});
				ticking = false;
			}

			function onScroll() {
				if (!ticking) {
					requestAnimationFrame(update);
					ticking = true;
				}
			}

			window.addEventListener("scroll", onScroll, { passive: true });
			window.addEventListener("resize", onScroll, { passive: true });
			update();
		},
	};

	/* ----------------------------------------------------------------------
	   4. SCROLL PROGRESS — thin bar at top showing page scroll %
	   ---------------------------------------------------------------------- */
	var ScrollProgress = {
		init: function () {
			if (reduceMotion) return;
			var bar = document.querySelector(".tfg-scroll-progress");
			if (!bar) return;

			var ticking = false;
			function update() {
				var scrollTop = window.scrollY;
				var docHeight = document.documentElement.scrollHeight - window.innerHeight;
				var pct = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
				bar.style.width = pct + "%";
				ticking = false;
			}
			function onScroll() {
				if (!ticking) {
					requestAnimationFrame(update);
					ticking = true;
				}
			}
			window.addEventListener("scroll", onScroll, { passive: true });
			update();
		},
	};

	/* ----------------------------------------------------------------------
	   5. SCENE DOTS — right-side pips that track active scene
	   ---------------------------------------------------------------------- */
	var SceneDots = {
		init: function () {
			var dots = document.querySelectorAll(".tfg-scene-dot");
			if (!dots.length) return;

			var scenes = document.querySelectorAll("[data-scene]");
			if (!scenes.length || !("IntersectionObserver" in window)) {
				dots.forEach(function (d) { d.style.display = "none"; });
				return;
			}

			var observer = new IntersectionObserver(
				function (entries) {
					entries.forEach(function (entry) {
						if (entry.isIntersecting) {
							var id = entry.target.getAttribute("data-scene");
							dots.forEach(function (dot) {
								dot.classList.toggle(
									"is-active",
									dot.getAttribute("data-scene-target") === id
								);
							});
						}
					});
				},
				{ threshold: 0.5 }
			);

			scenes.forEach(function (s) {
				observer.observe(s);
			});

			// Click to scroll to scene
			dots.forEach(function (dot) {
				dot.addEventListener("click", function () {
					var target = document.querySelector(
						'[data-scene="' + dot.getAttribute("data-scene-target") + '"]'
					);
					if (target) {
						target.scrollIntoView({ behavior: reduceMotion ? "auto" : "smooth", block: "start" });
					}
				});
			});
		},
	};

	/* ----------------------------------------------------------------------
	   INIT
	   ---------------------------------------------------------------------- */
	document.addEventListener("DOMContentLoaded", function () {
		Reveal.init();
		CountUp.init();
		Parallax.init();
		ScrollProgress.init();
		SceneDots.init();
	});
})();
