<?php
$adir = '../';
include($adir.'adminCode.php');

$sale_create = 'sale_ajax.php?action=create';
$sale_read = 'sale_ajax.php?action=read';
$sale_update = 'sale_ajax.php?action=update';

if($_POST['id']) { 
  
    $opt = array(
        'tableName' => 'sales',
        'cond' => 'WHERE id="'.$_POST['id'].'"'
    );

    dbDeleteQuery ($opt);  //$del = 'DELETE FROM sales WHERE id="'.$_POST['id'].'" LIMIT 1';

    $msg = 'Successfully deleted sales record';
}


$resP = getAllProducts (); //get product info from DB
while($p = $resP->fetch_array()) {
    $products[$p['id']] = $p; 
}

if($_GET['p'])
	$currentPage = $_GET['p'];
else
	$currentPage = 1;


$fieldList = array(
'productID', 
'itemNumber', 
'itemName',
'transID',
'payerEmail' );

foreach($fieldList as $fld) {
	if($_POST[$fld] != '') {
		$searchFor .= $fld.'="'.$_POST[$fld].'" and ';
	}
}

//1 day in seconds
$oneDay = 60 * 60 * 24;

if($_SESSION['before'] == '')
    $_SESSION['before'] = date('Y-m-d', time() + $oneDay);
	
if($_SESSION['after'] == '')
    $_SESSION['after'] = $val['installDate'];
	
    $searchFor .= ' purchased >= "'.$_SESSION['after'].' 00:00:00" and purchased <= "'.$_SESSION['before'].' 23:59:59"';

    $searchFor = ' id is not NULL';

    //get sales records
    $selS = 'SELECT *, date_format(purchased, "%m/%d/%Y") AS transDate 
    FROM sales s where '.$searchFor.' ORDER BY purchased DESC'; 
    //$resS = mysql_query($selS, $conn) or die(mysql_error());

    $resS = $conn->query($selS); 
    $records = mysqli_num_rows($resS);

    //if(is_object ($records)) echo 'true'; 

    if ($records > 0) {
    unset($_SESSION['sendTo']);
    $_SESSION['sendTo'] = array();

    $total = $records; //total # of records
    $listCount = $count = 1;
    $perPage = 100;

    while($c = $resS->fetch_array()) {
        if ($count % $perPage == 0)
            $listCount++;

        array_push($_SESSION['sendTo'], $c['payerEmail']);
        
        $salesID = $c['id'];

        $prodName = $products[$c['productID']]['itemName'];
        $folder = $products[$c['productID']]['folder'];
        $custView = 'custView.php?id=' . $c['id'];

        $tableRow = '<tr title="Sales record #'.$c['id'].'">
			<td>'.$count.'</td>
			<td>'.$c['transDate'].'</td>
			<td><a href="updateProfile.php?e='.$c['payerEmail'].'">'.$c['payerEmail'].'</a></td>
			<td>'.$prodName.'</td>
			<td><a href="'.$custView.'" target="_blank">'.$c['transID'].'</a> &nbsp;
				<a href="'.$custView.'" target="_blank">View</a></td>
			<td><a href="javascript:updateSaleDialog(\''.$salesID.'\')">Edit</a></td>
			<td align="center">
                <form method="POST">
                <input type=image src="' . $delImg . '" onclick="confirm(\'Deletions are irreversible! Are you sure to delete record #'.$c['id'].'?\');">
                <input type=hidden name=id value="' . $c['id'] . '"> 
                </form>
            </td>
        </tr>';

        $custTable .= $tableRow;
        $cust[$listCount] .= $tableRow;
        $count++; //total # of sales
    }

    //calculate page numbers
    $numPages = ceil($total / $perPage);

    for ($p = 1; $p <= $numPages; $p++) {
        if ($currentPage == $p)
            $pages .= '<font size=3><a href="?p=' . $p . '">' . $p . '</a></font> ';
        else
            $pages .= '<a href="?p=' . $p . '">' . $p . '</a> ';
    }

    //calculate prev page
    if ($currentPage == 1)
        $prev = 1;
    else
        $prev = $currentPage - 1;

    //calculate next page
    if ($currentPage == $numPages)
        $next = $numPages;
    else
        $next = $currentPage + 1;

    $emailButton = '<a href="email/emailSend.php"><input type="button" class="btn btn-warning" value="Email All"></a>';

    $pages = '<tr><td colspan="5" align="center">
        <a href="?p=' . $prev . '"><< Prev</a> ' . $pages . ' <a href="?p=' . $next . '">Next >></a>
        </td></tr>';

    $salesTable = '<table class="moduleBlue" cellspacing="0">
        <tr>
            <th>#</th>
            <th>Purchased</th>
            <th>Payer Email</th>
            <th>Product </th>
            <th>Transaction ID</th>
            <th>Delete</th>
        </tr>
        <tr>
            <td colspan="5" align="center">
                ' . $emailButton . '
            </td>
        </tr>
        ' . $pages . ' ' . $cust[$currentPage] . ' ' . $pages . '
        <tr>
            <td colspan="5" align="center">
                ' . $emailButton . '
            </td>
        </tr>
        </table>';

    $searchText = 'Search results: found ' . $records . ' records';
}
else {
    $searchText = 'Search found ' . $records . ' records. Please try again.';
}

