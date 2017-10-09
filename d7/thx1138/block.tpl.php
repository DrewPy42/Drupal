<?php

if ($classes) {
  $classes = ' class="'. $classes . ' "';
}

//add a aria role search if this is the search block
if($variables['block_html_id'] == "block-search-form"){
	$role = ' role="search"';
}else{
  $role = '';
}

// pull the machine name from the view array, if it exists and use it for the block ID.
$id_block = $variables['elements']['#contextual_links']['views_ui_basic'][1][1];

// if the $id_block doesn't have a value that means the block was created outside of views.
// So just use its delta value.
if (!$id_block) {
  $id_block = "block-" . $block->module . '-' . $block->delta;
}

$bid = 'block-' . $block->module .'-'. $block->delta;

?>

<?php if(theme_get_setting('thx1138_poorthemers_helper') ){ ?>
  <!-- block -->
<?php } ?>
<input type="checkbox" id="<?php print $id_block; ?>-toggle" class="toggle-check" name="toggler" />
<label for="<?php print $id_block ?>-toggle" class="toggle" onclick>
  <span class="icon" aria-hidden="true"></span>
  <span class="icon-text"><?php print $block->subject ?></span>
</label>
<div <?php print "id = '" . $id_block . "' " . $classes .  $attributes . $role; ?>>
  <p><?php print "block id = " . $bid;?></p>
  <p><?php print "machine name = " . $id_block;?></p>
  <?php print $thx1138_poorthemers_helper;  ?>

  <?php print render($title_prefix); ?>
  <?php if ($block->subject): ?>
    <h2<?php print $title_attributes; ?>><?php print $block->subject ?></h2>
  <?php endif;?>
  <?php print render($title_suffix); ?>

  <?php if (!theme_get_setting('thx1138_classes_block_contentdiv') AND $block->module == "block"): ?>
  <div <?php print $content_attributes; ?>>
  <?php endif ?>

  <?php print $content ?>

  <?php if (!theme_get_setting('thx1138_classes_block_contentdiv') AND $block->module == "block"): ?>
  </div>
  <?php endif ?>
</div>
<?php if(theme_get_setting('thx1138_poorthemers_helper') ){ ?>
  <!-- /block -->
<?php } ?>
