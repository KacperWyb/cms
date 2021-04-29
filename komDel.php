<?php
	session_start();
	
	require_once('czyAdmin.php');
	
	include_once("connect.php");
	$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
	
	$komDel = $_GET['id'];
	
	$query = "DELETE FROM komentarze WHERE id=".$komDel;
	if(mysqli_query($polaczenie, $query))
	{
		header('Refresh:0; url=komentarze.php');
	}
	else
	{
		echo "Usuwanie komentarza poszło nie tak!";
	}
?>