<?php

function _jcl_ical($arg) {
	$args = explode("-", $arg);
	//load the node and make sure it is an event
	$node = node_load($args[0]);
	if ($node) {
		if ($node->type = "event") {
			if (count($args) == 3) {
				switch ($args[2]) {
					case "apple":
					case "outlook":
						_jcl_ical_file($node, $args[1]);
						break;
					default:
						// used for yahoo, google, and outlook.com
						drupal_goto(_jcl_ical_url($node, $args));
						break;
				}
			} else {
				drupal_goto("404.html");
			}
		} else {
			drupal_goto("404.html");
		}
	} else {
		drupal_goto("404.html");
	}
}

function _jcl_ical_url($node, $args) {

	$url = '';
	$title = urlencode($node->title);
	
	// we need the dateto fix the times but will need to adjust the date for the midnight hack later.
	$date = str_replace("-","", substr(_jcl_ical_get_field_value($node, 'field_event_dates', $args[1]),0, 10));
	$starttime = _jcl_ical_fix_dst($date, _jcl_ical_get_field_value($node, 'field_event_starttime'));
	$endtime = _jcl_ical_fix_dst($date, _jcl_ical_get_field_value($node, 'field_event_endtime'));
	
	// fix the date for the midnight hack
	$date = _jcl_ical_fix_date($date, $starttime);
	$location = urlencode(_jcl_ical_get_location($node));
	$body = urlencode(strip_tags(trim($node->body['und']['0']['value'])));

	switch ($args[2]) {
		case "google":
			$start = $date . "T" . str_replace(":","", $starttime) . "Z";
			$end = $date . "T" . str_replace(":","", $endtime) . "Z";
			$url = "https://www.google.com/calendar/event?action=TEMPLATE&text=" . $title . "&dates=" . $start ."/" . $end . "&details=$body&location=$location";
			break;
		case "outlookcom":
			$start = $date . "T" . str_replace(":","", $starttime) . "Z" ;
			$end = $date . "T" . str_replace(":","", $endtime) . "Z";
			$url = "https://bay02.calendar.live.com/calendar/calendar.aspx?rru=addevent&dtstart=$start&dtend=$end&summary=$title&description=$body&location=$location&allday=false&uid=";
			break;
		case "yahoo":
			$start = $date . "T" . str_replace(":","", $starttime) . "Z" ;
			$dur = _jcl_ical_duration($date, $starttime, $endtime);
			$dur->format("%H%I");
			$url = "http://calendar.yahoo.com/?v=60&title=$title&st=$start&dur=" . $dur->format("%H%I") . "&desc=$body&in_loc=$location&type=10";
			break;
	}
	return $url;
}

function _jcl_ical_fix_date($date, $start) {
	$dtNew = new DateTime($date);
	$dtTime = new DateTime($start);
	$dst = $dtNew->format("I");

	if ($dtTime->format("His") >= "000000" && $dtTime->format("His") < "010000") {
		// fix if the stored start date is midnight as it will bork.
		$dtTemp = $dtNew->add(new DateInterval('P1D'));
		return $dtTemp->format("Ymd");
	} else {	
		if (!$dst && $dtTime->format("His") == "010000") {
			$dtTemp = $dtNew->add(new DateInterval('P1D'));
			return $dtTemp->format("Ymd");
		}
	}
	// just return the date
	return $dtNew->format("Ymd");

}

function _jcl_ical_fix_dst($date, $time) {
	//since the times are stored weird we need to fix them for dst

	// check if current date is DST
	$dtNow = new DateTime($date);
	$dst = $dtNow->format("I");

	// covert the incoming date to an actual date object
	$dtNew = new DateTime($time);

	if ($dst) {
		// subtract an hour
		$dtTemp = $dtNew->sub(new DateInterval('PT1H'));
		return $dtTemp->format("H:i:s");
	} else {
		// return the original time
		return $dtNew->format("H:i:s");
	}

}

function _jcl_ical_file($node, $delta) {
	$nid = $node->nid;

	$filename = "event" . $nid . ".ics";
	$filedata = _jcl_ical_file_data($node, $delta);
	$len = mb_strlen($filedata, '8bit');
	drupal_add_http_header('Cache-Control', 'private');
	drupal_add_http_header('Expires', '0');
	drupal_add_http_header('Content-type', 'text/Calendar; Charset=UTF-8');
	drupal_add_http_header('Content-Disposition', 'attachment; filename=' . $filename);
	drupal_add_http_header('Access-Control-Allow-Origin', "*");
	drupal_add_http_header('Transfer-Encoding', 'binary');
	drupal_add_http_header('Content-Length', $len);
	drupal_add_http_header('HTTP/1.0 200 OK', true, 200);
	$fp = fopen('php://output', 'w');
	print($filedata);
	fclose($fp);
}

function _jcl_ical_file_data($node, $delta = 0) {
	$nid = $node->nid;
	
	$ical = "BEGIN:VCALENDAR\r\n" .
			"VERSION:2.0\r\n" .
			"PRODID:-//Johnson County Library//Event Management System//EN\r\n";

	$date = str_replace("-","", substr(_jcl_ical_get_field_value($node, 'field_event_dates', $delta),0, 10));
	$ical .= _jcl_ical_gen_ical($nid, $date);

	$ical .= "END:VCALENDAR";
	return $ical;
}

