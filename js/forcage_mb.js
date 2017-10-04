	// --------- Force l'état MB (Utile en cas de perte de session) ----------- //
	function forcer_mb( k, _target, _url ) {
		//alert( "on force puis redirection vers " + _url );
		//alert( "K : " + k + " --> " + _url );
		
		$.ajax({
			type: "POST",			
			cache: false,
			url: '/ajax/ajax_divers.php?task=forcer_mb',
			data: {
				k :	k
			},
			error: function() {},
			success: function( data ){
				if ( _url != '' ) {
					if ( _target == '_parent' ) parent.window.location.href = _url;
					else window.location.href = _url;
				}
			}
		});
	}
	
	$( ".forcer_mb").click(function(e) {
		e.preventDefault();
		var elem = $(this);
		var k = elem.attr( "data-key" );
		var _url = elem.attr( "href" );
		
		// ---- En cas de redirection vers un target particulier
		var _target = elem.attr( "target" );
		
		//alert( _target + " / " + _url );
		forcer_mb( k, _target, _url );
	});
	// ------------------------------------------------------------------------ //
			