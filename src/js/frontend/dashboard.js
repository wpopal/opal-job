var Opaljob_Dashboard =  {

	init:function(){
		Opaljob_Dashboard.changePassword();
	},

 	makeAjax:function( formData, $submit_btn ) {
 		Opaljob_Dashboard.toggleSubmit( $submit_btn );
        $.ajax({
            url : opaljobJS.ajaxurl,
            data : formData,
            type : 'POST',
         //   processData: false,
       //     contentType: false,
            dataType: "json",
            success : function( response ){
                if( response.status == true ){
                    if( response.redirect ){
                        window.location.href = response.redirect;
                    }

                    var myToast = $.toast({
                        heading: response.heading,
                        text: response.message,
                        icon: 'success',
                        position:  'bottom-right', 
                        hideAfter: 5000, 
                        showHideTransition: 'fade',
                    });
                } else { 
                   Opaljob_Dashboard.toggleSubmit( $submit_btn );
                    var myToast = $.toast({
                        heading: response.heading,
                        text: response.message,
                        icon: 'error',
                        position:  'bottom-right', 
                         hideAfter: 5000, 
                         showHideTransition: 'fade'
                    });
                }
            }
        }); 
    },
 	toggleSubmit:function ( _this ){
        if( $( _this ).attr('disabled') == "disabled" ){
             $( _this ).removeAttr( 'disabled' );
             $(_this).find('i').remove( );  
        } else {
             $( _this ).attr('disabled','disabled');
             $(_this).append( ' <i class="fa fa-spinner fa-spin"></i> ' );   
        }
           
    },
    /// change password page
	changePassword:function(){
		$( "#opaljob-changepassword-form" ).submit( function () {
			Opaljob_Dashboard.makeAjax( $(this).serialize()+"&action=opaljob_save_changepass", $("button:submit" , this ) );
			return false;
		} );	 
	}
}

$( Opaljob_Dashboard.init );