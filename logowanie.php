<?php
	session_start();
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: zalogowany.php');
		exit();
	}
?>

<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Blog informacyjny</title>
	<link rel="stylesheet" type="text/css" href="style.css" >
</head>

<body>
	<div id="containerLogowanie">
		
		<div id="logowanie" style="top: 30%;"><center>
		
			Nie posiadasz konta?
			<a href="rejestracja.php" style="text-decoration: underline;">Zarejestuj się tutaj!</a>
			</br></br>
			<form action="zaloguj.php" method="post">
			
				<input type="text" name="login" placeholder="Login" value="<?php
			if (isset($_SESSION['fl_login']))
			{
				echo $_SESSION['fl_login'];
				unset($_SESSION['fl_login']);
			}
		?>"/> </br>
				<input type="password" name="haslo" placeholder="Hasło"/> </br></br>
				<?php
				if (isset($_SESSION['blad'])) 
				{
					echo $_SESSION['blad'];
					unset($_SESSION['blad']);
				}
			?>
				<input type="submit" value="Zaloguj się" />
				
			</form>
			</br>
			
			
			Powrót na <a href="index.php" style="text-decoration: underline;">stronę główną</a>
		</div>
	</div>
</body>
</html>