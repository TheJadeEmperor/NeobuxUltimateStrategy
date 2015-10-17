<?php
include('adminCode.php');
set_time_limit(120);
$row = 1;

if (($handle = fopen("import.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) 
    {
        $num = count($data);
         
        $row++;
        for ($c=0; $c < 2; $c++) {
            //echo $data[$c] . "<br />\n";
        }
        
	list($email, $crap)	= explode('/', $data[0]);
		
	$sel = 'select * from subscribers where email="'.$email.'"';
	$res = mysql_query($sel, $conn) or die(mysql_error());
       
	if(mysql_num_rows($res) == 0)
	{
      echo $ins = 'insert into subscribers (name, email) values ("'.$data[1].'", "'.$email.'") ';
		mysql_query($ins) or die(mysql_error());

	}
	

	echo "<br>\n";
	
    }
    fclose($handle);
}

echo $row;
?>