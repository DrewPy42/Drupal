<?php

// Plugin definition
$plugin = array(
  'title' => t('HTML5 base'),
  'category' => t('thx1138'),
  'icon' =>  'thx1138-html5page.png',
  'theme' => 'thx1138-html5page',
  'css' =>   'thx1138-html5page.admin.css',
  'regions' => array(
    'top' => t('Top (<header>)'),
    'top_mobile' => t('Top - Mobile (<header>)'),
    'middle' => t('Middle (role="main")'),
    'bottom' => t('Bottom (<footer>)'),
  ),
);
