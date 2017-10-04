<? include_once( "../classes/config_v2.php" ); ?>
<? include_once( "../classes/classes.php" ); ?>
<? include_once( "../include_connexion/connexion_site_on.php" ); ?>
<? include_once( "../includes/information.php" ); ?>
<?
	$debug = 		false;
	$domaine =		new domaine();
	$restaurant =	new restaurant();
	
	// ----------- Traitement des informations AVANT affichage ---------- //
	if ( 1 == 1 ) {
		
		// ---------- A PROPOS DU DOMAINE... ---------------------------- //
		$domaine->load( $_SESSION[ "domaine" ][ "num_domaine" ] );
		
		// ---------- A PROPOS DU RESTAURANT... ------------------------- //
		$restaurant->load( $_SESSION[ "restaurant" ][ "num_restaurant" ] );
		$nom_resto = utf8_encode( $restaurant->nom );
	}
	// ------------------------------------------------------------------ //
			
	// -------------------- Gestion de la mise en cache ----------------- //
	$cache = ( MISE_EN_CACHE ) ? "" : "?" . time();
	//echo $cache . "<br>";
	// ------------------------------------------------------------------ //
	
	//print_pre( $_SESSION );
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Cache-Control" content="no-cache" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="0" /> 
		
		<title><?=$nom_resto?> - Les mentions légales</title>
		<meta name="description" content="Les mentions légales de <?=$nom_resto?>" />
		<meta name="robots" content="index,follow" />
		
		<link rel="icon" type="image/gif" href="/img/favicon-RM.gif" >
		
		<link rel="stylesheet" href="/css/style_universel.css<?=$cache?>">
		<link rel="stylesheet" href="/css/style_bis.css<?=$cache?>">
		<link rel="stylesheet" href="/css/forms.css<?=$cache?>">
		<link rel="stylesheet" href="/css/tooltipster.css<?=$cache?>">
		<link rel="stylesheet" type="text/css" href="/css/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
		
		<!-- plugins, script et CSS liées -->
		<link rel="stylesheet" href="/css/anythingslider_universel.css<?=$cache?>">
		
		
		<!--[if IE]>
		<link rel="stylesheet" href="/css/ie8.css">
		<![endif]-->
		
		<!-- fontes -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Dancing+Script">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fjalla+One">
		
		<?
		// ---- Prise en compte de la CSS personnalisée s elle existe ---- //
		echo $_SESSION[ "domaine" ][ "css_personnalise" ];
		
		include_once( $_SERVER[ 'DOCUMENT_ROOT' ] . "/includes/include_outils.php" );
		?>
		
	</head>
	
	<body>
		
		<div id="container">
			
			<div id="liens-utiles">
				<? include_once( "../includes/menu_connexion.php" ); ?>
			</div>
			
			<div id="page">
				
				<? include_once( "../includes/header_universel.php" ); ?>
	
				<div class="inner">
					<div id="breadcrumbs">
						<div>
						  <a href="/" itemprop="url">
						    <span itemprop="title" class="crumb">Accueil</span>
						  </a> ›
						</div>  
						<div>
						    <span itemprop="title" class="crumb">Mentions légales</span>
						</div>  
					</div>
				</div>
	
				<div id="content" class="inner">
					<div id="col-unique-contenu">
						<h1><?=$nom_resto?> - Les mentions légales</h1>
						<br />
					
					<?
					// ---- Mentions légales de la vitrine ------------------ //
					if ( $domaine->mention_legale_active ) {
						?>
					    <fieldset>
						   <legend>
							  <h1>Restaurant</h1>
						   </legend>
						
						   <div id="div-connexion">
							  <p class="legende" style="margin-bottom:20px;">
							  <b><?=$nom_resto?></b><br />
							  <?=nl2br( $domaine->mention_legale_texte )?>
							  </p>
						   </div>
					    </fieldset>
					    <?
					}
					?>
					
					<!-- Editeur -->	
				    <fieldset>
					   <legend>
						  <h1>Editeur</h1>
					   </legend>
					
					   <div id="div-connexion">
						  <p class="legende" style="margin-bottom:20px;">
						  <b><a href="https://restomalin.com" target="_blank" title="Spécialiste de la livraison de repas à domicile">Restomalin</a></b><br />
						  17 rue de l'école<br />
						  67520 Kirchheim<br /><br />
						  
						  Siret : 527 909 758 00015<br />
						  Forme juridique : SARL au capital de 4000€<br /><br />
						  						  
						  <!--Directeur de la publication : Olivier FREYMANN<br /><br />-->
						  
						  Adresse email de contact : contact@restomalin.com<br />
						  Numéro de téléphone : 09 72 377 666 (numéro non surtaxé)		
						  </p>
						  
						  
						  <p class="maxlist-more"><a href="./contacter_universel.php?lb=1" class="go_up iframe_mon_compte">Nous contacter par formulaire</a></p>
						
					   </div>
				    </fieldset>
					
					<!-- Hébergeur -->
					<fieldset>
						<legend>
							<h1>Hébergeur</h1>
						</legend>
						
						<div id="div-connexion">
							<p class="legende" style="margin-bottom:20px;">
								<b>OVH</b><br />
								2 rue Kellermann<br />
								59100 Roubaix - France
							</p>
						</div>
					</fieldset>
					
					<?
					// ---- Méthodes de linking (Si pas de mentions légales actives)
					if ( !$domaine->mention_legale_active && $domaine->methode_linking != '0' ) {
						
						// ---- Méthode nº4 : Page « mentions légales », partie « concepteur du site »
						if ( $domaine->methode_linking == '100' || $domaine->methode_linking == '4' ) {
							?>
							<fieldset>
								<legend>
									<h1>Concepteur</h1>
								</legend>
								
								<div id="div-connexion">
									<p class="legende" style="margin-bottom:20px;">
										<b><a href="https://restomalin.com" target="_blank" title="Livraison de repas a domicile">Restomalin</a></b><br />
										17 rue de l'école<br />
										67520 Kirchheim - France
									</p>
								</div>
							</fieldset>
							<?
						}
					}
					?>
						
					<div class="double">				
						<input type="button" class="btn-retour" value="Retour">		
					</div>
						
					</div>
					<span class="clearfix">&nbsp;</span>
				</div>
				
				<? include_once( "../includes/footer_universel.php" ); ?>
				
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