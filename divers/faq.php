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
		
		<title>Questions fréquentes posées à Restomalin</title>
		<meta name="description" content="Foire aux questions le plus souvent posées à notre Service Assistance." />
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
						    <span itemprop="title" class="crumb">Foire aux questions</span>
						</div>  
					</div>
				</div>
	
				<div id="content" class="inner">
					<div id="col-unique-contenu">
						<h1>RESTOMALIN - Foire aux questions</h1>
						<br /><br />
						
						<div id="1" class="depliable">
							<h2>1. Comment faire pour passer une commande ?</h3>
							<div id="contenu_1" class="wait">
								<br />
								<p>
									Depuis la page d'accueil de Restomalin,<br />
									saisissez votre code postal ou directement le nom de votre quartier/commune dans la zone prévue à cet effet :<br /><br />
									
									<table>
									<tr>
										<td><img src="../img/zone_saisie.jpg" width="259" height="170"></td>
										<td width="10">&nbsp;</td>
										<td valign="top" align="left">
											Au fur et à mesure de votre saisie, la liste des quartiers qui vous est proposée se restreint. Lorsque vous avez trouvé votre quartier dans la liste, vous pouvez cliquer dessus ou vous aider des flèches haut / bas de votre clavier puis validez votre choix avec la touche Entrée.<br /><br />
											Par défaut, la recherche de restaurant <b>en livraison</b> est activée.<br />
											Si vous préférez aller récupérer votre commande directement auprès du restaurant, changez le curseur sur <b>à emporter</b>.<br /><br />
											Cette 1ére étape est très importante, assurez-vous d'indiquer la bonne zone de livraison, 
											ainsi vous serez certain(e) de n'avoir que les restaurants qui livrent sur votre secteur mais également les bons minimums de commande.<br /><br />
											Si le quartier que vous avez indiqué ne correspond pas à la réalité, le restaurant risque de refuser votre commande.<br /><br />
										</td>
									</tr>
									</table>
									
									Une fois le code postal/quartier indiqué, vous êtes redirigé vers la liste des restaurants.<br />
									Si vous avez une idée précise de ce que vous souhaitez manger, filtrez par spécialité (chinois, oriental, italien...)<br /><br />
									Choisissez le restaurant de votre choix puis remplissez votre panier.<br /><br />
									
									<table>
									<tr>
										<td valign="center" align="left" width="200">
											Attention,<br /><br />Le bouton <b>Valider ma commande</b><br /><br />n'apparaitra que<br /><br />lorsque le minimum de commande sera atteint.
										</td>
										<td width="10">&nbsp;</td>
										<td><img src="../img/minimum_de_commande.jpg" width="215" height="242"></td>
									</tr>
									</table>
									
									Une fois le minimum de commande atteint, validez votre commande et laissez vous guider.
								</p>
							</div>
						</div>
						
						<div id="2" class="depliable">
							<h2 class="depliable">2. Quels sont les moyens de paiement acceptés ?</h3>
							<div id="contenu_2" class="wait">
								<br />
								<p>
									Les moyens de paiement acceptés sont propre à chaque restaurant.<br /><br />
									
									<table>
									<tr>
										<td><img src="../img/moyens_de_paiement.jpg" width="305" height="242"></td>
										<td width="10">&nbsp;</td>
										<td valign="center" align="left">
											Depuis la liste des restaurants,<br /><br />
											survolez la zone entourée en rouge<br /><br />
											pour en voir le détail.
										</td>
									</tr>
									</table>
									<br />
									Et si vous êtes dans la vitrine du restaurant, retrouvez ces informations dans l'onglet <b>INFOS PRATIQUES</b>.
								</p>
							</div>
						</div>

						<div id="3" class="depliable">
							<h2 class="depliable">3. Est-ce que je peux passer une commande en dehors des heures d'ouverture des restaurants ?</h3>
							<div id="contenu_3" class="wait">
								<br />
								<p>
									Oui, il est possible de précommander. Votre commande sera alors validée à la prochaine prise de service du restaurant.
								</p>
							</div>
						</div>

						<div id="4" class="depliable">
							<h2 class="depliable">4. Est-ce que je peux passer une commande dans plusieurs restaurants ?</h3>
							<div id="contenu_4" class="wait">
								<br />
								<p>
									Non, si vous souhaitez passer commande auprès de 2 restaurants différents, il vous faudra passer 2 commandes distinctes.
								</p>
							</div>
						</div>
						
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