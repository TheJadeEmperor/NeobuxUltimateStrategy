<?
$dir = '../';
include($dir.'include/functions.php');
include($dir.'include/mysql.php'); 
include($dir.'include/config.php');
include($dir.'include/spmSettings.php');

$today = date('Y-m-d', time());

if($_POST[includePosts])
{    //get posts in sitemap
    $selB = 'select *, date_format(postedOn, "%Y-%m-%d") as date from posts order by postedOn';
    $resB = mysql_query($selB, $conn) or die(mysql_error());
    
    while($b = mysql_fetch_assoc($resB)) 
    {
        $subject = stripslashes($b[subject]);
       
        $sitemap[$b[url]] = array(
            'loc' => $websiteURL.'/?p='.$b[url],
            'lastmod' => $b['date'],
            'changefreq' => 'weekly',
            'priority' => '0.5' );
    }
}

if($_POST[includeProducts])
{
    //get products in sitemap 
    $selP = 'select * from products order by id asc';
    $resP = mysql_query($selP, $conn) or die(mysql_error()); 
    
    while($p = mysql_fetch_assoc($resP))
    {
        $sitemap[$p[folder]] = array(
            'loc' => $websiteURL.'/'.$p[folder],
            'lastmod' => $today,
            'changefreq' => 'weekly',
            'priority' => '1'); 
    }
}


if($_POST['includePages']) {
    $selP = 'SELECT * FROM memberpages order by url';
	$resP = mysql_query($selP, $conn) or die(mysql_error());
    
    while($p = mysql_fetch_assoc($resP))
    {
        //echo $p['url'];
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
<loc>'.$val[loc].'</loc>
<lastmod>'.$val[lastmod].'</lastmod>
<changefreq>'.$val[changefreq].'</changefreq>
<priority>'.$val[priority].'</priority>
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

echo 'Sitemap generated - <a href="sitemap.xml">View Sitemap</a>';
?>
<p>&nbsp;</p>
Sitemap Options 
<form method=post>
<table>
<tr>
    <td>Include posts</td>
    <td><input type=checkbox name=includePosts /></td>    
</tr>
<tr>
    <td>Include products</td>
    <td><input type=checkbox name=includeProducts /></td>
</tr>
<tr>
    <td>Include pages</td>
    <td><input type=checkbox name=includePages /></td>
</tr>
<tr>
    <td colspan=2 align=center>
        <input type=submit value=" Generate Sitemap " />
    </td>
</tr>
</table>
</form>