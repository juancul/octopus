jQuery( document ).ready( function() {
	//order notes quick view
	jQuery( '.wooon-quickview' ).on( 'click', function( e ) {
		var order = jQuery( this ).attr( 'data-order' );
		var current = jQuery( this ).attr( 'data-current' );
		jQuery( '#wooon_dialog' ).html( 'Loading order notes...' );
		jQuery( '#wooon_dialog' ).dialog( {minWidth: 460, title: 'Order #' + order} );
		var data = {
			action: 'wooon_quickview',
			nonce: wooon_vars.nonce,
			order: order,
			current: current,
		};
		jQuery.post( wooon_vars.url, data, function( response ) {
			jQuery( '#wooon_dialog' ).html( response );
		} );
		e.preventDefault();
	} );
} );