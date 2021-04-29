<?php
	session_start();
	
	require_once('czyAdmin.php');
	
	include_once("connect.php");
	$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
	
	mysqli_report(MYSQLI_REPORT_STRICT);
	
	$Temat = $_POST['Temat'];
	$Tresc = $_POST['Tresc'];
	$data = date("Y-m-d");
	//wysylamy na serwer
	try
	{
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		if($polaczenie->connect_errno!=0)
		{
			throw new Exception(mysqli_connect_errno());
		}
		else
		{
			if(isset($_POST['insert']))
			{
				$res = $polaczenie->query("INSERT INTO wpisy (`id`, `data`, `Temat`, `Treść`) VALUES (NULL, '".$data."', '".$Temat."', '".$Tresc."' )");
				
				$ostatniPostId = "SELECT id FROM wpisy ORDER BY id DESC LIMIT 1";
				$pobierzOstatni = mysqli_query($polaczenie, $ostatniPostId);
				$ostatni = $pobierzOstatni->fetch_assoc();

				//zdjecia
				
				$filename = $_FILES['image']['name'];
				$tmpname = $_FILES['image']['tmp_name'];
				$filetype = $_FILES['image']['type'];
				for($i=0; $i<=count($tmpname)-1; $i++)
				{
					$name = addcslashes($filename[$i], "W");
					$tmp = addslashes(file_get_contents($tmpname[$i]));
					$req= "INSERT INTO zdjecia(nazwa, zdjecie, id_postu) VALUES('$name', '$tmp', '".$ostatni['id']."') ";
					mysqli_query($polaczenie, $req);
				}
				
				echo '<script>alert("Plik został dodany")</script>';
			}
			
			header('Location: index.php');
		}
	}
	catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności!"</span>';
		echo '</br>Informacja developerska: '.$e;
	}
?>