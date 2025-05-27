function filtraUtenti(valori){
	const cards=document.querySelectorAll('.row > .col-12');
	for(let i=0;i<cards.length;i++){
		cards[i].classList.remove('d-none');
	}
	for(let i=0; i<cards.length;i++){
		let val1=cards[i].querySelector('#ricerca1').innerText;
		let val2=cards[i].querySelector('#ricerca2').innerText;
		let val1Val2 = val1.toLowerCase() + ' ' + val2.toLowerCase();
		if(!val1Val2.includes(valori.value.toLowerCase())){
			cards[i].classList.add('d-none');
		}
	}			
}