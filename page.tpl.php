<?php
	global $base_url;
	$theme_base = $base_url . '/' . drupal_get_path('theme', $GLOBALS['theme']);
	$secure = 'http' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : '') . '://';
    $theme_base = str_replace('http://', $secure, $theme_base);
?>

		<ul id="wb-tphp">
			<li class="wb-slc">
				<a class="wb-sl" href="#wb-cont">Skip to main content</a>
			</li>
		</ul>

		<header role="banner">
			<div class="container">
				<div class="row">

					<div id="wb-sttl" class="col-md-8 col-xs-6">
						<a href="/" class="nslogo">
							<img src="<?php echo $theme_base; ?>/img/nsvip-en.svg" alt="Government of Nova Scotia, Canada" />
						</a>
					</div>

					<section class="wb-mb-links col-xs-6 visible-sm visible-xs" id="wb-glb-mn">
						<h2 class="element-invisible">Search and menus</h2>
						<ul class="pnl-btn list-inline text-right">
							<li><a href="#mb-pnl" title="Search and menus" aria-controls="mb-pnl" class="overlay-lnk btn btn-sm btn-default" role="button"><span class="glyphicon glyphicon-search"><span class="glyphicon glyphicon-th-list"><span class="wb-inv">Search and menus</span></span></span></a></li>
						</ul>
						<div id="mb-pnl"></div>
					</section>

					
				<?php if ($page['header']): ?>
					<section id="wb-srch" class="col-md-4 visible-md visible-lg">
						<?php print render($page['header']); ?>
					</section>
				<?php endif; ?>	


				</div>
			</div>

			<div id="wb-sm" data-trgt="mb-pnl" class="wb-menu visible-md visible-lg" typeof="SiteNavigationElement"> <!-- data-ajax-fetch="/sitemenu.html" -->
				<div class="container nvbar">
	<h2 class="element-invisible">Topics menu</h2>
    <div class="row">
        <!-- ul class="list-inline menu" --> 
		<nav role="navigation" id="main-navigation" aria-label="main navigation" class="list-inline menu">
			<?php
				$menu = menu_tree('main-menu');
				print drupal_render($menu);
			?>
		</nav>
    </div>
</div>

			</div>


		</header>
	
		<main role="main" property="mainContentOfPage" class="container" id="wb-cont">
	
		<nav role="navigation" id="wb-bc" property="breadcrumb" class="breadcrumb">
			<?php if ($breadcrumb): ?><?php print $breadcrumb; ?><?php endif;?>
		</nav>
		
		<?php if ($page['content_top']): ?>
			<section class="content_top">
				<?php print render($page['content_top']); ?>
			</section>
		<?php endif; ?>	
		
		<?php if ($page['sidebar_first']): ?>
			<aside class="sidebar_first hidden-sm col-md-3">
				<?php print render($page['sidebar_first']); ?>
			</aside>
		<?php endif; ?>
		
			<div<?php if (($page['sidebar_first']) && ($page['sidebar_second'])) { ?> class="col-sm-12 col-md-6"<?php } else if (($page['sidebar_first']) || ($page['sidebar_second'])) {?> class="col-sm-12 col-md-9" <?php } else {?><?php } ?>>
				
				<div id="alert"></div>
								
				<?php if (isset($node) && $node->type == 'news_story') { // Hide Page title here for News Items render in node.tpl instead. 
				} else {
					print render($title_prefix);
						if ($title): ?><h1 id="wb-cont" property="name"><?php print $title; ?></h1><?php endif;
					print render($title_suffix);
				}
				
					if (!empty($tabs['#primary'])): ?><div class="tabs-wrapper clearfix"><?php print render($tabs); ?></div><?php endif;
					print render($page['content']); ?>
				
			</div>

			
		<?php if ($page['sidebar_second']): ?>
			<aside class="sidebar_second col-sm-12 col-md-3">
				<?php print render($page['sidebar_second']); ?>
			</aside>
		<?php endif; ?>
		
		
		<?php if ($page['content_bottom']): ?>
			<section class="content_bottom">
				<?php print render($page['content_bottom']); ?>
			</section>
		<?php endif; ?>
		</main>
		
		<footer role="contentinfo" id="wb-info" class="visible-md visible-lg wb-navcurr">
			<div class="container">
				<nav role="navigation" class="row">
				<h2>NovaScotia.ca Sections</h2>

				<?php if ($page['footer']): ?>
					<?php print render($page['footer']); ?>
				<?php endif; ?>
				</nav>
			</div>
			<div role="contentinfo" aria-label="copyright" class="copyright">
				<p><a href="/cns/privacy/">Privacy</a> 
				<a href="/terms/">Terms</a> 
				<a href="/cns/privacy/cookies/">Cookies</a> 
				Crown copyright © 2014, Province of Nova Scotia.</p>
			</div>
		</footer>