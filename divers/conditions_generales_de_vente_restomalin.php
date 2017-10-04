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
		
		<title>Restomalin - Les conditions générales de vente</title>
		<meta name="description" content="Les CGV du site Restomalin.com" />
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
						    <span itemprop="title" class="crumb">Conditions générales de vente</span>
						</div>  
					</div>
				</div>
	
				<div id="content" class="inner">
					<div id="col-unique-contenu">
						<h1>RESTOMALIN - Les conditions générales de vente</h1>
						<br />
						
VERSION A JOUR DU 16/12/2015<br /><br />
Les conditions générales de ventes sont conclues entre :<br /><br />
- <b>le Client Internaute acheteur</b> (ci-après dénommé « <b>le Client</b> »), soit toute personne physique majeure, capable, achetant à titre professionnel ou non-professionnel,<br />
- <b>le Restaurant partenaire vendeur</b>, (ci-après dénommé « <b>le Restaurant</b> »), présent sur le site internet www.restomalin.com  (ci-après dénommé « <b>Site Internet</b> ») et dont les informations figurent sur la page vitrine du Restaurant (ci-après dénommée « <b>Vitrine</b> »).<br /><br />
- <b>la société RESTOMALIN</b> (RCS de Saverne B 527 909 758), mandataire du Restaurant (ci-après dénommé « <b>le Mandataire</b> »). Le Mandataire édite le site <a class="maxlist-more" href="https://restomalin.com">www.restomalin.com</a> et <b>agit au nom et pour le compte du Restaurant</b> qui l'a mandaté.<br />
</ul>

<br /><br />

<h2>Le service</h2><br />

Le Mandataire édite le Site Internet qui référence les restaurants partenaires proposant la livraison et/ou la vente à emporter de produits de restauration.<br /><br />
Le Site Internet permet ainsi au Client de sélectionner le Restaurant de son choix, d’y passer commande ou précommande (passée en dehors des heures d’ouverture) et de se voir confirmer la commande une fois l’accord du Restaurant obtenu. Le cas échéant, le Client aura le choix de régler le montant de sa commande,<br />
- soit à réception de la commande (auprès du livreur), selon les moyens de paiement acceptés par le Restaurant,<br />
- soit en saisissant ses coordonnées bancaires sur la plateforme de paiement sécurisé HIPAY.<br /><br />
Dans le cadre de la vente à emporter, le Client réglera le montant de sa commande au moment de venir récupérer ses plats.<br /><br />
Les moyens de paiement acceptés par le Restaurant sont indiqués sur la Vitrine du Restaurant.<br /><br />

<h2>Les produits</h2><br />

Les produits proposés sont ceux qui figurent dans les Vitrines des Restaurants, sur le Site Internet. Ces produits sont disponibles dans la limite des stocks du Restaurant.<br /><br />
En cas de rupture temporaire de stocks, le Restaurant s’engage à contacter le Client et à lui proposer un produit similaire, pouvant correspondre aux attentes du client.<br /><br />
Si toutefois le client ne souhaite pas le produit de remplacement et que le Client a effectué un paiement par carte bancaire en ligne, le Restaurant s’engage à contacter le Mandataire pour diminuer le montant de la somme à débiter à hauteur du prix du ou des produits manquants.<br /><br />
Le contenu des produits peuvent parfois être modifiés pour des raisons techniques, indépendantes de la volonté du Mandataire et à la simple initiative du Restaurant partenaire. Par conséquent, le Mandataire ne pourra être tenu pour responsable de ces éventuelles modifications. Dans ce cas précis, le Mandataire s’engage toutefois à effectuer les modifications dans les plus brefs délais.<br /><br />
Les photos de présentation des produits proposés sur le Site Internet ne sont pas contractuelles, et ne peuvent engager la responsabilité du Mandataire et/ou du Restaurant à l'égard du Client.<br /><br />
Pour des raisons d’hygiène, de par la nature des produits proposés, aucune marchandise ne sera ni reprise, ni échangée après commande. En effet, aux termes de l’article L121-20-4 du Code de la Consommation, « les dispositions des articles L. 121-20 et L. 121-20-1, relatifs au délai de rétractation, ne sont pas applicables aux contrats ayant pour objet :<br />
1° La fourniture de biens de consommation courante réalisée au lieu d'habitation ou de travail du consommateur par des distributeurs faisant des tournées fréquentes et régulières.<br />
2° La prestation de services d'hébergement, de transport, de restauration, de loisirs qui doivent être fournis à une date ou selon une périodicité déterminée ».