function _jcl_ical_get_term($tid) {
	$term = taxonomy_term_load($tid);
	return $term->name;
}

function _jcl_ical_get_field_value($node, $fieldname, $delta = 0) {
	$field = field_get_items('node', $node, $fieldname);
	return $field[$delta]['value'];
}


function _jcl_ical_description($field) {
	$text = strip_tags($field[0]['#markup'],"<a></a><br></br>");
	$text = str_replace("<br />", " ", $text);
	$text = str_replace('<a href="', "(", $text);
	$text = str_replace(' target="_self"', "", $text);
	$text = str_replace('" title="">', ") ", $text);
	$text = str_replace('</a>', '', $text);
	$text = str_replace(',', '\,', $text);
	return $text;
}

function _jcl_ical_get_location($node) {
	$location_id = field_get_items('node', $node, 'field_event_location');
	if ($location_id) {
		$nid = $location_id[0]['target_id'];
		$node = node_load($nid);
		return $node->title;
	}
}

function _jcl_ical_duration($date, $starttime, $endtime) {
	$dtStart = new DateTime($date . " " . $starttime);
	if ($endtime < $starttime) {
		$d0 = new DateTime($date . " " . $endtime);
		$dtEnd = $d0->add(new DateInterval('P1D'));
	} else {
		$dtEnd = new DateTime($date . " " . $endtime);
	}
	return $dtStart->diff($dtEnd);
}

function _jcl_ical_gen_ical($nid, $date) {
	$ical_data = array();
	$ical_data['nid'] = $nid;
	
	// load the node
	$node = node_load($ical_data['nid']);
	// get the node's title
	$title = $node->title;
	// see if the title contains "Mill Creek"
	$mill = strpos($title, 'Mill Creek Activity Center');
	if ($mill == false) {
		$ical_data['title'] = $title;
		$location = _jcl_ical_get_location($node);
		// $locationNode = node_load($field[0]['target_id']);
		$ical_data['library'] = $location;
	} else {
		$ical_data['title'] = trim(substr($title, 0, $mill), ' ');
		$ical_data['library'] = 'Mill Creek Activity Center';
	}
	
	// get the node's UUID
	$uuid = $node->uuid;
	if (!$uuid) {
		$ical_data['uuid'] = uniqid();
	} else {
		$ical_data['uuid'] = $uuid;
	}
	
	// get the event's body field value
	$ical_data['body'] = trim($node->body['und']['0']['value']);

	// get the URL
	$ical_data['url'] = 'https://www.jocolibrary.org/' . $node->path['alias'];

	// Get the event type field
	$field = field_get_items('node', $node, 'field_eventtype_ref');
	$ical_data['category'] = _jcl_ical_get_term($field[0]['tid']);

	// get the timezone
	$field = field_get_items('node', $node, 'field_event_dates');
	$ical_data['tzid'] = "TZID:" . $field[0]['timezone'] . "\r\n";

	// Get the event start and end time and adjust for DST if necessary
	$starttime = _jcl_ical_fix_dst($date, _jcl_ical_get_field_value($node, 'field_event_starttime'));
	$endtime = _jcl_ical_fix_dst($date, _jcl_ical_get_field_value($node, 'field_event_endtime'));

	// Get the event date
	$date = _jcl_ical_fix_date($date, $starttime);
	$ical_data['date'] = $date;


	// make the DTSTART string
	$ical_data['dtstart'] = $date . "T" . str_replace(":","", $starttime) . "Z";
	
	// get the duration from the record and convert it from minutes to Hours and minutes
	$dur = _jcl_ical_duration($date, $starttime, $endtime);
	$ical_data['duration'] = $dur->format("PT%HH%IM");
	
	// make datestamp string
	$ical_data['dstamp'] = date('Ymd') . "T" . date('His') . "Z";

	// build the ical text
	$ical =	"BEGIN:VEVENT\r\n" .
				"DTSTAMP:" . $ical_data['dstamp'] . "\r\n" .
				$ical_data['tzid'] .
				"DESCRIPTION:" . $ical_data['body'] ."\r\n" .
				"X-ALT-DESC;FMTTYPE=text/html:" . $ical_data['body'] ."\r\n" .
				"SUMMARY:" . $ical_data['title'] ."\r\n" .
				"LOCATION:" . $ical_data['library'] ."\r\n" .
				"URL:" . $ical_data['url'] ."\r\n" .
				"UID:" . $ical_data['uuid'] ."\r\n" .
				"CATEGORIES:" . $ical_data['category'] ."\r\n" .
				"DTSTART:" . $ical_data['dtstart'] ."\r\n" .
				"DURATION:" . $ical_data['duration'] ."\r\n" .
				"BEGIN:VALARM\r\n" .
				"TRIGGER:-PT15M\r\n" .
				"ACTION:DISPLAY\r\n" .
				"END:VALARM\r\n" .
				"END:VEVENT\r\n";
	return $ical;
}