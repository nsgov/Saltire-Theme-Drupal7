<section id="<?php print $block_html_id; ?>" class="<?php print $classes; ?>">
  <?php print render($title_prefix); ?>
    <?php if (isset($title)): ?><h2><?php print $title; ?></h2><?php endif; ?>
  <?php print render($title_suffix); ?>

  <?php print $content ?>
</section>