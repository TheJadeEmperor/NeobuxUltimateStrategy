<?php
$adir = '../';
include($adir.'adminCode.php');

if($_POST['update']) {
    $dbOpt = array(
        'blogHeader' => $_POST['blogHeader'],
        'blogFooter' => $_POST['blogFooter'],
        'blogCustomContent' => $_POST['blogCustomContent']
    );

    $opt = array(
        'tableName' => 'settings', 
        'dbFields' => array(
            'setting' => $_POST['blogHeader']),
        'cond' => 'WHERE opt="blogHeader"'
    );
    $result = dbUpdate($opt);

    $opt = array(
        'tableName' => 'settings', 
        'dbFields' => array(
            'setting' => $_POST['blogFooter']),
        'cond' => 'WHERE opt="blogFooter"'
    );
    $result = dbUpdate($opt);

    $opt = array(
        'tableName' => 'settings', 
        'dbFields' => array(
            'setting' => $_POST['blogCustomContent']),
        'cond' => 'WHERE opt="blogCustomContent"'
    );
    $result = dbUpdate($opt);
    
    $msg = '<font color="red"><b>Blog options are updated</b></font>';
}


$opt = array(
    'tableName' => 'settings',
    'cond' => 'WHERE opt="blogHeader" OR opt="blogFooter" OR opt="blogCustomContent"');

$blogData = dbSelect($opt);

foreach($blogData as $num => $bd) {
    $blogOptions[$bd['opt']] = $bd['setting'];
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
            <input type="submit" name="update" value=" Update Blog " class="btn success" />
        </td>
    </tr>
    </table>
</div>
</div>

<p>&nbsp;</p>

<div class="moduleBlue"><h1>Blog Custom Content </h1>
<div class="moduleBody">
    <textarea rows="15" cols="50" name="blogCustomContent"><?=$blogOptions['blogCustomContent']?></textarea><br /><br />
    <center>
    <input type="submit" name="update" value=" Update Blog " class="btn success" />
    </center>
</div>
</div>
</form>

<p>&nbsp;</p>
<?
include($adir.'adminFooter.php');  ?>