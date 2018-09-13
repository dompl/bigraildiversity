// ==== FOOTER ==== //
(function ($) {
	$(function () {
		function initPlugins() {

			//=require includes/navigation.js
			//=require includes/cookie-bar.js
			//=require includes/blazy.js

		}

		/* Initaite plugins */
		initPlugins();

		// Initiate plugins for pJax
		if (typeof is_ks_pjax !== 'undefined') {

			$(document).pjax('#container a', '#container', {
				fragment: '#container',
				timeout: 1500,
			});

			$(document).on('pjax:complete', function () {

				initPlugins();

			});
		}
	});
}(jQuery));