<br /><br />

<h2>Obligations des intervenants</h2><br />

<b><u>A. Le Restaurant</u></b><br />
Le Restaurant propose au Client, par l’intermédiaire de sa Vitrine, la fourniture de biens de consommation alimentaire (ci-après dénommés « Plats ») et une prestation de service de livraison à domicile et/ou de vente à emporter.<br /><br />
Cette proposition ne constitue pas une offre ferme et définitive, celle-ci étant émise par le Client lors de sa commande.<br /><br />
En cas d’acceptation de l’offre du Client, le Restaurant assure la préparation des Plats ainsi que la livraison au Client ou la mise à disposition des Plats dans son restaurant dans le cas d’une vente à emporter.<br /><br />
Dans le cadre d’une livraison, le Restaurant est tenu de respecter au mieux le délai de livraison indiqué au Client. En cas de retard responsable ou indépendant de sa volonté, le Restaurant s’engage à en informer le Client et son Mandataire.
Le Restaurant assure et est donc responsable à lui seul, de la bonne livraison des Plats, de la qualité de leur emballage et de l’arrivée des Plats à température convenable dans le cas de livraison de Plats chauds.<br /><br />
Le Restaurant s’engage également à communiquer au plus vite à son Mandataire, tout changement relatif aux informations figurant sur sa Vitrine.<br /><br />
Le Restaurant s’engage à pratiquer les mêmes tarifs (prix des plats et frais de livraison éventuels) que ce soit par l’intermédiaire du Mandataire ou en passant directement par son point de vente, son site internet ou tout autre support.<br /><br />

<b><u>B. Le Mandataire</u></b><br />

Le Mandataire assure, dans la limite des pouvoirs conférés par le Restaurant mandant, des prestations d’intermédiation entre le Restaurant et le Client, via son Site Internet.<br /><br />
Le Mandataire assure ainsi la diffusion des informations relatives aux Plats figurant dans les menus communiqués par le Restaurant, la prise de commandes sur le Site Internet,  leur suivi, la confirmation de commandes auprès du Client une fois l’accord du Restaurant obtenu, ainsi que, le cas échéant, les encaissements par carte bancaire sur ledit Site Internet, au nom et pour le compte du Restaurant.<br /><br />
Suite à toute demande de modification de Vitrine émanant du Restaurant partenaire, le Mandataire s’engage à modifier dans les meilleurs délais, les informations présentes dans la Vitrine.

<br /><br />

<b><u>C. Le Client</u></b><br />

Le Client, lors de son inscription, s’engage sur la justesse des informations communiquées lors de son inscription et/ou du passage de sa commande. Le Mandataire ou le Restaurant se réserve le droit d’annuler la commande en cas d’informations erronées.
Dès lors, il est vivement recommandé au client de fournir avec précision ses coordonnées exactes ainsi qu’un numéro de téléphone valide.<br /><br />
En cas de commande ou précommande, le Client s’engage à être joignable sur le numéro de téléphone indiqué durant les horaires d’ouverture du Restaurant dans lequel il a commandé.
En cas d’injoignabilité du Client, le Mandataire ou le Restaurant se réserve le droit d’annuler la commande.
De même, le Client se doit d’être présent sur le lieu de la livraison, à l’heure convenue.
En cas d’absence du Client et hors cas de force majeure, le montant de la commande restera dû. Libre au Mandataire et/ou au Restaurant de régler le litige à l’amiable, voir d’engager des poursuites judiciaires.<br /><br />
En cas de commande comportant de l’alcool, le Client s’engage à être âgé d’au moins 18 ans le jour du passage de la commande.

<br /><br />

<h2>Dispositions particulières liées aux boissons alcoolisées</h2><br />

Il est possible de commander de l’alcool via le Site Internet.<br /><br />
Conformément à l’ordonnance n°59-107 du 7 janvier 1959, et aux termes de l’article L.80 du Code des débits de boissons et des mesures contre l’alcoolisme, la vente d’alcool aux mineurs est interdite. Tout Client s’engage à avoir 18 ans révolus en passant sa commande sur le Site Internet.<br /><br />
<u>L’abus d’alcool est dangereux pour la santé. A consommer et apprécier avec modération.</u><br /><br />
En passant commande ou précommande, le Client renonce expressément au bénéfice de l’article 1587 du Code Civil qui prévoit la conclusion définitive de la vente de vin qu’après dégustation et agrément de l’acheteur.

<br /><br />

<h2>Dispositions particulières relatives à certains moyens de paiement</h2><br />
 
