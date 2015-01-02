<?php
	global $base_url;
	$theme_base = $base_url . '/' . drupal_get_path('theme', $GLOBALS['theme']);
	$secure = 'http' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : '') . '://';
    $theme_base = str_replace('http://', $secure, $theme_base);
?>
<!-- From WET -->
<!DOCTYPE html>
<!--[if lt IE 9]><html class="no-js lt-ie9" lang="en" dir="ltr"><![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en" dir="ltr">
<head>
<meta charset="utf-8"/>
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

	<!--[if gte IE 9 | !IE ]><!--> <link href="<?php echo $theme_base; ?>/assets/favicon.ico" rel="icon" type="image/x-icon"/>
	<link rel="stylesheet" href="<?php echo $theme_base; ?>/css/wet-boew.css"/> <!--<![endif]-->

	<!--[if lt IE 9]>
	<link href="<?php echo $theme_base; ?>/assets/favicon.ico" rel="shortcut icon" />
	<link rel="stylesheet" href="<?php echo $theme_base; ?>/css/ie8-wet-boew.css" />
	<![endif]-->

	<noscript><link rel="stylesheet" href="<?php echo $theme_base; ?>/css/noscript.css"/></noscript>
<!-- / From WET -->

<!-- From Chester -->
	<link rel="stylesheet" href="<?php echo $theme_base; ?>/fonts/fonts.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $theme_base; ?>/css/style.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo $theme_base; ?>/css/theme.css"/>
	<link rel="stylesheet" href="<?php echo $theme_base; ?>/css/news.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo $theme_base; ?>/css/mediaviewer.css" type="text/css" media="all" />

	<?php
		if (user_access('administer site configuration')) {
			print $styles;
		}
	?>
	
	<link href="<?php echo $theme_base; ?>/favicon.ico" rel="icon" type="image/x-icon" />
<!-- / From Chester -->
		
</head>
<body <?php if ($is_front): ?> class="front"<?php endif;?> vocab="http://schema.org/" typeof="WebPage">
	<?php print $page_top; ?>

	<?php print $page; ?>

	<?php print $page_bottom; ?>
	
	<?php
		if (user_access('administer site configuration')) {
			print $scripts;
		}
	?>

	<!-- INSERT GOOGLE ANALYTICS TRACKING CODE -->
		<!--[if gte IE 9 | !IE ]><!-->
<script src="<?php echo $theme_base; ?>/js/jquery-2.1.1.js"></script>
<script src="<?php echo $theme_base; ?>/js/wet-boew.js"></script>
<!--<![endif]-->
<!--[if lt IE 9]>
<script src="<?php echo $theme_base; ?>/js/jquery-1.11.1.js"></script>
<script src="<?php echo $theme_base; ?>/js/ie8-wet-boew2.js"></script>
<![endif]-->
</body>
</html>
