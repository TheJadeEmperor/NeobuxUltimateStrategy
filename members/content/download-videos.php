<?php

$downloadDir = '/home2/codegeas/ebooks/nus-video-course/';

$videoDownload = array(
    '1-Intro-A' => $downloadDir.'1-Intro-A.zip',
    '2-TrafficWave-A' => $downloadDir.'2-TrafficWave-A.zip',
    '2-TrafficWave-B' => $downloadDir.'2-TrafficWave-B.zip', 
    '2-TrafficWave-C' => $downloadDir.'2-TrafficWave-C.zip', 
    '3-TrafficWave-A' => $downloadDir.'3-TrafficWave-A.zip', 
    '3-TrafficWave-B' => $downloadDir.'3-TrafficWave-B.zip', 
    '4-EasyHits4U-A' => $downloadDir.'4-EasyHits4U-A.zip',
	'4-EasyHits4U-B' => $downloadDir.'4-EasyHits4U-B.zip',
	'4-EasyHits4U-C' => $downloadDir.'4-EasyHits4U-C.zip',
	'5-TrafficExchanges-A' => $downloadDir.'5-TrafficExchanges-A.zip',
	'5-TrafficExchanges-B' => $downloadDir.'5-TrafficExchanges-A.zip',
);

?>
<h1>Download NUS Video Course</h1>

<hr color="#25569a" size="4" />

<p>&nbsp;</p>

<center>
<?php
foreach($videoDownload as $vidTitle => $vidLink){
    echo $vidTitle.'<br /> 
        <form method="post">
        <p><input type="submit" name="dl" value=" Download Video " class="btn success" /></p>
        <input type="hidden" name="id" value="3">
        <input type="hidden" name="url" value="'.$vidLink.'">
        </form>
        
    <p>&nbsp;</p>';
}
?>
</center>