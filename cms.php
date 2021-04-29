<html>
<head>
	<style>
		#menuCms
		{
			width: 100%;
			font-size: 20px;
		}
		.cms
		{
			text-align: center;
			display: inline-block;
			padding-top: 1%;
			padding-bottom: 1%;
			padding-left: 0.5%;
			padding-right: 0.5%;
			transition-duration: 0.5s;
		}
		.cms:hover
		{
			color: #31E6DF;
			padding-right: 40px;
			padding-left: 40px;
		}
	</style>
</head>
<div id="container">

<?php

	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
	
	$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
	
	if($polaczenie->connect_errno!=0)
	{
		throw new Exception(mysqli_connect_errno());
	}
	else
	{
		$czyAdmin = false;
		
		if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
		{
			//szuka uzytkownika zalogowanego i wybiera jego rekord po id
			$res = $polaczenie->query("SELECT userType FROM uzytkownicy WHERE id=". $_SESSION['id']);
			
			//sprawdza userType czy jest wiekszy od 0
			$czyAdmin = ($res->fetch_assoc())['userType'] > 0 ;
		}
		//jezeli nie jest adminem, przerwij skrypt
		if(!$czyAdmin)
		{
			return;
		}
		
		// echo $czyAdmin ? "TAK" : "NIE";
	}
			
echo<<<END
	
	
	<div id="menuCms">
		<a href="http://k19.unixstorm.org/phpMyAdmin" target="_blank"><div class="cms">Baza danych</div></a>
		<a href="dodajPost.php"><div class="cms">Dodaj post</div></a>
		<a href="wszystkiePosty.php"><div class="cms">Posty</div></a>
		<a href="komentarze.php"><div class="cms">Komentarze</div></a>
		<a href="zapytania.php"><div class="cms">Zapytania</div></a>
		<a href="users.php"><div class="cms">Użytkownicy</div></a>
		
		<div class="typeUser" style="float: right;">Administrator</div>
	</div>
		
	<div style="clear:both;">
	<hr style="border: 1px solid #00a3cc"></hr>
	
END
	
?>
</div>