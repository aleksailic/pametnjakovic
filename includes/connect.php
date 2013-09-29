<?php
$host='ec2-54-227-243-78.compute-1.amazonaws.com';
$db='daks89rtc2s34u';
$user='donuebzgpwolvq';
$pass='K_dICZAIT-Phx9YI5IHDb6OA7t';
// Create connection
$con = pg_connect("host=$host dbname=$db user=$user password=$pass") or die ("Could not connect to server\n"); 

/*$con=mysqli_connect("localhost","root","impressed","pametnjakovic");
// Check connection
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }*/
?> 