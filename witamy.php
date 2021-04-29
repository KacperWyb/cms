<?php

	session_start();
	
	if (!isset($_SESSION['udanaRejestracja']))
	{
		header('Location: zalogowany.php');
		exit();
	}
	else
	{
		unset($_SESSION['udanaRejestracja']);
	}
	
	//wyslanie maila
	/*
	$adres = "kontakt@kacwyb.pl";
	$temat = "Dziękujemy za rejestrację w naszym serwisie!";
	$tresc = "treść \n\naszego maila";
	
	$wyslany = mail($adres, $temat, $tresc);
	if($wyslany)
	{
		echo "Poszło"; 
	}
	else
	{
		echo "coś nie poszło";
	}*/
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Blog informacyjny</title>
	<style>
		a
		{
			text-decoration: underline; 
			color: #00a3cc;
		}
		a:hover
		{
			color: #0083a4;
		}
	</style>
</head>

<body>
	
	<div style='margin-top: 20%;'><center><b style='color: #00a3cc; font-size: 30px; '>Dziękujemy za rejestracje w serwisie! 
	<a href="logowanie.php">Zaloguj się na swoje konto!</a></b></center></div>

</body>
</html>