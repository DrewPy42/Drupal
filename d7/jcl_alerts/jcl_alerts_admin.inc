<?php

/**
 * @file
 * Module's admin forms.
 */

/**
 * General configuration form.
 *
 * @return Assoc
 *   renderable form.
 */
function _jcl_alerts_general_settings_form($form, &$form_state) {

	$form = array();

    $form['message'] = array(
        '#markup' => '<p>It is important to have a taxonomy field added to the selected content type. This field needs to be set to a taxonomy vocabulary named "Alert types". Doing this will allow theming to change the visual format of the alert depending on type</p>',
        );
    
    // This allows the site admin to change which content type provides the alert messages
	$form['jcl_alerts_content_type'] = array(
    	'#type' => 'select',
    	'#title' => t('Select Content Type'),
    	'#description' => t('This content type will provide the text for the Alerts.'),
    	'#default_value' => variable_get('jcl_alerts_content_type', 'alert'),
    	'#options' => _node_types_build()->names,
  	);

    // // this sets how many messages are visible for the dismiss all button to be visible.
    // $form['general']['jcl_alerts_dismiss_all_count'] = array(
    //     '#type' => 'textfield',
    //     '#title' => t('Show "Dismiss all messages" when number of messages is higher than'),
    //     '#default_value' => variable_get('jcl_alerts_dismiss_all_count', 2),
    // );

    $form['general']['jcl_alerts_type_field'] = array(
        '#type' => 'textfield',
        '#title' => t('The field that handles the alert types for theming purposes.'),
        '#default_value' => variable_get('jcl_alerts_type_field', 'field_alert_type'),
    );

	return system_settings_form($form);
}