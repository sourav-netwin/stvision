var oTable;
$(function(){
	oTable = initDataTable();
	initTooltip();
	//initFileInput();
	checkNewBOAlert();
	checkNewCMAlert();

	// this will work for all roles dashboard.
	$( "body" ).on( "click", ".hit-dashboard", function() {
		var dshLink = $(".sidebar-menu li span:contains('Dashboard')").parent().attr('href');
                if (typeof(dshLink) != "undefined")
                    window.location.href = dshLink;
	});
});
$(window).ready(function(){
	Pace.restart();
});
function initDataTable(id){
	var oTable;
	var tableRef = '#'+id;
	if(id == '' || typeof id == 'undefined'){
		tableRef = '.datatable';
	}
        else if ( $.fn.DataTable.isDataTable( tableRef ) ) {
            return 1;
        }
        if($(tableRef).length > 0){
            /* Create an array with the values of all the input boxes in a column */
                $.fn.dataTable.ext.order['dom-text'] = function  ( settings, col )
                {
                    return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
                        return $('input', td).val();
                    } );
                }
                /* Create an array with the values of all the input boxes in a column, parsed as numbers */
                $.fn.dataTable.ext.order['dom-text-numeric'] = function  ( settings, col )
                {
                    return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
                        //console.log($('input',td).val());
                        return $('input', td).val() * 1;
                    } );
                }

                $.fn.dataTable.ext.order['dom-html-formated-numeric'] = function  ( settings, col )
                {
                    return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
                        //console.log($(td).html().replace(/\./g,'').replace(',','.') * 1);
                        return parseFloat($(td).html().replace(/\./g,'').replace(',','.'));
                        //return ($(td).attr('data-sort')) * 1;
                    } );
                }

		/* Create an array with the values of all the select options in a column */
		$.fn.dataTable.ext.order['dom-select'] = function  ( settings, col )
		{
			return this.api().column( col, {
				order:'index'
			} ).nodes().map( function ( td, i ) {
				return $('select', td).val();
			} );
		}


                /* Create an array with the values of all the checkboxes in a column */
                $.fn.dataTable.ext.order['dom-checkbox'] = function  ( settings, col )
                {
                    return this.api().column( col, {order:'index'} ).nodes().map( function ( td, i ) {
                        return $('input', td).prop('checked') ? '1' : '0';
                    } );
                }


		oTable = $(tableRef).DataTable({
			"paging": true,
                        //"pageLength": 2,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": true,
			"responsive": true,
			"order": [],
			"sScrollX": true,
			"columnDefs": [
			{
				"targets"  : 'no-sort',
				"orderable": false
			},
			{
				"targets"  : 'col-text-numeric',
				"sSortDataType": 'dom-text-numeric'
			},
			{
				"targets"  : 'col-html-formated-numeric',
				"sSortDataType": 'dom-html-formated-numeric'
			}
			]
		});
	}
	return oTable;
}

function removeModal(id){
	$('#'+id).fadeOut('slow', function(){
		$('#'+id).remove();
		$('.modal-backdrop').first().remove();
		if($('.modalCustom').length > 0){
			$('body').addClass('modal-open');
		}
	});
}

function createModal(id, title, message,size){
	if(id == '' || typeof id == 'undefined'){
		id = 'myModal';
	}
	var html = '<div class="modal modalCustom " id="'+id+'" role="dialog" aria-labelledby="myModalLabel">\n\
					<div class="modal-dialog '+size+'" role="document">\n\
						<div class="modal-content" style="">\n\
							<div class="modal-header">\n\
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> \n\
								<h4 class="modal-title" id="myModalLabel">'+title+'</h4>\n\
							</div>\n\
							<div class="modal-body" style="display: inline"> '+message+'\n\
							</div>\n\
						</div>\n\
					</div>\n\
				</div>';
	$('body').append(html);
	$('#'+id).modal({
		backdrop: 'static',
		keyboard: true,
		show: true
	});
}

$('body').on('click', '.modalCustom [aria-label=Close]', function(e){
	e.preventDefault();
	var parent = $(this).parent().parent().parent().parent();
	parent.fadeOut('slow', function(){
		parent.remove();
		if($('.modalCustom').length > 0){
			$('body').addClass('modal-open');
		}
		$('.modal-backdrop').first().remove();
	});

});

