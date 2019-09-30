var Opaljob_Search_View =  { 
	
	init:function () {  
		Opaljob_Search_View.trigger();
	},
	makeAjax:function( url , _callback ){  
        $.ajax({
            type: 'GET',
            url: opaljobJS.ajaxurl,
            data:  url,
            success: function(data) { 
              _callback( data );
            }
        });
    },
	trigger:function () { 	
		if( $( "#opaljob-job-search-view-jobs" ).length > 0 ) {
			var _this = $( "#opaljob-job-search-view-jobs" );
			$( _this ).on( 'click',  '.job-quick-view', function () {
				var job_id = $( this ).data( 'job-id' );
		
				
				if ( history.pushState ) {  
                    var ps     =  "view_job_id="+job_id;
                    var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?'+ ps;
                    window.history.pushState({path:newurl},'',newurl);
                }
               
                Opaljob_Search_View.makeAjax( 'action=opaljob_quick_view_single_job&view_job_id='+job_id, function( data ) { 
                	var html = $( data ).find( ".job-search-view-single" );   
            
                	$( "#opaljob-job-search-view-jobs .job-search-view-single" ).html(  html.html()  );
                } );

			} ); 
		} 
	} 
}
$( document ).ready( function () { 
    $( Opaljob_Search_View.init );
} );