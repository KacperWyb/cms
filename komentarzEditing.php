<?php
	session_start();
	
	require_once('czyAdmin.php');
	include_once("connect.php");
	
	if(isset($_POST['newKom']))
	{
    	$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		$komEdit = $_POST['newKom'];
		
		$updateSQL = "UPDATE komentarze SET tresc='$komEdit' WHERE id=".$_SESSION['id_kom'];
		$update = mysqli_query($polaczenie, $updateSQL);
		header('Location: komentarze.php');
	}
	else
	{
		echo "Nie można zaktualizować.";
	}
?>