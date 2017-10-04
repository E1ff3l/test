<? include_once( "../classes/config_v2.php" ); ?>
<? include_once( "../classes/classes.php" ); ?>
<? include_once( "../include_connexion/connexion_site_on.php" ); ?>
<?
	$debug = false;
	$key = $_GET[ "k" ];
	$vitrine_valeur = $_GET[ "v" ];
	
	/*echo "<pre>";
	print_r( $_GET );
	echo "</pre>";*/
	
	$ville = new ville();
	$commande = new commande();
	$restaurant = new restaurant();
	$zone_livraison = new zone_livraison();
	
	if ( $debug ) {
		echo "<pre>";
		//print_r( $_GET );
		print_r( $_SESSION );
		echo "</pre>";
		
		echo "--- num_restaurant : " . $num_restaurant . "<br>";
	}
	
	$chaine_affichage = $_GET[ "r" ];
	$chaine_affichage = str_replace( "Code postal  ou  ville", "", $chaine_affichage );
	$chaine = strtolower( utf8_decode( $chaine_affichage ) );
	
	// ----------- Traitement des informations AVANT affichage ---------- //
	if ( 1 == 1 ) {
		
		// ---------------- Correspondance restaurant (SI NON MB) ------- //
		if ( $restaurant->loadByKey( '', $key, $debug ) ) {
			
			// On a une différence!
			if ( $_SESSION[ "site" ][ "num_restaurant" ] != $restaurant->id ) {
				$commande->verifierConcordance( 
					$_SESSION[ "site" ][ "num_restaurant" ], 
					$restaurant->id,
					false
				);
				
				$_SESSION[ "site" ][ "num_restaurant" ] = $restaurant->id;
				if ( isset( $_SESSION[ "site" ][ "key_marque_blanche" ] ) ) $key = $_SESSION[ "site" ][ "key_marque_blanche" ];
				if ( isset( $_SESSION[ "site" ][ "vitrine_valeur" ] ) ) $vitrine_valeur = $_SESSION[ "site" ][ "vitrine_valeur" ];
			}
		}
		// -------------------------------------------------------------- //
		
		// ----- Liste des villes livrées par le restaurant ------------- //
		if ( 1 == 1 ) {
			unset( $recherche );
			$recherche[ "id_resto" ] = $_SESSION[ "site" ][ "num_restaurant" ];
			$recherche[ "actif" ] = "1";
			$liste = $zone_livraison->getListeV2( $recherche, $debug );
			
			$liste_ville_texte = "0";
			
			if ( !empty( $liste ) ) {
				foreach( $liste as $_zone ) {
					$liste_ville_texte .= "," . $_zone->id_ville;
				}
			}
			if ( $debug ) echo "\--- Liste : " . $liste_ville_texte . "\n";
		}
		// -------------------------------------------------------------- //
			
		// ----- Liste des codes postaux correspondants à la recherche -- //
		if ( 1 == 1 ) {
			unset( $recherche );
			$recherche[ "requete_directe" ] = " WHERE cp LIKE '" . addslashes( $chaine ) . "%'";
			$recherche[ "requete_directe" ] .= " AND id IN (" . $liste_ville_texte . ")";
			$recherche[ "requete_directe" ] .= " AND visible = '1'";
			$recherche[ "requete_directe" ] .= " ORDER BY cp, priorite";
			$liste_cp = $ville->getListe( $recherche, $debug );
		}
		// -------------------------------------------------------------- //
		
		// ----- Liste des villes ou quartiers correspondants ----------- //
		if ( 1 == 1 ) {
			unset( $recherche );
			$recherche[ "requete_directe" ] = " WHERE nom LIKE LOWER( '%" . addslashes( $chaine ) . "%' )";
			$recherche[ "requete_directe" ] .= " AND id IN (" . $liste_ville_texte . ")";
			$recherche[ "requete_directe" ] .= " AND visible = '1'";
			$recherche[ "requete_directe" ] .= " ORDER BY nom, priorite";
			$liste_ville = $ville->getListe( $recherche, $debug );
		}
		// -------------------------------------------------------------- //
		
	}
	// ------------------------------------------------------------------ //
	
	
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
		
		<title>Restomalin - Résultats possibles</title>
		<meta name="description" content="Que cherchez-vous sur restomalin.com?">
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
	</head>
	
	<body>
		<div id="container-box">
			<fieldset>
				<legend>
					<h2>Résultats possibles pour "<?=$chaine_affichage?>"</h2>
				</legend>
				
				<div id="col-unique-contenu">
					
					<?
					// Aucun résultat
					if ( empty( $liste_cp ) && empty( $liste_ville ) ) {
						echo "<div class='warning'>\n";
						echo "	<h2>Désolé</h2>\n";
						echo "	<p>Aucune réponse n'a été trouvée...</p>\n";
						echo "</div>\n";
					}
					else {
						
						// Codes postaux trouvés
						if ( !empty( $liste_cp ) ) {
							echo "<h3>Codes postaux contenant \"" . $chaine_affichage . "\"</h3>\n";
							echo "<ul>\n";
							
							foreach( $liste_cp as $_ville ) {
								if ( $_ville->cp > 0) {
									$nom_ville = "-" . utf8_encode( strtolower( $_ville->nom ) );
									$nom_ville = str_replace( "wcentrew", "centre", $nom_ville );
									
									// URL de type "/validation/carte.php?id=1&idv=1&d=1&mode=l&k=" . $marque_blanche . "&v=" . $vitrine"
									$titre = $_ville->cp . " " . $nom_ville;
									$url = "/validation/carte.php?id=" . $_SESSION[ "site" ][ "num_restaurant" ] . "&idv=" . $_ville->id . "&d=1&mode=l&k=" . $key . "&v=" . $vitrine_valeur;
									
									echo "	<li><a href='" . $url . "' target='_parent'>" . $titre . "</a></li>\n";
								}
							}
							
							echo "</ul>\n";
						}
						
						// Villes ou quartiers trouvés
						if ( !empty( $liste_ville ) ) {
							echo "<h3>Villes ou quartiers contenant \"" . $chaine_affichage . "\"</h3>\n";
							echo "<ul>\n";
							
							foreach( $liste_ville as $_ville ) {
								if ( $_ville->cp > 0) {
									$nom_ville = "- " . utf8_encode( $_ville->nom );
									$nom_ville = str_replace( "wcentrew", "centre", $nom_ville );
									
									// URL de type "/validation/carte.php?id=1&idv=1&d=1&mode=l&k=" . $marque_blanche . "&v=" . $vitrine"
									$titre = $_ville->cp . " " . $nom_ville;
									$url = "/validation/carte.php?id=" . $_SESSION[ "site" ][ "num_restaurant" ] . "&idv=" . $_ville->id . "&d=1&mode=l&k=" . $key . "&v=" . $vitrine_valeur;
									
									echo "	<li><a href='" . $url . "' target='_parent'>" . $titre . "</a></li>\n";
								}
							}
							
							echo "</ul>\n";
						}
					}
					?>
					
				</div>
				
				<div id="boutons-action">
					<a href="#" id="retour" class="btn-comp">Retour</a>
				</div>
			</fieldset>
		</div>
	</body>

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
		
		// DOM Ready
		$(function(){
			
			$( "#retour" ).click(function() {
				parent.$.fancybox({
					'href'				: './completion.php?k=<?=$key?>&v=<?=$vitrine_valeur?>',
					'width'				: 400,
					'height'			: 280,
					'autoScale'			: false,
					'transitionIn'		: 'none',
					'transitionOut'		: 'none',
					'type'				: 'iframe',
					'showCloseButton'	: false,
					'hideOnOverlayClick': false
				});
			});
			
		});

	</script>
		
</html>
<? include_once( "../include_connexion/connexion_site_off.php" ); ?>