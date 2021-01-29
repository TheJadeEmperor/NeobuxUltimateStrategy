<?php
$adir = '../';
include($adir.'adminCode.php');

$today = date('Y-m-d', time());

if($_POST['includePosts']) {    
    //get posts in sitemap
    $sel = 'SELECT *, date_format(postedOn, "%Y-%m-%d") AS date FROM posts ORDER BY postedOn'; 
    $res = $conn->query($sel);

    while($b = $res->fetch_array()) {
        $subject = stripslashes($b['subject']);
       
        $sitemap[$b['url']] = array(
            'loc' => $websiteURL.'/?p='.$b['url'],
            'lastmod' => $b['date'],
            'changefreq' => 'weekly',
            'priority' => '0.5' 
        );
    }
}

if($_POST['includeProducts']) {
    //get products in sitemap 
    $sel = 'SELECT folder FROM products ORDER BY id asc';
    $res = $conn->query($sel);

    while($p = $res->fetch_array()) {
        $sitemap[$p['folder']] = array(
            'loc' => $websiteURL.'/'.$p['folder'],
            'lastmod' => $today,
            'changefreq' => 'weekly',
            'priority' => '1'
        ); 
    }
}


if($_POST['includePages']) {
    $sel = 'SELECT url FROM memberpages order by url';
    $res = $conn->query($sel);

    while($p = $res->fetch_array()) {
        $sitemap[$p['url']] = array(
            'loc' => $websiteURL.'/?action='.$p['url'],
            'lastmod' => $today,
            'changefreq' => 'weekly',
            'priority' => '1'); 
    }
}

foreach($sitemap as $loc => $val) {
    $xmlContent .= '
<url>
<loc>'.$val['loc'].'</loc>
<lastmod>'.$val['lastmod'].'</lastmod>
<changefreq>'.$val['changefreq'].'</changefreq>
<priority>'.$val['priority'].'</priority>
</url>';
}

//open file
$myFile = "sitemap.xml";
$fh = fopen($myFile, 'w') or die("can't open file");

$xmlContent = '<?xml version="1.0" encoding="utf-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.$xmlContent.'
</urlset>';
 
fwrite($fh, $xmlContent);
fclose($fh);

if($_POST)
echo 'Sitemap generated - <a href="sitemap.xml" target="_BLANK">View Sitemap</a>';
?>
<p>&nbsp;</p>
Sitemap Options 
<form method="POST">
<table>
<tr>
    <td>Include posts</td>
    <td><input type="checkbox" name="includePosts" /></td>    
</tr>
<tr>
    <td>Include products</td>
    <td><input type="checkbox" name="includeProducts" /></td>
</tr>
<tr>
    <td>Include pages</td>
    <td><input type="checkbox" name="includePages" /></td>
</tr>
<tr>
    <td colspan="2" align="center">
        <input type="submit" value=" Generate Sitemap " />
    </td>
</tr>
</table>
</form>