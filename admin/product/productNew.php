<?php
$adir = '../';
include($adir.'adminCode.php');



$emailDownloadSubject = "";

$emailDownloadTemplate = '<p>Hi $firstName, </p> <p>Thank you for your purchase of $itemName. Everybody wants to make money online but most of them are not willing to do what it takes. By getting this product you have shown that you are different than the others who do not take any action.</p> <p>You are on your way to profitting with PTC\'s. Only one more step left. Just go to the download link below to download your copy of $itemName.</p> <p>The following information are your purchase details, sent from paypal:</p> <p>Txn ID:  $transID <br />Paypal Email:  $payerEmail<br />Item Name:  $itemName<br />Item #:  $itemNumber<br />Payment Amount:  $itemPrice</p> <p>This is an automatically generated message from our system regarding your order from us. If the status is "Completed", that means your order went through, and you may download your the $itemName immediately. If not, then please wait for the payment to be completed.</p> <p>You can download the product through this link:</p> <p><strong>$downloadLink</strong></p> <p>Just go to the link to download the product. Enjoy!</p> <p> </p> <p>Sincerely,</p> <p>Your Name<br />Company Name <br /><a href="mailto:your@email.address">your@email.address</a></p>';


$emailWelcomeSubject = "Transaction Error: $itemName";

$emailWelcomeTemplate = '<p>Hi $firstName</p>
<p>There was a problem with the transaction from paypal. Either the amount paid did not match the item\'s price or the transaction timed out. Then please go back to the website and order again.&nbsp;</p>
<p>If this problem continues then please contact us so we can resolve the problem.</p>
<p>Thank you for understanding.&nbsp;</p>
<p>&nbsp;</p>
<p>Neobux Ultimate Strategy<br /><a href="mailto:your@email.address">your@email.address</a><br />https://neobuxultimatestrategy.com</p>';



//check for errors
if($_POST) {
	if($_POST['itemName'] == '')
		$error .= 'Please fill in Item Name <br>';

	if($_POST['itemPrice'] == '')
		$error .= 'Please fill in Item Price <br>';
    
    if($_POST['expires'] == '')
        $error .= 'Please fill in expiration time <br />';
}

$dbFields = array(
	'itemName' => $_POST['itemName'],
	'itemNumber' => $_POST['itemNumber'],
	'itemPrice' => $_POST['itemPrice'],
	'folder' => $_POST['folder'],
	'download' => $_POST['download'],
	'expires' => $_POST['expires'], 
	'keywords' => $_POST['keywords'],
	'description' => $_POST['description'],
    'upsellID' => $_POST['upsellID'],
	'header' => $_POST['header'], 
	'footer' => $_POST['footer'],
	'salespage' => $_POST['salespage'],
	'otoPage' => $_POST['otoPage'],
	'downloadPage' => $_POST['downloadPage'],
	'productOrderLink' => $_POST['productOrderLink'],
	'productOrderText' => $_POST['productOrderText']
	);


	
if($_POST['add']) {
    $viewOpt = array(
        'tableName' => 'pageviews',
        'dbFields' => array(
            'page' => '/'.$_POST['itemName'],
            'uniqueViews' => '0',
            'rawViews' => '0',
        )
    );
    
	if($error) {
		$p = $_POST; 
	}
    else {
		$opt = array( 
			'tableName' => 'products',
			'dbFields' => $dbFields
		); 
			
        $res = dbInsert($opt); //insert new product into table
        $newID = $conn->insert_id; //ID 
        
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
                'type' => 'fraud',
                'subject' => $emailWelcomeSubject,
                'message' => $emailWelcomeTemplate)
        ); 
    
        //add view
        dbInsert($viewOpt); 
        
        //add email templates
        dbInsert($emailDownloadOpt); 
        dbInsert($emailWelcomeOpt); 

        echo '<meta http-equiv="refresh" content="1;url=productNew.php?id='.$newID.'">';        
    }		
}
else if($_POST['update']) {
	$set = array(); 
	
	foreach($dbFields as $fld => $val) {
		array_push($set, $fld.'="'.addslashes($val).'"');
	} 
	
	$theSet = implode(',', $set);

	$queryOptions = array( //update settings table
		'tableName' => 'products', 
		'dbFields' => $dbFields,
		'cond' => 'WHERE id="'.$_GET['id'].'"'
	);

	dbUpdate($queryOptions);  //'UPDATE products SET '.$theSet.' WHERE id="'.$_GET['id'].'"';
}

