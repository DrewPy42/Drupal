Drupal.jcl_alerts = Drupal.jcl_alerts || {};

(function ($) {
	Drupal.jcl_alerts.initialize = function(){

		if ($("#jcl-alerts-container").length > 0) {
			// Bind all required events.
			Drupal.jcl_alerts.bindEvents();
		}
	};

	Drupal.jcl_alerts.bindEvents = function(){
		// First try to unbind all previously bound events, to avoid multiple calls
		// after bindings are refreshed when adding new messages on ajaxComplete.

		// Dismiss single message.
		$("a.jcl-alerts-dismiss").unbind("mouseenter").bind("mouseenter", function(){
			$(this).css("cursor", "pointer");
			}).unbind("mouseleave").bind("mouseleave", function(){
				$(this).css("cursor", "auto");
				});

		$("a.jcl-alerts-dismiss").unbind("click").bind("click", function(){
			// send click event to google analytics
			// Unbind "click" event first to avoid accidental collapsing/expanding.
			$(this).parents(".jcl-alerts-message").unbind("click").hide(function(){
				// store the message's index value into a cookie
				var alertindex = Drupal.jcl_alerts.getID($(this));
				ga('send', 'event', 'Alert', 'Click', 'Hide', alertindex);
				Drupal.jcl_alerts.setCookie(alertindex);
			});
		});
	};


	Drupal.jcl_alerts.getID = function(element) {
		// gets the messages embedded node ID that we setup earlier
		var alertID = element.attr('class').split(' ').slice(-1);
		return alertID;
	}

	Drupal.jcl_alerts.getState = function(id) {
		//checks to see if a message index is stored locally and returns it's value
		messagestate = localStorage.getItem(id);
		if (messagestate == "FALSE" || messagestate == null) {
			return "FALSE";
		}
		return "TRUE";
	}

	Drupal.jcl_alerts.setCookie = function(alertindex) {
		var d = new Date();
		d.setDate(d.getDate() + 90);
		var expires = "expires="+d.toUTCString();
		document.cookie = alertindex + "=" + 'TRUE' + "; " + expires + "; path=/";
	}

	$(document).ready(function(){
		Drupal.jcl_alerts.initialize();
	});

})(jQuery);
