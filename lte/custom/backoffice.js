$('.goToDetail').on('click', function(e){
	e.preventDefault();
	passingData = $(this).attr("id").split("__");
	loadBookingDetail(passingData[1]);
});	
function loadBookingDetail(bookId,tab){
	removeModal('viewDashboardDetailModal');
	var url = siteUrl+'backoffice/newAvail/'+bookId;
	if(tab != '' && typeof tab != 'undefined'){
		url = siteUrl+'backoffice/newAvail/'+bookId+'/'+tab;
	}
	$.ajax({
		url: url,
		type: 'POST',
		data: {},
		success: function(data){
			if(data){
				createModal('viewDashboardDetailModal','Bookings detail',data,'large');
				$("#B_active").datepicker({
					dateFormat: "dd/mm/yy",
					maxDate: $('#maxNoLmDate').val()
				});
				if($("#lm_flag").prop("checked")){
					$( "#B_active" ).datepicker( "option", "maxDate", $('#maxLmDate').val() );
				}
				$( ".chooseDate1" ).datepicker({
					numberOfMonths: 1,
					dateFormat: "dd/mm/yy",
					onSelect: function() {
						var idToChange = $(this).attr("id").split("__");
						changeIdIs="data_partenza_campus";
						dataGirata = parseDate($(this).val());
						alert(dataGirata);
						$( "#"+changeIdIs ).datepicker( "option", "minDate", new Date(dataGirata) );
					}
				});	
				$( ".chooseDate2" ).datepicker({
					numberOfMonths: 1,
					dateFormat: "dd/mm/yy",
					onClose: function() {
						var idToChange = $(this).attr("id").split("__");
						changeIdIs="andata_data_arrivo__"+idToChange[1];
						dataGirata = parseDate($(this).val());
						$( "#"+changeIdIs ).datepicker( "option", "maxDate", new Date(dataGirata) );
					}
				});	
				$( ".chooseDOB" ).datepicker({
					numberOfMonths: 1,
					dateFormat: "dd/mm/yy"
				});	
				$( ".chooseDateTime1" ).datepicker({
					numberOfMonths: 1,
					dateFormat: "dd/mm/yy",
					autoSize: false
				//format: "dd/mm/yy HH:ii"
				});	
				$( ".chooseDateTime2" ).datepicker({
					numberOfMonths: 1,
					dateFormat: "dd/mm/yy",
					autoSize: false
				//format: "dd/mm/yy HH:ii"
				});		
				$( "#ora_arrivo_volo" ).timepicker({
					showMeridian: false,
					minuteStep: 1
				}).on('show.timepicker', function(e) {
					$("i.icon-chevron-down").each(function(){
						$(this).addClass("glyphicon");
						$(this).addClass("glyphicon-chevron-down");
					});
					$("i.icon-chevron-up").each(function(){
						$(this).addClass("glyphicon");
						$(this).addClass("glyphicon-chevron-up");
					});				
				});	
				$( "#ora_partenza_volo" ).timepicker({
					showMeridian: false,
					minuteStep: 1
				}).on('show.timepicker', function(e) {
					$("i.icon-chevron-down").each(function(){
						$(this).addClass("glyphicon");
						$(this).addClass("glyphicon-chevron-down");
					});
					$("i.icon-chevron-up").each(function(){
						$(this).addClass("glyphicon");
						$(this).addClass("glyphicon-chevron-up");
					});				
				});
			}
			else{
				swal('Error', 'No records found');
			}
		},
		error: function(){
			swal('Error', 'No records found');
		}
	});
}

	
	
/*Start: For tab a*/
$('body').on('click','#printVisaPax', function(e){
	e.preventDefault();
	var elm = $(this);
	var bookId = elm.attr('data-book');
	if(bookId !== '' && typeof bookId != 'undefined'){
		
		$.ajax({
			url: siteUrl+'backoffice/checkLockPax/'+bookId,
			type: 'POST',
			data: {},
			success: function(data){
				var pax_status = jQuery.parseJSON(data);
				if(pax_status.status == 1){
					$.ajax({
						url: siteUrl+'backoffice/visaTemplates/'+bookId,
						type: 'POST',
						data: {},
						success: function(data){
							if(data){
								createModal('viewDashboardPrintModal','Select template',data,'small');
								$('#boTmplSelForm').validate();
							}
							else{
								swal('Error', 'No records found');
							}
						},
						error: function(){
							swal('Error', 'No records found');
						}
					});
				}
				else{
					swal('Error', 'No pax locked');
				}
			},
			error: function(){
				swal('Error', 'No records found');
			}
		});
		
		
	}
});
	
