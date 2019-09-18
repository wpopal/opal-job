var GoogleMapSearch =  function ( data ) { 
    var initializeJobsMap = function ( jobs ) {
        // Jobs Array
        var mapOptions = {
            zoom: 12,
            maxZoom: 16,
            scrollwheel: false,
             mapTypeId: google.maps.MapTypeId.ROADMAP,
            panControl: false,
            zoomControl: true,
            mapTypeControl: false,
            scaleControl: false,
            streetViewControl: true,
            overviewMapControl: false,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL,
                position: google.maps.ControlPosition.RIGHT_TOP
            },
            streetViewControlOptions: {
                position: google.maps.ControlPosition.RIGHT_TOP
            }
        };

        var map = new google.maps.Map( document.getElementById( "opaljob-map-preview" ), mapOptions );

        var bounds = new google.maps.LatLngBounds();

        // Loop to generate marker and infowindow based on jobs array
        var markers = new Array();

        for ( var i=0; i < jobs.length; i++ ) {

            // console.log( jobs[i] );
            var url = jobs[i].icon;
            var size = new google.maps.Size( 42, 57 );
            if( window.devicePixelRatio > 1.5 ) {
                if ( jobs[i].retinaIcon ) {
                    url = jobs[i].retinaIcon;
                    size = new google.maps.Size( 83, 113 );
                }
            }

            var image = {
                url: url,
                size: size,
                scaledSize: new google.maps.Size( 30, 51 ),
                origin: new google.maps.Point( 0, 0 ),
                anchor: new google.maps.Point( 21, 56 )
            };

            markers[i] = new google.maps.Marker({
                position: new google.maps.LatLng( jobs[i].lat, jobs[i].lng ),
                map: map,
                icon: image,
                title: jobs[i].title,
                animation: google.maps.Animation.DROP,
                visible: true
            });

            bounds.extend( markers[i].getPosition() );

            var boxText = document.createElement( "div" );
            var pricelabel = '';

            if( jobs[i].pricelabel ){
                 pricelabel = ' / ' + jobs[i].pricelabel;
            }

            // console.log( jobs[i] );
            boxText.className = 'map-info-preview media';

            var meta = '<ul class="list-inline job-meta-list">';
            if( jobs[i].metas ){
                for ( var x in jobs[i].metas ){
                    var m = jobs[i].metas[x]; 
                    meta += '<li><i class="icon-job-'+x+'"></i>' + m.value +'<span class="label-job">' + m.label + '</span></li>'
                 }   
            }
            meta    += '</ul>';

            boxText.innerHTML = '<div class="media-top"><a class="thumb-link" href="' + jobs[i].url + '">' +
                                    '<img class="prop-thumb" src="' + jobs[i].thumb + '" alt="' + jobs[i].title + '"/>' +
                                    '</a>'+ jobs[i].status +'</div>' +
                                    '<div class="info-container media-body">' +
                                    '<h5 class="prop-title"><a class="title-link" href="' + jobs[i].url + '">' + jobs[i].title +
                                    '</a></h5><p class="prop-address"><em>' + jobs[i].address + '</em></p><p><span class="price text-primary">' + jobs[i].pricehtml + pricelabel +
                                    '</span></p>'+meta+'</div>'+'<div class="arrow-down"></div>';

            var myOptions = {
                content: boxText,
                disableAutoPan: true,
                maxWidth: 0,
                alignBottom: true,
                pixelOffset: new google.maps.Size( -122, -48 ),
                zIndex: null,
                closeBoxMargin: "0 0 -16px -16px",
                closeBoxURL: opalesateJS.mapiconurl+"close.png",
                infoBoxClearance: new google.maps.Size( 1, 1 ),
                isHidden: false,
                pane: "floatPane",
                enableEventPropagation: false
            };

            var ib = new InfoBox( myOptions );
       
            attachInfoBoxToMarker( map, markers[i], ib, i );
        }

        var last = null ;

        $('body').delegate( '[data-related="map"]', 'mouseenter', function(){    
            if( $(this).hasClass('map-active') ){
                return true;
            }
    
            var i = $(this).data( 'id' );
            $( '[data-related="map"]' ).removeClass( 'map-active' );
            $(this).addClass( 'active' );
            map.setZoom( 65536 );//  alert( scale );

            if(  markers[i] ){
                var marker =  markers[i]; 
                google.maps.event.trigger( markers[i], 'click' );

                var scale = Math.pow( 2, map.getZoom() );
                var offsety = ( (100/scale) || 0 );
                var projection = map.getProjection();
                var markerPosition = marker.getPosition();
                var markerScreenPosition = projection.fromLatLngToPoint( markerPosition );
                var pointHalfScreenAbove = new google.maps.Point( markerScreenPosition.x, markerScreenPosition.y - offsety );
                var aboveMarkerLatLng = projection.fromPointToLatLng( pointHalfScreenAbove );
                map.setZoom( scale );
                map.setCenter( aboveMarkerLatLng );

            }
            return false;
        });  
        
        map.fitBounds(bounds);

        /* Marker Clusters */
        var markerClustererOptions = {
            ignoreHidden: true,
            maxZoom: 14,
            styles: [{
                textColor: '#000000',
                url: opalesateJS.mapiconurl+"cluster-icon.png",
                height: 51,
                width: 30
            }]
        };

        var markerClusterer = new MarkerClusterer( map, markers, markerClustererOptions );

       

        function attachInfoBoxToMarker( map, marker, infoBox , i ){ 

            google.maps.event.addListener( marker, 'click', function(){
              
                if( $( '[data-related="map"]' ).filter('[data-id="'+i+'"]').length > 0 ){ 
                    var $m = $( '[data-related="map"]' ).filter('[data-id="'+i+'"]'); 
                    $( '[data-related="map"]' ).removeClass( 'map-active' );
                    $m.addClass('map-active');
                }

                if( last != null ){
                    last.close();
                }    
                
                var scale = Math.pow( 2, map.getZoom() );
                var offsety = ( (100/scale) || 0 );
                var projection = map.getProjection();
                var markerPosition = marker.getPosition();
                var markerScreenPosition = projection.fromLatLngToPoint( markerPosition );
                var pointHalfScreenAbove = new google.maps.Point( markerScreenPosition.x, markerScreenPosition.y - offsety );
                var aboveMarkerLatLng = projection.fromPointToLatLng( pointHalfScreenAbove );
                map.setCenter( aboveMarkerLatLng );
                infoBox.open( map, marker );
                last = infoBox; 
            });
        }
    }
    initializeJobsMap( data );  
}

/**
 * Create Google Map In Single Job Only
 */
var Opaljob_Search =  { 
	
	init:function () {  
		Opaljob_Search.trigger();	 
	},
    updatePreviewGoogleMap:function( url ){
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: opaljobJS.ajaxurl,
            data:  url,
            success: function(data) {
               new GoogleMapSearch( data );
            }
        });
    },
	trigger:function () {

		if( $("#opaljob-search-map-preview").length > 0 )  { 

            var page = 0;
            var localURL = location.search.substr(1)+"&action=opaljob_get_jobs_map&paged="+page;
            alert( localURL );
            Opaljob_Search.updatePreviewGoogleMap( localURL );
            // 
		}

	}
 
}


/**
 * Create Google Map In Single Job Only
 */
$( document ).ready( function () { 
    $( Opaljob_Search.init );
} );