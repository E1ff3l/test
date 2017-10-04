<? include_once( "../classes/config_v2.php" ); ?>
<? include_once( "../classes/classes.php" ); ?>
<? include_once( "../include_connexion/connexion_site_on.php" ); ?>
<?
	$debug = true;
	$_SESSION[ "site" ][ "affichage_pourquoi" ] = true;
	
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
		<meta name="robots" content="index,nofollow" />
		
		<title>Restomalin - Demande de rappel</title>
		
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
				<fieldset>
					<legend>
						<h2>Mais pourquoi?</h2>
					</legend>
					
					<p class="legende" style="margin-bottom:20px;">
					  Attention, vous êtes sur la liste des restaurants d'un quartier qui est différent de celui indiqué dans votre profil.<br /><br />
					  Ce restaurant ne livre peut être pas sur votre secteur.<br /><br />
					  Et si il y livre, les minimums de commande et les éventuels frais de livraison peuvent être différents.<br /><br />
					  Si vous souhaitez vous faire livrer ailleurs que sur votre lieu habituel,<br />déconnectez-vous (cliquez sur **Déconnexion** en haut à droite) et passez une <b>commande express</b> en indiquant l'adresse de votre choix.<br /><br />
					  Si vous souhaitez vous faire livrer à votre adresse habituelle,<br />cliquez sur **Mes restaurants** pour n'avoir que les restos qui vous concernent.
					</p>
					
					<input type="button" class="btn" value="Fermer">
				</fieldset>
			</form>
		</div>
	</body>
	
	<!-- Jquery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js<?=$cache?>"></script>
	<script>window.jQuery || document.write('<script src="/js/jquery.min.js<?=$cache?>"><\/script>')</script>
	
 	<!-- plugins, script et CSS liées -->
	<script src="/js/jquery.tooltipster.js<?=$cache?>"></script>
	
	<script src="/lib/jquery-validation/jquery.validate.js<?=$cache?>" type="text/javascript"></script>
	<script src="/lib/jquery-validation/messages_fr.js<?=$cache?>" type="text/javascript"></script>
	
	<script>
		
		// DOM Ready
		$(function(){
			
			// Fermeture de la FancyBox
			$( ".btn" ).click(function() {
				//alert( "click..." );
				parent.$.fancybox.close();
			});
		});

	</script>
		
</html>
<? include_once( "../include_connexion/connexion_site_off.php" ); ?>