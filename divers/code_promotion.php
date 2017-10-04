<? include_once( "../classes/config_v2.php" ); ?>
<? include_once( "../classes/classes.php" ); ?>
<? include_once( "../include_connexion/connexion_site_on.php" ); ?>
<? include_once( "../includes/information.php" ); ?>
<?
	$debug = 		false;
	$retour = 		$_GET[ "r" ];
	$lightbox = 	( $_GET[ "lb" ] == '1' ) ? true : false;
	$mon_action =	$_POST[ "mon_action" ];
	//echo ( $_GET[ "lb" ] == '1' ) ? "Dans LB" : "Hors LB";
	
	$tab_chiffre =	array( "zéro", "un", "deux", "trois", "quatre", "cinq", "six", "sept", "huit", "neuf", "dix" );
	$chiffre_1 =	rand( 0, 10 );
	$chiffre_2 =	rand( 0, 10 );
	$somme =		$chiffre_1 + $chiffre_2;
	
	// -------------- HEURE COURANTE -------------------------------------------- //
	// PEUT ETRE MODIFIEE (format : "hh, mm, ss, mois, jour, année")
	$debug_horaire =			false;
	$_SESSION[ "general" ][ "heure_courante" ] = ( !$debug_horaire ) ? getMktime( "now" ) : getMktime( "18/01/2016 11:10", true );
	// -------------------------------------------------------------------------- //
	
	
	// ---- Remplissage automatique des champs ---------------------------------- //
	//print_pre( $_SESSION[ "site" ][ "client" ] );
	//print_pre( $_SESSION[ "express" ] );
	if ( $_SESSION[ "site" ][ "client" ][ "connexion" ] ) {
		// Chargement des informations client
		$client = 	new client();
		$client->load( $_SESSION[ "site" ][ "client" ][ "num_client" ] );
		
		$nom = 		ucfirst( $client->nom );
		$prenom = 	ucfirst( $client->prenom );
	}
	else if ( $_SESSION[ "express" ][ "termine" ] ) {
		$nom = 		ucfirst( $_SESSION[ "express" ][ "nom_express" ] );
		$prenom = 	ucfirst( $_SESSION[ "express" ][ "prenom_express" ] );
	}
	
	//unset( $_SESSION[ "code_promo" ] );
	$classe_affichage_saisie = 	( empty( $_SESSION[ "code_promo" ] ) )	? "" : "wait";
	$classe_affichage_encours = ( empty( $_SESSION[ "code_promo" ] ) ) 	? "wait" : "";
	
	// ---- Gestion de la mise en cache ----------------------------------------- //
	$cache = ( MISE_EN_CACHE ) ? "" : "?" . time();
	//echo $cache . "<br>";
	
	//print_pre( $_SESSION[ "site" ][ "liste_promo" ] );
	//print_pre( $_SESSION[ "code_promo" ] );
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Cache-Control" content="no-cache">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Expires" content="0"> 
		
		<title>Codes promotionnels</title>
		<meta name="description" content="Saisissez ici votre code promotionnel">
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
		echo "				    <span itemprop='title' class='crumb'>Demande de rappel</span>\n";
		echo "				</div>  \n";
		echo "			</div>\n";
		echo "		</div>\n";
		echo "		<div id='content' class='inner'>\n";
		echo "			<div id='col-unique-contenu'>\n";
	}
	?>
	
			<form id="formulaire" method="post" action="./code_promotion.php">
				<input type="hidden" name="mon_action" id="mon_action" value="">
				<input type="hidden" name="lb" value="<?=$_GET[ "lb" ]?>">
				<input type="hidden" name="somme" value="<?=md5( $somme )?>">
				<input type="hidden" name="id_client" value="<?=$_SESSION[ "site" ][ "client" ][ "num_client" ]?>">
				<input type="hidden" name="r" id="r" value="<?=$retour?>">
				
				<fieldset id="fieldset_saisie" class="<?=$classe_affichage_saisie?>">
					<legend>
						<h2>Code promotionnel</h2>
					</legend>
					
					<div id="div_erreur_code" class="warning wait">
						<h2>Désolé,</h2>
						<p>Quelques erreurs sont présentes dans le formulaire</p>
					</div>
					
					<div>
						<p class="legende" style="margin-bottom:20px;">
							Vous avez un code promo ? Saisissez-le ici
						</p>
						
						<div class="field">
							<label class="obligatoire" for="code_promo"><span>Votre code promotionnel</span></label>
							<input type="text" name="code_promo" id="code_promo" size="26" class="tooltip-hint champ" maxlength="50" value="">
						</div>
						
						<div id="div_portable" class="field wait">
							<label class="obligatoire" for="portable"><span>Téléphone</span></label>
							<input type="text" name="portable" id="portable" size="26" class="tooltip-hint champ" maxlength="50" value="">
						</div>
						
						<?
						// On n'affiche pas le captcha si le client est connecté ou en mode Express
						if ( !$_SESSION[ "site" ][ "client" ][ "connexion" ] && !$_SESSION[ "express" ][ "termine" ] ) {
							?>
							<p class="obligatoire">Combien font (En chiffres)</p>
							<div class="field">
								<label class="obligatoire" for="captcha"><span><?=$tab_chiffre[ $chiffre_1 ]?> + <?=$tab_chiffre[ $chiffre_2 ]?></span></label>
								<input type="text" name="captcha" id="captcha" class="tooltip-hint champ" size="10" maxlength="50" value="" autocomplete="off" >
							</div>
							<?
						}
						?>
						<p class="legende notice">* Champs obligatoires</p>
						
						<div class="processing btn-wait" style="display:none;">En cours...</div>
						<div id="boutons-action" style="margin-top:10px;">
							<input type="submit" class="btn" id="validation-commande" value="Valider">
							<a href="#" id="aide" class="btn-comp retour">Retourner à ma commande</a>
						</div>
					</div>
					
				</fieldset>
				
				<fieldset id="fieldset_en_cours" class="<?=$classe_affichage_encours?>">
					<legend>
						<h2>Code promotionnel en cours</h2>
					</legend>
					
					<div>
						<p class="legende" style="margin-bottom:20px;">
							<?=utf8_encode( $_SESSION[ "code_promo" ][ 0 ][ "titre" ] )?><br>
							<?=utf8_encode( $_SESSION[ "code_promo" ][ 0 ][ "description" ] )?>
						</p>
						
						<div class="processing btn-en_cours-wait" style="display:none;">En cours...</div>
						<div id="boutons-en_cours-action" style="margin-top:10px;">
							<a href="#" class="btn-valider-lightbox modifier-code">Modifier le code</a>
							<a href="#" id="aide" class="btn-comp retour">Retourner à ma commande</a>
							<a href="#" id="aide" class="btn-comp annuler-code">Finalement, j'utiliserai mon code pour une autre commande</a>
						</div>
					</div>
					
				</fieldset>
				
				<p id="waiting" style="text-align:center;" class="wait">
					<img src="/img/ajax-loader.gif" alt="Redirection en cours..." />
				</p>
				
			</form>
	
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
		
		function afficher_message( div, classe, message ) {
			$( "#" + div ).tooltipster( 'update', "<div class='" + classe + "'>" + message + "</div>" );
		}
		
		function initialiser( champ ) {
			//alert( "init de "+ champ );
			
			$( "#div_erreur_code" ).hide();
			
			if ( champ == '' || champ == 'code_promo' ) {
				$( "#code_promo" ).removeClass( "input-error" );
				afficher_message( "code_promo", "hint", "Indiquer votre code promotionnel." );
			}
			
			if ( champ == '' || champ == 'portable' ) {
				$( "#portable" ).removeClass( "input-error" );
				afficher_message( "portable", "hint", "Indiquer le portable associé au code promo." );
			}
			
			if ( champ == '' || champ == 'captcha' ) {
				$( "#captcha" ).removeClass( "input-error" );
				afficher_message( "captcha", "hint", "Indiquez la somme en chiffre ici." );
			}
		}
		
		function poster( form ) {
			var tout_ok = true;
			
			// En cas de présence de captcha
			if ( $( "#captcha" ).length > 0 ) {
				$.ajax({
					type: 		"POST",
					url: 		"/ajax/ajax_divers.php?task=check_captcha",
					data: 		$( "#formulaire" ).serialize(),
					error: 		function() { alert( "Une erreur s'est produite..." ); },
					success: 	function( data ){
						var obj = $.parseJSON( data );
						
			        	if ( obj.erreur ) {
							$( "#" + obj.champ ).addClass( "input-error" );
							afficher_message( obj.champ, "error", obj.message );
							tout_ok = false;
			        	}
					}
				});
			}
			
			if ( tout_ok ) {
				//form.submit();
				//alert( "ELSE : post..." );
				
				// ---- Retour vers la page des choix de modes de paiement
				if ( $( "#r" ).val() == "mp" ) {
					//alert( "Redirection..." );
					window.location.href = "/commande/commande_mode_paiement.php";
				}
				
				$( "#boutons-action" ).show();
				$( ".btn-wait" ).hide();
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
			
			// ---- Initialisation des aides textuelles --------- //
			initialiser( '' );
			// -------------------------------------------------- //
			
			// ---- On retourne à la commande (Fermeture de la FancyBox)
			$( ".retour" ).live( "click", function() {
				//alert( "Retour commande" );
				parent.$.fancybox.close();
				
				return false;
			});
			
			// ---------- Validation du formulaire -------------- //
			$( "#formulaire" ).validate({
				focusInvalid: false,
				onkeyup: function( element ) { 
					if( $( "#" + element[ "name" ] ).valid() ) initialiser( element[ "name" ] );
				},
				rules: {
					code_promo:	"required",
					portable:	"required",
					captcha:	"required"
				},
				messages: {
		            portable: 	"Indiquer le portable associé au code promo.",
		            captcha: 	"Veuillez indiquer la somme en chiffre ici."
		        },
				invalidHandler: function(event, validator) {
					// 'this' refers to the form
					var errors = validator.numberOfInvalids();
					//alert( "Nb erreur : " + errors );
					
					// On a des erreurs...
					if ( errors ) {
						var tab_aide = new Array( "code_promo", "captcha" );
						$.each( tab_aide, function( index, champ ) {
							initialiser( champ );
						});
					}
				},
				showErrors: function( map, list ) {
					$.each( list, function( index, error ) {
						var _element = $( error.element );
						var div = _element.attr( "name" );
						//alert( "Erreur sur " + div );
						$( "#" + div ).addClass( "input-error" );
						afficher_message( div, "error", error.message );
					});
				},
				submitHandler: function( form ) {
					initialiser( '' );
					$( "#div_portable" ).hide();
					$( "#boutons-action" ).hide();
					$( ".btn-wait" ).show();
					
					$.ajax({
						type: 		"POST",
						url: 		"/ajax/ajax_code_promotion.php?task=verifier-code",
						data: 		$( "#formulaire" ).serialize(),
						error: 		function() { alert( "Une erreur s'est produite..." ); },
						success: 	function( data ){
							var obj = $.parseJSON( data );
							
							// ---- Tout va bien! ------------------------------ //
				        	if ( !obj.erreur && obj.code_erreur != 5 ) {
				        		
				        		// ---- Si aucune redirection n'est demandée --- //
				        		if ( $( "#r" ).val() == '' ) {
					        		$( "#fieldset_en_cours" ).find( ".legende" ).html( obj.contenu );
					        		$( "#fieldset_saisie" ).hide();
					        		$( "#fieldset_en_cours" ).show();
					        	}
					        	else {
					        		$( "#fieldset_saisie" ).hide();
					        		$( "#fieldset_en_cours" ).hide();
					        		$( "#waiting" ).show();
					        	}
				        		
				        		// ---- MAJ du panier -------------------------- //
				        		parent.refresh_panier();
				        		
				        		poster( form );
							}
							
							// ---- En cas de code personnel ------------------- //
							else if ( obj.code_erreur == 5 && $( "#portable" ).val() == '' ) {
								$( ".btn-wait" ).hide();
								$( "#div_portable" ).fadeIn();
								$( "#boutons-action" ).show();
							}
							
							// ---- En cas d'erreur ---------------------------- //
							else {
								$( "#div_erreur_code p" ).html( "Quelques erreurs sont présentes dans le formulaire :<br>- " + obj.message );
								$( "#" + obj.champ ).addClass( "input-error" );
								afficher_message( obj.champ, "error", obj.message );
								
								if ( obj.code_erreur == 5 ) {
									$( "#portable" ).addClass( "input-error" );
									afficher_message( "portable", "error", obj.message );
									$( "#div_portable" ).show();
								}
								
								$( "#div_erreur_code" ).show();
								
								$( "#boutons-action" ).show();
								$( ".btn-wait" ).hide();
				        	}
						}
					});
					
				}
			});
			// -------------------------------------------------- //
			
			// ---- Annuler l'utilisation d'un code promo ------- //
			$( ".annuler-code" ).click(function() {
        		$.ajax({
					type: 		"POST",
					url: 		"/ajax/ajax_code_promotion.php?task=annuler_code",
					data: 		$( "#formulaire" ).serialize(),
					error: 		function() { alert( "Une erreur s'est produite..." ); },
					success: 	function( data ){
						$( "#fieldset_en_cours" ).hide();
						$( "#fieldset_saisie" ).show();
						
		        		// ---- MAJ du panier -------------------------- //
		        		parent.refresh_panier();
					}
				});
				
				return false;
			});
			// -------------------------------------------------- //
			
			// ---- Modification d'un code promo ---------------- //
			$( ".modifier-code" ).click(function() {
        		$( "#fieldset_en_cours" ).hide();
        		$( "#fieldset_saisie" ).show();
				$( "#fieldset_en_cours" ).find( ".legende" ).html( '' );
				
        		// ---- MAJ du panier -------------------------- //
        		parent.refresh_panier();
        		
				return false;
			});
			// -------------------------------------------------- //
			
		});

	</script>
		
</html>
<? include_once( "../include_connexion/connexion_site_off.php" ); ?>