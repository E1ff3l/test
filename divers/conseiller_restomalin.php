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
	
	if ( $_SESSION[ "franchise" ][ "is_franchise" ] ) $qui = $_SESSION[ "site" ][ "signature" ];
	else $qui = "Restomalin";
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Cache-Control" content="no-cache">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Expires" content="0"> 
		
		<title><?=$qui;?> - Conseiller <?=$qui;?> à un ami</title>
		<meta name="description" content="Vous souhaites nous contacter? Remplissez ce formulaire dès maintenant!">
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
		echo "				    <span itemprop='title' class='crumb'>Conseiller " . $qui . " à un ami</span>\n";
		echo "				</div>  \n";
		echo "			</div>\n";
		echo "		</div>\n";
		echo "		<div id='content' class='inner'>\n";
		echo "			<div id='col-unique-contenu'>\n";
	}
	?>
	
			<form id="formulaire" method="post" action="./formulaire-fin-conseiller-a-un-ami.html">
				<input type="hidden" name="mon_action" value="conseiller">
				<input type="hidden" name="lb" value="<?=$_GET[ "lb" ]?>">
				<input type="hidden" name="somme" value="<?=md5( $somme )?>">
				
				<fieldset>
					<legend>
						<h2>Conseiller <?=$qui;?> à un ami</h2>
					</legend>
					
					<div id="div-connexion">
						<p class="legende">
							En remplissant ce formulaire, votre ami(e) recevra un email avec un lien vers notre site.
							Merci d'avoir eu la bonne idée de suggérer <?=$qui;?> à votre ami(e).
						</p>
						<div class="field">
							<label class="obligatoire" for="nom"><span>Votre nom</span></label>
							<input type="text" name="nom" id="nom" size="26" class="tooltip-hint champ" maxlength="20" value="">
						</div>
						<div class="field">
							<label class="obligatoire" for="mail"><span>Son e-mail</span></label>
							<input type="text" name="mail" id="mail" size="26" class="tooltip-hint champ" maxlength="50" value="">
						</div>
						
						<br />
						<p class="obligatoire">Lutte anti-spam :<br />Combien font (En chiffres)</p>
						<div class="field">
							<label class="obligatoire" for="tel2"><span><?=$tab_chiffre[ $chiffre_1 ]?> + <?=$tab_chiffre[ $chiffre_2 ]?></span></label>
							<input type="text" name="captcha" id="captcha" class="tooltip-hint champ" size="10" maxlength="50" value="" autocomplete="off" >
						</div>
						<p class="legende notice">* Champs obligatoires</p>
						<p class="legende notice">** <?=$qui;?> s'engage à ne pas conserver les données</p>
						
						<div class="processing btn-wait" style="display:none;">En cours...</div>
						<input type="submit" class="btn connexion" value="Envoyer">
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
				afficher_message( "mail", "hint", "Indiquez ici l'adresse mail de votre ami(e)." );
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
					mail: {
						required: true,
						email: true
					},
					captcha: "required"
				},
				messages: {
		            nom: "Veuillez indiquer votre nom.",
		            captcha: "Veuillez indiquer la somme en chiffre ici."
		        },
				invalidHandler: function(event, validator) {
					// 'this' refers to the form
					var errors = validator.numberOfInvalids();
					//alert( "Nb erreur : " + errors );
					
					// On a des erreurs...
					if ( errors ) {
						var tab_aide = new Array( "nom", "mail", "captcha" );
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
					poster( form );
				}
			});
			
			// -------------------------------------------------- //
			
		});

	</script>
		
</html>
<? include_once( "../include_connexion/connexion_site_off.php" ); ?>