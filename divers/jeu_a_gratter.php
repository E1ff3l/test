<? include_once( $_SERVER[ "DOCUMENT_ROOT" ] . "/classes/config_v2.php" ); ?>
<? include_once( $_SERVER[ "DOCUMENT_ROOT" ] . "/classes/classes.php" ); ?>
<? include_once( $_SERVER[ "DOCUMENT_ROOT" ] . "/include_connexion/connexion_site_on.php" ); ?>
<?
	$commande =		new commande();
	
	$debug = 		false;
	$unique_id =  	$_GET[ "unique_id" ];
	
	//print_pre( $_GET );
	//print_pre( $_SESSION );
	
	// ----------- Traitement des informations AVANT affichage ---------- //
	if ( 1 == 1 ) {
		
		// ---- Tentative de chargement de la commande ------------------ //
		if ( !$commande->loadByUniqueID( $unique_id, false ) ) {
			if ( $debug ) echo "1 - Commande introuvable!<br>";
			//exit();
		}
		else {
			
		}
		// -------------------------------------------------------------- //
		
		// ---- Jeu déjà gratté pour cette commande ------------------ //
		if ( 1 == 12 ) {
			if ( $debug ) echo "2 - Jeu déjà gratté!<br>";
		}
		// -------------------------------------------------------------- //
		
		$__session = ( !empty( $_SESSION[ "site" ] ) )
			? $_SESSION[ "site" ]
			: $_SESSION[ "mobile" ];
		
		// ---- Commande en mode "Connecté" ----------------------------- //
		if ( isset( $_SESSION[ "site" ][ "client" ] ) ) {
			if ( $debug ) echo "--- Connecté<br>";
			$portable = 	substr( $__session[ "client" ][ "tel" ], 0, 2 );
			$portable2 = 	substr( $__session[ "client" ][ "tel2" ], 0, 2 );
			
			$tel_portable = "";
			if ( $portable == "06" || $portable == "07" ) 			$tel_portable = $__session[ "client" ][ "tel" ];
			else if ( $portable2 == "06" || $portable2 == "07" ) 	$tel_portable = $__session[ "client" ][ "tel2" ];
		}
		// -------------------------------------------------------------- //
		
		// ---- Commande en mode "Express" ------------------------------ //
		else {
			if ( $debug ) echo "--- Express<br>";
			$portable = substr( $_SESSION[ "express" ][ "tel_express" ], 0, 2 );
			
			$tel_portable = "";
			if ( $portable == "06" || $portable == "07" ) $tel_portable = $_SESSION[ "express" ][ "tel_express" ];
		}
		// -------------------------------------------------------------- //
		
		// ---- Gain ou non du client au jeu à gratter ------------------ //
		if ( 1 == 1 ) {
			$nb1 = rand( 1, 3 );
			$nb2 = rand( 1, 3 );
			
			if ( 1 == 1 || $nb1 == $nb2 ) {
				if ( $debug ) echo "GAGNE!<br>";
				$is_winner = 1;
				$img_gain = "/img/fidelite/place_cinema.jpg";
			}
			else {
				if ( $debug ) echo "PERDU!<br>";
				$is_winner = 0;
				$img_gain = "/img/fidelite/perdu.jpg";
			}
		}
		// -------------------------------------------------------------- //
		
		// Etape active
		$etape_active = 5;
	}
	// ------------------------------------------------------------------ //
	
	
	// -------------------- Gestion de la mise en cache ----------------- //
	$cache = ( MISE_EN_CACHE ) ? 0 : time();
	//echo $cache . "<br>";
	// ------------------------------------------------------------------ //
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Cache-Control" content="no-cache">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Expires" content="0"> 
		
		<link rel="stylesheet" href="/css/style.css?<?=$cache?>">
		<link rel="stylesheet" href="/css/style_bis.css?<?=$cache?>">
		<link rel="stylesheet" href="/css/forms.css?<?=$cache?>">
		<link rel="stylesheet" href="/lib/scratchcard/css/scratchcard.css?<?=$cache?>">
		
		<!--[if IE]>
		<link rel="stylesheet" href="/css/ie8.css?<?=$cache?>">
		<![endif]-->
		
		<!-- fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Dancing+Script">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fjalla+One">
	</head>

	<body>
		<div class="container" id="scratch-container">
			<canvas class="canvas" id="scratch-canvas" width="300" height="150"></canvas>
			<div class="winner-box" style="background-image:url('<?=$img_gain?>');">
				<br>
				<h2 class="xblinker wait">BRAVO!!</h2>
				<h3 class="xblinker wait">Cette place est pour vous!</h3>
				<p class="xblinker wait">Des instructions vont vous être envoyées par SMS au</p>
				<h3 class="xblinker wait"><?=$tel_portable?></h3>
			</div>
		</div>
	</body>
	
	<!-- Jquery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js?<?=$cache?>"></script>
	<script>window.jQuery || document.write('<script src="/js/jquery.min.js?<?=$cache?>"><\/script>')</script>
	
	<script>
		
		// ---- Carte cadeau à gratter --------------------- //
		if ( 1 == 1 ) {
			var is_winner = 	<?=$is_winner?>;
		}
		// ------------------------------------------------- //
	
	</script>
	<script type="text/javascript" src="/lib/scratchcard/js/scratchcard.js"></script>
	
	<script>

		// DOM Ready
		$(function(){
			
		});

	</script>
	
</html>