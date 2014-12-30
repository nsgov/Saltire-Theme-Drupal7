<li>
  <h3 class="title"<?php print $title_attributes; ?>>
    <a href="<?php print $url; ?>"><?php print $title; ?></a>
  </h3>
  <?php if ($snippet): ?>
    <p class="search-snippet"<?php print $content_attributes; ?>><?php print $snippet; ?></p>
  <?php endif; ?>
</li>
