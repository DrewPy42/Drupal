<?php
//kpr(get_defined_vars());
//kpr($theme_hook_suggestions);
//template naming
//page--[CONTENT TYPE].tpl.php
?>
<?php if( theme_get_setting('thx1138_poorthemers_helper') ){ ?>
<!-- page.tpl.php-->
<?php } ?>

<?php print $thx1138_poorthemers_helper; ?>

<header role="banner">
  <div class="siteinfo">
    <?php if ($logo): ?>
      <figure>
      <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home">
        <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
      </a>
      </figure>
    <?php endif; ?>

    <?php if($site_name OR $site_slogan ): ?>
    <hgroup>
      <?php if($site_name): ?>
        <h1><?php print $site_name; ?></h1>
      <?php endif; ?>
      <?php if ($site_slogan): ?>
        <h2><?php print $site_slogan; ?></h2>
      <?php endif; ?>
    </hgroup>
    <?php endif; ?>
  </div>
  <?php if($page['header']): ?>
    <div class="header-region">
      <?php print render($page['header']); ?>
    </div>
  <?php endif; ?>
</header>

<?php if($page['highlighted'] OR $messages){ ?>
  <div class="drupal-messages">
  <?php print render($page['highlighted']); ?>
  <?php print $messages; ?>
  </div>
<?php } ?>

<?php if($page['header_utility']): ?>
<div id="utility">
  <div class="utility-wrapper">
    <?php print render($page['header_utility']); ?>
  </div>
</div>
<?php endif; ?>
<?php if ($page['sidebar_first']): ?>
  <div class="sidebar-first">
  <?php print render($page['sidebar_first']); ?>
  </div>
<?php endif; ?>

<?php if ($page['sidebar_top']): ?>
  <div class="sidebar-top">
  <?php print render($page['sidebar_top']); ?>
  </div>
<?php endif; ?>


<div class="page">
  <div role="main" id="main-content">
    <?php print render($title_prefix); ?>
    <?php if ($title): ?>
      <h1><?php print $title; ?></h1>
    <?php endif; ?>
    <?php print render($title_suffix); ?>

    <?php print $breadcrumb; ?>

    <?php if ($action_links): ?>
      <ul class="action-links"><?php print render($action_links); ?></ul>
    <?php endif; ?>

    <?php if (isset($tabs['#primary'][0]) || isset($tabs['#secondary'][0])): ?>
      <nav class="tabs"><?php print render($tabs); ?></nav>
    <?php endif; ?>

    <?php print render($page['content_pre']); ?>

    <?php print render($page['content']); ?>

    <?php print render($page['content_post']); ?>

  </div><!-- /main-->

  <?php if ($page['sidebar_second']): ?>
    <div class="sidebar-second">
      <?php print render($page['sidebar_second']); ?>
    </div>
  <?php endif; ?>
</div><!-- /page-->
<footer role="contentinfo">
  <?php print render($page['footer']); ?>
</footer>
<script type="text/javascript">
var loop11_key = "9x9x9a8s9xxx0097x8g8";
var l11_clientOptions = {"crossDomainSupport":true};
document.write(unescape("%3cscript src='//cdn.loop11.com/my/loop11.js' type='text/javascript'%3e%3c/script%3e"));
</script>