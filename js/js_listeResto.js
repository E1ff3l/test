	function calcHeight() {
						
		// Récupère la hauteur de la page
		var the_height = document.getElementById( 'the_iframe' ).contentWindow.document.body.scrollHeight;
		
		// Change la hauteur de l'iframe
		document.getElementById( 'the_iframe' ).height = the_height;
	}
	
	// Changement de mode de fonctionnement
	$( "#choix-livraison" ).click( function() {
		window.location.href = $( "#url_livraison" ).val();
	});
	$( "#choix-emporter" ).click( function() {
		window.location.href = $( "#url_ae" ).val();
	});
	
	$( ".picto-vazee" ).tooltipster({
	    animation: 	'fade',
	    arrow: 		'true',
	    position:	'top'
	});
	
	$( ".lien-critere" ).tooltipster({
	    animation: 	'fade',
	    arrow: 		'true',
	    position:	'right'
	});
	
	// ---- Affichage de la liste des restaurants --- //
	function afficherListe() {
		
		$.ajax({
			type: 	"POST",
			cache: 	false,
			url: 	"/ajax/ajax_listeResto.php?task=afficher_liste",
			success: function( data ){
				$( "#liste-restos" ).fadeIn().html( data );
				
				$('.lien-moyens-paiement').tooltipster({
				    animation: 'fade',
				    arrow: 'true',
				    position:'top'
				});
				
				$('.frais-livraison-stuart').tooltipster({
				    animation: 'fade',
				    arrow: 'true',
				    position:'top'
				});
				
				$('.lien-horaire').tooltipster({
				    animation: 'fade',
				    arrow: 'true',
				    position:'top'
				});
			}
		});
	}
	
	$('.lien-moyens-paiement').tooltipster({
	    animation: 	'fade',
	    arrow: 		'true',
	    position:	'top'
	});
	
	$('.frais-livraison-stuart').tooltipster({
	    animation: 	'fade',
	    arrow: 		'true',
	    position:	'top'
	});
	
	$('.lien-horaire').tooltipster({
	    animation: 	'fade',
	    arrow: 		'true',
	    position:	'top'
	});
	// ---------------------------------------------- //
	
	// ---------- Tri (éventuel) des résultats ------ //
	function trier_eventuellement() {
		//alert( "Tri eventuel...!" );
		
		$.ajax({
			type: "POST", 
			url: "/ajax/ajax_listeResto.php?task=a_trier",
			error: function() {},
			success: function( retour ){ 
				var obj = $.parseJSON( retour );
				//alert( obj.a_trier );
				
				// ---- MAJ du module de tri -------- //
				if ( obj.div_tri != '' ) {
					//alert( "MAJ du module de tri" );
					$( "#tri" ).html( obj.div_tri );
				}
				
				// ---- MAJ du module de tri par critères
				if ( obj.div_autre_critere != '' ) {
					//alert( "MAJ du module de tri par critères" );
					$( "#div_autre_critere" ).html( obj.div_autre_critere );
				}
				
				// ---- Le tri est à faire! --------- //
				if ( obj.a_trier ) trier();
			}
		});
	}
	
	// ---------- Tri des résultats ----------------- //
	function trier() {
		//alert( "on trie!" );
		
		// ---- Mise en attente
		var contenu = '<div style="padding-top:120px; height:150px; text-align:center;">\n';
		contenu += '	<img src="/img/ajax-loader.gif" width="24" height="24" alt="En cours de chargement..." border="0" />\n';
		contenu += '</div>';
		$( "#liste-restos" ).html( contenu );
		
		$.ajax({
			type: 	"POST",
			cache: 	false,
			url: 	"/ajax/ajax_listeResto.php?task=trier",
			data: 	$( "#formulaire" ).serialize(),
			success: function( data ){
				
				// ---- Ré-affichage de la liste des restaurants
				afficherListe();
			}
		});
	}
	// ---------------------------------------------- //
	
	$( document).on( "change", ".tri", function() {
		trier();
		return false;
	});
	
	// ---- Recherche d'un restaurant spécifique ---- //
	$( "#rechercher" ).click(function() {
		trier();
		return false;
	});
	
	// ---- Appuie sur la toucher "entrée" ---------- //
	$( "#field" ).keypress(function( e ) {
		if( e.keyCode == 13 ) {
			//alert( "Trier..." );
			trier();
			e.preventDefault();
		}
	});
	
	// ---- Sélection / désélection de critères ----- //
	$( document).on( "click", ".critere", function() {
		trier();
	});
	// ---------------------------------------------- //
	
	// ---------- On fait clignoter ----------------- //
	setInterval( function() {
		$( ".clignote" ).fadeOut( 900 ).delay( 300 ).fadeIn( 800 );
	}, 4000);
	// ---------------------------------------------- //
	
	// Liste des quartiers dépliable
	$('#changer-quartier ul').hideMaxListItems({
		'max':		4, 
		'speed':	500, 
		'moreHTML':	'<p class="maxlist-more"><a href="#" title="Tout voir">Voir la liste…</a></p>',
		moreText:	'Voir la liste',
		lessText:	'cacher la liste',
	});
	
	// --------- Liste des plats dépliables ----------------------------------- //
	$('#liste-resto-pizza ul').hideMaxListItems({
		'max':		4, 
		'speed':	500, 
		'moreHTML':	'<p class="maxlist-more"><a href="#" title="Tout voir">Voir toute la liste</a></p>',
		moreText:	'Voir toute la liste',
		lessText:	'Cacher la liste',
	});
	
	$('#liste-resto-nem ul').hideMaxListItems({
		'max':		4, 
		'speed':	500, 
		'moreHTML':	'<p class="maxlist-more"><a href="#" title="Tout voir">Voir toute la liste</a></p>',
		moreText:	'Voir toute la liste',
		lessText:	'Cacher la liste',
	});
	
	$('#liste-resto-sushis ul').hideMaxListItems({
		'max':		4, 
		'speed':	500, 
		'moreHTML':	'<p class="maxlist-more"><a href="#" title="Tout voir">Voir toute la liste</a></p>',
		moreText:	'Voir toute la liste',
		lessText:	'Cacher la liste',
	});
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
	
	$( ".pourquoi" ).click(function() {
		afficher_pourquoi();
	});
	