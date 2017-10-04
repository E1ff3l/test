<? include_once( "../classes/config_v2.php" ); ?>
<? include_once( "../classes/classes.php" ); ?>
<? include_once( "../include_connexion/connexion_site_on.php" ); ?>
<? include_once( "../includes/information.php" ); ?>
<?
	$debug = true;
	
	// -------------------- Gestion de la mise en cache ----------------- //
	$cache = ( MISE_EN_CACHE ) ? "" : "?" . time();
	//echo $cache . "<br>";
	// ------------------------------------------------------------------ //
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="0" /> 
		
		<title>Restomalin - Nos engagements</title>
		<meta name="description" content="Un service client à votre écoute, un grand choix de restaurants, pas de surcoûts, une livraison rapide et des plats livrés chauds." />
		<meta name="robots" content="index,follow" />
		
		<link rel="icon" type="image/gif" href="/img/favicon-RM.gif" >
		
		<link rel="stylesheet" href="/css/style.css<?=$cache?>">
		<link rel="stylesheet" href="/css/style_bis.css<?=$cache?>">
		<link rel="stylesheet" href="/css/forms.css<?=$cache?>">
		<link rel="stylesheet" href="/css/tooltipster.css<?=$cache?>">
		<link rel="stylesheet" type="text/css" href="/css/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
		
		<!-- plugins, script et CSS liées -->
		<link rel="stylesheet" href="/css/anythingslider.css<?=$cache?>">
		
		<!--[if IE]>
		<link rel="stylesheet" href="/css/ie8.css">
		<![endif]-->
		
		<!-- fontes -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Dancing+Script">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fjalla+One">
		
		<? include_once( $_SERVER[ 'DOCUMENT_ROOT' ] . "/includes/include_outils.php" ); ?>
		
	</head>
	
	<body>
		
		<div id="container">
			
			<div id="liens-utiles">
				<? include_once( "../includes/menu_connexion.php" ); ?>
			</div>
			
			<div id="page">
				
				<? include_once( "../includes/header.php" ); ?>
	
				<div class="inner">
					<div id="breadcrumbs">
						<div>
						  <a href="/" itemprop="url">
						    <span itemprop="title" class="crumb">Accueil</span>
						  </a> ›
						</div>  
						<div>
						    <span itemprop="title" class="crumb">Nos engagements</span>
						</div>  
					</div>
				</div>
	
				<div id="content" class="inner">
					<div id="col-unique-contenu">
						<h1>RESTOMALIN - Nos engagements</h1>
						<br />
						
Restomalin accorde la plus grande importance à la qualité de ses services. Votre satisfaction et votre fidélité sont pour nous une récompense et restent une priorité au quotidien.

<h2>1- Un service client à votre écoute</h2><br />
Restomalin est très sensible à vos éventuelles suggestions ou réclamations. Pour entrer en contact avec nous, plusieurs possibilités s'offrent à vous :<br />
- Vous pouvez utiliser <a href="/divers/contacter.php?lb=1" class="go_up iframe_creation" title="Comment contacter Restomalin ?">notre formulaire de contact.</a><br />
- Vous pouvez <a href="/divers/demande_rappel.php?lb=1" class="go_up iframe_mon_compte">demander à ce qu'on vous rappelle par téléphone</a> (permanence de 11h30 à 14h00 et de 18h00 à 22h30).<br /><br />

Une enquête satisfaction vous est envoyée <b>(1)</b> 48h après chacune de vos commandes.<br />
Quel que soit le moyen que vous avez choisi pour nous contacter, nous nous engageons à vous répondre dans les plus brefs délais.<br /><br />

<h2>2- Un grand choix de restaurants</h2><br />

Restomalin veille à vous proposer le plus vaste choix de spécialités culinaires sur chaque ville.<br />
Si toutefois, vous constatiez un manque, un restaurant dans lequel vous avez l’habitude de commander et qui ne figure pas sur notre site, n’hésitez pas à nous en faire <a href="/divers/contacter.php?lb=1" class="go_up iframe_creation" title="Suggérer-nous un resto">la suggestion.</a><br /><br />

<h2>3- Pas de surcoûts</h2><br />

Le fait de commander sur le site Restomalin n’engendre aucun surcoût.<br />
Les prix des produits indiqués pour les différents restaurants sont identiques aux prix pratiqués dans le cas où vous feriez la démarche directement auprès du restaurateur.<br /><br />

<h2>4- Une livraison rapide</h2><br />

Sitôt votre commande passée, Restomalin la transmet au restaurant. Vous serez livré entre 30 et 45 minutes <b>(2)</b>.<br /><br />

<h2>5- Des plats livrés chauds</h2><br />

Nos restaurateurs-partenaires s’engagent à livrer des plats chauds. Ils ont en général des caisses isotherme pour conserver la chaleur.<br /><br />

<h2>6- Responsabilité</h2><br />

Restomalin dégage toute responsabilité quant à l'usage ou au contenu des produits commandés sur son site.<br />
Nous ne sommes qu’un intermédiaire entre vous et les restaurateurs.<br />
Nous sommes par contre réactif fasse à une éventuelle insatisfaction de votre part, voir à un niveau d’insatisfaction général relevé auprès d’un de nos restaurateurs partenaire.<br />
Dans ce cas précis, Restomalin s’engage à retirer le restaurant mis en cause.<br /><br />

<b>(1):</b> dans le cas où vous nous avez communiqué une adresse email lors de votre commande.<br />
<b>(2):</b> Temps moyen constaté mais qui varie selon le facteur climatique, d’éventuels incidents lors de la livraison ou encore le niveau de saturation des restaurants partenaires.


            <br /><br />
						
						<div class="double">				
							<input type="button" class="btn-retour" value="Retour">		
						</div>
						
					</div>
					<span class="clearfix">&nbsp;</span>
				</div>
				
				<? include_once( "../includes/footer.php" ); ?>
				
			</div>
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
	
	<script>
		// DOM Ready
		$(function(){
			
			// Clic sur une question
			$( ".depliable" ).click(function() {
				var val = $(this).attr( "id" );
				if ( $( "#contenu_" + val ).css( "display" ) == 'none' ) $( "#contenu_" + val ).fadeIn( 'fast' );
				else $( "#contenu_" + val ).fadeOut( 'fast' );
			});
			
			// Clic sur le bouton de retour
			$( ".btn-retour" ).click(function() {
				history.back(1);
			});
	
		});
	</script>
	
</html>