$properties = 'type="text" class="activeField"'; 

?>
<script> 
$(document).ready( function () {
    var custTable = $('#cust').dataTable({  
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "iDisplayLength": 50
    });

    $('#addSaleForm').validate({
        rules: {
            productID: {required: true},
            transID: {required: true},
            amount: {required: true},
            payerEmail: {required: true}, 
            purchased: {required: true},
            expires: {required: true}
        },
    });
}); //document.ready

function addSaleDialog () {  
    $('#updateButton').attr('disabled', true);
    
    $('#addSaleForm').dialog({
        modal: true,
        width: 400,
        position: 'center',
        show: {
            effect: "explode",
            duration: 500
        },
        hide: {
            effect: "explode",
            duration: 500
        },
        beforeClose: function( event, ui ) {
            $('#saveButton').attr('disabled', false);
            $('#updateButton').attr('disabled', false);
            $("input[type=text]").val("");
        }
    });
}

function updateSaleDialog (salesID) {
    $('#saveButton').attr('disabled', true);
    fillSalesForm(salesID); //fill in the form fields from database

    $('#addSaleForm').dialog({
        modal: true,
        width: 400,
        position: 'center',
        show: {
            effect: "explode",
            duration: 500
        },
        hide: {
            effect: "explode",
            duration: 500
        },
        beforeClose: function( event, ui ) {
            $('#saveButton').attr('disabled', false);
            $('#updateButton').attr('disabled', false);
            $("input[type=text]").val("");
            $("input[id=id]").val("");
        }
    });
}
    
function insertSale () {
    if ($('#addSaleForm').valid()) {
        $.ajax({
            type: "POST",
            url: "<?=$sale_create?>",
            data: $('#addSaleForm').serialize(),
            success: function(msg) {
                alert('Message: '+msg);
                location.reload();
                //custTable.ajax.reload( null, false );
            }
        });
        closeDialog();
    }
}

function updateSaleDB () {
    var id = $('#id').val();
    if ($('#addSaleForm').valid()) {
        $.ajax({
            type: "POST",
            url: "<?=$sale_update?>",
            data: $('#addSaleForm').serialize()+'&id='+id,
            success: function(msg) {
                alert('Message: '+msg);
                //location.reload();
            }
        });
    }
    closeDialog();
}

function fillSalesForm (salesID) {
	console.log('salesID'+salesID);
	$.ajax({ 
		type        : 'POST',
		url         : '<?=$sale_read?>', 
		data        : 'id='+salesID,
		success     : function(data) {
			data = $.parseJSON(data);
			console.log('data'+data);
			$.each(data, function(name, value) {
				//console.log(name+' '+value);
				
				if(name == 'id') $('#sale_id').val(value);
				
				$('#'+name).val(value);
			});          
		}
	});
}

