	
	// --------- Listes dépliables ------------------------------- //
	$( ".deroulable" ).hideMaxListItems({
		'max':		7, 
		'speed':	500, 
		'moreHTML':	'<p class="maxlist-more"><a href="#" title="Tout voir">Voir toute la liste</a></p>',
		moreText:	'Voir toute la liste',
		lessText:	'cacher la liste',
	});
	// ----------------------------------------------------------- //
	
	$( "#postcode" ).keyup(function(e) {
		if( e.keyCode == 13 ) {
			afficherLB();
		}
	});
	
	$( "#main-form" ).submit(function(event) {
	    event.preventDefault();
	    //alert( "Submit evité!" );
	    
	    return false;
	});
	
	$( "#main-form-simple" ).submit(function(event) {
	    event.preventDefault();
	    return false;
	});
	
	$( ".mode_fonctionnement" ).click( function() {
		//alert( "coche : " + $( "input[type=radio][name=mode_fonctionnement]:checked" ).attr( "value" ) );
		
		// Modification de l'URL
		var coche = $( "input[type=radio][name=mode_fonctionnement]:checked" ).attr( "value" );
		
		// ---- Si passage en AE, alors on cache le code postal (Sinon, on l'affiche!)
		if ( coche == "ae" ) {
			$( "#div_categorie_livraison" ).hide();
			$( "#div_categorie_ae" ).fadeIn();
			$( "#postcode" ).fadeOut();
			
			if ( $( "#url" ).val() != '' ) _url_livraison = $( "#url" ).val();
			$( "#url" ).val( _url_ae );
			_ville_livraison = $( "#num_ville" ).val();
			$( "#num_ville" ).val( _ville_ae );
		}
		else {
			$( "#div_categorie_ae" ).hide();
			$( "#div_categorie_livraison" ).fadeIn();
			$( "#postcode" ).fadeIn();
			
			$( "#url" ).val( _url_livraison );
			$( "#num_ville" ).val( _ville_livraison );
		}
		
		$( "#fonctionnement" ).val( coche );
		//$( "#url" ).val( _url );
	});
	
	$( ".label_mode_fonctionnement" ).click( function() {
		var val = $(this).attr( "val" );
		$( "#" + val ).attr( 'checked','checked' );
		
		// Modification de l'URL
		var coche = $( "input[type=radio][name=mode_fonctionnement]:checked" ).attr( "value" );
		
		// ---- Si passage en AE, alors on cache le code postal (Sinon, on l'affiche!)
		if ( coche == "ae" ) {
			$( "#div_categorie_livraison" ).hide();
			$( "#div_categorie_ae" ).fadeIn();
			$( "#postcode" ).fadeOut();
			if ( $( "#url" ).val() != '' ) _url_livraison = $( "#url" ).val();
			$( "#url" ).val( _url_ae );
			_ville_livraison = $( "#num_ville" ).val();
			$( "#num_ville" ).val( _ville_ae );
		}
		else {
			$( "#div_categorie_ae" ).hide();
			$( "#div_categorie_livraison" ).fadeIn();
			$( "#postcode" ).fadeIn();
			$( "#url" ).val( _url_livraison );
			$( "#num_ville" ).val( _ville_livraison );
		}
		
		$( "#fonctionnement" ).val( coche );	
		//$( "#url" ).val( _url );
		
		return false;
	});
	
	$( "#postcode" ).autocomplete({
		source : function( request, response ) {
			$.post( "/ajax/ajax_liste_ville_universel.php", 
			{
				m: 			$( "input[type=radio][name=mode_fonctionnement]:checked" ).attr( "value" ),
				m_bis: 		$( "#fonctionnement" ).val(),
				term:		encodeURIComponent( $( "#postcode" ).val() )
			}, function( data ) 
			{
				response( data )
			}, 'json' );
		},
		minLength: 1,
		response: function( event, ui ) {
			$( "#url" ).val( '' );
		},
		focus: function( event, ui ) {
			$( "#postcode" ).val( ui.item.label );
			$( "#url" ).val( ui.item.url );
			$( "#num_ville" ).val( ui.item.num_ville );
			return false;
		},
		select: function( event, ui ) {
			$( "#postcode" ).val( ui.item.label );
			$( "#url" ).val( ui.item.url );
			
			$.ajax({ 
				type: "POST", 
				url: "/ajax/ajax_divers.php?task=set-ville-temp", 
				data: {
					num_ville_temp:		ui.item.num_ville
				},
				error: function() { alert( "Une erreur est survenue..." ); },
				success: function( retour ){ 
					//alert("Donnees obtenues : " + retour ); 
					var obj = $.parseJSON( retour );
					
					//alert( "#" + ui.item.num_ville + " : " + ui.item.url );
					window.location.href = ui.item.url;
				}
			});
			return false;
		}
	});
	
	$( "#postcode" ).click(function() {
		$( "#postcode" ).val( '' );
		//$( "#url" ).val( '' );
		//$( "#num_ville" ).val( '' );
	});
	
	$( "#btn-voir" ).click( function() {
		
		// URL déjà présente --> Redirection
		if ( $( "#url" ).val() != '' ) {
			
			$.ajax({ 
				type: "POST", 
				url: "/ajax/ajax_divers.php?task=set-ville-temp", 
				data: {
					num_ville_temp:		$( "#num_ville" ).val()
				},
				error: function() { alert( "Une erreur est survenue..." ); },
				success: function( retour ){ 
					//alert("Donnees obtenues : " + retour ); 
					var obj = $.parseJSON( retour );
					
					//alert( "Redirection vers " + $( "#url" ).val() );
					window.location.href = $( "#url" ).val();
				}
			});
			return false;
		}
		
		// Pas encore d'URL --> Affichage du LightBox
		else {
			afficherLB();
		}
	});
	
	$( "#btn-carte-viti" ).click( function() {
		//alert( "Redirection vers " + $( "#url" ).val() );
		
		$.ajax({ 
			type: "POST", 
			url: "/ajax/ajax_divers.php?task=set-ville-temp", 
			data: {
				num_ville_temp:		$( "#num_ville" ).val()
			},
			error: function() { alert( "Une erreur est survenue..." ); },
			success: function( retour ){ 
				//alert("Donnees obtenues : " + retour ); 
				var obj = $.parseJSON( retour );
				
				window.location.href = $( "#url" ).val();
			}
		});
		return false;
	});
	
	// intégration placeholder IE + Opera
	if( !$.support.placeholder ) { 
		var active = document.activeElement;
		$(':text').focus(function () {
			if ($(this).attr('placeholder') != '' && $(this).val() == $(this).attr('placeholder')) {
				$(this).val('').removeClass('hasPlaceholder');
			}
		}).blur(function () {
			if ($(this).attr('placeholder') != '' && ($(this).val() == '' || $(this).val() == $(this).attr('placeholder'))) {
				$(this).val($(this).attr('placeholder')).addClass('hasPlaceholder');
			}
		});
		$(':text').blur();
		$(active).focus();
		$('form').submit(function () {
			$(this).find('.hasPlaceholder').each(function() { $(this).val(''); });
		});
	}
	