function loading(message) {
	//Add overlay and loading img
	if(message == '' || typeof message == 'undefined'){
		message = '';
	}
	setTimeout(function(){
		//unloading();
		$('body').append('<div class="overlay"><div class="fa fa-refresh fa-spin"></div><div class="over-message">'+message+'</div></div>');
	},10);


}
function unloading() {
	//Remove overlay and loading img
	setTimeout(function(){
            $('body').find('.overlay').remove();
        }, 1000);
}

$( document ).ajaxSend(function(e, xhr, opt) {
    if(!(opt.url.indexOf("students/logquesanswer") != -1 
    || opt.url.indexOf("students/upatetimer") != -1))
    	loading();
});

$( document ).ajaxComplete(function() {
	unloading();
});

function initTooltip(){
	if($('[data-toggle="tooltip"]').length > 0){
		$('[data-toggle="tooltip"]').tooltip(
		{
			container : 'body',
			trigger : 'hover'
		}
		);
	}
}

function confirmAction(message, callback, closeOnConfirm, closeOnCancel){
	if(!message){
		message = 'Are you sure';
	}
	if(!closeOnConfirm){
		closeOnConfirm = false;
	}
	else{
		closeOnConfirm = true;
	}
	if(!closeOnCancel){
		closeOnCancel = false;
	}
	else{
		closeOnCancel = true;
	}
	swal({
		title: '',
		text: message,
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#00a65a",
		confirmButtonText: "Yes",
		closeOnConfirm: closeOnConfirm,
		closeOnCancel: closeOnCancel
	}, function(status){
		if(status){
			callback(true);
		}
		else{
			callback(false);
		}
	});

}

function swalYesNo(confirmTitle,textMessage,callback, closeOnConfirm, closeOnCancel,confirmBtnText,cancelBtnText){
        if(!confirmTitle){
		confirmTitle = 'Are you sure';
	}
        if(!confirmBtnText){
		confirmBtnText = 'Yes';
	}
        if(!cancelBtnText){
		cancelBtnText = 'No';
	}


	if(!closeOnConfirm){
		closeOnConfirm = false;
	}
	else{
		closeOnConfirm = true;
	}
	if(!closeOnCancel){
		closeOnCancel = false;
	}
	else{
		closeOnCancel = true;
	}
    swal({
        title: confirmTitle,
        text: textMessage,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#00a65a",
        cancelButtonClass: "btn-danger",
        confirmButtonText: confirmBtnText,
        cancelButtonText: cancelBtnText,
        closeOnConfirm: closeOnConfirm,
        closeOnCancel: closeOnCancel
    },
    function(isConfirm) {
        callback(isConfirm);
    });
}

function confirmLinkAction(message,actionLink){
	confirmAction(message, function(c)
	{
		if(c)
			window.location.href = actionLink;
	},true,true);
	return false;
}


$(document).on('mouseup','[data-toggle="tooltip"]:not(input[type="text"])',function(){
	$(this).blur();
});

$(document).on("input propertychange","[alpha-hyphen]", function(){
	var regexp = /[^a-zA-Z\-]/g;
	$(this).val( $(this).val().replace(regexp,'') );
});
$(document).on("input propertychange","[alpha-only]", function(){
	var regexp = /[^a-zA-Z]/g;
	$(this).val( $(this).val().replace(regexp,'') );
});

$(document).on("input propertychange","[alpha-space-only]", function(){
	var regexp = /[^a-zA-Z ]/g;
	$(this).val( $(this).val().replace(regexp,'') );
});


$(document).on("input propertychange","[alpha-numeric-only]", function(){
	var regexp = /[^a-zA-Z0-9]/g;
	$(this).val( $(this).val().replace(regexp,'') );
});
$(document).on("input propertychange","[alpha-space-numeric-only]", function(){
	var regexp = /[^a-zA-Z0-9 ]/g;
	$(this).val( $(this).val().replace(regexp,'') );
});

$(document).on("input propertychange","[numeric-only]", function(){
	var regexp = /[^0-9]/g;
	$(this).val( $(this).val().replace(regexp,'') );
});
$(document).on("input propertychange","[decimal-only]", function(){
	var regexp = /[^0-9\.]/g;
	$(this).val( $(this).val().replace(regexp,'') );
});

