<?php
$adir = '../';
include($adir.'adminCode.php');

$emailDownloadTemplate = '<p>Hi $firstName, </p> <p>Thank you for your purchase of $itemName. Everybody wants to make money online but most of them are not willing to do what it takes. By getting this product you have shown that you are different than the others who do not take any action.</p> <p>You are on your way to profitting with PTC\'s. Only one more step left. Just go to the download link below to download your copy of $itemName.</p> <p>The following information are your purchase details, sent from paypal:</p> <p>Txn ID:  $transID <br />Paypal Email:  $payerEmail<br />Item Name:  $itemName<br />Item #:  $itemNumber<br />Payment Amount:  $itemPrice</p> <p>This is an automatically generated message from our system regarding your order from us. If the status is "Completed", that means your order went through, and you may download your the $itemName immediately. If not, then please wait for the payment to be completed.</p> <p>You can download the product through this link:</p> <p><strong>$downloadLink</strong></p> <p>Just go to the link to download the product. Enjoy!</p> <p> </p> <p>Sincerely,</p> <p>Your Name<br />Company Name <br /><a href="mailto:your@email.address">your@email.address</a></p>';

$emailWelcomeTemplate = '<p>Hi $firstName,</p> <p>Thank you for signing up to the $itemName affiliate program. There is no better time to get started than right now! With $itemName you get to make $salesPercent% commission of your sales.</p> <p>Here are your details from registration: <br />Username: $nickname<br />Password: $password<br />Paypal Email: $paypal<br />Contact Email: $email</p> <p>Our affiliate program is different than other ones you are used to, as it is unique in many ways. For starters, you will be paid directly from the customer on $salesPercent% of your sales. No waiting 30 to 60 days for payments - that\'s way too slow. This means the money will be sent to your Paypal account immediately.</p> <p>To log in to your account, just go to: <br />http://bestpayingsites.com/members <br />and put in your username and password.</p> <p>Welcome aboard.</p> <p>Your Name<br />Business Name<br />your@email.address<br />your@email.address</p>';

//check for errors
if($_POST)
{
	if($_POST[itemName] == '')
		$error .= 'Please fill in Item Name <br>';

	if($_POST[itemPrice] == '')
		$error .= 'Please fill in Item Price <br>';
    
    if($_POST[expires] == '')
        $error .= 'Please fill in expiration time <br />';
}

$dbFields = array(
	'itemName' => $_POST[itemName],
	'itemNumber' => $_POST[itemNumber],
	'itemPrice' => $_POST[itemPrice],
	'folder' => $_POST[folder],
	'download' => $_POST[download],
	'expires' => $_POST[expires], 
	'keywords' => $_POST[keywords],
	'description' => $_POST[description],
	'affProgram' => $_POST[affProgram], 
	'affcenter' => $_POST[affcenter],
	'salesPercent' => $_POST[salesPercent],
    'upsellID' => $_POST[upsellID],
	'oto' => $_POST[oto],
	'otoName' => $_POST[otoName],
	'otoNumber' => $_POST[otoNumber],
	'otoPrice' => $_POST[otoPrice], 
	'header' => $_POST[header], 
	'footer' => $_POST[footer],
	'salespage' => $_POST[salespage]
	);

$opt = array(
'tableName' => 'products',
'dbFields' => $dbFields);

	
if($_POST[add])
{
    $viewOpt = array(
        'tableName' => 'pageviews',
        'dbFields' => array(
            'page' => '/'.$_POST[itemName],
            'uniqueViews' => '0',
            'rawViews' => '0',
        )
    );
    
	if($error)
	{
		$p = $_POST; 
	}
    else 
    {
        $res = dbInsert($opt); 
        
        $newID = mysql_insert_id();
        
        //purchase confirmation email / download email
        $emailDownloadOpt = array(
            'tableName' => 'emails',
            'dbFields' => array(
                'productID' => $newID,
                'type' => 'download',
                'subject' => '$itemName Purchase Confirmation [Download Link]',
                'message' => $emailDownloadTemplate) 
        ); 
        
        $emailWelcomeOpt = array(
            'tableName' => 'emails',
            'dbFields' => array(
                'productID' => $newID,
                'type' => 'welcome',
                'subject' => 'Welcome to the Affiliate Program - PTC Crash Course',
                'message' => $emailWelcomeTemplate)
        ); 
    
        //add view
        dbInsert($viewOpt); 
        
        //add emails
        dbInsert($emailDownloadOpt); 
        dbInsert($emailWelcomeOpt); 

        echo '<meta http-equiv="refresh" content="1;url=productNew.php?id='.$newID.'">';        
    }
		
}
else if($_POST[update])
{
	$set = array(); 
	
	foreach($dbFields as $fld => $val)
	{
		array_push($set, $fld.'="'.addslashes($val).'"');
	} 
	
	$theSet = implode(',', $set);
	
	$upd = 'update products set '.$theSet.' where id="'.$_GET[id].'"';
	$res = mysql_query($upd) or die(mysql_error());
}

