$(document).ready(function(){
	$("#loader_holder").hide();
	$('a[href^="#"]').on('click',function (e) {
	    e.preventDefault();
	    var target = this.hash;
	   	num=0;
	    if(target=="#howto"){
	    	num=0;
	    }else if(target=="#game"){
	    	num=1300;
	    }else if(target=="#menu"){
	    	num=650;
	    }
	    $target = $(target);
	    $('#GAME').stop().animate({
	        'scrollTop': num,
	    }, 900, 'swing', function () {
	        window.location.hash = target;
	    });
	});

	$('a[href^="#game"]').click(function(){
		getXMLObject();
		resetGame();
	});


	$("#modal #close").click(function(){
		hideModal();
	});

	window.location.hash = '#menu';
});


function showModal(id){
	$('#modal #'+id).css('display','block');
	$("#modal_wrapper").fadeIn();
	$('#modal').animate({
		marginTop: '85px'
	}, 1000);
}
function hideModal(){
	$('#modal').animate({
		marginTop: '-500px'
	}, 1000,function(){
		$("#modal_wrapper").fadeOut();
		$('#modal>*:not(:first-child)').css('display','none');
	});
}

function changeProgress(value){
	$("#loading .progress>div").css("width",value+"%");

	if(value==100){
		setTimeout(function(){
			$("#loading").fadeOut('fast');
		},700);
	}
}
