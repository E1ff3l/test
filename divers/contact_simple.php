<? include_once( "../classes/config_v2.php" ); ?>
<? include_once( "../classes/classes.php" ); ?>
<? include_once( "../include_connexion/connexion_site_on.php" ); ?>
<? include_once( "../includes/information.php" ); ?>
<?
	$debug = false;
	
	$lightbox = ( $_GET[ "lb" ] == '1' ) ? true : false;
	//echo ( $_GET[ "lb" ] == '1' ) ? "Dans LB" : "Hors LB";
	
	$tab_chiffre = array("zéro", "un", "deux", "trois", "quatre", "cinq", "six", "sept", "huit", "neuf", "dix");
	$chiffre_1 = rand( 0, 10);
	$chiffre_2 = rand( 0, 10);
	$somme = $chiffre_1 + $chiffre_2;
	
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
		
		<title>Contactez-nous</title>
		<meta name="description" content="Vous souhaites contacter l'Equipe Allo Nem ? Remplissez ce formulaire dès maintenant!">
		<meta name="robots" content="noindex,follow">
		
		<link rel="stylesheet" href="/css/style_universel.css<?=$cache?>">
		<link rel="stylesheet" href="/css/style_bis.css<?=$cache?>">
		<link rel="stylesheet" href="/css/forms.css<?=$cache?>">
		<link rel="stylesheet" href="/css/tooltipster.css<?=$cache?>">
		<link rel="stylesheet" type="text/css" href="/css/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
		
		<!-- plugins, script et CSS liées -->
		<link rel="stylesheet" href="/css/anythingslider_universel.css<?=$cache?>">
		
		<!--[if IE]>
		<link rel="stylesheet" href="/css/ie8.css<?=$cache?>">
		<![endif]-->
		
		<!-- fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Dancing+Script">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fjalla+One">
		
		<?
		// ---- Prise en compte de la CSS personnalisée s elle existe ---- //
		echo $_SESSION[ "domaine" ][ "css_personnalise" ];
		
		include_once( $_SERVER[ 'DOCUMENT_ROOT' ] . "/includes/include_outils.php" );
		?>
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
		include_once( "../includes/header_universel.php" );
		echo "		<div class='inner'>\n";
		echo "			<div id='breadcrumbs'>\n";
		echo "				<div>\n";
		echo "				  <a href='/' itemprop='url'>\n";
		echo "				    <span itemprop='title' class='crumb'>Accueil</span>\n";
		echo "				  </a> ›\n";
		echo "				</div>\n";
		echo "				<div>\n";
		echo "				    <span itemprop='title' class='crumb'>Contactez-nous</span>\n";
		echo "				</div>  \n";
		echo "			</div>\n";
		echo "		</div>\n";
		echo "		<div id='content' class='inner'>\n";
		echo "			<div id='col-unique-contenu'>\n";
	}
	?>
	
			<form id="formulaire" method="post" action="/formulaire-fin-contact-simple.html">
				<input type="hidden" name="mon_action" value="contact-simple">
				<input type="hidden" name="lb" value="<?=$_GET[ "lb" ]?>">
				<input type="hidden" name="somme" value="<?=md5( $somme )?>">
				
				<fieldset>
					<legend>
						<h2>Contactez-nous</h2>
					</legend>
					
					<div id="div-connexion">
						<p class="legende">
							Toute question ou remarque mérite une réponse. Nous nous engageons à vous répondre dans les meilleurs délais (laissez-nous une adresse mail valide).
						</p>
						
						<div class="field">
							<label class="obligatoire" for="nom"><span>Nom</span></label>
							<input type="text" name="nom" id="nom" size="26" class="tooltip-hint champ" maxlength="50" value="">
						</div>
						
						<div class="field">
							<label for="mail"><span>Votre e-mail</span></label>
							<input type="text" name="mail" id="mail" size="26" class="tooltip-hint champ" maxlength="50" value="">
						</div>
						
						<div class="field">
							<label for="sujet"><span>Sujet</span></label>
							<input type="text" name="sujet" id="sujet" size="26" class="tooltip-hint champ" maxlength="50" value="">
						</div>
						
						<div class="field">
							<p><label class="zone-text obligatoire" for="message"><span>Mon message :</span></label></p>
							<textarea name="message" id="message" class="tooltip-hint champ" cols="30" rows="5"></textarea>
						</div>
						
						<br />
						<p class="obligatoire">Lutte anti-spam :<br />Combien font (En chiffres)</p>
						<div class="field">
							<label class="obligatoire" for="captcha"><span><?=$tab_chiffre[ $chiffre_1 ]?> + <?=$tab_chiffre[ $chiffre_2 ]?></span></label>
							<input type="text" name="captcha" id="captcha" class="tooltip-hint champ" size="10" maxlength="50" value="" autocomplete="off" >
						</div>
						<p class="legende notice">* Champs obligatoires</p>
						
						<div class="processing btn-wait" style="display:none;">En cours...</div>
						<input type="submit" class="btn connexion" value="Valider">
					</div>
				</fieldset>
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
			include_once( "../includes/footer_universel.php" );
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
		
		// On cale en haut de page
		parent.$.scrollTo( 0, 0 );
		
		function afficher_message( div, classe, message ) {
			$( "#" + div ).tooltipster( 'update', "<div class='" + classe + "'>" + message + "</div>" );
		}
		
		function initialiser( champ ) {
			//alert( "init de "+ champ );
			if ( champ == '' || champ == 'nom' ) {
				$( "#nom" ).removeClass( "input-error" );
				afficher_message( "nom", "hint", "Indiquez votre nom." );
			}
			
			if ( champ == '' || champ == 'mail' ) {
				$( "#mail" ).removeClass( "input-error" );
				afficher_message( "mail", "hint", "Indiquer votre adresse mail." );
			}
			
			if ( champ == '' || champ == 'sujet' ) {
				$( "#sujet" ).removeClass( "input-error" );
				afficher_message( "sujet", "hint", "Indiquer le sujet de votre message." );
			}
			
			if ( champ == '' || champ == 'message' ) {
				$( "#message" ).removeClass( "input-error" );
				afficher_message( "message", "hint", "Expliquez-nous..." );
			}
			
			if ( champ == '' || champ == 'captcha' ) {
				$( "#captcha" ).removeClass( "input-error" );
				afficher_message( "captcha", "hint", "Indiquez la somme en chiffre ici." );
			}
		}
		
		function poster( form ) {
			$.ajax({
				type: "POST",
				url: '/ajax/ajax_divers.php?task=check_captcha',
				data: $( "#formulaire" ).serialize(),
				error: function() { alert( "Une erreur s'est produite..." ); },
				success: function( data ){
					var obj = $.parseJSON( data );
					
		        	if ( !obj.erreur ) {
		        		form.submit();
					}
					else {
						$( "#" + obj.champ ).addClass( "input-error" );
						afficher_message( obj.champ, "error", obj.message );
						
						$( ".btn" ).show();
						$( ".btn-wait" ).hide();
		        	}
				}
			});
		}
		
		// DOM Ready
		$(function(){
			
			$( ".radio" ).click(function() {
				//var check = $(this).attr( "checked" );
				//alert( check );
				
				if ( $(this).hasClass( "commande" ) ) $( "#legende_commande" ).fadeIn();
				else $( "#legende_commande" ).fadeOut();
			});
			
			// ---------- Gestion des aides textuelles ---------- //
			$( ".tooltip-hint" ).tooltipster({
			    animation: 'fade',
			    arrow: 'true',
			    position:'right'
			});
			
			// Initialisation des aides textuelles
			initialiser( '' );
			// -------------------------------------------------- //
			
			// ---------- Validation du formulaire -------------- //
			$( "#formulaire" ).validate({
				focusInvalid: false,
				onkeyup: function( element ) { 
					if( $( "#" + element[ "name" ] ).valid() ) initialiser( element[ "name" ] );
				},
				rules: {
					nom: "required",
					mail: "required",
					sujet: "required",
					message: "required",
					captcha: "required"
				},
				messages: {
		            nom: "Veuillez indiquer votre nom.",
		            mail: "Veuillez indiquer votre adresse mail",
		            sujet: "Veuillez indiquer le sujet de votre message.",
		            message: "Veuillez indiquer le but de votre message.",
		            captcha: "Veuillez indiquer la somme en chiffre ici."
		        },
				invalidHandler: function(event, validator) {
					// 'this' refers to the form
					var errors = validator.numberOfInvalids();
					//alert( "Nb erreur : " + errors );
					
					// On a des erreurs...
					if ( errors ) {
						var tab_aide = new Array( "nom", "mail", "sujet", "message", "captcha" );
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
					$( ".btn" ).hide();
					$( ".btn-wait" ).show();
					
					if ( $( "#mail" ).val() == '' && $( ".radio:checked" ).val() == 'reclamation' ) {
						$.ajax({
							type: "POST",
							url: '/ajax/ajax_divers.php?task=check_tel',
							data: $( "#formulaire" ).serialize(),
							error: function() { alert( "Une erreur s'est produite..." ); },
							success: function( data ){
								var obj = $.parseJSON( data );
								
					        	if ( !obj.erreur ) {
					        		poster( form );
								}
								else {
									$( "#" + obj.champ ).addClass( "input-error" );
									afficher_message( obj.champ, "error", obj.message );
									
									$( ".btn" ).show();
									$( ".btn-wait" ).hide();
					        	}
							}
						});
					}
					else {
						poster( form );
					}
				}
			});
			
			// -------------------------------------------------- //
			
		});

	</script>
		
</html>
<? include_once( "../include_connexion/connexion_site_off.php" ); ?>