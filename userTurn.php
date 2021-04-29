<?php
	session_start();
	
	require_once('czyAdmin.php');
	
	require_once('connect.php');
	$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
	
	$userTurn = $_GET['id'];
	
	$query = "SELECT userType FROM uzytkownicy WHERE id=".$userTurn;
	if($wynik = $polaczenie->query($query))
	{
		while($row = $wynik->fetch_assoc())
		{
			if($row['userType'] == 0)
			{
				$zmien = "UPDATE uzytkownicy SET userType=1 WHERE id=".$userTurn;
				if(mysqli_query($polaczenie, $zmien))	header('Refresh:0; url=users.php');
			}
			else
			{
				$zmien = "UPDATE uzytkownicy SET userType=0 WHERE id=".$userTurn;
				if(mysqli_query($polaczenie, $zmien))	header('Refresh:0; url=users.php');
			}
		}
	}
	else
	{
		echo "Zmiana typu użytkownika poszła nie tak!";
	}
?>