if($_GET[id])
{
    $id = $_GET[id];
	$selP = 'select * from products order by id';
	$resP = mysql_query($selP) or die(mysql_error());
    
    while($item = mysql_fetch_assoc($resP)) {
            
        if($id == $item[id]) {
            $p = $item;
            $aff[ $p[affProgram] ] = 'selected';
            $payment[ $p[payment] ] = 'selected';
            $oto[ $p[oto] ] = 'selected';
            $aPercent[ $p[salesPercent] ] = 'selected';
            $jPercent[ $p[jvPercent] ] = 'selected';
            $affcenter[ $p[affcenter] ] = 'selected'; 
        }
    
        $products[] = $item; 
    }
    
    foreach($products as $prod) {
        $select = '';
        if($p[upsellID] == $prod[id]) {
            $select = 'selected'; 
            $u = $prod; 
        }
        
        $upsellDropDown .= '<option value="'.$prod[id].'" '.$select.'>'.$prod[itemName].'</option>';
    }

    if($_POST[delete])
    {
        $delP = 'delete from products where id="'.$id.'"';
        mysql_query($delP, $conn) or die(mysql_error());
        
        $delV = 'delete from pageviews where page="/'.$p['itemName'].'"';
        mysql_query($delV, $conn) or die(mysql_error());
        
        $delE = 'delete from emails where productID="'.$id.'"';
        mysql_query($delE, $conn) or die(mysql_error());
        
        $error = 'Successfully deleted product '.$p['itemName'];
    }

	$disAdd = 'disabled';
}
else
{
	$disUpd = 'disabled';
}


//aff program disabled
if($p[affProgram] == 'N')
{
    $affProgramDis = 'disabled';
    $fieldClass = '';
}
else {
	$fieldClass = 'class="activeField"';
}

?>

<form method=post>
<div class="moduleBlue"><h1>General Info</h1>
	<div class="moduleBody">
	<font color=red><b><?=$error?></b></font>
	<table>
	<tr valign=top>
		<td>Item Name *</td>
		<td>
		    <div title="header=[Product Name or Item Name] body=[Name of the product, 100 characters max] "><img src="<?=$helpImg?>" />
		    <input class="activeField" name=itemName value="<?=$p['itemName']?>" size=40>
	        </div>
	    </td>
	</tr>
	<tr valign=top>
		<td>Price (USD) *</td>
		<td>       
		    <div title="header=[Item Price] body=[Price of product, numbers and decimal points only <br>
		        Ex: 1.00 or 1] "><img src="<?=$helpImg?>" />
		        <input class="activeField" name=itemPrice value="<?=$p['itemPrice']?>">
		    </div>
	    </td>
	</tr>
	<tr valign=top>
		<td>Item #</td>
		<td>       
		    <div title="header=[Item number] body=[Optional, item # is for tracking purposes] "><img src="<?=$helpImg?>" />
		        <input class="activeField" name=itemNumber value="<?=$p[itemNumber]?>">
		    </div>
	    </td>
	</tr>
	<tr valign=top>
		<td>Product Folder</td>
		<td>
	        <div title="header=[Product Folder] body=[Folder where product files are located in the website server, no slashes <br />If the folder is www.website.com/product1 <br /> Put in product1]"><img src="<?=$helpImg?>" />
	            <input class="activeField" name=folder value="<?=$p['folder']?>">
	            <a href="../../<?=$p['folder']?>" target="_blank">Visit Link</a>
	        </div>        
	    </td>
	</tr>
	<tr valign=top>
		<td>Download Link</td>
		<td>
	        <div title="header=[Download link] body=[Location of file to be downloaded] "><img src="<?=$helpImg?>" />
		    <input class="activeField" name=download value="<?=$p[download]?>" size=50> <br />
			<a href="productDownloads.php?id=<?=$id?>" style="margin-left: 20px">Click here to Manage Downloads</a> 
	    	</div>	
		</td>
	</tr>
	<tr valign=top>
		<td>Expiration (Download file) *</td>
		<td>
	        <div class=".left" title="header=[Download Expiration Date] body=[When will the download link expire, in hours] "><img src="<?=$helpImg?>" />
		    <input class="activeField" name=expires value="<?=$p[expires]?>">
	    	</div>
	    </td>
	</tr>
	<tr valign="top">
		<td>SEO Keywords</td>
		<td>
		    <div title="header=[Product keywords] body=[Keywords that describe the product, for seo purposes. Separate each keyword phrase with a comma <br>Ex: dog training, dog house, dog trainers] "><img src="<?=$helpImg?>" class="help" style="float: left;" />
		    <textarea class="activeField" name=keywords cols=40><?=$p[keywords]?></textarea>
	        </div>
	    </td>
	</tr>
	<tr valign=top>
		<td>Description</td>
		<td>
		    <div title="header=[Product description] body=[Describe the product in a few sentences. Will be used for seo purposes and used in affiliate pages] "><img src="<?=$helpImg?>" class="help" style="float: left;" />
		    <textarea class="activeField" name=description cols=40><?=$p[description]?></textarea>
		    </div>
	    </td>
	</tr>
	</table>
