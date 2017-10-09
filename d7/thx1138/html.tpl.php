<!doctype html>
<html class="no-js" lang="en">
<?php print $thx1138_poorthemers_helper; ?>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta charset="utf-8">


<title><?php print $head_title; ?></title>
<?php print $head; ?>
<link rel="dns-prefetch" href="//fonts.googleapis.com">
<!--[if IE]> <link rel="prefetch" href="//fonts.googleapis.com"> <![endif]-->
<?php print $appletouchicon; ?>
<?php if(theme_get_setting('thx1138_mobile')){  ?>
<meta name="MobileOptimized" content="width">
<meta name="HandheldFriendly" content="true"><?php } ?>
<?php if(theme_get_setting('thx1138_viewport')){  ?><meta name="viewport" content="width=device-width, initial-scale=1"><?php } ?>
<?php if(theme_get_setting('thx1138_viewport_maximumscale')){  ?><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"><?php } ?>
<meta http-equiv="cleartype" content="on">
<?php print $styles; ?>
<?php if(theme_get_setting('thx1138_respondjs')) { ?>
<!--[if lt IE 9]>
  <script src="<?php print $thx1138_path; ?>/js/respond.min.js"></script>
<![endif]-->
<?php } ?>
<!--[if lt IE 9]>
  <script src="<?php print $thx1138_path; ?>/js/html5.js"></script>
<![endif]-->
<?php print $selectivizr; ?>
<?php
  if(!theme_get_setting('thx1138_script_place_footer')) {
    print $scripts;
  }
?>
</head>
<?php
	$search = array('sidebar-first ', 'sidebar-second ');
	$classes = str_replace($search, '', $classes);
?>
<body class="<?php print $classes; ?>" <?php print $attributes;?>>
<a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
<?php print $page_top; //stuff from modules always render first ?>
<?php print $page; // uses the page.tpl ?>
<?php
  if(theme_get_setting('thx1138_script_place_footer')) {
    print $scripts;
  }
?>
<?php print $page_bottom; //stuff from modules always render last ?>
</body>
</html>

