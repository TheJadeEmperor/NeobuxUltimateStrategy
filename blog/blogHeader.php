<!DOCTYPE HTML>
<html>
	<head>
		
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		
		<title><?=$meta['title']?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="<?=$meta['tags']?>">
		<meta name="description" content="<?=$meta['desc']?>">
		<meta property="og:type" content="article" />
		<meta property="og:title" content="<?=$meta['title']?>" />
		
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="blog/assets/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		
		<link rel="stylesheet" href="include/css/popup.css" type="text/css" />
		
		<script type="text/javascript" src="include/js/jquery.js"></script>
		<script type="text/javascript" src="include/js/popup.js"></script>
		<script type="text/javascript">
		function linkTo(url) {
			window.open(url);
		}
		<?
		if($popUp) {
			if($_SESSION['popUp'] < 1)
				echo popUpWindow($dir); 
			$_SESSION['popUp'] = 1;
		}
		?>
		</script>
		<script type="text/javascript">var switchTo5x=true;</script>
		<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
		<script type="text/javascript">stLight.options({publisher:'67a0d44d-0b79-44c1-bb19-7f31f475d6fe'});</script>

	</head>
	<body>

		<!-- Wrapper -->
		<div id="wrapper">

			<!-- Header -->
			<header id="header" class="alt">
				<span class="logo"><img src="blog/images/logo.svg" alt="" /></span>
				<h1>Neobux Ultimate Strategy 3.0</h1>
				<p>The ultimate strategy to make money from Neobux and PTC sites<br />
					Contact us at our <a href="mailto:<?=$supportEmail?>">support email address</a>
				</p>
			</header>

			<!-- Nav -->
			<nav id="nav">
				<ul>
					<li><a href="./?action=posts" title="NUS Posts">All Posts</a></li>
					<li><a href="./?p=neobux-tips-make-money-neobux" title="Neobux Tips">Basic Tips</a></li>
					<li><a href="./?p=neobux-direct-referrals" title="Neobux Direct Referrals">Referrals</a></li>
					<li><a href="./?p=recycling-strategy" title="Neobux Recycling Strategy">Recycling</a></li>
					<li><a href="./?p=best-paying-ptc-sites" title="PTC Sites">PTC Sites</a></li>	
				</ul>
			</nav>

			<!-- Main -->
			<div id="main">

				<!-- Introduction -->
				<section id="intro" class="main">
					<div class="spotlight">
						<div class="content">