if($_GET['id']) {
	$id = $_GET['id'];
	
	$resP = getAllProducts (); //get product info from DB

    while($item = $resP->fetch_array()) {
            
        if($id == $item['id']) {
            $p = $item;
        }
    
        $products[] = $item; 
    }
    
    foreach($products as $prod) {
        $select = '';
        if($p['upsellID'] == $prod['id']) {
            $select = 'selected'; 
            $u = $prod; 
        }
        
        $upsellDropDown .= '<option value="'.$prod['id'].'" '.$select.'>'.$prod['itemName'].'</option>';
    }

    if($_POST['delete']) {

		$opt = array(
            'tableName' => 'products',
            'cond' => 'WHERE id="'.$id.'"' 
        ); 
        dbDeleteQuery ($opt); //'DELETE FROM products WHERE id="'.$id.'"'

		$opt = array(
            'tableName' => 'pageviews',
            'cond' => 'WHERE page="/'.$p['itemName'].'"' 
        ); 
        dbDeleteQuery ($opt); //'DELETE FROM pageviews WHERE page="/'.$p['itemName'].'"'

		$opt = array(
            'tableName' => 'emails',
            'cond' => 'WHERE productID="'.$id.'"'
        ); 
        dbDeleteQuery ($opt); //'DELETE FROM pageviews WHERE page="/'.$p['itemName'].'"'

		$opt = array(
            'tableName' => 'downloads',
            'cond' => 'WHERE productID="'.$id.'"'
        ); 
        dbDeleteQuery ($opt); //'DELETE FROM downloads WHERE id="'.$id.'"'

        $error = 'Successfully deleted product '.$p['itemName'];
    }

	$disAdd = 'disabled';
}
else {
	$disUpd = 'disabled';
}


?>

<form method="POST">
<div class="moduleBlue"><h1>General Info</h1>
	<div class="moduleBody">
	<font color="red"><b><?=$error?></b></font>
	<table>
	<tr valign="top">
		<td>Item Name *</td>
		<td>
		    <div title="header=[Product Name or Item Name] body=[Name of the product, 100 characters max] "><img src="<?=$helpImg?>" />
		    <input class="activeField" name="itemName" value="<?=$p['itemName']?>" size="40">
	        </div>
	    </td>
	</tr>
	<tr valign="top">
		<td>Price (USD) *</td>
		<td>       
		    <div title="header=[Item Price] body=[Price of product, numbers and decimal points only <br />
		        Ex: 1.00 or 1] "><img src="<?=$helpImg?>" />
		        <input class="activeField" name="itemPrice" value="<?=$p['itemPrice']?>">
		    </div>
	    </td>
	</tr>
	<tr valign="top">
		<td>Item #</td>
		<td>       
		    <div title="header=[Item number] body=[Optional, item # is for tracking purposes] "><img src="<?=$helpImg?>" />
		        <input class="activeField" name="itemNumber" value="<?=$p['itemNumber']?>">
		    </div>
	    </td>
	</tr>
	<tr valign="top">
		<td>Product Folder</td>
		<td>
	        <div title="header=[Product Folder] body=[Folder where product files are located in the website server, no slashes <br />If the folder is www.website.com/product1 <br /> Put in product1]"><img src="<?=$helpImg?>" />
	            <input class="activeField" name="folder" value="<?=$p['folder']?>">
	            <a href="../../<?=$p['folder']?>" target="_BLANK">Visit Link</a>
	        </div>        
	    </td>
	</tr>
	<tr valign="top">
		<td>Download Link</td>
		<td>
	        <div title="header=[Download link] body=[Location of file to be downloaded] "><img src="<?=$helpImg?>" />
		    <input class="activeField" name="download" value="<?=$p['download']?>" size="50"> <br />
			
			<a href="productDownloads.php?id=<?=$id?>" style="margin-left: 20px" class="btn btn-warning">Click here to Manage Downloads</a> 
			
	    	</div>	
		</td>
	</tr>
	<tr valign="top">
		<td>Expiration (Download file) *</td>
		<td>
	        <div class=".left" title="header=[Download Expiration Date] body=[When will the download link expire, in hours] "><img src="<?=$helpImg?>" />
		    <input class="activeField" name="expires" value="<?=$p['expires']?>">
	    	</div>
	    </td>
	</tr>
	
	<tr valign="top">
		<td>Product Order Link</td>
		<td>
	        <div class=".left" title="header=Order link for product] body=[This is used in place of the default Paypal link]"><img src="<?=$helpImg?>" />
		    
			<input class="activeField" name="productOrderLink" value="<?=$p['productOrderLink']?>" size="40" />
	    	</div>
	    </td>
	</tr>
	
	<tr valign="top">
		<td>Product Order Text</td>
		<td>
	        <div class=".left" title="header=Product order text] body=[What text to show with the order link]"><img src="<?=$helpImg?>" />
		    
			<input class="activeField" name="productOrderText" value="<?=$p['productOrderText']?>" size="40" />
	    	</div>
	    </td>
	</tr>
	
	<tr valign="top">
		<td>SEO Keywords</td>
		<td>
		    <div title="header=[Product keywords] body=[Keywords that describe the product, for seo purposes. Separate each keyword phrase with a comma <br>Ex: dog training, dog house, dog trainers] "><img src="<?=$helpImg?>" class="help" style="float: left;" />
		    <textarea class="activeField" name="keywords" cols="40"><?=$p['keywords']?></textarea>
	        </div>
	    </td>
	</tr>
	<tr valign="top">
		<td>Description</td>
		<td>
		    <div title="header=[Product description] body=[Describe the product in a few sentences. Will be used for seo purposes and used in affiliate pages] "><img src="<?=$helpImg?>" class="help" style="float: left;" />
		    <textarea class="activeField" name="description" cols="40"><?=$p['description']?></textarea>
		    </div>
	    </td>
	</tr>
	</table>
