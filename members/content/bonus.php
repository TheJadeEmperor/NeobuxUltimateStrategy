<?php
$bonusDir = 'images/members/';

$bonusProducts = array(
    'Mr. S PTC Course' => array(
        'img' => $bonusDir.'bonus-ptc-course.jpg',
        'dl' => '../../../../products/bonus/Santanderinos-PTC-Course.pdf',
        'desc' => 'This PTC guide, written by Mr. S. It is a detailed step by step guide on how to find the right PTC to join and where to get referral sign ups.'
    ), 
    'Paypal Booster' => array(
        'img' => $bonusDir.'bonus-ppbooster.jpg',
        'dl' => '../../../../products/bonus/Make-$18K-in-30-Days.pdf',
        'desc' => 'Make money from Neobux & Clixsense using our turn-key system'
    ),
	'Make Money Surveys' => array(
        'img' => $bonusDir.'bonus-mms.jpg',
        'dl' => '../../../../ebooks/bonus/MakeMoneySurveys.pdf',
        'desc' => 'Make $5 to $75 per survey'
    ),
    'PTC Beginners Course' => array(
        'img' => $bonusDir.'bonus-ptc-beginners-course.jpg',
        'dl' => '../../../../products/bonus/PTC-Beginners-Course.pdf',
        'desc' => 'The PTC Beginners Course shows you how to get started with PTCs'
    ),
	'PTC Crash Course' => array(
        'img' => $bonusDir.'bonus-ptc-crash-course.jpg',
        'dl' => '../../../../products/bonus/PTCCrashCourse.zip',
        'desc' => 'This ebook shows you make money with PTCs fast and different ways to make money from PTCs without clicking on ads'
    ),
    'Clixsense Report' => array(
        'dl' => '../../../../products/bonus/The-Clixsense-Report.pdf',
        'img' => $bonusDir.'bonus-clixsense-report.jpg',
    ),
	'Referral Blueprint' => array(
        'dl' => '../../../../products/bonus/Referral-Blueprint.pdf',
        'img' => $bonusDir .'bonus-referral-blueprint.jpg',
    ),
	'PTC Referral Secrets' => array(
        'dl' => '../../../../products/bonus/PTC-Referral-Secrets.pdf',
        'img' => $bonusDir.'bonus-ptc-referral-secrets.jpg',
    ),
); 

$premiumBonuses = array(
    'Rich PTC Kid' => array(
        'dl' => '../../../../products/bonus/RichPTCKid.pdf',
        'img' => $bonusDir.'bonus-rich-ptc-kid.jpg',
    ),
    'PTC Riches' => array(
        'dl' => '../../../../products/bonus/PTC-Riches.pdf',
        'img' => $bonusDir.'bonus-ptc-riches.jpg',
    ),
    'PTC Income Today' => array(
        'dl' => '../../../../products/bonus/PTC-Income-Today.pdf',
        'img' => $bonusDir.'bonus-ptc-income-today.jpg',
    ),
    'PTC Insider Secrets' => array(
        'dl' => '../../../../products/bonus/PTC-Insider-Secrets.pdf',
        'img' => $bonusDir.'bonus-ptc-insider-secrets.jpg',
    ),
	'Ultimate Traffic Monster' => array(
        'dl' => '../../../../products/bonus/UltimateTrafficMonster.zip',
        'img' => $bonusDir.'bonus-ultimate-traffic-monster.jpg',
    ),
);


$productID = 3; //PTC Mini Site

$selS = 'SELECT *, date_format(purchased, "%m/%d/%y") AS purchased FROM sales WHERE (payerEmail="'.$_SESSION['login']['paypal'].'") AND productID="'.$productID.'"';
$resS = $conn->query($selS);

if(mysqli_num_rows($resS) == 0){
    $vipBonus = 0;
}
else {
    $vipBonus = 1;
}
?>

<p>&nbsp;</p>
    
<h1>Bonus Downloads</h1>
<hr color="#25569a" size="4" />
<p>&nbsp;</p>

<center>
    <?php
    $count = 0;
    foreach($bonusProducts as $name => $val) {
        
        if(empty($val['width'])) $width = '150px';
        else $width = $val['width'];
        
        $tableRows .= '<tr>
            <td align="center">
                <form method="POST">
                <button type="submit" name="dl" value="dl"><img src="'.$dir.$val['img'].'" width="'.$width.'" /></button>	
                <input type=hidden name="url" value="'.$val['dl'].'" />
                </form>
            </td>
            <td>
                <h3>'.$name.'</h3>
				<p>'.$val['desc'].'</p>
            </td>
        </tr>
        ';

        if($count < sizeof($bonusProducts)-1)
        $tableRows .= '<tr>
            <td colspan="2"><hr /></td></tr>';
        
       $count++;
    }
    
    echo '<table class="bonus">'.$tableRows.'</table>'
    ?>
    
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    

    <h1>Premium Bonuses</h1>
    <hr color="#25569a" size="4" />

    
    <p>These bonuses are for PTC Mini-Site customers only</p>
        
    <p>&nbsp;</p>     
    
    <?php
    $tableRows = ''; 
    $count = 0;
    foreach($premiumBonuses as $name => $val) {
    
        if($vipBonus == 0) {
            $val['desc'] = '<a href="'.$websiteURL.'minisite">Click here to get PTC Mini-Sites</a>';
            $thumb = '<img src="'.$dir.$val['img'].'" />';
        }
        else {
            $thumb = '<form method="POST">
                 <button type="submit" name="dl" value="dl"><img src="'.$dir.$val['img'].'" width="'.$width.'" />	
                <input type=hidden name="url" value="'.$val['dl'].'" />
                </form>';
        }
        
        if(empty($val['width'])) $width = '150px';
        else $width = $val['width'];
        
        $tableRows .= '<tr>
            <td align="center">
                '.$thumb.'
            </td>
            <td>
                <h3>'.$name.'</h3>
                <p>'.$val['desc'].'</p>
            </td>
        </tr>
        ';

        if($count < sizeof($premiumBonuses)-1)
        $tableRows .= '<tr>
            <td colspan="2"><hr /></td></tr>';
        
       $count++;
    }
    
    echo '<table class="bonus">'.$tableRows.'</table>';
    ?>
    
    <p>&nbsp;</p>
    
</center>
<p>&nbsp;</p>
<p>&nbsp;</p>