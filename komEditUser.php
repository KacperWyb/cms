<style>
	textarea
	{
		width: 80%;
		background-color: #efefef;
		color: #666;
		border: 2px solid #ddd;
		border-radius: 5px;
		font-size: 20px;
		padding-top: 10px;
		padding-left: 10px;
		padding-bottom: 200px;
		box-sizing: border-box;
		outline: none;
		margin-top: 15px;
		font-family: 'Overpass', sans-serif;
	}
	input[type=submit]
	{
		width: 300px;
		background-color: #36b03c;
		font-size:20px;
		color: white;
		padding: 15px 10px;
		margin-top: 20px;
		border: none;
		border-radius: 5px;
		cursor: pointer;
		letter-spacing: 2px;
		outline: none;
	}

	input[type=submit]:focus
	{
		-webkit-box-shadow: 0px 0px 15px 5px rgba(204,204,204,0.9);
		-moz-box-shadow: 0px 0px 15px 5px rgba(204,204,204,0.9);
		box-shadow: 0px 0px 15px 5px rgba(204,204,204,0.9);
	}

	input[type=submit]:hover
	{
		background-color: #37b93d;
	}
</style>

<?php
	session_start();
	
	include_once("connect.php");
	$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
	
	if(isset($_GET['id']))
	{
		$_SESSION['id_kom'] = $_GET['id'];
		$komEdit = $_GET['id'];
		//pobierz
		$zapytanie = "SELECT tresc FROM komentarze WHERE id=".$komEdit;
		$wynik = mysqli_query($polaczenie, $zapytanie);
		if($row = mysqli_fetch_array($wynik))
		{
			//edycja
			echo "<form action='komentarzEditing.php' method='POST'>";
				echo "<center><textarea name='newKom'>".$row['tresc']."</textarea></br>";
				echo '<input type="Submit" value="Edytuj Komentarz"></input></center>';
			echo "</form>";
		}
		else
		{
			echo "Nie można pobrać treści komentarza.";
		}
		
	}
	else
	{
		echo "Error GET!";
	}
?>