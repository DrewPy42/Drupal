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
function _jcl_breadcrumb_general_settings_form($form, &$form_state) {

  $form = array(
    '#type' => 'fieldset',
    '#title' => t('General settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  $form['jcl_breadcrumb_include_invalid_paths'] = array(
    '#type' => 'checkbox',
    '#title' => t('Include invalid paths alias as plain-text segments'),
    '#description' => t('Include the invalid paths alias as plain-text segments in the breadcrumb.'),
    '#default_value' => variable_get('jcl_breadcrumb_include_invalid_paths', TRUE),
  );

  //$form['jcl_breadcrumb_excluded_paths'] = array(
  //  '#type' => 'textarea',
  //  '#title' => t('Paths to be excluded while generating segments'),
  //  '#description' => t('Enter a list of path that will not be affected by Breadcrumb Manager. You can use "*" as wildcard.'),
  //  '#default_value' => variable_get('jcl_breadcrumb_excluded_paths', 'search/*'),
  //);

  $form['jcl_breadcrumb_include_home_segment'] = array(
    '#type' => 'checkbox',
    '#title' => t('Include the front page as a segment in the breadcrumb'),
    '#description' => t('Include the front page as the first segment in the breacrumb.'),
    '#default_value' => variable_get('jcl_breadcrumb_include_home_segment', TRUE),
  );

  $form['jcl_breadcrumb_home_title'] = array(
    '#type' => 'textfield',
    '#title' => t('Title for the front page segment in the breadcrumb'),
    '#description' => t('Text to be displayed as the from page segment.'),
    '#default_value' => variable_get('jcl_breadcrumb_home_title','Home'),
  );

  $form['jcl_breadcrumb_include_title_segment'] = array(
    '#type' => 'checkbox',
    '#title' => t('Include the current page title as a segment in the breadcrumb'),
    '#description' => t('Include the current page title as the last segment in the breadcrumb.'),
    '#default_value' => variable_get('jcl_breadcrumb_include_title_segment', FALSE),
  );

  $form['jcl_breadcrumb_title_from_page'] = array(
    '#type' => 'checkbox',
    '#title' => t('Use the real page title when available'),
    '#description' => t('Use the real page title when it is available instead of always deducing it from the URL.'),
    '#default_value' => variable_get('jcl_breadcrumb_title_from_page', TRUE),
  );

  $form['jcl_breadcrumb_title_segment_as_link'] = array(
    '#type' => 'checkbox',
    '#title' => t('Make the page title segment a link'),
    '#description' => t('Prints the page title segment as a link.'),
    '#default_value' => variable_get('jcl_breadcrumb_title_segment_as_link', FALSE),
  );

  $form['jcl_breadcrumb_segments_separator'] = array(
    '#type' => 'textfield',
    '#title' => t('Segments separator'),
    '#description' => t('Separator to be used between the breadcrumb segments.'),
    '#default_value' => variable_get('jcl_breadcrumb_segments_separator', ">>"),
  );

  $form['jcl_breadcrumb_captializer_mode'] = array(
    '#type' => 'select',
    '#title' => t('Transformation mode for the segment titles'),
    '#options' => array(
      0 => t('Capitalize the first letter of each word in the segment'),
      1 => t('Only capitalize the first letter of each segment'),
      2 => t('None'),
    ),
    '#description' => t('Choose the transformation mode you want to apply to the segments. E.g.: "blog/once-a-time" -> "Home >> Blog >> Once a Time".'),
    '#default_value' => variable_get('jcl_breadcrumb_captializer_mode', '0'),
  );

  $form['jcl_breadcrumb_ignored_words'] = array(
    '#type' => 'textarea',
    '#rows' => 3,
    '#title' => t('Words to be ignored by the capitalization function'),
    '#description' => t('Enter a space separated list of words to be ignored by the capitalization function. A word must match exactly to be ignored. Do not use wildcards.'),
    '#default_value' => variable_get('jcl_breadcrumb_ignored_words', 'of and or de del y o'),
  );

  $form['jcl_breadcrumb_special_words'] = array(
    '#type' => 'textarea',
    '#rows' => 3,
    '#title' => t('Words to be printed as is'),
    '#description' => t('Enter a space separated list of words to be printed "as is" in the breadcrumb. This is useful for items that have different than normal capilization. These words are not used when capitalization is set to only capitalize the first word.'),
    '#default_value' => variable_get('jcl_breadcrumb_special_words', 'eLibrary eAudiobooks eLearning'),
  );

  return system_settings_form($form);
}