Lors de la livraison de la commande, dans le cas où le Client a spécifié vouloir payer par carte bancaire auprès du livreur, le Restaurant se réserve le droit de demander au Client de présenter une pièce d'identité.<br /><br />
Pour tout règlement par chèque au-delà d'un certain montant laissé à la libre appréciation du Restaurant,  une pièce d'identité pourra également être demandée.<br /><br />
Le Restaurant et/ou le Mandataire se réservent le droit de ne pas honorer une commande ou d’imposer certains types de paiement face à un Client faisant l’objet d’un impayé non résolu ou dont les moyens de paiements présentent des anomalies.

<br /><br />

<h2>Le paiement sécurisé en ligne</h2><br />

Le Mandataire a fait le choix de confier les transactions bancaires au groupe HIPAY.<br /><br />
Les transactions sont sécurisées par le système de paiement HIPAY à la norme 3DSecure.<br /><br />
Dans le processus de commande, au moment de payer, le Client est redirigé sur le site de HIPAY sur lequel il saisira ses coordonnées bancaires.<br /><br />
De ce fait, le numéro de la carte bancaire n’est jamais porté à la connaissance du Restaurant et du Mandataire et aucune donnée bancaire n’est stockée sur le serveur.

<br /><br />

<h2>Cas de force majeure</h2><br />

Le Restaurant et le Mandataire ne pourront être tenu pour responsable en cas de survenance d’un événement de force majeure tel qu’entendu par la jurisprudence habituelle des tribunaux français (événement imprévisible, irrésistible et extérieur).<br /><br />
Le Restaurant sera notamment déchargé de son obligation de livraison si celle-ci est perturbée,  empêchée, limitée en raison d’intempéries, panne matérielles, incendie, problème d’approvisionnement ou tout autre circonstance hors du contrôle raisonnable du Restaurant.
Dans ce cas, le Mandataire et/ou le Restaurant contacteront le Client pour l’en informer, et ce, dans les plus brefs délais.

<br /><br />

<h2>Les commandes, les frais de livraison  et les frais de gestion</h2><br />

Les commandes sont possibles 24h/24, 7j/7 et se font exclusivement sur le site <a href="https://restomalin.com">www.restomalin.com</a> ou tout autre support mis à disposition par le Mandataire.<br /><br />
Le montant minimum de la commande dépend du Restaurant et du quartier de livraison.<br />
Il n’y a pas de minimum de commande dans le cadre d’une vente à emporter.<br /><br />

La prestation de service est gratuite. Le Mandataire n’applique aucun frais de gestion à la différence du Restaurant qui peut parfois appliquer des frais de livraison selon la zone de livraison.

<br /><br />

<h2>Annulation de commande</h2><br />

Le Client peut annuler sa commande, sous réserve d'un appel téléphonique d’urgence auprès du Mandataire (N° vert : 0805 69 69 67) ou directement auprès du Restaurant.
Il peut aussi faire une demande de rappel téléphonique depuis le site du mandataire.<br />
Si la commande a été réglée par carte bancaire sur le site du mandataire, la transaction bancaire sera annulée et le client en sera avisé par téléphone.

<br /><br />

<h2>Loi informatique et liberté</h2><br />

Les informations qui sont demandées au Client sont nécessaires au traitement de la commande.<br /><br />
Le Mandataire,  sensible au respect de la vie privée s’engage à ne jamais céder son fichier client à des tiers.<br />
Le Client peut toutefois être amené à recevoir des offres de Restomalin par courrier électronique.<br /><br />
Conformément à la loi informatique et liberté 78-17 du 06/01/78, le Client dispose d'un droit d’accès et de rectification pour les données nominatives le concernant.<br /><br />
Si le client ne souhaite plus rien recevoir de la part de RESTOMALIN, il peut cliquer sur le lien de désabonnement présent sur tous les courriels.<br />
Il peut aussi se rendre sur cette page : <a href="https://restomalin.com/pub/desinscription.php" target="_new">www.restomalin.com/pub/desinscription.php</a> et y saisir son adresse mail.<br />
Le traitement est immédiat.

<br /><br />

<h2>Application et modification des CGV</h2><br />

Les présentes CGV s'appliqueront pendant toute la durée de mise en ligne des services proposés par le Mandataire, sous réserve des modifications ultérieures.<br />
Les CGV applicables sont celle en vigueur le jour de la Commande.<br />
Le Mandataire se réserve le droit de modifier à tout moment les présentes CGV.<br />
Il est recommandé de les consulter régulièrement.

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