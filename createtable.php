<?php
	include('includes/connect.php');
	echo 'IMMA GOIN TO TRY TO UPDATE DB! AGAIN!';
	pg_query($con,"CREATE TABLE scores (
  id int(11) NOT NULL serial PRIMARY KEY,
  fbid text CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  time int(11) NOT NULL,
  maxscore int(11) NOT NULL,
  score int(11) NOT NULL,
  games int(11) NOT NULL,
  achievments text NOT NULL,
);") or die("WHY DONT YOU WORK!");

?>