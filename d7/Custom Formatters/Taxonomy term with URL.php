<?php
$settings = $variables['#display']['settings'];

$output = '';
foreach ($variables['#items'] as $delta => $item) {
	$vocab = taxonomy_term_load($item['tid']);
	$name = $vocab->name;

	if ($settings['add_dashes'] == 'Yes') {
		$name = str_replace(" ", "-", $name);
	}

	$option = $settings['transform_options'];
	switch ($option) {
		case 'Lower':
			$name = strtolower($name);
			break;
		case 'Upper':
			$name = strtoupper($name);
			break;
	}
        $prefix = $settings['url_prefix'];
        if (substr($prefix, 0, 1) != "/") {
               $prefix = "/" . $prefix;
        }
        if (substr($prefix, -1) != "/") {
               $prefix = $prefix .  "/";
        }
	// $output .= "<a href='" . $prefix . $name . "'>" . $vocab->name . "</a> ";
	$element[$delta] = array(
		'#type' => 'link',
		'#title' => $vocab->name,
		'#href' => $prefix . $name,
	);
}
return $element;
?>