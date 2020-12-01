<?php

function getConn(){
	$conn = new mysqli("localhost","root",null,"wycieczki");
	if($conn->connect_errno!=0) return null;
	$conn->query("SET NAMES UTF8");
	return $conn;
}


function getWycieczki():array{
	$conn=getConn();
		if ($conn==null) {
			return [];
		}
	$dane = [];
	$sql = "SELECT id_wycieczki,nazwa,aktualnaIloscMiejsc from wycieczki";
	$result = $conn->query($sql);
	if (!$result){
		die("Błąd danych lub DB! Błąd: ".$conn->error);
	}
	while ($row = $result->fetch_row()){
		$dane[] = $row; 
	}
	$conn->close();
	return $dane;
}

function listaWycieczek(array $dane):string{

	$html = "<ol class='listaWycieczek'>";
	foreach ($dane as $line) {
	 	$html .= "<li><a href='wycieczki.php?id={$line[0]}'>{$line[1]}</a></li>";
	}
	$html .= "</ol>";

	return $html;
}


function listaWycieczek2(array $dane):string{

	$html = "<ol class='listaWycieczek'>";
	foreach ($dane as $line) {
	 	$html .= "<li><a href='uczestnicy.php?id={$line[0]}'>{$line[1]}</a></li>";
	}
	$html .= "</ol>";

	return $html;
}


function infoOWycieczkach():string{

	if (!empty($_GET['id'])) $id = $_GET['id'];
	if (isset($id)) {
	
		$conn=getConn();
		if ($conn==null) {
			return [];
		}
		$dane = [];
		$sql = "SELECT nazwa,miejsca,aktualnaIloscMiejsc, data, cena from wycieczki where id_wycieczki='{$id}'";
		$result = $conn->query($sql);
		if (!$result){
			die("Błąd danych lub DB! Błąd: ".$conn->error);
		}
		$row = $result->fetch_row();
		$conn->close();

		$html = "<div class='center'>
					<div class='line'><b>{$row[0]}</b></div>
					<div class='line'>Całkowita ilość miejsc: <b>{$row[1]}</b></div>
					<div class='line'>Aktualna ilość wolnych miejsc: <b>{$row[2]}</b></div>
					<div class='line'>Data: <b>{$row[3]}</b></div>
					<div class='line'>Cena: <b>{$row[4]}</b></div>
				</div>";

		return $html;
	}else{
		$html = "<div class='line' style='width:50%;margin:auto;margin-top:100px;'>Wybierz z panelu obok wycieczkę, która Cie interesuje!</div>";
		return $html;
	}
}


function listaZapisy(array $dane):string{
	$html = "<table class='tablezapisy'><tr><th class='thzapisy'>Nazwa</th><th class='thzapisy'>Miejsca</th><th class='thzapisy'>Chętny?</th></tr>";
	foreach ($dane as $line) {
		if ($line[2]>0) {
			$html .= "<tr>
						<td class='tdzapisy'>{$line[1]}</td>
						<td class='tdzapisy'>{$line[2]}</td>
						<td class='tdzapisy'><input type='button' name='{$line[1]}' value='Zapisz się!' onclick='idWycieczki(this.id)' id='{$line[0]}'></td>
 					</tr>";
		}else{
			$html .= "<tr>
						<td class='tdzapisy'>{$line[1]}</td>
						<td class='tdzapisy'>{$line[2]}</td>
						<td class='tdzapisy'><input type='button' value='Niedostępne' style='color:red;'></td>
 					</tr>";
		}	 	
	}
	$html .= "</table>";
	return $html;
}


