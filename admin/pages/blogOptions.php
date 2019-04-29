<?php
$adir = '../';
include($adir.'adminCode.php');

if($_POST['update'])
{
    $dbOpt = array(
        'blogHeader' => $_POST['blogHeader'],
        'blogFooter' => $_POST['blogFooter'],
        'blogCustomContent' => $_POST['blogCustomContent']
    );
    
    foreach($dbOpt as $opt => $setting)
    {
        $setting = addslashes(trim($setting)); 
        
        $updS = 'UPDATE settings SET setting="'.$setting.'" WHERE opt="'.$opt.'"';
        mysql_query($updS) or print(mysql_error()); 
    }
}

$selB = 'SELECT * FROM settings ORDER BY opt';
$resB = mysql_query($selB, $conn); 

while($m = mysql_fetch_assoc($resB))
{
    $m['setting'] = stripslashes($m['setting']);
    $blogOptions[$m['opt']] = $m['setting'];
        
} 

?>
<form method="POST">
<div class="moduleBlue"><h1>Blog Template</h1>
<div class="moduleBody">
    <p><?=$msg?></p>
    <table>
    <tr>
        <td>Header File</td>
        <td>            
            <div title="header=[Header File] body=[File to be included as the header of the blog] ">
            <img src="<?=$helpImg?>" />
<input type="text" class="activeField" name="blogHeader" size="30" value="<?=$blogOptions['blogHeader']?>"/>
            </div>
        </td>
    </tr>
    <tr>
        <td>Footer File</td>
        <td>
            <div title="header=[Footer File] body=[File to be included as the footer of the blog] ">
            <img src="<?=$helpImg?>" />
            <input type="text" class="activeField" name="blogFooter" size="30" value="<?=$blogOptions['blogFooter']?>" /></td>
    </tr>
    <tr>
        <td colspan="2" align="center">
            <input type="submit" name="update" value=" Update Blog " />
        </td>
    </tr>
    </table>
</div>
</div>

<p>&nbsp;</p>

<div class="moduleBlue"><h1>Blog Custom Content </h1>
<div class="moduleBody">
    <textarea rows="15" cols="50" name="blogCustomContent"><?=$blogOptions['blogCustomContent']?></textarea><br />
    <center>
        <input type="submit" name="update" value=" Update Blog " />
    </center>
</div>
</div>
</form>

<p>&nbsp;</p>
<?
include($adir.'adminFooter.php');  ?>