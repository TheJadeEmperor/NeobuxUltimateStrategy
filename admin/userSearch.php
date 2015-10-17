<?
include('adminCode.php'); 

$fieldList = array(
'username',
'fname',
'lname',
'email',
'paypal');

foreach($fieldList as $fld)
{
    if($_POST[$fld] != '')
    {
        $searchFor .= $fld.'="'.$_POST[$fld].'" and ';
    }
}
    
//1 day
$oneDay = 60 * 60 * 24;

if($_SESSION[before] == '')
    $_SESSION[before] = date('Y-m-d', time() + $oneDay);
    
if($_SESSION[after] == '')
    $_SESSION[after] = $installDate;

$searchFor .= ' joinDate >= "'.$_SESSION[after].' 00:00:00" and joinDate <= "'.$_SESSION[before].' 23:59:59"';

$sel = 'select * from users where '.$searchFor.' ';
$res = mysql_query($sel, $conn) or die(mysql_error()); 

while($u = mysql_fetch_assoc($res))
{
    $u = formatFields($u); 
       
    $searchResults .= '<tr>
    <td><a href="updateProfile.php?id='.$u[id].'">'.$u[username].'</a></td>
    <td><a href="updateProfile.php?id='.$u[id].'">'.shortenText($u[email], 30).'</a></td>
    <td>'.shortenText($u[paypal], 30).'</td>
    <td>'.$u[fname].' '.$u[lname].'</td>
    <td>'.$u[joinDate].' </td>
    </tr>';
}   
?>
<form method=post>
<div class="moduleBlue"><h1>Affiliate Search</h1>     
<div class="moduleBody">
    <p><?=$msg?></p>
    <table>
    <tr valign="top">
    <td>  
            <table>
            <tr>
                <td>Username</td>
                <td><input type=text class=activeField size=35 name=username value="<?=$_POST[username]?>" /></td>
            </tr>
            <tr>
                <td>First Name</td>
                <td>
                    <input type=text class=activeField size=35 name=fname value="<?=$_POST[fname]?>" />
                </td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td>
                    <input type=text class=activeField size=35 name=lname value="<?=$_POST[lname]?>" />
                </td>
            </tr>
            <tr>
                <td>Contact Email </td>
                <td>
                    <input type=text class=activeField size=35 name=email value="<?=$_POST[email]?>" />
                </td>
            </tr>
            <tr>
                <td>Paypal Email </td>
                <td>
                    <input type=text class=activeField size=35 name=paypal value="<?=$_POST[paypal]?>" />
                </td>
            </tr>
            <tr>
                <td colspan=2 align=center>
                    <input type=submit name=search value=" Search " />
                </td>
            </tr>
            </table>
    </td><td>
        <table>
        <tr>
            <td>Affiliate Sales</td>        
            <td>
                <input type=text class=activeField size=5 name=sales value="<?=$_POST[sales]?>" />
                
            </td>
            <td>
                
            </td>
        </tr>
        </table>
    </td>
</tr>
</table>    
</form>
</div>
</div>

<p>&nbsp;</p>

<table class="moduleBlue" cellspacing=0 cellpadding=5>
<tr>
    <th>Username</th>
    <th>Email</th>
    <th>Paypal</th>
    <th>Full Name</th>
    <th>Join Date</th>        
</tr>
<?=$searchResults?>
</table> 

<?
include('adminFooter.php');  ?>