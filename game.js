var selPitanje; //kreirati praznu varijablu koju cemo popuniti shodno progressu na kojem se igrac nalazi

function getXMLObject(){
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open("GET","d.xml",false);
	xmlhttp.send();
	xmlDoc=xmlhttp.responseXML;
	
	pitanja = xmlDoc.getElementsByTagName("pitanje");  //array koji drzi sva pitanja
}

function resetGame(){
	score=0;
	changeScore();
	progress=1;
	skipsLeft=2;
	multiplikacija_avail =true;
	newQuestion();
	$("#progress>*").removeClass();
	changeActiveQuestion();
	$("#skip").show();
	$("#skip").html(skipsLeft);

	stopwatchStart=new Date(); //pokreni stopericu
	helpUsed=false; //namesti da korisnik nije iskoristio niti jednu vrstu pomoci, sto ce nam koristiti za achievment

}

function newQuestion(){
	//brisemo odgovor iz textbox-a
	$(".status").hide(0);
	$(".textbox").val("");

	//Omoguci multiplikaciju u svakoj seriji od 5	
	if(progress==1 || progress==5 || progress==10){
		multiplikacija_avail=true;
		$("#multiplikacija").fadeIn();
	}

	if(progress<=15){//provera da li je igra gotova
		if(progress<=5){//odredjujemo tezinu pitanja na osnovu progress-a
			selPitanje = getQuestion('lako');
		}else if(progress>5 && progress<=10){
			selPitanje = getQuestion('srednje');
		}else if(progress>10){
			selPitanje = getQuestion('tesko');
		}
		
		printQuestion();
	}else{//igra je gotova
		gameOver();
	}

	
	
}

function gameOver(){
	stopwatchStop=new Date();
	stopwatchTime=(stopwatchStop - stopwatchStart) / 1000;

	$.ajax({
		type: "POST",
		url: "savedata.php",
		data: { id: FB_ID,time:stopwatchTime,help:helpUsed,score:score}
	}).done(function( msg ) {
		alert( "Data Saved: " + msg );
		/*$("#modal #friendstats ul").html(response.friends);
		$("#stats_time").append(response.mytime);
		$("#stats_score").append(response.myscore);
		$("#stats_games").append(response.mygames);
		$("#modal #achievments ul").html(response.myachievments);
		
		FB_ID=response.FB_ID;

		changeProgress(100);*/
	});
}

function printQuestion(){
	$("#loader_holder").show();
	var opts = {
	  lines: 11, // The number of lines to draw
	  length: 0, // The length of each line
	  width: 24, // The line thickness
	  radius: 60, // The radius of the inner circle
	  corners: 1, // Corner roundness (0..1)
	  rotate: 90, // The rotation offset
	  direction: 1, // 1: clockwise, -1: counterclockwise
	  color: '#000', // #rgb or #rrggbb
	  speed: 1.1, // Rounds per second
	  trail: 63, // Afterglow percentage
	  shadow: false, // Whether to render a shadow
	  hwaccel: false, // Whether to use hardware acceleration
	  className: 'spinner', // The CSS class to assign to the spinner
	  zIndex: 2e9, // The z-index (defaults to 2000000000)
	  top: 'auto', // Top position relative to parent in px
	  left: 'auto' // Left position relative to parent in px
	};
	var target = document.getElementById('loader_holder');
	var spinner = new Spinner(opts).spin(target);
	//proveravamo tip pitanja
	//N.B. prihvatamo samo youtube snimke	
	if(selPitanje.getElementsByTagName("tip")[0].firstChild.data == 'slika'){
		var image=new Image();
		image.height=500;
		console.log(selPitanje.getElementsByTagName("putanja")[0].firstChild.data);
		image.src=selPitanje.getElementsByTagName("putanja")[0].firstChild.data;
		
		//Postavljamo image load handler zbog smooth load-a
		$(image).load(function(){
			spinner.stop(target);
			$("#loader_holder").hide();

			$("#image_holder").fadeOut(function() {
				$(this).html(image).fadeIn();
			});
		});
	}else if(selPitanje.getElementsByTagName("tip")[0].firstChild.data == 'video'){
		var data='<iframe width="700" height="500" src="http://www.youtube.com/embed/'+selPitanje.getElementsByTagName("putanja")[0].firstChild.data+'?wmode=transparent;modestbranding=0;showinfo=0;iv_load_policy=3;autohide=0" frameborder="0"></iframe><div style="position:absolute;width:700px !important;height:25px !important;background:black;top:0;left:0;"></div><div style="position:absolute;width:700px !important;height:465px !important;background:transparent;top:0;left:0;"></div><div style="position:absolute;width:200px !important;height:27px !important;background:rgb(27, 27, 27);bottom:0;right:0;"></div>';
		//takodje dodajemo absolutni element koji ce prekriti kontrole snimka kao i link koji vodi ka youtube-u (time onemogucavamo korisnika da vidi naslov klipa)
		spinner.stop();
		$("#loader_holder").hide();
		$("#image_holder").fadeOut(function() {
			$(this).html(data).fadeIn();
		});
	}


}

