<?php
$adir = '../';
include($adir.'adminCode.php');

if($_POST['reset'])
{ 
    echo $reset = 'update pageviews set rawViews=0, uniqueViews=0 where page="'.$_POST[page].'" limit 1' ;
    mysql_query($reset, $conn) or die(mysql_error());
}

$selV = 'select * from pageviews where page<>"" order by page';
$resV = mysql_query($selV) or die(mysql_error()); 

while($v = mysql_fetch_assoc($resV))
{
    $rawViews = $v[rawViews];
    $uniqueViews = $v[uniqueViews];
    $page = $v[page];
    
    //put everything into an array
    $views[$page] = array(
        'rawViews' => $rawViews,
        'uniqueViews' => $uniqueViews
    );  
}

//get products
$selP = 'select * from products order by id';
$resP = mysql_query($selP) or die(mysql_error()); 

while($p = mysql_fetch_assoc($resP))
{
    $folder = $p['folder'];
    $url = '/'.$folder;
    
    $uniqueViews = $views[$url][uniqueViews];
    $rawViews = $views[$url][rawViews];
    
    $productViews .= '<tr>
    <td>'.$p['itemName'].'</td>
    <td><a href="../'.$folder.'" target=_blank>'.$url.'</a></td>
    <td>'.$uniqueViews.'</td>
    <td>'.$rawViews.'</td>
    <td>
        <form method=post>
        <input type=hidden name=page value="'.$url.'">
        <input type=submit class="btn info" name=reset onclick="confirm(\'Are you sure you want to reset the views for this page to 0?\')">
        </form>
    </td>
    </tr>';
}

$selB = 'select url, subject from posts order by url';
$resB = mysql_query($selB) or die(mysql_error()); 

while($b = mysql_fetch_assoc($resB))
{
    $url = $b['url'];
    $postURL = '/?p='.$url;
    
    $uniqueViews = $views[$postURL][uniqueViews];
    $rawViews = $views[$postURL][rawViews];
        
    $blogViews .= '<tr>
    <td>'.shortenText($b[subject], 35).'</td>
    <td><a href="../?p='.$url.'" target=_blank>'.shortenText($postURL, 50).'</a></td>
    <td>'.$uniqueViews.'</td>
    <td>'.$rawViews.'</td>
    <td>
        <form method=post>
        <input type=hidden name=page value="'.$postURL.'">
        <input type=submit class="btn info" name=reset onclick="confirm(\'Are you sure you want to reset the views for this page to 0?\')">
        </form>
    </td>    
    </tr>';
}

$selS = 'select url from memberpages order by url';
$resS = mysql_query($selS) or die(mysql_error());

while($s = mysql_fetch_assoc($resS))
{
    $url = $s['url'];
    $page = '/?action='.$url;
    $uniqueViews = $views[$page]['uniqueViews'];
    $rawViews = $views[$page]['rawViews'];
     
    $siteViews .= '<tr>
    <td><a href="../?action='.$url.'" target=_blank>'.$page.'</a></td>
    <td>'.$uniqueViews.'</td>
    <td>'.$rawViews.'</td>
    <td>
        <form method=post>
        <input type=hidden name=page value="'.$page.'">
        <input type=submit class="btn info" name=reset onclick="confirm(\'Are you sure you want to reset the views for this page to 0?\')">
        </form>
    </td>    
    </tr>';
}

?>

<div class="moduleBlue"><h1>Products</h1>    
<div class="moduleBody">
    <table cellspacing=0>
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

<div class="moduleBlue"><h1>Site Pages Views</h1>    
<div class="moduleBody">
    <table cellspacing=0>
    <tr>
        <th>URL</th><th>Unique Views</th><th>Raw Views</th><th>Reset</th>
    </tr>
    <?=$siteViews?>
    </table>    
</div>
</div>

<?
include('adminFooter.php'); ?>