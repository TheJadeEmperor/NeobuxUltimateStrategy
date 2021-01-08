<?php
$dir = '../../';
include($dir.'include/functions.php');
include($dir.'include/config.php');

//sanitize arguments
foreach($_REQUEST as $request => $value) {
    $_REQUEST[$request] = mysql_real_escape_string($value);
}


$opt = array(
    'tableName' => 'sales',
    'cond' => 'WHERE id="'.$_REQUEST['id'].'"'
);

$resS = dbSelectQuery($opt);
$s = $resS->fetch_array();


echo json_encode($s);
?>