<?php
	global $base_url;
	$theme_base = $base_url . '/' . drupal_get_path('theme', $GLOBALS['theme']);
	$secure = 'http' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : '') . '://';
    $theme_base = str_replace('http://', $secure, $theme_base);
    header("X-UA-Compatible: IE=edge");
?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php print $head_title; ?></title>
	<meta content="width=device-width, initial-scale=1" name="viewport"/>
	<meta name="HandheldFriendly" content="True" />
	<meta name="MobileOptimized" content="320" />
	<meta name="description" content="The official website for the province of Nova Scotia includes resources for people and business, information on government programs and tourism, news releases as well as links to all government departments and agencies." />
	<meta name="dcterms.creator" content="Communications Nova Scotia" />
	<meta name="dcterms.title" content="Government of Nova Scotia" />
	<meta name="dcterms.issued" title="W3CDTF" content="2014-10-20" />
	<meta name="dcterms.modified" title="W3CDTF" content="2014-10-20" />
	<meta name="dcterms.subject" title="scheme" content="Nova Scotia; Employment; Travel; Immigration; Citizenship; Maritime Provinces; Acadian; Agriculture; Aquaculture; Communities; Culture; Community Services; Economic Development; Education; Energy; Environment; Finance; Fisheries; Gaelic; Heritage; Health; Justice; Labour; Legislature; Museums; Natural Resources; Procurement; Public Service; Seniors; Transportation; Tenders; Vital Statistics; Workers Compensation" />
	
	<?php print $styles; ?>
	
<!-- / From WET -->
	<link rel="stylesheet" href="<?php echo $theme_base; ?>/css/wet-boew.css"/> 
	<link rel="stylesheet" href="<?php echo $theme_base; ?>/css/theme.css" />
	<!--[if lt IE 9]>
	<link rel="stylesheet" href="<?php echo $theme_base; ?>/css/ie8-wet-boew.css" />
	<link rel="stylesheet" href="<?php echo $theme_base; ?>/css/ie8-theme.css" />
	<script src="<?php echo $theme_base; ?>/js/jquery-1.11.1.js"></script>
	<script src="<?php echo $theme_base; ?>/js/ie8-wet-boew.js"></script>

	<script type="text/javascript">
$(function(){		
	if(!document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#Shape", "1.0")){
		var imgs = $('img'),
			endsWithDotSvg = /.*\.svg$/,
			l = imgs.length;
		for(var x = 0; x !== l; ++x) {
			if(imgs[x].src.match(endsWithDotSvg)) {
				imgs[x].src = imgs[x].src.slice(0, -3) + 'png';
			}
		}
	}

});		
	</script>
	
	<![endif]-->

	<noscript><link rel="stylesheet" href="<?php echo $theme_base; ?>/css/noscript.css"/></noscript>
<!-- / From WET -->

<!-- From Chester -->
	<link rel="stylesheet" href="<?php echo $theme_base; ?>/fonts/fonts.css" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $theme_base; ?>/css/twitterfeed.css" />
	<link href="<?php echo $theme_base; ?>/assets/favicon.ico" rel="icon" type="image/x-icon"/>
	
<!-- / From Chester -->
		
</head>
<body <?php if ($is_front): ?> class="front"<?php endif;?> vocab="http://schema.org/" typeof="WebPage">
	<?php print $page_top; ?>

	<?php print $page; ?>

	<?php print $page_bottom; ?>
	
	<?php print $scripts; ?>

<!-- INSERT GOOGLE ANALYTICS TRACKING CODE -->
	
<!--[if gte IE 9 | !IE ]><!-->
<script src="<?php echo $theme_base; ?>/js/jquery-2.1.1.js"></script>
<script src="<?php echo $theme_base; ?>/js/wet-boew.js"></script>
<!--<![endif]-->

<!--[if lt IE 9]>
<script src="<?php echo $theme_base; ?>/js/ie8-wet-boew2.js"></script>
<![endif]-->

<script src="<?php echo $theme_base; ?>/js/twitterfeed.js"></script>
</body>
</html>
