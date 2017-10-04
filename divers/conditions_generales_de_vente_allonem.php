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
		
		<title><?=$_SESSION[ "franchise" ][ "signature" ]?> - Les conditions générales de vente</title>
		<meta name="description" content="Les CGV du site <?=$_SESSION[ "franchise" ][ "site_web_texte" ];?>" />
		<meta name="robots" content="index,follow" />
		
		<link rel="icon" type="image/gif" href="/img/favicon-RM.gif" >
		
		<link rel="stylesheet" href="/css/style_allonem.css<?=$cache?>">
		<link rel="stylesheet" href="/css/style_bis.css<?=$cache?>">
		<link rel="stylesheet" href="/css/forms.css<?=$cache?>">
		<link rel="stylesheet" href="/css/tooltipster.css<?=$cache?>">
		<link rel="stylesheet" type="text/css" href="/css/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
		
		<!-- plugins, script et CSS liées -->
		<link rel="stylesheet" href="/css/anythingslider_allonem.css<?=$cache?>">
		
		
		<!--[if IE]>
		<link rel="stylesheet" href="/css/ie8.css">
		<![endif]-->
		
		<!-- fontes -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Dancing+Script">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fjalla+One">
		
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
						    <span itemprop="title" class="crumb">Conditions générales de vente</span>
						</div>  
					</div>
				</div>
	
				<div id="content" class="inner">
					<div id="col-unique-contenu">
						<h1>AlloNem - Les conditions générales de vente</h1>
						<br />
						
VERSION A JOUR DU 21/07/2014<br /><br />
<h2>Champ d'application et objet</h2><br />
Le site <?=$_SESSION[ "franchise" ][ "site_web_texte" ];?> a été mise en place par la société ALLO NEM FRANCE, Société à responsabilité en cours de formation.<br /><br />
<!--identifiée au Registre du Commerce et des Sociétés de Marseille sous le numéro XXX XXX XXX.<br /><br />-->
Toute prise de commande au titre d'un produit figurant au sein de la boutique en ligne du site web <?=$_SESSION[ "franchise" ][ "site_web_texte" ];?>,
implique l’acceptation préalable des présentes conditions générales.<br /><br />
En conséquence, le consommateur reconnaît être parfaitement informé du fait que son accord concernant le contenu des présentes conditions générales ne nécessite pas une signature manuscrite, dans la mesure où le client souhaite commander en ligne les produits présentés sur le site web.
<br /><br />

<h2>Les restaurants ALLO NEM et leurs zones de livraison</h2><br />
Le Client commandant via le Site Internet ALLO NEM et qui souhaite être livré doit fournir une adresse de livraison valide située dans la zone de livraison de l'un des restaurants du réseau ALLO NEM. 
De même, le client est tenu de fournir un numéro de téléphone fixe ou mobile valide et sur lequel il sera joignable jusqu'au moment de la livraison.<br /><br />
A ce jour, seules certaines zones géographiques sont desservies.
La liste actualisée des restaurants ALLO NEM et des villes desservies par ALLO NEM est disponible sur le Site Internet ALLO NEM.<br />
Si l’adresse indiquée n’est pas desservie, le Client en est informé avant la commande.
<br /><br />

<h2>Inscription</h2><br />
La prise de commande via le Site Internet ALLO NEM n'impose pas d'inscription préalable.<br />
Pour s’inscrire, le Client doit cliquer sur l’onglet « Créer un compte » situé en haut à droite de l’écran.<br />Il remplit alors le formulaire d’inscription.<br />
Lors de l’inscription sur le Site Internet ALLO NEM, le Client choisit un identifiant associé à une adresse de courrier électronique valide et un mot de passe.<br />
Il s’engage à garder ces informations strictement confidentielles et à ne pas les communiquer à des tiers, afin d'éviter autant que possible tout risque d'intrusion dans son compte client.<br />
ALLO NEM ne pourra être tenu responsable d’aucune utilisation non autorisée du compte client par un tiers qui aurait eu accès à l’identifiant et au mot de passe correspondant, sans faute de la part de ALLO NEM, et notamment si l’identifiant et le mot de passe ont été communiqués à un tiers par le Client ou en raison de sa négligence.<br />
Une fois l’inscription effectuée, un e-mail récapitulatif  sera envoyé au Client à l'adresse de courrier électronique renseignée.<br />
L'adresse de livraison indiquée par le Client doit être aussi précise que possible (numéro de bâtiment, d'étage, digicode, etc...),
afin de permettre au livreur ALLO NEM d’apporter la commande dans les meilleures conditions et les meilleurs délais.<br />
ALLO NEM ne pourra être tenu responsable en cas d'impossibilité de livraison due à des renseignements erronés ou incomplets.<br />
Suite à son inscription, le Client sera dirigé automatiquement vers le point de vente le concernant.<br />
Il disposera de la faculté de consulter la carte ALLO NEM et de choisir les plats et les menus de son choix.<br />
<br /><br /> 

