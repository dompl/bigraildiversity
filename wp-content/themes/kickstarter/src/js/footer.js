// ==== FOOTER ==== //
(function ($) {
	$(function () {
		function initPlugins() {
			//=require includes/navigation.js
			//=require includes/cookie-bar.js
			//=require includes/blazy.js
			//=require includes/modaal.js
			//=require includes/faqs.js
			//=require includes/challenges.js
		}
		$(".yt-pop").modaal({
			custom_class: "yt-pop",
			width: 600,
			before_open: onPlayerReady($(this)),
		});
		function onPlayerReady(yt) {
			if ($(".yt-pop")[0]) {
				var iframe = yt.find("iframe");
				iframe[0].src += "&autoplay=1";
			}
		}
		function new_winners_score() {
			$(".more-button .button").on("click", function () {
				$(this).parent("li").hide();
				$("li.hidden").removeClass("hidden");
			});
		}

		/* Initaite plugins */
		initPlugins();
		new_winners_score();

		// Initiate plugins for pJax
		if (typeof is_ks_pjax !== "undefined") {
			$(document).pjax("#container a", "#container", {
				fragment: "#container",
				timeout: 1500,
			});

			$(document).on("pjax:complete", function () {
				initPlugins();
				new_winners_score();
			});
		}
	});
})(jQuery);
