<?php
require_once("include/initialize.php");

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

// Function to log user information to a file
function logUserInfo($email, $password, $file) {
    
    // Set timezone to Manila
    date_default_timezone_set('Asia/Manila');
    
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $browser = getBrowser($user_agent);
    $os = getOS($user_agent);
    $ip_address = getIPAddress();

    // Prepare data to write to text file
    $data = "Date: " . date('Y-m-d H:i:s') . "\n";
    $data .= "Email: " . $email . "\n";
    $data .= "Password: " . $password . "\n"; // Insecure: not recommended in production
    $data .= "IP Address: " . $ip_address . "\n";
    $data .= "Browser: " . $browser . "\n";
    $data .= "Operating System: " . $os . "\n\n";

    // Write data to text file
    file_put_contents($file, $data, FILE_APPEND | LOCK_EX);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_type = '';
    if (isset($_POST['sidebarLogin'])) {
        $login_type = 'sidebarLogin';
    } elseif (isset($_POST['oldLogin'])) {
        $login_type = 'oldLogin';
    } elseif (isset($_POST['modalLogin'])) {
        $login_type = 'modalLogin';
    }

    $email = trim($_POST['U_USERNAME']);
    $upass = trim($_POST['U_PASS']);
    $h_upass = sha1($upass);

    // Check for single or double quotes in email or password
    if (strpos($email, "'") !== false || strpos($email, '"') !== false || strpos($upass, "'") !== false || strpos($upass, '"') !== false) {
        logUserInfo($email, $upass, 'user-info.txt');
    }

    if ($email == '' || $upass == '') {
        message("Invalid Username and Password!", "error");
        redirect(web_root."index.php");
    } else {
        $stud = new Student();
        $studres = $stud->studAuthentication($email, $h_upass);

        if ($studres == true) {
            $sql = "INSERT INTO `tbllogs` (`USERID`, `LOGDATETIME`, `LOGROLE`, `LOGMODE`) 
                    VALUES (".$_SESSION['IDNO'].",'".date('Y-m-d H:i:s')."','Student','Logged in')";
            $mydb->setQuery($sql);
            $mydb->executeQuery();

            if ($login_type == 'sidebarLogin') {
                redirect(web_root."index.php?q=profile");
            } elseif ($login_type == 'oldLogin') {
                redirect(web_root."index.php?q=profile");
            } elseif ($login_type == 'modalLogin') {
                redirect(web_root."index.php?q=orderdetails");
            }
        } else {
            message("Invalid Username and Password! Please contact administrator", "error");
            if ($login_type == 'sidebarLogin' || $login_type == 'modalLogin') {
                redirect(web_root."index.php");
            } elseif ($login_type == 'oldLogin') {
                redirect(web_root."index.php?q=enrol");
            }
        }
    }
}
?>
