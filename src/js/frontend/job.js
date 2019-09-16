 /**
 * GooglemapSearch
 */
var GooglemapSingle = function ( data , id ) {

    /**
     * Create Google Map In Single Job Only
     */
    var initializeJobMap = function ( data , id ){

        var jobMarkerInfo = data; 
        var enable  = true ;
        var url     = jobMarkerInfo.icon;   
        var size    = new google.maps.Size( 42, 57 );
       

        var allMarkers = []; 
        
        var setMapOnAll = function (markers, map) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap( map );
            }
        }
        // retina
        if( window.devicePixelRatio > 1.5 ) {
            if ( jobMarkerInfo.retinaIcon ) {
                url = jobMarkerInfo.retinaIcon;
                size = new google.maps.Size( 83, 113 );
            }
        }
        
        var jobLocation = new google.maps.LatLng( jobMarkerInfo.latitude, jobMarkerInfo.longitude );
        var jobMapOptions = {
            center: jobLocation,
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: false
        };
        var jobMap = new google.maps.Map( document.getElementById( id ), jobMapOptions );

        /**
         *
         */
        var  createMarker = function ( position, icon ) {
            
            var image   = {
                url: icon,
                size: size,
                scaledSize: new google.maps.Size( 32, 57 ),
                origin: new google.maps.Point( 0, 0 ),
                anchor: new google.maps.Point( 21, 56 )
            };

            var _marker = new google.maps.Marker({
                map: jobMap,
                position: position,
                icon: image
            });
            return _marker; 
        }

        
        var infowindow = new google.maps.InfoWindow();

        createMarker( jobLocation, url ); 
    }

    initializeJobMap( data , id );  
} 

var Opaljob_Job =  { 
	
	init:function () {  
		Opaljob_Job.trigger();
 
	},
	trigger:function () {

		$( ".job-preview-map").each( function(){
            new GooglemapSingle( $(this).data() , $(this).attr('id') );
        } );
	}
	 
}


$( document ).ready( function () { 
    $( Opaljob_Job.init );
} );