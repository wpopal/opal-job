var Opaljob_User =  { 
	
	init:function () {
		Opaljob_User.trigger();
		Opaljob_User.tabs();
	},
	tabs:function(){

		$( '.opaljob-tab .tab-item' ).click( function ( event ) {
	        event.preventDefault();
	        $( this ).parent().find( ' .tab-item' ).removeClass( 'active' );
	        $( this ).addClass( 'active' );

	        $( $( this ).attr( 'href' ) ).parent().children( '.opaljob-tab-content' ).removeClass( 'active' );
	        $( $( this ).attr( 'href' ) ).addClass( 'active' );
	    } );

	    $( '.opaljob-tab' ).each( function () {
	        $( this ).find( '.tab-item' ).first().click();
	    } );

	},
	trigger:function () {

	    $( 'body' ).delegate( '.opaljob-popup-button', 'click', function () {
	        var $target = $( this ).data( 'target' );
	        $.magnificPopup.open( {
	            items: {
	                src: $target
	            }
	        } );
	        return false;
	    } );
		// open login form
	    $( document ).on( 'opaljob:login', function () {
	        if ( $( '#opaljob-user-form-popup' ) ) {
	            $.magnificPopup.open( {
	                items: {
	                    src: '#opaljob-user-form-popup'
	                },
	                mainClass: 'mfp-with-zoom', // this class is for CSS animation below
	                zoom: {
	                    enabled: true
	                }
	            } );
	        }
	    } );

	    $( 'body' ).delegate( '.opaljob-need-login', 'click', function () {  
	        $( document ).trigger( 'opaljob:login', [ true ] );

	        var myToast = $.toast({
                heading: "User login",
                text: "Please login the site to complete the action.",
                icon: 'warning',
                position:  'bottom-right', 
                hideAfter: 5000, 
                showHideTransition: 'fade',
            });
	        return false;
	    } );
	}
}


$( document ).ready( function () { 
    $( Opaljob_User.init );
} );