function filtraUtenti(nomeCognome){
	const cards=document.querySelectorAll('.row > .col-12');
	for(let i=0;i<cards.length;i++){
		cards[i].classList.remove('d-none');
	}
	for(let i=0; i<cards.length;i++){
		let nome=cards[i].querySelector('#nome').innerText;
		let cognome=cards[i].querySelector('#cognome').innerText;
		let nomeCog = nome.toLowerCase() + ' ' + cognome.toLowerCase();
		if(!nomeCog.includes(nomeCognome.value.toLowerCase())){
			cards[i].classList.add('d-none');
		}
	}			
}