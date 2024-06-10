document.getElementById('update').style.display = "none";
let editBook = (e) => {
	let currentData = []
	for (let i = 0; i < e.parentElement.parentElement.children.length-1; i++) {
	  currentData.push(e.parentElement.parentElement.children[i].innerHTML.trim());
	}
	console.log(currentData);
	console.log(document.getElementById('authors').options);
	let selected_author_option = Array.from(document.getElementById('authors').options).map(option => option.text).findIndex(element => element === currentData[5]);
	let selected_store_option = Array.from(document.getElementById('stores').options).map(option => option.text).findIndex(element => element === currentData[4]);
	document.getElementById('isbn').value = currentData[0];
	document.getElementById('title').value = currentData[1];
	document.getElementById('price').value = currentData[2];
	document.getElementById('stock').value = currentData[3];
	document.getElementById('stores').value = selected_store_option;
	document.getElementById('authors').value = selected_author_option;
	
	document.getElementById('insert').style.display = 'none';
	document.getElementById('update').style.display = 'block';
	//document.getElementById('book_form').setAttribute('method', 'put');
	
}