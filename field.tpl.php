	<?php if (!$label_hidden): ?>
		<div><?php print $label ?>:&nbsp;</div>
	<?php endif; ?>

	<?php foreach ($items as $delta => $item): ?>
		<?php print render($item); ?>
	<?php endforeach; ?>