<?

$videoDownload = array(
    '1-Intro-A.zip' => '/home2/codegeas/ebooks/nus-video-course/1-Intro-A.zip',
    '2-TrafficWave-A.zip' => '/home2/codegeas/ebooks/nus-video-course/2-TrafficWave-A.zip',
    '2-TrafficWave-B.zip' => '/home2/codegeas/ebooks/nus-video-course/2-TrafficWave-B.zip', 
    '2-TrafficWave-C.zip' => '/home2/codegeas/ebooks/nus-video-course/2-TrafficWave-C.zip', 
    '3-TrafficWave-A.zip' => '/home2/codegeas/ebooks/nus-video-course/3-TrafficWave-A.zip', 
    '3-TrafficWave-B.zip' => '/home2/codegeas/ebooks/nus-video-course/3-TrafficWave-B.zip', 
    '4-DownlineRefs-A.zip' => '/home2/codegeas/ebooks/nus-video-course/4-DownlineRefs-A.zip', 
    '4-DownlineRefs-B.zip' => '/home2/codegeas/ebooks/nus-video-course/4-DownlineRefs-B.zip', 
    '5-EasyHits4U-A.zip' => '/home2/codegeas/ebooks/nus-video-course/5-EasyHits4U-A.zip', 
    '5-EasyHits4U-B.zip' => '/home2/codegeas/ebooks/nus-video-course/5-EasyHits4U-B.zip', 
    '5-EasyHits4U-C.zip' => '/home2/codegeas/ebooks/nus-video-course/5-EasyHits4U-C.zip', 
);

?>
<h1>Download NUS Video Course</h1>

<hr color="#25569a" size="4" />

<p>&nbsp;</p>

<center>
<?
foreach($videoDownload as $vidTitle => $vidLink){
    echo $vidTitle.'<br /> 
        <form method=post>
        <p><input type=submit name="dl" value=" Download Now "></p>
        <input type=hidden name=id value="3">
        <input type=hidden name=url value="'.$vidLink.'">
        </form>
        
    <p>&nbsp;</p>';
}
?>
</center>