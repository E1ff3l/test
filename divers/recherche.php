<? include_once( "../classes/config_v2.php" ); ?>
<? include_once( "../classes/classes.php" ); ?>
<? include_once( "../include_connexion/connexion_site_on.php" ); ?>
<? include_once( "../includes/information.php" ); ?>
<?
	$debug = false;
	
	$ville = new ville();
	$restaurant = new restaurant();
	
	$lightbox = ( $_GET[ "lb" ] == '1' ) ? true : false;
	$target = ( $_GET[ "lb" ] == '1' ) ? "target='_parent'" : "";
	$mode = $_GET[ "m" ];
	$chaine_affichage = $_GET[ "r" ];
	$chaine = strtolower( utf8_decode( $chaine_affichage ) );
	
	// ----------- Traitement des informations AVANT affichage ---------- //
	if ( 1 == 1 ) {
		
		// ----- Liste des codes postaux correspondants à la recherche -- //
		if ( 1 == 1 ) {
			unset( $recherche );
			$recherche[ "requete_directe" ] = " WHERE cp LIKE '" . addslashes( $chaine ) . "%'";
			$recherche[ "requete_directe" ] .= " AND visible = '1'";
			$recherche[ "requete_directe" ] .= " ORDER BY cp, priorite";
			$liste_cp = $ville->getListe( $recherche, $debug );
		}
		// -------------------------------------------------------------- //
		
		// ----- Liste des villes ou quartiers correspondants ----------- //
		if ( 1 == 1 ) {
			unset( $recherche );
			$recherche[ "requete_directe" ] = " WHERE nom LIKE LOWER( '%" . addslashes( $chaine ) . "%' )";
			$recherche[ "requete_directe" ] .= " AND visible = '1'";
			$recherche[ "requete_directe" ] .= " ORDER BY nom, priorite";
			$liste_ville = $ville->getListe( $recherche, $debug );
		}
		// -------------------------------------------------------------- //
		
		// ----- Liste des restaurants correspondants ------------------- //
		if ( 1 == 1 ) {
			unset( $recherche );
			$recherche[ "where" ] = " WHERE ( nom LIKE LOWER( '%" . addslashes( $chaine ) . "%' )";
			$recherche[ "where" ] .= " OR cp LIKE '%" . addslashes( $chaine ) . "%' )";
			$recherche[ "where" ] .= " AND restos.visible = '1'";
			$recherche[ "where" ] .= " ORDER BY nom";
			$liste_restaurant = $restaurant->getListeV2( $recherche, $debug );
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

	<?
	// Affichage dans une LightBox
	if ( $lightbox ) {
		echo "<body>\n";
		echo "	<div id='container-box'>\n";
	}
	
	// Affichage HORS LightBox
	else {
		echo "<body>\n";
		echo "<div id='container'>\n";
			
		echo "	<div id='liens-utiles'>\n";
		include_once( "../includes/menu_connexion.php" );
		echo "	</div>\n";
			
		echo "	<div id='page'>\n";
		include_once( "../includes/header.php" );
		echo "		<div class='inner'>\n";
		echo "			<div id='breadcrumbs'>\n";
		echo "				<div>\n";
		echo "				  <a href='/' itemprop='url'>\n";
		echo "				    <span itemprop='title' class='crumb'>Accueil</span>\n";
		echo "				  </a> ›\n";
		echo "				</div>\n";
		echo "				<div>\n";
		echo "				    <span itemprop='title' class='crumb'>Suggérer un restaurant</span>\n";
		echo "				</div>  \n";
		echo "			</div>\n";
		echo "		</div>\n";
		echo "		<div id='content' class='inner'>\n";
		echo "			<div id='col-unique-contenu'>\n";
	}
	?>
	
				<fieldset>
					<legend>
						<h2>Résultats possibles pour "<?=$chaine_affichage?>"</h2>
					</legend>
					
					<div id="col-unique-contenu">
						
						<?
						// Aucun résultat
						if ( empty( $liste_cp ) && empty( $liste_ville ) && empty( $liste_restaurant ) ) {
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
										
										// URL de type "restaurant-livraison/strasbourg-bourse/1/0/page.htm"
										if ( $mode == 'l' ) {
											$titre = $_ville->cp . " " . $nom_ville;
											$url = "restaurant-livraison/" . $_ville->meta . "/" . $_ville->id . "/0/page.htm";
										}
										
										// URL de type "restauration-a-domicile/strasbourg-bourse/1/0/page.htm"
										else {
											$titre = $_ville->cp . " " . $nom_ville;
											$url = "restaurant-a-emporter/" . $_ville->meta . "/" . $_ville->id . "/0/page.htm";
										}
										
										echo "	<li><a href='" . $url . "' class='set-temp' data-ville='" . $_ville->id . "' " . $target . ">" . $titre . "</a></li>\n";
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
										
										// URL de type "restaurant-livraison/strasbourg-bourse/1/0/page.htm"
										if ( $mode == 'l' ) {
											$titre = $_ville->cp . " " . $nom_ville;
											$url = "restaurant-livraison/" . $_ville->meta . "/" . $_ville->id . "/0/page.htm";
										}
										
										// URL de type "restauration-a-domicile/strasbourg-bourse/1/0/page.htm"
										else {
											$titre = $_ville->cp . " " . $nom_ville;
											$url = "restaurant-a-emporter/" . $_ville->meta . "/" . $_ville->id . "/0/page.htm";
										}
										
										echo "	<li><a href='" . $url . "' class='set-temp' data-ville='" . $_ville->id . "' " . $target . ">" . $titre . "</a></li>\n";
									}
								}
								
								echo "</ul>\n";
							}
							
							// Restaurants trouvés
							if ( !empty( $liste_restaurant ) ) {
								echo "<h3>Nom de restaurants contenant \"" . $chaine_affichage . "\"</h3>\n";
								echo "<ul>\n";
								
								foreach( $liste_restaurant as $_restaurant ) {
										
									// Le restaurant doit être OUVERT
									if ( $_restaurant->actif != '0' ) {
										$__nom_restaurant = utf8_encode( $_restaurant->nom ) . " (" . $_restaurant->cp . ")";
										$nom_resto_meta = tranformer_url( $_restaurant->nom, 'utf-8', false );
										
										// Chargement de la ville de rattachement du restaurant
										$ville->load( $_restaurant->id_ville_rattachement );
										
										// URL de type "md30-pizza/strasbourg-conseil-des-xv/4/0/2/page.htm"
										$lien = ( $mode == 'l' )
											? $_restaurant->id . "' class='afficher_quartier"
											: "/" . $nom_resto_meta . "/" . $ville->meta . "/" . $_restaurant->id_ville_rattachement . "/0/" . $_restaurant->id . "/a-emporter/page.htm";
										echo "<li><a href='" . $lien . "' " . $target . ">" . $__nom_restaurant . "</a></li>\n";
										
										// En mode "Livraison"
										if ( $mode == 'l' ) {
											$zone_livraison = new zone_livraison();
											
											// Liste des quartiers desservis par le restaurant
											unset( $recherche );
											$recherche[ "champ" ] = "villes.*";
											$recherche[ "requete_directe" ] = " INNER JOIN zone_livraison ON zone_livraison.id_ville = villes.id";
											$recherche[ "requete_directe" ] .= " WHERE zone_livraison.id_resto = " . $_restaurant->id;
											$recherche[ "requete_directe" ] .= " AND zone_livraison.actif = '1'";
											$recherche[ "requete_directe" ] .= " ORDER BY villes.nom";
											$liste_ville = $ville->getListe( $recherche, false );
											
											if ( !empty( $liste_ville ) ) {
												echo "<div id='resto_" . $_restaurant->id . "' class='wait' style='margin:0px 0px 10px 20px; border: 0px solid red;'>\n";
												
												foreach( $liste_ville  as $_ville ) {
													
													$lien = ( $mode == 'l' )
														? "/" . $nom_resto_meta . "/" . $_ville->meta . "/" . $_ville->id . "/0/" . $_restaurant->id . "/page.htm"
														: "/" . $nom_resto_meta . "/" . $_ville->meta . "/" . $_ville->id . "/0/" . $_restaurant->id . "/a-emporter/page.htm";
														
													$balise_title = ( $mode == 'l' )
														? "Livraison sur " . utf8_encode( $_ville->nom )
														: "Plats à emporter sur " . utf8_encode( $_ville->nom );
														
													echo "<li><a href=\"" . $lien . "\" class='set-temp' data-ville='" . $_ville->id . "' title=\"" . $balise_title . "\" " . $target . ">Livraison sur " . utf8_encode( $_ville->nom ) . " (" . $_ville->cp . ")</a></li>\n";
												}
												
												echo "</div>\n";
											}
										}
									}
								}
								
								echo "</ul>\n";
							}
						}
						?>
						
					</div>
				</fieldset>
			
	<?
	// Affichage dans une LightBox
	if ( $lightbox ) {
		echo "	</div>\n";
		echo "</body>\n";
	}
	
	// Affichage HORS LightBox
	else {
		echo "				</div>\n";
		echo "				<span class='clearfix'>&nbsp;</span>\n";
		echo "			</div>\n";
			include_once( "../includes/footer.php" );
		echo "		</div>\n";
		echo "	</div>\n";
		echo "</body>\n";
	}
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
		
		// DOM Ready
		$(function(){
			
			$( ".afficher_quartier" ).click(function() {
				var val = $(this).attr( "href" );
				//alert( "afficher_quartier " + val );
				$( "#resto_" + val ).toggleClass( "wait" );
				
				return false;
			});
			
		});

	</script>
		
</html>
<? include_once( "../include_connexion/connexion_site_off.php" ); ?>