var Opaljob_Site =  { 
	
	init:function () {  
		Opaljob_Site.trigger();
	},
	trigger:function () {
		// apply select2 style for form elements
		$('select.form-control').select2( {
	 
	    } );
	    
	    /// check 
	    if( $( '.opaljob-sticky-column' ).length > 0 ) {
	    	$( '.opaljob-sticky-column' ).stick_in_parent();
		}

		/// tooltip
		if( $('.tooltip').length ) { 
			$('.tooltip').tooltipster();
		}
		
	} 
}
$( document ).ready( function () { 
    $( Opaljob_Site.init );
} );