$('body').on('submit','#boTmplSelForm', function(e){
	e.preventDefault();
	var templ = $('#templSelWhole').val();
	var bookId = $('#visaTmplBook').val();
	window.open(siteUrl+"backoffice/pdf_visas/"+bookId+"/"+templ);
});
function bConfirm(){
	var bookId = $('#bkDetBookId').val();
	confirmAction("Are you sure you want to confirm this booking?", function(s){
		if(s){
			$.ajax({
				url: siteUrl + "backoffice/change_booking_status/"+bookId+"/confirmed",
				success: function(html){
					loadBookingDetail(bookId);
                                        var urlStr = siteUrl + "mapbookings/generateinvoice/"+bookId+'/json';
                                        $.post( urlStr,{}, function( data ) {
                                            if(data.result != 0)
                                            {
                                                swal("Success",data.message);
                                            }
                                            else
                                            {
                                                swal("Alert",data.message);
                                            }
                                        },'json');
				}
			});
		}
	},true,true);
}

function bReject(){
	var bookId = $('#bkDetBookId').val();
	confirmAction("Are you sure you want to reject this booking?", function(s){
		if(s){
			$.ajax({
				url: siteUrl + "backoffice/change_booking_status/"+bookId+"/rejected",
				success: function(html){
					loadBookingDetail(bookId);
				}
			});
		}
	},true,true);
}
	
function bPaid(){
	var bookId = $('#bkDetBookId').val();
	confirmAction("Are you sure you want to notify to operator the payment for this booking?", function(s){
		if(s){
			$.ajax({
				url: siteUrl + "backoffice/add_flag_payment/"+bookId,
				success: function(html){
					loadBookingDetail(bookId);
				}
			});
		}
	},true,true);
}	
	
function bCleared(){
	var bookId = $('#bkDetBookId').val();
	confirmAction("Are you sure you want to clear this booking for departure?", function(s){
		if(s){
			$.ajax({
				url: siteUrl + "backoffice/add_flag_cfd/"+bookId,
				success: function(html){
					loadBookingDetail(bookId);
				}
			});
		}
	},true,true);
}
	
function bCheckPaid(){
	var bookId = $('#bkDetBookId').val();
	confirmAction("Are you sure you want to notify to accounting to check the payment for this booking?", function(s){
		if(s){
			$.ajax({
				url: siteUrl + "backoffice/add_flag_checkPay/"+bookId,
				success: function(html){
					location.reload();
				}
			});
		}
	},true,true);
}		
	
