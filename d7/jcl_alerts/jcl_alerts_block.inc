<?php

/**
 * @file
 * Module's blocks.
 */

/**
 * Obtains the 'jcl_alerts' block.
 *
 * @return Assoc
 *   resulting renderizable array.
 */

function _jcl_alerts_block() {
    // get the messages and then send them to the screen.
    $output = _jcl_alerts_get_messages();
    return $output;
}

function _jcl_alerts_get_messages() {
     // pull up the content type and the field information from the config settings
    $type = variable_get('jcl_alerts_content_type', 'alert');
    $field = variable_get('jcl_alerts_type_field', 'field_alert_type');
    $nodes = array();
    // load the nodes of that type and and that are only published.
    $nodes = node_load_multiple(array(), array('type' => $type, 'status' => 1));

    // initialize the messages array that we will hold all the messages in
    $messages = array();
    $host = $_SERVER['HTTP_HOST'];
    foreach($nodes as $node) {
        // if the message is not hidden then keep going
        $skip = FALSE;
        $nid = $node->nid;
        if(isset($_COOKIE[$nid])) {
            if($_COOKIE[$nid] == 'TRUE') {
                $skip = TRUE;
            }
        }
        if($skip == FALSE) {

            $match = FALSE;
            // get the alert type associated with the node
            $terms = field_view_field('node', $node, $field);
            $section_terms = field_view_field('node', $node, 'field_alert_section');

            $a_type = $terms['#items'][0]['taxonomy_term']->name;
            if ($a_type == '') {
                $a_type = 'default';
            }

            // determine if this is a global message
            $globalfield = field_get_items('node', $node, 'field_alert_is_global');
            $global = field_view_value('node', $node, 'field_alert_is_global', $globalfield[0]);
            // pulls the contextual taxonomy
            if ($section_terms) {
                $section = strtolower($section_terms['#items'][0]['taxonomy_term']->name);
            } else {
                $section = '';
            }

            switch ($section) {
                case 'teens':
                    $section = 'teenscene';
                    break;
                case 'birth to 6':
                    $section = 'birth-to-six';
                    break;
                default:
                    $section = str_replace(' ', '-', $section);
                    break;
            }

            if ($global['#markup'] == 'true') {
                $match = TRUE;
            } else {
                // get the page's current path alias and conver to an array
                $path = strtolower(drupal_get_path_alias(current_path()));
                $paths = explode('/', $path);
                // fix for espanol URL changes
                for($i=0; $i < count($paths); $i++) {
                    if($paths[$i] == 'espanol') {
                        $paths[$i] = 'español';
                    }
                }
                // compare the path alias with the taxonomy and see if there is a match
                // put those matches into another array
                $match = in_array($section, $paths);
            }   
            // if the message is marked global or there is a match then build it
            if ($match == TRUE) {
                // build the read more URL lookup
                $options = array('absolute' => TRUE);
                $nid = $node->nid;
                $url = url('node/' . $nid, $options);

                //append the node id to the type so that it can be accessed via javascript
                $a_type .= $nid . ' ' . $nid;' ' . $nid;
                
                $detailfield = field_get_items('node', $node, 'field_alert_details');
                $summary = _jcl_alerts_normalize_summary($detailfield);
                // build the message HTML
                $message = $summary . "<div class='read-more-button'><a href=" . $url . " class='read-more' >read more</a></div>";
                // add the message and it's 'type' to the array
                $messages[] = array('message' => $message, 'type' => $a_type);
            }
        }
    }
    // return the themed messages
    return theme_jcl_alerts($messages);
}

function _jcl_alerts_normalize_summary($detailfield) {
    $summary = $detailfield[0]['summary'];
    if (substr($summary,0, 3) === '<p>') {
        //if the string starts with a <p> then it will end with a <p>. Strip them out.
        $summary = substr($summary, 3);
        $summary = substr($summary, 0, strlen($summary)-6);
    }
    return $summary;
}

function theme_jcl_alerts($messages) {

    // Theme all messages for output.
    $output = '';
    // only do something if there are messages (saves processing power)
    if (count($messages) > 0) {
        foreach ($messages as $message) {
            $vars = array(
                'type'    => $message['type'],
                'message' => $message['message'],
                'dismiss' => t('Dismiss this message'),
            );
            // theme each message and add it to the output string
            $output .= theme('jcl_alerts_message', array('vars' => $vars));
        }
        
        // Add 'Dismiss all messages'
        // $vars = array(
        //     'messages'    => $output,
        //     'dismiss_all' => t('Dismiss all messages'),
        // );

        // theme the dismiss all code and add it to the output string
        // $output .= theme('jcl_alerts_dismiss_all', array('vars' => $vars));

        // Add the 'show dismissed messages to the array.
        $vars = array(
            'messages'        => $output,
            'show_dismissed'  => t('Show dismissed messages'),
            'dismiss_all'     => t('Dismiss all messages'),
        );
       
        // theme the message wrapper
        $messages = theme('jcl_alerts_wrapper', array('vars' => $vars));
    }

    // send them back to the block.
    return $messages;
}