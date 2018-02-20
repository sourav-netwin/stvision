// ! Your application

(function($, window, document, undefined){
	
	// Put all JS you need additionally to script.js here

	})(jQuery, this, document);

function checkNewBOAlert(){
	$.ajax({
		url: siteUrl+'ticketmanagement/checkAnyBOAlert',
		type: 'POST',
		data: {},
		success: function(data){
			if(data > 0){
				$('#tktbomgt #BoNotif').html('&nbsp;&nbsp<span class="blink_me notif_ico" title="New Ticket">T('+data+')</span>');
			}
			else{
				$('#tktbomgt #BoNotif').html('');
			}
		}
	});
}
function checkNewCMAlert(){
	$.ajax({
		url: siteUrl+'ticketmanagement/checkAnyCMAlert',
		type: 'POST',
		data: {},
		success: function(data){
			if(data > 0){
				$('#mngTkt #CmNotif').html('&nbsp;&nbsp<span class="blink_me notif_ico" title="New Reply">R('+data+')</span>');
			}
			else{
				$('#mngTkt #CmNotif').html('');
			}
		}
	});
}
$(function(){
	checkNewBOAlert();
	checkNewCMAlert();	
});



function scrollPageToTop(){
	$('html, body').animate({
		scrollTop: '0px'
	}, 300);
}