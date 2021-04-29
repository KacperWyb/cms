<?php
	session_start();
	
	require_once('czyAdmin.php');
		
?>

<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="stylesheet" type="text/css" href="style.css" >
	<link href="https://fonts.googleapis.com/css?family=Overpass&display=swap&subset=latin-ext" rel="stylesheet">
</head>

<body>

	<?php
		
		include_once("cms.php");
		
		include_once("menu.php");
	
	?>

	<div id="content">
		<?php
			
			$zap = "SELECT * FROM pytania ORDER BY id DESC";
			$wynik = mysqli_query($polaczenie, $zap);			
			
			echo<<<END
			<table border="1px" width="1000px" style="margin-top: 5%;">
				<tr style="color: #004d80;">
					<td><b>ID</b></td>
					<td><b>Data utworzenia</b></td>
					<td><b>E-Mail</b></td>
					<td><b>Treść</b></td>
					<td><b>Czynność</b></td>
				</tr>
END;
			echo '<div style="font-size: 28px;">';
				while($row = mysqli_fetch_array($wynik))
				{
					echo "<tr>";
						echo "<td>".$row["id"]."</td>";
						echo "<td>".$row["data"]."</td>";
						echo "<td>".$row["email"]."</td>";
						echo "<td>".$row["tresc"]."</td>";
						echo "
						<td><a href='pytDel.php?id=".$row['id']."'><img src='pic/ban.png' width='20px' height='20px'> </a>
						<a href='odp.php?id=".$row['id']."'><img src='pic/odp.png' width='20px' height='20px'> </a></td>";
					echo "</tr>";
				}
			echo '</div>';
			echo "</table>";

			
		?>
	</div>
	
	<?php
	
		include_once("footer.php");
		
	?>
	
</body>
</html>