<?php
include('adminCode.php'); 
$dbList = array($dbName);

$rows = 10;
$cols = 80;

if($_GET['h'] == '') //history
	$_GET['h'] = genString(8);

if($_GET['reset']!="")
	unset($_SESSION['test_query'][$_GET['h']]);

if(!(is_array($_SESSION['test_query'][$_GET['h']])))
	$_SESSION['test_query'][$_GET['h']] = array();

$_POST[sql] = stripslashes($_POST['sql']);
	
if($_POST['subQuery']!="")
{
	$db_sel[$_POST['dbName']]=" selected ";
	$ck_csv[$_POST['ck_csv']]=" checked ";
	$ck_quotes[$_POST['ck_quotes']]=" checked ";

	switch($_POST['ck_csv'])
	{
		case "":
			$ck_bool=false;
			$cell1="<td>";
			$cell2="</td>";
			$th1="<th>";
			$th2="</th>";
			$row1="<tr>";
			$row2="</tr>";
			$impl="";
			break;
		default: //  , or |
			$ck_bool=true;
			$impl=$_POST['ck_csv'];
			$row2="\n";
			break;
	}

	if($_POST['ck_quotes']!='')
	{
		$quotes_around='"';
	}
 
	mysql_select_db($_POST['dbName'], $conn) or die(mysql_error());
	
	
	array_push($_SESSION['test_query'][$_GET['h']], $_POST['sql']);
	
	$result = mysql_query(stripslashes($_POST['sql']), $conn);

	if(mysql_errno($conn) != 0)
	{
		$errorMsg = 'MYSQL ERROR - '.mysql_error().'<br><br>';
	}
	else
	{
		$numfields = @mysql_num_fields($result);
		$hd = array();
		for ($i=0; $i < $numfields; $i++) // Header
		{
			$table_name = mysql_field_table($result, $i);

			array_push($hd,$th1.$quotes_around.(mysql_field_name($result, $i)).$quotes_around.$th2);
		}
		$th.=$row1.(implode($impl,$hd)).$row2;
	
		if(mysql_num_rows($result) > 0)
		{
			$res_ct = 0;
			while ($row = mysql_fetch_assoc($result)) //if there is a result
			{
				$res_ct++;
				$line=array();
				$v=1;
				foreach($row as $fld)
				{
					if(($unser_bl) && ($unser_ary[$v]!='') && ($fld!=''))
					{
						$fld2=str_replace('"','&quot;',$fld);
						$fld='<a href="javascript:popUp(\'\')">Click Here</a><br>'.$fld;
					}

					if($ck_bool)
					{
						$fld=str_replace('"','""',$fld); // 2 double quotes are needed for excel to save correctly
					}
	
					switch($fld)
					{
						case "":
							$fld="BLANK";
							break;
						case null:
							$fld="NULL";
							break;
					}

					$fld=str_replace("<","&lt;",$fld);
					$fld=str_replace(">","&gt;",$fld);

					array_push($line, $cell1.$quotes_around.$fld.$quotes_around.$cell2);

					$v++;
				}

				$tbl.=$row1.(implode($impl,$line)).$row2;
			}
			$res_ct_lbl="<br><br>Results Returned: ".$res_ct;
		}
		else
		{
			$tbl .= $row1."<td colspan=".$numfields.">No results returned".$cell2.$row2;
		}

		if($ck_bool)
		{
			$tbl="<br><textarea cols=80 rows=20 name=\"txt\">".$th.$tbl."</textarea>";
		}
		else
		{
			$tbl="<table colspan=100% border=1 cellpadding=10>".$th.$tbl."</table>";
		}
		
		$res = 'Query: '.$_POST['sql']."<br>Tables: ".$table_name."<hr>".$tbl.$res_ct_lbl;

	}
}

//query history list
for($i = sizeof($_SESSION['test_query'][$_GET['h']])-1; $i >= 0; $i--)
{
	$thisQuery = $_SESSION['test_query'][$_GET['h']][$i]; 
	
	$dispQuery = str_replace("\"", "&quot;", $thisQuery); //replace quotes
	$dispQuery = shortenText($dispQuery, 50);   //shorten the query 
	
	if($thisQuery != $_SESSION['test_query'][$_GET['h']][$i+1])//show only unique queries
	{
		$history_opt.="<option value=\"".str_replace("\"","&quot;",$thisQuery).'">'.$dispQuery.'</option>';
	}
}

