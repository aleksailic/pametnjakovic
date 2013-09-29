<?php
	require('includes/connect.php');

	$id=$_POST["id"];
	$time=$_POST["time"];
	$help=$_POST["help"];
	$score=$_POST["score"];

	/*----------POST VARIABLES ERROR HANDLING--------------*/
	// Required field names
	$required = array('id', 'time', 'help', 'score');
	// Loop over field names, make sure each one exists and is not empty
	$error = false;
	foreach($required as $field) {
	  if (empty($_POST[$field])) {
	    $error = true;
	  }
	}
	if ($error) {
	  die("Error parsing data");
	}
	/*-----------------------------------------------------*/

	$return_ach="";
	$ach="";


	$getUserData=pg_query($con,"SELECT * FROM scores WHERE fbid=$id");
	
	if (pg_num_rows($getUserData)==1){ //Korisnik je vec igrao igru pa ga ima u bazi
		while($row=pg_fetch_array($getUserData)){
			$my_time = $row["time"];
			$my_max_score = $row["maxscore"];
			$my_games = $row["games"];
			$sumscore=$row["score"];
			$ach = $row["achievments"];


			$newtime=$my_time+$time;//update-uj vreme
			if($score>$my_max_score){//ako je korisnik osvojio vise poena nego ranije, namesti novi skor. U suprotnom ostavi stari
				$new_max_score=$score;
			}else{
				$new_max_score=$my_max_score;
			}
			$new_games=$my_games+1;//update-uj partije
			$new_sumscore=$sumscore+$score;//update-uj sumscore

			//---------------------------------------------------------------------------------------------------------------------//
			$insertData=pg_query($con,"UPDATE scores SET time=$newtime,maxscore=$new_max_score,games=$new_games,score=$new_sumscore WHERE fbid=$id") or die("Error connecting to database");
			//--------------------------------------------------------------------------------------------------------------------//
			
		    if (strpos($ach,'uporan') !== false) {
			}else{
				//vise od 3partija, a osvojio ukupno manje od 60poena
			    if($new_games>3 && $new_sumscore<60){
			    	dodeli('uporan');	
			    }
			}
			if (strpos($ach,'postenjak') !== false) {
			}else{
				//nijedna pomoc, a preso vise of 60
			    if($help==false && $score>60){
			    	dodeli('postenjak');
			    }
			}
			if (strpos($ach,'puz') !== false) {
			}else{
				//igrao partiju duze od 10minuta i osvojio vise od 60poena
			    if($time>600 && $score>60){
			    	dodeli('puz');
			    }
			}
			if (strpos($ach,'starac') !== false){
			}else{
				//odigrao vise od 30partija
			    if($new_games>30){
			    	dodeli('starac');
			    }
			}
			if (strpos($ach,'pametnjakovic') !== false){
			}else{
				//vise ili jednako od 120p
			    if($score>=120){
			    	dodeli('pametnjakovic');
			    }
			}
			if (strpos($ach,'jaguar') !== false) {
			}else{
				//vise od 60poena za manje od 100s
			    if($score>60 && $time<100){
			    	dodeli('jaguar');
			    }
			}
			
		}
		pg_close($con) or die("Cannot close mysql connection");
	}


	function dodeli($new_ach){
		global $ach,$id,$con;
		if(empty($ach)){
			$ach=$new_ach;
		}else{
			$ach.=(';'.$new_ach);
		}
		
		pg_query($con,"UPDATE scores SET achievments='$ach' WHERE fbid=$id") or die("Error connecting to the database");
	}

	global $ach;
	if( empty($ach) ){
		echo false;
	}else{
		echo $ach;
	}
?>