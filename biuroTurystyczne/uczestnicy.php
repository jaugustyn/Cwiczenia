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
			<div class="mainleft">
				<hr><div style="text-align: center; color: #2C3E50; font-size: 25px;font-weight: bold;">Lista wycieczek</div><hr>
				<?php
					require_once 'functions.php';
					echo listaWycieczek2(getWycieczki());
				?>
			</div>
			<div class="mainright">
					<?php
						echo wykazUczestnikow();
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

<?php
	require_once 'functions.php';
?>


</body>
</html>