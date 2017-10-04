	
	$( ".redirection" ).click( function() {
		var page = $(this).attr( "href" );
		//alert( "Redirection vers " + page  );
		
		$.ajax({
			type: 		"POST",
			url: 		"/ajax/ajax_divers.php?task=choisir_support",
			data: 		'',
			success: 	function( data ){
				window.location.href = page;
			}
		});
		
		return false;	
	});
	
	// Slideshow init (fade)
	jQuery( "#slideshow" ).fadeSlideShow();
	
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
	
	$( ".mode_fonctionnement" ).click( function() {
		
		// Modification de l'URL
		var coche = $( "input[type=radio][name=mode_fonctionnement]:checked" ).attr( "value" );
		var _url = ( coche == 'l' )
			? $( "#url" ).val().replace( "a-emporter", "livraison" )
			: $( "#url" ).val().replace( "livraison", "a-emporter" );
		$( "#url" ).val( _url );
	});
	
	$( ".label_mode_fonctionnement" ).click( function() {
		var val = $(this).attr( "val" );
		$( "#" + val ).attr( 'checked','checked' );
		
		// Modification de l'URL
		var coche = $( "input[type=radio][name=mode_fonctionnement]:checked" ).attr( "value" );
		var _url = ( coche == 'l' )
			? $( "#url" ).val().replace( "a-emporter", "livraison" )
			: $( "#url" ).val().replace( "livraison", "a-emporter" );
		$( "#url" ).val( _url );
		//alert( "--> " + coche + " / " + _url );
		
		return false;
	});
	
	$( "#postcode" ).autocomplete({
		source: "/ajax/ajax_liste_ville.php?m=" + $( "input[type=radio][name=mode_fonctionnement]:checked" ).attr( "value" ),
		minLength: 1,
		response: function( event, ui ) {
			$( "#url" ).val( '' );
		},
		focus: function( event, ui ) {
			$( "#postcode" ).val( ui.item.label );
			return false;
		},
		select: function( event, ui ) {
			var coche = $( "input[type=radio][name=mode_fonctionnement]:checked" ).attr( "value" );
			var _url = ( coche == 'l' )
				? ui.item.url.replace( "a-emporter", "livraison" )
				: ui.item.url.replace( "livraison", "a-emporter" );
			
			$( "#postcode" ).val( ui.item.label );
			$( "#url" ).val( _url );
			
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
					
					window.location.href = _url;
					//alert( "#" + ui.item.num_ville + " : " + ui.item.url );
				}
			});
			
			//window.location.href = _url;
			//alert( "SELECT : " + coche + " / " + _url );
			return false;
		}
	});
	
	$( "#postcode" ).click(function() {
		$( "#postcode" ).val( '' );
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
			
			//alert( "Redirection vers " + $( "#url" ).val() );
			//window.location.href = $( "#url" ).val();
		}
		
		// Pas encore d'URL --> Affichage du LightBox
		else {
			afficherLB();
		}
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
	