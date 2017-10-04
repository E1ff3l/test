<? include_once( "../classes/config_v2.php" ); ?>
<? include_once( "../classes/classes.php" ); ?>
<? include_once( "../include_connexion/connexion_site_on.php" ); ?>
<?
	$debug = false;
	
	$vazee = new vazee( $_SESSION[ "fidelisation" ][ "login_vazee" ], '', $debug );
	//$vazee->getParticipationDefi( "VZ-UAUNI", '', true );
	//$vazee->getParticipationDefi( "VZ-INCR", '', true );
	//$vazee->connecter( "VZ-UYCBO", '', true );
	
	// ---- On défini sur quel site on est (restomalin ou vit) pour adapter le discours
	if (( $_SESSION[ "vit" ][ "is_mb" ] == 1 ) OR ( $_SESSION[ "vit" ][ "is_vitrine" ] == 1 )) $quel_site = utf8_encode( $_SESSION[ "site" ][ "signature" ] );
	else $quel_site = "RESTOMALIN";

	$etat = 			( $_GET[ "etat" ] != '' ) ? $_GET[ "etat" ] : $_POST[ "etat" ];
	$mon_action = 		$_POST[ "mon_action" ];
	$page_suivante = 	$_POST[ "page_suivante" ];
	
	$affichage_message_success = "wait";
	$affichage_message_erreur = "wait";
	
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
				
				// ---- Redirection directe après connexion (Menus) --------------- //
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
				
				$message_success = "Vous êtes à présent déconnecté de votre compte Vazee.";
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
		
		// ---- Compte Vazee renseigné --> Recup des infos Vazee ------------ //
		if ( $_SESSION[ "fidelisation" ][ "login_vazee" ] != '' ) {
			
			// ---- Récupération du nombre de points Vazee
			$nb_point = $vazee->nb_point;
			$nb_point = ( $nb_point > 1 ) ? $nb_point . " points" : $nb_point . " point";
			
			// ---- Participation à un défi
			if ( 1 == 1 ) {
				//print_pre( $_SESSION[ "fidelisation" ] );
				
				// ---- Défi en cours --------------------------------------- //
				if ( $_SESSION[ "fidelisation" ][ "participe_defi" ] ) {
					
					// ---- Défi pas encore finalisé ------------------------ //
					if ( $_SESSION[ "fidelisation" ][ "nb_commande_passee" ] < $_SESSION[ "fidelisation" ][ "nb_commande_necessaire" ] ) {
						$texte_defi = $_SESSION[ "fidelisation" ][ "defi_titre" ];
						$texte_defi .= " (" . $_SESSION[ "fidelisation" ][ "nb_commande_passee" ] . " /  " . $_SESSION[ "fidelisation" ][ "nb_commande_necessaire" ] . ")";
					}
					
					// ---- Défi terminé! ------------------------------ //
					else {
						$texte_defi = "<font color='green'>" . $_SESSION[ "fidelisation" ][ "defi_titre" ] . " validé!</font>";
					}
				}
				
				// ---- Pas de défi en cours... ----------------------------- //
				else {
					$texte_defi = "<font color='red'>Vous ne participez à aucun défi actuellement...</font>";
				}
			}
			
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
				
				<!-- Détail de son compte Vazee -->
				<div id="div-detail" class="<?=$affichage_detail_vazee?>">
					<p class="legende" style="margin-bottom:20px;">Détails de votre compte :</p>
					
					<div class="field">
						<label><span>Votre identifiant</span></label>
						<?=$_SESSION[ "fidelisation" ][ "login_vazee" ]?>&nbsp;&nbsp;
						<a href="#" class="modifier modifier_vazee">Modifier</a>&nbsp;|&nbsp;
						<a href="#" class="modifier supprimer_vazee">Déconnecter</a>
					</div>
					
					<div class="field">
						<label><span>Vos points disponibles</span></label>
						<?=$nb_point?>
					</div>
					
					<div class="field">
						<label><span>Les Défis Restomalin</span></label>
						<?=$texte_defi?>
					</div>
					
					<?
					// ---- Pas de page suivante --> On ferme la fenêtre ------ //
					if ( $page_suivante == '' ) echo "<input type='button' class='btn fermer' value='Fermer'>\n";
					else echo "<input type='button' class='btn suivant' value='Suivant'>\n";
					?>
				</div>
				
				<legend><h2>Mes points Fidélité Vazee - Comment ça marche?</h2></legend>
				
<!--
				<div id="ou-trouver"><p class="legende_grande_police" style="margin-bottom:20px;">Vous souhaitez en savoir plus sur ce programme de fidélité ? <a href="#" class="afficher_vazee">Voir la vidéo</a></p></div>
-->				
				
				<!-- Connexion à son compte Vazee -->
				<div id="div-connexion" class="<?=$affichage_connexion_vazee?>">
<!--
					Vous voulez aller plus loin et en savoir plus : <a href="https://restomalin.com/divers/fidelite_Vazee-Restomalin.pdf" target="_new">Cliquez ici</a>
					<br /><br />
-->					
					<p class="legende_grande_police_titre" style="margin-bottom:20px;">
						J'ai déjà un compte VAZEE :
					</p>

					<!--<p class="legende_grande_police" style="margin-bottom:20px;">Je me connecte :</p>-->
					
					<div class="field">
						<label for="login_vazee"><span>Votre identifiant Vazee</span></label>
						<input type="text" name="login_vazee" id="login_vazee" size="26" class="tooltip-hint champ" maxlength="50" value="">
					</div>
					<div id="ou-trouver"><a href="/vazee/programme-de-fidelite-vazee-v2.pdf" target="_new">Où le trouver ?</a></div>
					
					<div class="processing btn-wait" style="display:none;">En cours...</div>
					<input type="submit" class="btn connexion" value="Valider">
				</div>

				<div id="div_success" class="success <?=$affichage_message_success?>">
					<h2>Opération réussie !</h2>
					<p id="p_erreur"><?=$message_success?></p>
				</div>
				
				<div id="div_erreur" class="warning <?=$affichage_message_erreur?>">
					<h2>Erreur</h2>
					<p id="p_erreur"><?=$message_erreur?></p>
				</div>
				

<!--				<div id="div_vazee" class="wait"> -->
					<p class="legende_grande_police_titre" style="margin-bottom:20px;">
						Découverte en vidéo :
					</p>

					<iframe width="500" height="300" src="https://www.youtube.com/embed/y-owYAxpu5Q" frameborder="0" allowfullscreen></iframe>
<!--				</div>-->

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