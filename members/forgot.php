<?
if($_POST['reset']) {
    $password = $_POST['password'];
    $confirm = $_POST['confirm']; 
    $username = $_POST['username']; 
    
    //password is blank
    if(empty($password))
    {
        $msg = 'Password cannot be blank';
    }
    else 
    {
        if($password != $confirm) //passwords do not match
        {
            $msg = 'Passwords do not match';
        }    
        else //update password
        {
            $upd = 'update users set password="'.$password.'" where username="'.$username.'"';
            $res = mysql_query($upd, $conn) or die(mysql_error());
            
            $msg = 'Successfully updated password';    
        }
    }    
}

if($_POST['forgot']) {
    $username = $_POST[username]; 
    $email = $_POST[email]; 

    $headers = "From: ".$val[adminEmail]."\n";
    $headers .= "Content-type: text/html;";     
    
    $activateLink = $websiteURL.'/members/?action=forgot&username='.$username.'&code='.strrev($username); 
    $subject = 'Reset Password - '.$val[businessName];
    $message = '<p>Hi there, </p>
    
    <p>You or somebody has requested to reset your password for the '.$val[businessName].'
    Members Area. To reset your password please click on the link below: </p>
    
    <p><a href="'.$activateLink.'">'.$activateLink.'</a></p>
    
    <p>Neobux Ultimate Strategy <br />
    Members Area </p>'; 
    
   // echo $message;
    
    //username is blank / email is blank 
    if(empty($username))
    {
        $msg = 'Username cannot be blank'; 
    }
    else 
    {
        if(empty($email))
        {
            $msg = 'Email cannot be blank';
        }
        else 
        {
            $selU = 'select username, email from users where username="'.$username.'"';
            $resU = mysql_query($selU, $conn) or die(mysql_error()); 
            $u = mysql_fetch_assoc($resU); 
            
            if(mysql_num_rows($resU) == 0)  //username does not exist
            {
                $msg = 'Username does not exist'; 
            }        
            else     
            {
                if($u[email] != $email)//username doesn't match email 
                {
                    $msg = 'Username does not match email address'; 
                }
                else //all conditions are cleared 
                {
                    //send activation link
                    mail($email, $subject, $message, $headers);
                    $msg = 'An email has been sent to your email address - Please check your inbox now';
                }
            }
        }
    }
}

if($_GET[code]) //reset passsword
{
    $username = $_GET[username];
    $code = $_GET[code]; 
    //check if code is correct 
    $selU = 'select username from users where username="'.$_GET[username].'" and username="'.strrev($code).'"';
    $resU = mysql_query($selU, $conn) or die(mysql_error()); 
    
    if(mysql_num_rows($resU) == 0)
    {
        $msg = 'Activation link is invalid'; 
        $disField = 'disabled'; 
    }
    
    $pageContent = '<h1>Reset Password</h1>
    <center>
    <form method=post>
    <p><font color=red>'.$msg.'</font></p>
    <table class="joinForm">
    <tr>
        <th colspan="2" align=center>Enter New Password</th>
    </tr>
    <tr>
        <td>New Password</td>
        <td><input type=text '.$disField.' class="activeField" name=password size="30" /></td>
    </tr>
    <tr>
        <td>Confirm Password </td>
        <td><input type=text '.$disField.' class="activeField" name=confirm size="30" /></td>
    </tr>
    <tr>
        <td colspan=2 align=center>
            <input type=submit name=reset class="btn danger" />
            <input type=hidden name=username value="'.$username.'" />
        </td>
    </tr>
    <tr>
        <td align=left><a href="./">Login</a></td>
    </tr>
    </table>    
    </form>
    </center>';
    
    echo '<p>&nbsp;</p>'.$pageContent.'<p>&nbsp</p>'; 
}
else //forgot password 
{
    include('login.html');
}


?>
