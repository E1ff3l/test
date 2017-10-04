<? include_once( "../classes/config_v2.php" ); ?>
<? include_once( "../classes/classes.php" ); ?>
<? include_once( "../include_connexion/connexion_site_on.php" ); ?>
<?
	$debug = 				false;
	
	if ( $_GET[ "r" ] != '' ) {
		unset( $_SESSION[ "stuart" ] );
	}
	
	$commande = 			new commande();
	$restaurant = 			new restaurant();
	$ville = 				new ville();
	$stuart_api =			new stuart_api( $_SESSION[ "stuart" ][ "token" ], false );
	
	//print_pre( $_SESSION[ "stuart" ] );
	//print_pre( $_SERVER );
	//echo "--- " . $_SESSION[ "lien_final" ] . "<br>";
	
	// ----------- Traitement des informations AVANT affichage ---------- //
	if ( 1 == 1 ) {
		
		// ---- Correspondance restaurant ------------- //
		if ( $restaurant->loadByKey( $cle, '', false ) ) {
			
			// On a une différence!
			if ( $_SESSION[ "site" ][ "num_restaurant" ] != $restaurant->id ) {
				$commande->verifierConcordance( 
					$_SESSION[ "site" ][ "num_restaurant" ], 
					$restaurant->id,
					false
				);
				
				$_SESSION[ "site" ][ "num_restaurant" ] = $restaurant->id;
			}
		}
		// -------------------------------------------- //
		
		// ---- Chargement du restaurant en cours ----- //
		$restaurant->load( $_SESSION [ "site" ][ "num_restaurant" ] );
		$nom_restaurant =	utf8_encode( $restaurant->nom );
		// -------------------------------------------- //
		
		// ---- Chargement de la ville de livraison --- //
		$ville->load( $_SESSION [ "site" ][ "num_ville" ] );
		$nom_ville =		utf8_encode( $ville->nom );
		// -------------------------------------------- //
		
		// ---- Définition du lien suivant ------------ //
		if ( 1 == 1 ) {
			$lien_suivant = ( $_GET[ "r" ] == "resume" )
				? "/commande/commande_resume_commande.php"
				: "/commande/commande_heure_livraison.php";
			if ( $debug ) echo "--> lien_suivant : " . $lien_suivant . "<br>";
		}
	}
	// ------------------------------------------------------------------ //
	
	$_SESSION[ "stuart" ][ "is_chgt_frais" ] = 			false;
	
	if ( $_GET[ "id" ] != '' ) {
		$stuart_api->creerJob( false );
	}
	
	// -------------------- Gestion de la mise en cache ----------------- //
	$cache = ( MISE_EN_CACHE ) ? "" : "?" . time();
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
		
		<title>Restomalin - Module de livraison</title>
		
		<link rel="stylesheet" href="/css/style.css<?=$cache?>">
		<link rel="stylesheet" href="/css/style_bis.css<?=$cache?>">
		<link rel="stylesheet" href="/css/forms.css<?=$cache?>">
		<link rel="stylesheet" href="/css/tooltipster.css<?=$cache?>">
		
		<!--[if IE]>
		<link rel="stylesheet" href="/css/ie8.css<?=$cache?>">
		<![endif]-->
		
		<!-- fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Dancing+Script">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fjalla+One">
	</head>

	<body>
		<div id="container-box">
			
			<div id="info-gal">
					<fieldset class="<?=$display_resume?>">
						<legend>
							<h2>Module de livraison</h2>
						</legend>
						
						<?
						//print_pre( $_SESSION[ "site" ] );
						print_pre( $_SESSION[ "stuart" ] );
						echo "<br><a href='./gestion_livraison_stuart.php?r=1'>[-- Reset --]</a>";
						echo "<a href='./gestion_livraison_stuart.php?id=" . $_SESSION[ "stuart" ][ "jobQuoteId" ] . "'>[-- Créer le job #" . $_SESSION[ "stuart" ][ "jobQuoteId" ] . " --]</a><br>";
						
						// ---- Communication avec le client ------------------- //
						if ( $_SESSION[ "stuart" ][ "is_livraison_possible" ] ) {
							?>
							<div class="field" style="margin-bottom:40px;">
								<h2>Pour information,</h2>
								<p>Les frais de livraison pour votre commande seront de <b><?=number_format( $_SESSION[ "site" ][ "frais_livraison" ], 2, '.', '' )?>€</b></p>
							</div>
							
							<div class="processing btn-wait" style="display:none;">En cours...</div>
							<div id="boutons-action" style="margin-top:10px;">
								<a href="javascript:void(0);" id="validation-commande" class="btn">Poursuivre</a>
								<a href="javascript:void(0);" id="aide" class="btn-comp">Changer de restaurant</a>
							</div>
							<?
						}
						// ----------------------------------------------------- //
						
						// ---- En cas d'erreur -------------------------------- //
						else {
							?>
							<div class="field" style="margin-bottom:40px;">
								<div class="warning">
									<h2>Désolé,</h2>
									<p><?=$stuart_api->getMessageErreur( $_SESSION[ "stuart" ][ "code_error" ], false )?></p>
								</div>
							</div>
							<input type="button" class="btn fermer" value="Fermer">
							<?
						}
						// ----------------------------------------------------- //
						?>
						
					</fieldset>
				</form>			
			</div>
		</div>
	</body>
	
	<!-- Jquery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js<?=$cache?>"></script>
	<script>window.jQuery || document.write('<script src="/js/jquery.min.js<?=$cache?>"><\/script>')</script>
	
 	<!-- plugins, script et CSS liées -->
	<script src="/js/jquery.tooltipster.js<?=$cache?>"></script>
	
	<script>
		
		// DOM Ready
		$(function(){
			
			// ---- Fermeture du LightBox ------------------------------------------ //
			$( ".fermer" ).click(function() {
				//alert( "click..." );
				parent.$.fancybox.close();
			});
			
			// ---- Poursuite de la commande & Mise en attente... ------------------ //
			$( "#validation-commande" ).click(function() {
				$( "#boutons-action" ).hide();
				$( ".btn-wait" ).show();
				
				window.location.href = "<?=$lien_suivant?>";
			});
			
			// ---- Retour à la liste des restaurants & Mise en attente... --------- //
			$( "#aide" ).click(function() {
				$( "#boutons-action" ).hide();
				$( ".btn-wait" ).show();
				
				window.open( "/mes-restaurants.html", "_parent" );
			});
			
		});

	</script>
	
</html>