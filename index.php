<?php
	session_start();
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<script type="text/javascript" src="includes/jquery.js"></script>
		<script type="text/javascript" src="game.js"></script>
		<script type="text/javascript" src="script.js"></script>
		<script type="text/javascript" src="convertor.js"></script>
		<script type="text/javascript" src="spin.js"></script>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link rel="stylesheet" type="text/css" href="achievments.css" />
	</head>
	<body>
		<div id="fb-root"></div>
		<script>
		  window.fbAsyncInit = function() {
		    // init the FB JS SDK
		    FB.init({
		      appId      : '492812057461588',                        // App ID from the app dashboard
		      channelUrl : 'localhost/channel.html', // Channel file for x-domain comms
		      status     : true,                                 // Check Facebook Login status
		      xfbml      : true                                  // Look for social plugins on the page
		    });

		    FB.Event.subscribe('auth.authResponseChange', function(response) {
			    // Here we specify what we do with the response anytime this event occurs. 
			    if (response.status === 'connected') {
			      // The response object is returned with a status field that lets the app know the current
			      // login status of the person. In this case, we're handling the situation where they 
			      // have logged in to the app.
			      testAPI();
			    } else if (response.status === 'not_authorized') {
			      // In this case, the person is logged into Facebook, but not into the app, so we call
			      // FB.login() to prompt them to do so. 
			      // In real-life usage, you wouldn't want to immediately prompt someone to login 
			      // like this, for two reasons:
			      // (1) JavaScript created popup windows are blocked by most browsers unless they 
			      // result from direct interaction from people using the app (such as a mouse click)
			      // (2) it is a bad experience to be continually prompted to login upon page load.
			      FB.login();
			    } else {
			      // In this case, the person is not logged into Facebook, so we call the login() 
			      // function to prompt them to do so. Note that at this stage there is no indication
			      // of whether they are logged into the app. If they aren't then they'll see the Login
			      // dialog right after they log in to Facebook. 
			      // The same caveats as above apply to the FB.login() call here.
			      FB.login();
			    }
			});

		    // Additional initialization code such as adding Event Listeners goes here
		  };
		  function testAPI() {
		    FB.api('/me?fields=friends.fields(picture.width(40).height(40),name,id),id,picture', function(response) {
			    $.ajax({
					type: "POST",
					url: "getdata.php",
					data: { id: response.id, friends:response.friends.data}
				}).done(function( msg ) {
					var response = jQuery.parseJSON(msg);
					console.log(response);
					//alert( "Data Saved: " + msg );
					$("#modal #friendstats ul").html(response.friends);
					$("#stats_time").append(response.mytime);
					$("#stats_score").append(response.myscore);
					$("#stats_games").append(response.mygames);
					$("#modal #achievments ul").html(response.myachievments);
					
					FB_ID=response.FB_ID;

					changeProgress(100);
				});
		    });
		  }

		  // Load the SDK asynchronously
		  (function(d, s, id){
		     var js, fjs = d.getElementsByTagName(s)[0];
		     if (d.getElementById(id)) {return;}
		     js = d.createElement(s); js.id = id;
		     js.src = "//connect.facebook.net/en_US/all.js";
		     fjs.parentNode.insertBefore(js, fjs);
		   }(document, 'script', 'facebook-jssdk'));

		  $(document).ready(function(){

		  	changeProgress(20);
		  });

		</script>
		<div id="HEADER">
			<div style="height:10px;width:100%;"></div>
			<a href="http://www.facebook.com/pametnjakovicapp"><img src="sprites/header.png" alt="header"></a>
		</div>
		<div id="GAME">

		<div id="loading">
			<img src="icon.png" width="180" height="180" alt="logo">
			<div class="text">ПАМЕТЊАКОВИЋ</div>
			<div class="progress">
				<div></div>
			</div>
			<div class="copyright">Copyright © 2013 Aleksa Ilic</div>
		</div>

		<!-- Slike -->
		<img src="sprites/cica_glisa.png" alt="glisa" id="img_cica_glisa">
		<img src="sprites/iks-oks.png" alt="X-O" id="img_iks_oks">
		<img src="sprites/ocena.png" alt="ocena" id="img_ocena">
		<img src="sprites/netacno.png" alt="zvrlja" id="img_netacno">
		<!--______-->

		<div class="page" id="howto">
			<div class="menu_holder">
				<a href="#" class="button">Sounds</a>
				<a style="margin-top:60px" href="#" class="button">Animation</a>
				<a style="margin-top:60px" href="#menu" class="button">Back</a>
			</div>
		</div>
		<div class="page" id="menu">
			<div class="menu_holder">
				<a href="#game" class="button">Igraj</a>
				<a style="margin-top:60px" href="javascript:showModal('pravila')" class="button">Pravila</a>
				<!-- <a style="margin-top:60px" href="#howto" class="button">Kreiraj pitanje</a> -->
				<a style="margin-top:60px" href="javascript:showModal('stats')" class="button">Stats</a>
			</div>
		</div>
		<div style="padding-top:10px;" class="page" id="game">
			<div id="image_holder">
			</div>
			<div id="loader_holder">
			</div>
			
			<ul id="progress">
				<li>1</li>
				<li>2</li>
				<li>3</li>
				<li>4</li>
				<li>5</li>
				<li>6</li>
				<li>7</li>
				<li>8</li>
				<li>9</li>
				<li>10</li>
				<li>11</li>
				<li>12</li>
				<li>13</li>
				<li>14</li>
				<li>15</li>
			</ul>
			
			<div id="navigation">
				<label>Odgovor:</label>
				<div class="input_holder">
					<input id="textbox" class="textbox" type="text" maxlength="30">
				</div>

				<div id="aside_wrapper">
					<div id="score">0</div>
					<div class="pomoc" id="skip">2</div>
					<div class="pomoc" id="multiplikacija"></div>
				</div>
				
				
			</div>
		</div>

		<div id="modal_wrapper">
			<div id="modal">
				<div id="close"></div>
				<div id="stats" class="content">
					<div id="mystats">
						<div class="header">
							MOJI REZULTATI
						</div>
						<div>
							<p id="stats_time">VREME: </p>
							<p id="stats_score">MAKSIMALAN SKOR: </p>
							<p id="stats_games">BROJ PARTIJA: </p>
						</div>
					</div>
					<div id="friendstats">
						<ul>
							
						</ul>
					</div>
					<div id="achievments">
						<ul>
						</ul>
					</div>
				</div>
				<div id="pravila" class="content">
					KLIKNES IGRAJ, I TO JE TO.
				</div>
			</div>
		</div>

		</div>
	</body>
</html>