<h2>Connexion au Site Internet ALLO NEM</h2><br />
Avant chaque prise de commande ou après avoir validé son panier,
le Client se connecte à l'espace client du Site Internet ALLO NEM en cliquant sur les liens  « Se connecter » ou « S'identifier ».<br />
En cas de perte ou d'oubli du mot de passe, le Client a la possibilité de récupérer ce dernier en cliquant sur le lien  « Mot de passe oublié ? » et en saisissant son adresse électronique.<br />
Le Client recevra alors un e-mail à l'adresse électronique indiquée, si elle est reconnue, lui rappelant ses paramètres de connexion.
<br /><br />

<h2>Processus de passation de commande en ligne</h2><br />
Une fois le point de vente choisi, le client pourra composer son repas en sélectionnant les plats mis à sa disposition.<br />
Le détail des produits, leurs prix et le montant total du panier sont en permanence affichés en haut à droite de la page.<br />
Une fois le repas composé, le Client pourra finaliser son panier en cliquant sur « VALIDER MA COMMANDE ».<br />
Le client sera averti si le minimum de commande n'est pas atteint.<br />
Le Client indiquera ensuite à quel moment il souhaite recevoir sa commande en cliquant sur « Dès que possible », « Idéalement à » ou « Surtout pas avant ».<br />
Dans les trois cas, le Client renseigne alors le créneau horaire dans lequel il souhaite être livré.<br />
Le Client devra ensuite choisir parmi les moyens de paiement acceptés par le point de vente dont il dépend.<br />
Il pourra notamment payer en ligne ou à la livraison.<br /><br />
Le Client choisira ensuite de s'identifier si il a au préalable créer un compte ALLO NEM, créer un compte ou passer une commande express.<br />
Les données personnelles fournies lors d'une commande express ne seront pas conservées par le site ALLO NEM et le Client sera obligé de ressaisir à nouveau ses coordonnées lors des commandes ultérieures.<br /><br />
La page "Récapitulatif de la commande" reprend et affiche à la vue du Client l'ensemble des informations liées à sa commande.<br />
Le Client devra valider cette page pour rendre effective la commande.<br /><br />
Si le Client a renseigné une adresse email valide, il recevra un premier email de confirmation. <br />
De même, si le client a renseigné un numéro de téléphone portable valide, il recevra ce même message de confirmation par SMS.<br />
un second message sera envoyé au client lorsque le point de vente ALLO NEM aura confirmé l'heure de livraison.
<br /><br />

<h2>Indisponibilité des Produits</h2><br />

Les Produits affichés sur la carte ALLO NEM le sont sous réserve des stocks disponibles dans le point de vente ALLO NEM où a été passé la commande.<br /><br />
En cas d'épuisement des stocks, le restaurant ALLO NEM concerné préviendra le Client par téléphone au numéro indiqué par le Client pour lui proposer soit d'opter pour un autre Produit,
soit déduire du montant de la facture le prix du Produit indisponible et procéder au remboursement du Produit manquant.
<br /><br />


<h2>Livraison</h2><br />
La livraison de la commande interviendra à l’adresse de livraison indiquée par le Client lors de la commande.<br />
Toutes les livraisons sont effectuées dans les délais indiqués lors de la commande.<br />
Le Client accepte la livraison des Produits selon le délai et le lieu de livraison convenus.<br />
Les dépassements de délais de livraison ne peuvent donner lieu à dédommagement.<br />
Si le Client n’est pas présent pour réceptionner la livraison des Produits commandés à l’adresse indiquée lors de la commande celle-ci sera remportée et ALLO NEM ne remboursera pas le prix de la commande et facturera au Client la totalité de la somme.

<br />
						
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
			
			// On cale en haut de page
			parent.$.scrollTo( 0, 0 );
			
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