function uzytkownikDoZapisania(){

	if (filter_has_var(INPUT_GET, 'id')) {
		if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
			
			$wycieczkaID = $_GET['id']; // ID wycieczki
			$userID = $_SESSION['userID']; // ID użytkownika
			$login = $_SESSION['login']; // Email/login

			$conn=getConn();
			if ($conn==null) {
				return [];
			}

			// CHECK czy uzytkownik juz jest zapisany na tą wycieczke czy nie
			$check = $conn->query("SELECT ID_wpisu FROM zapisaninawycieczki WHERE ID_uzytkownika = {$userID} AND ID_wycieczki = {$wycieczkaID}");
			$rowcheck = $check->num_rows;
			
			// Zapisanie uzytkownika na wycieczke //
			if ($rowcheck == 0) {
				$sql = "INSERT INTO zapisaninawycieczki (ID_uzytkownika,ID_wycieczki) VALUES ({$userID},{$wycieczkaID});";
				$result = $conn->query($sql);
				if (!$result){
					echo "ERROR: Nie udało się zapisać na wycieczkę";
				}else{

					// AKTUALIZACJA ilości miejsc w wycieczkach po zapisie //
					$sql2 = "UPDATE wycieczki SET AktualnaIloscMiejsc = AktualnaIloscMiejsc-1 WHERE ID_wycieczki = {$wycieczkaID};";
					$update = $conn->query($sql2);
					if (!$update) {
						echo "ERROR";
					}
					echo "<div style='font-size:25px;color:green;margin-top:25px;'>Zostałeś zapisany na wycieczkę</div>";
					header( "refresh:5; url=zapisy.php" );
				}
			}else{
				echo "<div style='font-size:25px;color:#86130a;margin-top:25px;'>Już jesteś zapisany na tę wycieczkę!</div>";
			}
			$conn->close();

		}else{
			echo "<div style='font-size:25px;color:#86130a;margin-top:25px;'>Aby zapisać się na wycieczkę musisz być zalogowany!</div>";
		}
	}
}


function wykazUczestnikow():string{

	if (!empty($_GET['id'])) $id = $_GET['id'];

	if (isset($_SESSION["loggedin"]) && $_SESSION['loggedin']===true) {
		if (isset($id)) {

			$conn=getConn();
			if ($conn==null) {
				return [];
			}
			$uczestnicy = [];
			$sql = "SELECT u.imie, u.nazwisko, u.email, u.data_urodzenia FROM `uzytkownicy` as u INNER JOIN zapisaninawycieczki as z ON u.ID_uzytkownika = z.ID_uzytkownika WHERE z.ID_wycieczki = '{$id}' ORDER BY u.nazwisko";
			$result = $conn->query($sql);
			if (!$result){
				die("Błąd danych lub DB! Błąd: ".$conn->error);
			}

			while ($row = $result->fetch_row()){
				$uczestnicy[] = $row; 
			}
			$html = "<table class='tableuczestnicy'><tr><th class='thuczestnicy'>Imie</th><th class='thuczestnicy'>Nazwisko</th><th class='thuczestnicy'>Wiek</th><th class='thuczestnicy'>Email</th></tr>";

			foreach ($uczestnicy as $line) {

				$skroconyEmail = substr($line[2], 0, strpos($line[2], '@'))." . . .";
				$currentDate = date_create(date('Y-m-d'));
				$dataUr = date_create($line[3]);
				$wiek = date_diff($dataUr,$currentDate)->format('%y');

				$html .= "<tr><td class='tduczestnicy'>{$line[0]}</td><td class='tduczestnicy'>{$line[1]}</td><td class='tduczestnicy'>{$wiek}</td><td class='tduczestnicy'>{$skroconyEmail}</td></tr>";
			}

			if (empty($uczestnicy)) {
				$html .= "<tr><td class='tduczestnicy' colspan='4'>Brak uczestników</td></tr>";
			}

			$html .= "</table>";
			$conn->close();

			return $html;
		}else{
			$html = "<div class='line' style='width:50%;margin:auto;margin-top:100px;'>Wybierz z panelu obok wycieczkę, z której chciałbyś zobaczyć listę uczestników!</div>";
			return $html;
		}
	}else{
		$html = "<div class='line' style='color:#86130a;width:50%;margin:auto;margin-top:100px;'>Aby wyświetlić uczestników należy się zalogować!</div>";
		return $html;
	}
}


