function scrol(event){

	let range = event.target.value;
	let inval = event.target.parentElement.parentElement.children[1].children[0];
	inval.setAttribute('value',range);
}