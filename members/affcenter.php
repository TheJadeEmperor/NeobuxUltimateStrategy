<?php

$selN = 'SELECT *, date_format(purchased, "%m/%d/%y") AS purchased FROM sales WHERE (payerEmail="'.$_SESSION['login']['paypal'].'") AND productID="5"'; 
$resN = $conn->query($selN); 

$n = $resN->fetch_array();
$nPurchase = $n['purchased']; 

$downloadContent = '<div class="moduleGradient"><h1>Neobux Basics</h1>
<div>Neobux basics is a free product <br />
The product was last updated on '.date('m/d/Y', time()-2592000).' <br />
Click below to download the latest version of Neobux Basics <br />
<center>
<form method="POST">
<p><input type="submit" name="dl" class="downloadNow" value=" Download Now "></p>
<input type="hidden" name="id" value="2">
<input type="hidden" name="url" value="'.$p['download'].'">
</form></center></div></div><br />

<div class="moduleGradient"><h1>NUS Membership</h1>
<div>You bought the NUS Membership on '.$nPurchase.'
<table><tr>
    <td>
    Neobux Ultimate Strategy</td><td><a href="./?action=chapter1"><input type="button" name="dl" class="downloadNow" value=" View Now "></a></td>
</tr><tr>
<td>
    NUS Video Course</td><td><a href="./?action=video1"><input type="button" name="dl" class="downloadNow" value=" View Now "></a>
</td>
</tr></table>
</div></div><br />

<div class="moduleGradient"><h1>PTC Mini-Sites</h1>
    <div>
';

if($isMiniSitesCustomer != 1) {

    $downloadContent .= 'You are not a client of the PTC Mini-Sites';
} 
else {
    $downloadContent .= 'You bought the PTC Mini-Sites on '.$mPurchase;
}

$downloadContent .= '</div></div>';

echo $downloadContent;

 
?>
<p>&nbsp;</p>
<h1>Members Home</h1>
<hr color="#25569a" size="4" />

<p>&nbsp;</p>
<p>You should begin by reading the NUS chapters. Then watch the step by step instructional videos on the videos page. Also check out the bonuses section as we make monthly updates to our bonuses. Begin reading here: </p>

<br />
<div id="chapterTitles">
	<p><img src="images/redArrow.png"> <a href="./?action=chapter1">Chapter 1: Introduction</a></p>
	<p><img src="images/redArrow.png"> <a href="./?action=chapter2">Chapter 2: Free Direct Referrals</a></p>
	<p><img src="images/redArrow.png"> <a href="./?action=chapter3">Chapter 3: Paid Direct Referrals</a></p>
	<p><img src="images/redArrow.png"> <a href="./?action=chapter4">Chapter 4: Building A List</a></p>
	<p><img src="images/redArrow.png"> <a href="./?action=chapter5">Chapter 5: Capture Pages</a></p>
	<p><img src="images/redArrow.png"> <a href="./?action=chapter6-7">Chapter 6 & 7: Conclusion</a></p>
	<p><img src="images/redArrow.png"> <a href="./?action=video1">Videos Part 1</a></p>
	<p><img src="images/redArrow.png"> <a href="./?action=video2">Videos Part 2</a></p>
</div>

<p>&nbsp;</p>

<p>As a valued customer of the NUS, we have some special offers for you. Please see below to access your bonus offers!</p>

<p>&nbsp;</p>

<?php
if($isMiniSitesCustomer != 1) {
?>

<div class="moduleGradient">
<h1>Special Limited Time Offer</h1>
<div>
	<p>Ever wanted to have your own website focused on PTC's but never had the time or could never afford it? Well throw those excuses away, because PTC Mini-Sites are here. It's an offer exclusive to only customers and affiliates of our products. </p>

	<p>We'll make you a PTC website with your own domain name - so you can promote all your PTC's with one link. </p>

	<p>In a nutshell, here's what you'll get: </p>

	<ul>
		<li>Small One Time Fee & Free Hosting</li>

		<li>Promote All Your Sites with Your Own Unique URL</li>
	 
		<li>Unlimited Lifetime Updates for Free </li>
	 
		<li>Quality & Quickness - Satisfaction Guaranteed!</li>

		<li>Keep Your Files Forever</li>

		<li>And much, much, more!</li>
	</ul>

	<p>Interested? Curious? Want to find out more? Go on to our <a href="<?=$websiteURL?>minisite">mini site page</a></p>
</div>
</div>

<?php
}

echo '<p>&nbsp;</p><center>'.$adContent.'</center>';
?>
<p>&nbsp;</p>
<p>&nbsp;</p>