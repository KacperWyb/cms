<?php
	
	include_once("connect.php");
	$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
	
	$czyAdmin = false;
		
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		//szuka uzytkownika zalogowanego i wybiera jego rekord po id
		$res = $polaczenie->query("SELECT userType FROM uzytkownicy WHERE id=".$_SESSION['id']);
		
		//sprawdza userType czy jest wiekszy od 0
		$czyAdmin = ($res->fetch_assoc())['userType'] > 0 ;
	}
	//jezeli nie jest adminem, otworz formularz logowania
	if(!$czyAdmin)
	{
		header('Location: logowanie.php');
	}
		
?>