</div>
</div>

<center><br />
<input type="submit" <?=$disAdd?> name="add" value=" Add Product " class="btn btn-success">
<input type="submit" <?=$disUpd?> name="update" value=" Update Product " class="btn btn-info">
</center>

<p>&nbsp;</p>
<p>&nbsp;</p>

<div class="moduleBlue"><h1>Template Options</h1>
<div class="moduleBody">
<table>
	<tr>
		<td>Template Header: </td>
		<td><input class="activeField" name="header" value="<?=$p['header']?>"></td>
	</tr>
	<tr>
		<td>Template Footer: </td>
		<td><input class="activeField" name="footer" value="<?=$p['footer']?>"></td>
	</tr>
	<tr>
		<td>Sales Letter:</td>
		<td><input class="activeField" name="salespage" value="<?=$p['salespage']?>" /></td>
	</tr>
	<tr>
		<td>Download Page</td>
		<td><input class="activeField" name="downloadPage" value="<?=$p['downloadPage']?>" /></td>
	</tr>
	<tr>
		<td>OTO Page</td>
		<td><input class="activeField" name="otoPage" value="<?=$p['otoPage']?>" /></td>
	</tr>
</table>
</div>
</div>


<center><br />
<input type="submit" <?=$disAdd?> name="add" value=" Add Product " class="btn btn-success">
<input type="submit" <?=$disUpd?> name="update" value=" Update Product " class="btn btn-info">
<input type="submit" <?=$disUpd?> name="delete" value=" Delete Product " class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">
</center>

</form>

<p>&nbsp;</p>
<p>&nbsp;</p>

<div class="moduleBlue"><h1>Product Emails</h1>
<div class="moduleBody">
	
	<center>   
	<br />
	<p><a href="productEmailsEdit.php?id=<?=$id?>&type=download"><button class="btn btn-warning">Download Email</button></a>
	 &nbsp; 
    <a href="productEmailsEdit.php?id=<?=$id?>&type=fraud"><button class="btn btn-warning">Fraud Email</button></a>
	</p>
	
	</center>

</div>
</div>
<?
include($adir.'adminFooter.php'); ?>