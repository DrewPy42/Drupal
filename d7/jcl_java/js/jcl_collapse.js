(function ($) {
	$(document).ready(function(){
		$("div.jcl-menu legend").unbind("mouseenter").bind("mouseenter", function(){
				$(this).css("cursor", "pointer");
				}).unbind("mouseleave").bind("mouseleave", function(){
					$(this).css("cursor", "auto");
					});

		$("div.jcl-menu legend").bind("click", function(){
			$(this).parent().find("div.jcl-menu-wrapper").slideToggle();
		});
	});
}) (jQuery);