</div>
</div>

<center><br />
<input type=submit <?=$disAdd?> name=add value=" Add Product ">
<input type=submit <?=$disUpd?> name=update value=" Update Product "></center>

<p>&nbsp;</p>

<div class=moduleBlue><h1>Affiliate Program Info</h1>
<div class="moduleBody">
    <table>
    <tr valign=top>
    	<td>Enable Affiliate Program? *</td>
    	<td><select class="activeField" name=affProgram>
    		<option <?=$aff[Y]?> value="Y">Yes</option>
    		<option <?=$aff[N]?> value="N">No</option></select>
    	</td>
    </tr><tr valign=top>
    	<td>Affiliate Commissions</td>
    	<td><select <?=$affProgramDis?> <?=$fieldClass?> name=salesPercent>
    	<option <?=$aPercent[25]?> value="25">25%</option>
    	<option <?=$aPercent[33]?> value="33">33%</option>
    	<option <?=$aPercent[50]?> value="50">50%</option>
    	<option <?=$aPercent[66]?> value="66">66%</option>
    	<option <?=$aPercent[75]?> value="75">75%</option>
    	<option <?=$aPercent[100]?> value="100">100%</option>
    	</select>
    	</td>
    </tr>	
    <tr>
        <td>Show this product in affiliate center? </td>
            <td><select <?=$affProgramDis?> <?=$fieldClass?> name=affcenter>
            <option <?=$affcenter[Y]?> value="Y">Yes</option>
            <option <?=$affcenter[N]?> value="N">No</option></select>
        </td>
    
    </tr>
    </table>
</div></div>
<p>&nbsp;</p>

<div class=moduleBlue><h1>Upsell Product</h1>
<div class="moduleBody">
<table>
<tr valign=top>
	<td>Use Upsell? *</td>
	<td><select class="activeField" name="oto">
	    <option <?=$oto[Y]?> value="Y">Yes</option>
	    <option <?=$oto[N]?> value="N">No</option>
	</select>
	</td>
<tr>
    <td>One time offer?</td>
    <td></td>
</tr>
<tr>
    <td>Use this product as upsell </td>
    <td>
        <select class="activeField" name="upsellID">
            <?=$upsellDropDown?>
        </select>
    </td>
</tr>
<tr valign=top>
	<td>Upsell Item Name</td>
	<td><?=$u[itemName]?></td>
</tr><tr valign=top>
	<td>Upsell Price</td>
	<td><?=$u[itemPrice]?></td>
</tr>
<tr valign=top>
	<td>Upsell Item #</td>
	<td><?=$u[itemNumber]?></td>
</tr>
<tr valign=top>
    <td>Use Special Upsell Price: </td>
    <td><input type=text class=activeField name=otoPrice value="<?=$p[otoPrice]?>"><br>
        Leave blank to use above price
    </td>
</tr>
</table>
</div></div>

<p>&nbsp;</p>

<div class="moduleBlue"><h1>Template Options</h1>
<div class="moduleBody">
<table>
	<tr>
		<td>Template Header: </td>
		<td><input class="activeField" name=header value="<?=$p[header]?>"></td>
	</tr><tr>
		<td>Template Footer: </td>
		<td><input class="activeField" name=footer value="<?=$p[footer]?>"></td>
	</tr><tr>
		<td>Sales Letter:</td>
		<td><input class="activeField" name=salespage value="<?=$p[salespage]?>" /></td>
	</tr>
</table>
</div></div>

<p>&nbsp;</p>

<div class="moduleBlue"><h1>Product Emails</h1>
<div class="moduleBody">
	<p><a href="productEmailsEdit.php=<?=$id?>&type=download">Download Email</a> &nbsp; 
    <a href="productEmailsEdit.php?id=<?=$id?>&type=welcome">Welcome Affiliate</a> &nbsp;
    <a href="productEmailsEdit.php?id=<?=$id?>&type=fraud">Fraud Email</a>
    </p>
</div>
</div>

<center><br />
<input type=submit <?=$disAdd?> name=add value=" Add Product ">
<input type=submit <?=$disUpd?> name=update value=" Update Product ">
<input type=submit <?=$disUpd?> name=delete value=" Delete Product " onclick="return confirm('Are you sure you want to delete this product?')">
</center>

</form>
<?
include($adir.'adminFooter.php'); ?>