function getQuestion(tezina){
	var tempArray = new Array(); //kreiramo Array koji ce drzati samo pitanje sa odredjenom tezinom
	
	for(var i=0;i<pitanja.length;i++){
		if(pitanja[i].getAttribute('tezina')==tezina){
			tempArray[tempArray.length] = pitanja[i]; //dodajemo pitanja nasem privremenom Array-u koja odgovara zadatoj tezini
		}
	}
	
	var randomNum = Math.floor(Math.random()*tempArray.length); //kreiramo nasumice odabran broj
	
	return tempArray[randomNum]; //vratimo u funkciju koja poziva getQuestion Array sa odredjenim pitanjem
}

function changeActiveQuestion(result){
    $('#progress li:nth-child('+progress+')').addClass('current tooltip');
    $('#progress li:nth-child('+progress+')').attr("data-tooltip", 'Pitanje: '+selPitanje.getElementsByTagName("tekst")[0].firstChild.data);

    if(result==true){
    	$('#progress li:nth-child('+(progress-1)+')').removeClass('current');
    	$('#progress li:nth-child('+(progress-1)+')').addClass('passed');
    }else if(result==false){
    	$('#progress li:nth-child('+(progress-1)+')').removeClass('current');
    	$('#progress li:nth-child('+(progress-1)+')').addClass('wrong');
    }

}

function checkAnswer(answer){
	//prvo dekapitalizujemo odgovor pa skidamo speciajlne karaktere karakteristicne samo za srpsku latinicu, pa na kraju tekst sa vise odgovora (odgovori su odvojeni znakom ;) pretvaramo u Array
	var odgovor = rmspecchar(selPitanje.getElementsByTagName("odgovor")[0].firstChild.data.toLowerCase()).split(";");
	var result = null;
	
	//proveravamo poklapanje sa svakim odgovorom
	//N.B. odgovori iz baze rade na principu kljucne reci
	if(progress<=15){ //da ne bi bilo provere nakon zavrsetka igre
		for(var i=0;i<odgovor.length;i++){
			var n = answer.indexOf(odgovor[i]);
			if(n>=0){//odgovor je tacan
				result=true;
				//dodaj odgovor u tooltip
				var html=$('#progress li:nth-child('+progress+')').attr("data-tooltip");
				$('#progress li:nth-child('+progress+')').attr("data-tooltip",html+' Odgovor: '+answer+'.');

				if(multiplikacija==true){//uvecaj skor u zavisnosti od multiplikacije
					score += progress*2
					multiplikacija_avail=false;
					multiplikacija=false;
					$("#multiplikacija").fadeOut();
				}else{
					score += progress 
				}
				
				progress++; //povecaj progress
				newQuestion(); // generisi novo pitanje
				changeActiveQuestion(true); //promeni aktivno pitanje
				break;
			}
		}
		if(result!=true){ //odgovor je netacan
			//dodaj tacan odgovor u tooltip
			var html=$('#progress li:nth-child('+progress+')').attr("data-tooltip");
			$('#progress li:nth-child('+progress+')').attr("data-tooltip",html+' Odgovor: '+odgovor[0]+'.');
			
			if(multiplikacija==true){//umanji skor u zavisnosti od multiplikacije
				score-= (15-(progress-1))*2;
				multiplikacija_avail=false;
				multiplikacija=false;
				$("#multiplikacija").fadeOut();
			}else{
				score-=(15-(progress-1));
			}

			progress++; //povecaj progress
			newQuestion(); // generisi novo pitanje
			changeActiveQuestion(false); //promeni aktivno pitanje
		}
		changeScore(); //napisi skor
	}
	
}

function skipQuestion(){
	//proveri da li postoje neiskorisceni preskoci
	if(skipsLeft>=1){
		helpUsed=true; //iskoristio je vrstu pomoci
		skipsLeft--;
		newQuestion();
		changeActiveQuestion(null);
		$("#skip").html(skipsLeft);
		if(skipsLeft==0)$("#skip").fadeOut();
	}
}


function changeScore(){
	$("#score").html(score); //napisi skor
}

$(document).ready(function(){

	$("#skip").click(function(){
		skipQuestion();
	});

	$("#multiplikacija").click(function(){
		if(multiplikacija_avail==true){
			helpUsed=true; //iskoristio je vrstu pomoci
			multiplikacija=true;
			$("#multiplikacija").fadeOut();
		}else{
			alert("VARAS SOME");
		}
		
	});

	$('#textbox').bind('keyup', function(e) {
		if ( e.keyCode === 13 ) { // 13 je enter
			//prvo dekapitalizujemo uneti tekst, pa ga pretvaramo u latinicu i na kraju brisemo specijalne karaktere karakteristicne samo za srpsku latinicu
			checkAnswer(rmspecchar(cirtolat(this.value.toLowerCase())));
		}
	});	
	
});