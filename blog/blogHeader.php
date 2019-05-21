<?php

function popUpWindow($dir) {
    return '
    var seconds = 15; 
    var milliseconds = seconds * 1000; 
setTimeout("javascript:TINY.box.show({url:\''.$dir.'splash/popUp.php\',width:780,height:525,openjs:\'initPopupLogin\',opacity:30});", milliseconds);'; 
}

$url = $_GET['p']; 
$websiteURL = $val['websiteURL']; 
$postLink = $websiteURL.'/'.$url;

//blog options
$popUp = 1;
$imgBlog = $imgDir = $dir.'images/guide/';  
$X_img = '<img src="images/newsletter/X.jpg" alt="Neobux X" width="25px" />';
$useHTMLFile = true; 
$referralLink = 'https://www.clixsense.com/?3373459&blog'; 
$redirLink = 'https://neobuxultimatestrategy.com/redirect.php?action='; 
$subscrLandingURL = $redirLink.'clixsense';
$confirmLandingURL = $redirLink.'clixsense'; 
?>
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
	
	<link rel="stylesheet" href="include/css/popup.css" type="text/css" />
	<link rel="stylesheet" href="include/blog/assets/css/blog.css" type="text/css" />

	<script type="text/javascript" src="include/js/jquery.js"></script>
	<script type="text/javascript" src="include/js/popup.js"></script>
	<script type="text/javascript">
	function linkTo(url) {
		window.open(url);
	}
	<?php
	if($popUp) {
		if($_SESSION['popUp'] < 1)
			echo popUpWindow($dir); 
		$_SESSION['popUp'] = 1;
	}
	
	?>
	</script>
	<script type="text/javascript">var switchTo5x=true;</script>
	<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>
	<script type="text/javascript">stLight.options({publisher:'67a0d44d-0b79-44c1-bb19-7f31f475d6fe'});</script>

	
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
	  (adsbygoogle = window.adsbygoogle || []).push({
		google_ad_client: "ca-pub-9979225970120201",
		enable_page_level_ads: true
	  });
	</script>
	
	<style>
		img, img.referralProof {
			max-width: 600px;
		}
		
		.stButton .stBubble {
			height: 29px !important;
		}
		
		#chitika_leaderboard {
			text-align: center;
			margin-bottom: 40px;
		}
	</style>
</head>
<body>
	<!-- Wrapper -->
	<div id="wrapper">

		<!-- Header -->
		<header id="header" class="alt">
			<span class="logo"><img src="include/blog/images/logo.svg" alt="" /></span>
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
				<li><a href="./?p=neobux-direct-referrals" title="Neobux Direct Referrals">Neobux Referrals</a></li>
				<li><a href="./?p=recycling-strategy" title="Neobux Recycling Strategy">Recycling Strategy</a></li>
				<li><a href="./?p=best-paying-ptc-sites" title="Best PTC Sites">PTC Sites</a></li>	
			</ul>
		</nav>

		<!-- Main -->
		<div id="main">

			<!-- Introduction -->
			<section id="intro" class="main">
				<div class="spotlight">
					
					<div class="content">
						<footer class="bothSides">
							<section class="leftContent">