function bActivate(){
	var bookId = $('#bkDetBookId').val();
	var lmFlag = 0;
	if($("#lm_flag").prop("checked"))
		lmFlag = 1;
	var DatKo = $("#B_active").val().split("/");
	var Yok = DatKo[2];
	var Mok = DatKo[1];
	var Dok = DatKo[0];
	var DatOk = DatKo[0]+"-"+DatKo[1]+"-"+DatKo[2];
	confirmAction("Are you sure you want to activate this booking until "+$("#B_active").val()+"?", function(s){
		if(s){
			$.ajax({
				url: siteUrl + "backoffice/change_booking_status/"+bookId+"/active/"+DatOk+"/"+lmFlag,
				success: function(html){
					loadBookingDetail(bookId);
				}
			});
		}
	},true,true);
}
$('body').on('click',"#B_cambiaStato",function(){
	if($("#statusBooking").val()=="B_reject"){
		bReject();
	}
	if($("#statusBooking").val()=="B_activate"){
		bActivate();
	}
	if($("#statusBooking").val()=="B_confirm"){
		bConfirm();
	}			
});
$('body').on('click',"#B_checkPayment",function(){
	bCheckPaid();
});
$('body').on('click',"#B_setOvernight",function(){
	var bookId = $('#bkDetBookId').val();
	var yearId = $('#yearId').val();
	if($("#durationOvernight").val()=="" || $("#periodOvernight").val()=="" || $("#campusOvernight").val()==""){
		swal("Error","Please set duration, period and campus for overnight");
		return false;
	}else{
		$("#B_setOvernight").attr("disabled",true);
		$.ajax({
			method: "POST",
			url: siteUrl + "backoffice/newDuplicateOvernight",
			data: "tWhen=" + $("#periodOvernight").val() + "&tNights=" + $("#durationOvernight").val() + "&tCampus=" + $("#campusOvernight").val() + "&tRef="+bookId
		}).done(function(html){
			if(html=="ok"){
				swal("Success","Overnight for booking "+yearId+"_"+bookId+" has been setted!");
				$("#overnightBox").hide();
			}
		});
		return false;
	}
});
$('body').on('click',"#B_confermaBooking",function(){
	if($("#statusBookingFinCon").val()=="B_confirm"){
		bConfirm();
	}
	if($("#statusBookingFinCon").val()=="B_reject"){
		bReject();
	}			
});	

$('body').on('click',"#B_notificaCleared",function(){
	if($("#statusClearedFinCon").val()=="B_cleared"){
		bCleared();
	}
});
$('body').on('change',"#statusBooking",function(){
	if($(this).val()=="B_reject"){
		$("#B_active").attr("disabled",true);
		$("#lm_flag").attr("disabled",true);
	}
	if($(this).val()=="B_activate"){
		$("#B_active").prop("disabled",false);
		$("#lm_flag").prop("disabled",false);
	}
});

$('body').on('change',"#lm_flag",function(){
	if($(this).prop("checked")){
		$( "#B_active" ).datepicker( "option", "maxDate", $('#maxLmDate').val() );
	}else{
		$( "#B_active" ).datepicker( "setDate", $('#maxNoLmDate').val() );
		$( "#B_active" ).datepicker( "option", "maxDate", $('#maxNoLmDate').val() );
	}
});

$('body').on('click',"#B_setOvernight",function(){
	if($("#durationOvernight").val()=="" || $("#periodOvernight").val()=="" || $("#campusOvernight").val()==""){
		swal("Error","Please set duration, period and campus for overnight");
		return false;
	}else{
		$("#B_setOvernight").attr("disabled",true);
		$.ajax({
			method: "POST",
			url: siteUrl + "backoffice/newDuplicateOvernight",
			data: "tWhen=" + $("#periodOvernight").val() + "&tNights=" + $("#durationOvernight").val() + "&tCampus=" + $("#campusOvernight").val() + "&tRef=<?php echo $storeId; ?>"
		}).done(function(html){
			if(html=="ok"){
				swal("Success","Overnight for booking "+$('#yearId').val()+"_"+$('#bkDetBookId').val()+" has been setted!");
				$("#overnightBox").hide();
			}
		});
		return false;
	}
});
/*End: For tab a*/
	
/*Start: For tab b*/
$(document).on('change', '#tipo_pax', function(){
	var val = $(this).val();
	if(val == 'GL'){
		$('#suppl-div').hide();
		$('#suppl').val('');
		$('#suppl').attr('disabled', 'disabled');
	}
	else{
		$('#suppl-div').show();
		$('#suppl').val('');
		$('#suppl').removeAttr('disabled');
	}
			
});
$('body').on('click','#unlockBookingRoster',function(){
	confirmAction("Are you sure you want to unlock roster for this payment?", function(s){
		if(s){
			var bookId = $('#bkDetBookId').val();
			$.ajax({
				url: siteUrl + "backoffice/unlockRoster/"+bookId,
				success: function(html){
					loadBookingDetail(bookId,'b');
				}
			});
		}
	},false,true);
});
$('body').on('click','#addRosterPax',function(){
	confirmAction("Are you sure you want to add a pax to the booking?", function(s){
		if(s){
			var bookId = $('#bkDetBookId').val();
			$.ajax({
				url: siteUrl + "backoffice/addRosterPax/"+bookId,
				success: function(html){
					loadBookingDetail(bookId,'b');
                                        generateNewInvoiceForBooking(siteUrl,bookId);
				}
			});
		}
	},true,true);
});

