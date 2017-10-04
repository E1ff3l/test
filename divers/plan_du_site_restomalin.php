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
		
		<title>Restomalin - Plan du site</title>
		<meta name="description" content="Plan du site Restomalin.com" />
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
						    <span itemprop="title" class="crumb">Plan du site</span>
						</div>  
					</div>
				</div>
	
				<div id="sitemap" class="inner">
					<div id="col-unique-contenu">
						<p class="h1">RESTOMALIN - Plan du site</p>
						<br /><br />
						
						<h1>Pour bien commander vos repas à livrer ou à emporter</h1>
						<p style="text-align:justify;">
							Voici le plan du site, surtout orienté pour aider celles et ceux qui ne parviennent pas à s'en sortir avec la page d'accueil et la saisie du code postal ou de la commune.<br /><br />
							Les rubriques classiques (mentions légales, conditions générales de ventes et formulaire de contact) se trouvent au bas de chaque page, y compris celle-ci.<br /><br />
							Vous êtes pressés de commander et voulez des explications rapides ? Laissez votre numéro de téléphone et on vous rappelle : <a href="/divers/demande_rappel.php?lb=1" class="go_up iframe_mon_compte">Besoin d'aide</a><br />
							Pour les plus patients, il y a notre dossier <a href="/divers/faq.php">Foire aux Questions</a> qui s'etoffe de semaine en semaine et qui est là pour vous aider à comprendre comment notre site fonctionne.
						</p>
						<br /><br />
						
						<h2>Service de livraison à domicile</h2>
						<p style="text-align:justify;">
							Nos restaurants partenaires assurent la livraison de repas à votre domicile ou au bureau.<br />
							Ils sont tous équipés de caissons isothermes pour conserver les plats au chaud.<br />
						</p>
						<br />
						
						<h3>Accès par région :</h3>
						<p style="text-align:justify;">
							<?
							$ville_temp = new ville();
							foreach( $__liste_region as $_region ) {
								$nom_region = utf8_encode( $_region->nom );
								
								// Recherche de la 1iere ville
								unset( $recherche );
								$recherche[ "requete_directe" ] = " WHERE id_region = " . $_region->id;
								$recherche[ "requete_directe" ] .= " AND priorite = 1";
								$recherche[ "requete_directe" ] .= " AND actif = 1";
								$recherche[ "requete_directe" ] .= " ORDER BY nom";
								$tab = $ville_temp->getListe( $recherche, false );
								$_num_ville = $tab[ 0 ]->id;
								
								$lien = "/" . tranformer_url( $_region->nom ) . "/livraison/restaurants/" . $_region->id . "/" . $_num_ville . "/page.htm";
								SWITCH ( $nom_region ) {
									CASE "Alsace" : $title = "Alsaciens, Alsaciennes (Bas-Rhin et Haut-Rhin)"; break;
									CASE "Aquitaine" : $title = "Aquitains, Aquitaines (en Gironde uniquement)"; break;
									CASE "Auvergne" : $title = "Auvergnats et Auvergnates (Puy de Dôme uniquement)"; break;
									CASE "Bourgogne" : $title = "Bourguignons et les Bourguignonnes (Côte d Or uniquement)"; break;
									CASE "Bretagne" : $title = "Bretons et les Bretonnes (Ille et Vilaine uniquement)"; break;
									CASE "Centre" : $title = "Centrais et les Centraises (Loiret et Indre-et-Loire)"; break;
									CASE "Champagne-Ardenne" : $title = "Champardennais et les Champardennaises (Ardennes et Marne uniquement)"; break;
									CASE "Corse" : $title = "Corses (Corse-du-sud 2A uniquement)"; break;
									CASE "Haute-Normandie" : $title = "Hauts-Normands et Hauts-Normandes (Seine-Maritime uniquement)"; break;
									CASE "Languedoc-Roussillon" : $title = "Languedociens et Languedociennes (Hérault et Pyrénées Orientales uniquement)"; break;
									CASE "Limousin" : $title = "Limousins et les Limousines (Haute Vienne uniquement)"; break;
									CASE "Lorraine" : $title = "Lorrain et les Lorraines (Meurthe-et-Moselle, moselle et Vosges uniquement)"; break;
									CASE "Midi-Pyrénées" : $title = "Midi-Pyrénéens et Midi-Pyrénéennes (Haute-Garonne uniquement)"; break;
									CASE "Nord-Pas-de-Calais" : $title = "Chtis (Nord uniquement)"; break;
									CASE "Pays de la Loire" : $title = "Ligériens et Ligériennes (Loire-Atlantique, Mayenne et Sarthe uniquement)"; break;
									CASE "Picardie" : $title = "Picards et Picardes (Aisne et Somme uniquement)"; break;
									CASE "Provence-Alpes-Côte-d'Azur" : $title = "Pacaïens et Pacaïennes (Alpes-Maritimes, Bouches-du-Rhône, Vaucluse et Var uniquement)"; break;
									CASE "Rhône-Alpes" : $title = "Rhônalpiens et Rhônalpines (Haute-Savoie, Isère et Rhône uniquement)"; break;
									
									DEFAULT : $title = '';
								}
								echo "<a href='" . $lien . "' title='Repas en livraison pour les " . $title . "'>" . $nom_region . "</a>&nbsp;&nbsp;";
							}
							?>
						</p>
						<br /><br />
						
						<h3>Accès par département :</h3>
						<p style="text-align:justify;">
							<a href="/picardie/saint-quentin/livraison/restaurants/18/846/page.htm" title="Livraison de repas pour les Axonais et Axonnaises ( 02100 Saint-Quentin)" />Aisne (02)</a>&nbsp;&nbsp;
							<a href="/provence-alpes-cote-d-azur/nice/livraison/restaurants/20/108/page.htm" title="Livraison de repas pour les Maralpins et Maralpines ( 06000 Nice, 06400 cannes)" />Alpes-Maritimes (06)</a>&nbsp;&nbsp;
							<a href="/champagne-ardenne/charleville-mezieres/livraison/restaurants/8/975/page.htm" title="Livraison de repas pour les Ardennais et Ardennaises ( 08000 Charleville-Mézières)" />Ardennes (08)</a>&nbsp;&nbsp;
							<a href="/alsace/livraison/restaurants/1/2/page.htm" title="Livraison de repas pour les Bas-Rhinois et Bas-Rhinoises ( 67000 Strasbourg et 67500 Haguenau)" />Bas-Rhin (67)</a>&nbsp;&nbsp;
							<a href="/provence-alpes-cote-d-azur/aix-en-provence/livraison/restaurants/20/517/page.htm" title="Livraison de repas pour les Bucco-Rhodaniniens et Bucco-Rhodaniennes ( 13100 Aix-en-Provence, 13001 Marseille )" />Bouches-du-Rhône (13)</a>&nbsp;&nbsp;
							<a href="/bourgogne/livraison/restaurants/5/580/page.htm" title="Livraison de repas pour les Côte d'oriens et Costaloriennes ( 21000 Dijon)" />Côte-d'Or (21)</a>&nbsp;&nbsp;
							<a href="/corse/ajaccio/livraison/restaurants/23/1263/page.htm" title="Livraison de repas pour les Pumontinchis, 20000 Ajaccio (Aiacciu)" />Corse-du-sud <i>(Pumonte)</i> (20)</a>&nbsp;&nbsp;
							<a href="/bretagne/livraison/restaurants/6/1390/page.htm" title="Livraison de repas pour les Brestois ( 29200 Brest )" />Finistère <i>(Penn-ar-Bed) </i>(29)</a>&nbsp;&nbsp;
							<a href="/aquitaine/livraison/restaurants/2/147/page.htm" title="Livraison de repas chez les Girondins et Girondines ( 33000 Bordeaux)" />Gironde (33)</a>&nbsp;&nbsp;
							<a href="/alsace/mulhouse/livraison/restaurants/1/772/page.htm" title="Livraison de repas pour les Haut-Rhinois et Haut-Rhinoises ( 68000 Colmar, 68100 Mulhouse et 68500 Guebwiller)" />Haut-Rhin (68)</a>&nbsp;&nbsp;
							<a href="/midi-pyrenees/livraison/restaurants/15/115/page.htm" title="Livraison de repas pour les Haut-Garonnais et Haut-Garonnaises ( 31000 Toulouse )" />Haute-Garonne (31)</a>&nbsp;&nbsp;
							<a href="/limousin/livraison/restaurants/13/765/page.htm" title="Livraison de repas pour les Haut-Viennoise et Haute-Viennoises ( 87000 Limoges)" />Haute-Vienne (87)</a>&nbsp;&nbsp;
							<a href="/rhone-alpes/livraison/restaurants/21/871/page.htm" title="Livraison de repas pour les Haut-Savoyards et Haut-Savoyardes ( 74000 Annecy)" />Haute-Savoie (74)</a>&nbsp;&nbsp;
							<a href="/languedoc-roussillon/livraison/restaurants/12/116/page.htm" title="Livraison de repas pour les Héraultais et Héraultaises ( 34000 Montpellier)" />Hérault (34)</a>&nbsp;&nbsp;
							<a href="/bretagne/livraison/restaurants/6/221/page.htm" title="Livraison  de repas pour les Bretilliens ( 35000 Rennes)" />Ille-et-Vilaine (35)</a>&nbsp;&nbsp;
							<a href="/centre/livraison/restaurants/7/715/page.htm" title="Livraison de repas pour les Indroligériens et Indroligériennes ( 37000 Tours)" />Indre-et-Loire (37)</a>&nbsp;&nbsp;
							<a href="/rhone-alpes/grenoble/livraison/restaurants/21/537/page.htm" title="Livraison de repas pour les Isérois et Iséroises ( 38000 Grenoble, 38200 Vienne )" />Isère (38)</a>&nbsp;&nbsp;
							<a href="/rhone-alpes/saint-etienne/livraison/restaurants/21/962/page.htm" title="Livraison de repas pour les Ligériens et Ligériennes ( 42000 Saint-Etienne )" />Loire (42)</a>&nbsp;&nbsp;
							<a href="/pays-de-la-loire/nantes/livraison/restaurants/17/136/page.htm" title="Livraison de repas pour les Nantais et Nantaises ( 44000 Nantes )" />Loire-Atlantique (44)</a>&nbsp;&nbsp;
							<a href="/centre/tours/livraison/restaurants/7/715/page.htm" title="Livraison de repas pour les Loirétains et Loirétaines ( 45000 Orléans )" />Loiret (45)</a>&nbsp;&nbsp;
							<a href="/champagne-ardenne/reims/livraison/restaurants/8/245/page.htm" title="Livraison de repas pour les Marnais et les Marnaises ( 51000 Châlons-en-Champagne, 51100 Reims, 51200 Epernay )" />Marne (51)</a>&nbsp;&nbsp;
							<a href="/pays-de-la-loire/livraison/restaurants/17/911/page.htm" title="Livraison de repas pour les Mayennais et Mayennaises ( 53000 Laval )" />Mayenne (53)</a>&nbsp;&nbsp;
							<a href="/lorraine/nancy/livraison/restaurants/14/27/page.htm" title="Livraison de repas pour les Meurthe et Mosellans et Meurthe et Mosellanes ( 54000 Nancy )" />Meurthe-et-Moselle (54)</a>&nbsp;&nbsp;
							<a href="/lorraine/metz/livraison/restaurants/14/26/page.htm" title="Livraison de repas pour les Mosellans et mosellanes ( 57000 Metz, 57100 Thionville )" />Moselle (57)</a>&nbsp;&nbsp;
							<a href="/nord-pas-de-calais/livraison/restaurants/16/209/page.htm" title="Livraison de repas pour les Nordistes ( 59000 Lille, 59300 Vanlenciennes )" />Nord (59)</a>&nbsp;&nbsp;
							<a href="/picardie/compiegne/livraison/restaurants/18/943/page.htm" title="Livraison de repas pour les Isariens et Isariennes ( 60200 Compiègnes )" />Oise (60)</a>&nbsp;&nbsp;
							<a href="/auvergne/livraison/restaurants/3/674/page.htm" title="Livraison de repas pour les Puydômois et Puydômoises ( 63000 Clermont Ferrand )" />Puy-de-Dôme (63)</a>&nbsp;&nbsp;
							<a href="/languedoc-roussillon/livraison/restaurants/12/527/page.htm" title="Livraison de repas pour les Catalans et Catalanes ( 66000 Perpignan )" />Pyrénées-Orientales (66)</a>&nbsp;&nbsp;
							<a href="/rhone-alpes/livraison/restaurants/21/1181/page.htm" title="Livraison de repas pour les Rhodaniens et Rhodaniennes ( 69001 Lyon )" />Rhône (69)</a>&nbsp;&nbsp;
							<a href="/pays-de-la-loire/le-mans/livraison/restaurants/17/650/page.htm" title="Livraison de repas pour les Sarthois et Sarthoises ( 72000 Le Mans )" />Sarthe (72)</a>&nbsp;&nbsp;
							<a href="/haute-normandie/livraison/restaurants/10/384/page.htm" title="Livraison de repas pour les Seinomarins et Seinomarines ( 76600 Le Havre )" />Seine-Maritime (76)</a>&nbsp;&nbsp;
							<a href="/picardie/amiens/livraison/restaurants/18/697/page.htm" title="Livraison de repas pour les Samariens et Samariennes ( 80000 Amiens )" />Somme (80)</a>&nbsp;&nbsp;
							<a href="/provence-alpes-cote-d-azur/toulon/livraison/restaurants/20/471/page.htm" title="Livraison de repas pour les Varois et Varoises ( 83000 Toulon )" />Var (83)</a>&nbsp;&nbsp;
							<a href="/provence-alpes-cote-d-azur/avignon/livraison/restaurants/20/999/page.htm" title="Livraison de repas pour les Vauclusiens et Vauclusiennes ( 84000 Avignon )" />Vaucluse (84)</a>&nbsp;&nbsp;
							<a href="/lorraine/epinal/livraison/restaurants/14/917/page.htm" title="Livraison de repas pour les Vosgiens et Vosginnes ( 88000 Epinal )" />Vosges (88)</a>&nbsp;&nbsp;
						</p>
						<br /><br />
						
						<h3>Accès par ville :</h3>
						<p style="text-align:justify;">
							Cliquez sur un de ces liens puis sur la page d'arrivée, précisez votre lieu exact de livraison en selectionnant un des quartiers dans la zone CHANGER MON QUARTIER<br />
							Si votre quartier/commune ne figure pas dans la liste, c'est que vous n'êtes pas encore desservi par notre service.<br /><br /> 
							
							<a href="/restaurant-livraison/aix-en-provence/517/0/page.htm" title="Livraison à domicile chez les Aixois, Aixoises" />Aix-en-Provence (13100)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/ajaccio/1263/0/page.htm" title="Livraison à domicile chez les Ajacciens, Ajacciennes (Aiaccini ou Aghjaccinchi)" />Ajaccio (20000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/amiens/697/0/page.htm" title="Livraison à domicile chez les Amiénois, Amiénoises" />Amiens (80000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/annecy/871/0/page.htm" title="Livraison à domicile chez les Annécien, Annéciennes" />Annecy (74000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/avignon/999/0/page.htm" title="Livraison à domicile chez les Avignonnais, Avignonnaises" />Avignon (84000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/bordeaux/147/0/page.htm" title="Livraison à domicile chez les Bordelais, Bordelaises" />Bordeaux (33000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/brest/1390/0/page.htm" title="Livraison à domicile chez les Brestois, Brestoises" />Brest (29200)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/cannes/1244/0/page.htm" title="Livraison à domicile chez les Cannois, cannoises" />Cannes (06400)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/chalons-en-champagne/921/0/page.htm" title="Livraison à domicile chez les Châlonnais, Châlonnaises" />Châlons-en-Champagne (51000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/charleville-mezieres/975/0/page.htm" title="Livraison à domicile chez les Carolomacériens, Carolomacériennes" />Charleville-Mézières (08000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/clermont-ferrand/674/0/page.htm" title="Livraison à domicile chez les Clermontois, Clermontoises" />Clermont-Ferrand (63000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/colmar/1136/0/page.htm" title="Livraison à domicile chez les Colmariens, Colmariennes" />Colmar (68000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/compiegne/943/0/page.htm" title="Livraison à domicile chez les Compiègnois, Compiègnoises" />Compiègne (60200)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/dijon/580/0/page.htm" title="Livraison à domicile chez les dijonnais, Dijonnaise" />Dijon (21000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/epernay/1120/0/page.htm" title="Livraison à domicile chez les Sparnaciens" />Epernay (51200)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/epinal/917/0/page.htm" title="Livraison à domicile chez les Spinaliens, Spinaliennes" />Epinal (88000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/grenoble/537/0/page.htm" title="Livraison à domicile chez les Grenoblois, Grenobloises" />Grenoble (38000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/guebwiller/920/0/page.htm" title="Livraison à domicile chez les Guebwillerois, Guebwilleroises" />Guebwiller (68500)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/haguenau/851/0/page.htm" title="Livraison à domicile chez les Haguenoviens, Haguenoviennes" />Haguenau (67500)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/laval/911/0/page.htm" title="Livraison à domicile chez les Lavallois, Lavalloises" />Laval (53000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/le-havre/384/0/page.htm" title="Livraison à domicile chez les Havrais, Havraises" />Le Havre (76600)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/le-mans/650/0/page.htm" title="Livraison à domicile chez les Manceaux, Mancelles" />Le Mans (72000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/lille/209/0/page.htm" title="Livraison à domicile chez les Lillois, Lilloises" />Lille (59000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/limoges/765/0/page.htm" title="Livraison à domicile chez les Limougeauds, Limougeaudes" />Limoges (87000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/lyon-69001/1181/0/page.htm" title="Livraison à domicile chez les Lyonnais, Lyonnaises" />Lyon (69001)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/marseille-13001/852/0/page.htm" title="Livraison à domicile chez les Marseillais, Marseillaises" />Marseille (13001)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/metz/26/0/page.htm" title="Livraison à domicile chez les Messins, Messines" />Metz (57000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/montpellier/116/0/page.htm" title="Livraison à domicile chez les Montpelliérain, Montpelliéraines" />Montpellier (34000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/mulhouse/772/0/page.htm" title="Livraison à domicile chez les Mulhousiens, Mulhousiennes" />Mulhouse (68100)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/nancy/27/0/page.htm" title="Livraison à domicile chez les Nancéiens, Nancéiennes" />Nancy (54000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/nantes/136/0/page.htm" title="Livraison à domicile chez les Nantais, Nantaises" />Nantes (44000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/nice/108/0/page.htm" title="Livraison à domicile chez les Niçois, Niçoises" />Nice (06000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/orleans/1059/0/page.htm" title="Livraison à domicile chez les Orléanais, Orléanaises" />Orléans (45000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/perpignan/527/0/page.htm" title="Livraison à domicile chez les Perpignanais, Perpignanaises" />Perpignan (66000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/reims/245/0/page.htm" title="Livraison à domicile chez les Rémois, Rémoises" />Reims (51100)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/rennes/221/0/page.htm" title="Livraison à domicile chez les Rennais, Rennaises" />Rennes (35000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/saint-etienne/962/0/page.htm" title="Livraison à domicile chez les Stéphanois, Stéphanoises" />Saint-Etienne (42000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/saint-quentin/846/0/page.htm" title="Livraison à domicile chez les Saint-Quentinois, Saint-Quentinoises" />Saint-Quentin (02100)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/strasbourg/2/0/page.htm" title="Livraison à domicile chez les Strasbourgeois, Strasbourgeoises" />Strasbourg (67000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/thionville/832/0/page.htm" title="Livraison à domicile chez les Thionvillois, Thionvilloises" />Thionville (57100)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/toulon/471/0/page.htm" title="Livraison à domicile chez les Toulonnais, Toulonnaises" />Toulon (83000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/toulouse/115/0/page.htm" title="Livraison à domicile chez les Toulousains, Toulousaines" />Toulouse (31000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/tours/715/0/page.htm" title="Livraison à domicile chez les Tourangeaux, Tourangelles" />Tours (37000)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/valenciennes/1092/0/page.htm" title="Livraison à domicile chez les Valenciennois, Valenciennoises" />Valenciennes (59300)</a>&nbsp;&nbsp;
							<a href="/restaurant-livraison/vienne/1103/0/page.htm" title="Livraison à domicile chez les Viennois, Viennoises" />Vienne (38200)</a>&nbsp;&nbsp;
						</p>
						<br /><br />
						 
						<h2>Service de plats à emporter</h2>
						<p style="text-align:justify;">
							Des restaurants partenaires proposent également la vente de plats à emporter, souvent à des tarifs préférentiels par rapport à ceux de la livraison.<br />
							Vous passez commande sur Restomalin, indiquez à quelle heure vous souhaitez passer récupérer votre repas puis le restaurateur vous confirme votre commande par SMS ou par email.<br />
						</p>
						
						<h3>Accès par région :</h3>
						<p style="text-align:justify;">
							<?
							$ville_temp = new ville();
							foreach( $__liste_region as $_region ) {
								$nom_region = utf8_encode( $_region->nom );
								
								// Recherche de la 1iere ville
								unset( $recherche );
								$recherche[ "requete_directe" ] = " WHERE id_region = " . $_region->id;
								$recherche[ "requete_directe" ] .= " AND priorite = 1";
								$recherche[ "requete_directe" ] .= " AND actif = 1";
								$recherche[ "requete_directe" ] .= " ORDER BY nom";
								$tab = $ville_temp->getListe( $recherche, false );
								$_num_ville = $tab[ 0 ]->id;
								
								$lien = "/" . tranformer_url( $_region->nom ) . "/a-emporter/restaurants/" . $_region->id . "/" . $_num_ville . "/page.htm";
								SWITCH ( $nom_region ) {
									CASE "Alsace" : $title = "Alsaciens, Alsaciennes (Bas-Rhin et Haut-Rhin)"; break;
									CASE "Aquitaine" : $title = "Aquitains, Aquitaines (en Gironde uniquement)"; break;
									CASE "Auvergne" : $title = "Auvergnats et Auvergnates (Puy de Dôme uniquement)"; break;
									CASE "Bourgogne" : $title = "Bourguignons et les Bourguignonnes (Côte d Or uniquement)"; break;
									CASE "Bretagne" : $title = "Bretons et les Bretonnes (Ille et Vilaine uniquement)"; break;
									CASE "Centre" : $title = "Centrais et les Centraises (Loiret et Indre-et-Loire)"; break;
									CASE "Champagne-Ardenne" : $title = "Champardennais et les Champardennaises (Ardennes et Marne uniquement)"; break;
									CASE "Corse" : $title = "Corses (Corse-du-sud 2A uniquement)"; break;
									CASE "Haute-Normandie" : $title = "Hauts-Normands et Hauts-Normandes (Seine-Maritime uniquement)"; break;
									CASE "Languedoc-Roussillon" : $title = "Languedociens et Languedociennes (Hérault et Pyrénées Orientales uniquement)"; break;
									CASE "Limousin" : $title = "Limousins et les Limousines (Haute Vienne uniquement)"; break;
									CASE "Lorraine" : $title = "Lorrain et les Lorraines (Meurthe-et-Moselle, moselle et Vosges uniquement)"; break;
									CASE "Midi-Pyrénées" : $title = "Midi-Pyrénéens et Midi-Pyrénéennes (Haute-Garonne uniquement)"; break;
									CASE "Nord-Pas-de-Calais" : $title = "Chtis (Nord uniquement)"; break;
									CASE "Pays de la Loire" : $title = "Ligériens et Ligériennes (Loire-Atlantique, Mayenne et Sarthe uniquement)"; break;
									CASE "Picardie" : $title = "Picards et Picardes (Aisne et Somme uniquement)"; break;
									CASE "Provence-Alpes-Côte-d'Azur" : $title = "Pacaïens et Pacaïennes (Alpes-Maritimes, Bouches-du-Rhône, Vaucluse et Var uniquement)"; break;
									CASE "Rhône-Alpes" : $title = "Rhônalpiens et Rhônalpines (Haute-Savoie, Isère et Rhône uniquement)"; break;
									
									DEFAULT : $title = '';
								}	
								echo "<a href='" . $lien . "' title='Plats à emporter pour les " . $title . "'>" . $nom_region . "</a>&nbsp;&nbsp;";
							}
							?>
						</p>
						<br /><br />
						 
						<h3>Accès par département :</h3>
						<p style="text-align:justify;">
							<a href="/picardie/saint-quentin/a-emporter/restaurants/18/846/page.htm" title="Repas à emporter pour les Axonais et Axonnaises ( 02100 Saint-Quentin)" />Aisne (02)</a>&nbsp;&nbsp;
							<a href="/provence-alpes-cote-d-azur/nice/a-emporter/restaurants/20/108/page.htm" title="Repas à emporter pour les Maralpins et Maralpines ( 06000 Nice, 06400 Cannes)" />Alpes-Maritimes (06)</a>&nbsp;&nbsp;
							<a href="/champagne-ardenne/charleville-mezieres/a-emporter/restaurants/8/975/page.htm" title="Repas à emporter pour les Ardennais et Ardennaises ( 08000 Charleville-Mézières)" />Ardennes (08)</a>&nbsp;&nbsp;
							<a href="/alsace/a-emporter/restaurants/1/2/page.htm" title="Repas à emporter pour les Bas-Rhinois et Bas-Rhinoises ( 67000 Strasbourg et 67500 Haguenau)" />Bas-Rhin (67)</a>&nbsp;&nbsp;
							<a href="/provence-alpes-cote-d-azur/aix-en-provence/a-emporter/restaurants/20/517/page.htm" title="Repas à emporter pour les Bucco-Rhodaniniens et Bucco-Rhodaniennes ( 13100 Aix-en-Provence, 13001 Marseille )" />Bouches-du-Rhône (13)</a>&nbsp;&nbsp;
							<a href="/bourgogne/a-emporter/restaurants/5/580/page.htm" title="Repas à emporter pour les Côte d'oriens et Costaloriennes ( 21000 Dijon)" />Côte-d'Or (21)</a>&nbsp;&nbsp;
							<a href="/corse/ajaccio/a-emporter/restaurants/23/1263/page.htm" title="Repas à emporter pour les Pumontinchis, 20000 Ajaccio (Aiacciu)" />Corse-du-sud <i>(Pumonte)</i> (20)</a>&nbsp;&nbsp;
							<a href="/bretagne/a-emporter/restaurants/6/1390/page.htm" title="Repas à emporter pour les Brestois ( 29200 Brest )" />Finistère <i>(Penn-ar-Bed) </i>(29)</a>&nbsp;&nbsp;
							<a href="/aquitaine/a-emporter/restaurants/2/147/page.htm" title="Repas à emporter chez les Girondins et Girondines ( 33000 Bordeaux)" />Gironde (33)</a>&nbsp;&nbsp;
							<a href="/alsace/mulhouse/a-emporter/restaurants/1/772/page.htm" title="Repas à emporter pour les Haut-Rhinois et Haut-Rhinoises ( 68000 Colmar, 68100 Mulhouse et 68500 Guebwiller)" />Haut-Rhin (68)</a>&nbsp;&nbsp;
							<a href="/midi-pyrenees/a-emporter/restaurants/15/115/page.htm" title="Repas à emporter pour les Haut-Garonnais et Haut-Garonnaises ( 31000 Toulouse )" />Haute-Garonne (31)</a>&nbsp;&nbsp;
							<a href="/limousin/a-emporter/restaurants/13/765/page.htm" title="Repas à emporter pour les Haut-Viennoise et Haute-Viennoises ( 87000 Limoges)" />Haute-Vienne (87)</a>&nbsp;&nbsp;
							<a href="/rhone-alpes/a-emporter/restaurants/21/871/page.htm" title="Repas à emporter pour les Haut-Savoyards et Haut-Savoyardes ( 74000 Annecy)" />Haute-Savoie (74)</a>&nbsp;&nbsp;
							<a href="/languedoc-roussillon/a-emporter/restaurants/12/116/page.htm" title="Repas à emporter pour les Héraultais et Héraultaises ( 34000 Montpellier)" />Hérault (34)</a>&nbsp;&nbsp;
							<a href="/bretagne/a-emporter/restaurants/6/221/page.htm" title="Livraison  de repas pour les Bretilliens ( 35000 Rennes)" />Ille-et-Vilaine (35)</a>&nbsp;&nbsp;
							<a href="/centre/a-emporter/restaurants/7/715/page.htm" title="Repas à emporter pour les Indroligériens et Indroligériennes ( 37000 Tours)" />Indre-et-Loire (37)</a>&nbsp;&nbsp;
							<a href="/rhone-alpes/grenoble/a-emporter/restaurants/21/537/page.htm" title="Repas à emporter pour les Isérois et Iséroises ( 38000 Grenoble, 38200 Vienne )" />Isère (38)</a>&nbsp;&nbsp;
							<a href="/rhone-alpes/saint-etienne/a-emporter/restaurants/21/962/page.htm" title="Repas à emporter pour les Ligériens et Ligériennes ( 42000 Saint-Etienne )" />Loire (42)</a>&nbsp;&nbsp;
							<a href="/pays-de-la-loire/nantes/a-emporter/restaurants/17/136/page.htm" title="Repas à emporter pour les Nantais et Nantaises ( 44000 Nantes )" />Loire-Atlantique (44)</a>&nbsp;&nbsp;
							<a href="/centre/tours/a-emporter/restaurants/7/715/page.htm" title="Repas à emporter pour les Loirétains et Loirétaines ( 45000 Orléans )" />Loiret (45)</a>&nbsp;&nbsp;
							<a href="/champagne-ardenne/reims/a-emporter/restaurants/8/245/page.htm" title="Repas à emporter pour les Marnais et les Marnaises ( 51000 Châlons-en-Champagne, 51100 Reims, 51200 Epernay )" />Marne (51)</a>&nbsp;&nbsp;
							<a href="/pays-de-la-loire/a-emporter/restaurants/17/911/page.htm" title="Repas à emporter pour les Mayennais et Mayennaises ( 53000 Laval )" />Mayenne (53)</a>&nbsp;&nbsp;
							<a href="/lorraine/nancy/a-emporter/restaurants/14/27/page.htm" title="Repas à emporter pour les Meurthe et Mosellans et Meurthe et Mosellanes ( 54000 Nancy )" />Meurthe-et-Moselle (54)</a>&nbsp;&nbsp;
							<a href="/lorraine/metz/a-emporter/restaurants/14/26/page.htm" title="Repas à emporter pour les Mosellans et mosellanes ( 57000 Metz, 57100 Thionville )" />Moselle (57)</a>&nbsp;&nbsp;
							<a href="/nord-pas-de-calais/a-emporter/restaurants/16/209/page.htm" title="Repas à emporter pour les Nordistes ( 59000 Lille )" />Nord (59)</a>&nbsp;&nbsp;
							<a href="/picardie/compiegne/a-emporter/restaurants/18/943/page.htm" title="Repas à emporter pour les Isariens et Isariennes ( 60200 Compiègnes )" />Oise (60)</a>&nbsp;&nbsp;
							<a href="/auvergne/a-emporter/restaurants/3/674/page.htm" title="Repas à emporter pour les Puydômois et Puydômoises ( 63000 Clermont Ferrand )" />Puy-de-Dôme (63)</a>&nbsp;&nbsp;
							<a href="/languedoc-roussillon/a-emporter/restaurants/12/527/page.htm" title="Repas à emporter pour les Catalans et Catalanes ( 66000 Perpignan )" />Pyrénées-Orientales (66)</a>&nbsp;&nbsp;
							<a href="/rhone-alpes/a-emporter/restaurants/21/1181/page.htm" title="Repas à emporter pour les Rhodaniens et Rhodaniennes ( 69001 Lyon )" />Rhône (69)</a>&nbsp;&nbsp;
							<a href="/pays-de-la-loire/le-mans/a-emporter/restaurants/17/650/page.htm" title="Repas à emporter pour les Sarthois et Sarthoises ( 72000 Le Mans )" />Sarthe (72)</a>&nbsp;&nbsp;
							<a href="/haute-normandie/a-emporter/restaurants/10/384/page.htm" title="Repas à emporter pour les Seinomarins et Seinomarines ( 76600 Le Havre )" />Seine-Maritime (76)</a>&nbsp;&nbsp;
							<a href="/picardie/amiens/a-emporter/restaurants/18/697/page.htm" title="Repas à emporter pour les Samariens et Samariennes ( 80000 Amiens )" />Somme (80)</a>&nbsp;&nbsp;
							<a href="/provence-alpes-cote-d-azur/toulon/a-emporter/restaurants/20/471/page.htm" title="Repas à emporter pour les Varois et Varoises ( 83000 Toulon )" />Var (83)</a>&nbsp;&nbsp;
							<a href="/provence-alpes-cote-d-azur/avignon/a-emporter/restaurants/20/999/page.htm" title="Repas à emporter pour les Vauclusiens et Vauclusiennes ( 84000 Avignon )" />Vaucluse (84)</a>&nbsp;&nbsp;
							<a href="/lorraine/epinal/a-emporter/restaurants/14/917/page.htm" title="Repas à emporter pour les Vosgiens et Vosginnes ( 88000 Epinal )" />Vosges (88)</a>&nbsp;&nbsp;
						</p>
						<br /><br />
						
						<h3>Accès par ville :</h3>
						<p style="text-align:justify;">
							<a href="/restaurant-a-emporter/aix-en-provence/517/0/page.htm" title="Vente à emporter chez les Aixois, Aixoises" />Aix-en-Provence (13100)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/ajaccio/1263/0/page.htm" title="Vente à emporter chez les Ajacciens, Ajacciennes (Aiaccini ou Aghjaccinchi)" />Ajaccio (20000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/amiens/697/0/page.htm" title="Vente à emporter chez les Amiénois, Amiénoises" />Amiens (80000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/annecy/871/0/page.htm" title="Vente à emporter chez les Annécien, Annéciennes" />Annecy (74000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/avignon/999/0/page.htm" title="Vente à emporter chez les Avignonnais, Avignonnaises" />Avignon (84000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/bordeaux/147/0/page.htm" title="Vente à emporter chez les Bordelais, Bordelaises" />Bordeaux (33000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/cannes/1244/0/page.htm" title="Vente à emporter chez les Cannois, cannoises" />Cannes (06400)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/chalons-en-champagne/921/0/page.htm" title="Vente à emporter chez les Châlonnais, Châlonnaises" />Châlons-en-Champagne (51000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/charleville-mezieres/975/0/page.htm" title="Vente à emporter chez les Carolomacériens, Carolomacériennes" />Charleville-Mézières (08000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/clermont-ferrand/674/0/page.htm" title="Vente à emporter chez les Clermontois, Clermontoises" />Clermont-Ferrand (63000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/colmar/1136/0/page.htm" title="Vente à emporter chez les Colmariens, Colmariennes" />Colmar (68000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/compiegne/943/0/page.htm" title="Vente à emporter chez les Compiègnois, Compiègnoises" />Compiègne (60200)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/dijon/580/0/page.htm" title="Vente à emporter chez les dijonnais, Dijonnaise" />Dijon (21000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/epernay/1120/0/page.htm" title="Vente à emporter chez les Sparnaciens" />Epernay (51200)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/epinal/917/0/page.htm" title="Vente à emporter chez les Spinaliens, Spinaliennes" />Epinal (88000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/grenoble/537/0/page.htm" title="Vente à emporter chez les Grenoblois, Grenobloises" />Grenoble (38000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/guebwiller/920/0/page.htm" title="Vente à emporter chez les Guebwillerois, Guebwilleroises" />Guebwiller (68500)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/haguenau/851/0/page.htm" title="Vente à emporter chez les Haguenoviens, Haguenoviennes" />Haguenau (67500)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/laval/911/0/page.htm" title="Vente à emporter chez les Lavallois, Lavalloises" />Laval (53000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/le-havre/384/0/page.htm" title="Vente à emporter chez les Havrais, Havraises" />Le Havre (76600)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/le-mans/650/0/page.htm" title="Vente à emporter chez les Manceaux, Mancelles" />Le Mans (72000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/lille/209/0/page.htm" title="Vente à emporter chez les Lillois, Lilloises" />Lille (59000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/limoges/765/0/page.htm" title="Vente à emporter chez les Limougeauds, Limougeaudes" />Limoges (87000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/lyon-69001/1181/0/page.htm" title="Vente à emporter chez les Lyonnais, Lyonnaises" />Lyon (69001)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/marseille-13001/852/0/page.htm" title="Vente à emporter chez les Marseillais, Marseillaises" />Marseille (13001)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/metz/26/0/page.htm" title="Vente à emporter chez les Messins, Messines" />Metz (57000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/montpellier/116/0/page.htm" title="Vente à emporter chez les Montpelliérain, Montpelliéraines" />Montpellier (34000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/mulhouse/772/0/page.htm" title="Vente à emporter chez les Mulhousiens, Mulhousiennes" />Mulhouse (68100)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/nancy/27/0/page.htm" title="Vente à emporter chez les Nancéiens, Nancéiennes" />Nancy (54000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/nantes/136/0/page.htm" title="Vente à emporter chez les Nantais, Nantaises" />Nantes (44000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/nice/108/0/page.htm" title="Vente à emporter chez les Niçois, Niçoises" />Nice (06000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/orleans/1059/0/page.htm" title="Vente à emporter chez les Orléanais, Orléanaises" />Orléans (45000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/perpignan/527/0/page.htm" title="Vente à emporter chez les Perpignanais, Perpignanaises" />Perpignan (66000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/reims/245/0/page.htm" title="Vente à emporter chez les Rémois, Rémoises" />Reims (51100)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/rennes/221/0/page.htm" title="Vente à emporter chez les Rennais, Rennaises" />Rennes (35000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/saint-etienne/962/0/page.htm" title="Vente à emporter chez les Stéphanois, Stéphanoises" />Saint-Etienne (42000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/saint-quentin/846/0/page.htm" title="Vente à emporter chez les Saint-Quentinois, Saint-Quentinoises" />Saint-Quentin (02100)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/strasbourg/2/0/page.htm" title="Vente à emporter chez les Strasbourgeois, Strasbourgeoises" />Strasbourg (67000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/thionville/832/0/page.htm" title="Vente à emporter chez les Thionvillois, Thionvilloises" />Thionville (57100)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/toulon/471/0/page.htm" title="Vente à emporter chez les Toulonnais, Toulonnaises" />Toulon (830000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/toulouse/115/0/page.htm" title="Vente à emporter chez les Toulousains, Toulousaines" />Toulouse (31000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/tours/715/0/page.htm" title="Vente à emporter chez les Tourangeaux, Tourangelles" />Tours (37000)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/valenciennes/1092/0/page.htm" title="Vente à emporter chez les Valenciennois, Valenciennoises" />Valenciennes (59300)</a>&nbsp;&nbsp;
							<a href="/restaurant-a-emporter/vienne/1103/0/page.htm" title="Vente à emporter chez les Viennois, Viennoises" />Vienne (38200)</a>&nbsp;&nbsp;
						</p>
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
			
			// Clic sur le bouton de retour
			$( ".btn-retour" ).click(function() {
				history.back(1);
			});
	
		});
	</script>
	
</html>