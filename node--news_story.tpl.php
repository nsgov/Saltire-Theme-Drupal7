<?php if (!$page): ?>
  <article id="node-<?php print $node->nid; ?>" class="clearfix">
<?php endif; ?>

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
  
    <?php if (!$page): ?>
      </header>
	<?php endif; ?>
  <?php endif; ?>
  <div class="content"<?php print $content_attributes; ?> vocab="http://schema.org/" typeof="Article">
  
  <?php if ($status==1) {} else {?><div class="status">DRAFT</div><?php } ?>
   
	<section class="newscontent"> 
	<?php if ($content['field_additional_photos'] || $content['field_video']): ?>
		<div class="media-viewer">
			<div class="media-index">
				<div class="media-index-viewport">
					<div class="media-index-items">
					<?php
					print render($content['field_additional_photos']); 
					print render($content['field_video']); 
					?>
					</div>
				</div>
				<button class="media-index-back"></button>
				<button class="media-index-next"></button>
			</div>
	        <div class="media-viewport">
	          <div class="media-view-photo">
				<img alt="" title="" class="media-view-img" />
				<div class="media-overlay">
					<details class="media-caption">
						<p></p>
						<summary>View Caption</summary>
					</details>
					<a class="media-download">Download Hi-Res Photo</a>
				</div>
			  </div>
			  <div class="media-view-video">
			  </div>
	        </div>
		</div>
	<?php endif; ?>
		
		
	    <?php if ($title): ?><h1><?php print $title; ?></h1><?php endif; ?>
		<?php if ($submitted): ?><p class="date"><?php print format_date($node->created, 'custom', 'F dS Y'); ?></p><?php endif; ?>
	    <?php
	      // Hide comments, tags, and links now so that we can render them later.
	      hide($content['comments']);
	      hide($content['links']);
	      hide($content['field_tags']);
	      //print render($content);	  
		  print render($content['field_select_department_s_']); ?>
		  
		  <div class="news">
		  	  <span property="description"><?php print render($content['field_summary']); ?></span>
			  <span property="articleBody"><?php print render($content['field_press_release']); ?></span>
<pre class="broadcastcopy"><?php print render($content['field_broadcast_copy']);?></pre>
			 <?php print render($content['field_media_contact']);?> 
		  </div>
	  </section>
	  <section class="newsdetail">
	  	  <?php
		  print render($content['field_learn_more_links']); 
		  print render($content['field_categories']);?>
		  
		  <div class="field">
		  	<div class="field-label">Share this story</div>
		  	<div class="field-items">
		  		<a href="" class="twitter"><img src="/sites/all/themes/saltire/img/icon-twitter.png" width="34" height="34" alt="Tweet this" /></a> 
		  		<a href="" class="facebook"><img src="/sites/all/themes/saltire/img/icon-facebook.png" width="34" height="34" alt="Share this on Facebook" /></a> 
		  		<a href="" class="linkedin"><img src="/sites/all/themes/saltire/img/icon-linkedin.png" width="34" height="34" alt="Share this on LinkedIn" /></a>
		  		<a href="" class="google"><img src="/sites/all/themes/saltire/img/icon-google.png" width="34" height="34" alt="Share on G+" /></a> 
		  	</div>
		  </div>
		  
		  <?php
		  print render($content['field_file_attachment']); 
		  print render($content['field_audio_clip']); 
		  ?>
		  
		 
	  </section>
  </div>

  <?php print render($content['comments']); ?>
  <script type="text/javascript" src="/<?php echo $directory; ?>/js/mediavwr.js"></script>

<?php if (!$page): ?>
  </article> <!-- /.node -->
<?php endif; ?>
