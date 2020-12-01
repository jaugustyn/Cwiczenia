<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Firma turystyczna - wycieczki za grosze</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript" src="functions.js"></script>
</head>
<body>
	<div class="container">
		<div class="banner"></div>
		<div class="menu">
			<ul class="menulist">
				<a href="index.php"><li>Strona główna</li></a>
				<a href="wycieczki.php"><li>Wykaz wycieczek</li></a>
				<a href="zapisy.php"><li>Zapisz się na wycieczkę!</li></a>
				<a href="uczestnicy.php"><li>Wykaz uczestników</li></a>
				<a href="Login.php"><li>Logowanie</li></a>
				<a href="Logout.php"><li>Wyloguj</li></a>
			</ul>
		</div>
		<main>
			<div class="maindiv">
				<div class="zapisytytul" id="zapisytytul">Wybierz wycieczkę, na którą chcesz się zapisać!</div>
				<div class="zapisylista" id="wynik">
<!-- 					<div class='line2'><label>Grecja</label><input type='button' name='{$line[1]}' value='Zapisz się!' onclick='formzapisy(this.id)' id='{$line[0]}'></div>
					<div class='line2'><label>Peru</label><input type='button' name='{$line[1]}' value='Zapisz się!' onclick='formzapisy(this.id)' id='{$line[0]}'></div>
					<div class='line2'><label>Karaiby</label><input type='button' name='{$line[1]}' value='Zapisz się!' onclick='formzapisy(this.id)' id='{$line[0]}'></div>
					<div class='line2'><label>Paryzparyzparyz</label><input type='button' name='{$line[1]}' value='Zapisz się!' onclick='formzapisy(this.id)' id='{$line[0]}'></div>
					<div class='line2'><label>Karaiby</label><input type='button' name='{$line[1]}' value='Zapisz się!' onclick='formzapisy(this.id)' id='{$line[0]}'></div>
					<div class='line2'><label>Karaiby</label><input type='button' name='{$line[1]}' value='Zapisz się!' onclick='formzapisy(this.id)' id='{$line[0]}'></div>
 -->				

					<?php 
						require_once "functions.php";
						echo listaZapisy(getWycieczki());
						echo uzytkownikDoZapisania();
					?>
				</div>
			</div>
		</main>
		<footer>
			<div>All Rights reserved
				<?php
					if (isset($_SESSION['login'])) {
						echo " | Zalogowano jako ".$_SESSION['login'];
					}
				 ?>
			</div>
		</footer>

	</div>


</body>
</html>