function rejestracjaKonta(){

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if (isset($_POST['submit'])) {

			$imie = filter_input(INPUT_POST,'imie',FILTER_SANITIZE_STRING);
			$nazwisko = filter_input(INPUT_POST,'nazwisko',FILTER_SANITIZE_STRING);
			$email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
			$dataUr = filter_input(INPUT_POST,'dataUr');
			$password = password_hash(filter_input(INPUT_POST,'password'),PASSWORD_DEFAULT);

			if (!empty($imie) && !empty($nazwisko)&& !empty($email) && !empty($dataUr) && !empty($password)) {
				
				echo "<script type='text/javascript'>wynik.innerHTML='';wynik.style.textAlign='center';</script>";
				echo "<div class='formerror1'>";

// WALIDACJA DANYCH //
				if (!preg_match("/^[a-zA-z]*$/", $imie)) {
					$imieOK = false;
					echo "<div class='formerror'>Imie może zawierać jedynie litery</div>";
				}else{
					$imieOK = true;
				}

				if (!preg_match("/^[a-zA-z]*$/", $nazwisko)) {
					$nazwiskoOK = false;
					echo "<div class='formerror'>Nazwisko może zawierać jedynie litery</div>";
				}else{
					$nazwiskoOK = true;
				}

				if (!preg_match("/^(?=.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/", filter_input(INPUT_POST,'password'))) {
					$passwordOK = false;
					echo "<div class='formerror'>Hasło musi zawierać min. 8 znaków; w tym 1 dużą, małą i cyfrę</div>";
				}else{
					$passwordOK = true;
				}

				$d = strtotime("-100 Years");
				if ($dataUr < date("Y-m-d", $d)) {
					$dataUrOK = false;
					echo "<div class='formerror'>Rok urodzenia nie może przekraczać 100 lat</div>";
				}else{
					$dataUrOK = true;
				}
				
				if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
					$emailOK = false;
					echo "<div class='formerror'>Błędnie podany Email</div>";
				}else{
					$emailOK = true;
				}
// KONIEC WALIDACJI //

				if ($imieOK ===true && $nazwiskoOK === true && $dataUrOK === true && $emailOK === true && $passwordOK === true) {

					$conn=getConn();
					if ($conn==null) {
						return [];
					}

					// Dodanie uzytkownika do bazy danych //
					$sql = "INSERT INTO uzytkownicy (Imie,Nazwisko,Email,data_urodzenia,Haslo) VALUES ('{$imie}','{$nazwisko}','{$email}','{$dataUr}','{$password}');";
					$result = $conn->query($sql);
					if (!$result){
						echo("<div class='formerror'>Wybrany adres Email jest już w użyciu</div>");
					}else{
					$conn->close();

					session_start();
					$_SESSION['rejestracjaOK'] = "<div style='font-size:20px;font-weight:bold; border: 5px #116466 dashed;padding:25px;background-color:#D1F2EB'>Zostałeś poprawnie zarejestrowany<div><a href='login.php'>Logowanie</a></div></div>";
					header('Location: index.php');
					}
				}else{
					echo "<hr style='border-bottom:1px solid #D1F2EB;border-top: 1px solid #86130a;'><div class='formerror' style='font-weight:bold';>Proszę uzupełnić formularz poprawnymi danymi</div></div>";
				}

			}else{
				return false;
			}
		}else{
			return false;
		}
	}
}


function login(){
	
	if (isset($_POST['loginsubmit']) && $_SERVER['REQUEST_METHOD'] =="POST") {

		$login = filter_input(INPUT_POST,'loginEmail');

		if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
			echo "";
		} else {
		    echo "<script type='text/javascript'>error.innerHTML='Błędny email';</script>";
		    return false;
		}

		if (!empty($login) && !empty(filter_input(INPUT_POST,'loginPassword'))) {
			
			$conn=getConn();
			if($stmt = $conn->prepare("SELECT ID_uzytkownika,Haslo FROM uzytkownicy WHERE Email = ?;")){
				$stmt->bind_param('s', $login);
				$stmt->execute();
				$stmt->store_result();

				if ($stmt->num_rows >0) {
						
					$stmt->bind_result($id,$passwordFromDB);
					$stmt->fetch();

					if (password_verify(filter_input(INPUT_POST,'loginPassword'), $passwordFromDB)) {
						
						session_regenerate_id();
						$_SESSION['loggedin'] = true;
						$_SESSION['login'] = $login;
						$_SESSION['userID'] = $id;
						$_SESSION['wiadomosc'] = "<script type='text/javascript'>wynik.innerHTML='Pomyślnie zalogowano ".$_SESSION['login']." '</script>";
						header('Location:index.php');
					}else{
						echo "<script type='text/javascript'>error.innerHTML='Błędny email lub hasło';</script>";
					}

				}else{
					echo "<script type='text/javascript'>error.innerHTML = 'Nie ma takiego użytkownika';</script>";
				}

				$stmt->close();
			}else{
				echo "<script type='text/javascript'>error.innerHTML = 'Nie ma takiego użytkownika';</script>";
			}
			$conn->close();
		}else{
			return false;
		}
	}else{
		return false;
	}
}