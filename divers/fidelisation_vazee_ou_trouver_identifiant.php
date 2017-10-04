<? include_once( "../classes/config_v2.php" ); ?>
<? include_once( "../classes/classes.php" ); ?>
<? include_once( "../include_connexion/connexion_site_on.php" ); ?>
<? //include_once( "../includes/information.php" ); ?>
<?
	$debug = false;
	
	$affichage_message_success = "wait";
	$affichage_message_erreur = "wait";
	
	// ---- on défini sur quel site on est (restomalin ou vit) pour adapter le discours
	if (( $_SESSION[ "vit" ][ "is_mb" ] == 1 ) OR ( $_SESSION[ "vit" ][ "is_vitrine" ] == 1 )) $quel_site = utf8_encode( $_SESSION[ "site" ][ "signature" ] );
	else $quel_site = "RESTOMALIN";
	
	
	if ( $debug ) {
		print_pre( $_POST );
		//print_pre( $_SESSION );
		//echo "<br>-----------------------------------------------<br>";
	}
	
	// ---- Action à réaliser... -------------------------------------------- //
	if ( $mon_action != '' ) {
		
		// ---- Connexion au compte Vazee --------- //
		if ( $mon_action == "connexion-vazee" ) {
			if ( $debug ) echo "--- Tentative de connexion...<br>";
			
			// ---- Tentative de connexion ----------------------------- //
			$response = $vazee->connecter( $_POST[ "login_vazee" ], '', $debug );
			
			// ---- Connexion réussie ---------------------------------- //
			if ( $response[ "connexion" ] ) {
				if ( $debug ) echo "--> On est bien connecté!<br>";
				
				// ---- Enregistrement des identifiants dans la table "client" ---- //
				if ( $_SESSION[ "site" ][ "client" ][ "num_client" ] ) {
					
					$client = new client();
					$client->load( $_SESSION[ "site" ][ "client" ][ "num_client" ] );
					$client->setChamp( "login_vazee", $_POST[ "login_vazee" ], $debug );
					
					// ---- On crédite le compte Vazee du client des points déjà gagnés depuis le 01/02/2016
					$vazee->crediterClientDepuisDebut( $client->id, $debug );
					
					// ---- On recharge les données client ------------------------ //
					$_SESSION[ "site" ][ "client" ] = ( $_SESSION[ "site" ][ "is_a_viticulteur" ] )
						? $client->charger_viticulteur( $client->id, false )
						: $client->charger();
				}
				
				// ---- Chargement du compte fidélité ----------------------------- //
				$vazee->connecter( $_POST[ "login_vazee" ], '', $debug );
				$vazee->chargerEnSession( $debug );
				
				// ---- Redirection directe après connexion (Résumé de commande) -- //
				if ( $_POST[ "etat" ] == "resume" ) {
					if ( $debug ) echo "---> REDIRECTION DIRECTE VERS VALIDATION<br>";
					else header( "Location: /commande/commande_resume_commande.php?vd=letzgo" );
					exit();
				}
				
				// ---- Redirection directe après connexion (Menus) -- //
				else if ( $_POST[ "etat" ] == "menu" ) {
					if ( $debug ) echo "---> REDIRECTION DIRECTE VERS MENUS<br>";
					else header( "Location: /menu-" . $_SESSION[ "site" ][ "num_restaurant" ] . "-" . $_POST[ "id" ] . ".html" );
					exit();
				}
			}
			// --------------------------------------------------------- //
			
			// ---- ERREUR lors de la connexion ------------------------ //
			else {
				$message_erreur = $response[ "message" ];
				$affichage_message_erreur = "";
			}
			// --------------------------------------------------------- //
			
		}
		// ---------------------------------------- //
		
		// ---- Suppression de compte ------------- //
		else if ( $mon_action == "supprimer-compte" ) {
			if ( $debug ) echo "--- Suppression de compte...<br>";
			
			// ---- Tentative de connexion ----------------------------- //
			$response = $vazee->connecter( $_SESSION[ "fidelisation" ][ "login_vazee" ], '', $debug );
			
			// ---- Connexion réussie ---------------------------------- //
			if ( $response[ "connexion" ] ) {
				if ( $debug ) echo "--> On est bien connecté!<br>";
				
				// ---- Enregistrement des identifiants dans la table "client" ---- //
				if ( $_SESSION[ "site" ][ "client" ][ "num_client" ] ) {
					
					$client = new client();
					$client->load( $_SESSION[ "site" ][ "client" ][ "num_client" ] );
					$client->setChamp( "login_vazee", '', $debug );
					$client->setChamp( "mdp_vazee", '', $debug );
					
					// ---- On recharge les données client -------------- //
					$_SESSION[ "site" ][ "client" ] = ( $_SESSION[ "site" ][ "is_a_viticulteur" ] )
						? $client->charger_viticulteur( $client->id, false )
						: $client->charger();
					
				}
				
				// ---- Suppression des infos sur la fidélité ---------- //
				$vazee->supprimerDansSession( $debug );
				
				$message_success = "Votre compte a été supprimé avec succès.";
				$affichage_message_success = "";
			}
			// --------------------------------------------------------- //
			
			// ---- ERREUR lors de la connexion ------------------------ //
			else {
				$message_erreur = $response[ "message" ];
				$affichage_message_erreur = "";
			}
			// --------------------------------------------------------- //
			
		}
		// ---------------------------------------- //
		
	}
	// ---------------------------------------------------------------------- //
	
	
	// ---- Espace VAZEE ---------------------------------------------------- //
	if ( 1 == 1 ) {
		//if ( $debug ) print_pre( $_SESSION[ "site" ][ "client" ] );
		
		// ---- Compte Vazee renseigné --> Recup du nb de points ---------------- //
		if ( $_SESSION[ "fidelisation" ][ "login_vazee" ] != '' ) {
			
			// ---- Récupération du nombre de points Vazee
			$nb_point = $vazee->nb_point;
			$nb_point = ( $nb_point > 1 ) ? $nb_point . " points" : $nb_point . " point";
			
			$affichage_detail_vazee = "";
			$affichage_connexion_vazee = "wait";
		}
		else {
			$affichage_detail_vazee = "wait";
			$affichage_connexion_vazee = "";
		}
		// ---------------------------------------------------------------------- //
		
	}
	// ---------------------------------------------------------------------- //
	
	
	// ---- DIVERS ---------------------------------------------------------- //
	if ( 1 == 1 ) {
		$tarif = $_SESSION[ "site" ][ "prix_total" ] + $_SESSION[ "site" ][ "frais_livraison" ] - $_SESSION[ "site" ][ "liste_promo" ][ "total_reduction" ];
		if ( floatval( $_SESSION[ "site" ][ "frais_gestion" ] ) > 0 ) $tarif += floatval( $_SESSION[ "site" ][ "frais_gestion" ] );
		
		//echo "--> Prix : " . $tarif . "<br>";
		//print_pre( $_SESSION );
		$nb_point_gagne = floor( $tarif );
		$affichage_poursuite_commande = ( $etat == "resume" ) ? "" : "wait";
	}
	// ---------------------------------------------------------------------- //
	
	// Gestion de la mise en cache
	$cache = ( MISE_EN_CACHE ) ? "" : "?" . time();
	//echo $cache . "<br>";
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Cache-Control" content="no-cache">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Expires" content="0"> 
		
		<title>Programme de fidélisation Vazee</title>
		<meta name="description" content="Vous êtes intéressés par ce programme">
		<meta name="robots" content="noindex,follow">
		
		<link rel="stylesheet" href="/css/style.css<?=$cache?>">
		<link rel="stylesheet" href="/css/style_bis.css<?=$cache?>">
		<link rel="stylesheet" href="/css/forms.css<?=$cache?>">
		<link rel="stylesheet" href="/css/tooltipster.css<?=$cache?>">
		<link rel="stylesheet" type="text/css" href="/css/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
		
		<!-- plugins, script et CSS liées -->
		<link rel="stylesheet" href="/css/anythingslider.css<?=$cache?>">
		
		<!--[if IE]>
		<link rel="stylesheet" href="/css/ie8.css<?=$cache?>">
		<![endif]-->
		
		<!-- fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Dancing+Script">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fjalla+One">
		
		<? include_once( $_SERVER[ 'DOCUMENT_ROOT' ] . "/includes/include_outils.php" ); ?>
	
	</head>

	<?
	// Affichage dans une LightBox
	echo "<body>\n";
	
	echo "	<div id='container-box'>\n";
	?>
		<form id="formulaire" method="post" action="./fidelisation-vazee.html">
			<input type="hidden" name="mon_action" id="mon_action" value="connexion-vazee">
			<input type="hidden" name="etat" value="<?=$etat?>">
			<input type="hidden" name="page_suivante" value="<?=$page_suivante?>">
			<input type="hidden" name="id_client" value="<?=$_SESSION[ "site" ][ "client" ][ "num_client" ]?>">
			
			<input type="hidden" name="id" value="<?=$_GET[ "id" ]?>">
			
			<!-- Mes points Vazee -->
			<fieldset>
				<legend><h2>Comment obtenir mon identifiant Vazee ?</h2></legend>
				
				<div id="ou-trouver">
					<p class="legende_grande_police_titre" style="margin-bottom:20px;">
						Je n'ai pas encore téléchargé l'appli Vazee :
					</p>	
							
					<p class="legende_grande_police" style="margin-bottom:10px;">
						rendez-vous sur le site <a href="https://www.vazee.fr" target="_new">www.vazee.fr</a> avec votre smartphone ou votre tablette et cherchez ces logos :
					</p>
					
					<p><img src="/img/vazee-applestore.png" width="125" height="44"><img src="/img/vazee-googleplay.png" width="125" height="44"></p>
					
					<p class="legende_grande_police_titre" style="margin-bottom:20px;">
						J'ai téléchargé l'appli :
					</p>	
					
					<p class="legende_grande_police" style="margin-bottom:10px;">
						une fois inscrit, recopiez l'identifiant obtenu dans votre profil <b><?=$quel_site?></b> <a href="/fidelisation-vazee.html?lb=1#">ICI</a>
					</p>
					
					
					<p><img src="/img/vazee-ou-trouver-identifiant1.jpg" width="161" height="252">&nbsp;&nbsp;<img src="/img/vazee-ou-trouver-identifiant2.jpg" width="161" height="252"></p>
				
				</div>
				
				
			</fieldset>
			
			<!-- Poursuivre ma commande -->
			<fieldset class="<?=$affichage_poursuite_commande?>">
				<legend>
					<h2>Poursuivre ma commande?</h2>
				</legend>
				
				<div>
					<p class="legende" style="margin-bottom:20px;">Vous souhaitez simplement finaliser cette commande et perdre vos <b><?=$nb_point_gagne?> points disponibles</b> :</p>
					
					<div class="processing btn-wait-finaliser" style="display:none;">En cours...</div>
					<input type="button" class="btn finaliser" value="Finaliser ma commande">
				</div>
				
			</fieldset>
			
		</form>
	<?
	// Affichage dans une LightBox
	echo "	</div>\n";
	echo "</body>\n";
	?>
	
	<!-- Jquery -->
	<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
	<script src="/js/jquery-ui-1.10.2.custom.js<?=$cache?>"></script>
	<script src="/js/jquery.scrollTo-1.4.3.1-min.js<?=$cache?>"></script>
	<script src="/js/fadeSlideShow.js<?=$cache?>"></script>
	<script src="/js/jquery.anythingslider.js<?=$cache?>"></script>
	<script src="/js/hideMaxListItem.js<?=$cache?>"></script>
	<script src="/js/truncateText.js<?=$cache?>"></script>
	<script src="/js/topLink.js<?=$cache?>"></script>
	<script src="/js/jquery.coookie.js<?=$cache?>"></script>
	<script src="/js/jquery.showHide.js<?=$cache?>"></script>
	<script src="/js/jquery.tooltipster.js<?=$cache?>"></script>
	
	<script type="text/javascript" src="/css/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="/css/fancybox/jquery.fancybox-1.3.4.js"></script>
	<script type="text/javascript" src="/js/fancybox_custom.js"></script>
	<script type="text/javascript" src="/js/divers.js"></script>
	
 	<!-- plugins, script et CSS liées -->
	<script src="/js/jquery.tooltipster.js<?=$cache?>"></script>
	
	<script src="/lib/jquery-validation/jquery.validate.js<?=$cache?>" type="text/javascript"></script>
	<script src="/lib/jquery-validation/messages_fr.js<?=$cache?>" type="text/javascript"></script>
	
	<script>
		
		function afficher_message( div, classe, message ) {
			$( "#" + div ).tooltipster( 'update', "<div class='" + classe + "'>" + message + "</div>" );
		}
		
		function initialiser( champ ) {
			//alert( "init de "+ champ );
			
			if ( champ == '' || champ == 'login_vazee' ) {
				$( "#login_vazee" ).removeClass( "input-error" );
				afficher_message( "login_vazee", "hint", "Indiquer votre identifiant." );
			}
			
		}
		
		// DOM Ready
		$(function(){
			
			// ---------- Gestion des aides textuelles ---------- //
			$( ".tooltip-hint" ).tooltipster({
			    animation: 'fade',
			    arrow: 'true',
			    position:'right'
			});
			
			// Initialisation des aides textuelles
			initialiser( '' );
			// -------------------------------------------------- //
			
			$( ".connexion" ).click(function() {
				initialiser( '' );
				$( ".btn" ).hide();
				$( ".btn-wait" ).show();
					
				return true;
			});
			
			$( ".afficher_vazee" ).click(function() {
				if ( $( "#div_vazee" ).hasClass( "wait" ) ) $( "#div_vazee" ).fadeIn();
				else $( "#div_vazee" ).fadeOut();
					
				return false;
			});
			
			$( ".modifier_vazee" ).click(function() {
				$( "#div-detail" ).hide();
				$( "#div-connexion" ).show();
					
				return false;
			});
			
			$( ".supprimer_vazee" ).click(function() {
				$( "#mon_action" ).val( "supprimer-compte" );
				$( "#formulaire" ).submit();
			});
			
			$( ".fermer" ).click(function() {
				parent.$.fancybox.close();
			});
			
			$( ".finaliser" ).click(function() {
				$( ".finaliser" ).hide();
				$( ".btn-wait-finaliser" ).show();
				window.location.href = "/commande/commande_resume_commande.php?vd=letzgo";
			});
			
		});

	</script>
		
</html>
<? include_once( "../include_connexion/connexion_site_off.php" ); ?>