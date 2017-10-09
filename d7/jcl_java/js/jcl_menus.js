(function ($) {

	function closeMenu() {
		$("body").find('input[id^=contentmenu]').each(function() {
			$(this).attr('checked', false);
			$(this).parent().removeClass("open");
		});
	}

	$(document).click(function(e) {
		var target = $(e.target);
		var parent = target.parent();

		if (target.is('span.icon-text') && parent.parent().hasClass("open")) {
			// do nothing
		} else {
			if (!target.is('input')) {
				if (!parent.hasClass("open")) {
					closeMenu();
				}
			} else {
				if (target.is('input') && !parent.hasClass("open")) {
					parent.addClass("open");
				}
			}
		}
	});

	$('div.megamenu').click(function(e) {
		e.stopPropagation();
	});

	$("#bibliobar").click(function() {
		closeMenu();
		$('a.log_out_btn').attr('href', 'https://jocolibrary.bibliocommons.com/user/logout');
	});


}) (jQuery);