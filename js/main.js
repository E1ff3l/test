var TimeOut;

function refresh_menu() {
	//alert( "refresh_menu..." );
	
	$.ajax({
		type: "POST",
		cache: false,
		url: '/includes/menu_connexion.php',
		error: function() { alert( "Une erreur s'est produite..." ); },
		success: function( data ){
			$( '#liens-utiles' ).html( data );
		}
	});
}

function refresh_panier() {
	//alert( "refresh_panier... #" + $( "#num_restaurant" ).val() );
	
	$.ajax({
		type: 		"POST",
		url: 		"/ajax/ajax_panier.php?task=showPanier",
		data: { num_restaurant: $( "#num_restaurant" ).val() },
		success: 	function( data ){
			//alert( data );
			
			// ---- Traitement de la réponse
			var tab = data.split("#@#");
			
			// ---- Tout s'est bien passé!
			if ( tab[ 0 ] == "ok" ) {
				$( "#mon_panier" ).html( tab[ 1 ] );
				
				// ---- MAJ des frais de livraison
				//alert( "FdL : " + tab[ 5 ] );
				$( ".li_frais_livraison" ).html( tab[ 5 ] + " €" );
				
				// ---- tooltip "détail article"
				$('.detail_article').tooltipster({
				    animation: 	'fade',
				    arrow: 		'true',
				    position:	'right'
				});
				
				// ---- On cache tous les boutons
				$( ".suite" ).hide();
				$( ".art_offert_promo" ).hide();
				$( ".art_offert" ).hide();
				//alert( tab[ 2 ] );
				
				// ---- Bouton "Article offert ( Promotion )"
				if ( tab[ 2 ] == 1 ) {
					$( ".art_offert_promo" ).show();
				}
				
				// ---- Bouton "Article offert ( Traitement spécifique )"
				else if ( tab[ 2 ] == 2 ) {
					$( ".art_offert" ).show();
				}
				
				// ---- Bouton "Valider ma commande"
				else {
					$( ".suite" ).show();
					
					// Modification du lien sur le bouton
					$( ".suite a" ).attr( "href", tab[ 4 ] );
				}
			}
			
			// ---- Une erreur s'est produite!!!
			else {
				alert( "Une erreur s'est produite lors de l'affichage du panier : " + tab[ 1 ] );
			}
		}
	});
}

// Redirige vers la carte du restaurant
function accederCarte( _url ) {
	window.location.href = _url;
}

function je_force() {
	forcer_mb( $( "#special_k" ).val(), '', '' );
}

function vider_panier() {
	
	$.ajax({
		type: "POST",
		url: '/ajax/ajax_panier.php?task=viderPanier',
		error: function() { alert( "Une erreur s'est produite..." ); },
		success: function( data ){
			var obj = $.parseJSON( data );
						        	
			if ( !obj.erreur ) {
				
				// Affichage du panier
				$.ajax({
					type: "POST",
					url: '/ajax/ajax_panier.php?task=showCart',
					data: '',
					error: function() {},
					success: function( data ){
						
						// Traitement de la réponse
						var tab = data.split("#@#")
						//alert( tab[2] );
						
						// Le panier est à afficher
						if ( tab[0] == 'ok' ) {
							$( ".mon_panier" ).removeClass( "panier_rempli" );
							$( ".mon_panier" ).removeClass( "panier_rempli" );
							$( ".mon_panier" ).addClass( tab[1] );
							$( ".mon_panier" ).html( tab[2] );
							
							refresh_panier();
						}
					}
				});
			}
		}
	});
}

function add_product( productid, offert ) {
	//alert("add_product : " + productid);
	//var post = $( 'form[name="form_' + productid + '"]' ).serialize();
	var post = $( "#form_" + productid ).serialize();
	
	$.ajax({
		type: "POST",
		url: '/ajax/ajax_panier.php?task=addToCart&id=' + productid  +'&offert=' + offert,
		data: post,
		error: function() { alert( "Une erreur s'est produite lors de l'enregistrement." ); },
		success: function( data ) {
			
			// Traitement de la réponse
			var tab = data.split("#@#");
			
			// Tout s'est bien passé!
			if ( tab[0] == "ok" ) {
				
				// Mise à jour de l'affichage
				refresh_panier();
				
				// Affichage du message
				$( "#banco_" + productid ).fadeIn();
				setTimeout( "$( '#banco_" + productid + "' ).fadeOut()", 2000 );
			}
			
			// Une erreur s'est produite!!!
			else if ( tab[ 0 ] == "erreur_bloquante" ) {
				alert( tab[ 1 ] );
				var k = $( "#special_k" ).val();
				var _url = $( "#special_url" ).val();
				
				forcer_mb( k, '', _url );
			}
			
			// Une erreur s'est produite!!!
			else {
				alert( tab[1] );
			}
		}
	});
}

