<?php
$dir = '../../';
include($dir.'include/functions.php');
include($dir.'include/mysql.php');
include($dir.'include/config.php');

//sanitize arguments
foreach($_REQUEST as $request => $value) {
    $_REQUEST[$request] = mysql_real_escape_string($value);
}

$getSale = 'SELECT * FROM sales where id="'.$_REQUEST['id'].'"';
$resSale = mysql_query($getSale) or die(mysql_error());

$s = mysql_fetch_assoc($resSale);

echo json_encode($s);
?>