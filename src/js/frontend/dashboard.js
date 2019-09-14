var Opaljob_Dashboard =  {

	init:function(){
		Opaljob_Dashboard.changePassword();
	},

 	makeAjax:function( formData, $submit_btn, _callback, isform ) {
        var _isform = true;
        if( isform == true ){
            _isform = false;
        }
        Opaljob_Dashboard.toggleSubmit( $submit_btn );
        $.ajax({
            url : opaljobJS.ajaxurl,
            data : formData,
            type : 'POST',
            processData: _isform,
            contentType: _isform,
            dataType: "json",
            success : function( response ){
                if( response.status == true ){
                    
                    if( response.redirect ){
                        var _time = setTimeout( function() {
                           window.location.href = response.redirect;
                        }, 3000);                  
                    }
                    
                    _callback( response );

                    var myToast = $.toast({
                        heading: response.heading,
                        text: response.message,
                        icon: 'success',
                        position:  'bottom-right', 
                        hideAfter: 4000, 
                        showHideTransition: 'fade',
                    });
                     Opaljob_Dashboard.toggleSubmit( $submit_btn );
                } else { 
                   Opaljob_Dashboard.toggleSubmit( $submit_btn );
                    var myToast = $.toast({
                        heading: response.heading,
                        text: response.message,
                        icon: 'error',
                        position:  'bottom-right', 
                         hideAfter: 4000, 
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
    metaboxForm: function () {
        $( ".opaljob-submited-form" ).submit( function () {

            var formData = new FormData();
            formData.append('section', 'general');            

            $(".opaljob-uploader-files", this ).each( function(){
                var file_btn      = $( 'input.select-file', this ); 
                var files         =  $(".uploader-item-preview", this );

                var name          = $(this).data( 'name' );
                var issingle      = $( this ).data('single'); 
                $(files).each( function( i , element ){ 
                    var file = $(this).prop( 'file');
                    if( file ) {
                        if( issingle ){
                            formData.append( name, file ); 
                        } else {
                            formData.append( name+"["+i+"]", file ); 
                        }
                    }
                } );
            });
            var dataSubmit =  $( this ).serializeArray();
            $.each( dataSubmit, function ( key, input ) {
                formData.append( input.name, input.value ); 
            });

            formData.append('action', 'opaljob_submitted_job_data');
            Opaljob_Dashboard.makeAjax( formData, $(':submit',this), function ( response ) {
                 
            }, true  );
              
        } );
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