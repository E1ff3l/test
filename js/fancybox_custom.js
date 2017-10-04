$( ".iframe" ).live( "click", function() {
	$.fancybox({
		'width'				: '75%',
		'height'			: '75%',
		'autoScale'			: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe',
		'href' 				: $(this).attr( "href" ),
	});
	
	return false;
});

$( document).on( "click", ".iframe_mon_compte", function() {
	//alert( "click..." );
	$.fancybox({
		'width'				: 700,
		'height'			: 550,
		'autoScale'			: false,
		'type'				: 'iframe',
		'href' 				: $(this).attr( "href" ),
	});
	
	return false;
});

$( ".iframe_connexion" ).live( "click", function() {
	$.fancybox({
		'width'				: 700,
		'height'			: 320,
		'autoScale'			: false,
		'type'				: 'iframe',
		'href' 				: $(this).attr( "href" ),
	});
	
	return false;
});

$( ".iframe_deconnexion" ).live( "click", function() {
	$.fancybox({
		'width'				: 700,
		'height'			: 200,
		'autoScale'			: false,
		'type'				: 'iframe',
		'href' 				: $(this).attr( "href" ),
	});
	
	return false;
});

$( ".iframe_creation" ).live( "click", function() {
	//alert( $(this).attr( "href" ) );
	$.fancybox({
		'width'				: 700,
		'height'			: 650,
		'autoScale'			: false,
		'type'				: 'iframe',
		'href' 				: $(this).attr( "href" ),
	});
	
	return false;
});

$( ".iframe_creation_ipad" ).live( "click", function() {
	$.fancybox({
		'width'				: 700,
		'height'			: 5000,
		'autoScale'			: false,
		'type'				: 'iframe',
		'href' 				: $(this).attr( "href" ),
	});
	
	return false;
});

$( ".iframe_menu" ).live( "click", function() {
	$.fancybox({
		'width'				: 700,
		'height'			: '95%',
		'autoScale'			: false,
		'type'				: 'iframe',
		'href' 				: $(this).attr( "href" ),
	});
	
	return false;
});