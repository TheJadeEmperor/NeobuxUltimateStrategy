<?php
//blog options
$popUp = 1; //popUp enabled
$useHTMLFile = true; //use html files
$imgBlog = $imgDir = $dir.'images/guide/';  
$X_img = '<img src="images/newsletter/X.jpg" alt="Neobux X" width="25px" />';

$url = $_GET['p']; 
$websiteURL = $val['websiteURL']; 
$postLink = $websiteURL.'/'.$url;

//referral links from links database
$csReferralLink = $context['links']['clixsenseReferralLink']; 
$clixsenseBannerImg = $context['links']['clixsenseBannerImg']; 
$subscribeLandingURL = $dir.'templates/redirect.php?url=ysense'; 
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
		global $popUp;
		$popUp = 1;
		echo popUpWindow($dir); 		
	?>	

	function validateEmail(email) {
		console.log(email);
		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{3,4})+$/.test(email)) {
			return true;
		} else {
			//alert("You have entered an invalid email address!");
			document.getElementById('error').innerHTML = '<p>You have entered an invalid email address!</p>';
			return false;
		}
	}

	function validateEmailPopup(email) { /* validation for email field */
		console.log(email); 
		if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{3,4})+$/.test(email)) {
			return true; 
		} else {
			document.getElementById('errorPopup').innerHTML = '<br />You have entered an invalid email address!';
			
			return false;
		}
	}
	</script>
	<script type="text/javascript">var switchTo5x=true;</script>
	<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>
	<script type="text/javascript">stLight.options({publisher:'67a0d44d-0b79-44c1-bb19-7f31f475d6fe'});</script>

</head>
<body>
	<!--<div class="sidebar"><br />
		<center>
			<span class="st_twitter_vcount" st_url="http://neobuxultimatestrategy.com" displayText="Tweet"></span>
			<span class="st_email_vcount" st_url="http://neobuxultimatestrategy.com" displayText="Email"></span>
			<span class="st_facebook_vcount" st_url="http://neobuxultimatestrategy.com" displayText="Facebook"></span>
			<span class="st_fblike_vcount" st_url="http://neobuxultimatestrategy.com" st_title="Neobux Ultimate Strategy" st_url="http://neobuxultimatestrategy.com" displayText="share"></span>
		</center>
	</div>-->

	<!-- Wrapper -->
	<div id="wrapper">

		<!-- Header -->
		<header id="header" class="alt">
			<span class="logo"><img src="<?=$dir?>images/guide/logo.svg" alt="Neobux Ultimate Strategy" /></span>
			<h1>Neobux Ultimate Strategy 3.0</h1>
			<p>The ultimate strategy to make money from Neobux and PTC sites<br />Contact us at our <a href="mailto:<?=$supportEmail?>">support email address</a>
			</p>
		</header>

		<!-- Nav -->
		<nav id="nav">
			<ul>
				<li><a href="./?action=posts" title="NUS Posts">All Posts</a></li>
				<li><a href="./?p=neobux-tips-make-money-neobux" title="Neobux Tips">Basic Tips</a></li>
				<li><a href="./?p=neobux-direct-referrals" title="Neobux Direct Referrals">Neobux Referrals</a></li>
				<li><a href="./?p=recycle-strategy-auto-recycle" title="Neobux Recycling Strategy">Recycling Strategy</a></li>
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