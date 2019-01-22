<?php
include('adminCode.php');

$saveThis = array('orderBy', 'perPage');

foreach($saveThis as $save)
{
    if($_POST[$save] != '' && $_POST[$save] != $_SESSION[$save])
    {
        $_SESSION[$save] = $_POST[$save];
    }
}

//default order by 
if($_SESSION[orderBy])
    $orderBy = $_SESSION[orderBy];
else 
    $orderBy = 'id';

//default subscribers per page
if($_SESSION[perPage])
	$perPage = $_SESSION[perPage];
else 
	$perPage = 100;


//set the current page (default is 1)
if($_GET[p])
	$_SESSION[p] = $_GET[p];
else
	$_SESSION[p] = 1;

$thisPage = $_SESSION[p];	


$total = 1; //total # of users
$listCount = 1; //# of pages

$selS = 'select * from users order by '.$orderBy;
$resS = mysql_query($selS, $conn) or die(mysql_error());

while($m = mysql_fetch_assoc($resS))
{
	if($total % $perPage == 0) 
	{
		$listCount++;
	}

	$subscribers[$listCount] .= '<tr>
	<td><a href="updateProfile.php?id='.$m[id].'">'.$m[id].'</a> - <a href="updateProfile.php?id='.$m[id].'">'.$m[email].'</a> </td>
	<td><a href="updateProfile.php?id='.$m[id].'">'.$m[username].'</a></td>
	<td>'.$m[joinDate].'</td>
	</tr>';
	
	$total++;
}


//calculate page numbers
$numPages = ceil($total / $perPage);


for($p = 1; $p <= $numPages; $p++)
{
	if($thisPage == $p)
		$page .= '<font size=4><b><a href="?p='.$p.'">'.$p.'</a></b></font> &nbsp;';
	else
		$page .= '<a href="?p='.$p.'">'.$p.'</a> &nbsp;';
}


//calculate prev page
if($thisPage == 1)
	$prev = 1;
else
	$prev = $thisPage - 1;

	
//calculate next page
if($thisPage == $numPages)
	$next = $numPages;
else
	$next = $thisPage + 1;
	
	
$prevPage = '<a href="?p='.$prev.'"><< Prev</a>';
$nextPage = '<a href="?p='.$next.'">Next >></a>';	

$pageNav = '<tr><td colspan=4 align=center>'.$prevPage.' '.$page.' '.$nextPage.'</td></tr>';


//subscriber options
$usersPerPage = array(
'50', '100', '150', '200');

foreach($usersPerPage as $pp)
{
	$pick = '';
	if($perPage == $pp)
		$pick = 'selected';
	$ppOpt .= '<option value="'.$pp.'" '.$pick.'>'.$pp.'</option>';
}

$sortChoices = array(
'email' => 'Email', 
'joinDate' => 'Joined',
'username' => 'Username'
);

foreach($sortChoices as $field => $choice)
{
    $pick = '';
    if($orderBy == $field)
        $pick = 'selected';
    
    $sortOptions .= '<option value="'.$field.'" '.$pick.'>'.$choice.'</option>';
}


$subOpt = '';

if($msg)
	echo '<fieldset>'.$msg.'</fieldset>';

?>	
<table>
<tr valign=top>
	<td>
	<table class=moduleBlue cellspacing=0 cellpading=2>
    <tr>
	    <th colspan=4>Affiliates List - Total: <?=$total?></th> 
    	<?=$pageNav ?>
    <tr>
        <td>
    		<table class=moduleBlue cellspacing=0 cellpading=4>
    		<tr>
    			<th>User ID - Email</th><th>Username</th><th>Joined</th>
    		</tr>
    			<?=$subscribers[$thisPage]?>
    		</table>
    	</td>
    </tr>
	<?=$pageNav?>
	</table>
	</td>
	<td width="10px"></td>
	
	<td><form method=POST><div class=moduleBlue><h1>User List Options</h1>
	    <div class="moduleBody">
	Subscribers Per Page <select name="perPage" onchange=submit();><?=$ppOpt?></select>
	
	<br /><br />
	Sort list by <select name="orderBy" onchange=submit();>
	    <?=$sortOptions?>
	</select>
	</form>
	</div></div>
	</td>
</tr>
</table>

<?
include('adminFooter.php');  ?>