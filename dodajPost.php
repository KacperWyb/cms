<?php
	session_start();
	
	require_once "connect.php";
	$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
	
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
		header('Location: logowanie.php');
	}
?>

<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Blog informacyjny</title>
	<link rel="stylesheet" type="text/css" href="style.css" >
	<style>
	
	#containerPost
	{
		background-color: white;
		width: 60%;
		padding: 50px;
		margin-left: auto;
		margin-right: auto;
		margin-top: 6%;
		-webkit-box-shadow: 3px 3px 30px 5px rgba(204,204,204,0.9);
		-moz-box-shadow: 3px 3px 30px 5px rgba(204,204,204,0.9);
		box-shadow: 3px 3px 30px 5px rgba(204,204,204,0.9);
	}
	
	input[type=temat]
	{
		width: 80%;
		background-color: #efefef;
		border: 2px solid #ddd;
		border-radius: 5px;
		font-size: 20px;
		padding: 10px;
		box-sizing: border-box;
		outline: none;
		margin-top: 15px;
	}
	</style>
</head>

<body>
	<div id="containerPost">
		<div id="dodawaniePostow" style="top: 30%;"><center>
			<p style="text-align: center; "><h1 style="color: #808080;">Dodawanie Postów</h1></p>
			
			<form name="uploader" id="uploader" action="DodawaniePostow.php" method="POST" enctype="multipart/form-data">
				<input name="Temat" type="temat" placeholder="Temat Postu"/></input>  </br>
				<textarea name="Tresc" class="textarea" placeholder="Treść Postu"></textarea> </br>
				<input type="file" name="image[]" id="image" multiple/></input> 
				
				<input type="submit" value="Dodaj post!"  name="insert" id="insert" />
			
			</form>
		</div>
	</div>
</body>
</html>