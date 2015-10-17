<?php
include('adminCode.php');

function getTable($tableName)
{
	global $conn;
	
	mysql_select_db($_SESSION[select_db], $conn);
	$table[0] = $tableName;
	$queryD = 'desc '.$tableName;//describe this table
	$resultD = mysql_query($queryD, $conn) or die(mysql_error().' ('.__LINE__.')');

	//get the number of rows (records from this table)
	$queryR = 'select count(*) from '.$tableName;
	$resultR = mysql_query($queryR, $conn) or die(mysql_error().' ('.__LINE__.')');
	$numRows = mysql_fetch_row($resultR);

	$tableContent .= '<tr bgcolor="FFFFCC"><td colspan=3>Fields: '.mysql_num_rows($resultD).'</td>
	<td colspan=3>Rows: '.$numRows[0].'</td></tr>
	<tr><td>Field</td><td>Type</td><td>Null</td><td>Key</td><td>Default</td><td>Extra</td></tr>';

	while($field = mysql_fetch_row($resultD))
	{
		$tableContent .= '<tr><td>'.$field[0].'</td><td>'.$field[1].'</td><td>'.$field[2].'</td><td>'.$field[3].'</td>
		<td>'.$field[4].'</td><td>'.$field[5].'</td>';		
	} 
	
	$tableContent = '<div class=thelist>
	<h2><a href="?table='.$table[0].'">'.$table[0].'</a></h2>
	<table border="0">'. $tableContent . '</table></div><br><br>';	
	
	return $tableContent; 
}//

///////////////////////////////
$dbList = array($dbName);
///////////////////////////////
if($_POST[select_db] && $_POST[select_db] != $_SESSION[select_db])
{	//select new database
	$_SESSION[select_db] = $_POST[select_db];	
	unset($_GET);
}

if($_SESSION[select_db]) //use this database
{
//	global $conn;
	//database info goes here
	//////////////////////////////
	//$dbHost = '66.147.240.156';
	//$dbUser = 'codegeas';
	//$dbPW = 'Military1!';
	//$dbName = 'codegeas_ptc';
	/////////////////////////////
//	mysql_select_db($_SESSION[select_db], $conn);

	$conn = database($dbHost, $dbUser, $dbPW, $_SESSION[select_db]);	
}


if($_POST[select_db]) //text list of tables
{
	$query = 'show tables';
	$result = mysql_query($query, $conn) or die(mysql_error().'(Line: '.__LINE__.')');
	
	$count[r] = 0;
	while($rowT = mysql_fetch_assoc($result))
	{ 
		if($count[r] % 25 == 0)
			$show_tables .= "</table></td><td><table>";
		
		$show_tables .= "<tr><td><a href = \"?table=".$rowT["Tables_in_".$_POST[select_db]]."
		\">".$rowT["Tables_in_".$_POST[select_db]]."</a></td></tr>";
		
		$count[r] ++;
	}//while
	
	$pageContent = "<table><tr valign = top><td><table>".$show_tables."</table></td></tr></table>";
}//

if($_POST[show_tables]) //detailed info for all tables
{
	$query = 'show tables from '.$_SESSION[select_db];
	
	$result = mysql_query($query, $conn) or die(mysql_error().' ('.__LINE__.')');
	
	while($table = mysql_fetch_row($result))//go through tables
	{	
		$pageContent .= getTable($table[0]);
	}//
}
 
/*
if($_POST[get_database])//export to excel button is clicked
{
	if($_POST[select_db] != "all")
	{
		unset($dbList); 
		$dbList = array( $_POST[select_db] );
		$file_name = $_POST[select_db]."_".date("Y-m-d", time()).".csv";	
	}//if
	else
	{
		$file_name = "all_databases_".date("Y-m-d", time()).".csv";
	}//else
	
	$export = 1;
	
	if($export == 1)
	{
		//$file ="dabatase_list.csv";
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;filename=".$file_name );
		header('Pragma: no-cache');
		header('Expires: 0');
	}//if
	
	foreach($database_array as $database => $database_name)
	{
		echo "Tables in ".$database."\n";
		
		foreach($database_name as $table => $table_name)
		{
			echo "\n".$table."\n";
			echo "Fields: ".$table_name[num_fields].", Rows: ".$table_name[num_rows]."\n";

			echo "Field,Type,Null,Key,Default,Extra\n";
			
			foreach($table_name[r] as $key => $element) 
				echo $element[field].",".$element[type].",".$element[null].",".$element[key].",".$element['default'].",".$element[extra]."\n";
		}//foreach
	}//foreach
 
	exit;
}//if
*/

if($_POST[get_sql])//save as sql file
{
	//echo $_GET[table];
echo	$dump = 'mysqldump -u'.$dbUser.' -p'.$dbPW.' '.$_SESSION[select_db].' '.$_GET[table].' > ./file.sql';
	system($dump);
}//


//$restore = "mysql -uroot -pdaRkN1t3 nyu < file.sql";
//system($restore);

if($_GET[table])
{
 	$pageContent = getTable($_GET[table]);
}//


//drop down list of databases
foreach($dbList as $db)
{
	$selected = '';
	if($_SESSION[select_db] == $db)
		$selected = 'selected';
	
	$dropDown .= '<option value="'.$db.'" '.$selected.'>'.$db.'</option>';
}

$dropDown = '<select name=select_db onChange="submit();">
	<option value="">--Pick a database--</option>'.$dropDown.'</select>';

?>

<form action="<?=$var ?>" method=post>
<?=$dropDown?>
<input type=submit name="show_tables" value="Show All Tables"/>
<input type=submit name="get_sql" value="Export to SQL File"/>
</form>

<?=$pageContent?>
</body></html>