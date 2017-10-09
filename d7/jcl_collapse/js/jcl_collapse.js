(function ($) {
	$(document).ready(function(){
		$("div.legend").unbind("mouseenter").bind("mouseenter", function(){
				$(this).css("cursor", "pointer");
				}).unbind("mouseleave").bind("mouseleave", function(){
					$(this).css("cursor", "auto");
					});

		$("div.legend").bind("click", function(){
			url = window.location.pathname;
			ga('send', 'event', 'Menu', 'Click', 'Drop Down', url);
			$(this).parent().find("div.jcl-menu-wrapper").slideToggle();
		});
	});
}) (jQuery);