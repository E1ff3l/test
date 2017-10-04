	// --------- Changement de mode de fonctionnement ------------------------- //
	$( "#choix-livraison" ).click( function() {
		window.location.href = $( "#url_livraison" ).val();
	});
	$( "#choix-emporter" ).click( function() {
		window.location.href = $( "#url_ae" ).val();
	});
	// ------------------------------------------------------------------------ //
	
	// Liste des quartiers dépliable
	$('#changer-quartier ul').hideMaxListItems({
		'max':4, 
		'speed':500, 
		'moreHTML':'<p class="maxlist-more"><a href="#" title="Tout voir">Voir la liste...</a></p>',
		moreText:'Voir la liste...',
		lessText:'Cacher la liste',
	});
	
	// Liste des catégories dépliables
	$('.changer-categorie ul').hideMaxListItems({
		'max':4, 
		'speed':500, 
		'moreHTML':'<p class="maxlist-more"><a href="#" title="Tout voir">...</a></p>',
		moreText:'...',
		lessText:'cacher la liste',
	});
	
	// Liste des catégories dépliables (Liste des catégories disponibles, zone centrale)
	$('.plat ul').hideMaxListItems({
		'max':4, 
		'speed':500, 
		'moreHTML':'<p class="maxlist-more" style="margin-left:10px;"><a href="#" title="Tout voir">...</a></p>',
		moreText:'Voir la suite de la liste...',
		lessText:'cacher la liste',
	});
	
	$('#slider-thematiques').anythingSlider({ 
		expand              : false,     // If true, the entire slider will expand to fit the parent element 
		resizeContents      : true,      // If true, solitary images/objects in the panel will expand to fit the viewport 
		showMultiple        : false,     // Set this value to a number and it will show that many slides at once 
		easing              : "swing",   // Anything other than "linear" or "swing" requires the easing plugin or jQuery UI 
		
		buildArrows         : false,      // If true, builds the forwards and backwards buttons 
		buildNavigation     : false,      // If true, builds a list of anchor links to link to each panel 
		buildStartStop      : false,      // If true, builds the start/stop button 
		
		// Navigation 
		startPanel          : 1,         // This sets the initial panel 
		changeBy            : 1,         // Amount to go forward or back when changing panels. 
		hashTags            : false,      // Should links change the hashtag in the URL? 
		infiniteSlides      : true,      // if false, the slider will not wrap & not clone any panels 
		navigationFormatter : null,      // Details at the top of the file on this use (advanced use) 
		navigationSize      : false,     // Set this to the maximum number of visible navigation tabs; false to disable 
		
		// Slideshow options 
		autoPlay            : true,     // If true, the slideshow will start running; replaces "startStopped" option 
		pauseOnHover        : true,      // If true & the slideshow is active, the slideshow will pause on hover 
		
		// Times 
		delay               : 5000,      // How long between slideshow transitions in AutoPlay mode (in milliseconds) 
		resumeDelay         : 15000,     // Resume slideshow after user interaction, only if autoplayLocked is true (in milliseconds). 
		animationTime       : 600,       // How long the slideshow transition takes (in milliseconds) 
		delayBeforeAnimate  : 0,         // How long to pause slide animation before going to the desired slide (used if you want your "out" FX to show). 
	});

	// Slideshow init (fade)
	$('#slideshow').fadeSlideShow();
	
	// TruncateText init
	$('.commentaire').truncate( {  
		length: 200,  
		minTrail: 40,  
		moreText: '› Lire la suite',  
		lessText: '› Replier',
		ellipsisText: '...'  
	}); 
	
	// topLink init
	$('#lien-panier').topLink({
		min: 430,
		fadeSpeed: 300
	});
	
	// smoothscroll
	$('#lien-panier').click(function(e) {
		e.preventDefault();
		$.scrollTo(180,600);
	});
	
	// Tooltip picto Vazee
	$( ".picto-vazee" ).tooltipster({
	    animation: 	'fade',
	    arrow: 		'true',
	    position:	'top'
	});
	
	// Tooltip paiement
	$('#lien-moyens-paiement').tooltipster({
	    animation: 	'fade',
	    arrow: 		'true',
	    position:	'right'
	});
	
	// Tooltip catégorie
	$('.lien-categorie').tooltipster({
	    animation: 	'fade',
	    arrow: 		'true',
	    position:	'right'
	});
	
	// -------------- Gestion des avis ---------------------------------------- //
	$( ".detail" ).click(function() {
		var val = $(this).attr( "id" );
		
		$( "#avis_recursif_" + val ).fadeIn();
		$( "#detail_" + val).hide();
		$( "#cacher_" + val).show();
		
		return false;
	});
	
	$( ".cacher" ).click(function() {
		var val = $(this).attr( "id" );
		
		$( "#avis_recursif_" + val ).fadeOut();
		$( "#cacher_" + val).hide();
		$( "#detail_" + val).show();
		
		return false;
	});
	
	// ------------------------------------------------------------------------ //
	
	// -------------- Gestion des suppléments --------------------------------- //
	$( ".ouvrir" ).click(function() {
		//alert( ".ouvrir..." );
		var id_a = $(this).attr( "id" );
		if ( $( "#radio_" + id_a + ":checked" ).val() > 0 ) {
			//alert( "radio_" + id_a + " ..." );
			var id_i = $( "#radio_" + id_a + ":checked" ).val();
		}
		else {
			//alert( "select_" + id_a + " ..." );
			var id_i = $( "#select_" + id_a ).val();
		}
		//alert( "Ouverture de #" + id_a );
		//alert( id_i );
		
		// On déroule les suppléments
		if ( !$( "#div_element_" + id_a ).is( ":visible" ) ) {
			//alert( id_a + " / " + id_i );
			
			// Mise en attente...
			$( "#div_element_" + id_a ).html( "<img src='/img/ajax-loader.gif' alt='En cours de chargement...' border='0' />" );
			$( "#div_element_" + id_a ).show();
			
			// Affichage des suppléments
			afficherSupplement( id_a, id_i );
		}
		// On re-roule...
		else {
			$( "#div_element_" + id_a ).fadeOut();
		}
		
		return false;
	});
	
	// Changement d'éléments dans une liste déroulante
	$( ".option_select" ).change( function() {
		//alert( "changement de option_select..." );
		var id_a = $( this ).attr( "id" ).replace( "select_", "" );
		var id_i = $( this ).val();
		
		// Le DIV des suppléments existe
		if ( $( "#div_element_" + id_a ).is( ":visible" ) ) {
			//alert( id_a + " / " + id_i );
			
			// Mise en attente...
			$( "#div_element_" + id_a ).html( "<img src='/img/ajax-loader.gif' alt='En cours de chargement...' border='0' />" );
			
			// Affichage des suppléments
			afficherSupplement( id_a, id_i );
		}
	});
	// ------------------------------------------------------------------------ //
	
	// Affichage du panier
	refresh_panier();
	
	// Validation de la commande
	$( ".btn-valider" ).click( function() {
		//alert( "Validation de la commande..." );
		
		clearInterval( jeclignote );
		$( ".clignote" ).fadeIn();
	});
	
	// ---------- On fait clignoter ------------------------------------------- //
	var jeclignote = setInterval( function() {
		$( ".clignote" ).fadeOut( 900 ).delay( 300 ).fadeIn( 800 );
	}, 2200);
	// ------------------------------------------------------------------------ //
	
	
	function afficher_pourquoi() {
		$.fancybox({
			'width'				: 700,
			'height'			: 400,
			'autoScale'			: false,
			'type'				: 'iframe',
			'href' 				: '/divers/pourquoi.php',
		});
	}
	
	//afficher_pourquoi();
	$( ".pourquoi" ).click(function() {
		afficher_pourquoi();
	});
	
	$( ".conteneur_menu_fidelite" ).click(function() {
		var _url = $(this).find( "a" ).attr( "href" );
		//alert( "Redirection vers " + _url );
		
		$.scrollTo( 0, 600 );
		
		$.fancybox({
			'width'				: 700,
			'height'			: 650,
			'autoScale'			: false,
			'type'				: 'iframe',
			'href' 				: _url,
		});
		
		return false;
	});
	
	$( ".conteneur_menu" ).click(function() {
		var _url = $(this).find( "a" ).attr( "href" );
		//alert( "Redirection vers " + _url );
		
		$.scrollTo( 0, 600 );
		
		$.fancybox({
			'width'				: 700,
			'height'			: 650,
			'autoScale'			: false,
			'type'				: 'iframe',
			'href' 				: _url,
		});
		
		return false;
	});
	