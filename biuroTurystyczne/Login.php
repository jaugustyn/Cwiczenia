<?php
	session_start();

	if (isset($_SESSION["loggedin"]) && $_SESSION['loggedin']===true) {
		$_SESSION['uloggedin']= "Jesteś już zalogowany";
		header("location: index.php");
		exit;
	}
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
			<div id="wynik" class="wyniklogin">
				<form class="login" action="" method="POST">
					<fieldset class="center" style="width: 380px;height: 220px;">
						<div class="line3first">Zaloguj się</div>
						<div class="line3"><label for="loginEmail">E-mail: </label><input type="text" name="loginEmail" required></div>
						<div class="line3"><label for="loginPassword">Hasło: </label><input type="password" name="loginPassword" required pattern='[A-Za-z0-9!@#$%^&*(),.?":{}|<>]{8,}'></div>
						<div class="line3"><input type="submit" value="Zaloguj!" name="loginsubmit"><br><a style="cursor: pointer;" onclick="formRejestracja()">Nie masz konta? Zarejestruj się</a></div>
						<span id="error"></span>
					</fieldset>
	       		</form>
	       		<?php
					require_once "functions.php";
					rejestracjaKonta();
					login();
				?>
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