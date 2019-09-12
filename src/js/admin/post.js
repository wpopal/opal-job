var Opaljob_Admin =  {

	init:function(){
		Opaljob_Admin.membership();
	},
    membership:function () {
       // alert("fs");
       $(".opaljob-target-show-container").hide();
       $(".cmb2-id-opalmb-package-type select").each( function() {
            var options = $("option", this);
            var _show = function ( v ){
                options.each( function(){
                    $("#opaljob-package-"+$(this).val() ).hide();
                } );
                $("#opaljob-package-"+v ).show();
            }
            var s = $(this).val(); 
            if( s != "" ) {
                _show( s );
            } else {
                options.first().attr( "selected", "selected" );
                _show( options.first().val() );    
            }
            
          
            $( this ).change( function() {
               _show( $(this).val() );  
            } );
       } )
    }
}

$( Opaljob_Admin.init );