<?php

	session_start();
	
	//zabezpieczenie przed wklejeniem w link
	if ((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: index.php');
		exit();
	}

	require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
		$login = $_POST['login'];
		$haslo = $_POST['haslo'];
		$email = $_POST['email'];
		
		if(isset($_POST['login']))
		{
			$_SESSION['login'] = $_POST['login'];
		}
		$_SESSION['fl_login'] = $_POST['login'];
		$_SESSION['email'] = $_POST['email'];
		$_SESSION['email'] = $email;
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		
		if ($rezultat = @$polaczenie->query(
		sprintf("SELECT * FROM uzytkownicy WHERE login='%s'",
		mysqli_real_escape_string($polaczenie,$login))))
		{
			$ilu_userow = $rezultat->num_rows;
			if($ilu_userow>0)
			{
				$wiersz = $rezultat->fetch_assoc();
				if(password_verify($haslo, $wiersz['pass']))
				{
					$_SESSION['zalogowany'] = true;
					$_SESSION['id'] = $wiersz['id'];
					$_SESSION['login'] = $wiersz['login'];
					$_SESSION['name'] = $wiersz['name'];
					$_SESSION['surname'] = $wiersz['surname'];
					$_SESSION['email'] = $wiersz['email'];
					
					unset($_SESSION['blad']);
					$rezultat->free_result();
					header('Location: zalogowany.php');
				}
				else 
				{				
				$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				header('Location: logowanie.php');
				}
			}
			else 
			{				
				$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
				header('Location: logowanie.php');
			}
		}
		
		$polaczenie->close();
	}
?>