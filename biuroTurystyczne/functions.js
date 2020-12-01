window.onload = function(){

}


function idWycieczki(clicked_id){

	let id = parseInt(clicked_id);
	let name = document.getElementById(id).name;
	
	if(confirm("Czy na pewno chcesz wybrać wycieczkę - "+name+"?")){

		sessionStorage.setItem("nazwaWycieczki",`${name}`);
		window.location.href = "zapisy.php?id="+id;
	}
}


function formRejestracja(){
	let data = new Date();
	let m = data.getMonth();
	let d = data.getDate();
	let y = data.getFullYear();
	let max = `${y}-${m}-${d}`;
	
	wynik.innerHTML = `<form action='Login.php' name='myform' method='POST' class='rejestracjaform' onsubmit='return rejestracjaWalidacja();'>
			<fieldset style='background-color:#D1F2EB;'>
				<div class='line3first'>Rejestracja</div>
				<div class='line3'><label for='imie'>Imię: </label><input type='text' name='imie' required pattern='[A-Za-z]{1,30}' title='Tylko litery'></div>
				<div class='line3'><label for='nazwisko'>Nazwisko: </label><input type='text' name='nazwisko' required pattern='[A-Za-z]{1,30}' title='Tylko litery'></div>
				<div class='line3'><label for='email'>E-mail: </label><input type='text' name='email' required pattern='[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+[a-zA-z]'></div>
				<div class='line3'><label for='dataUr'>Data Urodzenia: </label><input type='date' name='dataUr' required min='1920-01-01' max=`+max+`></div>
				<div class='line3'><label for='password'>Hasło: </label><input type='password' name='password' onKeyUp='rejestracjaWalidacja()' id='password' required pattern="(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,}"></div>
				<div class='line3'><input type='submit' name='submit'>
				<a href='Login.php'><input type='button' value='Anuluj'></a>
				<div id='walidacja'></div></div>
			</fieldset>
		</form>`;
}


function rejestracjaWalidacja(){
	let password = document.querySelector('#password').value
	let walidacja = document.querySelector('#walidacja');
	
	if (password.length < 8) {
		walidacja.innerHTML = "Hasło musi zawierać min. 8 znaków";
		walidacja.style.color = '#86130a';
	}else{
		walidacja.innerHTML = '';
	}

	if (!/[A-Z]/.test(password)) {
		walidacja.innerHTML += "<br>Hasło musi zawierać dużą literę";
	}

	if (!/[a-z]/.test(password)) {
		walidacja.innerHTML += "<br>Hasło musi zawierać małą literę";
	}

	if (!/[0-9]/.test(password)) {
		walidacja.innerHTML += "<br>Hasło musi zawierać liczbę";
	}
}