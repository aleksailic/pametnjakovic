function cirtolat(text) {
	text = text.replace(/љ/g,'lj');
	text = text.replace(/Љ/g,'Lj');
	text = text.replace(/њ/g,'nj');
	text = text.replace(/Њ/g,'Nj');                                          
	text = text.replace(/џ/g,'dž');
	text = text.replace(/Џ/g,'Dž');
	text = text.replace(/а/g,'a');
	text = text.replace(/б/g,'b');
	text = text.replace(/ц/g,'c');
	text = text.replace(/ч/g,'č');
	text = text.replace(/ћ/g,'ć');
	text = text.replace(/д/g,'d');
	text = text.replace(/ђ/g,'đ');
	text = text.replace(/е/g,'e');
	text = text.replace(/ф/g,'f');
	text = text.replace(/г/g,'g');
	text = text.replace(/х/g,'h');
	text = text.replace(/и/g,'i');
	text = text.replace(/ј/g,'j');
	text = text.replace(/к/g,'k');
	text = text.replace(/л/g,'l');
	text = text.replace(/м/g,'m');
	text = text.replace(/н/g,'n');
	text = text.replace(/о/g,'o');
	text = text.replace(/п/g,'p');
	text = text.replace(/р/g,'r');
	text = text.replace(/с/g,'s');
	text = text.replace(/ш/g,'š');
	text = text.replace(/т/g,'t');
	text = text.replace(/у/g,'u');
	text = text.replace(/в/g,'v');
	text = text.replace(/з/g,'z');
	text = text.replace(/ж/g,'ž');
                                                      
	text = text.replace(/А/g,'A');
	text = text.replace(/Б/g,'B');
	text = text.replace(/Ц/g,'C');
	text = text.replace(/Ч/g,'Č');
	text = text.replace(/Ћ/g,'Ć');
	text = text.replace(/Д/g,'D');
	text = text.replace(/Ђ/g,'Đ');
	text = text.replace(/Е/g,'E');
	text = text.replace(/Ф/g,'F');
	text = text.replace(/Г/g,'G');
	text = text.replace(/Х/g,'H');
	text = text.replace(/И/g,'I');
	text = text.replace(/Ј/g,'J');
	text = text.replace(/К/g,'K');
	text = text.replace(/Л/g,'L');
	text = text.replace(/М/g,'M');
	text = text.replace(/Н/g,'N');
	text = text.replace(/О/g,'O');
	text = text.replace(/П/g,'P');
	text = text.replace(/Р/g,'R');
	text = text.replace(/С/g,'S');
	text = text.replace(/Ш/g,'Š');
	text = text.replace(/Т/g,'T');
	text = text.replace(/У/g,'U');
	text = text.replace(/В/g,'V');
	text = text.replace(/З/g,'Z');
	text = text.replace(/Ж/g,'Ž');

	return text;
}

function rmspecchar(text){
	text=text.replace(/č/g,"c");
	text=text.replace(/ć/g,"c");
	text=text.replace(/đ/g,"dj");
	text=text.replace(/š/g,"s");
	text=text.replace(/ž/g,"z");
	
	return text;

}