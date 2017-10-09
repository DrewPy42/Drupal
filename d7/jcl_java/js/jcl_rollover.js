(function ($) {
 
	$(document).ready(function() {
 		// rollover swap of images using the opacity trick
		var img_src = "";
		var new_src = "";
		var original = "";
	
		$(".alternate > a picture img").css("display", "none");
		//preload images and add them as backgrounds to the original div
		$(".user-img").each(function(){
			var original = $(this).children(".rollover").children(".original");
			new_src = $(this).children(".alternate").children("a").children("picture").children("img").attr('srcset');
			var n = new_src.indexOf(" ");
			if (n > 0) {
				new_src = new_src.substring(0, n);
			}
			
			
			// var browser = navigator.userAgent.toLowerCase();
			// console.log(browser);
			var firefox = /firefox/.test(navigator.userAgent.toLowerCase());
			//console.log(firefox);
			if (!firefox) {
				var staff_img = $(this).children(".alternate").children("a").children("picture").children("img");
				$(original).css({'background-image': "url('" + new_src + "')", "background-size" : "contain"}).height(staff_img.height()).width(staff_img.width());
			} else {
				// $(this).on('ready', function(){
				$(original).css({'background-image': "url('" + new_src + "')", "background-size" : "contain"});
				// });
				$(this).delay(6000).queue(function() {
				//$(original).on('ready', function() {
					var staff_img = $(this).children(".alternate").children("a").children("picture").children("img");
					$(original).height(staff_img.height()).width(staff_img.width());
				});
			}
		});

		$(".rollover .original > a picture img").hover(function(){
			//mouseover
			$(this).css('opacity', '0.0');      
		},
		function(){
			//mouse out
			$(this).css('opacity', '1.0');
		});
	});
})(jQuery);