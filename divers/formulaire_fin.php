<? include_once( "../classes/config_v2.php" ); ?>
<? include_once( "../classes/classes.php" ); ?>
<? include_once( "../include_connexion/connexion_site_on.php" ); ?>
<?
	$debug = false;
	$lien_retour = $_POST[ "r" ];
	$lightbox = ( $_POST[ "lb" ] == '1' ) ? true : false;
	
	//print_pre( $_SERVER );
	//print_pre( $_POST );
	
	// On suggère un restaurant
	if ( $_GET[ "mon_action" ] == "suggerer" ) {
		//echo "On suggère...<br>";
		
		// Préparation du mail
		$sujet = "Suggestion de restaurant";
		
		$sender = "feedback@restomalin.com";
		
		if ( $_SESSION[ "franchise" ][ "is_franchise" ] ) $sender_label = $_SESSION[ "site" ][ "signature" ];
		else $sender_label = "Restomalin";
		
		//echo "--- sender_label / sender : " . $sender_label . " / " . $sender . "<br>";
		
		$_to = $_POST[ "mail" ];
		//$_to = "franck_langleron@hotmail.com";
		//echo "--- To : " . $_to . "<br>";
		
		$corps = "Bonjour,<br><br>";
		$corps .= "Voici une suggestion de restaurant :<br><br>";
		$corps .= "Nom du restaurant : <b>" . $_POST[ "nom" ] . "</b><br>";
		$corps .= "Ville : <b>" . $_POST[ "ville" ] . "</b><br>";
		$corps .= "Propriétaire : <b>" . $_POST[ "proprietaire" ] . "</b><br>";
		if ( $_POST[ "tel" ] != '' ) $corps .= "Téléphone : <b>" . $_POST[ "tel" ] . "</b><br>";
		if ( $_POST[ "mail" ] != '' ) $corps .= "E-mail : <b>" . $_POST[ "mail" ] . "</b><br>";
		if ( $_POST[ "commentaire" ] != '' ) $corps .= "<br>Commentaire : <br><b>" . $_POST[ "commentaire" ] . "</b><br><br>";
		$corps .= "A bientôt.<br><br>";
		$corps .= "<br><br>";
		$corps .= "L'équipe restomalin.com.";
		$corps = utf8_decode( $corps );
		//echo $corps . "<br>";
		
		// Envoi du mail au propriétaire (si mail renseigné)
		if ( $_to != '' ) _nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );
		
		// Mails aux collègues
		if ( !$debug ) {
			
			$_to = "maurice@restomalin.com";
			_nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );
			
			$_to = "jean-luc@restomalin.com";
			_nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );
			
			$_to = "manu@restomalin.com";
			_nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );

			$_to = "olivier@restomalin.com";
			$retour = _nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );

			$_to = "anais@restomalin.com";
			$retour = _nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );

			$_to = "stephanie@restomalin.com";
			$retour = _nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );

			$_to = "damien@restomalin.com";
			$retour = _nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );

		}
		
		$erreur = ( $retour ) ? "false" : "true";
		$texte = ( $retour )
			? "Votre suggestion a bien été prise en compte."
			: "Une erreur est survenue.<br />Veuillez ré-essayer ultérieurement.";
	}
	
	// On conseiller Restomalin à un ami
	else if ( $_GET[ "mon_action" ] == "conseiller" ) {
		//echo "On suggère...<br>";
		
		if ( $_SESSION[ "franchise" ][ "is_franchise" ] ) $qui = $_SESSION[ "site" ][ "signature" ];
		else $qui = "Restomalin";
			
		// Préparation du mail
		$sujet = utf8_decode( $_POST[ "nom" ] . ", un(e) ami(e) qui vous veut du bien, vient de vous suggérer " . $qui );
		
		$sender = "feedback@restomalin.com";
		$sender_label = $qui;
		//echo "--- sender_label / sender : " . $sender_label . " / " . $sender . "<br>";
		
		//$_to = "franck_langleron@hotmail.com";
		$_to = $_POST[ "mail" ];
		//echo "--- To : " . $_to . "<br>";
		
		$corps = "Bonjour,<br /><br />";

		if ( $_SESSION[ "franchise" ][ "is_franchise" ] ) {
			
			$corps .= $_POST[ "nom" ] . " vous conseille de visiter <a href='" . $_SESSION[ "domaine" ][ "site_web" ]. "'>" . $_SESSION[ "domaine" ][ "site_web_texte" ] . "</a>.<br /><br />";
			$corps .= "Découvrez une cuisine vietnamienne authentique.<br />";
			$corps .= "Composez votre menu, réglez en ligne ou auprès du livreur puis dégustez !<br /><br />";
			$corps .= "Guy Quang cuisine pour vous depuis 22 ans. Son savoir-faire, sa réputation et la passion qui l'anime ont été transmis aux Chefs cuisiniers de ALLO NEM. La qualité des plats livrés restent sa préoccupation au quotidien. Mis à part les nems, préparés le jour même et précuits, vos plats sont cuisinés après le passage de votre commande. Tous les plats sautés, le sont au Wok et sur un feu dragon chinois";
			$corps .= "<br><br>";
			$corps .= "L'équipe " . $_SESSION[ "site" ][ "signature" ] . ".<br /><br />";
			$corps .= "<font size=\"-1\"><i>PS : Aucun lien de désabonnement n'est présent et jugé nécessaire pour cet email, " . $qui . " ne conservant pas l'adresse email communiquée par votre ami(e).</i><i></font>";
			}
		else {
			
			$corps .= $_POST[ "nom" ] . " vous conseille de visiter <a href='https://www.restomalin.com'>www.restomalin.com</a> , le 1er portail de livraison de repas à domicile.<br /><br />";
			$corps .= "RESTOMALIN n'est pas qu'un simple site d'e-commerce, c'est aussi <font color=\"red\"><b>une communauté de Membres actifs</b></font> qui suggérent de nouveaux restos et publient leur avis sur les plats reçus.<br /><br />";
			$corps .= "<u><b>COMMENT CA MARCHE ? :</b></u><br />";
			$corps .= "Indiquez votre code postal, ou le nom de votre commune et composez votre repas en quelques clics, parmi une large sélection de restaurants, classés par type de cuisine.<br />";
			$corps .= "N'oubliez pas, avec RESTOMALIN, il n'y a <font color=\"red\"><b>aucun frais de gestion, le service est 100% gratuit !</b></font><br />";
			$corps .= "A tout moment, vous pouvez demander de l'aide en cliquant sur les boutons <i>Besoin d'aide</i> qui jalonnent votre parcours.<br />";
			$corps .= "Cliquez et la charmante Equipe Restomalin se charge de vous rappeler sur le numéro de téléphone de votre choix.<br /><br />";
			$corps .= "Sur RESTOMALIN, <font color=\"red\"><b>l'inscription n'est pas obligatoire</b></font>, vous pouvez passer une commande express.<br />";
			$corps .= "S'inscrire a toutefois l'avantage de vous éviter de saisir votre adresse de livraison à chaque commande.<br /><br />";		
			$corps .= "Le paiement de la commande s'effectue en ligne (paiement sécurisé 3DSecure) ou auprès du livreur, selon les moyens de paiement acceptés par le restaurant partenaire.<br /><br />";
			$corps .= "Une fois votre commande passée, vous recevrez <font color=\"red\"><b>un SMS et un EMAIL de confirmation</b></font> vous indiquant l'heure de livraison.<br />";
			$corps .= "Il y a aussi la page <font color=\"red\"><b><i>suivi commande</i></b></font> qui se lance immédiatement après le passage de votre commande.<br />";
			$corps .= "Cette page se réactualise toute seule et vous indique en 6 étapes où en est votre commande.<br />";
			$corps .= "Vous avez fermé cette page par inadvertance ? Pas de panique, retournez sur la page d'accueil de RESTOMALIN et vous verrez un lien clignotant en haut de la page.";
			$corps .= "<br /><br />Nous espérons vous retrouvez très bientôt parmi les Membres les plus actifs, sur <a href=\"https://restomalin.com\">restomalin.com</a> ou sur <a href=\"https://m.restomalin.com\">m.restomalin.com</a> si vous disposez d'un smartphone ou d'une tablette.";
			$corps .= "<br><br>";
			$corps .= "L'équipe Restomalin.<br /><br />";
			$corps .= "<font size=\"-1\"><i>PS : Aucun lien de désabonnement n'est présent et jugé nécessaire pour cet email, Restomalin ne conservant pas l'adresse email communiquée par votre ami(e).</i><i></font>";
		
		}
		
		$corps = utf8_decode( $corps );
		//echo $corps . "<br>";
		
		// Envoi du mail
		$retour = _nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );
		$erreur = ( $retour ) ? "false" : "true";
		$texte = ( $retour )
			? "Un e-mail a été envoyé à votre ami(e)."
			: "Une erreur est survenue.<br />Veuillez ré-essayer ultérieurement.";
		
		// Mails aux collègues
		if ( !$debug ) {
			
			$_to = "maurice@restomalin.com";
			_nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );
			
			$_to = "jean-luc@restomalin.com";
			_nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );
			
			$corps_z = $_SERVER[ 'REMOTE_ADDR' ] . "<br />" . $corps;
			$_to = "olivier@restomalin.com";
			_nmail( $_to, $sujet, stripslashes( $corps_z ), $sender, $sender_label );
		}
	}
	
	// Devenir partenaire Restomalin
	else if ( $_GET[ "mon_action" ] == "partenaire" ) {
		//echo "Partenaire RM...<br>";
		
		// Préparation du mail
		$sujet = "Devenir partenaire Restomalin";
		
		$sender = "feedback@restomalin.com";
		$sender_label = "Restomalin";
		//echo "--- sender_label / sender : " . $sender_label . " / " . $sender . "<br>";
		
		//$_to = "franck_langleron@hotmail.com";
		$_to = "olivier@restomalin.com";
		//echo "--- To : " . $_to . "<br>";
		
		$corps = "Bonjour,<br><br>";
		$corps .= "Une demande de partenariat vient d'être faite :<br><br>";
		$corps .= "Nom du restaurant : <b>" . $_POST[ "nom" ] . "</b><br>";
		$corps .= "Ville : <b>" . $_POST[ "ville" ] . "</b><br>";
		
		$mail = ( $_POST[ "mail" ] != '' ) ? $_POST[ "mail" ] : "-";
		$tel = ( $_POST[ "tel" ] != '' ) ? traiter_champ_telephone( $_POST[ "tel" ] ) : "-";
		$corps .= "Mail / Téléphone : <b>" . $mail . " / " . $tel . "</b><br>";
		if ( $_POST[ "commentaire" ] != '' ) $corps .= "Commentaire : <br><b>" . $_POST[ "commentaire" ] . "</b><br><br>";
		$corps .= "A bientôt.<br><br>";
		$corps .= "<br><br>";
		$corps .= "L'équipe restomalin.com.";
		$corps = utf8_decode( $corps );
		//echo $corps . "<br>";
		
		// Envoi du mail
		$retour = _nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );
		$erreur = ( $retour ) ? "false" : "true";
		$texte = ( $retour )
			? "Votre demande a bien été prise en compte."
			: "Une erreur est survenue.<br />Veuillez ré-essayer ultérieurement.";
		
		// Mails aux collègues
		if ( !$debug ) {
			
			$_to = "maurice@restomalin.com";
			_nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );
			
			$_to = "jean-luc@restomalin.com";
			_nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );
			
			$_to = "manu@restomalin.com";
			_nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );
			
			$_to = "anais@restomalin.com";
			_nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );

			$_to = "stephanie@restomalin.com";
			_nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );

			$_to = "damien@restomalin.com";
			_nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );

		}
	}
	
	// Formulaire de contact
	else if ( $_GET[ "mon_action" ] == "contact" ) {
		//echo "Partenaire RM...<br>";
		
		// Préparation du mail
		 if ( $_SESSION[ "franchise" ][ "is_franchise" ] ) $sujet = "Formulaire de contact " . $_SESSION[ "site" ][ "signature" ];
		 else $sujet = "Formulaire de contact";
		
		$sender = "feedback@restomalin.com";

		if ( $_SESSION[ "franchise" ][ "is_franchise" ] ) $sender_label = $_SESSION[ "site" ][ "signature" ];
		else $sender_label = "Restomalin";

		//echo "--- sender_label / sender : " . $sender_label . " / " . $sender . "<br>";
		
		$_to = $_POST[ "mail" ];
		//$_to = "franck_langleron@hotmail.com";
		//echo "--- To : " . $_to . "<br>";
		
		// Définition du sujet de la demande
		switch( $_POST[ "sujet" ] ) {
			case "contact" :
				if ( $_SESSION[ "franchise" ][ "is_franchise" ] ) $_sujet = "Formulaire de contact " . $_SESSION[ "site" ][ "signature" ];
				else $_sujet = "Formulaire de contact";
				break;
			
			case "suggestion" :
				$_sujet = "J'ai une suggestion à vous faire";
				break;
			
			case "commande" :
				if ( $_SESSION[ "franchise" ][ "is_franchise" ] ) $_sujet = "Où en est ma commande " . $_SESSION[ "site" ][ "signature" ] . " ?";
				else $_sujet = "Où en est ma commande?";
				break;
			
			case "probleme_commande" :
				if ( $_SESSION[ "franchise" ][ "is_franchise" ] ) $_sujet = "J'ai un problème avec ma commande " . $_SESSION[ "site" ][ "signature" ];
				else $_sujet = "J'ai un problème avec ma commande";
				break;
			
			case "reclamation" :
				if ( $_SESSION[ "franchise" ][ "is_franchise" ] ) $_sujet = "Je veux émettre une réclamation à propos du site " . $_SESSION[ "site" ][ "signature" ];
				else $_sujet = "Je veux émettre une réclamation";
				break;
		}
		
		$corps = "Bonjour,<br><br>";
		$corps .= "Un formulaire de contact vient d'être posté :<br><br>";
		$corps .= "Sujet : <b>" . $_sujet . "</b><br>";
		$corps .= "Nom : <b>" . $_POST[ "nom" ] . " " . $_POST[ "prenom" ] . "</b><br>";
		
		$mail = ( $_POST[ "mail" ] != '' ) ? $_POST[ "mail" ] : "-";
		$tel = ( $_POST[ "tel" ] != '' ) ? traiter_champ_telephone( $_POST[ "tel" ] ) : "-";
		$corps .= "Mail / Téléphone : <b>" . $mail . " / " . $tel . "</b><br>";
		$corps .= "Message : <br><b>" . $_POST[ "message" ] . "</b><br><br>";
		$corps .= "A bientôt.<br><br>";
		$corps .= "<br><br>";
		
		if ( $_SESSION[ "franchise" ][ "is_franchise" ] ) $corps .= "L\'équipe " . $_SESSION[ "site" ][ "signature" ];
		else $corps .= "L'équipe restomalin.com.";
		
		$corps = utf8_decode( $corps );
		//echo $corps . "<br>";
		
		// Envoi du mail
		if ( $_to != '' ) _nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );
		
		// Mails aux collègues
		if ( !$debug ) {
			
			$_to = "maurice@restomalin.com";
			_nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );
			
			$_to = "jean-luc@restomalin.com";
			_nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );

			$_to = "manu@restomalin.com";
			_nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );

			$_to = "olivier@restomalin.com";
			$retour = _nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );

			$_to = "anais@restomalin.com";
			$retour = _nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );

			$_to = "stephanie@restomalin.com";
			$retour = _nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );

			$_to = "damien@restomalin.com";
			$retour = _nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );

		}
		
		$erreur = ( $retour ) ? "false" : "true";
		$texte = ( $retour )
			? "Votre demande a bien été prise en compte."
			: "Une erreur est survenue.<br />Veuillez ré-essayer ultérieurement.";
	}
	
	// Formulaire de contact SIMPLE
	else if ( $_GET[ "mon_action" ] == "contact-simple" ) {
		//echo "Contact simple...<br>";
		//print_pre( $_POST );
		
		// ---- Chargement du restaurant en cours ----- //
		$restaurant = new restaurant();
		$restaurant->load( $_SESSION[ "site" ][ "num_restaurant" ] );
		
		// ---- Préparation du mail ------------------- //
		if ( 1 == 1 ) {
			$sujet = "Formulaire de contact";
			
			$sender = "feedback@restomalin.com";
			$sender_label = ( $_SESSION[ "vit" ][ "is_vitrine" ] || $_SESSION[ "franchise" ][ "is_franchise" ] ) ? $_SESSION[ "site" ][ "signature" ] : "Restomalin";
			//echo "--- sender_label / sender : " . $sender_label . " / " . $sender . "<br>";
			
			$corps = "Bonjour,<br><br>";
			$corps .= "Un formulaire de contact vient d'être posté :<br><br>";
			$corps .= "Sujet : <b>" . $_POST[ "sujet" ] . "</b><br>";
			$corps .= "Nom : <b>" . $_POST[ "nom" ] . "</b><br>";
			$corps .= "Mail : <b>" . $_POST[ "mail" ] . "</b><br>";
			$corps .= "Message : <br><i>" . $_POST[ "message" ] . "</i><br><br>";
			$corps .= "A bientôt.<br><br>";
			$corps .= "<br><br>";
			$corps .= ( $_SESSION[ "vit" ][ "is_vitrine" ] || $_SESSION[ "franchise" ][ "is_franchise" ] ) ? "L\'équipe " . $_SESSION[ "site" ][ "signature" ] : "L'équipe restomalin.com.";
			$corps = utf8_decode( $corps );
			//echo $corps . "<br>";
		}
		// -------------------------------------------- //
		
		// ---- Envoi du mail ------------------------- //
		if ( 1 == 1 ) {
			
			// ---- Envoi du mail au patron du restaurant
			$_to = $restaurant->email;
			$_to = "olivier@restomalin.com";
			//echo "--- To : " . $restaurant->email . "<br>";
			if ( $_to != '' ) $retour = _nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );
			
			// ---- Mails aux collègues
			if ( !$debug ) {
				
				$_to = "maurice@restomalin.com";
				_nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );
				
				$_to = "jean-luc@restomalin.com";
				_nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );
	
				$_to = "manu@restomalin.com";
				_nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );
	
				$_to = "olivier@restomalin.com";
				$retour = _nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );

				$_to = "anais@restomalin.com";
				$retour = _nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );

				$_to = "stephanie@restomalin.com";
				$retour = _nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );

				$_to = "damien@restomalin.com";
				$retour = _nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );

			}
			
			$erreur = ( $retour ) ? "false" : "true";
		}
		// -------------------------------------------- //
		
		$texte = ( $retour )
			? "Votre demande a bien été prise en compte."
			: "Une erreur est survenue.<br />Veuillez ré-essayer ultérieurement.";
	}
	
	// Demande de rappel
	else if ( $_GET[ "mon_action" ] == "rappel" ) {
		//echo "Demande de rappel...<br>";
		
		$commande = new commande();
		$commande->gererDonnee( $_POST, false );
		
		// Préparation du mail
		if ( $_SESSION[ "franchise" ][ "is_franchise" ] ) $sujet = "Demande de rappel " . $_SESSION[ "franchise" ][ "is_franchise" ];
		else $sujet = "Demande de rappel";
		
		$sender = "feedback@restomalin.com";
		
		if ( $_SESSION[ "franchise" ][ "is_franchise" ] ) $sender_label =  $_SESSION[ "franchise" ][ "is_franchise" ];
		else $sender_label = "Restomalin";
		
		//echo "--- sender_label / sender : " . $sender_label . " / " . $sender . "<br>";
		
		$_to = "olivier@restomalin.com";
		//echo "--- To : " . $_to . "<br>";
		
		$corps = "Bonjour,<br><br>";
		$corps .= "Une demande de rappel vient d'être faite :<br /><br />";
		$corps .= "Téléphone : <b>" . traiter_champ_telephone( $_POST[ "tel" ] ) . "</b><br />";
		$corps .= "IP : " . $_SERVER[ 'REMOTE_ADDR' ] . "<br /><br />";
		$corps .= "A bientôt.<br><br>";
		$corps .= "<br><br>";
		$corps .= "L'équipe restomalin.com.";
		$corps = utf8_decode( $corps );
		//echo $corps . "<br>";
		
		// Envoi du mail
		$retour = _nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );
		$erreur = ( $retour ) ? "false" : "true";
		$texte = ( $retour )
			? "Votre demande a bien été prise en compte."
			: "Une erreur est survenue.<br />Veuillez ré-essayer ultérieurement.";
		
		// Mails aux collègues
		if (( !$debug ) && ( $_SERVER[ "REMOTE_ADDR" ] == 'restomalin.com' )) {
			
			$_to = "maurice@restomalin.com";
			_nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );
			
			$_to = "jean-luc@restomalin.com";
			_nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );
			
			$_to = "manu@restomalin.com";
			_nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );

			$_to = "anais@restomalin.com";
			_nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );

			$_to = "stephanie@restomalin.com";
			_nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );

			$_to = "damien@restomalin.com";
			_nmail( $_to, $sujet, stripslashes( $corps ), $sender, $sender_label );

		}
	}
	
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
		
		<title>Formulaire terminé</title>
		
		<link rel="stylesheet" href="/css/style.css<?=$cache?>">
		<link rel="stylesheet" href="/css/style_bis.css<?=$cache?>">
		<link rel="stylesheet" href="/css/forms.css<?=$cache?>">
		<link rel="stylesheet" type="text/css" href="/css/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
		
		<!-- plugins, script et CSS liées -->
		<link rel="stylesheet" href="/css/anythingslider.css<?=$cache?>">
		
		
		<!--[if IE]>
		<link rel="stylesheet" href="/css/ie8.css<?=$cache?>">
		<![endif]-->
		
		<!-- fontes -->
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
		echo "				    <span itemprop='title' class='crumb'>" . utf8_encode( $sujet ) . "</span>\n";
		echo "				</div>  \n";
		echo "			</div>\n";
		echo "		</div>\n";
		echo "		<div id='content' class='inner'>\n";
		echo "			<div id='col-unique-contenu'>\n";
	}
	?>
	
			<div id="info-gal">
				<fieldset>
					<legend>
						<h2><?=utf8_encode( $sujet )?></h2>
					</legend>
					
					<?
					// Dans une LightBox
					if ( $lightbox ) {
						
						// Pas de redirection...
						if ( $lien_retour == '' ) {
							?>
							<p style="margin-top:25px; height:250px;">
								<?=$texte?><br />
								Vous pouvez maintenant fermer cette fenêtre.
							</p>
							
							<input type="button" class="btn fermer" value="Fermer">
							<?
						}
						
						// Retour vers le résumé de commande
						else if ( $lien_retour == 'crc' ) {
							?>
							<p style="margin-top:25px; height:250px;">
								<?=$texte?><br />
								Vous allez être redirigé vers le résumé de votre commande.
							</p>
							
							<input type="button" class="btn resume" value="Suivant">
							<?
						}
					}
					
					// HORS lightbox
					else {
						?>
						<p style="margin-top:25px; height:250px;">
							<?=$texte?><br />
						</p>
						
						<input type="button" class="btn accueil" value="Accueil">
						<?
					}
					?>
				</fieldset>
			</div>
		
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
	
	<script>
		
		// AnythingSlider initialization
		$('#caroussel-atouts').anythingSlider();
		
		// Clic sur une question
		$( ".depliable" ).click(function() {
			var val = $(this).attr( "id" );
			if ( $( "#contenu_" + val ).css( "display" ) == 'none' ) $( "#contenu_" + val ).fadeIn( 'fast' );
			else $( "#contenu_" + val ).fadeOut( 'fast' );
		});
		
		// DOM Ready
		$(function(){
			
			$( ".fermer" ).click(function() {
				//alert( "click..." );
				parent.$.fancybox.close();
			});
			
			$( ".resume" ).click(function() {
				//alert( "click..." );
				window.location.href = "/commande/commande_resume_commande.php";
			});
			
			$( ".accueil" ).click(function() {
				//alert( "click..." );
				window.location.href = "/index.php";
			});
			
			<?
			// Retour vers le résumé de commande
			if ( $lien_retour == 'crc' ) {
				?>
				setTimeout( "window.location.href = '/commande/commande_resume_commande.php'", 3000);
				<?
			}
			?>
			
		});
		
	</script>

</html>
<? include_once( "../include_connexion/connexion_site_off.php" ); ?>