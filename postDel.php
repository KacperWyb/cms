<?php
	session_start();
	
	require_once('czyAdmin.php');
	
	include_once("connect.php");
	$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
	
	$postDel = $_GET['id'];
	
	$query = "DELETE FROM wpisy WHERE id=".$postDel;
	if(mysqli_query($polaczenie, $query))
	{
		header('Refresh:0; url=wszystkiePosty.php');
	}
	else
	{
		echo "Usuwanie postu poszło nie tak!";
	}
?>