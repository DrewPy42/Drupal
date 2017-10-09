<?php
	include 'config.php'; //include the configuration info
	include 'opendb.php'; //include the connection function

	$dir = dirname($argv[0]);
	$file = $dir . '/nodes.txt';
	$logfile = $dir . '/log.txt';
	$log = '';
	
	date_default_timezone_set('America/Chicago');
	$logheader = "\r\n" . date('n/d/Y H:i:s') . "\r\n---------------------\r\n";
	// initialize the fields array to make sure it's empty.
	$fields = array();

	if (filesize($file) == 0) {
		print ("nodes.txt not found\n");
		$log .= $logheader . "Node.txt file not found.\r\n";
		file_put_contents($logfile, $log);
		die();
	}
	// load the nodes.txt file in as an array
	$lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	
	// iterate through the array and convert the semicolon delimited line
	// into an array and add it to the fields array.
	foreach ($lines as $line) {
		// if the line does not have a semicolon in it, then we assume the date is
		// missing and add one at the end
		if (!preg_match('/;/', $line)) {
			$line .= ";";
		}
		$fields[] = str_getcsv($line, ";");
	}
	print_r($fields);
	// go through the array and see if a record is needing to be unpublished.
	// if the date is blank or older than the current date, then unpublish the node
	for ($i = 0; $i < count($fields); ++$i) {
		$nid = intval($fields[$i][0]);
		// print "NID: " . $nid . "\n";
		if (is_int($nid)) {
			$date = strtotime($fields[$i][1]);
			if ($date == '' || $date <= time()) {
				// get the vid for the most recent revision
				$query = "SELECT vid FROM node WHERE nid WHERE nid = " . $nid . ";";
				$result = $conn->query($query);
				$row = mysqli_fetch_row($result);
				$vid = $row[0];
				
				// look to see if a a workbench history record exists.
				// Pull only the ones where the is_current value set to 1 to ensure we get the most recent record.
				// We don't care about anything that isn't current at this time.
				$query = "SELECT vid, nid, state, published, is_current FROM workbench_moderation_node_history WHERE nid = " . $nid . " AND vid = " . $vid . " and is_current = 1;";
				$result = $conn->query($query);
				// convert the results to an array so we can process it
				$row = mysqli_fetch_array($result, MYSQLI_NUM);
				// mysqli_free_result($result);
				if (count($row) == 0) {
					// if no workbench record, then we need to create one
					$query = "INSERT INTO workbench_moderation_node_history (vid, nid, state, published, is_current) VALUES (" . $vid . ", " . $nid . ", 'draft', 0, 1);";
					$result = $conn->query($query);
				} else {
					// if workbench recor exists then change the existing is_current to 0 and create a new workbench record.
					$query = "UPDATE workbench_moderation_node_history SET is_current = 0 WHERE nid = " . $nid . " AND vid = ". $vid . ";";
					$result = $conn->query($query);
					$query = "INSERT INTO workbench_moderation_node_history (vid, nid, state, published, is_current) VALUES (" . $vid . ", " . $nid . ", 'draft', 0, 1);";
					$result = $conn->query($query);
				}
			}
		}
	}
	if ($log) {
		$log = $logheader . $log;
		file_put_contents($logfile, $log);
	}
	// close the connection
	mysqli_close($conn);
?>