function closeDialog () {
   $('button').attr('disabled', false); //enable all buttons
   $('#addSaleForm').dialog("close"); //close the dialog
   //clear the sales form
   $("input[type=text]").val("");
   $("#addSaleForm")[0].reset();
}

</script>
<style>
    #addSaleForm {
        display: none;
    }
    
    .panel-heading {
        padding-bottom: 0px;
    }
</style>
<div class="panel panel-info">
    <div class="panel-heading">
        <p align="center"><input type="button" class="btn btn-success addSaleButton" value="Add Sales Record" onclick="addSaleDialog()" /></p>
    </div>
</div>

<table cellpadding="0" cellspacing="0" border="0" class="display" id="cust">
    <thead>
        <tr>
            <th>#</th>
            <th>Purchased</th>
            <th>Payer Email</th>
            <th>Product </th>
            <th>Transaction ID</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tfoot>
    </tfoot>
    <tbody>
         <?=$custTable?>
    </tbody>
</table>
<br />
<div class="panel panel-info">
    <div class="panel-heading">
        <p align="center"><a href="email/emailSend.php"><input type="button" class="btn btn-warning" value="Email All"></a></p>
    </div>
</div>

<?
$salesFields = array(
    'Product ID' => array(
        'id' => 'productID',
        'size' => '3',
        'maxsize' => '10'
    ),
    'Transaction ID' => array(
        'id' => 'transID',
        'maxsize' => '50'
    ),
    'Item Name' => array(
        'id' => 'itemName',
        'maxsize' => '50'
    ),
    'Item Number' => array(
        'id' => 'itemNumber',
        'maxsize' => '50'
    ),
    'Amount' => array(
        'id' => 'amount',
        'maxsize' => '20'
    ),
    'Payer Email' => array(
        'id' => 'payerEmail',
        'maxsize' => '100'
    ),
    'Contact Email' => array(
        'id' => 'contactEmail',
        'maxsize' => '100'
    ),
    'Purchased' => array(
        'id' => 'purchased'
    ),
    'Expires' => array(
        'id' => 'expires'
    ),
    'First Name' => array(
        'id' => 'firstName',
        'maxsize' => '50'
    ),
    'Last Name' => array(
        'id' => 'lastName',
        'maxsize' => '50'
    ),
    'Paid To' => array(
        'id' => 'paidTo',
        'maxsize' => '100'
    ),
    'Status' => array(
        'id' => 'status',
        'size' => '3',
        'maxsize' => '1'
    ),
    'Notes' => array(
        'id' => 'notes',
    ),
    'Opt Out?' => array(
        'id' => 'optout',
        'size' => '3',
        'maxsize' => '1'
    ),
);
?>

<form id="addSaleForm" title="Add New Sale">
    <div style="padding: 10px;">
        <table>
            <tr>
                <td align="right">ID</td>
                <td width="5px"></td>
                <td align="left"><input type="button" id="sale_id" /><input type="hidden" id="id" /></td>
            </tr>
            <?
            foreach($salesFields as $disp => $textBox) {
                echo '<tr title="'.$textBox['id'].'">
                    <td align="right" width="120px">'.$disp.'</td><td></td>
                    <td align="left"><input type="text" class="activeField" name="'.$textBox['id'].'" id="'.$textBox['id'].'" size="'.$textBox['size'].'" /></td>
                </tr>';
            }
            ?>
        </table>
    </div><br />
    <center>
        <input type="button" class="btn btn-success" id="saveButton" value="Save" onclick="insertSale()" />
        <input type="button" class="btn btn-info" id="updateButton" value="Update" onclick="updateSaleDB()" />
        <input type="button" class="btn btn-warning" id="cancelButton" value="Cancel" onclick="closeDialog()" />
    </center>
   
</form>


<br /><br />
<?
include($adir.'adminFooter.php');  ?>