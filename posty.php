<?php
	session_start();
?>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Blog informacyjny</title>
	<link rel="stylesheet" type="text/css" href="style.css" >
	<link href="https://fonts.googleapis.com/css?family=Overpass&display=swap&subset=latin-ext" rel="stylesheet">
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<style>
		input[name=komentarz]
		{
			width: 60%;
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
		input[name=komentarz]:focus,
		{
			-webkit-box-shadow: 0px 0px 10px 2px rgba(204,204,204,0.9);
			-moz-box-shadow: 0px 0px 10px 2px rgba(204,204,204,0.9);
			box-shadow: 0px 0px 10px 2px rgba(204,204,204,0.9);
			border: 2px solid #a5cda5;
			background-color: #e9f3e9;
			color: #428c42;
		}
		
		#poleKomentarzy
		{
			width: 59%;
			margin-left: auto;
			margin-right: auto;
			border: 1px solid grey;
			margin-top: 2%;
			padding: .5%;
		}
		#poleAutor
		{
			text-align: center;
			font-size: 20px;
		}
		#komentarze
		{
			text-align: center;
		}
		.buttonKomentarz
		{
			width: 600px;
			background-color: #efefef;
			color: #666;
			border: 2px solid #ddd;
			border-radius: 5px;
			font-size: 20px;
			padding: 10px;
			box-sizing: border-box;
			outline: none;
			margin-top: 3%;
			margin-bottom: 1%;
			cursor: pointer; 
		}
	</style>
	
</head>

<body>
	
	<?php
		include_once("cms.php");
		include_once("menu.php");
		
	?>
	<div id="content">
	
		<?php
			require_once "connect.php";
			$id = $_GET['posty'];
			
			if(isset($_POST['komentarz']))
			{
				$Udana_Walidacja = true;

				//zapamietaj dane
				$_SESSION['komentarz'] = $_POST['komentarz'];
				//bot
				/*$sekret = "6LdKsq8ZAAAAAPDufixK5sNmnkxdJf5_aegzvm1m";
				
				$sprawdz_Box = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
				$odpowiedz_Box = json_decode($sprawdz_Box);
				
				if($odpowiedz_Box->success==false)
				{
					$Udana_Walidacja = false;
					$_SESSION['e_bot'] = "Potwierdź, że nie jesteś robotem!";
				}*/
				
				if(isset($_POST['komentarz']) && ($_POST['komentarz'])==true && ($Udana_Walidacja == true))
				{
					$dodaj = $polaczenie->query("INSERT INTO komentarze(id, autor,tresc,Data,id_postu) VALUES(NULL, '".$_SESSION['login']."', '".$_POST['komentarz']."','".date('Y-m-d H:i:s')."', '".$id."')");
					unset($_SESSION['e_bot']);
					//header('Refresh: 0');
				}
			}
			
			//contentPostu
			$wyswietl = "SELECT * FROM wpisy WHERE id=".$id;
			$temp = $polaczenie->query($wyswietl);
			$wynik = $temp->fetch_assoc();
			echo "<div class='tytulInfo'>".$wynik['Temat']."</div><br>";
			echo "<div class='trescInfo'>".$wynik['Treść']."</div><br>";
			
			//zdjecia
			$res = "SELECT * FROM zdjecia WHERE id_postu=".$id;
			$result = mysqli_query($polaczenie, $res);
			$row = mysqli_fetch_array($result);
		?>
			<!-- wyswietlanie zdjec (1 i reszta) -->
			<div class="row">	
			<?php
				// jezeli istnieja zdjecia
				if(isset($row))
				{
					echo '
					<div class="column">
						<img src="data:image/jpeg;base64,'.base64_encode($row['zdjecie']).'" width="200px" height="150px" onclick="myFunction(this);"/>
					</div>
					';
					
					while($row = mysqli_fetch_array($result))
					{
						echo '
						<div class="column">
						<img src="data:image/jpeg;base64,'.base64_encode($row['zdjecie']).'" width="200px" height="150px"onclick="myFunction(this); ">
						</div>';
					}
				}
			?>
			</div>
			
			<div class="container1">
				<span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>
				<img id="expandedImg" style="width:100%">
				<div id="imgtext"></div>
			</div>
		<?php
			echo '</div><hr>';
			
			//wyswietlanie komentarzy
			$kom = "SELECT * FROM komentarze WHERE id_postu=".$id ;
			if($czyAdmin)
			{
				if($komentarz = $polaczenie->query($kom))
				{
					while($pokazKomentarz = $komentarz->fetch_assoc())
					{
						
						$autor = $pokazKomentarz['autor'];
						if($pokazKomentarz['autor'] = $Login)
						{
						echo "<div id='poleKomentarzy'>";
						echo "
						<div id='poleAutor'><b>".ucfirst($pokazKomentarz['autor'])."</b>
							<div id='panel' style='float: right;'><a href='komEdit.php?id=".$pokazKomentarz['id']."'><img src='pic/edit.jpg' width='22px' height='22px' /></a>
							</div>
							<div id='panel' style='float: right;'><a href='komDel.php?id=".$pokazKomentarz['id']."'><img src='pic/ban.png' width='22px' height='22px' /></a>
							</div>
						</div>";
						echo "<div id='poleKoment'>".ucfirst($pokazKomentarz['tresc'])."</div><br>";
						echo "</div>";
						}
					}
				}
			}
			else
			{
				if($komentarz = $polaczenie->query($kom))
				{
					while($pokazKomentarz = $komentarz->fetch_assoc())
					{
						echo "<div id='poleKomentarzy'>";
							
							if(isset($_SESSION['login']))
							{
								$Login = $_SESSION['login'];
							}
							else
							{
								$Login = "";
							}
							
							if($Login == $pokazKomentarz['autor'])
							{
								echo "<div id='poleAutor' style='margin-left: 45px;'><b>".ucfirst($pokazKomentarz['autor'])."</b>";
								echo "<div id='panel' style='float: right; position: relative;'><a href='komDel.php?id=".$pokazKomentarz['id']."' ><img src='pic/ban.png' width='22px' height='22px' /></a></div>
								<div id='panel' style='float: right; position: relative;'><a href='komEditUser.php?id=".$pokazKomentarz['id']."'><img src='pic/edit.jpg' width='22px' height='22px' /></a></div>";
							}
							else
							{
								echo "<div id='poleAutor'><b>".ucfirst($pokazKomentarz['autor'])."</b>";
							}
							echo "</div>";
							echo "<div id='poleKoment'>".ucfirst($pokazKomentarz['tresc'])."</div><br>";
						echo "</div>";
					}
				}
			}
		//dla zalogowanych tworzenie komentarzy
		if(isset($_SESSION['id']))
		{
		?>
		<br>
		<div id="komentarze">
			<form method="POST">
			
				<textarea name="komentarz" class="textareaKom" placeholder="Treść komentarza.."><?php
				if (isset($_SESSION['komentarz']))
				{
					echo $_SESSION['komentarz'];
					unset($_SESSION['komentarz']);
				}?></textarea> </br>
				<center style="margin-top: 1%;">
				
				<!--<div class="g-recaptcha" data-sitekey="6LdKsq8ZAAAAAOxVPLkjp3ET53Vz6aXbDmo40Xx_"></div>
				<?php
				/*if(isset($_SESSION['e_bot']))
				{
					echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
				}
				*/?>-->
				</center>
				
				<input type="submit" value="dodaj" name="dodajKomentarz" />
				
			</form>
		</div>
			
		<?php
			}
			else
			{
				echo '
				<div style="text-align: center;">
					<a href="logowanie.php">
						<button class="buttonKomentarz">W celu dodania komentarza zaloguj się!</button>
					</a></br></br>
				</div>';
			}
			echo "<div style='height: 30px;'></div>";
			
			include_once("footer.php");
			
		?>
	
</body>
</html>
<script>
	function myFunction(imgs) 
	{
		// Get the expanded image
		var expandImg = document.getElementById("expandedImg");
		// Get the image text
		var imgText = document.getElementById("imgtext");
		// Use the same src in the expanded image as the image being clicked on from the grid
		expandImg.src = imgs.src;
		// Use the value of the alt attribute of the clickable image as text inside the expanded image
		imgText.innerHTML = imgs.alt;
		// Show the container element (hidden with CSS)
		expandImg.parentElement.style.display = "block";
	}
</script>