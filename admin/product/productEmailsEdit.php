<?php
$adir = '../';
include($adir.'adminCode.php');
$tableName = 'emails';

$id = $_GET['id'];
$type = $_GET['type'];

if($_POST['save']) {
	$opt = array(
        'tableName' => $tableName, 
        'dbFields' => array(
            'subject' => $_POST['subject'],
            'message' => $_POST['message']
	),
	'cond' => ' WHERE productID="'.$id.'" AND type="'.$type.'"'
	); 
	
	$u = dbUpdate($opt); 
}


$opt = array( //get product email
    'tableName' => 'emails', 
    'cond' => ' WHERE productID="'.$id.'" AND type="'.$type.'"'
);
$allEmails = dbSelectQuery($opt); 
$e = $allEmails->fetch_array();

if(!is_array($e)) { //if product & email doesn't exist
    $dis = 'disabled'; 
} 

$typeDisplay = array(
	'download' => 'Product Download',
	'fraud' => 'Fraud' 
); 
 
$properties = 'class="activeField" size=60'; 
?>
<script type="text/javascript" src="<?=$tinyMCE?>"></script>
<script type="text/javascript">
    tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
        plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull, | ,code,cut,copy,paste fontsizeselect",
        theme_advanced_buttons2 : ",pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",

        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "center",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

        // Example content CSS (should be your site CSS)
        content_css : "css/content.css",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "lists/template_list.js",
        external_link_list_url : "lists/link_list.js",
        external_image_list_url : "lists/image_list.js",
        media_external_list_url : "lists/media_list.js",

        // Style formats
        style_formats : [
            {title : 'Bold text', inline : 'b'},
            {title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
            {title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
            {title : 'Example 1', inline : 'span', classes : 'example1'},
            {title : 'Example 2', inline : 'span', classes : 'example2'},
            {title : 'Table styles'},
            {title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
        ],

        // Replace values for the template plugin
        template_replace_values : {
            username : "Some User",
            staffid : "991234"
        }
    });
</script>
<!-- /TinyMCE -->
<script type="text/javascript">
if (document.location.protocol == 'file:') {
    alert("The examples might not work properly on the local file system due to security settings in your browser. Please use a real webserver.");
}
</script> 

<div class="moduleBlue"><h1>Emails for Product #<?=$_GET['id']?></h1>
<div class="moduleBody">
	<br />
	<center><p><a href="?id=<?=$id?>&type=download"><button class="btn btn-info">Download Email</button></a> &nbsp; 
    <a href="?id=<?=$id?>&type=fraud"><button class="btn btn-warning">Fraud Email</button></a></p></center>
</div>
</div>

<br /> 
<div class="moduleBlue"><h1>Edit Email Template</h1>
<div>
<form method="POST">
	<table>
	<tr>
		<td colspan="2" align="center">
			<h3><?php echo $typeDisplay[$type] ?> Email Template </h3>
		</td>
	</tr>
	<tr>
		<td>Subject Line</td>
		<td><input <?=$properties?> name="subject" value="<?=$e['subject']?>" <?=$dis ?> /></td>
	</tr>
	<tr>
		<td>Message Body</td>
	</tr>
	<tr>
		<td colspan="2"><textarea name="message" rows="25" cols="70" id="elm1" <?=$dis ?> ><?=$e['message']?></textarea></td>
	</tr>
	<tr>
		<td align="center" colspan="2"><input type="submit" name="save" value=" Save Changes " class="btn success" <?=$dis ?> />
		</td>
	</tr>
	</table>
</form>
</div>	
</div>

<?php
include($adir.'adminFooter.php');  ?>