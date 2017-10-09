<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */

?>
<div id="jcl_container">
<div class="jcl-tiles-count-<?php print count($rows); ?>">
<?php if (!empty($title)): ?>
	<h3><?php print $title; ?></h3>
<?php endif; ?>
<?php foreach ($rows as $id => $row): ?>
		<?php print $row; ?>
<?php endforeach; ?>
</div>
</div>