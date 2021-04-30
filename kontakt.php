<?php
	session_start();	
?>

<html lang="pl">
<head>
<script>
var metricValue = '123';
ga('set', 'metric1', metricValue);
</script>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Blog informacyjny</title>
	<link rel="stylesheet" type="text/css" href="style.css" >
	<link href="https://fonts.googleapis.com/css?family=Overpass&display=swap&subset=latin-ext" rel="stylesheet">
	<style>
		#containerKontakt
		{
			width: 80%;
			margin-left: auto;
			margin-right: auto;
			font-size: 20px;
		}
		#lewo
		{
			display: inline-block;
			width: 40%;
		}
		#prawo
		{
			display: inline-block;
			width: 40%;
		}
		
		input[type=mail]
		{
			width: 300px;
			background-color: #efefef;
			color: #666;
			border: 2px solid #ddd;
			border-radius: 5px;
			font-size: 20px;
			padding: 10px;
			box-sizing: border-box;
			outline: none;
			margin-top: 15px;
		}
	</style>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>

	<?php
		
		include_once("cms.php");
		include_once("menu.php");
		
		if(isset($_POST['email']))
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			//sprawdz email
			$Udana_Walidacja = true;
			
			$email = $_POST['email'];
			$tresc = $_POST['tresc'];
			$email_oczyszczony = filter_var($email, FILTER_SANITIZE_EMAIL); //polskie litery, znaki
			
			if((filter_var($email_oczyszczony, FILTER_VALIDATE_EMAIL)==false) || ($email_oczyszczony != $email))
			{
				$Udana_Walidacja=false;
				$_SESSION['blad_email'] = "Podaj poprawny adres E-Mail";
			}
			/*
			//bot or not
			$sekret = "6LdKsq8ZAAAAAPDufixK5sNmnkxdJf5_aegzvm1m";
			
			$sprawdz_Box = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
			$odpowiedz_Box = json_decode($sprawdz_Box);
			
			if($odpowiedz_Box->success==false)
			{
				$Udana_Walidacja = false;
				$_SESSION['error_bot'] = "Potwierdź, że nie jesteś robotem!";
			}*/
			
			//zapamietaj dane
			$_SESSION['email'] = $_POST['email'];
			$_SESSION['tresc'] = $_POST['tresc'];
			
			//wyslij pytanie
			if(($_POST['email']) && ($_POST['email'])==true && ($Udana_Walidacja == true))
			{
				$zapytaj = 'INSERT INTO pytania(id,data,email,tresc) VALUES(NULL, "'.date('Y-m-d H:i:s').'", "'.$email.'", "'.$tresc.'")';
				$polaczenie->query($zapytaj);
				unset($_SESSION['tresc']);
			}
			
		}
		?>
		
		<div id="containerKontakt" style="margin-top: 3%; margin-bottom: 5%;">
			<center><b style="font-size: 24px;"> Masz pytania? Skontaktuj się z nami! </b></center></br></br>
			<div id="head">
				<div id="lewo">
					<center><b>Kacper Wybierała</b></p>
					<p>Klasa 4Ti1</p>
					<p>Grupa A</p>
					<p>e-mail: kontakt@kacwyb.pl</p>
					<p>Tel: 510985318</p>
					<p>www.kacwyb.pl</p></center>
					
					</br></br></br></br></br>
				</div>
				
				<div id="prawo">
					<form method="POST">
						<center>E-Mail:  <input type="mail" name="email" placeholder="Podaj adres e mail" value="<?php
							if (isset($_SESSION['email']))
							{
								echo $_SESSION['email'];
							}
							?>">
						<?php
						if(isset($_SESSION['blad_email']))
						{
							echo '<div class="error">'.$_SESSION['blad_email'].'</div>';
							unset($_SESSION['blad_email']);
						}
						?>
						<textarea class="textarea" style="width: 100%" name="tresc" placeholder="Pytanie"><?php
							if (isset($_SESSION['tresc']))
							{
								echo $_SESSION['tresc'];
								unset($_SESSION['tresc']);
							}
						?></textarea></br></br>
						
						<!--<div class="g-recaptcha" data-sitekey="6LdKsq8ZAAAAAOxVPLkjp3ET53Vz6aXbDmo40Xx_"></div>-->
			
						<?php
						/*
							if(isset($_SESSION['error_bot']))
							{
								echo '<div class="error">'.$_SESSION['error_bot'].'</div>';
								unset($_SESSION['error_bot']);
							}*/
						?>
						<input type="Submit" value="Wyślij Pytanie!">
					</form>
				</div>
			</div>
		</div>
		
		
	<?php
	
		include_once("footer.php");
		
	?>
	
</body>
</html>