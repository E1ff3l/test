	// --------- Permet la remontée en haut de page --------------------------- //
	$('.go_up').click(function(e) {
		e.preventDefault();
		$.scrollTo( 0, 600 );
	});
	// ------------------------------------------------------------------------ //
	
	// --------- Liste des quartiers dépliables ------------------------------- //
	$('#changer-ville ul').hideMaxListItems({
		'max':		16, 
		'speed':	500, 
		'moreHTML':	'<p class="maxlist-more"><a href="#" title="Tout voir">Voir toute la liste</a></p>',
		moreText:	'Voir toute la liste',
		lessText:	'cacher la liste',
	});
	// ------------------------------------------------------------------------ //
	
	// --------- Liste des chefs-lieux dépliables ------------------------------- //
	$('#changer-chef-lieu ul').hideMaxListItems({
		'max':		11, 
		'speed':	500, 
		'moreHTML':	'<p class="maxlist-more"><a href="#" title="Tout voir">Voir toute la liste</a></p>',
		moreText:	'Voir toute la liste',
		lessText:	'cacher la liste',
	});
	// ------------------------------------------------------------------------ //

	// --------- Liste des quartiers dépliables ------------------------------- //
	/*$('#changer-quartier ul').hideMaxListItems({
		'max':4, 
		'speed':500, 
		'moreHTML':'<p class="maxlist-more"><a href="#" title="Tout voir">…</a></p>',
		moreText:'…',
		lessText:'cacher la liste',
	});*/
	// ------------------------------------------------------------------------ //
			
	// --------- Liste des nouveaux restos dépliables ------------------------- //
	$('#nouveau-restaurant ul').hideMaxListItems({
		'max':		7, 
		'speed':	500, 
		'moreHTML':	'<p class="maxlist-more"><a href="#" title="Tout voir">Voir toute la liste</a></p>',
		moreText:	'Voir toute la liste',
		lessText:	'cacher la liste',
	});
	// ------------------------------------------------------------------------ //
	
	// AnythingSlider init
	$('#caroussel-atouts').anythingSlider();
	
	// ---------- Apple? On change la classe CSS ------------------------------ //
	var uagent = navigator.userAgent.toLowerCase();
	//alert( uagent );
	
	var deviceIphone = "iphone";
	var deviceIpad = "ipad";
	var deviceIpod = "ipod";
	
	// Modification à la volée des classes
	if ( uagent.search( deviceIphone ) > -1 ||  uagent.search( deviceIpad ) > -1 ||  uagent.search( deviceIpod ) > -1 ) {
		$( ".offert" ).removeClass( "iframe_creation" ).addClass( "iframe_creation_ipad" );
		$( ".validation" ).removeClass( "iframe_creation" ).addClass( "iframe_creation_ipad" );
		$( ".ajouter_menu" ).removeClass( "iframe_creation" ).addClass( "iframe_creation_ipad" );
	}
	// ------------------------------------------------------------------------ //
	
	function afficher_cp( num_cat, page_redirection, is_modal ) {
		//alert( "Affichage CP" );
		//alert( "Affichage CP : " + num_cat + " / " + page_redirection );
		
		// ---- En mode "AE", on passe directement sur l'url du lien ---------- //
		if ( $( "#fonctionnement" ).val() == 'ae' && page_redirection != '' ) {
			//alert( "Redirection directe ..." );
			if ( page_redirection != '' ) {
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
						
						//alert( page_redirection );
						window.location.href = page_redirection;
					}
				});
				return false;
			}
		}
		
		// ---- En mode "L", on passe par la page d'auto-complétion ----------- //
		else {
			var fonctionnement = $( "#fonctionnement" ).val();
			var num_restaurant = $( "#num_restaurant" ).val();
			
			$.ajax({ 
				type: "POST", 
				url: "/ajax/ajax_divers.php?task=get-ville-temp", 
				data: {
					fonctionnement:		fonctionnement,
					num_restaurant:		num_restaurant,
					page_redirection:	page_redirection,
					num_cat:			num_cat
				},
				error: function() { alert( "Une erreur est survenue..." ); },
				success: function( retour ){ 
					//alert("Donnees obtenues : " + retour ); 
					var obj = $.parseJSON( retour );
					
					// ---- Pas de ville --> Affichage lightbox ----------------- //
					if ( !obj.hasVilleTemp ) {
						var page = "/auto_completion.php";
						page += "?f=" + fonctionnement;
						page += "&nr=" + num_restaurant;
						page += "&nc=" + num_cat;
						//alert( page );
						
						$.fancybox({
							'width'				: 300, //300
							'height'			: 300, //220
							'autoScale'			: false,
							'type'				: 'iframe',
							'modal'				: is_modal,
							'href' 				: page,
						});
					}
					// ---------------------------------------------------------- //
					
					// ---- Ville de livraison déjà présente -------------------- //
					else {
						//alert( "Redirection vers " + obj.lien );
						window.location.href = obj.lien;
					}
					// ---------------------------------------------------------- //
					
				}
			});
		}
	}
	
	$( ".afficher_cp" ).click(function() {
		//alert( "Affichage CP" );
		var page = 		$(this).attr( "href" );
		var num_cat = 	$(this).attr( "data-cat" );
		afficher_cp( num_cat, page, '', false );
		return false;
	});
	
	$( ".set-temp" ).click(function() {
		//alert( "Set temp..." );
		var num_ville_temp = $(this).attr( "data-ville" );
		var page = $(this).attr( "href" );
		
		$.ajax({ 
			type: "POST", 
			url: "/ajax/ajax_divers.php?task=set-ville-temp", 
			data: {
				num_ville_temp:		num_ville_temp
			},
			error: function() { alert( "Une erreur est survenue..." ); },
			success: function( retour ){ 
				parent.location.href = page;
			}
		});
		
		return false;
	});
				