<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-5GX8Z2N');</script>
    <!-- End Google Tag Manager -->
	<style>
		
		.menu
		{
			text-align: center;
			float: left;
			padding-left: 0.5%;
			padding-right: 0.5%;
			padding-top: 1%;
			padding-bottom: 1%;
			transition-duration: 0.5s;
			font-size: 20px;
		}
		.menu:hover
		{
			color: #31E6DF;
			padding-right: 40px;
			padding-left: 40px;
		}

		@media only screen and (max-width: 1000px)
		{
			#menu
			{
				width: 100%;
				text-align: right;
				font-size: 20px;
				float: none;
			}
			.menu
			{
				clear:both;
				text-align: center;
				width: 100%;
				padding-top: 1%;
				padding-bottom: 1%;
				float: none;
			}
			.cms
			{
				text-align: center;
			}
		}
</style>

</head>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5GX8Z2N"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    
    <div id="container">
    	
    	
    		<?php
    			if(isset($_SESSION['login']))
    			{
    				echo '<div class="typeUser" style="float: left;">';
    				$Login = $_SESSION['login'];
    				$Login = ucfirst ($Login);
    				echo $Login;
    				echo '</div>';
    				echo '<div id="menu">';
    			}
    			else
    			{
    				echo '<div id="menuUnLog" style="margin-left: 5%;">';
    			}
    		?>
    	
    		<a href="index.php"><div class="menu">HOME</div></a>
    		<a href="index.php"><div class="menu">BLOG</div></a>
    		<a href="index.php"><div class="menu">NOWOŚCI</div></a>
    		<a href="index.php"><div class="menu">O NAS</div></a>
    		<a href="index.php"><div class="menu">GALERIA</div></a>
    		<a href="kontakt.php"><div class="menu">KONTAKT</div></a>
    		<a href="https://kacwyb.pl/wordpress/" target="_blank"><div class="menu">WordPress</div></a>
    		
    		<?php 
    			
    		if(!isset($_SESSION['id']))
    		{
    			echo "<a href='logowanie.php'><div class='menu' style='float: right; width: 10%;'>Zaloguj się!</div></a>";
    		}
    		else
    		{
    			echo "<a href='logout.php'><div class='menu' style='float: right; width: 10%;'>Wyloguj się!</div></a>";
    		}
    		?>
    	</div>
    	<div style="clear:both;"></div>
    	<hr class="hr"></hr>
    	
    </div>
</body>