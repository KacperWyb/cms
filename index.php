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
	
</head>

<body>

	<?php
		
		include_once("cms.php");
		
		include_once("menu.php");
		
		include_once("content.php");
		
		include_once("footer.php");
		
	?>
	
</body>
</html>