$('body').on('click','.paxModClass',function(){
	var bookId = $('#bkDetBookId').val();
	var paxKo = $(this).attr("id").split("_");
	var idToMod = paxKo[1];
	$.ajax({
		url: siteUrl+"backoffice/modRosterPax/"+idToMod+"/"+bookId,
		type: 'POST',
		data: {},
		success: function(data){
			if(data){
				createModal('paxRowEditModal','Pax editing',data);
				$('#postaPax').validate({
					messages: {
						cognome: "Please enter surname",
						nome: "Please enter name",
						sesso: "Please select sex",
						pax_dob: "Please enter date of birth",
						nazionalita: "Please enter citizenship",
						numero_documento: "Please enter passport number",
						data_arrivo_campus: "Please enter campus date in",
						data_partenza_campus: "Please enter campus date out",
						andata_data_arrivo: "Please enter arrival flight date",
						ritorno_data_partenza: "Please enter departure flight date",
						andata_apt_partenza: "Please enter departure airport",
						ritorno_apt_arrivo: "Please enter arrival airport"
					}
				});
				initDatePicker();
				initTimepicker();
			}
			else{
				swal('Error', 'No records found');
			}
		},
		error: function(){
			swal('Error', 'No records found');
		}
	});
	$("#modalBody").load(siteUrl + "backoffice/modRosterPax/"+idToMod+"/"+bookId);
	$('#myModal').modal()
});	

$('body').on('click', '.paxUnlClass', function(e){
	e.preventDefault();
	var elm = $(this);
	confirmAction("Are you sure to unlock roster?", function(s){
		if(s){
			var parent = elm.parent().parent().parent().parent();
			var rowId = elm.attr('id').replace('paxUnl_', '');
			$.ajax({
				url: siteUrl + 'backoffice/unlockSingleRoster',
				type: 'POST',
				data: {
					rowId: rowId
				},
				success: function(data){
					if(data == 1){
						elm.remove();
						parent.find('.locked').remove();
						swal('Success','Roster unlocked successfully');
					}
					else{
						swal('Error','Failed to unlock Roster');
					}
				},
				error: function(){
					swal('Error','Failed to unlock Roster');
				}
			});
		}
	},false,true);
		
});
$('body').on('submit', '#postaPax', function(e){
	e.preventDefault();
	var url = $('#postaPax').attr('action');
	var bookId = $('#bkDetBookId').val();
	$.ajax({
		url: url,
		type: 'POST',
		data: $('#postaPax').serialize(),
		success: function(data){
			if(data == 1){
				removeModal('paxRowEditModal');
				swal('Success', 'Pax details updated successfully');
				loadBookingDetail(bookId,'b');
			}
			else{
				swal('Error', 'Failed to update pax details');
			}
		},
		error: function(){
			swal('Error', 'Failed to update pax details');
		}
	});
});
$('body').on('input focus',".airport_ac",function(){
	$(".airport_ac").autocomplete({
		source: function (request, response) {
			$.ajax({
				url: siteUrl+"backoffice/searchAP",
				dataType: "json",
				data: {
					style: "full",
					term: request.term
				},
				success: function( data ) {
					response( $.map( data.airports, function( item ) {
						return {
							id: item.id,
							label: item.value,
							value: item.value
						}
					}));
				}
			});					
		},
		minLength: 3
	});	
});

