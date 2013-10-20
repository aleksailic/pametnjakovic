<?php
	//include('includes/connect.php');

	// Create connection
	$con = new mysqli('http://sql4.freesqldatabase.com', 'sql420761','bW5!fQ3%', 'sql420761');
	   if($mysqli->connect_error) {
	     die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
	   }
	echo json_encode("IM A BARBIE GIRL IN A BARBIE WORLD");

	/*$id=mysqli_real_escape_string($_POST["id"]);
	$friends=mysqli_real_escape_string($_POST["friends"]); 
	$friend_ids=""; 

	for($i=0;$i<count($friends);$i++){
		$friend_ids.=$friends[$i]["id"].",";
	}
	$friend_ids=rtrim($friend_ids, ",");
	$friends_query = mysqli_query($con,"SELECT fbid,maxscore,achievments FROM scores WHERE fbid IN ($friend_ids) ORDER BY maxscore DESC LIMIT 0,6");
	$friend_html="";
	while($row = mysqli_fetch_array($friends_query))
	{
	  	$friend_html.="<li>";

	  	for($i=0;$i<count($friends);$i++){
			if ($friends[$i]["id"]==$row['fbid']){

				$friend_html.='<img width="40" height="40" src="'.$friends[$i]["picture"]["data"]["url"].'">';
				$friend_html.='<div class="text">'.$friends[$i]["name"].'</div>';
				$friend_html.='<div class="stats">';
				$friend_html.='<div class="score">score: '.$row['maxscore'].'</div>';

				$friend_html.='<div class="achievments">'.'<ul>';

				if($row["achievments"]==""){//nema achievmenta
					$friend_html.='<li id="bebac"></li>'; //dodaj bebac
				}else{//ima achievmenta
					$ach = split(';',$row["achievments"]);
					for($c=0;$c<count($ach);$c++){
						$friend_html.='<li id="'.$ach[$c].'"></li>';
					}
				}
				$friend_html.='</ul></div>';

				$friend_html.='</div>';
				//echo $friends[$i]["name"];
				break;
			}
		}

		$friend_html.="</li>";
	}

	$mystats=mysqli_query($con,"SELECT * FROM scores WHERE fbid=$id");
	
	if (mysqli_num_rows($mystats)==1){ //Korisnik je vec igrao igru pa ga ima u bazi
		$myachievments="";
		while($row=mysqli_fetch_array($mystats)){
			$mytime=gmdate("H:i:s", $row["time"]);
			$myscore = $row["maxscore"];
			$mygames = $row["games"];

			if($row["achievments"]==""){//nema achievmenta
				$myachievments.='<li id="bebac"></li>'; //dodaj bebac
			}else{//ima achievmenta
				$ach = split(';',$row["achievments"]);
				for($c=0;$c<count($ach);$c++){
					$myachievments.='<li id="'.$ach[$c].'"></li>';
				}
			}

			
		}
	}else{ //Korisnik nikada pre nije igrao igru pa ga nema u bazi
		$sql="INSERT INTO scores (fbid, time, maxscore,score,games)
		VALUES
		('$id',0,0,0,0)";
		mysqli_query($con,$sql);

		$mytime = 0;
		$myscore = 0;
		$mygames = 0;
		$myachievments = '<li id="bebac"></li>';
 
	}

	


	
	$returnArray=array('friends'=>$friend_html, 'mytime'=>$mytime, 'myscore'=>$myscore,'mygames'=>$mygames, 'myachievments'=>$myachievments,'FB_ID'=>$id);
	echo json_encode($returnArray);*/


?>