if(!$_POST[dbName])
	$_POST[dbName] = $dbList[0];
	
$selectT = 'show tables from '.$_POST[dbName];
$queryT = mysql_query($selectT, $conn) or print(mysql_error());

while($t = mysql_fetch_assoc($queryT))
{
	foreach($t as $table)
	{
		if($_POST[tableName] == $table)
			$pick = 'selected';
		else
			$pick = '';	
			
		$tableList .= '<option value="'.$table.'" '.$pick.'>'.$table.'</option>';
	}
}

$tableList = '<select name="tableName">'.$tableList.'</select>';

$qContent = '<head><script>	
function copyQuery(q)
{
	document.query.sql.value = q;
	document.query.sql.focus();
} 

function appendQuery(q)
{
	document.query.sql.value += q;
	document.query.sql.focus();
}
</script></head> 
<body>
<form name="query" action="'.$_SERVER[PHP_SELF].'?h='.$_GET['h'].'" method=POST>
<table border=1 class="moduleBlue">
<tr valign=top><th colspan=3>MySQL Query</th></tr>
<tr valign=top>
	<td>
	<table border=0>
	<tr>
		<td>Database</td>
		<td><select name="dbName" onchange=submit();>';

foreach($dbList as $dbName)
{	
	if($_POST[dbName] == $dbName)
		$pick = 'selected';
	else
		$pick = '';
	$qContent .= '<option value="'.$dbName.'" '.$db_sel[$dbName].' '.$pick.'>'.$dbName.'</option>';
}

$qContent .= '</select> Table '.$tableList.'
	</td>
	</tr><tr>
		<td>Query </td><td><textarea name="sql" rows='.$rows.' cols='.$cols.'>'.stripslashes($_POST['sql']).'</textarea></td>
	</tr><tr>
		<td></td><td><input type="submit" name="subQuery" value="Submit Query"> 
			<a href="./query.php?h='.genString(8).'" target=_blank><input type=button value="Open New Session"></a>
			<a href="./query.php?h='.$_GET['h'].'&reset=1"><input type=button value="Reset Query History"></a>
		</td>
	</tr><tr>
		<td>Query History</td>
		<td><select name="previous_queries" onChange="copyQuery(this.value)">
			<option value="">---Query History----</option>'.$history_opt.'</select>
		</td>
	</tr>
	</table>
	</td><td>
	<table border=0 height=100%>
	<tr valign=top>
		<td>
		<input type="radio" name="ck_csv" value="" checked> Not Delimited<br>
		<input type="radio" name="ck_csv" value="," '.$ck_csv[','].'> Comma Delimited<br>
		<input type="radio" name="ck_csv" value="|" '.$ck_csv['|'].'> Pipe Delimited<br>
		<input type="checkbox" name="ck_quotes" value="Y" '.$ck_quotes['Y'].'> Quotes around fields<br>
		<hr>
		</td>
	</tr><tr>
			<td>Syntax Shortcuts:<br>
			<a href="#" onClick="copyQuery(\'select * from \'+document.query.tableName.value)">select * from</a><br>
			<a href="#" onClick="appendQuery(\' is null \')">...is null</a><br>	
			<a href="#" onClick="copyQuery(\'desc \'+document.query.tableName.value)">describe table</a><br>
			<a href="#" onClick="copyQuery(\'show tables\')">show tables</a><br>
			<a href="#" onClick="copyQuery(\'alter table \'+document.query.tableName.value)">alter table</a><br>
			<a href="#" onClick="appendQuery(\' add column \')">...add column</a><br>
			<a href="#" onClick="appendQuery(\' modify column \')">...modify column</a><br>
			<a href="#" onClick="appendQuery(\' drop column \')">...drop column</a><br>
			<a href="#" onClick="copyQuery(\'insert into \'+document.query.tableName.value)">insert into</a><br>
			</td>
		</tr>
	</table>
	</td>
</tr>
</table><div width=100%>'.$errorMsg.$res.'</div></form>';
?>
<div class=moduleBlue><h1>What is this?</h1><div>
This section is for advanced users only. See the database structure as well as make changes to the data.</div></div>
<br>
<?=$qContent; ?>