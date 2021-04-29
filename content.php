<head>
	<style>
		#paginacja
		{
			text-align: center;
		}
		.paginacja:hover
		{
			text-decoration: none;
			padding: 0px;
			color: #00a3cc;
			transition-duration: 0.2s;
		}
		#TrescPostu
		{
			
		}
		.miniaturka
		{
			float: left;
			margin-top: 3%;
			width: 30%;
		}
		.trescInfo
		{
			float: left;
			width: 70%;
			text-align: justify;
		}
		@media only screen and (max-width: 1750px)
		{
			#TrescPostu
			{
				clear:both;
				width: 100%;
				text-align: right;
				font-size: 20px;
				float: none;
			}
		}
		@media only screen and (max-width: 1750px)
		{
			.miniaturka
			{
				clear:both;
				text-align: center;
				width: 100%;
				float: none;
			}
			.trescInfo
			{
				text-align: center;
				width: 100%;
				padding-top: 1%;
				padding-bottom: 1%;
				float: none;
			}
		}
	</style>
</head>
<div id="container">
	
	<div id="content">
		<div class="miniaturkaInfo">
			<?php
			    include_once("connect.php");
				$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
				
				$wyniki_na_stronie = 5;
				
				$sql = "SELECT * FROM wpisy";
				$wynik = mysqli_query($polaczenie, $sql);
				$liczba_wynikow = mysqli_num_rows($wynik);
				
				//sprawdza ile jest stron
				$numer_strony = ceil($liczba_wynikow/$wyniki_na_stronie);
				
				if(!isset($_GET['page']))
				{
					$page = 1;
				}
				else
				{
					$page = $_GET['page'];
				}
				
				$pierwszy_wynik_tej_strony = ($page-1) * $wyniki_na_stronie;
				
				$sql = "SELECT * FROM wpisy ORDER BY id DESC LIMIT " . $pierwszy_wynik_tej_strony . ',' . $wyniki_na_stronie;
				$wynik = mysqli_query($polaczenie, $sql);
				
				// posty wyswietla
				while($row = mysqli_fetch_array($wynik)) 
				{	
					//dlugosc liter w poscie
					$dlugoscPostu = 700;
					if(strlen($row['Treść']) > $dlugoscPostu)
					{
						$row['Treść'] = substr($row['Treść'], 0, $dlugoscPostu);
						$row['Treść'] .= "...";
					}
				
					echo "<a href='posty.php?posty=".$row['id']."' style='color: black;'><div class='tytulInfo'>".$row['Temat']."<br><br><br></div></a>";
					
					$zap = "SELECT * FROM zdjecia WHERE id_postu=".$row['id'];
					$result = mysqli_query($polaczenie, $zap);
					$rows = mysqli_fetch_array($result);
					
					echo "<div id='TrescPostu'>";
						// jezeli istnieja zdjecia
						if(isset($rows)) 
						{
							echo "
							<div class='miniaturka'>
								<img src='data:image/jpeg;base64,".base64_encode($rows['zdjecie'])."' width='300px' height='200px'>
							</div>";
							
							echo "<div class='trescInfo'>".$row['Treść'];
							echo "<a href='posty.php?posty=".$row['id']."' style='color: 3A3A3A; text-decoration: underline;'>wiecej..
								<br><br><br>
								</div></a>
							</div>
							<div style='clear: both;'></div>";
						}
						else
						{
							echo "
								<div class='trescInfo' style='width: 100%;'>".$row['Treść'];
									echo "<a href='posty.php?posty=".$row['id']."' style='color: 3A3A3A; text-decoration: underline;'>wiecej..<br><br><br>
								</div></a>
					</div>
					<div style='clear: both;'></div>";
						}
				}
			?>
				
			<div id="paginacja">
				<?php
				//wyswietla linki do stron
				for($page=1; $page<=$numer_strony; $page++)
				{
					echo '<a href="index.php?page='.$page.'" class="paginacja">'. $page . '</a> ';
				}
				?>
			</div>
		</div>
	</div>
</div>