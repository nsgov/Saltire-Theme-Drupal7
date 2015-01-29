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
		
	        <?php if ($messages): ?>
	          <div id="console" class="clearfix"><?php print $messages; ?></div>
	        <?php endif; ?>
	
	        <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>    		
		
		<?php if ($page['content_top']): ?>
			<section class="content_top">
				<?php print render($page['content_top']); ?>
			</section>
		<?php endif; ?>	
		
		<?php if ($page['sidebar_first']): ?>
			<aside class="sidebar_first hidden-xs hidden-sm col-md-3">
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
				
					if (!empty($tabs['#primary'])): ?><div class="tabs-wrapper clearfix">
					
					<?php print render($tabs); ?></div><?php endif;
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
				<?php if ($page['footer']): ?>
					<div class="local">
							<?php print render($page['footer']); ?>
					</div>
				<?php endif; ?>
			<div class="container">
				<section>
					<nav role="navigation" aria-label="global-navigation" class="row">
					<h2>NovaScotia.ca Sections</h2>
					<div class="row"><div class="col-sm-9 col-lg-9"><section class="col-sm-6 col-lg-4"><h3>Government</h3><ul class="list-unstyled"> <li><a href="http://novascotia.ca/government/"  class="gl-footer">Locations, Depts, Agencies</a></li> <li><a href="https://novascotia.ca/contact/#phone" class="gl-footer">Phone numbers</a></li><li><a href="http://nslegislature.ca/">Legislature</a></li> </ul> </section> <section class="col-sm-6 col-lg-4"> <h3>Residents</h3> <ul class="list-unstyled"> <li><a href="http://novascotia.ca/snsmr/access/" class="gl-footer">Access Nova Scotia</a></li> <li><a href="http://511.gov.ns.ca/en/" class="gl-footer">Road conditions - 511</a></li> <li><a href="http://novascotia.ca/tran/cameras/" class="gl-footer">Highway webcams</a></li> </ul> </section> <section class="col-sm-6 col-lg-4"> <h3>Visitors</h3> <ul class="list-unstyled"> <li><a href="http://www.novascotia.com/">Official Travel site</a></li> <li><a href="https://museum.novascotia.ca/our-museums">Museums</a></li> <li><a href="http://parks.gov.ns.ca/">Provincial Parks</a></li> </ul> </section> <section class="col-sm-6 col-lg-4"> <h3>Business</h3> <ul class="list-unstyled"> <li><a href="http://business.novascotia.ca/en/home/default.aspx">Doing Business in NS</a></li><li><a href="http://novascotia.ca/snsmr/access/business/bizpal.asp">Licences and Permits (BizPaL)</a></li> </ul> </section> <section class="col-sm-6 col-lg-4"> <h3>Health care</h3> <ul class="list-unstyled"> <li><a href="http://811.novascotia.ca/">Speak to a nurse - 811</a></li> <li><a href="http://www.cdha.nshealth.ca/maps?category=Hospital&amp;title=">Hospitals/ERs</a></li> <li><a href="http://www.doctorsns.com/en/home/yourhealth/walk-in-clinics.aspx">Clinics</a></li>	 </ul> </section> </div> <div class="col-sm-3 col-lg-3 brdr-lft"><section> <h3>About Nova Scotia</h3> <p><a href="http://novascotia.ca/about/">General information</a></p> </section> <section> <h3>Contact us</h3> <p><a href="https://novascotia.ca/contact/">Contact novascotia.ca</a></p> </section> <section> <h3>Social media</h3> <p><a href="http://novascotia.ca/connect/">Government accounts</a></p> </section></div></nav>
				</section>
			</div>

			<div role="contentinfo" aria-label="copyright" class="copyright">
				<p><a href="/cns/privacy/">Privacy</a> 
				<a href="/terms/">Terms</a> 
				<a href="/cns/privacy/cookies/">Cookies</a> 
				Crown copyright © 2014, Province of Nova Scotia.</p>
			</div>
		</footer>
