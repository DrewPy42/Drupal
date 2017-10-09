<?php

/**
 * @file
 * Module's blocks.
 */

/**
 * Obtains the 'jcl_collapse' block.
 *
 * @return Assoc
 *   resulting renderizable array.
 */
function _jcl_collapse_block() {
	// get the menus and then send them to the screen.
	$output = _jcl_collapse_get_links();
	return $output;
}

function _jcl_collapse_get_links() {
	// initialize variables
	$type = 'collapsible_menu';
	$menu_title = '';
	$nodes = array();
	$links = array();
	$output = '';

	// only load the nodes of that type that are published.
	$nodes = node_load_multiple(array(), array('type' => $type, 'status' => 1));
	// go through each node and see if it is available for the current page
	// if available, then get it's links and save them in the $links arrays
	foreach($nodes as $node) {
		$match = _jcl_collapse_match_location($node);
		if ($match) {
			$menu_title = $node->title;
			$links = _jcl_collapse_links($node);
			$class = _jcl_collapse_class($node);
			$output .= theme_jcl_collapse($links, $class, $menu_title);
		}
	}
	// return the themed menus
	return $output;
}

/**
* @return Assoc
*	return true if the location matches
*/
function _jcl_collapse_match_location($node) {
	$locationfield = field_get_items('node', $node, 'field_collapsible_location');
	$location = $locationfield[0]['safe_value'];
	if (drupal_is_front_page()) {
		$path = "front";
	} else {
		$path = drupal_get_path_alias(current_path());
	}
	$match = ($location == $path);
	return $match;
}

function _jcl_collapse_links($node) {
	$url = array();
	$link = field_get_items('node', $node, 'field_collapsible_link');
	foreach ($link as $key=>$value) {
		$output = field_view_value('node', $node, 'field_collapsible_link', $link[$key]);
		$url[] = array(
			'link'		=> $output['#element']['url'],
			'linktext'	=> $output['#element']['title'],
			);
	}
	return $url;
}

function _jcl_collapse_class($node) {
	$classfield = field_get_items('node', $node, 'field_collapsible_class');
	$class = $classfield[0]['safe_value'];
	return $class;
}

function theme_jcl_collapse($links, $class, $title) {

	// Theme all menus for output.
	$output = '';
	// only do something if there are menus (saves processing power)
	if (count($links) > 0) {
		foreach ($links as $link) {
			$vars = array(
				'link'	=> $link['link'],
				'linktext' => $link['linktext'],
		    );
			// theme each menu and add it to the output string
			$output .= theme('jcl_collapse_link', array('vars' => $vars));
		}
		// Add the 'show dismissed menus to the array.
		$vars = array(
			'title'	=> $title,
			'class'	=> $class,
			'links'	=> $output,
		);
		// theme the menu wrapper
		$output = theme('jcl_collapse_wrapper', array('vars' => $vars));
	}
	// send them back to the block.
	return $output;
}