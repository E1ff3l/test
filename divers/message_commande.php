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
		
		<title>Message lié à ma commande</title>
		<meta name="description" content="Vous souhaitez apporter une information supplémentaire à votre commande? Remplissez ce formulaire dès maintenant!">
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
		echo "				    <span itemprop='title' class='crumb'>Message lié à ma commande</span>\n";
		echo "				</div>  \n";
		echo "			</div>\n";
		echo "		</div>\n";
		echo "		<div id='content' class='inner'>\n";
		echo "			<div id='col-unique-contenu'>\n";
	}
	?>
	
			<form id="formulaire" method="post" action="#">
				<input type="hidden" name="mon_action" value="message">
				<input type="hidden" name="lb" value="<?=$_GET[ "lb" ]?>">
				
				<fieldset>
					<legend>
						<h2>Message lié à ma commande</h2>
					</legend>
					
					<div id="div-connexion">
						<p class="legende">
							<?
							if ( $_SESSION[ "site" ][ "is_a_viticulteur" ] ) echo "Vous souhaitez apporter une précision par rapport aux vins commandés ?";
							else echo "Vous souhaitez apporter une précision par rapport aux plats commandés ?";
							?>
						</p>
						<p id="p_message_succes" class="succes wait">
							Le message liè à votre commande est bien enregistré.
						</p>
						
						<div class="field">
							<p><label class="zone-text" for="message_spe"><span>Votre message :</span></label></p>
							<textarea name="message_spe" id="message_spe" class="tooltip-hint champ" cols="30" rows="5"><?=$_SESSION[ "site" ][ "message_specifique_commande" ]?></textarea>
						</div>
						
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
		
		// On cale en haut de page
		parent.$.scrollTo( 0, 0 );
		
		function afficher_message( div, classe, message ) {
			$( "#" + div ).tooltipster( 'update', "<div class='" + classe + "'>" + message + "</div>" );
		}
		
		function initialiser( champ ) {
			//alert( "init de "+ champ );
			if ( champ == '' || champ == 'message_spe' ) {
				$( "#message_spe" ).removeClass( "input-error" );
				afficher_message( "message_spe", "hint", "Vous avez une remarque particulière ?" );
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
			
			// ---------- Validation du formulaire -------------- //
			$( "#formulaire" ).validate({
				focusInvalid: false,
				onkeyup: function( element ) { 
					if( $( "#" + element[ "name" ] ).valid() ) initialiser( element[ "name" ] );
				},
				rules: {
					message_spe: "required"
				},
				messages: {
		            message_spe: "Veuillez indiquer votre remarque ici."
		        },
				invalidHandler: function(event, validator) {
					// 'this' refers to the form
					var errors = validator.numberOfInvalids();
					//alert( "Nb erreur : " + errors );
					
					// On a des erreurs...
					if ( errors ) {
						var tab_aide = new Array( "message_spe", "captcha" );
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
					$( ".btn" ).hide();
					$( ".btn-wait" ).show();
					
					//alert( "On poste..." );
					$.ajax({
						type: "POST",
						url: '/ajax/ajax_commande.php?task=set_message_spe',
						data: $( "#formulaire" ).serialize(),
						error: function() { alert( "Une erreur s'est produite..." ); },
						success: function( data ){
				        	$( "#p_message_succes" ).fadeIn();
				        	$( ".btn" ).show();
							$( ".btn-wait" ).hide();
						}
					});
					
				}
			});
			
			// -------------------------------------------------- //
			
		});

	</script>
		
</html>
<? include_once( "../include_connexion/connexion_site_off.php" ); ?>