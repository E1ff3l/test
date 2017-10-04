	
	var largeur = $( "body" ).css( "width" ).replace( "px", "" );
	//alert( largeur );
	if ( largeur < 1000 ) {
		$( "body" ).css( "width", "1000px" );
		$( "#smartbanner" ).css( "width", "1000px" );
	}

$.smartbanner({ 
	daysHidden: 		0, 
	daysReminder: 		0,
	title:				'Appli Restomalin',
	author:				'Restomalin',
	price: 				'Disponible', 
	inAppStore: 		'sur l\'App Store', 
	inGooglePlay: 		'sur Google Play', 
	inWindowsStore: 	'sur Windows Store', 
	appStoreLanguage:	'fr', 
	icon:				'https://restomalin.com/img/logo_appli.png',
	button: 			'Ouvrir', 
	iOSUniversalApp: 	true, 
	force: 				null
	//force: 				'android'
});
//alert( "On lance smartbanner!" );