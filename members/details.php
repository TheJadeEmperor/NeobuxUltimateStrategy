<?php
if(!$_SESSION['login']['id'])
    header('Location: index.php');

function updateSession() {
    global $conn; 
    
    $selU = 'SELECT * FROM users WHERE username="'.$_SESSION['login']['username'].'" 
    || email="'.$_SESSION['login']['email'].'"';
    $resU = $conn->query($selU);

    $user = $resU->fetch_array(); 
    $_SESSION['login'] = $user; 
    return $user; 
}
//// update session ////
$u = $_SESSION['login']; 
//// update session ////

if($_POST['update']) {
    if($_POST['email'] == '') {
        $msg = 'Email cannot be blank - please try again';
    }
    else {
        $updE = 'UPDATE users SET email="'.$_POST['email'].'" WHERE id="'.$u['id'].'"';
        $resE = $conn->query($updE); 

        $msg .= '<br />Email successfully updated';          
    }

    $newUsername = $_POST['username'];
    if($newUsername != $u['username'])
    if($newUsername == '') {
        $msg .= '<br />Username cannot be blank - please try again';            
    }    
    else {
        //check for existing username
        $selU = 'SELECT username FROM users WHERE username="'.$_POST['username'].'"';
        $resU = $conn->query($selU);

        if(mysqli_num_rows($resU) > 0) {
            $msg .= '<br />Username already is being used - please use another one';
        }
        else { 
            $updU = 'update users set username="'.$_POST['username'].'" where id="'.$u[id].'"';
            $resU = $conn->query($updU);
        }
    }
    $u = updateSession();    
}

if($_POST['pw']) {
    $newpass = $_POST['newpw'];
    if(!newpass)
        $msg = 'Password is blank - please try again';
    else {
        if($newpass != $_POST['verify']) 
            $msg = 'Passwords do not match - please try again';
        else {
            $updU = 'update users set password="'.$newpass.'" where username="'.$u['username'].'"';
            $resU = $conn->query($updU);

            $msg = 'Password updated';
            $u = updateSession();
        }
    }
}

$msg = '<font color=red><b>'.$msg.'</b></font>';

if($_SESSION['login']['username'] == 'VIPUser' || $_SESSION['login']['username'] == 'vipuser') {
    $disable = 'disabled'; 
    $warning = '<span class="red"><b>You are on a shared account, changing your details is not allowed</b></span><br /><br />';
}
?>
<p>&nbsp;</p>
<center>
<?=$msg?>
<?=$warning?>
<form method="POST">
    <div class="moduleBlue"><h1>Update Profile</h1>
    <div class="moduleBody">
        <br />
        <table>
        <tr>
            <td align="right">Username: </td>
            <td>
                <input <?=$disable?> type="text" class="activeField" name="username" value="<?=$u['username']?>" size="30" />
            </td>
        </tr>
        <tr>
            <td align="right">Paypal Email: </td>
            <td>
                <input <?=$disable?> type="text" class="activeField" name="email" value="<?=$u['email']?>" size="30" /> 
            </td>
        </tr>
        <tr>
            <td align="center" colspan="2">
                <input <?=$disable?> type=submit name=update value="Update Profile" class="btn primary" onclick="alert('Are you sure you want to update your username?')"  />
            </td>
        </tr>
        </table>
        <br/>
    </div>
    </div>
</form>

    <div class="moduleBlue"><h1>Change Password</h1>
    <div class="moduleBody">
        <form method="post">
        <table>
        <tr>
            <td>&nbsp;</td>
        </tr><tr align="center">
            <td align="right">New Password:</td>
            <td align="left"><input <?=$disable?> type="text" class="activeField" name="newpw" size="30">
            </td>
        </tr><tr>
            <td align="right">Confirm Password:</td>
            <td align="left"><input <?=$disable?> type="text" class="activeField" name="verify" size="30">
            </td>
        </tr><tr>
            <td align="center" colspan="2">
            <input <?=$disable?> type="submit" name="pw" value="Change Password" class="btn primary" /></td></tr>
            <tr><td>&nbsp;</td></tr>
        </table>
        </form>
    </div>
    </div>
</div>
</center>
<p>&nbsp;</p>