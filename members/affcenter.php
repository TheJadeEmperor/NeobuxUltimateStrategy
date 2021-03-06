<?php
//get all products to display 
$selP = 'SELECT * FROM products WHERE id in (2, 3, 5) ORDER BY itemName';
$resP = $conn->query($selP);

$cust = 0; //# of products they bought
while($p = $resP->fetch_array()) {
    $itemName = $p['itemName']; 
    $productID = $p['id'];

    $selS = 'SELECT *, date_format(purchased, "%m/%d/%y") AS purchased FROM sales WHERE (payerEmail="'.$_SESSION['login']['paypal'].'") AND productID="'.$p['id'].'"'; 
    $resS = $conn->query($selS); 
    
	if($p['id'] == '3')
		$isMiniSitesCustomer = 1;
	
    if(mysqli_num_rows($resS) == 0) { // not a customer 
        $downloadContent = 'You are not a customer of '.$itemName.'<br />
        <a href="'.$dir.$p['folder'].'" target="_BLANK">Click here to get it</a>';
    }
    else {
        $cust++;  //# of products they bought
    } 

    if($p['itemPrice'] == 0) { //free gift - download is available
    
        $downloadContent  = $itemName.' is a free product <br />
        The product was last updated on '.date('m/d/Y', time()-2592000).' <br />
        Click below to download the latest version of '.$itemName.' <br />
        <center>
        <form method="POST">
        <p><input type="submit" name="dl" class="downloadNow" value=" Download Now "></p>
        <input type="hidden" name="id" value="'.$p['id'].'">
        <input type="hidden" name="url" value="'.$p['download'].'">
        </form></center>';
    } // if($p['itemPrice'] == 0)
    else if(mysqli_num_rows($resS) > 0) { //sale
        $sale = $resS->fetch_array();

        //multiple downloads
        $selD = 'SELECT * FROM downloads WHERE productID="'.$productID.'" ORDER BY name';
        $resD = $conn->query($selD);

        if(mysqli_num_rows($resD) > 0) { //multiple downloads
        
            $downloadContent = '<table>
                <tr>
                    <td>You bought the product on '.$sale['purchased'].' </td>
                </tr>';
            while($d = $resD->fetch_array()) {
            
                $downloadContent .= '<tr>
                <td>'.$d['name'].'</td>
                <td>
                    <form method="POST"><input type="submit" name="dl" class="downloadNow" value=" Download "/>
                    <input type="hidden" name="url" value="'.$d['url'].'" /></form>
                </td>';
            }    
            $downloadContent .= '</table>';
        } // if(mysqli_num_rows($resD) > 0)
        else { //single download 
            $downloadContent = 'You bought the product on '.$sale['purchased'].' <br />
            The product was last updated on '.date('m/d/Y', time()-2592000).' <br />
            Click below to download the latest version of '.$itemName.' <br />
            <center>
            <form method="post">
            <p><input type="submit" name="dl" class="downloadNow"  value=" Download Now "></p>
            <input type="hidden" name="id" value="'.$p['id'].'">
            <input type="hidden" name="url" value="'.$p['download'].'">
            </form></center>';
        } // else 
    } // else if(mysqli_num_rows($resS) > 0)

    echo '<div class="moduleGradient"><h1>'.$p['itemName'].'</h1>
	<div>
    '.$downloadContent.'
    </div></div><br />'; 
} //while($p = $resP->fetch_array()) 

?>
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

<?
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

	<p>Interested? Curious? Want to find out more? Go on to our <a href="http://neobuxultimatestrategy.com/minisite">mini site page</a></p>
</div>
</div>

<?
}

echo '<p>&nbsp;</p><center>'.$adContent.'</center>';
?>
<p>&nbsp;</p>
<p>&nbsp;</p>