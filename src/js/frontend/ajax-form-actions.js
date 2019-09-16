var Opaljob_Features =  {

	init:function(){
		Opaljob_Features.submitForm();
        Opaljob_Features.favorite();
        Opaljob_Features.followEmployer();
        Opaljob_Features.applyJob();
        Opaljob_Features.sendMessage();

        Opaljob_Features.submitJob();
	},

 	makeAjax:function( formData, $submit_btn, _callback, isform ) {
       
        var ajax = {
            url : opaljobJS.ajaxurl,
            data : formData,
            type : 'POST',
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
        };

 
        if( isform == true ) {
            ajax.processData  = false;
             ajax.contentType = false;
        }

 		Opaljob_Dashboard.toggleSubmit( $submit_btn );
        $.ajax( ajax ); 
    },
    ///// ////// 
    submitJob:function() {

        $( ".opaljob-submited-form" ).on( "submit" ,function () {
            ///////////////
            ///
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
            Opaljob_Features.makeAjax( formData, $(':submit',this), function ( response ) {
                 
            }, true  );
            ///////
            ///
            return false; 
        } );
    },
    ///// /////
    sendMessage:function () { 
        $( ".opaljob-message-form" ).on('submit', function(){ 
          
            var data = $( this ).serialize()+"&action=opaljob_send_email_contact";
            Opaljob_Features.makeAjax( data, $( ":submit",this), function (   ) {
                
            }  );

            return false; 
        } );
    },
    ///
 	toggleSubmit:function ( _this ){
        if( $( _this ).attr('disabled') == "disabled" ){
             $( _this ).removeAttr( 'disabled' );
             $(_this).find('i').remove( );  
        } else {
             $( _this ).attr('disabled','disabled');
             $(_this).append( ' <i class="fa fa-spinner fa-spin"></i> ' );   
        }
           
    },
    // apply job
    applyJob:function () {
        $( 'body' ).delegate( '.job-apply-now', 'click', function () {
            var $this = $( this );
            if ( $( this ).hasClass( 'opaljob-need-login' ) ) {
                return;
            }
            if ( $( '#opaljob-apply-form-popup' ) ) {
                $.magnificPopup.open( {
                    items: {
                        src: '#opaljob-apply-form-popup'
                    },
                    closeOnBgClick: false,
                    mainClass: 'mfp-with-zoom', // this class is for CSS animation below
                    zoom: {
                        enabled: true
                    }
                } );
            }
                
            return false ; 
            var ps = 'job_id=' + $( this ).data( 'job-id' ) + '&employer_id=' + $( this ).data( 'employer-id' ) + '&action=opaljob_candidate_apply_now' ; 
            
            Opaljob_Features.makeAjax( ps, $(this), function ( response ) {
                if( response.html ){ 
                    $this.replaceWith( $( response.html ) );
                }
            }  );
            return false;
        } );
        $( ".opaljob-apply-job-form" ).submit( function () {
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

            formData.append('action', 'opaljob_apply_job_data');
            Opaljob_Features.makeAjax( formData, $(':submit',this), function ( response ) {
                 
            }, true  );
            return false; 
        } );
    },
    // add follow employer
    followEmployer:function () { 
         $( 'body' ).delegate( '.job-following-button', 'click', function () {
            var $this = $( this );
            if ( $( this ).hasClass( 'opaljob-need-login' ) ) {
                return;
            }
            var ps = 'employer_id=' + $( this ).data( 'employer-id' ) + '&action=opaljob_following_employer' ; 
            Opaljob_Features.makeAjax( ps, $(this), function ( response ) {
                if( response.html ){ 
                    $this.replaceWith( $( response.html ) );
                }
            }  );

           var p = $( $this ).parent().parent();

            if( p.hasClass('has-toggle-remove') ) {
                p.remove();
            }

            return false;
        } );
    },
    // remove or add job in favorite
    favorite:function () { 
        $( 'body' ).delegate( '.job-toggle-favorite', 'click', function () { 

            var $this = $( this );
            if ( $( this ).hasClass( 'opaljob-need-login' ) ) {
                return;
            }
            var ps = 'job_id=' + $( this ).data( 'job-id' ) + '&action=opaljob_toggle_status' ; 

            Opaljob_Features.makeAjax( ps, $(this), function ( response ) {
                if( response.html ){ 
                    $this.replaceWith( $( response.html ) );
                }
            }  );
        } );
        ////
        $( 'body' ).delegate( '.job-remove-favorite', 'click', function() {  
            var ps = 'job_id=' + $( this ).data( 'job-id' ) + '&action=opaljob_toggle_status' ; 
            var $this = $( this );
        
            Opaljob_Features.makeAjax( ps, $(this), function ( response ) {
                $( $this ).parent().parent().remove();
                if( response.html ){ 
                    $this.replaceWith( $( response.html ) );
                }
                
            }  );
            return false;
        } );
    },
    /// change password page
	submitForm:function(){
   
	}
}
$( document ).ready( function () {
    $( Opaljob_Features.init );
} );