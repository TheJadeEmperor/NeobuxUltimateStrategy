<?php
$adir = '../';
include($adir.'adminCode.php');

if($_POST['reset']) { 
    
    $queryOptions = array(
        'tableName' => 'pageviews', 
        'dbFields' => array(
            'rawviews' => 0,
            'uniqueViews' => 0
        ),
        'cond' => 'WHERE page="'.$_POST['page'].'" LIMIT 1'
    );

    dbUpdate($queryOptions);  //'UPDATE pageviews SET rawViews=0, uniqueViews=0 WHERE page="'.$_POST['page'].'" LIMIT 1' ;
}

$opt = array(
    'tableName' => 'pageviews',
    'cond' => 'WHERE page<>"" ORDER BY page'
);

$resV = dbSelectQuery($opt);


//$selV = 'SELECT * FROM pageviews WHERE page<>"" ORDER BY page';
//$resV = mysql_query($selV) or die(mysql_error()); 

while($v = $resV->fetch_array()) {
    $rawViews = $v['rawViews'];
    $uniqueViews = $v['uniqueViews'];
    $page = $v['page'];
    
    //put everything into an array
    $views[$page] = array(
        'rawViews' => $rawViews,
        'uniqueViews' => $uniqueViews
    );  
}


$resP = getAllProducts (); //get product info from DB


while($p = $resP->fetch_array()) {
    $folder = $p['folder'];
    $url = '/'.$folder;
    
    $uniqueViews = $views[$url]['uniqueViews'];
    $rawViews = $views[$url]['rawViews'];
    
    $productViews .= '<tr>
    <td>'.$p['itemName'].'</td>
    <td><a href="../'.$folder.'" target="_BLANK">'.$url.'</a></td>
    <td>'.$uniqueViews.'</td>
    <td>'.$rawViews.'</td>
    <td>
        <form method="POST">
        <input type="hidden" name="page" value="'.$url.'">
        <input type="submit" class="btn info" name="reset" onclick="confirm(\'Are you sure you want to reset the views for this page to 0?\')">
        </form>
    </td>
    </tr>';
}


$opt = array(
    'tableName' => 'posts',
    'cond' => ' ORDER BY url'
);

$resB = dbSelectQuery($opt);

while($b = $resB->fetch_array()) {
    $url = $b['url'];
    $postURL = '/?p='.$url;
    
    $uniqueViews = $views[$postURL]['uniqueViews'];
    $rawViews = $views[$postURL]['rawViews'];
        
    $blogViews .= '<tr>
    <td>'.shortenText($b['subject'], 35).'</td>
    <td><a href="'.$dir.'?p='.$url.'" target="_BLANK">'.shortenText($postURL, 50).'</a></td>
    <td>'.$uniqueViews.'</td>
    <td>'.$rawViews.'</td>
    <td>
        <form method="POST">
        <input type="hidden" name="page" value="'.$postURL.'">
        <input type="submit" class="btn info" name="reset" onclick="confirm(\'Are you sure you want to reset the views for this page to 0?\')">
        </form>
    </td>    
    </tr>';
}



?>

<div class="moduleBlue"><h1>Products</h1>    
<div class="moduleBody">
    <table cellspacing="0">
    <tr>
        <th>Product </th><th>URL</th><th>Unique Views</th><th>Raw Views</th><th>Reset</th>
    </tr>
    <?=$productViews?>
    </table>    
</div>
</div>

<p>&nbsp;</p>

<div class="moduleBlue"><h1>Blog Views</h1>    
<div class="moduleBody">
    <table cellspacing=0>
    <tr>
        <th>Page Name </th><th>URL</th><th>Unique Views</th><th>Raw Views</th><th>Reset</th>
    </tr>
    <?=$blogViews?>
    </table>    
</div>
</div>

<p>&nbsp;</p>



<?
include($adir.'adminFooter.php');  ?>