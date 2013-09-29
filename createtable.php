<?php
	include('includes/connect.php');
	echo 'IMMA GOIN TO TRY TO UPDATE DB!';
	pg_query($con,"CREATE TABLE IF NOT EXISTS `scores` (`id` int(11) NOT NULL AUTO_INCREMENT,
  `fbid` text CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `time` int(11) NOT NULL,
  `maxscore` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `games` int(11) NOT NULL,
  `achievments` text NOT NULL,
  PRIMARY KEY (`id`)
)") or die("DAFUQ HAPPENED!");
?>