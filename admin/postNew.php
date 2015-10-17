<?php
include('adminCode.php'); 

if($_POST[save]) //insert into db 
{
    $url = addslashes($_POST[url]);
    
    //error checking
    if($_POST['subject'] == '')
    {
        $msg .= '* Subject line is required <br />';
    }
    
    if($_POST['url'] == '')
    {
        $msg .= '* URL is required <br />';
    }
    
    if($msg)
    {
        $msg = '<font color=red><b>Please fix the following errors: <br />'.$msg.'</b></font>';
    }
    else 
    {
        $dbFields = array(
            'subject' => '"'.addslashes($_POST['subject']).'"', 
            'post' => '"'.addslashes($_POST['elm1']).'"',
            'postedBy' => '"'.$_SESSION['login']['id'].'"',
            'postedOn' => 'now()', 
            'tags' => '"'.addslashes($_POST['tags']).'"', 
            'url' => '"'.addslashes($_POST['url']).'"',
            'status' => '"'.$_POST['status'].'"',
            'useHTMLFile' => '"'.$_POST['useHTMLFile'].'"'
        );
    
        $fields = $values = array();
    
        foreach($dbFields as $fld => $val)
        {
            array_push($fields, $fld);
            array_push($values, $val); 
        }
    
        $theFields = implode(',', $fields);
        $theValues = implode(',', $values); 
    
        //add post
        $ins = 'insert into posts ('.$theFields.') values ('.$theValues.') ';
        $res = mysql_query($ins, $conn) or die(mysql_error()); 
        $postID = mysql_insert_id();
        
        //add view     
        $dbOptions = array(
        'tableName' => 'pageviews',
        'dbFields' => array(
            'page' => '?p='.$url,
            'uniqueViews' => 0,
            'rawViews' => 0,
        ) 
        );
        
        dbInsert($dbOptions); 
    
        echo '<meta http-equiv="refresh" content="1;url=postNew.php?id='.$postID.'">';
    }
}
else if($_POST[update])
{
	$opt = array(
		'tableName' => 'posts',	
		'dbFields' => array(
			'subject' => $_POST['subject'], 
			'post' => $_POST['elm1'],
			'postedBy' => $_SESSION['login']['id'], 
			'tags' => $_POST['tags'], 
			'url' => $_POST['url'],
			'status' => $_POST['status'],
			'useHTMLFile' => $_POST['useHTMLFile']
		),
		'cond' => 'where id="'.$_GET[id].'"'
	);
	
	if(dbUpdate($opt))
		$msg = 'Post has been updated.'; 
}

if($_GET[id])
{
	$opt = array(
	'tableName' => 'posts',
	'cond' => 'where id="'.$_GET[id].'"'); 
	
	$allPosts = dbSelect($opt); 	
	$p = $allPosts[0]; 

	$disAdd = 'disabled'; 
}
else
	$disEdit = 'disabled';

//status: active or inactive
$statusChoice = array(
'A' => 'Active',
'I' => 'Inactive');

foreach($statusChoice as $sta => $dis)
{
    $pick = '';
    if($p[status] == $sta)
        $pick = 'selected';
    $statusOpt .= '<option '.$pick.' value="'.$sta.'">'.$dis.'</option>';
}

//use html file?
if($p['useHTMLFile'] == 'on')
    $useHTMLChecked = 'checked';


?>
<!-- TinyMCE -->
<script type="text/javascript" src="<?=$tinyMCE?>"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
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
</head>
<body>

<form method="post">
<div class="moduleBlue" style="width: 720px;"><h1>Add / Edit Post</h1>
<div class="moduleBody">
    <?=$msg?>
<table>
	<tr>	
		<td> Subject: </td>
		<td><input class="activeField" name=subject size=80 value="<?=$p[subject]?>"></td>
	</tr><tr>
		<td> Post URL: </td>
		<td><input class="activeField" name=url size=80 value="<?=$p[url]?>"></td>
	</tr><tr>
		<td> Tags: </td>
		<td><input class="activeField" name=tags size=80 value="<?=$p[tags]?>"></td>
	</tr>
	<tr>
	    <td> Status: </td>
	    <td> 
	        <select name=status>
	        <?=$statusOpt?>
            </select>
	    </td>
	</tr>
	<tr>
	    <td>Use HTML File? </td>
	    <td>
	        <input type=checkbox class="activeField" name=useHTMLFile <?=$useHTMLChecked?> />
	    </td>
	</tr>
</table>


<!-- Gets replaced with TinyMCE, remember HTML in a textarea should be encoded -->
<div>
    <textarea id="elm1" name="elm1" rows="20" cols="80">
        <?=$p[post]?>
    </textarea>
</div>

<a href="javascript:;" onmousedown="tinyMCE.get('elm1').show();">[Show]</a>
<a href="javascript:;" onmousedown="tinyMCE.get('elm1').hide();">[Hide]</a>
<a href="javascript:;" onmousedown="tinyMCE.get('elm1').execCommand('Bold');">[Bold]</a>
<a href="javascript:;" onmousedown="alert(tinyMCE.get('elm1').getContent());">[Get contents]</a>
<a href="javascript:;" onmousedown="alert(tinyMCE.get('elm1').selection.getContent());">[Get selected HTML]</a>
<a href="javascript:;" onmousedown="alert(tinyMCE.get('elm1').selection.getContent({format : 'text'}));">[Get selected text]</a>
<a href="javascript:;" onmousedown="alert(tinyMCE.get('elm1').selection.getNode().nodeName);">[Get selected element]</a>
<a href="javascript:;" onmousedown="tinyMCE.execCommand('mceInsertContent',false,'<b>Hello world!!</b>');">[Insert HTML]</a>

<br /><br />
<center>
    <input type="submit" <?=$disAdd?> name="save" value="New Post" />
    <input type="submit" <?=$disEdit?> name="update" value="Save" />
    <input type="reset" name="reset" value="Reset" />

</center><br />
</div></div>
</form>

<?
include('adminFooter.php');  ?>