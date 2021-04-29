<?php

	session_start();
	
	if(isset($_POST['email']))
	{
		//Udana walidacja
		$Udana_Walidacja=true;
		
		//sprawdzenie LOGINU
		$login=$_POST['login'];
		
		if((strlen($login)<3) || (strlen($login)>20))
		{
			$Udana_Walidacja=false;
			$_SESSION['error_login']="Login musi posiadać od 3 do 20 znaków";
		}
		
		if(ctype_alnum($login)==false)
		{
			$Udana_Walidacja = false;
			$_SESSION['error_imie']="Login może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		
		
		//sprawdzenie IMIENIA
		$imie = $_POST['name'];
		
		if((strlen($imie)<2))
		{
			$Udana_Walidacja=false;
			$_SESSION['error_name']="Imię musi posiadać minimum 2 znaki";
		}
		
		//nazwisko
		$surname = $_POST['surname'];
		if((strlen($imie)<2))
		{
			$Udana_Walidacja=false;
			$_SESSION['error_surname']="Nazwisko musi posiadać minimum 2 znaki";
		}
		
		//sprawdz EMAIL
		$email = $_POST['email'];
		$email_oczyszczony = filter_var($email, FILTER_SANITIZE_EMAIL); //polskie litery, znaki
		
		if((filter_var($email_oczyszczony, FILTER_VALIDATE_EMAIL)==false) || ($email_oczyszczony != $email))
		{
			$Udana_Walidacja=false;
			$_SESSION['error_email'] = "Podaj poprawny adres E-Mail";
		}
		
		//sprawdz HASŁO
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		
		if((strlen($haslo1)<8) || (strlen($haslo1)>20))
		{
			$Udana_Walidacja = false;
			$_SESSION['error_haslo'] = "Hasło musi posiadać od 8 do 20 znaków";
		}
		
		if($haslo1 != $haslo2)
		{
			$Udana_Walidacja=false;
			$_SESSION['error_haslo'] = "Hasła muszą być identyczne";
		}
		
		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
		
		//sprawdzanie CHECKBOX
		if(!isset($_POST['regulamin']))
		{
			$Udana_Walidacja = false;
			$_SESSION['error_regulamin'] = "Zaakceptuj regulamin";
		}
		
		//sprawdzenie BOTA
		/*$sekret = "6LdKsq8ZAAAAAPDufixK5sNmnkxdJf5_aegzvm1m";
		
		$sprawdz_Box = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		
		$odpowiedz_Box = json_decode($sprawdz_Box);
		
		if($odpowiedz_Box->success==false)
		{
			$Udana_Walidacja = false;
			$_SESSION['error_bot'] = "Potwierdź, że nie jesteś robotem!";
		}*/
		
		//Zapamiętaj wprowadzone dane
		$_SESSION['fr_login'] = $login;
		$_SESSION['fr_imie'] = $imie;
		$_SESSION['fr_surname'] = $surname;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_haslo1'] = $haslo1;
		$_SESSION['fr_haslo2'] = $haslo2;
		if (isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;
		
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//czy email juz istnieje?
				$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");
				
				if(!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)
				{
					$Udana_Walidacja = false;
					$_SESSION['error_email'] = "Istnieje już konto przypisane do tego adresu E-Mail!";
				}
				
				//czy login juz istnieje?
				$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE login='$login'");
				
				if(!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_loginow = $rezultat->num_rows;
				if($ile_takich_loginow>0)
				{
					$Udana_Walidacja = false;
					$_SESSION['error_login'] = "Istnieje już konto o takim loginie!";
				}
				
				//JEZELI WSZYSTKO SIE UDA TO ZALOGUJ 
				if($Udana_Walidacja == true)
				{
					if($polaczenie->query("INSERT INTO uzytkownicy(login, name, surname, pass, email, userType) VALUES('".$login."', '".$imie."', '".$surname."', '".$haslo_hash."', '".$email."', 0)"))
					{
						$_SESSION['udanaRejestracja']=true;
						header('Location: witamy.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					$polaczenie->close();
				}
			}
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności!"</span>';
			echo '</br>Informacja developerska: '.$e;
		}
	}
		
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Blog informacyjny</title>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<link rel="stylesheet" type="text/css" href="style.css" >
</head>

<body>
	
	<form method="post" style="margin-top: 2%;">
	<center>
		Login: </br> <input type="text" name="login" value="<?php
			if (isset($_SESSION['fr_login']))
			{
				echo $_SESSION['fr_login'];
				unset($_SESSION['fr_login']);
			}
		?>" /> </br>
		
		<?php
			if(isset($_SESSION['error_login']))
			{
				echo '<div class="error">'.$_SESSION['error_login'].'</div>';
				unset($_SESSION['error_login']);
			}
		?>
		
		Imię: </br> <input type="text" name="name" value="<?php
			if (isset($_SESSION['fr_imie']))
			{
				echo $_SESSION['fr_imie'];
				unset($_SESSION['fr_imie']);
			}
		?>" /> </br>
		
		<?php
			if(isset($_SESSION['error_name']))
			{
				echo '<div class="error">'.$_SESSION['error_name'].'</div>';
				unset($_SESSION['error_name']);
			}
		?>
		
		Nazwisko: </br> <input type="text" name="surname" value="<?php
			if (isset($_SESSION['fr_surname']))
			{
				echo $_SESSION['fr_surname'];
				unset($_SESSION['fr_surname']);
			}
		?>" /> </br>
		
		<?php
			if(isset($_SESSION['error_surname']))
			{
				echo '<div class="error">'.$_SESSION['error_surname'].'</div>';
				unset($_SESSION['error_surname']);
			}
		?>
		
		E-Mail: </br> <input type="text" name="email" value="<?php
			if (isset($_SESSION['fr_email']))
			{
				echo $_SESSION['fr_email'];
				unset($_SESSION['fr_email']);
			}
		?>" /> </br>
		
		<?php
			if(isset($_SESSION['error_email']))
			{
				echo '<div class="error">'.$_SESSION['error_email'].'</div>';
				unset($_SESSION['error_email']);
			}
		?>
		
		Hasło: </br> <input type="password" name="haslo1" value="<?php
			if (isset($_SESSION['fr_haslo1']))
			{
				echo $_SESSION['fr_haslo1'];
				unset($_SESSION['fr_haslo1']);
			}
		?>" /> </br>
		
		<?php
			if(isset($_SESSION['error_haslo']))
			{
				echo '<div class="error">'.$_SESSION['error_haslo'].'</div>';
				unset($_SESSION['error_haslo']);
			}
		?>
		
		Powtórz hasło: </br> <input type="password" name="haslo2" value="<?php
			if (isset($_SESSION['fr_haslo2']))
			{
				echo $_SESSION['fr_haslo2'];
				unset($_SESSION['fr_haslo2']);
			}
		?>" /> </br></br>
	
		<label>
			<input type="checkbox" name="regulamin"/>
			Akceptuję<a href="regulamin.php" style="text-decoration: underline;">regulamin</a>
		</label>
		
		<?php
			if(isset($_SESSION['error_regulamin']))
			{
				echo '<div class="error">'.$_SESSION['error_regulamin'].'</div>';
				unset($_SESSION['error_regulamin']);
			}
		?>
		</br></br>
		<!--
		<div class="g-recaptcha" data-sitekey="6LdKsq8ZAAAAAOxVPLkjp3ET53Vz6aXbDmo40Xx_"></div>
		
		<?php
			/*if (isset($_SESSION['error_bot']))
			{
				echo '<div class="error">'.$_SESSION['error_bot'].'</div>';
				unset($_SESSION['error_bot']);
			}*/
		?>	
		-->
		</br>
		</br>
		
		<input type="submit" value="Zarejestruj się"/>
		</center>
	</form>
	
</body>
</html>