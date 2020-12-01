<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Firma turystyczna - wycieczki za grosze</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">
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
			<div id="welcome">
				<div style="width: 50%;text-align: center;margin: auto;padding-top: 100px;font-size: 30px;">Witamy na stronie firmy turystycznej<br><b>Wycieczki za grosze!</b></div></br></br><div style="width: 30%;text-align: center;margin: auto;font-size: 20px;">Zapraszamy do zapoznania się z naszą ofertą</div>
				<div id="wynik" style="text-align: center;margin-top:50px;font-size: 20px;color: green;"></div>
				<?php
					require_once 'functions.php';
					
					if (isset($_SESSION['rejestracjaOK'])) {
						echo "<script type='text/javascript'>welcome.innerHTML = '';</script>";
						echo "<div style='margin:auto; width:20%;text-align:center;padding-top:100px;'>".$_SESSION['rejestracjaOK']."</div>";
						unset($_SESSION['rejestracjaOK']);
					}
					if (isset($_SESSION['uloggedin'])) {
						echo "<div style='margin:auto; width:20%;text-align:center;font-size:25px;color:green;'>".$_SESSION['uloggedin']."</div>";
						unset($_SESSION['uloggedin']);
					}
					
				?>
			</div>
		</main>
		<footer>
			<div>All Rights reserved
				<?php
					if (isset($_SESSION['login'])) {
						echo " | Zalogowano jako ".$_SESSION['login'];
					}
					if (isset($_SESSION['wiadomosc'])) {
					 	echo $_SESSION['wiadomosc'];unset($_SESSION['wiadomosc']);
					 }
				 ?>
				
			</div>
		</footer>

	</div>




</body>
</html>