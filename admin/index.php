<?php
$dir = '../';
session_start();
include($dir.'include/functions.php');
include($dir.'include/mysql.php');
include($dir.'include/config.php');

$getLogin = 'select * from settings where opt="adminUser" || opt="adminPass"';
$resLogin = mysql_query($getLogin, $conn) or die(mysql_error());

while($l = mysql_fetch_assoc($resLogin))
{
    if($l['opt'] == 'adminUser')
        $adminUser = $l['setting'];
    else
        $adminPass = $l['setting'];
}

if($_POST['login'])
{
    if($_POST['username'] == $adminUser && $_POST['password'] == $adminPass) {
        $_SESSION['admin']['username'] = $adminUser;
        $_SESSION['admin']['id'] = 0;
        header('Location: salesMonthly.php');
}
    else {
        $err = '<p><font color="red"><b>Wrong credentials</b></font></p>';
    }
}

$bootDir = $dir.'include/bootstrap/';
?>
<link href="<?=$dir?>include/css/admin.css" rel="stylesheet" type="text/css"/>
<link href="<?= $bootDir ?>css/bootstrap-theme.css" rel="stylesheet" />
<link href="<?= $bootDir ?>css/bootstrap.css" rel="stylesheet" />
<script src="<?= $bootDir ?>js/bootstrap.min.js"></script>
<style>
    .loginBox {
        width: 400px;
    }
</style>
<center>
<p>&nbsp;</p>
<p>Admin Login</p>

<?=$err ?>
<form method=POST>
    
    <div class="loginBox">
    <div class="panel panel-primary">
        <div class="panel-heading"><h2 class="panel-title">Control Panel</h2></div>
        <div class="panel-body">
            <table>
                <tr>
                    <td width="90px"><p>Username</p> </td>
                    <td>
                        <p><input type="text" class="activeField" size="26" name="username" /></p>
                    </td>
                </tr>
                <tr>
                    <td><p>Password</p> </td>
                    <td>
                        <p><input type="password" class="activeField" size="26" name="password" /></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <p><input type="submit" name="login" value=" Login to Admin Panel " class="btn info"></p>
                    </td>
                </tr>
            </table>
        </div>
    </div>    
    </div>
</form>

<a href="../">Return to website</a>
</center>