$('body').on('input focus',".nationality_ac",function(){			
	$(".nationality_ac").autocomplete({
		source: function (request, response) {
			$.ajax({
				url: siteUrl+"backoffice/searchNat",
				dataType: "json",
				data: {
					style: "full",
					term: request.term
				},
				success: function( data ) {
					response( $.map( data.nationalities, function( item ) {
						return {
							id: item.id,
							label: item.value,
							value: item.value
						}
					}));
				}
			});					
		},
		minLength: 3
	});	
});
$(document).on('blur', '.nationality_ac', function(){
	var elm = $(this);
	var nationality = elm.val();
	if(nationality != '' && typeof nationality != 'undefined'){
		$.ajax({
			url: siteUrl+'backoffice/checkTypedNationality',
			type: 'POST',
			data: {
				nationality: nationality
			},
			success: function(data){
				if(data != 1){
					elm.val('');
				}
			},
			error: function(){
				elm.val('');
			}
		});
	}
});

/*End: For tab b*/


/*Start: For tab e*/
$('body').on('click',"#saveNote",function(e){
	e.preventDefault();
	var bookId = $('#bkDetBookId').val();
	if($("#newNoteBk").val()==""){
		swal("Form error","Please fill the note field!");
	}else{
		var nPublic = 0;
		if($("#isPubNote").prop('checked')){
			nPublic = 1
		}
		$.ajax({
			url: siteUrl + "backoffice/insertBkNote/"+bookId,
			type: 'POST',
			data:{
				testo: $("#newNoteBk").val(), 
				utente: $('#mainfamilyname').val(), 
				notaPubblica: nPublic
			},
			success: function(data){
				if(data == 1){
					removeModal('addNewNoteModal');
					swal('Success', 'Note added successfully');
					loadBookingDetail(bookId,'e');
				}
				else{
					swal('Error','Failed to add note');
				}	
			},
			error: function(){
				swal('Error','Failed to add note');
			}
		});
	}
});
$('body').on('click',"#addBkNotes",function(){
	var html = '<div class="margin-5"><textarea class="form-control" id="newNoteBk" name="newNoteBk"></textarea><br />\n\
		<label for="isPubNote">Note is public (visible by Campus Managers)</label>&nbsp;\n\
		<input type="checkbox" name="isPubNote" id="isPubNote" value="1" />\n\
		<div class="row"><div class="col-md-12 text-center"><button type="button" id="saveNote" class="btn btn-success">Save</button></div></div></div>';
	createModal('addNewNoteModal', 'Insert note', html, 'small');	
});

$('body').on('click','.paxRemClass',function(){
	var bookId = $('#bkDetBookId').val();
	var elm = $(this);
	confirmAction("Are you sure you want to delete this pax from the booking?", function(s){
		if(s){
			var paxKo = elm.attr("id").split("_");
			var idToDel = paxKo[1];
			$.ajax({
				url: siteUrl + "backoffice/delRosterPax/"+idToDel+"/"+bookId,
				success: function(html){
					loadBookingDetail(bookId,'b');
                                        generateNewInvoiceForBooking(siteUrl,bookId);
				}
			});
		}
	},true,true);
});
/*End: For tab e*/

/**
 * This will generate booking for any old booking by giving it's id.
 */
function generateNewInvoiceForBooking(siteUrl,bookId){
    var urlStr = siteUrl + "mapbookings/generateinvoice/"+bookId+'/json';
    $.post( urlStr,{}, function( data ) {
        if(data.result != 0)
        {
            swal("Success",data.message);
        }
        else
        {
            swal("Alert",data.message);
        }
    },'json');
}


function parseDate(str) {
	var mdy = str.split('/')
	return new Date(mdy[2], mdy[1]-1, mdy[0]);
}


$('body').on('change','#data_arrivo_campus', function(){
	var dateval = $('#data_arrivo_campus').val()
	$( ".chooseDate2" ).datepicker( "option", "minDate", dateval);
	$( ".chooseDateTime1" ).datepicker( "option", "maxDate", dateval);
	$('#data_partenza_campus').change();
});
$('body').on('change','#data_partenza_campus', function(){
	var dateval = $('#data_partenza_campus').val()
	$( ".chooseDateTime2" ).datepicker( "option", "minDate", dateval);
});
$('body').on('change','#andata_data_arrivo', function(){
	var dateval = $('#andata_data_arrivo').val()
	$( ".chooseDateTime2" ).datepicker( "option", "minDate", dateval);
});
	
