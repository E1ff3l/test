<?
	//print_pre( $_SERVER );
	$page = ( $_SESSION[ "domaine" ][ "protocole" ] != '' )
		? $_SESSION[ "domaine" ][ "protocole" ] . "://" . $_SERVER[ "SERVER_NAME" ] . "/m/"
		: "https://" . $_SERVER[ "SERVER_NAME" ] . "/m/";
	//echo "--->" . $page;
	
	//print_pre( $_SESSION[ "general" ] );
	
	echo "<script>\n";
	echo "	var page = '" . $page . "';\n";
	
	// Texte personnalisé pour la redirection vers la zone mobile
	if ( $_SESSION[ "domaine" ][ "num_domaine" ] > 0 ) echo "	var texte_confim = 'Voulez-vous utiliser la version mobile du site?';\n";
	else echo "	var texte_confim = 'Voulez-vous utiliser la version mobile de restomalin.com?';\n";
	
	//echo "alert( 'test_mobile : " . $_SESSION[ "general" ][ "test_mobile" ] . "' );";
	
	echo "</script>\n";
	
	// ---- On ne fait le test qu'une seule fois...
	//unset( $_SESSION[ "general" ][ "test_mobile" ] );
	if ( !isset( $_SESSION[ "general" ][ "test_mobile" ] ) ) {
		echo "<script type='text/javascript' src='/js/mobile-redirection.js'></script>\n";
		
		// ---- On n'autorise pas pour le moment la redirection vers le site mobile pour les franchises
		if ( !$_SESSION[ "franchise" ][ "is_franchise" ] ) {
			
			echo "<script>\n";
			//echo "	alert( 'Test redirection...' );\n";
			//echo "										je_redirige( 0, 'TEST', page );\n";
			echo "	if ( DetectIphoneOrIpod() ) 		je_redirige( 1, 'IPhone/Ipod', page );\n";
			echo "	else if ( DetectS60OssBrowser() )	je_redirige( 2, 'S60', page );\n";
			echo "	else if ( DetectAndroid() ) 		je_redirige( 3, 'Android', page );\n";
			echo "	else if ( DetectAndroidWebKit() ) 	je_redirige( 4, 'Android + WK', page );\n";
			echo "	else if ( DetectWindowsMobile() ) 	je_redirige( 5, 'WindowsMobile', page );\n";
			echo "	else if ( DetectBlackBerry() ) 		je_redirige( 6, 'BlackBerry', page );\n";
			echo "	else if ( DetectPalmOS() ) 			je_redirige( 7, 'PalmOS', page );\n";
			echo "</script>\n";
		}
	}
	
	// ---- Redirection DÉJÀ proposée ET acceptée --> On redirige directement
	else if ( $_SESSION[ "general" ][ "test_mobile" ] ) {
		echo "<script>\n";
		//echo "	alert( 'Redirection déjà faite!' );\n";
		echo "										window.location.href = page\n";
		echo "</script>\n";
	}
?>