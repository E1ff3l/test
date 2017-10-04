<? include_once( $_SERVER['DOCUMENT_ROOT'] . "/classes/config_v2.php" ); ?>
<? include_once( $_SERVER['DOCUMENT_ROOT'] . "/classes/classes.php" ); ?>
<? include_once( $_SERVER['DOCUMENT_ROOT'] . "/include_connexion/connexion_site_on.php" ); ?>
<? include_once( $_SERVER['DOCUMENT_ROOT'] . "/includes/information.php" ); ?>
<?
	// ---- Chargement de la bonne page ( Page "RM" classique / Page "Universelle" / Page spécifique ) ------ //
	include_once( $_SERVER['DOCUMENT_ROOT'] . "/includes/chargement_page.php" );
	$page = charger_page( 
		$_SERVER['DOCUMENT_ROOT'] . "/divers/plan_du_site_restomalin.php", 
		$_SERVER['DOCUMENT_ROOT'] . "/divers/plan_du_site_universel.php", 
		"-"
	);
	include_once( $page );
	// ------------------------------------------------------------------------------------------------------ //
?>