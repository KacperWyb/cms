<?php
	session_start();
	
	require_once('czyAdmin.php');
	
	require_once('connect.php');
	$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
	
	$userDel = $_GET['id'];
	
	$query = "DELETE FROM uzytkownicy WHERE id=".$userDel;
	if(mysqli_query($polaczenie, $query))
	{
		header('Refresh:0; url=users.php');
	}
	else
	{
		echo "Usuwanie użytkownika poszło nie tak!";
	}
?>