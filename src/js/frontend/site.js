var Opaljob_Site =  { 
	
	init:function () {  
		Opaljob_Site.trigger();
	},
	trigger:function () {
		$('select.form-control').select2( {
	 
	    } );
	    
	} 
}


$( document ).ready( function () { 
    $( Opaljob_Site.init );
} );