<?php

require 'test_login.php';
require 'test_register.php';
require 'test_show.php';
require 'test_update.php';
require 'test_logout.php';
require 'utils.php';

/**********************************************/
/* replace $baseurl with your local directory */
/* or with the address on the server          */
/* https://saw21.dibris.unige.it/~S.....      */
/*                                            */
/* DO NOT UPLOAD TEST FILES ON SAW21!         */
/**********************************************/
$baseurl = "https://saw21.dibris.unige.it/~S5175314/Pages"; 
//$baseurl = "http://localhost/SAW/Pages";

echo "[+] Testing Registration - Login - Show Profile<br>";

echo "[*] Generating random user<br>";

echo "---<br>";
$email = generate_random_email();
$pass = generate_random_password();
$first_name = generate_random_name();
$last_name = generate_random_name();
echo "Email: $email<br>";
echo "Pass: $pass<br>";
echo "First name: $first_name<br>";
echo "Last name: $last_name<br>";
echo "---<br>";

echo "[-] Calling registration.php<br>";

register($email, $pass, $first_name, $last_name, $baseurl);

echo "[-] Calling login.php<br>";
login($email, $pass, $baseurl);


echo "[-] Calling show_profile.php<br>";

echo check_correct_user($email, $first_name, $last_name, show_logged_user($baseurl))
    ? "[*] Success :)<br>"
    : "[*] Failed<br>";

echo "------------------------<br>";

echo "[+] Testing Update - Show Profile<br>";

echo "[*] Generating new random user<br>";
$first_name = generate_random_name();
$last_name = generate_random_name();

echo "---<br>";
echo "Email: $email<br>";
echo "First name: $first_name<br>";
echo "Last name: $last_name<br>";
echo "---<br>";

echo "[-] Calling update_profile.php<br>";
update($email, $first_name, $last_name, $baseurl);

echo "[-] Calling show_profile.php<br>";

echo check_correct_user($email, $first_name, $last_name, show_logged_user($baseurl))
    ? "[*] Success :)<br>"
    : "[*] Failed<br>";


echo "---<br>";
echo "[+] Testing Logout - Show Profile<br>";
echo "[-] Calling logout.php<br>";
logout($baseurl);

echo "[-] Calling show_profile.php (it must fail after logout)<br>";
echo check_correct_user($email, $first_name, $last_name, show_logged_user($baseurl))
    ? "[*] Success<br>"
    : "[*] Failed :)<br>";

echo "------------------------<br>";
