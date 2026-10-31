/**
 * Events Insider front-end: mobile menu, hero slider, newsletter popup.
 */
(function () {
	'use strict';

	var settings = window.eiSettings || {};

	function store(key, value) {
		try {
			if (value === undefined) {
				return window.localStorage.getItem(key);
			}
			window.localStorage.setItem(key, value);
		} catch (e) {
			return null;
		}
	}

	// Mobile menu --------------------------------------------------------
	var toggle = document.querySelector('.nav-toggle');
	var mobileNav = document.getElementById('mobile-nav');

	function setMenu(open) {
		if (!mobileNav) {
			return;
		}
		mobileNav.hidden = !open;
		document.body.classList.toggle('nav-open', open);
		if (toggle) {
			toggle.setAttribute('aria-expanded', String(open));
		}
		(open ? mobileNav.querySelector('.nav-close') : toggle).focus();
	}

	if (toggle && mobileNav) {
		toggle.addEventListener('click', function () {
			setMenu(true);
		});
		mobileNav.querySelector('.nav-close').addEventListener('click', function () {
			setMenu(false);
		});
		mobileNav.addEventListener('click', function (e) {
			if (e.target.closest('a')) {
				setMenu(false);
			}
		});
		window.matchMedia('(min-width: 961px)').addEventListener('change', function (mq) {
			if (mq.matches && !mobileNav.hidden) {
				setMenu(false);
			}
		});
	}

	// Hero slider --------------------------------------------------------
	var hero = document.querySelector('.hero');
	if (hero) {
		var slides = hero.querySelectorAll('.hero__slide');
		var dots = hero.querySelectorAll('.hero__dot');
		var current = 0;
		var timer = null;
		var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

		var show = function (index) {
			current = (index + slides.length) % slides.length;
			slides.forEach(function (slide, i) {
				var active = i === current;
				slide.classList.toggle('is-active', active);
				slide.setAttribute('aria-hidden', String(!active));
			});
			dots.forEach(function (dot, i) {
				dot.classList.toggle('is-active', i === current);
				dot.setAttribute('aria-current', i === current ? 'true' : 'false');
			});
		};
		var start = function () {
			if (slides.length > 1 && !reduceMotion) {
				clearInterval(timer);
				timer = setInterval(function () {
					show(current + 1);
				}, 6000);
			}
		};

		dots.forEach(function (dot, i) {
			dot.addEventListener('click', function () {
				show(i);
				start();
			});
		});
		hero.addEventListener('mouseenter', function () {
			clearInterval(timer);
		});
		hero.addEventListener('mouseleave', start);
		hero.addEventListener('focusin', function () {
			clearInterval(timer);
		});

		// Swipe on touch screens.
		var touchX = null;
		hero.addEventListener('touchstart', function (e) {
			touchX = e.touches[0].clientX;
		}, { passive: true });
		hero.addEventListener('touchend', function (e) {
			if (touchX === null) {
				return;
			}
			var dx = e.changedTouches[0].clientX - touchX;
			if (Math.abs(dx) > 40) {
				show(current + (dx < 0 ? 1 : -1));
				start();
			}
			touchX = null;
		});

		start();
	}

	// Newsletter popup ---------------------------------------------------
	var popup = document.getElementById('nl-popup');
	var POPUP_KEY = 'ei_popup_dismissed';
	var lastFocus = null;

	function closePopup() {
		if (!popup || popup.hidden) {
			return;
		}
		popup.hidden = true;
		document.body.classList.remove('nav-open');
		store(POPUP_KEY, String(Date.now()));
		if (lastFocus) {
			lastFocus.focus();
		}
	}

	function openPopup() {
		if (!popup || !popup.hidden || (mobileNav && !mobileNav.hidden)) {
			return;
		}
		lastFocus = document.activeElement;
		popup.hidden = false;
		document.body.classList.add('nav-open');
		var input = popup.querySelector('input[type="email"]');
		if (input) {
			input.focus({ preventScroll: true });
		}
	}

	if (popup && settings.popupEnabled) {
		var dismissed = parseInt(store(POPUP_KEY) || '0', 10);
		var days = settings.popupDays || 14;
		if (!dismissed || Date.now() - dismissed > days * 864e5) {
			setTimeout(openPopup, (settings.popupDelay || 12) * 1000);
		}
		popup.querySelectorAll('[data-popup-close]').forEach(function (el) {
			el.addEventListener('click', closePopup);
		});
		popup.querySelector('form').addEventListener('submit', function () {
			// Mailchimp opens in a new tab; hide the popup for good on this device.
			setTimeout(closePopup, 100);
		});
	}

	document.addEventListener('keydown', function (e) {
		if (e.key !== 'Escape') {
			return;
		}
		if (popup && !popup.hidden) {
			closePopup();
		} else if (mobileNav && !mobileNav.hidden) {
			setMenu(false);
		}
	});

	// Keep keyboard focus inside the open dialog.
	document.addEventListener('focusin', function (e) {
		var open = popup && !popup.hidden ? popup : mobileNav && !mobileNav.hidden ? mobileNav : null;
		if (open && !open.contains(e.target)) {
			var first = open.querySelector('button, a, input');
			if (first) {
				first.focus();
			}
		}
	});
})();
