<?php
	session_start();
	
	require_once('czyAdmin.php');
	
	if(isset($_POST['newPost']))
	{
		include_once("connect.php");
	    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
	    
		$postEdit = $_POST['newPost'];
	
		$updateSQL = "UPDATE wpisy SET Treść='$postEdit' WHERE id=".$_SESSION['id_post'];
		$update = mysqli_query($polaczenie, $updateSQL);
		header('Location: wszystkiePosty.php');
	}
	else
	{
		echo "Nie można zaktualizować postu.";
	}
?>