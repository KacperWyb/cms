<?php
	session_start();
	
	require_once('czyAdmin.php');
	
	include_once("connect.php");
	$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
	
	$pytDel = $_GET['id'];
	
	$query = "DELETE FROM pytania WHERE id=".$pytDel;
	if(mysqli_query($polaczenie, $query))
	{
		header('Refresh:0; url=zapytania.php');
	}
	else
	{
		echo "Usuwanie komentarza poszło nie tak!";
	}
?>