$("body").on("click",".box button.btn-box-tool[data-toggle='tooltip']",function() {
	var cVal = $(this).attr('data-original-title');
	if(cVal == 'Collapse')
		$(this).attr('data-original-title','Expand');
	else
		$(this).attr('data-original-title','Collapse');
	$(this).tooltip('fixTitle').tooltip('show');
});

$('body').bind('reset','form', function() {
	if($('label.error').length > 0){
		$('label.error').each(function(){
			$(this).remove();
		});
	}
});
function initDatePicker(){
	if($('.datepicker').length > 0){
		var datePicker = $('.datepicker').datepicker({
			dateFormat: "dd/mm/yy"
		});
	}
}
function initTimepicker(){
	if($('.timepicker').length > 0){
		$(".timepicker").timepicker({
			showInputs: false,
			timeFormat: 'hh:mm',
			showMeridian: false,
			minuteStep: 1
		});
	}
}

// THIS IS TO POPOVER ALL TOOLTIP USING BOOTSTRAP
$("body").on('mouseover','[data-toggle="tooltip"]', function(){
	$(this).attr('data-container','body');
});
function scrollPageToTop(){
	$('html, body').animate({
		scrollTop: '0px'
	}, 300);
}
$('body').on('click','.session-message .alert .close', function(){
	$(this).parent().parent().remove();
});
function initFileInput(){
	$("input:file").fileinput({
		'showUpload':false,
		'showPreview': false
	});
}
function checkNewBOAlert(){
	$('#tMsgAnim').remove();
	$.ajax({
		url: siteUrl+'ticketmanagement/checkAnyBOAlert',
		type: 'POST',
		data: {},
		success: function(data){
			if(data > 0){
				$('.treeview').each(function(){
					if($(this).find('a span').html() == 'Ticket management'){
						$(this).find('a span:first').after('<span class="pull-right-container mr-right-15 faa-flash animated" id="tMsgAnim"><small class="label pull-right bg-red">T('+data+')</small></span>');
					}
				});
			//$('#tktbomgt #BoNotif').html('&nbsp;&nbsp<span class="blink_me notif_ico" title="New Ticket">T('+data+')</span>');
			}
			else{
				$('#tktbomgt #BoNotif').html('');
			}
		}
	});
}
function checkNewCMAlert(){
	$('#rMsgAnim').remove();
	$.ajax({
		url: siteUrl+'ticketmanagement/checkAnyCMAlert',
		type: 'POST',
		data: {},
		success: function(data){
			if(data > 0){
				$('.treeview').each(function(){
					if($(this).find('a span').html() == 'Ticket management'){
						$(this).find('a span:first').after('<span class="pull-right-container mr-right-15 faa-flash animated" id="rMsgAnim"><small class="label pull-right bg-red">R('+data+')</small></span>');
					//$(this).html('&nbsp;&nbsp<span class="faa-flash animated notif_ico" title="New Reply">R('+data+')</span>');
					}
				});

			}
			else{
				$('#mngTkt #CmNotif').html('');
			}
		}
	});
}
$('.modal').on('shown.bs.modal', function() {
	setTimeout(function(){
		Pace.stop();
	},2000);
	Pace.stop();
});
$(document).ready(function(){
	$('textarea.editor').each(function(){
	    var $input = $(this),
	      isFull = $input.hasClass('full');
	    $input.cleditor({
	      width: isFull ? 'auto' : '100%',
	      height: '250px',
	      bodyStyle: 'margin: 10px; font: 12px Arial,Verdana; cursor:text',
	      useCSS: true
	    });
	    isFull && $input.parents('.cleditorMain').addClass('full');
	});

	//For tinymce editor
	if (typeof tinymce !== "undefined"){
		tinymce.init({
			selector: "textarea.tinymce",theme: "modern",width: 680,height: 300,
			plugins: [
				"advlist autolink link image lists charmap print preview hr anchor pagebreak",
				"searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
				"table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
			],
			toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
			toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
			image_advtab: true ,
			external_filemanager_path:lte_url+"frontweb/tinymce/filemanager/",
			filemanager_title:"Responsive Filemanager" ,
			external_plugins: {"filemanager" : lte_url+"frontweb/tinymce/filemanager/plugin.min.js"}
		});
	}

});
