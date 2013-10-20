<?php
$host='http://sql4.freesqldatabase.com';
$db='sql420761';
$user='sql420761';
$pass='bW5!fQ3%';
// Create connection
$con = new mysqli($host, $user, $pass, $db);
   if($mysqli->connect_error) {
     die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
   }
?> 