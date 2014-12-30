<article>

<?php if ($user_picture || $display_submitted || !$page): ?>
	<?php if (!$page): ?>
		<header>
	<?php endif; ?>

	<?php print $user_picture; ?>

	<?php print render($title_prefix); ?>

	<?php if (!$page): ?>
	<?php if ($title): ?><h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2><?php endif; ?>
	<?php endif; ?>

	<?php print render($title_suffix); ?>

	<?php if ($submitted): ?>
		<p><?php print format_date($node->created, 'custom', 'F dS Y'); ?></p>
	<?php endif; ?>


	<?php if (!$page): ?>
		</header>
	<?php endif; ?>
<?php endif; ?>

<?php
	// Hide comments, tags, and links now so that we can render them later.
	hide($content['comments']);
	hide($content['links']);
	hide($content['field_tags']);
	print render($content);
?>

<?php print render($content['comments']); ?>

</article>
