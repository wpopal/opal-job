!function(w){"use strict";var a={init:function(){a.submitForm(),a.favorite(),a.followEmployer(),a.applyJob(),a.sendMessage(),a.submitJob()},makeAjax:function(o,e,t,a){var i={url:opaljobJS.ajaxurl,data:o,type:"POST",dataType:"json",success:function(o){if(1==o.status){if(o.redirect)setTimeout(function(){window.location.href=o.redirect},3e3);t(o);w.toast({heading:o.heading,text:o.message,icon:"success",position:"bottom-right",hideAfter:4e3,showHideTransition:"fade"});s.toggleSubmit(e)}else{s.toggleSubmit(e);w.toast({heading:o.heading,text:o.message,icon:"error",position:"bottom-right",hideAfter:4e3,showHideTransition:"fade"})}}};1==a&&(i.processData=!1,i.contentType=!1),s.toggleSubmit(e),w.ajax(i)},submitJob:function(){w(".opaljob-submited-form").on("submit",function(){var n=new FormData;n.append("section","general"),w(".opaljob-uploader-files",this).each(function(){w("input.select-file",this);var o=w(".uploader-item-preview",this),a=w(this).data("name"),i=w(this).data("single");w(o).each(function(o,e){var t=w(this).prop("file");t&&(i?n.append(a,t):n.append(a+"["+o+"]",t))})});var o=w(this).serializeArray();return w.each(o,function(o,e){n.append(e.name,e.value)}),n.append("action","opaljob_submitted_job_data"),a.makeAjax(n,w(":submit",this),function(o){},!0),!1})},sendMessage:function(){w(".opaljob-message-form").on("submit",function(){var o=w(this).serialize()+"&action=opaljob_send_email_contact";return a.makeAjax(o,w(":submit",this),function(){}),!1})},toggleSubmit:function(o){"disabled"==w(o).attr("disabled")?(w(o).removeAttr("disabled"),w(o).find("i").remove()):(w(o).attr("disabled","disabled"),w(o).append(' <i class="fa fa-spinner fa-spin"></i> '))},applyJob:function(){w("body").delegate(".job-apply-now","click",function(){w(this);if(!w(this).hasClass("opaljob-need-login"))return w("#opaljob-apply-form-popup")&&w.magnificPopup.open({items:{src:"#opaljob-apply-form-popup"},closeOnBgClick:!1,mainClass:"mfp-with-zoom",zoom:{enabled:!0}}),!1}),w(".opaljob-apply-job-form").submit(function(){var n=new FormData;n.append("section","general"),w(".opaljob-uploader-files",this).each(function(){w("input.select-file",this);var o=w(".uploader-item-preview",this),a=w(this).data("name"),i=w(this).data("single");w(o).each(function(o,e){var t=w(this).prop("file");t&&(i?n.append(a,t):n.append(a+"["+o+"]",t))})});var o=w(this).serializeArray();return w.each(o,function(o,e){n.append(e.name,e.value)}),n.append("action","opaljob_apply_job_data"),a.makeAjax(n,w(":submit",this),function(o){},!0),!1})},followEmployer:function(){w("body").delegate(".job-following-button","click",function(){var e=w(this);if(!w(this).hasClass("opaljob-need-login")){var o="employer_id="+w(this).data("employer-id")+"&action=opaljob_following_employer";a.makeAjax(o,w(this),function(o){o.html&&e.replaceWith(w(o.html))});var t=w(e).parent().parent();return t.hasClass("has-toggle-remove")&&t.remove(),!1}})},favorite:function(){w("body").delegate(".job-toggle-favorite","click",function(){var e=w(this);if(!w(this).hasClass("opaljob-need-login")){var o="job_id="+w(this).data("job-id")+"&action=opaljob_toggle_status";a.makeAjax(o,w(this),function(o){o.html&&e.replaceWith(w(o.html))})}}),w("body").delegate(".job-remove-favorite","click",function(){var o="job_id="+w(this).data("job-id")+"&action=opaljob_toggle_status",e=w(this);return a.makeAjax(o,w(this),function(o){w(e).parent().parent().remove(),o.html&&e.replaceWith(w(o.html))}),!1})},submitForm:function(){}};w(document).ready(function(){w(a.init)});var s={init:function(){s.changePassword()},makeAjax:function(o,e,t,a){var i=!0;1==a&&(i=!1),s.toggleSubmit(e),w.ajax({url:opaljobJS.ajaxurl,data:o,type:"POST",processData:i,contentType:i,dataType:"json",success:function(o){if(1==o.status){if(o.redirect)setTimeout(function(){window.location.href=o.redirect},3e3);t(o);w.toast({heading:o.heading,text:o.message,icon:"success",position:"bottom-right",hideAfter:4e3,showHideTransition:"fade"});s.toggleSubmit(e)}else{s.toggleSubmit(e);w.toast({heading:o.heading,text:o.message,icon:"error",position:"bottom-right",hideAfter:4e3,showHideTransition:"fade"})}}})},toggleSubmit:function(o){"disabled"==w(o).attr("disabled")?(w(o).removeAttr("disabled"),w(o).find("i").remove()):(w(o).attr("disabled","disabled"),w(o).append(' <i class="fa fa-spinner fa-spin"></i> '))},metaboxForm:function(){w(".opaljob-submited-form").submit(function(){var n=new FormData;n.append("section","general"),w(".opaljob-uploader-files",this).each(function(){w("input.select-file",this);var o=w(".uploader-item-preview",this),a=w(this).data("name"),i=w(this).data("single");w(o).each(function(o,e){var t=w(this).prop("file");t&&(i?n.append(a,t):n.append(a+"["+o+"]",t))})});var o=w(this).serializeArray();w.each(o,function(o,e){n.append(e.name,e.value)}),n.append("action","opaljob_submitted_job_data"),s.makeAjax(n,w(":submit",this),function(o){},!0)})},changePassword:function(){w("#opaljob-changepassword-form").submit(function(){return s.makeAjax(w(this).serialize()+"&action=opaljob_save_changepass",w("button:submit",this)),!1})}};w(s.init);function o(o,e){!function(o,e){var t=o,a=t.icon,i=new google.maps.Size(42,57);1.5<window.devicePixelRatio&&t.retinaIcon&&(a=t.retinaIcon,i=new google.maps.Size(83,113));var n,s,r=new google.maps.LatLng(t.latitude,t.longitude),l={center:r,zoom:15,mapTypeId:google.maps.MapTypeId.ROADMAP,scrollwheel:!1},p=new google.maps.Map(document.getElementById(e),l);new google.maps.InfoWindow;n=r,s={url:a,size:i,scaledSize:new google.maps.Size(32,57),origin:new google.maps.Point(0,0),anchor:new google.maps.Point(21,56)},new google.maps.Marker({map:p,position:n,icon:s})}(o,e)}var e={init:function(){e.trigger()},trigger:function(){w(".job-preview-map").each(function(){new o(w(this).data(),w(this).attr("id"))})}};w(document).ready(function(){w(e.init)});function t(o,e){!function(o,e){for(var t={zoom:12,maxZoom:16,scrollwheel:!1,mapTypeId:google.maps.MapTypeId.ROADMAP,panControl:!1,zoomControl:!0,mapTypeControl:!1,scaleControl:!1,streetViewControl:!0,overviewMapControl:!1,zoomControlOptions:{style:google.maps.ZoomControlStyle.SMALL,position:google.maps.ControlPosition.RIGHT_TOP},streetViewControlOptions:{position:google.maps.ControlPosition.RIGHT_TOP}},p=new google.maps.Map(document.getElementById("opaljob-search-map-preview"),t),a=new google.maps.LatLngBounds,c=new Array,i=0;i<o.length;i++){var n=o[i].icon,s=new google.maps.Size(42,57);1.5<window.devicePixelRatio&&o[i].retinaIcon&&(n=o[i].retinaIcon,s=new google.maps.Size(83,113));var r={url:n,size:s,scaledSize:new google.maps.Size(30,51),origin:new google.maps.Point(0,0),anchor:new google.maps.Point(21,56)};c[i]=new google.maps.Marker({position:new google.maps.LatLng(o[i].lat,o[i].lng),map:p,icon:r,title:o[i].title,animation:google.maps.Animation.DROP,visible:!0}),a.extend(c[i].getPosition());var l=document.createElement("div"),m="";if(o[i].pricelabel&&(m=" / "+o[i].pricelabel),l.className="map-info-preview media",e)l.innerHTML=e(o[i]);else{var d='<ul class="list-inline job-meta-list">';if(o[i].metas)for(var u in o[i].metas){var g=o[i].metas[u];d+='<li><i class="icon-job-'+u+'"></i>'+g.value+'<span class="label-job">'+g.label+"</span></li>"}d+="</ul>",l.innerHTML='<div class="media-top"><a class="thumb-link" href="'+o[i].url+'"><img class="prop-thumb" src="'+o[i].thumb+'" alt="'+o[i].title+'"/></a>'+o[i].status+'</div><div class="info-container media-body"><h5 class="prop-title"><a class="title-link" href="'+o[i].url+'">'+o[i].title+'</a></h5><p class="prop-address"><em>'+o[i].address+'</em></p><p><span class="price text-primary">'+o[i].pricehtml+m+"</span></p>"+d+'</div><div class="arrow-down"></div>'}var f={content:l,disableAutoPan:!0,maxWidth:0,alignBottom:!0,pixelOffset:new google.maps.Size(-122,-48),zIndex:null,closeBoxMargin:"0 0 -16px -16px",closeBoxURL:opaljobJS.mapiconurl+"close.png",infoBoxClearance:new google.maps.Size(1,1),isHidden:!1,pane:"floatPane",enableEventPropagation:!1},h=new InfoBox(f);j(p,c[i],h,i)}var b=null;w("body").delegate('[data-related="map"]',"mouseenter",function(){if(w(this).hasClass("map-active"))return!0;var o=w(this).data("id");if(w('[data-related="map"]').removeClass("map-active"),w(this).addClass("active"),p.setZoom(65536),c[o]){var e=c[o];google.maps.event.trigger(c[o],"click");var t=Math.pow(2,p.getZoom()),a=100/t||0,i=p.getProjection(),n=e.getPosition(),s=i.fromLatLngToPoint(n),r=new google.maps.Point(s.x,s.y-a),l=i.fromPointToLatLng(r);p.setZoom(t),p.setCenter(l)}return!1}),p.fitBounds(a);var v={ignoreHidden:!0,maxZoom:14,styles:[{textColor:"#000000",url:opaljobJS.mapiconurl+"cluster-icon.png",height:51,width:30}]};new MarkerClusterer(p,c,v);function j(r,l,p,c){google.maps.event.addListener(l,"click",function(){if(0<w('[data-related="map"]').filter('[data-id="'+c+'"]').length){var o=w('[data-related="map"]').filter('[data-id="'+c+'"]');w('[data-related="map"]').removeClass("map-active"),o.addClass("map-active")}null!=b&&b.close();var e=100/Math.pow(2,r.getZoom())||0,t=r.getProjection(),a=l.getPosition(),i=t.fromLatLngToPoint(a),n=new google.maps.Point(i.x,i.y-e),s=t.fromPointToLatLng(n);r.setCenter(s),p.open(r,l),b=p})}}(o,e)}var r={init:function(){r.triggerSearchJobs(),r.triggerSearchCandidates(),r.triggerSearchEmployers()},updatePreviewGoogleMap:function(o,e){w.ajax({type:"GET",dataType:"json",url:opaljobJS.ajaxurl,data:o,success:function(o){new t(o,e)}})},updateResults:function(o,e){w.ajax({type:"GET",url:opaljobJS.ajaxurl,data:o,success:e})},triggerSearchJobs:function(){if(0<w("form.opaljob-form-search-jobs").length&&0<w("#opaljob-search-map-preview").length){var a=function(o){if(0<w("#opaljob-search-map-preview").length){var e=location.search.substr(1)+"&action=opaljob_get_jobs_map&paged=0";o&&(e+="&"+o),r.updatePreviewGoogleMap(e)}};a(null),w("form.opaljob-form-search-jobs").submit(function(){var o=w(this).serialize();if(a(o),function(o){if(0<w(".opaljob-collection-results").length){var e=location.search.substr(1)+"&action=opaljob_get_html_search_jobs&paged=0";o&&(e+="&"+o),r.updateResults(e,function(o){var e=w(o).find(".opaljob-collection-results").html();w(".opaljob-collection-results").html(e)})}}(o),history.pushState){var e=w(this).serialize(),t=window.location.protocol+"//"+window.location.host+window.location.pathname+"?"+e;window.history.pushState({path:t},"",t)}return!1}),w("form.opaljob-form-search-jobs .form-checkbox-control").change(function(){w("form.opaljob-form-search-jobs").submit()}),w("form.opaljob-form-search-jobs .form-control").change(function(){w("form.opaljob-form-search-jobs").submit()})}},triggerSearchCandidates:function(){if(0<w("#opaljob-search-map-candidates").length){var i=w("#opaljob-search-map-candidates"),n=function(o){var e=location.search.substr(1)+"&action=opaljob_get_candidates_map&paged="+page;o&&(e+="&"+o),0<w("#opaljob-search-map-preview").length&&r.updatePreviewGoogleMap(e,function(o){return"hacongtien"})};n(null),w("form .form-checkbox-control").change(function(){w("form",i).submit()}),w("form .form-control",i).change(function(){w("form",i).submit()}),w("form",i).submit(function(){var o=w(this).serialize(),e=location.search.substr(1)+"&action=opaljob_get_html_search_candidates&paged=0";if(o&&(e+="&"+o),n(o),r.updateResults(e,function(o){var e=w(o).find(".opaljob-candidates-results").html();w(".opaljob-candidates-results",i).html(e)}),history.pushState){var t=w(this).serialize(),a=window.location.protocol+"//"+window.location.host+window.location.pathname+"?"+t;window.history.pushState({path:a},"",a)}return!1})}},triggerSearchEmployers:function(){if(0<w("#opaljob-search-map-employers").length){var i=w("#opaljob-search-map-employers"),n=function(o){var e=location.search.substr(1)+"&action=opaljob_get_employers_map&paged="+page;o&&(e+="&"+o),0<w("#opaljob-search-map-preview").length&&r.updatePreviewGoogleMap(e,function(o){return"hacongtien"})};n(null),w("form .form-checkbox-control").change(function(){w("form",i).submit()}),w("form .form-control",i).change(function(){w("form",i).submit()}),w("form",i).submit(function(){var o=w(this).serialize(),e=location.search.substr(1)+"&action=opaljob_get_html_search_employers&paged=0";if(o&&(e+="&"+o),n(o),r.updateResults(e,function(o){var e=w(o).find(".opaljob-employers-results").html();w(".opaljob-employers-results",i).html(e)}),history.pushState){var t=w(this).serialize(),a=window.location.protocol+"//"+window.location.host+window.location.pathname+"?"+t;window.history.pushState({path:a},"",a)}return!1})}}};w(document).ready(function(){w(r.init)});var i={init:function(){i.trigger()},trigger:function(){w("select.form-control").select2({})}};w(document).ready(function(){w(i.init)});var n={init:function(){n.trigger(),n.tabs()},tabs:function(){w(".opaljob-tab .tab-item").click(function(o){o.preventDefault(),w(this).parent().find(" .tab-item").removeClass("active"),w(this).addClass("active"),w(w(this).attr("href")).parent().children(".opaljob-tab-content").removeClass("active"),w(w(this).attr("href")).addClass("active")}),w(".opaljob-tab").each(function(){w(this).find(".tab-item").first().click()})},trigger:function(){w("body").delegate(".opaljob-popup-button","click",function(){var o=w(this).data("target");return w.magnificPopup.open({items:{src:o}}),!1}),w(document).on("opaljob:login",function(){w("#opaljob-user-form-popup")&&w.magnificPopup.open({items:{src:"#opaljob-user-form-popup"},mainClass:"mfp-with-zoom",zoom:{enabled:!0}})}),w("body").delegate(".opaljob-need-login","click",function(){w(document).trigger("opaljob:login",[!0]);w.toast({heading:"User login",text:"Please login the site to complete the action.",icon:"warning",position:"bottom-right",hideAfter:5e3,showHideTransition:"fade"});return!1})}};w(document).ready(function(){w(n.init)})}(jQuery);