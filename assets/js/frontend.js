!function(s){"use strict";var a={init:function(){a.submitForm(),a.favorite(),a.followEmployer(),a.applyJob(),a.sendMessage(),a.submitJob()},makeAjax:function(t,e,i,a){var o=!0;1==a&&(o=!1),n.toggleSubmit(e),s.ajax({url:opaljobJS.ajaxurl,data:t,type:"POST",processData:o,contentType:o,dataType:"json",success:function(t){if(1==t.status){if(t.redirect)setTimeout(function(){window.location.href=t.redirect},3e3);i(t);s.toast({heading:t.heading,text:t.message,icon:"success",position:"bottom-right",hideAfter:4e3,showHideTransition:"fade"});n.toggleSubmit(e)}else{n.toggleSubmit(e);s.toast({heading:t.heading,text:t.message,icon:"error",position:"bottom-right",hideAfter:4e3,showHideTransition:"fade"})}}})},submitJob:function(){s(".opaljob-submited-form").on("submit",function(){var n=new FormData;n.append("section","general"),s(".opaljob-uploader-files",this).each(function(){s("input.select-file",this);var t=s(".uploader-item-preview",this),a=s(this).data("name"),o=s(this).data("single");s(t).each(function(t,e){var i=s(this).prop("file");i&&(o?n.append(a,i):n.append(a+"["+t+"]",i))})});var t=s(this).serializeArray();return s.each(t,function(t,e){n.append(e.name,e.value)}),n.append("action","opaljob_submitted_job_data"),a.makeAjax(n,s(":submit",this),function(t){},!0),!1})},sendMessage:function(){s(".opaljob-message-form").on("submit",function(){var t=s(this).serialize()+"&action=opaljob_send_email_contact";return a.makeAjax(t,s(":submit",this),function(){}),!1})},toggleSubmit:function(t){"disabled"==s(t).attr("disabled")?(s(t).removeAttr("disabled"),s(t).find("i").remove()):(s(t).attr("disabled","disabled"),s(t).append(' <i class="fa fa-spinner fa-spin"></i> '))},applyJob:function(){s("body").delegate(".job-apply-now","click",function(){s(this);if(!s(this).hasClass("opaljob-need-login"))return s("#opaljob-apply-form-popup")&&s.magnificPopup.open({items:{src:"#opaljob-apply-form-popup"},closeOnBgClick:!1,mainClass:"mfp-with-zoom",zoom:{enabled:!0}}),!1}),s(".opaljob-apply-job-form").submit(function(){var n=new FormData;n.append("section","general"),s(".opaljob-uploader-files",this).each(function(){s("input.select-file",this);var t=s(".uploader-item-preview",this),a=s(this).data("name"),o=s(this).data("single");s(t).each(function(t,e){var i=s(this).prop("file");i&&(o?n.append(a,i):n.append(a+"["+t+"]",i))})});var t=s(this).serializeArray();return s.each(t,function(t,e){n.append(e.name,e.value)}),n.append("action","opaljob_apply_job_data"),a.makeAjax(n,s(":submit",this),function(t){},!0),!1})},followEmployer:function(){s("body").delegate(".job-following-button","click",function(){var e=s(this);if(!s(this).hasClass("opaljob-need-login")){var t="employer_id="+s(this).data("employer-id")+"&action=opaljob_following_employer";a.makeAjax(t,s(this),function(t){t.html&&e.replaceWith(s(t.html))});var i=s(e).parent().parent();return i.hasClass("has-toggle-remove")&&i.remove(),!1}})},favorite:function(){s("body").delegate(".job-toggle-favorite","click",function(){var e=s(this);if(!s(this).hasClass("opaljob-need-login")){var t="job_id="+s(this).data("job-id")+"&action=opaljob_toggle_status";a.makeAjax(t,s(this),function(t){t.html&&e.replaceWith(s(t.html))})}}),s("body").delegate(".job-remove-favorite","click",function(){var t="job_id="+s(this).data("job-id")+"&action=opaljob_toggle_status",e=s(this);return a.makeAjax(t,s(this),function(t){s(e).parent().parent().remove(),t.html&&e.replaceWith(s(t.html))}),!1})},submitForm:function(){}};s(document).ready(function(){s(a.init)});var n={init:function(){n.changePassword()},makeAjax:function(t,e){n.toggleSubmit(e),s.ajax({url:opaljobJS.ajaxurl,data:t,type:"POST",dataType:"json",success:function(t){if(1==t.status){t.redirect&&(window.location.href=t.redirect);s.toast({heading:t.heading,text:t.message,icon:"success",position:"bottom-right",hideAfter:5e3,showHideTransition:"fade"})}else{n.toggleSubmit(e);s.toast({heading:t.heading,text:t.message,icon:"error",position:"bottom-right",hideAfter:5e3,showHideTransition:"fade"})}}})},toggleSubmit:function(t){"disabled"==s(t).attr("disabled")?(s(t).removeAttr("disabled"),s(t).find("i").remove()):(s(t).attr("disabled","disabled"),s(t).append(' <i class="fa fa-spinner fa-spin"></i> '))},changePassword:function(){s("#opaljob-changepassword-form").submit(function(){return n.makeAjax(s(this).serialize()+"&action=opaljob_save_changepass",s("button:submit",this)),!1})}};s(n.init);var t={init:function(){t.trigger(),t.tabs()},tabs:function(){s(".opaljob-tab .tab-item").click(function(t){t.preventDefault(),s(this).parent().find(" .tab-item").removeClass("active"),s(this).addClass("active"),s(s(this).attr("href")).parent().children(".opaljob-tab-content").removeClass("active"),s(s(this).attr("href")).addClass("active")}),s(".opaljob-tab").each(function(){s(this).find(".tab-item").first().click()})},trigger:function(){s("body").delegate(".opaljob-popup-button","click",function(){var t=s(this).data("target");return s.magnificPopup.open({items:{src:t}}),!1}),s(document).on("opaljob:login",function(){s("#opaljob-user-form-popup")&&s.magnificPopup.open({items:{src:"#opaljob-user-form-popup"},mainClass:"mfp-with-zoom",zoom:{enabled:!0}})}),s("body").delegate(".opaljob-need-login","click",function(){s(document).trigger("opaljob:login",[!0]);s.toast({heading:"User login",text:"Please login the site to complete the action.",icon:"warning",position:"bottom-right",hideAfter:5e3,showHideTransition:"fade"});return!1})}};s(document).ready(function(){s(t.init)})}(jQuery);