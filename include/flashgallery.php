<?php
error_reporting(0);

$allowed_formats = array("jpg", "jpeg", "JPG", "JPEG", "png", "PNG");
$exclude_files = array(
"_derived",
"_private",
"_vti_cnf",
"_vti_pvt",
"vti_script",
"_vti_txt"
); // add any other folders or files you wish to exclude from the gallery.

$listDir = array(); 

function conv($str) {
  
    for ( $i = 0, $length = strlen($str); $i < $length; $i++ ) {
    	
    	
        if((ord($str[$i])=='0'||ord($str[$i])=='4')){
        	$str1 = $str1;
        	
        }else{  $str1 = $str1.$str[$i];}
        
      
    }
    
    
if( ( strpos($str1,chr(209).chr(143).chr(209).chr(142)) === 0) ) 
 { $str2 = substr($str1, 4); $str1 = $str2;}else{$str1 = $str1;}
        
    return $str1;
}


function detectUTF8($string)
{
        return preg_match('%(?:
        [\xC2-\xDF][\x80-\xBF]        # non-overlong 2-byte
        |\xE0[\xA0-\xBF][\x80-\xBF]               # excluding overlongs
        |[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}      # straight 3-byte
        |\xED[\x80-\x9F][\x80-\xBF]               # excluding surrogates
        |\xF0[\x90-\xBF][\x80-\xBF]{2}    # planes 1-3
        |[\xF1-\xF3][\x80-\xBF]{3}                  # planes 4-15
        |\xF4[\x80-\x8F][\x80-\xBF]{2}    # plane 16
        )+%xs', $string);
}

function cp1251_utf8( $sInput )
{
    $sOutput = "";

    for ( $i = 0; $i < strlen( $sInput ); $i++ )
    {
        $iAscii = ord( $sInput[$i] );

        if ( $iAscii >= 192 && $iAscii <= 255 )
            $sOutput .=  "&#".( 1040 + ( $iAscii - 192 ) ).";";
        else if ( $iAscii == 168 )
            $sOutput .= "&#".( 1025 ).";";
        else if ( $iAscii == 184 )
            $sOutput .= "&#".( 1105 ).";";
        else
            $sOutput .= $sInput[$i];
    }
    
    return $sOutput;
}

function encoding($string){
    if (function_exists('iconv') && false) {    
        if (@!iconv('utf-8', 'cp1251', $string)) {
            $string = iconv('cp1251', 'utf-8', $string);
        }
        return $string;
    } else {
        if (detectUTF8($string)) {
            return $string;        
        } else {
            return cp1251_utf8($string);
        }
    }
}


function ReadFolderDirectory($dir) 
    { 
        global $listDir,$exclude_files,$allowed_formats;
        if($handler = opendir($dir))
        { 
           { 
            while (($sub = readdir($handler)) !== FALSE) 
                { 
                  
                  if ($sub != "." && $sub != ".." && $sub != "Thumb.db" && array_search($sub, $exclude_files)===false) 
                   {
                   	$ext = substr($sub, strrpos($sub, ".")+1);
                    if(is_file($dir."/".$sub) && array_search($ext, $allowed_formats)!==false )  $listDir[] = $dir."/".$sub; 
                    elseif(is_dir($dir."/".$sub))  ReadFolderDirectory($dir."/".$sub); 
                   } 
                } 
            }    
            closedir($handler); 
        } 
    }
    
if(isset($_GET['file_dir']))  ReadFolderDirectory($_GET['file_dir']);

natcasesort($listDir);

print '<?xml version="1.0" encoding="utf-8"?>'; 
print '
<pics>';

$directory= $_SERVER['HTTP_HOST'] .$_SERVER['PHP_SELF'];
$directory=dirname($directory);

foreach ($listDir as $val) 
{
	$title = substr(strrchr($val, '/'), 1);
	
	if ($sEncoding = mb_detect_encoding($title, 'auto', true) != 'UTF-8') $title = mb_convert_encoding($title, 'UTF-8', $sEncoding);

    $title=conv($title);
    if (substr($title,0,4) == 'ÿþ') $title = substr($title,4); 
    
	$defaul_dir = substr($val,0,strrpos($val,'/'));
	$file_name_ = substr(strrchr($val, '/'), 1);
	$url_dec = rawurlencode($file_name_);
	$val = $defaul_dir .'/'.$url_dec;
	
	print '
	<pic src="'.'http://'.$directory.'/'.$val.'" title="'.$title.'" />'; 
}

print '
</pics>';
?>