function add_menu( productid ) {
	//alert( "add_menu : " + productid );
	
	var post = $( "#form_id_" + productid ).serialize();
	post += "&num_menu=" + $( "#num_menu" ).val();
	post += "&current_order=" + $( "#ordre" ).val();
	//alert( post );
	
	$.ajax({
		type: "POST",
		url: '/ajax/ajax_panier.php?task=addMenu&id=' + productid,
		data: post,
		error: function() { alert( "Une erreur s'est produite lors d'enregistrement." ); },
		success: function( data ){
			
			// Traitement de la réponse
			var tab = data.split("#@#");
			//alert( tab[1] + " / " + tab[2] );
			
			// Tout s'est bien passé!
			if ( tab[0] == "ok" ) {
				$( "#ordre" ).val( tab[1] );
				
				$( "#recap-menu" ).hide();
				$( "#wait-recap-menu" ).show();
				getHistorique();
				
				$( "#carte" ).hide();
				$( "#wait_menu_article" ).show();
				getArticle();
			}
			
			// Redirection vers la page de validation
			else if ( tab[0] == "validation" ) {
				//alert( "Redirection... #" + $( "#num_menu" ).val() );
				$( "#formulaire" ).submit();
			}
			
			// Une erreur s'est produite!!!
			else {
				alert( tab[2] );
			}
		}
	});
}

function delete_product( productid, num_resto, offert ) {
	$.ajax({
		type: "GET",
		url: '/ajax/ajax_panier.php?task=deleteFromCart&id='+productid+'&num='+num_resto+"&offert="+offert,
		success: function(data){
		
			// Traitement de la réponse
			//var tab = data.split("#@#")
			//alert( tab[2] );
			
			/*$( ".mon_panier" ).removeClass( "panier_vide" );
			$( ".mon_panier" ).removeClass( "panier_rempli" );
			$( ".mon_panier" ).addClass( tab[1] );
			$( ".mon_panier" ).html( tab[2] );*/
			
			// Mise à jour de l'affichage
			refresh_panier();
		}
	});
}

function increment_product( productid, num_resto ) {
	$.ajax({
		type: "GET",
		url: '/ajax/ajax_panier.php?task=incrementCart&id='+productid+'&num='+num_resto,
		success: function(data){
		
			// Traitement de la réponse
			var tab = data.split("#@#")
			//alert( tab[2] );
			
			$( ".mon_panier" ).removeClass( "panier_rempli" );
			$( ".mon_panier" ).removeClass( "panier_rempli" );
			$( ".mon_panier" ).addClass( tab[1] );
			$( ".mon_panier" ).html( tab[2] );
			
			// Mise à jour de l'affichage
			refresh_panier();
		}
	});
}

function delete_menu( id, num_resto) {
    $.ajax({
        type: "GET",
        url: '/ajax/ajax_panier.php?task=deleteMenu&id=' + id + '&num=' + num_resto,
        success: function(data){
	        
			// Traitement de la réponse
			var tab = data.split("#@#")
			//alert( tab[2] );
			
			$( ".mon_panier" ).removeClass( "panier_vide" );
			$( ".mon_panier" ).removeClass( "panier_rempli" );
			$( ".mon_panier" ).addClass( tab[1] );
			$( ".mon_panier" ).html( tab[2] );
			
			// Mise à jour de l'affichage
			refresh_panier();
	    }
    });
}

function updateSupplement( id_article ) {
	//alert( "updateSupplement..." );
	var id_i = $( "#radio_" + id_article + ":checked" ).val();
	
	// Le DIV des suppléments est visible
	if ( $( "#div_element_" + id_article ).is( ":visible" ) ) {
		//alert( "#div_element_" + id_article + " trouvé!!!" );
		
		// Mise en attente...
		$( "#div_element_" + id_article ).html( "<img src='/img/ajax-loader.gif' alt='En cours de chargement...' border='0' />" );
		
		// Affichage des suppléments
		afficherSupplement( id_article, id_i );
	}
}

function afficherSupplement( id_a, id_i ) {
	//alert( "afficherSupplement()..." );
	$.ajax({
		type: "POST",
		url: '/ajax/ajax_produit.php?task=showSupplement&id=' + id_a + '&i=' + id_i,
		success: function( data ){
			if ( !data ) alert( "Une erreur s'est produite..." );
			else {
				//alert( data );
				$( "#div_element_" + id_a ).html( data );
			}
				
			return false;
		}
	});
}